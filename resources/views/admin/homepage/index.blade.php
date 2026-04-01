@extends('layouts.admin')
@section('title', 'Homepage Content — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <h1 class="font-serif text-4xl text-ink mb-8">Manage Homepage Content</h1>

  @if(session('success'))
    <div class="bg-green-100 border border-green-500 text-green-700 px-6 py-4 mb-6">
      {{ session('success') }}
    </div>
  @endif

  <div class="space-y-6">
    @foreach($contents as $section => $content)
    <form method="POST" action="{{ route('admin.homepage.update', $content->id) }}" class="bg-warm-surface border border-warm-border p-6">
      @csrf
      @method('PUT')

      <h2 class="font-serif text-2xl text-ink mb-4 capitalize">{{ $section }}</h2>

      <div class="mb-6">
        <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Title</label>
        <input type="text" name="title" value="{{ old('title', $content->title) }}"
               class="search-field" placeholder="Enter title...">
      </div>

      <div class="mb-6">
        <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Body / Description</label>
        <textarea name="body" rows="5" class="search-field" placeholder="Enter content...">{{ old('body', $content->body) }}</textarea>
      </div>

      <button type="submit" class="btn-primary">Update Content</button>
    </form>
    @endforeach
  </div>
</div>
@endsection
