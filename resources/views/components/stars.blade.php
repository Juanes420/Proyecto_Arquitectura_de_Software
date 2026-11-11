{{-- Cinco estrellas rellenas hasta el valor (admite medias), con el valor como texto para lectores de pantalla. --}}
@props(['value' => 0, 'size' => 'size-4'])

<span role="img" aria-label="{{ __('messages.rating_out_of', ['value' => \App\Models\Resena::formatear($value)]) }}" {{ $attributes->merge(['class' => 'relative inline-flex shrink-0']) }}>
    <span class="flex text-line-strong" aria-hidden="true">
        @for($i = 0; $i < 5; $i++)<x-icon name="star-fill" class="{{ $size }}" />@endfor
    </span>
    <span class="absolute inset-y-0 left-0 flex overflow-hidden text-ink" style="width: {{ min(max($value, 0), 5) * 20 }}%" aria-hidden="true">
        @for($i = 0; $i < 5; $i++)<x-icon name="star-fill" class="{{ $size }}" />@endfor
    </span>
</span>
