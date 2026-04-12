@extends('layouts.public')
@section('title', $title . ' — LegalCounsel')

@section('content')
<div class="pt-48 pb-32 px-6 lg:px-20 min-h-screen">
  <div class="max-w-3xl mx-auto" data-aos="fade-up">
    <div class="mb-16">
      <span class="text-[10px] font-bold tracking-ultra uppercase text-gold-500 mb-4 block">Last Updated: {{ $lastUpdated }}</span>
      <h1 class="text-7xl italic mb-10">{{ $title }}</h1>
      <div class="w-20 h-px bg-gold-500"></div>
    </div>

    <div class="prose prose-onyx prose-lg font-light text-onyx-60 leading-relaxed uppercase shadow-none tracking-wide text-xs">
        <p class="mb-10 text-xl font-serif italic text-onyx/80">
            Commitment to excellence and discretion is at the core of our legal network operations.
        </p>
        
        <p class="mb-8">
            {{ $content }}
        </p>

        <h3 class="text-onyx mt-16 mb-6 font-serif italic text-2xl">Standard Protocol</h3>
        <p class="mb-8">
            All interactions within our platform are subject to strict confidentiality agreements. We utilize end-to-end encryption for consultation requests and record-keeping to ensure the sanctity of the attorney-client privilege is maintained from the very first point of contact.
        </p>

        <h3 class="text-onyx mt-16 mb-6 font-serif italic text-2xl">Expert Oversight</h3>
        <p class="mb-8">
            Our administrative team regularly audits practitioner credentials but does not interfere with individual legal advice. By using our platform, you acknowledge that LegalCounsel is a matching service and not a law firm.
        </p>
    </div>

    <div class="mt-20 pt-10 border-t border-onyx-5">
      <a href="{{ url()->previous() }}" class="btn-lux btn-lux-outline">Return to previous page</a>
    </div>
  </div>
</div>
@endsection
