<template>
  <MemberLayout>
    <Head :title="`Nuevo Contacto - ${listing.name}`" />

    <PageHeader
      title="Nuevo Contacto"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing.id}/leads`"
    />

    <form @submit.prevent="submit">
        <div class="card">
          <div class="card-header bg-transparent border-bottom pb-2 pt-2 d-flex justify-content-between align-items-center">
            <h6 class="text-uppercase text-muted mb-0 fw-normal">
              <i class="bi bi-plus-circle me-1"></i>Crear nuevo lead
            </h6>
            <div class="form-check form-switch mb-0">
              <input class="form-check-input" type="checkbox" id="lead-active" v-model="form.is_active">
              <label class="form-check-label" for="lead-active">Activo</label>
            </div>
          </div>
          <div class="card-body">
            <div class="row g-3 mb-3">
            <div class="col-md-6">
              <FieldText
                id="name"
                label="Nombre"
                v-model="form.name"
                :formError="errors.name"
                required
              />
            </div>

            <div class="col-md-6">
              <FieldEmail
                id="email"
                label="Email"
                v-model="form.email"
                :formError="errors.email"
                required
              />
            </div>

            <div class="col-md-6">
              <FieldPhone
                id="phone"
                label="Telefono"
                v-model="form.phone"
              />
            </div>

            <div class="col-md-6">
              <FieldSelect
                id="business_location_id"
                label="Ubicacion"
                v-model="form.business_location_id"
              >
                <option :value="null">Sin ubicacion</option>
                <option v-for="loc in locations" :key="loc.id" :value="loc.id">{{ loc.name }}</option>
              </FieldSelect>
            </div>

            <div class="col-md-6">
              <FieldSelect
                id="source"
                label="Fuente"
                v-model="form.source"
              >
                <option value="">Seleccionar...</option>
                <option value="manual">Manual</option>
                <option value="website">Website</option>
                <option value="phone">Telefono</option>
                <option value="walk_in">Visita directa</option>
                <option value="referral">Referido</option>
                <option value="social_media">Redes sociales</option>
                <option value="other">Otro</option>
              </FieldSelect>
            </div>

            <div class="col-12">
              <FieldTextarea
                id="notes"
                label="Notas"
                v-model="form.notes"
                :rows="3"
                placeholder="Notas adicionales..."
              />
            </div>
            </div>
            </div>
          <div class="card-footer bg-transparent border-top pt-3 pb-3">
            <FormActions
              :submitText="'Guardar'"
              :submittingText="'Guardando...'"
              :cancelHref="`/member/listings/${listing.id}/leads`"
              :sending="sending"
            />
          </div>
        </div>
      </form>
    </MemberLayout>
</template>

<script setup>
import { computed, reactive, ref } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import { toast } from 'vue3-toastify'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldEmail from '@/Components/Fields/FieldEmail.vue'
import FieldPhone from '@/Components/Fields/FieldPhone.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FormActions from '@/Components/FormActions.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const locations = computed(() => page.props.locations || [])
const businessMenu = computed(() => page.props.businessMenu || [])

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Leads', href: `/member/listings/${listing.value.id}/leads` },
  { label: 'Nuevo' },
])

const sending = ref(false)

const form = reactive({
  name: '',
  email: '',
  phone: '',
  notes: '',
  business_location_id: null,
  source: '',
  is_active: true,
})

const errors = reactive({
  name: '',
  email: '',
  phone: '',
  notes: '',
  business_location_id: '',
  source: '',
})

const validateForm = () => {
  let isValid = true

  errors.name = ''
  errors.email = ''
  errors.phone = ''
  errors.business_location_id = ''
  errors.source = ''

  if (!form.name || form.name.trim() === '') {
    errors.name = 'El nombre es obligatorio.'
    isValid = false
  } else if (form.name.length > 150) {
    errors.name = 'El nombre no puede tener más de 150 caracteres.'
    isValid = false
  }

  if (!form.email || form.email.trim() === '') {
    errors.email = 'El email es obligatorio.'
    isValid = false
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
    errors.email = 'El email no es válido.'
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
  router.post(`/member/listings/${listing.value.id}/leads`, form, {
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
