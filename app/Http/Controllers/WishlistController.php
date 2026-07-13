<?php

namespace App\Http\Controllers;

use App\Services\WishlistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct(
        protected WishlistService $wishlistService
    ) {}

    public function index()
    {
        $wishlists = $this->wishlistService->getUserWishlist(Auth::id());

        return view('profile.wishlist', [
            'wishlists' => $wishlists,
        ]);
    }

    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|integer|exists:products,id']);

        $added = $this->wishlistService->toggle(Auth::id(), $request->product_id);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'added' => $added,
                'message' => $added ? 'Ditambahkan ke wishlist!' : 'Dihapus dari wishlist.',
            ]);
        }

        return back()->with('success', $added ? 'Ditambahkan ke wishlist!' : 'Dihapus dari wishlist.');
    }
}
