@props(['type' => 'success', 'message' => ''])

<div x-data="{ 
        show: false,
        visible: false,
        message: '{{ $message ?: session('success') ?: session('error') ?: session('warning') ?: session('info') ?: ($errors->any() ? $errors->first() : '') }}',
        type: '{{ (session('error') || $errors->any()) ? 'error' : (session('warning') ? 'warning' : (session('info') ? 'info' : 'success')) }}'
     }"
     x-init="
        if (message) {
            setTimeout(() => { show = true; visible = true; }, 100);
            setTimeout(() => { visible = false; setTimeout(() => show = false, 500); }, 5000);
        }
     "
     x-show="show"
     class="fixed top-24 right-8 z-[9999] pointer-events-none"
     id="toast-container">
    
    <div x-show="visible"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-x-24 scale-95"
         x-transition:enter-end="opacity-100 translate-x-0 scale-100"
         x-transition:leave="transition ease-in duration-400"
         x-transition:leave-start="opacity-100 translate-x-0 scale-100"
         x-transition:leave-end="opacity-0 translate-x-12 scale-90"
         class="bg-white border border-onyx/5 p-4 pr-6 shadow-premium pointer-events-auto relative overflow-hidden flex items-center gap-4"
         :class="{
            'border-l-4 border-l-gold-500': type === 'success',
            'border-l-4 border-l-red-600': type === 'error',
            'border-l-4 border-l-onyx': type === 'warning' || type === 'info'
         }">
        
        {{-- Luxury background accent --}}
        <div class="absolute top-0 right-0 w-32 h-32 bg-gold-500/5 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>

        <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0"
             :class="{
                'bg-gold-500/10 text-gold-600': type === 'success',
                'bg-red-500/10 text-red-600': type === 'error',
                'bg-onyx/5 text-onyx/60': type === 'info' || type === 'warning'
             }">
            <template x-if="type === 'success'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </template>
            <template x-if="type === 'error'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </template>
            <template x-if="type === 'warning' || type === 'info'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </template>
        </div>

        <div class="flex-1 min-w-[200px]">
            <p class="text-[9px] font-bold tracking-widest text-onyx/30 uppercase mb-0.5" x-text="type === 'success' ? 'Confirmed' : type"></p>
            <p class="text-[11px] font-bold text-onyx leading-tight uppercase tracking-wide" x-text="message"></p>
        </div>

        <button @click="visible = false" class="text-onyx/20 hover:text-onyx transition-colors ml-4 p-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        {{-- Progress Bar --}}
        <div class="absolute bottom-0 left-0 h-[2px] bg-gold-500/20" 
             x-init="if (message) { $el.style.width = '100%'; $el.style.transition = 'width 5000ms linear'; setTimeout(() => $el.style.width = '0%', 100); }">
        </div>
    </div>
</div>
