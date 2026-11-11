<?php

namespace App\Providers;

use App\Contracts\ProductosAliadosService;
use App\Services\CarritoService;
use App\Services\ProductosAliados\ProductosAliadosApi;
use App\Services\ProductosAliados\ProductosAliadosLocal;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductosAliadosService::class, function () {
            $url = config('services.aliados.url');

            return $url ? new ProductosAliadosApi($url) : new ProductosAliadosLocal;
        });
    }

    public function boot(): void
    {
        // Migas del admin: Resumen > Seccion; la pagina actual la agrega el layout con su encabezado.
        View::composer('layouts.admin', function ($view) {
            $ruta = explode('.', (string) request()->route()?->getName());
            $migas = [];

            if (count($ruta) === 3) {
                $migas[] = ['label' => __('messages.dashboard'), 'url' => route('admin.dashboard')];

                if ($ruta[2] !== 'index') {
                    $migas[] = ['label' => __('messages.' . $ruta[1]), 'url' => route("admin.{$ruta[1]}.index")];
                }
            }

            $view->with('migas', $migas);
        });

        View::composer('layouts.app', function ($view) {
            $view->with('wishlistCount', auth()->check() ? auth()->user()->wishlists()->count() : 0);
            $view->with('carritoCantidad', app(CarritoService::class)->cantidad());
        });
    }
}
