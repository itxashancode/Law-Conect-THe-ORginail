@extends('layouts.public')
@section('title', $lawyer->full_name)
@section('meta_description', 'Book a consultation with ' . $lawyer->full_name . ', a distinguished ' . $lawyer->specialization . ' lawyer based in ' . $lawyer->city . '.')

@section('content')
<div class="min-h-screen">

  {{-- Large Profile Header --}}
  <div class="bg-onyx text-white pt-40 pb-20 px-6 lg:px-20 relative overflow-hidden">
    {{-- Background grain --}}
    <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22n%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.65%22 numOctaves=%223%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23n)%22/%3E%3C/svg%3E');"></div>
    <div class="absolute bottom-0 right-0 w-1/3 h-full opacity-10">
      <div class="w-full h-full bg-gold-500 blur-[120px] rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto relative z-10">
      {{-- Back --}}
      <a href="{{ route('public.search') }}" class="mb-12 inline-flex items-center gap-4 group cursor-pointer no-underline">
        <div class="w-8 h-8 border border-white/20 flex items-center justify-center rounded-full group-hover:border-gold-500 group-hover:text-gold-500 transition-all duration-300">
          <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
          </svg>
        </div>
        <span class="text-[10px] font-bold tracking-widest uppercase text-white/30 group-hover:text-white transition-colors">Back to Network</span>
      </a>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-end">
        <div class="lg:col-span-8">
          {{-- Specialization + City badges --}}
          <div class="flex flex-wrap gap-2 mb-6">
            <span class="text-[9px] font-bold tracking-widest uppercase px-3 py-1 border border-gold-500/30 text-gold-400">{{ $lawyer->specialization }} Law</span>
            <span class="text-[9px] font-bold tracking-widest uppercase px-3 py-1 border border-white/10 text-white/40">{{ $lawyer->city }}</span>
            <span class="text-[9px] font-bold tracking-widest uppercase px-3 py-1 border border-white/10 text-white/40">{{ $lawyer->experience_years }} Years Exp.</span>
          </div>

          <h1 class="font-serif text-6xl md:text-8xl xl:text-9xl italic leading-none mb-8 text-white">{{ $lawyer->full_name }}</h1>
          <p class="text-lg font-light text-white/50 max-w-2xl leading-relaxed">{{ $lawyer->bio }}</p>
        </div>

        {{-- Avatar --}}
        <div class="lg:col-span-4 flex justify-center lg:justify-end">
          <div class="w-56 h-56 lg:w-72 lg:h-72 border-2 border-white/10 overflow-hidden relative">
            <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name='.urlencode($lawyer->full_name).'&background=D4AF37&color=0D0D0D&size=512' }}"
                 alt="{{ $lawyer->full_name }}"
                 class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700">
          </div>
        </div>
      </div>

      {{-- Stats Bar --}}
      <div class="grid grid-cols-3 gap-0 mt-16 border-t border-white/10 pt-8">
        <div class="pr-8 border-r border-white/10">
          <p class="text-[9px] font-bold tracking-widest uppercase text-white/30 mb-2">Consultation Rate</p>
          <p class="font-serif text-3xl italic text-gold-400">${{ number_format($lawyer->consultation_fee ?? 0) }}<span class="text-sm font-sans not-italic text-white/30 ml-1">/hr</span></p>
        </div>
        <div class="px-8 border-r border-white/10">
          <p class="text-[9px] font-bold tracking-widest uppercase text-white/30 mb-2">Bar License</p>
          <p class="font-mono text-sm text-white/60">{{ $lawyer->bar_license }}</p>
        </div>
        <div class="pl-8">
          <p class="text-[9px] font-bold tracking-widest uppercase text-white/30 mb-2">Availability</p>
          @php $openSlots = $lawyer->availabilitySlots->where('is_booked', false)->count(); @endphp
          <p class="font-serif text-xl {{ $openSlots > 0 ? 'text-green-400' : 'text-red-400' }}">
            {{ $openSlots > 0 ? $openSlots . ' Slots Open' : 'Fully Booked' }}
          </p>
        </div>
      </div>
    </div>
  </div>

  {{-- Body --}}
  <div class="max-w-7xl mx-auto px-6 lg:px-20 py-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

      {{-- Main Content --}}
      <div class="lg:col-span-8 space-y-16">

        {{-- About --}}
        @if($lawyer->address)
        <div>
          <h2 class="text-[10px] font-bold tracking-widest uppercase text-onyx/30 mb-6 flex items-center gap-4">
            <span>Chambers &amp; Location</span>
            <span class="flex-1 h-px bg-onyx/5"></span>
          </h2>
          <div class="bg-onyx text-white p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 opacity-5 p-6">
              <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
            </div>
            <p class="text-white/50 text-sm mb-2">{{ $lawyer->address }}</p>
            <p class="font-serif text-2xl italic text-white">{{ $lawyer->city }}</p>
            <a href="https://maps.google.com/?q={{ urlencode($lawyer->address . ' ' . $lawyer->city) }}"
               target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 mt-4 text-[10px] font-bold tracking-widest uppercase text-gold-400 hover:text-gold-300 transition-colors">
              Open in Maps
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
          </div>
        </div>
        @endif

        {{-- Availability Calendar --}}
        @auth
        @php $availableSlots = $lawyer->availabilitySlots->where('is_booked', false)->sortBy('available_date'); @endphp
        <div>
          <h2 class="text-[10px] font-bold tracking-widest uppercase text-onyx/30 mb-6 flex items-center gap-4">
            <span>Available Sessions</span>
            <span class="flex-1 h-px bg-onyx/5"></span>
          </h2>

          @if($availableSlots->count())
          {{-- Group slots by date --}}
          @php
            $grouped = $availableSlots->groupBy('available_date');
          @endphp
          <div class="space-y-8">
            @foreach($grouped as $date => $slots)
            <div>
              <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-3 flex items-center gap-3">
                <span class="font-serif text-onyx text-base italic not-uppercase">{{ \Carbon\Carbon::parse($date)->format('l, F j') }}</span>
                <span class="flex-1 h-px bg-onyx/5"></span>
                <span>{{ \Carbon\Carbon::parse($date)->diffForHumans() }}</span>
              </p>
              <div class="flex flex-wrap gap-3" id="slot-grid-{{ str_replace('-', '', $date) }}">
                @foreach($slots as $slot)
                <button type="button"
                        onclick="selectSlot({{ $slot->id }}, '{{ \Carbon\Carbon::parse($date)->format('M j') }}', '{{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }}')"
                        class="slot-btn group border border-onyx/10 px-5 py-3 hover:border-gold-500 hover:bg-gold-50 transition-all duration-200 text-left"
                        data-slot="{{ $slot->id }}">
                  <p class="text-base font-serif text-onyx group-hover:text-gold-700">{{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }}</p>
                  <p class="text-[9px] text-onyx/40 uppercase tracking-widest">to {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}</p>
                </button>
                @endforeach
              </div>
            </div>
            @endforeach
          </div>
          @else
          <div class="border border-onyx/5 p-12 text-center">
            <p class="font-serif text-xl italic text-onyx/30">No available sessions at this time.</p>
            <p class="text-[10px] text-onyx/30 uppercase tracking-widest mt-2">Please check back soon.</p>
          </div>
          @endif
        </div>
        @endauth

        @guest
        <div class="border border-onyx/5 p-12 text-center">
          <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/30 mb-4">Authentication Required</p>
          <p class="font-serif text-2xl italic text-onyx mb-8">Sign in to view available time slots</p>
          <div class="flex justify-center gap-4">
            <a href="{{ route('login') }}" class="btn-lux btn-lux-gold">Sign In</a>
            <a href="{{ route('register') }}" class="btn-lux btn-lux-outline">Create Account</a>
          </div>
        </div>
        @endguest

      </div>

      {{-- Sticky Booking Sidebar --}}
      <div class="lg:col-span-4">
        <div class="sticky top-28" id="booking-sidebar">
          <div class="border border-onyx/10 bg-white p-8 shadow-lg">
            <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/30 mb-6">Book a Consultation</p>
            <div class="mb-6 border-b border-onyx/5 pb-6">
              <p class="font-serif text-4xl italic text-gold-600">${{ number_format($lawyer->consultation_fee ?? 0) }}</p>
              <p class="text-[10px] text-onyx/40 uppercase tracking-widest mt-1">Per hour session</p>
            </div>

            @auth
              {{-- Selected Slot Preview --}}
              <div id="selected-slot-preview" class="hidden mb-6 p-4 bg-gold-50 border border-gold-200">
                <p class="text-[9px] font-bold tracking-widest uppercase text-gold-600 mb-1">Selected Time</p>
                <p class="font-serif text-lg text-onyx" id="slot-preview-text">—</p>
              </div>

              <button id="open-booking-modal"
                      class="btn-lux btn-lux-gold w-full shadow-premium text-center disabled:opacity-50 disabled:cursor-not-allowed"
                      disabled>
                Select a Time Above First
              </button>

              <p class="text-[9px] text-center mt-4 text-onyx/30 uppercase tracking-widest leading-relaxed">
                Secure • End-to-End Encrypted • Private
              </p>
            @else
              <a href="{{ route('login') }}" class="btn-lux btn-lux-gold w-full text-center block">
                Sign In to Book
              </a>
              <a href="{{ route('register') }}" class="btn-lux btn-lux-outline w-full text-center block mt-3">
                Create Free Account
              </a>
            @endauth
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Booking Modal --}}
@auth
@php $availableSlots = $lawyer->availabilitySlots->where('is_booked', false); @endphp
<div id="booking-dialog" class="fixed inset-0 z-[200] hidden items-center justify-center p-4">
  <div id="dialog-backdrop" class="absolute inset-0 bg-onyx/60 backdrop-blur-sm cursor-pointer opacity-0"></div>
  <div id="dialog-window" class="relative bg-white w-full max-w-md mx-auto opacity-0 scale-95 shadow-2xl overflow-hidden">
    {{-- Modal Header --}}
    <div class="p-6 border-b border-onyx/10 flex justify-between items-center bg-onyx">
      <div>
        <h3 class="font-serif text-xl italic text-white">Confirm Session</h3>
        <p class="text-[9px] tracking-widest uppercase text-white/40 mt-0.5">With {{ $lawyer->full_name }}</p>
      </div>
      <button id="close-booking-modal" class="w-8 h-8 flex items-center justify-center text-white/30 hover:text-white transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <form action="{{ route('customer.appointments.store') }}" method="POST" class="p-6 space-y-6">
      @csrf
      <input type="hidden" name="lawyer_id" value="{{ $lawyer->id }}">
      <input type="hidden" name="slot_id" id="modal-slot-id">

      {{-- Slot display --}}
      <div class="p-4 bg-gold-50 border border-gold-200">
        <p class="text-[9px] font-bold tracking-widest uppercase text-gold-600 mb-1">Your Selected Time</p>
        <p class="font-serif text-xl text-onyx" id="modal-slot-display">—</p>
      </div>

      {{-- Subject --}}
      <div>
        <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Matter Description</label>
        <textarea name="subject" rows="3" required
                  class="w-full border border-onyx/10 p-3 text-sm focus:ring-1 focus:ring-gold-500 focus:border-gold-500 outline-none resize-none placeholder:text-onyx/30 transition-colors"
                  placeholder="Briefly describe the nature of your legal matter..."></textarea>
      </div>

      <button type="submit" class="btn-lux btn-lux-gold w-full shadow-premium">Confirm Booking</button>
      <p class="text-[9px] text-center text-onyx/30 uppercase tracking-widest">Secure • Confidential • Encrypted</p>
    </form>
  </div>
</div>
@endauth

@endsection

@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LegalService",
  "name": "{{ $lawyer->full_name }}",
  "image": "{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name='.urlencode($lawyer->full_name).'&background=D4AF37&color=0D0D0D&size=512' }}",
  "description": "{{ addslashes(strip_tags($lawyer->bio)) }}",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "{{ $lawyer->address }}",
    "addressLocality": "{{ $lawyer->city }}"
  },
  "telephone": "{{ $lawyer->phone }}",
  "priceRange": "${{ number_format($lawyer->consultation_fee ?? 0) }}",
  "url": "{{ url()->current() }}"
}
</script>
@endpush

@push('scripts')
<script>
let selectedSlotId = null;

function selectSlot(slotId, date, time) {
  // Deselect all
  document.querySelectorAll('.slot-btn').forEach(btn => {
    btn.classList.remove('border-gold-500', 'bg-gold-100', 'ring-1', 'ring-gold-500');
    btn.classList.add('border-onyx/10');
  });
  // Select this one
  const btn = document.querySelector(`[data-slot="${slotId}"]`);
  if (btn) {
    btn.classList.add('border-gold-500', 'bg-gold-100', 'ring-1', 'ring-gold-500');
    btn.classList.remove('border-onyx/10');
  }

  selectedSlotId = slotId;
  const label = `${date} at ${time}`;

  // Update sidebar preview
  const preview = document.getElementById('selected-slot-preview');
  const previewText = document.getElementById('slot-preview-text');
  if (preview && previewText) {
    preview.classList.remove('hidden');
    previewText.textContent = label;
  }

  // Enable the book button
  const bookBtn = document.getElementById('open-booking-modal');
  if (bookBtn) {
    bookBtn.disabled = false;
    bookBtn.textContent = 'Book This Slot';
  }

  // Update modal
  const modalSlotId = document.getElementById('modal-slot-id');
  const modalDisplay = document.getElementById('modal-slot-display');
  if (modalSlotId) modalSlotId.value = slotId;
  if (modalDisplay) modalDisplay.textContent = label;
}

// Modal
document.addEventListener('DOMContentLoaded', () => {
  const openBtn = document.getElementById('open-booking-modal');
  const closeBtn = document.getElementById('close-booking-modal');
  const backdrop = document.getElementById('dialog-backdrop');
  const dialog = document.getElementById('booking-dialog');
  const window_ = document.getElementById('dialog-window');

  if (!openBtn || !dialog) return;

  const tl = gsap.timeline({ paused: true, onReverseComplete: () => dialog.style.display = 'none' });
  tl.to(backdrop, { opacity: 1, duration: 0.25 })
    .to(window_, { opacity: 1, scale: 1, y: 0, duration: 0.4, ease: 'back.out(1.4)' }, '-=0.1');

  const open = () => { dialog.style.display = 'flex'; window_.style.transform = 'scale(0.95) translateY(16px)'; tl.play(); };
  const close = () => tl.reverse();

  openBtn.addEventListener('click', open);
  if (closeBtn) closeBtn.addEventListener('click', close);
  if (backdrop) backdrop.addEventListener('click', close);
  document.addEventListener('keydown', e => { if (e.key === 'Escape' && dialog.style.display === 'flex') close(); });

  // Sticky CTA on mobile scroll
  const sidebar = document.getElementById('booking-sidebar');
  if (sidebar && window.innerWidth < 1024) {
    const stickyBar = document.createElement('div');
    stickyBar.className = 'fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-onyx/10 p-4 flex items-center justify-between shadow-2xl lg:hidden';
    stickyBar.innerHTML = `
      <div>
        <p class="text-[9px] font-bold tracking-widest uppercase text-onyx/30">Consultation</p>
        <p class="font-serif text-xl italic text-gold-600">${{ number_format($lawyer->consultation_fee ?? 0) }}/hr</p>
      </div>
      <button onclick="document.getElementById('availability-section')?.scrollIntoView({behavior:'smooth'})"
              class="btn-lux btn-lux-gold !py-2 !px-6">
        @auth Book Session @else Sign in to Book @endauth
      </button>
    `;
    document.body.appendChild(stickyBar);
  }
});
</script>
@endpush
