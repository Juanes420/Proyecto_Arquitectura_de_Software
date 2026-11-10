@extends('layouts.app')

@section('title', __('messages.juegos_gratis') . ' - GameVault')

@section('content')
<x-page-header :title="__('messages.juegos_gratis')" :description="__('messages.juegos_gratis_descripcion')">
    <x-slot:actions>
        <p class="text-[13px] text-muted">
            {{ __('messages.datos_de') }}
            <a href="https://www.freetogame.com" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-ink underline decoration-line-strong underline-offset-4 hover:decoration-ink">
                FreeToGame.com
                <x-icon name="arrow-up-right" class="size-3.5" />
            </a>
        </p>
    </x-slot:actions>
</x-page-header>

@if($juegos === [])
    <x-empty-state icon="gift" :title="__('messages.juegos_gratis_no_disponible')" />
@else
    <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($juegos as $juego)
            <a href="{{ $juego['enlace'] }}" target="_blank" rel="noopener" class="gv-tile group flex flex-col bg-surface">
                <x-cover :src="$juego['imagen']" :alt="$juego['titulo']" class="aspect-[16/9] rounded-t-md" />
                <div class="flex flex-1 flex-col gap-1 rounded-b-md border-x border-b border-line p-4">
                    <p class="text-[12px] text-muted">{{ $juego['plataforma'] }} · {{ $juego['genero'] }}</p>
                    <h3 class="text-[15px] font-medium leading-snug tracking-[-0.01em]">{{ $juego['titulo'] }}</h3>
                    <p class="mt-1 line-clamp-3 text-[13px] leading-relaxed text-muted">{{ $juego['descripcion'] }}</p>
                    <div class="mt-auto flex items-center justify-between gap-3 pt-4">
                        <x-badge color="success">{{ __('messages.free') }}</x-badge>
                        <span class="inline-flex items-center gap-1 text-[13px] font-medium text-ink">
                            {{ __('messages.jugar_gratis') }}
                            <x-icon name="arrow-up-right" class="size-4 transition-transform duration-200 ease-console group-hover:-translate-y-0.5 group-hover:translate-x-0.5" />
                        </span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endif
@endsection
