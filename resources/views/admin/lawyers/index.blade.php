@extends('layouts.admin')
@section('title', 'Manage Lawyers — LegalCounsel')

@section('content')
<div data-aos="fade-up">
  <div class="flex justify-between items-center mb-8">
    <h1 class="font-serif text-4xl text-ink">All Lawyers</h1>
    <a href="{{ route('home') }}" class="btn-primary">View Public Site</a>
  </div>

  <div class="bg-warm-surface border border-warm-border">
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left">
        <thead class="bg-ink text-white">
          <tr>
            <th class="px-6 py-4">ID</th>
            <th class="px-6 py-4">Name</th>
            <th class="px-6 py-4">Email</th>
            <th class="px-6 py-4">Specialization</th>
            <th class="px-6 py-4">City</th>
            <th class="px-6 py-4">Phone</th>
            <th class="px-6 py-4">Status</th>
            <th class="px-6 py-4">Experience</th>
            <th class="px-6 py-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($lawyers as $lawyer)
          <tr class="border-b border-warm-border hover:bg-parchment/30">
            <td class="px-6 py-4">{{ $lawyer->id }}</td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 overflow-hidden shrink-0">
                  <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=1A1A1A&color=B8860B' }}"
                       alt="{{ $lawyer->full_name }}"
                       class="w-full h-full object-cover">
                </div>
                <span class="font-serif text-ink">{{ $lawyer->full_name }}</span>
              </div>
            </td>
            <td class="px-6 py-4">{{ $lawyer->user->email }}</td>
            <td class="px-6 py-4">{{ $lawyer->specialization }}</td>
            <td class="px-6 py-4">{{ $lawyer->city }}</td>
            <td class="px-6 py-4">{{ $lawyer->phone }}</td>
            <td class="px-6 py-4">
              <span class="inline-block px-3 py-1 text-xs border
                @if($lawyer->status === 'approved') border-green-500 text-green-700
                @elseif($lawyer->status === 'pending') border-yellow-500 text-yellow-700
                @else border-red-500 text-red-700
                @endif">
                {{ ucfirst($lawyer->status) }}
              </span>
            </td>
            <td class="px-6 py-4">{{ $lawyer->experience_years }} yrs</td>
            <td class="px-6 py-4">
              @if($lawyer->status === 'pending')
                <form method="POST" action="{{ route('admin.lawyers.approve', $lawyer->id) }}" class="inline">
                  @csrf @method('POST')
                  <button type="submit" class="text-green-600 hover:text-green-800 mr-3 text-sm">Approve</button>
                </form>
                <form method="POST" action="{{ route('admin.lawyers.reject', $lawyer->id) }}" class="inline" onsubmit="return confirm('Reject this lawyer?')">
                  @csrf @method('POST')
                  <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Reject</button>
                </form>
              @else
                <form method="POST" action="{{ route('admin.lawyers.destroy', $lawyer->id) }}" class="inline" onsubmit="return confirm('Delete this lawyer permanently?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                </form>
              @endif
            </td>
          </tr>
          @empty
          <tr><td colspan="9" class="px-6 py-10 text-center text-ink-muted">No lawyers registered yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
