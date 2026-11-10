@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-[13px] text-muted">
            {{ __('Showing') }}
            <span class="font-mono tabular-nums text-ink">{{ $paginator->firstItem() }}</span>
            {{ __('to') }}
            <span class="font-mono tabular-nums text-ink">{{ $paginator->lastItem() }}</span>
            {{ __('of') }}
            <span class="font-mono tabular-nums text-ink">{{ $paginator->total() }}</span>
            {{ __('results') }}
        </p>

        @php
            $base = 'flex size-9 items-center justify-center rounded-md font-mono text-[13px] tabular-nums transition-colors duration-200 ease-console';
        @endphp

        <ul class="flex items-center gap-1">
            <li>
                @if ($paginator->onFirstPage())
                    <span class="{{ $base }} text-muted/50" aria-disabled="true" aria-label="{{ __('Previous') }}">
                        <x-icon name="caret-left" class="size-4" />
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $base }} text-ink hover:bg-subtle" aria-label="{{ __('Previous') }}">
                        <x-icon name="caret-left" class="size-4" />
                    </a>
                @endif
            </li>

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="{{ $base }} text-muted" aria-disabled="true">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            @if ($page == $paginator->currentPage())
                                <span class="{{ $base }} bg-ink text-on-ink" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="{{ $base }} text-muted hover:bg-subtle hover:text-ink" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach

            <li>
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $base }} text-ink hover:bg-subtle" aria-label="{{ __('Next') }}">
                        <x-icon name="caret-right" class="size-4" />
                    </a>
                @else
                    <span class="{{ $base }} text-muted/50" aria-disabled="true" aria-label="{{ __('Next') }}">
                        <x-icon name="caret-right" class="size-4" />
                    </span>
                @endif
            </li>
        </ul>
    </nav>
@endif
