@extends('layouts.admin')

@section('header', $videojuego->titulo)
@section('back', route('admin.videojuegos.index'))

@section('actions')
    <x-button :href="route('admin.videojuegos.edit', $videojuego)" icon="pencil-simple">{{ __('messages.edit') }}</x-button>
@endsection

@section('content')
<div class="grid gap-8 lg:grid-cols-[280px_minmax(0,1fr)]">
    <div class="self-start rounded-md border border-line bg-subtle p-1.5">
        <x-cover :src="$videojuego->imagen_url" :alt="$videojuego->titulo" class="aspect-[4/5] rounded-[4px]" />
    </div>

    <div class="flex flex-col gap-8">
        <dl class="grid gap-x-8 gap-y-6 sm:grid-cols-2">
            <div class="border-t border-line pt-4">
                <dt class="gv-label text-muted">{{ __('messages.plataforma') }}</dt>
                <dd class="mt-2">{{ $videojuego->plataforma }}</dd>
            </div>
            <div class="border-t border-line pt-4">
                <dt class="gv-label text-muted">{{ __('messages.categoria') }}</dt>
                <dd class="mt-2">{{ $videojuego->categoria->nombre }}</dd>
            </div>
            <div class="border-t border-line pt-4">
                <dt class="gv-label text-muted">{{ __('messages.precio') }}</dt>
                <dd class="mt-2"><x-price :value="$videojuego->precio" /></dd>
            </div>
            <div class="border-t border-line pt-4">
                <dt class="gv-label text-muted">{{ __('messages.stock') }}</dt>
                <dd class="mt-2 font-mono tabular-nums">{{ $videojuego->stock }}</dd>
            </div>
            @if($videojuego->descripcion)
                <div class="border-t border-line pt-4 sm:col-span-2">
                    <dt class="gv-label text-muted">{{ __('messages.descripcion') }}</dt>
                    <dd class="mt-2 max-w-[65ch] leading-relaxed">{{ $videojuego->descripcion }}</dd>
                </div>
            @endif
        </dl>

        @if($videojuego->dlcs->isNotEmpty())
            <section>
                <h2 class="text-lg font-semibold">{{ __('messages.dlcs') }} <span class="font-mono text-sm font-normal text-muted">({{ $videojuego->dlcs->count() }})</span></h2>
                <ul class="mt-3 divide-y divide-line rounded-md border border-line bg-surface">
                    @foreach($videojuego->dlcs as $dlc)
                        <li class="flex justify-between gap-4 px-4 py-3 text-sm">
                            <span>{{ $dlc->nombre }}</span>
                            <x-price :value="$dlc->precio" />
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        @if($videojuego->resenas->isNotEmpty())
            <section>
                <h2 class="flex flex-wrap items-center gap-3 text-lg font-semibold">
                    {{ __('messages.resenas') }}
                    <span class="inline-flex items-center gap-1 font-mono text-sm font-normal text-muted">
                        <x-icon name="star" class="size-4" />{{ __('messages.rating_out_of', ['value' => $videojuego->promedio_calificacion]) }}
                    </span>
                </h2>
                <ul class="mt-3 divide-y divide-line rounded-md border border-line bg-surface">
                    @foreach($videojuego->resenas as $resena)
                        <li class="px-4 py-3 text-sm">
                            <div class="flex justify-between gap-4">
                                <span class="font-medium">{{ $resena->usuario->nombre }}</span>
                                <span class="font-mono text-muted">{{ __('messages.rating_out_of', ['value' => $resena->calificacion]) }}</span>
                            </div>
                            @if($resena->comentario)
                                <p class="mt-1 leading-relaxed text-muted">{{ $resena->comentario }}</p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
    </div>
</div>
@endsection
