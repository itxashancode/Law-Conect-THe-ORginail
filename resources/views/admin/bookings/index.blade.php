@extends('layouts.admin')
@section('title', 'All Bookings — LegalCounsel')

@section('dashboard-content')
<div data-aos="fade-up">
  <div class="flex justify-between items-center mb-12 border-b border-onyx/5 pb-6">
    <h2 class="font-serif text-5xl text-onyx">Platform Appointments</h2>
  </div>

  @if($appointments->count())
    <div class="space-y-4">
      @foreach($appointments as $appointment)
      <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-6 hover:shadow-luxury transition-all duration-500 bespoke-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div>
            <p class="text-[10px] tracking-ultra uppercase text-onyx/40 mb-2">Client</p>
            <p class="font-serif text-xl text-onyx">{{ $appointment->customer->name }}</p>
            <p class="text-sm text-onyx/60">{{ $appointment->customer->email }}</p>
          </div>
          <div>
            <p class="text-[10px] tracking-ultra uppercase text-onyx/40 mb-2">Counsel</p>
            <p class="font-serif text-xl text-onyx">{{ $appointment->lawyer->full_name }}</p>
            <p class="text-sm text-onyx/60">ID: {{ $appointment->lawyer->id }}</p>
          </div>
          <div>
            <p class="text-[10px] tracking-ultra uppercase text-onyx/40 mb-2">Matter</p>
            <p class="text-lg text-onyx">{{ $appointment->subject }}</p>
            <p class="text-sm text-onyx/60">{{ $appointment->created_at->format('M j, Y') }}</p>
          </div>
        </div>

        <div class="mt-6 text-right">
          <span class="inline-block px-4 py-2 text-xs border border-onyx/20 text-onyx uppercase tracking-ultra {{ $appointment->status === 'confirmed' ? 'bg-onyx text-white border-onyx' : '' }}">{{ ucfirst($appointment->status) }}</span>
        </div>
      </div>
      @endforeach
    </div>
  @else
    <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-20 text-center bespoke-card">
      <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/30 mb-4">Appointments</p>
      <p class="font-serif text-2xl text-onyx/60 italic">No sessions have been booked across the network.</p>
    </div>
  @endif
</div>
@endsection
