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
    <nav class="bg-indigo-700 text-white shadow-lg relative">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold shrink-0">🎮 GameVault</a>

            <button onclick="document.getElementById('nav-menu').classList.toggle('hidden')" class="md:hidden p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div id="nav-menu" class="hidden md:flex md:items-center md:gap-4 absolute md:static top-full left-0 right-0 bg-indigo-700 md:bg-transparent px-4 pb-4 md:p-0 flex-col md:flex-row gap-3 z-50">
                <a href="{{ route('videojuegos.index') }}" class="hover:text-indigo-200">{{ __('messages.catalog') }}</a>

                @auth
                    @php $wishlistCount = auth()->user()->wishlists()->count(); @endphp
                    <a href="{{ route('wishlist.index') }}" class="hover:text-indigo-200">
                        ❤️ {{ __('messages.wishlist') }}
                        @if($wishlistCount)
                            <span class="bg-pink-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $wishlistCount }}</span>
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
