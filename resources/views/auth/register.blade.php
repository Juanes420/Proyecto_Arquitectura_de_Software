@extends('layouts.app')

@section('title', __('auth.register') . ' - GameVault')

@section('content')
<div class="mx-auto w-full max-w-sm py-8 sm:py-12">
    <h1 class="text-3xl font-semibold tracking-[-0.025em]">{{ __('auth.register') }}</h1>
    <p class="mt-2 text-[15px] leading-relaxed text-muted">{{ __('messages.register_subtitle') }}</p>

    <form method="POST" action="{{ route('register') }}" class="mt-8 flex flex-col gap-5">
        @csrf
        <x-input :label="__('auth.name')" name="nombre" required autofocus autocomplete="name" />
        <x-input :label="__('auth.email')" name="email" type="email" required autocomplete="email" />
        <x-input :label="__('auth.password_label')" name="password" type="password" required autocomplete="new-password" />
        <x-input :label="__('auth.confirm_password')" name="password_confirmation" type="password" required autocomplete="new-password" />

        <x-button size="lg" class="w-full">{{ __('auth.register') }}</x-button>
    </form>

    <p class="mt-8 border-t border-line pt-6 text-sm text-muted">
        {{ __('auth.has_account') }}
        <a href="{{ route('login') }}" class="font-medium text-ink underline decoration-line-strong underline-offset-4 hover:decoration-ink">{{ __('auth.login') }}</a>
    </p>
</div>
@endsection
