{{-- Autor: Juanes Peña --}}
@extends('layouts.admin')

@section('header', __('messages.manage_categorias'))

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.categorias.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        + {{ __('messages.create') }} {{ __('messages.categoria') }}
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.nombre') }}</th>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.descripcion') }}</th>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.videojuegos') }}</th>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($categorias as $categoria)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">{{ $categoria->nombre }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ Str::limit($categoria->descripcion, 70) }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-sm">
                            {{ $categoria->videojuegos_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('admin.categorias.show', $categoria) }}" class="text-blue-600 hover:underline">{{ __('messages.view') }}</a>
                        <a href="{{ route('admin.categorias.edit', $categoria) }}" class="text-yellow-600 hover:underline">{{ __('messages.edit') }}</a>
                        <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST" class="inline"
                              onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">{{ __('messages.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">{{ __('messages.no_results') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $categorias->links() }}
</div>
@endsection
