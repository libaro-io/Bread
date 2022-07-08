<script setup>
import { Link } from '@inertiajs/inertia-vue3'
import { useBreadStore } from '@bread/js/store'
import Bread from '@bread/js/Services/Bread'

const store = useBreadStore()

const props = defineProps({
  light: {
    type: Boolean,
    default: false,
  },
  dark: {
    type: Boolean,
    default: false,
  },
  danger: {
    type: Boolean,
    default: false,
  },
  save: {
    type: Boolean,
    default: false,
  },
  new: {
    type: Boolean,
    default: false,
  },
  info: {
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
  if (props.light) {
    return Bread.style('buttons.light')
  } else if (props.dark) {
    return Bread.style('buttons.dark')
  }
  if (props.save) {
    return Bread.style('buttons.success')
  } else if (props.danger) {
    return Bread.style('colors.danger')
  } else if (props.new) {
    return Bread.style('buttons.new')
  } else {
    return Bread.style('colors.info')
  }
}
</script>
<template>
  <Link
    v-if="props.link"
    :href="props.link"
    type="button"
    :class="getTypeClasses()"
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
