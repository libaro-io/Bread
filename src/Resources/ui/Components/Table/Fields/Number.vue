<script setup>
import {onMounted, ref} from 'vue'
import {Inertia} from '@inertiajs/inertia'

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
  number: {
    type: [Number, String],
    required: true,
  },
  update_route: {
    type: Object,
    required: false,
  },
})

const number = ref(0)

onMounted(() => {
  let _number = props.number
  _number = Number(_number).toFixed(2)
  number.value = _number.replace('.', ',')
})

const update = (event) => {
  let number = event.target.value

  if (!number) {
    number = '0'
  }

  number = number.replace(',', '.')

  Inertia.put(
      route(props.update_route.name, {product: props.id}),
      {
        id: props.id,
        [props.attribute_name]: number,
      },
      {
        preserveScroll: true,
      }
  )
}
</script>

<template>
  <div v-if="props.editable">
    <input
        className="border-gray-200 py-0.5 px-1 text-sm"
        type="text"
        :value="number"
        @change="update"
    />
  </div>
  <div v-else>
    {{ number }}
  </div>
</template>
