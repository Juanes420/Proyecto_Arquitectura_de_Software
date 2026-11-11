<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('messages.admin_panel') . ' - GameVault')</title>
    @include('layouts._assets')
</head>
<body class="min-h-[100dvh] bg-canvas font-sans text-ink">
    <a href="#contenido" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-md focus:bg-ink focus:px-4 focus:py-2 focus:text-sm focus:text-on-ink">
        {{ __('messages.skip_to_content') }}
    </a>

    <div class="md:flex">
        <aside class="border-b border-line bg-surface md:sticky md:top-0 md:flex md:h-[100dvh] md:w-64 md:shrink-0 md:flex-col md:border-b-0 md:border-r">
            <div class="flex h-16 items-center justify-between px-5">
                <a href="{{ route('admin.dashboard') }}" class="rounded-md"><x-logo /></a>
                <button type="button" class="flex size-10 items-center justify-center rounded-md hover:bg-subtle md:hidden"
                        aria-controls="admin-menu" aria-expanded="false" aria-label="{{ __('messages.open_menu') }}"
                        onclick="this.setAttribute('aria-expanded', !document.getElementById('admin-menu').classList.toggle('hidden'))">
                    <x-icon name="list" class="size-6" />
                </button>
            </div>

            <div id="admin-menu" class="hidden flex-1 flex-col px-3 pb-4 md:flex">
                <p class="gv-label px-3 pb-3 pt-2 text-muted">{{ __('messages.admin_panel') }}</p>
                <nav aria-label="{{ __('messages.admin_navigation') }}" class="flex flex-col gap-0.5">
                    <x-nav-link variant="guide" :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" icon="squares-four">{{ __('messages.dashboard') }}</x-nav-link>
                    <x-nav-link variant="guide" :href="route('admin.videojuegos.index')" :active="request()->routeIs('admin.videojuegos.*')" icon="game-controller">{{ __('messages.manage_videojuegos') }}</x-nav-link>
                    <x-nav-link variant="guide" :href="route('admin.categorias.index')" :active="request()->routeIs('admin.categorias.*')" icon="tag">{{ __('messages.manage_categorias') }}</x-nav-link>
                    <x-nav-link variant="guide" :href="route('admin.requisitos.index')" :active="request()->routeIs('admin.requisitos.*')" icon="desktop-tower">{{ __('messages.manage_requisitos') }}</x-nav-link>
                    <x-nav-link variant="guide" :href="route('admin.tarjetas.index')" :active="request()->routeIs('admin.tarjetas.*')" icon="credit-card">{{ __('messages.manage_tarjetas') }}</x-nav-link>
                </nav>

                <div class="mt-6 flex flex-col gap-0.5 border-t border-line pt-4 md:mt-auto">
                    <x-nav-link variant="guide" :href="route('home')" icon="storefront">{{ __('messages.back_to_site') }}</x-nav-link>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex h-10 w-full cursor-pointer items-center gap-3 rounded-md px-3 text-sm text-muted transition-colors duration-200 ease-console hover:bg-subtle hover:text-ink">
                            <x-icon name="sign-out" class="size-5" />
                            {{ __('auth.logout') }}
                        </button>
                    </form>
                    <div class="flex items-center justify-between gap-2 px-3 pt-3">
                        <span class="truncate text-sm text-muted">{{ auth()->user()->nombre }}</span>
                        <div class="flex items-center gap-1">
                            <x-theme-toggle />
                            <x-locale-switcher />
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <div class="min-w-0 flex-1">
            <main id="contenido" class="gv-enter mx-auto max-w-6xl px-4 py-10 sm:px-8">
                <div class="mb-8 flex flex-wrap items-end justify-between gap-4 border-b border-line pb-6">
                    <div class="min-w-0">
                        @php
                            // Resumen > Seccion (la URL de 'back' de cada vista) > Pagina actual.
                            $migas = [['label' => __('messages.dashboard'), 'url' => route('admin.dashboard')]];
                            if (View::hasSection('back')) {
                                $migas[] = ['label' => __('messages.' . explode('.', Route::currentRouteName())[1]), 'url' => html_entity_decode(View::yieldContent('back'), ENT_QUOTES)];
                            }
                            if (! request()->routeIs('admin.dashboard')) {
                                $migas[] = ['label' => html_entity_decode(View::yieldContent('header'), ENT_QUOTES), 'url' => null];
                            }
                        @endphp
                        <x-breadcrumbs :items="$migas" />
                        <h1 class="text-3xl font-semibold tracking-[-0.025em] text-balance">@yield('header')</h1>
                    </div>
                    @hasSection('actions')
                        <div class="flex flex-wrap items-center gap-2">@yield('actions')</div>
                    @endif
                </div>

                @if(session('success'))
                    <x-alert type="success" class="mb-8">{{ session('success') }}</x-alert>
                @endif
                @if(session('error'))
                    <x-alert type="error" class="mb-8">{{ session('error') }}</x-alert>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
