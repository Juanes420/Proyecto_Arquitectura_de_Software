@props(['type' => 'success'])

@php
    $estilos = [
        'success' => ['clases' => 'border-accent/30 bg-accent/8 text-ink', 'icono' => 'check-circle', 'color' => 'text-accent', 'rol' => 'status'],
        'error' => ['clases' => 'border-danger/30 bg-danger/8 text-ink', 'icono' => 'warning-circle', 'color' => 'text-danger', 'rol' => 'alert'],
        'warning' => ['clases' => 'border-warning/30 bg-warning/8 text-ink', 'icono' => 'warning-circle', 'color' => 'text-warning', 'rol' => 'status'],
        'info' => ['clases' => 'border-line bg-surface text-ink', 'icono' => 'info', 'color' => 'text-muted', 'rol' => 'status'],
    ][$type];
@endphp

<div role="{{ $estilos['rol'] }}" {{ $attributes->merge(['class' => 'flex items-start gap-3 rounded-md border px-4 py-3 text-sm leading-relaxed ' . $estilos['clases']]) }}>
    <x-icon :name="$estilos['icono']" class="mt-0.5 size-5 {{ $estilos['color'] }}" />
    <div class="min-w-0">{{ $slot }}</div>
</div>
