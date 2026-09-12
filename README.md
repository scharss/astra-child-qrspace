# Astra Child — QRSpace

An child theme that transforms the homepage of `https://qrspace.cam` into the QRSpace dark-mode landing page, without affecting the rest of the site (blog, products, cart, checkout, my account), which continues to use WordPress + WooCommerce.

## File Structure

| File | Purpose |
|---|---|
| `style.css` | Child theme header (name, author, `Template: astra`). Contains no style rules. |
| `functions.php` | Isolation logic: enqueues the landing JS only on the front page and unloads Astra styles/scripts solely on the home page. |
| `front-page.php` | Full-page landing template. Outputs the complete homepage HTML, calls `wp_head()`/`wp_footer()`, and loads the landing CSS at the end of the `<head>` with base `!important` styles. |
| `css/style.css` | Landing styles: dark-mode, glassmorphism, violet accent, mobile-first responsive. |
| `js/script.js` | ES/EN i18n (`localStorage` persistence with key `qrspace-lang`, default `es`), mobile menu, scroll reveal, navbar shadow, and WhatsApp button pulse. |
| `assets/img/` | Landing images (QR codes, logos, success stories, screenshots). |
| `AGENTS.md` | Editing guide for humans and AI: critical rules, conventions, verification, and deployment. |
| `README.md` | This document. |

## Source of Truth and Local Copies

- **This repo (GitHub `scharss/astra-child-qrspace`) is the canonical source of the theme.** All changes are made in the repo root and manually propagated to the local working folder `QR SPACE\PAGINA WEB\web site\`:
  - `index.html` + `js/` + `css/` + `assets/` → Static version of the landing page.
  - `wp-upload\astra-child\` → WordPress version uploaded to the server.
- **Do not edit** older clones of this repo located at `web site\wp-upload\github\astra-child-qrspace` and `web site\wp-upload\github2\astra-child-qrspace`: these are disk clutter and candidates for deletion.

## Key Architecture

- **Per-page isolation**: The landing uses `front-page.php`, which WordPress automatically assigns to the homepage. The `is_front_page()` condition in `functions.php` ensures that the landing JS and Astra style unloading apply **only** to the home page.
- **Outside the home page**: The blog, products, cart, checkout, and my account pages load Astra normally; landing styles do not leak into those pages.
- **Admin bar**: Preserved (core `admin-bar`/`dashicons` styles are untouched) → visible when logged in.
- **CSS precedence on home**: In `front-page.php`, `css/style.css` is output **after** `wp_head()`, and a short `<style>` tag forces base colors (`background:#0a0a0f`, `color:#e8e8f0`, `margin:0`) with `!important`.

## Landing Page Content

- Hero section with animated QR code (violet laser) + live scan feed + stats (QR+GPS, QR+NFC, 24/7).
- Sections: "A solution for every space" (Businesses / Educational Centers / Events), "Why QRSpace?" (features), "Real results" (success stories), pricing plans ($47 USD/MONTH and $350 USD/YEAR), "Resources and guides" banner (blog), WhatsApp CTA, and footer with social media links.
- i18n: Elements with `data-i18n="key"` are populated via `js/script.js` (ES and EN translations).

## Installation / Deployment

1. Upload the entire `astra-child` folder to `public_html/wp-content/themes/` (or install `astra-child.zip` via Appearance → Themes → Add New → Upload Theme).
2. Activate **"Astra Child"** under Appearance → Themes.
3. When editing the landing page, re-upload `front-page.php` and `js/script.js` (plus `css/style.css` if modified) to the same folder and hard-refresh using **Ctrl+F5**.
4. **Do not replace** `index.php`, `.htaccess`, or `wp-config.php`: the theme integrates as a child theme, leaving the WordPress core engine intact.

## Reference Links

- Website: `https://qrspace.cam`
- Demo: `https://qrspace.cam/demo/`
- Pricing: `https://qrspace.cam/precio/`
- Blog: `https://qrspace.cam/blog/`
- My Account (Login): `https://qrspace.cam/mi-cuenta/`
- Cart: `https://qrspace.cam/carrito/`
- Monthly Product: `https://qrspace.cam/producto/qrspace-software-de-control-de-asistencia-mes/`
- Annual Product: `https://qrspace.cam/producto/qrspace-software-de-control-de-asistencia-anual/`
- Social Media: Facebook, Instagram, LinkedIn, Telegram, YouTube (`@qrspacelab`)
