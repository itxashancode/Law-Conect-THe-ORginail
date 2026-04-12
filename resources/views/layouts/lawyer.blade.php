@extends('layouts.public')
@section('hide_footer', true)

@section('title', 'Lawyer Dashboard — LegalCounsel')

@section('content')
<div class="pt-32 pb-20 px-6 lg:px-20 min-h-screen">
  <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-16 gap-6">
    <div>
      <h1 class="text-5xl italic mb-2">My Practice</h1>
      <p class="text-onyx-50 font-light">Client and availability management</p>
    </div>
    
    <div class="flex items-center gap-6">
    <div class="flex flex-col md:flex-row items-start md:items-center gap-6 w-full md:w-auto">
      <nav class="flex w-full md:w-auto overflow-x-auto gap-6 text-[10px] font-bold tracking-ultra uppercase text-onyx-40 pb-2 md:pb-0" style="scrollbar-width: none;">
        <a href="{{ route('lawyer.dashboard') }}" class="whitespace-nowrap hover:text-gold-500 transition-colors {{ request()->routeIs('lawyer.dashboard') ? 'text-gold-500' : '' }}">Dashboard</a>
        <a href="{{ route('lawyer.slots.index') }}" class="whitespace-nowrap hover:text-gold-500 transition-colors {{ request()->routeIs('lawyer.slots.*') ? 'text-gold-500' : '' }}">Calendar</a>
        <a href="{{ route('lawyer.profile.edit') }}" class="whitespace-nowrap hover:text-gold-500 transition-colors {{ request()->routeIs('lawyer.profile.*') ? 'text-gold-500' : '' }}">My Identity</a>
      </nav>
    </div>

      <div class="relative group">
        <button class="flex items-center gap-3 border border-onyx-10 px-4 py-2 hover:bg-onyx-5 transition-colors shadow-sm">
          <span class="w-1.5 h-1.5 bg-gold-500 rounded-full"></span>
          <span class="text-[10px] font-bold tracking-ultra uppercase">{{ auth()->user()->name }}</span>
        </button>
        <div class="absolute right-0 top-full mt-2 w-48 bg-white border border-onyx-10 shadow-premium opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
           <a href="{{ route('public.lawyer', auth()->user()->lawyer->id ?? 0) }}" class="block w-full text-left px-4 py-3 text-[10px] font-bold tracking-ultra uppercase hover:bg-onyx-5 transition-colors border-b border-onyx-5">
             Public Profile
           </a>
           <form method="POST" action="{{ route('logout') }}">
             @csrf
             <button type="submit" class="w-full text-left px-4 py-3 text-[10px] font-bold tracking-ultra uppercase hover:bg-onyx-5 transition-colors text-red-600">
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
