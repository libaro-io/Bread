<script setup>
import { onMounted, ref } from 'vue'
import { useBreadStore } from '@bread/js/store'

const emits = defineEmits(['update:modelValue'])

const props = defineProps({
  field: {
    type: Object,
    required: true,
  },
  entity: {
    type: Object,
    required: true,
  },
  modelValue: {},
})

const breadStore = useBreadStore()
const image = ref(null)
const preview = ref(null)

onMounted(() => {
  if (props.modelValue) {
    image.value = props.modelValue

    if (typeof image.value === 'string') {
      preview.value = image.value
    } else {
      preview.value = URL.createObjectURL(image.value)
    }
  }
})

const handleFileUpload = (event) => {
  image.value = event.target.files[0]
  preview.value = URL.createObjectURL(image.value)
  emits('update:modelValue', image)
}

const removeImage = () => {
  image.value = null
}
</script>

<template>
  <div v-if="preview" class="flex justify-between">
    <img :src="preview" alt="" class="max-w-48 max-h-48" />
    <span class="text-sm text-red-400" @click="removeImage()">
      {{ breadStore.translate('delete', { ucfirst: true }) }}
    </span>
  </div>
  <div
      v-else
      class="mt-2 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6"
  >
    <div class="space-y-1 text-center">
      <div>
        <svg
            class="mx-auto h-12 w-12 text-gray-400"
            stroke="currentColor"
            fill="none"
            viewBox="0 0 48 48"
            aria-hidden="true"
        >
          <path
              d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
          />
        </svg>
      </div>

      <div class="flex justify-center text-sm text-gray-600">
        <label
            for="file-upload"
            class="relative cursor-pointer rounded-md border-2 border-blue-600 bg-white p-2 font-medium text-indigo-600 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500"
        >
          <span>
            {{ breadStore.translate('upload-file', { ucfirst: true }) }}
          </span>

          <input
              @change="handleFileUpload"
              id="file-upload"
              name="file-upload"
              type="file"
              accept="image/*"
              class="sr-only"
          />
        </label>
      </div>
      <p class="text-xs text-gray-500">
        PNG, JPG, GIF {{ breadStore.translate('up-to') }} 10MB
      </p>
    </div>
  </div>
</template>
