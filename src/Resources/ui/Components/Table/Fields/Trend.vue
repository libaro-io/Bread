<script setup>
import {
  TrendingDownIcon,
  TrendingUpIcon,
  MinusIcon,
} from '@heroicons/vue/outline'
const props = defineProps({
  trend: {
    type: Number,
    required: true,
  },
})
</script>

<template>
  <TrendingUpIcon v-if="props.trend > 0" class="h-4 w-4" />
  <MinusIcon v-else-if="props.trend === 0" class="h-4 w-4" />
  <TrendingDownIcon v-else-if="props.trend < 0" class="h-4 w-4" />
</template>
