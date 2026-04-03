@extends('layouts.customer')
@section('title', 'Appointment Details — LegalCounsel')

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
                    <p class="text-[10px] font-bold tracking-ultra uppercase text-gold-500 mb-4">Consultation Details</p>
                    <h1 class="text-5xl italic text-onyx mb-4">Appointment #{{ $appointment->id }}</h1>
                    <p class="text-onyx/60">With {{ $appointment->lawyer->full_name }}</p>
                </div>
                <div class="flex flex-col items-end">
                    @php
                        $statusClass = match($appointment->status) {
                            'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                            'confirmed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                            'cancelled' => 'bg-rose-100 text-rose-800 border-rose-200',
                            'completed' => 'bg-sky-100 text-sky-800 border-sky-200',
                            default => 'bg-onyx-5 text-onyx-60'
                        };
                        $statusLabel = match($appointment->status) {
                            'pending' => 'Pending Confirmation',
                            'confirmed' => 'Confirmed',
                            'cancelled' => 'Cancelled',
                            'completed' => 'Completed',
                            default => $appointment->status
                        };
                    @endphp
                    <span class="px-4 py-2 text-xs font-bold tracking-ultra uppercase border {{ $statusClass }} rounded-full">
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>

            {{-- Appointment Details Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
                {{-- Lawyer Info --}}
                <div class="space-y-6">
                    <h2 class="text-2xl italic mb-6">Legal Professional</h2>
                    <div class="flex items-start gap-6">
                        <img src="{{ $appointment->lawyer->photo ? asset('storage/' . $appointment->lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($appointment->lawyer->full_name) . '&background=0D0D0D&color=D4AF37&size=200' }}"
                             alt="{{ $appointment->lawyer->full_name }}"
                             class="w-24 h-24 rounded-full object-cover border-2 border-onyx/5">
                        <div>
                            <h3 class="text-2xl italic mb-1">{{ $appointment->lawyer->full_name }}</h3>
                            <p class="text-sm text-onyx/60 mb-2">{{ $appointment->lawyer->specialization }}</p>
                            <p class="text-xs text-onyx/40">{{ $appointment->lawyer->city }}</p>
                            @if($appointment->lawyer->consultation_fee)
                                <p class="text-sm font-semibold text-gold-600 mt-2">
                                    Consultation Fee: ${{ number_format($appointment->lawyer->consultation_fee, 2) }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Time & Place --}}
                <div class="space-y-6">
                    <h2 class="text-2xl italic mb-6">Consultation Details</h2>
                    @if($appointment->slot)
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <svg class="w-5 h-5 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/40">Date</p>
                                    <p class="text-lg italic">{{ \Carbon\Carbon::parse($appointment->slot->available_date)->format('l, F j, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <svg class="w-5 h-5 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/40">Time</p>
                                    <p class="text-lg italic">{{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($appointment->slot->end_time)->format('g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($appointment->meeting_place)
                        <div class="flex items-start gap-4 mt-6">
                            <svg class="w-5 h-5 text-gold-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div>
                                <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/40">Meeting Location</p>
                                <p class="text-lg italic">{{ $appointment->meeting_place }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Subject & Notes --}}
            <div class="mb-16 p-10 bg-onyx-5 border border-onyx/10 rounded-bespoke">
                <h2 class="text-2xl italic mb-6">Consultation Subject</h2>
                <p class="text-xl font-light text-onyx/80 leading-relaxed mb-6">{{ $appointment->subject }}</p>
                @if($appointment->notes)
                    <h3 class="text-lg font-bold tracking-ultra uppercase text-onyx/40 mb-3">Additional Notes</h3>
                    <p class="text-onyx/60 leading-relaxed">{{ $appointment->notes }}</p>
                @endif
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-6 justify-between items-center pt-8 border-t border-onyx/10">
                <div class="text-sm text-onyx/40">
                    Created: {{ $appointment->created_at->format('F j, Y g:i A') }}
                </div>
                <div class="flex gap-6">
                    @if($appointment->status === 'pending')
                        <form action="{{ route('customer.appointments.cancel', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-lux btn-lux-outline border-rose-300 text-rose-600 hover:bg-rose-50 hover:border-rose-400">
                                Cancel Appointment
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('customer.search') }}" class="btn-lux btn-lux-gold">Find Another Lawyer</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
