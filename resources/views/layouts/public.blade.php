<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Find elite legal professionals. Connect with verified lawyers for consultations.">
  <title>@yield('title', 'LegalCounsel — Find Your Lawyer')</title>

  <!-- Preconnect for performance -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://unpkg.com">
  <link rel="dns-prefetch" href="https://ui-avatars.com">

  <!-- Preload critical resources -->
  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" as="style">

  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-parchment text-ink-mid font-sans relative">

  <!-- Skip Navigation Link for Accessibility -->
  <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 z-[100] bg-gold text-white px-4 py-2 rounded-full text-sm font-semibold shadow-glow focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2">
    Skip to main content
  </a>

  <!-- Ambient glowing blobs -->
  <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-gold/10 rounded-full blur-[100px] pointer-events-none animate-blob z-[-1]"></div>
  <div class="fixed bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-ink/5 rounded-full blur-[120px] pointer-events-none animate-blob animation-delay-2000 z-[-1]"></div>

  <div id="page-overlay" class="fixed inset-0 bg-ink z-[9999] pointer-events-none opacity-0 transition-opacity duration-300"></div>

  <nav id="main-nav" class="fixed top-0 w-full z-50 transition-all duration-500 bg-transparent px-6 py-4 lg:px-16 border-b border-transparent">
    <div class="max-w-7xl mx-auto flex justify-between items-center relative z-10">
      <a href="{{ route('home') }}" class="font-serif text-xl text-ink font-semibold tracking-wide no-underline flex items-center gap-2">
        <span class="w-8 h-8 rounded-full bg-gradient-to-tr from-gold to-gold-light flex items-center justify-center text-white text-sm shadow-glow">L</span>
        Legal<span class="text-gold">Counsel</span>
      </a>
      <button id="nav-toggle" class="lg:hidden text-ink p-2 rounded-lg hover:bg-gold/10 transition-colors focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2"
              aria-label="Toggle navigation menu"
              aria-expanded="false"
              aria-controls="mobile-menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <span class="sr-only">Menu</span>
      </button>
      <div class="hidden lg:flex items-center gap-8 text-sm font-medium text-ink-mid">
        <a href="{{ route('public.search') }}" class="hover:text-gold transition-colors">Find a Lawyer</a>
        @auth
          <a href="{{ route('dashboard') }}" class="btn-primary">Dashboard</a>
        @else
          <a href="{{ route('login') }}" class="hover:text-gold transition-colors">Login</a>
          <a href="{{ route('register') }}" class="btn-primary">Register</a>
        @endauth
      </div>
    </div>
    <div id="mobile-menu" class="hidden lg:hidden mt-4 flex flex-col gap-4 text-sm font-medium text-ink-mid px-4 py-6 bg-white/95 backdrop-blur-xl border border-white/20 shadow-glass rounded-2xl absolute left-4 right-4 animate__animated animate__fadeInInDown"
         role="dialog"
         aria-modal="true"
         aria-label="Main navigation menu">
      <a href="{{ route('public.search') }}" class="hover:text-gold py-2 border-b border-warm-border text-center focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2 rounded-lg">Find a Lawyer</a>
      @auth
        <a href="{{ route('dashboard') }}" class="btn-primary text-center focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2">Dashboard</a>
      @else
        <a href="{{ route('login') }}" class="text-center py-2 hover:text-gold focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2 rounded-lg">Login</a>
        <a href="{{ route('register') }}" class="btn-primary text-center focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2">Register</a>
      @endauth
    </div>
  </nav>

  <main id="main-content" tabindex="-1">
    @yield('content')
  </main>

  <footer class="bg-ink text-white/65 pt-20 pb-10 px-6 lg:px-16 relative overflow-hidden">
    <!-- Footer glow -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[80%] h-px bg-gradient-to-r from-transparent via-gold/30 to-transparent"></div>
    <div class="absolute bottom-[-50%] left-[-20%] w-[50%] h-[100%] bg-gold/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 relative z-10">
      <div data-aos="fade-up" data-aos-delay="0">
        <div class="flex items-center gap-2 mb-6">
          <span class="w-8 h-8 rounded-full bg-gradient-to-tr from-gold to-gold-light flex items-center justify-center text-white text-sm shadow-glow">L</span>
          <h5 class="font-serif text-white text-xl">LegalCounsel</h5>
        </div>
        <p class="text-sm leading-relaxed text-white/50 max-w-xs">Connecting you with elite legal expertise. Seamlessly book consultations with top-tier professionals.</p>
      </div>
      <div data-aos="fade-up" data-aos-delay="100">
        <h5 class="font-sans text-white text-sm tracking-widest uppercase mb-6 font-semibold">Practice Areas</h5>
        <div class="flex flex-col gap-3">
          <a href="{{ route('public.search', ['service' => 'Criminal']) }}" class="footer-link">Criminal Law</a>
          <a href="{{ route('public.search', ['service' => 'Divorce']) }}" class="footer-link">Divorce</a>
          <a href="{{ route('public.search', ['service' => 'Affidavit']) }}" class="footer-link">Affidavit</a>
          <a href="{{ route('public.search', ['service' => 'Civil']) }}" class="footer-link">Civil Law</a>
        </div>
      </div>
      <div data-aos="fade-up" data-aos-delay="200">
        <h5 class="font-sans text-white text-sm tracking-widest uppercase mb-6 font-semibold">Quick Links</h5>
        <div class="flex flex-col gap-3">
          <a href="{{ route('home') }}" class="footer-link">Home</a>
          <a href="{{ route('public.search') }}" class="footer-link">Find a Lawyer</a>
          <a href="{{ route('register') }}" class="footer-link">Register</a>
        </div>
      </div>
      <div data-aos="fade-up" data-aos-delay="300">
        <h5 class="font-sans text-white text-sm tracking-widest uppercase mb-6 font-semibold">Contact</h5>
        <a href="mailto:info@legalcounsel.com" class="footer-link inline-flex items-center gap-2">
          <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
          info@legalcounsel.com
        </a>
      </div>
    </div>
    <div class="max-w-7xl mx-auto mt-16 pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center text-white/30 text-xs gap-4 relative z-10">
      <p>&copy; {{ date('Y') }} LegalCounsel. All rights reserved.</p>
      <div class="flex gap-4">
        <a href="#" class="hover:text-gold transition-colors">Privacy Policy</a>
        <a href="#" class="hover:text-gold transition-colors">Terms of Service</a>
      </div>
    </div>
  </footer>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    // Initialize AOS animations
    AOS.init({
      duration: 800,
      once: true,
      offset: 50,
      easing: 'ease-out-cubic',
      mirror: false,
    });

    // Glass navbar effect on scroll with debounce for performance
    let lastScrollY = window.scrollY;
    const nav = document.getElementById('main-nav');
    const pageOverlay = document.getElementById('page-overlay');
    const navToggle = document.getElementById('nav-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    let ticking = false;

    function updateNav() {
      const scrollY = window.scrollY;

      if (scrollY > 50) {
        nav.classList.add('glass-nav', 'py-3');
        nav.classList.remove('bg-transparent', 'py-4', 'border-transparent');
      } else {
        nav.classList.remove('glass-nav', 'py-3');
        nav.classList.add('bg-transparent', 'py-4', 'border-transparent');
      }

      // Add border when menu is open
      if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
        nav.classList.add('border-b', 'border-white/20');
      } else {
        nav.classList.remove('border-b', 'border-white/20');
      }

      lastScrollY = scrollY;
      ticking = false;
    }

    window.addEventListener('scroll', function () {
      if (!ticking) {
        window.requestAnimationFrame(updateNav);
        ticking = true;
      }
    });

    // Mobile menu toggle with improved accessibility
    navToggle.addEventListener('click', function (e) {
      e.stopPropagation();
      const isExpanded = navToggle.getAttribute('aria-expanded') === 'true';
      navToggle.setAttribute('aria-expanded', !isExpanded);

      if (mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.remove('hidden');
        mobileMenu.classList.add('flex');
        // Add fade-in animation
        mobileMenu.style.opacity = '0';
        mobileMenu.style.transform = 'translateY(-10px)';
        setTimeout(() => {
          mobileMenu.style.opacity = '1';
          mobileMenu.style.transform = 'translateY(0)';
        }, 10);
        // Focus first menu item for accessibility
        const firstLink = mobileMenu.querySelector('a');
        if (firstLink) firstLink.focus();
      } else {
        mobileMenu.classList.add('hidden');
        mobileMenu.classList.remove('flex');
        navToggle.setAttribute('aria-expanded', 'false');
      }
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function (e) {
      if (!mobileMenu.classList.contains('hidden') &&
          !mobileMenu.contains(e.target) &&
          !navToggle.contains(e.target)) {
        mobileMenu.classList.add('hidden');
        mobileMenu.classList.remove('flex');
        navToggle.setAttribute('aria-expanded', 'false');
      }
    });

    // Close mobile menu when clicking a link
    mobileMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
        mobileMenu.classList.remove('flex');
        navToggle.setAttribute('aria-expanded', 'false');
        navToggle.focus();
      });
    });

    // Close mobile menu on Escape key
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.add('hidden');
        mobileMenu.classList.remove('flex');
        navToggle.setAttribute('aria-expanded', 'false');
        navToggle.focus();
      }
    });

    // Handle window resize - ensure proper menu state
    window.addEventListener('resize', function () {
      if (window.innerWidth >= 1024 && !mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.add('hidden');
        mobileMenu.classList.remove('flex');
        navToggle.setAttribute('aria-expanded', 'false');
      }
    });

    // Page transition effect (optional enhancement)
    document.querySelectorAll('a:not([target="_blank"]):not(.no-transition)').forEach(function (link) {
      link.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href && href !== '#' && !href.startsWith('http') && !href.startsWith('mailto') && !href.startsWith('tel')) {
          // Only apply transition for internal navigation that takes >100ms
          // You can enhance this with a loading spinner
        }
      });
    });

    // Initialize focus visible polyfill behavior
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Tab') {
        document.body.classList.add('keyboard-nav');
      }
    });

    document.addEventListener('mousedown', function () {
      document.body.classList.remove('keyboard-nav');
    });
  </script>
</body>
</html>
