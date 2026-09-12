<template>
  <MemberLayout>
    <Head :title="`Editar Puesto - ${listing?.name || ''}`" />

    <PageHeader
      title="Editar Puesto"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing?.id}/team-member-positions`"
    />

    <form @submit.prevent="submit">
      <div class="card">
        <div class="card-header bg-transparent border-bottom pb-3 pt-3 d-flex justify-content-between align-items-center">
          <h5 class="text-uppercase text-muted mb-0 fw-normal">
            <i class="bi bi-pencil-square me-2"></i>Editar puesto
          </h5>
          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="position-active" v-model="form.is_active">
            <label class="form-check-label" for="position-active">Activo</label>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-12">
              <FieldText
                id="position-name"
                label="Nombre del puesto"
                placeholder="Ej: Recepcionista"
                v-model="form.name"
                :formError="form.errors.name"
                required
              />
            </div>

            <div class="col-12">
              <FieldSelect
                id="position-parent"
                label="Puesto padre (opcional)"
                v-model="form.parent_id"
                :options="parentPositionOptions"
                :formError="form.errors.parent_id"
              />
            </div>

            <div class="col-12">
              <FieldTextarea
                id="position-description"
                label="Descripción (opcional)"
                placeholder="Describe las responsabilidades del puesto"
                v-model="form.description"
                :formError="form.errors.description"
                rows="3"
              />
            </div>
          </div>
        </div>
        <div class="card-footer bg-transparent border-top pt-3 pb-3">
          <div class="d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-danger rounded-pill py-2" @click="deletePosition">
              <i class="bi bi-trash me-1"></i>Eliminar
            </button>
            <FormActions
              :submitText="'Guardar'"
              :submittingText="'Guardando...'"
              :cancelHref="`/member/listings/${listing?.id}/team-member-positions`"
              :sending="form.processing"
            />
          </div>
        </div>
      </div>
    </form>
  </MemberLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head, Link, usePage } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FormActions from '@/Components/FormActions.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const position = computed(() => page.props.position)
const parentPositions = computed(() => page.props.parentPositions || [])
const businessMenu = computed(() => page.props.businessMenu || [])

const parentPositionOptions = computed(() => {
  const options = parentPositions.value.map(p => ({
    value: p.id,
    label: p.name,
  }))
  return [{ value: '', label: 'Sin puesto padre' }, ...options]
})

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Mi Equipo', href: `/member/listings/${listing.value?.id}/team-members` },
  { label: 'Puestos', href: `/member/listings/${listing.value?.id}/team-member-positions` },
  { label: position.value?.name || 'Editar' },
])

const form = useForm({
  name: position.value?.name || '',
  parent_id: position.value?.parent_id || '',
  description: position.value?.description || '',
  is_active: position.value?.is_active ?? true,
})

const submit = () => {
  form.put(`/member/listings/${listing.value.id}/team-member-positions/${position.value.id}`, {
    preserveScroll: true,
  })
}

const deletePosition = () => {
  if (!confirm(`Eliminar el puesto "${position.value?.name}"?`)) return
  router.delete(`/member/listings/${listing.value.id}/team-member-positions/${position.value.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      window.location.href = `/member/listings/${listing.value.id}/team-member-positions`
    },
  })
}
</script>
