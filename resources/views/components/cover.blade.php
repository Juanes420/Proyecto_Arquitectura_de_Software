{{-- Portada de un producto. Sin imagen muestra un mosaico neutro con el icono del tipo de producto. --}}
@props(['src' => null, 'alt' => '', 'icon' => 'game-controller', 'eager' => false])

<div {{ $attributes->merge(['class' => 'relative overflow-hidden bg-subtle']) }}>
    @if($src)
        <img src="{{ $src }}" alt="{{ $alt }}" @unless($eager) loading="lazy" @endunless decoding="async"
             class="absolute inset-0 size-full object-cover transition-transform duration-700 ease-console group-hover:scale-[1.03]">
    @else
        <div class="absolute inset-0 flex items-center justify-center text-muted" role="img" aria-label="{{ $alt }}">
            <x-icon :name="$icon" class="size-10" />
        </div>
    @endif
</div>
