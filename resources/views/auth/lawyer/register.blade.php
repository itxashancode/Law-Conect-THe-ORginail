@extends('layouts.auth')

@section('auth-content')
<div class="mb-8 text-center">
  <h1 class="text-2xl font-bold text-onyx mb-2">Lawyer Registration</h1>
  <p class="text-sm text-onyx-60">Join our exclusive network of distinguished legal professionals</p>
</div>

@if($errors->any())
  <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
    <p class="font-bold mb-2">Please correct the following errors:</p>
    <ul class="list-disc list-inside space-y-1">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('lawyer.register') }}" enctype="multipart/form-data" class="auth-form">
  @csrf

  {{-- Account Credentials --}}
  <div class="form-section mb-8">
    <h2 class="text-base font-bold uppercase tracking-wider text-onyx-40 mb-4 pb-2 border-b border-onyx/10">Account Credentials</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div class="form-group">
        <label for="name">Full Name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Your full name" class="w-full">
        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="your@email.com" class="w-full">
        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required placeholder="Min. 8 characters" class="w-full">
        @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Repeat password" class="w-full">
        @error('password_confirmation') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>
    </div>
  </div>

  {{-- Professional Information --}}
  <div class="form-section mb-8">
    <h2 class="text-base font-bold uppercase tracking-wider text-onyx-40 mb-4 pb-2 border-b border-onyx/10">Professional Profile</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div class="form-group">
        <label for="full_name">Full Name (Bar License)</label>
        <input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" required placeholder="As on license" class="w-full">
        @error('full_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div class="form-group">
        <label for="bar_license">Bar License Number</label>
        <input id="bar_license" type="text" name="bar_license" value="{{ old('bar_license') }}" required placeholder="BAR-123456" class="w-full">
        @error('bar_license') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div class="form-group">
        <label for="specialization">Specialization</label>
        <select id="specialization" name="specialization" required class="w-full">
          <option value="">Select area</option>
          <option value="Criminal" {{ old('specialization') == 'Criminal' ? 'selected' : '' }}>Criminal Law</option>
          <option value="Divorce" {{ old('specialization') == 'Divorce' ? 'selected' : '' }}>Divorce & Family</option>
          <option value="Affidavit" {{ old('specialization') == 'Affidavit' ? 'selected' : '' }}>Affidavit</option>
          <option value="Civil" {{ old('specialization') == 'Civil' ? 'selected' : '' }}>Civil Litigation</option>
          <option value="Other" {{ old('specialization') == 'Other' ? 'selected' : '' }}>Other</option>
        </select>
        @error('specialization') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div class="form-group">
        <label for="experience_years">Years of Experience</label>
        <input id="experience_years" type="number" name="experience_years" value="{{ old('experience_years', 0) }}" min="0" max="50" required class="w-full">
        @error('experience_years') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div class="form-group">
        <label for="city">City</label>
        <input id="city" type="text" name="city" value="{{ old('city') }}" required placeholder="City of practice" class="w-full">
        @error('city') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required placeholder="+1 (555) 000-0000" class="w-full">
        @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div class="form-group">
        <label for="consultation_fee">Consultation Fee ($)</label>
        <input id="consultation_fee" type="number" step="0.01" name="consultation_fee" value="{{ old('consultation_fee') }}" required placeholder="0.00" class="w-full">
        @error('consultation_fee') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div class="form-group">
        <label for="photo">Professional Photo</label>
        <input id="photo" type="file" name="photo" accept="image/*" class="w-full text-sm">
        <p class="mt-1 text-xs text-gray-500">Optional. Max 2MB</p>
        @error('photo') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div class="sm:col-span-2">
        <label for="address">Office Address</label>
        <input id="address" type="text" name="address" value="{{ old('address') }}" placeholder="Optional" class="w-full">
        @error('address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>

      <div class="sm:col-span-2">
        <label for="bio">Professional Bio *</label>
        <textarea id="bio" name="bio" rows="3" required placeholder="Briefly describe your background and expertise..." class="w-full resize-none">{{ old('bio') }}</textarea>
        <p class="mt-1 text-xs text-gray-500">Max 2000 characters</p>
        @error('bio') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
      </div>
    </div>
  </div>

  {{-- Terms --}}
  <div class="form-section mb-6">
    <label class="flex items-start gap-3">
      <input type="checkbox" name="terms" required class="mt-1">
      <span class="text-sm text-gray-600">
        I agree to the <a href="{{ route('public.terms') }}" class="text-gold-500 hover:underline">Terms</a> and <a href="{{ route('public.privacy') }}" class="text-gold-500 hover:underline">Privacy Policy</a>.
        Profile requires admin approval.
      </span>
    </label>
    @error('terms') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
  </div>

  {{-- Buttons --}}
  <div class="flex flex-col sm:flex-row gap-3">
    <a href="{{ route('register') }}" class="btn-lux btn-lux-outline py-3 px-6 text-center">
      ← Customer Registration
    </a>
    <button type="submit" class="btn-lux btn-lux-gold py-3 px-6 flex-1 shadow-sm">
      Submit Application
    </button>
  </div>
</form>
@endsection
