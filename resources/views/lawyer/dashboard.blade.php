@extends('layouts.lawyer')
@section('title', 'Lawyer Dashboard — LegalCounsel')

@section('content')
<div data-aos="fade-up">

  {{-- Welcome & Stats --}}
  <div class="mb-20">
    <h1 class="font-serif text-7xl md:text-9xl italic mb-10">Welcome, {{ explode(' ', trim($lawyer->full_name))[0] }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-10 bespoke-card">
        <p class="text-[10px] tracking-ultra uppercase text-onyx/40 mb-4 border-b border-onyx/5 pb-4">Total Availability</p>
        <p class="font-serif text-5xl text-gold-600">{{ $totalSlots }} <span class="text-sm font-sans text-onyx/40 not-italic">SLOTS</span></p>
      </div>
      <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-10 bespoke-card border-onyx/10">
        <p class="text-[10px] tracking-ultra uppercase text-onyx/40 mb-4 border-b border-onyx/5 pb-4">Booked Sessions</p>
        <p class="font-serif text-5xl text-gold-600">{{ $bookedSlots }} <span class="text-sm font-sans text-onyx/40 not-italic">SLOTS</span></p>
      </div>
      <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-10 bespoke-card">
        <p class="text-[10px] tracking-ultra uppercase text-onyx/40 mb-4 border-b border-onyx/5 pb-4">Upcoming</p>
        <p class="font-serif text-5xl text-gold-600">{{ $upcomingAppointments->count() }} <span class="text-sm font-sans text-onyx/40 not-italic">THIS MONTH</span></p>
      </div>
    </div>
  </div>

  {{-- Upcoming Appointments --}}
  <div class="mb-20">
    <div class="flex items-center justify-between mb-12 border-b border-onyx/5 pb-6">
      <h2 class="font-serif text-5xl text-onyx">Upcoming Sessions</h2>
      <a href="{{ route('lawyer.slots.index') }}" class="btn-lux btn-lux-outline">Manage Calendar</a>
    </div>

    @if($upcomingAppointments->count())
      <div class="space-y-4">
        @foreach($upcomingAppointments as $appointment)
        <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-8 hover:shadow-luxury hover:-translate-y-1 transition-all duration-700 bespoke-card flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
          <div class="flex items-center gap-6">
            <div class="w-16 h-16 bg-onyx/5 rounded-full flex items-center justify-center text-gold-600 font-serif text-2xl group-hover:scale-110 transition-transform duration-500">
              {{ strtoupper(substr($appointment->customer->name, 0, 1)) }}
            </div>
            <div>
              <p class="text-[10px] tracking-ultra uppercase text-gold-500 mb-2">{{ \Carbon\Carbon::parse($appointment->slot->available_date)->format('D, M j Y') }} at {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('g:i A') }}</p>
              <h4 class="font-serif text-2xl text-onyx group-hover:text-gold-600 transition-colors">{{ $appointment->subject }}</h4>
              <p class="text-sm text-onyx/60">{{ $appointment->customer->name }} • {{ $appointment->customer->email }}</p>
            </div>
          </div>
          <div class="md:text-right">
            <span class="inline-block px-4 py-2 text-xs border border-onyx/20 text-onyx uppercase tracking-ultra">Confirmed</span>
          </div>
        </div>
        @endforeach
      </div>
    @else
      <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-20 text-center bespoke-card">
        <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/30 mb-4">Schedule</p>
        <p class="font-serif text-2xl text-onyx/60 italic">No upcoming sessions confirmed at this time.</p>
      </div>
    @endif
  </div>

  {{-- Pending Appointments --}}
  @if($pendingAppointments->count())
  <div>
    <div class="flex items-center justify-between mb-12 border-b border-onyx/5 pb-6">
      <h2 class="font-serif text-5xl text-onyx border-l-4 border-gold-500 pl-6">Pending Requests</h2>
    </div>

    <div class="space-y-4">
      @foreach($pendingAppointments as $appointment)
      <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-6 hover:shadow-luxury transition-all duration-700 bespoke-card flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
          <h4 class="font-serif text-xl text-onyx mb-1">{{ $appointment->subject }}</h4>
          <p class="text-sm text-onyx/60">Requested by {{ $appointment->customer->name }} on {{ $appointment->created_at->format('M j, Y') }}</p>
        </div>
        <div class="text-left sm:text-right">
          <span class="inline-block px-4 py-2 text-xs border border-onyx/20 text-onyx/60 uppercase tracking-ultra flex items-center gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-onyx/40"></span> Awaiting Confirmation
          </span>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif

</div>
@endsection
