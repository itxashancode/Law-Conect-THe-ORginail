<template>
  <div class="space-y-6">
    <!-- Search Results Loading -->
    <div v-if="loading" class="space-y-6">
      <div class="space-y-4">
        <!-- Loading Card -->
        <div v-for="i in 3" :key="i" class="bg-linen rounded-bespoke border border-gold-200/50 shadow-luxury p-6">
          <div class="space-y-4">
            <div class="flex items-center gap-4">
              <!-- Avatar Skeleton -->
              <div class="w-16 h-16 rounded-full bg-onyx/10 animate-pulse" />
              <div class="flex-1 space-y-2">
                <!-- Name Skeleton -->
                <div class="w-32 h-4 bg-onyx/20 rounded animate-pulse" />
                <!-- Title Skeleton -->
                <div class="w-24 h-3 bg-onyx/20 rounded animate-pulse" />
              </div>
            </div>
            <!-- Bio Skeleton -->
            <div class="w-full h-16 bg-onyx/20 rounded animate-pulse" />
            <!-- Info Grid Skeleton -->
            <div class="grid grid-cols-2 gap-4">
              <div class="w-full h-4 bg-onyx/20 rounded animate-pulse" />
              <div class="w-full h-4 bg-onyx/20 rounded animate-pulse" />
            </div>
          </div>
        </div>
      </div>

      <!-- Loading Pagination -->
      <div class="flex items-center justify-between">
        <!-- Previous Button Skeleton -->
        <button disabled class="px-4 py-2 bg-onyx/10 text-onyx/50 hover:bg-onyx/20 transition-colors duration-200 rounded-bespoke cursor-not-allowed">
          <!-- Icon Skeleton -->
          <span class="w-4 h-4 bg-onyx/20 rounded animate-pulse inline-block" />
          Previous
        </button>
        <!-- Page Info Skeleton -->
        <div class="text-sm text-onyx/50">
          <!-- Numbers Skeleton -->
          <span class="w-8 h-4 bg-onyx/20 rounded animate-pulse inline-block" />
          of
          <span class="w-8 h-4 bg-onyx/20 rounded animate-pulse inline-block" />
        </div>
        <!-- Next Button Skeleton -->
        <button disabled class="px-4 py-2 bg-onyx/10 text-onyx/50 hover:bg-onyx/20 transition-colors duration-200 rounded-bespoke cursor-not-allowed">
          Next
          <!-- Icon Skeleton -->
          <span class="w-4 h-4 bg-onyx/20 rounded animate-pulse inline-block" />
        </button>
      </div>
    </div>

    <!-- Loading States for Individual Components -->
    <!-- Loading Card -->
    <div v-if="cardLoading" class="bg-linen rounded-bespoke border border-gold-200/50 shadow-luxury p-6">
      <div class="space-y-4">
        <div class="flex items-center gap-4">
          <!-- Avatar Skeleton -->
          <div class="w-12 h-12 rounded-full bg-onyx/10 animate-pulse" />
          <div class="flex-1 space-y-2">
            <!-- Name Skeleton -->
            <div class="w-24 h-4 bg-onyx/20 rounded animate-pulse" />
            <!-- Title Skeleton -->
            <div class="w-20 h-3 bg-onyx/20 rounded animate-pulse" />
          </div>
        </div>
        <!-- Content Skeleton -->
        <div class="w-full h-12 bg-onyx/20 rounded animate-pulse" />
      </div>
    </div>

    <!-- Loading Table Row -->
    <div v-if="tableRowLoading" class="bg-linen rounded-bespoke border border-gold-200/50 shadow-luxury p-4">
      <div class="grid grid-cols-4 gap-4">
        <!-- Cell 1 -->
        <div class="space-y-2">
          <!-- Avatar Skeleton -->
          <div class="w-10 h-10 rounded-full bg-onyx/10 animate-pulse" />
          <!-- Text Skeletons -->
          <div class="w-20 h-3 bg-onyx/20 rounded animate-pulse" />
          <div class="w-16 h-3 bg-onyx/20 rounded animate-pulse" />
        </div>
        <!-- Cell 2 -->
        <div class="space-y-2">
          <!-- Avatar Skeleton -->
          <div class="w-10 h-10 rounded-full bg-onyx/10 animate-pulse" />
          <!-- Text Skeletons -->
          <div class="w-16 h-3 bg-onyx/20 rounded animate-pulse" />
          <div class="w-12 h-3 bg-onyx/20 rounded animate-pulse" />
        </div>
        <!-- Cell 3 -->
        <div class="space-y-2">
          <div class="w-24 h-4 bg-onyx/20 rounded animate-pulse" />
          <div class="w-20 h-3 bg-onyx/20 rounded animate-pulse" />
        </div>
        <!-- Cell 4 -->
        <div class="w-16 h-6 bg-onyx/20 rounded animate-pulse" />
        <!-- Cell 5 -->
        <div class="w-32 h-6 bg-onyx/20 rounded animate-pulse" />
      </div>
    </div>

    <!-- Loading Button -->
    <button
      v-if="buttonLoading"
      disabled
      class="px-4 py-2 bg-onyx/10 text-onyx/50 hover:bg-onyx/20 transition-colors duration-200 rounded-bespoke cursor-not-allowed"
    >
      <!-- Icon Skeleton -->
      <span class="w-4 h-4 bg-onyx/20 rounded animate-pulse inline-block" />
      Loading...
    </button>
  </div>
<template>

<script>
export default {
  props: {
    loading: {
      type: Boolean,
      default: false
    },
    cardLoading: {
      type: Boolean,
      default: false
    },
    tableRowLoading: {
      type: Boolean,
      default: false
    },
    buttonLoading: {
      type: Boolean,
      default: false
    }
  }
}
</script>