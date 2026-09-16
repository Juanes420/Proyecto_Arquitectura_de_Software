<?php

namespace App\Http\Controllers;

use App\Models\Resena;
use App\Models\VideoJuego;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResenaController extends Controller
{
    public function store(Request $request, VideoJuego $videojuego)
    {
        $validated = $request->validate([
            'calificacion' => ['required', 'integer', 'min:1', 'max:5'],
            'comentario' => ['nullable', 'string', 'max:1000'],
        ]);

        // Verificar que el usuario no haya reseñado este juego antes
        $existente = Resena::where('usuario_id', Auth::id())
            ->where('videojuego_id', $videojuego->id)
            ->first();

        if ($existente) {
            return back()->with('error', __('messages.resena_exists'));
        }

        Resena::create([
            'usuario_id' => Auth::id(),
            'videojuego_id' => $videojuego->id,
            'calificacion' => $validated['calificacion'],
            'comentario' => $validated['comentario'],
        ]);

        return back()->with('success', __('messages.resena_created'));
    }

    public function update(Request $request, Resena $resena)
    {
        // Solo el dueño puede editar
        if ($resena->usuario_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'calificacion' => ['required', 'integer', 'min:1', 'max:5'],
            'comentario' => ['nullable', 'string', 'max:1000'],
        ]);

        $resena->update($validated);

        return back()->with('success', __('messages.resena_updated'));
    }

    public function destroy(Resena $resena)
    {
        if ($resena->usuario_id !== Auth::id()) {
            abort(403);
        }

        $resena->delete();

        return back()->with('success', __('messages.resena_deleted'));
    }
}
