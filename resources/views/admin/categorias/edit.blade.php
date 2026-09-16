{{-- Autor: Juanes Peña --}}
@extends('layouts.admin')

@section('header', __('messages.edit') . ' ' . __('messages.categoria'))

@section('content')
<div class="max-w-2xl bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.categorias.update', $categoria) }}" method="POST">
        @csrf @method('PUT')
        @include('admin.categorias._form')

        <div class="flex gap-3">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                {{ __('messages.save') }}
            </button>
            <a href="{{ route('admin.categorias.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                {{ __('messages.cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection
