{{-- Autor: Juanes Peña --}}
@extends('layouts.admin')

@section('header', $tarjeta->nombre)
@section('back', route('admin.tarjetas.index'))

@section('actions')
    <x-button :href="route('admin.tarjetas.edit', $tarjeta)" icon="pencil-simple">{{ __('messages.edit') }}</x-button>
@endsection

@section('content')
<div class="grid gap-8 lg:grid-cols-[280px_minmax(0,1fr)]">
    <div class="self-start rounded-md border border-line bg-subtle p-1.5">
        <x-cover :src="$tarjeta->imagen" :alt="$tarjeta->nombre" icon="credit-card" class="aspect-[4/3] rounded-[4px]" />
    </div>

    <dl class="grid content-start gap-x-8 gap-y-6 sm:grid-cols-2">
        <div class="border-t border-line pt-4">
            <dt class="gv-label text-muted">{{ __('messages.plataforma') }}</dt>
            <dd class="mt-2">{{ $tarjeta->plataforma }}</dd>
        </div>
        <div class="border-t border-line pt-4">
            <dt class="gv-label text-muted">{{ __('messages.precio') }}</dt>
            <dd class="mt-2"><x-price :value="$tarjeta->precio" /></dd>
        </div>
        <div class="border-t border-line pt-4">
            <dt class="gv-label text-muted">{{ __('messages.stock') }}</dt>
            <dd class="mt-2 font-mono tabular-nums">{{ $tarjeta->stock }}</dd>
        </div>
        <div class="border-t border-line pt-4">
            <dt class="gv-label text-muted">{{ __('messages.imagen') }}</dt>
            <dd class="mt-2 break-all text-sm text-muted">{{ $tarjeta->imagen ?: '-' }}</dd>
        </div>
        <div class="border-t border-line pt-4 sm:col-span-2">
            <dt class="gv-label text-muted">{{ __('messages.descripcion') }}</dt>
            <dd class="mt-2 max-w-[65ch] leading-relaxed">{{ $tarjeta->descripcion ?: '-' }}</dd>
        </div>
    </dl>
</div>
@endsection
