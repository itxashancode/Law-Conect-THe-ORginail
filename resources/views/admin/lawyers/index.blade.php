@extends('layouts.admin')
@section('title', 'Manage Lawyers — LegalCounsel')
@section('page-title', 'Counsel Registry')
@section('page-subtitle', 'Manage registered legal professionals')

@section('dashboard-content')

{{-- Filter Tabs --}}
<div x-data="{ tab: '{{ request('status', 'all') }}' }" class="mb-6">
  <div class="flex gap-1 bg-white border border-onyx/5 p-1 w-fit mb-6">
    @foreach(['all' => 'All', 'pending' => 'Pending', 'approved' => 'Active', 'rejected' => 'Rejected'] as $key => $label)
    <a href="{{ route('admin.lawyers.index', ['status' => $key === 'all' ? null : $key]) }}"
       class="px-4 py-2 text-[10px] font-bold tracking-widest uppercase transition-colors duration-150
              {{ request('status', 'all') === $key ? 'bg-onyx text-white' : 'text-onyx/40 hover:text-onyx' }}">
      {{ $label }}
    </a>
    @endforeach
  </div>

  {{-- Table --}}
  <div class="bg-white border border-onyx/5 overflow-hidden">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-onyx/5 bg-onyx/[.02]">
          <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase">Counsel</th>
          <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase hidden md:table-cell">Specialization</th>
          <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase hidden lg:table-cell">Location</th>
          <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase hidden lg:table-cell">Fee/hr</th>
          <th class="text-left px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase">Status</th>
          <th class="text-right px-6 py-3 text-[10px] font-bold tracking-widest text-onyx/40 uppercase">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-onyx/5">
        @forelse($lawyers as $lawyer)
        <tr class="hover:bg-onyx/[.02] transition-colors group">
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-full overflow-hidden border border-onyx/10 shrink-0">
                <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name='.urlencode($lawyer->full_name).'&background=0D0D0D&color=D4AF37' }}"
                     class="w-full h-full object-cover">
              </div>
              <div>
                <p class="font-medium text-onyx text-[13px]">{{ $lawyer->full_name }}</p>
                <p class="text-[10px] text-onyx/40">{{ $lawyer->user->email }}</p>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 hidden md:table-cell">
            <span class="text-[10px] font-bold tracking-widest uppercase px-2 py-1 bg-onyx/5 text-onyx/60">{{ $lawyer->specialization }}</span>
          </td>
          <td class="px-6 py-4 text-[12px] text-onyx/60 hidden lg:table-cell">{{ $lawyer->city }}</td>
          <td class="px-6 py-4 font-serif text-gold-600 hidden lg:table-cell">${{ number_format($lawyer->consultation_fee ?? 0) }}</td>
          <td class="px-6 py-4">
            <span class="text-[9px] font-bold tracking-widest uppercase px-2 py-1 border
                          {{ $lawyer->status === 'approved' ? 'border-green-200 text-green-600 bg-green-50' :
                             ($lawyer->status === 'pending' ? 'border-gold-200 text-gold-600 bg-gold-50' : 'border-red-200 text-red-600 bg-red-50') }}">
              {{ $lawyer->status }}
            </span>
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center justify-end gap-3">
              <a href="{{ route('public.lawyer', $lawyer->id) }}" target="_blank"
                 class="text-[10px] font-bold tracking-widest uppercase text-onyx/30 hover:text-onyx transition-colors">View</a>
              @if($lawyer->status === 'pending')
                <form action="{{ route('admin.lawyers.approve', $lawyer->id) }}" method="POST" class="inline">
                  @csrf
                  <button type="submit" class="text-[10px] font-bold tracking-widest uppercase text-gold-600 hover:text-gold-700 transition-colors">Approve</button>
                </form>
                <form action="{{ route('admin.lawyers.reject', $lawyer->id) }}" method="POST" class="inline">
                  @csrf
                  <button type="submit" onclick="return confirm('Reject {{ $lawyer->full_name }}?')"
                          class="text-[10px] font-bold tracking-widest uppercase text-red-400 hover:text-red-600 transition-colors">Reject</button>
                </form>
              @endif
              <form action="{{ route('admin.lawyers.destroy', $lawyer->id) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirm('Permanently delete this lawyer record?')"
                        class="text-[10px] font-bold tracking-widest uppercase text-onyx/20 hover:text-red-500 transition-colors">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="px-6 py-16 text-center">
            <p class="font-serif text-xl text-onyx/30 italic">No lawyers found for this filter.</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
    @if(method_exists($lawyers, 'links'))
    <div class="px-6 py-4 border-t border-onyx/5 bg-white/50">
      {{ $lawyers->links() }}
    </div>
    @endif
  </div>
</div>

@endsection
