<template>
  <MemberLayout>
    <Head :title="`Nueva Cita - ${listing.name}`" />

    <PageHeader
      title="Nueva Cita"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing.id}/appointments`"
    />

    <form @submit.prevent="submit">
      <div class="card">
        <div class="card-header bg-transparent border-bottom pb-2 pt-2 d-flex justify-content-between align-items-center">
          <h6 class="text-uppercase text-muted mb-0 fw-normal">
            <i class="bi bi-plus-circle me-1"></i>Crear nueva cita
          </h6>
          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="appointment-active" v-model="form.is_active">
            <label class="form-check-label" for="appointment-active">Activo</label>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <FieldText
                id="customer_name"
                label="Nombre del cliente"
                v-model="form.customer_name"
                :formError="errors.customer_name"
                required
              />
            </div>

            <div class="col-md-6">
              <FieldEmail
                id="customer_email"
                label="Email del cliente"
                v-model="form.customer_email"
                :formError="errors.customer_email"
                required
              />
            </div>

            <div class="col-md-6">
              <FieldPhone
                id="customer_phone"
                label="Telefono"
                v-model="form.customer_phone"
              />
            </div>

            <div class="col-md-6">
              <FieldSelect
                id="business_service_id"
                label="Servicio"
                v-model="form.business_service_id"
                :formError="errors.business_service_id"
                required
              >
                <option :value="null" disabled>Seleccionar servicio</option>
                <option v-for="svc in services" :key="svc.id" :value="svc.id">
                  {{ svc.name }} ({{ svc.duration_minutes }} min)
                </option>
              </FieldSelect>
            </div>

            <div class="col-md-6">
              <FieldSelect
                id="business_location_id"
                label="Ubicacion"
                v-model="form.business_location_id"
                :formError="errors.business_location_id"
              >
                <option :value="null">Sin ubicacion</option>
                <option v-for="loc in locations" :key="loc.id" :value="loc.id">
                  {{ loc.name }}
                </option>
              </FieldSelect>
            </div>

            <div class="col-md-3">
              <FieldDate
                id="appointment_date"
                label="Fecha"
                v-model="form.appointment_date"
                :formError="errors.appointment_date"
                :min="today"
                required
                :validateFunction="validateDate"
                :showValidation="showDateValidation"
                @blur="showDateValidation = true"
              />
            </div>

            <div class="col-md-3">
              <FieldTime
                id="start_time"
                label="Hora"
                v-model="form.start_time"
                :formError="errors.start_time"
                required
              />
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
            :cancelHref="`/member/listings/${listing.id}/appointments`"
            :sending="sending"
          />
        </div>
      </div>
    </form>
    </MemberLayout>
</template>

<script setup>
import { computed, reactive, ref, watch } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import { toast } from 'vue3-toastify'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldEmail from '@/Components/Fields/FieldEmail.vue'
import FieldPhone from '@/Components/Fields/FieldPhone.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FieldDate from '@/Components/Fields/FieldDate.vue'
import FieldTime from '@/Components/Fields/FieldTime.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FormActions from '@/Components/FormActions.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const services = computed(() => page.props.services || [])
const locations = computed(() => page.props.locations || [])

const errors = reactive({
  customer_name: '',
  customer_email: '',
  business_service_id: '',
  business_location_id: '',
  appointment_date: '',
  start_time: '',
})

const validateForm = () => {
  let isValid = true

  errors.customer_name = ''
  errors.customer_email = ''
  errors.business_service_id = ''
  errors.business_location_id = ''
  errors.appointment_date = ''
  errors.start_time = ''

  if (!form.customer_name || form.customer_name.trim() === '') {
    errors.customer_name = 'El nombre es obligatorio.'
    isValid = false
  }

  if (!form.customer_email || form.customer_email.trim() === '') {
    errors.customer_email = 'El email es obligatorio.'
    isValid = false
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.customer_email)) {
    errors.customer_email = 'El email no es valido.'
    isValid = false
  }

  if (!form.business_service_id) {
    errors.business_service_id = 'Selecciona un servicio.'
    isValid = false
  }

  if (!form.appointment_date) {
    errors.appointment_date = 'La fecha es obligatoria.'
    isValid = false
  } else {
    const selected = new Date(form.appointment_date)
    const todayDate = new Date()
    todayDate.setHours(0, 0, 0, 0)
    if (selected < todayDate) {
      errors.appointment_date = 'La fecha debe ser hoy o posterior.'
      isValid = false
    }
  }

  if (!form.start_time) {
    errors.start_time = 'La hora es obligatoria.'
    isValid = false
  }

  return isValid
}

watch(() => errors.appointment_date, (val) => {
  if (val) showDateValidation.value = true
})
const businessMenu = computed(() => page.props.businessMenu || [])

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Citas', href: `/member/listings/${listing.value.id}/appointments` },
  { label: 'Nueva' },
])

const sending = ref(false)
const showDateValidation = ref(false)
const today = computed(() => new Date().toISOString().split('T')[0])

const validateDate = () => {
  if (!form.appointment_date) return ''
  const selected = new Date(form.appointment_date)
  const todayDate = new Date()
  todayDate.setHours(0, 0, 0, 0)
  if (selected < todayDate) {
    return 'La fecha debe ser hoy o posterior'
  }
  return ''
}

const form = reactive({
  customer_name: '',
  customer_email: '',
  customer_phone: '',
  business_service_id: null,
  business_location_id: null,
  appointment_date: '',
  start_time: '',
  notes: '',
  is_active: true,
})

const submit = () => {
  if (!validateForm()) {
    toast.warning('Por favor completa los campos requeridos')
    return
  }

  sending.value = true
  router.post(`/member/listings/${listing.value.id}/appointments`, form, {
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
