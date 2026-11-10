{{-- Tarjeta de regalo: usa la imagen si existe; si no, una tarjeta dibujada con la plataforma y el monto. --}}
@props(['imagen' => null, 'plataforma', 'precio', 'alt' => ''])

<div {{ $attributes->merge(['class' => 'relative aspect-[8/5] overflow-hidden rounded-md']) }}>
    @if($imagen)
        <div class="absolute inset-0 flex items-center justify-center bg-[#171a21] p-3">
            <img src="{{ $imagen }}" alt="{{ $alt }}" loading="lazy" class="max-h-full max-w-full object-contain">
        </div>
    @else
        <div class="absolute inset-0 flex flex-col justify-between bg-[#1c1c1a] p-[8%] text-[#f8f7f4]" role="img" aria-label="{{ $alt }}">
            <div class="flex items-start justify-between gap-2">
                <span class="gv-label opacity-70">{{ $plataforma }}</span>
                <x-logo variant="mark" class="text-[#f8f7f4] opacity-80" />
            </div>
            <span class="font-mono text-[clamp(1.25rem,4vw,2.25rem)] font-medium leading-none tracking-[-0.03em] tabular-nums">${{ number_format($precio, 0) }}</span>
        </div>
    @endif
</div>
