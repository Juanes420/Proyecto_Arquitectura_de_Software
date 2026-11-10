@props(['icon' => 'package', 'title', 'text' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center rounded-md border border-dashed border-line-strong px-6 py-16 text-center']) }}>
    <x-icon :name="$icon" class="size-10 text-muted" />
    <p class="mt-4 text-base font-medium text-ink">{{ $title }}</p>
    @if($text)
        <p class="mt-1 max-w-sm text-sm leading-relaxed text-muted">{{ $text }}</p>
    @endif
    @if($slot->isNotEmpty())
        <div class="mt-6">{{ $slot }}</div>
    @endif
</div>
