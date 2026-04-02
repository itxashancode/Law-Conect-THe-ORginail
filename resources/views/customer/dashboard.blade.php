@extends('layouts.customer')
@section('title', 'Client Dashboard — LegalCounsel')

@section('content')
<div data-aos="fade-up">

  {{-- Welcome --}}
  <div class="mb-20">
    <h1 class="font-serif text-7xl md:text-9xl italic mb-6">Welcome back,</h1>
    <p class="text-2xl text-onyx/60 font-light max-w-2xl">{{ $customer->name }}</p>
  </div>

  {{-- Quick Actions & Upcoming Appointments --}}
  <div class="mb-20">
    <div class="flex items-center justify-between mb-12 border-b border-onyx/5 pb-6">
      <h2 class="font-serif text-5xl text-onyx">Upcoming Sessions</h2>
      <a href="{{ route('customer.search') }}" class="btn-lux btn-lux-outline">Explore Network</a>
    </div>

    @if($upcomingAppointments->count())
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($upcomingAppointments as $appointment)
        <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-8 hover:shadow-luxury hover:-translate-y-1 transition-all duration-700 bespoke-card group">
          <div class="flex items-start justify-between mb-8 pb-8 border-b border-onyx/5">
            <div>
              <p class="text-[10px] tracking-ultra uppercase text-gold-500 mb-3">{{ \Carbon\Carbon::parse($appointment->slot->available_date)->format('D, M j') }} at {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('g:i A') }}</p>
              <h4 class="font-serif text-2xl text-onyx group-hover:text-gold-600 transition-colors">{{ $appointment->subject }}</h4>
            </div>
            <span class="inline-block px-4 py-2 text-xs border border-onyx/20 text-onyx uppercase tracking-ultra">Confirmed</span>
          </div>

          <div class="flex items-center justify-between">
             <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full overflow-hidden border border-onyx/10">
                   <img src="{{ $appointment->lawyer->photo ? asset('storage/' . $appointment->lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($appointment->lawyer->full_name) . '&background=0D0D0D&color=D4AF37&size=200' }}" alt="{{ $appointment->lawyer->full_name }}" class="w-full h-full object-cover">
                </div>
                <div>
                  <p class="font-serif text-lg text-onyx">{{ $appointment->lawyer->full_name }}</p>
                  <p class="text-xs text-onyx/60 tracking-wide uppercase">{{ $appointment->lawyer->specialization }} Law</p>
                </div>
             </div>
             <a href="{{ route('public.lawyer', $appointment->lawyer->id) }}" class="w-10 h-10 flex items-center justify-center rounded-full border border-onyx/10 hover:bg-onyx hover:text-white transition-colors group-hover:bg-gold-500 group-hover:border-gold-500 group-hover:text-white">
                <svg class="w-4 h-4 translate-x-0 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
             </a>
          </div>
        </div>
        @endforeach
      </div>
    @else
      <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-20 text-center bespoke-card">
        <div class="w-16 h-16 rounded-full bg-onyx/5 flex items-center justify-center mb-6">
          <svg class="w-6 h-6 text-onyx/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
        </div>
        <h3 class="font-serif text-2xl text-onyx mb-2">No upcoming sessions</h3>
        <p class="text-sm font-light text-onyx/60 mb-8 max-w-sm">Your calendar is currently clear. Book a consultation with one of our legal professionals when you need assistance.</p>
        <a href="{{ route('customer.search') }}" class="btn-lux btn-lux-gold">Find Representation</a>
      </div>
    @endif
  </div>

  {{-- Pending and Completed in columns --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-20">

    {{-- Pending --}}
    <div>
      <h3 class="font-serif text-2xl text-onyx mb-8 border-l-4 border-gold-500 pl-6">Pending Requests</h3>
      @if($pendingAppointments->count())
        <div class="space-y-4">
          @foreach($pendingAppointments as $appointment)
          <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-6 hover:shadow-luxury transition-all duration-500 bespoke-card flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
              <p class="font-serif text-xl text-onyx mb-1">{{ $appointment->lawyer->full_name }}</p>
              <p class="text-sm text-onyx/60">{{ $appointment->subject }}</p>
            </div>
            <div class="text-left sm:text-right">
              <span class="inline-block px-4 py-2 text-xs border border-onyx/20 text-onyx/60 uppercase tracking-ultra flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-onyx/40"></span> Awaiting
              </span>
            </div>
          </div>
          @endforeach
        </div>
      @else
        <p class="text-sm text-onyx/40 italic">No pending requests.</p>
      @endif
    </div>

    {{-- Completed --}}
    <div>
      <h3 class="font-serif text-2xl text-onyx mb-8 border-l-4 border-onyx/20 pl-6">Previous History</h3>
      @if($completedAppointments->count())
        <div class="space-y-4">
          @foreach($completedAppointments as $appointment)
          <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-6 hover:shadow-luxury transition-all duration-500 bespoke-card flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
              <p class="font-serif text-xl text-onyx mb-1">{{ $appointment->lawyer->full_name }}</p>
              <p class="text-sm text-onyx/60">{{ $appointment->created_at->format('M j, Y') }}</p>
            </div>
            <div class="text-left sm:text-right">
              <span class="inline-block px-4 py-2 text-xs border border-onyx/20 text-onyx uppercase tracking-ultra">Completed</span>
            </div>
          </div>
          @endforeach
        </div>
      @else
        <p class="text-sm text-onyx/40 italic">No previous history.</p>
      @endif
    </div>

  </div>

</div>
@endsection
