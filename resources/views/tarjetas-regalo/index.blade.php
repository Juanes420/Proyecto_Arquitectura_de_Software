@extends('layouts.app')

@section('title', __('messages.nav_tarjetas') . ' - GameVault')

@section('content')
<x-page-header :title="__('messages.nav_tarjetas')" :description="__('messages.tarjetas_descripcion')" />

@if($tarjetas->isEmpty())
    <x-empty-state icon="gift" :title="__('messages.sin_tarjetas')" />
@else
    <ul class="grid gap-x-4 gap-y-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($tarjetas as $tarjeta)
            <li class="flex flex-col">
                <x-gift-card :imagen="$tarjeta->imagen_url" :plataforma="$tarjeta->plataforma" :precio="$tarjeta->precio" :alt="$tarjeta->nombre" />
                <div class="mt-3 flex flex-1 flex-col gap-1">
                    <p class="text-[12px] text-muted">{{ $tarjeta->plataforma }}</p>
                    <h3 class="text-[15px] font-medium leading-snug tracking-[-0.01em]">{{ $tarjeta->nombre }}</h3>
                    <div class="mt-auto flex flex-wrap items-center justify-between gap-3 pt-3">
                        <x-price :value="$tarjeta->precio" class="text-[15px]" />
                        <x-add-to-cart tipo="tarjeta" :id="$tarjeta->id" size="sm" icon="shopping-bag" />
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endif
@endsection
