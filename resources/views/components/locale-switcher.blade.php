<div role="group" aria-label="{{ __('messages.language') }}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-0.5 font-mono text-xs']) }}>
    @foreach(config('app.available_locales') as $idioma)
        <a href="{{ route('locale.update', $idioma) }}" hreflang="{{ $idioma }}" lang="{{ $idioma }}"
           @if(app()->getLocale() === $idioma) aria-current="true" @endif
           class="flex h-8 min-w-8 items-center justify-center rounded-sm px-1.5 uppercase transition-colors duration-200 ease-console {{ app()->getLocale() === $idioma ? 'bg-ink text-on-ink' : 'text-muted hover:text-ink' }}">
            {{ $idioma }}
        </a>
    @endforeach
</div>
