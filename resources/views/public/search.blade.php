@extends('layouts.public')
@section('title', 'Find a Lawyer — LegalCounsel')

@section('content')

<div class="pt-60 pb-40 px-6 lg:px-20 relative min-h-screen">
  <!-- Subtle gold wash background -->
  <div class="absolute top-0 right-0 w-[50%] h-[600px] bg-gold-100/20 rounded-full blur-[150px] pointer-events-none z-0"></div>

  <div class="max-w-7xl mx-auto relative z-10">
    <div class="text-center mb-32">
      <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-500 mb-8 underline decoration-gold-500/30 underline-offset-8">Direct Access</p>
      <h1 class="text-7xl md:text-9xl italic leading-none mb-10">Find Your counsel.</h1>
      <p class="text-xl font-light text-onyx-50 max-w-2xl mx-auto leading-relaxed">Filter through our elite network of legal professionals by location and specialty.</p>
    </div>

    {{-- Luxury Search Form --}}
    <form method="GET" action="{{ route('public.search') }}"
          id="search-form"
          class="max-w-5xl mx-auto bg-white border border-onyx-[0.03] p-10 bespoke-card mb-20">
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-end">
        <div>
           <label for="city-input" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-4 block">Selection by Location</label>
           <input type="text" id="city-input" name="city" value="{{ request('city') }}" 
                  placeholder="ENTER CITY OR REGION"
                  class="lux-input">
        </div>

        <div>
           <label for="service-select" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-4 block">Selection by Expertise</label>
           <select name="service" id="service-select" class="lux-input !py-[1.15rem]">
              <option value="">ALL SPECIALTIES</option>
              @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil'] as $service)
                <option value="{{ $service }}" {{ request('service') === $service ? 'selected' : '' }}>
                  {{ strtoupper($service) }}
                </option>
              @endforeach
           </select>
        </div>
      </div>

      <div class="mt-16 flex justify-center">
         <x-magnetic-button>
            <button type="submit" id="search-submit" class="btn-lux btn-lux-gold !px-20 shadow-premium">
               Apply Filters
            </button>
         </x-magnetic-button>
      </div>
    </form>

    {{-- Results Section --}}
    @if($lawyers->isEmpty())
      <div class="py-32 text-center border-t border-onyx-5">
        <h3 class="text-5xl italic text-onyx-30 mb-8">No results found.</h3>
        <p class="text-onyx-50 font-light mb-12">Adjust your filters or return to our full global network.</p>
        <a href="{{ route('public.search') }}" class="btn-lux btn-lux-outline">Reset All Filters</a>
      </div>
    @else
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 pt-10" id="search-results-grid">
        @foreach($lawyers as $lawyer)
        <x-card class="search-anim-item flex flex-col h-full" style="opacity:0;transform:translateY(30px)">
          <div class="flex gap-6 items-start mb-8">
            <div class="w-20 h-20 shrink-0 border border-onyx/10 overflow-hidden">
              <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=0D0D0D&color=D4AF37' }}"
                   alt="{{ $lawyer->full_name }}" class="h-full w-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
            </div>
            <div>
              <h3 class="font-serif text-3xl text-onyx leading-tight mb-3 group-hover:text-gold-600 transition-colors">{{ $lawyer->full_name }}</h3>
              <div class="flex flex-wrap gap-2">
                <span class="text-[9px] font-bold tracking-ultra uppercase px-2 py-0.5 border border-onyx/10 text-onyx/40">{{ $lawyer->specialization }}</span>
                <span class="text-[9px] font-bold tracking-ultra uppercase px-2 py-0.5 border border-gold-500/20 text-gold-600 bg-gold-500/5">{{ $lawyer->city }}</span>
              </div>
            </div>
          </div>

          <p class="text-[13px] font-light text-onyx/60 leading-relaxed mb-10 flex-1">
            {{ strlen($lawyer->bio ?? '') > 140 ? substr($lawyer->bio, 0, 140) . '...' : ($lawyer->bio ?? 'Distinguished legal professional providing expert counsel and strategic representation.') }}
          </p>

          <div class="flex items-center justify-between pt-6 border-t border-onyx/5">
            <div>
               <p class="text-[9px] font-bold tracking-ultra text-onyx/30 uppercase mb-1">Honorable Rate</p>
               <span class="font-serif italic text-gold-600 text-2xl">${{ number_format($lawyer->consultation_fee ?? 0, 0) }} <span class="text-xs font-sans not-italic text-onyx/30">/HR</span></span>
            </div>
            <a href="{{ route('public.lawyer', $lawyer->id) }}" class="btn-lux btn-lux-outline !px-6 !py-3">Consult</a>
          </div>
        </x-card>
        @endforeach
      </div>
    @endif
  </div>
</div>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    gsap.registerPlugin(ScrollTrigger);

    // ============================================================
    // SEARCH RESULTS — Staggered fade-in
    // ============================================================
    const searchCards = gsap.utils.toArray('.search-anim-item');
    if (searchCards.length > 0) {
      gsap.to(searchCards, {
        opacity: 1,
        y: 0,
        duration: 0.6,
        stagger: {
          amount: 0.5,
          from: 'start',
          ease: 'power2.out'
        },
        ease: 'power3.out',
        delay: 0.2
      });
    }
    // ============================================================
    // SKELETON LOADING STATE
    // ============================================================
    const searchForm = document.getElementById('search-form');
    const searchGrid = document.getElementById('search-results-grid');
    if (searchForm && searchGrid) {
      searchForm.addEventListener('submit', () => {
        const skeletonHtml = Array(6).fill(`
          <div class="shad-card p-6 flex flex-col h-full">
            <div class="flex gap-4 items-start mb-4">
              <div class="shad-skeleton shad-avatar h-16 w-16"></div>
              <div class="flex-1 mt-1 space-y-3">
                <div class="shad-skeleton h-6 w-3/4 rounded"></div>
                <div class="flex gap-2">
                  <div class="shad-skeleton h-5 w-16 rounded-full"></div>
                  <div class="shad-skeleton h-5 w-24 rounded-full"></div>
                </div>
              </div>
            </div>
            <div class="flex-1 space-y-2 mt-6">
               <div class="shad-skeleton h-3 w-full rounded"></div>
               <div class="shad-skeleton h-3 w-5/6 rounded"></div>
               <div class="shad-skeleton h-3 w-4/6 rounded"></div>
            </div>
            <div class="flex justify-between items-center mt-6 pt-4 border-t border-onyx/5">
               <div class="shad-skeleton h-6 w-20 rounded"></div>
               <div class="shad-skeleton h-8 w-20 rounded"></div>
            </div>
          </div>
        `).join('');
        
        // Instant visual feedback before the page transition kicks in
        searchGrid.innerHTML = skeletonHtml;
      });
    }
  });
</script>
@endpush
