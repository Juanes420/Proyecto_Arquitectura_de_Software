@props(['videojuego', 'large' => false])

<a href="{{ route('videojuegos.show', $videojuego) }}" {{ $attributes->merge(['class' => 'gv-tile group flex flex-col bg-surface']) }}>
    <x-cover :src="$videojuego->imagen ? asset('storage/' . $videojuego->imagen) : null" :alt="$videojuego->titulo"
             class="rounded-t-md {{ $large ? 'aspect-[4/3] lg:aspect-auto lg:min-h-64 lg:flex-1' : 'aspect-[4/3]' }}" />
    <div class="flex {{ $large ? '' : 'flex-1' }} flex-col gap-1 border-x border-b border-line rounded-b-md p-4">
        <p class="text-[12px] text-muted">{{ $videojuego->plataforma }} · {{ $videojuego->categoria->nombre }}</p>
        <h3 class="{{ $large ? 'text-xl' : 'text-[15px]' }} font-medium leading-snug tracking-[-0.01em] text-ink text-pretty">{{ $videojuego->titulo }}</h3>
        <div class="mt-auto flex items-center justify-between gap-3 pt-3">
            <x-price :value="$videojuego->precio" class="text-[15px] text-ink" />
            @if($videojuego->stock > 0)
                <x-badge color="success">{{ __('messages.disponible') }}</x-badge>
            @else
                <x-badge color="danger">{{ __('messages.agotado') }}</x-badge>
            @endif
        </div>
    </div>
</a>
