<template>
  <MemberLayout>
    <Head title="Editar galeria" />

    <PageHeader
      title="Editar galeria"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing?.id || ''}/galleries`"
    />

    <form @submit.prevent="submit">
      <div class="card">
        <div class="card-header bg-transparent border-bottom pb-2 pt-2 d-flex justify-content-between align-items-center">
          <h6 class="text-uppercase text-muted mb-0 fw-normal">
            <i class="bi bi-pencil-square me-1"></i>Editar galeria
          </h6>
          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="gallery-active" v-model="form.is_active" :disabled="isPrimary">
            <label class="form-check-label" for="gallery-active">Activa</label>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
              <FieldText
                id="gallery-name"
                label="Nombre"
                v-model="form.name"
                :formError="form.errors.name"
                :readonly="isPrimary"
                required
              />
              <small v-if="isPrimary" class="text-muted">La galeria principal siempre se llama "Galeria principal".</small>
            </div>

            <div class="col-12 col-md-6 d-flex align-items-end">
              <FieldSwitch
                id="gallery-primary"
                label="Marcar como galeria principal"
                v-model="form.is_primary"
                :disabled="isPrimary"
              />
            </div>

            <div class="col-12">
              <FieldTextarea
                id="gallery-description"
                label="Descripcion"
                v-model="form.description"
                :formError="form.errors.description"
                :rows="2"
              />
            </div>

            <div class="col-12 col-md-4">
              <FieldNumber
                id="gallery-sort"
                label="Orden"
                v-model="form.sort_order"
                :formError="form.errors.sort_order"
                :min="0"
              />
            </div>
          </div>
        </div>
        <div class="card-footer bg-transparent border-top pt-3 pb-3 d-flex justify-content-between align-items-center">
          <button type="button" class="btn btn-danger rounded-pill py-2" @click="deleteGallery">
            <i class="bi bi-trash me-1"></i>Eliminar
          </button>
            <FormActions
              :submitText="'Guardar'"
              :submittingText="'Guardando...'"
              :cancelHref="`/member/listings/${listing?.id || ''}/galleries`"
              :sending="form.processing"
            />
        </div>
      </div>
    </form>
  </MemberLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head, Link, useForm, usePage, router } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FieldNumber from '@/Components/Fields/FieldNumber.vue'
import FieldSwitch from '@/Components/Fields/FieldSwitch.vue'
import FormActions from '@/Components/FormActions.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const gallery = computed(() => page.props.gallery)
const businessMenu = computed(() => page.props.businessMenu || [])

const isPrimary = computed(() => !!gallery.value?.is_primary)

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Galería', href: `/member/listings/${listing.value?.id}/galleries` },
  { label: gallery.value?.name || 'Editar' },
])

const form = useForm({
  name: gallery.value?.name,
  description: gallery.value?.description || '',
  is_primary: !!gallery.value?.is_primary,
  is_active: !!gallery.value?.is_active,
  sort_order: gallery.value?.sort_order || 0,
})

const submit = () => {
  form.put(`/member/listings/${listing.value.id}/galleries/${gallery.value.id}`)
}

const deleteGallery = () => {
  if (!confirm(`Eliminar la galeria "${gallery.value?.name}"?`)) return
  router.delete(`/member/listings/${listing.value.id}/galleries/${gallery.value.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      window.location.href = `/member/listings/${listing.value.id}/galleries`
    },
  })
}
</script>