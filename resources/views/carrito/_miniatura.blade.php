@if($item['tipo'] === 'tarjeta')
    <x-gift-card :imagen="$item['imagen']" :plataforma="$item['plataforma']" :precio="$item['precio']" :alt="$item['nombre']" class="w-28 sm:w-32" />
@elseif($item['tipo'] === 'dlc')
    <x-cover :src="$item['imagen']" :alt="$item['nombre']" class="aspect-[460/215] w-28 rounded-md sm:w-32" />
@else
    <x-cover :src="$item['imagen']" :alt="$item['nombre']" class="aspect-[2/3] w-16 rounded-md sm:w-20" />
@endif
