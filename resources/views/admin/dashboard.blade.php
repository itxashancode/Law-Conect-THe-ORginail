@extends('layouts.admin')
@section('title', 'Executive Dashboard — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  {{-- Premium Stats Header --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
    <x-card description="TOTAL NETWORK COUNSEL">
      <div class="flex items-end justify-between">
        <p class="font-serif text-5xl text-gold-600">{{ $totalLawyers }}</p>
        <div class="w-10 h-10 rounded-full bg-onyx/5 flex items-center justify-center">
            <svg class="w-5 h-5 text-onyx/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m12-14a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
        </div>
      </div>
    </x-card>

    <x-card description="AWAITING AUDIT">
      <div class="flex items-end justify-between">
        <p class="font-serif text-5xl text-gold-600">{{ $pendingLawyers }}</p>
        <div class="w-10 h-10 rounded-full bg-gold-500/5 flex items-center justify-center">
            <svg class="w-5 h-5 text-gold-500/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
        </div>
      </div>
    </x-card>

    <x-card description="SYSTEM ENGAGEMENT">
      <div class="flex items-end justify-between">
        <p class="font-serif text-5xl text-gold-600">{{ $totalBookings }}</p>
        <div class="w-10 h-10 rounded-full bg-onyx/5 flex items-center justify-center">
            <svg class="w-5 h-5 text-onyx/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
        </div>
      </div>
    </x-card>

    <x-card description="LIVE CAPACITY">
      <div class="flex items-end justify-between">
        <p class="font-serif text-5xl text-gold-600">{{ $totalSlots - $bookedSlots }}</p>
        <div class="w-10 h-10 rounded-full bg-onyx/5 flex items-center justify-center">
            <svg class="w-5 h-5 text-onyx/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
      </div>
    </x-card>
  </div>

  {{-- Strategic Overview Grid --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-16">
    {{-- Recent Lawyers --}}
    <x-card title="Counsel Verification" description="LATEST REGISTRATION ATTEMPTS">
      <div class="space-y-6">
        @forelse($recentLawyers as $lawyer)
          <div class="flex items-center justify-between group/row p-2 hover:bg-onyx/5 transition-colors duration-300">
            <div class="flex items-center gap-4">
              <div class="w-10 h-10 rounded-full border border-onyx/10 flex items-center justify-center overflow-hidden">
                <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=0D0D0D&color=D4AF37' }}" 
                     class="w-full h-full object-cover">
              </div>
              <div>
                <p class="text-sm font-medium text-onyx">{{ $lawyer->full_name }}</p>
                <p class="text-[10px] text-onyx/40">{{ strtoupper($lawyer->specialization) }} • {{ strtoupper($lawyer->city) }}</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              @if($lawyer->status === 'pending')
                <div class="flex gap-2">
                  <form action="{{ route('admin.lawyers.approve', $lawyer->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-[9px] font-bold tracking-ultra text-gold-600 hover:text-gold-700 uppercase">Approve</button>
                  </form>
                  <form action="{{ route('admin.lawyers.reject', $lawyer->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-[9px] font-bold tracking-ultra text-red-400 hover:text-red-600 uppercase">Reject</button>
                  </form>
                </div>
              @else
                 <span class="text-[9px] tracking-ultra text-onyx/20 uppercase font-bold">{{ $lawyer->status }}</span>
              @endif
            </div>
          </div>
        @empty
          <p class="text-[10px] text-onyx/30 italic uppercase tracking-widest text-center py-10">No recent applications.</p>
        @endforelse
      </div>
    </x-card>

    {{-- Recent Bookings --}}
    <x-card title="Platform Activity" description="LATEST CLIENT INTERACTIONS">
      <div class="grid grid-cols-1 gap-4">
        @forelse($recentAppointments as $booking)
          <div class="border border-onyx/5 p-4 group/item hover:bg-onyx/5 transition-all duration-300 flex justify-between items-center">
             <div>
                <p class="text-[9px] tracking-ultra text-onyx/40 uppercase mb-1">{{ $booking->created_at->format('M j, H:i') }}</p>
                <p class="text-sm font-serif text-onyx leading-tight">{{ $booking->subject }}</p>
                <p class="text-[10px] text-onyx/60 italic">{{ $booking->customer->name }} with {{ $booking->lawyer->full_name }}</p>
             </div>
             <div>
                <span class="text-[9px] tracking-ultra px-2 py-0.5 border border-onyx/10 uppercase font-bold text-onyx/40">{{ $booking->status }}</span>
             </div>
          </div>
        @empty
           <p class="text-[10px] text-onyx/30 italic uppercase tracking-widest text-center py-10">No activity recorded.</p>
        @endforelse
      </div>
      <div class="mt-8 pt-4 border-t border-onyx/5">
         <a href="{{ route('admin.bookings.index') }}" class="text-[9px] font-bold tracking-ultra text-onyx/40 hover:text-onyx uppercase transition-colors flex items-center gap-2">
            View All Transactions
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
         </a>
      </div>
    </x-card>
  </div>
</div>
@endsection
