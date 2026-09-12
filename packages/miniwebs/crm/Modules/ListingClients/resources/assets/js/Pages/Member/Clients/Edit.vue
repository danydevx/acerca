<template>
  <MemberLayout>
    <Head :title="`Editar Cliente - ${listing.name}`" />

    <PageHeader
      title="Editar Cliente"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing.id}/clients`"
    />

    <form @submit.prevent="submit">
        <div class="card">
          <div class="card-header bg-transparent border-bottom pb-2 pt-2 d-flex justify-content-between align-items-center">
            <h6 class="text-uppercase text-muted mb-0 fw-normal">
              <i class="bi bi-pencil-square me-1"></i>Editar cliente
            </h6>
            <div class="form-check form-switch mb-0">
              <input class="form-check-input" type="checkbox" id="client-active" v-model="form.is_active">
              <label class="form-check-label" for="client-active">Activo</label>
            </div>
          </div>
          <div class="card-body">
            <div class="row g-3 mb-3">
          <div class="col-12 col-md-6">
            <FieldText
              id="client-customer-name"
              label="Nombre del cliente"
              v-model="form.customer_name"
              :formError="errors.customer_name"
              required
            />
          </div>

          <div class="col-12 col-md-6">
            <FieldText
              id="client-contact-person"
              label="Persona de contacto"
              v-model="form.contact_person"
              :formError="errors.contact_person"
            />
          </div>

          <div class="col-12 col-md-6">
            <FieldText
              id="client-company"
              label="Empresa o negocio"
              v-model="form.company_name"
              :formError="errors.company_name"
            />
          </div>

          <div class="col-12 col-md-6">
            <FieldWhatsapp
              id="client-whatsapp"
              label="WhatsApp"
              v-model="form.whatsapp"
              :countryValue="form.whatsapp_country"
              :formError="errors.whatsapp"
              @update:countryValue="form.whatsapp_country = $event"
            />
          </div>

          <div class="col-12 col-md-6">
            <FieldEmail
              id="client-email"
              label="Email"
              v-model="form.customer_email"
              :formError="errors.customer_email"
            />
          </div>

          <div class="col-12 col-md-6">
            <FieldPhone
              id="client-phone"
              label="Telefono"
              v-model="form.customer_phone"
              :formError="errors.customer_phone"
            />
          </div>

          <div class="col-12 col-md-6">
            <FieldText
              id="client-website"
              label="Sitio web"
              v-model="form.website"
              :formError="errors.website"
            />
          </div>

          <div class="col-12 col-md-6">
            <FieldText
              id="client-rfc"
              label="RFC"
              v-model="form.rfc"
              :formError="errors.rfc"
            />
          </div>

          <div class="col-12">
            <FieldText
              id="client-address-1"
              label="Direccion linea 1"
              v-model="form.address_line_1"
              :formError="errors.address_line_1"
            />
          </div>

          <div class="col-12">
            <FieldText
              id="client-address-2"
              label="Direccion linea 2"
              v-model="form.address_line_2"
              :formError="errors.address_line_2"
            />
          </div>

          <div class="col-12 col-md-6">
            <LocationSelector
              v-model="locationData"
              :state-error="errors.state_code"
              :municipality-error="errors.municipality"
              @state-changed="onStateChanged"
              @municipality-changed="onMunicipalityChanged"
            />
          </div>

          <div class="col-12 col-md-3">
            <FieldText
              id="client-neighborhood"
              label="Colonia"
              v-model="form.neighborhood"
              :formError="errors.neighborhood"
            />
          </div>

          <div class="col-12 col-md-3">
            <FieldText
              id="client-postal"
              label="Codigo postal"
              v-model="form.postal_code"
              :formError="errors.postal_code"
            />
          </div>

          <div class="col-12">
            <FieldTextarea
              id="client-notes"
              label="Notas"
              v-model="form.notes"
              :formError="errors.notes"
              :rows="3"
            />
          </div>
          </div>
          </div>
          <div class="card-footer bg-transparent border-top pt-3 pb-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-danger rounded-pill py-2" @click="deleteClient">
              <i class="bi bi-trash me-1"></i>Eliminar
            </button>
            <FormActions
              :submitText="'Guardar'"
              :submittingText="'Guardando...'"
              :cancelHref="`/member/listings/${listing.id}/clients`"
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
import PageHeader from '@/Components/Admin/PageHeader.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldEmail from '@/Components/Fields/FieldEmail.vue'
import FieldWhatsapp from '@/Components/Fields/FieldWhatsapp.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import LocationSelector from '@/Components/LocationSelector.vue'
import FormActions from '@/Components/FormActions.vue'

const props = defineProps({
  listing: {
    type: Object,
  },
  client: {
    type: Object,
    required: true,
  },
})

const page = usePage()
const listing = computed(() => page.props.listing)
const client = computed(() => page.props.client)

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Clientes', href: `/member/listings/${listing.value.id}/clients` },
  { label: client.value?.customer_name || 'Editar' },
])

const locationData = ref({
  state_code: client.value.state_code || '',
  municipality: client.value.municipality || '',
})

const sending = ref(false)

const form = reactive({
  customer_name: client.value.customer_name,
  contact_person: client.value.contact_person || '',
  company_name: client.value.company_name || '',
  whatsapp: client.value.whatsapp || '',
  whatsapp_country: client.value.whatsapp_country || '+52',
  website: client.value.website || '',
  rfc: client.value.rfc || '',
  address_line_1: client.value.address_line_1 || '',
  address_line_2: client.value.address_line_2 || '',
  neighborhood: client.value.neighborhood || '',
  postal_code: client.value.postal_code || '',
  state_code: client.value.state_code || '',
  municipality: client.value.municipality || '',
  customer_email: client.value.customer_email || '',
  customer_phone: client.value.customer_phone || '',
  status: client.value.status || 'pending',
  notes: client.value.notes || '',
})

const errors = reactive({
  customer_name: '',
  contact_person: '',
  company_name: '',
  whatsapp: '',
  website: '',
  rfc: '',
  address_line_1: '',
  address_line_2: '',
  neighborhood: '',
  postal_code: '',
  state_code: '',
  municipality: '',
  customer_email: '',
  customer_phone: '',
  notes: '',
})

const validateForm = () => {
  let isValid = true

  errors.customer_name = ''
  errors.contact_person = ''
  errors.company_name = ''
  errors.whatsapp = ''
  errors.website = ''
  errors.rfc = ''
  errors.address_line_1 = ''
  errors.address_line_2 = ''
  errors.neighborhood = ''
  errors.postal_code = ''
  errors.state_code = ''
  errors.municipality = ''
  errors.customer_email = ''
  errors.customer_phone = ''
  errors.notes = ''

  if (!form.customer_name || form.customer_name.trim() === '') {
    errors.customer_name = 'El nombre es obligatorio.'
    isValid = false
  }

  if (form.customer_email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.customer_email)) {
    errors.customer_email = 'El email no es valido.'
    isValid = false
  }

  return isValid
}

const onStateChanged = () => {}
const onMunicipalityChanged = () => {}

const submit = () => {
  if (!validateForm()) {
    toast.warning('Por favor completa los campos requeridos')
    return
  }

  sending.value = true
  form.state_code = locationData.value.state_code
  form.municipality = locationData.value.municipality

  router.put(`/member/listings/${listing.value.id}/clients/${client.value.id}`, form, {
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

const deleteClient = () => {
  if (!confirm(`Eliminar el cliente "${client.value?.customer_name}"?`)) return
  router.delete(`/member/listings/${listing.value.id}/clients/${client.value.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      window.location.href = `/member/listings/${listing.value.id}/clients`
    },
  })
}
</script>