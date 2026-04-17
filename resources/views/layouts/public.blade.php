<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="@yield('meta_description', 'Find elite legal professionals. Connect with verified lawyers for consultations.')">
  <title>@hasSection('title') @yield('title') — LegalCounsel @else LegalCounsel — Find Your Lawyer @endif</title>

  <!-- Preconnect for performance -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('head')
</head>
<body class="antialiased selection:bg-gold-500 selection:text-white overflow-x-hidden bg-linen text-onyx font-sans">
    {{-- Page Reveal Overlay --}}
    <div class="page-reveal fixed inset-0 z-[9999] bg-linen pointer-events-none"></div>
    {{-- Scroll Progress --}}
    <div class="scroll-progress fixed top-0 left-0 h-[2px] bg-gold-500 z-[10000]" style="width:0%"></div>

  <!-- Elegant Line Dividers (Bespoke Touch) -->
  <div class="fixed top-0 left-10 w-px h-full bg-onyx-5 z-0 pointer-events-none hidden lg:block"></div>
  <div class="fixed top-0 right-10 w-px h-full bg-onyx-5 z-0 pointer-events-none hidden lg:block"></div>

  <!-- Skip Navigation Link -->
  <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 z-[100] bg-gold-500 text-white px-6 py-2 text-[10px] tracking-ultra uppercase font-semibold focus:outline-none ring-offset-2 ring-2 ring-gold-500">
    Skip to main content
  </a>

  <!-- Ambient light -->
  <div class="fixed top-[-10%] left-[-10%] w-[50%] h-[50%] bg-gold-200/20 rounded-full blur-[150px] pointer-events-none z-[-1]"></div>

  @if(!View::hasSection('hide_navbar'))
  <nav id="main-nav" class="fixed top-0 w-full z-50 transition-all duration-700 bg-transparent px-6 py-6 lg:px-20">
    <div class="max-w-7xl mx-auto flex justify-between items-center relative z-10">
      <a href="{{ route('home') }}" class="font-serif text-3xl text-onyx font-normal tracking-tightest no-underline group flex items-baseline gap-1">
        Legal<span class="text-gold-500 italic drop-shadow-sm group-hover:translate-x-0.5 transition-transform">Counsel</span>
        <span class="w-1 h-1 bg-gold-500 rounded-full ml-1 animate-pulse"></span>
      </a>

      <div class="hidden lg:flex items-center gap-6 text-[11px] font-semibold tracking-ultra uppercase text-onyx">
      <a href="{{ route('public.search') }}" class="nav-link">Find a Lawyer</a>
      @auth
        <div class="relative group">
          <button class="flex items-center gap-3 btn-lux btn-lux-gold !px-6 !py-3">
             <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
             <span class="text-[10px] font-bold tracking-ultra uppercase">{{ auth()->user()->name }}</span>
             <svg class="w-3 h-3 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          
          <div class="absolute right-0 top-[90%] pt-4 w-56 bg-white border border-onyx-10 shadow-premium opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 rounded-lg overflow-hidden group-hover:translate-y-0">
             <div class="px-4 py-3 bg-onyx-5 border-b border-onyx-10">
               <p class="text-[9px] font-bold tracking-widest text-onyx/40 uppercase mb-0.5">Logged in as</p>
               <p class="text-[10px] font-bold text-onyx uppercase truncate">{{ auth()->user()->email }}</p>
             </div>
             
             <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-[10px] font-bold tracking-ultra uppercase text-onyx hover:bg-gold-500 hover:text-white transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
             </a>

             <form method="POST" action="{{ route('logout') }}">
               @csrf
               <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-[10px] font-bold tracking-ultra uppercase text-onyx hover:bg-red-500 hover:text-white transition-all duration-300 border-t border-onyx-5">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4-4H7m6 4v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6"/></svg>
                  Sign Out
               </button>
             </form>
          </div>
        </div>
      @else
        <a href="{{ route('login') }}" class="nav-link">Login</a>
        <a href="{{ route('register') }}" class="btn-lux btn-lux-gold !px-8 !py-3 shadow-premium">Join the Network</a>
      @endauth
      </div>
    </div>
  </nav>
  @endif

  <main id="main-content" tabindex="-1">
    @yield('content')
  </main>

  @if(!View::hasSection('hide_footer'))
  <footer class="bg-onyx text-white py-10 md:py-12 px-6 lg:px-20 relative overflow-hidden">
    <div class="absolute bottom-[-20%] left-[-10%] w-[60%] h-[100%] bg-gold-900/10 rounded-full blur-[150px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-10 relative z-10">
      <div class="lg:col-span-5">
        <h5 class="font-serif text-3xl italic text-white mb-6 tracking-tightest">LegalCounsel</h5>
        <p class="text-base text-white/40 font-light max-w-md leading-relaxed">Dedicated to matching individuals with the highest caliber of legal expertise for every challenge.</p>
        
        <div class="mt-8">
          <p class="text-[9px] tracking-ultra font-bold uppercase text-gold-500 mb-4">Newsletter</p>
          <form action="#" method="POST" class="flex max-w-sm">
             @csrf
             <input type="email" name="email" required placeholder="YOUR EMAIL ADDRESS" class="bg-transparent border-0 border-b border-white/10 w-full py-3 text-xs tracking-widest text-white focus:ring-0 focus:border-gold-500 transition-colors uppercase">
             <button type="submit" class="bg-white text-onyx px-6 py-3 text-[10px] font-bold tracking-ultra uppercase hover:bg-gold-500 hover:text-white transition-colors">Join</button>
          </form>
        </div>
      </div>

      <div class="lg:col-span-7 grid grid-cols-1 md:grid-cols-3 gap-10">
        <div>
          <h6 class="text-[9px] font-bold tracking-ultra uppercase text-gold-500 mb-6 underline decoration-gold-500/30 underline-offset-8">Explore</h6>
          <ul class="space-y-3 text-xs font-light text-white/60 uppercase tracking-widest">
            <li><a href="{{ route('public.search') }}" class="hover:text-gold-500 transition-colors">Areas of law</a></li>
            <li><a href="{{ route('public.privacy') }}" class="hover:text-gold-500 transition-colors">Our Ethos</a></li>
            <li><a href="{{ route('public.search') }}" class="hover:text-gold-500 transition-colors">Network</a></li>
          </ul>
        </div>
        <div>
          <h6 class="text-[9px] font-bold tracking-ultra uppercase text-gold-500 mb-6 underline decoration-gold-500/30 underline-offset-8">Support</h6>
          <ul class="space-y-3 text-xs font-light text-white/60 uppercase tracking-widest">
            <li><a href="mailto:concierge@legalcounsel.com" class="hover:text-gold-500 transition-colors">Contact</a></li>
            <li><a href="{{ route('public.privacy') }}" class="hover:text-gold-500 transition-colors">Privacy</a></li>
            <li><a href="{{ route('public.terms') }}" class="hover:text-gold-500 transition-colors">Terms</a></li>
          </ul>
        </div>
        <div>
          <h6 class="text-[9px] font-bold tracking-ultra uppercase text-gold-500 mb-6 underline decoration-gold-500/30 underline-offset-8">Social</h6>
          <ul class="space-y-3 text-xs font-light text-white/60 uppercase tracking-widest">
            <li><a href="https://instagram.com" target="_blank" class="hover:text-gold-500 transition-colors">Instagram</a></li>
            <li><a href="https://linkedin.com" target="_blank" class="hover:text-gold-500 transition-colors">LinkedIn</a></li>
            <li><a href="https://twitter.com" target="_blank" class="hover:text-gold-500 transition-colors">Twitter</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto mt-12 pt-10 border-t border-white/5 flex flex-col md:flex-row justify-between items-center text-[10px] tracking-ultra text-white/20 uppercase font-bold relative z-10">
      <p>&copy; {{ date('Y') }} LEGALCOUNSEL — EST. 2024. All rights reserved.</p>
      <div class="mt-4 md:mt-0 flex gap-10">
        <span>Designed for excellence</span>
        <span class="flex items-center gap-1 group cursor-pointer hover:text-gold-500 transition-colors">
          Built on Trust 
          <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </span>
      </div>
    </div>
  </footer>
  @endif

  <!-- Page transition curtain removed for stability -->

  <!-- GSAP + ScrollTrigger for advanced animations -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  <script src="https://unpkg.com/@studio-freight/lenis@1.0.33/dist/lenis.min.js"></script>
  <script>
    // ============================================================
    // NO PAGE CURTAIN - Disabled for maximum reliability
    // ============================================================

    // Page transition script has been safely disabled on standard routes.

    // ============================================================
    // LENIS SMOOTH SCROLL + GSAP SCROLL TRIGGER INTEGRATION
    // ============================================================
    const lenis = new Lenis();
    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => { lenis.raf(time * 1000); });
    gsap.ticker.lagSmoothing(0);

    // Navbar scroll effect
    const nav = document.getElementById('main-nav');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        nav.classList.add('bg-linen/80', 'backdrop-blur-xl', 'py-4', 'border-b', 'border-onyx-5');
        nav.classList.remove('py-6');
      } else {
        nav.classList.remove('bg-linen/80', 'backdrop-blur-xl', 'py-4', 'border-b', 'border-onyx-5');
        nav.classList.add('py-6');
      }
    });

    // Parallax background blobs via GSAP ScrollTrigger
    gsap.utils.toArray('.parallax-blob').forEach(blob => {
      const speed = parseFloat(blob.getAttribute('data-speed')) || 0.1;
      gsap.to(blob, {
        y: () => window.innerHeight * speed * 1.5,
        ease: 'none',
        scrollTrigger: { trigger: blob, start: 'top bottom', end: 'bottom top', scrub: true }
      });
    });

    // ============================================================
    // GSAP HOVER MICRO-INTERACTIONS — Lawyer card lift
    // (done via JS to avoid CSS transform conflict with scroll anims)
    // ============================================================
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.lawyer-card, .lawyer-card-search').forEach(card => {
        card.addEventListener('mouseenter', () => {
          gsap.to(card, { y: -8, duration: 0.4, ease: 'power2.out', overwrite: 'auto' });
        });
        card.addEventListener('mouseleave', () => {
          gsap.to(card, { y: 0, duration: 0.5, ease: 'power3.out', overwrite: 'auto' });
        });
      });
    });
  </script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 1000, easing: 'ease-out-expo', once: true, offset: 50 });

    // Native form submissions are used for reliability.
  </script>
  {{-- Custom Menu Configuration --}}
  @php
    $menuItems = [
        ['label' => 'Home', 'link' => route('home'), 'ariaLabel' => 'Go to homepage'],
        ['label' => 'Find a Lawyer', 'link' => route('public.search'), 'ariaLabel' => 'Search lawyers'],
    ];
    if (auth()->check()) {
        $menuItems[] = ['label' => 'Dashboard', 'link' => route('dashboard'), 'ariaLabel' => 'Go to dashboard'];
    } else {
        $menuItems[] = ['label' => 'Login', 'link' => route('login')];
        $menuItems[] = ['label' => 'Register', 'link' => route('register')];
    }
    $menuItems[] = ['label' => 'Contact', 'link' => 'mailto:concierge@legalcounsel.com', 'ariaLabel' => 'Get in touch'];
    
    $socialItems = [
        ["label" => "Instagram", "link" => "https://instagram.com/legalcounsel"],
        ["label" => "LinkedIn", "link" => "https://linkedin.com/company/legalcounsel"],
        ["label" => "Twitter", "link" => "https://twitter.com/legalcounsel"]
    ];
  @endphp

  <div id="custom-menu"
       data-items='@json($menuItems)'
       data-social='@json($socialItems)'
       data-menu-color="#0D0D0D"
       data-open-color="#D4AF37"
       data-accent="#5227FF">
  </div>

  <style>
    /* Hide CustomMenu toggle on desktop screens */
    @media (min-width: 1024px) {
      .sm-toggle,
      .custom-menu-wrapper .staggered-menu-header {
        display: none !important;
      }
    }

    /* Mobile menu improvements */
    @media (max-width: 1023px) {
      .sm-panel-item {
        font-size: 2rem !important;
        padding: 1rem 0 !important;
      }

      .sm-panel-itemLabel {
        font-weight: 500;
      }

      /* Better spacing for mobile menu */
      .sm-panel-list {
        gap: 1.5rem;
      }

      /* Social links styling */
      .sm-socials-link {
        font-size: 1.25rem;
        padding: 0.5rem 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.2);
        transition: all 0.3s ease;
      }

      .sm-socials-link:hover {
        color: #D4AF37 !important;
        padding-left: 1.5rem;
      }
    }

    /* Ensure footer stays at bottom */
    html, body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    main#main-content {
      flex: 1 0 auto;
    }

    footer {
      flex-shrink: 0;
    }

    /* Reduce hero section height on smaller screens */
    @media (max-width: 768px) {
      .min-h-screen {
        min-height: 80vh;
      }
    }

    /* Better button spacing on mobile */
    @media (max-width: 640px) {
      .flex.flex-col.sm\:flex-row {
        gap: 1rem;
      }

      .btn-lux {
        width: 100%;
        text-align: center;
      }
    }

    /* Authentication pages - less clogged */
    .auth-container {
      max-width: 480px;
      margin: 4rem auto;
      padding: 0 1.5rem;
    }

    .auth-container-wide {
      max-width: 900px !important;
    }

    .auth-card {
      background: #ffffff;
      border: 1px solid rgba(13, 13, 13, 0.05);
      border-radius: 0; /* Sharp for luxury */
      padding: 3rem;
      box-shadow: 
        0 60px 120px -20px rgba(13, 13, 13, 0.08),
        0 30px 60px -30px rgba(0, 0, 0, 0.05);
      position: relative;
    }

    .auth-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 6px;
      background: linear-gradient(to right, #D4AF37, #B8860B, #D4AF37);
    }

    .section-divider {
      @apply border-t border-onyx/5 my-12 relative;
    }

    .section-divider::after {
      content: attr(data-label);
      @apply absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white px-4 text-[9px] font-bold tracking-ultra uppercase text-onyx/20 opacity-100;
    }

    /* Form field spacing */
    .auth-form .form-group {
      margin-bottom: 1.5rem;
    }

    .auth-form label {
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 0.5rem;
      display: block;
      color: rgba(13, 13, 13, 0.6);
    }

    .auth-form input,
    .auth-form select,
    .auth-form textarea {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid rgba(13, 13, 13, 0.2);
      border-radius: 0.5rem;
      background: rgba(255, 255, 255, 0.8);
      font-size: 0.95rem;
      transition: all 0.3s ease;
    }

    .auth-form input:focus,
    .auth-form select:focus,
    .auth-form textarea:focus {
      outline: none;
      border-color: #D4AF37;
      box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
    }

    /* Smaller padding on auth pages */
    .auth-card .p-12 {
      padding: 1.5rem !important;
    }

    /* Multi-step form indicator */
    .form-step-indicator {
      display: flex;
      justify-content: center;
      gap: 0.5rem;
      margin-bottom: 2rem;
    }

    .step-dot {
      width: 0.5rem;
      height: 0.5rem;
      border-radius: 50%;
      background: rgba(13, 13, 13, 0.2);
      transition: all 0.3s ease;
    }

    .step-dot.active {
      width: 1.5rem;
      border-radius: 0.25rem;
      background: #D4AF37;
  }

  /* ============================================
     CUSTOM MENU - Fullscreen Staggered Navigation
     ============================================ */

  /* Wrapper - fullscreen fixed container */
  .custom-menu-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    pointer-events: none;
    overflow: hidden;
  }

  .custom-menu-wrapper[data-open] {
    pointer-events: auto;
  }

  /* Prelayers - colored animated backgrounds */
  .sm-prelayers {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
    overflow: hidden;
    pointer-events: none;
    background: transparent;
  }

  .sm-prelayer {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 300%;
    height: 300%;
    transform: translate(-50%, -50%);
    border-radius: 50%;
    opacity: 0;
    will-change: transform, opacity;
  }

  /* Header */
  .staggered-menu-header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 1.5rem;
    z-index: 10;
    pointer-events: none;
  }

  .staggered-menu-header .sm-toggle,
  .staggered-menu-header .sm-logo {
    pointer-events: auto;
  }

  /* Logo */
  .sm-logo {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .sm-logo-img {
    height: 24px;
    width: auto;
  }

  /* Toggle button */
  .sm-toggle {
    pointer-events: auto;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #fff;
    font-family: inherit;
  }

  .sm-toggle-textWrap {
    display: block;
    overflow: hidden;
    height: 1.2em;
    line-height: 1;
  }

  .sm-toggle-textInner {
    display: block;
    transition: transform 0.5s cubic-bezier(0.87, 0, 0.13, 1);
  }

  .sm-toggle-line {
    display: block;
    height: 1em;
  }

  /* Icon plus sign */
  .sm-icon {
    display: block;
    width: 24px;
    height: 24px;
    position: relative;
  }

  .sm-icon-line {
    position: absolute;
    top: 50%;
    left: 0;
    width: 100%;
    height: 2px;
    background: currentColor;
    transform: translateY(-50%);
  }

  .sm-icon-line-v {
    transform: translateY(-50%) rotate(90deg);
  }

  /* Panel - fullscreen menu */
  .staggered-menu-panel {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 5;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
  }

  .custom-menu-wrapper[data-open] .staggered-menu-panel {
    pointer-events: auto;
  }

  .sm-panel-inner {
    width: 100%;
    max-width: 900px;
    padding: 6rem 2rem 2rem;
    text-align: center;
  }

  /* Menu list */
  .sm-panel-list {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .sm-panel-itemWrap {
    margin: 0;
    padding: 0;
  }

  .sm-panel-item {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-family: 'Instrument Serif', serif;
    font-size: clamp(2rem, 8vw, 5rem);
    color: #fff;
    text-decoration: none;
    padding: 0.5rem 1rem;
    transition: color 0.3s ease;
    position: relative;
  }

  .sm-panel-item:hover {
    color: #D4AF37;
  }

  /* Numbering for menu items */
  .sm-panel-item[data-index]::before {
    content: attr(data-index);
    display: inline-block;
    font-size: 0.5em;
    font-family: 'Outfit', sans-serif;
    font-weight: 600;
    margin-right: 0.5rem;
    opacity: 0.4;
    vertical-align: middle;
  }

  /* Social section */
  .sm-socials {
    margin-top: 3rem;
  }

  .sm-socials-title {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.2em;
    color: rgba(255,255,255,0.5);
    margin-bottom: 1rem;
  }

  .sm-socials-list {
    list-style: none;
    display: flex;
    justify-content: center;
    gap: 2rem;
  }

  .sm-socials-link {
    color: #fff;
    text-decoration: none;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    transition: color 0.3s ease, padding-left 0.3s ease;
    padding: 0.5rem 0;
  }

  .sm-socials-link:hover {
    color: #D4AF37 !important;
    padding-left: 0.5rem;
  }
  </style>

    @stack('scripts')
    
    <x-toast />
    <x-confirm-modal />
</body>
</html>
