@php
    $filas = $requisitos->componentes();
    $conRecomendados = $requisitos->tieneRecomendados();
@endphp

<section class="mt-20" aria-labelledby="requisitos">
    <h2 id="requisitos" class="text-2xl font-semibold tracking-[-0.02em]">{{ __('messages.requisitos_titulo') }}</h2>

    <div class="mt-6 grid gap-8 lg:grid-cols-[minmax(0,1fr)_360px] lg:items-start">
        <div class="overflow-x-auto rounded-md border border-line bg-surface">
            <table class="gv-table">
                <thead>
                    <tr>
                        <th scope="col">{{ __('messages.componente') }}</th>
                        <th scope="col">{{ __('messages.requisitos_minimos') }}</th>
                        @if($conRecomendados)
                            <th scope="col">{{ __('messages.recomendados') }}</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($filas as $componente => $valores)
                        <tr>
                            <th scope="row" class="whitespace-nowrap text-left text-[13px] font-medium text-muted">{{ __('messages.' . $componente) }}</th>
                            <td class="min-w-48 text-[14px] leading-snug">{{ $valores['minimo'] ?: '-' }}</td>
                            @if($conRecomendados)
                                <td class="min-w-48 text-[14px] leading-snug">{{ $valores['recomendado'] ?: '-' }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @include('videojuegos._tu-equipo', ['datos' => $requisitos->datosComparacion()])
    </div>
</section>
