@extends('layouts.customer')
@section('title', 'Customer Dashboard — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <h1 class="font-serif text-4xl text-ink mb-2">My Dashboard</h1>
  <p class="text-ink-muted mb-8">Welcome, {{ $customer->name }}</p>

  {{-- Quick Actions --}}
  <div class="mb-10">
    <a href="{{ route('customer.search') }}" class="btn-primary">Find a Lawyer</a>
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
            <th class="px-6 py-4">Lawyer</th>
            <th class="px-6 py-4">Specialization</th>
            <th class="px-6 py-4">Date & Time</th>
            <th class="px-6 py-4">Subject</th>
            <th class="px-6 py-4">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($upcomingAppointments as $appointment)
          <tr class="border-b border-warm-border">
            <td class="px-6 py-4">{{ $appointment->lawyer->full_name }}</td>
            <td class="px-6 py-4">{{ $appointment->lawyer->specialization }}</td>
            <td class="px-6 py-4">
              {{ \Carbon\Carbon::parse($appointment->slot->available_date)->format('D, M j Y') }}<br>
              {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('g:i A') }}
            </td>
            <td class="px-6 py-4">{{ $appointment->subject }}</td>
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
  <div class="bg-warm-surface border border-warm-border mb-8">
    <div class="p-6 border-b border-warm-border">
      <h2 class="font-serif text-2xl text-ink">Pending Requests</h2>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left">
        <thead class="bg-ink text-white">
          <tr>
            <th class="px-6 py-4">Lawyer</th>
            <th class="px-6 py-4">Subject</th>
            <th class="px-6 py-4">Created</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pendingAppointments as $appointment)
          <tr class="border-b border-warm-border">
            <td class="px-6 py-4">{{ $appointment->lawyer->full_name }}</td>
            <td class="px-6 py-4">{{ $appointment->subject }}</td>
            <td class="px-6 py-4">{{ $appointment->created_at->format('M j, Y') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif

  {{-- Completed Appointments --}}
  @if($completedAppointments->count())
  <div class="bg-warm-surface border border-warm-border">
    <div class="p-6 border-b border-warm-border">
      <h2 class="font-serif text-2xl text-ink">Past Appointments</h2>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left">
        <thead class="bg-ink text-white">
          <tr>
            <th class="px-6 py-4">Lawyer</th>
            <th class="px-6 py-4">Subject</th>
            <th class="px-6 py-4">Date</th>
            <th class="px-6 py-4">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($completedAppointments as $appointment)
          <tr class="border-b border-warm-border">
            <td class="px-6 py-4">{{ $appointment->lawyer->full_name }}</td>
            <td class="px-6 py-4">{{ $appointment->subject }}</td>
            <td class="px-6 py-4">{{ $appointment->created_at->format('M j, Y') }}</td>
            <td class="px-6 py-4">
              <span class="inline-block px-3 py-1 text-xs border border-gray-500 text-gray-700">Completed</span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif

  @if(!$upcomingAppointments->count() && !$pendingAppointments->count() && !$completedAppointments->count())
    <div class="text-center py-20 text-ink-muted">
      <p>You haven't booked any appointments yet.</p>
      <a href="{{ route('customer.search') }}" class="btn-primary mt-4 inline-block">Find a Lawyer</a>
    </div>
  @endif
</div>
@endsection
