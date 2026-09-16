{{-- Autor: Juanes Peña --}}
{{-- Partial reutilizable para create y edit (DRY) --}}
<div class="mb-4">
    <label for="nombre" class="block text-gray-700 font-medium mb-1">{{ __('messages.nombre') }} *</label>
    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $categoria->nombre ?? '') }}" required
           class="w-full border rounded-lg px-3 py-2 @error('nombre') border-red-500 @enderror">
    @error('nombre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label for="descripcion" class="block text-gray-700 font-medium mb-1">{{ __('messages.descripcion') }}</label>
    <textarea name="descripcion" id="descripcion" rows="4" maxlength="1000"
              class="w-full border rounded-lg px-3 py-2 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>
    @error('descripcion') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
</div>
