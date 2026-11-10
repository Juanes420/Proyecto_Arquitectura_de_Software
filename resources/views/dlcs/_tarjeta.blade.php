<article class="flex h-full flex-col rounded-md border border-line bg-surface">
    <x-cover :src="$dlc->imagen_url" :alt="$dlc->nombre" class="aspect-[460/215] rounded-t-md" />
    <div class="flex flex-1 flex-col gap-1 p-4">
        @isset($conJuego)
            <a href="{{ route('videojuegos.show', $dlc->videojuego_id) }}" class="text-[12px] text-muted hover:text-ink hover:underline">{{ __('messages.para_juego', ['juego' => $dlc->videojuego->titulo]) }}</a>
        @endisset
        <h3 class="text-[15px] font-medium leading-snug tracking-[-0.01em] text-pretty">{{ $dlc->nombre }}</h3>
        @if($dlc->descripcion)
            <p class="line-clamp-2 text-sm leading-relaxed text-muted">{{ $dlc->descripcion }}</p>
        @endif
        <div class="mt-auto flex flex-wrap items-center justify-between gap-3 pt-4">
            <x-price :value="$dlc->precio" class="text-[15px]" />
            <x-add-to-cart tipo="dlc" :id="$dlc->id" size="sm" icon="shopping-bag" />
        </div>
    </div>
</article>
