{{-- Autor: Juanes Peña --}}
{{-- Partial reutilizable para create y edit (DRY) --}}
<div class="flex flex-col gap-6">
    <p class="text-xs text-muted">{{ __('messages.required_fields') }}</p>

    <x-select :label="__('messages.videojuego')" name="videojuego_id" required>
        @forelse($videojuegos as $videojuego)
            <option value="{{ $videojuego->id }}" @selected(old('videojuego_id', $requisito->videojuego_id ?? '') == $videojuego->id)>{{ $videojuego->titulo }}</option>
        @empty
            <option value="">{{ __('messages.no_videojuegos_disponibles') }}</option>
        @endforelse
    </x-select>

    <div class="grid gap-6 sm:grid-cols-2">
        <x-input :label="__('messages.sistema_operativo')" name="sistema_operativo" :value="$requisito->sistema_operativo ?? null" :placeholder="__('messages.placeholder_so')" required />
        <x-input :label="__('messages.procesador')" name="procesador" :value="$requisito->procesador ?? null" :placeholder="__('messages.placeholder_cpu')" required />
        <x-input :label="__('messages.memoria_ram')" name="memoria_ram" :value="$requisito->memoria_ram ?? null" :placeholder="__('messages.placeholder_ram')" required />
        <x-input :label="__('messages.tarjeta_grafica')" name="tarjeta_grafica" :value="$requisito->tarjeta_grafica ?? null" :placeholder="__('messages.placeholder_gpu')" required />
        <x-input :label="__('messages.almacenamiento')" name="almacenamiento" :value="$requisito->almacenamiento ?? null" :placeholder="__('messages.placeholder_storage')" required />
        <x-input :label="__('messages.directx')" name="directx" :value="$requisito->directx ?? null" :placeholder="__('messages.directx_placeholder')" />
    </div>

    <div class="border-t border-line pt-6">
        <h2 class="gv-label text-muted">{{ __('messages.requisitos_recomendados') }}</h2>
        <p class="mt-1 text-xs text-muted">{{ __('messages.requisitos_recomendados_ayuda') }}</p>
        <div class="mt-5 grid gap-6 sm:grid-cols-2">
            @foreach(\App\Models\RequisitosMinimosPc::COMPONENTES as $componente)
                <x-input :label="__('messages.' . $componente)" :name="$componente . '_recomendado'" :value="$requisito->{$componente . '_recomendado'} ?? null" />
            @endforeach
        </div>
    </div>
</div>
