@extends('layouts.admin')
@section('title', 'All Availability Slots — LegalCounsel')

@section('dashboard-content')
<div data-aos="fade-up">
  <div class="flex justify-between items-center mb-12 border-b border-onyx/5 pb-6">
    <h2 class="font-serif text-5xl text-onyx">Network Availability</h2>
  </div>

  @if($slots->count())
    <div class="space-y-4">
      @foreach($slots as $slot)
      <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-6 hover:shadow-luxury transition-all duration-500 bespoke-card">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div class="flex items-center gap-8">
            <div>
              <p class="text-[10px] tracking-ultra uppercase text-onyx/40 mb-2">Slot ID</p>
              <p class="font-serif text-xl text-onyx">#{{ $slot->id }}</p>
            </div>
            <div>
              <p class="text-[10px] tracking-ultra uppercase text-onyx/40 mb-2">Counsel</p>
              <p class="font-serif text-xl text-onyx">{{ $slot->lawyer->full_name }}</p>
            </div>
            <div>
              <p class="text-[10px] tracking-ultra uppercase text-onyx/40 mb-2">Schedule</p>
              <p class="text-lg text-onyx">
                {{ \Carbon\Carbon::parse($slot->available_date)->format('D, M j, Y') }}<br>
                <span class="text-sm text-onyx/60">{{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}</span>
              </p>
            </div>
          </div>

          <div class="flex items-center gap-4">
            <span class="inline-block px-4 py-2 text-xs border border-onyx/20 text-onyx uppercase tracking-ultra {{ $slot->is_booked ? 'bg-onyx/5 text-onyx/60' : 'bg-gold-500 border-gold-500 text-onyx' }}">{{ $slot->is_booked ? 'Booked' : 'Available' }}</span>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  @else
    <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-20 text-center bespoke-card">
      <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/30 mb-4">Availability</p>
      <p class="font-serif text-2xl text-onyx/60 italic">No availability slots registered across the network.</p>
    </div>
  @endif
</div>
@endsection
