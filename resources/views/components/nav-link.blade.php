@props(['href', 'active' => false, 'icon' => null, 'variant' => 'pivot'])

@php
    // pivot: pestañas de la barra superior con subrayado activo.
    // guide: elementos de la barra lateral; el activo se rellena como el elemento enfocado de un menu de consola.
    $variantes = [
        'pivot' => 'relative flex h-10 items-center gap-2 whitespace-nowrap px-1 text-[13px] font-medium uppercase tracking-[0.08em] transition-colors duration-200 ease-console after:absolute after:inset-x-1 after:-bottom-px after:h-0.5 after:origin-left after:transition-transform after:duration-300 after:ease-console '
            . ($active ? 'text-ink after:scale-x-100 after:bg-accent' : 'text-muted hover:text-ink after:scale-x-0 after:bg-ink hover:after:scale-x-100'),
        'guide' => 'flex h-10 items-center gap-3 rounded-md px-3 text-sm transition-colors duration-200 ease-console '
            . ($active ? 'bg-ink font-medium text-on-ink' : 'text-muted hover:bg-subtle hover:text-ink'),
    ];
@endphp

<a href="{{ $href }}" @if($active) aria-current="page" @endif {{ $attributes->merge(['class' => $variantes[$variant]]) }}>
    @if($icon)
        <x-icon :name="$icon" class="size-5" />
    @endif
    {{ $slot }}
</a>
