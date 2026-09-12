<template>
  <MemberLayout>
    <Head :title="`Formularios de Contacto - ${listing?.name || ''}`" />

    <PageHeader
      title="Formularios de Contacto"
      :breadcrumbs="breadcrumbs"
      :backHref="'/member/listings'"
    >
      <template #actions>
        <Link
          v-if="canCreateMore"
          :href="`/member/listings/${listing?.id}/contact-forms/create`"
          class="btn btn-primary rounded-pill"
        >
          <i class="bi bi-plus me-1"></i>Nuevo Formulario
        </Link>
        <span v-else class="btn btn-secondary rounded-pill" disabled>
          Limite alcanzado ({{ dataTable.total }}/{{ maxForms }})
        </span>
      </template>
    </PageHeader>

    <div v-if="$page.props.flash?.error" class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ $page.props.flash.error }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <BaseDataTable
      ref="dataTableRef"
      :endpoint="`/member/listings/${listing?.id}/contact-forms/api`"
      :columns="columns"
      :initial-data="dataTable"
      search-placeholder="Buscar formularios..."
      empty-title="No hay formularios"
      empty-text="Crea tu primer formulario de contacto."
      @updated="onDataTableUpdated"
    >
      <template #header-actions>
        <BulkSelect
          v-model:selectedIds="selectedIds"
          :current-page-ids="currentPageIds"
          :delete-endpoint="`/member/listings/${listing?.id}/contact-forms/bulk-delete`"
          item-name="formularios"
          @deleted="onBulkDeleted"
        />
      </template>

      <template #cell-name="{ row }">
        <strong>{{ row.name }}</strong>
        <p v-if="row.description" class="text-muted small mb-0">{{ row.description }}</p>
      </template>

      <template #cell-shortcode="{ row }">
        <div class="d-flex align-items-center">
          <code class="small">{{ row.shortcode }}</code>
          <button class="btn btn-sm btn-link p-0 ms-1" @click="copyShortcode(row.shortcode)" title="Copiar">
            <i class="bi bi-clipboard"></i>
          </button>
        </div>
      </template>

      <template #cell-fields_count="{ row }">
        {{ row.fields_count }}
      </template>

      <template #cell-is_active="{ row }">
        <span :class="row.is_active ? 'badge bg-success' : 'badge bg-secondary'">
          {{ row.is_active ? 'Activo' : 'Inactivo' }}
        </span>
      </template>

      <template #cell-created_at="{ row }">
        {{ formatDate(row.created_at) }}
      </template>

      <template #cell-actions="{ row }">
        <MemberTableActions :actions="getRowActions(row)" />
      </template>
    </BaseDataTable>

    <div class="alert alert-info mt-4">
      <strong>Como usar:</strong>
      <p class="mb-1">Copia el shortcode y pegalo en cualquier pagina de tu minisitio usando el bloque de HTML.</p>
      <p class="mb-0 small text-muted">Ejemplo: <code>&lt;div data-contact-form="{{ dataTable.data[0]?.shortcode }}"&gt;&lt;/div&gt;</code></p>
    </div>
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

const props = defineProps({
  listing: Object,
  dataTable: {
    type: Object,
    default: () => ({ data: [], total: 0 }),
  },
  maxForms: {
    type: Number,
    default: 5,
  },
  canCreateMore: {
    type: Boolean,
    default: true,
  },
})

const page = usePage()
const listing = computed(() => page.props.listing)
const businessMenu = computed(() => page.props.businessMenu || [])

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Formularios', active: true },
])

const columns = [
  { key: 'checkbox', label: '', sortable: false, width: '40px' },
  { key: 'name', label: 'Nombre', sortable: true },
  { key: 'shortcode', label: 'Shortcode', sortable: false },
  { key: 'fields_count', label: 'Campos', sortable: false },
  { key: 'is_active', label: 'Estado', sortable: true },
  { key: 'created_at', label: 'Fecha', sortable: true },
  { key: 'actions', label: 'Acciones', sortable: false },
]

const dataTableRef = ref(null)
const selectedIds = ref([])

const currentPageIds = computed(() => {
  if (!props.dataTable?.data) return []
  return props.dataTable.data.map(row => row.id)
})

const onDataTableUpdated = () => {
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

const copyShortcode = (shortcode) => {
  navigator.clipboard.writeText(shortcode)
}

const getRowActions = (row) => {
  return [
    { label: 'Editar', icon: 'bi bi-pencil', onClick: () => router.get(`/member/listings/${listing.value.id}/contact-forms/${row.id}/edit`) },
    { label: 'Ver mensajes', icon: 'bi bi-envelope', onClick: () => router.get(`/member/listings/${listing.value.id}/contact-forms/${row.id}/submissions`) },
    { label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => deleteForm(row) },
  ]
}

const deleteForm = (row) => {
  if (confirm(`¿Eliminar el formulario "${row.name}"?`)) {
    router.delete(`/member/listings/${listing.value.id}/contact-forms/${row.id}`, {
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
