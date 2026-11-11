@props(['items' => []])

{{-- Cada item es ['label' => texto, 'url' => enlace o null]; el ultimo es la pagina actual. --}}
@if(count($items) > 1)
    <nav aria-label="{{ __('messages.breadcrumbs') }}" {{ $attributes->merge(['class' => 'mb-4']) }}>
        <ol class="flex flex-wrap items-center gap-1.5 text-[13px] text-muted">
            @foreach($items as $item)
                <li class="flex min-w-0 items-center gap-1.5">
                    @if(! $loop->first)
                        <x-icon name="caret-right" class="size-3.5 shrink-0" />
                    @endif
                    @if($loop->last || empty($item['url']))
                        <span @if($loop->last) aria-current="page" @endif class="truncate text-ink">{{ $item['label'] }}</span>
                    @else
                        <a href="{{ $item['url'] }}" class="truncate transition-colors duration-200 ease-console hover:text-ink">{{ $item['label'] }}</a>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
