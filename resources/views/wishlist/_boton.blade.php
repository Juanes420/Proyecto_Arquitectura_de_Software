{{-- Autor: Juanes Peña --}}
{{-- Botón agregar/quitar de la lista de deseos. Espera la variable $videojuego. --}}
@auth
    @php
        $enWishlist = auth()->user()->wishlists->contains('videojuego_id', $videojuego->id);
    @endphp

    @if($enWishlist)
        <form action="{{ route('wishlist.destroy', $videojuego) }}" method="POST" class="inline">
            @csrf @method('DELETE')
            <button class="bg-red-100 text-red-700 px-4 py-2 rounded hover:bg-red-200">
                💔 {{ __('messages.wishlist_remove') }}
            </button>
        </form>
    @else
        <form action="{{ route('wishlist.store', $videojuego) }}" method="POST" class="inline">
            @csrf
            <button class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">
                ❤️ {{ __('messages.wishlist_add') }}
            </button>
        </form>
    @endif
@endauth
