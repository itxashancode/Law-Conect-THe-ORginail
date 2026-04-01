@extends('layouts.customer')
@section('title', 'My Appointments — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <h1 class="font-serif text-4xl text-ink mb-8">My Appointments</h1>

  @if(session('success'))
    <div class="bg-green-100 border border-green-500 text-green-700 px-6 py-4 mb-6">
      {{ session('success') }}
    </div>
  @endif

  <div class="bg-warm-surface border border-warm-border">
    @forelse($appointments as $appointment)
    <div class="p-6 border-b border-warm-border hover:bg-parchment/30 transition-colors">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <h3 class="font-serif text-xl text-ink">{{ $appointment->lawyer->full_name }}</h3>
          <p class="text-sm text-ink-muted">{{ $appointment->lawyer->specialization }} · {{ $appointment->lawyer->city }}</p>
          <p class="text-sm text-ink mt-2">
            <span class="text-ink-muted">Subject:</span> {{ $appointment->subject }}
          </p>
          @if($appointment->meeting_place)
            <p class="text-sm text-ink">
              <span class="text-ink-muted">Meeting:</span> {{ $appointment->meeting_place }}
            </p>
          @endif
          <p class="text-sm text-ink mt-2">
            <span class="text-ink-muted">When:</span>
            {{ \Carbon\Carbon::parse($appointment->slot->available_date)->format('D, M j, Y') }} at
            {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('g:i A') }} -
            {{ \Carbon\Carbon::parse($appointment->slot->end_time)->format('g:i A') }}
          </p>
        </div>
        <div class="flex items-center gap-4">
          <span class="inline-block px-4 py-2 text-xs border
            @if($appointment->status === 'confirmed') border-green-500 text-green-700
            @elseif($appointment->status === 'pending') border-yellow-500 text-yellow-700
            @else border-red-500 text-red-700
            @endif">
            {{ ucfirst($appointment->status) }}
          </span>
          @if($appointment->status === 'confirmed' || $appointment->status === 'pending')
            <form method="POST" action="{{ route('customer.appointments.cancel', $appointment->id) }}" class="inline" onsubmit="return confirm('Cancel this appointment?')">
              @csrf @method('DELETE')
              <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">Cancel</button>
            </form>
          @endif
        </div>
      </div>
    </div>
    @empty
    <div class="p-10 text-center text-ink-muted">
      <p>You haven't booked any appointments yet.</p>
      <a href="{{ route('customer.search') }}" class="btn-primary mt-4 inline-block">Find a Lawyer</a>
    </div>
    @endforelse
  </div>
</div>
@endsection
