@props(['label', 'name', 'type' => 'text', 'value' => null, 'hint' => null, 'required' => false])

@php
    $id = $attributes->get('id', $name);
    $conError = $errors->has($name);
    $describe = trim(($hint ? $id . '-ayuda ' : '') . ($conError ? $id . '-error' : ''));
@endphp

<x-field :label="$label" :for="$id" :name="$name" :hint="$hint" :required="$required" :class="$attributes->get('class')">
    <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}"
           @unless(in_array($type, ['password', 'file'])) value="{{ old($name, $value) }}" @endunless
           @if($required) required @endif
           @if($conError) aria-invalid="true" @endif
           @if($describe) aria-describedby="{{ $describe }}" @endif
           {{ $attributes->except(['class', 'id'])->merge(['class' => 'gv-input']) }}>
</x-field>
