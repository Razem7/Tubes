<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['product.photos', 'buyer', 'seller'])
            ->where('buyer_id', auth()->id())
            ->orWhere('seller_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->buyer_id !== auth()->id() && $transaction->seller_id !== auth()->id()) {
            abort(403);
        }

        $transaction->load(['product.photos', 'buyer', 'seller']);

        return view('transactions.show', compact('transaction'));
    }

    public function checkout(Product $product)
    {
        if ($product->user_id === auth()->id()) {
            return redirect()->route('products.show', $product)->with('error', 'Tidak bisa membeli produk sendiri.');
        }

        if ($product->is_sold) {
            return redirect()->route('products.show', $product)->with('error', 'Produk ini sudah terjual.');
        }

        return view('transactions.checkout', compact('product'));
    }

    public function purchase(Request $request, Product $product)
    {
        if ($product->user_id === auth()->id()) {
            return redirect()->route('products.show', $product)->with('error', 'Tidak bisa membeli produk sendiri.');
        }

        if ($product->is_sold) {
            return redirect()->route('products.show', $product)->with('error', 'Produk ini sudah terjual.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:cod,rekber',
            'notes' => 'nullable|string|max:1000',
        ]);

        $allowedMethods = $product->getPaymentMethodsArray();
        if (! in_array($validated['payment_method'], $allowedMethods, true)) {
            return back()->withErrors(['payment_method' => 'Metode pembayaran tidak tersedia untuk produk ini.'])->withInput();
        }

        DB::transaction(function () use ($product, $validated) {
            $transaction = Transaction::create([
                'product_id' => $product->id,
                'buyer_id' => auth()->id(),
                'seller_id' => $product->user_id,
                'payment_method' => $validated['payment_method'],
                'amount' => $product->price,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            $product->update(['is_sold' => true]);
        });

        return redirect()->route('transactions.index')->with('success', 'Pesanan berhasil dibuat. Silakan cek riwayat transaksi Anda.');
    }
}
