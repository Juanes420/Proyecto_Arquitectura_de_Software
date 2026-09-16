@extends('layouts.admin')

@section('header', $videojuego->titulo)

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-3xl">
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <span class="text-gray-500 text-sm">{{ __('messages.plataforma') }}</span>
            <p class="font-medium">{{ $videojuego->plataforma }}</p>
        </div>
        <div>
            <span class="text-gray-500 text-sm">{{ __('messages.categoria') }}</span>
            <p class="font-medium">{{ $videojuego->categoria->nombre }}</p>
        </div>
        <div>
            <span class="text-gray-500 text-sm">{{ __('messages.precio') }}</span>
            <p class="font-medium text-green-600">${{ number_format($videojuego->precio, 2) }}</p>
        </div>
        <div>
            <span class="text-gray-500 text-sm">{{ __('messages.stock') }}</span>
            <p class="font-medium">{{ $videojuego->stock }}</p>
        </div>
    </div>

    @if($videojuego->descripcion)
        <div class="mb-6">
            <span class="text-gray-500 text-sm">{{ __('messages.descripcion') }}</span>
            <p class="mt-1">{{ $videojuego->descripcion }}</p>
        </div>
    @endif

    {{-- DLCs --}}
    @if($videojuego->dlcs->count())
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">{{ __('messages.dlcs') }} ({{ $videojuego->dlcs->count() }})</h3>
            <ul class="space-y-1">
                @foreach($videojuego->dlcs as $dlc)
                    <li class="flex justify-between bg-gray-50 px-3 py-2 rounded">
                        <span>{{ $dlc->nombre }}</span>
                        <span class="text-green-600">${{ number_format($dlc->precio, 2) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Reseñas --}}
    @if($videojuego->resenas->count())
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">{{ __('messages.resenas') }} ({{ $videojuego->resenas->count() }}) — ⭐ {{ $videojuego->promedio_calificacion }}/5</h3>
            @foreach($videojuego->resenas as $resena)
                <div class="bg-gray-50 px-3 py-2 rounded mb-2">
                    <div class="flex justify-between">
                        <span class="font-medium">{{ $resena->usuario->nombre }}</span>
                        <span>{{ str_repeat('⭐', $resena->calificacion) }}</span>
                    </div>
                    @if($resena->comentario)
                        <p class="text-gray-600 text-sm mt-1">{{ $resena->comentario }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <div class="flex gap-3">
        <a href="{{ route('admin.videojuegos.edit', $videojuego) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">{{ __('messages.edit') }}</a>
        <a href="{{ route('admin.videojuegos.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">{{ __('messages.back') }}</a>
    </div>
</div>
@endsection
