{{-- Partial reutilizable para create y edit (DRY) --}}
<div class="flex flex-col gap-6">
    <p class="text-xs text-muted">{{ __('messages.required_fields') }}</p>

    <x-input :label="__('messages.titulo')" name="titulo" :value="$videojuego->titulo ?? null" required maxlength="255" />

    <div class="grid gap-6 sm:grid-cols-2">
        <x-select :label="__('messages.plataforma')" name="plataforma" required>
            @foreach(['PC', 'PlayStation 5', 'PlayStation 4', 'Xbox Series X', 'Nintendo Switch'] as $plat)
                <option value="{{ $plat }}" @selected(old('plataforma', $videojuego->plataforma ?? '') === $plat)>{{ $plat }}</option>
            @endforeach
        </x-select>
        <x-select :label="__('messages.categoria')" name="categoria_id" required>
            @foreach($categorias as $cat)
                <option value="{{ $cat->id }}" @selected(old('categoria_id', $videojuego->categoria_id ?? '') == $cat->id)>{{ $cat->nombre }}</option>
            @endforeach
        </x-select>
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <x-input :label="__('messages.precio')" name="precio" type="number" step="0.01" min="0" inputmode="decimal" :value="$videojuego->precio ?? null" required />
        <x-input :label="__('messages.stock')" name="stock" type="number" min="0" inputmode="numeric" :value="$videojuego->stock ?? 0" required />
    </div>

    <x-textarea :label="__('messages.descripcion')" name="descripcion" :value="$videojuego->descripcion ?? null" />

    <x-input :label="__('messages.imagen')" name="imagen" type="file" accept="image/*" />
</div>
