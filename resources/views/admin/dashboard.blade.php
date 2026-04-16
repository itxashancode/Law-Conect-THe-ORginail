@extends('layouts.admin')
@section('title', 'Executive Dashboard — LegalCounsel')
@section('page-title', 'Executive Overview')
@section('page-subtitle', 'Platform health at a glance')

@section('dashboard-content')

{{-- KPI Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
  @php
    $kpis = [
       ['label' => 'Total Lawyers',       'value' => $totalLawyers,   'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'highlight' => false],
       ['label' => 'Total Customers',     'value' => \App\Models\User::role('customer')->count(), 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'highlight' => false],
       ['label' => 'Pending Audit',       'value' => $pendingLawyers, 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'highlight' => true],
       ['label' => 'Total Appointments',  'value' => $totalBookings,  'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'highlight' => false],
      ['label' => 'Open Slots',          'value' => $totalSlots - $bookedSlots, 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'highlight' => false],
    ];
  @endphp

  @foreach($kpis as $kpi)
  <div class="bg-white border border-onyx/5 p-6 relative overflow-hidden hover:shadow-md transition-shadow duration-300 group">
    <div class="flex items-start justify-between mb-4">
      <div class="w-10 h-10 rounded-xl flex items-center justify-center
                  {{ $kpi['highlight'] ? 'bg-gold-500/10' : 'bg-onyx/5' }}">
        <svg class="w-5 h-5 {{ $kpi['highlight'] ? 'text-gold-500' : 'text-onyx/40' }}"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $kpi['icon'] }}"/>
        </svg>
      </div>
      @if($kpi['highlight'] && $kpi['value'] > 0)
        <span class="text-[9px] font-bold tracking-widest text-gold-600 bg-gold-50 border border-gold-200 px-2 py-0.5 uppercase">Needs Action</span>
      @endif
    </div>
    <p class="font-serif text-4xl xl:text-5xl text-onyx mb-1">{{ $kpi['value'] }}</p>
    <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/40">{{ $kpi['label'] }}</p>
  </div>
  @endforeach
</div>

{{-- Main content grid --}}
<div class="grid grid-cols-1 xl:grid-cols-5 gap-8">

  {{-- Lawyers Table (3/5 width) --}}
  <div class="xl:col-span-3 bg-white border border-onyx/5">
    <div class="flex items-center justify-between px-6 py-4 border-b border-onyx/5">
      <div>
        <h2 class="font-serif text-xl text-onyx">Counsel Registry</h2>
        <p class="text-[10px] tracking-widest uppercase text-onyx/30 mt-0.5">Latest registrations</p>
      </div>
      <a href="{{ route('admin.lawyers.index') }}" class="text-[10px] font-bold tracking-widest uppercase text-gold-500 hover:text-gold-600 transition-colors flex items-center gap-1.5">
        View All
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2"/></svg>
      </a>
    </div>
    <div class="divide-y divide-onyx/5">
      @forelse($recentLawyers as $lawyer)
      <div class="flex items-center gap-4 px-6 py-4 hover:bg-onyx/[.02] transition-colors group">
        <div class="w-9 h-9 rounded-full overflow-hidden border border-onyx/10 shrink-0">
          <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name='.urlencode($lawyer->full_name).'&background=0D0D0D&color=D4AF37' }}"
               alt="{{ $lawyer->full_name }}"
               class="w-full h-full object-cover">
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-medium text-onyx truncate">{{ $lawyer->full_name }}</p>
          <p class="text-[10px] text-onyx/40 uppercase tracking-wide">{{ $lawyer->specialization }} • {{ $lawyer->city }}</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
          <span class="text-[9px] font-bold tracking-widest uppercase px-2 py-0.5 border
                        {{ $lawyer->status === 'approved' ? 'border-green-200 text-green-600 bg-green-50' :
                           ($lawyer->status === 'pending' ? 'border-gold-200 text-gold-600 bg-gold-50' : 'border-red-200 text-red-600 bg-red-50') }}">
            {{ $lawyer->status }}
          </span>
          @if($lawyer->status === 'pending')
          <form action="{{ route('admin.lawyers.approve', $lawyer->id) }}" method="POST">
            @csrf
            <button type="submit" class="text-[10px] font-bold tracking-widest uppercase text-onyx/30 hover:text-onyx transition-colors">
              Approve ↗
            </button>
          </form>
          @endif
        </div>
      </div>
      @empty
      <div class="px-6 py-12 text-center">
        <p class="text-sm text-onyx/30 italic">No registrations yet.</p>
      </div>
      @endforelse
    </div>
  </div>

  {{-- Recent Activity (2/5 width) --}}
  <div class="xl:col-span-2 bg-white border border-onyx/5">
    <div class="flex items-center justify-between px-6 py-4 border-b border-onyx/5">
      <div>
        <h2 class="font-serif text-xl text-onyx">Session Activity</h2>
        <p class="text-[10px] tracking-widest uppercase text-onyx/30 mt-0.5">Latest bookings</p>
      </div>
      <a href="{{ route('admin.bookings.index') }}" class="text-[10px] font-bold tracking-widest uppercase text-gold-500 hover:text-gold-600 transition-colors flex items-center gap-1.5">
        All
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2"/></svg>
      </a>
    </div>
    <div class="divide-y divide-onyx/5">
      @forelse($recentAppointments as $booking)
      <div class="px-6 py-4 hover:bg-onyx/[.02] transition-colors">
        <div class="flex items-center justify-between mb-1.5">
          <p class="text-sm font-serif text-onyx leading-tight truncate max-w-[60%]">{{ $booking->subject }}</p>
          <span class="text-[9px] font-bold tracking-widest uppercase px-2 py-0.5 border
                        {{ $booking->status === 'confirmed' ? 'border-green-200 text-green-600' :
                           ($booking->status === 'pending' ? 'border-gold-200 text-gold-600' : 'border-onyx/10 text-onyx/40') }}">
            {{ $booking->status }}
          </span>
        </div>
        <p class="text-[10px] text-onyx/50">{{ $booking->customer->name }} → {{ $booking->lawyer->full_name }}</p>
        <p class="text-[9px] text-onyx/30 mt-1">{{ $booking->created_at->diffForHumans() }}</p>
      </div>
      @empty
      <div class="px-6 py-12 text-center">
        <p class="text-sm text-onyx/30 italic">No activity recorded.</p>
      </div>
      @endforelse
    </div>
  </div>

</div>

@endsection
