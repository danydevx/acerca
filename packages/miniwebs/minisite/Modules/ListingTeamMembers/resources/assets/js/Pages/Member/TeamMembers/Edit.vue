<template>
  <MemberLayout>
    <Head :title="`Editar Miembro - ${listing?.name || ''}`" />

    <PageHeader
      title="Editar Miembro"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing?.id}/team-members`"
    />

    <form @submit.prevent="submit">
      <div class="card">
        <div class="card-header bg-transparent border-bottom pb-2 pt-2 d-flex justify-content-between align-items-center">
          <h6 class="text-uppercase text-muted mb-0 fw-normal">
            <i class="bi bi-pencil-square me-1"></i>Editar miembro
          </h6>
          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="member-active" v-model="form.is_active">
            <label class="form-check-label" for="member-active">Activo</label>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-12 col-md-8">
              <FieldText
                id="member-name"
                label="Nombre completo"
                placeholder="Ej: Juan Pérez"
                v-model="form.name"
                :formError="errors.name"
                required
              />
            </div>
            <div class="col-12 col-md-4">
              <FieldSelect
                id="member-position"
                label="Puesto"
                v-model="form.position_id"
                :options="positionOptions"
                :formError="errors.position_id"
              />
            </div>
            <div class="col-12 col-md-6">
              <FieldEmail
                id="member-email"
                label="Correo electrónico (opcional)"
                placeholder="juan@ejemplo.com"
                v-model="form.email"
                :formError="errors.email"
              />
            </div>
            <div class="col-12 col-md-6">
              <FieldText
                id="member-phone"
                label="Teléfono (opcional)"
                placeholder="+52 555 123 4567"
                v-model="form.phone"
                :formError="errors.phone"
              />
            </div>
            <div class="col-12">
              <FieldTextarea
                id="member-bio"
                label="Biografía (opcional)"
                placeholder="Cuéntanos sobre este miembro del equipo"
                v-model="form.bio"
                :formError="errors.bio"
                :rows="3"
              />
            </div>
            <div class="col-12">
              <FieldImage
                id="member-image"
                label="Foto (opcional)"
                v-model="mainImage"
                :initialPreview="initialPreview"
                :maxFiles="1"
                :maxSizeMb="2"
                accept="image/jpeg"
                @update:keep="onImageKeepChange"
              />
              <small class="text-muted">JPG, max 2MB</small>
            </div>
          </div>
        </div>
        <div class="card-footer bg-transparent border-top pt-3 pb-3">
          <div class="d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-danger rounded-pill py-2" @click="deleteMember">
              <i class="bi bi-trash me-1"></i>Eliminar
            </button>
            <FormActions
              :submitText="'Guardar'"
              :submittingText="'Guardando...'"
              :cancelHref="`/member/listings/${listing?.id}/team-members`"
              :sending="sending"
            />
          </div>
        </div>
      </div>
    </form>
  </MemberLayout>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { Head, Link, usePage, router } from '@inertiajs/vue3'
import { toast } from 'vue3-toastify'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldEmail from '@/Components/Fields/FieldEmail.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FieldImage from '@/Components/Fields/FieldImage.vue'
import FormActions from '@/Components/FormActions.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const member = computed(() => page.props.member)
const positions = computed(() => page.props.positions || [])
const businessMenu = computed(() => page.props.businessMenu || [])

const positionOptions = computed(() => {
  return [
    { value: '', label: 'Sin puesto' },
    ...positions.value.map(p => ({
      value: p.id,
      label: p.name,
    }))
  ]
})

const sending = ref(false)
const mainImage = ref(null)
const keepImage = ref(true)
const initialPreview = computed(() => member.value?.image || '')

const onImageKeepChange = (value) => {
  keepImage.value = value
}

const errors = reactive({
  name: '',
  email: '',
  phone: '',
  bio: '',
  position_id: '',
  image: '',
})

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Mi Equipo', href: `/member/listings/${listing.value?.id}/team-members` },
  { label: member.value?.name || 'Editar' },
])

const form = reactive({
  name: member.value?.name || '',
  email: member.value?.email || '',
  phone: member.value?.phone || '',
  bio: member.value?.bio || '',
  position_id: member.value?.position_id || '',
  is_active: member.value?.is_active ?? true,
})

const validateForm = () => {
  let isValid = true
  errors.name = ''
  errors.email = ''
  errors.phone = ''
  errors.bio = ''
  errors.position_id = ''
  errors.image = ''

  if (!form.name || form.name.trim() === '') {
    errors.name = 'El nombre es obligatorio.'
    isValid = false
  }

  if (form.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
    errors.email = 'El email no es valido.'
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
  const formData = new FormData()

  Object.keys(form).forEach(key => {
    const val = form[key]
    if (val !== null && val !== '') {
      if (typeof val === 'boolean') {
        formData.append(key, val ? '1' : '0')
      } else {
        formData.append(key, val)
      }
    }
  })

  if (mainImage.value instanceof File) {
    formData.append('image', mainImage.value)
  } else if (!keepImage.value && member.value?.image) {
    formData.append('_remove_image', '1')
  }

  router.post(`/member/listings/${listing.value.id}/team-members/${member.value.id}`, formData, {
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

const deleteMember = () => {
  if (!confirm(`Eliminar el miembro "${member.value?.name}"?`)) return
  router.delete(`/member/listings/${listing.value.id}/team-members/${member.value.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      window.location.href = `/member/listings/${listing.value.id}/team-members`
    },
  })
}
</script>
