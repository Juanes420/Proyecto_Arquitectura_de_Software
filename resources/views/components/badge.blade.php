@props(['color' => 'neutral'])

@php
    $colores = [
        'neutral' => 'border-line-strong text-muted',
        'success' => 'border-accent/40 text-accent',
        'danger' => 'border-danger/40 text-danger',
        'warning' => 'border-warning/40 text-warning',
        'solid' => 'border-ink bg-ink text-on-ink',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center whitespace-nowrap rounded-sm border px-1.5 py-0.5 text-[11px] font-medium uppercase leading-none tracking-[0.08em] ' . $colores[$color]]) }}>
    {{ $slot }}
</span>
