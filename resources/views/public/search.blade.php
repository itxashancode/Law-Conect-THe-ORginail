@extends('layouts.public')
@section('title', 'Find a Lawyer')
@section('meta_description', 'Search our network of elite legal professionals by city and specialization to find the right counsel for your needs.')

@section('content')

{{-- Mobile Filter Sheet Overlay (Alpine.js) --}}
<div x-data="{ filterOpen: false }" @keydown.escape.window="filterOpen = false">

  {{-- Mobile Filter Sheet --}}
  <div x-show="filterOpen" class="fixed inset-0 z-[150] lg:hidden" style="display: none;">
    <div class="absolute inset-0 bg-onyx/50 backdrop-blur-sm" @click="filterOpen = false"></div>
    <div class="absolute left-0 top-0 bottom-0 w-80 bg-white shadow-2xl flex flex-col"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full">
      <div class="flex items-center justify-between p-6 border-b border-onyx/10">
        <h3 class="font-serif text-xl italic text-onyx">Filter Results</h3>
        <button @click="filterOpen = false" class="w-8 h-8 flex items-center justify-center text-onyx/30 hover:text-onyx transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <form method="GET" action="{{ route('public.search') }}" class="flex-1 flex flex-col p-6 gap-6">
        <div>
          <label class="text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-3 block">City or Region</label>
          <input type="text" name="city" value="{{ request('city') }}" placeholder="e.g. New York"
                 class="lux-input w-full">
        </div>
        <div>
          <label class="text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-3 block">Specialization</label>
          <select name="service" class="lux-input w-full !py-[1.1rem]">
            <option value="">All Specialties</option>
            @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil', 'Other'] as $s)
              <option value="{{ $s }}" {{ request('service') === $s ? 'selected' : '' }}>{{ $s }}</option>
            @endforeach
          </select>
        </div>
        <div class="mt-auto space-y-3">
          <button type="submit" class="btn-lux btn-lux-gold w-full">Apply Filters</button>
          <a href="{{ route('public.search') }}" class="btn-lux btn-lux-outline w-full text-center block">Clear All</a>
        </div>
      </form>
    </div>
  </div>

  {{-- Page Header --}}
  <div class="pt-32 pb-10 px-6 lg:px-20 border-b border-onyx/5">
    <div class="max-w-7xl mx-auto">
      <p class="text-[10px] font-bold tracking-widest uppercase text-gold-500 mb-3">Network Directory</p>
      <div class="flex items-end justify-between gap-6">
        <h1 class="font-serif text-6xl md:text-8xl italic leading-none">Find Your Counsel</h1>
        <p class="text-sm font-light text-onyx/50 hidden md:block max-w-xs text-right">
          {{ $lawyers->count() }} practitioner{{ $lawyers->count() !== 1 ? 's' : '' }} in our network
        </p>
      </div>
    </div>
  </div>

  {{-- Sticky Filter Bar (Desktop) + Mobile Trigger --}}
  <div class="sticky top-20 z-40 bg-linen/95 backdrop-blur-md border-b border-onyx/5 py-4 px-6 lg:px-20">
    <div class="max-w-7xl mx-auto flex items-center gap-4">
      {{-- Desktop Filter Form --}}
      <form method="GET" action="{{ route('public.search') }}"
            id="search-form"
            class="hidden lg:flex items-end gap-4 flex-1">
        <div class="flex-1">
          <label class="text-[9px] font-bold tracking-widest uppercase text-onyx/30 mb-1.5 block">Location</label>
          <input type="text" name="city" id="city-input" value="{{ request('city') }}"
                 placeholder="City or region..."
                 class="w-full border border-onyx/10 bg-white/80 py-2.5 px-4 text-sm focus:outline-none focus:ring-1 focus:ring-gold-500 focus:border-gold-500 transition-colors placeholder:text-onyx/30">
        </div>
        <div class="flex-1">
          <label class="text-[9px] font-bold tracking-widest uppercase text-onyx/30 mb-1.5 block">Specialization</label>
          <select name="service" id="service-select"
                  class="w-full border border-onyx/10 bg-white/80 py-2.5 px-4 text-sm focus:outline-none focus:ring-1 focus:ring-gold-500 focus:border-gold-500 transition-colors appearance-none">
            <option value="">All Specialties</option>
            @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil', 'Other'] as $s)
              <option value="{{ $s }}" {{ request('service') === $s ? 'selected' : '' }}>{{ $s }}</option>
            @endforeach
          </select>
        </div>
        <button type="submit" id="search-submit"
                class="btn-lux btn-lux-gold !py-2.5 !px-8 shrink-0">
          Search
        </button>
        @if(request('city') || request('service'))
        <a href="{{ route('public.search') }}"
           class="text-[10px] font-bold tracking-widest uppercase text-onyx/40 hover:text-onyx transition-colors whitespace-nowrap">
          Clear ✕
        </a>
        @endif
      </form>

      {{-- Active filters display (desktop) --}}
      @if(request('city') || request('service'))
      <div class="hidden lg:flex items-center gap-2 ml-4">
        @if(request('city'))
        <span class="text-[9px] font-bold tracking-widest uppercase px-3 py-1.5 border border-gold-500/30 text-gold-600 bg-gold-50">{{ request('city') }}</span>
        @endif
        @if(request('service'))
        <span class="text-[9px] font-bold tracking-widest uppercase px-3 py-1.5 border border-gold-500/30 text-gold-600 bg-gold-50">{{ request('service') }}</span>
        @endif
      </div>
      @endif

      {{-- Mobile Filter Button --}}
      <button @click="filterOpen = true"
              class="lg:hidden flex items-center gap-2 border border-onyx/10 px-4 py-2.5 text-[10px] font-bold tracking-widest uppercase text-onyx/60 hover:text-onyx hover:border-onyx/30 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 4a1 1 0 011-1h16a1 1 0 010 2H4a1 1 0 01-1-1zM6 10a1 1 0 011-1h10a1 1 0 010 2H7a1 1 0 01-1-1zM10 16a1 1 0 011-1h4a1 1 0 010 2h-4a1 1 0 01-1-1z"/>
        </svg>
        Filters
        @if(request('city') || request('service'))
        <span class="w-4 h-4 rounded-full bg-gold-500 text-white text-[8px] flex items-center justify-center">
          {{ (request('city') ? 1 : 0) + (request('service') ? 1 : 0) }}
        </span>
        @endif
      </button>

      <p class="text-[10px] text-onyx/30 uppercase tracking-widest ml-auto lg:hidden">
        {{ $lawyers->count() }} found
      </p>
    </div>
  </div>

  {{-- Results Area --}}
  <div class="px-6 lg:px-20 py-12">
    <div class="max-w-7xl mx-auto">

      {{-- Skeleton Loading (shown on form submit via JS) --}}
      <div id="skeleton-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
        @for($i = 0; $i < 6; $i++)
        <div class="bg-white border border-onyx/5 p-8 animate-pulse">
          <div class="flex gap-4 items-start mb-6">
            <div class="w-20 h-20 bg-onyx/10 shrink-0"></div>
            <div class="flex-1">
              <div class="h-6 bg-onyx/10 mb-3 w-3/4"></div>
              <div class="flex gap-2">
                <div class="h-4 bg-onyx/5 w-16"></div>
                <div class="h-4 bg-onyx/5 w-20"></div>
              </div>
            </div>
          </div>
          <div class="space-y-2 mb-8">
            <div class="h-3 bg-onyx/5 w-full"></div>
            <div class="h-3 bg-onyx/5 w-5/6"></div>
            <div class="h-3 bg-onyx/5 w-4/6"></div>
          </div>
          <div class="flex justify-between items-center pt-6 border-t border-onyx/5">
            <div class="h-6 bg-onyx/10 w-20"></div>
            <div class="h-9 bg-onyx/10 w-24"></div>
          </div>
        </div>
        @endfor
      </div>

      {{-- Empty State --}}
      @if($lawyers->isEmpty())
      <div class="py-24 text-center" id="empty-state">
        {{-- Illustration --}}
        <div class="w-24 h-24 mx-auto mb-8 border-2 border-onyx/10 rounded-full flex items-center justify-center">
          <svg class="w-10 h-10 text-onyx/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </div>
        <h3 class="font-serif text-4xl italic text-onyx/40 mb-4">No lawyers found</h3>
        <p class="text-sm font-light text-onyx/40 mb-2">
          @if(request('city') && request('service'))
            No <strong>{{ request('service') }}</strong> law practitioners found in <strong>{{ request('city') }}</strong>.
          @elseif(request('city'))
            No practitioners found in <strong>{{ request('city') }}</strong>.
          @elseif(request('service'))
            No <strong>{{ request('service') }}</strong> law specialists found.
          @else
            Our network is currently empty.
          @endif
        </p>
        <p class="text-sm text-onyx/30 mb-10">Try broadening your search criteria.</p>
        <a href="{{ route('public.search') }}" class="btn-lux btn-lux-outline">
          Clear Filters &amp; Show All
        </a>
      </div>

      @else
      {{-- Results Grid --}}
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="search-results-grid">
        @foreach($lawyers as $lawyer)
        <div class="search-card bg-white border border-onyx/5 p-8 flex flex-col group hover:shadow-lg transition-all duration-300"
             style="opacity: 0; transform: translateY(20px);">
          {{-- Header: Avatar + Name + Badges --}}
          <div class="flex gap-5 items-start mb-6">
            <div class="w-16 h-16 shrink-0 border border-onyx/10 overflow-hidden">
              <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name='.urlencode($lawyer->full_name).'&background=0D0D0D&color=D4AF37' }}"
                   alt="{{ $lawyer->full_name }}"
                   class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
            </div>
            <div class="flex-1 min-w-0">
              <h3 class="font-serif text-2xl text-onyx leading-tight mb-2 group-hover:text-gold-600 transition-colors duration-300 truncate">{{ $lawyer->full_name }}</h3>
              <div class="flex flex-wrap gap-1.5">
                <span class="text-[8px] font-bold tracking-widest uppercase px-2 py-0.5 border border-onyx/10 text-onyx/50">{{ $lawyer->specialization }}</span>
                <span class="text-[8px] font-bold tracking-widest uppercase px-2 py-0.5 border border-gold-500/20 text-gold-600 bg-gold-50">{{ $lawyer->city }}</span>
                <span class="text-[8px] font-bold tracking-widest uppercase px-2 py-0.5 border border-onyx/5 text-onyx/30">{{ $lawyer->experience_years }}yr exp</span>
              </div>
            </div>
          </div>

          {{-- Bio --}}
          <p class="text-sm font-light text-onyx/60 leading-relaxed flex-1 mb-6">
            {{ strlen($lawyer->bio ?? '') > 130 ? substr($lawyer->bio, 0, 130) . '...' : ($lawyer->bio ?? 'Distinguished legal professional providing expert counsel and strategic representation.') }}
          </p>

          {{-- Footer --}}
          <div class="flex items-center justify-between pt-5 border-t border-onyx/5">
            <div>
              <p class="text-[8px] font-bold tracking-widest uppercase text-onyx/30 mb-0.5">Rate</p>
              <p class="font-serif italic text-gold-600 text-xl">${{ number_format($lawyer->consultation_fee ?? 0) }}<span class="text-xs font-sans not-italic text-onyx/30">/hr</span></p>
            </div>
            <a href="{{ route('public.lawyer', $lawyer->slug) }}"
               class="group/btn flex items-center gap-2 border border-onyx/10 px-4 py-2 text-[10px] font-bold tracking-widest uppercase text-onyx/50 hover:bg-onyx hover:text-white hover:border-onyx transition-all duration-200">
              View Profile
              <svg class="w-3 h-3 group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </a>
          </div>
        </div>
        @endforeach
      </div>
      @endif

    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  gsap.registerPlugin(ScrollTrigger);

  // Staggered card reveal
  const cards = document.querySelectorAll('.search-card');
  if (cards.length > 0) {
    gsap.to(cards, {
      opacity: 1,
      y: 0,
      duration: 0.5,
      stagger: { amount: 0.6, from: 'start', ease: 'power2.out' },
      ease: 'power3.out',
      delay: 0.1,
    });
  }

  // Show skeletons on form submit
  const form = document.getElementById('search-form');
  const grid = document.getElementById('search-results-grid');
  const skeleton = document.getElementById('skeleton-grid');
  const empty = document.getElementById('empty-state');

  if (form && skeleton) {
    form.addEventListener('submit', () => {
      if (grid) grid.style.display = 'none';
      if (empty) empty.style.display = 'none';
      skeleton.classList.remove('hidden');
    });
  }

  // Auto-submit on specialty change (desktop)
  const serviceSelect = document.getElementById('service-select');
  if (serviceSelect) {
    serviceSelect.addEventListener('change', () => {
      if (form) form.submit();
    });
  }
});
</script>
@endpush
