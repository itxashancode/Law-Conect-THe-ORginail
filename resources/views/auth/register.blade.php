@extends('layouts.auth')
@section('title', 'Join LegalCounsel — Register')

@section('container_class', 'auth-container-wide')

@section('auth-content')

<div x-data="{ role: 'client', name: '' }">
  <div class="mb-16 text-center">
    <h1 class="font-serif text-6xl md:text-7xl italic text-onyx mb-6 tracking-tighter">Join the Network</h1>
    <div class="flex justify-center items-center gap-12 mt-8 border-b border-onyx/5 max-w-xs mx-auto pb-4">
      <button @click="role = 'client'" 
              :class="role === 'client' ? 'text-onyx opacity-100' : 'text-onyx opacity-20 hover:opacity-40'"
              class="text-[10px] font-bold tracking-ultra uppercase transition-all duration-500 relative py-2">
        Private Client
        <span x-show="role === 'client'" class="absolute bottom-0 left-0 w-full h-[2px] bg-gold-500" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-x-0" x-transition:enter-end="opacity-100 scale-x-100"></span>
      </button>
      <button @click="role = 'lawyer'" 
              :class="role === 'lawyer' ? 'text-onyx opacity-100' : 'text-onyx opacity-20 hover:opacity-40'"
              class="text-[10px] font-bold tracking-ultra uppercase transition-all duration-500 relative py-2">
        Expert Counsel
        <span x-show="role === 'lawyer'" class="absolute bottom-0 left-0 w-full h-[2px] bg-gold-500" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-x-0" x-transition:enter-end="opacity-100 scale-x-100"></span>
      </button>
    </div>
  </div>


  {{-- CLIENT FORM --}}
  <div x-show="role === 'client'" 
       x-transition:enter="transition ease-out duration-700"
       x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
    <form method="POST" action="{{ route('register') }}" class="space-y-10">
      @csrf
      <input type="hidden" name="_type" value="client">

      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-12">
        <div class="space-y-3">
          <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40">Full Name</label>
          <input type="text" name="name" value="{{ old('name') }}" required class="lux-input text-base" placeholder="Alexander Wright">
        </div>
        <div class="space-y-3">
          <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40">Email Address</label>
          <input type="email" name="email" value="{{ old('email') }}" required class="lux-input text-base" placeholder="alex@wright.com">
        </div>
        <div class="space-y-3">
          <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40">Phone Number</label>
          <input type="text" name="phone" required class="lux-input text-base" placeholder="+1 (555) 001">
        </div>
        <div class="space-y-3">
          <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40">City</label>
          <input type="text" name="city" required class="lux-input text-base" placeholder="New York">
        </div>
        <div class="space-y-3">
          <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40">Secure Password</label>
          <input type="password" name="password" required class="lux-input text-base" placeholder="••••••••">
        </div>
        <div class="space-y-3">
          <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40">Confirm Password</label>
          <input type="password" name="password_confirmation" required class="lux-input text-base" placeholder="••••••••">
        </div>
      </div>

      <div class="pt-10">
        <button type="submit" class="btn-lux btn-lux-gold w-full shadow-premium py-8 text-xs uppercase tracking-ultra font-bold">
           Initialize Client Registration
        </button>
      </div>
    </form>
  </div>

  {{-- LAWYER FORM --}}
  <div x-show="role === 'lawyer'" 
       x-cloak
       x-transition:enter="transition ease-out duration-700"
       x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
    <form method="POST" action="{{ route('lawyer.register') }}" enctype="multipart/form-data" class="space-y-16">
      @csrf
      
      <div class="section-divider" data-label="Identity & Security"></div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-12">
        <div class="space-y-3 group">
          <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40 group-focus-within:text-gold-500 transition-colors">Full Professional Name</label>
          <input type="text" name="name" x-model="name" required class="lux-input text-base" placeholder="As seen on Bar License">
        </div>
        <div class="space-y-3 group">
          <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40 group-focus-within:text-gold-500 transition-colors">Corporate Email</label>
          <input type="email" name="email" required class="lux-input text-base" placeholder="professional@firm.com">
        </div>
        <div class="space-y-3 group">
          <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40 group-focus-within:text-gold-500 transition-colors">Access Password</label>
          <input type="password" name="password" required class="lux-input text-base" placeholder="••••••••">
        </div>
        <div class="space-y-3 group">
          <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40 group-focus-within:text-gold-500 transition-colors">Verify Confirmation</label>
          <input type="password" name="password_confirmation" required class="lux-input text-base" placeholder="••••••••">
        </div>
      </div>

      <div class="section-divider" data-label="Professional Standing"></div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-x-12 gap-y-12">
        <div class="space-y-3 group">
          <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40 group-focus-within:text-gold-500 transition-colors">Bar License #</label>
          <input type="text" name="bar_license" required class="lux-input text-sm" placeholder="BAR-XXXXXX">
        </div>
        <div class="space-y-3 group">
          <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40 group-focus-within:text-gold-500 transition-colors">Specialization</label>
          <div class="relative">
            <select name="specialization" required class="lux-input text-sm appearance-none bg-transparent h-12 pr-10 w-full">
              <option value="Criminal">Criminal Law</option>
              <option value="Divorce">Divorce & Family</option>
              <option value="Affidavit">Affidavit</option>
              <option value="Civil">Civil Litigation</option>
            </select>
            <div class="absolute right-0 top-1/2 -translate-y-1/2 pointer-events-none opacity-20">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>
          </div>
        </div>
        <div class="space-y-3 group">
          <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40 group-focus-within:text-gold-500 transition-colors">Experience (Years)</label>
          <input type="number" name="experience_years" value="5" required class="lux-input text-sm">
        </div>
        <div class="space-y-3 group">
          <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40 group-focus-within:text-gold-500 transition-colors">Consultation Fee ($)</label>
          <input type="number" name="consultation_fee" required class="lux-input text-sm" placeholder="350.00">
        </div>
        <div class="space-y-3 group">
            <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40 group-focus-within:text-gold-500 transition-colors">Direct Phone</label>
            <input type="text" name="phone" required class="lux-input text-sm" placeholder="+1 (555) 001">
        </div>
        <div class="space-y-3 group">
            <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40 group-focus-within:text-gold-500 transition-colors">Practice City</label>
            <input type="text" name="city" required class="lux-input text-sm" placeholder="London, UK">
        </div>
        <div class="md:col-span-3 space-y-3 group">
          <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40 group-focus-within:text-gold-500 transition-colors">Curated Professional Bio</label>
          <textarea name="bio" rows="4" class="lux-input text-sm resize-none leading-relaxed" placeholder="Describe your landmark cases and academic background..."></textarea>
        </div>
        <div class="md:col-span-3 space-y-3 pt-6">
          <label class="block text-[9px] font-bold tracking-ultra uppercase text-onyx/40 mb-4">High-Resolution Portrait</label>
          <div class="flex items-center justify-between border-b border-onyx/10 pb-6 group hover:border-gold-500/30 transition-colors">
            <input type="file" name="photo" class="text-[10px] text-onyx/40 file:mr-10 file:py-2.5 file:px-8 file:rounded-none file:border file:border-onyx/10 file:text-[9px] file:font-bold file:uppercase file:bg-transparent file:text-onyx hover:file:bg-onyx hover:file:text-white transition-all cursor-pointer">
            <span class="text-[8px] uppercase tracking-ultra text-onyx/20">Studio standard required</span>
          </div>
        </div>
        
        <input type="hidden" name="full_name" x-bind:value="name">
      </div>

      <div class="pt-16">
        <button type="submit" class="btn-lux btn-lux-gold w-full shadow-premium py-10 relative overflow-hidden group">
           <span class="relative z-10 uppercase tracking-ultra font-bold text-xs group-hover:tracking-[0.3em] transition-all duration-500">Submit Credentials for Verification</span>
        </button>
      </div>
    </form>
  </div>

  {{-- Sign In Link --}}
  <div class="mt-24 pt-12 border-t border-onyx/5 text-center">
    <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/20 leading-loose">
      All Expert profiles are subject to manual vetting <br>
      Return to portal:
      <a href="{{ route('login') }}" class="text-gold-500 hover:text-onyx transition-colors ml-2 underline underline-offset-8">Authorize & Sign In</a>
    </p>
  </div>
</div>
@endsection
