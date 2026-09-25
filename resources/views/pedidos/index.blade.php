{{-- Autor: Juan David Bedoya --}}
@extends('layouts.app')

@section('title', __('messages.mis_pedidos') . ' - GameVault')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">📦 {{ __('messages.mis_pedidos') }}</h1>
        <a href="{{ route('pedidos.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            + {{ __('messages.nuevo_pedido') }}
        </a>
    </div>

    @if($pedidos->count())
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-gray-600 font-medium">#</th>
                        <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.fecha') }}</th>
                        <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.productos') }}</th>
                        <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.estado') }}</th>
                        <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.total') }}</th>
                        <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($pedidos as $pedido)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $pedido->id }}</td>
                            <td class="px-6 py-4">{{ $pedido->fecha->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4">{{ $pedido->detalles_count }}</td>
                            <td class="px-6 py-4">@include('pedidos._estado', ['estado' => $pedido->estado])</td>
                            <td class="px-6 py-4 font-bold text-green-600">${{ number_format($pedido->total, 2) }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('pedidos.show', $pedido) }}" class="text-indigo-600 hover:underline">
                                    {{ __('messages.view') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $pedidos->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-10 text-center">
            <p class="text-gray-500 mb-4">{{ __('messages.pedidos_empty') }}</p>
            <a href="{{ route('pedidos.create') }}" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                {{ __('messages.nuevo_pedido') }}
            </a>
        </div>
    @endif
</div>
@endsection
