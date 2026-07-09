<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('is_admin', false)->count(),
            'total_products' => Product::count(),
            'total_sold' => Product::where('is_sold', true)->count(),
            'total_chats' => Chat::count(),
        ];

        $recent_products = Product::with(['user', 'photos'])
            ->latest()
            ->take(10)
            ->get();

        $recent_users = User::where('is_admin', false)
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_products', 'recent_users'));
    }

    public function products(Request $request)
    {
        $query = Product::with(['user', 'photos']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(20);

        return view('admin.products', compact('products'));
    }

    public function deleteProduct(Product $product)
    {
        foreach ($product->photos as $photo) {
            if (!empty($photo->photo_url)) {
                \Storage::disk('public')->delete($photo->photo_url);
            }
            $photo->delete();
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }

    public function users(Request $request)
    {
        $query = User::where('is_admin', false);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function deleteUser(User $user)
    {
        if ($user->is_admin) {
            return back()->with('error', 'Tidak bisa menghapus admin!');
        }

        // Delete user's products
        foreach ($user->products as $product) {
            foreach ($product->photos as $photo) {
                if (!empty($photo->photo_url)) {
                    \Storage::disk('public')->delete($photo->photo_url);
                }
                $photo->delete();
            }
            $product->delete();
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus!');
    }
}
