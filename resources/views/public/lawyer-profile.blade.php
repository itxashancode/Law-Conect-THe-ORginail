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
        <div class="sticky top-40 shad-card p-12 text-center">
           <h2 class="font-serif text-3xl mb-4 text-onyx">Consultation</h2>
           <p class="text-sm text-onyx/60 mb-8">All sessions are private and end-to-end encrypted for your protection.</p>
           
           <div class="text-3xl font-serif text-gold-600 mb-8 italic">
              ${{ number_format($lawyer->consultation_fee ?? 0, 0) }} / hour
           </div>

           @auth
            <button id="open-booking-modal" class="btn-lux btn-lux-gold w-full shadow-sm">Select Date & Time</button>
           @else
              <div class="space-y-6 text-left">
                <p class="text-[10px] font-bold tracking-wide uppercase text-onyx/40 text-center">Identification Required</p>
                <div class="flex flex-col gap-3">
                  <a href="{{ route('login') }}" class="btn-lux btn-lux-gold w-full text-center">Sign In</a>
                  <a href="{{ route('register') }}" class="btn-lux w-full text-center bg-onyx/5 text-onyx border-onyx/10 hover:bg-onyx/10 hover:text-onyx uppercase">Create Account</a>
                </div>
              </div>
           @endauth
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Shadcn-Inspired Dialog Modal for Booking --}}
@auth
@php $availableSlots = $lawyer->availabilitySlots->where('is_booked', false); @endphp
<div id="booking-dialog" class="fixed inset-0 z-[100] hidden items-center justify-center">
  {{-- Backdrop --}}
  <div id="dialog-backdrop" class="absolute inset-0 bg-onyx/40 backdrop-blur-[2px] opacity-0 cursor-pointer"></div>
  
  {{-- Modal Window --}}
  <div id="dialog-window" class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg mx-4 opacity-0 scale-95 flex flex-col max-h-[90vh]">
    <div class="p-6 border-b border-onyx/10 flex justify-between items-center shrink-0">
      <h3 class="font-serif text-2xl text-onyx">Schedule Session</h3>
      <button id="close-booking-modal" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-onyx/5 text-onyx/50 hover:text-onyx transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    
    <div class="p-6 overflow-y-auto w-full">
      @if($availableSlots->count())
        <form action="{{ route('customer.appointments.store') }}" method="POST" id="booking-form" class="space-y-8">
          @csrf
          <input type="hidden" name="lawyer_id" value="{{ $lawyer->id }}">
          
          <div>
            <p class="font-medium text-onyx mb-4 text-sm tracking-wide">1. Select Available Time</p>
            <div class="grid grid-cols-2 gap-3 max-h-[300px] overflow-y-auto pr-2">
              @foreach($availableSlots as $slot)
              <label class="group relative cursor-pointer">
                <input type="radio" name="slot_id" value="{{ $slot->id }}" class="peer sr-only" required>
                <div class="rounded-lg border border-onyx/10 px-4 py-3 hover:bg-onyx/5 peer-checked:border-gold-500 peer-checked:bg-gold-50/50 peer-checked:ring-1 peer-checked:ring-gold-500 transition-all duration-200">
                  <p class="text-xs font-semibold uppercase text-onyx/60 group-hover:text-onyx peer-checked:text-gold-700 transition-colors">{{ \Carbon\Carbon::parse($slot->available_date)->format('M j, Y') }}</p>
                  <p class="text-lg font-serif mt-1 peer-checked:text-gold-800">{{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }}</p>
                </div>
              </label>
              @endforeach
            </div>
          </div>

          <div>
            <p class="font-medium text-onyx mb-4 text-sm tracking-wide">2. Matter Description</p>
            <textarea name="subject" rows="3" class="w-full bg-white border border-onyx/10 rounded-lg p-3 text-sm focus:ring-1 focus:ring-gold-500 focus:border-gold-500 transition-colors resize-none placeholder:text-onyx/30" required placeholder="Briefly describe the nature of your legal inquiry..."></textarea>
          </div>
          
          <div class="pt-2 border-t border-onyx/5">
            <button type="submit" class="btn-lux btn-lux-gold w-full rounded-lg shadow-sm">Confirm Booking</button>
            <p class="text-center text-[10px] text-onyx/40 mt-4 uppercase tracking-widest">Secure • Confidential • Encrypted</p>
          </div>
        </form>
      @else
        <div class="py-12 text-center">
          <div class="w-16 h-16 bg-onyx/5 rounded-full flex items-center justify-center mx-auto mb-4">
             <svg class="w-8 h-8 text-onyx/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          </div>
          <h4 class="font-serif text-xl text-onyx mb-2">Fully Booked</h4>
          <p class="text-sm text-onyx/50">There are no available sessions with this counsel at the moment.</p>
        </div>
      @endif
    </div>
  </div>
</div>
@endauth

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const openBtn = document.getElementById('open-booking-modal');
    const closeBtn = document.getElementById('close-booking-modal');
    const backdrop = document.getElementById('dialog-backdrop');
    const dialog = document.getElementById('booking-dialog');
    const windowEl = document.getElementById('dialog-window');
    
    if (openBtn && dialog) {
        const tl = gsap.timeline({ paused: true, onReverseComplete: () => { dialog.style.display = 'none'; } });
        
        // Spring-based GSAP Dialog Animation
        tl.to(backdrop, { opacity: 1, duration: 0.3, ease: 'power2.out' })
          .to(windowEl, { 
              opacity: 1, 
              scale: 1, 
              y: 0, 
              duration: 0.5, 
              ease: 'back.out(1.4)' 
          }, '-=0.2');

        const openModal = () => {
            dialog.style.display = 'flex';
            windowEl.style.transform = 'translateY(20px) scale(0.95)';
            tl.play();
        };

        const closeModal = () => {
            tl.reverse();
        };

        openBtn.addEventListener('click', openModal);
        closeBtn.addEventListener('click', closeModal);
        backdrop.addEventListener('click', closeModal);
        
        // Escape key to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && dialog.style.display === 'flex') {
                closeModal();
            }
        });
    }
});
</script>
@endpush
