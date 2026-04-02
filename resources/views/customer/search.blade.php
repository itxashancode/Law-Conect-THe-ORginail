@extends('layouts.customer')
@section('title', 'Find a Lawyer — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <h1 class="font-serif text-6xl text-onyx mb-12">Find a Lawyer</h1>

  {{-- Search Form --}}
  <form method="GET" action="{{ route('customer.search') }}" class="mb-16">
    <div class="flex flex-col md:flex-row gap-4">
      <input type="text" name="city" value="{{ request('city') }}" placeholder="City or location..." class="lux-input md:flex-1">
      <select name="service" class="lux-input md:w-64">
        <option value="">All Practice Areas</option>
        @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil'] as $service)
          <option value="{{ $service }}" {{ request('service') === $service ? 'selected' : '' }}>{{ $service }}</option>
        @endforeach
      </select>
      <button type="submit" class="btn-lux btn-lux-gold">Search</button>
    </div>
  </form>

  {{-- Results --}}
  @if($lawyers->isEmpty())
    <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-16 text-center bespoke-card">
      <svg class="w-16 h-16 mx-auto text-onyx/20 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
      </svg>
      <p class="font-serif text-2xl text-onyx mb-2">No lawyers found</p>
      <p class="text-onyx/60 mb-8">Try adjusting your search filters to find the right counsel.</p>
    </div>
  @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach($lawyers as $lawyer)
      <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 overflow-hidden hover:shadow-luxury hover:-translate-y-2 transition-all duration-700 bespoke-card group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
        <div class="aspect-square">
          <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=0D0D0D&color=D4AF37&size=512' }}"
               alt="{{ $lawyer->full_name }}"
               class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0">
        </div>
        <div class="p-8">
          <h3 class="font-serif text-2xl italic text-onyx mb-2">{{ $lawyer->full_name }}</h3>
          <p class="text-xs tracking-ultra uppercase text-gold-600 mb-4">{{ $lawyer->specialization }} — {{ $lawyer->city }}</p>
          <p class="text-sm text-onyx/60 mb-6 line-clamp-2">{{ $lawyer->bio }}</p>
          <div class="flex justify-between items-center">
            <span class="font-serif text-gold-600 text-xl">{{ $lawyer->experience_years }}Yrs</span>
            <a href="{{ route('public.lawyer', $lawyer->id) }}" class="btn-lux btn-lux-outline text-xs">View Profile</a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
