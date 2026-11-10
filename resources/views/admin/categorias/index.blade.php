{{-- Autor: Juanes Peña --}}
@extends('layouts.admin')

@section('header', __('messages.manage_categorias'))

@section('actions')
    <x-button :href="route('admin.categorias.create')" icon="plus">{{ __('messages.create') }} {{ __('messages.categoria') }}</x-button>
@endsection

@section('content')
@if($categorias->isEmpty())
    <x-empty-state icon="tag" :title="__('messages.no_results')" />
@else
    <x-card class="overflow-x-auto">
        <table class="gv-table">
            <thead>
                <tr>
                    <th scope="col">{{ __('messages.nombre') }}</th>
                    <th scope="col">{{ __('messages.descripcion') }}</th>
                    <th scope="col" class="text-right">{{ __('messages.videojuegos') }}</th>
                    <th scope="col"><span class="sr-only">{{ __('messages.actions') }}</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $categoria)
                    <tr>
                        <td class="whitespace-nowrap font-medium">{{ $categoria->nombre }}</td>
                        <td class="min-w-60 text-muted">{{ Str::limit($categoria->descripcion, 70) }}</td>
                        <td class="text-right font-mono tabular-nums">{{ $categoria->videojuegos_count }}</td>
                        <td>
                            <x-row-actions :show="route('admin.categorias.show', $categoria)" :edit="route('admin.categorias.edit', $categoria)"
                                           :destroy="route('admin.categorias.destroy', $categoria)" :nombre="$categoria->nombre" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-card>

    <div class="mt-8">{{ $categorias->links() }}</div>
@endif
@endsection
