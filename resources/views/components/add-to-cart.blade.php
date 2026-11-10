{{-- Formulario de un solo boton para agregar un producto al carrito o comprarlo de una. --}}
@props(['tipo', 'id', 'comprar' => false, 'variant' => null, 'size' => 'md', 'icon' => null])

<form action="{{ route($comprar ? 'carrito.comprar' : 'carrito.agregar') }}" method="POST" {{ $attributes->only('class') }}>
    @csrf
    <input type="hidden" name="tipo" value="{{ $tipo }}">
    <input type="hidden" name="id" value="{{ $id }}">
    <x-button :variant="$variant ?? ($comprar ? 'primary' : 'secondary')" :size="$size" :icon="$icon" {{ $attributes->except('class') }}>
        {{ $slot->isEmpty() ? __($comprar ? 'messages.comprar_ahora' : 'messages.agregar_carrito') : $slot }}
    </x-button>
</form>
