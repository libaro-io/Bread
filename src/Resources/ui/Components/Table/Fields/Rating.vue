<script setup>
import { computed, onMounted, ref } from 'vue'

const props = defineProps({
  item: {
    type: Object,
    required: true,
  },
  header: {
    type: Object,
    required: true,
  },
})

const numberOfItems = ref(0)

onMounted(() => {
  const { max } = props.header.options.settings

  numberOfItems.value = [...Array(max).keys()]
})

const getTooltip = computed(() => {
  const tooltip = props.header.options?.tooltip

  if (tooltip) {
    return props.item[tooltip]
  }

  return null
})
</script>

<template>
  <div class="flex space-x-2" :title="getTooltip">
    <div v-for="index in numberOfItems" :key="index" class="flex items-center">
      <span
        v-if="props.header.options.settings.type === 'ball'"
        :class="[
          index < props.item[props.header.value]
            ? 'bg-green-400'
            : 'bg-gray-100',
          'inline-block h-4 w-4 rounded-full text-gray-800',
        ]"
      ></span>
    </div>
  </div>
</template>
