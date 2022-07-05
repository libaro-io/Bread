<script setup>
import { onMounted, ref, watch } from 'vue'
import Label from '../Support/Label'
import { CheckIcon, SelectorIcon } from '@heroicons/vue/solid'
import {
  Listbox,
  ListboxButton,
  ListboxLabel,
  ListboxOption,
  ListboxOptions,
} from '@headlessui/vue'
import { useBreadStore } from '@bread/js/store'

const props = defineProps({
  filter: {
    type: Object,
    required: true,
  },
})

const store = useBreadStore()
const selected = ref(null)

onMounted(() => {
  if (props.filter.value) {
    selected.value = props.filter.options.values.find(
      (option) => option.value === props.filter.value
    )
  }
})

watch(selected, (newValue, oldValue) => {
  if (newValue !== oldValue) {
    store.setFilterValue(props.filter.uuid, newValue?.value)
  }
})

const removeSelected = () => {
  selected.value = null
}
</script>

<template>
  <Listbox as="div" v-model="selected">
    <Label>{{ props.filter.label }}</Label>

    <div class="relative mt-1">
      <ListboxButton
        class="relative w-96 cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
      >
        <span v-if="!selected">{{
          store.translate('select-option', { ucfirst: true })
        }}</span>
        <span v-else class="block truncate">{{ selected?.label }}</span>
        <span
          class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
        >
          <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
        </span>
      </ListboxButton>

      <transition
        leave-active-class="transition ease-in duration-100"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <ListboxOptions
          class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
        >
          <ListboxOption
            v-if="selected"
            as="template"
            key="remove_selected"
            @click="removeSelected()"
          >
            <li
              class="relative cursor-default select-none bg-indigo-50 py-2 pl-3 pr-9 text-gray-600 transition-all duration-200 hover:bg-indigo-100 hover:text-gray-500"
            >
              <span class="block truncate font-semibold">
                {{ store.translate('remove-selection', { ucfirst: true }) }}
              </span>
            </li>
          </ListboxOption>
          <ListboxOption
            as="template"
            v-for="item in props.filter.options.values"
            :key="item.value"
            :value="item"
            v-slot="{ active, selected }"
          >
            <li
              :class="[
                active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                'relative cursor-default select-none py-2 pl-3 pr-9',
              ]"
            >
              <span
                :class="[
                  selected ? 'font-semibold' : 'font-normal',
                  'block truncate',
                ]"
              >
                {{ item.label }}
              </span>

              <span
                v-if="selected"
                :class="[
                  active ? 'text-white' : 'text-indigo-600',
                  'absolute inset-y-0 right-0 flex items-center pr-4',
                ]"
              >
                <CheckIcon class="h-5 w-5" aria-hidden="true" />
              </span>
            </li>
          </ListboxOption>
        </ListboxOptions>
      </transition>
    </div>
  </Listbox>
</template>
