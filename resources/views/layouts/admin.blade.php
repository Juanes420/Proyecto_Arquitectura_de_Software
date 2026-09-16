<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - GameVault')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="flex">
        {{-- Sidebar --}}
        <aside class="w-64 bg-gray-900 text-white min-h-screen p-4">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold block mb-8">🎮 GameVault Admin</a>

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    📊 {{ __('messages.dashboard') }}
                </a>
                <a href="{{ route('admin.videojuegos.index') }}"
                   class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.videojuegos.*') ? 'bg-gray-700' : '' }}">
                    🎮 {{ __('messages.manage_videojuegos') }}
                </a>
                {{-- TODO: Tarjetas link (Bedoya) --}}
            </nav>

            <div class="mt-auto pt-8">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded hover:bg-gray-700 text-gray-400">
                    ← {{ __('messages.back') }} al sitio
                </a>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button class="block w-full text-left px-3 py-2 rounded hover:bg-gray-700 text-gray-400">
                        {{ __('auth.logout') }}
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1">
            <header class="bg-white shadow px-6 py-4">
                <h1 class="text-2xl font-semibold text-gray-800">@yield('header')</h1>
            </header>

            @if(session('success'))
                <div class="mx-6 mt-4">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
