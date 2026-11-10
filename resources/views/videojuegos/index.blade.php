@extends('layouts.app')

@section('title', __('messages.catalog') . ' - GameVault')

@section('content')
<x-page-header :title="__('messages.catalog')" :description="__('messages.catalog_description')" class="mb-6" />

{{-- Pestañas de categoria: conservan la busqueda y la plataforma activas. --}}
<nav aria-label="{{ __('messages.categoria') }}" class="-mx-4 mb-6 overflow-x-auto px-4 sm:mx-0 sm:px-0">
    <ul class="flex min-w-max gap-6 border-b border-line">
        <li>
            <x-nav-link :href="route('videojuegos.index', request()->only('buscar', 'plataforma'))" :active="! request()->filled('categoria')">
                {{ __('messages.all') }}
            </x-nav-link>
        </li>
        @foreach($categorias as $cat)
            <li>
                <x-nav-link :href="route('videojuegos.index', array_merge(request()->only('buscar', 'plataforma'), ['categoria' => $cat->id]))"
                            :active="request('categoria') == $cat->id">
                    {{ $cat->nombre }}
                </x-nav-link>
            </li>
        @endforeach
    </ul>
</nav>

<form action="{{ route('videojuegos.index') }}" method="GET" role="search" class="mb-10 grid gap-3 sm:grid-cols-[1fr_220px_auto_auto] sm:items-end">
    @if(request()->filled('categoria'))
        <input type="hidden" name="categoria" value="{{ request('categoria') }}">
    @endif
    <div class="relative">
        <label for="buscar" class="sr-only">{{ __('messages.search') }}</label>
        <x-icon name="magnifying-glass" class="pointer-events-none absolute left-3.5 top-1/2 size-[18px] -translate-y-1/2 text-muted" />
        <input type="search" id="buscar" name="buscar" value="{{ request('buscar') }}" placeholder="{{ __('messages.search_placeholder') }}" class="gv-input pl-10">
    </div>
    <div>
        <label for="plataforma" class="sr-only">{{ __('messages.plataforma') }}</label>
        <select id="plataforma" name="plataforma" class="gv-input">
            <option value="">{{ __('messages.plataforma') }}: {{ __('messages.all') }}</option>
            @foreach($plataformas as $plat)
                <option value="{{ $plat }}" @selected(request('plataforma') === $plat)>{{ $plat }}</option>
            @endforeach
        </select>
    </div>
    <x-button size="lg" class="h-11">{{ __('messages.filter') }}</x-button>
    @if(request()->anyFilled(['buscar', 'plataforma', 'categoria']))
        <x-button :href="route('videojuegos.index')" variant="ghost" size="lg" class="h-11">{{ __('messages.clear_filters') }}</x-button>
    @endif
</form>

@if($videojuegos->isEmpty())
    <x-empty-state icon="magnifying-glass" :title="__('messages.no_games_title')" :text="__('messages.no_games_text')">
        <x-button :href="route('videojuegos.index')" variant="secondary">{{ __('messages.clear_filters') }}</x-button>
    </x-empty-state>
@else
    <div class="grid grid-cols-2 gap-x-4 gap-y-6 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        @foreach($videojuegos as $videojuego)
            <x-game-tile :videojuego="$videojuego" />
        @endforeach
    </div>

    <div class="mt-12 border-t border-line pt-6">
        {{ $videojuegos->withQueryString()->links() }}
    </div>
@endif
@endsection
