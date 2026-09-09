<template>
  <nav class="panel" :class="[`is-${color}`]">
    <p v-if="title" class="panel-heading">{{ title }}</p>

    <div v-if="searchable" class="panel-block">
      <p class="control has-icons-left has-icons-right">
        <input
          v-model="searchQuery"
          class="input"
          :placeholder="searchPlaceholder"
          @input="$emit('search', searchQuery)"
        >
        <span class="icon is-left">
          <i class="bi bi-search"></i>
        </span>
        <span v-if="searchQuery" class="icon is-right is-clickable" @click="clearSearch">
          <i class="bi bi-x"></i>
        </span>
      </p>
    </div>

    <div v-if="filterOptions.length" class="panel-tabs">
      <a
        v-for="(filter, index) in filterOptions"
        :key="index"
        class="panel-tab"
        :class="{ 'is-active': activeFilter === filter.value }"
        @click="setFilter(filter.value)"
      >
        {{ filter.label }}
      </a>
    </div>

    <div class="panel-list">
      <a
        v-for="(item, index) in filteredItems"
        :key="index"
        class="panel-block"
        :class="{ 'is-active': selectedItems.includes(item[trackBy]) }"
        @click="toggleItem(item)"
      >
        <span v-if="itemIcon" class="panel-icon">
          <i :class="item.icon || itemIcon"></i>
        </span>
        <span class="panel-block-content">
          <span class="panel-item-label">{{ item[labelKey] }}</span>
          <span v-if="item[metaKey]" class="panel-item-meta">{{ item[metaKey] }}</span>
        </span>
        <span v-if="showCheckbox" class="panel-checkbox">
          <i :class="selectedItems.includes(item[trackBy]) ? 'bi bi-check-square' : 'bi bi-square'"></i>
        </span>
      </a>

      <div v-if="!filteredItems.length" class="panel-block has-text-centered">
        <span class="has-text-grey">{{ emptyText }}</span>
      </div>
    </div>

    <div v-if="$slots.footer || showSelectAll" class="panel-block">
      <slot name="footer">
        <div v-if="showSelectAll" class="is-flex is-justify-content-space-between is-align-items-center">
          <a class="is-size-7" @click="toggleAll">
            {{ allSelected ? 'Deselect all' : 'Select all' }}
          </a>
          <span v-if="selectedCount" class="tag is-primary">{{ selectedCount }} selected</span>
        </div>
      </slot>
    </div>
  </nav>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  title: { type: String, default: '' },
  items: { type: Array, default: () => [] },
  labelKey: { type: String, default: 'label' },
  metaKey: { type: String, default: '' },
  trackBy: { type: String, default: 'id' },
  itemIcon: { type: String, default: '' },
  color: {
    type: String,
    default: '',
    validator: (v) => ['', 'primary', 'info', 'success', 'warning', 'danger', 'link'].includes(v),
  },
  searchable: { type: Boolean, default: false },
  searchPlaceholder: { type: String, default: 'Search...' },
  filterOptions: { type: Array, default: () => [] },
  emptyText: { type: String, default: 'No items found' },
  showCheckbox: { type: Boolean, default: false },
  showSelectAll: { type: Boolean, default: false },
  modelValue: { type: Array, default: () => [] },
})

const emit = defineEmits(['update:modelValue', 'search', 'filter', 'item-click'])

const searchQuery = ref('')
const activeFilter = ref('')

const selectedItems = computed({
  get: () => props.modelValue,
  set: (val) => emit('update:modelValue', val),
})

const selectedCount = computed(() => selectedItems.value.length)
const allSelected = computed(() => selectedItems.value.length === props.items.length)

const filteredItems = computed(() => {
  let result = props.items

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    result = result.filter((item) =>
      item[props.labelKey].toString().toLowerCase().includes(query)
    )
  }

  if (activeFilter.value) {
    result = result.filter((item) => item.filter === activeFilter.value)
  }

  return result
})

const clearSearch = () => {
  searchQuery.value = ''
  emit('search', '')
}

const setFilter = (value) => {
  activeFilter.value = value
  emit('filter', value)
}

const toggleItem = (item) => {
  const id = item[props.trackBy]
  const newSelection = selectedItems.value.includes(id)
    ? selectedItems.value.filter((i) => i !== id)
    : [...selectedItems.value, id]
  selectedItems.value = newSelection
  emit('item-click', item)
}

const toggleAll = () => {
  if (allSelected.value) {
    selectedItems.value = []
  } else {
    selectedItems.value = props.items.map((item) => item[props.trackBy])
  }
}
</script>

<style lang="scss" scoped>
.panel {
  border-radius: var(--bulma-radius-large);
  box-shadow: none;
  border: 1px solid var(--bulma-border);

  &-heading {
    background: var(--bulma-scheme-main-bis);
    border-bottom: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius-large) var(--bulma-radius-large) 0 0;
  }

  &-tabs {
    border-bottom: 1px solid var(--bulma-border);
  }

  &-tab {
    color: var(--bulma-text-weak);
    border-bottom: 2px solid transparent;
    margin-bottom: -1px;
    padding: 0.75rem 1rem;
    cursor: pointer;
    transition: all 150ms;

    &:hover {
      color: var(--bulma-text);
    }

    &.is-active {
      color: var(--bulma-link);
      border-bottom-color: var(--bulma-link);
    }
  }

  &-block {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    transition: background 150ms;

    &:hover {
      background: var(--bulma-scheme-main-bis);
    }

    &.is-active {
      background: color-mix(in oklch, var(--bulma-link) 10%, var(--bulma-scheme-main));
      border-left: 3px solid var(--bulma-link);
    }
  }

  &-icon {
    color: var(--bulma-text-weak);
    flex-shrink: 0;
  }

  &-list {
    max-height: 300px;
    overflow-y: auto;
  }

  &-checkbox {
    color: var(--bulma-text-weak);
    flex-shrink: 0;
  }
}

.panel-item-content {
  flex: 1;
  min-width: 0;
}

.panel-item-label {
  display: block;
  color: var(--bulma-text);
}

.panel-item-meta {
  display: block;
  font-size: 0.75rem;
  color: var(--bulma-text-weak);
  margin-top: 0.125rem;
}
</style>
