<script setup>
import { Link } from '@inertiajs/inertia-vue3'
import { useBreadStore } from '@bread/js/store'

const store = useBreadStore()

const props = defineProps({
  danger: {
    type: Boolean,
    default: false,
  },
  save: {
    type: Boolean,
    default: false,
  },
  label: {
    type: String,
    required: true,
  },
  link: {
    type: [String, Boolean],
    default: false,
  },
})

const getTypeClasses = () => {
  if (props.save) {
    return 'bg-green-600 hover:bg-green-700'
  } else if (props.danger) {
    return 'bg-red-600 hover:bg-red-700'
  } else {
    return 'bg-blue-600 hover:bg-blue-700'
  }
}
</script>
<template>
  <Link
      v-if="props.link"
      :href="props.link"
      type="button"
      class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
  >
    {{ store.translate(props.label, { ucfirst: true }) }}
  </Link>
  <div
      v-else
      :class="getTypeClasses()"
      class="cursor-pointer rounded-md px-4 py-2 text-sm font-medium text-white shadow-sm"
  >
    {{ props.label }}
  </div>
</template>
