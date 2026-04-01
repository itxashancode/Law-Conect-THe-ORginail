@extends('layouts.public')
@section('title', 'LegalCounsel — Find Your Lawyer')

@section('content')

{{-- Hero --}}
<section class="min-h-screen bg-ink flex items-center px-6 lg:px-16 pt-24">
  <div class="max-w-7xl mx-auto w-full">
    <p class="text-gold text-xs tracking-widest uppercase mb-6 animate__animated animate__fadeInUp" style="animation-delay:0s">
      Legal Services Platform
    </p>
    <h1 class="font-serif text-white text-4xl md:text-6xl lg:text-7xl max-w-3xl leading-tight animate__animated animate__fadeInUp" style="animation-delay:0.1s">
      Find the Right Lawyer, <em>Today</em>
    </h1>
    <p class="text-white/60 text-lg mt-6 max-w-xl animate__animated animate__fadeInUp" style="animation-delay:0.3s">
      Search by specialty and location. Book your consultation in minutes.
    </p>
    <a href="{{ route('public.search') }}" class="btn-primary mt-10 inline-block animate__animated animate__fadeInUp" style="animation-delay:0.5s">
      Find a Lawyer
    </a>
  </div>
</section>

{{-- Service Categories --}}
<section class="py-24 px-6 lg:px-16 bg-parchment">
  <div class="max-w-7xl mx-auto">
    <p class="text-gold text-xs tracking-widest uppercase mb-3" data-aos="fade-up">Practice Areas</p>
    <h2 class="font-serif text-3xl md:text-4xl mb-12" data-aos="fade-up" data-aos-delay="50">
      What Do You Need Help With?
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil'] as $index => $service)
      <a href="{{ route('public.search', ['service' => $service]) }}"
         class="block border border-warm-border p-8 transition-all duration-300 hover:-translate-y-1 hover:border-gold group"
         data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
        <p class="font-serif text-2xl text-ink group-hover:text-gold transition-colors">{{ $service }}</p>
        <p class="text-xs text-ink-muted mt-2 tracking-widest uppercase">Law</p>
      </a>
      @endforeach
    </div>
  </div>
</section>

{{-- Featured Lawyers --}}
<section class="py-24 px-6 lg:px-16 bg-warm-surface">
  <div class="max-w-7xl mx-auto">
    <p class="text-gold text-xs tracking-widest uppercase mb-3" data-aos="fade-up">Our Lawyers</p>
    <h2 class="font-serif text-3xl md:text-4xl mb-12" data-aos="fade-up" data-aos-delay="50">
      Featured Legal Professionals
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($featuredLawyers as $lawyer)
      <a href="{{ route('public.lawyer', $lawyer->id) }}"
         class="lawyer-card p-6 group"
         data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-14 h-14 overflow-hidden shrink-0">
            <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=1A1A1A&color=B8860B' }}"
                 alt="{{ $lawyer->full_name }}"
                 class="w-full h-full object-cover grayscale-[25%] group-hover:grayscale-0 scale-100 group-hover:scale-105 transition-all duration-400">
          </div>
          <div>
            <p class="font-serif text-ink font-semibold">{{ $lawyer->full_name }}</p>
            <p class="text-xs text-gold tracking-widest uppercase mt-0.5">{{ $lawyer->specialization }}</p>
          </div>
        </div>
        <p class="text-sm text-ink-mid">{{ $lawyer->city }}</p>
        <p class="text-xs mt-4 tracking-wide uppercase text-gold">View Profile →</p>
      </a>
      @endforeach
    </div>
  </div>
</section>

@endsection
