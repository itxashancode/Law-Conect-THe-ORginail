{{-- Luxury Confirmation Modal — LegalCounsel Bespoke Component --}}
<div x-data="{ 
        open: false, 
        title: 'Confirm Action', 
        message: 'Are you sure you want to proceed?', 
        confirmText: 'Confirm', 
        cancelText: 'Cancel',
        callback: null,
        
        trigger(config) {
            this.title = config.title || 'Confirm Action';
            this.message = config.message || 'Are you sure?';
            this.confirmText = config.confirmText || 'Confirm';
            this.cancelText = config.cancelText || 'Cancel';
            this.callback = config.callback;
            this.open = true;
        },
        
        proceed() {
            if (this.callback) this.callback();
            this.open = false;
        }
     }"
     @confirm-action.window="trigger($event.detail)"
     class="relative z-[200]"
     x-cloak>
    
    {{-- Backdrop --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-onyx/40 backdrop-blur-md"
         @click="open = false"></div>

    {{-- Modal Content --}}
    <div x-show="open" 
         class="fixed inset-0 flex items-center justify-center p-6 pointer-events-none">
        
        <div x-show="open"
             x-transition:enter="transition ease-out duration-600"
             x-transition:enter-start="opacity-0 scale-95 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-400"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-8"
             class="bg-white border border-onyx/5 w-full max-w-md p-12 shadow-premium pointer-events-auto text-center relative overflow-hidden">
            
            {{-- Decorative Accent --}}
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-gold-500 to-transparent"></div>

            <div class="w-20 h-20 rounded-full border border-onyx/5 flex items-center justify-center mx-auto mb-10 text-gold-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>

            <h3 class="font-serif text-4xl italic text-onyx mb-4" x-text="title"></h3>
            <p class="text-sm font-light text-onyx/40 mb-12 uppercase tracking-widest leading-loose" x-text="message"></p>

            <div class="flex flex-col gap-4">
                <button @click="proceed()" 
                        class="btn-lux btn-lux-gold w-full text-xs py-5">
                    <span x-text="confirmText"></span>
                </button>
                <button @click="open = false" 
                        class="btn-lux btn-lux-outline w-full text-xs py-5">
                    <span x-text="cancelText"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Global helper for the luxury confirmation
    function luxuryConfirm(formOrCallback, config = {}) {
        const isForm = formOrCallback instanceof HTMLFormElement;
        
        window.dispatchEvent(new CustomEvent('confirm-action', {
            detail: {
                title: config.title || 'Are you sure?',
                message: config.message || 'Please confirm you wish to proceed with this action.',
                confirmText: config.confirmText || 'Proceed',
                cancelText: config.cancelText || 'Cancel',
                callback: () => {
                    if (isForm) {
                        formOrCallback.submit();
                    } else if (typeof formOrCallback === 'function') {
                        formOrCallback();
                    }
                }
            }
        }));
        
        return false; // Prevents default form submission
    }
</script>
