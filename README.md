# Astra Child — QRSpace

Tema hijo de **Astra** (`Template: astra`) que convierte la **home** de `https://qrspace.cam` en la landing dark-mode de QRSpace, sin afectar el resto del sitio (blog, productos, carrito, checkout, mi cuenta) que sigue usando WordPress + WooCommerce con los estilos de Astra.

## Estructura de archivos

| Archivo | Propósito |
|---|---|
| `style.css` | Cabecera del tema hijo (nombre, autor, `Template: astra`). No contiene reglas de estilo. |
| `functions.php` | Lógica de aislamiento: encola el JS de la landing solo en la portada y descarga los estilos/scripts de Astra únicamente en la home. |
| `front-page.php` | Template full-page de la landing. Imprime el HTML completo de la portada, llama `wp_head()`/`wp_footer()`, y carga el CSS de la landing al final del `<head>` con estilos base `!important`. |
| `css/style.css` | Estilos de la landing: dark-mode, glassmorphism, acento violeta, responsive mobile-first. |
| `js/script.js` | i18n ES/EN (persistencia en `localStorage` con clave `qrspace-lang`, default `es`), menú móvil, reveal on scroll, sombra del navbar y pulso del botón WhatsApp. |
| `assets/img/` | Imágenes de la landing (QR, logos, casos de éxito, screenshots). |
| `AGENTS.md` | Guía de edición para humanos e IA: reglas críticas, convenciones, verificación y despliegue. |
| `README.md` | Este documento. |

## Fuente de verdad y copias locales

- **Este repo (GitHub `scharss/astra-child-qrspace`) es la fuente canónica del tema.** Todo cambio se hace en la raíz del repo y se propaga a mano a la carpeta de trabajo local `QR SPACE\PAGINA WEB\web site\`:
  - `index.html` + `js/` + `css/` + `assets/` → versión estática de la landing.
  - `wp-upload\astra-child\` → versión WordPress que se sube al servidor.
- **No editar** los clones antiguos del propio repo que viven en `web site\wp-upload\github\astra-child-qrspace` y `web site\wp-upload\github2\astra-child-qrspace`: son sobra de disco, candidatos a borrar.

## Arquitectura clave

- **Aislamiento por página**: la landing usa `front-page.php`, que WordPress emplea automáticamente para la portada. La condición `is_front_page()` en `functions.php` garantiza que el JS de la landing y el descargo de estilos de Astra **solo** apliquen en la home.
- **Fuera de la home**: blog, productos, carrito, checkout y mi cuenta cargan Astra normalmente; los estilos de la landing no se filtran a esas páginas.
- **Barra de administración**: se conserva (los estilos `admin-bar`/`dashicons` de core no se tocan) → visible al estar logueado.
- **CSS gana en la home**: en `front-page.php`, `css/style.css` se imprime **después** de `wp_head()`, y un `<style>` corto fuerza los colores base (`background:#0a0a0f`, `color:#e8e8f0`, `margin:0`) con `!important`.

## Contenido de la landing

- Hero con código QR animado (láser violeta) + feed de escaneos en vivo + stats (QR+GPS, QR+NFC, 24/7).
- Secciones: "Una solución para cada espacio" (Empresas / Centros Educativos / Eventos), "¿Por qué QRSpace?" (features), "Resultados reales" (casos de éxito), planes de precio ($47 USD/MES y $350 USD/AÑO), banner "Recursos y guías" (blog), CTA WhatsApp y footer con redes sociales.
- i18n: elementos con `data-i18n="clave"` se rellenan desde `js/script.js` (traducciones ES y EN).

## Instalación / despliegue

1. Subir la carpeta `astra-child` completa a `public_html/wp-content/themes/` (o instalar `astra-child.zip` desde Apariencia → Temas → Añadir nuevo → Subir tema).
2. Activar **"Astra Child"** en Apariencia → Temas.
3. Al editar la landing, re-subir `front-page.php` y `js/script.js` (y `css/style.css` si cambió) a la misma carpeta y recargar con **Ctrl+F5**.
4. **No reemplazar** `index.php`, `.htaccess` ni `wp-config.php`: el tema se integra como child theme, el motor de WordPress queda intacto.

## Enlaces de referencia

- Sitio: `https://qrspace.cam`
- Demo: `https://qrspace.cam/demo/`
- Precios: `https://qrspace.cam/precio/`
- Blog: `https://qrspace.cam/blog/`
- Mi cuenta (Login): `https://qrspace.cam/mi-cuenta/`
- Carrito: `https://qrspace.cam/carrito/`
- Producto mensual: `https://qrspace.cam/producto/qrspace-software-de-control-de-asistencia-mes/`
- Producto anual: `https://qrspace.cam/producto/qrspace-software-de-control-de-asistencia-anual/`
- WhatsApp (info): `https://api.whatsapp.com/send/?phone=573117379576&text=Hola+QRSpace%2C+necesito+m%C3%A1s+informaci%C3%B3n`
- WhatsApp (demo): `https://wa.me/573117379576?text=Hola%20QRSpace%20quiero%20agendar%20una%20demostraci%C3%B3n`
- Redes: Facebook, Instagram, LinkedIn, Telegram, YouTube (`@qrspacelab`)
