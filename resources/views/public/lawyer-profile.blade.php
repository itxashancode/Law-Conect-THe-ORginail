@extends('layouts.public')
@section('title', $lawyer->full_name . ' — LegalCounsel')

@section('content')

<div class="pt-60 pb-40 px-6 lg:px-20 relative min-h-screen">
  {{-- Hero Wash --}}
  <div class="absolute top-0 inset-x-0 h-[600px] bg-onyx-5 -z-10 clip-path-hero parallax-blob" data-speed="0.15"></div>

  <div class="max-w-7xl mx-auto relative z-10 transition-all duration-1000 ease-expo">
    
    {{-- Top Navigation & Action --}}
    <div class="flex flex-col md:flex-row justify-between items-start gap-10 mb-20">
      <div class="max-w-3xl">
        <div class="flex items-center gap-4 mb-10 group cursor-pointer" onclick="window.history.back()">
           <div class="w-10 h-10 border border-onyx-10 flex items-center justify-center rounded-full group-hover:bg-onyx group-hover:text-white transition-all duration-500">
             <svg class="w-4 h-4 translate-x-0 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 19l-7-7 7-7"/></svg>
           </div>
           <span class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40">Return to network</span>
        </div>
        
        <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-500 mb-6">{{ $lawyer->specialization }} Law — {{ $lawyer->city }}</p>
        <h1 class="text-7xl md:text-9xl leading-none italic mb-10">{{ $lawyer->full_name }}</h1>
        <p class="text-xl font-light text-onyx-60 max-w-xl leading-relaxed">{{ $lawyer->bio }}</p>
      </div>

      <div class="w-full md:w-80 shrink-0">
        <div class="relative aspect-square overflow-hidden bespoke-card !p-0 border-0 rotate-1 shadow-premium">
           <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=0D0D0D&color=D4AF37&size=512' }}" 
                alt="{{ $lawyer->full_name }}" 
                class="w-full h-full object-cover grayscale brightness-90 hover:grayscale-0 hover:brightness-100 transition-all duration-700">
        </div>
      </div>
    </div>

    {{-- Details Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-20 border-t border-onyx-5 pt-20">
      <div class="lg:col-span-8 space-y-20">
        
        {{-- Professional Summary --}}
        <div>
          <h2 class="text-3xl italic mb-10 flex items-center gap-6">
            Profile Summary
            <span class="flex-1 h-px bg-onyx-5"></span>
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="p-8 border border-onyx-[0.03] bg-white/50 relative overflow-hidden backdrop-blur-sm group">
              <span class="text-[10px] font-bold tracking-ultra uppercase text-onyx-30 block mb-6">Experience</span>
              <p class="text-4xl italic text-gold-600">{{ $lawyer->experience_years }} <span class="text-xl">YRS</span></p>
            </div>
            <div class="p-8 border border-onyx-[0.03] bg-white/50 relative overflow-hidden backdrop-blur-sm group">
              <span class="text-[10px] font-bold tracking-ultra uppercase text-onyx-30 block mb-6">Retention</span>
              <p class="text-4xl italic text-gold-600">Premium</p>
            </div>
            <div class="p-8 border border-onyx-[0.03] bg-white/50 relative overflow-hidden backdrop-blur-sm group">
              <span class="text-[10px] font-bold tracking-ultra uppercase text-onyx-30 block mb-6">Consultation</span>
              <p class="text-4xl italic text-gold-600">${{ number_format($lawyer->consultation_fee ?? 0, 0) }}</p>
            </div>
          </div>
        </div>

        {{-- Office Location --}}
        @if($lawyer->address)
        <div class="p-16 bg-onyx text-white relative overflow-hidden">
           <div class="absolute top-0 right-0 p-10 opacity-10">
             <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
           </div>
           <h2 class="text-5xl italic mb-8">Chambers & <br> Location</h2>
           <p class="text-xl font-light text-white/50 mb-10">{{ $lawyer->address }}, {{ $lawyer->city }}</p>
           <a href="https://maps.google.com/?q={{ urlencode($lawyer->address . ' ' . $lawyer->city) }}" target="_blank" 
              class="text-[10px] font-bold tracking-ultra uppercase text-gold-500 flex items-center gap-2 hover:translate-x-2 transition-transform">
              Locate on Map
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
           </a>
        </div>
        @endif
      </div>

      {{-- Booking Sidebar --}}
      <div class="lg:col-span-4">
        <div class="sticky top-40 bg-white border border-onyx-[0.03] p-12 bespoke-card shadow-premium">
           <h2 class="text-4xl italic mb-4">Request Consultation</h2>
           <p class="text-sm font-light text-onyx-50 mb-10">All sessions are private and end-to-end encrypted for your protection.</p>

           @auth
            @php $availableSlots = $lawyer->availabilitySlots->where('is_booked', false); @endphp
            @if($availableSlots->count())
              <form action="{{ route('customer.appointments.store') }}" method="POST" class="group/form">
                @csrf
                <input type="hidden" name="lawyer_id" value="{{ $lawyer->id }}">
                
                <div class="space-y-4 mb-10 max-h-80 overflow-y-auto pr-4 custom-scrollbar">
                  @foreach($availableSlots as $slot)
                  <label class="group flex items-center justify-between p-6 border-b border-onyx-5 cursor-pointer hover:bg-gold-50/50 transition-colors has-[:checked]:bg-gold-50 has-[:checked]:border-gold-500">
                    <input type="radio" name="slot_id" value="{{ $slot->id }}" class="hidden" required>
                    <div class="text-left">
                      <p class="text-xs font-bold tracking-ultra uppercase text-onyx-30 mb-2">{{ \Carbon\Carbon::parse($slot->available_date)->format('D, M j') }}</p>
                      <p class="text-lg italic">{{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }}</p>
                    </div>
                    <svg class="w-4 h-4 text-gold-500 opacity-0 group-has-[:checked]:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                  </label>
                  @endforeach
                </div>

                <div class="space-y-8 mb-12">
                   <div>
                     <label class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Matter Subject</label>
                     <input type="text" name="subject" class="lux-input !py-2" required placeholder="NATURE OF YOUR CONSULTATION">
                   </div>
                </div>

                <button type="submit" class="btn-lux btn-lux-gold w-full shadow-premium group-has-[:checked]/form:animate-pulse-gold">Request Session</button>
              </form>
            @else
              <div class="py-10 text-center border border-dashed border-onyx-10 rounded-bespoke">
                 <p class="text-onyx-40 italic">Currently fully booked.</p>
              </div>
            @endif
           @else
              <div class="space-y-6">
                <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40">Identification Required</p>
                <div class="flex flex-col gap-4">
                  <a href="{{ route('login') }}" class="btn-lux btn-lux-gold w-full text-center">Sign In</a>
                  <a href="{{ route('register') }}" class="btn-lux btn-lux-outline w-full text-center">Register</a>
                </div>
              </div>
           @endauth
        </div>
      </div>
    </div>

  </div>
</div>

<style>
  .clip-path-hero {
    clip-path: polygon(0 0, 100% 0, 100% 80%, 0% 100%);
  }
</style>

@endsection
