<template>
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-50 dark:bg-gray-800">
        <tr>
          <th
            v-for="(column, index) in columns"
            :key="index"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider"
            :class="{
              'text-right': column.align === 'right',
              'text-center': column.align === 'center'
            }"
          >
            {{ column.label }}
          </th>
        </tr>
      </thead>
      <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
        <tr
          v-for="(row, index) in data"
          :key="index"
          class="hover:bg-gray-50 dark:hover:bg-gray-800"
        >
          <td
            v-for="(column, colIndex) in columns"
            :key="colIndex"
            class="px-6 py-4 whitespace-nowrap"
            :class="{
              'text-right': column.align === 'right',
              'text-center': column.align === 'center',
              'text-sm font-medium text-gray-900 dark:text-gray-100': column.type === 'primary',
              'text-sm text-gray-500 dark:text-gray-400': column.type === 'secondary',
              'text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-950': column.type === 'success',
              'text-sm text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-950': column.type === 'danger',
              'text-sm text-gold-600 dark:text-gold-400 bg-gold-50 dark:bg-gold-950': column.type === 'warning'
            }"
          >
            <div v-if="column.type === 'status'" class="inline-flex items-center gap-2">
              <span
                class="inline-block w-2 h-2 rounded-full"
                :class="{
                  'bg-green-500': row[column.key] === 'approved',
                  'bg-yellow-500': row[column.key] === 'pending',
                  'bg-red-500': row[column.key] === 'rejected',
                  'bg-gray-500': row[column.key] === 'inactive'
                }"
              ></span>
              {{ row[column.key] }}
            </div>

            <div v-else-if="column.type === 'action'" class="flex gap-2">
              <button
                v-for="action in column.actions"
                :key="action.type"
                type="button"
                class="px-3 py-1 text-xs font-medium rounded hover:bg-gray-100 dark:hover:bg-gray-700"
                :class="{
                  'text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-950': action.type === 'edit',
                  'text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950': action.type === 'delete',
                  'text-gold-600 dark:text-gold-400 hover:bg-gold-50 dark:hover:bg-gold-950': action.type === 'view'
                }"
                @click="action.onClick(row)"
              >
                {{ action.label }}
              </button>
            </div>

            <span v-else>{{ row[column.key] }}</span>
          </td>
        </tr>
      </tbody>
    <table>

    <div v-if="data.length === 0" class="px-6 py-8 text-center">
      <div class="mx-auto w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
        <svg class="w-6 h-6 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17I 2a2 2 0 002-2v-8a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2zm7-12a2 2 0 00-2 2v8a2 2 0 002 2h2a2 2 0 002-2v-6a2 2 0 00-2-2z" />
        </svg>
      </div>
      <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">No data available</p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    columns: {
      type: Array,
      required: true
    },
    data: {
      type: Array,
      default: () => []
    }
  }
}
</script>