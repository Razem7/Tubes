<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Notifications\NewTransactionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // ── Buyer: list semua transaksi ───────────────────────────────────────

    public function index()
    {
        $transactions = Transaction::with(['product.photos', 'buyer', 'seller'])
            ->where(function ($q) {
                $q->where('buyer_id', auth()->id())
                  ->orWhere('seller_id', auth()->id());
            })
            ->latest()
            ->paginate(20);

        // Auto mark-read notifikasi new_transaction saat buka halaman ini
        auth()->user()
            ->unreadNotifications()
            ->where('data->type', 'new_transaction')
            ->update(['read_at' => now()]);

        return view('transactions.index', compact('transactions'));
    }

    // ── Buyer/Seller: detail transaksi ────────────────────────────────────

    public function show(Transaction $transaction)
    {
        if ($transaction->buyer_id !== auth()->id() && $transaction->seller_id !== auth()->id()) {
            abort(403);
        }

        $transaction->load(['product.photos', 'buyer', 'seller']);

        // Auto mark-read notifikasi terkait transaksi ini
        auth()->user()
            ->unreadNotifications()
            ->where('data->transaction_id', $transaction->id)
            ->update(['read_at' => now()]);

        return view('transactions.show', compact('transaction'));
    }

    // ── Buyer: halaman checkout ───────────────────────────────────────────

    public function checkout(Product $product)
    {
        if ($product->user_id === auth()->id()) {
            return redirect()->route('products.show', $product)
                ->with('error', 'Tidak bisa membeli produk sendiri.');
        }

        if ($product->is_sold) {
            return redirect()->route('products.show', $product)
                ->with('error', 'Produk ini sudah terjual.');
        }

        return view('transactions.checkout', compact('product'));
    }

    // ── Buyer: proses pembelian (COD only) ────────────────────────────────

    public function purchase(Request $request, Product $product)
    {
        if ($product->user_id === auth()->id()) {
            return redirect()->route('products.show', $product)
                ->with('error', 'Tidak bisa membeli produk sendiri.');
        }

        if ($product->is_sold) {
            return redirect()->route('products.show', $product)
                ->with('error', 'Produk ini sudah terjual.');
        }

        $validated = $request->validate([
            'shipping_address' => 'required|string|min:10|max:500',
            'notes'            => 'nullable|string|max:1000',
        ], [
            'shipping_address.required' => 'Alamat pengiriman wajib diisi.',
            'shipping_address.min'      => 'Alamat pengiriman terlalu singkat, minimal 10 karakter.',
        ]);

        DB::transaction(function () use ($product, $validated) {
            $transaction = Transaction::create([
                'product_id'       => $product->id,
                'buyer_id'         => auth()->id(),
                'seller_id'        => $product->user_id,
                'payment_method'   => 'cod',
                'amount'           => $product->price,
                'status'           => Transaction::STATUS_PENDING,
                'notes'            => $validated['notes'] ?? null,
                'shipping_address' => $validated['shipping_address'],
            ]);

            // Tandai produk sebagai sold sementara (bisa di-revert kalau ditolak)
            $product->update(['is_sold' => true]);

            // Notifikasi ke seller
            $transaction->load('product', 'buyer');
            $product->user->notify(new NewTransactionNotification($transaction));
        });

        return redirect()->route('transactions.index')
            ->with('success', 'Pesanan berhasil dibuat! Menunggu konfirmasi dari penjual.');
    }

    // ── Seller/Merchant: konfirmasi pesanan ───────────────────────────────

    public function confirm(Transaction $transaction)
    {
        if ($transaction->seller_id !== auth()->id()) {
            abort(403);
        }

        if (! $transaction->isPending()) {
            return back()->with('error', 'Transaksi ini tidak bisa dikonfirmasi.');
        }

        $transaction->update([
            'status'       => Transaction::STATUS_CONFIRMED,
            'confirmed_at' => now(),
        ]);

        // Notifikasi ke buyer
        $transaction->buyer->notify(new \App\Notifications\TransactionStatusNotification($transaction, 'confirmed'));

        return back()->with('success', 'Pesanan berhasil dikonfirmasi!');
    }

    // ── Seller/Merchant: tolak pesanan ────────────────────────────────────

    public function reject(Request $request, Transaction $transaction)
    {
        if ($transaction->seller_id !== auth()->id()) {
            abort(403);
        }

        if (! $transaction->isPending()) {
            return back()->with('error', 'Transaksi ini tidak bisa ditolak.');
        }

        $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $transaction->update([
            'status'           => Transaction::STATUS_REJECTED,
            'rejected_at'      => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Kembalikan produk ke available
        $transaction->product->update(['is_sold' => false]);

        // Notifikasi ke buyer
        $transaction->buyer->notify(new \App\Notifications\TransactionStatusNotification($transaction, 'rejected'));

        return back()->with('success', 'Pesanan berhasil ditolak dan produk kembali tersedia.');
    }

    // ── Seller/Merchant: tandai selesai ───────────────────────────────────

    public function complete(Transaction $transaction)
    {
        if ($transaction->seller_id !== auth()->id()) {
            abort(403);
        }

        if (! $transaction->isConfirmed()) {
            return back()->with('error', 'Transaksi harus dikonfirmasi dulu sebelum diselesaikan.');
        }

        $transaction->update([
            'status' => Transaction::STATUS_COMPLETED,
        ]);

        // Notifikasi ke buyer
        $transaction->buyer->notify(new \App\Notifications\TransactionStatusNotification($transaction, 'completed'));

        return back()->with('success', 'Transaksi selesai!');
    }

    // ── Buyer: konfirmasi barang diterima → transaksi selesai ─────────────

    public function receive(Transaction $transaction)
    {
        if ($transaction->buyer_id !== auth()->id()) {
            abort(403);
        }

        if (! $transaction->isConfirmed()) {
            return back()->with('error', 'Pesanan harus dikonfirmasi penjual dulu sebelum bisa diterima.');
        }

        $transaction->update([
            'status'       => Transaction::STATUS_COMPLETED,
            'confirmed_at' => $transaction->confirmed_at ?? now(),
        ]);

        // Notifikasi ke seller bahwa barang sudah diterima
        $transaction->seller->notify(new \App\Notifications\TransactionStatusNotification($transaction, 'completed'));

        return back()->with('success', 'Pesanan berhasil dikonfirmasi diterima! Transaksi selesai.');
    }

    // ── Buyer: batalkan pesanan ───────────────────────────────────────────

    public function cancel(Transaction $transaction)
    {
        if ($transaction->buyer_id !== auth()->id()) {
            abort(403);
        }

        if (! $transaction->isPending()) {
            return back()->with('error', 'Pesanan hanya bisa dibatalkan saat menunggu konfirmasi.');
        }

        $transaction->update([
            'status' => Transaction::STATUS_CANCELLED,
        ]);

        // Kembalikan produk ke available
        $transaction->product->update(['is_sold' => false]);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
