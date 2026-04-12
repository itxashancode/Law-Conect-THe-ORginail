@extends('layouts.admin')
@section('page-title', 'Customer Management')
@section('page-subtitle', 'Manage registered clients and access status.')

@section('dashboard-content')
<div class="space-y-8">
    {{-- Stats Row --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-onyx/5 p-6 bespoke-card">
            <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-1">Total Customers</p>
            <p class="font-serif text-4xl text-onyx">{{ $customers->count() }}</p>
        </div>
        <div class="bg-white border border-onyx/5 p-6 bespoke-card">
            <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-1">Active Accounts</p>
            <p class="font-serif text-4xl text-green-600">{{ $customers->where('status', 'active')->count() }}</p>
        </div>
        <div class="bg-white border border-onyx/5 p-6 bespoke-card">
            <p class="text-[10px] font-bold tracking-widest uppercase text-onyx/40 mb-1">Banned Accounts</p>
            <p class="font-serif text-4xl text-red-600">{{ $customers->where('status', 'banned')->count() }}</p>
        </div>
    </div>

    {{-- Customers Table --}}
    <div class="bg-white border border-onyx/5 bespoke-card overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-onyx text-white">
                    <th class="px-6 py-4 text-[10px] font-bold tracking-widest uppercase">Name</th>
                    <th class="px-6 py-4 text-[10px] font-bold tracking-widest uppercase">Email</th>
                    <th class="px-6 py-4 text-[10px] font-bold tracking-widest uppercase">Joined</th>
                    <th class="px-6 py-4 text-[10px] font-bold tracking-widest uppercase">Status</th>
                    <th class="px-6 py-4 text-[10px] font-bold tracking-widest uppercase text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-onyx/5 text-sm">
                @forelse($customers as $customer)
                <tr class="hover:bg-onyx/[0.02] transition-colors">
                    <td class="px-6 py-4 font-medium text-onyx">{{ $customer->name }}</td>
                    <td class="px-6 py-4 text-onyx/60">{{ $customer->email }}</td>
                    <td class="px-6 py-4 text-onyx/40">{{ $customer->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        @if($customer->status === 'banned')
                            <span class="px-2 py-1 bg-red-100 text-red-700 text-[10px] font-bold uppercase tracking-wider rounded">Banned</span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider rounded">Active</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            @if($customer->status !== 'banned')
                            <form action="{{ route('admin.customers.ban', $customer->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 border border-red-500/20 text-red-600 text-[10px] font-bold uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all">Ban</button>
                            </form>
                            @else
                            <form action="{{ route('admin.customers.activate', $customer->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 border border-green-500/20 text-green-600 text-[10px] font-bold uppercase tracking-widest hover:bg-green-600 hover:text-white transition-all">Reactivate</button>
                            </form>
                            @endif
                            <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Permanently remove this customer?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-onyx/20 hover:text-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-onyx/30 italic">No customers registered in the system.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
