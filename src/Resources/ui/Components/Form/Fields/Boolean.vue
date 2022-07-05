<script>
import { defineComponent } from 'vue'
import BaseField from './BaseField'

export default defineComponent({
  name: 'Text',
  extends: BaseField,
  components: {
    BaseField,
  },
  methods: {
    toggle: function () {
      const value = this.modelValue === 1 || this.modelValue ? 0 : 1
      this.$emit('update:modelValue', value)
    },
  },
})
</script>

<template>
  <BaseField
    :field="field"
    :entity="entity"
    label-position="after"
    class="flex items-center justify-start"
  >
    <div
      class="switch ml-2"
      @click="toggle"
      v-if="field.attributes.type === 'switch'"
    >
      <input type="checkbox" :checked="modelValue" />
      <span
        class="slider round"
        :class="modelValue ? 'bg-green-300' : 'bg-gray-500'"
      ></span>
    </div>
    <div @click="toggle" v-else class="ml-2 flex items-center justify-start">
      <input type="checkbox" :checked="modelValue" />
    </div>
  </BaseField>
</template>

<style scoped>
.switch {
  position: relative;
  display: inline-block;
  width: 34px;
  height: 20px;
}

.switch input {
  display: none;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  transition: 0.4s;
}

.slider:before {
  position: absolute;
  content: '';
  height: 16px;
  width: 16px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  transition: 0.4s;
}

input:checked + .slider {
  /*background-color: green;*/
}

input:focus + .slider {
  /*box-shadow: 0 0 1px green;*/
}

input:checked + .slider:before {
  transform: translateX(14px);
}

.slider.round {
  border-radius: 17px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
