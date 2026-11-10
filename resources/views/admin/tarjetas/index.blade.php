{{-- Autor: Juanes Peña --}}
@extends('layouts.admin')

@section('header', __('messages.manage_tarjetas'))

@section('actions')
    <x-button :href="route('admin.tarjetas.create')" icon="plus">{{ __('messages.create') }} {{ __('messages.tarjeta') }}</x-button>
@endsection

@section('content')
@if($tarjetas->isEmpty())
    <x-empty-state icon="credit-card" :title="__('messages.no_results')" />
@else
    <x-card class="overflow-x-auto">
        <table class="gv-table">
            <thead>
                <tr>
                    <th scope="col">{{ __('messages.nombre') }}</th>
                    <th scope="col">{{ __('messages.plataforma') }}</th>
                    <th scope="col" class="text-right">{{ __('messages.precio') }}</th>
                    <th scope="col" class="text-right">{{ __('messages.stock') }}</th>
                    <th scope="col"><span class="sr-only">{{ __('messages.actions') }}</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach($tarjetas as $tarjeta)
                    <tr>
                        <td class="font-medium">{{ $tarjeta->nombre }}</td>
                        <td class="whitespace-nowrap text-muted">{{ $tarjeta->plataforma }}</td>
                        <td class="text-right"><x-price :value="$tarjeta->precio" /></td>
                        <td class="text-right font-mono tabular-nums {{ $tarjeta->stock <= 0 ? 'text-danger' : '' }}">{{ $tarjeta->stock }}</td>
                        <td>
                            <x-row-actions :show="route('admin.tarjetas.show', $tarjeta)" :edit="route('admin.tarjetas.edit', $tarjeta)"
                                           :destroy="route('admin.tarjetas.destroy', $tarjeta)" :nombre="$tarjeta->nombre" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-card>

    <div class="mt-8">{{ $tarjetas->links() }}</div>
@endif
@endsection
