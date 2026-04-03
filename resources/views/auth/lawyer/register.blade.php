@extends('layouts.auth')

@section('auth-content')
<div class="mb-10 text-center">
  <h2 class="text-4xl italic text-onyx mb-2">Legal Professional Registration</h2>
  <p class="text-xs font-light tracking-wide text-onyx-50">Join our exclusive network of distinguished lawyers</p>
</div>

@if($errors->any())
  <div class="mb-8 p-4 bg-red-100 border border-red-300 text-red-700 text-sm">
    <p class="font-bold mb-2">Please correct the following errors:</p>
    <ul class="list-disc list-inside">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('lawyer.register') }}" enctype="multipart/form-data" class="space-y-10">
  @csrf

  {{-- Step 1: Account Credentials --}}
  <div class="border-b border-onyx/10 pb-10">
    <h3 class="text-lg font-bold tracking-ultra uppercase text-onyx-40 mb-6">Account Credentials</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div>
        <label for="name" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Your Name *</label>
        <input id="name" class="lux-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="YOUR FULL NAME" />
        @error('name') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="email" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Email Address *</label>
        <input id="email" class="lux-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="YOUR EMAIL" />
        @error('email') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="password" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Create Password *</label>
        <input id="password" class="lux-input" type="password" name="password" required autocomplete="new-password" placeholder="MINIMUM 8 CHARACTERS" />
        @error('password') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="password_confirmation" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Confirm Password *</label>
        <input id="password_confirmation" class="lux-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="REPEAT PASSWORD" />
        @error('password_confirmation') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>
    </div>
  </div>

  {{-- Step 2: Professional Information --}}
  <div class="border-b border-onyx/10 pb-10">
    <div class="flex items-center justify-between mb-6">
      <h3 class="text-lg font-bold tracking-ultra uppercase text-onyx-40">Professional Profile</h3>
      <span class="text-xs text-onyx-40 italic">All fields required unless marked optional</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div>
        <label for="full_name" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Full Name (as on Bar License) *</label>
        <input id="full_name" class="lux-input" type="text" name="full_name" value="{{ old('full_name') }}" required placeholder="JOHN DOE" />
        @error('full_name') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="bar_license" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Bar License Number *</label>
        <input id="bar_license" class="lux-input" type="text" name="bar_license" value="{{ old('bar_license') }}" required placeholder="BAR-123456" />
        @error('bar_license') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="specialization" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Primary Specialization *</label>
        <select id="specialization" name="specialization" required class="lux-input bg-transparent border-0 border-b border-onyx/10 py-4 px-0 focus:ring-0 focus:border-gold-500 transition-all duration-500">
          <option value="">Select Practice Area</option>
          <option value="Criminal" {{ old('specialization') == 'Criminal' ? 'selected' : '' }}>Criminal Law</option>
          <option value="Divorce" {{ old('specialization') == 'Divorce' ? 'selected' : '' }}>Divorce & Family Law</option>
          <option value="Affidavit" {{ old('specialization') == 'Affidavit' ? 'selected' : '' }}>Affidavit & Documentation</option>
          <option value="Civil" {{ old('specialization') == 'Civil' ? 'selected' : '' }}>Civil Litigation</option>
          <option value="Corporate" {{ old('specialization') == 'Corporate' ? 'selected' : '' }}>Corporate Law</option>
          <option value="Property" {{ old('specialization') == 'Property' ? 'selected' : '' }}>Property & Real Estate</option>
          <option value="Tax" {{ old('specialization') == 'Tax' ? 'selected' : '' }}>Tax Law</option>
          <option value="IP" {{ old('specialization') == 'IP' ? 'selected' : '' }}>Intellectual Property</option>
          <option value="Other" {{ old('specialization') == 'Other' ? 'selected' : '' }}>Other</option>
        </select>
        @error('specialization') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="experience_years" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Years of Experience *</label>
        <input id="experience_years" class="lux-input" type="number" name="experience_years" value="{{ old('experience_years', 0) }}" min="0" max="50" required placeholder="0" />
        @error('experience_years') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="city" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">City of Practice *</label>
        <input id="city" class="lux-input" type="text" name="city" value="{{ old('city') }}" required placeholder="NEW YORK" />
        @error('city') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="phone" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Phone Number *</label>
        <input id="phone" class="lux-input" type="text" name="phone" value="{{ old('phone') }}" required placeholder="+1 (555) 000-0000" />
        @error('phone') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="consultation_fee" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Consultation Fee (USD) *</label>
        <input id="consultation_fee" class="lux-input" type="number" step="0.01" name="consultation_fee" value="{{ old('consultation_fee') }}" required placeholder="250.00" />
        @error('consultation_fee') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="photo" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Professional Photo (Optional)</label>
        <input id="photo" class="lux-input" type="file" name="photo" accept="image/*" class="block w-full text-sm text-onyx/60 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-bold file:tracking-ultra file:uppercase file:bg-onyx/5 file:text-onyx hover:file:bg-onyx/10" />
        <p class="mt-2 text-xs text-onyx-40">Recommended: 500x500px, max 2MB</p>
        @error('photo') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div class="md:col-span-2">
        <label for="address" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Office Address (Optional)</label>
        <input id="address" class="lux-input" type="text" name="address" value="{{ old('address') }}" placeholder="123 Legal Ave, Suite 400" />
        @error('address') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div class="md:col-span-2">
        <label for="bio" class="text-[10px] font-bold tracking-ultra uppercase text-onyx-40 mb-2 block">Professional Bio *</label>
        <textarea id="bio" name="bio" rows="4" required class="lux-input resize-none" placeholder="Briefly describe your background, expertise, and approach to legal practice...">{{ old('bio') }}</textarea>
        <p class="mt-2 text-xs text-onyx-40">Max 2000 characters</p>
        @error('bio') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>
    </div>
  </div>

  {{-- Terms and Submit --}}
  <div class="space-y-6">
    <div class="flex items-start gap-4">
      <input id="terms" type="checkbox" name="terms" required class="mt-1 w-4 h-4 border-onyx/20 text-gold-500 focus:ring-gold-500" />
      <label for="terms" class="text-sm text-onyx-60">
        I agree to the <a href="#" class="text-gold-500 hover:underline">Terms of Service</a> and <a href="#" class="text-gold-500 hover:underline">Privacy Policy</a>. I understand my profile will be reviewed by administrators before activation.
      </label>
    </div>

    <div class="flex flex-col sm:flex-row gap-6 items-center">
      <a href="{{ route('register') }}" class="btn-lux btn-lux-outline w-full sm:w-auto">
        ← Back to Customer Registration
      </a>
      <button type="submit" class="btn-lux btn-lux-gold w-full sm:flex-1 shadow-premium">
        Submit Application
      </button>
    </div>
  </div>
</form>
@endsection
