@extends('layouts.auth')

@section('auth-content')
<div class="mb-10 text-center">
    <h2 class="text-4xl italic text-onyx mb-2">Password Reset</h2>
    <p class="text-xs font-light tracking-wide text-onyx-50 max-w-sm mx-auto">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
</div>

<!-- Session Status -->
@if(session('status'))
    <div class="mb-6 text-sm font-medium text-gold-600 text-center border border-gold-500/20 bg-gold-500/5 py-3 rounded-lg">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="space-y-8">
    @csrf

    <!-- Email Address -->
    <div>
        <label for="email" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Email Address</label>
        <input id="email" class="lux-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="YOUR EMAIL" />
        @error('email')
            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="pt-4">
        <button type="submit" class="btn-lux btn-lux-gold w-full shadow-premium">
            Email Password Reset Link
        </button>
    </div>
    
    <div class="text-center pt-6 border-t border-onyx-5">
        <a href="{{ route('login') }}" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 hover:text-onyx transition-colors flex items-center justify-center gap-2">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Return to Login
        </a>
    </div>
</form>
@endsection
