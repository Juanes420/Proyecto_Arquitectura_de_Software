{{-- Calificacion con estrellas de 0,5 a 5. Es un input range nativo: funciona con mouse, toque y flechas del teclado. --}}
@props(['name' => 'calificacion', 'value' => 5, 'label'])

@php $valor = (float) old($name, $value); @endphp

<div data-calificacion class="flex flex-col gap-2">
    <label for="{{ $name }}" class="text-sm font-medium text-ink">{{ $label }}</label>
    <div class="flex items-center gap-3">
        <div class="relative inline-flex rounded-sm has-[:focus-visible]:outline-2 has-[:focus-visible]:outline-offset-4 has-[:focus-visible]:outline-ink">
            <x-stars :value="$valor" size="size-8" data-estrellas aria-hidden="true" />
            <input type="range" id="{{ $name }}" name="{{ $name }}" min="0.5" max="5" step="0.5" value="{{ $valor }}"
                   aria-valuetext="{{ __('messages.rating_out_of', ['value' => \App\Models\Resena::formatear($valor)]) }}"
                   class="absolute inset-0 size-full cursor-pointer opacity-0">
        </div>
        <output for="{{ $name }}" data-texto class="font-mono text-sm tabular-nums text-muted">{{ __('messages.rating_out_of', ['value' => \App\Models\Resena::formatear($valor)]) }}</output>
    </div>
    <p class="text-xs text-muted">{{ __('messages.calificar_con_estrellas') }}</p>
    @error($name)
        <p class="text-sm text-danger">{{ $message }}</p>
    @enderror
</div>

@once
    <script>
        document.addEventListener('input', (evento) => {
            const campo = evento.target.closest('[data-calificacion] input[type="range"]');
            if (!campo) return;
            const contenedor = campo.closest('[data-calificacion]');
            const texto = @js(__('messages.rating_out_of', ['value' => ':v'])).replace(':v', Number(campo.value).toLocaleString(document.documentElement.lang));
            contenedor.querySelector('[data-estrellas] > span:last-child').style.width = (campo.value * 20) + '%';
            contenedor.querySelector('[data-texto]').textContent = texto;
            campo.setAttribute('aria-valuetext', texto);
        });
    </script>
@endonce
