@extends('layouts.lawyer')
@section('title', 'Edit Profile — LegalCounsel')

@section('dashboard-content')
@php
  $fields = ['full_name', 'bio', 'photo', 'address', 'phone', 'bar_license', 'specialization', 'city', 'experience_years', 'consultation_fee'];
  $completed = collect($fields)->filter(fn($f) => !empty($lawyer->$f))->count();
  $pct = round(($completed / count($fields)) * 100);
  $missing = collect($fields)->filter(fn($f) => empty($lawyer->$f))->map(fn($f) => str_replace('_', ' ', ucfirst($f)))->values();
@endphp

<div data-aos="fade-up">

  {{-- Header --}}
  <div class="mb-10">
    <p class="text-[10px] font-bold tracking-widest uppercase text-gold-500 mb-3">Profile Management</p>
    <h1 class="font-serif text-6xl md:text-8xl italic leading-none text-onyx mb-4">Edit Profile</h1>
  </div>

  {{-- Profile Completion Card --}}
  <div class="mb-10 bg-white border border-onyx/5 p-6 max-w-3xl">
    <div class="flex items-center justify-between mb-3">
      <div>
        <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-0.5">Profile Completeness</p>
        @if($pct === 100)
          <p class="text-[10px] text-green-600 font-bold uppercase tracking-widest">✓ Your profile is complete</p>
        @else
          <p class="text-[10px] text-onyx/30 uppercase tracking-widest">Fill all fields to maximise discovery</p>
        @endif
      </div>
      <p class="font-serif text-3xl {{ $pct === 100 ? 'text-green-500' : 'text-gold-600' }}">{{ $pct }}%</p>
    </div>
    <div class="w-full bg-onyx/5 h-1.5 mb-4">
      <div class="h-1.5 transition-all duration-1000 {{ $pct === 100 ? 'bg-green-500' : 'bg-gold-500' }}"
           style="width: {{ $pct }}%"></div>
    </div>
    @if($missing->count() > 0)
    <p class="text-[10px] text-onyx/30 uppercase tracking-widest">
      Missing: {{ $missing->implode(' • ') }}
    </p>
    @endif
  </div>


  {{-- Form --}}
  <div class="bg-white border border-onyx/5 p-10 max-w-3xl">
    <form method="POST" action="{{ route('lawyer.profile.update') }}" enctype="multipart/form-data" class="space-y-8">
      @csrf
      @method('PUT')

      {{-- Section: Identity --}}
      <div>
        <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/30 mb-6 pb-2 border-b border-onyx/5">Identity</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Full Name *</label>
            <input type="text" name="full_name" value="{{ old('full_name', $lawyer->full_name) }}" required
                   class="lux-input w-full">
            @error('full_name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Bar License *</label>
            <input type="text" name="bar_license" value="{{ old('bar_license', $lawyer->bar_license) }}" required
                   class="lux-input w-full {{ $lawyer->bar_license ? 'bg-onyx/5 cursor-not-allowed' : '' }}"
                   {{ $lawyer->bar_license ? 'readonly' : '' }}>
            <p class="text-[9px] mt-1.5 uppercase tracking-widest {{ $lawyer->bar_license ? 'text-onyx/25' : 'text-onyx/40' }}">
              {{ $lawyer->bar_license ? 'Cannot be changed after registration' : 'Enter your official bar number' }}
            </p>
          </div>
        </div>
      </div>

      {{-- Section: Practice --}}
      <div>
        <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/30 mb-6 pb-2 border-b border-onyx/5">Practice Details</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Specialization *</label>
            <select name="specialization" required class="lux-input w-full !py-[1.1rem]">
              @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil', 'Other'] as $spec)
                <option value="{{ $spec }}" {{ old('specialization', $lawyer->specialization) === $spec ? 'selected' : '' }}>{{ $spec }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Years of Experience *</label>
            <input type="number" name="experience_years" value="{{ old('experience_years', $lawyer->experience_years) }}"
                   required min="0" max="60" class="lux-input w-full">
          </div>
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Consultation Fee ($/hr) *</label>
            <input type="number" name="consultation_fee" value="{{ old('consultation_fee', $lawyer->consultation_fee) }}"
                   required min="0" step="0.01" class="lux-input w-full">
          </div>
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Phone *</label>
            <input type="text" name="phone" value="{{ old('phone', $lawyer->phone) }}" required class="lux-input w-full">
          </div>
          <div>
            <label class="block text-[10px] font-bold tracking-widests uppercase text-onyx/40 mb-2">City *</label>
            <input type="text" name="city" value="{{ old('city', $lawyer->city) }}" required class="lux-input w-full">
          </div>
          <div>
            <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Office Address</label>
            <input type="text" name="address" value="{{ old('address', $lawyer->address) }}" class="lux-input w-full" placeholder="Optional">
          </div>
        </div>
      </div>

      {{-- Section: Bio --}}
      <div>
        <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/30 mb-6 pb-2 border-b border-onyx/5">Professional Biography</p>
        <div>
          <label class="block text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-2">Bio / About *</label>
          <textarea name="bio" rows="6" required
                    class="lux-input w-full resize-none"
                    placeholder="Describe your background, expertise, and approach to legal practice...">{{ old('bio', $lawyer->bio) }}</textarea>
          @error('bio')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- Section: Photo --}}
      <div>
        <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/30 mb-6 pb-2 border-b border-onyx/5">Profile Photo</p>
        @if($lawyer->photo)
        <div class="flex items-center gap-6 mb-4">
          <div class="w-20 h-20 overflow-hidden border border-onyx/10 shrink-0">
            <img src="{{ asset('storage/' . $lawyer->photo) }}" alt="Current photo" class="w-full h-full object-cover">
          </div>
          <div>
            <p class="text-[10px] text-onyx/40 uppercase tracking-widest mb-1">Current Photo</p>
            <p class="text-xs text-onyx/30">Upload a new file below to replace it.</p>
          </div>
        </div>
        @endif
        <input type="file" name="photo" accept="image/*" class="lux-input w-full text-sm">
        <p class="text-[9px] text-onyx/30 mt-2 uppercase tracking-widest">Recommended: 500×500px, max 2MB. JPEG or PNG.</p>
      </div>


      <div class="pt-4 flex gap-4">
        <button type="submit" class="btn-lux btn-lux-gold shadow-premium">Save Changes</button>
        <a href="{{ route('lawyer.dashboard') }}" class="btn-lux btn-lux-outline">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
