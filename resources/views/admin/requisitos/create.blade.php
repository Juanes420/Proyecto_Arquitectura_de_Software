{{-- Autor: Juanes Peña --}}
@extends('layouts.admin')

@section('header', __('messages.create') . ' ' . __('messages.requisitos'))
@section('back', route('admin.requisitos.index'))

@section('content')
<x-card class="max-w-2xl p-6 sm:p-8">
    <form action="{{ route('admin.requisitos.store') }}" method="POST">
        @csrf
        @include('admin.requisitos._form')

        <div class="mt-8 flex gap-3 border-t border-line pt-6">
            <x-button>{{ __('messages.save') }}</x-button>
            <x-button :href="route('admin.requisitos.index')" variant="ghost">{{ __('messages.cancel') }}</x-button>
        </div>
    </form>
</x-card>
@endsection
