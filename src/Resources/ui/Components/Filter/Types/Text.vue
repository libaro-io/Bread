<script setup>
import Label from '../Support/Label'
import { onMounted, ref, watch } from 'vue'
import { useBreadStore } from '@bread/js/store'

const props = defineProps({
  filter: {
    type: Object,
    required: true,
  },
})

const store = useBreadStore()
const value = ref(null)

onMounted(() => {
  value.value = props.filter.value
})

watch(value, (newValue, oldValue) => {
  if (newValue !== oldValue) {
    store.setFilterValue(props.filter.uuid, newValue)
  }
})
</script>

<template>
  <Label>{{ props.filter.label }}</Label>
  <input
    type="text"
    v-model="value"
    class="w-96 rounded-sm border-gray-200 text-sm"
  />
</template>
