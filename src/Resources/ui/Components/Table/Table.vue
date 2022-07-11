<script setup>
import {getPropByString} from './../../../js/Services/Helpers'
import {Link} from '@inertiajs/inertia-vue3'
import {computed, onBeforeUpdate, onMounted, reactive, ref} from 'vue'
import Confirmation from './../Elements/Modals/Confirmation'
import {Inertia} from '@inertiajs/inertia'
import Number from './Fields/Number.vue'
import Money from './Fields/Money.vue'
import Checkbox from './Fields/Checkbox.vue'
import Label from './Fields/Label.vue'
import Download from './Fields/Download'
import {ArrowSmUpIcon} from '@heroicons/vue/solid'
import Trend from './Fields/Trend.vue'
import Rating from './Fields/Rating.vue'
import {useBreadStore} from '@bread/js/store'
import Bread from '@bread/js/Services/Bread'

const {DateTime} = require('luxon')

const form = reactive({
  id: null,
})

const isModalVisible = ref(false)
const toDelete = ref(null)
const version = ref(0)
const store = useBreadStore()

onBeforeUpdate(() => {
  version.value++
})

const props = defineProps({
  headers: {
    type: Object,
    required: true,
  },
  items: {},
  routes: {
    type: Object,
    required: true,
  },
  deleteMessage: {
    type: String,
    default: 'delete-confirm',
  },
})

const currentSort = computed(() => {
  return route().params.sort
})
const moment = (date, format) => {
  return DateTime.fromISO(date).toLocaleString(format)
}

const deleteItem = (boolean) => {
  isModalVisible.value = false

  if (boolean === true) {
    form['_method'] = 'delete'
    Inertia.post(route(props.routes.destroy.name, {id: toDelete.value}), form)
  }

  toDelete.value = null
}

const openModal = (item) => {
  isModalVisible.value = true
  toDelete.value = item.id
}

const sortBy = (column) => {
  let _params = route().params

  if (_params.sort && _params.sort.column === column) {
    _params.sort.direction = _params.sort.direction === 'asc' ? 'desc' : 'asc'
  } else {
    _params.sort = {column, direction: 'asc'}
  }
  Inertia.get(route(route().current()), _params)
}

const getFormattedDate = (value, format) => {
  if (!value) {
    return ''
  }

  return moment(value, format)
}
</script>
<template>
  <Confirmation
    v-if="isModalVisible"
    @onDelete="deleteItem"
    :message="deleteMessage"
  ></Confirmation>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
        <div
          class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg"
        >
          <table :key="version" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
              <th
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                v-for="header in props.headers.data"
                :key="header.name"
              >
                <div
                  class="flex"
                  @click="header.sortable ? sortBy(header.value) : ''"
                  :class="{ 'cursor-pointer': header.sortable }"
                >
                    <span
                      :class="{
                        'font-extrabold': currentSort?.column === header.value,
                      }"
                    >
                      {{ header.label }}
                    </span>
                  <ArrowSmUpIcon
                    v-if="header.sortable"
                    class="ml-4 h-4 w-4 transform transition-all duration-200 hover:scale-125"
                    :class="{
                        'rotate-180 transform':
                          currentSort?.column &&
                          currentSort?.direction === 'desc',
                      }"
                  />
                </div>
              </th>
              <th scope="col" class="relative px-6 py-3" v-if="routes.edit">
                <span class="sr-only">{{ store.translate('edit') }}</span>
              </th>
            </tr>
            </thead>
            <tbody>
            <tr
              v-for="(item, i) in props.items"
              :key="item.id"
              :class="i % 2 === 0 ? 'bg-white' : 'bg-gray-50'"
            >
              <slot name="row">
                <td
                  class="whitespace-nowrap px-6 py-4 text-sm font-medium"
                  v-for="(header, _i) in props.headers.data"
                  :key="`${item.id}_${header.name}`"
                  :class="{ 'text-gray-900': _i === 0 }"
                >
                  <template v-if="header.type === 'property'">
                      <span>
                        {{ getPropByString(items[i], header.value) }}
                      </span>
                  </template>
                  <span v-else-if="header.type === 'number'">
                      <Number
                        :editable="header.editable"
                        :id="getPropByString(items[i], 'id')"
                        :number="getPropByString(items[i], header.value)"
                        :update_route="props.routes.update"
                        :attribute_name="header.value"
                      />
                  </span>
                  <span v-else-if="header.type === 'money'">
                      <Money
                        :editable="header.editable"
                        :id="getPropByString(items[i], 'id')"
                        :number="getPropByString(items[i], header.value)"
                        :update_route="props.routes.update"
                        :attribute_name="header.value"
                        :options="header.options"
                      />
                  </span>
                  <span v-else-if="header.type === 'boolean'">
                      <Checkbox
                        :editable="header.editable"
                        :id="getPropByString(items[i], 'id')"
                        :checked="getPropByString(items[i], header.value)"
                        :update_route="props.routes.update"
                        :attribute_name="header.value"
                      />
                    </span>
                  <span v-else-if="header.type === 'label'">
                      <Label
                        :value="getPropByString(items[i], header.value)"
                        :options="header.options"
                      />
                    </span>
                  <span v-else-if="header.type === 'rating'">
                      <Rating :header="header" :item="items[i]"/>
                    </span>
                  <span v-else-if="header.type === 'trend'">
                      <Trend :trend="getPropByString(items[i], header.value)"/>
                    </span>
                  <span v-else-if="header.type === 'download'">
                      <Download
                        v-if="getPropByString(items[i], header.value)"
                        :value="getPropByString(items[i], header.value)"
                      />
                    </span>
                  <span v-else-if="header.type === 'link'">
                      <a
                        :href="getPropByString(items[i], header.value)"
                        v-bind:target="header.options._target"
                      >
                        {{ header.label }}
                      </a>
                    </span>
                  <span v-else-if="header.type === 'inertia_link'">
                      <Link :href="getPropByString(items[i], header.value)">{{
                          header.options.name ??
                          getPropByString(items[i], header.options.prop_name)
                        }}</Link>
                    </span>
                  <span v-else-if="header.type === 'array'">
                      <span v-for="(fields, key) in header.value">
                        <span v-for="(entity, entityKey) in items[i][key]">
                          <span v-for="field in fields">
                            {{ entity[field] }}
                          </span>
                          <span
                            v-if="entityKey < items[i][key].length - 1"
                            v-html="header.options.separator"
                          >
                          </span>
                        </span>
                      </span>
                    </span>
                  <span v-else-if="header.type === 'date'">
                      <span
                        v-text="
                          getFormattedDate(
                            item[header.value],
                            header.options.format
                          )
                        "
                      ></span>
                    </span>
                </td>
                <td
                  v-if="routes.edit"
                  class="space-x-2 whitespace-nowrap px-2 py-4 text-right text-sm font-medium"
                >
                  <Link
                    :href="
                        route(routes.edit.name, [
                          items[i][routes.edit.identifier],
                        ])
                      "
                    :class="Bread.style('text.dark')"
                  >
                    {{ store.translate('edit') }}
                  </Link>
                  <span v-if="routes.destroy" class="inline-block">
                      <button
                        v-on:click="openModal(item)"
                        :class="Bread.style('text.danger')"
                      >
                        {{ store.translate('delete') }}
                      </button>
                    </span>
                </td>
              </slot>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
