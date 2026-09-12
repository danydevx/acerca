<template>
  <MemberLayout>
    <Head :title="`Acerca de - ${listing.name}`" />

    <PageHeader
      title="Acerca de"
      :breadcrumbs="breadcrumbs"
      :backHref="'/member/listings'"
    />

    <form @submit.prevent="submit">
      <div class="card">
        <div class="card-header bg-transparent border-bottom pb-2 pt-2 d-flex justify-content-between align-items-center">
          <h6 class="text-uppercase text-muted mb-0 fw-normal">
            <i class="bi bi-pencil-square me-1"></i>Acerca de
          </h6>
          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="is-active" v-model="form.is_active">
            <label class="form-check-label" for="is-active">Activo</label>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <FieldText
                id="about-title"
                label="Titulo"
                v-model="form.title"
                placeholder="Nuestra historia"
              />
            </div>

            <div class="col-md-6">
              <FieldText
                id="about-subtitle"
                label="Subtitulo"
                v-model="form.subtitle"
                placeholder="Conocé quienes somos"
              />
            </div>

            <div class="col-12">
              <FieldTextarea
                id="about-description"
                label="Descripcion"
                v-model="form.description"
                placeholder="Escribi la descripcion de tu negocio..."
                :rows="4"
              />
            </div>

            <div class="col-12">
              <hr />
              <h6 class="mb-3">Imagenes</h6>
            </div>

            <div class="col-md-6">
              <FieldImage
                id="about-image"
                label="Imagen principal"
                v-model="mainImage"
                :initialPreview="initialPreview"
                :maxFiles="1"
                :maxSizeMb="5"
                accept="image/jpeg,image/png,image/webp,image/gif"
                @update:keep="onImageKeepChange"
              />
              <small class="text-muted">JPG, PNG o WebP, max 5MB</small>
            </div>

            <div class="col-md-6">
              <FieldImage
                id="about-logo"
                label="Logotipo"
                v-model="logoImage"
                :initialPreview="initialLogoPreview"
                :maxFiles="1"
                :maxSizeMb="5"
                accept="image/jpeg,image/png,image/webp,image/gif"
                @update:keep="onLogoKeepChange"
              />
              <small class="text-muted">JPG, PNG o WebP, max 5MB</small>
            </div>
          </div>
        </div>
        <FormActions
          :submitText="'Guardar'"
          :submittingText="'Guardando...'"
          :cancelHref="'/member/listings'"
          :sending="sending"
        />
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
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FieldSwitch from '@/Components/Fields/FieldSwitch.vue'
import FieldImage from '@/Components/Fields/FieldImage.vue'
import FormActions from '@/Components/FormActions.vue'

const props = defineProps({
  listing: Object,
  about: Object,
})

const page = usePage()
const listing = computed(() => page.props.listing)
const businessMenu = computed(() => page.props.businessMenu || [])

const breadcrumbs = computed(() => {
  const path = window.location.pathname
  const businessMatch = path.match(/^\/member\/listings\/(\d+)/)
  if (businessMatch) {
    const businessId = parseInt(businessMatch[1])
    const biz = businessMenu.value.find(b => b.id === businessId)
    if (biz) {
      return [
        { label: 'Inicio', href: `/member/listings/${biz.id}/modules` },
        { label: 'Acerca de', active: true },
      ]
    }
  }
  return [
    { label: 'Inicio', href: '/member/dashboard' },
    { label: 'Acerca de', active: true },
  ]
})

const sending = ref(false)
const mainImage = ref(null)
const logoImage = ref(null)
const keepImage = ref(true)
const keepLogo = ref(true)

const initialPreview = computed(() => props.about?.image_path || '')
const initialLogoPreview = computed(() => props.about?.logo_path || '')

const onImageKeepChange = (value) => {
  keepImage.value = value
}

const onLogoKeepChange = (value) => {
  keepLogo.value = value
}

const errors = reactive({
  title: '',
  subtitle: '',
  description: '',
})

const form = reactive({
  title: props.about?.title || '',
  subtitle: props.about?.subtitle || '',
  description: props.about?.description || '',
  is_active: props.about?.is_active ?? true,
})

const validateForm = () => {
  let isValid = true
  errors.title = ''
  errors.subtitle = ''
  errors.description = ''

  if (!form.title || form.title.trim() === '') {
    errors.title = 'El titulo es obligatorio.'
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

  const data = new FormData()
  data.append('title', form.title || '')
  data.append('subtitle', form.subtitle || '')
  data.append('description', form.description || '')
  data.append('is_active', form.is_active ? '1' : '0')

  if (mainImage.value instanceof File) {
    data.append('image', mainImage.value)
  } else if (!keepImage.value && props.about?.image_path) {
    data.append('remove_image', '1')
  }

  if (logoImage.value instanceof File) {
    data.append('logo', logoImage.value)
  } else if (!keepLogo.value && props.about?.logo_path) {
    data.append('remove_logo', '1')
  }

  router.post(`/member/listings/${props.listing.id}/about`, data, {
    preserveScroll: true,
    onSuccess: () => {
      sending.value = false
      toast.success('Cambios guardados correctamente')
    },
    onError: (errs) => {
      sending.value = false
      Object.keys(errs).forEach(key => {
        if (key in errors) {
          errors[key] = errs[key]
        }
      })
      toast.error('Error al guardar')
    },
    onFinish: () => {
      sending.value = false
    },
  })
}
</script>
