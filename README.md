# GameVault

Tienda virtual de videojuegos — Entregable #1 de Arquitectura de Software (EAFIT).

## Stack

- **Backend:** Laravel 12 / PHP 8.2+
- **Base de datos:** MySQL
- **Frontend:** Blade + Tailwind CSS 4 (via Vite)
- **Despliegue:** GCP

## Setup local

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

# 4. Crear BD y migrar
mysql -u root -p -e "CREATE DATABASE gamevault;"
php artisan migrate
php artisan db:seed

# 5. Storage link
php artisan storage:link

# 6. Ejecutar
npm run dev        # en una terminal
php artisan serve  # en otra terminal
```

Visitar: http://localhost:8000

### Credenciales de prueba

- **Admin:** admin@gamevault.com / password
- **Clientes:** 10 generados automáticamente

## Equipo

| Integrante | Rol | Clases asignadas |
|---|---|---|
| Juan Esteban Peña | Arquitecto | Categoria, RequisitosMinimosPc, Wishlist |
| Juan José Acevedo | Desarrollador | VideoJuego, DLC, Reseña, Auth |
| Juan David Bedoya | Desarrollador | Pedido, DetallePedido, Tarjeta |
