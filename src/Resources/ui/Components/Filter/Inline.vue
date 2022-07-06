<script setup>
import Fields from './Fields.vue'
import { useBreadStore } from '@bread/js/store'
import Button from './../Elements/Buttons/Button'

const emits = defineEmits(['filter'])
const store = useBreadStore()

const filter = () => {
  emits('filter')
}
</script>

<template>
  <Transition>
    <div
      v-show="store.show_filters"
      class="my-8 flex justify-between items-start bg-gray-100 rounded-md p-4"
    >
      <div class="flex space-y-4 flex-col">
        <Fields />
      </div>
      <Button
          @click="filter()"
          :label="store.translate('filter', { ucfirst: true })"
      />
    </div>
  </Transition>
</template>

<style>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>
