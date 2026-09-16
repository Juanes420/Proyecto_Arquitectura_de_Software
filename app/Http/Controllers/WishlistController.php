<?php

/**
 * Autor: Juanes Peña
 * Lista de deseos del cliente autenticado.
 */

namespace App\Http\Controllers;

use App\Models\VideoJuego;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('videojuego.categoria')
            ->where('usuario_id', Auth::id())
            ->latest('fecha_agregado')
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    public function store(VideoJuego $videojuego)
    {
        // La tabla tiene un índice único (usuario_id, videojuego_id):
        // firstOrCreate evita el error de duplicado si hacen doble clic.
        $wishlist = Wishlist::firstOrCreate(
            [
                'usuario_id' => Auth::id(),
                'videojuego_id' => $videojuego->id,
            ],
            [
                'fecha_agregado' => now(),
            ],
        );

        if (! $wishlist->wasRecentlyCreated) {
            return back()->with('error', __('messages.wishlist_exists'));
        }

        return back()->with('success', __('messages.wishlist_added'));
    }

    public function destroy(VideoJuego $videojuego)
    {
        $wishlist = Wishlist::where('usuario_id', Auth::id())
            ->where('videojuego_id', $videojuego->id)
            ->first();

        if (! $wishlist) {
            return back()->with('error', __('messages.wishlist_not_found'));
        }

        $wishlist->delete();

        return back()->with('success', __('messages.wishlist_removed'));
    }
}
