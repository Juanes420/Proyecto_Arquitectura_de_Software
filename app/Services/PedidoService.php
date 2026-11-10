<?php

namespace App\Services;

use App\Models\Dlc;
use App\Models\Pedido;
use App\Models\Tarjeta;
use App\Models\VideoJuego;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PedidoService
{
    // Tipos de producto que puede llevar un pedido: modelo, columna en detalle_pedidos y si controla stock.
    private const PRODUCTOS = [
        'videojuego' => [VideoJuego::class, 'videojuego_id', 'titulo', true],
        'tarjeta' => [Tarjeta::class, 'tarjeta_id', 'nombre', true],
        'dlc' => [Dlc::class, 'dlc_id', 'nombre', false],
    ];

    public function crear(int $usuarioId, array $cantVideojuegos, array $cantTarjetas, array $cantDlcs = []): Pedido
    {
        $cantidades = array_filter([
            'videojuego' => $this->soloConCantidad($cantVideojuegos),
            'tarjeta' => $this->soloConCantidad($cantTarjetas),
            'dlc' => $this->soloConCantidad($cantDlcs),
        ]);

        if ($cantidades === []) {
            throw ValidationException::withMessages(['productos' => __('messages.pedido_vacio')]);
        }

        return DB::transaction(function () use ($usuarioId, $cantidades) {
            $lineas = [];

            foreach ($cantidades as $tipo => $porId) {
                [$clase, $campo, $atributoNombre, $conStock] = self::PRODUCTOS[$tipo];
                $productos = $clase::whereIn('id', array_keys($porId))->lockForUpdate()->get()->keyBy('id');

                foreach ($porId as $id => $cantidad) {
                    $producto = $productos->get($id);
                    $this->verificar($producto, $cantidad, $producto?->{$atributoNombre}, $conStock);
                    $lineas[] = ['producto' => $producto, 'campo' => $campo, 'cantidad' => $cantidad, 'conStock' => $conStock];
                }
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

                if ($linea['conStock']) {
                    $producto->decrement('stock', $linea['cantidad']);
                }

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

    private function verificar(?Model $producto, int $cantidad, ?string $nombre, bool $conStock): void
    {
        if (! $producto) {
            throw ValidationException::withMessages(['productos' => __('messages.producto_no_existe')]);
        }

        if ($conStock && $producto->stock < $cantidad) {
            throw ValidationException::withMessages([
                'productos' => __('messages.stock_insuficiente', ['producto' => $nombre, 'stock' => $producto->stock]),
            ]);
        }
    }
}
