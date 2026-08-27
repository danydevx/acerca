<template>
  <MemberLayout>
    <Head :title="`${listing.name} - Presets de Chatbot`" />
    <PageHeader
      title="Presets de Chatbot"
      :breadcrumbs="breadcrumbs"
    >
      <template #actions>
        <Link :href="`/member/listings/${listing.id}/ai-chatbot`" class="btn btn-outline-secondary me-2">
          <i class="bi bi-arrow-left me-1"></i>Volver
        </Link>
        <Link :href="`/member/listings/${listing.id}/ai-chatbot/presets/create`" class="btn btn-primary btn-sm">
          <i class="bi bi-plus-lg me-1"></i>Nuevo Preset
        </Link>
      </template>
    </PageHeader>

    <div v-if="$page.props.flash?.success" class="alert alert-success alert-dismissible fade show" role="alert">
      {{ $page.props.flash.success }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Personalidad</th>
                <th scope="col">Idioma</th>
                <th scope="col">Estado</th>
                <th scope="col" class="text-end">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="allPresets.length === 0">
                <td colspan="5" class="text-center text-muted py-4">
                  No tienes presets creados.
                  <Link :href="`/member/listings/${listing.id}/ai-chatbot/presets/create`" class="text-primary">
                    Crear el primero
                  </Link>
                </td>
              </tr>
              <tr v-for="preset in allPresets" :key="preset.id">
                <td>
                  <div class="fw-semibold">{{ preset.name }}</div>
                  <small class="text-muted">{{ preset.description?.substring(0, 60) || '' }}...</small>
                </td>
                <td>
                  <span class="badge text-bg-info">{{ preset.personality }}</span>
                </td>
                <td>
                  <span class="badge text-bg-secondary">{{ preset.language?.toUpperCase() }}</span>
                </td>
                <td>
                  <span :class="preset.is_active ? 'badge bg-success' : 'badge bg-secondary'">
                    {{ preset.is_active ? 'Activo' : 'Inactivo' }}
                  </span>
                </td>
                <td class="text-end">
                  <div class="actions d-inline-flex gap-1">
                    <Link
                      :href="`/member/listings/${listing.id}/ai-chatbot/presets/${preset.id}/edit`"
                      class="btn btn-sm btn-outline-primary"
                    >
                      <i class="bi bi-pencil"></i>
                    </Link>
                    <button
                      type="button"
                      class="btn btn-sm btn-outline-secondary"
                      @click="duplicatePreset(preset)"
                      title="Duplicar"
                    >
                      <i class="bi bi-copy"></i>
                    </button>
                    <button
                      v-if="!preset.is_system"
                      type="button"
                      class="btn btn-sm btn-outline-danger"
                      @click="deletePreset(preset)"
                    >
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </MemberLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'

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
