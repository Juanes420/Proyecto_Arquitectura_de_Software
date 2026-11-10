{{-- Autor: Juanes Peña --}}
{{-- Botón agregar/quitar de la lista de deseos. Espera la variable $videojuego. --}}
@auth
    @if(auth()->user()->wishlists->contains('videojuego_id', $videojuego->id))
        <form action="{{ route('wishlist.destroy', $videojuego) }}" method="POST">
            @csrf @method('DELETE')
            <x-button variant="secondary" size="lg" icon="heart" aria-pressed="true">{{ __('messages.wishlist_remove') }}</x-button>
        </form>
    @else
        <form action="{{ route('wishlist.store', $videojuego) }}" method="POST">
            @csrf
            <x-button variant="secondary" size="lg" icon="heart">{{ __('messages.wishlist_add') }}</x-button>
        </form>
    @endif
@endauth
