<template>
  <div class="ui-table-wrapper">
    <div v-if="$slots.header || searchable" class="ui-table-header">
      <slot name="header"></slot>
      <div v-if="searchable" class="ui-table-search">
        <input
          v-model="searchQuery"
          class="input is-small"
          :placeholder="searchPlaceholder"
          @input="$emit('search', searchQuery)"
        >
      </div>
    </div>

    <div class="table-wrapper">
      <table class="table" :class="tableClasses">
        <thead v-if="$slots.head || sortableColumns.length">
          <tr>
            <th v-if="selectable" class="ui-table-checkbox">
              <input
                type="checkbox"
                :checked="allSelected"
                :indeterminate="someSelected"
                @change="toggleSelectAll"
              >
            </th>
            <slot name="head">
              <th
                v-for="(col, index) in effectiveColumns"
                :key="index"
                :class="{ 'is-sortable': sortable && sortableColumns.includes(col.key), 'is-sorted': sortKey === col.key }"
                @click="sortable && sortableColumns.includes(col.key) && toggleSort(col.key)"
              >
                <span class="ui-table-th-content">
                  {{ col.label }}
                  <span v-if="sortable && sortableColumns.includes(col.key)" class="ui-table-sort-icon">
                    <i v-if="sortKey === col.key" :class="sortOrder === 'asc' ? 'bi bi-caret-up-fill' : 'bi bi-caret-down-fill'"></i>
                    <i v-else class="bi bi-caret-up"></i>
                  </span>
                </span>
              </th>
            </slot>
            <th v-if="$slots['cell-actions']" class="ui-table-actions-head">Actions</th>
          </tr>
        </thead>

        <tbody v-if="!loading">
          <template v-if="paginatedData.length">
            <template v-for="(row, rowIndex) in paginatedData" :key="rowIndex">
              <tr
                :class="{
                  'is-selected': selected && selected.includes(getRowId(row, rowIndex)),
                }"
              >
                <td v-if="selectable" class="ui-table-checkbox">
                  <input
                    type="checkbox"
                    :checked="selected && selected.includes(getRowId(row, rowIndex))"
                    @change="toggleSelect(row, rowIndex)"
                  >
                </td>
                <slot name="row" :row="row" :index="rowIndex">
                  <td v-for="(col, colIndex) in effectiveColumns" :key="colIndex">
                    <slot :name="`cell-${col.key}`" :row="row" :value="row[col.key]" :col="col">
                      {{ row[col.key] }}
                    </slot>
                  </td>
                </slot>
                <td v-if="$slots['cell-actions']" class="ui-table-actions-cell">
                  <slot name="cell-actions" :row="row" :index="rowIndex"></slot>
                </td>
              </tr>
              <tr v-if="$slots.expanded && expandedRows && expandedRows.includes(getRowId(row, rowIndex))" class="is-expanded">
                <td :colspan="effectiveColumns.length + (selectable ? 1 : 0) + ($slots['cell-actions'] ? 1 : 0)">
                  <slot name="expanded" :row="row" :index="rowIndex"></slot>
                </td>
              </tr>
            </template>
          </template>
          <tr v-else>
            <td
              :colspan="effectiveColumns.length + (selectable ? 1 : 0) + ($slots['cell-actions'] ? 1 : 0)"
              class="ui-table-empty"
            >
              <slot name="empty">
                <div class="has-text-centered py-5">
                  <p class="has-text-grey">{{ emptyText }}</p>
                </div>
              </slot>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="loading" class="ui-table-loading">
      <div class="ui-table-loading-overlay">
        <span class="loader"></span>
      </div>
      <table class="table" :class="tableClasses">
        <thead v-if="$slots.head || sortableColumns.length">
          <tr>
            <th v-if="selectable"></th>
            <th v-for="(col, index) in effectiveColumns" :key="index">{{ col.label }}</th>
            <th v-if="$slots['cell-actions']"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="n in 3" :key="n">
            <td v-if="selectable"></td>
            <td v-for="(col, index) in effectiveColumns" :key="index">
              <div class="skeleton-line"></div>
            </td>
            <td v-if="$slots['cell-actions']"></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="pagination && totalPages > 1" class="ui-table-pagination">
      <div class="ui-table-pagination-info">
        {{ paginationInfo }}
      </div>
      <nav class="pagination is-small" role="navigation">
        <a
          class="pagination-previous"
          :class="{ 'is-disabled': currentPage === 1 }"
          @click="currentPage = Math.max(1, currentPage - 1)"
        >Previous</a>
        <a
          class="pagination-next"
          :class="{ 'is-disabled': currentPage === totalPages }"
          @click="currentPage = Math.min(totalPages, currentPage + 1)"
        >Next</a>
        <ul class="pagination-list">
          <li v-for="page in visiblePages" :key="page">
            <a
              v-if="page !== '...'"
              class="pagination-link"
              :class="{ 'is-current': page === currentPage }"
              @click="currentPage = page"
            >{{ page }}</a>
            <span v-else class="pagination-ellipsis">&hellip;</span>
          </li>
        </ul>
      </nav>
      <div v-if="showPerPage" class="ui-table-per-page">
        <span>Per page:</span>
        <select v-model="perPage" class="select is-small">
          <option v-for="opt in perPageOptions" :key="opt" :value="opt">{{ opt }}</option>
        </select>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
  data: { type: Array, default: () => [] },
  columns: { type: Array, default: () => [] },
  striped: { type: Boolean, default: false },
  hoverable: { type: Boolean, default: false },
  narrow: { type: Boolean, default: false },
  bordered: { type: Boolean, default: false },
  selected: { type: Array, default: () => [] },
  expandedRows: { type: Array, default: () => [] },
  selectable: { type: Boolean, default: false },
  sortable: { type: Boolean, default: false },
  sortableColumns: { type: Array, default: () => [] },
  searchable: { type: Boolean, default: false },
  searchPlaceholder: { type: String, default: 'Search...' },
  emptyText: { type: String, default: 'No records found' },
  loading: { type: Boolean, default: false },
  pagination: { type: Boolean, default: false },
  perPageOptions: { type: Array, default: () => [10, 25, 50, 100] },
  defaultPerPage: { type: Number, default: 10 },
  showPerPage: { type: Boolean, default: false },
  idKey: { type: String, default: 'id' },
})

const emit = defineEmits([
  'row-click',
  'sort',
  'search',
  'selection-change',
  'page-change',
  'update:selected',
  'update:currentPage',
])

const searchQuery = ref('')
const sortKey = ref('')
const sortOrder = ref('asc')
const perPage = ref(props.defaultPerPage)
const currentPage = ref(1)

const effectiveColumns = computed(() => {
  if (props.columns.length) return props.columns
  if (props.data.length) {
    const firstRow = props.data[0]
    return Object.keys(firstRow).map(key => ({ key, label: key }))
  }
  return []
})

const sortedData = computed(() => {
  if (!sortKey.value || !props.data.length) return props.data

  return [...props.data].sort((a, b) => {
    const aVal = a[sortKey.value]
    const bVal = b[sortKey.value]

    if (aVal === bVal) return 0
    if (aVal === null || aVal === undefined) return 1
    if (bVal === null || bVal === undefined) return -1

    const comparison = aVal < bVal ? -1 : 1
    return sortOrder.value === 'asc' ? comparison : -comparison
  })
})

const totalPages = computed(() => {
  if (!props.pagination) return 1
  return Math.ceil(props.data.length / perPage.value)
})

const paginatedData = computed(() => {
  if (!props.pagination) return sortedData.value

  const start = (currentPage.value - 1) * perPage.value
  const end = start + perPage.value
  return sortedData.value.slice(start, end)
})

const paginationInfo = computed(() => {
  if (!props.pagination) return ''
  const total = props.data.length
  const start = (currentPage.value - 1) * perPage.value + 1
  const end = Math.min(currentPage.value * perPage.value, total)
  return `Showing ${start}–${end} of ${total}`
})

const visiblePages = computed(() => {
  if (totalPages.value <= 7) {
    return Array.from({ length: totalPages.value }, (_, i) => i + 1)
  }

  const pages = []
  if (currentPage.value <= 4) {
    for (let i = 1; i <= 5; i++) pages.push(i)
    pages.push('...')
    pages.push(totalPages.value)
  } else if (currentPage.value >= totalPages.value - 3) {
    pages.push(1)
    pages.push('...')
    for (let i = totalPages.value - 4; i <= totalPages.value; i++) pages.push(i)
  } else {
    pages.push(1)
    pages.push('...')
    for (let i = currentPage.value - 1; i <= currentPage.value + 1; i++) pages.push(i)
    pages.push('...')
    pages.push(totalPages.value)
  }
  return pages
})

const allSelected = computed(() => {
  if (!props.selected.length || !props.data.length) return false
  return props.data.every((row, i) => props.selected.includes(getRowId(row, i)))
})

const someSelected = computed(() => {
  return props.selected.length > 0 && !allSelected.value
})

const tableClasses = computed(() => ({
  'is-striped': props.striped,
  'is-hoverable': props.hoverable,
  'is-narrow': props.narrow,
  'is-bordered': props.bordered,
  'is-fullwidth': true,
}))

const getRowId = (row, index) => {
  return row[props.idKey] ?? index
}

const toggleSort = (key) => {
  if (sortKey.value === key) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortKey.value = key
    sortOrder.value = 'asc'
  }
  emit('sort', { key: sortKey.value, order: sortOrder.value })
}

const toggleSelectAll = () => {
  const newSelection = allSelected.value
    ? []
    : props.data.map((row, i) => getRowId(row, i))
  emit('update:selected', newSelection)
  emit('selection-change', newSelection)
}

const toggleSelect = (row, index) => {
  const id = getRowId(row, index)
  const newSelection = props.selected.includes(id)
    ? props.selected.filter(i => i !== id)
    : [...props.selected, id]
  emit('update:selected', newSelection)
  emit('selection-change', newSelection)
}

watch(perPage, () => {
  currentPage.value = 1
  emit('page-change', currentPage.value)
})

watch(currentPage, (val) => {
  emit('update:currentPage', val)
})
</script>

<style lang="scss" scoped>
.ui-table-wrapper {
  position: relative;
}

.ui-table-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.75rem 1rem;
  background: var(--bulma-scheme-main-bis);
  border: 1px solid var(--bulma-border);
  border-bottom: none;
  border-radius: var(--bulma-radius-large) var(--bulma-radius-large) 0 0;
  gap: 1rem;
}

.ui-table-search {
  .input {
    min-width: 200px;
  }
}

.table-wrapper {
  overflow-x: auto;
}

.table {
  width: 100%;
  background: var(--bulma-scheme-main);
  color: var(--bulma-text);

  &:not(.is-bordered) {
    border: none;
  }

  &.is-bordered {
    border: 1px solid var(--bulma-border);

    th, td {
      border: 1px solid var(--bulma-border);
    }
  }

  th, td {
    padding: 0.75rem 1rem;
    border: none;
    vertical-align: middle;
  }

  th {
    background: var(--bulma-scheme-main-bis);
    font-weight: 600;
    color: var(--bulma-text);
    white-space: nowrap;

    &.is-sortable {
      cursor: pointer;
      user-select: none;

      &:hover {
        background: var(--bulma-scheme-main-ter);
      }
    }

    &.is-sorted {
      color: var(--bulma-link);
    }
  }

  td {
    border-top: 1px solid var(--bulma-border);
  }

  &.is-narrow {
    th, td {
      padding: 0.5rem 0.75rem;
    }
  }

  tbody tr {
    &.is-selected {
      background: color-mix(in oklch, var(--bulma-primary) 10%, var(--bulma-scheme-main));
    }
  }

  tr.is-expanded td {
    padding: 1rem;
    background: var(--bulma-scheme-main-bis);
  }
}

.ui-table-th-content {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
}

.ui-table-sort-icon {
  font-size: 0.75rem;
  color: var(--bulma-text-weak);
}

.ui-table-checkbox {
  width: 3rem;
  text-align: center;

  input[type="checkbox"] {
    cursor: pointer;
  }
}

.ui-table-actions-head,
.ui-table-actions-cell {
  width: 100px;
  text-align: right;
}

.ui-table-empty {
  text-align: center;
  color: var(--bulma-text-weak);
}

.ui-table-loading {
  position: relative;

  &-overlay {
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
  }
}

.skeleton-line {
  height: 1rem;
  background: linear-gradient(90deg, var(--bulma-border) 25%, var(--bulma-scheme-main-ter) 50%, var(--bulma-border) 75%);
  background-size: 200% 100%;
  animation: skeleton-loading 1.5s infinite;
  border-radius: 4px;
}

@keyframes skeleton-loading {
  0% { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}

.ui-table-pagination {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.75rem 1rem;
  background: var(--bulma-scheme-main-bis);
  border: 1px solid var(--bulma-border);
  border-top: none;
  border-radius: 0 0 var(--bulma-radius-large) var(--bulma-radius-large);
  flex-wrap: wrap;
  gap: 0.75rem;

  &-info {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
  }
}

.ui-table-per-page {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.875rem;
  color: var(--bulma-text-weak);

  .select {
    min-width: 70px;
  }
}

.pagination {
  margin: 0;
}

.loader {
  width: 1.5rem;
  height: 1.5rem;
  border: 2px solid var(--bulma-border);
  border-top-color: var(--bulma-link);
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>
