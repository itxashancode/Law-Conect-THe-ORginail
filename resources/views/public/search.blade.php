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
         <button type="submit" id="search-submit" class="btn-lux btn-lux-gold !px-20 shadow-premium">
            Apply Filters
         </button>
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
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-20 border-t border-onyx-5 pt-20">
        @foreach($lawyers as $lawyer)
        <div class="group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
          <a href="{{ route('public.lawyer', $lawyer->id) }}" class="block relative overflow-hidden aspect-[4/5] mb-8 bespoke-card !p-0 border-0">
            <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=0D0D0D&color=D4AF37&size=512' }}"
                 alt="{{ $lawyer->full_name }}"
                 class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-105">
            <div class="absolute inset-0 bg-onyx-20 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            <div class="absolute bottom-8 left-8 right-8 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-700">
               <span class="btn-lux btn-lux-gold w-full !py-3">Direct Interview</span>
            </div>
          </a>
          <div class="flex justify-between items-start">
             <div>
               <h3 class="text-3xl italic mb-2">{{ $lawyer->full_name }}</h3>
               <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40">{{ $lawyer->specialization }} — {{ $lawyer->city }}</p>
             </div>
             <span class="font-serif italic text-gold-600 text-2xl">${{ number_format($lawyer->consultation_fee ?? 0, 0) }}</span>
          </div>
        </div>
        @endforeach
      </div>
    @endif
  </div>
</div>

@endsection
