@extends('layouts.public')
@section('title', 'Page Not Found — LegalCounsel')
@section('content')
<div class="min-h-[80vh] flex items-center justify-center p-6 text-center" data-aos="fade-up">
    <div>
        <div class="mb-8 relative inline-block">
            <h1 class="font-serif text-[12rem] md:text-[16rem] text-onyx/5 italic leading-none select-none">404</h1>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="font-serif text-4xl md:text-5xl italic text-gold-500 bg-linen px-4">Case Dismissed</span>
            </div>
        </div>
        <h2 class="font-serif text-3xl md:text-4xl text-onyx mb-6">Instruction Not Found</h2>
        <p class="text-sm font-light text-onyx/40 mb-12 max-w-md mx-auto leading-loose uppercase tracking-widest">
            The legal document or digital precinct you are seeking has been moved or purged from our archives.
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ url('/') }}" class="btn-lux btn-lux-gold shadow-premium">Return to Chambers</a>
            <a href="{{ route('public.search') }}" class="btn-lux btn-lux-outline">Find a Specialist</a>
        </div>
    </div>
</div>
@endsection
