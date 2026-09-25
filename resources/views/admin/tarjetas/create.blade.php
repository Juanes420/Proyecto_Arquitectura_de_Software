{{-- Autor: Juanes Peña --}}
@extends('layouts.admin')

@section('header', __('messages.create') . ' ' . __('messages.tarjeta'))

@section('content')
<div class="max-w-2xl bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.tarjetas.store') }}" method="POST">
        @csrf

        <div class="space-y-4">

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">
                    {{ __('messages.nombre') }}
                </label>

                <input type="text"
                       name="nombre"
                       id="nombre"
                       value="{{ old('nombre') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                       required>

                @error('nombre')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="plataforma" class="block text-sm font-medium text-gray-700">
                    {{ __('messages.plataforma') }}
                </label>

                <input type="text"
                       name="plataforma"
                       id="plataforma"
                       value="{{ old('plataforma') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                       required>

                @error('plataforma')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="precio" class="block text-sm font-medium text-gray-700">
                    {{ __('messages.precio') }}
                </label>

                <input type="number"
                       name="precio"
                       id="precio"
                       value="{{ old('precio') }}"
                       min="0"
                       step="0.01"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                       required>

                @error('precio')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700">
                    {{ __('messages.stock') }}
                </label>

                <input type="number"
                       name="stock"
                       id="stock"
                       value="{{ old('stock', 0) }}"
                       min="0"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                       required>

                @error('stock')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">
                    {{ __('messages.descripcion') }}
                </label>

                <textarea name="descripcion"
                          id="descripcion"
                          rows="4"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('descripcion') }}</textarea>

                @error('descripcion')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="imagen" class="block text-sm font-medium text-gray-700">
                    {{ __('messages.imagen') }}
                </label>

                <input type="text"
                       name="imagen"
                       id="imagen"
                       value="{{ old('imagen') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">

                @error('imagen')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                {{ __('messages.save') }}
            </button>

            <a href="{{ route('admin.tarjetas.index') }}"
               class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                {{ __('messages.cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection