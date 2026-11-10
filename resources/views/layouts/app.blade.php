<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GameVault')</title>
    @include('layouts._assets')
</head>
<body class="flex min-h-[100dvh] flex-col bg-canvas font-sans text-ink">
    <a href="#contenido" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-md focus:bg-ink focus:px-4 focus:py-2 focus:text-sm focus:text-on-ink">
        {{ __('messages.skip_to_content') }}
    </a>

    <header class="sticky top-0 z-40 border-b border-line bg-canvas/85 backdrop-blur-md">
        <div class="relative mx-auto flex h-16 max-w-7xl items-center gap-6 px-4 sm:px-6 xl:gap-8">
            <a href="{{ route('home') }}" class="rounded-md">
                <x-logo />
            </a>

            <button type="button" class="ml-auto flex size-10 items-center justify-center rounded-md text-ink hover:bg-subtle xl:hidden"
                    aria-controls="nav-menu" aria-expanded="false" aria-label="{{ __('messages.open_menu') }}"
                    onclick="this.setAttribute('aria-expanded', !document.getElementById('nav-menu').classList.toggle('hidden'))">
                <x-icon name="list" class="size-6" />
            </button>

            <div id="nav-menu" class="absolute inset-x-0 top-full hidden flex-col gap-6 border-b border-line bg-canvas px-4 py-6 xl:static xl:flex xl:flex-1 xl:flex-row xl:items-center xl:justify-between xl:border-0 xl:bg-transparent xl:p-0">
                <nav aria-label="{{ __('messages.main_navigation') }}" class="flex flex-col gap-1 xl:flex-row xl:gap-6">
                    <x-nav-link :href="route('videojuegos.index')" :active="request()->routeIs('videojuegos.*')">{{ __('messages.catalog') }}</x-nav-link>
                    <x-nav-link :href="route('dlcs.index')" :active="request()->routeIs('dlcs.*')">{{ __('messages.dlc') }}</x-nav-link>
                    <x-nav-link :href="route('tarjetas.index')" :active="request()->routeIs('tarjetas.*')">{{ __('messages.nav_tarjetas') }}</x-nav-link>
                    <x-nav-link :href="route('juegos-gratis.index')" :active="request()->routeIs('juegos-gratis.*')">{{ __('messages.juegos_gratis') }}</x-nav-link>
                    <x-nav-link :href="route('productos-aliados.index')" :active="request()->routeIs('productos-aliados.*')">{{ __('messages.productos_aliados') }}</x-nav-link>
                </nav>

                <div class="flex flex-col gap-1 border-t border-line pt-6 xl:flex-row xl:items-center xl:gap-2 xl:border-0 xl:pt-0">
                    <a href="{{ route('carrito.index') }}" title="{{ __('messages.carrito') }}" class="flex h-10 items-center gap-2 rounded-md px-2 text-sm text-muted transition-colors duration-200 ease-console hover:text-ink {{ request()->routeIs('carrito.*') ? 'text-ink' : '' }}"
                       @if(request()->routeIs('carrito.*')) aria-current="page" @endif>
                        <x-icon name="shopping-bag" class="size-5" />
                        <span class="xl:sr-only">{{ __('messages.carrito') }}</span>
                        @if($carritoCantidad)
                            <span class="font-mono text-xs tabular-nums text-ink">{{ $carritoCantidad }}</span>
                        @endif
                    </a>
                    @auth
                        <a href="{{ route('wishlist.index') }}" class="flex h-10 items-center gap-2 rounded-md px-2 text-sm text-muted transition-colors duration-200 ease-console hover:text-ink {{ request()->routeIs('wishlist.*') ? 'text-ink' : '' }}"
                           @if(request()->routeIs('wishlist.*')) aria-current="page" @endif>
                            <x-icon name="heart" class="size-5" />
                            <span class="xl:sr-only">{{ __('messages.wishlist') }}</span>
                            @if($wishlistCount)
                                <span class="font-mono text-xs tabular-nums">{{ $wishlistCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('pedidos.index') }}" title="{{ __('messages.mis_pedidos') }}" class="flex h-10 items-center gap-2 rounded-md px-2 text-sm text-muted transition-colors duration-200 ease-console hover:text-ink {{ request()->routeIs('pedidos.*') ? 'text-ink' : '' }}"
                           @if(request()->routeIs('pedidos.*')) aria-current="page" @endif>
                            <x-icon name="package" class="size-5" />
                            <span class="xl:sr-only">{{ __('messages.mis_pedidos') }}</span>
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" title="{{ __('messages.admin_panel') }}" class="flex h-10 items-center gap-2 rounded-md px-2 text-sm text-muted transition-colors duration-200 ease-console hover:text-ink">
                                <x-icon name="squares-four" class="size-5" />
                                <span class="xl:sr-only">{{ __('messages.admin_panel') }}</span>
                            </a>
                        @endif
                        <div class="flex items-center gap-2 px-2 text-sm text-muted xl:ml-2 xl:border-l xl:border-line xl:pl-4">
                            <span class="max-w-40 truncate whitespace-nowrap xl:hidden 2xl:inline">{{ auth()->user()->nombre }}</span>
                            <form action="{{ route('logout') }}" method="POST" class="ml-auto xl:ml-0">
                                @csrf
                                <button type="submit" class="flex size-9 cursor-pointer items-center justify-center rounded-md text-muted hover:bg-subtle hover:text-ink"
                                        title="{{ __('auth.logout') }}" aria-label="{{ __('auth.logout') }}">
                                    <x-icon name="sign-out" class="size-5" />
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="flex h-10 items-center whitespace-nowrap px-2 text-sm text-muted hover:text-ink">{{ __('auth.login') }}</a>
                        <x-button :href="route('register')" size="sm" class="self-start xl:self-auto">{{ __('auth.register') }}</x-button>
                    @endauth

                    <div class="mt-2 flex items-center gap-2 xl:ml-3 xl:mt-0">
                        <x-theme-toggle />
                        <x-locale-switcher />
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main id="contenido" class="gv-enter mx-auto w-full max-w-7xl flex-1 px-4 py-10 sm:px-6">
        @if(session('success'))
            <x-alert type="success" class="mb-8">{{ session('success') }}</x-alert>
        @endif
        @if(session('error'))
            <x-alert type="error" class="mb-8">{{ session('error') }}</x-alert>
        @endif
        @foreach(['carrito', 'productos'] as $campoError)
            @error($campoError)
                <x-alert type="error" class="mb-8">{{ $message }}</x-alert>
            @enderror
        @endforeach

        @yield('content')
    </main>

    <footer class="border-t border-line">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-[2fr_1fr_1fr]">
            <div>
                <x-logo />
                <p class="mt-4 max-w-sm text-sm leading-relaxed text-muted">{{ __('messages.footer_tagline') }}</p>
            </div>
            <nav aria-label="{{ __('messages.footer_store') }}">
                <h2 class="gv-label text-muted">{{ __('messages.footer_store') }}</h2>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('videojuegos.index') }}" class="text-ink/80 hover:text-ink">{{ __('messages.catalog') }}</a></li>
                    <li><a href="{{ route('dlcs.index') }}" class="text-ink/80 hover:text-ink">{{ __('messages.dlc') }}</a></li>
                    <li><a href="{{ route('tarjetas.index') }}" class="text-ink/80 hover:text-ink">{{ __('messages.nav_tarjetas') }}</a></li>
                    <li><a href="{{ route('juegos-gratis.index') }}" class="text-ink/80 hover:text-ink">{{ __('messages.juegos_gratis') }}</a></li>
                    <li><a href="{{ route('productos-aliados.index') }}" class="text-ink/80 hover:text-ink">{{ __('messages.productos_aliados') }}</a></li>
                </ul>
            </nav>
            <nav aria-label="{{ __('messages.footer_account') }}">
                <h2 class="gv-label text-muted">{{ __('messages.footer_account') }}</h2>
                <ul class="mt-4 space-y-2.5 text-sm">
                    @auth
                        <li><a href="{{ route('pedidos.index') }}" class="text-ink/80 hover:text-ink">{{ __('messages.mis_pedidos') }}</a></li>
                        <li><a href="{{ route('wishlist.index') }}" class="text-ink/80 hover:text-ink">{{ __('messages.wishlist') }}</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="text-ink/80 hover:text-ink">{{ __('auth.login') }}</a></li>
                        <li><a href="{{ route('register') }}" class="text-ink/80 hover:text-ink">{{ __('auth.register') }}</a></li>
                    @endauth
                </ul>
            </nav>
        </div>
        <div class="border-t border-line">
            <p class="mx-auto max-w-7xl px-4 py-5 text-xs text-muted sm:px-6">&copy; {{ date('Y') }} GameVault. {{ __('messages.footer_rights') }}</p>
        </div>
    </footer>
</body>
</html>
