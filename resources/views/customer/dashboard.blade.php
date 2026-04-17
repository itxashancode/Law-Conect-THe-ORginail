@extends('layouts.customer')
@section('title', 'Your Private Practice — LegalCounsel')

@section('dashboard-content')
<div class="max-w-7xl mx-auto">

  {{-- Cinematic Welcome --}}
  <header class="mb-24 px-2" data-aos="fade-up">
    <div class="inline-flex items-center gap-3 px-3 py-1 bg-onyx/5 border border-onyx/5 rounded-full mb-8">
      <span class="w-1 h-1 rounded-full bg-gold-500 animate-pulse"></span>
      <span class="text-[9px] font-bold tracking-ultra uppercase text-onyx/40">Private Client Portal</span>
    </div>
    
    <h1 class="font-serif text-[clamp(4rem,10vw,8rem)] italic leading-[0.85] text-onyx mb-6">
      Welcome back, <br>
      <span class="text-gold-500">{{ explode(' ', $customer->name)[0] }}</span>
    </h1>
    <p class="text-xl font-light text-onyx/40 max-w-xl leading-relaxed">Your curated legal consultations and upcoming sessions, managed with precision and privacy.</p>
  </header>

  {{-- Upcoming Sessions Grid --}}
  <section class="mb-24">
    <div class="flex items-end justify-between mb-12 border-b border-onyx/5 pb-8 px-2">
      <div>
        <h2 class="font-serif text-5xl text-onyx mb-1">Upcoming Sessions</h2>
        <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/30">Your confirmed legal appointments</p>
      </div>
      <a href="{{ route('public.search') }}" class="group flex items-center gap-3 text-[10px] font-bold tracking-ultra uppercase text-onyx/40 hover:text-gold-600 transition-colors">
        Find Counsel
        <div class="w-8 h-8 rounded-full border border-onyx/10 flex items-center justify-center group-hover:bg-gold-500 group-hover:border-gold-500 group-hover:text-white transition-all duration-500">
           <svg class="w-3 h-3 translate-x-0 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </div>
      </a>
    </div>

    @if($upcomingAppointments->count())
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($upcomingAppointments as $appointment)
        <div class="bg-white border border-onyx-5 p-10 hover:shadow-luxury transition-all duration-700 bespoke-card group relative overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
          {{-- Status Ribbon --}}
          <div class="absolute top-0 right-0 p-10">
            <span class="inline-flex items-center gap-2 px-4 py-2 text-[9px] font-bold tracking-ultra uppercase border border-gold-500/20 bg-gold-50 text-gold-600">
              <span class="w-1 h-1 rounded-full bg-gold-500"></span> Confirmed
            </span>
          </div>

          <div class="mb-10">
            <p class="text-[10px] tracking-ultra uppercase text-gold-500 mb-4">{{ \Carbon\Carbon::parse($appointment->slot->available_date)->format('l, F j') }}</p>
            <h4 class="font-serif text-3xl text-onyx group-hover:text-gold-600 transition-colors duration-500 mb-2">{{ $appointment->subject }}</h4>
            <p class="text-sm font-light text-onyx/40 italic">{{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('g:i A') }} Eastern Standard Time</p>
          </div>

          <div class="pt-10 border-t border-onyx/5 flex items-center justify-between">
             <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-full overflow-hidden border border-onyx/5 grayscale group-hover:grayscale-0 transition-all duration-700">
                   <img src="{{ $appointment->lawyer->photo ? asset('storage/' . $appointment->lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($appointment->lawyer->full_name) . '&background=0D0D0D&color=D4AF37&size=200' }}" alt="{{ $appointment->lawyer->full_name }}" class="w-full h-full object-cover">
                </div>
                <div>
                  <p class="font-serif text-xl text-onyx mb-1">{{ $appointment->lawyer->full_name }}</p>
                  <p class="text-[10px] font-bold tracking-widest text-onyx/30 uppercase">{{ $appointment->lawyer->specialization }} Counsel</p>
                </div>
             </div>
             <a href="{{ route('public.lawyer', $appointment->lawyer->slug) }}" class="btn-lux btn-lux-outline !px-6 !py-3 text-[9px]">Profile</a>
          </div>
        </div>
        @endforeach
      </div>
    @else
      <div class="py-24 text-center border border-dashed border-onyx/10 bg-onyx/[0.02]" data-aos="fade-up">
        <div class="w-16 h-16 mx-auto mb-8 rounded-full border border-onyx/5 flex items-center justify-center text-onyx/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
        </div>
        <h3 class="font-serif text-3xl italic text-onyx/40 mb-4">No sessions scheduled</h3>
        <p class="text-sm font-light text-onyx/30 mb-10 max-w-sm mx-auto uppercase tracking-widest">Connect with an elite practitioner today.</p>
        <a href="{{ route('public.search') }}" class="btn-lux btn-lux-gold !px-12">Search Network</a>
      </div>
    @endif
  </section>

  {{-- Split Section: Pending & History --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
    
    {{-- Pending Requests --}}
    <div data-aos="fade-up">
      <div class="flex items-center gap-4 mb-10">
        <h3 class="font-serif text-3xl text-onyx italic">Pending Requests</h3>
        <span class="w-full h-px bg-onyx/5"></span>
      </div>

      @if($pendingAppointments->count())
        <div class="space-y-4">
          @foreach($pendingAppointments as $appointment)
          <div class="bg-white border border-onyx-5 p-6 hover:shadow-luxury transition-all duration-500 group">
            <div class="flex justify-between items-start">
              <div>
                <p class="font-serif text-2xl text-onyx mb-1 group-hover:text-gold-600 transition-colors">{{ $appointment->lawyer->full_name }}</p>
                <p class="text-[9px] font-bold tracking-widest text-onyx/30 uppercase mb-4">{{ $appointment->subject }}</p>
              </div>
              <span class="px-3 py-1.5 text-[9px] font-bold tracking-ultra uppercase border border-onyx/10 text-onyx/40 flex items-center gap-2">
                <span class="w-1 h-1 rounded-full bg-onyx/20 animate-pulse"></span> Processing
              </span>
            </div>
          </div>
          @endforeach
        </div>
      @else
        <div class="p-12 text-center bg-onyx/[0.01] border border-onyx/5">
            <p class="text-[10px] font-bold tracking-widest text-onyx/20 uppercase italic">No pending requests at this time.</p>
        </div>
      @endif
    </div>

    {{-- Session History --}}
    <div data-aos="fade-up" data-aos-delay="100">
      <div class="flex items-center gap-4 mb-10">
        <h3 class="font-serif text-3xl text-onyx italic">Session History</h3>
        <span class="w-full h-px bg-onyx/5"></span>
      </div>

      @if($completedAppointments->count())
        <div class="space-y-4">
          @foreach($completedAppointments as $appointment)
          <div class="bg-white border border-onyx-5 p-6 hover:shadow-luxury transition-all duration-500 group">
            <div class="flex justify-between items-center">
              <div>
                <p class="font-serif text-2xl text-onyx mb-1 group-hover:text-gold-600 transition-colors">{{ $appointment->lawyer->full_name }}</p>
                <p class="text-[9px] font-bold tracking-widest text-onyx/30 uppercase">{{ $appointment->created_at->format('F d, Y') }}</p>
              </div>
              <span class="px-3 py-1.5 text-[9px] font-bold tracking-ultra uppercase bg-onyx text-white">Archived</span>
            </div>
          </div>
          @endforeach
        </div>
      @else
        <div class="p-12 text-center bg-onyx/[0.01] border border-onyx/5">
            <p class="text-[10px] font-bold tracking-widest text-onyx/20 uppercase italic">Your practice history is empty.</p>
        </div>
      @endif
    </div>

  </div>
</div>
@endsection
