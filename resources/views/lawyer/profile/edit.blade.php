@extends('layouts.lawyer')
@section('title', 'Edit Profile — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <h1 class="font-serif text-6xl text-onyx mb-12">Edit Profile</h1>

  @if(session('success'))
    <div class="bg-gold-100 border border-gold-500 text-gold-900 px-6 py-4 mb-8">
      {{ session('success') }}
    </div>
  @endif

  <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-10 max-w-3xl bespoke-card">
    <form method="POST" action="{{ route('lawyer.profile.update') }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
          <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Full Name</label>
          <input type="text" name="full_name" value="{{ old('full_name', $lawyer->full_name) }}" required class="lux-input">
        </div>

        <div>
          <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Bar License Number</label>
          <input type="text" name="bar_license" value="{{ old('bar_license', $lawyer->bar_license) }}" required class="lux-input bg-onyx/5" readonly>
          <p class="text-xs text-onyx/40 mt-2">Bar license cannot be changed.</p>
        </div>

        <div>
          <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Specialization</label>
          <select name="specialization" required class="lux-input">
            @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil'] as $spec)
              <option value="{{ $spec }}" {{ $lawyer->specialization === $spec ? 'selected' : '' }}>{{ $spec }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Years of Experience</label>
          <input type="number" name="experience_years" value="{{ old('experience_years', $lawyer->experience_years) }}" required min="0" max="50" class="lux-input">
        </div>

        <div>
          <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">City</label>
          <input type="text" name="city" value="{{ old('city', $lawyer->city) }}" required class="lux-input">
        </div>

        <div>
          <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Phone</label>
          <input type="text" name="phone" value="{{ old('phone', $lawyer->phone) }}" required class="lux-input">
        </div>

        <div class="md:col-span-2">
          <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Address</label>
          <input type="text" name="address" value="{{ old('address', $lawyer->address) }}" required class="lux-input">
        </div>

        <div class="md:col-span-2">
          <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Consultation Fee (optional)</label>
          <input type="number" name="consultation_fee" value="{{ old('consultation_fee', $lawyer->consultation_fee) }}" min="0" step="0.01" class="lux-input">
        </div>

        <div class="md:col-span-2">
          <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Bio / Description</label>
          <textarea name="bio" rows="6" class="lux-input">{{ old('bio', $lawyer->bio) }}</textarea>
        </div>

        <div class="md:col-span-2">
          <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Professional Photo</label>
          <input type="file" name="photo" accept="image/*" class="lux-input">
          <p class="text-xs text-onyx/40 mt-2">Recommended: 500x500px, max 2MB. Leave empty to keep current.</p>
          @if($lawyer->photo)
            <div class="mt-4 flex items-center gap-4">
              <img src="{{ asset('storage/' . $lawyer->photo) }}" alt="Current photo" class="w-20 h-20 object-cover rounded-full border border-onyx/10">
              <p class="text-sm text-onyx/60">Current photo</p>
            </div>
          @endif
        </div>
      </div>

      <div class="mt-12">
        <button type="submit" class="btn-lux btn-lux-gold shadow-luxury">Update Profile</button>
      </div>
    </form>
  </div>
</div>
@endsection
