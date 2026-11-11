@extends('layouts.app')

@section('title', $videojuego->titulo . ' - GameVault')

@section('content')
<a href="{{ route('videojuegos.index') }}" class="mb-6 inline-flex items-center gap-1.5 text-[13px] text-muted transition-colors duration-200 ease-console hover:text-ink">
    <x-icon name="arrow-left" class="size-4" />
    {{ __('messages.catalog') }}
</a>

<article class="grid gap-10 lg:grid-cols-[minmax(0,4fr)_minmax(0,7fr)] lg:gap-14">
    {{-- Marco doble: bandeja exterior y portada interior. --}}
    <div class="w-full max-w-sm self-start rounded-md border border-line bg-subtle p-1.5 lg:max-w-none">
        <x-cover :src="$videojuego->imagen_url" :alt="$videojuego->titulo"
                 :eager="true" class="aspect-[2/3] rounded-[4px]" />
    </div>

    <div class="flex flex-col">
        <p class="text-sm text-muted">{{ $videojuego->plataforma }} · {{ $videojuego->categoria->nombre }}</p>
        <h1 class="mt-2 text-4xl font-semibold leading-[1.05] tracking-[-0.03em] text-balance sm:text-5xl">{{ $videojuego->titulo }}</h1>

        @if($videojuego->promedio_calificacion)
            <p class="mt-4 flex items-center gap-2 text-sm text-muted">
                <x-stars :value="$videojuego->promedio_calificacion" size="size-[18px]" />
                <span class="font-mono tabular-nums text-ink">{{ __('messages.rating_out_of', ['value' => \App\Models\Resena::formatear($videojuego->promedio_calificacion)]) }}</span>
                <span>({{ $videojuego->resenas->count() }} {{ __('messages.resenas') }})</span>
            </p>
        @endif

        <div class="mt-8 flex flex-wrap items-center gap-4 border-y border-line py-6">
            <x-price :value="$videojuego->precio" class="text-3xl font-medium tracking-[-0.02em]" />
            @if($videojuego->stock > 0)
                <x-badge color="success">{{ $videojuego->stock }} {{ __('messages.en_stock') }}</x-badge>
            @else
                <x-badge color="danger">{{ __('messages.agotado') }}</x-badge>
            @endif
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            @if($videojuego->stock > 0)
                <x-add-to-cart tipo="videojuego" :id="$videojuego->id" comprar size="lg" />
                <x-add-to-cart tipo="videojuego" :id="$videojuego->id" size="lg" icon="shopping-bag" />
            @endif
            @auth
                @include('wishlist._boton', ['videojuego' => $videojuego])
            @endauth
        </div>

        @if($videojuego->descripcion)
            <p class="mt-8 max-w-[65ch] text-[15px] leading-relaxed text-ink/85">{{ $videojuego->descripcion }}</p>
        @endif
    </div>
</article>

@if($videojuego->requisitosMinimosPC)
    @include('videojuegos._requisitos', ['requisitos' => $videojuego->requisitosMinimosPC])
@endif

@if($videojuego->dlcs->isNotEmpty())
    <section class="mt-20" aria-labelledby="dlcs">
        <h2 id="dlcs" class="text-2xl font-semibold tracking-[-0.02em]">{{ __('messages.dlcs') }}</h2>
        <ul class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($videojuego->dlcs as $dlc)
                <li>@include('dlcs._tarjeta', ['dlc' => $dlc])</li>
            @endforeach
        </ul>
    </section>
@endif

<section class="mt-20 grid gap-10 lg:grid-cols-[minmax(0,5fr)_minmax(0,6fr)] lg:gap-14" aria-labelledby="resenas">
    <div>
        <h2 id="resenas" class="text-2xl font-semibold tracking-[-0.02em]">{{ __('messages.resenas') }}</h2>

        @auth
            @unless($miResena)
                <form action="{{ route('resenas.store', $videojuego) }}" method="POST" class="mt-6 flex flex-col gap-5 rounded-md border border-line bg-surface p-6">
                    @csrf
                    <h3 class="text-base font-medium">{{ __('messages.write_review') }}</h3>
                    <x-rating-input :label="__('messages.calificacion')" />
                    <x-textarea :label="__('messages.comentario')" name="comentario" maxlength="1000" />
                    <x-button class="self-start">{{ __('messages.save') }}</x-button>
                </form>
            @endunless
        @else
            <p class="mt-6 text-sm text-muted">
                <a href="{{ route('login') }}" class="text-ink underline decoration-line-strong underline-offset-4 hover:decoration-ink">{{ __('messages.login_to_review') }}</a>
            </p>
        @endauth
    </div>

    <div>
        @forelse($videojuego->resenas as $resena)
            <div class="border-b border-line py-6 first:pt-0 last:border-0">
                <div class="flex flex-wrap items-baseline justify-between gap-2">
                    <p class="font-medium">{{ $resena->usuario->nombre }}</p>
                    <p class="text-xs text-muted">{{ $resena->created_at->diffForHumans() }}</p>
                </div>
                <p class="mt-1 flex items-center gap-1.5 text-sm text-muted">
                    <x-stars :value="$resena->calificacion" />
                    <span class="font-mono tabular-nums">{{ __('messages.rating_out_of', ['value' => \App\Models\Resena::formatear($resena->calificacion)]) }}</span>
                </p>
                @if($resena->comentario)
                    <p class="mt-3 max-w-[65ch] text-[15px] leading-relaxed text-ink/85">{{ $resena->comentario }}</p>
                @endif

                @if($miResena && $resena->is($miResena))
                    <form action="{{ route('resenas.destroy', $resena) }}" method="POST" class="mt-3"
                          onsubmit="return confirm(@js(__('messages.confirm_delete')))">
                        @csrf @method('DELETE')
                        <button class="inline-flex cursor-pointer items-center gap-1.5 text-[13px] text-danger hover:underline">
                            <x-icon name="trash" class="size-4" />
                            {{ __('messages.delete') }}
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <x-empty-state icon="star" :title="__('messages.reviews_empty')" />
        @endforelse
    </div>
</section>
@endsection
