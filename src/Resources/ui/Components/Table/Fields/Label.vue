<script setup>
import { computed } from 'vue'

const props = defineProps({
  value: {
    type: [String, Boolean],
    required: true,
  },
  options: {
    type: Object,
    required: true,
  },
})

const label = computed(() => {
  return props.options.cases.find((c) => c.value === props.value)
})
</script>

<template>
  <div
    v-if="label"
    :class="label.classes"
    class="select-none rounded px-1 py-0.5 text-center text-xs"
  >
    {{ label.title }}
  </div>
</template>
