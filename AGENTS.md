# AGENTS.md — Guía para IA/agentes que trabajan en este proyecto

Este documento describe cómo está montado el sitio y las reglas para editarlo sin romper nada.

## Contexto

- **Stack**: WordPress en `https://qrspace.cam`, tema padre **Astra**, **WooCommerce** (venta de suscripciones) y plugin de consentimiento **Complianz**.
- **`astra-child/`** es un tema hijo de Astra (`Template: astra`). Su único propósito es mostrar la landing dark-mode de QRSpace **solo en la home** mediante `front-page.php`.
- El resto del sitio (blog, productos, carrito, checkout, mi cuenta) sigue usando WordPress/WooCommerce con los estilos de Astra.

## Reglas críticas (no romper)

1. **La landing solo vive en la home.** `front-page.php` es usado automáticamente por WordPress para la portada. Nunca subas un `index.html` a la raíz ni reemplaces `index.php`, `.htaccess` ni `wp-config.php`: esos archivos mantienen vivo WordPress.
2. **Aislamiento de estilos.** Los estilos de la landing (`css/style.css`) deben afectar ÚNICAMENTE a la portada. En `functions.php`, `qrspace_landing_enqueue_assets` y `qrspace_strip_astra_on_front` verifican `is_front_page()`: fuera de la home la landing no carga y Astra carga normal.
3. **Descargo de Astra solo en la home.** `qrspace_strip_astra_on_front` elimina estilos/scripts del tema padre (`.../themes/astra/`) únicamente en la portada, respetando `admin-bar` y `dashicons`. No amplíes ese descargo a otras páginas.
4. **CSS de la landing carga al final del `<head>`.** En `front-page.php` el `<link>` de `css/style.css` se imprime DESPUÉS de `wp_head()`, más un `<style>` con colores base `!important`. Mantener ese orden: es lo que hace que la landing gane sobre el CSS del tema.
5. **`style.css` del child NO lleva reglas de estilo.** Solo la cabecera del tema. Toda la estética va en `css/style.css`.
6. **El botón "Gestionar consentimiento" de Complianz** se oculta con CSS adicional del Customizer (`.cmplz-btn.cmplz-manage-consent { display: none !important; }`). No es parte de este tema.

## Convenciones al editar

- **Los cambios de la landing se aplican en ambos lados**:
  - `web site/index.html` (versión estática local de la landing).
  - `web site/wp-upload/astra-child/front-page.php` (versión WordPress).
  - Si se toca texto/i18n, actualizar `js/script.js` en **ambas** copias:
    - `web site/js/script.js`
    - `web site/wp-upload/astra-child/js/script.js`
- **i18n**: los textos usan `data-i18n="clave"` y se rellenan desde `translations` en `script.js` (idiomas `es` y `en`, persistencia con `localStorage('qrspace-lang')`, default `es`). Al cambiar un texto, actualizar la clave ES y su equivalente EN.
- **Enlaces**: todos los enlaces externos apuntan a `qrspace.cam` (rutas absolutas) o a los WhatsApp/redes de QRSpace. No cambiarlos salvo que se pida.
- **Idioma de archivos nuevos**: en español (proyecto en español).

## Verificación

Ejecutar antes de dar un cambio por bueno:

```bash
php -l front-page.php
php -l functions.php
node --check js/script.js
```

Y confirmar que no quedan restos de textos viejos (`rg "texto viejo" .`).

## Despliegue

- No hay plugin de caché. Tras subir cambios del tema, recargar con **Ctrl+F5**.
- Subir al servidor a `public_html/wp-content/themes/astra-child/`, reemplazando los archivos modificados (`front-page.php`, `js/script.js`, `css/style.css` según corresponda).
- Si se sube por ZIP (instalador de temas), asegurarse de que quede **descomprimido** como `wp-content/themes/astra-child/` y activar **"Astra Child"**.

## Flujo para cambiar un texto visible

1. Buscar la clave: `rg "data-i18n=\"<clave>\"" front-page.php`.
2. Actualizar el texto de respaldo en `front-page.php` e `index.html`.
3. Actualizar la traducción ES y EN de esa clave en ambos `script.js`.
4. Verificar con los comandos de arriba y desplegar.
