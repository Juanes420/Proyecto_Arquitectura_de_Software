@extends('layouts.app')

@section('title', __('messages.juegos_gratis') . ' - GameVault')

@section('content')
<div class="flex flex-wrap justify-between items-end gap-2 mb-6">
    <div>
        <h2 class="text-2xl font-bold">{{ __('messages.juegos_gratis') }}</h2>
        <p class="text-gray-500">{{ __('messages.juegos_gratis_descripcion') }}</p>
    </div>
    <p class="text-sm text-gray-500">
        {{ __('messages.datos_de') }}
        <a href="https://www.freetogame.com" target="_blank" rel="noopener" class="text-indigo-600 hover:underline">FreeToGame.com</a>
    </p>
</div>

@if($juegos === [])
    <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
        {{ __('messages.juegos_gratis_no_disponible') }}
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($juegos as $juego)
            <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col">
                <img src="{{ $juego['imagen'] }}" alt="{{ $juego['titulo'] }}" class="h-40 w-full object-cover" loading="lazy">
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-bold text-lg">{{ $juego['titulo'] }}</h3>
                    <p class="text-gray-500 text-sm">{{ $juego['plataforma'] }} · {{ $juego['genero'] }}</p>
                    <p class="text-gray-600 text-sm mt-2 flex-1">{{ $juego['descripcion'] }}</p>
                    <a href="{{ $juego['enlace'] }}" target="_blank" rel="noopener"
                       class="mt-4 text-center bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        {{ __('messages.jugar_gratis') }}
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
