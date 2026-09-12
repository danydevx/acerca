<template>
  <MemberLayout>
    <Head :title="`${listing.name} - Presets de Chatbot`" />
    <PageHeader
      title="Presets de Chatbot"
      :breadcrumbs="breadcrumbs"
    >
      <template #actions>
        <Link :href="`/member/listings/${listing.id}/ai-chatbot`" class="btn btn-secondary rounded-pill me-2">
          <i class="bi bi-arrow-left me-1"></i>Volver
        </Link>
        <Link :href="`/member/listings/${listing.id}/ai-chatbot/presets/create`" class="btn btn-primary rounded-pill">
          <i class="bi bi-plus-lg me-1"></i>Nuevo Preset
        </Link>
      </template>
    </PageHeader>

    <div v-if="$page.props.flash?.success" class="alert alert-success alert-dismissible fade show" role="alert">
      {{ $page.props.flash.success }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <MemberTable
      :items="allPresets"
      :columns="columns"
      :get-row-actions="getRowActions"
      empty-title="No tienes presets creados"
      empty-text="Crea tu primer preset para el chatbot."
      :show-pagination="false"
    >
      <template #cell-name="{ row }">
        <div class="fw-semibold">{{ row.name }}</div>
        <small class="text-muted">{{ row.description?.substring(0, 60) || '' }}...</small>
      </template>
      <template #cell-personality="{ row }">
        <span class="badge text-bg-info">{{ row.personality }}</span>
      </template>
      <template #cell-language="{ row }">
        <span class="badge text-bg-secondary">{{ row.language?.toUpperCase() }}</span>
      </template>
      <template #cell-is_active="{ row }">
        <span :class="row.is_active ? 'badge bg-success' : 'badge bg-secondary'">
          {{ row.is_active ? 'Activo' : 'Inactivo' }}
        </span>
      </template>
    </MemberTable>
  </MemberLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import MemberTable from '@/Components/Member/MemberTable.vue'

const page = usePage()
const listing = page.props.listing
const globalPresets = page.props.globalPresets || []
const businessPresets = page.props.listingPresets || []

const allPresets = computed(() => [...globalPresets, ...businessPresets])

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Chatbot', href: `/member/listings/${listing?.id}/ai-chatbot` },
  { label: 'Presets', active: true },
])

const columns = [
  { key: 'name', label: 'Nombre', sortable: false },
  { key: 'personality', label: 'Personalidad', sortable: false },
  { key: 'language', label: 'Idioma', sortable: false },
  { key: 'is_active', label: 'Estado', sortable: false },
  { key: 'actions', label: '', sortable: false, class: 'text-end' },
]

const getRowActions = (preset) => {
  const actions = [
    {
      label: 'Editar',
      icon: 'bi bi-pencil',
      onClick: () => router.get(`/member/listings/${listing.id}/ai-chatbot/presets/${preset.id}/edit`),
    },
    {
      label: 'Duplicar',
      icon: 'bi bi-copy',
      onClick: () => duplicatePreset(preset),
    },
  ]
  if (!preset.is_system) {
    actions.push({
      label: 'Eliminar',
      icon: 'bi bi-trash',
      danger: true,
      onClick: () => deletePreset(preset),
    })
  }
  return actions
}

const duplicatePreset = (preset) => {
  if (confirm(`¿Duplicar el preset "${preset.name}"?`)) {
    router.post(`/member/listings/${listing.id}/ai-chatbot/presets/${preset.id}/duplicate`, {}, {
      preserveScroll: true,
    })
  }
}

const deletePreset = (preset) => {
  if (confirm(`¿Eliminar el preset "${preset.name}"?`)) {
    router.delete(`/member/listings/${listing.id}/ai-chatbot/presets/${preset.id}`, {
      preserveScroll: true,
    })
  }
}
</script>
