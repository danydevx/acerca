<template>
  <MemberLayout>
    <Head title="Ayuda" />

    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
      <div>
        <h1 class="h4 mb-1">Ayuda</h1>
        <p class="text-muted mb-0">Encuentra respuestas rapidas.</p>
      </div>
      <Link href="/member/support/create" class="btn btn-secondary rounded-pill">Crear ticket</Link>
    </div>

    <FilterBar
      :filters="['search', 'category']"
      :select-options="{
        category: categories.map(c => ({ value: c, label: c })),
      }"
      :values="filterValues"
      search-placeholder="Buscar en ayuda"
      @update="handleFilterUpdate"
      @clear="handleFilterClear"
    />

    <div class="row g-3">
      <div v-if="articles.data.length === 0" class="col-12">
        <div class="card border-0 shadow-sm">
          <div class="card-body text-center text-muted py-5">No hay articulos publicados.</div>
        </div>
      </div>

      <div v-for="article in articles.data" :key="article.id" class="col-12 col-lg-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="badge text-bg-secondary-subtle border">{{ article.category || 'General' }}</span>
              <span class="text-muted small">{{ article.published_at || '-' }}</span>
            </div>
            <h2 class="h5 mb-2">{{ article.title }}</h2>
            <p class="text-muted mb-3">{{ article.excerpt || 'Consulta el detalle del articulo.' }}</p>
              <Link :href="`/member/help/${article.slug}`" class="btn btn-info rounded-pill">Leer mas</Link>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between mt-3">
      <div class="text-muted small">
        Mostrando {{ articles.data.length }} de {{ articles.total }} registros
      </div>
      <Pagination :links="articles.links" />
    </div>
  </MemberLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import Pagination from '@/Components/Member/Pagination.vue'
import FilterBar from '@/Components/Member/FilterBar.vue'

const props = defineProps({
  articles: {
    type: Object,
    required: true,
  },
  categories: {
    type: Array,
    default: () => [],
  },
  filters: {
    type: Object,
    default: () => ({}),
  },
})

const filterValues = computed(() => ({
  search: props.filters.search || '',
  category: props.filters.category || '',
}))

const handleFilterUpdate = (values) => {
  router.get(
    '/member/help',
    { search: values.search || '', category: values.category || '' },
    { preserveState: true, replace: true, preserveScroll: true }
  )
}

const handleFilterClear = () => {
  handleFilterUpdate({ search: '', category: '' })
}
</script>
