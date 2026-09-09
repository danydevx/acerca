<template>
  <MemberLayout>
    <Head title="Preferencias" />

    <PageHeader title="Preferencias" :breadcrumbs="breadcrumbs" backHref="/member" />

    <form @submit.prevent="submit">
      <div class="card">
        <div class="card-header bg-transparent border-bottom pb-2 pt-2">
          <h6 class="text-uppercase text-muted mb-0 fw-normal">
            <i class="bi bi-pencil-square me-1"></i>Preferencias
          </h6>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
              <FieldSelect
                id="pref-locale"
                label="Idioma"
                v-model="form.locale"
                :options="localeOptions"
                :formError="form.errors.locale"
              />
            </div>
            <div class="col-12 col-md-6">
              <FieldSelect
                id="pref-timezone"
                label="Zona horaria"
                v-model="form.timezone"
                :options="timezoneOptions"
                :formError="form.errors.timezone"
              />
            </div>

            <div class="col-12">
              <FieldSwitch
                id="pref-email"
                label="Notificaciones por email"
                v-model="form.email_notifications"
              />
            </div>
            <div class="col-12">
              <FieldSwitch
                id="pref-system"
                label="Notificaciones internas"
                v-model="form.system_notifications"
              />
            </div>
            <div class="col-12">
              <FieldSwitch
                id="pref-welcome"
                label="Ocultar bienvenida del dashboard"
                v-model="form.dashboard_welcome_dismissed"
              />
            </div>
          </div>
        </div>
        <div class="card-footer bg-transparent border-top pt-3 pb-3">
            <FormActions
              :submitText="'Guardar cambios'"
              :submittingText="'Guardando...'"
              :cancelHref="'/member'"
              :sending="form.processing"
            />
        </div>
      </div>
    </form>
  </MemberLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FieldSwitch from '@/Components/Fields/FieldSwitch.vue'
import FormActions from '@/Components/FormActions.vue'

const props = defineProps({
  preferences: {
    type: Object,
    required: true,
  },
})

const breadcrumbs = [
  { label: 'Preferencias' },
]

const form = useForm({
  locale: props.preferences.locale || 'es',
  timezone: props.preferences.timezone || 'America/Mexico_City',
  email_notifications: !!props.preferences.email_notifications,
  system_notifications: !!props.preferences.system_notifications,
  dashboard_welcome_dismissed: !!props.preferences.dashboard_welcome_dismissed,
})

const submit = () => {
  form.put('/member/preferences')
}

const localeOptions = [
  { value: 'es', label: 'Espanol' },
  { value: 'en', label: 'English' },
]

const timezoneOptions = [
  { value: 'America/Mexico_City', label: 'Ciudad de Mexico' },
  { value: 'America/Tijuana', label: 'Tijuana' },
  { value: 'America/Hermosillo', label: 'Hermosillo' },
  { value: 'America/Mazatlan', label: 'Mazatlan' },
  { value: 'America/Chihuahua', label: 'Chihuahua' },
  { value: 'America/Ojinaga', label: 'Ojinaga' },
  { value: 'America/Ciudad_Juarez', label: 'Ciudad Juarez' },
  { value: 'America/Monterrey', label: 'Monterrey' },
  { value: 'America/Merida', label: 'Merida' },
  { value: 'America/Cancun', label: 'Cancun' },
]
</script>
