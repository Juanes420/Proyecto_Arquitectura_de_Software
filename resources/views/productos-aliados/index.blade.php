@extends('layouts.app')

@section('title', __('messages.productos_aliados') . ' - GameVault')

@section('content')
<x-page-header :title="__('messages.productos_aliados')" :description="__('messages.productos_aliados_descripcion', ['aliado' => $aliado])" />

@if($origen === 'local')
    <x-alert type="warning" class="mb-8">{{ __('messages.productos_aliados_local') }}</x-alert>
@endif

@if($productos === [])
    <x-empty-state icon="handshake" :title="__('messages.productos_aliados_no_disponible')" />
@else
    <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($productos as $producto)
            <article class="flex flex-col rounded-md bg-surface">
                <x-cover :src="$producto['imagen']" :alt="$producto['nombre']" icon="handshake" class="aspect-[4/3] rounded-t-md" />
                <div class="flex flex-1 flex-col gap-1 rounded-b-md border-x border-b border-line p-4">
                    <h3 class="text-[15px] font-medium leading-snug tracking-[-0.01em]">{{ $producto['nombre'] }}</h3>
                    @if($producto['descripcion'])
                        <p class="mt-1 line-clamp-3 text-[13px] leading-relaxed text-muted">{{ $producto['descripcion'] }}</p>
                    @endif
                    <div class="mt-auto flex items-center justify-between gap-3 pt-4">
                        @if(is_numeric($producto['precio']))
                            <x-price :value="$producto['precio']" class="text-[15px]" />
                        @endif
                        @if($producto['enlace'])
                            <a href="{{ $producto['enlace'] }}" target="_blank" rel="noopener" class="group ml-auto inline-flex items-center gap-1 text-[13px] font-medium text-ink">
                                {{ __('messages.ver_producto') }}
                                <x-icon name="arrow-up-right" class="size-4 transition-transform duration-200 ease-console group-hover:-translate-y-0.5 group-hover:translate-x-0.5" />
                            </a>
                        @endif
                    </div>
                </div>
            </article>
        @endforeach
    </div>
@endif
@endsection
