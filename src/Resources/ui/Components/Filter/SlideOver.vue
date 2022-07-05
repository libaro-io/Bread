<script setup>
import { onMounted, ref, watch } from 'vue'
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { XIcon } from '@heroicons/vue/outline'
import { useBreadStore } from '@bread/js/store'
import Fields from './Fields.vue'
import Button from './../Elements/Buttons/Button'

const store = useBreadStore()
const open = ref(false)
const emits = defineEmits(['filter'])

store.$subscribe((mutation, state) => {
  open.value = state.show_filters
})

const closePanel = () => {
  open.value = false
  store.show_filters = false
}

const filter = () => {
  closePanel()
  emits('filter')
}
</script>
<template>
  <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="relative z-10" @close="closePanel()">
      <div class="fixed inset-0" />

      <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
          <div
            class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10"
          >
            <TransitionChild
              as="template"
              enter="transform transition ease-in-out duration-500 sm:duration-700"
              enter-from="translate-x-full"
              enter-to="translate-x-0"
              leave="transform transition ease-in-out duration-500 sm:duration-700"
              leave-from="translate-x-0"
              leave-to="translate-x-full"
            >
              <DialogPanel class="pointer-events-auto w-screen max-w-md">
                <div
                  class="flex h-full flex-col overflow-y-scroll bg-white py-6 shadow-xl"
                >
                  <div class="px-4 sm:px-6">
                    <div class="flex items-start justify-between">
                      <DialogTitle class="text-lg font-medium text-gray-900">
                        {{ store.translate('filters', { ucfirst: true }) }}
                      </DialogTitle>
                      <div class="ml-3 flex h-7 items-center">
                        <button
                          type="button"
                          class="rounded-md bg-gray-200 text-gray-400 transition-all duration-200 hover:text-gray-500 focus:outline-none"
                          @click="closePanel()"
                        >
                          <span class="sr-only">Close panel</span>
                          <XIcon class="h-6 w-6" aria-hidden="true" />
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="relative mt-6 flex-1 space-y-8 px-4 sm:px-6">
                    <div class="flex justify-end">
                      <Button @click="filter()">Filter</Button>
                    </div>
                    <div class="flex flex-col space-y-8">
                      <Fields />
                    </div>
                  </div>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
