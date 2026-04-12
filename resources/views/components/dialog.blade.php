<template>
  <div
    class="fixed inset-0 bg-black/50 z-[2] flex items-center justify-center p-4"
    :class="{
      'pointer-events-none opacity-0': !open,
      'pointer-events-auto opacity-100': open
    }"
    @keydown.escape="onClose"
  >
    <div
      class="relative max-w-2xl w-full"
      @click="handleOverlayClick"
    >
      <div
        class="bg-white dark:bg-gray-900 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden"
        :class="{
          'opacity-0 scale-95': !open,
          'opacity-100 scale-100': open
        }"
        @click.stop
      >
        <div
          v-if="$slots.title || $slots.description"
          class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gold-50/30 backdrop-blur-sm"
        >
          <div v-if="$slots.title" class="flex items-center justify-between mb-2">
            <slot name="title"></slot>
            <button
              v-if="closable"
              type="button"
              class="p-1 -mr-2 -mt-2 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg"
              @click="onClose"
            >
              <svg class="h-6 w-6 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="9" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 5l7 7m0 0l7-7m-7 7V8m0 13l-3-3m-6 3a9 9 0 110-18 9 9 0 010 18z" />
              </svg>
            </button>
          </div>

          <div v-if="$slots.description" class="text-sm text-gray-600 dark:text-gray-400">
            <slot name="description"></slot>
          </div>
        </div>

        <div class="p-6">
          <slot name="default"></slot>
        </div>

        <div
          v-if="$slots.footer"
          class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50"
        >
          <slot name="footer"></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    open: {
      type: Boolean,
      default: false
    },
    closable: {
      type: Boolean,
      default: true
    },
    closeOnOverlayClick: {
      type: Boolean,
      default: true
    }
  },
  emits: ['close'],
  methods: {
    onClose() {
      if (this.closable) {
        this.$emit('close')
      }
    },
    handleOverlayClick(event) {
      if (this.closeOnOverlayClick && event.target === event.currentTarget) {
        this.onClose()
      }
    }
  }
}
</script>