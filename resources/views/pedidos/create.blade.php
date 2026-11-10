{{-- Autor: Juan David Bedoya --}}
@extends('layouts.app')

@section('title', __('messages.checkout_titulo') . ' - GameVault')

@section('content')
<x-page-header :title="__('messages.checkout_titulo')" :description="__('messages.checkout_descripcion')" :back="route('carrito.index')" />

<div class="grid gap-10 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-start">
    <ul class="divide-y divide-line border-y border-line">
        @foreach($items as $item)
            <li class="flex items-center gap-5 py-4">
                @include('carrito._miniatura', ['item' => $item])
                <div class="min-w-0 flex-1">
                    <p class="text-[12px] text-muted">{{ $item['detalle'] }}</p>
                    <p class="mt-0.5 font-medium leading-snug">{{ $item['nombre'] }}</p>
                    <p class="mt-1 font-mono text-sm tabular-nums text-muted">{{ $item['cantidad'] }} × ${{ number_format($item['precio'], 2) }}</p>
                </div>
                <x-price :value="$item['subtotal']" class="text-[15px]" />
            </li>
        @endforeach
    </ul>

    <x-card class="p-6 lg:sticky lg:top-24">
        <p class="gv-label text-muted">{{ __('messages.resumen') }}</p>
        <p class="mt-3 text-sm text-muted">{{ __('messages.productos_count', ['cantidad' => $items->sum('cantidad')]) }}</p>
        <div class="mt-4 flex items-baseline justify-between border-t border-line pt-4">
            <span class="text-sm font-medium">{{ __('messages.total') }}</span>
            <x-price :value="$total" class="text-2xl font-medium tracking-[-0.02em]" />
        </div>
        @if($items->contains('agotado', true))
            <x-alert type="error" class="mt-6">{{ __('messages.carrito_hay_agotados') }}</x-alert>
        @else
            <form action="{{ route('pedidos.store') }}" method="POST" class="mt-6">
                @csrf
                <x-button size="lg" icon="check-circle" class="w-full">{{ __('messages.confirmar_pedido') }}</x-button>
            </form>
        @endif
        <a href="{{ route('carrito.index') }}" class="mt-4 block text-center text-sm text-muted underline decoration-line-strong underline-offset-4 hover:text-ink">{{ __('messages.editar_carrito') }}</a>
    </x-card>
</div>
@endsection
