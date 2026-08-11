<?php
/**
 * Template Name: QRSpace Landing
 *
 * Plantilla full-page para la portada de QRSpace.
 * Usada automaticamente por WordPress para la home.
 */
$qrs_url = get_stylesheet_directory_uri();
$qrs_img = $qrs_url . '/assets/img';
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="QRSpace — Control de asistencia inteligente con códigos QR para empresas, centros educativos y eventos. Registro rápido con QR + GPS.">
  <title>QRSpace | Control de Asistencia con Códigos QR</title>
  <link rel="icon" type="image/png" href="<?php echo esc_url( $qrs_img ); ?>/QRspace.logoC.png">

  <!-- Google Fonts: Inter + Outfit -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- Font Awesome 6 (icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <?php wp_head(); ?>

  <!-- Landing QRSpace: se carga al final para ganar a cualquier estilo del tema -->
  <link rel="stylesheet" href="<?php echo esc_url( $qrs_url ); ?>/css/style.css">
  <style>
    html, body { background-color: #0a0a0f !important; color: #e8e8f0 !important; margin: 0 !important; }
    body { overflow-x: hidden; }
  </style>
</head>
<body <?php body_class(); ?>>

  <!-- ============================= -->
  <!-- NAVBAR (Sticky)               -->
  <!-- ============================= -->
  <header class="navbar" id="navbar">
    <div class="navbar__glass"></div>
    <div class="container">
      <a href="https://qrspace.cam/" class="navbar__logo">
        <img src="<?php echo esc_url( $qrs_img ); ?>/logowhitetransparente.png" alt="QRSpace" class="navbar__logo-img">
      </a>

      <nav class="navbar__nav" id="navMenu">
        <ul class="navbar__links">
          <li><a href="https://qrspace.cam/" class="navbar__link" data-i18n="nav_home">Inicio</a></li>
          <li><a href="https://qrspace.cam/demo/" class="navbar__link" data-i18n="nav_demo">Demo</a></li>
          <li><a href="#pricing" class="navbar__link" data-i18n="nav_pricing">Precio</a></li>
          <li><a href="https://qrspace.cam/blog/" class="navbar__link" data-i18n="nav_blog">Blog</a></li>
          <li><a href="https://qrspace.cam/mi-cuenta/" class="navbar__link" data-i18n="nav_login">Login</a></li>
        </ul>
        <div class="navbar__actions">
          <a href="https://qrspace.cam/carrito/" class="navbar__cart" aria-label="Carrito de compras" target="_blank" rel="noopener">
            <i class="fa-solid fa-cart-shopping"></i>
          </a>
          <button class="lang-toggle js-lang-toggle" id="langToggle" aria-label="Cambiar idioma">
            <i class="fa-solid fa-globe"></i>
            <span data-i18n="lang_label">EN</span>
          </button>
          <a href="https://wa.me/573117379576?text=Hola%20QRSpace%20quiero%20agendar%20una%20demostraci%C3%B3n" class="btn btn--primary navbar__cta" target="_blank" rel="noopener" data-i18n="nav_cta">
            Agendar Demo <i class="fa-solid fa-arrow-right"></i>
          </a>
        </div>
      </nav>

      <div class="navbar__right">
        <a href="https://qrspace.cam/carrito/" class="navbar__cart navbar__cart--mobile" aria-label="Carrito de compras" target="_blank" rel="noopener">
          <i class="fa-solid fa-cart-shopping"></i>
        </a>
        <button class="navbar__toggle" id="navToggle" aria-label="Abrir menú">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
  </header>

  <main>

    <!-- ============================= -->
    <!-- HERO SECTION                  -->
    <!-- ============================= -->
    <section class="hero" id="hero">
      <div class="hero__bg">
        <div class="hero__orb hero__orb--1"></div>
        <div class="hero__orb hero__orb--2"></div>
        <div class="hero__grid-pattern"></div>
      </div>
      <div class="container">
        <div class="hero__content">
          <span class="hero__badge reveal" data-i18n="hero_badge">&#9670; Control de Asistencia con QR</span>
          <h1 class="hero__title reveal" data-i18n="hero_title">Control de Asistencia<br>Inteligente con <span class="gradient-text">Códigos QR</span></h1>
          <p class="hero__subtitle reveal" data-i18n="hero_subtitle">Solución utilizada por empresas e instituciones educativas para registrar asistencia en segundos, con validación GPS o NFC.</p>
          <div class="hero__actions reveal">
            <a href="https://qrspace.cam/demo/" class="btn btn--primary btn--lg" target="_blank" rel="noopener" data-i18n="hero_cta1">Ver Demo</a>
            <a href="https://wa.me/573117379576?text=Hola%20QRSpace%20quiero%20agendar%20una%20demostraci%C3%B3n" class="btn btn--ghost btn--lg" target="_blank" rel="noopener" data-i18n="hero_cta2">
              <i class="fa-brands fa-whatsapp"></i> Agendar Demostración
            </a>
          </div>
          <div class="hero__stats reveal">
            <div class="hero__stat">
              <span class="hero__stat-number">QR+GPS</span>
              <span class="hero__stat-label" data-i18n="hero_stat2">Validación de ubicación</span>
            </div>
            <div class="hero__stat">
              <span class="hero__stat-number">QR+NFC</span>
              <span class="hero__stat-label" data-i18n="hero_stat_nfc">Validación con chip</span>
            </div>
            <div class="hero__stat">
              <span class="hero__stat-number" data-i18n="hero_stat3_val">24/7</span>
              <span class="hero__stat-label" data-i18n="hero_stat3">Desde cualquier dispositivo</span>
            </div>
          </div>
        </div>
        <div class="hero__visual reveal">
          <div class="hero__scan">
            <span class="hero__scan-corner hero__scan-corner--tl"></span>
            <span class="hero__scan-corner hero__scan-corner--tr"></span>
            <span class="hero__scan-corner hero__scan-corner--bl"></span>
            <span class="hero__scan-corner hero__scan-corner--br"></span>
            <div class="hero__scan-inner">
              <img src="<?php echo esc_url( $qrs_img ); ?>/QRspace.png" alt="Código QR de QRSpace" loading="lazy">
              <div class="hero__shot-laser" aria-hidden="true"></div>
            </div>
          </div>

          <div class="hero__scan-info">
            <span class="hero__scan-status">
              <span class="hero__scan-dot"></span>
              <span data-i18n="scan_status">Escaneo activo</span>
            </span>

            <div class="hero__feed" aria-hidden="true">
              <div class="hero__feed-row">
                <i class="fa-solid fa-circle-check"></i>
                <span class="hero__feed-name">M. Rodríguez</span>
                <span class="hero__feed-time">08:12:04</span>
              </div>
              <div class="hero__feed-row">
                <i class="fa-solid fa-circle-check"></i>
                <span class="hero__feed-name">L. García</span>
                <span class="hero__feed-time">08:12:10</span>
              </div>
              <div class="hero__feed-row">
                <i class="fa-solid fa-circle-check"></i>
                <span class="hero__feed-name">A. Torres</span>
                <span class="hero__feed-time">08:12:17</span>
              </div>
            </div>

            <p class="hero__scan-text" data-i18n="scan_text">Apunta la cámara al código y registra la asistencia en segundos.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================= -->
    <!-- HOW WE CAN HELP (3 segments)  -->
    <!-- ============================= -->
    <section class="segments section" id="segments">
      <div class="container">
        <div class="section__header reveal">
          <span class="section__tag" data-i18n="segments_tag">¿Cómo podemos ayudarle?</span>
          <h2 class="section__title" data-i18n="segments_title">Una solución para <span class="gradient-text">cada espacio</span></h2>
          <p class="section__description" data-i18n="segments_desc">QRSpace se adapta a empresas, centros educativos y eventos masivos.</p>
        </div>

        <div class="segments__grid">
          <article class="segment-card reveal">
            <div class="segment-card__shot">
              <img src="<?php echo esc_url( $qrs_img ); ?>/768x1334-2.jpg" alt="App QRSpace para empresas" loading="lazy">
            </div>
            <div class="segment-card__icon"><i class="fa-solid fa-building"></i></div>
            <h3 class="segment-card__title" data-i18n="segment1_title">Empresas</h3>
            <p class="segment-card__text" data-i18n="segment1_desc">Control total de la hora de entrada y salida con QR + GPS.</p>
            <a href="https://qrspace.cam/demo/" class="segment-card__link" target="_blank" rel="noopener" data-i18n="visit_demo">Visitar demo <i class="fa-solid fa-arrow-right"></i></a>
          </article>

          <article class="segment-card segment-card--featured reveal">
            <div class="segment-card__shot">
              <img src="<?php echo esc_url( $qrs_img ); ?>/768x1334-1.jpg" alt="App QRSpace para centros educativos" loading="lazy">
            </div>
            <div class="segment-card__icon"><i class="fa-solid fa-graduation-cap"></i></div>
            <h3 class="segment-card__title" data-i18n="segment2_title">Centros Educativos</h3>
            <p class="segment-card__text" data-i18n="segment2_desc">Registra la asistencia en segundos con códigos QR.</p>
            <a href="https://qrspace.cam/demo/" class="segment-card__link" target="_blank" rel="noopener" data-i18n="visit_demo">Visitar demo <i class="fa-solid fa-arrow-right"></i></a>
          </article>

          <article class="segment-card reveal">
            <div class="segment-card__shot">
              <img src="<?php echo esc_url( $qrs_img ); ?>/evento.png" alt="App QRSpace para eventos" loading="lazy">
            </div>
            <div class="segment-card__icon"><i class="fa-solid fa-calendar-check"></i></div>
            <h3 class="segment-card__title" data-i18n="segment3_title">Eventos</h3>
            <p class="segment-card__text" data-i18n="segment3_desc">Gestiona puntos de entrada de eventos masivos con QR.</p>
            <a href="https://qrspace.cam/demo/" class="segment-card__link" target="_blank" rel="noopener" data-i18n="visit_demo">Visitar demo <i class="fa-solid fa-arrow-right"></i></a>
          </article>
        </div>
      </div>
    </section>

    <!-- ============================= -->
    <!-- FEATURES SECTION              -->
    <!-- ============================= -->
    <section class="features section" id="features">
      <div class="container">
        <div class="section__header reveal">
          <span class="section__tag" data-i18n="features_tag">Características</span>
          <h2 class="section__title" data-i18n="features_title">¿Por qué <span class="gradient-text">QRSpace</span>?</h2>
          <p class="section__description" data-i18n="features_desc">La forma más rápida, simple y confiable de registrar la asistencia.</p>
        </div>

        <div class="features__grid">
          <div class="feature-card reveal">
            <div class="feature-card__icon"><i class="fa-solid fa-bolt"></i></div>
            <h3 data-i18n="feat1_title">Registro en segundos</h3>
            <p data-i18n="feat1_desc">Cada persona escanea su código QR y su asistencia queda registrada al instante, sin filas ni esperas.</p>
          </div>

          <div class="feature-card reveal">
            <div class="feature-card__icon"><i class="fa-solid fa-location-dot"></i></div>
            <h3 data-i18n="feat2_title">Validación GPS</h3>
            <p data-i18n="feat2_desc">Registros de entrada y salida con confirmación de ubicación para verificar que la persona está en el lugar correcto.</p>
          </div>

          <div class="feature-card reveal">
            <div class="feature-card__icon"><i class="fa-solid fa-file-import"></i></div>
            <h3 data-i18n="feat3_title">Importación masiva</h3>
            <p data-i18n="feat3_desc">Importa miles de estudiantes o colaboradores en segundos desde una hoja de cálculo.</p>
          </div>

          <div class="feature-card reveal">
            <div class="feature-card__icon"><i class="fa-solid fa-id-card"></i></div>
            <h3 data-i18n="feat4_title">QR descargables</h3>
            <p data-i18n="feat4_desc">Genera y descarga los códigos QR en lote para carnets físicos o pantallas de celular.</p>
          </div>

          <div class="feature-card reveal">
            <div class="feature-card__icon"><i class="fa-solid fa-chart-column"></i></div>
            <h3 data-i18n="feat5_title">Reportes en Excel</h3>
            <p data-i18n="feat5_desc">Detecta ausencias automáticamente y exporta reportes completos de asistencia a Excel.</p>
          </div>

          <div class="feature-card reveal">
            <div class="feature-card__icon"><i class="fa-solid fa-mobile-screen"></i></div>
            <h3 data-i18n="feat6_title">Multi-dispositivo</h3>
            <p data-i18n="feat6_desc">Funciona desde cualquier celular, tableta o computador. Sin instalar apps para el personal.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================= -->
    <!-- SUCCESS CASES SECTION         -->
    <!-- ============================= -->
    <section class="cases section" id="cases">
      <div class="container">
        <div class="section__header reveal">
          <span class="section__tag" data-i18n="cases_tag">Casos de éxito</span>
          <h2 class="section__title" data-i18n="cases_title">Resultados <span class="gradient-text">reales</span></h2>
          <p class="section__description" data-i18n="cases_desc">Instituciones y empresas ya confían en QRSpace para su control de asistencia.</p>
        </div>

        <div class="cases__grid">
          <figure class="case-card reveal">
            <img src="<?php echo esc_url( $qrs_img ); ?>/casodeexito.jpg" alt="Caso de éxito QRSpace" loading="lazy">
          </figure>
          <figure class="case-card reveal">
            <img src="<?php echo esc_url( $qrs_img ); ?>/casodeexito2.jpg" alt="Caso de éxito QRSpace" loading="lazy">
          </figure>
          <figure class="case-card reveal">
            <img src="<?php echo esc_url( $qrs_img ); ?>/casodeexito3.jpg" alt="Caso de éxito QRSpace" loading="lazy">
          </figure>
          <figure class="case-card reveal">
            <img src="<?php echo esc_url( $qrs_img ); ?>/casodeexito4.jpg" alt="Caso de éxito QRSpace" loading="lazy">
          </figure>
          <figure class="case-card reveal">
            <img src="<?php echo esc_url( $qrs_img ); ?>/qr6.png" alt="Caso de éxito QRSpace" loading="lazy">
          </figure>
          <figure class="case-card reveal">
            <img src="<?php echo esc_url( $qrs_img ); ?>/qr7.png" alt="Caso de éxito QRSpace" loading="lazy">
          </figure>
        </div>
      </div>
    </section>

    <!-- ============================= -->
    <!-- PRICING SECTION               -->
    <!-- ============================= -->
    <section class="pricing section" id="pricing">
      <div class="container">
        <div class="section__header reveal">
          <span class="section__tag" data-i18n="pricing_tag">Precio</span>
          <h2 class="section__title" data-i18n="pricing_title">Planes <span class="gradient-text">sencillos</span></h2>
          <p class="section__description" data-i18n="pricing_desc">Incluye el software, tutorial de administración y soporte. Sin cobros automáticos.</p>
        </div>

        <div class="pricing__grid">
          <article class="price-card reveal">
            <div class="price-card__period" data-i18n="price_monthly">Mensual</div>
            <div class="price-card__name">QRSpace</div>
            <div class="price-card__amount">$47 <span data-i18n="price_monthly_suffix">USD/MES</span></div>
            <p class="price-card__text" data-i18n="price_desc">Software de Control de Asistencia + Tutorial de Administración + Soporte.</p>
            <span class="price-card__note" data-i18n="price_note">No se hacen cobros automáticos.</span>
            <a href="https://qrspace.cam/producto/qrspace-software-de-control-de-asistencia-mes/" class="btn btn--outline btn--lg" target="_blank" rel="noopener" data-i18n="buy_now">Comprar ahora</a>
          </article>

          <article class="price-card price-card--featured reveal">
            <span class="price-card__badge" data-i18n="price_best">Mejor valor</span>
            <div class="price-card__period" data-i18n="price_annual">Anual</div>
            <div class="price-card__name">QRSpace</div>
            <div class="price-card__amount">$470 <span data-i18n="price_annual_suffix">USD/AÑO</span></div>
            <p class="price-card__text" data-i18n="price_desc">Software de Control de Asistencia + Tutorial de Administración + Soporte.</p>
            <span class="price-card__note" data-i18n="price_note">No se hacen cobros automáticos.</span>
            <a href="https://qrspace.cam/producto/qrspace-software-de-control-de-asistencia-anual/" class="btn btn--primary btn--lg" target="_blank" rel="noopener" data-i18n="buy_now">Comprar ahora</a>
          </article>
        </div>
      </div>
    </section>

    <!-- ============================= -->
    <!-- BLOG SECTION                  -->
    <!-- ============================= -->
    <section class="blog section" id="blog">
      <div class="container">
        <div class="section__header reveal">
          <span class="section__tag" data-i18n="blog_tag">Blog</span>
          <h2 class="section__title" data-i18n="blog_title">Recursos y <span class="gradient-text">guías</span></h2>
          <p class="section__description" data-i18n="blog_desc">Guías y novedades sobre el control de asistencia con códigos QR.</p>
        </div>

        <div class="blog-card blog-card--banner reveal">
          <div class="blog-card__icon"><i class="fa-solid fa-blog"></i></div>
          <h3 class="blog-card__title" data-i18n="blog_card_title">Recursos y guías QRSpace</h3>
          <p class="blog-card__desc" data-i18n="blog_card_desc">Aprende a aprovechar QRSpace al máximo con guías y novedades sobre el control de asistencia con códigos QR.</p>
          <a href="https://qrspace.cam/blog/" class="btn btn--primary btn--lg" target="_blank" rel="noopener" data-i18n="blog_cta">
            Visitar el Blog <i class="fa-solid fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </section>

    <!-- ============================= -->
    <!-- CTA SECTION                   -->
    <!-- ============================= -->
    <section class="cta section" id="contact">
      <div class="container">
        <div class="cta__card reveal">
          <span class="cta__icon"><i class="fa-brands fa-whatsapp"></i></span>
          <h2 class="cta__title" data-i18n="cta_title">¿Listo para implementar QRSpace?</h2>
          <p class="cta__text" data-i18n="cta_text">Escríbenos por WhatsApp y recibe toda la información que necesitas.</p>
          <div class="cta__actions">
            <a href="https://api.whatsapp.com/send/?phone=573117379576&text=Hola+QRSpace%2C+necesito+m%C3%A1s+informaci%C3%B3n" class="btn btn--primary btn--lg" target="_blank" rel="noopener" data-i18n="cta_btn1">
              <i class="fa-brands fa-whatsapp"></i> Solicitar información
            </a>
            <a href="https://wa.me/573117379576?text=Hola%20QRSpace%20quiero%20agendar%20una%20demostraci%C3%B3n" class="btn btn--outline btn--lg" target="_blank" rel="noopener" data-i18n="cta_btn2">
              Agendar demostración
            </a>
          </div>
        </div>
      </div>
    </section>

  </main>

  <!-- ============================= -->
  <!-- FOOTER                        -->
  <!-- ============================= -->
  <footer class="footer" id="footer">
    <div class="container">
      <div class="footer__grid">
        <div class="footer__brand">
          <a href="https://qrspace.cam/" class="footer__logo">
            <img src="<?php echo esc_url( $qrs_img ); ?>/logowhitetransparente.png" alt="QRSpace" class="footer__logo-img">
          </a>
          <p class="footer__tagline" data-i18n="footer_tagline">Control de asistencia inteligente<br>con códigos QR.</p>
          <div class="footer__social">
            <a href="https://www.facebook.com/qrspacelab/" aria-label="Facebook" target="_blank" rel="noopener"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="https://www.instagram.com/qrspacelab/" aria-label="Instagram" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://www.linkedin.com/company/qrspacelab" aria-label="LinkedIn" target="_blank" rel="noopener"><i class="fa-brands fa-linkedin-in"></i></a>
            <a href="https://t.me/qrspacelab" aria-label="Telegram" target="_blank" rel="noopener"><i class="fa-brands fa-telegram"></i></a>
            <a href="https://www.youtube.com/@qrspacelab" aria-label="YouTube" target="_blank" rel="noopener"><i class="fa-brands fa-youtube"></i></a>
          </div>
        </div>

        <div class="footer__col">
          <h4 data-i18n="footer_nav">Navegación</h4>
          <ul>
            <li><a href="https://qrspace.cam/demo/" data-i18n="nav_demo">Demo</a></li>
            <li><a href="#pricing" data-i18n="nav_pricing">Precio</a></li>
            <li><a href="https://qrspace.cam/blog/" data-i18n="nav_blog">Blog</a></li>
            <li><a href="https://qrspace.cam/mi-cuenta/" data-i18n="nav_login">Login</a></li>
            <li><a href="https://qrspace.cam/carrito/" data-i18n="footer_cart">Carrito de compras</a></li>
          </ul>
        </div>

        <div class="footer__col">
          <h4 data-i18n="footer_support">Contacto</h4>
          <ul>
            <li><a href="https://api.whatsapp.com/send/?phone=573117379576&text=Hola+QRSpace%2C+necesito+m%C3%A1s+informaci%C3%B3n" target="_blank" rel="noopener" data-i18n="footer_wa_info">WhatsApp — Información</a></li>
            <li><a href="https://wa.me/573117379576?text=Hola%20QRSpace%20quiero%20agendar%20una%20demostraci%C3%B3n" target="_blank" rel="noopener" data-i18n="footer_wa_demo">WhatsApp — Demo</a></li>
            <li><a href="https://qrspace.cam/mi-cuenta/" target="_blank" rel="noopener" data-i18n="footer_login">Iniciar sesión</a></li>
          </ul>
        </div>
      </div>

      <div class="footer__bottom">
        <p data-i18n="footer_copy">&copy; 2026 QR Space. Todos los derechos reservados.</p>
      </div>
    </div>
  </footer>

  <!-- ============================= -->
  <!-- MOBILE MENU OVERLAY (body level) -->
  <!-- ============================= -->
  <div class="mobile-overlay" id="mobileOverlay">
    <ul class="mobile-overlay__links">
      <li><a href="https://qrspace.cam/" class="navbar__link" data-i18n="nav_home">Inicio</a></li>
      <li><a href="https://qrspace.cam/demo/" class="navbar__link" data-i18n="nav_demo">Demo</a></li>
      <li><a href="#pricing" class="navbar__link" data-i18n="nav_pricing">Precio</a></li>
      <li><a href="https://qrspace.cam/blog/" class="navbar__link" data-i18n="nav_blog">Blog</a></li>
      <li><a href="https://qrspace.cam/mi-cuenta/" class="navbar__link" data-i18n="nav_login">Login</a></li>
    </ul>
    <div class="mobile-overlay__actions">
      <button class="lang-toggle js-lang-toggle" aria-label="Cambiar idioma" type="button">
        <i class="fa-solid fa-globe"></i>
        <span data-i18n="lang_label">EN</span>
      </button>
      <a href="https://qrspace.cam/carrito/" class="navbar__cart mobile-overlay__cart" aria-label="Carrito de compras" target="_blank" rel="noopener">
        <i class="fa-solid fa-cart-shopping"></i>
      </a>
      <a href="https://wa.me/573117379576?text=Hola%20QRSpace%20quiero%20agendar%20una%20demostraci%C3%B3n" class="btn btn--primary navbar__cta" target="_blank" rel="noopener" data-i18n="nav_cta">
        Agendar Demo <i class="fa-solid fa-arrow-right"></i>
      </a>
    </div>
  </div>

  <!-- ============================= -->
  <!-- WHATSAPP FLOATING BUTTON      -->
  <!-- ============================= -->
  <a href="https://api.whatsapp.com/send/?phone=573117379576&text=Hola+QRSpace%2C+necesito+m%C3%A1s+informaci%C3%B3n"
     class="whatsapp-btn"
     target="_blank"
     rel="noopener"
     aria-label="Chat por WhatsApp"
     id="whatsappBtn">
    <i class="fa-brands fa-whatsapp"></i>
    <span class="whatsapp-btn__pulse"></span>
  </a>

  <?php wp_footer(); ?>
</body>
</html>
