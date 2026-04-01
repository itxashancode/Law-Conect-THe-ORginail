@extends('layouts.admin')
@section('title', 'All Availability Slots — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <h1 class="font-serif text-4xl text-ink mb-8">Availability Slots</h1>

  <div class="bg-warm-surface border border-warm-border">
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left">
        <thead class="bg-ink text-white">
          <tr>
            <th class="px-6 py-4">ID</th>
            <th class="px-6 py-4">Lawyer</th>
            <th class="px-6 py-4">Date</th>
            <th class="px-6 py-4">Time</th>
            <th class="px-6 py-4">Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($slots as $slot)
          <tr class="border-b border-warm-border hover:bg-parchment/30">
            <td class="px-6 py-4">{{ $slot->id }}</td>
            <td class="px-6 py-4">{{ $slot->lawyer->full_name }}</td>
            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($slot->available_date)->format('D, M j, Y') }}</td>
            <td class="px-6 py-4">
              {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} -
              {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}
            </td>
            <td class="px-6 py-4">
              @if($slot->is_booked)
                <span class="inline-block px-3 py-1 text-xs border border-red-500 text-red-700">Booked</span>
              @else
                <span class="inline-block px-3 py-1 text-xs border border-green-500 text-green-700">Available</span>
              @endif
            </td>
          </tr>
          @empty
          <tr><td colspan="5" class="px-6 py-10 text-center text-ink-muted">No availability slots yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
