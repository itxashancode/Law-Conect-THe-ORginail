@extends('layouts.admin')
@section('title', 'Homepage Content — LegalCounsel')

@section('dashboard-content')
<div data-aos="fade-up">
  <h1 class="font-serif text-6xl text-onyx mb-12">Manage Homepage Content</h1>

  @if(session('success'))
    <div class="bg-gold-100 border border-gold-500 text-gold-900 px-6 py-4 mb-10">
      {{ session('success') }}
    </div>
  @endif

  <div class="space-y-6">
    @foreach($contents as $section => $content)
    <form method="POST" action="{{ route('admin.homepage.update', $content->id) }}" class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-8 bespoke-card">
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

      <button type="submit" class="btn-lux btn-lux-gold">Update Content</button>
    </form>
    @endforeach
  </div>
</div>
@endsection
