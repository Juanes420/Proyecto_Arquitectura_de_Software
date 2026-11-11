@props(['items' => []])

{{-- Cada item es ['label' => texto, 'url' => enlace]; el contenido del componente es la pagina actual. --}}
@if(count($items) > 0)
    <nav aria-label="{{ __('messages.breadcrumbs') }}" {{ $attributes->merge(['class' => 'mb-4']) }}>
        <ol class="flex flex-wrap items-center gap-1.5 text-[13px] text-muted">
            @foreach($items as $item)
                <li class="flex min-w-0 items-center gap-1.5">
                    @if(! $loop->first)
                        <x-icon name="caret-right" class="size-3.5 shrink-0" />
                    @endif
                    <a href="{{ $item['url'] }}" class="truncate transition-colors duration-200 ease-console hover:text-ink">{{ $item['label'] }}</a>
                </li>
            @endforeach
            <li class="flex min-w-0 items-center gap-1.5">
                <x-icon name="caret-right" class="size-3.5 shrink-0" />
                <span aria-current="page" class="truncate text-ink">{{ $slot }}</span>
            </li>
        </ol>
    </nav>
@endif
