@extends('layouts.public')
@section('title', 'LegalCounsel — Find Your Lawyer')

@section('content')

{{-- Hero --}}
<section class="relative min-h-[100vh] bg-ink flex items-center px-6 lg:px-16 pt-32 pb-20 overflow-hidden">
  <div class="absolute inset-0 bg-hero-pattern opacity-80 z-0"></div>
  <div class="max-w-7xl mx-auto w-full relative z-10 flex flex-col items-center text-center">
    <div class="inline-block px-4 py-1.5 rounded-full bg-gold/10 border border-gold/20 text-gold text-xs font-semibold tracking-widest uppercase mb-8 animate__animated animate__fadeInUp" style="animation-delay:0s">
      <span class="inline-block w-2 h-2 rounded-full bg-gold mr-2 animate-pulse"></span>Elite Legal Network
    </div>
    <h1 class="font-serif text-white text-5xl md:text-7xl lg:text-8xl max-w-4xl leading-tight animate__animated animate__fadeInUp" style="animation-delay:0.1s">
      Find the Right Lawyer, <br><em class="text-gradient">Today</em>
    </h1>
    <p class="text-white/60 text-lg md:text-xl mt-8 max-w-2xl leading-relaxed animate__animated animate__fadeInUp" style="animation-delay:0.3s">
      Seamlessly connect with top-tier legal professionals. Search by specialty and location, and book your secure consultation in minutes.
    </p>
    <div class="mt-12 flex flex-col sm:flex-row gap-4 justify-center animate__animated animate__fadeInUp" style="animation-delay:0.5s">
      <a href="{{ route('public.search') }}" class="btn-primary flex items-center justify-center gap-2">
        Find a Lawyer
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
      </a>
      <a href="#practice-areas" class="btn-ghost !text-white !border-white/30 hover:!bg-white hover:!text-ink flex items-center justify-center">
        Explore Areas
      </a>
    </div>
  </div>
  <!-- Floating decorative elements -->
  <div class="absolute top-[20%] right-[10%] w-64 h-64 bg-gold/10 rounded-full blur-[80px] animate-float"></div>
  <div class="absolute bottom-[10%] left-[10%] w-72 h-72 bg-white/5 rounded-full blur-[100px] animate-float" style="animation-delay: -3s"></div>
</section>

{{-- Service Categories --}}
<section id="practice-areas" class="py-32 px-6 lg:px-16 bg-white relative">
  <div class="max-w-7xl mx-auto">
    <div class="text-center md:text-left mb-16 flex flex-col md:flex-row md:items-end justify-between gap-8">
      <div>
        <div class="w-12 h-1 bg-gold mb-6 mx-auto md:mx-0"></div>
        <p class="text-gold text-xs font-semibold tracking-widest uppercase mb-3" data-aos="fade-up">Practice Areas</p>
        <h2 class="font-serif text-4xl md:text-5xl" data-aos="fade-up" data-aos-delay="50">
          What Do You Need Help With?
        </h2>
      </div>
      <a href="{{ route('public.search') }}" class="text-sm font-semibold text-ink hover:text-gold transition-colors flex items-center justify-center md:justify-start gap-2" data-aos="fade-up" data-aos-delay="100">
        View All Services
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
      </a>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil'] as $index => $service)
      <a href="{{ route('public.search', ['service' => $service]) }}"
         class="group block bg-parchment p-10 rounded-3xl border border-transparent hover:bg-white hover:border-gold/30 hover:shadow-glass transition-all duration-500 relative overflow-hidden"
         data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gold/5 rounded-full blur-2xl group-hover:bg-gold/10 transition-colors"></div>
        <p class="font-serif text-3xl text-ink group-hover:text-gold transition-colors mb-4 relative z-10">{{ $service }}</p>
        <p class="text-xs text-ink-muted font-medium tracking-widest uppercase relative z-10">Law Practice</p>
        
        <div class="mt-12 flex justify-between items-center relative z-10">
          <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm group-hover:scale-110 group-hover:bg-gold transition-all duration-300">
            <svg class="w-4 h-4 text-ink-mid group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </div>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</section>

{{-- Featured Lawyers --}}
<section class="py-32 px-6 lg:px-16 bg-parchment border-t border-warm-border relative overflow-hidden">
  <!-- Soft background blob -->
  <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[80%] h-[80%] bg-gold/5 rounded-full blur-[120px] pointer-events-none"></div>

  <div class="max-w-7xl mx-auto relative z-10">
    <div class="text-center mb-20">
      <div class="w-12 h-1 bg-gold mb-6 mx-auto"></div>
      <p class="text-gold text-xs font-semibold tracking-widest uppercase mb-3" data-aos="fade-up">Our Network</p>
      <h2 class="font-serif text-4xl md:text-5xl" data-aos="fade-up" data-aos-delay="50">
        Featured Legal Professionals
      </h2>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach($featuredLawyers as $lawyer)
      <a href="{{ route('public.lawyer', $lawyer->id) }}"
         class="lawyer-card group bg-white/60 backdrop-blur-sm p-6 lg:p-8"
         data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
        
        <div class="flex items-start justify-between mb-8">
          <div class="w-20 h-20 rounded-2xl overflow-hidden shrink-0 shadow-sm border border-warm-border group-hover:border-gold/30 transition-colors">
            <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=111&color=D4AF37' }}"
                 alt="{{ $lawyer->full_name }}"
                 class="w-full h-full object-cover grayscale-[40%] group-hover:grayscale-0 scale-100 group-hover:scale-110 transition-all duration-500">
          </div>
          <span class="bg-parchment text-ink-mid px-3 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase border border-warm-border group-hover:border-gold group-hover:text-gold transition-colors">
            {{ $lawyer->specialization }}
          </span>
        </div>
        
        <div>
          <h3 class="font-serif text-2xl text-ink font-semibold mb-2 group-hover:text-gold transition-colors">{{ $lawyer->full_name }}</h3>
          <p class="text-sm text-ink-muted flex items-center gap-2 mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            {{ $lawyer->city }}
          </p>
        </div>
        
        <div class="pt-6 border-t border-warm-border flex items-center justify-between">
          <p class="text-[11px] font-semibold tracking-widest uppercase text-ink-mid">Book Consultation</p>
          <div class="w-8 h-8 rounded-full bg-gold-light/10 text-gold flex items-center justify-center group-hover:bg-gold group-hover:text-white transition-colors duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </div>
        </div>
      </a>
      @endforeach
    </div>
    
    <div class="mt-20 text-center" data-aos="fade-up">
      <a href="{{ route('public.search') }}" class="btn-ghost inline-flex items-center gap-2">
        See All Professionals
      </a>
    </div>
  </div>
</section>

@endsection
