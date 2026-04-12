@extends('layouts.auth')
@section('title', 'Join LegalCounsel — Register')

@section('auth-content')

<div class="mb-10 text-center">
  <h1 class="font-serif text-4xl italic text-onyx mb-2">Join the Network</h1>
  <p class="text-xs font-light tracking-widest text-onyx/50 uppercase">Create your account to get started</p>
</div>

{{-- Error Summary --}}
@if($errors->any())
  <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 text-xs">
    <p class="font-bold uppercase tracking-widest mb-2">Please correct the following:</p>
    <ul class="space-y-1 list-disc list-inside">
      @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
  </div>
@endif

{{-- CLIENT FORM --}}
<div x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
  <form method="POST" action="{{ route('register') }}" class="space-y-5">
    @csrf
    <input type="hidden" name="_type" value="client">

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Full Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required
               class="lux-input" placeholder="Your full name">
        @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required
               class="lux-input" placeholder="your@email.com">
        @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Phone</label>
        <input type="text" name="phone" value="{{ old('phone') }}" required
               class="lux-input" placeholder="+1 (555) 000-0000">
        @error('phone')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">City</label>
        <input type="text" name="city" value="{{ old('city') }}" required
               class="lux-input" placeholder="Your city">
        @error('city')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Password</label>
        <input type="password" name="password" required
               class="lux-input" placeholder="Min. 8 characters">
        @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Confirm Password</label>
        <input type="password" name="password_confirmation" required
               class="lux-input" placeholder="Repeat password">
      </div>
    </div>

    <div class="pt-4">
      <button type="submit" class="btn-lux btn-lux-gold w-full shadow-premium">Create Client Account</button>
      <p class="text-[9px] text-center mt-3 text-onyx/30 uppercase tracking-widest leading-loose">
        By registering, you agree to our
        <a href="{{ route('public.terms') }}" class="underline hover:text-gold-500">Terms</a> &amp;
        <a href="{{ route('public.privacy') }}" class="underline hover:text-gold-500">Privacy Policy</a>
      </p>
    </div>
  </form>
</div>

  {{-- Sign In Link --}}
  <div class="mt-8 pt-6 border-t border-onyx/5 text-center">
    <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/40">
      Already have an account?
      <a href="{{ route('login') }}" class="text-gold-500 hover:text-onyx transition-colors ml-1">Sign In</a>
    </p>
  </div>

</div>
@endsection
