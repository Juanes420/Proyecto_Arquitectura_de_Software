{{-- Autor: Juanes Peña --}}
{{-- Partial reutilizable para create y edit (DRY) --}}
<div class="flex flex-col gap-6">
    <p class="text-xs text-muted">{{ __('messages.required_fields') }}</p>

    <div class="grid gap-6 sm:grid-cols-2">
        <x-input :label="__('messages.nombre')" name="nombre" :value="$tarjeta->nombre ?? null" required maxlength="255" />
        <x-input :label="__('messages.plataforma')" name="plataforma" :value="$tarjeta->plataforma ?? null" required maxlength="100" />
        <x-input :label="__('messages.precio')" name="precio" type="number" step="0.01" min="0" inputmode="decimal" :value="$tarjeta->precio ?? null" required />
        <x-input :label="__('messages.stock')" name="stock" type="number" min="0" inputmode="numeric" :value="$tarjeta->stock ?? 0" required />
    </div>

    <x-textarea :label="__('messages.descripcion')" name="descripcion" :value="$tarjeta->descripcion ?? null" maxlength="1000" />

    <x-input :label="__('messages.imagen')" name="imagen" :value="$tarjeta->imagen ?? null" :hint="__('messages.imagen_url_hint')"
             maxlength="500" inputmode="url" autocomplete="off" />
</div>
