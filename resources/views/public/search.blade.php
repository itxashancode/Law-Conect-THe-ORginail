@extends('layouts.public')
@section('title', 'Find a Lawyer — LegalCounsel')

@section('content')

<div class="pt-32 pb-24 px-6 lg:px-16">
  <div class="max-w-7xl mx-auto">

    <h1 class="font-serif text-4xl md:text-5xl text-ink mb-10" data-aos="fade-up">Find a Lawyer</h1>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('public.search') }}"
          class="flex flex-col md:flex-row gap-4 mb-12" data-aos="fade-up" data-aos-delay="100">
      <input type="text" name="city" value="{{ request('city') }}"
             placeholder="City or location..."
             class="search-field md:w-72">
      <select name="service" class="search-field md:w-56">
        <option value="">All Practice Areas</option>
        @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil'] as $service)
          <option value="{{ $service }}" {{ request('service') === $service ? 'selected' : '' }}>
            {{ $service }}
          </option>
        @endforeach
      </select>
      <button type="submit" class="btn-primary">Search</button>
    </form>

    {{-- Service Tags --}}
    <div class="flex flex-wrap gap-3 mb-10" data-aos="fade-up" data-aos-delay="150">
      @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil'] as $service)
        <span class="service-tag {{ request('service') === $service ? 'active' : '' }}"
              onclick="document.querySelector('[name=service]').value='{{ $service }}'; this.closest('form').submit()">
          {{ $service }}
        </span>
      @endforeach
    </div>

    {{-- Results --}}
    @if($lawyers->isEmpty())
      <p class="text-ink-muted text-center py-20" data-aos="fade-up">No lawyers found for your search. Try a different city or practice area.</p>
    @else
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($lawyers as $lawyer)
        <a href="{{ route('public.lawyer', $lawyer->id) }}"
           class="lawyer-card p-6 group"
           data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
          <div class="flex items-center gap-4 mb-4">
            <div class="w-14 h-14 overflow-hidden shrink-0">
              <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=1A1A1A&color=B8860B' }}"
                   alt="{{ $lawyer->full_name }}"
                   class="w-full h-full object-cover grayscale-[25%] group-hover:grayscale-0 transition-all duration-400">
            </div>
            <div>
              <p class="font-serif text-ink font-semibold">{{ $lawyer->full_name }}</p>
              <p class="text-xs text-gold tracking-widest uppercase mt-0.5">{{ $lawyer->specialization }}</p>
            </div>
          </div>
          <p class="text-sm text-ink-muted">{{ $lawyer->city }}</p>
          <p class="text-xs mt-4 tracking-wide uppercase text-gold">View Profile →</p>
        </a>
        @endforeach
      </div>
    @endif

  </div>
</div>

@endsection
