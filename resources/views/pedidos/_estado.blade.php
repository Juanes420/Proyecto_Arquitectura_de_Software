{{-- Autor: Juan David Bedoya --}}
{{-- Etiqueta de color para el estado del pedido. Espera la variable $estado. --}}
@php
    $colores = [
        'pendiente' => 'bg-yellow-100 text-yellow-800',
        'procesando' => 'bg-blue-100 text-blue-800',
        'completado' => 'bg-green-100 text-green-800',
        'cancelado' => 'bg-red-100 text-red-800',
    ];
@endphp
<span class="text-xs px-2 py-1 rounded {{ $colores[$estado] ?? 'bg-gray-100 text-gray-800' }}">
    {{ __('messages.estado_' . $estado) }}
</span>
