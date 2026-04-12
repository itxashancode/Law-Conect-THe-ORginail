@extends('layouts.admin')
@section('title', 'All Bookings — LegalCounsel')

@section('dashboard-content')
<div data-aos="fade-up">
  <div class="flex justify-between items-center mb-12 border-b border-onyx/5 pb-6">
    <h2 class="font-serif text-5xl text-onyx">Platform Appointments</h2>
  </div>

  <div class="flex justify-between items-center mb-8 border-b border-onyx/5 pb-2">
  @if($appointments->count())
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach($appointments as $appointment)
      <div class="bg-white/40 backdrop-blur-md border border-onyx/5 p-8 hover:shadow-premium transition-all duration-700 bespoke-card group relative overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
        {{-- Luxury status indicator dot --}}
        <div class="absolute top-0 right-0 p-6 flex items-center gap-2">
           @if($appointment->status === 'confirmed')
             <span class="w-2 h-2 rounded-full bg-gold-500 shadow-[0_0_10px_rgba(212,175,55,0.8)]"></span>
           @else
             <span class="w-2 h-2 rounded-full bg-onyx/20"></span>
           @endif
        </div>

        <div class="mb-8">
          <p class="text-[9px] font-bold tracking-widest text-gold-500 uppercase mb-3">Matter</p>
          <h4 class="font-serif text-2xl text-onyx leading-tight mb-2 italic">"{{ $appointment->subject }}"</h4>
          <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/40">{{ $appointment->created_at->format('M d, Y') }} • {{ $appointment->created_at->format('H:i') }}</p>
        </div>

        <div class="space-y-6 pt-6 border-t border-onyx/5">
          <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-full border border-onyx/10 shrink-0 overflow-hidden bg-onyx/5">
               <img src="{{ $appointment->lawyer->photo ? asset('storage/' . $appointment->lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($appointment->lawyer->full_name) . '&background=0D0D0D&color=D4AF37' }}" 
                    class="w-full h-full object-cover">
            </div>
            <div>
              <p class="text-[9px] font-bold tracking-widest text-onyx/30 uppercase">Counsel</p>
              <p class="text-[11px] font-bold text-onyx uppercase">{{ $appointment->lawyer->full_name }}</p>
            </div>
          </div>

          <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-full border border-onyx/10 shrink-0 flex items-center justify-center bg-gold-500/5">
               <svg class="w-4 h-4 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
            <div>
              <p class="text-[9px] font-bold tracking-widest text-onyx/30 uppercase">Client</p>
              <p class="text-[11px] font-bold text-onyx uppercase">{{ $appointment->customer->name }}</p>
            </div>
          </div>
        </div>

        <div class="mt-8 flex justify-between items-center opacity-0 group-hover:opacity-100 transition-all duration-500 translate-y-2 group-hover:translate-y-0">
           <div class="flex gap-4">
             <a href="#" class="text-[10px] font-bold tracking-widest text-gold-600 uppercase hover:text-gold-700 underline decoration-gold-500/30 underline-offset-4">Records</a>
             <form action="{{ route('admin.bookings.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('Cancel this appointment?')">
               @csrf
               @method('DELETE')
               <button type="submit" class="text-[10px] font-bold tracking-widest text-red-500/60 uppercase hover:text-red-500 transition-colors">Terminate</button>
             </form>
           </div>
           <span class="text-[9px] font-bold text-onyx/20 uppercase">#{{ $appointment->id }}</span>
        </div>
      </div>
      @endforeach
    </div>
  @else
    <div class="bg-white/40 backdrop-blur-md border border-onyx/5 p-32 text-center bespoke-card">
      <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/30 mb-6">Archive</p>
      <p class="font-serif text-3xl text-onyx/60 italic leading-snug">The platform registry is currently quiet.<br>No active sessions found.</p>
    </div>
  @endif
</div>
@endsection
