<template>
  <MemberLayout>
    <Head :title="`Nueva Ubicacion - ${listing.name}`" />

    <PageHeader
      :title="'Nueva Ubicacion'"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing.id}/locations`"
    />

    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <form @submit.prevent="submit" id="location-form">
          <div class="row g-3">
            <div class="col-12 col-md-8">
              <FieldText
                id="location-name"
                label="Nombre"
                v-model="form.name"
                :form-error="errors.name"
                placeholder=" "
                required
              />
            </div>

            <div class="col-12 col-md-4">
              <FieldSwitch
                id="location-primary"
                label="Ubicacion principal"
                v-model="form.is_primary"
              />
            </div>

            <div class="col-12">
              <FieldText
                id="location-address-1"
                label="Direccion linea 1"
                v-model="form.address_line_1"
                :form-error="errors.address_line_1"
                placeholder=" "
                required
              />
            </div>

            <div class="col-12">
              <FieldText
                id="location-address-2"
                label="Direccion linea 2"
                v-model="form.address_line_2"
                placeholder=" "
              />
            </div>

            <div class="col-12 col-md-6">
              <FieldText
                id="location-city"
                label="Ciudad / Colonia"
                v-model="form.city"
                :form-error="errors.city"
                placeholder=" "
                required
              />
            </div>

            <div class="col-12 col-md-6">
              <LocationSelector
                ref="locationSelectorRef"
                v-model="locationData"
                :state-error="errors.state_code"
                :municipality-error="errors.municipality"
                required
                @state-changed="onStateChanged"
                @municipality-changed="onMunicipalityChanged"
                @location-updated="onLocationUpdated"
              />
            </div>

            <div class="col-12 col-md-4">
              <FieldText
                id="location-postal"
                label="Codigo Postal"
                v-model="form.postal_code"
                placeholder=" "
              />
            </div>

            <div class="col-12 col-md-6">
              <FieldTel
                id="location-phone"
                label="Telefono"
                v-model="form.phone"
                placeholder=" "
              />
            </div>

            <div class="col-12 col-md-6">
              <FieldEmail
                id="location-email"
                label="Email"
                v-model="form.email"
                :form-error="errors.email"
                placeholder=" "
              />
            </div>

            <div class="col-12">
              <MapPicker
                label="Ubicacion en el mapa"
                :lat="form.latitude"
                :lng="form.longitude"
                @update:lat="form.latitude = $event"
                @update:lng="form.longitude = $event"
                @reverse-geocoded="onReverseGeocoded"
              />
            </div>

            <div class="col-12">
              <FieldUrl
                id="location-directions"
                label="Como llegar (URL de Google Maps)"
                v-model="form.directions_url"
                placeholder="https://maps.google.com/..."
              />
            </div>

            <div class="col-12">
              <FieldImage
                id="location-image"
                label="Imagen de la ubicacion"
                v-model="locationImage"
                :maxSizeMb="2"
                accept="image/jpeg,image/png"
                help-text="JPG o PNG, max 2MB. Opcional."
              />
            </div>

            <div class="col-12 col-md-4">
              <FieldSwitch
                id="location-active"
                label="Ubicacion activa"
                v-model="form.is_active"
              />
            </div>
          </div>

          <div class="col-12 d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-gradient rounded-pill" :disabled="sending">
              {{ sending ? 'Creando...' : 'Crear Ubicacion' }}
            </button>
            <Link :href="`/member/listings/${listing.id}/locations`" class="btn btn-outline-dark rounded-pill">Cancelar</Link>
          </div>
        </form>
      </div>
    </div>
  </MemberLayout>
</template>

<script setup>
import { computed, reactive, ref } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import { toast } from 'vue3-toastify'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import MapPicker from '@/Components/MapPicker.vue'
import LocationSelector from '@/Components/LocationSelector.vue'
import FieldImage from '@/Components/Fields/FieldImage.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldEmail from '@/Components/Fields/FieldEmail.vue'
import FieldTel from '@/Components/Fields/FieldPhone.vue'
import FieldUrl from '@/Components/Fields/FieldUrl.vue'
import FieldSwitch from '@/Components/Fields/FieldSwitch.vue'

const props = defineProps({
  listing: {
    type: Object,
    required: true,
  },
})

const page = usePage()
const listing = computed(() => page.props.listing)

const locationData = ref({ state_code: '', municipality: '' })

const errors = reactive({
  name: '',
  address_line_1: '',
  city: '',
  email: '',
  state_code: '',
  municipality: '',
})

const sending = ref(false)
const locationImage = ref(null)
const locationSelectorRef = ref(null)

const form = reactive({
  name: '',
  address_line_1: '',
  address_line_2: '',
  city: '',
  postal_code: '',
  phone: '',
  email: '',
  directions_url: '',
  latitude: '',
  longitude: '',
  is_primary: false,
  is_active: true,
})

const businessMenu = computed(() => page.props.businessMenu || [])

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Ubicaciones', href: `/member/listings/${listing.value.id}/locations` },
  { label: 'Nueva' },
])

const onStateChanged = ({ lat, lng }) => {
  if (lat && lng) {
    form.latitude = parseFloat(lat).toFixed(7)
    form.longitude = parseFloat(lng).toFixed(7)
  }
}

const onMunicipalityChanged = ({ lat, lng }) => {
  if (lat && lng) {
    form.latitude = parseFloat(lat).toFixed(7)
    form.longitude = parseFloat(lng).toFixed(7)
  }
}

const onReverseGeocoded = (locationData) => {
  if (locationSelectorRef.value) {
    locationSelectorRef.value.handleReverseGeocoded(locationData)
  }
}

const onLocationUpdated = (locationData) => {
  if (locationData.address) {
    form.address_line_1 = [locationData.address, locationData.number].filter(Boolean).join(' ')
  }
  if (locationData.colony) {
    form.city = locationData.colony
  }
  if (locationData.postal_code) {
    form.postal_code = locationData.postal_code
  }
}

const validateForm = () => {
  let isValid = true

  errors.name = ''
  errors.address_line_1 = ''
  errors.city = ''
  errors.email = ''
  errors.state_code = ''
  errors.municipality = ''
  errors.image = ''

  if (!form.name || form.name.trim() === '') {
    errors.name = 'El nombre es obligatorio.'
    isValid = false
  } else if (form.name.length > 150) {
    errors.name = 'El nombre no puede tener más de 150 caracteres.'
    isValid = false
  }

  if (!form.address_line_1 || form.address_line_1.trim() === '') {
    errors.address_line_1 = 'La dirección es obligatoria.'
    isValid = false
  } else if (form.address_line_1.length > 255) {
    errors.address_line_1 = 'La dirección no puede tener más de 255 caracteres.'
    isValid = false
  }

  if (!form.city || form.city.trim() === '') {
    errors.city = 'La ciudad es obligatoria.'
    isValid = false
  } else if (form.city.length > 100) {
    errors.city = 'La ciudad no puede tener más de 100 caracteres.'
    isValid = false
  }

  if (form.email && form.email.trim() !== '') {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    if (!emailRegex.test(form.email)) {
      errors.email = 'El email no es válido.'
      isValid = false
    } else if (form.email.length > 150) {
      errors.email = 'El email no puede tener más de 150 caracteres.'
      isValid = false
    }
  }

  return isValid
}

const submit = () => {
  if (!validateForm()) {
    toast.warning('Por favor completa los campos requeridos')
    return
  }

  sending.value = true

  const formData = new FormData()
  formData.append('name', form.name)
  formData.append('address_line_1', form.address_line_1)
  formData.append('address_line_2', form.address_line_2 || '')
  formData.append('city', form.city)
  formData.append('state', '')
  formData.append('state_code', locationData.value.state_code || '')
  formData.append('municipality', locationData.value.municipality || '')
  formData.append('postal_code', form.postal_code || '')
  formData.append('country', 'MX')
  formData.append('phone', form.phone || '')
  formData.append('email', form.email || '')
  formData.append('latitude', form.latitude || '')
  formData.append('longitude', form.longitude || '')
  formData.append('directions_url', form.directions_url || '')
  formData.append('is_primary', form.is_primary ? '1' : '0')
  formData.append('is_active', form.is_active ? '1' : '0')

  if (locationImage.value instanceof File) {
    formData.append('image', locationImage.value)
  }

  router.post(`/member/listings/${listing.value.id}/locations`, formData, {
    preserveScroll: true,
    onSuccess: () => {
      toast.success('Ubicacion creada correctamente')
      sending.value = false
    },
    onError: (serverErrors) => {
      sending.value = false
      const errorMessages = []
      if (serverErrors.name) { errors.name = serverErrors.name; errorMessages.push(serverErrors.name) }
      if (serverErrors.address_line_1) { errors.address_line_1 = serverErrors.address_line_1; errorMessages.push(serverErrors.address_line_1) }
      if (serverErrors.city) { errors.city = serverErrors.city; errorMessages.push(serverErrors.city) }
      if (serverErrors.email) { errors.email = serverErrors.email; errorMessages.push(serverErrors.email) }
      if (serverErrors.state_code) { errors.state_code = serverErrors.state_code; errorMessages.push(serverErrors.state_code) }
      if (serverErrors.municipality) { errors.municipality = serverErrors.municipality; errorMessages.push(serverErrors.municipality) }
      if (serverErrors.image) { errors.image = serverErrors.image; errorMessages.push(serverErrors.image) }
      if (errorMessages.length > 0) {
        toast.warning('Por favor completa los campos requeridos: ' + errorMessages.join(', '))
      }
    },
  })
}
</script>
