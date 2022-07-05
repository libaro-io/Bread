<script setup>
import { DocumentDownloadIcon } from '@heroicons/vue/outline'

const props = defineProps({
  value: {
    type: String,
    required: true,
  },
})
</script>

<template>
  <a :href="props.value" download>
    <DocumentDownloadIcon class="h-4 w-4" />
  </a>
</template>
