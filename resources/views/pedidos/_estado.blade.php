{{-- Autor: Juan David Bedoya --}}
{{-- Etiqueta del estado del pedido. Espera la variable $estado. --}}
<x-badge :color="['pendiente' => 'warning', 'procesando' => 'neutral', 'completado' => 'success', 'cancelado' => 'danger'][$estado] ?? 'neutral'">
    {{ __('messages.estado_' . $estado) }}
</x-badge>
