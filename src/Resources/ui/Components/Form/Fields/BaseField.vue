<script setup>
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
  labelPosition: {
    type: String,
    default: 'before',
  },
})
</script>

<template>
  <div :class="field.classes.wrapper">
    <label v-if="props.labelPosition === 'before'">
      <slot name="label">
        {{ field.label }}
      </slot>
    </label>
    <slot></slot>
    <label v-if="props.labelPosition === 'after'" class="ml-4">
      <slot name="label">
        {{ field.label }}
      </slot>
    </label>
  </div>
</template>
