@extends('layouts.auth')

@section('auth-content')
<div class="mb-10 text-center">
    <h2 class="text-4xl italic text-onyx mb-2">Reset Password</h2>
    <p class="text-xs font-light tracking-wide text-onyx-50">Choose a new password for your account.</p>
</div>

<form method="POST" action="{{ route('password.store') }}" class="space-y-6">
    @csrf

    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <!-- Email Address -->
    <div>
        <label for="email" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Email Address</label>
        <input id="email" class="lux-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="YOUR EMAIL" />
        @error('email')
            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">New Password</label>
        <input id="password" class="lux-input" type="password" name="password" required autocomplete="new-password" placeholder="NEW PASSWORD" />
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
            Reset Password
        </button>
    </div>
</form>
@endsection
