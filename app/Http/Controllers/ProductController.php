<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Product::with(['user', 'photos'])
            ->where('is_sold', false)
            ->latest();

        // Search by keyword
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Filter by condition
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        $products = $query->paginate(20);

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load(['user', 'photos']);
        $isFavorited = auth()->check() ? $product->isFavoritedBy(auth()->id()) : false;
        
        return view('products.show', compact('product', 'isFavorited'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:10|max:100',
            'description' => 'required|string|min:20|max:2000',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'brand' => 'nullable|string|max:50',
            'model' => 'nullable|string|max:100',
            'condition' => 'required|in:new,like_new,good,fair',
            'payment_methods' => 'required|array',
            'payment_methods.*' => 'in:cod,rekber',
            'photos' => 'required|array|min:1|max:8',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $product = Product::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'location' => $validated['location'],
            'brand' => $validated['brand'] ?? null,
            'model' => $validated['model'] ?? null,
            'condition' => $validated['condition'],
            'payment_methods' => implode(',', $validated['payment_methods']),
        ]);

        // Upload photos
        foreach ($request->file('photos') as $index => $photo) {
            $path = $photo->store('products', 'public');
            ProductPhoto::create([
                'product_id' => $product->id,
                'photo_url' => $path,
                'display_order' => $index,
            ]);
        }

        return redirect()->route('products.show', $product)->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'title' => 'required|string|min:10|max:100',
            'description' => 'required|string|min:20|max:2000',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'brand' => 'nullable|string|max:50',
            'model' => 'nullable|string|max:100',
            'condition' => 'required|in:new,like_new,good,fair',
            'payment_methods' => 'required|array',
            'payment_methods.*' => 'in:cod,rekber',
            'new_photos' => 'nullable|array|max:8',
            'new_photos.*' => 'image|mimes:jpeg,png,jpg|max:5120',
            'delete_photos' => 'nullable|array',
        ]);

        $product->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'location' => $validated['location'],
            'brand' => $validated['brand'] ?? null,
            'model' => $validated['model'] ?? null,
            'condition' => $validated['condition'],
            'payment_methods' => implode(',', $validated['payment_methods']),
        ]);

        // Delete selected photos
        if ($request->filled('delete_photos')) {
            $photosToDelete = ProductPhoto::whereIn('id', $request->delete_photos)
                ->where('product_id', $product->id)
                ->get();
            
            foreach ($photosToDelete as $photo) {
                Storage::disk('public')->delete($photo->photo_url);
                $photo->delete();
            }
        }

        // Upload new photos
        if ($request->hasFile('new_photos')) {
            $maxOrder = $product->photos()->max('display_order') ?? -1;
            foreach ($request->file('new_photos') as $index => $photo) {
                $path = $photo->store('products', 'public');
                ProductPhoto::create([
                    'product_id' => $product->id,
                    'photo_url' => $path,
                    'display_order' => $maxOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('products.show', $product)->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        // Delete all photos
        foreach ($product->photos as $photo) {
            Storage::disk('public')->delete($photo->photo_url);
            $photo->delete();
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function myProducts()
    {
        $products = Product::where('user_id', auth()->id())
            ->with('photos')
            ->latest()
            ->paginate(20);

        return view('products.my-products', compact('products'));
    }
}
