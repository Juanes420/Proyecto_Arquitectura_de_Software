@props(['variant' => 'primary', 'size' => 'md', 'href' => null, 'icon' => null])

@php
    $variantes = [
        'primary' => 'bg-ink text-on-ink hover:opacity-85',
        'secondary' => 'border border-line-strong bg-surface text-ink hover:border-ink',
        'ghost' => 'text-ink hover:bg-subtle',
        'danger' => 'border border-danger/40 text-danger hover:bg-danger hover:text-on-ink hover:border-danger',
        'accent' => 'bg-accent text-on-accent hover:opacity-90',
    ];
    $tamanos = [
        'sm' => 'h-8 gap-1.5 px-3 text-[13px]',
        'md' => 'h-10 gap-2 px-4 text-sm',
        'lg' => 'h-12 gap-2 px-6 text-[15px]',
    ];
    $clases = 'inline-flex shrink-0 cursor-pointer items-center justify-center whitespace-nowrap rounded-md font-medium transition-[background-color,border-color,color,opacity,transform] duration-200 ease-console active:scale-[0.98] disabled:pointer-events-none disabled:opacity-50 '
        . $variantes[$variant] . ' ' . $tamanos[$size];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $clases]) }}>
        @if($icon)<x-icon :name="$icon" class="size-[1.15em]" />@endif
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => $clases]) }}>
        @if($icon)<x-icon :name="$icon" class="size-[1.15em]" />@endif
        {{ $slot }}
    </button>
@endif
