<template>
  <MemberLayout>
    <Head title="Galerías" />

    <PageHeader
      title="Galerías"
      :breadcrumbs="breadcrumbs"
      :backHref="'/member/listings'"
    >
      <template #actions>
        <Link :href="`/member/listings/${listing?.id}/galleries/create`" class="btn btn-primary rounded-pill">
          <i class="bi bi-plus-lg me-1"></i>
          Nueva galería
        </Link>
      </template>
    </PageHeader>

    <div class="py-3">
      <div v-if="galleries.length === 0" class="alert alert-info">
        No hay galerías creadas. Crea tu primera galería para empezar.
      </div>

      <div class="row g-3">
        <div v-for="gallery in galleries" :key="gallery.id" class="col-12 col-md-6 col-lg-4">
          <div class="card h-100">
            <div v-if="gallery.thumbnails && gallery.thumbnails.length > 0" class="card-img-top d-flex gap-1 p-2" style="background: #f8f9fa; max-height: 120px;">
              <img
                v-for="(thumb, idx) in gallery.thumbnails.slice(0, 4)"
                :key="thumb.id"
                :src="thumb.path"
                class="rounded object-fit-cover"
                style="width: 80px; height: 80px;"
                :alt="gallery.name"
              />
              <span v-if="gallery.images_count > 4" class="d-flex align-items-center justify-content-center text-muted small bg-light rounded" style="width: 80px; height: 80px;">
                +{{ gallery.images_count - 4 }}
              </span>
            </div>
            <div class="card-header d-flex justify-content-between align-items-center">
              <div class="text-truncate">
                <span :class="{ 'text-muted': !gallery.is_active }">
                  <strong class="text-truncate">{{ gallery.name }}</strong>
                  <span v-if="gallery.is_primary" class="badge bg-primary ms-2">Principal</span>
                  <span v-if="!gallery.is_active" class="badge bg-secondary ms-2">Inactiva</span>
                </span>
                <small class="text-muted d-block">{{ gallery.images_count }} imágenes</small>
              </div>
              <MemberTableActions :actions="getGalleryActions(gallery)" />
            </div>
            <div class="card-body py-2">
              <p v-if="gallery.description" class="text-muted small mb-0 text-truncate">{{ gallery.description }}</p>
            </div>
            <div class="card-footer bg-transparent py-2">
              <Link :href="`/member/listings/${listing?.id}/gallery/${gallery.id}`" class="btn btn-sm btn-link text-decoration-none">
                <i class="bi bi-images me-1"></i>Ver imágenes
              </Link>
            </div>
          </div>
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
import MemberTableActions from '@/Components/Member/MemberTableActions.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const galleries = computed(() => page.props.galleries || [])
const businessMenu = computed(() => page.props.businessMenu || [])

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Galerías' },
])

const getGalleryActions = (gallery) => {
  const actions = [
    { label: 'Editar', icon: 'bi bi-pencil', onClick: () => router.get(`/member/listings/${listing.value.id}/galleries/${gallery.id}/edit`) },
  ]
  if (!gallery.is_primary) {
    actions.push({ label: 'Marcar Principal', icon: 'bi bi-star', onClick: () => setPrimary(gallery) })
  }
  actions.push({ label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => confirmDestroy(gallery) })
  return actions
}

const setPrimary = (gallery) => {
  if (confirm(`Marcar "${gallery.name}" como galería principal?`)) {
    router.post(`/member/listings/${listing.value.id}/galleries/${gallery.id}/set-primary`)
  }
}

const confirmDestroy = (gallery) => {
  if (confirm(`Eliminar "${gallery.name}"? Sus imágenes también se eliminarán.`)) {
    router.delete(`/member/listings/${listing.value.id}/galleries/${gallery.id}`)
  }
}
</script>
