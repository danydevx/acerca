<template>
  <MemberLayout>
    <Head :title="`Check-in - ${listing?.name || ''}`" />

    <PageHeader
      title="Check-in"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing?.id}/modules`"
    />

    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body text-center">
            <h3 class="mb-0">{{ stats.total }}</h3>
            <small class="text-muted">Total Invitados</small>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body text-center">
            <h3 class="mb-0 text-success">{{ stats.checked_in }}</h3>
            <small class="text-muted">Registrados</small>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body text-center">
            <h3 class="mb-0 text-warning">{{ stats.pending }}</h3>
            <small class="text-muted">Pendientes</small>
          </div>
        </div>
      </div>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div v-if="checkins.data.length === 0" class="text-center text-muted py-5">
          <i class="bi bi-qr-code-scan display-1"></i>
          <h5 class="mt-3">No hay registros de check-in</h5>
          <p>Los invitados se registrarán cuando lleguen al evento.</p>
        </div>

        <MemberTable
          v-else
          :items="checkins"
          :columns="columns"
          :get-row-actions="getRowActions"
          empty-title="No hay registros de check-in"
          empty-text="Los invitados se registrarán cuando lleguen al evento."
        >
          <template #cell-guest="{ row }">
            <strong>{{ row.guest?.name || '-' }}</strong>
            <br />
            <small class="text-muted">{{ row.guest?.email || '' }}</small>
          </template>
          <template #cell-checkin_time="{ row }">
            {{ formatDate(row.checkin_time) }}
          </template>
          <template #cell-notes="{ row }">
            {{ row.notes || '-' }}
          </template>
        </MemberTable>
      </div>
    </div>
  </MemberLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import MemberTable from '@/Components/Member/MemberTable.vue'

const props = defineProps({
  listing: Object,
  checkins: Object,
  stats: Object,
})

const page = usePage()
const listing = computed(() => page.props.listing)
const businessMenu = computed(() => page.props.businessMenu || [])

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: `/member/listings/${listing.value?.id}/modules` },
  { label: 'Check-in', active: true },
])

const columns = [
  { key: 'guest', label: 'Invitado', sortable: false },
  { key: 'checkin_time', label: 'Hora de registro', sortable: false },
  { key: 'notes', label: 'Notas', sortable: false },
  { key: 'actions', label: '', sortable: false, class: 'text-end' },
]

const formatDate = (date) => {
  if (!date) return '-'
  return new Date(date).toLocaleString('es-MX')
}

const getRowActions = (checkin) => {
  return [
    { label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => deleteCheckin(checkin) },
  ]
}

const deleteCheckin = (checkin) => {
  if (confirm('¿Eliminar este registro de check-in?')) {
    router.delete(`/member/listings/${listing.value.id}/checkin/${checkin.id}`, {
      preserveScroll: true,
    })
  }
}
</script>
