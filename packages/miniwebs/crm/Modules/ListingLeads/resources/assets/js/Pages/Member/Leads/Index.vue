<template>
  <MemberLayout>
    <Head :title="`Contactos - ${listing?.name || ''}`" />

    <PageHeader
      title="Contactos"
      :breadcrumbs="breadcrumbs"
      :backHref="'/member/listings'"
    >
      <template #actions>
        <a :href="`/member/listings/${listing?.id}/leads/export`" class="btn btn-secondary rounded-pill">
          <i class="bi bi-download me-1"></i>Exportar
        </a>
        <Link :href="`/member/listings/${listing?.id}/leads/create`" class="btn btn-primary rounded-pill">
          <i class="bi bi-plus-lg me-1"></i>
          Nuevo Contacto
        </Link>
      </template>
    </PageHeader>

    <BaseDataTable
      ref="dataTableRef"
      :endpoint="`/member/listings/${listing?.id}/leads`"
      :columns="columns"
      :initial-data="dataTable"
      search-placeholder="Buscar contactos..."
      empty-title="No hay contactos"
      empty-text="Comienza creando tu primer contacto."
      @updated="onDataTableUpdated"
    >
      <template #cell-checkbox="{ row }">
        <BulkSelectRowCheckbox
          :id="row.id"
          v-model:selectedIds="selectedIds"
        />
      </template>

      <template #cell-name="{ row }">
        <strong>{{ row.name }}</strong>
      </template>

      <template #cell-email="{ row }">
        <a :href="`mailto:${row.email}`">{{ row.email }}</a>
      </template>

      <template #cell-phone="{ row }">
        {{ row.phone || '-' }}
      </template>

      <template #cell-status="{ row }">
        <span :class="statusClass(row.status)" class="badge">
          {{ row.status_label }}
        </span>
      </template>

      <template #cell-source="{ row }">
        {{ row.source_label }}
      </template>

      <template #cell-created_at="{ row }">
        {{ formatDate(row.created_at) }}
      </template>

      <template #cell-actions="{ row }">
        <MemberTableActions :actions="[
          { label: 'Ver', icon: 'bi bi-eye', onClick: () => router.get(`/member/listings/${listing?.id}/leads/${row.id}`) },
          { label: 'Editar', icon: 'bi bi-pencil', onClick: () => router.get(`/member/listings/${listing?.id}/leads/${row.id}/edit`) },
          { label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => deleteLead(row) }
        ]" />
      </template>

      <template #header-actions>
        <BulkSelect
          v-model:selectedIds="selectedIds"
          :current-page-ids="currentPageIds"
          :delete-endpoint="`/member/listings/${listing?.id}/leads/bulk-delete`"
          item-name="contactos"
          @deleted="onBulkDeleted"
        />
      </template>
    </BaseDataTable>
  </MemberLayout>
</template>

<script setup>
import { computed, ref } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import BaseDataTable from '@/Components/DataTable/BaseDataTable.vue'
import { BulkSelect, BulkSelectRowCheckbox } from '@/Components/BulkSelect'
import MemberTableActions from '@/Components/Member/MemberTableActions.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const dataTable = computed(() => page.props.dataTable)
const businessMenu = computed(() => page.props.businessMenu || [])

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Leads' },
])

const columns = [
  { key: 'checkbox', label: '', sortable: false, width: '40px' },
  { key: 'name', label: 'Nombre', sortable: true },
  { key: 'email', label: 'Email', sortable: false },
  { key: 'phone', label: 'Telefono', sortable: false },
  { key: 'status', label: 'Estado', sortable: true },
  { key: 'source', label: 'Fuente', sortable: false },
  { key: 'created_at', label: 'Fecha', sortable: true },
  { key: 'actions', label: 'Acciones', sortable: false },
]

const dataTableRef = ref(null)
const selectedIds = ref([])

const currentPageIds = computed(() => {
  if (!dataTable.value?.data) return []
  return dataTable.value.data.map(row => row.id)
})

const onDataTableUpdated = (data) => {
  selectedIds.value = []
}

const onBulkDeleted = () => {
  if (dataTableRef.value) {
    dataTableRef.value.reload()
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-AR', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  })
}

const statusClass = (status) => {
  const classes = {
    new: 'bg-info',
    contacted: 'bg-primary',
    qualified: 'bg-success',
    converted: 'bg-dark',
    lost: 'bg-secondary',
  }
  return classes[status] || 'bg-secondary'
}

const deleteLead = (lead) => {
  if (confirm('¿Eliminar este contacto?')) {
    router.delete(`/member/listings/${listing.value.id}/leads/${lead.id}`, {
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
