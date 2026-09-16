@extends('layouts.app')

@section('title', __('messages.catalog') . ' - GameVault')

@section('content')
<h2 class="text-2xl font-bold mb-6">{{ __('messages.catalog') }}</h2>

{{-- Filtros --}}
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form action="{{ route('videojuegos.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm text-gray-600 mb-1">{{ __('messages.search') }}</label>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="{{ __('messages.titulo') }}..."
                   class="border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">{{ __('messages.categoria') }}</label>
            <select name="categoria" class="border rounded px-3 py-2">
                <option value="">{{ __('messages.all') }}</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">{{ __('messages.plataforma') }}</label>
            <select name="plataforma" class="border rounded px-3 py-2">
                <option value="">{{ __('messages.all') }}</option>
                @foreach($plataformas as $plat)
                    <option value="{{ $plat }}" {{ request('plataforma') === $plat ? 'selected' : '' }}>{{ $plat }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">{{ __('messages.filter') }}</button>
    </form>
</div>

{{-- Grid de juegos --}}
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse($videojuegos as $vj)
        <a href="{{ route('videojuegos.show', $vj) }}" class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
            @if($vj->imagen)
                <img src="{{ asset('storage/' . $vj->imagen) }}" alt="{{ $vj->titulo }}" class="h-48 w-full object-cover">
            @else
                <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-4xl">
                    🎮
                </div>
            @endif
            <div class="p-4">
                <h3 class="font-bold text-lg">{{ $vj->titulo }}</h3>
                <p class="text-gray-500 text-sm">{{ $vj->plataforma }} · {{ $vj->categoria->nombre }}</p>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-xl font-bold text-green-600">${{ number_format($vj->precio, 2) }}</span>
                    @if($vj->stock > 0)
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">En stock</span>
                    @else
                        <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded">Agotado</span>
                    @endif
                </div>
            </div>
        </a>
    @empty
        <p class="col-span-4 text-center text-gray-500 py-8">{{ __('messages.no_results') }}</p>
    @endforelse
</div>

<div class="mt-6">
    {{ $videojuegos->withQueryString()->links() }}
</div>
@endsection
