@extends('layouts.lawyer')
@section('title', 'Pending Verification — LegalCounsel')

@section('content')
<div class="flex items-center justify-center min-h-[60vh]" data-aos="fade-up">
  <div class="max-w-2xl w-full text-center">
    <div class="mb-12 inline-flex items-center justify-center w-24 h-24 rounded-full bg-onyx/5 border border-onyx/10">
      <svg class="w-10 h-10 text-gold-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
      </svg>
    </div>

    <h1 class="font-serif text-5xl md:text-7xl italic mb-6 text-onyx">Verification In Progress</h1>
    
    <p class="text-lg text-onyx/60 font-light mb-12 leading-relaxed">
      Welcome to the network, <span class="text-onyx font-medium italic">{{ $lawyer->full_name }}</span>. 
      Your credentials and bar license are currently being audited by our administrative team. 
      This exclusive verification process typically concludes within 24-48 business hours.
    </p>

    <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-8 rounded-bespoke mb-12 text-left">
      <p class="text-[10px] tracking-ultra uppercase text-onyx/40 mb-4 border-b border-onyx/5 pb-4">Next Steps</p>
      <ul class="space-y-4">
        <li class="flex items-start gap-4">
          <span class="w-5 h-5 rounded-full bg-gold-500/10 border border-gold-500/20 flex items-center justify-center text-[10px] font-bold text-gold-600 mt-0.5">1</span>
          <p class="text-sm text-onyx/80">Our team verifies your <span class="font-bold">Bar License: {{ $lawyer->bar_license }}</span></p>
        </li>
        <li class="flex items-start gap-4">
          <span class="w-5 h-5 rounded-full bg-gold-500/10 border border-gold-500/20 flex items-center justify-center text-[10px] font-bold text-gold-600 mt-0.5">2</span>
          <p class="text-sm text-onyx/80">You will receive an email confirmation once your profile becomes active.</p>
        </li>
        <li class="flex items-start gap-4">
          <span class="w-5 h-5 rounded-full bg-gold-500/10 border border-gold-500/20 flex items-center justify-center text-[10px] font-bold text-gold-600 mt-0.5">3</span>
          <p class="text-sm text-onyx/80">After approval, you can set your availability slots and accept bookings.</p>
        </li>
      </ul>
    </div>

    <div class="flex flex-wrap items-center justify-center gap-6">
      <a href="{{ route('lawyer.profile.edit') }}" class="btn-lux btn-lux-outline">Review Profile</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-lux btn-lux-ghost text-onyx/50 hover:text-onyx">Sign Out</button>
      </form>
    </div>
  </div>
</div>
@endsection
