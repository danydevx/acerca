<template>
  <MemberLayout>
    <Head :title="`Editar Horario - ${location.name}`" />

    <PageHeader
      :title="'Editar Horario'"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing.id}/locations/${location.id}/schedules`"
    />

    <div v-if="flashSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
      {{ flashSuccess }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <form @submit.prevent="submit">
      <div class="card">
        <div class="card-header bg-transparent border-bottom pb-2 pt-2 d-flex justify-content-between align-items-center">
          <h6 class="text-uppercase text-muted mb-0 fw-normal">
            <i class="bi bi-pencil-square me-1"></i>Editar horario
          </h6>
          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="is-active" v-model="form.is_active">
            <label class="form-check-label" for="is-active">Activo</label>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-12">
              <FieldText
                id="schedule-name"
                label="Nombre del horario"
                v-model="form.name"
                :form-error="errors.name"
                placeholder=" "
                required
                help-text="Ej: Horario Regular, Matutino, Nocturno, Diciembre"
              />
            </div>

            <div class="col-12">
              <FieldCheckboxes
                id="schedule-days"
                label="Días de la semana"
                v-model="form.days_of_week"
                :items="daysOfWeekForCheckboxes"
                id-prefix="day-"
                :form-error="errors.days_of_week"
                required
                help-text="Selecciona los días que aplica este horario. Déjalos todos vacíos para todos los días."
              />
            </div>

            <div class="col-12">
              <hr />
              <h6 class="mb-3">Horario general</h6>
            </div>

            <div class="col-12 col-md-6">
              <FieldTime
                id="opening-time"
                label="Hora de apertura"
                v-model="form.opening_time"
                :form-error="errors.opening_time"
                required
              />
            </div>

            <div class="col-12 col-md-6">
              <FieldTime
                id="closing-time"
                label="Hora de cierre"
                v-model="form.closing_time"
                :form-error="errors.closing_time"
                required
              />
            </div>

            <div class="col-12">
              <hr />
              <h6 class="mb-3">Horario de almuerzo (opcional)</h6>
            </div>

            <div class="col-12 col-md-6">
              <FieldTime
                id="lunch-start-time"
                label="Inicio del almuerzo"
                v-model="form.lunch_start_time"
              />
            </div>

            <div class="col-12 col-md-6">
              <FieldTime
                id="lunch-end-time"
                label="Fin del almuerzo"
                v-model="form.lunch_end_time"
              />
            </div>
          </div>
        </div>
        <div class="card-footer bg-transparent border-top pt-3 pb-3 d-flex justify-content-between align-items-center">
          <button type="button" class="btn btn-danger rounded-pill py-2" @click="deleteSchedule">
            <i class="bi bi-trash me-1"></i>Eliminar
          </button>
          <FormActions
            :submitText="'Guardar'"
            :submittingText="'Guardando...'"
            :cancelHref="`/member/listings/${listing.id}/locations/${location.id}/schedules`"
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
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldTime from '@/Components/Fields/FieldTime.vue'
import FieldCheckboxes from '@/Components/Fields/FieldCheckboxes.vue'
import FieldSwitch from '@/Components/Fields/FieldSwitch.vue'
import FormActions from '@/Components/FormActions.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const location = computed(() => page.props.location)
const scheduleData = computed(() => page.props.schedule)

const daysOfWeek = [
  { value: 0, label: 'Domingo' },
  { value: 1, label: 'Lunes' },
  { value: 2, label: 'Martes' },
  { value: 3, label: 'Miércoles' },
  { value: 4, label: 'Jueves' },
  { value: 5, label: 'Viernes' },
  { value: 6, label: 'Sábado' },
]

const daysOfWeekForCheckboxes = [
  { id: 0, label: 'Domingo' },
  { id: 1, label: 'Lunes' },
  { id: 2, label: 'Martes' },
  { id: 3, label: 'Miércoles' },
  { id: 4, label: 'Jueves' },
  { id: 5, label: 'Viernes' },
  { id: 6, label: 'Sábado' },
]

const errors = reactive({
  name: '',
  days_of_week: '',
  opening_time: '',
  closing_time: '',
})

const sending = ref(false)

const form = reactive({
  name: scheduleData.value.name || '',
  days_of_week: scheduleData.value.days_of_week || [],
  opening_time: scheduleData.value.opening_time || '09:00',
  closing_time: scheduleData.value.closing_time || '18:00',
  lunch_start_time: scheduleData.value.lunch_start_time || '',
  lunch_end_time: scheduleData.value.lunch_end_time || '',
  is_active: !!scheduleData.value.is_active,
})

const flashSuccess = computed(() => page.props.flash?.success || null)

const businessMenu = computed(() => page.props.businessMenu || [])

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Horarios', href: `/member/listings/${listing.value?.id}/office-hours` },
  { label: 'Editar' },
])

const validateForm = () => {
  let isValid = true

  errors.name = ''
  errors.days_of_week = ''
  errors.opening_time = ''
  errors.closing_time = ''

  if (!form.name || form.name.trim() === '') {
    errors.name = 'El nombre es obligatorio.'
    isValid = false
  } else if (form.name.length > 100) {
    errors.name = 'El nombre no puede tener más de 100 caracteres.'
    isValid = false
  }

  if (!form.opening_time) {
    errors.opening_time = 'La hora de apertura es obligatoria.'
    isValid = false
  }

  if (!form.closing_time) {
    errors.closing_time = 'La hora de cierre es obligatoria.'
    isValid = false
  }

  if (form.opening_time && form.closing_time && form.opening_time >= form.closing_time) {
    errors.closing_time = 'La hora de cierre debe ser posterior a la hora de apertura.'
    isValid = false
  }

  return isValid
}

const submit = () => {
  if (!validateForm()) {
    return
  }

  sending.value = true

  const formData = new FormData()
  formData.append('name', form.name)
  form.days_of_week.forEach(day => {
    formData.append('days_of_week[]', day)
  })
  formData.append('opening_time', form.opening_time)
  formData.append('closing_time', form.closing_time)
  if (form.lunch_start_time) {
    formData.append('lunch_start_time', form.lunch_start_time)
  }
  if (form.lunch_end_time) {
    formData.append('lunch_end_time', form.lunch_end_time)
  }
  formData.append('is_active', form.is_active ? '1' : '0')
  formData.append('_method', 'PUT')

  router.post(`/member/listings/${listing.value.id}/locations/${location.value.id}/schedules/${scheduleData.value.id}`, formData, {
    preserveScroll: true,
    onError: (serverErrors) => {
      sending.value = false
      if (serverErrors.name) errors.name = serverErrors.name
      if (serverErrors.days_of_week) errors.days_of_week = serverErrors.days_of_week
      if (serverErrors.opening_time) errors.opening_time = serverErrors.opening_time
      if (serverErrors.closing_time) errors.closing_time = serverErrors.closing_time
    },
    onFinish: () => {
      sending.value = false
    },
  })
}

const deleteSchedule = () => {
  if (!confirm(`Eliminar el horario "${scheduleData.value?.name}"?`)) return
  router.delete(`/member/listings/${listing.value.id}/locations/${location.value.id}/schedules/${scheduleData.value.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      window.location.href = `/member/listings/${listing.value.id}/locations/${location.value.id}/schedules`
    },
  })
}
</script>
