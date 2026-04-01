@extends('layouts.customer')
@section('title', 'Find a Lawyer — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <h1 class="font-serif text-4xl text-ink mb-8">Find a Lawyer</h1>

  {{-- Search Form --}}
  <form method="GET" action="{{ route('customer.search') }}" class="mb-10">
    <div class="flex flex-col md:flex-row gap-4">
      <input type="text" name="city" value="{{ request('city') }}" placeholder="City or location..." class="search-field md:flex-1">
      <select name="service" class="search-field md:w-64">
        <option value="">All Practice Areas</option>
        @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil'] as $service)
          <option value="{{ $service }}" {{ request('service') === $service ? 'selected' : '' }}>{{ $service }}</option>
        @endforeach
      </select>
      <button type="submit" class="btn-primary">Search</button>
    </div>
  </form>

  {{-- Results --}}
  @if($lawyers->isEmpty())
    <div class="text-center py-20">
      <p class="text-ink-muted">No lawyers found matching your criteria.</p>
      <p class="text-sm text-ink-muted mt-2">Try adjusting your search filters.</p>
    </div>
  @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($lawyers as $lawyer)
      <div class="lawyer-card p-6 group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-16 h-16 overflow-hidden shrink-0">
            <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=1A1A1A&color=B8860B' }}"
                 alt="{{ $lawyer->full_name }}"
                 class="w-full h-full object-cover grayscale-[25%] group-hover:grayscale-0 transition-all duration-400">
          </div>
          <div>
            <p class="font-serif text-lg text-ink font-semibold">{{ $lawyer->full_name }}</p>
            <p class="text-xs text-gold tracking-widest uppercase mt-1">{{ $lawyer->specialization }}</p>
            <p class="text-sm text-ink-muted mt-1">{{ $lawyer->city }}</p>
          </div>
        </div>
        <div class="flex gap-2 mt-4">
          <a href="{{ route('public.lawyer', $lawyer->id) }}" class="btn-ghost text-xs py-2 px-4">View Profile</a>
        </div>
      </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
