@extends('layouts.admin')

@section('header', __('messages.dashboard'))

@section('content')
<dl class="grid gap-4 sm:grid-cols-3">
    @foreach([
        ['label' => __('messages.total_videojuegos'), 'valor' => $totalVideojuegos],
        ['label' => __('messages.total_users'), 'valor' => $totalClientes],
        ['label' => __('messages.total_pedidos'), 'valor' => $totalPedidos],
    ] as $dato)
        <x-card class="p-6">
            <dt class="gv-label text-muted">{{ $dato['label'] }}</dt>
            <dd class="mt-3 font-mono text-5xl font-medium leading-none tracking-[-0.04em] tabular-nums">{{ $dato['valor'] }}</dd>
        </x-card>
    @endforeach
</dl>

<nav aria-label="{{ __('messages.admin_navigation') }}" class="mt-10 grid grid-cols-2 gap-4 lg:grid-cols-4">
    @foreach([
        ['ruta' => 'admin.videojuegos.index', 'icono' => 'game-controller', 'texto' => __('messages.manage_videojuegos')],
        ['ruta' => 'admin.categorias.index', 'icono' => 'tag', 'texto' => __('messages.manage_categorias')],
        ['ruta' => 'admin.requisitos.index', 'icono' => 'desktop-tower', 'texto' => __('messages.manage_requisitos')],
        ['ruta' => 'admin.tarjetas.index', 'icono' => 'credit-card', 'texto' => __('messages.manage_tarjetas')],
    ] as $acceso)
        <a href="{{ route($acceso['ruta']) }}" class="gv-tile flex aspect-[4/3] flex-col justify-between border border-line bg-surface p-5">
            <x-icon :name="$acceso['icono']" class="size-7 text-muted" />
            <span class="flex items-end justify-between gap-2 text-[15px] font-medium leading-snug">
                {{ $acceso['texto'] }}
                <x-icon name="arrow-right" class="size-4 shrink-0" />
            </span>
        </a>
    @endforeach
</nav>
@endsection
