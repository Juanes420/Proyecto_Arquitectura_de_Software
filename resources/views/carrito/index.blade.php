@extends('layouts.app')

@section('title', __('messages.carrito_titulo') . ' - GameVault')

@section('content')
<x-page-header :title="__('messages.carrito_titulo')" :description="__('messages.carrito_descripcion')" />

@if($items->isEmpty())
    <x-empty-state icon="shopping-bag" :title="__('messages.carrito_vacio_titulo')" :text="__('messages.carrito_vacio_texto')">
        <x-button :href="route('videojuegos.index')" variant="secondary" icon="arrow-left">{{ __('messages.seguir_comprando') }}</x-button>
    </x-empty-state>
@else
    <div class="grid gap-10 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-start">
        <ul class="divide-y divide-line border-y border-line">
            @foreach($items as $item)
                <li class="flex flex-wrap items-center gap-x-5 gap-y-4 py-5">
                    <a href="{{ $item['enlace'] }}" class="shrink-0 rounded-md">
                        @include('carrito._miniatura', ['item' => $item])
                    </a>

                    <div class="min-w-0 flex-1 basis-48">
                        <p class="text-[12px] text-muted">{{ $item['detalle'] }}</p>
                        <a href="{{ $item['enlace'] }}" class="mt-0.5 block font-medium leading-snug tracking-[-0.01em] hover:underline">{{ $item['nombre'] }}</a>
                        <x-price :value="$item['precio']" class="mt-1 block text-sm text-muted" />
                        @if($item['agotado'])
                            <x-badge color="danger" class="mt-2">{{ __('messages.agotado') }}</x-badge>
                        @endif
                    </div>

                    <div class="flex items-center gap-4">
                        <form action="{{ route('carrito.actualizar') }}" method="POST" class="flex items-center rounded-md border border-line-strong">
                            @csrf @method('PATCH')
                            <input type="hidden" name="tipo" value="{{ $item['tipo'] }}">
                            <input type="hidden" name="id" value="{{ $item['id'] }}">
                            <button type="submit" name="cantidad" value="{{ $item['cantidad'] - 1 }}"
                                    class="flex size-9 cursor-pointer items-center justify-center text-muted hover:text-ink"
                                    aria-label="{{ __('messages.disminuir') }}: {{ $item['nombre'] }}">
                                <x-icon name="minus" class="size-4" />
                            </button>
                            <output class="w-8 text-center font-mono text-sm tabular-nums" aria-live="polite">{{ $item['cantidad'] }}</output>
                            <button type="submit" name="cantidad" value="{{ $item['cantidad'] + 1 }}"
                                    class="flex size-9 cursor-pointer items-center justify-center text-muted hover:text-ink disabled:cursor-not-allowed disabled:opacity-30"
                                    aria-label="{{ __('messages.aumentar') }}: {{ $item['nombre'] }}"
                                    @disabled($item['cantidad'] >= $item['maximo'])>
                                <x-icon name="plus" class="size-4" />
                            </button>
                        </form>

                        <x-price :value="$item['subtotal']" class="w-20 text-right text-[15px]" />

                        <form action="{{ route('carrito.quitar') }}" method="POST">
                            @csrf @method('DELETE')
                            <input type="hidden" name="tipo" value="{{ $item['tipo'] }}">
                            <input type="hidden" name="id" value="{{ $item['id'] }}">
                            <button type="submit" class="flex size-9 cursor-pointer items-center justify-center rounded-md text-muted hover:bg-subtle hover:text-danger"
                                    title="{{ __('messages.quitar') }}" aria-label="{{ __('messages.quitar') }}: {{ $item['nombre'] }}">
                                <x-icon name="trash" class="size-[18px]" />
                            </button>
                        </form>
                    </div>
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
            <x-button :href="route('pedidos.create')" size="lg" icon="shopping-bag" class="mt-6 w-full">{{ __('messages.pagar') }}</x-button>
            <a href="{{ route('videojuegos.index') }}" class="mt-4 block text-center text-sm text-muted underline decoration-line-strong underline-offset-4 hover:text-ink">{{ __('messages.seguir_comprando') }}</a>
        </x-card>
    </div>
@endif
@endsection
