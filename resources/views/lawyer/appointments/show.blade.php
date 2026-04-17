@extends('layouts.lawyer')
@section('title', 'Appointment #' . $appointment->id . ' — LegalCounsel')

@section('content')
<div class="pt-32 pb-24 px-6 lg:px-20 min-h-screen" data-aos="fade-up">
    <div class="max-w-4xl mx-auto">
        {{-- Back Navigation --}}
        <div class="mb-12 group cursor-pointer" onclick="window.history.back()">
            <div class="flex items-center gap-3 w-fit">
                <div class="w-10 h-10 border border-onyx-10 flex items-center justify-center rounded-full group-hover:bg-onyx group-hover:text-white transition-all duration-500">
                    <svg class="w-4 h-4 translate-x-0 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 19l-7-7 7-7"/>
                    </svg>
                </div>
                <span class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40">Back to appointments</span>
            </div>
        </div>

        <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-12 bespoke-card shadow-premium">
            {{-- Header & Status --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12 pb-12 border-b border-onyx/10">
                <div>
                    <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-500 mb-4">Consultation {{ $appointment->id }}</p>
                    <h1 class="text-5xl italic text-onyx mb-2">Appointment Details</h1>
                    <p class="text-onyx/60">Client: {{ $appointment->customer->name }}</p>
                </div>
                <div class="flex flex-col items-end">
                    @php
                        $statusClass = match($appointment->status) {
                            'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                            'confirmed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                            'cancelled' => 'bg-rose-100 text-rose-800 border-rose-200',
                            'completed' => 'bg-sky-100 text-sky-800 border-sky-200',
                            default => 'bg-onyx-5 text-onyx/60'
                        };
                        $statusLabel = match($appointment->status) {
                            'pending' => 'Pending Confirmation',
                            'confirmed' => 'Confirmed',
                            'cancelled' => 'Cancelled',
                            'completed' => 'Completed',
                            default => $appointment->status
                        };
                    @endphp
                    <span class="px-4 py-2 text-xs font-bold tracking-ultra uppercase border rounded-full {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>

            {{-- Two Column Layout --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                {{-- Left: Client Information --}}
                <div class="lg:col-span-5 space-y-8">
                    <div class="p-10 bg-onyx text-white relative overflow-hidden rounded-bespoke">
                        <div class="absolute top-0 right-0 w-32 h-32 opacity-10">
                            <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl italic mb-8">Client Profile</h2>
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-onyx-20 rounded-full flex items-center justify-center">
                                    <span class="text-3xl italic text-gold-500">
                                        {{ strtoupper(substr($appointment->customer->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-300 mb-1">Client Name</p>
                                    <p class="text-xl italic">{{ $appointment->customer->name }}</p>
                                </div>
                            </div>
                            <div class="border-t border-onyx-20 pt-6">
                                <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-300 mb-2">Email Address</p>
                                <p class="text-lg italic">{{ $appointment->customer->email }}</p>
                            </div>
                            @if($appointment->customer->phone)
                                <div class="border-t border-onyx-20 pt-6">
                                    <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-300 mb-2">Phone Number</p>
                                    <p class="text-lg italic">{{ $appointment->customer->phone }}</p>
                                </div>
                            @endif
                            <div class="border-t border-onyx-20 pt-6">
                                <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-300 mb-2">Registered</p>
                                <p class="text-lg italic">{{ $appointment->customer->created_at->format('F j, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Appointment Details --}}
                <div class="lg:col-span-7 space-y-8">
                    {{-- Schedule --}}
                    <div class="p-10 bg-white/60 border border-onyx/5 rounded-bespoke">
                        <h3 class="text-2xl italic mb-8 flex items-center gap-4">
                            <svg class="w-6 h-6 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Schedule
                        </h3>
                        @if($appointment->slot)
                            <div class="grid grid-cols-1 gap-6">
                                <div class="flex items-center gap-6 p-6 bg-linen/50 rounded-bespoke">
                                    <div class="w-14 h-14 bg-gold-100 rounded-full flex items-center justify-center shrink-0">
                                        <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/40 mb-1">Date</p>
                                        <p class="text-2xl italic">{{ \Carbon\Carbon::parse($appointment->slot->available_date)->format('l, F j, Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-6 p-6 bg-linen/50 rounded-bespoke">
                                    <div class="w-14 h-14 bg-gold-100 rounded-full flex items-center justify-center shrink-0">
                                        <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/40 mb-1">Time</p>
                                        <p class="text-2xl italic">{{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($appointment->slot->end_time)->format('g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-onyx/60 italic">Slot information unavailable.</p>
                        @endif
                    </div>

                    {{-- Meeting Details --}}
                    <div class="p-10 bg-onyx text-white relative overflow-hidden rounded-bespoke">
                        <div class="absolute bottom-0 left-0 w-64 h-64 opacity-5 pointer-events-none">
                            <svg class="w-full h-full" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                            </svg>
                        </div>
                        <div class="relative z-10">
                            <h3 class="text-2xl italic mb-6 flex items-center gap-4">
                                <svg class="w-6 h-6 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Consultation Details
                            </h3>
                            <div class="space-y-6">
                                <div>
                                    <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-300 mb-2">Subject</p>
                                    <p class="text-xl italic">{{ $appointment->subject }}</p>
                                </div>
                                @if($appointment->meeting_place)
                                    <div class="border-t border-onyx/20 pt-6">
                                        <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-300 mb-2">Meeting Location</p>
                                        <p class="text-lg italic">{{ $appointment->meeting_place }}</p>
                                    </div>
                                @endif
                                @if($appointment->notes)
                                    <div class="border-t border-onyx/20 pt-6">
                                        <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-300 mb-2">Additional Notes</p>
                                        <p class="text-base leading-relaxed opacity-80">{{ $appointment->notes }}</p>
                                    </div>
                                @endif
                                <div class="border-t border-onyx/20 pt-6 flex justify-between text-sm">
                                    <div>
                                        <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-300 mb-1">Created</p>
                                        <p>{{ $appointment->created_at->format('F j, Y g:i A') }}</p>
                                    </div>
                                    @if($appointment->updated_at != $appointment->created_at)
                                        <div class="text-right">
                                            <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-300 mb-1">Last Updated</p>
                                            <p>{{ $appointment->updated_at->format('F j, Y g:i A') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-6 pt-8 border-t border-onyx/10">
                        @if($appointment->status === 'pending')
                            <form action="{{ route('lawyer.appointments.confirm', $appointment->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="btn-lux btn-lux-gold w-full shadow-premium">
                                    Confirm Appointment
                                </button>
                            </form>
                        @endif
                        @if(in_array($appointment->status, ['pending', 'confirmed']))
                            <form action="{{ route('lawyer.appointments.cancel', $appointment->id) }}" method="POST" class="flex-1" onsubmit="return luxuryConfirm(this, { title: 'Finalize Cancellation', message: 'Are you sure? This action cannot be undone and will notify the client.' })">
                                @csrf
                                <button type="submit" class="btn-lux btn-lux-outline border-rose-300 text-rose-600 hover:bg-rose-50 w-full">
                                    Cancel Appointment
                                </button>
                            </form>
                        @endif
                        <a href="mailto:{{ $appointment->customer->email }}" class="btn-lux btn-lux-outline self-end">
                            Email Client
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
