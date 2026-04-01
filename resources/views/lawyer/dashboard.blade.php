@extends('layouts.lawyer')
@section('title', 'Lawyer Dashboard — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <h1 class="font-serif text-4xl text-ink mb-2">Welcome, {{ $lawyer->full_name }}</h1>
  <p class="text-ink-muted mb-8">{{ $lawyer->specialization }} · {{ $lawyer->city }}</p>

  {{-- Statistics --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-warm-surface border border-warm-border p-6">
      <p class="text-ink-muted text-xs tracking-widest uppercase mb-2">Total Slots</p>
      <p class="font-serif text-3xl text-ink">{{ $totalSlots }}</p>
    </div>
    <div class="bg-warm-surface border border-warm-border p-6">
      <p class="text-ink-muted text-xs tracking-widest uppercase mb-2">Booked Slots</p>
      <p class="font-serif text-3xl text-ink">{{ $bookedSlots }}</p>
    </div>
    <div class="bg-warm-surface border border-warm-border p-6">
      <p class="text-ink-muted text-xs tracking-widest uppercase mb-2">Upcoming Appointments</p>
      <p class="font-serif text-3xl text-ink">{{ $upcomingAppointments->count() }}</p>
    </div>
  </div>

  {{-- Quick Actions --}}
  <div class="mb-10">
    <h2 class="font-serif text-2xl text-ink mb-4">Quick Actions</h2>
    <div class="flex flex-wrap gap-4">
      <a href="{{ route('lawyer.slots.index') }}" class="btn-primary">Manage Availability</a>
      <a href="{{ route('lawyer.profile.edit') }}" class="btn-ghost">Edit Profile</a>
    </div>
  </div>

  {{-- Upcoming Appointments --}}
  @if($upcomingAppointments->count())
  <div class="bg-warm-surface border border-warm-border mb-8">
    <div class="p-6 border-b border-warm-border">
      <h2 class="font-serif text-2xl text-ink">Upcoming Appointments</h2>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left">
        <thead class="bg-ink text-white">
          <tr>
            <th class="px-6 py-4">Customer</th>
            <th class="px-6 py-4">Subject</th>
            <th class="px-6 py-4">Date & Time</th>
            <th class="px-6 py-4">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($upcomingAppointments as $appointment)
          <tr class="border-b border-warm-border">
            <td class="px-6 py-4">
              <p class="font-serif text-ink">{{ $appointment->customer->name }}</p>
              <p class="text-xs text-ink-muted">{{ $appointment->customer->email }}</p>
            </td>
            <td class="px-6 py-4">{{ $appointment->subject }}</td>
            <td class="px-6 py-4">
              {{ \Carbon\Carbon::parse($appointment->slot->available_date)->format('D, M j Y') }}<br>
              {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('g:i A') }}
            </td>
            <td class="px-6 py-4">
              <span class="inline-block px-3 py-1 text-xs border border-green-500 text-green-700">Confirmed</span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif

  {{-- Pending Appointments --}}
  @if($pendingAppointments->count())
  <div class="bg-warm-surface border border-warm-border">
    <div class="p-6 border-b border-warm-border">
      <h2 class="font-serif text-2xl text-ink">Pending Confirmations</h2>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left">
        <thead class="bg-ink text-white">
          <tr>
            <th class="px-6 py-4">Customer</th>
            <th class="px-6 py-4">Subject</th>
            <th class="px-6 py-4">Created</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pendingAppointments as $appointment)
          <tr class="border-b border-warm-border">
            <td class="px-6 py-4">{{ $appointment->customer->name }}</td>
            <td class="px-6 py-4">{{ $appointment->subject }}</td>
            <td class="px-6 py-4">{{ $appointment->created_at->format('M j, Y') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif
</div>
@endsection
