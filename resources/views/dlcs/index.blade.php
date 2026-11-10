@extends('layouts.app')

@section('title', __('messages.dlcs') . ' - GameVault')

@section('content')
<x-page-header :title="__('messages.dlcs')" :description="__('messages.dlcs_descripcion')" />

@if($dlcs->isEmpty())
    <x-empty-state icon="game-controller" :title="__('messages.sin_dlcs')" />
@else
    <ul class="grid gap-x-4 gap-y-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($dlcs as $dlc)
            <li>@include('dlcs._tarjeta', ['dlc' => $dlc, 'conJuego' => true])</li>
        @endforeach
    </ul>

    <div class="mt-10">{{ $dlcs->links() }}</div>
    <p class="mt-8 text-xs text-muted">{{ __('messages.datos_steam') }}</p>
@endif
@endsection
