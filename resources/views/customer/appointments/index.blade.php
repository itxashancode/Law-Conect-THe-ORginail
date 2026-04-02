@extends('layouts.customer')
@section('title', 'My Appointments — LegalCounsel')

@section('dashboard-content')
<div data-aos="fade-up">
  <div class="flex justify-between items-center mb-10 border-b border-onyx-5 pb-6">
    <h2 class="text-3xl italic text-onyx">All Sessions</h2>
  </div>

  @if(session('success'))
    <div class="mb-6 text-sm font-medium text-gold-600 border border-gold-500/20 bg-gold-500/5 py-4 px-6 rounded-lg flex items-center justify-between shadow-sm">
      {{ session('success') }}
      <button onclick="this.parentElement.style.display='none'" class="text-gold-600 hover:text-gold-800">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
  @endif

  @if($appointments->count())
    <div class="space-y-4">
      @foreach($appointments as $appointment)
      <div class="bg-white/60 p-8 border border-onyx-[0.03] flex flex-col md:flex-row md:items-center justify-between group hover:bg-white transition-colors rounded-lg shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 flex-1">
           <div>
             <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-1">Counsel</p>
             <div class="flex items-center gap-3">
               <div class="w-8 h-8 rounded-full overflow-hidden border border-onyx-10 shrink-0">
                 <img src="{{ $appointment->lawyer->photo ? asset('storage/' . $appointment->lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($appointment->lawyer->full_name) . '&background=0D0D0D&color=D4AF37' }}" alt="{{ $appointment->lawyer->full_name }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-colors">
               </div>
               <p class="font-serif text-lg text-onyx">{{ $appointment->lawyer->full_name }}</p>
             </div>
             <p class="text-xs font-light text-onyx-60 mt-1">{{ $appointment->lawyer->specialization }} Law</p>
           </div>
           
           <div>
             <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-1">Schedule</p>
             <p class="font-serif text-lg text-onyx">{{ \Carbon\Carbon::parse($appointment->slot->available_date)->format('D, M j, Y') }}</p>
             <p class="text-xs font-light text-onyx-60">{{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($appointment->slot->end_time)->format('g:i A') }}</p>
           </div>
           
           <div>
             <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-1">Matter</p>
             <p class="text-sm font-bold text-onyx-80">{{ $appointment->subject }}</p>
             @if($appointment->meeting_place)
               <p class="text-xs font-light text-onyx-50 mt-1 break-words">Location: {{ $appointment->meeting_place }}</p>
             @endif
           </div>
        </div>

        <div class="mt-6 md:mt-0 md:ml-8 flex flex-col md:items-end gap-3 shrink-0">
          <span class="inline-block px-4 py-2 text-[10px] font-bold tracking-ultra uppercase border border-onyx-20 text-onyx 
            {{ $appointment->status === 'confirmed' ? 'bg-gold-500/10 border-gold-500/30 text-gold-700' : '' }}
            {{ $appointment->status === 'cancelled' ? 'text-onyx-40 opacity-70 border-onyx-10' : '' }}">
            {{ ucfirst($appointment->status) }}
          </span>
          
          @if($appointment->status === 'confirmed' || $appointment->status === 'pending')
            <form method="POST" action="{{ route('customer.appointments.cancel', $appointment->id) }}" class="inline-block" onsubmit="return confirm('Cancel this appointment?')">
              @csrf @method('DELETE')
              <button type="submit" class="text-[10px] font-bold tracking-ultra uppercase text-red-500 hover:text-red-700 transition-colors uppercase border-b border-transparent hover:border-red-500">Cancel Request</button>
            </form>
          @endif
        </div>
      </div>
      @endforeach
    </div>
  @else
    <div class="py-20 text-center border border-dashed border-onyx-10 bg-white/50 backdrop-blur-sm rounded-bespoke flex flex-col items-center justify-center">
       <div class="w-16 h-16 rounded-full bg-onyx-5 flex items-center justify-center mb-6">
         <svg class="w-6 h-6 text-onyx-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
       </div>
       <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx-30 mb-2">My Sessions</p>
       <p class="text-xl italic text-onyx-60 mb-8">You haven't booked any appointments yet.</p>
       <a href="{{ route('customer.search') }}" class="btn-lux btn-lux-gold shadow-premium">Find Representation</a>
    </div>
  @endif
</div>
@endsection
