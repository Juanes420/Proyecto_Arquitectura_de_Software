<?php

/**
 * Autor: Juanes Peña
 * Gestión de los requisitos mínimos de PC asociados a cada videojuego.
 * La relación es 1:1 (VideoJuego hasOne RequisitosMinimosPc), por eso al crear
 * solo se listan los videojuegos que todavía no tienen ficha de requisitos.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequisitosMinimosPcRequest;
use App\Models\RequisitosMinimosPc;
use App\Models\VideoJuego;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RequisitosMinimosPcController extends Controller
{
    public function index(): View
    {
        $requisitos = RequisitosMinimosPc::with('videojuego')
            ->orderBy('videojuego_id')
            ->paginate(15);

        return view('admin.requisitos.index', compact('requisitos'));
    }

    public function create(): View
    {
        $videojuegos = VideoJuego::sinRequisitos()->orderBy('titulo')->get();

        return view('admin.requisitos.create', compact('videojuegos'));
    }

    public function store(RequisitosMinimosPcRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        RequisitosMinimosPc::create($validated);

        return redirect()->route('admin.requisitos.index')
            ->with('success', __('messages.requisitos_created'));
    }

    public function edit(RequisitosMinimosPc $requisito): View
    {
        $requisito->load('videojuego');
        $videojuegos = VideoJuego::sinRequisitos($requisito->videojuego_id)->orderBy('titulo')->get();

        return view('admin.requisitos.edit', compact('requisito', 'videojuegos'));
    }

    public function update(RequisitosMinimosPcRequest $request, RequisitosMinimosPc $requisito): RedirectResponse
    {
        $validated = $request->validated();

        $requisito->update($validated);

        return redirect()->route('admin.requisitos.index')
            ->with('success', __('messages.requisitos_updated'));
    }

    public function destroy(RequisitosMinimosPc $requisito): RedirectResponse
    {
        $requisito->delete();

        return redirect()->route('admin.requisitos.index')
            ->with('success', __('messages.requisitos_deleted'));
    }
}
