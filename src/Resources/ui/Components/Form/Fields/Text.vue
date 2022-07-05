<script>
import { defineComponent } from 'vue'
import BaseField from './BaseField'

export default defineComponent({
  name: 'Text',
  extends: BaseField,
  components: {
    BaseField,
  },
})
</script>

<template>
  <BaseField :field="field" :entity="entity">
    <input
        v-if="field.editable"
        :type="field.type"
        :name="field.name"
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
        class="my-2 block h-10 w-full rounded-md border-gray-300 bg-white p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
    />
    <div
        v-else
        class="block h-10 w-full rounded-md border-gray-300 bg-white p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
    >
      {{ modelValue }}
    </div>
  </BaseField>
</template>
