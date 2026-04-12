<template>
  <span
    class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-medium"
    :class="{
      'border-onyx-200 text-onyx bg-onyx/50': variant === 'default',
      'border-gold-200 text-gold-700 bg-gold-50': variant === 'secondary',
      'border-gold-200 text-gold-700 bg-gold-50': variant === 'success',
      'border-onyx-200 text-onyx bg-onyx/50': variant === 'destructive',
      'border-gold-200 text-gold-700 bg-gold-50': variant === 'accent',
      'border-linen-200 text-linen bg-linen/50': variant === 'muted',
      'border-gold-200 text-gold-700 bg-gold-50': variant === 'primary',
      'border-onyx-200 text-onyx bg-onyx/50': variant === 'secondary',
      'border-gold-200 text-gold-700 bg-gold-50': variant === 'warning',
      'border-onyx-200 text-onyx bg-onyx/50': variant === 'outline',
      'border-gold-200 text-gold-700 bg-gold-50': variant === 'ghost'
    }"
    :style="style"
  >
    <slot />
  </span>
</template>

<script>
export default {
  props: {
    variant: {
      type: String,
      default: 'default',
      validator: (value) => [
        'default', 'secondary', 'success', 'destructive', 'accent', 'muted', 'primary', 'secondary', 'warning', 'outline', 'ghost'
      ].includes(value)
    },
    style: {
      type: String,
      default: ''
    }
  }
}
</script>