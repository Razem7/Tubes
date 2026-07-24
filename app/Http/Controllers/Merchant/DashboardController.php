<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware(['auth', 'merchant']);
    }

    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_products' => Product::where('user_id', $user->id)->count(),
            'total_sold' => Product::where('user_id', $user->id)->where('is_sold', true)->count(),
            'total_active' => Product::where('user_id', $user->id)->where('is_sold', false)->count(),
            'total_revenue' => Transaction::where('seller_id', $user->id)
                ->where('status', '!=', 'cancelled')
                ->sum('amount'),
        ];

        $recent_products = Product::where('user_id', $user->id)
            ->with('photos')
            ->latest()
            ->take(5)
            ->get();

        $recent_sales = Transaction::where('seller_id', $user->id)
            ->with(['product.photos', 'buyer'])
            ->latest()
            ->take(5)
            ->get();

        $recent_chats = Chat::where('seller_id', $user->id)
            ->with([
                'product',
                'buyer',
                'latestMessage',
                'messages' => fn ($q) => $q->where('sender_id', '!=', $user->id)->whereNull('read_at'),
            ])
            ->latest('updated_at')
            ->take(5)
            ->get();

        $unread_chats = Chat::where('seller_id', $user->id)
            ->whereHas('messages', function ($q) use ($user) {
                $q->where('sender_id', '!=', $user->id)->whereNull('read_at');
            })
            ->count();

        return view('merchant.dashboard', compact('stats', 'recent_products', 'recent_sales', 'recent_chats', 'unread_chats'));
    }

    public function products(Request $request)
    {
        $query = Product::where('user_id', auth()->id())
            ->with(['photos', 'category']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_sold', $request->status === 'sold');
        }

        $products = $query->latest()->paginate(20);

        return view('merchant.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::orderBy('name')->get();

        return view('merchant.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:100',
            'description' => 'required|string|min:10|max:2000',
            'price' => 'required|numeric|min:1|integer',
            'stock' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'condition' => 'required|in:new,like_new,good,fair',
            'location' => 'required|string|max:255',
            'brand' => 'nullable|string|max:50',
            'model' => 'nullable|string|max:100',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = Product::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category_id' => $validated['category_id'],
            'condition' => $validated['condition'],
            'location' => $validated['location'],
            'brand' => $validated['brand'] ?? null,
            'model' => $validated['model'] ?? null,
            'payment_methods' => 'cod',
            'is_sold' => false,
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('products', 'public');
                ProductPhoto::create([
                    'product_id' => $product->id,
                    'photo_url' => $path,
                ]);
            }
        }

        return redirect()->route('merchant.products')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function editProduct(Product $product)
    {
        $this->authorize('update', $product);

        $categories = Category::orderBy('name')->get();

        return view('merchant.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'title'        => 'required|string|min:5|max:100',
            'description'  => 'required|string|min:10|max:2000',
            'price'        => 'required|numeric|min:1|integer',
            'stock'        => 'required|integer|min:0',
            'category_id'  => 'required|exists:categories,id',
            'condition'    => 'required|in:new,like_new,good,fair',
            'location'     => 'required|string|max:255',
            'brand'        => 'nullable|string|max:50',
            'model'        => 'nullable|string|max:100',
            'delete_photos'=> 'nullable|array',
            'delete_photos.*' => 'integer',
            'new_photos'   => 'nullable|array|max:5',
            'new_photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $product->update([
            'title'           => $validated['title'],
            'description'     => $validated['description'],
            'price'           => $validated['price'],
            'stock'           => $validated['stock'],
            'category_id'     => $validated['category_id'],
            'condition'       => $validated['condition'],
            'location'        => $validated['location'],
            'brand'           => $validated['brand'] ?? null,
            'model'           => $validated['model'] ?? null,
            'payment_methods' => 'cod',
        ]);

        // Delete photos that were checked for removal
        if ($request->filled('delete_photos')) {
            $photosToDelete = ProductPhoto::whereIn('id', $request->delete_photos)
                ->where('product_id', $product->id)
                ->get();

            foreach ($photosToDelete as $photo) {
                Storage::disk('public')->delete($photo->getRawOriginal('photo_url'));
                $photo->delete();
            }
        }

        // Upload new photos
        if ($request->hasFile('new_photos')) {
            foreach ($request->file('new_photos') as $photo) {
                $path = $photo->store('products', 'public');
                ProductPhoto::create([
                    'product_id' => $product->id,
                    'photo_url'  => $path,
                ]);
            }
        }

        return redirect()->route('merchant.products')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroyProduct(Product $product)
    {
        $this->authorize('delete', $product);

        foreach ($product->photos as $photo) {
            Storage::disk('public')->delete($photo->getRawOriginal('photo_url'));
            $photo->delete();
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }

    public function stock(Request $request)
    {
        $query = Product::where('user_id', auth()->id())
            ->with(['photos', 'category']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(20);

        return view('merchant.stock', compact('products'));
    }

    public function updateStock(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $request->validate(['stock' => 'required|integer|min:0']);

        $product->update([
            'stock' => $request->stock,
            'is_sold' => $request->stock == 0,
        ]);

        return back()->with('success', 'Stok berhasil diperbarui!');
    }

    public function sales(Request $request)
    {
        $query = Transaction::where('seller_id', auth()->id())
            ->with(['product.photos', 'buyer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->paginate(20);

        $summary = [
            'total' => Transaction::where('seller_id', auth()->id())->count(),
            'pending' => Transaction::where('seller_id', auth()->id())->where('status', 'pending')->count(),
            'revenue' => Transaction::where('seller_id', auth()->id())->where('status', '!=', 'cancelled')->sum('amount'),
        ];

        return view('merchant.sales', compact('transactions', 'summary'));
    }
}
