@extends('layouts.public')

@section('content')
<div class="min-h-screen flex items-center justify-center py-20 px-6">
  <div class="max-w-md w-full mx-auto relative z-10">
    <div class="text-center mb-12">
      <a href="{{ route('home') }}" class="font-serif text-5xl italic text-onyx">Legal<span class="text-gold-500">Counsel</span></a>
    </div>
    <div class="bg-white/40 backdrop-blur-sm border border-onyx-5 p-12 bespoke-card shadow-premium relative">
      <div class="absolute -top-10 -right-10 w-32 h-32 bg-gold-200/40 rounded-full blur-2xl pointer-events-none -z-10"></div>
      @yield('auth-content')
    </div>
  </div>
</div>
@endsection
