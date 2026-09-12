<template>
  <MemberLayout>
    <Head :title="`Proyectos - ${listing?.name || ''}`" />

    <PageHeader
      title="Proyectos"
      :breadcrumbs="breadcrumbs"
      :backHref="'/member/listings'"
    >
      <template #actions>
        <Link :href="`/member/listings/${listing?.id}/project-categories`" class="btn btn-secondary rounded-pill">
          <i class="bi bi-folder me-1"></i>Categorias
        </Link>
        <Link :href="`/member/listings/${listing?.id}/projects/create`" class="btn btn-primary rounded-pill">
          <i class="bi bi-plus-lg me-1"></i>
          Nuevo Proyecto
        </Link>
      </template>
    </PageHeader>

    <div class="row mb-3 align-items-center">
      <div class="col">
        <div class="d-flex gap-2 align-items-center flex-wrap">
          <select v-model="filterCategory" class="form-select form-select-sm" @change="filterProjects" style="max-width: 200px;">
            <option :value="null">Todas las categorias</option>
            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
          </select>
          <button v-if="filterCategory" type="button" class="btn btn-secondary rounded-pill" @click="clearFilter">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
      </div>
    </div>

    <BaseDataTable
      ref="dataTableRef"
      :endpoint="`/member/listings/${listing?.id}/projects`"
      :columns="columns"
      :initial-data="dataTable"
      :initial-per-page="perPage"
      :reorderable="true"
      :reorder-endpoint="`/member/listings/${listing?.id}/projects/reorder`"
      search-placeholder="Buscar proyectos..."
      empty-title="No hay proyectos"
      :empty-text="selectedCategoryName ? `No hay proyectos en la categoria '${selectedCategoryName}'.` : 'Comienza creando tu primer proyecto.'"
      @updated="onDataTableUpdated"
    >
      <template #header-actions>
        <BulkSelect
          v-model:selectedIds="selectedIds"
          :current-page-ids="currentPageIds"
          :delete-endpoint="`/member/listings/${listing?.id}/projects/bulk-delete`"
          item-name="proyectos"
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
        <div v-else class="bg-secondary-subtle rounded d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
          <i class="bi bi-image text-muted"></i>
        </div>
      </template>

      <template #cell-title="{ row }">
        <strong>{{ row.title }}</strong>
        <p v-if="row.description" class="text-muted small mb-0">{{ row.description.substring(0, 60) }}...</p>
        <div v-if="row.tags && row.tags.length" class="mt-1">
          <span v-for="tag in row.tags.slice(0, 3)" :key="tag" class="badge bg-secondary-subtle text-dark me-1" style="font-size: 0.65rem;">{{ tag }}</span>
          <span v-if="row.tags.length > 3" class="badge bg-secondary" style="font-size: 0.65rem;">+{{ row.tags.length - 3 }}</span>
        </div>
      </template>

      <template #cell-category="{ row }">
        <span v-if="row.category">{{ row.category.name }}</span>
        <span v-else class="text-muted">-</span>
      </template>

      <template #cell-is_featured="{ row }">
        <span v-if="row.is_featured" class="badge bg-warning text-dark">Destacado</span>
      </template>

      <template #cell-is_active="{ row }">
        <span :class="row.is_active ? 'badge bg-success' : 'badge bg-secondary'">
          {{ row.is_active ? 'Activo' : 'Inactivo' }}
        </span>
      </template>

      <template #cell-actions="{ row }">
        <MemberTableActions :actions="getRowActions(row)" />
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
import MemberTableActions from '@/Components/Member/MemberTableActions.vue'
import { BulkSelect, BulkSelectRowCheckbox } from '@/Components/BulkSelect'

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
  { label: 'Proyectos' },
])

const columns = [
  { key: 'checkbox', label: '', sortable: false, width: '40px' },
  { key: 'image', label: '', sortable: false, width: '60px' },
  { key: 'title', label: 'Titulo', sortable: true },
  { key: 'category', label: 'Categoria', sortable: false },
  { key: 'is_featured', label: '', sortable: false },
  { key: 'is_active', label: 'Estado', sortable: true },
  { key: 'actions', label: 'Acciones', sortable: false },
]

const dataTableRef = ref(null)
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

const filterProjects = () => {
  let url = `/member/listings/${listing.value.id}/projects`
  if (filterCategory.value) {
    url += `?category=${filterCategory.value}`
  }
  window.location.href = url
}

const clearFilter = () => {
  filterCategory.value = null
  window.location.href = `/member/listings/${listing.value.id}/projects`
}

const getRowActions = (row) => {
  return [
    { label: 'Clonar', icon: 'bi bi-copy', onClick: () => cloneProject(row) },
    { label: 'Editar', icon: 'bi bi-pencil', onClick: () => router.get(`/member/listings/${listing.value.id}/projects/${row.id}/edit`) },
    { label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => deleteProject(row) },
  ]
}

const deleteProject = (project) => {
  if (confirm(`Eliminar el proyecto "${project.title}"?`)) {
    router.delete(`/member/listings/${listing.value.id}/projects/${project.id}`, {
      preserveScroll: true,
      onFinish: () => {
        if (dataTableRef.value) {
          dataTableRef.value.reload()
        }
      },
    })
  }
}

const cloneProject = (project) => {
  if (confirm(`Clonar el proyecto "${project.title}"?`)) {
    cloning.value = project.id
    router.post(`/member/listings/${listing.value.id}/projects/${project.id}/clone`, {}, {
      preserveScroll: true,
      onFinish: () => {
        cloning.value = null
      },
    })
  }
}
</script>
