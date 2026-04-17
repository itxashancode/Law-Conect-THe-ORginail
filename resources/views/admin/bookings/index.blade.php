@extends('layouts.admin')
@section('title', 'Appointments — LegalCounsel')
@section('page-title', 'Appointment Registry')
@section('page-subtitle', 'All booked and pending sessions')

@section('dashboard-content')

{{-- Tab Filter --}}
<div class="mb-6">
  <div class="flex gap-1 bg-white border border-onyx/5 p-1 w-fit mb-6">
    @foreach(['all' => 'All', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'cancelled' => 'Cancelled'] as $key => $label)
    <a href="{{ route('admin.bookings.index', ['status' => $key === 'all' ? null : $key]) }}"
       class="px-4 py-2 text-[10px] font-bold tracking-widest uppercase transition-colors duration-150
              {{ request('status', 'all') === $key ? 'bg-onyx text-white' : 'text-onyx/40 hover:text-onyx' }}">
      {{ $label }}
    </a>
    @endforeach
  </div>

  <div class="bg-white border border-onyx/5 overflow-hidden">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-onyx/5 bg-onyx/[.02]">
          <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase">#</th>
          <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase">Matter</th>
          <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase hidden md:table-cell">Client</th>
          <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase hidden lg:table-cell">Counsel</th>
          <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase hidden lg:table-cell">Date</th>
          <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase">Status</th>
          <th class="text-right px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-onyx/5">
        @forelse($appointments as $appointment)
        <tr class="hover:bg-onyx/[.02] transition-colors group">
          <td class="px-6 py-4 text-[11px] text-onyx/30 font-mono">#{{ str_pad($appointment->id, 4, '0', STR_PAD_LEFT) }}</td>
          <td class="px-6 py-4">
            <p class="font-medium text-onyx text-[13px] max-w-[180px] truncate">{{ $appointment->subject }}</p>
          </td>
          <td class="px-6 py-4 hidden md:table-cell">
            <p class="text-[12px] text-onyx/70">{{ $appointment->customer->name }}</p>
          </td>
          <td class="px-6 py-4 hidden lg:table-cell">
            <p class="text-[12px] text-onyx/70">{{ $appointment->lawyer->full_name }}</p>
          </td>
          <td class="px-6 py-4 hidden lg:table-cell">
            <p class="text-[11px] text-onyx/50">{{ $appointment->created_at->format('M j, Y') }}</p>
          </td>
          <td class="px-6 py-4">
            <span class="text-[9px] font-bold tracking-widest uppercase px-2 py-1 border
                          {{ $appointment->status === 'confirmed' ? 'border-green-200 text-green-600 bg-green-50' :
                             ($appointment->status === 'pending' ? 'border-gold-200 text-gold-600 bg-gold-50' : 'border-red-200 text-red-600 bg-red-50') }}">
              {{ $appointment->status }}
            </span>
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center justify-end gap-4">
              <form action="{{ route('admin.bookings.destroy', $appointment->id) }}" method="POST"
                    onsubmit="return luxuryConfirm(this, { title: 'Void Appointment', message: 'Cancel this session? The slot will be released back to the registry.' })">
                @csrf @method('DELETE')
                <button type="submit"
                        class="text-[10px] font-bold tracking-widest uppercase text-red-400 hover:text-red-600 transition-colors">
                  Cancel
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="px-6 py-16 text-center">
            <p class="font-serif text-xl text-onyx/30 italic">No appointments found.</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
