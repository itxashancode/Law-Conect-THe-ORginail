@extends('layouts.auth')

@section('auth-content')
<div class="mb-10 text-center">
    <h2 class="text-4xl italic text-onyx mb-2">Verify Identity</h2>
    <p class="text-xs font-light tracking-wide text-onyx-50 max-w-sm mx-auto mb-6">Thanks for joining us. Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
</div>

@if (session('status') == 'verification-link-sent')
    <div class="mb-6 text-sm font-medium text-gold-600 text-center border border-gold-500/20 bg-gold-500/5 py-3 rounded-lg">
        A new verification link has been sent to the email address you provided during registration.
    </div>
@endif

<div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-4">
    <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto flex-1">
        @csrf
        <button type="submit" class="btn-lux btn-lux-gold w-full shadow-premium !px-6">
            Resend Email
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto shrink-0">
        @csrf
        <button type="submit" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 hover:text-onyx transition-colors">
            Log Out
        </button>
    </form>
</div>
@endsection
