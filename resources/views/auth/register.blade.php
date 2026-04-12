@extends('layouts.auth')
@section('title', 'Join LegalCounsel — Register')

@section('auth-content')

<div class="auth-container-wide">
<div class="mb-12 text-center">
  <h1 class="font-serif text-5xl md:text-6xl italic text-onyx mb-4 tracking-tightest">Join the Network</h1>
  <p class="text-[10px] font-bold tracking-widest text-gold-500 uppercase">Executive Client Registration</p>
</div>

{{-- Error Summary --}}
@if($errors->any())
  <div class="mb-8 p-6 bg-red-50 border-l-4 border-red-500 text-red-900 shadow-sm animate-reveal">
    <p class="text-[10px] font-bold uppercase tracking-widest mb-3">Resolution Required:</p>
    <ul class="space-y-1 text-xs">
      @foreach($errors->all() as $error)
        <li class="flex items-center gap-2">
           <span class="w-1 h-1 bg-red-500 rounded-full"></span>
           {{ $error }}
        </li>
      @endforeach
    </ul>
  </div>
@endif

{{-- CLIENT FORM --}}
<div x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
  <form method="POST" action="{{ route('register') }}" class="space-y-8">
    @csrf
    <input type="hidden" name="_type" value="client">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
      <div class="space-y-2">
        <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/30">Full Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required
               class="lux-input text-sm" placeholder="e.g. Alexander Wright">
        @error('name')<p class="mt-1 text-[10px] text-red-500 uppercase font-bold tracking-widest">{{ $message }}</p>@enderror
      </div>
      <div class="space-y-2">
        <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/30">Email Address</label>
        <input type="email" name="email" value="{{ old('email') }}" required
               class="lux-input text-sm" placeholder="alexander@wright.com">
        @error('email')<p class="mt-1 text-[10px] text-red-500 uppercase font-bold tracking-widest">{{ $message }}</p>@enderror
      </div>
      <div class="space-y-2">
        <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/30">Phone Number</label>
        <input type="text" name="phone" value="{{ old('phone') }}" required
               class="lux-input text-sm" placeholder="+1 (555) 001-001">
        @error('phone')<p class="mt-1 text-[10px] text-red-500 uppercase font-bold tracking-widest">{{ $message }}</p>@enderror
      </div>
      <div class="space-y-2">
        <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/30">Primary City</label>
        <input type="text" name="city" value="{{ old('city') }}" required
               class="lux-input text-sm" placeholder="New York, NY">
        @error('city')<p class="mt-1 text-[10px] text-red-500 uppercase font-bold tracking-widest">{{ $message }}</p>@enderror
      </div>
      <div class="space-y-2">
        <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/30">Secure Password</label>
        <input type="password" name="password" required
               class="lux-input text-sm" placeholder="••••••••">
        @error('password')<p class="mt-1 text-[10px] text-red-500 uppercase font-bold tracking-widest">{{ $message }}</p>@enderror
      </div>
      <div class="space-y-2">
        <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/30">Confirm Password</label>
        <input type="password" name="password_confirmation" required
               class="lux-input text-sm" placeholder="••••••••">
      </div>
    </div>

    <div class="pt-6">
      <button type="submit" class="btn-lux btn-lux-gold w-full shadow-premium py-6">
         <span class="relative z-10">Complete Registration</span>
      </button>
      <p class="text-[9px] text-center mt-6 text-onyx/40 uppercase tracking-widest leading-loose max-w-xs mx-auto">
        Ensuring your data remains secure and private.
        <a href="{{ route('public.terms') }}" class="underline hover:text-gold-500 transition-colors">Terms of Service</a> apply.
      </p>
    </div>
  </form>
</div>

  {{-- Sign In Link --}}
  <div class="mt-12 pt-8 border-t border-onyx/5 text-center">
    <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/30">
      Already registered?
      <a href="{{ route('login') }}" class="text-gold-500 hover:text-onyx transition-colors ml-1 underline underline-offset-4">Sign In</a>
    </p>
  </div>

</div>
@endsection
