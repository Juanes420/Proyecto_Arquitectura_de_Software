<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResenaRequest;
use App\Models\Resena;
use App\Models\VideoJuego;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ResenaController extends Controller
{
    public function store(ResenaRequest $request, VideoJuego $videojuego): RedirectResponse
    {
        $validated = $request->validated();

        // Una sola reseña por usuario y videojuego
        if (Resena::delUsuario(Auth::id())->delVideojuego($videojuego->id)->exists()) {
            return back()->with('error', __('messages.resena_exists'));
        }

        Resena::create([
            'usuario_id' => Auth::id(),
            'videojuego_id' => $videojuego->id,
            'calificacion' => $validated['calificacion'],
            'comentario' => $validated['comentario'] ?? null,
        ]);

        return back()->with('success', __('messages.resena_created'));
    }

    public function update(ResenaRequest $request, Resena $resena): RedirectResponse
    {
        abort_unless($resena->perteneceA(Auth::id()), 403);

        $resena->update($request->validated());

        return back()->with('success', __('messages.resena_updated'));
    }

    public function destroy(Resena $resena): RedirectResponse
    {
        abort_unless($resena->perteneceA(Auth::id()), 403);

        $resena->delete();

        return back()->with('success', __('messages.resena_deleted'));
    }
}
