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
  </div>
</div>
@endsection
