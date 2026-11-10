{{-- Autor: Juanes Peña --}}
@extends('layouts.admin')

@section('header', __('messages.edit') . ' ' . __('messages.tarjeta'))
@section('back', route('admin.tarjetas.index'))

@section('content')
<x-card class="max-w-2xl p-6 sm:p-8">
    <form action="{{ route('admin.tarjetas.update', $tarjeta) }}" method="POST">
        @csrf @method('PUT')
        @include('admin.tarjetas._form')

        <div class="mt-8 flex gap-3 border-t border-line pt-6">
            <x-button>{{ __('messages.save') }}</x-button>
            <x-button :href="route('admin.tarjetas.index')" variant="ghost">{{ __('messages.cancel') }}</x-button>
        </div>
    </form>
</x-card>
@endsection
