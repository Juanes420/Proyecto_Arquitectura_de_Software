@props(['label', 'name', 'value' => null, 'hint' => null, 'required' => false])

@php
    $id = $attributes->get('id', $name);
    $conError = $errors->has($name);
    $describe = trim(($hint ? $id . '-ayuda ' : '') . ($conError ? $id . '-error' : ''));
@endphp

<x-field :label="$label" :for="$id" :name="$name" :hint="$hint" :required="$required" :class="$attributes->get('class')">
    <textarea id="{{ $id }}" name="{{ $name }}"
              @if($required) required @endif
              @if($conError) aria-invalid="true" @endif
              @if($describe) aria-describedby="{{ $describe }}" @endif
              {{ $attributes->except(['class', 'id'])->merge(['class' => 'gv-input', 'rows' => 4]) }}>{{ old($name, $value) }}</textarea>
</x-field>
