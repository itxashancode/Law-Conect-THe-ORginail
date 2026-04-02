@extends('layouts.public')

@section('title', 'Admin Dashboard — LegalCounsel')

@section('content')
<div class="pt-32 pb-20 px-6 lg:px-20 min-h-screen">
  <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-16 gap-6">
    <div>
      <h1 class="text-5xl italic mb-2">Admin Portal</h1>
      <p class="text-onyx-50 font-light">Platform oversight and management</p>
    </div>
    
    <div class="flex items-center gap-6">
      <nav class="hidden md:flex gap-6 text-[10px] font-bold tracking-ultra uppercase text-onyx-40">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-gold-500 transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-gold-500' : '' }}">Dashboard</a>
        <a href="{{ route('admin.lawyers.index') }}" class="hover:text-gold-500 transition-colors {{ request()->routeIs('admin.lawyers.*') ? 'text-gold-500' : '' }}">Lawyers</a>
        <a href="{{ route('admin.bookings.index') }}" class="hover:text-gold-500 transition-colors {{ request()->routeIs('admin.bookings.*') ? 'text-gold-500' : '' }}">Bookings</a>
        <a href="{{ route('admin.slots.index') }}" class="hover:text-gold-500 transition-colors {{ request()->routeIs('admin.slots.*') ? 'text-gold-500' : '' }}">Slots</a>
        <a href="{{ route('admin.homepage.index') }}" class="hover:text-gold-500 transition-colors {{ request()->routeIs('admin.homepage.*') ? 'text-gold-500' : '' }}">Content</a>
      </nav>

      <div class="w-px h-6 bg-onyx-10 hidden md:block"></div>

      <div class="relative group">
        <button class="flex items-center gap-3 border border-onyx-10 px-4 py-2 hover:bg-onyx-5 transition-colors">
          <span class="w-1.5 h-1.5 bg-gold-500 rounded-full"></span>
          <span class="text-[10px] font-bold tracking-ultra uppercase">{{ auth()->user()->name }}</span>
        </button>
        <div class="absolute right-0 top-full mt-2 w-48 bg-white border border-onyx-10 shadow-premium opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
           <form method="POST" action="{{ route('logout') }}">
             @csrf
             <button type="submit" class="w-full text-left px-4 py-3 text-[10px] font-bold tracking-ultra uppercase hover:bg-onyx-5 transition-colors">
               Sign Out
             </button>
           </form>
        </div>
      </div>
    </div>
  </div>

  @yield('dashboard-content')
</div>
@endsection
