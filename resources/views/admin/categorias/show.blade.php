{{-- Autor: Juanes Peña --}}
@extends('layouts.admin')

@section('header', $categoria->nombre)
@section('back', route('admin.categorias.index'))

@section('actions')
    <x-button :href="route('admin.categorias.edit', $categoria)" icon="pencil-simple">{{ __('messages.edit') }}</x-button>
@endsection

@section('content')
<div class="flex max-w-3xl flex-col gap-10">
    <div class="border-t border-line pt-4">
        <p class="gv-label text-muted">{{ __('messages.descripcion') }}</p>
        <p class="mt-2 max-w-[65ch] leading-relaxed">{{ $categoria->descripcion ?: '-' }}</p>
    </div>

    <section>
        <h2 class="text-lg font-semibold">{{ __('messages.videojuegos') }} <span class="font-mono text-sm font-normal text-muted">({{ $categoria->videojuegos->count() }})</span></h2>
        @if($categoria->videojuegos->isEmpty())
            <x-empty-state icon="game-controller" :title="__('messages.no_results')" class="mt-3" />
        @else
            <ul class="mt-3 divide-y divide-line rounded-md border border-line bg-surface">
                @foreach($categoria->videojuegos as $videojuego)
                    <li class="flex justify-between gap-4 px-4 py-3 text-sm">
                        <a href="{{ route('admin.videojuegos.show', $videojuego) }}" class="font-medium hover:underline">{{ $videojuego->titulo }}</a>
                        <x-price :value="$videojuego->precio" />
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
</div>
@endsection
