{{-- Autor: Juan David Bedoya --}}
@extends('layouts.app')

@section('title', __('messages.nuevo_pedido') . ' - GameVault')

@section('content')
<div class="max-w-5xl mx-auto">
    <a href="{{ route('pedidos.index') }}" class="text-indigo-600 hover:underline mb-4 inline-block">← {{ __('messages.back') }}</a>

    <h1 class="text-3xl font-bold mb-2">🛒 {{ __('messages.nuevo_pedido') }}</h1>
    <p class="text-gray-500 mb-6">{{ __('messages.pedido_instrucciones') }}</p>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf

        {{-- Videojuegos --}}
        <div class="bg-white rounded-lg shadow mb-6">
            <h2 class="text-xl font-bold p-4 border-b">🎮 {{ __('messages.videojuegos') }}</h2>
            <div class="divide-y">
                @forelse($videojuegos as $vj)
                    @php $valor = old('videojuegos.' . $vj->id, $preseleccionado === $vj->id ? 1 : 0); @endphp
                    <div class="flex items-center justify-between gap-4 p-4 {{ $preseleccionado === $vj->id ? 'bg-indigo-50' : '' }}">
                        <div>
                            <p class="font-medium">{{ $vj->titulo }}</p>
                            <p class="text-gray-500 text-sm">{{ $vj->plataforma }} · {{ $vj->stock }} {{ __('messages.en_stock') }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="font-bold text-green-600">${{ number_format($vj->precio, 2) }}</span>
                            <label class="sr-only" for="vj-{{ $vj->id }}">{{ __('messages.cantidad') }}</label>
                            <input type="number" id="vj-{{ $vj->id }}" name="videojuegos[{{ $vj->id }}]"
                                   value="{{ $valor }}" min="0" max="{{ min(10, $vj->stock) }}"
                                   class="border rounded px-3 py-2 w-20">
                        </div>
                    </div>
                @empty
                    <p class="p-4 text-gray-500">{{ __('messages.no_results') }}</p>
                @endforelse
            </div>
        </div>

        {{-- Tarjetas --}}
        <div class="bg-white rounded-lg shadow mb-6">
            <h2 class="text-xl font-bold p-4 border-b">💳 {{ __('messages.tarjetas') }}</h2>
            <div class="divide-y">
                @forelse($tarjetas as $tarjeta)
                    <div class="flex items-center justify-between gap-4 p-4">
                        <div>
                            <p class="font-medium">{{ $tarjeta->nombre }}</p>
                            <p class="text-gray-500 text-sm">{{ $tarjeta->plataforma }} · {{ $tarjeta->stock }} {{ __('messages.en_stock') }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="font-bold text-green-600">${{ number_format($tarjeta->precio, 2) }}</span>
                            <label class="sr-only" for="tj-{{ $tarjeta->id }}">{{ __('messages.cantidad') }}</label>
                            <input type="number" id="tj-{{ $tarjeta->id }}" name="tarjetas[{{ $tarjeta->id }}]"
                                   value="{{ old('tarjetas.' . $tarjeta->id, 0) }}" min="0" max="{{ min(10, $tarjeta->stock) }}"
                                   class="border rounded px-3 py-2 w-20">
                        </div>
                    </div>
                @empty
                    <p class="p-4 text-gray-500">{{ __('messages.no_results') }}</p>
                @endforelse
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                {{ __('messages.confirmar_pedido') }}
            </button>
            <a href="{{ route('pedidos.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                {{ __('messages.cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection
