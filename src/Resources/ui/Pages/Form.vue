<script setup>
import { computed, defineAsyncComponent, onMounted, reactive, ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { useBreadStore } from '@bread/js/store'
import Confirmation from './../Components/Elements/Modals/Confirmation'
import SectionHeading from './../Components/Elements/Section/Heading'
import Button from '@bread/ui/Components/Elements/Buttons/Button'
import Errors from '@bread/ui/Components/Form/Errors'

const store = useBreadStore()

const props = defineProps({
  routes: {
    type: Object,
    required: true,
  },
  entity: {
    type: Object,
    required: true,
  },
  resource: {
    type: String,
    required: true,
  },
  errors: {
    type: Object,
    required: false,
  },
  classes: {
    type: Array,
    default: [],
  },
  fields: {
    type: Object,
    required: true,
  },
  title: {
    type: String,
    required: true,
  },
  lang: {
    type: String,
    default: 'en',
  },
  components: {
    type: Object,
    required: false,
    default: {},
  },
})

const isModalVisible = ref(false)

const isNew = computed(() => {
  return !props.entity.id
})

onMounted(() => {
  store.setLang(props.lang)
  store.setResource(props.resource)
})

let form = reactive({ ...props.entity })

const getField = function (component) {
  return defineAsyncComponent(() =>
      import(`./../Components/Form/Fields/${component}.vue`)
  )
}

const loadComponent = (component) => {
  return defineAsyncComponent(() => import(`./../Components/${component}`))
}

const submitForm = () => {
  if (isNew.value) {
    Inertia.post(route(props.routes.store.name), form)
  } else {
    Inertia.post(
        route(props.routes.update.name, {
          [props.resource]: props.entity.id,
        }),
        {
          _method: 'put',
          ...form,
        }
    )
  }
}

const deleteItem = (response) => {
  isModalVisible.value = false
  if (response) {
    Inertia.delete(
        route(props.routes.destroy.name, {
          [props.resource]: props.entity.id,
        })
    )
  }
}

const updateTabModelValue = (data) => {
  form[data.name] = data.value
}
</script>

<template>
  <div
      :key="store.getKey"
      class="rounded-md rounded-t-md border border-gray-100 bg-gray-50 shadow-md"
  >
    <div class="border-b border-gray-200">
      <SectionHeading :label="props.title">
        <template v-slot:actions>
          <slot name="actions">
            <component
                v-for="component in props.components['header']"
                v-bind:is="loadComponent(component.component)"
                :data="component.data"
                :entity="props.entity"
            />
            <div class="mt-3 flex space-x-4 sm:mt-0 sm:ml-4">
              <Button
                  type="submit"
                  @click="submitForm()"
                  save
                  :label="store.translate('save', { ucfirst: true })"
              />
              <Button
                  v-if="!isNew"
                  @click="isModalVisible = true"
                  danger
                  :label="store.translate('delete', { ucfirst: true })"
              />
            </div>
          </slot>
        </template>
      </SectionHeading>
    </div>
    <div class="rounded-b-md bg-white p-4">
      <Errors :errors="props.errors" />
      <form @submit.prevent :class="props.classes?.join(' ')">
        <component
            v-bind:is="getField(field.component)"
            v-for="field in props.fields.data"
            :field="field"
            :entity="props.entity"
            :form="form"
            v-model="form[field.name]"
            @update:tabModelValue="updateTabModelValue"
        >
        </component>
      </form>
      <component
          v-for="component in props.components['belowForm']"
          v-bind:is="loadComponent(component.component)"
          :data="component.data"
          :entity="props.entity"
      />
    </div>
  </div>
  <Confirmation
      v-if="isModalVisible"
      @onDelete="deleteItem"
      :message="store.translate('delete-confirm', { ucfirst: true })"
  ></Confirmation>
</template>
