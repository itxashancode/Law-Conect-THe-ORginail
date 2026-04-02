@extends('layouts.auth')

@section('auth-content')
<div class="mb-10 text-center">
    <h2 class="text-4xl italic text-onyx mb-2">Secure Area</h2>
    <p class="text-xs font-light tracking-wide text-onyx-50 max-w-sm mx-auto">This is a secure area of the application. Please confirm your password before continuing.</p>
</div>

<form method="POST" action="{{ route('password.confirm') }}" class="space-y-8">
    @csrf

    <!-- Password -->
    <div>
        <label for="password" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Password</label>
        <input id="password" class="lux-input" type="password" name="password" required autocomplete="current-password" placeholder="YOUR PASSWORD" />
        @error('password')
            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="pt-4">
        <button type="submit" class="btn-lux btn-lux-gold w-full shadow-premium">
            Confirm Identity
        </button>
    </div>
</form>
@endsection
