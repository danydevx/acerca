<template>
  <MemberLayout>
    <Head :title="`Nuevo Puesto - ${listing?.name || ''}`" />

    <PageHeader
      title="Nuevo Puesto"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing?.id}/team-member-positions`"
    />

    <form @submit.prevent="submit">
      <div class="card">
        <div class="card-header bg-transparent border-bottom pb-3 pt-3 d-flex justify-content-between align-items-center">
          <h5 class="text-uppercase text-muted mb-0 fw-normal">
            <i class="bi bi-plus-circle me-2"></i>Crear nuevo puesto
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
                :formError="errors.name"
                required
              />
            </div>

            <div class="col-12">
              <FieldSelect
                id="position-parent"
                label="Puesto padre (opcional)"
                v-model="form.parent_id"
                :options="parentPositionOptions"
                :formError="errors.parent_id"
              />
            </div>

            <div class="col-12">
              <FieldTextarea
                id="position-description"
                label="Descripción (opcional)"
                placeholder="Describe las responsabilidades del puesto"
                v-model="form.description"
                :formError="errors.description"
                rows="3"
              />
            </div>
          </div>
        </div>
        <div class="card-footer bg-transparent border-top pt-3 pb-3">
            <FormActions
              :submitText="'Guardar'"
              :submittingText="'Guardando...'"
              :cancelHref="`/member/listings/${listing?.id}/team-member-positions`"
              :sending="sending"
            />
        </div>
      </div>
    </form>
  </MemberLayout>
</template>

<script setup>
import { computed, reactive, ref } from 'vue'
import { Head, Link, usePage, router } from '@inertiajs/vue3'
import { toast } from 'vue3-toastify'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FormActions from '@/Components/FormActions.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const parentPositions = computed(() => page.props.parentPositions || [])
const businessMenu = computed(() => page.props.businessMenu || [])

const parentPositionOptions = computed(() => {
  return [
    { value: '', label: 'Sin puesto padre' },
    ...parentPositions.value.map(p => ({
      value: p.id,
      label: p.name,
    }))
  ]
})

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Mi Equipo', href: `/member/listings/${listing.value?.id}/team-members` },
  { label: 'Puestos', href: `/member/listings/${listing.value?.id}/team-member-positions` },
  { label: 'Nuevo' },
])

const sending = ref(false)

const form = reactive({
  name: '',
  parent_id: null,
  description: '',
  is_active: true,
})

const errors = reactive({
  name: '',
  parent_id: '',
  description: '',
})

const validateForm = () => {
  let isValid = true

  errors.name = ''
  errors.parent_id = ''
  errors.description = ''

  if (!form.name || form.name.trim() === '') {
    errors.name = 'El nombre es obligatorio.'
    isValid = false
  } else if (form.name.length > 100) {
    errors.name = 'El nombre no puede tener más de 100 caracteres.'
    isValid = false
  }

  return isValid
}

const submit = () => {
  if (!validateForm()) {
    toast.warning('Por favor completa los campos requeridos')
    return
  }

  sending.value = true
  router.post(`/member/listings/${listing.value.id}/team-member-positions`, form, {
    preserveScroll: true,
    onSuccess: () => {
      sending.value = false
    },
    onError: (errs) => {
      sending.value = false
      Object.keys(errs).forEach(key => {
        if (key in errors) {
          errors[key] = errs[key]
        }
      })
      toast.warning('Por favor completa los campos requeridos')
    },
    onFinish: () => {
      sending.value = false
    },
  })
}
</script>
