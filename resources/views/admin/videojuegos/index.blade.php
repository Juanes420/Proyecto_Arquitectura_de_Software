@extends('layouts.admin')

@section('header', __('messages.manage_videojuegos'))

@section('actions')
    <x-button :href="route('admin.videojuegos.create')" icon="plus">{{ __('messages.create') }} {{ __('messages.videojuego') }}</x-button>
@endsection

@section('content')
@if($videojuegos->isEmpty())
    <x-empty-state icon="game-controller" :title="__('messages.no_results')" />
@else
    <x-card class="overflow-x-auto">
        <table class="gv-table">
            <thead>
                <tr>
                    <th scope="col">{{ __('messages.titulo') }}</th>
                    <th scope="col">{{ __('messages.plataforma') }}</th>
                    <th scope="col">{{ __('messages.categoria') }}</th>
                    <th scope="col" class="text-right">{{ __('messages.precio') }}</th>
                    <th scope="col" class="text-right">{{ __('messages.stock') }}</th>
                    <th scope="col"><span class="sr-only">{{ __('messages.actions') }}</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach($videojuegos as $vj)
                    <tr>
                        <td class="font-medium">{{ $vj->titulo }}</td>
                        <td class="whitespace-nowrap text-muted">{{ $vj->plataforma }}</td>
                        <td class="text-muted">{{ $vj->categoria->nombre }}</td>
                        <td class="text-right"><x-price :value="$vj->precio" /></td>
                        <td class="text-right font-mono tabular-nums {{ $vj->stock <= 0 ? 'text-danger' : '' }}">{{ $vj->stock }}</td>
                        <td>
                            <x-row-actions :show="route('admin.videojuegos.show', $vj)" :edit="route('admin.videojuegos.edit', $vj)"
                                           :destroy="route('admin.videojuegos.destroy', $vj)" :nombre="$vj->titulo" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-card>

    <div class="mt-8">{{ $videojuegos->links() }}</div>
@endif
@endsection
