{{-- Autor: Juanes Peña --}}
@extends('layouts.admin')

@section('header', $tarjeta->nombre)

@section('content')
<div class="max-w-2xl bg-white rounded-lg shadow p-6">

    <div class="space-y-4">

        <div>
            <p class="text-sm text-gray-500">{{ __('messages.nombre') }}</p>
            <p class="text-lg font-medium">{{ $tarjeta->nombre }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">{{ __('messages.plataforma') }}</p>
            <p class="text-lg">{{ $tarjeta->plataforma }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">{{ __('messages.precio') }}</p>
            <p class="text-lg">${{ number_format($tarjeta->precio, 2) }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">{{ __('messages.stock') }}</p>
            <p class="text-lg">{{ $tarjeta->stock }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">{{ __('messages.descripcion') }}</p>
            <p class="text-gray-700">{{ $tarjeta->descripcion ?: '-' }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">{{ __('messages.imagen') }}</p>
            <p class="text-gray-700">{{ $tarjeta->imagen ?: '-' }}</p>
        </div>

    </div>

    <div class="flex gap-3 mt-6">
        <a href="{{ route('admin.tarjetas.edit', $tarjeta) }}"
           class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600">
            {{ __('messages.edit') }}
        </a>

        <a href="{{ route('admin.tarjetas.index') }}"
           class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
            {{ __('messages.cancel') }}
        </a>
    </div>

</div>
@endsection