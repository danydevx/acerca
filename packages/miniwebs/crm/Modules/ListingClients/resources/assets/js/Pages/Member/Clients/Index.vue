<template>
  <MemberLayout>
    <Head :title="`Clientes - ${listing?.name || ''}`" />

    <PageHeader
      title="Clientes"
      :breadcrumbs="breadcrumbs"
      :backHref="'/member/listings'"
    >
      <template #actions>
        <Link :href="`/member/listings/${listing?.id}/clients/create`" class="btn btn-primary rounded-pill">
          <i class="bi bi-plus-lg me-1"></i>
          Nuevo Cliente
        </Link>
      </template>
    </PageHeader>

    <BaseDataTable
      ref="dataTableRef"
      :endpoint="`/member/listings/${listing?.id}/clients`"
      :columns="columns"
      :initial-data="dataTable"
      search-placeholder="Buscar clientes..."
      empty-title="No hay clientes"
      empty-text="Comienza registrando tu primer cliente."
      @updated="onDataTableUpdated"
    >
      <template #header-actions>
        <BulkSelect
          v-model:selectedIds="selectedIds"
          :current-page-ids="currentPageIds"
          :delete-endpoint="`/member/listings/${listing?.id}/clients/bulk-delete`"
          item-name="clientes"
          @deleted="onBulkDeleted"
        />
      </template>

      <template #cell-checkbox="{ row }">
        <BulkSelectRowCheckbox
          :id="row.id"
          v-model:selectedIds="selectedIds"
        />
      </template>

      <template #cell-company_name="{ row }">
        <div>{{ row.company_name || row.contact_person || '-' }}</div>
        <small class="text-muted">{{ row.contact_person || '' }}</small>
      </template>

      <template #cell-customer_email="{ row }">
        <div>{{ row.customer_name }}</div>
        <small class="text-muted">{{ row.customer_email || '' }}</small>
      </template>

      <template #cell-state="{ row }">
        {{ row.state_code ? `${row.state_code} / ${row.municipality || ''}` : '-' }}
      </template>

      <template #cell-actions="{ row }">
        <MemberTableActions :actions="getRowActions(row)" />
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
import MemberTableActions from '@/Components/Member/MemberTableActions.vue'
import { BulkSelect, BulkSelectRowCheckbox } from '@/Components/BulkSelect'

const page = usePage()
const listing = computed(() => page.props.listing)
const dataTable = computed(() => page.props.dataTable)
const businessMenu = computed(() => page.props.businessMenu || [])

const columns = [
  { key: 'checkbox', label: '', sortable: false, width: '40px' },
  { key: 'company_name', label: 'Empresa / Contacto', sortable: true },
  { key: 'customer_email', label: 'Cliente', sortable: true },
  { key: 'whatsapp', label: 'WhatsApp', sortable: false },
  { key: 'rfc', label: 'RFC', sortable: false },
  { key: 'state', label: 'Estado / Municipio', sortable: false },
  { key: 'actions', label: 'Acciones', sortable: false },
]

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Clientes' },
])

const dataTableRef = ref(null)
const selectedIds = ref([])

const currentPageIds = computed(() => {
  if (!dataTable.value?.data) return []
  return dataTable.value.data.map(row => row.id)
})

const onDataTableUpdated = () => {
  selectedIds.value = []
}

const onBulkDeleted = () => {
  if (dataTableRef.value) {
    dataTableRef.value.reload()
  }
}

const getRowActions = (row) => {
  return [
    { label: 'Clonar', icon: 'bi bi-copy', onClick: () => cloneClient(row) },
    { label: 'Editar', icon: 'bi bi-pencil', onClick: () => router.get(`/member/listings/${listing.value.id}/clients/${row.id}/edit`) },
    { label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => deleteClient(row) },
  ]
}

const deleteClient = (row) => {
  if (confirm(`Estas seguro de eliminar a ${row.customer_name}? Esta accion no se puede deshacer.`)) {
    router.delete(`/member/listings/${listing.value.id}/clients/${row.id}`, {
      preserveScroll: true,
      onFinish: () => {
        if (dataTableRef.value) {
          dataTableRef.value.reload()
        }
      },
    })
  }
}

const cloneClient = (row) => {
  if (!confirm(`¿Clonar "${row.customer_name}"?`)) {
    return
  }
  router.post(`/member/listings/${listing.value.id}/clients/${row.id}/clone`, {}, {
    preserveScroll: true,
    onSuccess: () => {
      if (dataTableRef.value) {
        dataTableRef.value.reload()
      }
    },
  })
}
</script>
