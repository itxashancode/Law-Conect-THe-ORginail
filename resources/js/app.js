import './bootstrap';

import Alpine from 'alpinejs';
import Lenis from 'lenis';
import './components/Grainient.js';
import './components/BounceCards.js';
import './components/CustomMenu.js';

// Expose GSAP globally so inline blade scripts can use it
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
gsap.registerPlugin(ScrollTrigger);
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

// Initialize Lenis Smooth Scroll
const lenis = new Lenis({
  duration: 1.2,
  easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), // https://www.desmos.com/calculator/brs54l4xou
  orientation: 'vertical',
  gestureOrientation: 'vertical',
  smoothWheel: true,
  wheelMultiplier: 1,
  smoothTouch: false,
  touchMultiplier: 2,
  infinite: false,
});

// Sync Lenis with GSAP ScrollTrigger
lenis.on('scroll', ScrollTrigger.update);

gsap.ticker.add((time) => {
  lenis.raf(time * 1000);
});

gsap.ticker.lagSmoothing(0);

window.lenis = lenis;

window.Alpine = Alpine;
Alpine.start();

// ─── Page Reveal ────────────────────────────────────────────────────────────
// Fade out the linen overlay that covers the page on load.
document.addEventListener('DOMContentLoaded', () => {
  const reveal = document.querySelector('.page-reveal');
  if (reveal) {
    gsap.to(reveal, {
      yPercent: -100,
      duration: 0.6,
      ease: 'expo.out',
      delay: 0.15,
      onComplete: () => { reveal.style.display = 'none'; }
    });
  }

  // ─── Scroll Progress Bar ──────────────────────────────────────────────────
  const bar = document.querySelector('.scroll-progress');
  if (bar && window.lenis) {
    window.lenis.on('scroll', (e) => {
      bar.style.width = Math.min(e.progress * 100, 100) + '%';
    });
  }

  // ─── Navbar Floating Dock ────────────────────────────────────────────────
  const nav = document.getElementById('main-nav');
  if (nav && window.lenis) {
    window.lenis.on('scroll', (e) => {
      if (e.scroll > 50) {
        nav.classList.add('bg-white/80', 'backdrop-blur-xl', 'py-3', 'px-10', 'border-onyx-5', 'shadow-premium', 'max-w-2xl');
        nav.classList.remove('max-w-7xl', 'py-4', 'px-8', 'bg-white/0', 'border-transparent');
      } else {
        nav.classList.remove('bg-white/80', 'backdrop-blur-xl', 'py-3', 'px-10', 'border-onyx-5', 'shadow-premium', 'max-w-2xl');
        nav.classList.add('max-w-7xl', 'py-4', 'px-8', 'bg-white/0', 'border-transparent');
      }
    });
  }

  // ─── Lucide Icons ────────────────────────────────────────────────────────
  if (typeof lucide !== 'undefined') {
    lucide.createIcons();
  }

  // ─── AOS Init ────────────────────────────────────────────────────────────
  if (typeof AOS !== 'undefined') {
    AOS.init({ once: true, duration: 400, offset: 60 });
  }
});
