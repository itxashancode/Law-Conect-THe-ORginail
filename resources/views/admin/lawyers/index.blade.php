@extends('layouts.admin')
@section('title', 'Manage Lawyers — LegalCounsel')

@section('dashboard-content')
<div data-aos="fade-up">
  <div class="flex justify-between items-center mb-12 border-b border-onyx/5 pb-6">
    <h2 class="font-serif text-5xl text-onyx">Network Professionals</h2>
    <a href="{{ route('home') }}" class="btn-lux btn-lux-outline">View Public Directory</a>
  </div>

  @if($lawyers->count())
    <div class="space-y-4">
      @foreach($lawyers as $lawyer)
      <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-6 hover:shadow-luxury transition-all duration-500 bespoke-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div class="flex items-center gap-6">
            <div class="w-20 h-20 overflow-hidden border border-onyx/10 shrink-0">
              <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=0D0D0D&color=D4AF37' }}"
                   alt="{{ $lawyer->full_name }}"
                   class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
            </div>
            <div>
              <div class="flex items-center gap-3">
                <h4 class="font-serif text-2xl text-onyx">{{ $lawyer->full_name }}</h4>
                @if($lawyer->status === 'approved')
                  <span class="w-2 h-2 rounded-full bg-gold-600" title="Approved"></span>
                @elseif($lawyer->status === 'pending')
                  <span class="w-2 h-2 rounded-full bg-onyx/40" title="Pending"></span>
                @else
                  <span class="w-2 h-2 rounded-full bg-onyx/60" title="Rejected"></span>
                @endif
              </div>
              <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/50 mt-1">{{ $lawyer->specialization }} Law • {{ $lawyer->city }} • {{ $lawyer->experience_years }} Yrs Exp</p>
              <p class="text-sm font-light text-onyx/40 mt-1">{{ $lawyer->user->email }} • {{ $lawyer->phone }}</p>
            </div>
          </div>

          <div class="flex items-center gap-4">
            @if($lawyer->status === 'pending')
              <form method="POST" action="{{ route('admin.lawyers.approve', $lawyer->id) }}" class="inline">
                @csrf @method('POST')
                <button type="submit" class="btn-lux btn-lux-outline text-xs">Approve</button>
              </form>
              <form method="POST" action="{{ route('admin.lawyers.reject', $lawyer->id) }}" class="inline" onsubmit="return confirm('Reject this lawyer?')">
                @csrf @method('POST')
                <button type="submit" class="btn-lux btn-lux-ghost text-xs text-onyx/60">Reject</button>
              </form>
            @else
              <span class="inline-block px-4 py-2 text-xs border border-onyx/20 text-onyx uppercase tracking-ultra {{ $lawyer->status === 'approved' ? 'bg-onyx text-white border-onyx' : '' }}">{{ ucfirst($lawyer->status) }}</span>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
  @else
    <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-20 text-center bespoke-card">
      <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/30 mb-4">Network</p>
      <p class="font-serif text-2xl text-onyx/60 italic">No legal professionals are registered yet.</p>
    </div>
  @endif
</div>
@endsection
