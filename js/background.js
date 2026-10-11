/**
 * QRSpace — Fondo animado global (canvas vanilla, sin dependencias).
 * Efecto: red / constelación de partículas con líneas entre las cercanas.
 * Se anima siempre (no respeta prefers-reduced-motion), pausa al ocultar
 * la pestaña y limita la cantidad de partículas según el tamaño de pantalla.
 */

(function () {
  'use strict';

  var canvas = document.getElementById('qrspace-bg');
  if (!canvas || !canvas.getContext) {
    return;
  }

  var ctx = canvas.getContext('2d');
  var finePointer = window.matchMedia &&
    window.matchMedia('(pointer: fine)').matches;

  var DPR = Math.min(window.devicePixelRatio || 1, 2);
  var LINK_DIST = 120;
  var MAX_PARTICLES = 90;
  var MIN_PARTICLES = 18;

  var COLOR_A = '139, 92, 246'; // #8b5cf6 (violeta)
  var COLOR_B = '99, 102, 241'; // #6366f1 (índigo)

  var W = 0;
  var H = 0;
  var particles = [];
  var mouse = { x: 0, y: 0, active: false };
  var rafId = null;
  var running = false;

  function rand(min, max) {
    return Math.random() * (max - min) + min;
  }

  function countFor(width, height) {
    var n = Math.round((width * height) / 16000);
    if (width < 768) {
      n = Math.round(n * 0.5);
    }
    return Math.max(MIN_PARTICLES, Math.min(n, MAX_PARTICLES));
  }

  function resize() {
    W = Math.max(1, document.documentElement.clientWidth || window.innerWidth || 1);
    H = Math.max(1, window.innerHeight || document.documentElement.clientHeight || 1);

    canvas.width = Math.round(W * DPR);
    canvas.height = Math.round(H * DPR);
    ctx.setTransform(DPR, 0, 0, DPR, 0, 0);

    build();
  }

  function build() {
    var n = countFor(W, H);
    particles = [];

    for (var i = 0; i < n; i++) {
      particles.push({
        x: rand(0, W),
        y: rand(0, H),
        vx: rand(-0.35, 0.35),
        vy: rand(-0.35, 0.35),
        r: rand(1, 2.4),
        c: Math.random() < 0.5 ? COLOR_A : COLOR_B
      });
    }
  }

  function draw() {
    ctx.clearRect(0, 0, W, H);

    var i, j, p, q, dx, dy, dist;

    for (i = 0; i < particles.length; i++) {
      p = particles[i];
      p.x += p.vx;
      p.y += p.vy;

      if (p.x < 0 || p.x > W) { p.vx *= -1; p.x = Math.max(0, Math.min(W, p.x)); }
      if (p.y < 0 || p.y > H) { p.vy *= -1; p.y = Math.max(0, Math.min(H, p.y)); }

      if (mouse.active) {
        dx = mouse.x - p.x;
        dy = mouse.y - p.y;
        var d2 = dx * dx + dy * dy;
        if (d2 < 40000 && d2 > 1) {
          p.vx += dx * 0.0006;
          p.vy += dy * 0.0006;
        }
      }

      var speed = Math.sqrt(p.vx * p.vx + p.vy * p.vy);
      if (speed > 0.8) {
        p.vx *= 0.8 / speed;
        p.vy *= 0.8 / speed;
      }

      ctx.beginPath();
      ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
      ctx.fillStyle = 'rgba(' + p.c + ', 0.55)';
      ctx.fill();
    }

    for (i = 0; i < particles.length; i++) {
      p = particles[i];
      for (j = i + 1; j < particles.length; j++) {
        q = particles[j];
        dx = p.x - q.x;
        dy = p.y - q.y;
        dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < LINK_DIST) {
          ctx.beginPath();
          ctx.moveTo(p.x, p.y);
          ctx.lineTo(q.x, q.y);
          ctx.strokeStyle = 'rgba(' + COLOR_A + ', ' + ((1 - dist / LINK_DIST) * 0.35).toFixed(3) + ')';
          ctx.lineWidth = 1;
          ctx.stroke();
        }
      }
    }
  }

  function loop() {
    draw();
    rafId = window.requestAnimationFrame(loop);
  }

  function start() {
    if (running) {
      return;
    }
    running = true;
    loop();
  }

  function stop() {
    running = false;
    if (rafId) {
      window.cancelAnimationFrame(rafId);
      rafId = null;
    }
  }

  var resizeTimer = null;
  window.addEventListener('resize', function () {
    window.clearTimeout(resizeTimer);
    resizeTimer = window.setTimeout(function () {
      resize();
    }, 150);
  });

  document.addEventListener('visibilitychange', function () {
    if (document.hidden) {
      stop();
    } else {
      start();
    }
  });

  if (finePointer) {
    window.addEventListener('mousemove', function (e) {
      var rect = canvas.getBoundingClientRect();
      var x = e.clientX - rect.left;
      var y = e.clientY - rect.top;
      if (x >= 0 && y >= 0 && x <= rect.width && y <= rect.height) {
        mouse.x = x;
        mouse.y = y;
        mouse.active = true;
      } else {
        mouse.active = false;
      }
    }, { passive: true });

    window.addEventListener('mouseout', function () {
      mouse.active = false;
    });
  }

  function init() {
    resize();
    start();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
