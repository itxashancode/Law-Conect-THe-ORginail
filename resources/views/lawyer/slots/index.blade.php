@extends('layouts.lawyer')
@section('title', 'Manage Availability — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <div class="flex justify-between items-center mb-8">
    <h1 class="font-serif text-4xl text-ink">My Availability Slots</h1>
  </div>

  @if(session('success'))
    <div class="bg-green-100 border border-green-500 text-green-700 px-6 py-4 mb-6">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="bg-red-100 border border-red-500 text-red-700 px-6 py-4 mb-6">
      {{ session('error') }}
    </div>
  @endif

  {{-- Add New Slot Form --}}
  <div class="bg-warm-surface border border-warm-border p-6 mb-8">
    <h2 class="font-serif text-2xl text-ink mb-4">Add New Availability Slot</h2>
    <form method="POST" action="{{ route('lawyer.slots.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
      @csrf
      <div>
        <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Date</label>
        <input type="date" name="available_date" required min="{{ date('Y-m-d') }}" class="search-field">
      </div>
      <div>
        <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Start Time</label>
        <input type="time" name="start_time" required class="search-field">
      </div>
      <div>
        <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">End Time</label>
        <input type="time" name="end_time" required class="search-field">
      </div>
      <div>
        <button type="submit" class="btn-primary w-full">Add Slot</button>
      </div>
    </form>
  </div>

  {{-- Slots List --}}
  <div class="bg-warm-surface border border-warm-border">
    <div class="p-6 border-b border-warm-border">
      <h2 class="font-serif text-2xl text-ink">All Slots</h2>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left">
        <thead class="bg-ink text-white">
          <tr>
            <th class="px-6 py-4">Date</th>
            <th class="px-6 py-4">Time</th>
            <th class="px-6 py-4">Status</th>
            <th class="px-6 py-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($slots as $slot)
          <tr class="border-b border-warm-border hover:bg-parchment/30">
            <td class="px-6 py-4">
              {{ \Carbon\Carbon::parse($slot->available_date)->format('D, M j, Y') }}
            </td>
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
            <td class="px-6 py-4">
              @unless($slot->is_booked)
                <form method="POST" action="{{ route('lawyer.slots.destroy', $slot->id) }}" class="inline" onsubmit="return confirm('Delete this slot?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                </form>
              @else
                <span class="text-ink-muted text-sm">—</span>
              @endunless
            </td>
          </tr>
          @empty
          <tr><td colspan="4" class="px-6 py-10 text-center text-ink-muted">No slots created yet. Add your first slot above.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
