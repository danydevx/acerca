<template>
  <MemberLayout>
    <Head :title="`${listing.name} - Personalidades de Chatbot`" />
    <PageHeader
      title="Personalidades de Chatbot"
      :breadcrumbs="breadcrumbs"
    >
      <template #actions>
        <Link :href="`/member/listings/${listing.id}/ai-chatbot`" class="btn btn-secondary rounded-pill me-2">
          <i class="bi bi-arrow-left me-1"></i>Volver
        </Link>
        <Link :href="`/member/listings/${listing.id}/ai-chatbot/personalities/create`" class="btn btn-primary rounded-pill">
          <i class="bi bi-plus-lg me-1"></i>Nueva Personalidad
        </Link>
      </template>
    </PageHeader>

    <div v-if="$page.props.flash?.success" class="alert alert-success alert-dismissible fade show" role="alert">
      {{ $page.props.flash.success }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <div class="app-datatable mb-4">
      <div class="app-datatable__header">
        <div>
          <h6 class="text-uppercase text-muted mb-0 fw-normal">
            <i class="bi bi-building me-1"></i>Personalidades del Negocio
          </h6>
          <small class="text-muted">Personalidades que puedes editar o eliminar</small>
        </div>
      </div>
      <div class="app-datatable__table-wrapper">
        <table class="app-datatable__table">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Key</th>
              <th scope="col">Descripción</th>
              <th scope="col">Estado</th>
              <th scope="col" class="text-end">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="businessPersonalities.length === 0">
              <td colspan="5" class="app-datatable__empty">
                No tienes personalidades creadas.
                <Link :href="`/member/listings/${listing.id}/ai-chatbot/personalities/create`" class="text-primary">
                  Crear la primera
                </Link>
              </td>
            </tr>
            <tr v-for="personality in businessPersonalities" :key="personality.id">
              <td>
                <div class="fw-semibold">{{ personality.display_name }}</div>
              </td>
              <td>
                <code>{{ personality.key }}</code>
              </td>
              <td>
                <small class="text-muted">{{ personality.description?.substring(0, 60) || '-' }}</small>
              </td>
              <td>
                <span :class="personality.is_active ? 'badge bg-success' : 'badge bg-secondary'">
                  {{ personality.is_active ? 'Activa' : 'Inactiva' }}
                </span>
              </td>
              <td class="text-end">
                <div class="actions d-inline-flex gap-1">
                  <Link
                    :href="`/member/listings/${listing.id}/ai-chatbot/personalities/${personality.id}/edit`"
                    class="btn btn-outline-secondary rounded-pill"
                  >
                    <i class="bi bi-pencil"></i>
                  </Link>
                  <button
                    type="button"
                    class="btn btn-outline-danger rounded-pill"
                    @click="deletePersonality(personality)"
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

    <div class="app-datatable">
      <div class="app-datatable__header">
        <div>
          <h6 class="text-uppercase text-muted mb-0 fw-normal">
            <i class="bi bi-globe me-1"></i>Personalidades Globales
          </h6>
          <small class="text-muted">Personalidades del sistema, solo lectura</small>
        </div>
      </div>
      <div class="app-datatable__table-wrapper">
        <table class="app-datatable__table">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Key</th>
              <th scope="col">Descripción</th>
              <th scope="col">Estado</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="personality in globalPersonalities" :key="personality.id">
              <td>
                <div class="fw-semibold">{{ personality.display_name }}</div>
              </td>
              <td>
                <code>{{ personality.key }}</code>
              </td>
              <td>
                <small class="text-muted">{{ personality.description?.substring(0, 60) || '-' }}</small>
              </td>
              <td>
                <span :class="personality.is_active ? 'badge bg-success' : 'badge bg-secondary'">
                  {{ personality.is_active ? 'Activa' : 'Inactiva' }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </MemberLayout>
</template>

<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'

const page = usePage()
const listing = page.props.listing
const businessPersonalities = page.props.businessPersonalities || []
const globalPersonalities = page.props.globalPersonalities || []

const breadcrumbs = [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Chatbot', href: `/member/listings/${listing?.id}/ai-chatbot` },
  { label: 'Personalidades', active: true },
]

const deletePersonality = (personality) => {
  if (confirm(`¿Eliminar la personalidad "${personality.display_name}"?`)) {
    router.delete(`/member/listings/${listing.id}/ai-chatbot/personalities/${personality.id}`, {
      preserveScroll: true,
    })
  }
}
</script>
