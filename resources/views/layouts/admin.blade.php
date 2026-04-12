@extends('layouts.public')
@section('title', isset($title) ? $title : 'Admin — LegalCounsel')

@section('content')
<div class="flex min-h-screen pt-24" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

  {{-- Sidebar --}}
  <aside class="fixed left-0 top-24 bottom-0 z-40 flex flex-col transition-all duration-300"
         :class="sidebarOpen ? 'w-64' : 'w-16'"
         style="background: #0D0D0D;">

    {{-- Toggle --}}
    <button @click="sidebarOpen = !sidebarOpen"
            class="flex items-center justify-center h-12 w-full border-b border-white/5 text-white/30 hover:text-gold-500 transition-colors shrink-0">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>

    {{-- Nav Links --}}
    <nav class="flex-1 py-6 overflow-y-auto overflow-x-hidden">
      @php
        $navItems = [
          ['route' => 'admin.dashboard',       'label' => 'Dashboard',   'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
          ['route' => 'admin.lawyers.index',   'label' => 'Lawyers',     'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
          ['route' => 'admin.bookings.index',  'label' => 'Bookings',    'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
          ['route' => 'admin.slots.index',     'label' => 'Slots',       'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
          ['route' => 'admin.homepage.index',  'label' => 'Content',     'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h7'],
        ];
      @endphp

      @foreach($navItems as $item)
        @php $active = request()->routeIs(str_replace('.index', '.*', $item['route'])); @endphp
        <a href="{{ route($item['route']) }}"
           class="flex items-center gap-4 px-4 py-3 mx-2 rounded-lg text-sm font-medium transition-all duration-200 group relative mb-1"
           :class="'{{ $active ? 'bg-gold-500/10 text-gold-400 border-l-2 border-gold-500' : 'text-white/40 hover:text-white hover:bg-white/5 border-l-2 border-transparent' }}'">
          <svg class="w-5 h-5 shrink-0 {{ $active ? 'text-gold-400' : 'text-white/40 group-hover:text-white' }}"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $item['icon'] }}"/>
          </svg>
          <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200"
                class="whitespace-nowrap text-[11px] tracking-widest uppercase font-bold">{{ $item['label'] }}</span>

          {{-- Tooltip on collapsed --}}
          <div x-show="!sidebarOpen"
               class="absolute left-full ml-3 px-3 py-1.5 bg-onyx text-white text-[10px] tracking-widest uppercase font-bold whitespace-nowrap rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-50 border border-gold-500/20">
            {{ $item['label'] }}
          </div>
        </a>
      @endforeach
    </nav>

    {{-- Sidebar Footer --}}
    <div class="p-4 border-t border-white/5 shrink-0">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                class="flex items-center gap-4 w-full px-2 py-2 text-white/30 hover:text-red-400 transition-colors group">
          <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
          <span x-show="sidebarOpen" class="text-[10px] tracking-widest uppercase font-bold whitespace-nowrap">Sign Out</span>
        </button>
      </form>
    </div>
  </aside>

  {{-- Main Content Area --}}
  <main class="flex-1 min-w-0 transition-all duration-300 pb-20"
        :class="sidebarOpen ? 'ml-64' : 'ml-16'">
    {{-- Top Bar --}}
    <div class="sticky top-24 z-30 bg-linen/95 backdrop-blur-md border-b border-onyx/5 px-8 py-4 flex items-center justify-between">
      <div>
        <h1 class="font-serif text-2xl italic text-onyx">@yield('page-title', 'Dashboard')</h1>
        <p class="text-[9px] tracking-widest uppercase text-onyx/30 font-bold mt-0.5">@yield('page-subtitle', 'Executive Management Console')</p>
      </div>
      <div class="flex items-center gap-4">
        <span class="w-2 h-2 bg-gold-500 rounded-full animate-pulse"></span>
        <span class="text-[10px] font-bold tracking-widest uppercase text-onyx/40">{{ auth()->user()->name }}</span>
      </div>
    </div>

    <div class="px-8 pt-8">
      @yield('dashboard-content')
    </div>
  </main>
</div>
@endsection
