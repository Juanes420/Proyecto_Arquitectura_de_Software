@extends('layouts.app')

@section('title', 'GameVault - ' . __('messages.welcome_title'))

@section('content')
<section class="relative -mt-2 overflow-hidden rounded-md bg-[#161615]">
    @if($portada)
        <img src="{{ $portada->imagen_url }}" alt="" class="absolute inset-0 size-full object-cover opacity-70" fetchpriority="high">
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-black/10" aria-hidden="true"></div>

    <div class="relative flex min-h-[460px] flex-col justify-end px-6 pb-10 pt-24 sm:min-h-[540px] sm:px-10 sm:pb-14">
        <h1 class="max-w-3xl text-4xl font-semibold leading-[1.05] tracking-[-0.035em] text-white text-balance sm:text-6xl">
            {{ __('messages.hero_title') }}
        </h1>
        <p class="mt-4 max-w-xl text-base leading-relaxed text-white/75 sm:text-lg">{{ __('messages.hero_text') }}</p>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('videojuegos.index') }}" class="inline-flex h-12 items-center gap-2 rounded-md bg-white px-6 text-[15px] font-medium text-[#161615] transition-[opacity,transform] duration-200 ease-console hover:opacity-90 active:scale-[0.98]">
                {{ __('messages.explore_catalog') }}
                <x-icon name="arrow-right" class="size-4" />
            </a>
            <a href="{{ route('juegos-gratis.index') }}" class="inline-flex h-12 items-center rounded-md border border-white/35 px-6 text-[15px] font-medium text-white transition-colors duration-200 ease-console hover:border-white hover:bg-white/10">
                {{ __('messages.juegos_gratis') }}
            </a>
        </div>
    </div>
</section>

<section class="mt-20" aria-labelledby="destacados">
    <div class="mb-8 flex flex-wrap items-end justify-between gap-6 border-b border-line pb-6">
        <div class="flex items-end gap-5">
            <p class="font-mono text-6xl font-medium leading-none tracking-[-0.04em] tabular-nums text-ink sm:text-7xl">{{ $totalJuegos }}</p>
            <div class="pb-1">
                <p class="text-sm text-muted">{{ __('messages.titles_in_vault') }}</p>
                <h2 id="destacados" class="text-2xl font-semibold tracking-[-0.02em]">{{ __('messages.featured') }}</h2>
            </div>
        </div>
        <a href="{{ route('videojuegos.index') }}" class="group inline-flex items-center gap-1.5 text-sm font-medium text-ink underline decoration-line-strong underline-offset-4 hover:decoration-ink">
            {{ __('messages.see_all') }}
            <x-icon name="arrow-right" class="size-4 transition-transform duration-200 ease-console group-hover:translate-x-0.5" />
        </a>
    </div>

    @if($destacados->isEmpty())
        <x-empty-state icon="game-controller" :title="__('messages.no_results')">
            <x-button :href="route('videojuegos.index')" variant="secondary">{{ __('messages.catalog') }}</x-button>
        </x-empty-state>
    @else
        <div class="grid grid-flow-dense grid-cols-2 gap-4 lg:grid-cols-4">
            @foreach($destacados as $videojuego)
                <x-game-tile :videojuego="$videojuego" :large="$loop->first"
                             class="{{ $loop->first ? 'col-span-2 lg:row-span-2' : '' }}" />
            @endforeach
        </div>
    @endif
</section>
@endsection
