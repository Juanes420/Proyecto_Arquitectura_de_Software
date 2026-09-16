{{-- Autor: Juanes Peña --}}
@extends('layouts.admin')

@section('header', __('messages.manage_requisitos'))

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.requisitos.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        + {{ __('messages.create') }} {{ __('messages.requisitos') }}
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.videojuego') }}</th>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.sistema_operativo') }}</th>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.procesador') }}</th>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.memoria_ram') }}</th>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($requisitos as $requisito)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">{{ $requisito->videojuego->titulo }}</td>
                    <td class="px-6 py-4">{{ $requisito->sistema_operativo }}</td>
                    <td class="px-6 py-4">{{ $requisito->procesador }}</td>
                    <td class="px-6 py-4">{{ $requisito->memoria_ram }}</td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('admin.requisitos.edit', $requisito) }}" class="text-yellow-600 hover:underline">{{ __('messages.edit') }}</a>
                        <form action="{{ route('admin.requisitos.destroy', $requisito) }}" method="POST" class="inline"
                              onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">{{ __('messages.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">{{ __('messages.no_results') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $requisitos->links() }}
</div>
@endsection
