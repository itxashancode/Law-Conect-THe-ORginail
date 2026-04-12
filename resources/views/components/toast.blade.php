@props(['type' => 'success', 'message' => ''])

<div x-data="{ 
        show: false,
        visible: false,
        message: '{{ $message ?: session('success') ?: session('error') ?: session('warning') ?: session('info') }}',
        type: '{{ session('error') ? 'error' : (session('warning') ? 'warning' : (session('info') ? 'info' : 'success')) }}'
     }"
     x-init="
        if (message) {
            setTimeout(() => { show = true; visible = true; }, 100);
            setTimeout(() => { visible = false; setTimeout(() => show = false, 500); }, 5000);
        }
     "
     x-show="show"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="opacity-0 translate-y-12 scale-95"
     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
     x-transition:leave-end="opacity-0 translate-y-4 scale-95"
     class="fixed bottom-8 right-8 z-[9999] pointer-events-none"
     id="toast-container">
    
    <div x-show="visible"
         class="bg-white/80 backdrop-blur-xl border border-onyx/10 p-5 rounded-xl shadow-premium flex items-center gap-5 max-w-sm pointer-events-auto"
         :class="{
            'border-gold-500/20': type === 'success',
            'border-red-500/20': type === 'error',
            'border-onyx/20': type === 'info'
         }">
        
        <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0"
             :class="{
                'bg-gold-500/10 text-gold-600': type === 'success',
                'bg-red-500/10 text-red-600': type === 'error',
                'bg-onyx/5 text-onyx/60': type === 'info'
             }">
            <template x-if="type === 'success'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </template>
            <template x-if="type === 'error'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </template>
        </div>

        <div class="flex-1">
            <p class="text-[10px] font-bold tracking-widest text-onyx/30 uppercase mb-0.5" x-text="type"></p>
            <p class="text-[11px] font-bold text-onyx leading-tight" x-text="message"></p>
        </div>

        <button @click="visible = false" class="text-onyx/20 hover:text-onyx transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
</div>
