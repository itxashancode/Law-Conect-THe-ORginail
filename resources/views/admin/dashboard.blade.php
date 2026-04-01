@extends('layouts.admin')
@section('title', 'Admin Dashboard — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <h1 class="font-serif text-4xl text-ink mb-8">Admin Dashboard</h1>

  {{-- Statistics Cards --}}
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="bg-warm-surface border border-warm-border p-6">
      <p class="text-ink-muted text-xs tracking-widest uppercase mb-2">Total Lawyers</p>
      <p class="font-serif text-3xl text-ink">{{ $totalLawyers }}</p>
    </div>
    <div class="bg-warm-surface border border-warm-border p-6">
      <p class="text-ink-muted text-xs tracking-widest uppercase mb-2">Pending Lawyers</p>
      <p class="font-serif text-3xl text-ink">{{ $pendingLawyers }}</p>
    </div>
    <div class="bg-warm-surface border border-warm-border p-6">
      <p class="text-ink-muted text-xs tracking-widest uppercase mb-2">Total Bookings</p>
      <p class="font-serif text-3xl text-ink">{{ $totalBookings }}</p>
    </div>
    <div class="bg-warm-surface border border-warm-border p-6">
      <p class="text-ink-muted text-xs tracking-widest uppercase mb-2">Available Slots</p>
      <p class="font-serif text-3xl text-ink">{{ $totalSlots - $bookedSlots }}</p>
    </div>
  </div>

  {{-- Recent Lawyers --}}
  <div class="bg-warm-surface border border-warm-border mb-10">
    <div class="p-6 border-b border-warm-border">
      <h2 class="font-serif text-2xl text-ink">Recent Lawyer Registrations</h2>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left">
        <thead class="bg-ink text-white">
          <tr>
            <th class="px-6 py-4">Name</th>
            <th class="px-6 py-4">Specialization</th>
            <th class="px-6 py-4">City</th>
            <th class="px-6 py-4">Status</th>
            <th class="px-6 py-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recentLawyers as $lawyer)
          <tr class="border-b border-warm-border">
            <td class="px-6 py-4">{{ $lawyer->full_name }}</td>
            <td class="px-6 py-4">{{ $lawyer->specialization }}</td>
            <td class="px-6 py-4">{{ $lawyer->city }}</td>
            <td class="px-6 py-4">
              <span class="inline-block px-3 py-1 text-xs border
                @if($lawyer->status === 'approved') border-green-500 text-green-700
                @elseif($lawyer->status === 'pending') border-yellow-500 text-yellow-700
                @else border-red-500 text-red-700
                @endif">
                {{ ucfirst($lawyer->status) }}
              </span>
            </td>
            <td class="px-6 py-4">
              @if($lawyer->status === 'pending')
                <form method="POST" action="{{ route('admin.lawyers.approve', $lawyer->id) }}" class="inline">
                  @csrf @method('POST')
                  <button type="submit" class="text-green-600 hover:text-green-800 mr-3">Approve</button>
                </form>
                <form method="POST" action="{{ route('admin.lawyers.reject', $lawyer->id) }}" class="inline" onsubmit="return confirm('Reject this lawyer?')">
                  @csrf @method('POST')
                  <button type="submit" class="text-red-600 hover:text-red-800">Reject</button>
                </form>
              @endif
            </td>
          </tr>
          @empty
          <tr><td colspan="5" class="px-6 py-4 text-ink-muted">No recent registrations.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Recent Appointments --}}
  <div class="bg-warm-surface border border-warm-border">
    <div class="p-6 border-b border-warm-border">
      <h2 class="font-serif text-2xl text-ink">Recent Appointments</h2>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left">
        <thead class="bg-ink text-white">
          <tr>
            <th class="px-6 py-4">Customer</th>
            <th class="px-6 py-4">Lawyer</th>
            <th class="px-6 py-4">Subject</th>
            <th class="px-6 py-4">Status</th>
            <th class="px-6 py-4">Date</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recentAppointments as $appointment)
          <tr class="border-b border-warm-border">
            <td class="px-6 py-4">{{ $appointment->customer->name }}</td>
            <td class="px-6 py-4">{{ $appointment->lawyer->full_name }}</td>
            <td class="px-6 py-4">{{ $appointment->subject }}</td>
            <td class="px-6 py-4">{{ ucfirst($appointment->status) }}</td>
            <td class="px-6 py-4">{{ $appointment->created_at->format('M j, Y') }}</td>
          </tr>
          @empty
          <tr><td colspan="5" class="px-6 py-4 text-ink-muted">No appointments yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
