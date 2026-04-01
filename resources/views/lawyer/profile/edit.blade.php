@extends('layouts.lawyer')
@section('title', 'Edit Profile — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <h1 class="font-serif text-4xl text-ink mb-8">Edit Profile</h1>

  @if(session('success'))
    <div class="bg-green-100 border border-green-500 text-green-700 px-6 py-4 mb-6">
      {{ session('success') }}
    </div>
  @endif

  <div class="bg-warm-surface border border-warm-border p-8 max-w-3xl">
    <form method="POST" action="{{ route('lawyer.profile.update') }}">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Full Name</label>
          <input type="text" name="full_name" value="{{ old('full_name', $lawyer->full_name) }}" required class="search-field">
        </div>

        <div>
          <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Bar License Number</label>
          <input type="text" name="bar_license" value="{{ old('bar_license', $lawyer->bar_license) }}" required class="search-field" readonly class="bg-gray-100">
          <p class="text-xs text-ink-muted mt-1">Bar license cannot be changed.</p>
        </div>

        <div>
          <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Specialization</label>
          <select name="specialization" required class="search-field">
            @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil'] as $spec)
              <option value="{{ $spec }}" {{ $lawyer->specialization === $spec ? 'selected' : '' }}>{{ $spec }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Years of Experience</label>
          <input type="number" name="experience_years" value="{{ old('experience_years', $lawyer->experience_years) }}" required min="0" max="50" class="search-field">
        </div>

        <div>
          <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">City</label>
          <input type="text" name="city" value="{{ old('city', $lawyer->city) }}" required class="search-field">
        </div>

        <div>
          <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Phone</label>
          <input type="text" name="phone" value="{{ old('phone', $lawyer->phone) }}" required class="search-field">
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Address</label>
          <input type="text" name="address" value="{{ old('address', $lawyer->address) }}" required class="search-field">
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Consultation Fee (optional)</label>
          <input type="number" name="consultation_fee" value="{{ old('consultation_fee', $lawyer->consultation_fee) }}" min="0" step="0.01" class="search-field">
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Bio / Description</label>
          <textarea name="bio" rows="6" class="search-field">{{ old('bio', $lawyer->bio) }}</textarea>
        </div>
      </div>

      <div class="mt-8">
        <button type="submit" class="btn-primary">Update Profile</button>
      </div>
    </form>
  </div>
</div>
@endsection
