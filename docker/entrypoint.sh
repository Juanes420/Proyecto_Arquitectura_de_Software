#!/bin/sh
set -e

echo "==> GameVault: iniciando contenedor"

if [ -z "$APP_KEY" ]; then
    echo "==> APP_KEY no definida, generando una temporal (definela en Railway para que no cambie en cada deploy)"
    export APP_KEY="$(php artisan key:generate --show)"
fi

php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan migrate --force

USUARIOS="$(php artisan tinker --execute='echo \App\Models\User::count();' 2>/dev/null | tail -n 1)"
if [ "$USUARIOS" = "0" ]; then
    echo "==> Base de datos vacia, cargando datos de prueba"
    php artisan db:seed --force || echo "==> El seed fallo, la app sigue arrancando"
fi

php artisan storage:link --force 2>/dev/null || true
php artisan juegos:importar-steam || echo "==> No se pudieron importar los juegos de Steam"
# En segundo plano: consulta muchas fichas de Steam y no debe retrasar el arranque del servidor.
(php artisan dlcs:importar-steam || echo "==> No se pudieron importar los DLC de Steam"; php artisan requisitos:importar-steam || echo "==> No se pudieron importar los requisitos de Steam") &

chown -R www-data:www-data storage bootstrap/cache

echo "==> GameVault listo"

exec "$@"
