@props(['value'])

<span {{ $attributes->merge(['class' => 'font-mono tabular-nums']) }}>${{ number_format((float) $value, 2) }}</span>
