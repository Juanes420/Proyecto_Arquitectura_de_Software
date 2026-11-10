{{-- Acciones de una fila del panel: ver, editar y eliminar con confirmacion. --}}
@props(['show' => null, 'edit', 'destroy', 'nombre'])

@php $clase = 'flex size-8 cursor-pointer items-center justify-center rounded-md text-muted transition-colors duration-200 ease-console hover:bg-subtle'; @endphp

<div class="flex items-center justify-end gap-1">
    @if($show)
        <a href="{{ $show }}" class="{{ $clase }} hover:text-ink" title="{{ __('messages.view') }}" aria-label="{{ __('messages.view') }}: {{ $nombre }}">
            <x-icon name="eye" class="size-[18px]" />
        </a>
    @endif
    <a href="{{ $edit }}" class="{{ $clase }} hover:text-ink" title="{{ __('messages.edit') }}" aria-label="{{ __('messages.edit') }}: {{ $nombre }}">
        <x-icon name="pencil-simple" class="size-[18px]" />
    </a>
    <form action="{{ $destroy }}" method="POST" onsubmit="return confirm(@js(__('messages.confirm_delete')))">
        @csrf @method('DELETE')
        <button type="submit" class="{{ $clase }} hover:text-danger" title="{{ __('messages.delete') }}" aria-label="{{ __('messages.delete') }}: {{ $nombre }}">
            <x-icon name="trash" class="size-[18px]" />
        </button>
    </form>
</div>
