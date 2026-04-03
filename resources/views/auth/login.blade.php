@extends('layouts.auth')

@section('auth-content')
<div class="mb-10 text-center">
    <h2 class="text-4xl italic text-onyx mb-2">Sign In</h2>
    <p class="text-xs font-light tracking-wide text-onyx-50">Access your private account.</p>
</div>

<!-- Session Status -->
@if(session('status'))
    <div class="mb-4 text-sm font-medium text-gold-600">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}" class="space-y-8">
    @csrf

    <!-- Email Address -->
    <div>
        <label for="email" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Email Address</label>
        <input id="email" class="lux-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="YOUR EMAIL" />
        @error('email')
            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Password</label>
        <input id="password" class="lux-input" type="password" name="password" required autocomplete="current-password" placeholder="YOUR PASSWORD" />
        @error('password')
            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between pt-2">
        <label for="remember_me" class="flex items-center group cursor-pointer">
            <input id="remember_me" type="checkbox" class="w-4 h-4 rounded-sm border-onyx-20 text-gold-500 focus:ring-gold-500 focus:ring-offset-0 bg-transparent transition-colors" name="remember">
            <span class="ms-3 text-[10px] font-bold tracking-ultra uppercase text-onyx-40 group-hover:text-onyx transition-colors">Keep me signed in</span>
        </label>

        @if (Route::has('password.request'))
            <a class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 hover:text-gold-500 transition-colors" href="{{ route('password.request') }}">
                Forgot Password?
            </a>
        @endif
    </div>

    <div class="pt-6">
        <button type="submit" class="btn-lux btn-lux-gold w-full shadow-premium">
            Sign In
        </button>
    </div>
    
    <div class="text-center pt-6 border-t border-onyx-5">
        <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-gold-500 hover:text-onyx transition-colors ml-1">Join as Client</a>
            <span class="mx-2">|</span>
            <a href="{{ route('lawyer.register') }}" class="text-gold-500 hover:text-onyx transition-colors">Join as Lawyer</a>
        </p>
    </div>
</form>
@endsection
