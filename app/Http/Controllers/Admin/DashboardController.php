<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_merchants' => User::where('role', 'merchant')->count(),
            'total_products' => Product::count(),
            'total_sold' => Product::where('is_sold', true)->count(),
            'total_chats' => Chat::count(),
            'total_revenue' => Transaction::where('status', '!=', 'cancelled')->sum('amount'),
        ];

        $recent_products = Product::with(['user', 'photos'])
            ->latest()
            ->take(10)
            ->get();

        $recent_users = User::whereIn('role', ['user', 'merchant'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_products', 'recent_users'));
    }

    public function products(Request $request)
    {
        $query = Product::with(['user', 'photos', 'category']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('user', fn ($q) => $q->where('role', $request->role));
        }

        $products = $query->latest()->paginate(20);

        return view('admin.products', compact('products'));
    }

    public function deleteProduct(Product $product)
    {
        foreach ($product->photos as $photo) {
            if (! empty($photo->photo_url)) {
                \Storage::disk('public')->delete($photo->photo_url);
            }
            $photo->delete();
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }

    public function users(Request $request)
    {
        $query = User::whereIn('role', ['user', 'merchant']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function deleteUser(User $user)
    {
        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Tidak bisa menghapus Super Admin!');
        }

        foreach ($user->products as $product) {
            foreach ($product->photos as $photo) {
                if (! empty($photo->photo_url)) {
                    \Storage::disk('public')->delete($photo->photo_url);
                }
                $photo->delete();
            }
            $product->delete();
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus!');
    }

    public function promoteToMerchant(User $user)
    {
        if (! $user->isUser()) {
            return back()->with('error', 'Hanya user biasa yang bisa dipromosikan ke Merchant.');
        }

        $user->update(['role' => 'merchant']);

        return back()->with('success', $user->name . ' berhasil dipromosikan menjadi Merchant!');
    }

    public function demoteToUser(User $user)
    {
        if (! $user->isMerchant()) {
            return back()->with('error', 'User ini bukan Merchant.');
        }

        $user->update(['role' => 'user']);

        return back()->with('success', $user->name . ' berhasil diubah menjadi User biasa!');
    }

    public function banners()
    {
        $banner = Banner::first();

        return view('admin.banners', compact('banner'));
    }

    public function storeBanner(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
            'link_url' => 'nullable|url|max:255',
        ]);

        $existing = Banner::first();
        if ($existing) {
            \Storage::disk('public')->delete($existing->image_url);
            $existing->delete();
        }

        $path = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title' => $request->title,
            'image_url' => $path,
            'link_url' => $request->link_url,
            'is_active' => true,
        ]);

        return back()->with('success', 'Banner berhasil disimpan!');
    }

    public function deleteBanner()
    {
        $banner = Banner::first();
        if ($banner) {
            \Storage::disk('public')->delete($banner->image_url);
            $banner->delete();
        }

        return back()->with('success', 'Banner berhasil dihapus!');
    }

    public function categories()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:categories,name']);

        Category::create(['name' => $request->name]);

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:100|unique:categories,name,' . $category->id]);

        $category->update(['name' => $request->name]);

        return back()->with('success', 'Kategori berhasil diubah!');
    }

    public function deleteCategory(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk!');
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}
