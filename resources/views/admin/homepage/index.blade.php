@extends('layouts.admin')
@section('title', 'Homepage Content — LegalCounsel')

@section('dashboard-content')
<div data-aos="fade-up">
  <h1 class="font-serif text-6xl text-onyx mb-12">Manage Homepage Content</h1>


  @if(isset($missingSections) && count($missingSections) > 0)
    <div class="mb-16 p-10 bg-amber-50 border border-amber-200 rounded-bespoke">
      <h2 class="text-2xl italic text-amber-900 mb-6">Missing Sections</h2>
      <p class="text-amber-800 mb-8">The following sections are not yet created. Add them to enable full homepage functionality.</p>
      <div class="space-y-4">
        @foreach($missingSections as $section)
        <form method="POST" action="{{ route('admin.homepage.store') }}" class="flex flex-col md:flex-row gap-4 items-center p-6 bg-white rounded-bespoke border border-amber-100">
          @csrf
          <input type="hidden" name="section" value="{{ $section }}">
          <div class="flex-1">
            <span class="text-lg font-semibold capitalize text-onyx">{{ $section }}</span>
            <p class="text-sm text-onyx/60">Create this section with default content.</p>
          </div>
          <button type="submit" class="btn-lux btn-lux-gold">
            Create Section
          </button>
        </form>
        @endforeach
      </div>
    </div>
  @endif

  <div class="space-y-6">
    @foreach($contents as $section => $content)
    <form method="POST" action="{{ route('admin.homepage.update', $content->id) }}" class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-8 bespoke-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
      @csrf
      @method('PUT')

      <h2 class="font-serif text-3xl text-onyx mb-6 capitalize">{{ $section }}</h2>

      <div class="mb-8">
        <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Title</label>
        <input type="text" name="title" value="{{ old('title', $content->title) }}"
               class="lux-input" placeholder="Enter title...">
      </div>

      <div class="mb-8">
        <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Body / Description</label>
        <textarea name="body" rows="5" class="lux-input" placeholder="Enter content...">{{ old('body', $content->body) }}</textarea>
      </div>

      <div class="mb-8">
        <label class="block text-[10px] tracking-ultra uppercase text-onyx/40 mb-3">Image Path (optional)</label>
        <input type="text" name="image_path" value="{{ old('image_path', $content->image_path) }}"
               class="lux-input" placeholder="/path/to/image.jpg">
        <p class="mt-2 text-xs text-onyx/40">Optional: Relative path to image asset</p>
      </div>

      <button type="submit" class="btn-lux btn-lux-gold">Update Content</button>
    </form>
    @endforeach
  </div>
</div>
@endsection
