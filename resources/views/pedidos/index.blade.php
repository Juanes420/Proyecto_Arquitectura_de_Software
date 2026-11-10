{{-- Autor: Juan David Bedoya --}}
@extends('layouts.app')

@section('title', __('messages.mis_pedidos') . ' - GameVault')

@section('content')
<x-page-header :title="__('messages.mis_pedidos')">
    <x-slot:actions>
        <x-button :href="route('pedidos.create')" icon="plus">{{ __('messages.nuevo_pedido') }}</x-button>
    </x-slot:actions>
</x-page-header>

@if($pedidos->isEmpty())
    <x-empty-state icon="package" :title="__('messages.pedidos_empty')">
        <x-button :href="route('videojuegos.index')" variant="secondary">{{ __('messages.catalog') }}</x-button>
    </x-empty-state>
@else
    <x-card class="overflow-x-auto">
        <table class="gv-table">
            <thead>
                <tr>
                    <th scope="col">{{ __('messages.pedido') }}</th>
                    <th scope="col">{{ __('messages.fecha') }}</th>
                    <th scope="col">{{ __('messages.productos') }}</th>
                    <th scope="col">{{ __('messages.estado') }}</th>
                    <th scope="col" class="text-right">{{ __('messages.total') }}</th>
                    <th scope="col"><span class="sr-only">{{ __('messages.actions') }}</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                    <tr>
                        <td class="font-mono tabular-nums">#{{ $pedido->id }}</td>
                        <td class="whitespace-nowrap text-muted">{{ $pedido->fecha->format('d/m/Y H:i') }}</td>
                        <td class="font-mono tabular-nums">{{ $pedido->detalles_count }}</td>
                        <td>@include('pedidos._estado', ['estado' => $pedido->estado])</td>
                        <td class="text-right"><x-price :value="$pedido->total" /></td>
                        <td class="text-right">
                            <a href="{{ route('pedidos.show', $pedido) }}" class="inline-flex items-center gap-1 whitespace-nowrap text-[13px] font-medium text-ink hover:underline">
                                {{ __('messages.view_details') }}
                                <x-icon name="arrow-right" class="size-4" />
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-card>

    <div class="mt-8">{{ $pedidos->links() }}</div>
@endif
@endsection
