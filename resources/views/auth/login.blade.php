@extends('layouts.app')

@section('title', __('auth.login') . ' - GameVault')

@section('content')
<div class="mx-auto w-full max-w-sm py-8 sm:py-12">
    <h1 class="text-3xl font-semibold tracking-[-0.025em]">{{ __('auth.login') }}</h1>
    <p class="mt-2 text-[15px] leading-relaxed text-muted">{{ __('messages.login_subtitle') }}</p>

    <form method="POST" action="{{ route('login') }}" class="mt-8 flex flex-col gap-5">
        @csrf
        <x-input :label="__('auth.email')" name="email" type="email" required autofocus autocomplete="email" />
        <x-input :label="__('auth.password_label')" name="password" type="password" required autocomplete="current-password" />

        <label for="remember" class="flex cursor-pointer items-center gap-2.5 text-sm text-muted">
            <input type="checkbox" name="remember" id="remember" @checked(old('remember')) class="size-4 rounded-sm accent-[var(--gv-ink)]">
            {{ __('auth.remember_me') }}
        </label>

        <x-button size="lg" class="w-full">{{ __('auth.login') }}</x-button>
    </form>

    <p class="mt-8 border-t border-line pt-6 text-sm text-muted">
        {{ __('auth.no_account') }}
        <a href="{{ route('register') }}" class="font-medium text-ink underline decoration-line-strong underline-offset-4 hover:decoration-ink">{{ __('auth.register') }}</a>
    </p>
</div>
@endsection
