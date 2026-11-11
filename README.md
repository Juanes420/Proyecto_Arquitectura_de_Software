# GameVault

Tienda virtual de videojuegos, DLC y tarjetas de regalo. Proyecto de Arquitectura de Software (EAFIT).

- **App en producción:** https://proyecto-arquitectura-de-software.onrender.com
- **API pública:** https://proyecto-arquitectura-de-software.onrender.com/api/videojuegos

## Stack

- **Backend:** Laravel 12 / PHP 8.2+
- **Base de datos:** MySQL (TiDB Cloud en producción)
- **Frontend:** Blade + Tailwind CSS 4 (vía Vite)
- **Despliegue:** Render con Docker

## Nuestra API: `/api/videojuegos`

Expone los videojuegos con stock disponible, ordenados por título. Es la que consume el Equipo 2.

```http
GET /api/videojuegos
Accept: application/json
```

Ejemplo de respuesta:

```json
{
  "data": [
    {
      "id": 9,
      "titulo": "Baldur's Gate 3",
      "plataforma": "PC",
      "categoria": "Estrategia",
      "precio": 59.99,
      "stock": 171,
      "imagen": "https://shared.steamstatic.com/store_item_assets/steam/apps/1086940/library_600x900.jpg",
      "enlace": "https://proyecto-arquitectura-de-software.onrender.com/videojuegos/9"
    }
  ]
}
```

| Campo | Tipo | Descripción |
|---|---|---|
| `id` | entero | Identificador del videojuego |
| `titulo` | texto | Nombre del juego |
| `plataforma` | texto | Plataforma (PC, PlayStation, Xbox, …) |
| `categoria` | texto o `null` | Nombre de la categoría |
| `precio` | decimal | Precio en USD |
| `stock` | entero | Unidades disponibles |
| `imagen` | URL | Portada del juego |
| `enlace` | URL | Ficha del juego en GameVault |

Código: [routes/api.php](routes/api.php), [app/Http/Controllers/Api/VideoJuegoApiController.php](app/Http/Controllers/Api/VideoJuegoApiController.php) y [app/Http/Resources/VideoJuegoResource.php](app/Http/Resources/VideoJuegoResource.php).

## APIs que consumimos

| API | Para qué la usamos | Dónde está |
|---|---|---|
| [FreeToGame](https://www.freetogame.com/api-doc) | Sección `/juegos-gratis` con los juegos free-to-play más populares (en caché por 1 hora) | [app/Services/FreeToGameService.php](app/Services/FreeToGameService.php) |
| [Steam Store](https://store.steampowered.com) | Nombres, descripciones, precios, portadas, DLC y requisitos de PC de los juegos del catálogo | [app/Services/SteamService.php](app/Services/SteamService.php) y los comandos `juegos:importar-steam`, `dlcs:importar-steam` y `requisitos:importar-steam` |
| Tienda de muebles y decoración (equipo aliado) | Sección `/productos-aliados` | [app/Services/ProductosAliados/](app/Services/ProductosAliados/) |

## Inversión de dependencias

El controlador de productos aliados no depende de una clase concreta, sino de la interfaz [app/Contracts/ProductosAliadosService.php](app/Contracts/ProductosAliadosService.php):

```php
interface ProductosAliadosService
{
    public function obtener(): array;

    public function origen(): string;
}
```

Hay dos implementaciones:

- [ProductosAliadosApi](app/Services/ProductosAliados/ProductosAliadosApi.php): consume el servicio web de la tienda aliada.
- [ProductosAliadosLocal](app/Services/ProductosAliados/ProductosAliadosLocal.php): datos de respaldo cuando el servicio no está configurado.

El enlace se decide en [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php): si existe la variable `ALIADOS_API_URL` se inyecta `ProductosAliadosApi`; si no, `ProductosAliadosLocal`. Cambiar de proveedor no exige tocar el controlador ni la vista.

Los diagramas están en [docs/diagramas/](docs/diagramas/).

## Cómo correr el proyecto

```bash
# 1. Clonar e instalar dependencias
git clone https://github.com/Juanes420/Proyecto_Arquitectura_de_Software.git
cd Proyecto_Arquitectura_de_Software
composer install
npm install

# 2. Configurar entorno
cp .env.example .env
php artisan key:generate

# 3. Editar .env con credenciales MySQL
# DB_DATABASE=gamevault
# DB_USERNAME=root
# DB_PASSWORD=tu_password
# ALIADOS_API_URL=     (opcional: URL de la API de la tienda aliada)

# 4. Crear BD, migrar y cargar datos de prueba
mysql -u root -p -e "CREATE DATABASE gamevault;"
php artisan migrate
php artisan db:seed

# 5. (Opcional) Traer juegos, DLC y requisitos reales de Steam
php artisan juegos:importar-steam
php artisan dlcs:importar-steam
php artisan requisitos:importar-steam

# 6. Storage link
php artisan storage:link

# 7. Ejecutar
npm run dev        # en una terminal
php artisan serve  # en otra terminal
```

Visitar: http://localhost:8000

También se puede levantar todo con Docker (app + MySQL): `docker compose up --build` y visitar http://localhost:8080.

### Credenciales de prueba

- **Admin:** admin@gamevault.com / password
- **Clientes:** 10 generados automáticamente

## Tests

```bash
php artisan test
```

Usan SQLite en memoria (configurado en [phpunit.xml](phpunit.xml)), así que no tocan la base de datos local. Hay pruebas unitarias de los servicios (`CarritoService`, `PedidoService`, `SteamService`), de los scopes de `VideoJuego` y de `RequisitosMinimosPc`, y una prueba de integración del flujo de compra desde el carrito.

## Despliegue

La app corre en **Render** a partir del [Dockerfile](Dockerfile) del repositorio, y la base de datos es **TiDB Cloud** (compatible con MySQL).

1. El `Dockerfile` compila los assets con Node (Vite + Tailwind), instala las dependencias con Composer y arma la imagen final con PHP-FPM, Nginx y Supervisor, que escucha en el puerto `8080`.
2. Al arrancar, [docker/entrypoint.sh](docker/entrypoint.sh) cachea la configuración, corre las migraciones, carga los datos de prueba si la base está vacía e importa los juegos de Steam (los DLC y los requisitos se importan en segundo plano).
3. En Render el servicio es de tipo *Web Service* con entorno Docker, conectado a este repositorio.

Variables de entorno en Render:

| Variable | Valor |
|---|---|
| `APP_KEY` | Llave generada con `php artisan key:generate --show` |
| `APP_ENV` / `APP_DEBUG` | `production` / `false` |
| `APP_URL` | `https://proyecto-arquitectura-de-software.onrender.com` |
| `DB_CONNECTION` | `mysql` |
| `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | Datos de conexión del clúster de TiDB |
| `MYSQL_ATTR_SSL_CA` | Ruta del certificado CA, porque TiDB exige conexión TLS (por ejemplo `/etc/ssl/certs/ca-certificates.crt` en la imagen de Alpine) |
| `ALIADOS_API_URL` | URL de la API de la tienda aliada |

El archivo `.env` nunca se sube al repositorio.

## Equipo

| Integrante | Rol | Clases asignadas |
|---|---|---|
| Juan Esteban Peña | Arquitecto | Categoria, RequisitosMinimosPc, Wishlist |
| Juan José Acevedo | Desarrollador | VideoJuego, DLC, Reseña, Auth |
| Juan David Bedoya | Desarrollador | Pedido, DetallePedido, Tarjeta |
