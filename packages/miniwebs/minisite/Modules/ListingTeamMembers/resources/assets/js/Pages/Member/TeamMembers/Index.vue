<template>
  <MemberLayout>
    <Head :title="`Mi Equipo - ${listing?.name || ''}`" />

    <PageHeader
      title="Mi Equipo"
      :breadcrumbs="breadcrumbs"
      backHref="/member/dashboard"
    >
      <template #filters>
        <select
          v-model="selectedPosition"
          class="form-select form-select-sm"
          @change="filterByPosition"
          style="max-width: 200px;"
        >
          <option :value="null">Todos los puestos</option>
          <option v-for="pos in positions" :key="pos.id" :value="pos.id">
            {{ pos.name }}
          </option>
        </select>
      </template>
      <template #tabs>
        <div class="dropdown">
          <button class="btn btn-secondary rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="bi bi-people me-1"></i>Miembros
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <Link :href="`/member/listings/${listing?.id}/team-members`" class="dropdown-item active">
                <i class="bi bi-people me-2"></i>Miembros
              </Link>
            </li>
            <li>
              <Link :href="`/member/listings/${listing?.id}/team-member-positions`" class="dropdown-item">
                <i class="bi bi-folder me-2"></i>Puestos
              </Link>
            </li>
          </ul>
        </div>
      </template>
      <template #actions>
        <Link :href="`/member/listings/${listing?.id}/team-members/create`" class="btn btn-primary rounded-pill">
          <i class="bi bi-plus-lg me-1"></i>Nuevo Miembro
        </Link>
      </template>
    </PageHeader>

    <BaseDataTable
      ref="dataTableRef"
      :endpoint="`/member/listings/${listing?.id}/team-members`"
      :columns="columns"
      :initial-data="dataTable"
      :initial-per-page="perPage"
      :reorderable="true"
      :reorder-endpoint="`/member/listings/${listing?.id}/team-members/reorder`"
      search-placeholder="Buscar miembros..."
      empty-title="No hay miembros del equipo"
      empty-text="Comienza invitando a tu primer miembro del equipo."
      @updated="onDataTableUpdated"
    >
      <template #header-actions>
        <BulkSelect
          v-model:selectedIds="selectedIds"
          :current-page-ids="currentPageIds"
          :delete-endpoint="`/member/listings/${listing?.id}/team-members/bulk-delete`"
          item-name="miembros"
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
        <div class="d-flex align-items-center gap-2">
          <img
            v-if="row.image"
            :src="row.image"
            class="rounded-circle"
            style="width: 40px; height: 40px; object-fit: cover;"
          />
          <div v-else class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <i class="bi bi-person text-muted"></i>
          </div>
          <div>
            <strong>{{ row.name }}</strong>
            <p v-if="row.position" class="text-muted small mb-0">
              <span class="badge bg-light text-dark">{{ row.position.name }}</span>
            </p>
          </div>
        </div>
      </template>

      <template #cell-email="{ value }">
        <span v-if="value">{{ value }}</span>
        <span v-else class="text-muted">-</span>
      </template>

      <template #cell-phone="{ value }">
        <span v-if="value">{{ value }}</span>
        <span v-else class="text-muted">-</span>
      </template>

      <template #cell-is_active="{ value }">
        <span v-if="value" class="badge bg-success">Activo</span>
        <span v-else class="badge bg-secondary">Inactivo</span>
      </template>

      <template #cell-actions="{ row }">
        <MemberTableActions :actions="[
          { label: 'Editar', icon: 'bi bi-pencil', onClick: () => router.get(`/member/listings/${listing?.id}/team-members/${row.id}/edit`) },
          { label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => deleteMember(row) }
        ]" />
      </template>
    </BaseDataTable>
  </MemberLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import BaseDataTable from '@/Components/DataTable/BaseDataTable.vue'
import { BulkSelect, BulkSelectRowCheckbox } from '@/Components/BulkSelect'
import MemberTableActions from '@/Components/Member/MemberTableActions.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const positions = computed(() => page.props.positions || [])
const dataTable = computed(() => page.props.dataTable || { data: [] })
const businessMenu = computed(() => page.props.businessMenu || [])

const filters = computed(() => page.props.filters || {})
const getInitialPosition = () => {
  const params = new URLSearchParams(window.location.search)
  return params.get('position') ? Number(params.get('position')) : null
}
const selectedPosition = ref(getInitialPosition())

watch(filters, (newFilters) => {
  selectedPosition.value = newFilters.position
})

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Mi Equipo' },
])

const perPage = ref(10)

const columns = [
  { key: 'checkbox', label: '', sortable: false, width: '40px' },
  { key: 'name', label: 'Nombre', sortable: true },
  { key: 'email', label: 'Correo', sortable: true },
  { key: 'phone', label: 'Teléfono', sortable: false },
  { key: 'is_active', label: 'Estado', sortable: true },
  { key: 'actions', label: 'Acciones', sortable: false },
]

const dataTableRef = ref(null)
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

const filterByPosition = () => {
  const params = {}
  if (selectedPosition.value) {
    params.position = selectedPosition.value
  }
  router.get(`/member/listings/${listing.value.id}/team-members`, params, {
    preserveScroll: true,
  })
}

const deleteMember = (member) => {
  if (!confirm(`¿Estás seguro de eliminar a "${member.name}"?`)) {
    return
  }

  router.delete(`/member/listings/${listing.value.id}/team-members/${member.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      if (dataTableRef.value) {
        dataTableRef.value.reload()
      }
    },
  })
}
</script>
