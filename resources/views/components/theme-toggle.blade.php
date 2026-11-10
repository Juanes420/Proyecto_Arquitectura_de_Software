{{-- Alterna entre tema claro y oscuro; el script vive en layouts/_assets para aplicarse antes de pintar. --}}
<button type="button" data-theme-toggle onclick="gvCambiarTema()" aria-pressed="false"
        title="{{ __('messages.cambiar_tema') }}" aria-label="{{ __('messages.tema_oscuro') }}"
        {{ $attributes->merge(['class' => 'flex size-9 cursor-pointer items-center justify-center rounded-md text-muted transition-colors duration-200 ease-console hover:bg-subtle hover:text-ink']) }}>
    <x-icon name="moon" class="gv-icono-claro size-5" />
    <x-icon name="sun" class="gv-icono-oscuro size-5" />
</button>
