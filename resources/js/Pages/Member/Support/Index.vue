<template>
  <MemberLayout>
    <Head title="Soporte" />

    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
      <div>
        <h1 class="h4 mb-1">Soporte</h1>
        <p class="text-muted mb-0">Consulta y crea solicitudes de ayuda.</p>
      </div>
      <Link href="/member/support/create" class="btn btn-primary rounded-pill">
        <i class="bi bi-plus-lg me-1"></i>Nuevo ticket
      </Link>
    </div>

    <FilterBar
      :filters="['search', 'status', 'priority']"
      :select-options="{
        status: statuses.map(s => ({ value: s, label: s })),
        priority: priorities.map(p => ({ value: p, label: p })),
      }"
      :values="filterValues"
      search-placeholder="Asunto o categoría"
      search-col-class="col-12 col-md-4"
      @update="handleFilterUpdate"
      @clear="handleFilterClear"
    />

    <MemberTable
      :items="tickets"
      :columns="columns"
      :get-row-actions="getRowActions"
      empty-title="No tienes tickets abiertos"
      empty-text=""
    >
      <template #cell-subject="{ row }">
        <strong>{{ row.subject }}</strong>
      </template>
      <template #cell-status="{ row }">
        <span class="badge" :class="statusClass(row.status)">{{ row.status }}</span>
      </template>
      <template #cell-priority="{ row }">
        <span class="text-muted">{{ row.priority || '-' }}</span>
      </template>
      <template #cell-last_reply_at="{ row }">
        <span class="text-muted">{{ row.last_reply_at || row.created_at }}</span>
      </template>
    </MemberTable>
  </MemberLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import MemberTable from '@/Components/Member/MemberTable.vue'
import FilterBar from '@/Components/Member/FilterBar.vue'

const props = defineProps({
  tickets: {
    type: Object,
    required: true,
  },
  filters: {
    type: Object,
    default: () => ({}),
  },
})

const statuses = ['open', 'pending', 'answered', 'closed']
const priorities = ['low', 'medium', 'high']

const filterValues = computed(() => ({
  search: props.filters.search || '',
  status: props.filters.status || '',
  priority: props.filters.priority || '',
}))

const columns = [
  { key: 'subject', label: 'Asunto', sortable: false },
  { key: 'status', label: 'Estado', sortable: false },
  { key: 'priority', label: 'Prioridad', sortable: false },
  { key: 'last_reply_at', label: 'Última respuesta', sortable: false },
  { key: 'actions', label: '', sortable: false, class: 'text-end' },
]

const getRowActions = (ticket) => {
  return [
    {
      label: 'Ver',
      icon: 'bi bi-eye',
      onClick: () => router.get(`/member/support/${ticket.id}`),
    },
  ]
}

const handleFilterUpdate = (values) => {
  router.get(
    '/member/support',
    {
      search: values.search || '',
      status: values.status || '',
      priority: values.priority || '',
    },
    { preserveState: true, replace: true, preserveScroll: true }
  )
}

const handleFilterClear = () => {
  handleFilterUpdate({ search: '', status: '', priority: '' })
}

const statusClass = (value) => {
  if (value === 'open') return 'text-bg-success'
  if (value === 'pending') return 'text-bg-warning'
  if (value === 'answered') return 'text-bg-primary'
  if (value === 'closed') return 'text-bg-secondary'
  return 'text-bg-secondary'
}
</script>
