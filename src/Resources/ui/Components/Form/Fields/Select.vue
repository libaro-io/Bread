<script>
import { defineComponent } from 'vue'
import BaseField from './BaseField'
import { mapStores } from 'pinia'
import { useBreadStore } from '@bread/js/store'

export default defineComponent({
  name: 'Select',
  extends: BaseField,
  components: {
    BaseField,
  },
  computed: {
    ...mapStores(useBreadStore),
  },
})
</script>

<template>
  <BaseField :field="field" :entity="entity">
    <select
        :name="field.name"
        class="my-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        :id="field.name"
        @change="$emit('update:modelValue', $event.target.value)"
    >
      <option>
        {{ breadStore.translate('select-one', { ucfirst: true }) }}
      </option>
      <option
          :value="value.value"
          v-for="(value, key) in field.options"
          :selected="parseInt(value.value) === parseInt(modelValue)"
      >
        {{ value.label }}
      </option>
    </select>
  </BaseField>
</template>
