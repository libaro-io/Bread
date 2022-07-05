<script setup>
import Text from './Types/Text'
import Select from './Types/Select'
import Boolean from './Types/Boolean'
import { useBreadStore } from '@bread/js/store'

const store = useBreadStore()
</script>

<template>
  <div
    v-if="store.resource"
    v-for="filter in store.getFilters()"
    :key="filter.uuid"
  >
    <Select v-if="filter.type === 'select'" :filter="filter" />
    <Text v-if="filter.type === 'text'" :filter="filter" />
    <Boolean v-if="filter.type === 'boolean'" :filter="filter" />
  </div>
</template>
