<template>
  <div class="space-y-3" role="status" aria-live="polite">
    <div
      v-for="(skeleton, index) in count"
      :key="index"
      class="animate-pulse rounded bg-gray-200 dark:bg-gray-700"
      :class="{
        'h-8 w-1/2': variant === 'text',
        'h-12 w-full': variant === 'heading',
        'h-6 w-3/4': variant === 'line',
        'h-20 w-full rounded-lg': variant === 'card',
        'h-10 w-20 rounded-full': variant === 'avatar',
        'h-6 w-12 rounded-full': variant === 'badge'
      }"
      :style="style"
    </div>
  </div>
</template>

<script>
export default {
  props: {
    count: {
      type: Number,
      default: 1
    },
    variant: {
      type: String,
      default: 'text',
      validator: (value) => [
        'text', 'heading', 'line', 'card', 'avatar', 'badge'
      ].includes(value)
    },
    style: {
      type: String,
      default: ''
    }
  }
}
</script>