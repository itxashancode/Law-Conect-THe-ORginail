@extends('layouts.public')

@section('content')
<div class="min-h-screen flex items-center justify-center py-10 px-4">
  <div class="auth-container w-full">
    <div class="text-center mb-8">
      <a href="{{ route('home') }}" class="font-serif text-4xl italic text-onyx">Legal<span class="text-gold-500">Counsel</span></a>
    </div>
    <div class="auth-card">
      @yield('auth-content')
    </div>
    <div class="mt-8 text-center animate-reveal animation-delay-600">
      <p class="text-[10px] tracking-ultra uppercase text-onyx-40">
        &copy; {{ date('Y') }} LegalCounsel — 
        <a href="{{ route('public.privacy') }}" class="hover:text-gold-500 transition-colors mx-2">Privacy Policy</a>
        <span class="opacity-20">|</span>
        <a href="{{ route('public.terms') }}" class="hover:text-gold-500 transition-colors mx-2">Terms of Service</a>
      </p>
    </div>
  </div>
</div>
@endsection
