@extends('layouts.public')
@section('title', 'LegalCounsel — Bespoke Legal Excellence')

@section('content')

{{-- Hero Section: Editorial & Bold --}}
<section class="relative min-h-[70vh] flex items-center pt-16 overflow-hidden">
  <!-- Grainient Canvas Background -->
  <div id="hero-grainient" class="absolute inset-0 z-0"></div>

  <div class="max-w-7xl mx-auto px-6 lg:px-20 w-full relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
      <div class="lg:col-span-8">
        <div class="inline-flex items-center gap-3 px-4 py-2 bg-onyx-5 border border-onyx-5 rounded-full mb-10 translate-y-10 opacity-0 animate-reveal">
           <span class="w-1.5 h-1.5 rounded-full bg-gold-500 animate-pulse"></span>
           <span class="text-[10px] font-bold tracking-ultra uppercase">The New Standard in Legal Care</span>
        </div>
        
        <h1 class="text-7xl md:text-9xl lg:text-[10rem] leading-[0.85] mb-12 opacity-0 animate-reveal animation-delay-200">
           Excellence <br>
           <span class="text-gold-500 italic drop-shadow-sm">Redefined.</span>
        </h1>

        <p class="text-xl md:text-2xl font-light text-onyx-60 max-w-2xl leading-relaxed mb-16 opacity-0 animate-reveal animation-delay-400">
          Connecting you with the world’s most distinguished legal professionals through a seamless, secure, and private digital experience.
        </p>

        <div class="flex flex-col sm:flex-row gap-6 opacity-0 animate-reveal animation-delay-600">
          <a href="{{ route('public.search') }}" class="btn-lux btn-lux-gold shadow-premium">
             Find Counsel
          </a>
          <a href="#services" class="btn-lux btn-lux-outline">
             Explore Services
          </a>
        </div>
      </div>
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
        <h2 class="text-6xl md:text-8xl leading-tight">Selected <br> Practice Areas</h2>
      </div>
      <p class="text-lg font-light text-onyx-50 max-w-sm mb-4">A curated network of specialists across every major legal discipline, ensuring you receive focused, world-class advice.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 border-t border-onyx-5">
      @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil'] as $index => $service)
      <a href="{{ route('public.search', ['service' => $service]) }}"
         class="group p-6 md:p-8 border-b md:border-r border-onyx/5 hover:bg-onyx hover:text-white transition-all duration-500 relative overflow-hidden"
         data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
        <span class="text-[10px] font-bold tracking-ultra uppercase text-onyx/30 group-hover:text-gold-500 transition-colors mb-3 block">0{{ $index + 1 }}</span>
        <h3 class="text-2xl md:text-3xl italic mb-4 group-hover:translate-x-1 md:group-hover:translate-x-2 transition-transform duration-500">{{ $service }}</h3>
        <p class="text-xs tracking-widest uppercase opacity-0 group-hover:opacity-100 transition-opacity duration-500 font-semibold text-gold-500">View Practice</p>

        <!-- Hover SVG Decoration -->
        <div class="absolute bottom-[-10%] right-[-10%] w-16 md:w-24 h-16 md:h-24 opacity-0 group-hover:opacity-10 transition-opacity duration-500">
           <svg class="w-full h-full text-gold-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 12l10 10 10-10L12 2z"/></svg>
        </div>
      </a>
      @endforeach

      <!-- Last Empty Slot for "More" -->
      <a href="{{ route('public.search') }}"
         class="group p-6 md:p-8 border-b border-onyx/5 bg-onyx text-white flex flex-col justify-center items-center text-center hover:bg-gold-500 transition-colors duration-500"
         data-aos="fade-up" data-aos-delay="400">
         <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-300 mb-3">Discovery</p>
         <h3 class="text-xl md:text-2xl italic">View All <br> Specialties</h3>
         <svg class="w-6 h-6 mt-4 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
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
            ['label' => 'ELITE LAWYERS', 'value' => $stats['total_lawyers'] ?? 0, 'suffix' => ''],
            ['label' => 'CITIES COVERED', 'value' => $stats['total_cities'] ?? 0, 'suffix' => '+'],
            ['label' => 'YEARS AVG EXPERIENCE', 'value' => $stats['avg_experience'] ?? 0, 'suffix' => 'YRS'],
            ['label' => 'CONSULTATIONS', 'value' => $stats['total_appointments'] ?? 0, 'suffix' => '+'],
        ];
      @endphp
      @foreach($statItems as $stat)
        <div class="stat-counter" data-target="{{ $stat['value'] }}" data-suffix="{{ $stat['suffix'] }}">
          <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/40 mb-4">{{ $stat['label'] }}</p>
          <p class="text-4xl md:text-6xl italic text-gold-600">
            <span class="counter-number">0</span><span class="counter-suffix">{{ $stat['suffix'] }}</span>
          </p>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- BounceCards Featured Attorneys --}}
<section class="py-20 md:py-40 px-6 lg:px-20 bg-white relative overflow-hidden">
  <div class="max-w-7xl mx-auto">
    <div class="text-center mb-20" data-aos="fade-up">
      <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-500 mb-4">Exclusive Network</p>
      <h2 class="font-serif text-6xl md:text-8xl text-onyx">Featured Attorneys</h2>
    </div>
    <div id="bounce-cards-container"
         class="flex justify-center py-10"
         data-aos="fade-up"
         data-aos-delay="200"
         data-images='@json($featuredLawyers->map(function($lawyer) {
             return $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=0D0D0D&color=D4AF37&size=400';
         })->toArray())'>
    </div>
  </div>
</section>

{{-- Featured Section --}}
<section class="py-20 md:py-40 px-6 lg:px-20 bg-linen relative overflow-hidden">
  <div class="absolute top-0 right-1/2 w-px h-64 bg-gradient-to-b from-onyx/10 to-transparent"></div>

  <div class="max-w-7xl mx-auto">
    <div class="text-center mb-32">
       <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-500 mb-6">Our Inner Circle</p>
       <h2 class="text-6xl md:text-8xl italic">Distinguished Counsel</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-16">
      @foreach($featuredLawyers as $lawyer)
      <div class="group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
        <a href="{{ route('public.lawyer', $lawyer->id) }}" class="block relative overflow-hidden aspect-[4/5] mb-8 bespoke-card !p-0 border-0">
          <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=0D0D0D&color=D4AF37&size=512' }}" 
               alt="{{ $lawyer->full_name }}" 
               class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-105">
          <div class="absolute inset-0 bg-onyx-20 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
          <div class="absolute bottom-8 left-8 right-8 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-700">
             <span class="btn-lux btn-lux-gold w-full !py-3">Book Private Session</span>
          </div>
        </a>
        <div class="flex justify-between items-start">
           <div>
             <h3 class="text-3xl italic mb-2">{{ $lawyer->full_name }}</h3>
             <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40">{{ $lawyer->specialization }} — {{ $lawyer->city }}</p>
           </div>
           <span class="font-serif italic text-gold-600 text-2xl">{{ $lawyer->experience_years }}Yrs</span>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- Final CTA --}}
<section class="py-60 px-6 lg:px-20 bg-white text-center relative overflow-hidden">
  <div class="absolute inset-0 mask-edge-soft bg-gold-50/30 -z-10 parallax-blob" data-speed="0.1"></div>
  <div class="max-w-3xl mx-auto relative z-10">
    <h2 class="text-7xl md:text-9xl italic leading-none mb-12">Secure your <br> <span class="text-gold-500">legacy today.</span></h2>
    <p class="text-xl font-light text-onyx-50 mb-16 px-10">Private consultations starting from distinguished professionals across the nation.</p>
    <a href="{{ route('register') }}" class="btn-lux btn-lux-gold !px-16 !py-6 text-sm">Create Private Account</a>
  </div>
</section>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize Grainient
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

    // Initialize BounceCards (only if images present)
    try {
      const bounceContainer = document.getElementById('bounce-cards-container');
      if (bounceContainer && window.BounceCards && bounceContainer.dataset.images) {
        const images = JSON.parse(bounceContainer.dataset.images);
        if (images && images.length > 0) {
          new window.BounceCards(bounceContainer, {
            images: images,
            containerWidth: 400,
            containerHeight: 400,
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

    // GSAP Counter Animation
    try {
      if (typeof gsap !== 'undefined') {
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
                  ease: "power2.out",
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
