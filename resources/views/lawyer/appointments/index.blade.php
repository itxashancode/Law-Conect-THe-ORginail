@extends('layouts.lawyer')
@section('title', 'My Appointments — LegalCounsel')

@section('content')
<div class="pt-32 pb-24 px-6 lg:px-20 min-h-screen" data-aos="fade-up">
    <div class="max-w-7xl mx-auto">
        {{-- Header with Stats --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-8 mb-16">
            <div>
                <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-500 mb-4">Appointment Management</p>
                <h1 class="text-6xl md:text-8xl italic text-onyx leading-none">All Consultations</h1>
            </div>

            {{-- Filter Tabs --}}
            <div class="flex gap-3">
                <a href="?status=pending" class="px-6 py-3 text-xs font-bold tracking-ultra uppercase border rounded-full transition-all duration-500 {{ request('status') === 'pending' ? 'bg-amber-100 border-amber-200 text-amber-800' : 'border-onyx/10 text-onyx/60 hover:border-gold-500' }}">
                    Pending ({{ $pendingAppointments->count() }})
                </a>
                <a href="?status=confirmed" class="px-6 py-3 text-xs font-bold tracking-ultra uppercase border rounded-full transition-all duration-500 {{ request('status') === 'confirmed' ? 'bg-emerald-100 border-emerald-200 text-emerald-800' : 'border-onyx/10 text-onyx/60 hover:border-gold-500' }}">
                    Confirmed ({{ $confirmedAppointments->count() }})
                </a>
                <a href="{{ route('lawyer.appointments.index') }}" class="px-6 py-3 text-xs font-bold tracking-ultra uppercase border rounded-full transition-all duration-500 {{ !request('status') ? 'bg-gold-100 border-gold-200 text-gold-800' : 'border-onyx/10 text-onyx/60 hover:border-gold-500' }}">
                    All ({{ $allAppointments->count() }})
                </a>
            </div>
        </div>

        {{-- Appointments List --}}
        @if($allAppointments->isEmpty())
            <div class="py-32 text-center border border-onyx/10 rounded-bespoke bg-white/30">
                <svg class="w-24 h-24 mx-auto text-onyx/20 mb-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-4xl italic text-onyx/40 mb-4">No appointments yet</h3>
                <p class="text-onyx/60 mb-10">Your consultation bookings will appear here.</p>
                <a href="{{ route('lawyer.slots.index') }}" class="btn-lux btn-lux-outline">Manage Availability</a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($allAppointments as $appointment)
                    <div class="bg-white/50 border border-onyx/5 p-8 md:p-10 rounded-bespoke shadow-luxury hover:shadow-premium transition-all duration-700 group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                        <div class="flex flex-col md:flex-row justify-between gap-8">
                            {{-- Client Info & Time --}}
                            <div class="flex-1 space-y-6">
                                <div class="flex items-start gap-6">
                                    <div class="w-16 h-16 bg-onyx-5 rounded-full flex items-center justify-center shrink-0">
                                        <span class="text-2xl italic text-gold-600">
                                            {{ strtoupper(substr($appointment->customer->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl italic mb-1">{{ $appointment->customer->name }}</h3>
                                        <p class="text-sm text-onyx/60">{{ $appointment->customer->email }}</p>
                                        <p class="text-xs text-onyx/40 mt-1">{{ $appointment->customer->phone ?? 'No phone provided' }}</p>
                                    </div>
                                    <div class="ml-auto">
                                        @php
                                            $statusClass = match($appointment->status) {
                                                'pending' => 'bg-amber-100 text-amber-800',
                                                'confirmed' => 'bg-emerald-100 text-emerald-800',
                                                'cancelled' => 'bg-rose-100 text-rose-800',
                                                'completed' => 'bg-sky-100 text-sky-800',
                                                default => 'bg-onyx-5 text-onyx/60'
                                            };
                                        @endphp
                                        <span class="px-4 py-2 text-[10px] font-bold tracking-ultra uppercase border rounded-full {{ $statusClass }} border-current/20">
                                            {{ $appointment->status }}
                                        </span>
                                    </div>
                                </div>

                                @if($appointment->slot)
                                    <div class="flex flex-wrap gap-8 text-sm">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-4 h-4 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span>{{ \Carbon\Carbon::parse($appointment->slot->available_date)->format('l, F j, Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <svg class="w-4 h-4 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($appointment->slot->end_time)->format('g:i A') }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if($appointment->subject)
                                    <p class="text-onyx/70 italic">{{ $appointment->subject }}</p>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="flex md:flex-col gap-4 items-center shrink-0">
                                <a href="{{ route('lawyer.appointments.show', $appointment->id) }}" class="btn-lux btn-lux-outline w-full md:w-auto text-center whitespace-nowrap">
                                    View Details
                                </a>
                                @if($appointment->status === 'pending')
                                    <form action="{{ route('lawyer.appointments.confirm', $appointment->id) }}" method="POST" class="w-full md:w-auto">
                                        @csrf
                                        <button type="submit" class="btn-lux btn-lux-gold w-full shadow-premium">
                                            Confirm
                                        </button>
                                    </form>
                                @endif
                                @if(in_array($appointment->status, ['pending', 'confirmed']))
                                    <form action="{{ route('lawyer.appointments.cancel', $appointment->id) }}" method="POST" class="w-full md:w-auto" onsubmit="return confirm('Cancel this appointment? This will notify the client.')">
                                        @csrf
                                        <button type="submit" class="btn-lux btn-lux-outline border-rose-300 text-rose-600 hover:bg-rose-50 w-full">
                                            Cancel
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
