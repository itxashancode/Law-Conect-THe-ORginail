@extends('layouts.customer')
@section('title', 'Book Appointment — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <h1 class="font-serif text-6xl text-onyx mb-4">Book Appointment</h1>
  <p class="text-onyx/60 mb-12">With {{ $lawyer->full_name }} ({{ $lawyer->specialization }})</p>

  @if(session('error'))
    <div class="bg-ash/20 border border-onyx/20 text-onyx px-6 py-4 mb-10">
      {{ session('error') }}
    </div>
  @endif

  <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-10 max-w-3xl bespoke-card">
    <form method="POST" action="{{ route('customer.appointments.store') }}">
      @csrf
      <input type="hidden" name="lawyer_id" value="{{ $lawyer->id }}">

      {{-- Available Slots --}}
      @if($availableSlots->count())
        <div class="mb-10">
          <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-4">Select an Available Time Slot</label>
          <div class="space-y-3">
            @foreach($availableSlots as $slot)
            <label class="flex items-center gap-4 p-4 border border-onyx/10 cursor-pointer hover:border-gold-500 transition-all duration-500 {{ $errors->has('slot_id') ? 'border-gold-500 bg-gold-50/30' : '' }}">
              <input type="radio" name="slot_id" value="{{ $slot->id }}" required class="w-5 h-5 accent-gold-500">
              <div class="flex-1">
                <p class="font-semibold text-onyx">
                  {{ \Carbon\Carbon::parse($slot->available_date)->format('l, F j, Y') }}
                </p>
                <p class="text-sm text-onyx/60">
                  {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} -
                  {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}
                </p>
              </div>
            </label>
            @endforeach
          </div>
          @error('slot_id')
            <p class="text-gold-600 text-sm mt-2">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-8">
          <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Subject / Reason for Appointment</label>
          <input type="text" name="subject" required class="lux-input" placeholder="e.g., Initial consultation about...">
          @error('subject')
            <p class="text-gold-600 text-sm mt-2">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-10">
          <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Preferred Meeting Place (optional)</label>
          <input type="text" name="meeting_place" class="lux-input" placeholder="e.g., Lawyer's office, Video call, Phone, etc.">
        </div>

        <button type="submit" class="btn-lux btn-lux-gold shadow-luxury animate-pulse-gold w-full">Confirm Booking</button>
      @else
        <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-16 text-center bespoke-card">
          <svg class="w-16 h-16 mx-auto text-onyx/20 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <p class="font-serif text-2xl text-onyx mb-2">No available slots</p>
          <p class="text-onyx/60 mb-8">This lawyer has no availability at the moment.</p>
          <a href="{{ route('customer.search') }}" class="btn-lux btn-lux-outline">Browse Other Lawyers</a>
        </div>
      @endif
    </form>
  </div>
</div>
@endsection
