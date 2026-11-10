@extends('layouts.admin')

@section('header', __('messages.create') . ' ' . __('messages.videojuego'))
@section('back', route('admin.videojuegos.index'))

@section('content')
<x-card class="max-w-2xl p-6 sm:p-8">
    <form action="{{ route('admin.videojuegos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.videojuegos._form')

        <div class="mt-8 flex gap-3 border-t border-line pt-6">
            <x-button>{{ __('messages.save') }}</x-button>
            <x-button :href="route('admin.videojuegos.index')" variant="ghost">{{ __('messages.cancel') }}</x-button>
        </div>
    </form>
</x-card>
@endsection
