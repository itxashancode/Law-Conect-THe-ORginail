<template>
  <div
    class="inline-flex rounded-full bg-linen/20"
    :class="{
      'border-2 border-gold-200/50': !image,
      'ring-2 ring-inset ring-gold-500/20': outlined,
      'ring-2 ring-inset ring-onyx/20': variant === 'destructive',
      'ring-2 ring-inset ring-gold-500/20': variant === 'secondary'
    }"
    :style="style"
  >
    <img
      v-if="image"
      :src="image"
      :alt="alt"
      class="inline-block h-full w-full rounded-full object-cover"
      :class="{
        'opacity-75 grayscale': !imageLoaded
      }"
      @load="imageLoaded = true"
      @error="imageLoaded = false"
    />

    <div
      v-else
      class="flex items-center justify-center h-full w-full rounded-full"
      :class="{
        'text-onyx bg-gold-100': variant === 'default',
        'text-gold-600 bg-onyx/20': variant === 'destructive',
        'text-linen bg-onyx-600': variant === 'secondary',
        'text-gold-600 bg-onyx/10': variant === 'ghost'
      }"
    >
      <span
        v-if="initials"
        class="text-sm font-medium leading-none"
        :class="{
          'sm:text-base': size === 'medium',
          'text-lg font-semibold': size === 'large',
          'text-xl font-bold': size === 'xlarge'
        }"
      >{{ initials }}</span>

      <slot v-else />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    initials: {
      type: String,
      default: ''
    },
    image: {
      type: String,
      default: ''
    },
    alt: {
      type: String,
      default: ''
    },
    variant: {
      type: String,
      default: 'default',
      validator: (value) => ['default', 'destructive', 'secondary', 'ghost'].includes(value)
    },
    outlined: {
      type: Boolean,
      default: false
    },
    size: {
      type: String,
      default: 'default',
      validator: (value) => ['default', 'medium', 'large', 'xlarge'].includes(value)
    },
    style: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      imageLoaded: false
    }
  }
}
</script>