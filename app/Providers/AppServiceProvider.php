<?php

namespace App\Providers;

use App\Contracts\ProductosAliadosService;
use App\Services\ProductosAliados\ProductosAliadosApi;
use App\Services\ProductosAliados\ProductosAliadosLocal;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductosAliadosService::class, function () {
            $url = config('services.aliados.url');

            return $url ? new ProductosAliadosApi($url) : new ProductosAliadosLocal();
        });
    }

    public function boot(): void
    {
        //
    }
}
