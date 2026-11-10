@extends('layouts.app')

@section('title', __('messages.productos_aliados') . ' - GameVault')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold">{{ __('messages.productos_aliados') }}</h2>
    <p class="text-gray-500">{{ __('messages.productos_aliados_descripcion', ['aliado' => $aliado]) }}</p>
    @if($origen === 'local')
        <p class="mt-2 text-sm bg-yellow-100 text-yellow-800 px-3 py-2 rounded inline-block">{{ __('messages.productos_aliados_local') }}</p>
    @endif
</div>

@if($productos === [])
    <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
        {{ __('messages.productos_aliados_no_disponible') }}
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($productos as $producto)
            <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col">
                @if($producto['imagen'])
                    <img src="{{ $producto['imagen'] }}" alt="{{ $producto['nombre'] }}" class="h-40 w-full object-cover" loading="lazy">
                @else
                    <div class="h-40 bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white text-4xl">🤝</div>
                @endif
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-bold text-lg">{{ $producto['nombre'] }}</h3>
                    @if($producto['descripcion'])
                        <p class="text-gray-600 text-sm mt-1 flex-1">{{ $producto['descripcion'] }}</p>
                    @endif
                    @if(is_numeric($producto['precio']))
                        <p class="text-xl font-bold text-green-600 mt-2">${{ number_format((float) $producto['precio'], 2) }}</p>
                    @endif
                    @if($producto['enlace'])
                        <a href="{{ $producto['enlace'] }}" target="_blank" rel="noopener"
                           class="mt-4 text-center bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            {{ __('messages.ver_producto') }}
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
