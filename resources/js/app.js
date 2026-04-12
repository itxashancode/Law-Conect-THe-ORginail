import './bootstrap';

import Alpine from 'alpinejs';
import './components/Grainient.js';
import './components/BounceCards.js';
import './components/CustomMenu.js';

// Expose GSAP globally so inline blade scripts can use it
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
gsap.registerPlugin(ScrollTrigger);
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

window.Alpine = Alpine;
Alpine.start();

// ─── Page Reveal ────────────────────────────────────────────────────────────
// Fade out the linen overlay that covers the page on load.
document.addEventListener('DOMContentLoaded', () => {
  const reveal = document.querySelector('.page-reveal');
  if (reveal) {
    gsap.to(reveal, {
      yPercent: -100,
      duration: 1.1,
      ease: 'expo.inOut',
      delay: 0.15,
      onComplete: () => { reveal.style.display = 'none'; }
    });
  }

  // ─── Scroll Progress Bar ──────────────────────────────────────────────────
  const bar = document.querySelector('.scroll-progress');
  if (bar) {
    window.addEventListener('scroll', () => {
      const h = document.documentElement;
      const pct = (h.scrollTop / (h.scrollHeight - h.clientHeight)) * 100;
      bar.style.width = Math.min(pct, 100) + '%';
    }, { passive: true });
  }

  // ─── Navbar scroll behaviour ─────────────────────────────────────────────
  const nav = document.getElementById('main-nav');
  if (nav) {
    const update = () => {
      if (window.scrollY > 80) {
        nav.classList.add('bg-linen/95', 'backdrop-blur-md', 'shadow-sm', 'py-3');
        nav.classList.remove('bg-transparent', 'py-6');
      } else {
        nav.classList.remove('bg-linen/95', 'backdrop-blur-md', 'shadow-sm', 'py-3');
        nav.classList.add('bg-transparent', 'py-6');
      }
    };
    window.addEventListener('scroll', update, { passive: true });
    update();
  }

  // ─── AOS Init ────────────────────────────────────────────────────────────
  if (typeof AOS !== 'undefined') {
    AOS.init({ once: true, duration: 700, offset: 60 });
  }
});
