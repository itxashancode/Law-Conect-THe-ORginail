@extends('layouts.auth')

@section('auth-content')
<div class="mb-8 text-center">
  <h1 class="text-2xl font-bold text-onyx mb-2">Create Account</h1>
  <p class="text-sm text-onyx-60">Join our exclusive network</p>
</div>

@if($errors->any())
  <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
    <p class="font-bold mb-2">Please correct the errors:</p>
    <ul class="list-disc list-inside space-y-1">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('register') }}" class="auth-form">
  @csrf

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
    <div class="form-group">
      <label for="name">Full Name</label>
      <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full">
      @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full">
      @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
      <label for="phone">Phone</label>
      <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required class="w-full">
      @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
      <label for="city">City</label>
      <input id="city" type="text" name="city" value="{{ old('city') }}" required class="w-full">
      @error('city') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input id="password" type="password" name="password" required class="w-full">
      @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
      <label for="password_confirmation">Confirm Password</label>
      <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full">
      @error('password_confirmation') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
    </div>
  </div>

  <div class="mb-6">
    <button type="submit" class="btn-lux btn-lux-gold w-full py-3">
      Create Account
    </button>
  </div>

  <div class="text-center space-y-2 pt-4 border-t border-onyx/10">
    <p class="text-sm text-onyx-60">
      Already have an account? <a href="{{ route('login') }}" class="text-gold-500 hover:underline font-medium">Sign In</a>
    </p>
    <p class="text-sm text-onyx-60">
      Legal professional? <a href="{{ route('lawyer.register') }}" class="text-gold-500 hover:underline font-medium">Register as Lawyer</a>
    </p>
  </div>
</form>
@endsection
