@extends('layouts.admin')
@section('title', 'All Bookings — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <h1 class="font-serif text-4xl text-ink mb-8">All Appointments</h1>

  <div class="bg-warm-surface border border-warm-border">
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left">
        <thead class="bg-ink text-white">
          <tr>
            <th class="px-6 py-4">ID</th>
            <th class="px-6 py-4">Customer</th>
            <th class="px-6 py-4">Lawyer</th>
            <th class="px-6 py-4">Subject</th>
            <th class="px-6 py-4">Meeting Place</th>
            <th class="px-6 py-4">Status</th>
            <th class="px-6 py-4">Created</th>
          </tr>
        </thead>
        <tbody>
          @forelse($appointments as $appointment)
          <tr class="border-b border-warm-border hover:bg-parchment/30">
            <td class="px-6 py-4">{{ $appointment->id }}</td>
            <td class="px-6 py-4">
              <p class="font-serif text-ink">{{ $appointment->customer->name }}</p>
              <p class="text-xs text-ink-muted">{{ $appointment->customer->email }}</p>
            </td>
            <td class="px-6 py-4">{{ $appointment->lawyer->full_name }}</td>
            <td class="px-6 py-4">{{ $appointment->subject }}</td>
            <td class="px-6 py-4">{{ $appointment->meeting_place ?? 'Not specified' }}</td>
            <td class="px-6 py-4">
              <span class="inline-block px-3 py-1 text-xs border
                @if($appointment->status === 'confirmed') border-green-500 text-green-700
                @elseif($appointment->status === 'pending') border-yellow-500 text-yellow-700
                @elseif($appointment->status === 'cancelled') border-red-500 text-red-700
                @else border-gray-500 text-gray-700
                @endif">
                {{ ucfirst($appointment->status) }}
              </span>
            </td>
            <td class="px-6 py-4">{{ $appointment->created_at->format('M j, Y') }}</td>
          </tr>
          @empty
          <tr><td colspan="7" class="px-6 py-10 text-center text-ink-muted">No appointments yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
