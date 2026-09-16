@extends('layouts.app')

@section('title', __('auth.register') . ' - GameVault')

@section('content')
<div class="max-w-md mx-auto mt-10">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-center mb-6">{{ __('auth.register') }}</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-medium mb-2">{{ __('auth.name') }}</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required autofocus
                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror">
                @error('nombre')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">{{ __('auth.email') }}</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">{{ __('auth.password_label') }}</label>
                <input type="password" name="password" id="password" required
                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">{{ __('auth.confirm_password') }}</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition">
                {{ __('auth.register') }}
            </button>
        </form>

        <p class="text-center mt-4 text-gray-600">
            {{ __('auth.has_account') }}
            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">{{ __('auth.login') }}</a>
        </p>
    </div>
</div>
@endsection
