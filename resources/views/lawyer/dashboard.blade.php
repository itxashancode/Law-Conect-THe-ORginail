@extends('layouts.lawyer')
@section('title', 'My Dashboard — LegalCounsel')

@section('content')
<div class="pt-32 pb-20 px-6 lg:px-20 min-h-screen" data-aos="fade-up">

  {{-- Welcome Header --}}
  <div class="mb-16">
    <p class="text-[10px] font-bold tracking-widest uppercase text-gold-500 mb-3">Practice Overview</p>
    <h1 class="font-serif text-6xl md:text-8xl italic leading-none mb-4">{{ explode(' ', trim($lawyer->full_name))[0] }}'s Dashboard</h1>
  </div>

  {{-- Profile Completion Bar --}}
  @php
    $fields = ['full_name', 'bio', 'photo', 'address', 'phone', 'bar_license', 'specialization', 'city', 'experience_years', 'consultation_fee'];
    $completed = collect($fields)->filter(fn($f) => !empty($lawyer->$f))->count();
    $pct = round(($completed / count($fields)) * 100);
  @endphp
  @if($pct < 100)
  <div class="mb-10 bg-white border border-onyx/5 p-6">
    <div class="flex items-center justify-between mb-3">
      <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/40">Profile Completeness</p>
      <p class="text-[10px] font-bold tracking-widest text-onyx/60">{{ $pct }}%</p>
    </div>
    <div class="w-full bg-onyx/5 h-1.5 rounded-full">
      <div class="bg-gold-500 h-1.5 rounded-full transition-all duration-1000" style="width: {{ $pct }}%"></div>
    </div>
    <p class="text-[10px] text-onyx/30 mt-2">
      Complete your profile to appear in more search results.
      <a href="{{ route('lawyer.profile.edit') }}" class="text-gold-500 hover:text-gold-600 underline ml-1">Update Profile</a>
    </p>
  </div>
  @endif

  {{-- KPI Stats --}}
  <div class="grid grid-cols-3 gap-4 mb-12">
    <div class="bg-white border border-onyx/5 p-6">
      <p class="text-[9px] font-bold tracking-widest uppercase text-onyx/30 mb-2">Total Slots</p>
      <p class="font-serif text-4xl text-gold-600">{{ $totalSlots }}</p>
    </div>
    <div class="bg-white border border-onyx/5 p-6">
      <p class="text-[9px] font-bold tracking-widest uppercase text-onyx/30 mb-2">Booked</p>
      <p class="font-serif text-4xl text-onyx">{{ $bookedSlots }}</p>
    </div>
    <div class="bg-white border border-onyx/5 p-6">
      <p class="text-[9px] font-bold tracking-widest uppercase text-onyx/30 mb-2">Upcoming</p>
      <p class="font-serif text-4xl text-onyx">{{ $upcomingAppointments->count() }}</p>
    </div>
  </div>

  {{-- Upcoming Appointments Table --}}
  <div class="mb-12">
    <div class="flex items-center justify-between mb-6">
      <h2 class="font-serif text-3xl italic text-onyx">Upcoming Sessions</h2>
      <a href="{{ route('lawyer.slots.index') }}" class="text-[10px] font-bold tracking-widest uppercase text-gold-500 hover:text-gold-600 transition-colors flex items-center gap-1.5">
        Manage Calendar
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2"/></svg>
      </a>
    </div>

    @if($upcomingAppointments->count())
    <div class="bg-white border border-onyx/5 overflow-hidden">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b border-onyx/5 bg-onyx/[.02]">
            <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase">Date & Time</th>
            <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase">Client</th>
            <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase hidden md:table-cell">Matter</th>
            <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-onyx/5">
          @foreach($upcomingAppointments as $appointment)
          <tr class="hover:bg-onyx/[.02] transition-colors">
            <td class="px-6 py-4">
              @if($appointment->slot)
              <p class="text-[12px] font-medium text-onyx">{{ \Carbon\Carbon::parse($appointment->slot->available_date)->format('M j, Y') }}</p>
              <p class="text-[10px] text-onyx/40 uppercase tracking-wide">{{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('g:i A') }}</p>
              @else
              <p class="text-[10px] text-onyx/30 italic">Slot removed</p>
              @endif
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
                <div class="w-7 h-7 rounded-full bg-onyx flex items-center justify-center text-white text-[10px] font-bold shrink-0">
                  {{ strtoupper(substr($appointment->customer->name, 0, 1)) }}
                </div>
                <div>
                  <p class="text-[12px] font-medium text-onyx">{{ $appointment->customer->name }}</p>
                  <p class="text-[10px] text-onyx/40 hidden md:block">{{ $appointment->customer->email }}</p>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 hidden md:table-cell">
              <p class="text-[12px] text-onyx/70 max-w-[200px] truncate">{{ $appointment->subject }}</p>
            </td>
            <td class="px-6 py-4">
              <span class="text-[9px] font-bold tracking-widest uppercase px-2 py-1 border
                            {{ $appointment->status === 'confirmed' ? 'border-green-200 text-green-600 bg-green-50' :
                               ($appointment->status === 'pending' ? 'border-gold-200 text-gold-600 bg-gold-50' : 'border-onyx/10 text-onyx/40') }}">
                {{ $appointment->status }}
              </span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @else
    <div class="bg-white border border-onyx/5 p-16 text-center">
      <p class="font-serif text-xl italic text-onyx/30 mb-4">No upcoming sessions.</p>
      <a href="{{ route('lawyer.slots.index') }}" class="btn-lux btn-lux-gold">Add Availability Slots</a>
    </div>
    @endif
  </div>

  {{-- Pending Requests --}}
  @if($pendingAppointments->count())
  <div>
    <h2 class="font-serif text-3xl italic text-onyx mb-6">Pending Requests</h2>
    <div class="bg-white border border-onyx/5 overflow-hidden">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b border-onyx/5 bg-gold-50/50">
            <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-gold-600 uppercase">Client</th>
            <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-gold-600 uppercase hidden md:table-cell">Matter</th>
            <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-gold-600 uppercase">Requested</th>
            <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-gold-600 uppercase">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-onyx/5">
          @foreach($pendingAppointments as $appointment)
          <tr class="hover:bg-gold-50/30 transition-colors">
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
                <div class="w-7 h-7 rounded-full bg-gold-500 flex items-center justify-center text-white text-[10px] font-bold shrink-0">
                  {{ strtoupper(substr($appointment->customer->name, 0, 1)) }}
                </div>
                <p class="text-[12px] font-medium text-onyx">{{ $appointment->customer->name }}</p>
              </div>
            </td>
            <td class="px-6 py-4 hidden md:table-cell">
              <p class="text-[12px] text-onyx/60 max-w-[200px] truncate">{{ $appointment->subject }}</p>
            </td>
            <td class="px-6 py-4">
              <p class="text-[11px] text-onyx/40">{{ $appointment->created_at->diffForHumans() }}</p>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-4">
                <form action="{{ route('lawyer.appointments.confirm', $appointment->id) }}" method="POST">
                  @csrf
                  <button type="submit" class="text-[10px] font-bold tracking-widest uppercase text-green-600 hover:text-green-700 transition-colors">Confirm</button>
                </form>
                <form action="{{ route('lawyer.appointments.cancel', $appointment->id) }}" method="POST">
                  @csrf
                  <button type="submit" class="text-[10px] font-bold tracking-widest uppercase text-red-400 hover:text-red-600 transition-colors">Decline</button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif

</div>
@endsection
