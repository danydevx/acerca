<template>
  <div class="filter-bar card border-0 shadow-sm mb-3">
    <div class="card-body">
      <div class="row g-2 align-items-end">
        <div v-if="filters.includes('search')" class="col-12" :class="searchColClass">
          <input
            v-model="localSearch"
            type="search"
            class="form-control"
            :placeholder="searchPlaceholder || 'Buscar...'"
            @search="handleSubmit"
          />
        </div>

        <div
          v-for="filter in selectFilters"
          :key="filter.key"
          :class="filter.colClass || 'col-6 col-md-2'"
        >
          <select v-model="localValues[filter.key]" class="form-select" @change="handleChange(filter.key)">
            <option value="">{{ filter.allLabel || `Todas` }}</option>
            <option v-for="opt in filter.options" :key="opt.value" :value="opt.value">
              {{ opt.label }}
            </option>
          </select>
        </div>

        <div class="col-12" :class="actionsColClass || 'col-md-2 d-flex gap-2'">
          <button class="btn btn-info rounded-pill" type="button" @click="handleSubmit">
            <i class="bi bi-search me-1"></i>Filtrar
          </button>
          <button
            v-if="showClear"
            class="btn btn-secondary rounded-pill"
            type="button"
            @click="handleClear"
          >
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
  filters: {
    type: Array,
    default: () => ['search'],
  },
  searchPlaceholder: {
    type: String,
    default: 'Buscar...',
  },
  selectOptions: {
    type: Object,
    default: () => ({}),
  },
  values: {
    type: Object,
    default: () => ({}),
  },
  showClear: {
    type: Boolean,
    default: true,
  },
  searchColClass: {
    type: String,
    default: 'col-md-4',
  },
  actionsColClass: {
    type: String,
    default: 'col-md-2 d-flex gap-2',
  },
})

const emit = defineEmits(['update', 'change', 'clear'])

const localSearch = ref('')
const localValues = ref({})

watch(() => props.values, (newVals) => {
  localSearch.value = newVals.search || ''
  localValues.value = { ...newVals }
  Object.keys(props.selectOptions).forEach(key => {
    if (!(key in localValues.value)) {
      localValues.value[key] = ''
    }
  })
}, { immediate: true })

const selectFilters = computed(() => {
  return Object.entries(props.selectOptions).map(([key, options]) => ({
    key,
    label: key.charAt(0).toUpperCase() + key.slice(1),
    options: typeof options === 'function' ? options() : options,
    allLabel: `Todas`,
    colClass: 'col-6 col-md-2',
  }))
})

const getValues = () => ({
  search: localSearch.value,
  ...localValues.value,
})

const handleSubmit = () => {
  emit('update', getValues())
}

const handleChange = (key) => {
  emit('change', key, localValues.value[key])
  emit('update', getValues())
}

const handleClear = () => {
  localSearch.value = ''
  Object.keys(localValues.value).forEach(key => {
    localValues.value[key] = ''
  })
  emit('clear')
  emit('update', getValues())
}

defineExpose({ getValues })
</script>
