<script>
import { defineComponent, reactive } from 'vue'
import VueMultiSelect from 'vue-multiselect'
import BaseField from './BaseField'

export default defineComponent({
  name: 'MultiSelect',
  extends: BaseField,
  components: {
    BaseField,
    VueMultiSelect,
  },
  data() {
    return {
      value: reactive(this.modelValue),
    }
  },
  watch: {
    value(newValue) {
      // Fix for 'unproxifying' the value
      this.$emit('update:modelValue', JSON.parse(JSON.stringify(newValue)))
    },
  },
})
</script>

<template>
  <BaseField :field="field" :entity="entity">
    <VueMultiSelect
      :options="field.options"
      v-model="value"
      placeholder="Pick a value"
      label="name"
      track-by="id"
      multiple
      taggable
    ></VueMultiSelect>
  </BaseField>
</template>

<style
  src="../../../../../../node_modules/vue-multiselect/dist/vue-multiselect.css"
></style>
