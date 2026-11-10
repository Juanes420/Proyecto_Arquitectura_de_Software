<?php

namespace App\Services;

use App\Models\Dlc;
use App\Models\Tarjeta;
use App\Models\VideoJuego;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

// Carrito guardado en la sesion: ['videojuego' => [id => cantidad], 'tarjeta' => [...], 'dlc' => [...]].
class CarritoService
{
    public const TIPOS = [
        'videojuego' => VideoJuego::class,
        'tarjeta' => Tarjeta::class,
        'dlc' => Dlc::class,
    ];

    public const MAXIMO_POR_PRODUCTO = 10;

    private const CLAVE = 'carrito';

    public function agregar(string $tipo, int $id, int $cantidad = 1): void
    {
        $producto = $this->producto($tipo, $id);
        $maximo = $this->maximo($producto);

        if ($maximo === 0) {
            throw ValidationException::withMessages(['carrito' => __('messages.carrito_agotado', ['producto' => $this->nombre($producto)])]);
        }

        $carrito = $this->contenido();
        $carrito[$tipo][$id] = min(($carrito[$tipo][$id] ?? 0) + $cantidad, $maximo);
        $this->guardar($carrito);
    }

    public function actualizar(string $tipo, int $id, int $cantidad): void
    {
        if ($cantidad <= 0) {
            $this->quitar($tipo, $id);

            return;
        }

        $carrito = $this->contenido();

        if (! isset($carrito[$tipo][$id])) {
            return;
        }

        $carrito[$tipo][$id] = min($cantidad, $this->maximo($this->producto($tipo, $id)));
        $this->guardar($carrito);
    }

    public function quitar(string $tipo, int $id): void
    {
        $carrito = $this->contenido();
        unset($carrito[$tipo][$id]);
        $this->guardar($carrito);
    }

    public function vaciar(): void
    {
        session()->forget(self::CLAVE);
    }

    // Productos del carrito con sus datos actuales. Normaliza la sesion: quita los que ya no existen
    // y ajusta cada cantidad al maximo disponible, para que lo que se ve sea exactamente lo que se cobra.
    public function items(): Collection
    {
        $items = collect();
        $normalizado = [];

        foreach ($this->contenido() as $tipo => $cantidades) {
            $modelos = self::TIPOS[$tipo]::query()
                ->when($tipo === 'dlc', fn ($consulta) => $consulta->with('videojuego'))
                ->whereIn('id', array_keys($cantidades))
                ->get()
                ->keyBy('id');

            foreach ($cantidades as $id => $cantidad) {
                $producto = $modelos->get($id);

                if (! $producto) {
                    continue;
                }

                $maximo = $this->maximo($producto);
                $cantidad = min($cantidad, max($maximo, 1));
                $normalizado[$tipo][$id] = $cantidad;

                $items->push([
                    'tipo' => $tipo,
                    'id' => $producto->id,
                    'nombre' => $this->nombre($producto),
                    'detalle' => $this->detalle($producto),
                    'imagen' => $producto->imagen_url,
                    'plataforma' => $producto->plataforma ?? null,
                    'enlace' => $this->enlace($producto),
                    'precio' => (float) $producto->precio,
                    'cantidad' => $cantidad,
                    'maximo' => $maximo,
                    'agotado' => $maximo === 0,
                    'subtotal' => $maximo === 0 ? 0.0 : (float) $producto->precio * $cantidad,
                ]);
            }
        }

        $this->guardar($normalizado);

        return $items;
    }

    public function total(): float
    {
        return $this->items()->sum('subtotal');
    }

    public function cantidad(): int
    {
        return (int) collect($this->contenido())->flatten()->sum();
    }

    // Formato que recibe PedidoService::crear: [tipo => [id => cantidad]], armado desde los items normalizados.
    public function porTipo(): array
    {
        $porTipo = array_fill_keys(array_keys(self::TIPOS), []);

        foreach ($this->items() as $item) {
            $porTipo[$item['tipo']][$item['id']] = $item['cantidad'];
        }

        return $porTipo;
    }

    public function tieneAgotados(): bool
    {
        return $this->items()->contains('agotado', true);
    }

    private function contenido(): array
    {
        return array_filter(
            array_intersect_key(session(self::CLAVE, []), self::TIPOS),
            fn (array $cantidades) => $cantidades !== [],
        );
    }

    private function guardar(array $carrito): void
    {
        session([self::CLAVE => array_filter($carrito, fn (array $cantidades) => $cantidades !== [])]);
    }

    private function producto(string $tipo, int $id): Model
    {
        $clase = self::TIPOS[$tipo] ?? null;
        $producto = $clase ? $clase::find($id) : null;

        if (! $producto) {
            throw ValidationException::withMessages(['carrito' => __('messages.producto_no_existe')]);
        }

        return $producto;
    }

    // Los DLC son digitales y no tienen stock; el resto queda limitado por su inventario.
    private function maximo(Model $producto): int
    {
        return $producto instanceof Dlc
            ? self::MAXIMO_POR_PRODUCTO
            : min(self::MAXIMO_POR_PRODUCTO, max((int) $producto->stock, 0));
    }

    private function nombre(Model $producto): string
    {
        return $producto instanceof VideoJuego ? $producto->titulo : $producto->nombre;
    }

    private function detalle(Model $producto): string
    {
        return match (true) {
            $producto instanceof Dlc => __('messages.dlc_de', ['juego' => $producto->videojuego?->titulo]),
            $producto instanceof Tarjeta => __('messages.tarjeta_regalo') . ' · ' . $producto->plataforma,
            default => $producto->plataforma,
        };
    }

    private function enlace(Model $producto): string
    {
        return match (true) {
            $producto instanceof VideoJuego => route('videojuegos.show', $producto),
            $producto instanceof Dlc => route('videojuegos.show', $producto->videojuego_id),
            default => route('tarjetas.index'),
        };
    }
}
