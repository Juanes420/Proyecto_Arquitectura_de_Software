@props(['title', 'description' => null, 'back' => null])

<header {{ $attributes->merge(['class' => 'mb-8 flex flex-wrap items-end justify-between gap-x-6 gap-y-4 border-b border-line pb-6']) }}>
    <div class="min-w-0">
        @if($back)
            <a href="{{ $back }}" class="mb-4 inline-flex items-center gap-1.5 text-[13px] text-muted transition-colors duration-200 ease-console hover:text-ink">
                <x-icon name="arrow-left" class="size-4" />
                {{ __('messages.back') }}
            </a>
        @endif
        <h1 class="text-3xl font-semibold tracking-[-0.025em] text-ink text-balance sm:text-4xl">{{ $title }}</h1>
        @if($description)
            <p class="mt-2 max-w-[65ch] text-[15px] leading-relaxed text-muted">{{ $description }}</p>
        @endif
    </div>
    @isset($actions)
        <div class="flex flex-wrap items-center gap-2">{{ $actions }}</div>
    @endisset
</header>
