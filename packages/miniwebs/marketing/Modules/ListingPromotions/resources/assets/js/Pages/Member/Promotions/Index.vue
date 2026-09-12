<template>
  <MemberLayout>
    <Head :title="`Promociones - ${listing?.name || ''}`" />

    <PageHeader
      title="Promociones"
      :breadcrumbs="breadcrumbs"
      :backHref="'/member/listings'"
    >
      <template #actions>
        <Link :href="`/member/listings/${listing?.id}/promotions/create`" class="btn btn-primary rounded-pill">
          <i class="bi bi-plus-lg me-1"></i>
          Nueva Promocion
        </Link>
      </template>
    </PageHeader>

    <BaseDataTable
      ref="dataTableRef"
      :endpoint="`/member/listings/${listing?.id}/promotions`"
      :columns="columns"
      :initial-data="dataTable"
      :reorderable="true"
      :reorder-endpoint="`/member/listings/${listing?.id}/promotions/reorder`"
      search-placeholder="Buscar promociones..."
      empty-title="No hay promociones"
      empty-text="Comienza creando tu primera promocion."
      @updated="onDataTableUpdated"
    >
      <template #cell-checkbox="{ row }">
        <BulkSelectRowCheckbox
          :id="row.id"
          v-model:selectedIds="selectedIds"
        />
      </template>

      <template #cell-image="{ row }">
        <img v-if="row.image" :src="row.image" class="rounded" style="width: 50px; height: 50px; object-fit: cover;" />
        <i v-else class="bi bi-image text-muted fs-4"></i>
      </template>

      <template #cell-name="{ row }">
        <strong>{{ row.name }}</strong>
      </template>

      <template #cell-regular_price="{ row }">
        {{ formatPrice(row.regular_price) }}
      </template>

      <template #cell-promotion_price="{ row }">
        <span class="text-success fw-bold">{{ formatPrice(row.promotion_price) }}</span>
      </template>

      <template #cell-coupon_code="{ row }">
        <span v-if="row.coupon_code" class="badge bg-warning text-dark">{{ row.coupon_code }}</span>
        <span v-else>-</span>
      </template>

      <template #cell-expires_at="{ row }">
        <span v-if="row.expires_at" :class="isExpired(row.expires_at) ? 'text-danger' : 'text-muted'">
          {{ formatDate(row.expires_at) }}
        </span>
        <span v-else>-</span>
      </template>

      <template #cell-is_active="{ row }">
        <span :class="row.is_active ? 'badge bg-success' : 'badge bg-secondary'">
          {{ row.is_active ? 'Activa' : 'Inactiva' }}
        </span>
      </template>

      <template #header-actions>
        <BulkSelect
          v-model:selectedIds="selectedIds"
          :current-page-ids="currentPageIds"
          :delete-endpoint="`/member/listings/${listing?.id}/promotions/bulk-delete`"
          item-name="promociones"
          @deleted="onBulkDeleted"
        />
      </template>

      <template #cell-actions="{ row }">
        <MemberTableActions
          :actions="[
            { label: 'Clonar', icon: 'bi bi-copy', onClick: () => clonePromotion(row), disabled: cloning === row.id },
            { label: 'Editar', icon: 'bi bi-pencil', onClick: () => router.get(`/member/listings/${listing?.id}/promotions/${row.id}/edit`) },
            { label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => deletePromotion(row) }
          ]"
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
  { label: 'Promociones' },
])

const columns = [
  { key: 'checkbox', label: '', sortable: false, width: '40px' },
  { key: 'image', label: 'Imagen', sortable: false },
  { key: 'name', label: 'Nombre', sortable: true },
  { key: 'regular_price', label: 'Precio Regular', sortable: true },
  { key: 'promotion_price', label: 'Precio Promo', sortable: true },
  { key: 'coupon_code', label: 'Cupon', sortable: false },
  { key: 'expires_at', label: 'Expira', sortable: true },
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

const formatDate = (date) => {
  if (!date) return '-'
  return new Date(date).toLocaleDateString('es-AR')
}

const formatPrice = (price) => {
  if (!price) return '-'
  return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(price)
}

const isExpired = (date) => {
  return new Date(date) < new Date()
}

const deletePromotion = (row) => {
  if (!confirm(`Eliminar la promocion "${row.name}"?`)) return
  router.delete(`/member/listings/${listing.value.id}/promotions/${row.id}`, {
    preserveScroll: true,
  })
}

const clonePromotion = (row) => {
  if (!confirm(`Clonar la promocion "${row.name}"?`)) return
  cloning.value = row.id
  router.post(`/member/listings/${listing.value.id}/promotions/${row.id}/clone`, {}, {
    preserveScroll: true,
    onFinish: () => {
      cloning.value = null
    },
  })
}
</script>
