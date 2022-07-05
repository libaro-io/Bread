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
      class="my-8 flex items-center justify-between"
    >
      <div class="flex items-center space-x-6">
        <Fields />
      </div>
      <Button
          class="self-end"
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
