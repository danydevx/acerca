<template>
  <MemberLayout>
    <Head :title="listing ? `Productos - ${listing.name}` : 'Productos'" />

    <PageHeader
      title="Menu del Restaurant"
      :breadcrumbs="breadcrumbs"
      :backHref="'/member/listings'"
    >
      <template #description>
        <p class="text-muted mb-0">Gestiona los productos de tu menu. Arrastra para reordenar.</p>
      </template>
      <template #filters>
        <div class="d-flex gap-2 align-items-center">
          <input
            type="text"
            class="form-control form-control-sm"
            v-model="searchQuery"
            placeholder="Buscar..."
            @keyup.enter="filterProducts"
            style="max-width: 160px;"
          />
          <select v-model="filterCategory" class="form-select form-select-sm" @change="filterProducts" style="max-width: 180px;">
            <option :value="null">Todas las categorias</option>
            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.title }}</option>
          </select>
          <button v-if="filterCategory || searchQuery" type="button" class="btn btn-secondary rounded-pill" @click="clearFilters">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
      </template>
      <template #tabs>
        <div class="dropdown">
          <button class="btn btn-secondary rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="bi bi-cup-hot me-1"></i>Menú
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <Link :href="`/member/listings/${listing?.id}/menu-products`" class="dropdown-item active">
                <i class="bi bi-cup-hot me-2"></i>Productos
              </Link>
            </li>
            <li>
              <Link :href="`/member/listings/${listing?.id}/menu-categories`" class="dropdown-item">
                <i class="bi bi-folder me-2"></i>Categorías
              </Link>
            </li>
          </ul>
        </div>
      </template>
      <template #actions>
        <Link :href="`/member/listings/${listing?.id}/menu-products/create`" class="btn btn-primary rounded-pill">
          <i class="bi bi-plus-lg me-1"></i>Nuevo Producto
        </Link>
      </template>
    </PageHeader>

    <div v-if="$page.props.flash?.success" class="alert alert-success alert-dismissible fade show" role="alert">
      {{ $page.props.flash.success }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <SortableCards
      ref="sortableCardsRef"
      :items="productsList"
      item-class="col-6 col-md-4 col-lg-2"
      :reorderable="true"
      :reorder-endpoint="`/member/listings/${listing?.id}/menu-products/reorder`"
      :loading="loading"
      empty-title="No hay productos"
      :empty-text="selectedCategoryName ? 'No hay productos en esta categoria.' : 'Comienza creando tu primer producto.'"
      toast-message="Orden actualizado"
      @reordered="onReordered"
    >
      <template #item="{ item: product }">
        <div class="sortable-cards__checkbox">
          <BulkSelectRowCheckbox
            :id="product.id"
            v-model:selectedIds="selectedIds"
          />
        </div>
        <div class="card-img-top ratio ratio-4x3 bg-light d-flex align-items-center justify-content-center overflow-hidden">
          <img
            v-if="product.image"
            :src="product.image"
            :alt="product.title"
            class="w-100 h-100"
            style="object-fit: cover;"
          />
          <img
            v-else
            src="https://placehold.co/400x300/e9ecef/868e96?text=Sin+imagen"
            :alt="product.title"
            class="w-100 h-100"
            style="object-fit: cover;"
          />
        </div>
        <div class="card-body py-2">
          <h6 class="card-title mb-1 text-truncate">{{ product.title }}</h6>
          <p class="card-text small text-muted mb-1 text-truncate">{{ product.category?.title }}</p>
          <div class="d-flex justify-content-between align-items-center">
            <span v-if="product.show_price && product.display_price" class="fw-bold small">${{ product.display_price }}</span>
            <span v-else-if="product.show_price && product.variants?.length" class="fw-bold small">Desde ${{ product.variants[0].price }}</span>
            <span v-else class="text-muted small">-</span>
            <span v-if="product.featured" class="badge bg-warning badge-sm">Dest.</span>
          </div>
        </div>
        <div class="card-footer bg-transparent py-1">
          <div class="d-flex gap-1">
            <button @click="cloneProduct(product)" class="btn btn-secondary rounded-pill">
              <i class="bi bi-copy"></i>
            </button>
            <Link :href="`/member/listings/${listing?.id}/menu-products/${product.id}/edit`" class="btn btn-info rounded-pill flex-grow-1">
              <i class="bi bi-pencil"></i>
            </Link>
            <button @click="deleteProduct(product)" class="btn btn-danger rounded-pill">
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </div>
      </template>
    </SortableCards>

    <div v-if="products.total > products.per_page" class="d-flex justify-content-center mt-4">
      <Pagination :links="products.links" />
    </div>
  </MemberLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import SortableCards from '@/Components/DataTable/SortableCards.vue'
import Pagination from '@/Components/Member/Pagination.vue'
import { BulkSelect, BulkSelectRowCheckbox } from '@/Components/BulkSelect'

const props = defineProps({
  listing: Object,
  products: Object,
  categories: Array,
  selectedCategory: [Number, String],
  searchQuery: String,
})

const page = usePage()
const listing = computed(() => page.props.listing)
const businessMenu = computed(() => page.props.businessMenu || [])

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Menú' },
])

const sortableCardsRef = ref(null)

const loading = ref(false)
const filterCategory = ref(props.selectedCategory)
const searchQuery = ref(props.searchQuery || '')
const selectedIds = ref([])

const productsList = computed(() => {
  if (!props.products) return []
  if (Array.isArray(props.products)) return props.products
  if (Array.isArray(props.products.data)) return props.products.data
  return []
})

const currentPageIds = computed(() => {
  return productsList.value.map(p => p.id)
})

const selectedCategoryName = computed(() => {
  if (!filterCategory.value) return null
  if (filterCategory.value === 'uncategorized') return 'Sin categoria'
  const cat = props.categories.find(c => c.id === filterCategory.value)
  return cat?.title
})

const onReordered = (ids) => {
  console.log('Reordered:', ids)
}

const onBulkDeleted = () => {
  if (sortableCardsRef.value) {
    sortableCardsRef.value.reload()
  }
}

const filterProducts = () => {
  let url = `/member/listings/${props.listing.id}/menu-products`
  const params = []
  if (filterCategory.value) {
    if (filterCategory.value === 'uncategorized') {
      params.push('uncategorized=1')
    } else {
      params.push(`category=${filterCategory.value}`)
    }
  }
  if (searchQuery.value) {
    params.push(`search=${encodeURIComponent(searchQuery.value)}`)
  }
  if (params.length > 0) {
    url += '?' + params.join('&')
  }
  window.location.href = url
}

const clearFilters = () => {
  filterCategory.value = null
  searchQuery.value = ''
  window.location.href = `/member/listings/${props.listing.id}/menu-products`
}

const deleteProduct = (product) => {
  if (!confirm(`Eliminar el producto "${product.title}"?`)) return

  router.delete(`/member/listings/${props.listing.id}/menu-products/${product.id}`, {
    preserveScroll: true,
  })
}

const cloneProduct = (product) => {
  if (!confirm(`Clonar el producto "${product.title}"?`)) return

  router.post(`/member/listings/${props.listing.id}/menu-products/${product.id}/clone`, {
    preserveScroll: true,
  })
}
</script>

<style scoped>
.sortable-cards__checkbox {
  position: absolute;
  top: 8px;
  left: 8px;
  z-index: 20;
}

.form-check-input {
  cursor: pointer;
  width: 1.2em;
  height: 1.2em;
}

.sortable-cards__item {
  position: relative;
}
</style>
