<template>
  <MemberLayout>
    <Head :title="`Productos - ${listing?.name || ''}`" />

    <PageHeader
      title="Productos"
      :breadcrumbs="breadcrumbs"
      :backHref="'/member/listings'"
    >
      <template #filters>
        <select v-model="filterCategory" class="form-select form-select-sm" @change="filterProducts" style="max-width: 200px;">
          <option :value="null">Todas las categorias</option>
          <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
        </select>
        <button v-if="filterCategory" type="button" class="btn btn-secondary rounded-pill" @click="clearFilter">
          <i class="bi bi-x-lg"></i>
        </button>
      </template>
      <template #actions>
        <Link :href="`/member/listings/${listing?.id}/product-categories`" class="btn btn-secondary rounded-pill">
          <i class="bi bi-folder me-1"></i>Categorias
        </Link>
        <Link :href="`/member/listings/${listing?.id}/products/create`" class="btn btn-primary rounded-pill">
          <i class="bi bi-plus-lg me-1"></i>
          Nuevo Producto
        </Link>
      </template>
    </PageHeader>

    <BaseDataTable
      ref="dataTableRef"
      :endpoint="`/member/listings/${listing?.id}/products`"
      :columns="columns"
      :initial-data="dataTable"
      :initial-per-page="perPage"
      :reorderable="true"
      :reorder-endpoint="`/member/listings/${listing?.id}/products/reorder`"
      search-placeholder="Buscar productos..."
      empty-title="No hay productos"
      :empty-text="selectedCategoryName ? `No hay productos en la categoria '${selectedCategoryName}'.` : 'Comienza creando tu primer producto.'"
      @updated="onDataTableUpdated"
    >
      <template #header-actions>
        <BulkSelect
          v-model:selectedIds="selectedIds"
          :current-page-ids="currentPageIds"
          :delete-endpoint="`/member/listings/${listing?.id}/products/bulk-delete`"
          item-name="productos"
          @deleted="onBulkDeleted"
        />
      </template>

      <template #cell-checkbox="{ row }">
        <BulkSelectRowCheckbox
          :id="row.id"
          v-model:selectedIds="selectedIds"
        />
      </template>

      <template #cell-image="{ row }">
        <img
          v-if="row.image"
          :src="row.image"
          class="rounded"
          style="width: 48px; height: 48px; object-fit: cover;"
        />
        <div v-else class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
          <i class="bi bi-image text-muted"></i>
        </div>
      </template>

      <template #cell-name="{ row }">
        <strong>{{ row.name }}</strong>
        <p v-if="row.description" class="text-muted small mb-0">{{ row.description.substring(0, 60) }}...</p>
      </template>

      <template #cell-category="{ row }">
        <span v-if="row.category">{{ row.category.name }}</span>
        <span v-else class="text-muted">-</span>
      </template>

      <template #cell-price="{ row }">
        <span v-if="row.price" class="fw-semibold" v-format-price="row.price"></span>
        <span v-else class="text-muted">-</span>
      </template>

      <template #cell-quantity="{ row }">
        <span v-if="row.quantity !== null">{{ row.quantity }}</span>
        <span v-else class="text-muted">-</span>
      </template>

      <template #cell-location="{ row }">
        <span v-if="row.location">{{ row.location.name }}</span>
        <span v-else class="text-muted">Todas</span>
      </template>

      <template #cell-is_active="{ row }">
        <span :class="row.is_active ? 'badge bg-success' : 'badge bg-secondary'">
          {{ row.is_active ? 'Activo' : 'Inactivo' }}
        </span>
      </template>

      <template #cell-actions="{ row }">
        <MemberTableActions :actions="[
          { label: 'Clonar', icon: 'bi bi-copy', onClick: () => cloneProduct(row) },
          { label: 'Editar', icon: 'bi bi-pencil', onClick: () => router.get(`/member/listings/${listing?.id}/products/${row.id}/edit`) },
          { label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => deleteProduct(row) }
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

const props = defineProps({
  selectedCategory: [Number, String],
})

const page = usePage()
const listing = computed(() => page.props.listing)
const dataTable = computed(() => page.props.dataTable)
const categories = computed(() => page.props.categories || [])
const businessMenu = computed(() => page.props.businessMenu || [])

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Productos' },
])

const columns = [
  { key: 'checkbox', label: '', sortable: false, width: '40px' },
  { key: 'image', label: '', sortable: false, width: '60px' },
  { key: 'name', label: 'Nombre', sortable: true },
  { key: 'category', label: 'Categoria', sortable: false },
  { key: 'price', label: 'Precio', sortable: true },
  { key: 'quantity', label: 'Stock', sortable: true },
  { key: 'location', label: 'Ubicacion', sortable: false },
  { key: 'is_active', label: 'Estado', sortable: true },
  { key: 'actions', label: 'Acciones', sortable: false },
]

const dataTableRef = ref(null)
const deleting = ref(null)
const cloning = ref(null)
const perPage = ref(10)
const selectedIds = ref([])
const filterCategory = ref(props.selectedCategory)

const selectedCategoryName = computed(() => {
  if (!filterCategory.value) return null
  const cat = categories.value.find(c => c.id === filterCategory.value)
  return cat?.name
})

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

const filterProducts = () => {
  let url = `/member/listings/${listing.value.id}/products`
  if (filterCategory.value) {
    url += `?category=${filterCategory.value}`
  }
  window.location.href = url
}

const clearFilter = () => {
  filterCategory.value = null
  window.location.href = `/member/listings/${listing.value.id}/products`
}

const deleteProduct = (product) => {
  if (confirm(`Eliminar el producto "${product.name}"?`)) {
    deleting.value = product.id
    router.delete(`/member/listings/${listing.value.id}/products/${product.id}`, {
      preserveScroll: true,
      onFinish: () => {
        deleting.value = null
        if (dataTableRef.value) {
          dataTableRef.value.reload()
        }
      },
    })
  }
}

const cloneProduct = (product) => {
  if (confirm(`Clonar el producto "${product.name}"?`)) {
    cloning.value = product.id
    router.post(`/member/listings/${listing.value.id}/products/${product.id}/clone`, {}, {
      preserveScroll: true,
      onFinish: () => {
        cloning.value = null
      },
    })
  }
}
</script>
