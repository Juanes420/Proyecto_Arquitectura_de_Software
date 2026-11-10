<?php

namespace App\Services;

use App\Models\Pedido;
use App\Models\Tarjeta;
use App\Models\VideoJuego;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PedidoService
{
    public function crear(int $usuarioId, array $cantVideojuegos, array $cantTarjetas): Pedido
    {
        $cantVideojuegos = $this->soloConCantidad($cantVideojuegos);
        $cantTarjetas = $this->soloConCantidad($cantTarjetas);

        if ($cantVideojuegos === [] && $cantTarjetas === []) {
            throw ValidationException::withMessages(['productos' => __('messages.pedido_vacio')]);
        }

        return DB::transaction(function () use ($usuarioId, $cantVideojuegos, $cantTarjetas) {
            $videojuegos = VideoJuego::whereIn('id', array_keys($cantVideojuegos))->lockForUpdate()->get()->keyBy('id');
            $tarjetas = Tarjeta::whereIn('id', array_keys($cantTarjetas))->lockForUpdate()->get()->keyBy('id');

            $lineas = [];

            foreach ($cantVideojuegos as $id => $cantidad) {
                $videojuego = $videojuegos->get($id);
                $this->verificarStock($videojuego, $cantidad, $videojuego?->titulo);
                $lineas[] = ['producto' => $videojuego, 'campo' => 'videojuego_id', 'cantidad' => $cantidad];
            }

            foreach ($cantTarjetas as $id => $cantidad) {
                $tarjeta = $tarjetas->get($id);
                $this->verificarStock($tarjeta, $cantidad, $tarjeta?->nombre);
                $lineas[] = ['producto' => $tarjeta, 'campo' => 'tarjeta_id', 'cantidad' => $cantidad];
            }

            $pedido = Pedido::create([
                'usuario_id' => $usuarioId,
                'fecha' => now(),
                'estado' => 'pendiente',
                'total' => 0,
            ]);

            $total = 0;

            foreach ($lineas as $linea) {
                $producto = $linea['producto'];

                $pedido->detalles()->create([
                    $linea['campo'] => $producto->id,
                    'cantidad' => $linea['cantidad'],
                    'precio_unit' => $producto->precio,
                ]);

                $producto->decrement('stock', $linea['cantidad']);
                $total += $producto->precio * $linea['cantidad'];
            }

            $pedido->update(['total' => $total]);

            return $pedido;
        });
    }

    public function cancelar(Pedido $pedido): bool
    {
        if ($pedido->estado !== 'pendiente') {
            return false;
        }

        DB::transaction(function () use ($pedido) {
            foreach ($pedido->detalles as $detalle) {
                $detalle->videojuego?->increment('stock', $detalle->cantidad);
                $detalle->tarjeta?->increment('stock', $detalle->cantidad);
            }

            $pedido->update(['estado' => 'cancelado']);
        });

        return true;
    }

    private function soloConCantidad(array $cantidades): array
    {
        return array_map('intval', array_filter($cantidades, fn ($cantidad) => (int) $cantidad > 0));
    }

    private function verificarStock(?Model $producto, int $cantidad, ?string $nombre): void
    {
        if (! $producto) {
            throw ValidationException::withMessages(['productos' => __('messages.producto_no_existe')]);
        }

        if ($producto->stock < $cantidad) {
            throw ValidationException::withMessages([
                'productos' => __('messages.stock_insuficiente', ['producto' => $nombre, 'stock' => $producto->stock]),
            ]);
        }
    }
}
