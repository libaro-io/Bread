<script setup>
import Label from '../Support/Label'
import { onMounted, ref, watch } from 'vue'
import { Switch } from '@headlessui/vue'
import { useBreadStore } from '@bread/js/store'

const store = useBreadStore()
const enabled = ref(false)
const props = defineProps({
  filter: {
    type: Object,
    required: true,
  },
})

onMounted(() => {
  enabled.value =
    props.filter.value === '1' ||
    props.filter.value === true ||
    props.filter.value === 1 ||
    props.filter.value === 'true'
})

watch(enabled, (newValue, oldValue) => {
  if (newValue !== oldValue) {
    store.setFilterValue(props.filter.uuid, newValue)
  }
})
</script>

<template>
  <Label>{{ props.filter.label }}</Label>
  <Switch
    v-model="enabled"
    :class="[
      enabled ? 'bg-indigo-600' : 'bg-gray-200',
      'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none',
    ]"
  >
    <span class="sr-only">Use setting</span>
    <span
      aria-hidden="true"
      :class="[
        enabled ? 'translate-x-5' : 'translate-x-0',
        'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
      ]"
    />
  </Switch>
</template>
