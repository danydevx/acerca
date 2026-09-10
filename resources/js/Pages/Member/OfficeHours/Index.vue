<template>
  <MemberLayout>
    <Head :title="`Horarios - ${location.name}`" />

    <PageHeader
      title="Horarios de Atención"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing.id}/locations/${location.id}/edit`"
    >
      <template #actions>
        <Link
          :href="`/member/listings/${listing.id}/locations/${location.id}/schedules/create`"
          class="btn btn-primary rounded-pill"
        >
          <i class="bi bi-plus-lg me-1"></i>
          Nuevo Horario
        </Link>
      </template>
    </PageHeader>

    <BaseDataTable
      ref="dataTableRef"
      :endpoint="`/member/listings/${listing?.id}/locations/${location?.id}/schedules`"
      :columns="columns"
      :initial-data="dataTable"
      :initial-per-page="perPage"
      search-placeholder="Buscar horarios..."
      empty-title="No hay horarios"
      empty-text="Comienza creando tu primer horario."
      @updated="onDataTableUpdated"
    >
      <template #header-actions>
        <BulkSelect
          v-model:selectedIds="selectedIds"
          :current-page-ids="currentPageIds"
          :delete-endpoint="`/member/listings/${listing?.id}/locations/${location?.id}/schedules/bulk-delete`"
          item-name="horarios"
          @deleted="onBulkDeleted"
        />
      </template>

      <template #cell-checkbox="{ row }">
        <BulkSelectRowCheckbox
          :id="row.id"
          v-model:selectedIds="selectedIds"
        />
      </template>
      <template #cell-name="{ row }">
        <strong>{{ row.name }}</strong>
      </template>

      <template #cell-days_display="{ row }">
        <span class="badge bg-light text-dark border">{{ row.days_display }}</span>
      </template>

      <template #cell-time_display="{ row }">
        <span class="schedule-time">{{ row.time_display }}</span>
      </template>

      <template #cell-is_active="{ row }">
        <span :class="row.is_active ? 'badge bg-success-subtle text-success' : 'badge bg-secondary-subtle text-secondary'">
          <i :class="row.is_active ? 'bi bi-check-circle me-1' : 'bi bi-x-circle me-1'"></i>
          {{ row.is_active ? 'Activo' : 'Inactivo' }}
        </span>
      </template>

      <template #cell-actions="{ row }">
        <MemberTableActions :actions="[
          { label: 'Editar', icon: 'bi bi-pencil', onClick: () => router.get(`/member/listings/${listing?.id}/locations/${location?.id}/schedules/${row.id}/edit`) },
          { label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => deleteSchedule(row) }
        ]" />
      </template>
    </BaseDataTable>
  </MemberLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import BaseDataTable from '@/Components/DataTable/BaseDataTable.vue'
import { BulkSelect, BulkSelectRowCheckbox } from '@/Components/BulkSelect'
import MemberTableActions from '@/Components/Member/MemberTableActions.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const location = computed(() => page.props.location)
const dataTable = computed(() => page.props.dataTable)

const businessMenu = computed(() => page.props.businessMenu || [])

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Horarios' },
])

const columns = [
  { key: 'checkbox', label: '', sortable: false, width: '40px' },
  { key: 'name', label: 'Nombre', sortable: true },
  { key: 'days_display', label: 'Días', sortable: false },
  { key: 'time_display', label: 'Horario', sortable: false },
  { key: 'is_active', label: 'Estado', sortable: true },
  { key: 'actions', label: 'Acciones', sortable: false },
]

const dataTableRef = ref(null)
const selectedIds = ref([])
const perPage = ref(10)

const currentPageIds = computed(() => {
  if (!dataTable.value?.data) return []
  return dataTable.value.data.map(row => row.id)
})

const onDataTableUpdated = (data) => {
  perPage.value = data.per_page
  selectedIds.value = []
}

const onBulkDeleted = () => {
  if (dataTableRef.value) {
    dataTableRef.value.reload()
  }
}

const deleteSchedule = (schedule) => {
  if (confirm('¿Eliminar este horario? Esta acción no se puede deshacer.')) {
    router.delete(`/member/listings/${listing.value.id}/locations/${location.value.id}/schedules/${schedule.id}`, {
      preserveScroll: true,
      onSuccess: () => {
        if (dataTableRef.value) {
          dataTableRef.value.reload()
        }
      },
    })
  }
}
</script>

<style scoped>
.schedule-time {
  font-family: monospace;
  background: var(--bs-light);
  padding: 0.125rem 0.5rem;
  border-radius: 0.25rem;
  font-size: 0.85em;
}
</style>
