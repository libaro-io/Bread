<script setup>
const props = defineProps({
  errors: {
    type: Object,
    required: true,
  },
})

const upperFirst = (str) => {
  return str.charAt(0).toUpperCase() + str.slice(1)
}
</script>
<template>
  <ul
      v-if="Object.entries(props.errors).length > 0"
      class="mb-4 rounded-sm border border-red-200 bg-red-50 py-2 px-4 text-sm text-red-700"
  >
    <li v-for="error in props.errors" class="py-1">{{ upperFirst(error) }}</li>
  </ul>
</template>
