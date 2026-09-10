<template>
  <div class="app-datatable">
    <div class="app-datatable__header" v-if="$slots['header-actions'] || searchPlaceholder">
      <div class="app-datatable__search-wrapper" v-if="searchPlaceholder">
        <div class="app-datatable__search">
          <i class="bi bi-search search-icon"></i>
          <input
            type="text"
            v-model="localSearch"
            :placeholder="searchPlaceholder"
            @input="onSearchInput"
          />
        </div>
      </div>
      <div class="app-datatable__controls">
        <slot name="header-actions"></slot>
      </div>
    </div>

    <div class="app-datatable__table-wrapper" ref="tableWrapperElement">
      <table class="app-datatable__table">
        <thead>
          <tr>
            <th v-if="bulkSelect" class="app-datatable__checkbox-column" style="width: 40px;">
              <input
                type="checkbox"
                class="form-check-input"
                :checked="allSelected"
                :indeterminate="someSelected && !allSelected"
                @change="toggleSelectAll"
              />
            </th>
            <th
              v-for="column in columns"
              :key="column.key"
              :class="[
                column.class || '',
                {
                  sortable: column.sortable,
                  'actions-header': column.key === 'actions',
                }
              ]"
              :style="column.width ? { width: column.width } : {}"
            >
              {{ column.label }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="localItems.length === 0">
            <td :colspan="totalColumns" class="app-datatable__empty">
              <div class="empty-icon">
                <i class="bi bi-inbox"></i>
              </div>
              <div class="empty-title">{{ emptyTitle }}</div>
              <div class="empty-text">{{ emptyText }}</div>
            </td>
          </tr>
          <tr
            v-for="(row, index) in localItems"
            :key="getRowKey(row, index)"
            :data-id="row.id"
          >
            <td v-if="bulkSelect" class="app-datatable__checkbox-cell">
              <input
                type="checkbox"
                class="form-check-input"
                :value="row.id"
                v-model="localSelectedIds"
              />
            </td>
            <td
              v-for="column in columns"
              :key="column.key"
              :class="column.class"
            >
              <template v-if="column.key === 'actions'">
                <MemberTableActions :actions="getRowActions(row)" />
              </template>
              <template v-else>
                <slot
                  :name="`cell-${column.key}`"
                  :row="row"
                  :value="getNestedValue(row, column.key)"
                >
                  {{ getNestedValue(row, column.key) }}
                </slot>
              </template>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="app-datatable__footer" v-if="showPagination && hasPagination">
      <div class="app-datatable__info">
        Mostrando {{ from }} a {{ to }} de {{ total }} registros
      </div>
      <div class="app-datatable__pagination">
        <button
          v-for="link in links"
          :key="link.label"
          class="btn btn-sm rounded-pill"
          :class="link.active ? 'btn-primary' : 'btn-secondary'"
          :disabled="!link.url"
          @click="goToPage(link)"
          v-html="link.label"
        />
      </div>
    </div>

    <div v-if="bulkSelect && localSelectedIds.length > 0" class="app-datatable__bulk-actions">
      <span class="text-muted small">
        {{ localSelectedIds.length }} seleccionado{{ localSelectedIds.length > 1 ? 's' : '' }}
      </span>
      <button
        class="btn btn-danger btn-sm rounded-pill"
        @click="executeBulkDelete"
        :disabled="bulkDeleting"
      >
        <i class="bi bi-trash me-1"></i>
        Eliminar ({{ localSelectedIds.length }})
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import MemberTableActions from '@/Components/Member/MemberTableActions.vue'

const props = defineProps({
  items: {
    type: [Object, Array],
    required: true,
  },
  columns: {
    type: Array,
    required: true,
  },
  getRowActions: {
    type: Function,
    default: () => [],
  },
  emptyTitle: {
    type: String,
    default: 'No hay registros',
  },
  emptyText: {
    type: String,
    default: '',
  },
  searchPlaceholder: {
    type: String,
    default: '',
  },
  showPagination: {
    type: Boolean,
    default: true,
  },
  bulkSelect: {
    type: Boolean,
    default: false,
  },
  bulkDeleteEndpoint: {
    type: String,
    default: '',
  },
  itemName: {
    type: String,
    default: 'elementos',
  },
  currentPageIds: {
    type: Array,
    default: () => [],
  },
  rowKey: {
    type: String,
    default: 'id',
  },
})

const emit = defineEmits(['deleted', 'updated'])

const localSearch = ref('')
const localSelectedIds = ref([])
const bulkDeleting = ref(false)
const tableWrapperElement = ref(null)
let searchTimer = null

const isPaginator = computed(() => {
  return props.items && typeof props.items === 'object' && 'data' in props.items
})

const localItems = computed(() => {
  if (isPaginator.value) {
    return props.items.data || []
  }
  return Array.isArray(props.items) ? props.items : []
})

const links = computed(() => {
  if (isPaginator.value) {
    return props.items.links || []
  }
  return []
})

const hasPagination = computed(() => {
  if (!isPaginator.value) return false
  return props.items.last_page > 1
})

const total = computed(() => {
  if (isPaginator.value) {
    return props.items.total || 0
  }
  return localItems.value.length
})

const from = computed(() => {
  if (isPaginator.value) {
    return props.items.from || 0
  }
  return 1
})

const to = computed(() => {
  if (isPaginator.value) {
    return props.items.to || 0
  }
  return localItems.value.length
})

const totalColumns = computed(() => {
  let cols = props.columns.length
  if (props.bulkSelect) cols++
  return cols
})

const allSelected = computed(() => {
  if (props.currentPageIds.length === 0) return false
  return props.currentPageIds.every(id => localSelectedIds.value.includes(id))
})

const someSelected = computed(() => {
  return localSelectedIds.value.length > 0
})

const getRowKey = (row, index) => {
  return row[props.rowKey] ?? index
}

const getNestedValue = (obj, path) => {
  return path.split('.').reduce((acc, part) => acc && acc[part], obj)
}

const onSearchInput = () => {
  clearTimeout(searchTimer)
  searchTimer = setTimeout(() => {
    emit('updated', { search: localSearch.value })
  }, 300)
}

const toggleSelectAll = () => {
  if (allSelected.value) {
    localSelectedIds.value = localSelectedIds.value.filter(
      id => !props.currentPageIds.includes(id)
    )
  } else {
    const newIds = [...new Set([...localSelectedIds.value, ...props.currentPageIds])]
    localSelectedIds.value = newIds
  }
}

const goToPage = (link) => {
  if (!link.url) return
  router.get(link.url, {}, {
    preserveState: true,
    preserveScroll: true,
  })
}

const executeBulkDelete = () => {
  if (!props.bulkDeleteEndpoint) return
  if (localSelectedIds.value.length === 0) return

  const count = localSelectedIds.value.length
  if (!confirm(`¿Eliminar ${count} ${props.itemName}?`)) return

  bulkDeleting.value = true
  router.post(props.bulkDeleteEndpoint, {
    ids: localSelectedIds.value,
  }, {
    preserveScroll: true,
    onSuccess: () => {
      localSelectedIds.value = []
      emit('deleted')
    },
    onFinish: () => {
      bulkDeleting.value = false
    },
  })
}

watch(() => props.currentPageIds, (newIds) => {
  const removed = localSelectedIds.value.filter(id => !newIds.includes(id))
  if (removed.length > 0) {
    localSelectedIds.value = localSelectedIds.value.filter(id => newIds.includes(id))
  }
})

watch(() => props.items, () => {
  if (!props.bulkSelect) return
  const currentPageSelected = localSelectedIds.value.filter(id => props.currentPageIds.includes(id))
}, { deep: true })

onMounted(() => {
  localSelectedIds.value = []
})
</script>
