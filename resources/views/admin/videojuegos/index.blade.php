@extends('layouts.admin')

@section('header', __('messages.manage_videojuegos'))

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.videojuegos.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        + {{ __('messages.create') }} {{ __('messages.videojuego') }}
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.titulo') }}</th>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.plataforma') }}</th>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.categoria') }}</th>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.precio') }}</th>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.stock') }}</th>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($videojuegos as $vj)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">{{ $vj->titulo }}</td>
                    <td class="px-6 py-4">{{ $vj->plataforma }}</td>
                    <td class="px-6 py-4">{{ $vj->categoria->nombre }}</td>
                    <td class="px-6 py-4">${{ number_format($vj->precio, 2) }}</td>
                    <td class="px-6 py-4">{{ $vj->stock }}</td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('admin.videojuegos.show', $vj) }}" class="text-blue-600 hover:underline">Ver</a>
                        <a href="{{ route('admin.videojuegos.edit', $vj) }}" class="text-yellow-600 hover:underline">{{ __('messages.edit') }}</a>
                        <form action="{{ route('admin.videojuegos.destroy', $vj) }}" method="POST" class="inline"
                              onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">{{ __('messages.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">{{ __('messages.no_results') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $videojuegos->links() }}
</div>
@endsection
