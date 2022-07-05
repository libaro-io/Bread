<script setup>
import { Link } from '@inertiajs/inertia-vue3'
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/solid'
import { useBreadStore } from '@bread/js/store'

const store = useBreadStore()

const props = defineProps({
  items: {
    type: Object,
    default: {},
  },
})
</script>

<template>
  <div class="flex items-center justify-between py-5">
    <div class="flex flex-1 justify-between sm:hidden">
      <Link
          :href="items.prev_page_url"
          class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
      >
        {{ store.translate('previous', { ucfirst: true }) }}
      </Link>
      <Link
          :href="items.next_page_url"
          class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
      >
        {{ store.translate('next', { ucfirst: true }) }}
      </Link>
    </div>
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          {{ store.translate('show', { ucfirst: true }) }}
          {{ ' ' }}
          <span class="font-medium">
            {{ items.from }}
          </span>
          {{ ' ' }}
          {{ store.translate('to') }}
          {{ ' ' }}
          <span class="font-medium">
            {{ items.to }}
          </span>
          <span v-if="items.hasOwnProperty('total')">
            {{ ' ' }}
            {{ store.translate('from') }}
            {{ ' ' }}
            <span class="font-medium">
              {{ items.total }}
            </span>
            {{ ' ' }}
            {{ store.translate('results') }}
          </span>
        </p>
      </div>
      <div>
        <nav
            class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm"
            aria-label="Pagination"
        >
          <Link
              v-for="link in items.links"
              :href="link.url ?? '#'"
              :class="
              link.active
                ? 'z-10 border-indigo-500 bg-indigo-50 text-indigo-600'
                : 'border-gray-300 bg-white text-gray-500 hover:bg-gray-50'
            "
              class="relative inline-flex items-center border px-4 py-2 text-sm font-medium"
              v-html="link.label"
          ></Link>
        </nav>
      </div>
    </div>
  </div>
</template>
