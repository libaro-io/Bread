<script setup>
import { reactive, ref, defineAsyncComponent } from 'vue'

const emits = defineEmits(['update:tabModelValue'])

const props = defineProps({
  field: {
    type: Object,
  },
  entity: {
    type: Object,
    required: true,
  },
  form: {
    type: Object,
    required: true,
  },
})

const tabs = reactive(
  props.field.tabs.map((tab) => {
    return { ...tab, isActive: tab === props.field.tabs[0] }
  })
)
const active = ref(false)

const displayTab = (title) => {
  tabs.forEach((tab) => {
    tab.title === title ? (tab.isActive = true) : (tab.isActive = false)
  })
}

const getField = function (component) {
  return defineAsyncComponent(() => import(`./${component}.vue`))
}
</script>

<template>
  <div>
    <div class="col-span-6">
      <div class="sm:hidden">
        <label for="tabs" class="sr-only">Select a tab</label>
        <select
          id="tabs"
          name="tabs"
          class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
        >
          <option
            v-for="tab in tabs"
            :key="tab.title"
            :selected="tab.isActive"
            @click="displayTab(tab.title)"
          >
            {{ tab.title }}
          </option>
        </select>
      </div>
      <div class="hidden sm:block">
        <div class="border-b border-gray-200">
          <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <a
              v-for="tab in tabs"
              :key="tab.title"
              :class="[
                tab.isActive
                  ? 'border-indigo-500 text-indigo-600'
                  : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                'cursor-pointer whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium',
              ]"
              :aria-current="tab.isActive ? 'page' : undefined"
              @click="displayTab(tab.title)"
            >
              {{ tab.title }}
            </a>
          </nav>
        </div>
      </div>
    </div>
    <div v-for="tab in tabs" class="col-span-6" :key="tab.title">
      <div v-if="tab.isActive" class="pt-8">
        <component
          v-for="field in tab.fields"
          v-bind:is="getField(field.component)"
          :field="field"
          :entity="props.entity"
          v-model="form[field.name]"
        >
        </component>
      </div>
    </div>
  </div>
</template>
