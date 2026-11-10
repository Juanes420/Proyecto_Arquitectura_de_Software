@props(['videojuego'])

{{-- La portada usa la proporcion 2:3 de las caratulas, asi se ve completa sin recortar el logo. --}}
<a href="{{ route('videojuegos.show', $videojuego) }}" {{ $attributes->merge(['class' => 'gv-tile group flex flex-col bg-surface']) }}>
    <x-cover :src="$videojuego->imagen_url" :alt="$videojuego->titulo" class="aspect-[2/3] rounded-t-md" />
    <div class="flex flex-1 flex-col gap-1 border-x border-b border-line rounded-b-md p-4">
        <p class="text-[12px] text-muted">{{ $videojuego->plataforma }} · {{ $videojuego->categoria->nombre }}</p>
        <h3 class="text-[15px] font-medium leading-snug tracking-[-0.01em] text-ink text-pretty">{{ $videojuego->titulo }}</h3>
        <div class="mt-auto flex flex-wrap items-center justify-between gap-x-3 gap-y-2 pt-3">
            <x-price :value="$videojuego->precio" class="text-[15px] text-ink" />
            @if($videojuego->stock > 0)
                <x-badge color="success">{{ __('messages.disponible') }}</x-badge>
            @else
                <x-badge color="danger">{{ __('messages.agotado') }}</x-badge>
            @endif
        </div>
    </div>
</a>
