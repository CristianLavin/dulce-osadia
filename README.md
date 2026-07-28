 Dulce Osadia

Aplicación web para la gestión comercial y operativa de Dulce Osadía, una pyme chilena dedicada a la venta de chocolates artesanales.

El proyecto combina dos áreas de negocio en una sola plataforma:

- Canal e-commerce para clientes: catálogo, detalle de productos, carrito, checkout, pago en línea y consulta de compras.
- Canal interno de operación para administración: actualización de insumos, historial de movimientos y planificación de producción basada en recetas.

 Objetivo del proyecto

Este sistema busca centralizar en una misma aplicación:

- La exhibición y venta de productos artesanales.
- La autenticación y gestión básica de clientes.
- La confirmación de pagos mediante Transbank Webpay Plus.
- El control de stock de insumos y productos vendidos.
- La planificación de fabricación a partir de recetas e insumos disponibles.

 Arquitectura del proyecto

La solución está implementada como una aplicación web PHP renderizada del lado del servidor, con una arquitectura simple y directa basada en archivos.

 1. Arquitectura general

- Frontend tradicional: páginas HTML generadas desde PHP con estilos CSS y JavaScript ligero.
- Backend monolítico en PHP: la lógica de negocio, acceso a datos, sesiones y flujos HTTP viven en archivos PHP separados por responsabilidad.
- Base de datos principal en MySQL/MariaDB: usada para clientes, usuarios, productos, compras, detalle de compras, recetas e insumos.
- Integración de servicios externos:
  - Transbank Webpay Plus para pagos.
  - Brevo/SMTP con PHPMailer para correos transaccionales.
  - QuickChart para generar el QR del ticket de retiro en el correo.
  - Cloudinary para audios narrados de recetas/productos en el planificador.

 2. Estilo arquitectónico

Aunque no está organizado bajo un framework MVC formal, el proyecto sigue una separación práctica por capas:

- Capa de presentación:
  - Páginas PHP dentro de `php/`
  - Recursos estáticos en `css/`, `img/`, `js/`, `audios/`, `html/`
- Capa de configuración:
  - `config/config.php`
  - `config/database.php`
- Capa de lógica de negocio reutilizable:
  - `php/clienteFunciones.php`
  - `php/Mailer.php`
- Capa de integración externa:
  - SDK de Transbank
  - PHPMailer
  - Dotenv
- Capa de persistencia:
  - Acceso a base de datos vía `PDO`

 3. Patrón de navegación y sesión

El proyecto se apoya en:

- Sesiones PHP para autenticación, carrito y estado temporal.
- Páginas servidoras como puntos de entrada por caso de uso.
- Endpoints AJAX simples para validaciones y actualización dinámica del carrito.

Ejemplos:

- `carrito.php`: agrega productos al carrito y responde JSON.
- `actualizar_carrito.php` y `eliminar_carrito.php`: actualizan el checkout sin recargar toda la lógica de negocio.
- `clienteAjax.php`: valida disponibilidad de usuario y email desde el formulario de registro.

 Arquitectura funcional

El sistema se divide en dos dominios principales.

 1. E-commerce para clientes

Incluye:

- Página de inicio con productos destacados.
- Catálogo completo de presentaciones de venta.
- Vista de detalle de producto.
- Carrito de compras manejado en sesión.
- Checkout y resumen previo al pago.
- Pago en línea mediante Webpay.
- Registro, login, activación de cuenta y recuperación de contraseña.
- Historial de compras y comprobante de compra.
- Correo de confirmación con ticket y QR.

 2. Operación interna y producción

Incluye:

- Panel administrativo.
- Gestión de insumos.
- Historial de actualizaciones de inventario.
- Planificador de producción por receta.
- Verificación de stock antes de reservar insumos.
- Reserva y reversa de stock de insumos.
- Estimación financiera por lote producido.
- Reproducción de audio descriptivo asociado al producto/receta.

 Funcionalidades principales

 Catálogo y productos

- Muestra productos desde la tabla `presentaciones_venta`.
- Calcula token de integridad para navegación a detalle y acciones sobre carrito.
- Presenta productos destacados en la portada.
- Expone fichas con imagen, nombre, descripción, precio y estado.

Archivos relevantes:

- `php/index.php`
- `php/productos.php`
- `php/detalles.php`

 Carrito y checkout

- Guarda el carrito en `$_SESSION`.
- Permite agregar productos desde catálogo y detalle.
- Soporta actualización de cantidades.
- Permite eliminar productos.
- Calcula subtotales y total general en tiempo real.

Archivos relevantes:

- `php/carrito.php`
- `php/checkout.php`
- `php/actualizar_carrito.php`
- `php/eliminar_carrito.php`

 Autenticación de usuarios

- Registro de cliente y usuario.
- Validación de email y nombre de usuario.
- Activación de cuenta por enlace enviado por correo.
- Inicio y cierre de sesión.
- Recuperación y cambio de contraseña.
- Distinción de rol administrador por nombre de usuario `admin`.

Archivos relevantes:

- `php/registro.php`
- `php/login.php`
- `php/logout.php`
- `php/activa_cliente.php`
- `php/recupera.php`
- `php/reset_password.php`
- `php/clienteFunciones.php`
- `php/clienteAjax.php`

 Pagos online

- Genera transacción con Transbank Webpay Plus.
- Redirige al portal seguro de pago.
- Confirma la transacción en el retorno.
- Registra la compra y su detalle en base de datos.
- Descarga stock asociado a la venta.
- Limpia el carrito después de una compra exitosa.
- Envía correo de confirmación al cliente.

Archivos relevantes:

- `php/pago.php`
- `php/crear_transaccion.php`
- `php/retorno_transaccion.php`
- `php/completado.php`
- `php/enviar_email.php`

 Administración, insumos y producción

- Acceso restringido para administrador.
- Edición manual de stock e información de insumos.
- Historial de movimientos recientes.
- Cálculo de materiales requeridos por receta.
- Evaluación de stock suficiente o insuficiente.
- Reserva de insumos para producción.
- Cancelación de la última reserva.
- Resumen de costo, ingreso, margen y ganancia estimada.

Archivos relevantes:

- `php/inicioadmin.php`
- `php/editarinsumo.php`
- `php/historial.php`
- `php/procesar.php`

 Estructura del repositorio

```text
.
|-- audios/                 Audios locales de apoyo para recetas/productos
|-- config/
|   |-- config.php          Sesión, constantes, variables de entorno, correo, Webpay
|   `-- database.php        Conexión PDO a MySQL
|-- css/                    Hojas de estilo
|-- html/                   Vistas HTML auxiliares
|-- img/                    Recursos gráficos
|-- js/
|   `-- index.js            JS de soporte del front
|-- php/                    Páginas y lógica principal del sistema
|-- phpmailer/              Librería PHPMailer incluida en el repositorio
|-- Dockerfile              Imagen PHP 8.2 + Apache
|-- composer.json           Dependencias PHP
`-- package.json            Archivo legado/no central para la app PHP
```

 Dependencias y stack tecnológico

 Backend

- PHP 8.2
- Apache
- PDO para acceso a datos
- Composer

 Librerías PHP declaradas

Según `composer.json`, el proyecto usa:

- `transbank/transbank-sdk`
- `vlucas/phpdotenv`
- `phpmailer/phpmailer`
- `mongodb/mongodb`

 Frontend

- HTML renderizado desde PHP
- CSS personalizado
- JavaScript vanilla
- Font Awesome vía CDN

 Infraestructura

- Docker con imagen `php:8.2-apache`
- Variables de entorno para base de datos y correo
- Despliegue pensado para nube, con referencias a Render

 Configuración

 Variables y constantes relevantes

El proyecto mezcla constantes fijas con variables de entorno.

 Base de datos

Configuradas en `config/database.php`:

- `DB_HOST`
- `DB_PORT`
- `DB_NAME`
- `DB_USER`
- `DB_PASS`

Si no existen, usa valores locales por defecto para entorno tipo XAMPP.

 Archivo de entorno local

En `config/config.php` se intenta cargar un archivo:

- `data.env`

Debe ubicarse en la raíz pública del proyecto para ser leído por `Dotenv`.

 Correo

Configuradas en `config/config.php`:

- `MAIL_HOST`
- `MAIL_USER`
- `MAIL_PASS`
- `MAIL_PORT`

 Pago

También en `config/config.php`:

- `WEBPAY_PLUS_COMMERCE_CODE`
- `WEBPAY_PLUS_API_KEY`
- `WEBPAY_PLUS_INTEGRATION_TYPE`
- `SITE_URL`

 Flujo principal de compra

1. El usuario navega por `index.php`, `productos.php` o `detalles.php`.
2. Agrega productos al carrito usando `carrito.php`.
3. Revisa cantidades y total en `checkout.php`.
4. Accede a `pago.php` y envía el formulario a `crear_transaccion.php`.
5. El sistema crea una transacción Webpay y redirige a Transbank.
6. Transbank retorna a `retorno_transaccion.php`.
7. Si la transacción es aprobada:
   - se registra la compra,
   - se registra el detalle,
   - se descuenta stock,
   - se limpia el carrito,
   - se envía correo,
   - se redirige a `completado.php`.

 Flujo principal de producción

1. Un administrador entra al panel `inicioadmin.php`.
2. Accede al planificador `procesar.php`.
3. Selecciona una presentación de venta y la cantidad de paquetes a producir.
4. El sistema consulta la receta asociada y calcula insumos requeridos.
5. Se verifica disponibilidad de stock.
6. Se muestra un resumen financiero con costo, ingreso y margen.
7. Si hay stock suficiente, se puede reservar material.
8. Si fue un error operativo, se puede cancelar la última reserva.

 Cómo ejecutar el proyecto

 Opción 1: Docker

El proyecto incluye `Dockerfile`.

Pasos generales:

```bash
docker build -t dulce-osadia .
docker run -p 8080:80 dulce-osadia
```

Notas:

- El `Dockerfile` copia el contenido de `php/` a la raíz del contenedor.
- Esto permite servir la aplicación directamente desde Apache.
- Se ejecuta `composer update --no-dev --optimize-autoloader --ignore-platform-reqs` durante el build.

 Opción 2: Entorno local con Apache/PHP

Requisitos:

- PHP 8.2 o compatible
- Apache o entorno local tipo XAMPP
- MySQL/MariaDB
- Composer

Pasos sugeridos:

```bash
composer install
```

Luego:

- Configurar la base de datos.
- Ajustar variables de entorno o `data.env`.
- Asegurar que el directorio servido por Apache apunte correctamente a la app.
- Verificar que `vendor/autoload.php` exista.

 Consideraciones técnicas importantes

 1. El proyecto es monolítico por archivos

No usa framework como Laravel o Symfony. La navegación, lógica y persistencia están distribuidas en archivos PHP específicos por funcionalidad.

 2. La base de datos principal es relacional

Aunque `composer.json` declara `mongodb/mongodb`, en el código revisado no se encontró uso activo de MongoDB en los flujos principales. La persistencia efectiva observada está construida sobre MySQL mediante `PDO`.

 3. `package.json` no representa el núcleo de la aplicación

Existe un `package.json` con referencias a un ejemplo de PayPal/Node, pero la aplicación real del repositorio funciona sobre PHP. Ese archivo parece residual o secundario respecto al sistema actual.

 4. Dependencia del `DOCUMENT_ROOT`

Algunas rutas usan `$_SERVER['DOCUMENT_ROOT']`, por lo que el entorno de despliegue debe respetar bien el directorio público esperado.

 5. Seguridad y estado actual

El sistema ya implementa:

- `password_hash()` y `password_verify()`
- validación básica por token para productos
- sesiones para autenticación
- prepared statements con `PDO`

Sin embargo, antes de pasar a producción conviene reforzar:

- manejo de secretos fuera del código fuente
- validaciones de autorización más consistentes
- estandarización de rutas y nombres de sesión
- manejo de errores y páginas de fallo
- documentación del esquema SQL

 Posibles módulos de negocio identificados

- Catálogo y marketing
- Clientes y autenticación
- Carrito y checkout
- Pagos
- Compras
- Inventario de insumos
- Producción y recetas
- Correo transaccional

 Estado documentado por este README

Este documento describe la aplicación según el código actual del repositorio. No asume funcionalidades no implementadas ni una arquitectura basada en framework.

 Recomendaciones para evolución futura

- Migrar a una estructura MVC o framework PHP.
- Separar controladores, servicios y repositorios.
- Externalizar todos los secretos y credenciales.
- Agregar migraciones y documentación formal de base de datos.
- Incorporar pruebas automáticas.
- Definir claramente un entorno de desarrollo local y uno de producción.

 Créditos funcionales

Proyecto orientado a la operación de Dulce Osadía, con foco en venta de chocolates artesanales y soporte interno para producción e inventario.
