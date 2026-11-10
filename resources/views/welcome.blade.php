@extends('layouts.app')

@section('title', 'GameVault - ' . __('messages.welcome_title'))

@section('content')
@if(empty($diapositivas))
    <h1 class="sr-only">{{ __('messages.hero_title') }}</h1>
@else
    <section data-carrusel aria-roledescription="carousel" aria-label="{{ __('messages.carousel_label') }}"
             class="relative -mt-2 overflow-hidden rounded-md bg-[#161615] text-white">
        <div class="grid">
            @foreach($diapositivas as $diapositiva)
                @php $juego = $diapositiva['juego']; @endphp
                <div data-diapositiva role="group" aria-roledescription="slide"
                     aria-label="{{ __('messages.slide_position', ['actual' => $loop->iteration, 'total' => $loop->count]) }}"
                     @unless($loop->first) inert aria-hidden="true" @endunless
                     class="relative [grid-area:1/1] transition-opacity duration-700 ease-console {{ $loop->first ? '' : 'pointer-events-none opacity-0' }}">
                    <img src="{{ $juego->fondo_url }}" alt="" @if($loop->first) fetchpriority="high" @else loading="lazy" @endif
                         class="absolute inset-0 size-full object-cover object-[70%_center]">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/60 to-black/10" aria-hidden="true"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent" aria-hidden="true"></div>

                    <div class="relative grid min-h-[480px] items-end gap-10 px-6 pb-20 pt-20 sm:min-h-[540px] sm:px-10 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center lg:pb-16">
                        <div class="max-w-2xl">
                            <p class="gv-label text-white/70">{{ $diapositiva['etiqueta'] }}</p>
                            @if($loop->first)
                                <h1 class="mt-4 text-4xl font-semibold leading-[1.05] tracking-[-0.035em] text-balance sm:text-6xl">{{ $diapositiva['titulo'] }}</h1>
                            @else
                                <h2 class="mt-4 text-4xl font-semibold leading-[1.05] tracking-[-0.035em] text-balance sm:text-6xl">{{ $diapositiva['titulo'] }}</h2>
                            @endif
                            <p class="mt-4 max-w-xl text-base leading-relaxed text-white/75 sm:text-lg">{{ $diapositiva['texto'] }}</p>
                            <div class="mt-8 flex flex-wrap gap-3">
                                <a href="{{ $diapositiva['enlace'] }}" class="inline-flex h-12 items-center gap-2 rounded-md bg-white px-6 text-[15px] font-medium text-[#161615] transition-[opacity,transform] duration-200 ease-console hover:opacity-90 active:scale-[0.98]">
                                    {{ $diapositiva['accion'] }}
                                    <x-icon name="arrow-right" class="size-4" />
                                </a>
                                @if($loop->first)
                                    <a href="{{ route('juegos-gratis.index') }}" class="inline-flex h-12 items-center rounded-md border border-white/35 px-6 text-[15px] font-medium text-white transition-colors duration-200 ease-console hover:border-white hover:bg-white/10">
                                        {{ __('messages.juegos_gratis') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Caratula completa del juego, en marco doble, para que el logo nunca quede recortado. --}}
                        <a href="{{ route('videojuegos.show', $juego) }}" tabindex="-1"
                           class="hidden w-48 rounded-md bg-white/5 p-1.5 ring-1 ring-white/15 transition-transform duration-500 ease-console hover:-translate-y-1 lg:block xl:w-56">
                            <x-cover :src="$juego->imagen_url" :alt="$juego->titulo" :eager="$loop->first" class="aspect-[2/3] rounded-[4px]" />
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        @if(count($diapositivas) > 1)
            <div class="absolute inset-x-0 bottom-0 flex items-center justify-between gap-3 px-5 pb-4 sm:px-10">
                <div class="flex items-center gap-1">
                    @foreach($diapositivas as $diapositiva)
                        <button type="button" data-ir="{{ $loop->index }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"
                                aria-label="{{ __('messages.slide_go_to', ['numero' => $loop->iteration]) }}"
                                class="group py-3 pr-1">
                            <span class="block h-0.5 w-4 rounded-full sm:w-6 bg-white/35 transition-all duration-500 ease-console group-hover:bg-white/70 group-aria-[current=true]:w-8 sm:group-aria-[current=true]:w-12 group-aria-[current=true]:bg-white"></span>
                        </button>
                    @endforeach
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" data-pausa aria-pressed="false"
                            data-texto-pausar="{{ __('messages.slideshow_pause') }}" data-texto-reproducir="{{ __('messages.slideshow_play') }}"
                            class="gv-label rounded-sm sm:mr-2 px-1 py-2 text-white/70 transition-colors hover:text-white">{{ __('messages.slideshow_pause') }}</button>
                    <button type="button" data-anterior aria-label="{{ __('messages.slide_previous') }}"
                            class="flex size-9 items-center justify-center rounded-full sm:size-10 border border-white/30 transition-colors duration-200 ease-console hover:border-white hover:bg-white/10">
                        <x-icon name="caret-left" class="size-4" />
                    </button>
                    <button type="button" data-siguiente aria-label="{{ __('messages.slide_next') }}"
                            class="flex size-9 items-center justify-center rounded-full sm:size-10 border border-white/30 transition-colors duration-200 ease-console hover:border-white hover:bg-white/10">
                        <x-icon name="caret-right" class="size-4" />
                    </button>
                </div>
            </div>
        @endif
    </section>
@endif

<section class="mt-20" aria-labelledby="destacados">
    <div class="mb-8 flex flex-wrap items-end justify-between gap-6 border-b border-line pb-6">
        <div class="flex items-end gap-5">
            <p class="font-mono text-6xl font-medium leading-none tracking-[-0.04em] tabular-nums text-ink sm:text-7xl">{{ $totalJuegos }}</p>
            <div class="pb-1">
                <p class="text-sm text-muted">{{ __('messages.titles_in_vault') }}</p>
                <h2 id="destacados" class="text-2xl font-semibold tracking-[-0.02em]">{{ __('messages.featured') }}</h2>
            </div>
        </div>
        <a href="{{ route('videojuegos.index') }}" class="group inline-flex items-center gap-1.5 text-sm font-medium text-ink underline decoration-line-strong underline-offset-4 hover:decoration-ink">
            {{ __('messages.see_all') }}
            <x-icon name="arrow-right" class="size-4 transition-transform duration-200 ease-console group-hover:translate-x-0.5" />
        </a>
    </div>

    @if($destacados->isEmpty())
        <x-empty-state icon="game-controller" :title="__('messages.no_results')">
            <x-button :href="route('videojuegos.index')" variant="secondary">{{ __('messages.catalog') }}</x-button>
        </x-empty-state>
    @else
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
            @foreach($destacados as $videojuego)
                <x-game-tile :videojuego="$videojuego" class="{{ match ($loop->iteration) { 4 => 'sm:hidden lg:flex', 5 => 'hidden lg:flex', default => '' } }}" />
            @endforeach
        </div>
    @endif
</section>

<script>
    // Carrusel: avanza solo cada 7 s, se pausa con el mouse, el foco o el boton Pausar, y respeta "reducir movimiento".
    document.querySelectorAll('[data-carrusel]').forEach((carrusel) => {
        const diapositivas = [...carrusel.querySelectorAll('[data-diapositiva]')];
        const puntos = [...carrusel.querySelectorAll('[data-ir]')];
        const pausa = carrusel.querySelector('[data-pausa]');
        if (diapositivas.length < 2) return;

        let actual = 0;
        let temporizador = null;
        let pausadoPorUsuario = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        const mostrar = (indice) => {
            actual = (indice + diapositivas.length) % diapositivas.length;
            diapositivas.forEach((diapositiva, i) => {
                const visible = i === actual;
                diapositiva.classList.toggle('opacity-0', !visible);
                diapositiva.classList.toggle('pointer-events-none', !visible);
                diapositiva.inert = !visible;
                diapositiva.setAttribute('aria-hidden', String(!visible));
            });
            puntos.forEach((punto, i) => punto.setAttribute('aria-current', String(i === actual)));
        };
        const detener = () => clearInterval(temporizador);
        const iniciar = () => {
            detener();
            if (!pausadoPorUsuario) temporizador = setInterval(() => mostrar(actual + 1), 7000);
        };
        const ir = (indice) => { mostrar(indice); iniciar(); };
        const actualizarPausa = () => {
            pausa.setAttribute('aria-pressed', String(pausadoPorUsuario));
            pausa.textContent = pausadoPorUsuario ? pausa.dataset.textoReproducir : pausa.dataset.textoPausar;
        };

        carrusel.querySelector('[data-anterior]').addEventListener('click', () => ir(actual - 1));
        carrusel.querySelector('[data-siguiente]').addEventListener('click', () => ir(actual + 1));
        puntos.forEach((punto) => punto.addEventListener('click', () => ir(Number(punto.dataset.ir))));
        pausa.addEventListener('click', () => { pausadoPorUsuario = !pausadoPorUsuario; actualizarPausa(); iniciar(); });

        carrusel.addEventListener('mouseenter', detener);
        carrusel.addEventListener('mouseleave', iniciar);
        carrusel.addEventListener('focusin', detener);
        carrusel.addEventListener('focusout', (evento) => { if (!carrusel.contains(evento.relatedTarget)) iniciar(); });
        carrusel.addEventListener('keydown', (evento) => {
            if (evento.key === 'ArrowLeft') ir(actual - 1);
            if (evento.key === 'ArrowRight') ir(actual + 1);
        });

        let inicioX = null;
        carrusel.addEventListener('pointerdown', (evento) => { inicioX = evento.clientX; });
        carrusel.addEventListener('pointerup', (evento) => {
            const distancia = inicioX === null ? 0 : evento.clientX - inicioX;
            inicioX = null;
            if (Math.abs(distancia) > 50) ir(distancia < 0 ? actual + 1 : actual - 1);
        });

        actualizarPausa();
        iniciar();
    });
</script>
@endsection
