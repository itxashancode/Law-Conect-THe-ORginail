@extends('layouts.lawyer')
@section('title', 'Manage Availability — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <div class="flex justify-between items-center mb-12">
    <h1 class="font-serif text-6xl text-onyx">My Availability Slots</h1>
  </div>

  @if(session('success'))
    <div class="bg-gold-100 border border-gold-500 text-gold-900 px-6 py-4 mb-10">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="bg-ash/20 border border-onyx/20 text-onyx px-6 py-4 mb-10">
      {{ session('error') }}
    </div>
  @endif

  {{-- Add New Slot Form --}}
  <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-8 mb-12 bespoke-card">
    <h2 class="font-serif text-2xl text-onyx mb-6">Add New Availability Slot</h2>
    <form method="POST" action="{{ route('lawyer.slots.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
      @csrf
      <div>
        <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Date</label>
        <input type="date" name="available_date" required min="{{ date('Y-m-d') }}" class="lux-input">
      </div>
      <div>
        <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Start Time</label>
        <input type="time" name="start_time" required class="lux-input">
      </div>
      <div>
        <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">End Time</label>
        <input type="time" name="end_time" required class="lux-input">
      </div>
      <div>
        <button type="submit" class="btn-lux btn-lux-gold w-full">Add Slot</button>
      </div>
    </form>
  </div>

  {{-- Slots List --}}
  <div class="space-y-4">
    @forelse($slots as $slot)
    <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-6 hover:shadow-luxury hover:-translate-y-1 transition-all duration-500 bespoke-card">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-6">
          <div class="w-16 h-16 bg-onyx/5 rounded-full flex items-center justify-center">
            <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
          <div>
            <p class="font-serif text-xl text-onyx mb-1">
              {{ \Carbon\Carbon::parse($slot->available_date)->format('l, F j, Y') }}
            </p>
            <p class="text-sm text-onyx/60">
              {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}
            </p>
          </div>
        </div>
        <div class="flex items-center gap-6">
          @if($slot->is_booked)
            <span class="inline-block px-4 py-2 text-xs border border-onyx/20 text-onyx">Booked</span>
          @else
            <span class="inline-block px-4 py-2 text-xs border border-onyx/20 text-onyx">Available</span>
          @endif
          <div class="text-right">
            @unless($slot->is_booked)
              <form method="POST" action="{{ route('lawyer.slots.destroy', $slot->id) }}" class="inline" onsubmit="return confirm('Delete this slot?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-onyx/40 hover:text-onyx text-sm underline">Delete</button>
              </form>
            @endunless
          </div>
        </div>
      </div>
    </div>
    @empty
    <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-16 text-center bespoke-card">
      <svg class="w-16 h-16 mx-auto text-onyx/20 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
      <p class="font-serif text-2xl text-onyx mb-2">No slots created yet</p>
      <p class="text-onyx/60 mb-8">Add your first availability slot above to start receiving bookings.</p>
    </div>
    @endforelse
  </div>
</div>
@endsection
