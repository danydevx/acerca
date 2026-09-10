<template>
  <div class="d-flex align-items-center gap-3">
    <div class="form-check form-switch">
      <input
        type="checkbox"
        id="bulk-select-all"
        :checked="allSelected"
        :indeterminate="someSelected && !allSelected"
        @change="toggleSelectAll"
        class="form-check-input"
      />
      <label for="bulk-select-all" class="form-check-label">Seleccionar todos</label>
    </div>
    <button
      v-if="selectedIds.length > 0"
      class="btn btn-sm btn-danger rounded-pill"
      @click="deleteSelected"
      :disabled="deleting"
    >
      <i class="bi bi-trash me-1"></i>
      Eliminar ({{ selectedIds.length }})
    </button>
  </div>
</template>

<script setup>
import { computed, ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  selectedIds: {
    type: Array,
    default: () => [],
  },
  currentPageIds: {
    type: Array,
    required: true,
  },
  deleteEndpoint: {
    type: String,
    required: true,
  },
  itemName: {
    type: String,
    default: 'elementos',
  },
})

const emit = defineEmits(['update:selectedIds', 'deleted'])

const deleting = ref(false)

const allSelected = computed(() => {
  return props.currentPageIds.length > 0 &&
    props.currentPageIds.every(id => props.selectedIds.includes(id))
})

const someSelected = computed(() => {
  return props.selectedIds.length > 0
})

const toggleSelectAll = () => {
  if (allSelected.value) {
    emit('update:selectedIds', props.selectedIds.filter(id => !props.currentPageIds.includes(id)))
  } else {
    const newSelected = [...props.selectedIds]
    props.currentPageIds.forEach(id => {
      if (!newSelected.includes(id)) {
        newSelected.push(id)
      }
    })
    emit('update:selectedIds', newSelected)
  }
}

watch(() => props.currentPageIds, (newIds) => {
  emit('update:selectedIds', props.selectedIds.filter(id => newIds.includes(id)))
})

const deleteSelected = () => {
  if (props.selectedIds.length === 0) return

  const count = props.selectedIds.length
  const message = props.itemName === 'elementos'
    ? `Eliminar ${count} ${count > 1 ? 'elementos' : 'elemento'} seleccionado${count > 1 ? 's' : ''}?`
    : `Eliminar ${count} ${props.itemName}${count > 1 ? 's' : ''} seleccionado${count > 1 ? 's' : ''}?`

  if (confirm(message)) {
    deleting.value = true
    router.post(props.deleteEndpoint, {
      ids: props.selectedIds,
    }, {
      preserveScroll: true,
      onSuccess: () => {
        emit('update:selectedIds', [])
        emit('deleted', count)
      },
      onFinish: () => {
        deleting.value = false
      },
    })
  }
}
</script>

<style scoped>
.form-check-input {
  cursor: pointer;
}

.form-check-label {
  cursor: pointer;
}
</style>
