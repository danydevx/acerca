<template>
  <div class="service-filter" :class="[`service-filter--${variant}`]">
    <div class="service-filter__header" v-if="title || filters.length">
      <h3 class="service-filter__title" v-if="title">{{ title }}</h3>

      <div class="service-filter__active" v-if="activeFilters.length && showActive">
        <span class="service-filter__active-label">Filtros activos:</span>
        <button
          v-for="filter in activeFilters"
          :key="filter.id"
          class="service-filter__active-tag"
          type="button"
          @click="removeFilter(filter)"
        >
          {{ filter.label }}
          <i class="bi bi-x"></i>
        </button>
        <button
          v-if="activeFilters.length > 1"
          class="service-filter__clear"
          type="button"
          @click="clearAll"
        >
          Limpiar todo
        </button>
      </div>
    </div>

    <div class="service-filter__groups">
      <div
        v-for="group in filters"
        :key="group.id"
        class="service-filter__group"
        :class="{ 'is-expanded': expandedGroups.includes(group.id) }"
      >
        <button
          class="service-filter__group-header"
          type="button"
          @click="toggleGroup(group.id)"
        >
          <span class="service-filter__group-title">{{ group.label }}</span>
          <span v-if="getGroupSelectedCount(group) > 0" class="service-filter__group-count">
            {{ getGroupSelectedCount(group) }}
          </span>
          <i class="service-filter__group-icon bi" :class="expandedGroups.includes(group.id) ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
        </button>

        <div class="service-filter__group-body">
          <div v-if="group.type === 'checkbox'" class="service-filter__options">
            <label
              v-for="option in group.options"
              :key="option.id"
              class="service-filter__option"
              :class="{ 'is-selected': isSelected(group.id, option.id) }"
            >
              <input
                type="checkbox"
                :value="option.id"
                :checked="isSelected(group.id, option.id)"
                @change="toggleOption(group.id, option.id)"
              >
              <span class="service-filter__option-check">
                <i class="bi bi-check"></i>
              </span>
              <span class="service-filter__option-label">{{ option.label }}</span>
              <span v-if="option.count !== undefined" class="service-filter__option-count">
                ({{ option.count }})
              </span>
            </label>
          </div>

          <div v-else-if="group.type === 'radio'" class="service-filter__options">
            <label
              v-for="option in group.options"
              :key="option.id"
              class="service-filter__option"
              :class="{ 'is-selected': isSelected(group.id, option.id) }"
            >
              <input
                type="radio"
                :name="group.id"
                :value="option.id"
                :checked="isSelected(group.id, option.id)"
                @change="toggleOption(group.id, option.id)"
              >
              <span class="service-filter__option-check">
                <i class="bi bi-check"></i>
              </span>
              <span class="service-filter__option-label">{{ option.label }}</span>
              <span v-if="option.count !== undefined" class="service-filter__option-count">
                ({{ option.count }})
              </span>
            </label>
          </div>

          <div v-else-if="group.type === 'range'" class="service-filter__range">
            <input
              type="range"
              :min="group.min || 0"
              :max="group.max || 100"
              :step="group.step || 1"
              :value="getRangeValue(group.id)"
              @input="updateRange(group.id, $event.target.value)"
            >
            <div class="service-filter__range-values">
              <span>{{ group.prefix || '' }}{{ getRangeValue(group.id).min }}{{ group.suffix || '' }}</span>
              <span>{{ group.prefix || '' }}{{ getRangeValue(group.id).max }}{{ group.suffix || '' }}</span>
            </div>
          </div>

          <div v-else-if="group.type === 'chips'" class="service-filter__chips">
            <button
              v-for="option in group.options"
              :key="option.id"
              class="service-filter__chip"
              :class="{ 'is-selected': isSelected(group.id, option.id) }"
              type="button"
              @click="toggleOption(group.id, option.id)"
            >
              {{ option.label }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="service-filter__footer" v-if="showFooter">
      <button
        v-if="showApply"
        class="service-filter__btn service-filter__btn--apply"
        type="button"
        @click="apply"
      >
        Aplicar Filtros
      </button>
      <button
        v-if="showClear"
        class="service-filter__btn service-filter__btn--clear"
        type="button"
        @click="clearAll"
      >
        Limpiar
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  title: String,
  filters: {
    type: Array,
    default: () => [],
  },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'inline', 'sidebar'].includes(v),
  },
  showActive: {
    type: Boolean,
    default: true,
  },
  showFooter: {
    type: Boolean,
    default: true,
  },
  showApply: {
    type: Boolean,
    default: false,
  },
  showClear: {
    type: Boolean,
    default: true,
  },
  modelValue: {
    type: Object,
    default: () => ({}),
  },
})

const emit = defineEmits(['update:modelValue', 'change', 'apply'])

const selected = ref({ ...props.modelValue })
const expandedGroups = ref(props.filters.map(f => f.id))
const rangeValues = ref({})

const activeFilters = computed(() => {
  const result = []
  for (const [groupId, optionIds] of Object.entries(selected.value)) {
    if (!optionIds || (Array.isArray(optionIds) && optionIds.length === 0)) continue
    const group = props.filters.find(g => g.id === groupId)
    if (!group) continue

    if (group.type === 'range') {
      result.push({
        id: groupId,
        label: `${group.label}: ${rangeValues.value[groupId]?.min || group.min}-${rangeValues.value[groupId]?.max || group.max}`,
      })
    } else {
      const ids = Array.isArray(optionIds) ? optionIds : [optionIds]
      for (const optId of ids) {
        const option = group.options.find(o => o.id === optId)
        if (option) {
          result.push({
            id: `${groupId}-${optId}`,
            label: option.label,
            groupId,
            optionId: optId,
          })
        }
      }
    }
  }
  return result
})

const toggleGroup = (groupId) => {
  const idx = expandedGroups.value.indexOf(groupId)
  if (idx > -1) {
    expandedGroups.value.splice(idx, 1)
  } else {
    expandedGroups.value.push(groupId)
  }
}

const isSelected = (groupId, optionId) => {
  const val = selected.value[groupId]
  if (Array.isArray(val)) return val.includes(optionId)
  return val === optionId
}

const toggleOption = (groupId, optionId) => {
  const group = props.filters.find(g => g.id === groupId)
  if (!group) return

  if (group.type === 'radio') {
    selected.value[groupId] = optionId
  } else {
    if (!selected.value[groupId]) {
      selected.value[groupId] = []
    }
    const idx = selected.value[groupId].indexOf(optionId)
    if (idx > -1) {
      selected.value[groupId].splice(idx, 1)
    } else {
      selected.value[groupId].push(optionId)
    }
  }

  emit('update:modelValue', selected.value)
  emit('change', selected.value)
}

const getGroupSelectedCount = (group) => {
  const val = selected.value[group.id]
  if (!val) return 0
  if (Array.isArray(val)) return val.length
  return 1
}

const getRangeValue = (groupId) => {
  if (!rangeValues.value[groupId]) {
    const group = props.filters.find(g => g.id === groupId)
    rangeValues.value[groupId] = { min: group?.min || 0, max: group?.max || 100 }
  }
  return rangeValues.value[groupId]
}

const updateRange = (groupId, value) => {
  rangeValues.value[groupId] = { min: 0, max: parseInt(value) }
  emit('update:modelValue', selected.value)
  emit('change', selected.value)
}

const removeFilter = (filter) => {
  if (filter.groupId && filter.optionId) {
    const idx = selected.value[filter.groupId].indexOf(filter.optionId)
    if (idx > -1) {
      selected.value[filter.groupId].splice(idx, 1)
    }
  }
  emit('update:modelValue', selected.value)
  emit('change', selected.value)
}

const clearAll = () => {
  selected.value = {}
  rangeValues.value = {}
  emit('update:modelValue', {})
  emit('change', {})
}

const apply = () => {
  emit('apply', selected.value)
}
</script>

<style lang="scss" scoped>
.service-filter {
  &__header {
    margin-bottom: 1.25rem;
  }

  &__title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--bulma-text);
    margin: 0 0 0.75rem;
  }

  &__active {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.5rem;
  }

  &__active-label {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &__active-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    border: none;
    border-radius: var(--bulma-radius-small);
    font-size: 0.6875rem;
    font-weight: 600;
    cursor: pointer;

    i {
      font-size: 0.75rem;
    }
  }

  &__clear {
    padding: 0.25rem 0.5rem;
    background: transparent;
    color: var(--bulma-danger);
    border: none;
    font-size: 0.6875rem;
    font-weight: 600;
    cursor: pointer;
  }

  &__groups {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  &__group {
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius);
    overflow: hidden;
  }

  &__group-header {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: var(--bulma-scheme-main-bis);
    border: none;
    cursor: pointer;
    text-align: left;
  }

  &__group-title {
    flex: 1;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--bulma-text);
  }

  &__group-count {
    padding: 0.125rem 0.375rem;
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    font-size: 0.625rem;
    font-weight: 700;
    border-radius: 10px;
  }

  &__group-icon {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &__group-body {
    display: none;
    padding: 1rem;
  }

  &__group.is-expanded &__group-body {
    display: block;
  }

  &__options {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
  }

  &__option {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem;
    border-radius: var(--bulma-radius-small);
    cursor: pointer;
    transition: background 0.15s;

    &:hover {
      background: var(--bulma-scheme-main-bis);
    }

    input {
      display: none;
    }
  }

  &__option-check {
    width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--bulma-border);
    border-radius: 3px;
    font-size: 0.75rem;
    color: transparent;
    transition: all 0.15s;
  }

  &__option.is-selected &__option-check {
    background: var(--bulma-link);
    border-color: var(--bulma-link);
    color: white;
  }

  &__option-label {
    flex: 1;
    font-size: 0.8125rem;
    color: var(--bulma-text);
  }

  &__option-count {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &__range {
    padding: 0.5rem 0;
  }

  &__range-values {
    display: flex;
    justify-content: space-between;
    margin-top: 0.5rem;
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
  }

  &__chips {
    display: flex;
    flex-wrap: wrap;
    gap: 0.375rem;
  }

  &__chip {
    padding: 0.375rem 0.75rem;
    border: 1px solid var(--bulma-border);
    border-radius: 20px;
    background: transparent;
    color: var(--bulma-text);
    font-size: 0.8125rem;
    cursor: pointer;
    transition: all 0.15s;

    &:hover {
      border-color: var(--bulma-link);
      color: var(--bulma-link);
    }

    &.is-selected {
      background: var(--bulma-link);
      border-color: var(--bulma-link);
      color: var(--bulma-link-invert);
    }
  }

  &__footer {
    display: flex;
    gap: 0.75rem;
    margin-top: 1.25rem;
    padding-top: 1.25rem;
    border-top: 1px solid var(--bulma-border);
  }

  &__btn {
    flex: 1;
    padding: 0.625rem 1rem;
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius);
    background: transparent;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;

    &--apply {
      background: var(--bulma-link);
      border-color: var(--bulma-link);
      color: var(--bulma-link-invert);

      &:hover {
        background: var(--bulma-link-hover);
      }
    }

    &--clear {
      color: var(--bulma-text);

      &:hover {
        background: var(--bulma-scheme-main-bis);
      }
    }
  }

  &--inline {
    .service-filter__groups {
      flex-direction: row;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .service-filter__group {
      border: none;
      background: var(--bulma-scheme-main-bis);
      border-radius: var(--bulma-radius);
      padding: 0.75rem 1rem;
    }

    .service-filter__group-header {
      padding: 0;
      background: transparent;
    }

    .service-filter__group-body {
      display: block;
      padding: 0.75rem 0 0;
    }
  }

  &--sidebar {
    .service-filter__groups {
      gap: 0;
    }

    .service-filter__group {
      border: none;
      border-bottom: 1px solid var(--bulma-border);
      border-radius: 0;
    }

    .service-filter__group-header {
      background: transparent;
    }

    .service-filter__group.is-expanded &__group-body {
      padding: 0.75rem 0;
    }
  }
}
</style>
