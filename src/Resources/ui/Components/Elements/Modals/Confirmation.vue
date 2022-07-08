<script setup>
import {
  Dialog,
  DialogOverlay,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { useBreadStore } from '@bread/js/store'
import Bread from '@bread/js/Services/Bread'

const store = useBreadStore()

const props = defineProps({
  message: {
    type: String,
  },
})
</script>

<template>
  <TransitionRoot as="template" :show="true">
    <Dialog
      as="div"
      class="fixed inset-0 z-10 overflow-y-auto"
      @close="$emit('onDelete', false)"
    >
      <div
        class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0"
      >
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="ease-in duration-200"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <DialogOverlay
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
          />
        </TransitionChild>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span
          class="hidden sm:inline-block sm:h-screen sm:align-middle"
          aria-hidden="true"
        >&#8203;</span
        >
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          enter-to="opacity-100 translate-y-0 sm:scale-100"
          leave="ease-in duration-200"
          leave-from="opacity-100 translate-y-0 sm:scale-100"
          leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
          <div
            class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6 sm:align-middle"
          >
            <div>
              <div class="mt-3 text-center sm:mt-5">
                <DialogTitle
                  as="h3"
                  class="text-lg font-medium leading-6 text-gray-900"
                >
                  {{ store.translate('delete-this', { ucfirst: true }) }}
                </DialogTitle>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">
                    {{ store.translate(message) }}
                  </p>
                </div>
              </div>
            </div>
            <div class="mt-5 flex space-x-8">
              <button
                type="button"
                :class="Bread.style('buttons.light')"
                @click="$emit('onDelete', false)"
                ref="cancelButtonRef"
              >
                {{ store.translate('cancel', { ucfirst: true }) }}
              </button>
              <button
                type="button"
                :class="Bread.style('buttons.danger')"
                @click="$emit('onDelete', true)"
              >
                {{ store.translate('delete', { ucfirst: true }) }}
              </button>
            </div>
          </div>
        </TransitionChild>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
