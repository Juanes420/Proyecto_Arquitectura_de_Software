@extends('layouts.admin')

@section('header', __('messages.dashboard'))

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm uppercase">{{ __('messages.total_videojuegos') }}</h3>
        <p class="text-3xl font-bold text-indigo-600 mt-2">{{ \App\Models\VideoJuego::count() }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm uppercase">{{ __('messages.total_users') }}</h3>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ \App\Models\User::where('role', 'cliente')->count() }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm uppercase">{{ __('messages.total_pedidos') }}</h3>
        <p class="text-3xl font-bold text-orange-600 mt-2">{{ \App\Models\Pedido::count() }}</p>
    </div>
</div>
@endsection
