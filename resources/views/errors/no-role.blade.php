@extends('layouts.public')
@section('title', 'Action Required — LegalCounsel')

@section('content')
<div class="min-h-screen flex items-center justify-center pt-24 pb-20 px-6 relative">
    {{-- Background Ambient --}}
    <div class="absolute inset-0 bg-onyx-5 -z-10" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=\'0 0 200 200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noise\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.65\' numOctaves=\'3\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noise)\' opacity=\'0.02\'/%3E%3C/svg%3E');"></div>

    <div class="max-w-xl w-full">
        <div class="bespoke-card text-center p-14 bg-white/60">
            <div class="mx-auto w-16 h-16 bg-gold-50 border border-gold-500/20 text-gold-500 rounded-full flex items-center justify-center mb-10 shadow-luxury animate-reveal">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            
            <h1 class="font-serif text-5xl italic text-onyx mb-4 animate-reveal animation-delay-200">Account Access Pending</h1>
            <p class="font-sans text-sm font-light text-onyx-60 leading-relaxed mb-10 animate-reveal animation-delay-400">
                It appears your profile is currently being verified or lacks a specific role mapping. Please complete your registration details or contact our administrative team to explicitly assign your role.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center animate-reveal animation-delay-600">
                <a href="{{ route('home') }}" class="btn-lux btn-lux-gold w-full sm:w-auto">Return to Home</a>
                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="btn-lux btn-lux-outline w-full sm:w-auto">Sign Out</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
