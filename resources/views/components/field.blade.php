{{-- Contenedor de campo: etiqueta arriba, control, ayuda y error debajo. --}}
@props(['label', 'for', 'name' => null, 'hint' => null, 'required' => false])

@php $name ??= $for; @endphp

<div {{ $attributes->merge(['class' => 'flex flex-col gap-2']) }}>
    <label for="{{ $for }}" class="text-[13px] font-medium text-ink">
        {{ $label }}
        @if($required)
            <span class="text-muted" aria-hidden="true">*</span>
        @endif
    </label>
    {{ $slot }}
    @if($hint)
        <p id="{{ $for }}-ayuda" class="text-xs leading-relaxed text-muted">{{ $hint }}</p>
    @endif
    @error($name)
        <p id="{{ $for }}-error" class="flex items-center gap-1.5 text-xs text-danger">
            <x-icon name="warning-circle" class="size-4" />
            {{ $message }}
        </p>
    @enderror
</div>
