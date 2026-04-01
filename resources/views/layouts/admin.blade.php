<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Dashboard — LegalCounsel')</title>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-parchment text-ink-mid font-sans">

<div class="flex h-screen overflow-hidden">
  {{-- Sidebar --}}
  <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-ink transform -translate-x-full lg:translate-x-0 transition-transform duration-300 lg:static lg:inset-auto">
    <div class="flex flex-col h-full">
      <div class="p-6 border-b border-white/10">
        <a href="{{ route('home') }}" class="font-serif text-2xl text-white no-underline">
          Legal<span class="text-gold">Counsel</span>
        </a>
        <p class="text-white/50 text-xs mt-2">Admin Panel</p>
      </div>

      <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-white/70 hover:bg-white/5 hover:text-white transition-all rounded-none">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
          Dashboard
        </a>
        <a href="{{ route('admin.lawyers.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/70 hover:bg-white/5 hover:text-white transition-all rounded-none">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
          Lawyers
        </a>
        <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/70 hover:bg-white/5 hover:text-white transition-all rounded-none">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
          Bookings
        </a>
        <a href="{{ route('admin.slots.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/70 hover:bg-white/5 hover:text-white transition-all rounded-none">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          Slots
        </a>
        <a href="{{ route('admin.homepage.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/70 hover:bg-white/5 hover:text-white transition-all rounded-none">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
          Homepage Content
        </a>
      </nav>

      <div class="p-4 border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-white/70 hover:bg-white/5 hover:text-white transition-all rounded-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Logout
          </button>
        </form>
      </div>
    </div>
  </aside>

  {{-- Mobile overlay --}}
  <div id="sidebar-overlay" class="fixed inset-0 bg-ink/50 z-40 lg:hidden" onclick="toggleSidebar()"></div>

  {{-- Main content --}}
  <div class="flex-1 overflow-auto">
    <main class="p-6 lg:p-10">
      @yield('content')
    </main>
  </div>
</div>

<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
  }
</script>

</body>
</html>
