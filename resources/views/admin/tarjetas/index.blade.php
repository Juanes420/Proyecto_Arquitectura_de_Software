{{-- Autor: Juanes Peña --}}
@extends('layouts.admin')

@section('header', __('messages.manage_tarjetas'))

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.tarjetas.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        + {{ __('messages.create') }} {{ __('messages.tarjeta') }}
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.nombre') }}</th>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.plataforma') }}</th>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.precio') }}</th>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.stock') }}</th>
                <th class="px-6 py-3 text-gray-600 font-medium">{{ __('messages.actions') }}</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse($tarjetas as $tarjeta)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">
                        {{ $tarjeta->nombre }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $tarjeta->plataforma }}
                    </td>

                    <td class="px-6 py-4">
                        ${{ number_format($tarjeta->precio, 2) }}
                    </td>

                    <td class="px-6 py-4">
                        <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-sm">
                            {{ $tarjeta->stock }}
                        </span>
                    </td>

                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('admin.tarjetas.show', $tarjeta) }}"
                           class="text-blue-600 hover:underline">
                            {{ __('messages.view') }}
                        </a>

                        <a href="{{ route('admin.tarjetas.edit', $tarjeta) }}"
                           class="text-yellow-600 hover:underline">
                            {{ __('messages.edit') }}
                        </a>

                        <form action="{{ route('admin.tarjetas.destroy', $tarjeta) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                            @csrf
                            @method('DELETE')

                            <button class="text-red-600 hover:underline">
                                {{ __('messages.delete') }}
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        {{ __('messages.no_results') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $tarjetas->links() }}
</div>
@endsection