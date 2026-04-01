@extends('layouts.customer')
@section('title', 'Book Appointment — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <h1 class="font-serif text-4xl text-ink mb-2">Book Appointment</h1>
  <p class="text-ink-muted mb-8">With {{ $lawyer->full_name }} ({{ $lawyer->specialization }})</p>

  @if(session('error'))
    <div class="bg-red-100 border border-red-500 text-red-700 px-6 py-4 mb-6">
      {{ session('error') }}
    </div>
  @endif

  <div class="bg-warm-surface border border-warm-border p-8 max-w-3xl">
    <form method="POST" action="{{ route('customer.appointments.store') }}">
      @csrf
      <input type="hidden" name="lawyer_id" value="{{ $lawyer->id }}">

      {{-- Available Slots --}}
      @if($availableSlots->count())
        <div class="mb-8">
          <label class="block text-xs tracking-widest uppercase text-ink-muted mb-4">Select an Available Time Slot</label>
          <div class="space-y-3">
            @foreach($availableSlots as $slot)
            <label class="flex items-center gap-4 p-4 border border-warm-border cursor-pointer hover:border-gold transition-colors {{ $errors->has('slot_id') ? 'border-red-500' : '' }}">
              <input type="radio" name="slot_id" value="{{ $slot->id }}" required class="w-5 h-5">
              <div class="flex-1">
                <p class="font-semibold text-ink">
                  {{ \Carbon\Carbon::parse($slot->available_date)->format('l, F j, Y') }}
                </p>
                <p class="text-sm text-ink-muted">
                  {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} -
                  {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}
                </p>
              </div>
            </label>
            @endforeach
          </div>
          @error('slot_id')
            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-6">
          <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Subject / Reason for Appointment</label>
          <input type="text" name="subject" required class="search-field" placeholder="e.g., Initial consultation about...">
          @error('subject')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-8">
          <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Preferred Meeting Place (optional)</label>
          <input type="text" name="meeting_place" class="search-field" placeholder="e.g., Lawyer's office, Video call, Phone, etc.">
        </div>

        <button type="submit" class="btn-primary animate-pulse-gold">Confirm Booking</button>
      @else
        <div class="text-center py-10">
          <p class="text-ink-muted mb-4">No available slots found for this lawyer at the moment.</p>
          <a href="{{ route('customer.search') }}" class="btn-primary">Browse Other Lawyers</a>
        </div>
      @endif
    </form>
  </div>
</div>
@endsection
