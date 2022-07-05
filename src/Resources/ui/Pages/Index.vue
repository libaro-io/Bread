<script setup>
import {usePage} from '@inertiajs/inertia-vue3'
import {useBreadStore} from '@bread/js/store'
import Table from './../Components/Table/Table'
import Filters from './../Components/Filter/Filters'
import Pagination from './../Components/Table/Pagination'
import SectionHeading from './../Components/Elements/Section/Heading'
import ShowFiltersButton from './../Components/Filter/ShowFiltersButton'
import {
  computed,
  defineAsyncComponent,
  onMounted,
  onUnmounted,
  getCurrentInstance,
} from 'vue'

const store = useBreadStore()

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  headers: {
    type: Object,
    required: true,
  },
  items: {
    type: [Array, Object],
  },
  routes: {
    type: Object,
    required: true,
  },
  resource: {
    type: String,
    required: true,
  },
  filters: {
    type: Object,
    default: [],
  },
  lang: {
    type: String,
    default: 'en',
  },
  components: {
    type: Object,
    required: false,
    default: {},
  }
})

onMounted(() => {
  store.setLang(props.lang)
  store.setResource(props.resource)
  store.setFilters(props.resource, props.filters)
})

onUnmounted(() => {
  store.unsetFilters()
})

const isPaginated = computed(() => {
  return props.items.hasOwnProperty('data')
})

const loadComponent = (component) => {
  return defineAsyncComponent(() => import(`./../Components/${component}`))
}
</script>

<template>
  <div class="relative min-h-screen">
    <SectionHeading
        :label="props.title"
        :link="props.routes.create ? props.routes.create.name : null"
    >
      <template v-slot:actions></template>
      <template v-slot:after-actions>
        <div class="flex items-stretch space-x-4">
          <component
              v-for="component in props.components['header']"
              v-bind:is="loadComponent(component.component)"
              :data="component.data"
          />
          <ShowFiltersButton v-if="store.resourceHasFilters()" />
        </div>
      </template>
    </SectionHeading>

    <Filters />

    <Table
        :items="props.items.data ?? props.items"
        :headers="props.headers"
        :routes="props.routes"
        :delete-message="$attrs.deleteMessage"
    ></Table>
    <Pagination v-if="isPaginated" :items="props.items"></Pagination>
  </div>
</template>
