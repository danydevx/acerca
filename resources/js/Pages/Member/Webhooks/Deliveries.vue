<template>
  <MemberLayout>
    <Head title="Entregas" />

    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
      <div>
        <h1 class="h4 mb-1">Entregas</h1>
        <p class="text-muted mb-0">{{ webhook.name }} · {{ webhook.url }}</p>
      </div>
      <Link href="/member/webhooks" class="btn btn-secondary rounded-pill">Volver</Link>
    </div>

    <MemberTable
      :items="deliveries"
      :columns="columns"
      :get-row-actions="getRowActions"
      empty-title="No hay entregas registradas"
      empty-text=""
    >
      <template #cell-event="{ row }">
        <strong>{{ row.event }}</strong>
      </template>
      <template #cell-status="{ row }">
        <span v-if="row.delivered_at" class="badge text-bg-success">Entregado</span>
        <span v-else class="badge text-bg-warning">Fallido</span>
      </template>
      <template #cell-date="{ row }">
        <span class="text-muted">{{ row.delivered_at || row.failed_at || row.created_at }}</span>
      </template>
      <template #cell-attempt_count="{ row }">
        <span class="text-muted">{{ row.attempt_count }}</span>
      </template>
    </MemberTable>
  </MemberLayout>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import MemberTable from '@/Components/Member/MemberTable.vue'

const props = defineProps({
  webhook: {
    type: Object,
    required: true,
  },
  deliveries: {
    type: Object,
    required: true,
  },
})

const columns = [
  { key: 'event', label: 'Evento', sortable: false },
  { key: 'status', label: 'Estado', sortable: false },
  { key: 'date', label: 'Fecha', sortable: false },
  { key: 'attempt_count', label: 'Intentos', sortable: false },
  { key: 'actions', label: '', sortable: false, class: 'text-end' },
]

const getRowActions = (delivery) => {
  if (delivery.delivered_at) return []
  return [
    {
      label: 'Reintentar',
      icon: 'bi bi-arrow-clockwise',
      onClick: () => retry(delivery),
    },
  ]
}

const retry = (delivery) => {
  router.post(`/member/webhooks/deliveries/${delivery.id}/retry`, {}, { preserveScroll: true })
}
</script>
