<template>
  <MemberLayout>
    <Head :title="`Editar Paquete - ${listing?.name || ''}`" />

    <PageHeader
      title="Editar Paquete"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing?.id}/packages`"
    />

    <form @submit.prevent="submit">
      <div class="card">
        <div class="card-header bg-transparent border-bottom pb-2 pt-2 d-flex justify-content-between align-items-center">
          <h6 class="text-uppercase text-muted mb-0 fw-normal">
            <i class="bi bi-pencil-square me-1"></i>Editar paquete
          </h6>
          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="package-active" v-model="form.is_active">
            <label class="form-check-label" for="package-active">Activo</label>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-12">
              <FieldText
                id="package-title"
                label="Titulo"
                placeholder="Ej: Paquete Basic"
                v-model="form.title"
                :formError="errors.title"
                required
              />
            </div>

            <div class="col-12">
              <FieldText
                id="package-short-description"
                label="Descripcion corta"
                placeholder="Breve descripcion del paquete"
                v-model="form.short_description"
                :formError="errors.short_description"
                required
              />
            </div>

            <div class="col-12">
              <FieldTextarea
                id="package-long-description"
                label="Descripcion larga (opcional)"
                placeholder="Descripcion detallada del paquete"
                v-model="form.long_description"
                :formError="errors.long_description"
                :rows="3"
              />
            </div>

            <div class="col-md-6">
              <FieldPrice
                id="package-price"
                label="Precio (opcional)"
                placeholder="0.00"
                v-model="form.price"
                :formError="errors.price"
              />
            </div>
            <div class="col-md-6">
              <FieldPrice
                id="package-promo-price"
                label="Precio promocional (opcional)"
                placeholder="0.00"
                v-model="form.promo_price"
                :formError="errors.promo_price"
              />
            </div>

            <div class="col-12">
              <FieldImage
                id="package-image"
                label="Imagen (opcional)"
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

          <div class="card bg-secondary-subtle border-0 mb-3">
            <div class="card-header bg-transparent border-bottom pb-2 pt-2">
              <h6 class="mb-0"><i class="bi bi-whatsapp me-1"></i>WhatsApp</h6>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <FieldText
                    id="package-whatsapp"
                    label="WhatsApp (opcional)"
                    :placeholder="defaultWhatsapp || '+52 555 000 0000'"
                    v-model="form.whatsapp"
                    :formError="errors.whatsapp"
                  />
                </div>
                <div class="col-md-6 d-flex align-items-end">
                  <button type="button" class="btn btn-secondary rounded-pill" @click="useDefaultWhatsapp">
                    Usar WhatsApp del negocio
                  </button>
                </div>
                <div class="col-12">
                  <FieldTextarea
                    id="package-whatsapp-message"
                    label="Mensaje de WhatsApp (opcional)"
                    placeholder="Usa {package_title} para incluir el nombre del paquete"
                    v-model="form.whatsapp_message"
                    :formError="errors.whatsapp_message"
                    :rows="2"
                  />
                </div>
              </div>
            </div>
          </div>

          <div class="card bg-secondary-subtle border-0">
            <div class="card-header bg-transparent border-bottom pb-2 pt-2">
              <h6 class="mb-0"><i class="bi bi-list-check me-1"></i>Caracteristicas</h6>
            </div>
            <div class="card-body">
              <p class="text-muted small mb-3">Agrega las caracteristicas incluidas en el paquete (maximo 30)</p>
              <draggable
                v-model="form.features"
                item-key="index"
                handle=".drag-handle"
                ghost-class="bg-secondary-subtle"
              >
                <template #item="{ element, index }">
                  <div class="d-flex align-items-center gap-2 mb-2">
                    <button type="button" class="btn btn-secondary rounded-pill drag-handle">
                      <i class="bi bi-arrows-move"></i>
                    </button>
                    <input
                      type="text"
                      class="form-control form-control-sm"
                      v-model="form.features[index]"
                      :placeholder="`Caracteristica ${index + 1}`"
                    />
                    <button
                      type="button"
                      class="btn btn-danger rounded-pill"
                      @click="removeFeature(index)"
                      :disabled="form.features.length <= 1"
                    >
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </template>
              </draggable>

              <button
                type="button"
                class="btn btn-primary rounded-pill mt-2"
                @click="addFeature"
                :disabled="form.features.length >= 30"
              >
                <i class="bi bi-plus me-1"></i>Agregar caracteristica
              </button>
            </div>
          </div>
        </div>
        <div class="card-footer bg-transparent border-top pt-3 pb-3 d-flex justify-content-between align-items-center">
          <button type="button" class="btn btn-danger rounded-pill py-2" @click="deletePackage">
            <i class="bi bi-trash me-1"></i>Eliminar
          </button>

          <FormActions :submitText="'Guardar'" :submittingText="'Guardando...'" :cancelHref="`/member/listings/${listing?.id}/packages`" :sending="sending" />
        </div>
      </div>
    </form>
  </MemberLayout>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { Head, Link, usePage, router } from '@inertiajs/vue3'
import { toast } from 'vue3-toastify'
import draggable from 'vuedraggable'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldPrice from '@/Components/Fields/FieldPrice.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FieldImage from '@/Components/Fields/FieldImage.vue'
import FormActions from '@/Components/FormActions.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const pkg = computed(() => page.props.package)
const defaultWhatsapp = computed(() => page.props.defaultWhatsapp || '')
const businessMenu = computed(() => page.props.businessMenu || [])

const sending = ref(false)
const mainImage = ref(null)
const keepImage = ref(true)
const initialPreview = computed(() => pkg.value?.image || '')

const onImageKeepChange = (value) => {
  keepImage.value = value
}

const errors = reactive({
  title: '',
  short_description: '',
  long_description: '',
  price: '',
  promo_price: '',
  whatsapp: '',
  whatsapp_message: '',
})

const breadcrumbs = computed(() => {
  const path = window.location.pathname
  const businessMatch = path.match(/^\/member\/listings\/(\d+)/)
  if (businessMatch) {
    const businessId = parseInt(businessMatch[1])
    const biz = businessMenu.value.find(b => b.id === businessId)
    if (biz) {
      return [
        { label: 'Inicio', href: `/member/listings/${biz.id}/modules` },
        { label: 'Paquetes', href: `/member/listings/${biz.id}/packages` },
        { label: pkg.value?.title || 'Editar', active: true },
      ]
    }
  }
  return [
    { label: 'Inicio', href: '/member/dashboard' },
    { label: 'Paquetes', href: `/member/listings/${listing.value?.id}/packages` },
    { label: pkg.value?.title || 'Editar', active: true },
  ]
})

const form = reactive({
  title: pkg.value?.title || '',
  short_description: pkg.value?.short_description || '',
  long_description: pkg.value?.long_description || '',
  price: pkg.value?.price || '',
  promo_price: pkg.value?.promo_price || '',
  whatsapp: pkg.value?.whatsapp || '',
  whatsapp_message: pkg.value?.whatsapp_message || '',
  features: pkg.value?.features || [''],
  is_active: pkg.value?.is_active ?? true,
})

const validateForm = () => {
  let isValid = true
  errors.title = ''
  errors.short_description = ''

  if (!form.title || form.title.trim() === '') {
    errors.title = 'El titulo es obligatorio.'
    isValid = false
  }

  if (!form.short_description || form.short_description.trim() === '') {
    errors.short_description = 'La descripcion corta es obligatoria.'
    isValid = false
  }

  return isValid
}

const useDefaultWhatsapp = () => {
  form.whatsapp = defaultWhatsapp.value
}

const addFeature = () => {
  if (form.features.length < 30) {
    form.features.push('')
  }
}

const removeFeature = (index) => {
  if (form.features.length > 1) {
    form.features.splice(index, 1)
  }
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
      if (key === 'features') {
        form.features.forEach((f, i) => {
          formData.append(`features[${i}]`, f)
        })
      } else if (typeof val === 'boolean') {
        formData.append(key, val ? '1' : '0')
      } else {
        formData.append(key, val)
      }
    }
  })

  if (mainImage.value instanceof File) {
    formData.append('image', mainImage.value)
  } else if (!keepImage.value && pkg.value?.image) {
    formData.append('_remove_image', '1')
  }

  router.post(`/member/listings/${listing.value.id}/packages/${pkg.value.id}`, formData, {
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

const deletePackage = () => {
  if (!confirm(`Eliminar el paquete "${pkg.value?.title}"?`)) return
  router.delete(`/member/listings/${listing.value.id}/packages/${pkg.value.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      window.location.href = `/member/listings/${listing.value.id}/packages`
    },
  })
}
</script>
