<?php

/**
 * Autor: Juanes Peña
 * Lista de deseos del cliente autenticado.
 */

namespace App\Http\Controllers;

use App\Models\VideoJuego;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $wishlists = Wishlist::with('videojuego.categoria')
            ->delUsuario(Auth::id())
            ->latest('fecha_agregado')
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    public function store(VideoJuego $videojuego): RedirectResponse
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

    public function destroy(VideoJuego $videojuego): RedirectResponse
    {
        $wishlist = Wishlist::delUsuario(Auth::id())->delVideojuego($videojuego->id)->first();

        if (! $wishlist) {
            return back()->with('error', __('messages.wishlist_not_found'));
        }

        $wishlist->delete();

        return back()->with('success', __('messages.wishlist_removed'));
    }
}
