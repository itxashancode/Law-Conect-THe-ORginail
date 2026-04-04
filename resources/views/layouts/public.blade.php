<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Find elite legal professionals. Connect with verified lawyers for consultations.">
  <title>@yield('title', 'LegalCounsel — Find Your Lawyer')</title>

  <!-- Preconnect for performance -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-linen text-onyx font-sans relative selection:bg-gold-500 selection:text-white">

  <!-- Elegant Line Dividers (Bespoke Touch) -->
  <div class="fixed top-0 left-10 w-px h-full bg-onyx-5 z-0 pointer-events-none hidden lg:block"></div>
  <div class="fixed top-0 right-10 w-px h-full bg-onyx-5 z-0 pointer-events-none hidden lg:block"></div>

  <!-- Skip Navigation Link -->
  <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 z-[100] bg-gold-500 text-white px-6 py-2 text-[10px] tracking-ultra uppercase font-semibold focus:outline-none ring-offset-2 ring-2 ring-gold-500">
    Skip to main content
  </a>

  <!-- Ambient light -->
  <div class="fixed top-[-10%] left-[-10%] w-[50%] h-[50%] bg-gold-200/20 rounded-full blur-[150px] pointer-events-none z-[-1]"></div>

  <nav id="main-nav" class="fixed top-0 w-full z-50 transition-all duration-700 bg-transparent px-6 py-6 lg:px-20">
    <div class="max-w-7xl mx-auto flex justify-between items-center relative z-10">
      <a href="{{ route('home') }}" class="font-serif text-3xl text-onyx font-normal tracking-tightest no-underline group flex items-baseline gap-1">
        Legal<span class="text-gold-500 italic drop-shadow-sm group-hover:translate-x-0.5 transition-transform">Counsel</span>
        <span class="w-1 h-1 bg-gold-500 rounded-full ml-1 animate-pulse"></span>
      </a>

      <div class="hidden lg:flex items-center gap-6 text-[11px] font-semibold tracking-ultra uppercase text-onyx">
      <a href="{{ route('public.search') }}" class="nav-link">Find a Lawyer</a>
      @auth
        <a href="{{ route('dashboard') }}" class="btn-lux btn-lux-gold !px-8 !py-3">Dashboard</a>
      @else
        <a href="{{ route('login') }}" class="nav-link">Login</a>
        <a href="{{ route('register') }}" class="btn-lux btn-lux-gold !px-8 !py-3 shadow-premium">Join as Client</a>
        <a href="{{ route('lawyer.register') }}" class="btn-lux btn-lux-outline !px-8 !py-3">For Lawyers</a>
      @endauth
    </div>
  </nav>

  <main id="main-content" tabindex="-1">
    @if(session('success'))
      <div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 bg-gold-500 text-white px-8 py-4 shadow-premium animate__animated animate__fadeInDown" role="alert">
        {{ session('success') }}
      </div>
    @endif
    @if(session('warning'))
      <div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 bg-onyx text-white px-8 py-4 shadow-premium animate__animated animate__fadeInDown" role="alert">
        {{ session('warning') }}
      </div>
    @endif
    @if(session('error'))
      <div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 bg-red-600 text-white px-8 py-4 shadow-premium animate__animated animate__fadeInDown" role="alert">
        {{ session('error') }}
      </div>
    @endif
    @yield('content')
  </main>

  <footer class="bg-onyx text-white py-16 md:py-24 px-6 lg:px-20 relative overflow-hidden">
    <div class="absolute bottom-[-20%] left-[-10%] w-[60%] h-[100%] bg-gold-900/10 rounded-full blur-[150px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-20 relative z-10">
      <div class="lg:col-span-5">
        <h5 class="font-serif text-5xl italic text-white mb-8 tracking-tightest">LegalCounsel</h5>
        <p class="text-lg text-white/50 font-light max-w-md leading-relaxed">Dedicated to matching individuals with the highest caliber of legal expertise for every challenge.</p>
        
        <div class="mt-12">
          <p class="text-[10px] tracking-ultra font-bold uppercase text-gold-500 mb-4">Newsletter</p>
          <div class="flex max-w-sm">
             <input type="email" placeholder="YOUR EMAIL ADDRESS" class="bg-transparent border-0 border-b border-white/10 w-full py-4 text-xs tracking-widest text-white focus:ring-0 focus:border-gold-500 transition-colors uppercase">
             <button class="bg-white text-onyx px-8 py-4 text-[10px] font-bold tracking-ultra uppercase hover:bg-gold-500 hover:text-white transition-colors">Join</button>
          </div>
        </div>
      </div>

      <div class="lg:col-span-7 grid grid-cols-1 md:grid-cols-3 gap-12">
        <div>
          <h6 class="text-[10px] font-bold tracking-ultra uppercase text-gold-500 mb-8 underline decoration-gold-500/30 underline-offset-8">Explore</h6>
          <ul class="space-y-4 text-sm font-light text-white/80 uppercase tracking-widest">
            <li><a href="#" class="hover:text-gold-500 transition-colors">Areas of law</a></li>
            <li><a href="#" class="hover:text-gold-500 transition-colors">Our Ethos</a></li>
            <li><a href="#" class="hover:text-gold-500 transition-colors">Journal</a></li>
          </ul>
        </div>
        <div>
          <h6 class="text-[10px] font-bold tracking-ultra uppercase text-gold-500 mb-8 underline decoration-gold-500/30 underline-offset-8">Support</h6>
          <ul class="space-y-4 text-sm font-light text-white/80 uppercase tracking-widest">
            <li><a href="#" class="hover:text-gold-500 transition-colors">Contact</a></li>
            <li><a href="#" class="hover:text-gold-500 transition-colors">Terms</a></li>
            <li><a href="#" class="hover:text-gold-500 transition-colors">Privacy</a></li>
          </ul>
        </div>
        <div>
          <h6 class="text-[10px] font-bold tracking-ultra uppercase text-gold-500 mb-8 underline decoration-gold-500/30 underline-offset-8">Social</h6>
          <ul class="space-y-4 text-sm font-light text-white/80 uppercase tracking-widest">
            <li><a href="#" class="hover:text-gold-500 transition-colors">Instagram</a></li>
            <li><a href="#" class="hover:text-gold-500 transition-colors">LinkedIn</a></li>
            <li><a href="#" class="hover:text-gold-500 transition-colors">Twitter</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto mt-32 pt-10 border-t border-white/5 flex flex-col md:flex-row justify-between items-center text-[10px] tracking-ultra text-white/20 uppercase font-bold relative z-10">
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

  <!-- GSAP for advanced animations -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://unpkg.com/@studio-freight/lenis@1.0.33/dist/lenis.min.js"></script>
  <script>
    // Initialize Lenis for smooth scrolling
    const lenis = new Lenis()
    function raf(time) {
      lenis.raf(time)
      requestAnimationFrame(raf)
    }
    requestAnimationFrame(raf)

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

    // Parallax background blobs
    window.addEventListener('scroll', () => {
      const blobs = document.querySelectorAll('.parallax-blob');
      blobs.forEach(blob => {
        const speed = parseFloat(blob.getAttribute('data-speed')) || 0.1;
        blob.style.transform = `translateY(${window.scrollY * speed}px)`;
      });
    });
  </script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 1000, easing: 'ease-out-expo', once: true, offset: 50 });

    // Form submission loading states
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('form').forEach(form => {
        const btn = form.querySelector('button[type="submit"]');
        if (btn && !btn.hasAttribute('data-no-loader')) {
          form.addEventListener('submit', function() {
            if (!btn.disabled) {
              btn.disabled = true;
              btn.classList.add('opacity-75', 'cursor-not-allowed');
              if (!btn.querySelector('.spinner')) {
                const spinner = document.createElement('span');
                spinner.className = 'spinner ml-2 inline-block';
                spinner.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
                btn.appendChild(spinner);
              }
            }
          });
        }
      });
    });
  </script>
  {{-- Custom Menu Configuration --}}
  @php
    $menuItems = [
        ['label' => 'Home', 'link' => route('home'), 'ariaLabel' => 'Go to homepage'],
        ['label' => 'Find a Lawyer', 'link' => route('public.search'), 'ariaLabel' => 'Search lawyers'],
    ];
    if (!auth()->check()) {
        $menuItems[] = ['label' => 'Login', 'link' => route('login')];
        $menuItems[] = ['label' => 'Register', 'link' => route('register')];
        $menuItems[] = ['label' => 'Lawyer Registration', 'link' => route('lawyer.register')];
        $menuItems[] = ['label' => 'Dashboard', 'link' => route('dashboard'), 'ariaLabel' => 'Go to dashboard'];
    }
    
    $socialItems = [
        ["label" => "Instagram", "link" => "#"],
        ["label" => "LinkedIn", "link" => "#"],
        ["label" => "Twitter", "link" => "#"]
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
      margin: 2rem auto;
      padding: 0 1rem;
    }

    .auth-card {
      background: rgba(255, 255, 255, 0.4);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(13, 13, 13, 0.1);
      border-radius: 1rem;
      padding: 2rem;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
    }

    .auth-title {
      font-size: 1.75rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .auth-subtitle {
      font-size: 0.875rem;
      color: rgba(13, 13, 13, 0.6);
      margin-bottom: 2rem;
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
    background: #0D0D0D;
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
</body>
</html>
