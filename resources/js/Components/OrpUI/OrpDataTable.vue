<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
    columns: {
        type: Array,
        default: () => []
    },
    rows: {
        type: Array,
        default: () => []
    },
    rowKey: {
        type: String,
        default: 'id'
    },
    loading: {
        type: Boolean,
        default: false
    },
    sortKey: {
        type: String,
        default: ''
    },
    sortDirection: {
        type: String,
        default: 'none'
    },
    selectedKeys: {
        type: Array,
        default: () => []
    },
    selectable: {
        type: Boolean,
        default: false
    },
    expandable: {
        type: Boolean,
        default: false
    },
    stickyHeader: {
        type: Boolean,
        default: false
    },
    stickyColumn: {
        type: Boolean,
        default: false
    },
    variant: {
        type: String,
        default: 'default'
    }
})

const emit = defineEmits(['sort-change', 'selection-change', 'row-expand', 'update:sortKey', 'update:sortDirection'])

const localSelectedKeys = ref([...props.selectedKeys])
const expandedKeys = ref([])

watch(() => props.selectedKeys, (val) => {
    localSelectedKeys.value = [...val]
})

const allSelected = computed(() => {
    if (props.rows.length === 0) return false
    return props.rows.every(row => localSelectedKeys.value.includes(row[props.rowKey]))
})

const someSelected = computed(() => {
    if (allSelected.value) return false
    return props.rows.some(row => localSelectedKeys.value.includes(row[props.rowKey]))
})

const tableClasses = computed(() => {
    const classes = ['orp-table']
    if (props.variant === 'striped') classes.push('orp-table--striped')
    if (props.variant === 'bordered') classes.push('orp-table--bordered')
    if (props.variant === 'hover') classes.push('orp-table--hover')
    if (props.variant === 'compact') classes.push('orp-table--compact')
    if (props.stickyHeader) classes.push('orp-table--sticky-header')
    if (props.stickyColumn) classes.push('orp-table--sticky-column')
    return classes.join(' ')
})

const handleSort = (column) => {
    if (!column.sortable) return

    let newDirection = 'asc'
    if (props.sortKey === column.key && props.sortDirection === 'asc') {
        newDirection = 'desc'
    } else if (props.sortKey === column.key && props.sortDirection === 'desc') {
        newDirection = 'none'
    }

    emit('update:sortKey', column.key)
    emit('update:sortDirection', newDirection)
    emit('sort-change', { key: column.key, direction: newDirection })
}

const getSortIcon = (column) => {
    if (props.sortKey !== column.key) return 'bi-arrow-down-up'
    if (props.sortDirection === 'asc') return 'bi-sort-up'
    if (props.sortDirection === 'desc') return 'bi-sort-down'
    return 'bi-arrow-down-up'
}

const isSelected = (row) => {
    return localSelectedKeys.value.includes(row[props.rowKey])
}

const toggleSelectAll = () => {
    if (allSelected.value) {
        localSelectedKeys.value = []
    } else {
        localSelectedKeys.value = props.rows.map(row => row[props.rowKey])
    }
    emit('selection-change', localSelectedKeys.value)
}

const toggleSelect = (row) => {
    const key = row[props.rowKey]
    const index = localSelectedKeys.value.indexOf(key)
    if (index === -1) {
        localSelectedKeys.value.push(key)
    } else {
        localSelectedKeys.value.splice(index, 1)
    }
    emit('selection-change', localSelectedKeys.value)
}

const toggleExpand = (row) => {
    const key = row[props.rowKey]
    const index = expandedKeys.value.indexOf(key)
    if (index === -1) {
        expandedKeys.value.push(key)
    } else {
        expandedKeys.value.splice(index, 1)
    }
    emit('row-expand', { key, expanded: expandedKeys.value.includes(key) })
}

const isExpanded = (row) => {
    return expandedKeys.value.includes(row[props.rowKey])
}
</script>

<template>
    <div class="orp-data-table">
        <div class="orp-table-wrap">
            <table :class="tableClasses" role="table">
                <thead>
                    <tr>
                        <th v-if="selectable" class="orp-table__cell--checkbox" scope="col">
                            <input
                                type="checkbox"
                                class="orp-checkbox"
                                :checked="allSelected"
                                :indeterminate="someSelected"
                                @change="toggleSelectAll"
                                aria-label="Select all"
                            >
                        </th>
                        <th
                            v-for="column in columns"
                            :key="column.key"
                            :class="{
                                'orp-table__cell--sticky': stickyColumn && column.sticky,
                                'orp-table__cell--actions': column.key === 'actions'
                            }"
                            :style="column.width ? { width: column.width } : {}"
                            scope="col"
                        >
                            <button
                                v-if="column.sortable"
                                class="orp-table__sort"
                                :class="{ 'orp-table__sort--active': sortKey === column.key }"
                                @click="handleSort(column)"
                                :aria-sort="sortKey === column.key ? (sortDirection === 'asc' ? 'ascending' : sortDirection === 'desc' ? 'descending' : 'none') : 'none'"
                            >
                                {{ column.label }}
                                <i :class="['bi', getSortIcon(column), 'orp-table__sort-icon']" aria-hidden="true"></i>
                            </button>
                            <span v-else>{{ column.label }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody v-if="loading">
                    <tr v-for="n in 5" :key="n" class="orp-table__skeleton">
                        <td v-if="selectable" class="orp-table__cell--checkbox">
                            <div class="orp-table__skeleton-cell" style="width: 16px; height: 16px;"></div>
                        </td>
                        <td v-for="column in columns" :key="column.key">
                            <div class="orp-table__skeleton-cell" :style="{ width: column.skeletonWidth || '80%' }"></div>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else-if="rows.length === 0">
                    <tr>
                        <td :colspan="columns.length + (selectable ? 1 : 0)">
                            <slot name="empty">
                                <div class="orp-empty" style="padding: var(--orp-space-8);">
                                    <div class="orp-empty__media">
                                        <i class="bi bi-inbox orp-icon orp-icon--2xl" aria-hidden="true"></i>
                                    </div>
                                    <h3 class="orp-empty__title">No data</h3>
                                    <p class="orp-empty__description">There are no records to display</p>
                                </div>
                            </slot>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <template v-for="row in rows" :key="row[rowKey]">
                        <tr :class="{ 'orp-table__row--selected': isSelected(row) }">
                            <td v-if="selectable" class="orp-table__cell--checkbox">
                                <input
                                    type="checkbox"
                                    class="orp-checkbox"
                                    :checked="isSelected(row)"
                                    @change="toggleSelect(row)"
                                    :aria-label="`Select row ${row[rowKey]}`"
                                >
                            </td>
                            <td
                                v-for="column in columns"
                                :key="column.key"
                                :class="{
                                    'orp-table__cell--sticky': stickyColumn && column.sticky,
                                    'orp-table__cell--actions': column.key === 'actions',
                                    'orp-table__cell--numeric': column.align === 'end'
                                }"
                            >
                                <slot :name="`cell-${column.key}`" :row="row" :value="row[column.key]">
                                    {{ row[column.key] }}
                                </slot>
                            </td>
                        </tr>
                        <tr v-if="expandable && isExpanded(row)" class="orp-table__expanded-row">
                            <td :colspan="columns.length + (selectable ? 1 : 0)">
                                <div class="orp-table__expanded-content">
                                    <slot name="expanded" :row="row"></slot>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
.orp-data-table {
    background: var(--orp-surface);
    border: 1px solid var(--orp-border);
    border-radius: var(--orp-radius-lg);
    overflow: hidden;
}

.orp-table-wrap {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.orp-table__sort {
    display: inline-flex;
    align-items: center;
    gap: var(--orp-space-1);
    padding: 0;
    background: transparent;
    border: none;
    font: inherit;
    color: inherit;
    cursor: pointer;
    transition: color var(--orp-duration-fast);
}

.orp-table__sort:hover {
    color: var(--orp-surface-foreground);
}

.orp-table__sort:focus-visible {
    outline: 2px solid var(--orp-ring);
    outline-offset: 2px;
    border-radius: var(--orp-radius-sm);
}

.orp-table__sort-icon {
    opacity: 0.4;
    transition: opacity var(--orp-duration-fast);
}

.orp-table__sort--active .orp-table__sort-icon {
    opacity: 1;
}

.orp-table__row--selected {
    background: color-mix(in srgb, var(--orp-primary) 8%, transparent);
}

.orp-table__row--selected:hover {
    background: color-mix(in srgb, var(--orp-primary) 12%, transparent);
}

.orp-table__expanded-row td {
    padding: var(--orp-space-4);
    background: var(--orp-surface-muted);
    border-bottom: 1px solid var(--orp-border);
}

.orp-table__expanded-content {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-surface-foreground);
}

.orp-table__skeleton td {
    padding: var(--orp-space-3) var(--orp-space-4);
}

.orp-table__skeleton-cell {
    height: 16px;
    background: var(--orp-surface-muted);
    border-radius: var(--orp-radius-sm);
    animation: skeleton-pulse 1.5s ease-in-out infinite;
}

@keyframes skeleton-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
}

.orp-checkbox {
    width: 16px;
    height: 16px;
    cursor: pointer;
    accent-color: var(--orp-primary);
}
</style>
