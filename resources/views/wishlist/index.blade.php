{{-- Autor: Juanes Peña --}}
@extends('layouts.app')

@section('title', __('messages.wishlist') . ' - GameVault')

@section('content')
<div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">❤️ {{ __('messages.wishlist') }}</h1>

    @forelse($wishlists as $item)
        @if($loop->first)
            <div class="bg-white rounded-lg shadow divide-y">
        @endif

        <div class="flex items-center justify-between gap-4 p-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center text-white text-2xl">
                    🎮
                </div>
                <div>
                    <a href="{{ route('videojuegos.show', $item->videojuego) }}" class="font-medium text-lg text-indigo-700 hover:underline">
                        {{ $item->videojuego->titulo }}
                    </a>
                    <p class="text-gray-500 text-sm">
                        {{ $item->videojuego->plataforma }} · {{ $item->videojuego->categoria->nombre }}
                    </p>
                    <p class="text-gray-400 text-xs">
                        {{ __('messages.fecha_agregado') }}: {{ $item->fecha_agregado->format('d/m/Y') }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <span class="text-xl font-bold text-green-600">${{ number_format($item->videojuego->precio, 2) }}</span>
                <form action="{{ route('wishlist.destroy', $item->videojuego) }}" method="POST"
                      onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                    @csrf @method('DELETE')
                    <button class="bg-red-100 text-red-700 px-3 py-2 rounded hover:bg-red-200">
                        {{ __('messages.wishlist_remove') }}
                    </button>
                </form>
            </div>
        </div>

        @if($loop->last)
            </div>
        @endif
    @empty
        <div class="bg-white rounded-lg shadow p-10 text-center">
            <p class="text-gray-500 mb-4">{{ __('messages.wishlist_empty') }}</p>
            <a href="{{ route('videojuegos.index') }}" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                {{ __('messages.catalog') }}
            </a>
        </div>
    @endforelse
</div>
@endsection
