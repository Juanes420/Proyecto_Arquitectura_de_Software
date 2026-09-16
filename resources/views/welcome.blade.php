@extends('layouts.app')

@section('title', 'GameVault - Tienda de Videojuegos')

@section('content')
<div class="text-center py-20">
    <h1 class="text-5xl font-bold text-indigo-700 mb-4">🎮 GameVault</h1>
    <p class="text-xl text-gray-600 mb-8">{{ __('messages.welcome') }}</p>

    <div class="flex justify-center gap-4">
        <a href="{{ route('videojuegos.index') }}"
           class="bg-indigo-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-indigo-700 transition">
            {{ __('messages.catalog') }}
        </a>

        @guest
            <a href="{{ route('register') }}"
               class="bg-white text-indigo-600 border-2 border-indigo-600 px-6 py-3 rounded-lg text-lg hover:bg-indigo-50 transition">
                {{ __('auth.register') }}
            </a>
        @endguest
    </div>
</div>
@endsection
