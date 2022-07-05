<script setup>
import { computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { useBreadStore } from '@bread/js/store'

const store = useBreadStore()

const numberOfActiveFilters = computed(() => {
  const queryParams = route().params

  if (queryParams.filters) {
    return Object.keys(queryParams.filters)?.length
  }

  return 0
})

const removeFilters = () => {
  const queryParams = _.flow([
    Object.entries,
    (arr) => arr.filter(([key, value]) => key !== 'filters'),
    Object.fromEntries,
  ])(route().params)

  Inertia.get(route(route().current(), queryParams))
}
</script>

<template>
  <span class="relative z-0 inline-flex rounded-md shadow-sm">
    <div
      @click="store.toggleShowFilters()"
      type="button"
      class="relative inline-flex cursor-pointer items-center rounded-l-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none"
      :class="{ 'rounded-r-md': numberOfActiveFilters === 0 }"
    >
      {{
        store.show_filters
          ? store.translate('hide', { ucfirst: true })
          : store.translate('show', { ucfirst: true })
      }}
      {{ store.translate('filters', { ucfirst: true }) }}
    </div>
    <div
      v-if="numberOfActiveFilters > 0"
      type="button"
      class="relative -ml-px inline-flex cursor-pointer items-center rounded-r-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none"
      title="Remove Filters"
      @click="removeFilters()"
    >
      {{ numberOfActiveFilters }}
    </div>
  </span>
</template>
