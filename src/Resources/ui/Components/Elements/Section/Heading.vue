<script setup>
import Button from '@bread/ui/Components/Elements/Buttons/Button'
import {useBreadStore} from '@bread/js/store'

const store = useBreadStore()

const props = defineProps({
  label: {
    type: String,
  },
  link: {
    type: String,
    required: false,
  },
})
</script>

<template>
  <div className="w-full px-4 pt-4 pb-5 sm:flex sm:items-center sm:justify-between">
    <h3 className="text-lg font-medium leading-6 text-gray-900">{{ label }}</h3>
    <div className="flex items-center">
      <slot name="actions">
        <div className="mx-2 mt-3 sm:mt-0 sm:ml-4">
          <Button v-if="link" label="new" :link="route(link)" new/>
        </div>
      </slot>
      <slot name="after-actions"></slot>
    </div>
  </div>
</template>
