<template>
  <MemberLayout>
    <Head title="Archivos" />

    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
      <div>
        <h1 class="h4 mb-1">Archivos</h1>
        <p class="text-muted mb-0">Sube y gestiona tus archivos.</p>
      </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
      <div class="card-body">
        <form class="row g-3" @submit.prevent="submit">
          <div class="col-12 col-md-8">
            <label class="form-label">Archivo</label>
            <input ref="fileInput" type="file" class="form-control" @change="handleFile" />
            <div v-if="form.errors.file" class="text-danger small mt-1">{{ form.errors.file }}</div>
            <div class="text-muted small mt-1">
              Max {{ maxSizeKb / 1024 }} MB · Tipos: {{ allowedTypes.join(', ') }}
            </div>
          </div>
          <div class="col-12 col-md-4 d-flex align-items-end">
            <button class="btn btn-primary rounded-pill w-100" type="submit" :disabled="form.processing">
              {{ form.processing ? 'Subiendo...' : 'Subir archivo' }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <MemberTable
      :items="files"
      :columns="columns"
      :get-row-actions="getRowActions"
      empty-title="No hay archivos"
      empty-text=""
    >
      <template #cell-original_name="{ row }">
        <strong>{{ row.original_name }}</strong>
      </template>
      <template #cell-type="{ row }">
        <span class="text-muted">{{ row.type || '-' }}</span>
      </template>
      <template #cell-mime_type="{ row }">
        <span class="text-muted">{{ row.mime_type || '-' }}</span>
      </template>
      <template #cell-size="{ row }">
        <span class="text-muted">{{ formatSize(row.size) }}</span>
      </template>
      <template #cell-created_at="{ row }">
        <span class="text-muted">{{ row.created_at }}</span>
      </template>
    </MemberTable>
  </MemberLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link, router, useForm } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import MemberTable from '@/Components/Member/MemberTable.vue'

const props = defineProps({
  files: {
    type: Object,
    required: true,
  },
  maxSizeKb: {
    type: Number,
    default: 5120,
  },
  allowedTypes: {
    type: Array,
    default: () => [],
  },
})

const fileInput = ref(null)
const form = useForm({
  file: null,
})

const columns = [
  { key: 'original_name', label: 'Nombre', sortable: false },
  { key: 'type', label: 'Tipo', sortable: false },
  { key: 'mime_type', label: 'Mime', sortable: false },
  { key: 'size', label: 'Tamaño', sortable: false },
  { key: 'created_at', label: 'Fecha', sortable: false },
  { key: 'actions', label: '', sortable: false, class: 'text-end' },
]

const handleFile = (event) => {
  form.file = event.target.files[0]
}

const submit = () => {
  form.post('/member/files', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset('file')
      if (fileInput.value) fileInput.value.value = ''
    },
  })
}

const getRowActions = (file) => {
  return [
    { label: 'Ver', icon: 'bi bi-eye', onClick: () => router.get(`/member/files/${file.id}`) },
    { label: 'Descargar', icon: 'bi bi-download', onClick: () => router.get(`/member/files/${file.id}/download`) },
    { label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => remove(file) },
  ]
}

const remove = (file) => {
  if (!confirm('Eliminar este archivo?')) return
  router.delete(`/member/files/${file.id}`, { preserveScroll: true })
}

const formatSize = (bytes) => {
  if (!bytes) return '0 KB'
  const kb = bytes / 1024
  if (kb < 1024) return `${kb.toFixed(0)} KB`
  return `${(kb / 1024).toFixed(2)} MB`
}
</script>
