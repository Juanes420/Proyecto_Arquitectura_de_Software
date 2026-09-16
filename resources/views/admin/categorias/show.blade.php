{{-- Autor: Juanes Peña --}}
@extends('layouts.admin')

@section('header', $categoria->nombre)

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-3xl">
    <div class="mb-6">
        <span class="text-gray-500 text-sm">{{ __('messages.descripcion') }}</span>
        <p class="mt-1">{{ $categoria->descripcion ?: '—' }}</p>
    </div>

    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">
            {{ __('messages.videojuegos') }} ({{ $categoria->videojuegos->count() }})
        </h3>
        @forelse($categoria->videojuegos as $videojuego)
            <div class="flex justify-between bg-gray-50 px-3 py-2 rounded mb-2">
                <a href="{{ route('admin.videojuegos.show', $videojuego) }}" class="text-blue-600 hover:underline">
                    {{ $videojuego->titulo }}
                </a>
                <span class="text-green-600">${{ number_format($videojuego->precio, 2) }}</span>
            </div>
        @empty
            <p class="text-gray-500">{{ __('messages.no_results') }}</p>
        @endforelse
    </div>

    <div class="flex gap-3">
        <a href="{{ route('admin.categorias.edit', $categoria) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">{{ __('messages.edit') }}</a>
        <a href="{{ route('admin.categorias.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">{{ __('messages.back') }}</a>
    </div>
</div>
@endsection
