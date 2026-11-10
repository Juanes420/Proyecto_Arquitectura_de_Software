# Diagramas de GameVault (Entregable 2)

Las fuentes están en Mermaid (`.mmd`) y las imágenes se regeneran con:

```bash
npx -p @mermaid-js/mermaid-cli mmdc -i arquitectura.mmd -o arquitectura.png -b white --size 3000
npx -p @mermaid-js/mermaid-cli mmdc -i clases.mmd -o clases.png -b white --size 3000
```

## Arquitectura

![Arquitectura](arquitectura.png)

- **Servicio provisto:** el Equipo 2 (Tienda de Carnicería) consume `GET /api/videojuegos` (`Api/VideoJuegoApiController` + `VideoJuegoResource`).
- **Servicio consumido:** `/productos-aliados` lee la API de la Tienda de muebles y decoración configurada en `ALIADOS_API_URL`.
- **APIs de terceros:** `/juegos-gratis` consume la API pública de FreeToGame (`FreeToGameService`) y los comandos `juegos:importar-steam` y `dlcs:importar-steam`, que corren al desplegar (`docker/entrypoint.sh`), consumen la API de Steam (`SteamService`) para traer nombre, descripción, precio e imagen de juegos y DLC reales.
- **Carrito y pedidos:** `CarritoService` guarda el carrito en la sesión y ajusta cantidades al stock; `PedidoService` crea el pedido en una transacción con `lockForUpdate`. Los pedidos pueden llevar videojuegos, tarjetas de regalo y DLC.
- **PortadaService:** arma las diapositivas del carrusel de la página de inicio (`HomeController`) a partir de los videojuegos guardados.
- **Inversión de dependencias:** `ProductosAliadosController` depende de la interfaz `ProductosAliadosService`; `AppServiceProvider` inyecta `ProductosAliadosApi` si hay URL configurada o `ProductosAliadosLocal` si no.
- **Despliegue:** contenedor Docker en Render, base de datos TiDB Cloud (compatible con MySQL, conexión TLS) y un ping de cron-job.org para evitar que el plan gratuito se duerma.

## Clases

![Clases](clases.png)
