@extends('layouts.public')
@section('title', 'Bespoke Legal Excellence')
@section('meta_description', 'Connect with the world\'s most distinguished legal professionals through a seamless, secure, and private digital experience.')

@section('content'){{-- Hero Section: Cinematic Editorial --}}
<section class="relative h-screen flex items-center pt-24 overflow-hidden" id="hero-section">
  <!-- Grainient Canvas Background -->
  <div id="hero-grainient" class="absolute inset-0 z-0"></div>

  <div class="max-w-7xl mx-auto px-6 lg:px-20 w-full relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
      <div class="lg:col-span-8">
        <div class="inline-flex items-center gap-3 px-4 py-2 bg-onyx-5 border border-onyx-5 rounded-full mb-10 hero-badge" style="opacity:0;transform:translateY(20px)">
           <span class="w-1.5 h-1.5 rounded-full bg-gold-500 animate-pulse"></span>
           <span class="text-[10px] font-bold tracking-ultra uppercase">The New Standard in Legal Care</span>
        </div>
        
        @php
            $heroParts = explode('|', $content['hero']->title ?? 'Excellence|Redefined.');
        @endphp
        <h1 class="text-7xl md:text-9xl lg:text-[10rem] leading-[0.85] mb-12" id="hero-headline" aria-label="{{ str_replace('|', ' ', $content['hero']->title ?? 'Excellence Redefined.') }}">
          <span class="hero-word block" style="overflow:hidden"><span class="hero-word-inner" style="display:block">{{ $heroParts[0] ?? 'Excellence' }}</span></span>
          <span class="hero-word block" style="overflow:hidden"><span class="hero-word-inner text-gold-500 italic drop-shadow-sm" style="display:block">{{ $heroParts[1] ?? 'Redefined.' }}</span></span>
        </h1>

        <p class="text-xl md:text-2xl font-light text-onyx-60 max-w-2xl leading-relaxed mb-10 hero-sub" style="opacity:0;transform:translateY(30px)">
          {{ $content['hero']->body ?? 'Connecting you with the world\'s most distinguished legal professionals through a seamless, secure, and private digital experience.' }}
        </p>

        <div class="flex flex-col sm:flex-row gap-6 hero-cta" style="opacity:0;transform:translateY(30px)">
          <a href="{{ route('public.search') }}" class="btn-lux btn-lux-gold group shadow-premium hero-cta-primary">
             <span class="relative z-10 flex items-center gap-3">
                <i data-lucide="scale" class="w-4 h-4 opacity-80"></i>
                <span>Find Counsel</span>
                <i data-lucide="arrow-right" class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform duration-500 ease-expo"></i>
             </span>
          </a>
          <a href="#services" class="btn-lux btn-lux-outline group flex items-center gap-3">
             <i data-lucide="layout-grid" class="w-4 h-4 opacity-60 group-hover:opacity-100 transition-opacity duration-500"></i>
             <span>Explore Services</span>
          </a>
        </div>
      </div>

      {{-- Floating CTA badge (right column) --}}
      <div class="hidden lg:flex lg:col-span-4 items-center justify-center">
        <div class="hero-float-badge relative w-52 h-52" id="hero-float-badge" style="opacity:0">
          <div class="absolute inset-0 rounded-full border border-gold-500/20 animate-spin-slow"></div>
          <div class="absolute inset-4 rounded-full border border-gold-500/10 animate-spin-slow-reverse"></div>
          <a href="{{ route('public.search') }}" class="absolute inset-8 rounded-full bg-gold-500 text-white flex flex-col items-center justify-center text-center group hover:bg-onyx transition-colors duration-500 shadow-premium">
            <span class="text-[9px] font-bold tracking-[0.2em] uppercase block mb-1">Start Here</span>
            <span class="font-serif text-lg italic leading-tight">Book a Consult</span>
            <i data-lucide="chevron-down" class="w-4 h-4 mt-2 group-hover:translate-y-1 transition-transform"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Scroll Indicator -->
  <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-10 hero-scroll-hint" style="opacity:0">
    <div class="flex flex-col items-center gap-4">
      <span class="text-[9px] font-bold tracking-[0.3em] uppercase text-onyx/30">Scroll to Explore</span>
      <div class="w-px h-12 bg-gradient-to-b from-onyx/20 to-transparent"></div>
    </div>
  </div>

  <!-- Decorative Element -->
  <div class="absolute right-[-5%] top-[15%] w-1/3 aspect-square bg-gold-100/30 rounded-full blur-[120px] pointer-events-none parallax-blob" data-speed="0.25"></div>
</section>

{{-- Services Section --}}
<section id="services" class="py-20 md:py-40 px-6 lg:px-20 relative bg-white">
  <div class="max-w-7xl mx-auto">
    <div class="flex flex-col lg:flex-row justify-between items-end mb-32 gap-10">
      <div class="max-w-2xl">
        <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-500 mb-6">Expertise</p>
        @php
            $servicesParts = explode('|', $content['featured_lawyers']->title ?? 'Selected|Practice Areas');
        @endphp
        <h2 class="text-6xl md:text-8xl leading-tight">{{ $servicesParts[0] ?? 'Selected' }} <br> {{ $servicesParts[1] ?? 'Practice Areas' }}</h2>
      </div>
      <p class="text-lg font-light text-onyx-50 max-w-sm mb-4">{{ $content['featured_lawyers']->body ?? 'A curated network of specialists across every major legal discipline.' }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 border-t border-onyx-5">
      @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil'] as $index => $service)
      <a href="{{ route('public.search', ['service' => $service]) }}"
         class="group p-6 md:p-8 border-b md:border-r border-onyx/5 hover:bg-onyx hover:text-white transition-all duration-500 relative overflow-hidden"
         data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
        <span class="text-[10px] font-bold tracking-ultra uppercase text-onyx/30 group-hover:text-gold-500 transition-colors mb-3 block">0{{ $index + 1 }}</span>
        <h3 class="text-2xl md:text-3xl italic mb-4 group-hover:translate-x-1 md:group-hover:translate-x-2 transition-transform duration-500">{{ $service }}</h3>
        <p class="text-xs tracking-widest uppercase opacity-0 group-hover:opacity-100 transition-opacity duration-500 font-semibold text-gold-500 flex items-center gap-2">
          View Practice
          <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
        </p>

        <!-- Hover Icon Decoration -->
        <div class="absolute bottom-[-10%] right-[-10%] w-16 md:w-24 h-16 md:h-24 opacity-0 group-hover:opacity-10 transition-opacity duration-500">
           <i data-lucide="scale" class="w-full h-full text-gold-500"></i>
        </div>
      </a>
      @endforeach

      <!-- Last Empty Slot for "More" -->
      <a href="{{ route('public.search') }}"
         class="group p-6 md:p-8 border-b border-onyx/5 bg-onyx text-white flex flex-col justify-center items-center text-center hover:bg-gold-500 transition-colors duration-500"
         data-aos="fade-up" data-aos-delay="400">
         <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-300 mb-3">Discovery</p>
         <h3 class="text-xl md:text-2xl italic">View All <br> Specialties</h3>
         <i data-lucide="arrow-right" class="w-6 h-6 mt-4 transform group-hover:translate-x-2 transition-transform"></i>
      </a>
    </div>
  </div>
</section>

{{-- Stats Counter Section --}}
<section class="py-12 md:py-24 px-6 lg:px-20 bg-linen relative border-y border-onyx/5">
  <div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12 text-center" data-aos="fade-up" data-aos-delay="100">
      @php
        $statItems = [
            ['label' => 'ELITE LAWYERS', 'value' => $stats['total_lawyers'] ?? 0, 'suffix' => '', 'icon' => 'user-check'],
            ['label' => 'CITIES COVERED', 'value' => $stats['total_cities'] ?? 0, 'suffix' => '+', 'icon' => 'map-pin'],
            ['label' => 'YEARS AVG EXPERIENCE', 'value' => $stats['avg_experience'] ?? 0, 'suffix' => 'YRS', 'icon' => 'award'],
            ['label' => 'CONSULTATIONS', 'value' => $stats['total_appointments'] ?? 0, 'suffix' => '+', 'icon' => 'calendar-check'],
        ];
      @endphp
      @foreach($statItems as $stat)
        <div class="stat-counter" data-target="{{ $stat['value'] }}" data-suffix="{{ $stat['suffix'] }}">
          <div class="flex justify-center mb-4">
            <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5 text-gold-500/50"></i>
          </div>
          <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/40 mb-2">{{ $stat['label'] }}</p>
          <p class="text-4xl md:text-6xl italic text-gold-600">
            <span class="counter-number">0</span><span class="counter-suffix">{{ $stat['suffix'] }}</span>
          </p>
        </div>
      @endforeach
    </div>
  </div>
</section>

@php
  // Features section removed for cleaner editorial flow
@endphp

{{-- Featured Section --}}
<section class="py-20 md:py-40 px-6 lg:px-20 bg-linen relative overflow-hidden">
  <div class="absolute top-0 right-1/2 w-px h-64 bg-gradient-to-b from-onyx/10 to-transparent"></div>

  <div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
      <div>
        <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-500 mb-4" style="opacity:0;transform:translateY(20px)" data-scroll-reveal="true">{{ $content['call_to_action']->body ?? 'Our Inner Circle' }}</p>
        <h2 class="text-6xl md:text-8xl italic leading-none" style="opacity:0;transform:translateY(30px)" data-scroll-reveal="true" data-scroll-delay="0.1">{{ $content['call_to_action']->title ?? 'Distinguished Counsel' }}</h2>
      </div>
      <a href="{{ route('public.search') }}" class="btn-lux btn-lux-outline shrink-0 flex items-center gap-2" style="opacity:0" data-scroll-reveal="true" data-scroll-delay="0.2">
        View All Lawyers
        <i data-lucide="arrow-right" class="w-4 h-4"></i>
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-0 border border-onyx/5" id="featured-lawyers-grid">
      @foreach($featuredLawyers as $lawyer)
      <div class="lawyer-card p-8 border-r border-onyx/5 last:border-r-0 group hover:bg-white transition-colors duration-300 flex flex-col" data-index="{{ $loop->index }}">
        {{-- Avatar --}}
        <div class="flex items-start justify-between mb-8">
          <div class="w-20 h-20 overflow-hidden border border-onyx/10 shrink-0">
            <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name='.urlencode($lawyer->full_name).'&background=0D0D0D&color=D4AF37' }}"
                 alt="{{ $lawyer->full_name }}"
                 class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
          </div>
          <span class="text-[9px] font-bold tracking-widest uppercase px-2 py-1 border border-gold-500/20 text-gold-600 bg-gold-50/50 flex items-center gap-1">
            <i data-lucide="shield-check" class="w-2.5 h-2.5"></i>
            {{ $lawyer->specialization }}
          </span>
        </div>

        {{-- Info --}}
        <div class="flex-1">
          <h3 class="font-serif text-3xl text-onyx leading-tight mb-2 group-hover:text-gold-600 transition-colors duration-300">{{ $lawyer->full_name }}</h3>
          <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/30 mb-4 flex items-center gap-2">
            <i data-lucide="map-pin" class="w-3 h-3"></i>
            {{ $lawyer->city }} 
            <span class="mx-1">•</span>
            <i data-lucide="award" class="w-3 h-3"></i>
            {{ $lawyer->experience_years }} Yrs Experience
          </p>
          <p class="text-sm text-onyx/60 font-light leading-relaxed">
            {{ strlen($lawyer->bio ?? '') > 120 ? substr($lawyer->bio, 0, 120) . '...' : ($lawyer->bio ?? 'Distinguished legal professional providing expert counsel.') }}
          </p>
        </div>

        {{-- Footer --}}
        <div class="mt-8 pt-6 border-t border-onyx/5 flex items-center justify-between">
          <div>
            <p class="text-[9px] font-bold tracking-widest uppercase text-onyx/30 mb-1">Consultation Fee</p>
            <p class="font-serif italic text-gold-600 text-xl flex items-baseline gap-1">
              <span class="text-xs font-sans not-italic text-onyx/30">$</span>{{ number_format($lawyer->consultation_fee ?? 0) }}<span class="text-xs font-sans not-italic text-onyx/30">/hr</span>
            </p>
          </div>
          <a href="{{ route('public.lawyer', $lawyer->slug) }}"
             class="group/btn flex items-center gap-2 text-[10px] font-bold tracking-widest uppercase text-onyx/40 hover:text-onyx transition-colors">
            View Profile
            <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover/btn:translate-x-1 transition-transform"></i>
          </a>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>


{{-- Final CTA --}}
<section class="py-32 px-6 lg:px-20 bg-white text-center relative overflow-hidden">
  <div class="absolute inset-0 mask-edge-soft bg-gold-50/30 -z-10 parallax-blob" data-speed="0.1"></div>
  <div class="max-w-3xl mx-auto relative z-10">
    @php
        $ctaParts = explode('|', $content['footer_about']->title ?? 'Secure your|legacy today.');
    @endphp
    <h2 class="text-7xl md:text-9xl italic leading-none mb-12">{{ $ctaParts[0] ?? 'Secure your' }} <br> <span class="text-gold-500">{{ $ctaParts[1] ?? 'legacy today.' }}</span></h2>
    <p class="text-xl font-light text-onyx-50 mb-16 px-10">{{ $content['footer_about']->body ?? 'Private consultations starting from distinguished professionals.' }}</p>
    <a href="{{ route('register') }}" class="btn-lux btn-lux-gold !px-16 !py-6 text-sm">Create Private Account</a>
  </div>
</section>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Register ScrollTrigger plugin
    gsap.registerPlugin(ScrollTrigger);

    // Background Parallax
    gsap.to('#hero-grainient', {
      y: '15%',
      ease: 'none',
      scrollTrigger: {
        trigger: '#hero-section',
        start: 'top top',
        end: 'bottom top',
        scrub: true
      }
    });

    // ============================================================
    // CINEMATIC HERO — Word-by-word reveal
    // ============================================================
    const heroTl = gsap.timeline({ defaults: { ease: 'power4.out' } });
    heroTl
      .to('.hero-badge', { opacity: 1, y: 0, duration: 0.8, delay: 0.3 })
      .fromTo('.hero-word-inner', {
        y: '110%',
        skewX: -5,
      }, {
        y: '0%',
        skewX: 0,
        duration: 1.1,
        stagger: 0.15,
      }, '-=0.3')
      .to('.hero-sub', { opacity: 1, y: 0, duration: 0.8 }, '-=0.5')
      .to('.hero-cta', { opacity: 1, y: 0, duration: 0.7 }, '-=0.5')
      .to('#hero-float-badge', {
        opacity: 1,
        duration: 1,
        ease: 'power2.out'
      }, '-=0.8')
      .to('.hero-scroll-hint', {
        opacity: 1,
        duration: 1,
        ease: 'power2.out'
      }, '-=0.5');

    // Floating badge continuous float animation
    gsap.to('#hero-float-badge', {
      y: -14,
      duration: 2.5,
      ease: 'sine.inOut',
      repeat: -1,
      yoyo: true,
      delay: 1.5
    });

    // ============================================================
    // SCROLL-TRIGGERED LAWYER CARDS — Staggered fade-slide
    // ============================================================
    const lawyerCards = gsap.utils.toArray('.lawyer-card');
    if (lawyerCards.length > 0) {
      gsap.fromTo(lawyerCards, {
        opacity: 0,
        y: 60,
        filter: 'blur(4px)',
      }, {
        opacity: 1,
        y: 0,
        filter: 'blur(0px)',
        duration: 0.9,
        stagger: 0.18,
        ease: 'power3.out',
        scrollTrigger: {
          trigger: '#featured-lawyers-grid',
          start: 'top 82%',
          toggleActions: 'play none none none',
        }
      });
    }

    // ============================================================
    // SCROLL-REVEAL elements (heading labels and titles)
    // ============================================================
    gsap.utils.toArray('[data-scroll-reveal="true"]').forEach((el, i) => {
      const delay = parseFloat(el.getAttribute('data-scroll-delay')) || 0;
      gsap.to(el, {
        opacity: 1,
        y: 0,
        duration: 1,
        delay,
        ease: 'power3.out',
        scrollTrigger: {
          trigger: el,
          start: 'top 88%',
          toggleActions: 'play none none none',
        }
      });
    });

    // ============================================================
    // Initialize Grainient
    // ============================================================
    const grainientContainer = document.getElementById('hero-grainient');
    if (grainientContainer && window.Grainient) {
      new window.Grainient(grainientContainer, {
        color1: '#D4AF37',
        color2: '#0D0D0D',
        color3: '#F9F7F2',
        timeSpeed: 0.25,
        warpStrength: 1.0,
        warpFrequency: 3.0,
        warpSpeed: 1.5,
        contrast: 1.2,
        saturation: 0.8,
        grainAmount: 0.05
      });
    }

    // ============================================================
    // BounceCards
    // ============================================================
    try {
      const bounceContainer = document.getElementById('bounce-cards-container');
      if (bounceContainer && window.BounceCards && bounceContainer.dataset.images) {
        const images = JSON.parse(bounceContainer.dataset.images);
        if (images && images.length > 0) {
          new window.BounceCards(bounceContainer, {
            images: images,
            containerWidth: 600,
            containerHeight: 600,
            cardWidth: 240,
            cardHeight: 320,
            animationDelay: 0.4,
            animationStagger: 0.1,
            easeType: 'power2.out',
            enableHover: true
          });
        }
      }
    } catch (e) {
      console.debug('BounceCards initialization failed:', e.message);
    }

    // ============================================================
    // GSAP Counter Animation
    // ============================================================
    try {
      const counters = document.querySelectorAll('.stat-counter');
      if (counters.length > 0) {
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              const counter = entry.target;
              const target = parseInt(counter.getAttribute('data-target')) || 0;
              const numberEl = counter.querySelector('.counter-number');
              gsap.to(numberEl, {
                innerText: target,
                duration: 2,
                snap: { innerText: 1 },
                ease: 'power2.out',
                onUpdate: function() {
                  numberEl.innerText = Math.ceil(this.targets()[0].innerText);
                }
              });
              observer.unobserve(counter);
            }
          });
        }, { threshold: 0.5 });
        counters.forEach(counter => observer.observe(counter));
      }
    } catch (e) {
      console.debug('GSAP counter error:', e.message);
    }

    // Re-initialize AOS after dynamic content
    if (typeof AOS !== 'undefined') {
      AOS.refresh();
    }
  });
</script>
@endpush
