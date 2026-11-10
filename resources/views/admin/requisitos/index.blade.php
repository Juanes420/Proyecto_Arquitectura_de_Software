{{-- Autor: Juanes Peña --}}
@extends('layouts.admin')

@section('header', __('messages.manage_requisitos'))

@section('actions')
    <x-button :href="route('admin.requisitos.create')" icon="plus">{{ __('messages.create') }} {{ __('messages.requisitos') }}</x-button>
@endsection

@section('content')
@if($requisitos->isEmpty())
    <x-empty-state icon="desktop-tower" :title="__('messages.no_results')" />
@else
    <x-card class="overflow-x-auto">
        <table class="gv-table">
            <thead>
                <tr>
                    <th scope="col">{{ __('messages.videojuego') }}</th>
                    <th scope="col">{{ __('messages.sistema_operativo') }}</th>
                    <th scope="col">{{ __('messages.procesador') }}</th>
                    <th scope="col">{{ __('messages.memoria_ram') }}</th>
                    <th scope="col"><span class="sr-only">{{ __('messages.actions') }}</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach($requisitos as $requisito)
                    <tr>
                        <td class="font-medium">{{ $requisito->videojuego->titulo }}</td>
                        <td class="text-muted">{{ $requisito->sistema_operativo }}</td>
                        <td class="text-muted">{{ $requisito->procesador }}</td>
                        <td class="whitespace-nowrap text-muted">{{ $requisito->memoria_ram }}</td>
                        <td>
                            <x-row-actions :edit="route('admin.requisitos.edit', $requisito)" :destroy="route('admin.requisitos.destroy', $requisito)"
                                           :nombre="$requisito->videojuego->titulo" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-card>

    <div class="mt-8">{{ $requisitos->links() }}</div>
@endif
@endsection
