<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'LegalCounsel — Find Your Lawyer')</title>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-parchment text-ink-mid font-sans">

  <div id="page-overlay" class="fixed inset-0 bg-ink z-[9999] pointer-events-none opacity-0 transition-opacity duration-300"></div>

  <nav id="main-nav" class="fixed top-0 w-full z-50 transition-all duration-300 bg-transparent px-6 py-5 lg:px-16">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
      <a href="{{ route('home') }}" class="font-serif text-xl text-ink no-underline">
        Legal<span class="text-gold">Counsel</span>
      </a>
      <button id="nav-toggle" class="lg:hidden text-ink">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
      <div class="hidden lg:flex items-center gap-8 text-sm text-ink-mid">
        <a href="{{ route('public.search') }}" class="hover:text-gold transition-colors">Find a Lawyer</a>
        @auth
          <a href="{{ route('dashboard') }}" class="btn-primary">Dashboard</a>
        @else
          <a href="{{ route('login') }}" class="hover:text-gold transition-colors">Login</a>
          <a href="{{ route('register') }}" class="btn-primary">Register</a>
        @endauth
      </div>
    </div>
    <div id="mobile-menu" class="hidden lg:hidden mt-4 flex flex-col gap-4 text-sm text-ink-mid px-2 pb-4 bg-warm-surface border-t border-warm-border">
      <a href="{{ route('public.search') }}" class="pt-3 hover:text-gold">Find a Lawyer</a>
      @auth
        <a href="{{ route('dashboard') }}" class="btn-primary text-center">Dashboard</a>
      @else
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}" class="btn-primary text-center">Register</a>
      @endauth
    </div>
  </nav>

  <main>
    @yield('content')
  </main>

  <footer class="bg-ink text-white/65 pt-20 pb-10 px-6 lg:px-16">
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
      <div data-aos="fade-up" data-aos-delay="0">
        <div class="w-10 h-0.5 bg-gold mb-4"></div>
        <h5 class="font-serif text-white text-lg mb-3">LegalCounsel</h5>
        <p class="text-sm leading-loose">Connecting you with the right legal expertise.</p>
      </div>
      <div data-aos="fade-up" data-aos-delay="100">
        <div class="w-10 h-0.5 bg-gold mb-4"></div>
        <h5 class="font-serif text-white text-lg mb-3">Practice Areas</h5>
        <a href="{{ route('public.search', ['service' => 'Criminal']) }}" class="footer-link">Criminal Law</a>
        <a href="{{ route('public.search', ['service' => 'Divorce']) }}" class="footer-link">Divorce</a>
        <a href="{{ route('public.search', ['service' => 'Affidavit']) }}" class="footer-link">Affidavit</a>
        <a href="{{ route('public.search', ['service' => 'Civil']) }}" class="footer-link">Civil Law</a>
      </div>
      <div data-aos="fade-up" data-aos-delay="200">
        <div class="w-10 h-0.5 bg-gold mb-4"></div>
        <h5 class="font-serif text-white text-lg mb-3">Quick Links</h5>
        <a href="{{ route('home') }}" class="footer-link">Home</a>
        <a href="{{ route('public.search') }}" class="footer-link">Find a Lawyer</a>
        <a href="{{ route('register') }}" class="footer-link">Register</a>
      </div>
      <div data-aos="fade-up" data-aos-delay="300">
        <div class="w-10 h-0.5 bg-gold mb-4"></div>
        <h5 class="font-serif text-white text-lg mb-3">Contact</h5>
        <a href="mailto:info@legalcounsel.com" class="footer-link">info@legalcounsel.com</a>
      </div>
    </div>
    <div class="max-w-7xl mx-auto mt-12 pt-6 border-t border-white/10 text-center text-white/30 text-xs">
      &copy; {{ date('Y') }} LegalCounsel. All rights reserved.
    </div>
  </footer>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 700, once: true, offset: 80, easing: 'ease-out-cubic' });

    window.addEventListener('scroll', function () {
      const nav = document.getElementById('main-nav');
      if (window.scrollY > 80) {
        nav.classList.add('bg-warm-surface', 'shadow-sm');
        nav.classList.remove('bg-transparent');
      } else {
        nav.classList.remove('bg-warm-surface', 'shadow-sm');
        nav.classList.add('bg-transparent');
      }
    });

    document.getElementById('nav-toggle').addEventListener('click', function () {
      document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    document.querySelectorAll('a:not([target="_blank"])').forEach(function (link) {
      link.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href && href !== '#' && !href.startsWith('http')) {
          e.preventDefault();
          document.getElementById('page-overlay').style.opacity = '1';
          setTimeout(() => { window.location.href = href; }, 280);
        }
      });
    });

    document.querySelectorAll('.service-tag').forEach(function (tag) {
      tag.addEventListener('click', function () {
        document.querySelectorAll('.service-tag').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
      });
    });
  </script>
</body>
</html>
