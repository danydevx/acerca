<template>
  <MemberLayout>
    <Head :title="`Resenas - ${listing?.name || ''}`" />

    <PageHeader
      title="Resenas"
      :breadcrumbs="breadcrumbs"
      :backHref="'/member/listings'"
    >
      <template #actions>
        <Link :href="`/member/listings/${listing?.id}/reviews/create`" class="btn btn-primary rounded-pill">
          <i class="bi bi-plus-lg me-1"></i>
          Nueva Reseña
        </Link>
      </template>
    </PageHeader>

    <BaseDataTable
      ref="dataTableRef"
      :endpoint="`/member/listings/${listing?.id}/reviews`"
      :columns="columns"
      :initial-data="dataTable"
      :reorderable="true"
      :reorder-endpoint="`/member/listings/${listing?.id}/reviews/reorder`"
      search-placeholder="Buscar resenas..."
      empty-title="No hay resenas"
      empty-text="Comienza creando tu primera resena."
      @updated="onDataTableUpdated"
    >
      <template #cell-checkbox="{ row }">
        <BulkSelectRowCheckbox
          :id="row.id"
          v-model:selectedIds="selectedIds"
        />
      </template>

      <template #cell-client_name="{ row }">
        <div>{{ row.client_name }}</div>
        <small v-if="row.company" class="text-muted">{{ row.company }}</small>
      </template>

      <template #cell-rating="{ row }">
        <span class="text-warning">
          <i v-for="n in row.rating" :key="n" class="bi bi-star-fill"></i>
          <i v-for="n in (5 - row.rating)" :key="'empty-' + n" class="bi bi-star text-muted"></i>
        </span>
      </template>

      <template #cell-comment="{ row }">
        <span v-if="row.comment">{{ row.comment.substring(0, 60) }}{{ row.comment.length > 60 ? '...' : '' }}</span>
        <span v-else class="text-muted">-</span>
      </template>

      <template #cell-location="{ row }">
        {{ row.location?.name || '-' }}
      </template>

      <template #cell-is_active="{ row }">
        <span :class="row.is_active ? 'badge bg-success' : 'badge bg-secondary'">
          {{ row.is_active ? 'Activa' : 'Inactiva' }}
        </span>
      </template>

      <template #cell-actions="{ row }">
        <MemberTableActions
          :actions="[
            { label: 'Clonar', icon: 'bi bi-copy', onClick: () => cloneReview(row), disabled: cloning === row.id },
            { label: 'Editar', icon: 'bi bi-pencil', onClick: () => router.get(`/member/listings/${listing?.id}/reviews/${row.id}/edit`) },
            { label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => deleteReview(row) }
          ]"
        />
      </template>

      <template #header-actions>
        <BulkSelect
          v-model:selectedIds="selectedIds"
          :current-page-ids="currentPageIds"
          :delete-endpoint="`/member/listings/${listing?.id}/reviews/bulk-delete`"
          item-name="resenas"
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
  { label: 'Reseñas' },
])

const columns = [
  { key: 'checkbox', label: '', sortable: false, width: '40px' },
  { key: 'sort_order', label: 'Orden', sortable: true, width: '70px' },
  { key: 'client_name', label: 'Cliente', sortable: true },
  { key: 'rating', label: 'Calificacion', sortable: true },
  { key: 'comment', label: 'Comentario', sortable: false },
  { key: 'location', label: 'Ubicacion', sortable: false },
  { key: 'is_active', label: 'Estado', sortable: true },
  { key: 'actions', label: 'Acciones', sortable: false },
]

const dataTableRef = ref(null)
const cloning = ref(null)
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

const deleteReview = (review) => {
  if (!confirm(`Eliminar la reseña de "${review.client_name}"?`)) return
  router.delete(`/member/listings/${listing.value.id}/reviews/${review.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      if (dataTableRef.value) {
        dataTableRef.value.reload()
      }
    },
  })
}

const cloneReview = (review) => {
  if (!confirm(`Clonar la reseña de "${review.client_name}"?`)) return
  cloning.value = review.id
  router.post(`/member/listings/${listing.value.id}/reviews/${review.id}/clone`, {}, {
    preserveScroll: true,
    onFinish: () => {
      cloning.value = null
    },
  })
}
</script>
