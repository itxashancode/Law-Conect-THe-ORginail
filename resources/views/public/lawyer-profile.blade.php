@extends('layouts.public')
@section('title', $lawyer->full_name . ' — LegalCounsel')

@section('content')

<div class="pt-32 pb-24 px-6 lg:px-16 relative">
  <div class="absolute inset-0 bg-hero-pattern opacity-10 h-80 z-0"></div>
  <div class="absolute bg-gradient-to-b from-transparent to-parchment w-full h-40 top-40 z-0"></div>

  <div class="max-w-6xl mx-auto relative z-10">

    {{-- Profile Header Card --}}
    <div class="bg-white rounded-3xl shadow-glass border border-white p-8 md:p-12 mb-16 flex flex-col md:flex-row gap-8 lg:gap-16 items-start" data-aos="fade-up">
      <div class="relative w-40 h-40 md:w-56 md:h-56 shrink-0 rounded-2xl overflow-hidden shadow-glow-strong border-2 border-gold/30">
        <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=111&color=D4AF37&size=250' }}"
             alt="{{ $lawyer->full_name }}"
             class="w-full h-full object-cover grayscale-[30%] hover:grayscale-0 scale-100 hover:scale-110 transition-all duration-700">
      </div>
      
      <div class="flex-1 w-full mt-4 md:mt-0">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-warm-border pb-6 mb-6">
          <div>
            <div class="inline-flex items-center gap-2 mb-3">
              <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
              <p class="text-gold text-xs font-semibold tracking-widest uppercase">{{ $lawyer->specialization }} Law</p>
            </div>
            <h1 class="font-serif text-5xl md:text-6xl text-ink leading-tight">{{ $lawyer->full_name }}</h1>
          </div>
          
          <div class="flex items-center gap-2 bg-parchment rounded-2xl p-4 border border-warm-border min-w-[140px] text-center shrink-0">
            <div class="flex-1">
              <p class="text-ink-muted text-[10px] font-bold tracking-widest uppercase mb-1">Experience</p>
              <p class="font-serif text-2xl text-ink">{{ $lawyer->experience_years }}<span class="text-gold text-lg">Y</span></p>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8">
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center shrink-0 text-gold">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div>
              <p class="text-[10px] font-bold tracking-widest uppercase text-ink-muted mb-1">Location</p>
              <p class="text-ink text-sm font-medium">{{ $lawyer->city }}</p>
              @if($lawyer->address)
                <p class="text-sm text-ink-muted mt-1">{{ $lawyer->address }}</p>
              @endif
            </div>
          </div>
          
          @if($lawyer->consultation_fee)
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center shrink-0 text-gold">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
              <p class="text-[10px] font-bold tracking-widest uppercase text-ink-muted mb-1">Consultation Fee</p>
              <p class="text-ink text-lg font-serif font-semibold">${{ number_format($lawyer->consultation_fee, 2) }}</p>
            </div>
          </div>
          @endif
          
          @if($lawyer->phone)
          <div class="flex items-start gap-4 mt-2 sm:col-span-2">
            <div class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center shrink-0 text-gold">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            </div>
            <div>
              <p class="text-[10px] font-bold tracking-widest uppercase text-ink-muted mb-1">Contact</p>
              <p class="text-ink text-sm font-medium">{{ $lawyer->phone }}</p>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
      <div class="lg:col-span-2 space-y-12">
        {{-- Bio --}}
        @if($lawyer->bio)
        <div data-aos="fade-up">
          <h2 class="font-serif text-3xl text-ink mb-6 flex items-center gap-4">
            About
            <span class="flex-1 h-px bg-warm-border"></span>
          </h2>
          <div class="bg-white rounded-3xl p-8 border border-warm-border shadow-sm">
            <p class="text-ink-mid leading-relaxed text-lg">{{ $lawyer->bio }}</p>
          </div>
        </div>
        @endif
      </div>

      {{-- Book Appointment Sidebar --}}
      <div class="lg:col-span-1" data-aos="fade-up" data-aos-delay="100">
        <div class="sticky top-28 bg-white border border-warn-border shadow-glass rounded-3xl p-8 overflow-hidden relative">
          <div class="absolute top-0 right-0 w-32 h-32 bg-gold/10 rounded-full blur-3xl pointer-events-none"></div>
          
          <h2 class="font-serif text-2xl text-ink mb-2 relative z-10">Book a Consultation</h2>
          <p class="text-ink-muted text-sm mb-8 relative z-10">Secure your appointment instantly.</p>

          @auth
            @if($lawyer->availabilitySlots->where('is_booked', false)->count())
              <form method="POST" action="{{ route('customer.appointments.store') }}" class="relative z-10">
                @csrf
                <input type="hidden" name="lawyer_id" value="{{ $lawyer->id }}">

                <div class="mb-6">
                  <label class="block text-[10px] font-bold tracking-widest uppercase text-ink-muted mb-3 pr-2">Select a Time Slot</label>
                  <div class="space-y-3 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($lawyer->availabilitySlots->where('is_booked', false) as $slot)
                    <label class="flex items-start gap-4 p-4 rounded-xl border border-warm-border cursor-pointer hover:border-gold hover:shadow-glow transition-all duration-300 relative group has-[:checked]:border-gold has-[:checked]:bg-gold/5 has-[:checked]:shadow-glow">
                      <div class="pt-0.5">
                        <input type="radio" name="slot_id" value="{{ $slot->id }}" required class="text-gold focus:ring-gold border-warm-border">
                      </div>
                      <div class="flex-1">
                        <p class="text-sm font-semibold text-ink">{{ \Carbon\Carbon::parse($slot->available_date)->format('D, M j Y') }}</p>
                        <p class="text-xs text-ink-muted">{{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} – {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}</p>
                      </div>
                    </label>
                    @endforeach
                  </div>
                </div>

                <div class="mb-5">
                  <label class="block text-[10px] font-bold tracking-widest uppercase text-ink-muted mb-2">Subject</label>
                  <input type="text" name="subject" required class="search-field !py-3 !px-4" placeholder="Briefly describe your matter">
                </div>

                <div class="mb-8">
                  <label class="block text-[10px] font-bold tracking-widest uppercase text-ink-muted mb-2">Meeting Place (Optional)</label>
                  <input type="text" name="meeting_place" class="search-field !py-3 !px-4" placeholder="Office, video call, etc.">
                </div>

                <button type="submit" class="btn-primary w-full animate-pulse-gold flex justify-center items-center gap-2 text-sm !py-4 shadow-lg">
                  Confirm Booking
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
              </form>
            @else
              <div class="bg-parchment border border-warm-border rounded-2xl p-6 text-center">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto mb-4 border border-warm-border">
                  <svg class="w-6 h-6 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <p class="text-ink font-semibold mb-1">Fully Booked</p>
                <p class="text-ink-muted text-sm">No available slots at this time. Please check back soon.</p>
              </div>
            @endif
          @else
            <div class="bg-parchment border border-warm-border rounded-2xl p-8 text-center mt-6">
               <svg class="w-10 h-10 text-gold mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
               <p class="text-ink font-semibold mb-4">Please log in to book</p>
               <div class="flex flex-col gap-3">
                 <a href="{{ route('login') }}" class="btn-primary w-full text-center">Log In</a>
                 <a href="{{ route('register') }}" class="btn-ghost w-full text-center">Register</a>
               </div>
            </div>
          @endauth
        </div>
      </div>
    </div>

  </div>
</div>

<style>
/* Custom scrollbar for time slots */
.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #E5E7EB;
  border-radius: 10px;
}
.custom-scrollbar:hover::-webkit-scrollbar-thumb {
  background: #D4AF37;
}
</style>

@endsection
