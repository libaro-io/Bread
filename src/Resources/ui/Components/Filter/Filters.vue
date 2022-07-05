<script setup>
import Inline from './Inline'
import SlideOver from './SlideOver'
import { Inertia } from '@inertiajs/inertia'
import { useBreadStore } from '@bread/js/store'

const store = useBreadStore()

const filter = () => {
  let queryParam = route().params
  let filters = {}
  store.getFilters().forEach((filter) => {
    if (filter.value) {
      filters[filter.field] = filter.value
    }
  })

  Inertia.get(route(route().current(), { ...queryParam, filters }))
}
</script>

<template>
  <div v-if="store.resource && store.resourceHasFilters()">
    <Inline v-if="store.showFiltersInline()" @filter="filter" />
    <SlideOver v-else @filter="filter" />
  </div>
</template>
