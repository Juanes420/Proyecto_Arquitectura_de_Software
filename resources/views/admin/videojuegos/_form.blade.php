{{-- Partial reutilizable para create y edit (DRY) --}}
<div class="mb-4">
    <label for="titulo" class="block text-gray-700 font-medium mb-1">{{ __('messages.titulo') }} *</label>
    <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $videojuego->titulo ?? '') }}" required
           class="w-full border rounded-lg px-3 py-2 @error('titulo') border-red-500 @enderror">
    @error('titulo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <label for="plataforma" class="block text-gray-700 font-medium mb-1">{{ __('messages.plataforma') }} *</label>
        <select name="plataforma" id="plataforma" required class="w-full border rounded-lg px-3 py-2">
            @foreach(['PC', 'PlayStation 5', 'PlayStation 4', 'Xbox Series X', 'Nintendo Switch'] as $plat)
                <option value="{{ $plat }}" {{ old('plataforma', $videojuego->plataforma ?? '') === $plat ? 'selected' : '' }}>{{ $plat }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="categoria_id" class="block text-gray-700 font-medium mb-1">{{ __('messages.categoria') }} *</label>
        <select name="categoria_id" id="categoria_id" required class="w-full border rounded-lg px-3 py-2">
            @foreach($categorias as $cat)
                <option value="{{ $cat->id }}" {{ old('categoria_id', $videojuego->categoria_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <label for="precio" class="block text-gray-700 font-medium mb-1">{{ __('messages.precio') }} *</label>
        <input type="number" name="precio" id="precio" step="0.01" min="0" value="{{ old('precio', $videojuego->precio ?? '') }}" required
               class="w-full border rounded-lg px-3 py-2 @error('precio') border-red-500 @enderror">
        @error('precio') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="stock" class="block text-gray-700 font-medium mb-1">{{ __('messages.stock') }} *</label>
        <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', $videojuego->stock ?? 0) }}" required
               class="w-full border rounded-lg px-3 py-2 @error('stock') border-red-500 @enderror">
        @error('stock') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mb-4">
    <label for="descripcion" class="block text-gray-700 font-medium mb-1">{{ __('messages.descripcion') }}</label>
    <textarea name="descripcion" id="descripcion" rows="4"
              class="w-full border rounded-lg px-3 py-2">{{ old('descripcion', $videojuego->descripcion ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label for="imagen" class="block text-gray-700 font-medium mb-1">{{ __('messages.imagen') }}</label>
    <input type="file" name="imagen" id="imagen" accept="image/*" class="w-full">
    @error('imagen') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
</div>
