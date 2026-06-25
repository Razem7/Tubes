<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $favorites = Favorite::where('user_id', auth()->id())
            ->with('product.photos')
            ->latest()
            ->paginate(20);

        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Product $product)
    {
        $favorite = Favorite::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $isFavorited = false;
            $message = 'Produk dihapus dari favorit!';
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ]);
            $isFavorited = true;
            $message = 'Produk ditambahkan ke favorit!';
        }

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'is_favorited' => $isFavorited,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }
}
