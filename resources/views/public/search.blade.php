@extends('layouts.public')
@section('title', 'Find a Lawyer — LegalCounsel')

@section('content')

<div class="pt-40 pb-32 px-6 lg:px-16 relative">
  <!-- Glowing blob for search header -->
  <div class="absolute top-0 right-0 w-[40%] h-[400px] bg-gold/5 rounded-full blur-[120px] pointer-events-none z-0"></div>

  <div class="max-w-7xl mx-auto relative z-10">
    <div class="text-center mb-16">
      <div class="w-12 h-1 bg-gold mb-6 mx-auto"></div>
      <h1 class="font-serif text-5xl md:text-6xl text-ink mb-6" data-aos="fade-up">Find your Legal Guide</h1>
      <p class="text-ink-muted text-lg max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="50">Search our network of verified professionals to find the absolute best match for your specific legal needs.</p>
    </div>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('public.search') }}"
          class="bg-white/60 backdrop-blur-xl p-4 rounded-3xl border border-white/40 shadow-glass flex flex-col md:flex-row gap-4 mb-10 max-w-4xl mx-auto"
          data-aos="fade-up" data-aos-delay="100">
      <div class="relative flex-1">
        <svg class="absolute left-6 top-1/2 -translate-y-1/2 w-5 h-5 text-ink-muted/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        <input type="text" name="city" value="{{ request('city') }}"
               placeholder="City or location..."
               class="search-field !pl-14 !bg-transparent !border-transparent hover:!bg-white/50 focus:!bg-white focus:!border-gold transition-colors">
      </div>
      <div class="w-px h-12 bg-warm-border hidden md:block self-center"></div>
      <div class="relative w-full md:w-64">
        <select name="service" class="search-field !bg-transparent !border-transparent hover:!bg-white/50 focus:!bg-white focus:!border-gold transition-colors appearance-none pr-10">
          <option value="">All Practice Areas</option>
          @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil'] as $service)
            <option value="{{ $service }}" {{ request('service') === $service ? 'selected' : '' }}>
              {{ $service }}
            </option>
          @endforeach
        </select>
        <svg class="absolute right-6 top-1/2 -translate-y-1/2 w-4 h-4 text-ink-muted pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
      </div>
      <button type="submit" class="btn-primary !py-4 md:!px-10 shrink-0 shadow-lg">Search</button>
    </form>

    {{-- Service Tags --}}
    <div class="flex flex-wrap justify-center gap-3 mb-20 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="150">
      @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil'] as $service)
        <span class="service-tag {{ request('service') === $service ? 'active' : '' }}"
              onclick="document.querySelector('[name=service]').value='{{ $service }}'; this.closest('.max-w-7xl').querySelector('form').submit()">
          {{ $service }}
        </span>
      @endforeach
    </div>

    {{-- Results --}}
    @if($lawyers->isEmpty())
      <div class="bg-white rounded-3xl shadow-glass border border-white p-16 text-center max-w-2xl mx-auto" data-aos="fade-up">
        <div class="w-20 h-20 bg-ink/5 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg class="w-8 h-8 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h3 class="font-serif text-2xl text-ink font-semibold mb-3">No Results Found</h3>
        <p class="text-ink-muted">We couldn't find any lawyers matching your exact criteria.<br>Please try adjusting your filters or search terms.</p>
        <a href="{{ route('public.search') }}" class="btn-ghost mt-8 inline-block">Clear Filters</a>
      </div>
    @else
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($lawyers as $lawyer)
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
            <p class="text-[11px] font-semibold tracking-widest uppercase text-ink-mid">View Profile</p>
            <div class="w-8 h-8 rounded-full bg-gold-light/10 text-gold flex items-center justify-center group-hover:bg-gold group-hover:text-white transition-colors duration-300">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
          </div>
        </a>
        @endforeach
      </div>
    @endif
  </div>
</div>
@endsection
