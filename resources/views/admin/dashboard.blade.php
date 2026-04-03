@extends('layouts.admin')
@section('title', 'Admin Dashboard — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <h1 class="font-serif text-6xl text-onyx mb-12">Admin Dashboard</h1>

  {{-- Statistics --}}
  <div class="flex flex-wrap gap-6 mb-16">
    <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-8 min-w-[200px]">
      <p class="text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Total Lawyers</p>
      <p class="font-serif text-4xl text-gold-600">{{ $totalLawyers }}</p>
    </div>
    <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-8 min-w-[200px]">
      <p class="text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Pending Lawyers</p>
      <p class="font-serif text-4xl text-gold-600">{{ $pendingLawyers }}</p>
    </div>
    <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-8 min-w-[200px]">
      <p class="text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Total Bookings</p>
      <p class="font-serif text-4xl text-gold-600">{{ $totalBookings }}</p>
    </div>
    <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-8 min-w-[200px]">
      <p class="text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Available Slots</p>
      <p class="font-serif text-4xl text-gold-600">{{ $totalSlots - $bookedSlots }}</p>
    </div>
  </div>

  {{-- Recent Lawyers --}}
  <div class="mb-16">
    <h2 class="font-serif text-3xl text-onyx mb-8">Recent Lawyer Registrations</h2>
    <div class="space-y-4">
      @forelse($recentLawyers as $lawyer)
      <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-6 hover:shadow-luxury hover:-translate-y-1 transition-all duration-500 bespoke-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div class="flex items-center gap-6">
            <div class="w-16 h-16 overflow-hidden border border-onyx/10 shrink-0">
              <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=0D0D0D&color=D4AF37' }}"
                   alt="{{ $lawyer->full_name }}"
                   class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
            </div>
            <div>
              <div class="flex items-center gap-3">
                <h4 class="font-serif text-2xl text-onyx">{{ $lawyer->full_name }}</h4>
                @if($lawyer->status === 'approved')
                  <span class="w-2 h-2 rounded-full bg-gold-600" title="Approved"></span>
                @elseif($lawyer->status === 'pending')
                  <span class="w-2 h-2 rounded-full bg-onyx/40" title="Pending"></span>
                @else
                  <span class="w-2 h-2 rounded-full bg-onyx/60" title="Rejected"></span>
                @endif
              </div>
              <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/50 mt-1">{{ $lawyer->specialization }} Law • {{ $lawyer->city }} • {{ $lawyer->experience_years }} Yrs Exp</p>
              <p class="text-sm font-light text-onyx/40 mt-1">{{ $lawyer->user->email }} • {{ $lawyer->phone }}</p>
            </div>
          </div>

          <div class="flex items-center gap-4">
            @if($lawyer->status === 'pending')
              <form method="POST" action="{{ route('admin.lawyers.approve', $lawyer->id) }}" class="inline">
                @csrf @method('POST')
                <button type="submit" class="btn-lux btn-lux-outline text-xs">Approve</button>
              </form>
              <form method="POST" action="{{ route('admin.lawyers.reject', $lawyer->id) }}" class="inline" onsubmit="return confirm('Reject this lawyer?')">
                @csrf @method('POST')
                <button type="submit" class="btn-lux btn-lux-ghost text-xs text-onyx/60 hover:text-onyx">Reject</button>
              </form>
            @else
              <span class="inline-block px-4 py-2 text-xs border border-onyx/20 text-onyx uppercase tracking-ultra {{ $lawyer->status === 'approved' ? 'bg-onyx text-white border-onyx' : '' }}">{{ ucfirst($lawyer->status) }}</span>
            @endif
          </div>
        </div>
      </div>
      @empty
      <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-16 text-center bespoke-card">
        <p class="font-serif text-2xl text-onyx/60 italic">No lawyer registrations yet.</p>
      </div>
      @endforelse
    </div>
  </div>

  {{-- Recent Appointments --}}
  <div>
    <h2 class="font-serif text-3xl text-onyx mb-8">Recent Appointments</h2>
    <div class="space-y-4">
      @forelse($recentAppointments as $appointment)
      <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-6 hover:shadow-luxury hover:-translate-y-1 transition-all duration-500 bespoke-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div class="flex-1">
            <h4 class="font-serif text-xl text-onyx mb-2">{{ $appointment->subject }}</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-onyx/60">
              <div>
                <p class="text-[10px] tracking-ultra uppercase mb-1">Customer</p>
                <p>{{ $appointment->customer->name }}</p>
              </div>
              <div>
                <p class="text-[10px] tracking-ultra uppercase mb-1">Lawyer</p>
                <p>{{ $appointment->lawyer->full_name }}</p>
              </div>
              <div>
                <p class="text-[10px] tracking-ultra uppercase mb-1">Date</p>
                <p>{{ $appointment->created_at->format('M j, Y') }}</p>
              </div>
            </div>
          </div>
          <div class="flex items-center gap-4">
            <span class="inline-block px-4 py-2 text-xs border border-onyx/20 text-onyx uppercase tracking-ultra">{{ ucfirst($appointment->status) }}</span>
          </div>
        </div>
      </div>
      @empty
      <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-16 text-center bespoke-card">
        <p class="font-serif text-2xl text-onyx/60 italic">No appointments yet.</p>
      </div>
      @endforelse
    </div>
  </div>
</div>
@endsection
