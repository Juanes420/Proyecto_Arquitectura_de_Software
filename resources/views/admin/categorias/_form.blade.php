{{-- Autor: Juanes Peña --}}
{{-- Partial reutilizable para create y edit (DRY) --}}
<div class="flex flex-col gap-6">
    <p class="text-xs text-muted">{{ __('messages.required_fields') }}</p>
    <x-input :label="__('messages.nombre')" name="nombre" :value="$categoria->nombre ?? null" required maxlength="255" />
    <x-textarea :label="__('messages.descripcion')" name="descripcion" :value="$categoria->descripcion ?? null" maxlength="1000" />
</div>
