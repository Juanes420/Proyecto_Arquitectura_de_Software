{{-- Fila de producto del formulario de pedido. Espera: $campo, $id, $nombre, $detalle, $precio, $stock, $valor, $destacado. --}}
@php $clave = $campo . '.' . $id; @endphp

<li class="flex flex-wrap items-center justify-between gap-4 px-5 py-4 {{ $destacado ? 'bg-subtle' : '' }}">
    <div class="min-w-0">
        <p class="flex items-center gap-2 font-medium">
            {{ $nombre }}
            @if($destacado)
                <x-badge color="solid">{{ __('messages.selected') }}</x-badge>
            @endif
        </p>
        <p class="mt-0.5 text-[13px] text-muted">{{ $detalle }} · {{ $stock }} {{ __('messages.en_stock') }}</p>
        @error($clave)
            <p id="{{ $campo }}-{{ $id }}-error" class="mt-1 flex items-center gap-1.5 text-xs text-danger">
                <x-icon name="warning-circle" class="size-4" />{{ $message }}
            </p>
        @enderror
    </div>
    <div class="flex items-center gap-4">
        <x-price :value="$precio" class="text-[15px]" />
        <label class="sr-only" for="{{ $campo }}-{{ $id }}">{{ __('messages.cantidad') }}: {{ $nombre }}</label>
        <input type="number" id="{{ $campo }}-{{ $id }}" name="{{ $campo }}[{{ $id }}]" inputmode="numeric"
               value="{{ old($clave, $valor) }}" min="0" max="{{ min(10, $stock) }}"
               @error($clave) aria-invalid="true" aria-describedby="{{ $campo }}-{{ $id }}-error" @enderror
               class="gv-input w-20 text-center font-mono tabular-nums">
    </div>
</li>
