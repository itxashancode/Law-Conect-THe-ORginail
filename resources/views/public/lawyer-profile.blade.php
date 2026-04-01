@extends('layouts.public')
@section('title', $lawyer->full_name . ' — LegalCounsel')

@section('content')

<div class="pt-32 pb-24 px-6 lg:px-16">
  <div class="max-w-5xl mx-auto">

    {{-- Profile Header --}}
    <div class="flex flex-col md:flex-row gap-10 mb-16" data-aos="fade-up">
      <div class="w-32 h-32 md:w-48 md:h-48 overflow-hidden shrink-0">
        <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=1A1A1A&color=B8860B&size=200' }}"
             alt="{{ $lawyer->full_name }}"
             class="w-full h-full object-cover grayscale-[20%] hover:grayscale-0 transition-all duration-500">
      </div>
      <div>
        <p class="text-gold text-xs tracking-widest uppercase mb-2">{{ $lawyer->specialization }} Law</p>
        <h1 class="font-serif text-4xl md:text-5xl text-ink mb-4">{{ $lawyer->full_name }}</h1>
        <p class="text-ink-muted text-sm">{{ $lawyer->city }} · {{ $lawyer->experience_years }} years experience</p>
        @if($lawyer->consultation_fee)
          <p class="text-sm text-ink mt-2">Consultation: <span class="font-semibold">${{ number_format($lawyer->consultation_fee, 2) }}</span></p>
        @endif
        @if($lawyer->address)
          <p class="text-sm text-ink-muted mt-2">{{ $lawyer->address }}</p>
        @endif
        @if($lawyer->phone)
          <p class="text-sm text-ink-muted mt-1">{{ $lawyer->phone }}</p>
        @endif
      </div>
    </div>

    {{-- Bio --}}
    @if($lawyer->bio)
    <div class="mb-16 border-l-2 border-gold pl-8" data-aos="fade-up">
      <p class="text-ink-mid leading-relaxed">{{ $lawyer->bio }}</p>
    </div>
    @endif

    {{-- Book Appointment --}}
    <div data-aos="fade-up" data-aos-delay="100">
      <div class="w-10 h-0.5 bg-gold mb-6"></div>
      <h2 class="font-serif text-3xl text-ink mb-8">Book an Appointment</h2>

      @auth
        @if($lawyer->availabilitySlots->where('is_booked', false)->count())
          <form method="POST" action="{{ route('customer.appointments.store') }}" class="max-w-lg">
            @csrf
            <input type="hidden" name="lawyer_id" value="{{ $lawyer->id }}">

            <div class="mb-6">
              <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Select a Time Slot</label>
              @foreach($lawyer->availabilitySlots->where('is_booked', false) as $slot)
              <label class="flex items-center gap-3 p-4 border border-warm-border mb-2 cursor-pointer hover:border-gold transition-colors">
                <input type="radio" name="slot_id" value="{{ $slot->id }}" required>
                <span class="text-sm text-ink">{{ \Carbon\Carbon::parse($slot->available_date)->format('D, M j Y') }} · {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} – {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}</span>
              </label>
              @endforeach
            </div>

            <div class="mb-6">
              <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Subject</label>
              <input type="text" name="subject" required class="search-field" placeholder="Briefly describe your matter">
            </div>

            <div class="mb-8">
              <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Preferred Meeting Place (optional)</label>
              <input type="text" name="meeting_place" class="search-field" placeholder="Office, video call, etc.">
            </div>

            <button type="submit" class="btn-primary animate-pulse-gold">Book Appointment</button>
          </form>
        @else
          <p class="text-ink-muted">No available slots at this time. Check back soon.</p>
        @endif
      @else
        <p class="text-ink-muted">
          Please <a href="{{ route('login') }}" class="text-gold underline">log in</a> or
          <a href="{{ route('register') }}" class="text-gold underline">register</a> to book an appointment.
        </p>
      @endauth
    </div>

  </div>
</div>

@endsection
