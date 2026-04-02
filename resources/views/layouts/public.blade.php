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

      <div class="hidden lg:flex items-center gap-12 text-[11px] font-semibold tracking-ultra uppercase text-onyx">
        <a href="{{ route('public.search') }}" class="nav-link">Find a Lawyer</a>
        @auth
          <a href="{{ route('dashboard') }}" class="btn-lux btn-lux-gold !px-8 !py-3">Dashboard</a>
        @else
          <a href="{{ route('login') }}" class="nav-link">Login</a>
          <a href="{{ route('register') }}" class="btn-lux btn-lux-gold !px-8 !py-3 shadow-premium">Join Now</a>
        @endauth
      </div>

      <button id="nav-toggle" class="lg:hidden text-onyx p-2 focus:outline-none" aria-label="Toggle Navigation">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 8h16M4 16h16"/></svg>
      </button>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden lg:hidden fixed inset-0 bg-linen/98 backdrop-blur-3xl z-50 flex flex-col items-center justify-center gap-12 text-center p-10 animate__animated animate__fadeIn">
      <button id="nav-close" class="absolute top-10 right-10 text-onyx">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
      <a href="{{ route('home') }}" class="font-serif text-4xl text-onyx italic mb-4">LegalCounsel</a>
      <a href="{{ route('public.search') }}" class="text-2xl font-serif italic text-onyx-70 hover:text-gold-500">Practice areas</a>
      @auth
        <a href="{{ route('dashboard') }}" class="btn-lux btn-lux-gold w-full max-w-xs">Dashboard</a>
      @else
        <a href="{{ route('login') }}" class="text-2xl font-serif italic text-onyx-70">Sign In</a>
        <a href="{{ route('register') }}" class="btn-lux btn-lux-gold w-full max-w-xs">Get Started</a>
      @endauth
    </div>
  </nav>

  <main id="main-content" tabindex="-1">
    @yield('content')
  </main>

  <footer class="bg-onyx text-white py-32 px-6 lg:px-20 relative overflow-hidden">
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

    // Mobile menu toggle
    const toggle = document.getElementById('nav-toggle');
    const menu = document.getElementById('mobile-menu');
    const close = document.getElementById('nav-close');

    if (toggle && menu) {
      toggle.addEventListener('click', () => {
        menu.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      });
      close.addEventListener('click', () => {
        menu.classList.add('hidden');
        document.body.style.overflow = '';
      });
    }

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
  </script>
  @stack('scripts')
</body>
</html>
