<template>
  <MemberLayout>
    <Head title="Recompensas" />

    <PageHeader
      title="Recompensas"
      :breadcrumbs="breadcrumbs"
    >
      <template #actions>
        <Link :href="`/member/listings/${listing?.id}/fidelity-rewards/create`" class="btn btn-primary rounded-pill">
          <i class="bi bi-plus-lg me-1"></i>
          Nueva recompensa
        </Link>
      </template>
    </PageHeader>

    <BaseDataTable
      ref="dataTableRef"
      :endpoint="`/member/listings/${listing?.id}/fidelity-rewards/api`"
      :columns="columns"
      :initial-data="dataTable"
      search-placeholder="Buscar recompensas..."
      empty-title="No hay recompensas"
      empty-text="Crea tu primera recompensa para empezar."
      @updated="onDataTableUpdated"
    >
      <template #header-actions>
        <BulkSelect
          v-model:selectedIds="selectedIds"
          :current-page-ids="currentPageIds"
          :delete-endpoint="`/member/listings/${listing?.id}/fidelity-rewards/bulk-delete`"
          item-name="recompensas"
          @deleted="onBulkDeleted"
        />
      </template>

      <template #cell-checkbox="{ row }">
        <BulkSelectRowCheckbox :id="row.id" v-model:selectedIds="selectedIds" />
      </template>

      <template #cell-image="{ row }">
        <img
          v-if="row.image"
          :src="`/storage/${row.image}`"
          :alt="row.title"
          class="img-thumbnail"
          style="width: 60px; height: 60px; object-fit: cover;"
        />
        <span v-else class="text-muted">
          <i class="bi bi-image" style="font-size: 1.5rem;"></i>
        </span>
      </template>

      <template #cell-title="{ row }">
        <strong>{{ row.title }}</strong>
        <p v-if="row.description" class="text-muted small mb-0">{{ row.description.substring(0, 50) }}...</p>
      </template>

      <template #cell-max_visits="{ row }">
        <span class="badge bg-primary">{{ row.max_visits }} visitas</span>
      </template>

      <template #cell-is_active="{ row }">
        <span :class="row.is_active ? 'badge bg-success' : 'badge bg-secondary'">
          {{ row.is_active ? 'Activa' : 'Inactiva' }}
        </span>
      </template>

      <template #cell-actions="{ row }">
        <MemberTableActions
          :actions="[
            { label: 'Editar', icon: 'bi bi-pencil', onClick: () => router.get(`/member/listings/${listing?.id}/fidelity-rewards/${row.id}/edit`) },
            { label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => deleteReward(row), disabled: row.cards_count > 0 }
          ]"
        />
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
const dataTable = computed(() => page.props.dataTable || { data: [], total: 0 })

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Fidelización', href: `/member/listings/${listing.value?.id}/fidelity-cards` },
  { label: 'Recompensas' },
])

const columns = [
  { key: 'checkbox', label: '', sortable: false, width: '40px' },
  { key: 'image', label: 'Imagen', sortable: false },
  { key: 'title', label: 'Título', sortable: true },
  { key: 'max_visits', label: 'Visitas', sortable: false },
  { key: 'is_active', label: 'Estado', sortable: true },
  { key: 'actions', label: 'Acciones', sortable: false },
]

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

const deleteReward = (row) => {
  if (row.cards_count > 0) {
    alert('No se puede eliminar una recompensa que tiene tarjetas asociadas.')
    return
  }
  if (confirm(`¿Eliminar la recompensa "${row.title}"?`)) {
    router.delete(`/member/listings/${listing.value?.id}/fidelity-rewards/${row.id}`, {
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
