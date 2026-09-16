{{-- Autor: Juanes Peña --}}
{{-- Partial reutilizable para create y edit (DRY) --}}
<div class="mb-4">
    <label for="videojuego_id" class="block text-gray-700 font-medium mb-1">{{ __('messages.videojuego') }} *</label>
    <select name="videojuego_id" id="videojuego_id" required
            class="w-full border rounded-lg px-3 py-2 @error('videojuego_id') border-red-500 @enderror">
        @forelse($videojuegos as $videojuego)
            <option value="{{ $videojuego->id }}"
                {{ old('videojuego_id', $requisito->videojuego_id ?? '') == $videojuego->id ? 'selected' : '' }}>
                {{ $videojuego->titulo }}
            </option>
        @empty
            <option value="">{{ __('messages.no_videojuegos_disponibles') }}</option>
        @endforelse
    </select>
    @error('videojuego_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <label for="sistema_operativo" class="block text-gray-700 font-medium mb-1">{{ __('messages.sistema_operativo') }} *</label>
        <input type="text" name="sistema_operativo" id="sistema_operativo" required
               value="{{ old('sistema_operativo', $requisito->sistema_operativo ?? '') }}"
               placeholder="Windows 10 64-bit"
               class="w-full border rounded-lg px-3 py-2 @error('sistema_operativo') border-red-500 @enderror">
        @error('sistema_operativo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="procesador" class="block text-gray-700 font-medium mb-1">{{ __('messages.procesador') }} *</label>
        <input type="text" name="procesador" id="procesador" required
               value="{{ old('procesador', $requisito->procesador ?? '') }}"
               placeholder="Intel Core i5-8400"
               class="w-full border rounded-lg px-3 py-2 @error('procesador') border-red-500 @enderror">
        @error('procesador') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <label for="memoria_ram" class="block text-gray-700 font-medium mb-1">{{ __('messages.memoria_ram') }} *</label>
        <input type="text" name="memoria_ram" id="memoria_ram" required
               value="{{ old('memoria_ram', $requisito->memoria_ram ?? '') }}"
               placeholder="8 GB RAM"
               class="w-full border rounded-lg px-3 py-2 @error('memoria_ram') border-red-500 @enderror">
        @error('memoria_ram') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="tarjeta_grafica" class="block text-gray-700 font-medium mb-1">{{ __('messages.tarjeta_grafica') }} *</label>
        <input type="text" name="tarjeta_grafica" id="tarjeta_grafica" required
               value="{{ old('tarjeta_grafica', $requisito->tarjeta_grafica ?? '') }}"
               placeholder="NVIDIA GTX 1060 6GB"
               class="w-full border rounded-lg px-3 py-2 @error('tarjeta_grafica') border-red-500 @enderror">
        @error('tarjeta_grafica') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <label for="almacenamiento" class="block text-gray-700 font-medium mb-1">{{ __('messages.almacenamiento') }} *</label>
        <input type="text" name="almacenamiento" id="almacenamiento" required
               value="{{ old('almacenamiento', $requisito->almacenamiento ?? '') }}"
               placeholder="50 GB disponibles"
               class="w-full border rounded-lg px-3 py-2 @error('almacenamiento') border-red-500 @enderror">
        @error('almacenamiento') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="directx" class="block text-gray-700 font-medium mb-1">{{ __('messages.directx') }}</label>
        <input type="text" name="directx" id="directx"
               value="{{ old('directx', $requisito->directx ?? '') }}"
               placeholder="Versión 12"
               class="w-full border rounded-lg px-3 py-2 @error('directx') border-red-500 @enderror">
        @error('directx') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>
