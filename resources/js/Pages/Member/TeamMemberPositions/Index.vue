<template>
  <MemberLayout>
    <Head :title="`Puestos - ${listing?.name || ''}`" />

    <PageHeader
      title="Puestos"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing?.id}/team-members`"
    >
      <template #tabs>
        <div class="dropdown">
          <button class="btn btn-secondary rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="bi bi-folder me-1"></i>Puestos
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <Link :href="`/member/listings/${listing?.id}/team-members`" class="dropdown-item">
                <i class="bi bi-people me-2"></i>Miembros
              </Link>
            </li>
            <li>
              <Link :href="`/member/listings/${listing?.id}/team-member-positions`" class="dropdown-item active">
                <i class="bi bi-folder me-2"></i>Puestos
              </Link>
            </li>
          </ul>
        </div>
      </template>
      <template #actions>
        <Link :href="`/member/listings/${listing?.id}/team-member-positions/create`" class="btn btn-primary rounded-pill">
          <i class="bi bi-plus-lg me-1"></i>Nuevo Puesto
        </Link>
      </template>
    </PageHeader>

    <BaseDataTable
      ref="dataTableRef"
      :endpoint="`/member/listings/${listing?.id}/team-member-positions`"
      :columns="columns"
      :initial-data="dataTable"
      :initial-per-page="perPage"
      :reorderable="true"
      :reorder-endpoint="`/member/listings/${listing?.id}/team-member-positions/reorder`"
      search-placeholder="Buscar puestos..."
      empty-title="No hay puestos"
      empty-text="Crea tu primer puesto para organizar a tu equipo."
      @updated="onDataTableUpdated"
    >
      <template #header-actions>
        <BulkSelect
          v-model:selectedIds="selectedIds"
          :current-page-ids="currentPageIds"
          :delete-endpoint="`/member/listings/${listing?.id}/team-member-positions/bulk-delete`"
          item-name="puestos"
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
        <span v-if="row.parent" class="badge bg-light text-dark ms-2">{{ row.parent.name }}</span>
      </template>

      <template #cell-description="{ row }">
        <span v-if="row.description" class="text-muted small">{{ row.description.substring(0, 50) }}...</span>
        <span v-else class="text-muted">-</span>
      </template>

      <template #cell-members_count="{ row }">
        <span class="text-muted">
          <i class="bi bi-people me-1"></i>{{ row.members_count || 0 }}
        </span>
      </template>

      <template #cell-children_count="{ row }">
        <span v-if="row.children_count > 0" class="text-muted">
          <i class="bi bi-diagram-3 me-1"></i>{{ row.children_count }}
        </span>
        <span v-else class="text-muted">-</span>
      </template>

      <template #cell-is_active="{ row }">
        <span :class="row.is_active ? 'badge bg-success-subtle text-success' : 'badge bg-secondary-subtle text-secondary'">
          {{ row.is_active ? 'Activo' : 'Inactivo' }}
        </span>
      </template>

      <template #cell-actions="{ row }">
        <MemberTableActions :actions="[
          { label: 'Editar', icon: 'bi bi-pencil', onClick: () => router.get(`/member/listings/${listing?.id}/team-member-positions/${row.id}/edit`) },
          { label: 'Eliminar', icon: 'bi bi-trash', danger: true, disabled: (row.members_count || 0) > 0 || (row.children_count || 0) > 0, disabledMessage: 'No se puede eliminar porque tiene miembros o sub-puestos asociados', onClick: () => deletePosition(row) }
        ]" />
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

const dataTableRef = ref(null)
const perPage = ref(10)

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Mi Equipo', href: `/member/listings/${listing.value?.id}/team-members` },
  { label: 'Puestos' },
])

const columns = [
  { key: 'checkbox', label: '', sortable: false, width: '40px' },
  { key: 'name', label: 'Nombre', sortable: true },
  { key: 'description', label: 'Descripción', sortable: false },
  { key: 'members_count', label: 'Miembros', sortable: false, class: 'text-center' },
  { key: 'children_count', label: 'Sub-puestos', sortable: false, class: 'text-center' },
  { key: 'is_active', label: 'Estado', sortable: true },
  { key: 'actions', label: 'Acciones', sortable: false, class: 'text-end' },
]

const selectedIds = ref([])

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

const deletePosition = (position) => {
  if (!confirm(`¿Estás seguro de eliminar "${position.name}"?`)) {
    return
  }

  router.delete(`/member/listings/${listing.value.id}/team-member-positions/${position.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      if (dataTableRef.value) {
        dataTableRef.value.reload()
      }
    },
  })
}
</script>
