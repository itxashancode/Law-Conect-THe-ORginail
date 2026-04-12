@extends('layouts.public')

@section('title', 'Admin Dashboard — LegalCounsel')

@section('content')
<div class="pt-44 pb-20 px-6 lg:px-20 min-h-screen">
  <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-16 gap-6 border-b border-onyx-5 pb-10">
    <div>
      <h1 class="text-4xl italic mb-1 font-serif">Management Console</h1>
      <p class="text-[10px] tracking-widest uppercase text-onyx-40 font-bold">Authenticated Admin Session</p>
    </div>
    <div class="flex flex-col md:flex-row items-start md:items-center gap-6 w-full md:w-auto">
      <nav class="flex w-full md:w-auto overflow-x-auto gap-6 text-[10px] font-bold tracking-ultra uppercase text-onyx-40 pb-2 md:pb-0" style="scrollbar-width: none;">
        <a href="{{ route('admin.dashboard') }}" class="whitespace-nowrap hover:text-gold-500 transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-gold-500' : '' }}">Dashboard</a>
        <a href="{{ route('admin.lawyers.index') }}" class="whitespace-nowrap hover:text-gold-500 transition-colors {{ request()->routeIs('admin.lawyers.*') ? 'text-gold-500' : '' }}">Lawyers</a>
        <a href="{{ route('admin.bookings.index') }}" class="whitespace-nowrap hover:text-gold-500 transition-colors {{ request()->routeIs('admin.bookings.*') ? 'text-gold-500' : '' }}">Bookings</a>
        <a href="{{ route('admin.slots.index') }}" class="whitespace-nowrap hover:text-gold-500 transition-colors {{ request()->routeIs('admin.slots.*') ? 'text-gold-500' : '' }}">Slots</a>
        <a href="{{ route('admin.homepage.index') }}" class="whitespace-nowrap hover:text-gold-500 transition-colors {{ request()->routeIs('admin.homepage.*') ? 'text-gold-500' : '' }}">Content</a>
      </nav>
    </div>
  </div>

  @yield('dashboard-content')
</div>
@endsection
