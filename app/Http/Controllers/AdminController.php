<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected function authorizeAdmin(): void
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }
    }

    public function dashboard()
    {
        $this->authorizeAdmin();

        $productCount = Product::count();
        $userCount = User::count();
        $recentProducts = Product::with('user')->latest()->limit(8)->get();

        return view('admin.dashboard', compact('productCount', 'userCount', 'recentProducts'));
    }

    public function products(Request $request)
    {
        $this->authorizeAdmin();

        $query = Product::with('user')->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            if ($request->status === 'unsold') {
                $query->where('is_sold', false);
            } elseif ($request->status === 'sold') {
                $query->where('is_sold', true);
            }
        }

        $products = $query->paginate(20)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function destroy(Product $product)
    {
        $this->authorizeAdmin();

        foreach ($product->photos as $photo) {
            if (app('files')->exists(storage_path('app/public/' . $photo->photo_url))) {
                app('files')->delete(storage_path('app/public/' . $photo->photo_url));
            }
            $photo->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus oleh admin.');
    }
}
