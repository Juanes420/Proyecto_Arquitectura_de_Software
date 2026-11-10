{{-- Autor: Juan David Bedoya --}}
@extends('layouts.app')

@section('title', __('messages.pedido') . ' #' . $pedido->id . ' - GameVault')

@section('content')
<x-page-header :title="__('messages.pedido') . ' #' . $pedido->id" :back="route('pedidos.index')"
               :description="__('messages.fecha') . ': ' . $pedido->fecha->format('d/m/Y H:i')">
    <x-slot:actions>
        @include('pedidos._estado', ['estado' => $pedido->estado])
    </x-slot:actions>
</x-page-header>

<div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-start">
    <x-card class="overflow-x-auto">
        <h2 class="px-5 pt-5 text-base font-medium">{{ __('messages.detalle_pedido') }}</h2>
        <table class="gv-table mt-3">
            <thead>
                <tr>
                    <th scope="col">{{ __('messages.producto') }}</th>
                    <th scope="col">{{ __('messages.tipo') }}</th>
                    <th scope="col" class="text-right">{{ __('messages.cantidad') }}</th>
                    <th scope="col" class="text-right">{{ __('messages.precio_unit') }}</th>
                    <th scope="col" class="text-right">{{ __('messages.subtotal') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedido->detalles as $detalle)
                    <tr>
                        <td>
                            @if($detalle->videojuego)
                                <a href="{{ route('videojuegos.show', $detalle->videojuego) }}" class="font-medium hover:underline">{{ $detalle->videojuego->titulo }}</a>
                            @elseif($detalle->tarjeta)
                                <span class="font-medium">{{ $detalle->tarjeta->nombre }}</span>
                            @else
                                <span class="text-muted">{{ __('messages.producto_eliminado') }}</span>
                            @endif
                        </td>
                        <td class="text-muted">
                            @if($detalle->videojuego_id)
                                <span class="inline-flex items-center gap-1.5"><x-icon name="game-controller" class="size-4" />{{ __('messages.videojuego') }}</span>
                            @elseif($detalle->tarjeta_id)
                                <span class="inline-flex items-center gap-1.5"><x-icon name="credit-card" class="size-4" />{{ __('messages.tarjeta') }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-right font-mono tabular-nums">{{ $detalle->cantidad }}</td>
                        <td class="text-right"><x-price :value="$detalle->precio_unit" /></td>
                        <td class="text-right"><x-price :value="$detalle->precio_unit * $detalle->cantidad" /></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-card>

    <x-card class="p-6">
        <p class="gv-label text-muted">{{ __('messages.total') }}</p>
        <x-price :value="$pedido->total" class="mt-2 block text-3xl font-medium tracking-[-0.02em]" />

        @if($pedido->estado === 'pendiente')
            <form action="{{ route('pedidos.cancelar', $pedido) }}" method="POST" class="mt-6 border-t border-line pt-6"
                  onsubmit="return confirm(@js(__('messages.confirm_cancelar_pedido')))">
                @csrf @method('PATCH')
                <x-button variant="danger" class="w-full">{{ __('messages.cancelar_pedido') }}</x-button>
            </form>
        @endif
    </x-card>
</div>
@endsection
