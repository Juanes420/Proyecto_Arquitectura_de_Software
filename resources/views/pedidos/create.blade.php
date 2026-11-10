{{-- Autor: Juan David Bedoya --}}
@extends('layouts.app')

@section('title', __('messages.nuevo_pedido') . ' - GameVault')

@section('content')
<x-page-header :title="__('messages.nuevo_pedido')" :description="__('messages.pedido_instrucciones')" :back="route('pedidos.index')" />

@if($errors->any())
    <x-alert type="error" class="mb-8">
        <ul class="space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-alert>
@endif

<form action="{{ route('pedidos.store') }}" method="POST" class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-start">
    @csrf

    <div class="flex flex-col gap-8">
        <x-card>
            <h2 class="flex items-center gap-2 border-b border-line px-5 py-4 text-base font-medium">
                <x-icon name="game-controller" class="size-5 text-muted" />
                {{ __('messages.videojuegos') }}
            </h2>
            @if($videojuegos->isEmpty())
                <p class="px-5 py-6 text-sm text-muted">{{ __('messages.no_results') }}</p>
            @else
                <ul class="divide-y divide-line">
                    @foreach($videojuegos as $vj)
                        @include('pedidos._fila', [
                            'campo' => 'videojuegos', 'id' => $vj->id, 'nombre' => $vj->titulo, 'detalle' => $vj->plataforma,
                            'precio' => $vj->precio, 'stock' => $vj->stock,
                            'valor' => $preseleccionado === $vj->id ? 1 : 0, 'destacado' => $preseleccionado === $vj->id,
                        ])
                    @endforeach
                </ul>
            @endif
        </x-card>

        <x-card>
            <h2 class="flex items-center gap-2 border-b border-line px-5 py-4 text-base font-medium">
                <x-icon name="credit-card" class="size-5 text-muted" />
                {{ __('messages.tarjetas') }}
            </h2>
            @if($tarjetas->isEmpty())
                <p class="px-5 py-6 text-sm text-muted">{{ __('messages.no_results') }}</p>
            @else
                <ul class="divide-y divide-line">
                    @foreach($tarjetas as $tarjeta)
                        @include('pedidos._fila', [
                            'campo' => 'tarjetas', 'id' => $tarjeta->id, 'nombre' => $tarjeta->nombre, 'detalle' => $tarjeta->plataforma,
                            'precio' => $tarjeta->precio, 'stock' => $tarjeta->stock, 'valor' => 0, 'destacado' => false,
                        ])
                    @endforeach
                </ul>
            @endif
        </x-card>
    </div>

    <x-card class="flex flex-col gap-3 p-6 lg:sticky lg:top-24">
        <x-button size="lg" class="w-full" icon="shopping-bag">{{ __('messages.confirmar_pedido') }}</x-button>
        <x-button :href="route('pedidos.index')" variant="ghost" class="w-full">{{ __('messages.cancel') }}</x-button>
    </x-card>
</form>
@endsection
