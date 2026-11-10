{{-- Autor: Juanes Peña --}}
@extends('layouts.app')

@section('title', __('messages.wishlist') . ' - GameVault')

@section('content')
<x-page-header :title="__('messages.wishlist')" />

@if($wishlists->isEmpty())
    <x-empty-state icon="heart" :title="__('messages.wishlist_empty')">
        <x-button :href="route('videojuegos.index')" variant="secondary">{{ __('messages.explore_catalog') }}</x-button>
    </x-empty-state>
@else
    <ul class="divide-y divide-line border-y border-line">
        @foreach($wishlists as $item)
            @php $videojuego = $item->videojuego; @endphp
            <li class="flex flex-wrap items-center gap-5 py-5">
                <a href="{{ route('videojuegos.show', $videojuego) }}" class="group shrink-0 rounded-md">
                    <x-cover :src="$videojuego->imagen_url" :alt="$videojuego->titulo"
                             class="aspect-[2/3] w-20 rounded-md sm:w-24" />
                </a>
                <div class="min-w-0 flex-1">
                    <p class="text-[12px] text-muted">{{ $videojuego->plataforma }} · {{ $videojuego->categoria->nombre }}</p>
                    <a href="{{ route('videojuegos.show', $videojuego) }}" class="mt-0.5 block text-lg font-medium tracking-[-0.01em] hover:underline">{{ $videojuego->titulo }}</a>
                    <p class="mt-1 text-xs text-muted">{{ __('messages.fecha_agregado') }} {{ $item->fecha_agregado->format('d/m/Y') }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <x-price :value="$videojuego->precio" class="text-[15px]" />
                    @if($videojuego->stock > 0)
                        <x-add-to-cart tipo="videojuego" :id="$videojuego->id" size="sm" variant="primary" icon="shopping-bag" />
                    @else
                        <x-badge color="danger">{{ __('messages.agotado') }}</x-badge>
                    @endif
                    <form action="{{ route('wishlist.destroy', $videojuego) }}" method="POST"
                          onsubmit="return confirm(@js(__('messages.confirm_delete')))">
                        @csrf @method('DELETE')
                        <button type="submit" class="flex size-8 cursor-pointer items-center justify-center rounded-md text-muted hover:bg-subtle hover:text-danger"
                                title="{{ __('messages.wishlist_remove') }}" aria-label="{{ __('messages.wishlist_remove') }}: {{ $videojuego->titulo }}">
                            <x-icon name="trash" class="size-[18px]" />
                        </button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@endif
@endsection
