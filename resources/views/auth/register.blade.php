@extends('layouts.auth')

@section('auth-content')
<div class="mb-10 text-center">
    <h2 class="text-4xl italic text-onyx mb-2">Create Account</h2>
    <p class="text-xs font-light tracking-wide text-onyx-50">Join our exclusive network.</p>
</div>

<form method="POST" action="{{ route('register') }}" class="space-y-6">
    @csrf

    <!-- Name -->
    <div>
        <label for="name" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Full Name</label>
        <input id="name" class="lux-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="JOHN DOE" />
        @error('name')
            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email Address -->
    <div>
        <label for="email" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Email Address</label>
        <input id="email" class="lux-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="YOUR EMAIL" />
        @error('email')
            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Phone -->
    <div>
        <label for="phone" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Phone Number</label>
        <input id="phone" class="lux-input" type="text" name="phone" value="{{ old('phone') }}" required autocomplete="tel" placeholder="+1 (555) 000-0000" />
        @error('phone')
            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- City -->
    <div>
        <label for="city" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">City</label>
        <input id="city" class="lux-input" type="text" name="city" value="{{ old('city') }}" required autocomplete="address-level2" placeholder="NEW YORK" />
        @error('city')
            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Password</label>
        <input id="password" class="lux-input" type="password" name="password" required autocomplete="new-password" placeholder="CREATE PASSWORD" />
        @error('password')
            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div>
        <label for="password_confirmation" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Confirm Password</label>
        <input id="password_confirmation" class="lux-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="REPEAT PASSWORD" />
        @error('password_confirmation')
            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="pt-6">
        <button type="submit" class="btn-lux btn-lux-gold w-full shadow-premium">
            Join Now
        </button>
    </div>
    
    <div class="text-center pt-6 border-t border-onyx-5">
        <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40">
            Already registered?
            <a href="{{ route('login') }}" class="text-gold-500 hover:text-onyx transition-colors ml-1">Sign In</a>
        </p>
        <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mt-4">
            Are you a legal professional?
            <a href="{{ route('lawyer.register') }}" class="text-gold-500 hover:text-onyx transition-colors ml-1">Register as Lawyer</a>
        </p>
    </div>
</form>
@endsection
