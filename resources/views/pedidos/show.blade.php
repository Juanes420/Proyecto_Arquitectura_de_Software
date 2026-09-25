{{-- Autor: Juan David Bedoya --}}
@extends('layouts.app')

@section('title', __('messages.pedido') . ' #' . $pedido->id . ' - GameVault')

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('pedidos.index') }}" class="text-indigo-600 hover:underline mb-4 inline-block">← {{ __('messages.back') }}</a>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold">{{ __('messages.pedido') }} #{{ $pedido->id }}</h1>
                <p class="text-gray-500 mt-1">{{ __('messages.fecha') }}: {{ $pedido->fecha->format('d/m/Y H:i') }}</p>
            </div>
            <div class="text-right">
                @include('pedidos._estado', ['estado' => $pedido->estado])
                <p class="text-3xl font-bold text-green-600 mt-2">${{ number_format($pedido->total, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <h2 class="text-xl font-bold p-4 border-b">{{ __('messages.detalle_pedido') }}</h2>
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.producto') }}</th>
                    <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.tipo') }}</th>
                    <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.cantidad') }}</th>
                    <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.precio_unit') }}</th>
                    <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.subtotal') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($pedido->detalles as $detalle)
                    <tr>
                        <td class="px-6 py-4">
                            @if($detalle->videojuego)
                                <a href="{{ route('videojuegos.show', $detalle->videojuego) }}" class="text-indigo-700 hover:underline">
                                    {{ $detalle->videojuego->titulo }}
                                </a>
                            @elseif($detalle->tarjeta)
                                {{ $detalle->tarjeta->nombre }}
                            @else
                                <span class="text-gray-400">{{ __('messages.producto_eliminado') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            @if($detalle->videojuego_id)
                                🎮 {{ __('messages.videojuego') }}
                            @elseif($detalle->tarjeta_id)
                                💳 {{ __('messages.tarjeta') }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $detalle->cantidad }}</td>
                        <td class="px-6 py-4">${{ number_format($detalle->precio_unit, 2) }}</td>
                        <td class="px-6 py-4 font-medium">${{ number_format($detalle->precio_unit * $detalle->cantidad, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="4" class="px-6 py-3 text-right font-bold">{{ __('messages.total') }}</td>
                    <td class="px-6 py-3 font-bold text-green-600">${{ number_format($pedido->total, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    @if($pedido->estado === 'pendiente')
        <form action="{{ route('pedidos.cancelar', $pedido) }}" method="POST"
              onsubmit="return confirm('{{ __('messages.confirm_cancelar_pedido') }}')">
            @csrf @method('PATCH')
            <button class="bg-red-100 text-red-700 px-4 py-2 rounded hover:bg-red-200">
                {{ __('messages.cancelar_pedido') }}
            </button>
        </form>
    @endif
</div>
@endsection
