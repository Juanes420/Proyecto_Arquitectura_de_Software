@extends('layouts.app')

@section('title', $videojuego->titulo . ' - GameVault')

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('videojuegos.index') }}" class="text-indigo-600 hover:underline mb-4 inline-block">← {{ __('messages.back') }}</a>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="md:flex gap-6">
            <div class="w-full md:w-1/3 h-64 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center text-white text-6xl mb-4 md:mb-0">
                🎮
            </div>
            <div class="flex-1">
                <h1 class="text-3xl font-bold">{{ $videojuego->titulo }}</h1>
                <p class="text-gray-500 mt-1">{{ $videojuego->plataforma }} · {{ $videojuego->categoria->nombre }}</p>

                <div class="mt-4 flex items-center gap-4">
                    <span class="text-3xl font-bold text-green-600">${{ number_format($videojuego->precio, 2) }}</span>
                    @if($videojuego->stock > 0)
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded">{{ $videojuego->stock }} en stock</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded">Agotado</span>
                    @endif
                </div>

                @if($videojuego->promedio_calificacion)
                    <p class="mt-2 text-yellow-500 text-lg">⭐ {{ $videojuego->promedio_calificacion }}/5 ({{ $videojuego->resenas->count() }} {{ __('messages.resenas') }})</p>
                @endif

                @if($videojuego->descripcion)
                    <p class="mt-4 text-gray-700">{{ $videojuego->descripcion }}</p>
                @endif

                {{-- Wishlist (Peña) --}}
                <div class="mt-4">
                    @include('wishlist._boton', ['videojuego' => $videojuego])
                </div>
            </div>
        </div>
    </div>

    {{-- Requisitos PC --}}
    @if($videojuego->requisitosMinimosPC)
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h2 class="text-xl font-bold mb-4">{{ __('messages.requisitos') }}</h2>
            <div class="grid grid-cols-2 gap-3 text-sm">
                @php $req = $videojuego->requisitosMinimosPC; @endphp
                <div><span class="text-gray-500">SO:</span> {{ $req->sistema_operativo }}</div>
                <div><span class="text-gray-500">CPU:</span> {{ $req->procesador }}</div>
                <div><span class="text-gray-500">RAM:</span> {{ $req->memoria_ram }}</div>
                <div><span class="text-gray-500">GPU:</span> {{ $req->tarjeta_grafica }}</div>
                <div><span class="text-gray-500">Almacenamiento:</span> {{ $req->almacenamiento }}</div>
                @if($req->directx)
                    <div><span class="text-gray-500">DirectX:</span> {{ $req->directx }}</div>
                @endif
            </div>
        </div>
    @endif

    {{-- DLCs --}}
    @if($videojuego->dlcs->count())
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h2 class="text-xl font-bold mb-4">{{ __('messages.dlcs') }}</h2>
            @foreach($videojuego->dlcs as $dlc)
                <div class="flex justify-between items-center border-b last:border-0 py-3">
                    <div>
                        <p class="font-medium">{{ $dlc->nombre }}</p>
                        @if($dlc->descripcion)
                            <p class="text-gray-500 text-sm">{{ $dlc->descripcion }}</p>
                        @endif
                    </div>
                    <span class="text-green-600 font-bold">${{ number_format($dlc->precio, 2) }}</span>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Reseñas --}}
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <h2 class="text-xl font-bold mb-4">{{ __('messages.resenas') }}</h2>

        @auth
            @php
                $miResena = $videojuego->resenas->where('usuario_id', auth()->id())->first();
            @endphp

            @if(!$miResena)
                <form action="{{ route('resenas.store', $videojuego) }}" method="POST" class="bg-gray-50 rounded p-4 mb-6">
                    @csrf
                    <h3 class="font-medium mb-3">{{ __('messages.write_review') }}</h3>
                    <div class="mb-3">
                        <label class="block text-sm text-gray-600 mb-1">{{ __('messages.calificacion') }} *</label>
                        <select name="calificacion" required class="border rounded px-3 py-2">
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}">{{ str_repeat('⭐', $i) }} ({{ $i }})</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm text-gray-600 mb-1">{{ __('messages.comentario') }}</label>
                        <textarea name="comentario" rows="3" maxlength="1000" class="w-full border rounded px-3 py-2"></textarea>
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">{{ __('messages.save') }}</button>
                </form>
            @endif
        @endauth

        @forelse($videojuego->resenas as $resena)
            <div class="border-b last:border-0 py-4">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="font-medium">{{ $resena->usuario->nombre }}</span>
                        <span class="text-yellow-500 ml-2">{{ str_repeat('⭐', $resena->calificacion) }}</span>
                    </div>
                    <span class="text-gray-400 text-sm">{{ $resena->created_at->diffForHumans() }}</span>
                </div>
                @if($resena->comentario)
                    <p class="text-gray-600 mt-1">{{ $resena->comentario }}</p>
                @endif

                @auth
                    @if($resena->usuario_id === auth()->id())
                        <form action="{{ route('resenas.destroy', $resena) }}" method="POST" class="mt-2 inline"
                              onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 text-sm hover:underline">{{ __('messages.delete') }}</button>
                        </form>
                    @endif
                @endauth
            </div>
        @empty
            <p class="text-gray-500">{{ __('messages.no_results') }}</p>
        @endforelse
    </div>
</div>
@endsection
