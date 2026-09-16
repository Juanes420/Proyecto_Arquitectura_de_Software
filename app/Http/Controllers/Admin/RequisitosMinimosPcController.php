<?php

/**
 * Autor: Juanes Peña
 * Gestión de los requisitos mínimos de PC asociados a cada videojuego.
 * La relación es 1:1 (VideoJuego hasOne RequisitosMinimosPc), por eso al crear
 * solo se listan los videojuegos que todavía no tienen ficha de requisitos.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequisitosMinimosPc;
use App\Models\VideoJuego;
use Illuminate\Http\Request;

class RequisitosMinimosPcController extends Controller
{
    public function index()
    {
        $requisitos = RequisitosMinimosPc::with('videojuego')
            ->orderBy('videojuego_id')
            ->paginate(15);

        return view('admin.requisitos.index', compact('requisitos'));
    }

    public function create()
    {
        $videojuegos = $this->videojuegosSinRequisitos();

        return view('admin.requisitos.create', compact('videojuegos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'videojuego_id' => ['required', 'exists:videojuegos,id', 'unique:requisitos_minimos_pc,videojuego_id'],
            'sistema_operativo' => ['required', 'string', 'max:255'],
            'procesador' => ['required', 'string', 'max:255'],
            'memoria_ram' => ['required', 'string', 'max:255'],
            'tarjeta_grafica' => ['required', 'string', 'max:255'],
            'almacenamiento' => ['required', 'string', 'max:255'],
            'directx' => ['nullable', 'string', 'max:255'],
        ]);

        RequisitosMinimosPc::create($validated);

        return redirect()->route('admin.requisitos.index')
            ->with('success', __('messages.requisitos_created'));
    }

    public function edit(RequisitosMinimosPc $requisito)
    {
        $requisito->load('videojuego');
        $videojuegos = $this->videojuegosSinRequisitos($requisito->videojuego_id);

        return view('admin.requisitos.edit', compact('requisito', 'videojuegos'));
    }

    public function update(Request $request, RequisitosMinimosPc $requisito)
    {
        $validated = $request->validate([
            'videojuego_id' => [
                'required',
                'exists:videojuegos,id',
                'unique:requisitos_minimos_pc,videojuego_id,' . $requisito->id,
            ],
            'sistema_operativo' => ['required', 'string', 'max:255'],
            'procesador' => ['required', 'string', 'max:255'],
            'memoria_ram' => ['required', 'string', 'max:255'],
            'tarjeta_grafica' => ['required', 'string', 'max:255'],
            'almacenamiento' => ['required', 'string', 'max:255'],
            'directx' => ['nullable', 'string', 'max:255'],
        ]);

        $requisito->update($validated);

        return redirect()->route('admin.requisitos.index')
            ->with('success', __('messages.requisitos_updated'));
    }

    public function destroy(RequisitosMinimosPc $requisito)
    {
        $requisito->delete();

        return redirect()->route('admin.requisitos.index')
            ->with('success', __('messages.requisitos_deleted'));
    }

    /**
     * Videojuegos disponibles para asociar. El $incluir permite que al editar
     * siga apareciendo el videojuego que ya tiene asignada esta ficha.
     */
    private function videojuegosSinRequisitos(?int $incluir = null)
    {
        return VideoJuego::whereDoesntHave('requisitosMinimosPC')
            ->when($incluir, fn ($query) => $query->orWhere('id', $incluir))
            ->orderBy('titulo')
            ->get();
    }
}
