<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GameVault')</title>
    @include('layouts._assets')
</head>
<body class="bg-gray-100 min-h-screen">
    {{-- Navbar --}}
    <nav class="bg-indigo-700 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold">🎮 GameVault</a>

            <div class="flex items-center gap-4">
                <a href="{{ route('videojuegos.index') }}" class="hover:text-indigo-200">{{ __('messages.catalog') }}</a>

                @auth
                    <a href="{{ route('wishlist.index') }}" class="hover:text-indigo-200">
                        ❤️ {{ __('messages.wishlist') }}
                        @if(auth()->user()->wishlists->count())
                            <span class="bg-pink-500 text-white text-xs px-2 py-0.5 rounded-full">{{ auth()->user()->wishlists->count() }}</span>
                        @endif
                    </a>

                    <a href="{{ route('pedidos.index') }}" class="hover:text-indigo-200">📦 {{ __('messages.mis_pedidos') }}</a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-200">{{ __('messages.admin_panel') }}</a>
                    @endif

                    <span class="text-indigo-200">{{ auth()->user()->nombre }}</span>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-indigo-200">{{ __('auth.logout') }}</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-indigo-200">{{ __('auth.login') }}</a>
                    <a href="{{ route('register') }}" class="bg-white text-indigo-700 px-3 py-1 rounded hover:bg-indigo-100">{{ __('auth.register') }}</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto mt-4 px-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto mt-4 px-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Content --}}
    <main class="max-w-7xl mx-auto px-4 py-6">
        @yield('content')
    </main>
</body>
</html>
