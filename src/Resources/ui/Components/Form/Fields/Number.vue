<script>
import { defineComponent } from 'vue'
import BaseField from './BaseField'

export default defineComponent({
  name: 'Number',
  extends: BaseField,
  components: {
    BaseField,
  },
  data() {
    return {
      value: null,
    }
  },
  mounted() {
    if (this.modelValue) {
      if (this.field.options.float) {
        let number = Number(this.modelValue).toFixed(2)
        number = number.replace('.', ',')
        this.value = number
      } else {
        this.value = Math.round(Number(this.modelValue))
      }
    } else {
      this.value = this.modelValue
    }
  },
  methods: {
    update(event) {
      let number = event.target.value

      if (!number) {
        number = '0'
      }

      number = number.replace(',', '.')
      this.$emit('update:modelValue', number)
    },
  },
})
</script>

<template>
  <BaseField :field="field" :entity="entity">
    <input
      v-if="field.editable"
      type="text"
      :name="field.name"
      :value="value"
      @change="update"
      class="my-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
    />
    <div
      v-else
      class="block w-full rounded-md border-gray-300 bg-white p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
    >
      {{ value }}
    </div>
  </BaseField>
</template>
