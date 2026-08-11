/**
 * QRSpace — Main JavaScript
 * Handles: i18n (ES/EN toggle), mobile menu, scroll reveal animations, navbar effects
 */

(function () {
  'use strict';

  /* =============================================================
     TRANSLATIONS
     ============================================================= */
  const translations = {
    es: {
      lang_label: 'EN',

      nav_home: 'Inicio',
      nav_demo: 'Demo',
      nav_pricing: 'Precio',
      nav_blog: 'Blog',
      nav_login: 'Login',
      nav_cta: 'Agendar Demo <i class="fa-solid fa-arrow-right"></i>',

      hero_badge: '\u25C7 Control de Asistencia con QR',
      hero_title: 'Control de Asistencia<br>Inteligente con <span class="gradient-text">C\u00F3digos QR</span>',
      hero_subtitle: 'Soluci\u00F3n utilizada por empresas e instituciones educativas para registrar asistencia en segundos, con validaci\u00F3n GPS o NFC.',
      hero_cta1: 'Ver Demo',
      hero_cta2: '<i class="fa-brands fa-whatsapp"></i> Agendar Demostraci\u00F3n',
      hero_stat2: 'Validaci\u00F3n de ubicaci\u00F3n',
      hero_stat_nfc: 'Validaci\u00F3n con chip',
      hero_stat3: 'Desde cualquier dispositivo',
      scan_status: 'Escaneo activo',
      scan_text: 'Apunta la c\u00E1mara al c\u00F3digo y registra la asistencia en segundos.',

      segments_tag: '\u00BFC\u00F3mo podemos ayudarle?',
      segments_title: 'Una soluci\u00F3n para <span class="gradient-text">cada espacio</span>',
      segments_desc: 'QRSpace se adapta a empresas, centros educativos y eventos masivos.',
      segment1_title: 'Empresas',
      segment1_desc: 'Control total de la hora de entrada y salida con QR + GPS.',
      segment2_title: 'Centros Educativos',
      segment2_desc: 'Registra la asistencia en segundos con c\u00F3digos QR.',
      segment3_title: 'Eventos',
      segment3_desc: 'Gestiona puntos de entrada de eventos masivos con QR.',
      visit_demo: 'Visitar demo <i class="fa-solid fa-arrow-right"></i>',

      features_tag: 'Caracter\u00EDsticas',
      features_title: '\u00BFPor qu\u00E9 <span class="gradient-text">QRSpace</span>?',
      features_desc: 'La forma m\u00E1s r\u00E1pida, simple y confiable de registrar la asistencia.',
      feat1_title: 'Registro en segundos',
      feat1_desc: 'Cada persona escanea su c\u00F3digo QR y su asistencia queda registrada al instante, sin filas ni esperas.',
      feat2_title: 'Validaci\u00F3n GPS',
      feat2_desc: 'Registros de entrada y salida con confirmaci\u00F3n de ubicaci\u00F3n para verificar que la persona est\u00E1 en el lugar correcto.',
      feat3_title: 'Importaci\u00F3n masiva',
      feat3_desc: 'Importa miles de estudiantes o colaboradores en segundos desde una hoja de c\u00E1lculo.',
      feat4_title: 'QR descargables',
      feat4_desc: 'Genera y descarga los c\u00F3digos QR en lote para carnetts f\u00EDsicos o pantallas de celular.',
      feat5_title: 'Reportes en Excel',
      feat5_desc: 'Detecta ausencias autom\u00E1ticamente y exporta reportes completos de asistencia a Excel.',
      feat6_title: 'Multi-dispositivo',
      feat6_desc: 'Funciona desde cualquier celular, tableta o computador. Sin instalar apps para el personal.',

      screens_tag: 'Demo',
      screens_title: 'As\u00ED se ve <span class="gradient-text">QRSpace</span>',
      screens_desc: 'Conoce la plataforma desde tu m\u00F3vil, tableta o computador.',
      screens_cta: 'Clic para entrar al Demo QRSpace',

      cases_tag: 'Casos de \u00E9xito',
      cases_title: 'Resultados <span class="gradient-text">reales</span>',
      cases_desc: 'Instituciones y empresas ya conf\u00EDan en QRSpace para su control de asistencia.',

      pricing_tag: 'Precio',
      pricing_title: 'Planes <span class="gradient-text">sencillos</span>',
      pricing_desc: 'Incluye el software, tutorial de administraci\u00F3n y soporte. Sin cobros autom\u00E1ticos.',
      price_monthly: 'Mensual',
      price_annual: 'Anual',
      price_monthly_suffix: 'USD/MES',
      price_annual_suffix: 'USD/A\u00D1O',
      price_desc: 'Software de Control de Asistencia + Tutorial de Administraci\u00F3n + Soporte.',
      price_note: 'No se hacen cobros autom\u00E1ticos.',
      price_best: 'Mejor valor',
      buy_now: 'Comprar ahora',

      blog_tag: 'Blog',
      blog_title: 'Recursos y <span class="gradient-text">gu\u00EDas</span>',
      blog_desc: 'Gu\u00EDas y novedades sobre el control de asistencia con c\u00F3digos QR.',
      blog_card_title: 'Recursos y gu\u00EDas QRSpace',
      blog_card_desc: 'Aprende a aprovechar QRSpace al m\u00E1ximo con gu\u00EDas y novedades sobre el control de asistencia con c\u00F3digos QR.',
      blog_cta: 'Visitar el Blog <i class="fa-solid fa-arrow-right"></i>',

      cta_title: '\u00BFListo para implementar QRSpace?',
      cta_text: 'Escr\u00EDbenos por WhatsApp y recibe toda la informaci\u00F3n que necesitas.',
      cta_btn1: '<i class="fa-brands fa-whatsapp"></i> Solicitar informaci\u00F3n',
      cta_btn2: 'Agendar demostraci\u00F3n',

      footer_tagline: 'Control de asistencia inteligente<br>con c\u00F3digos QR.',
      footer_nav: 'Navegaci\u00F3n',
      footer_support: 'Contacto',
      footer_cart: 'Carrito de compras',
      footer_wa_info: 'WhatsApp \u2014 Informaci\u00F3n',
      footer_wa_demo: 'WhatsApp \u2014 Demo',
      footer_login: 'Iniciar sesi\u00F3n',
      footer_copy: '\u00A9 2026 QR Space. Todos los derechos reservados.'
    },

    en: {
      lang_label: 'ES',

      nav_home: 'Home',
      nav_demo: 'Demo',
      nav_pricing: 'Pricing',
      nav_blog: 'Blog',
      nav_login: 'Login',
      nav_cta: 'Book a Demo <i class="fa-solid fa-arrow-right"></i>',

      hero_badge: '\u25C7 QR Attendance Control',
      hero_title: 'Smart Attendance Control<br>with <span class="gradient-text">QR Codes</span>',
      hero_subtitle: 'A solution used by companies and educational institutions to record attendance in seconds, with GPS or NFC validation.',
      hero_cta1: 'View Demo',
      hero_cta2: '<i class="fa-brands fa-whatsapp"></i> Book a Demo',
      hero_stat2: 'Location validation',
      hero_stat_nfc: 'Chip validation',
      hero_stat3: 'From any device',
      scan_status: 'Scanning active',
      scan_text: 'Point your camera at the code and record attendance in seconds.',

      segments_tag: 'How can we help you?',
      segments_title: 'One solution for <span class="gradient-text">every space</span>',
      segments_desc: 'QRSpace adapts to companies, educational centers and mass events.',
      segment1_title: 'Companies',
      segment1_desc: 'Full control of check-in and check-out times with QR + GPS.',
      segment2_title: 'Educational Centers',
      segment2_desc: 'Record attendance in seconds with QR codes.',
      segment3_title: 'Events',
      segment3_desc: 'Manage entry points for mass events with QR.',
      visit_demo: 'Visit demo <i class="fa-solid fa-arrow-right"></i>',

      features_tag: 'Features',
      features_title: 'Why <span class="gradient-text">QRSpace</span>?',
      features_desc: 'The fastest, simplest and most reliable way to record attendance.',
      feat1_title: 'Register in seconds',
      feat1_desc: 'Each person scans their QR code and their attendance is recorded instantly, with no queues or waiting.',
      feat2_title: 'GPS validation',
      feat2_desc: 'Check-in and check-out records with location confirmation to verify the person is in the right place.',
      feat3_title: 'Bulk import',
      feat3_desc: 'Import thousands of students or employees in seconds from a spreadsheet.',
      feat4_title: 'Downloadable QR',
      feat4_desc: 'Generate and download QR codes in batch for physical cards or phone screens.',
      feat5_title: 'Excel reports',
      feat5_desc: 'Automatically detect absences and export complete attendance reports to Excel.',
      feat6_title: 'Multi-device',
      feat6_desc: 'Works from any phone, tablet or computer. No apps to install for staff.',

      screens_tag: 'Demo',
      screens_title: 'This is <span class="gradient-text">QRSpace</span>',
      screens_desc: 'Explore the platform from your phone, tablet or computer.',
      screens_cta: 'Click to enter the QRSpace Demo',

      cases_tag: 'Success cases',
      cases_title: 'Real <span class="gradient-text">results</span>',
      cases_desc: 'Institutions and companies already trust QRSpace for their attendance control.',

      pricing_tag: 'Pricing',
      pricing_title: 'Simple <span class="gradient-text">plans</span>',
      pricing_desc: 'Includes the software, admin tutorial and support. No automatic charges.',
      price_monthly: 'Monthly',
      price_annual: 'Annual',
      price_monthly_suffix: 'USD/MONTH',
      price_annual_suffix: 'USD/YEAR',
      price_desc: 'Attendance Control Software + Admin Tutorial + Support.',
      price_note: 'No automatic charges.',
      price_best: 'Best value',
      buy_now: 'Buy now',

      blog_tag: 'Blog',
      blog_title: 'Resources & <span class="gradient-text">guides</span>',
      blog_desc: 'Guides and news about QR code attendance control.',
      blog_card_title: 'QRSpace resources & guides',
      blog_card_desc: 'Learn how to get the most out of QRSpace with guides and news about QR code attendance control.',
      blog_cta: 'Visit the Blog <i class="fa-solid fa-arrow-right"></i>',

      cta_title: 'Ready to implement QRSpace?',
      cta_text: 'Message us on WhatsApp and get all the information you need.',
      cta_btn1: '<i class="fa-brands fa-whatsapp"></i> Request information',
      cta_btn2: 'Book a demo',

      footer_tagline: 'Smart attendance control<br>with QR codes.',
      footer_nav: 'Navigation',
      footer_support: 'Contact',
      footer_cart: 'Shopping cart',
      footer_wa_info: 'WhatsApp \u2014 Information',
      footer_wa_demo: 'WhatsApp \u2014 Demo',
      footer_login: 'Sign in',
      footer_copy: '\u00A9 2026 QR Space. All rights reserved.'
    }
  };

  /* =============================================================
     STATE
     ============================================================= */
  let currentLang = localStorage.getItem('qrspace-lang') || 'es';

  /* =============================================================
     i18N ENGINE
     ============================================================= */
  function updatePageLanguage(lang) {
    currentLang = lang;
    localStorage.setItem('qrspace-lang', lang);

    const elements = document.querySelectorAll('[data-i18n]');
    elements.forEach(function (el) {
      const key = el.getAttribute('data-i18n');
      const value = translations[lang][key];
      if (value !== undefined) {
        el.innerHTML = value;
      }
    });

    document.documentElement.lang = lang;
  }

  /* =============================================================
     DOM REFERENCES
     ============================================================= */
  const langToggles    = document.querySelectorAll('.js-lang-toggle');
  const navToggle      = document.getElementById('navToggle');
  const mobileOverlay  = document.getElementById('mobileOverlay');
  const navbar         = document.getElementById('navbar');
  const whatsappBtn    = document.getElementById('whatsappBtn');
  const revealEls      = document.querySelectorAll('.reveal');

  /* =============================================================
     LANGUAGE TOGGLE (all .js-lang-toggle buttons)
     ============================================================= */
  function switchLanguage() {
    const nextLang = currentLang === 'es' ? 'en' : 'es';
    updatePageLanguage(nextLang);
  }

  langToggles.forEach(function (btn) {
    btn.addEventListener('click', switchLanguage);
  });

  /* Apply saved language on load */
  updatePageLanguage(currentLang);

  /* =============================================================
     MOBILE MENU TOGGLE
     ============================================================= */
  function closeMenu() {
    mobileOverlay.classList.remove('open');
    navToggle.classList.remove('active');
    document.body.style.overflow = '';
  }

  function openMenu() {
    mobileOverlay.classList.add('open');
    navToggle.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  if (navToggle && mobileOverlay) {
    navToggle.addEventListener('click', function () {
      if (mobileOverlay.classList.contains('open')) {
        closeMenu();
      } else {
        openMenu();
      }
    });
  }

  /* Close menu when clicking a nav link inside overlay */
  const overlayLinks = document.querySelectorAll('.mobile-overlay__links .navbar__link');
  overlayLinks.forEach(function (link) {
    link.addEventListener('click', function () {
      closeMenu();
    });
  });

  /* Close menu when clicking CTA inside overlay */
  const overlayCta = mobileOverlay ? mobileOverlay.querySelector('.navbar__cta') : null;
  if (overlayCta) {
    overlayCta.addEventListener('click', function () {
      closeMenu();
    });
  }

  /* Close menu when pressing Escape */
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && mobileOverlay && mobileOverlay.classList.contains('open')) {
      closeMenu();
    }
  });

  /* =============================================================
     NAVBAR — shadow on scroll
     ============================================================= */
  if (navbar) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 20) {
        navbar.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.5)';
      } else {
        navbar.style.boxShadow = 'none';
      }
    }, { passive: true });
  }

  /* =============================================================
     INTERSECTION OBSERVER — Fade-in on scroll
     ============================================================= */
  if (revealEls.length > 0) {
    var observerOptions = {
      root: null,
      rootMargin: '0px 0px -60px 0px',
      threshold: 0.1
    };

    var revealObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('revealed');
          revealObserver.unobserve(entry.target);
        }
      });
    }, observerOptions);

    revealEls.forEach(function (el) {
      revealObserver.observe(el);
    });
  }

  /* =============================================================
     WHATSAPP BUTTON — pause pulse on hover
     ============================================================= */
  if (whatsappBtn) {
    whatsappBtn.addEventListener('mouseenter', function () {
      whatsappBtn.style.animationPlayState = 'paused';
    });

    whatsappBtn.addEventListener('mouseleave', function () {
      whatsappBtn.style.animationPlayState = 'running';
    });

    /* Ensure pulse span resumes too */
    var pulseEl = whatsappBtn.querySelector('.whatsapp-btn__pulse');
    if (pulseEl) {
      whatsappBtn.addEventListener('mouseenter', function () {
        pulseEl.style.animationPlayState = 'paused';
      });
      whatsappBtn.addEventListener('mouseleave', function () {
        pulseEl.style.animationPlayState = 'running';
      });
    }
  }

})();
