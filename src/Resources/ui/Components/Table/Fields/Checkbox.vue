<script setup>
import { onMounted, ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
  editable: {
    type: Boolean,
    default: false,
  },
  id: {
    type: Number,
    required: false,
  },
  attribute_name: {
    type: String,
    required: false,
  },
  checked: {
    type: Boolean,
    required: true,
  },
  update_route: {
    type: Object,
    required: false,
  },
})

const checked = ref(null)

onMounted(() => {
  checked.value = props.checked
})

watch(checked, (newValue, oldValue) => {
  if (oldValue === null) {
    return
  }

  Inertia.put(
      route(props.update_route.name, { [Inertia.page.props.resource]: props.id }),
      {
        id: props.id,
        [props.attribute_name]: checked.value,
      },
      {
        preserveScroll: true,
      }
  )
})
</script>

<template>
  <input type="checkbox" v-model="checked" />
</template>
