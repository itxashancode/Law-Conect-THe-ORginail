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

{{-- Tab Switcher --}}
<div x-data="{ tab: '{{ old('_type', 'client') }}' }">

  {{-- Tab Buttons --}}
  <div class="flex border border-onyx/10 mb-8">
    <button type="button" @click="tab = 'client'"
            :class="tab === 'client' ? 'bg-onyx text-white' : 'text-onyx/50 hover:text-onyx bg-white'"
            class="flex-1 py-3.5 text-[10px] font-bold tracking-widest uppercase transition-colors duration-200 flex items-center justify-center gap-2">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
      </svg>
      I am a Client
    </button>
    <button type="button" @click="tab = 'lawyer'"
            :class="tab === 'lawyer' ? 'bg-onyx text-white' : 'text-onyx/50 hover:text-onyx bg-white'"
            class="flex-1 py-3.5 text-[10px] font-bold tracking-widest uppercase transition-colors duration-200 border-l border-onyx/10 flex items-center justify-center gap-2">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
      </svg>
      I am a Lawyer
    </button>
  </div>

  {{-- CLIENT TAB --}}
  <div x-show="tab === 'client'" x-transition:enter="transition ease-out duration-200"
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

  {{-- LAWYER TAB --}}
  <div x-show="tab === 'lawyer'" x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
    <form method="POST" action="{{ route('lawyer.register') }}" enctype="multipart/form-data" class="space-y-6">
      @csrf
      <input type="hidden" name="_type" value="lawyer">

      {{-- Account section --}}
      <div>
        <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/30 mb-4 border-b border-onyx/5 pb-2">Account Credentials</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="lux-input" placeholder="Display name">
          </div>
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="lux-input" placeholder="your@email.com">
          </div>
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Password</label>
            <input type="password" name="password" required class="lux-input" placeholder="Min. 8 characters">
          </div>
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Confirm Password</label>
            <input type="password" name="password_confirmation" required class="lux-input">
          </div>
        </div>
      </div>

      {{-- Professional section --}}
      <div>
        <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/30 mb-4 border-b border-onyx/5 pb-2">Professional Profile</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Full Name (as on License)</label>
            <input type="text" name="full_name" value="{{ old('full_name') }}" required class="lux-input">
          </div>
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Bar Number</label>
            <input type="text" name="bar_license" value="{{ old('bar_license') }}" required class="lux-input" placeholder="BAR-123456">
          </div>
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Specialization</label>
            <select name="specialization" required class="lux-input">
              <option value="">Select area</option>
              @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil', 'Other'] as $s)
                <option value="{{ $s }}" {{ old('specialization') === $s ? 'selected' : '' }}>{{ $s }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Experience (years)</label>
            <input type="number" name="experience_years" value="{{ old('experience_years', 0) }}" min="0" max="50" required class="lux-input">
          </div>
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">City</label>
            <input type="text" name="city" value="{{ old('city') }}" required class="lux-input">
          </div>
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}" required class="lux-input">
          </div>
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Consultation Fee ($)</label>
            <input type="number" name="consultation_fee" value="{{ old('consultation_fee') }}" required step="0.01" class="lux-input">
          </div>
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Photo (optional)</label>
            <input type="file" name="photo" accept="image/*" class="lux-input text-xs">
          </div>
          <div class="sm:col-span-2">
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Office Address</label>
            <input type="text" name="address" value="{{ old('address') }}" class="lux-input" placeholder="Optional">
          </div>
          <div class="sm:col-span-2">
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Professional Bio</label>
            <textarea name="bio" rows="3" required class="lux-input resize-none" placeholder="Describe your expertise and background...">{{ old('bio') }}</textarea>
          </div>
        </div>
      </div>

      <div>
        <label class="flex items-start gap-3 cursor-pointer">
          <input type="checkbox" name="terms" required class="mt-0.5 w-4 h-4">
          <span class="text-[10px] text-onyx/50 uppercase tracking-widest leading-relaxed">
            I agree to the <a href="{{ route('public.terms') }}" class="text-gold-500 underline">Terms</a> &amp;
            <a href="{{ route('public.privacy') }}" class="text-gold-500 underline">Privacy Policy</a>.
            Profile requires admin approval before going live.
          </span>
        </label>
      </div>

      <button type="submit" class="btn-lux btn-lux-gold w-full shadow-premium">Submit Application</button>
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
