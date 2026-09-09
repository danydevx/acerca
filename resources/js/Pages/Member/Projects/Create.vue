<template>
  <MemberLayout>
    <Head :title="`Nuevo Proyecto - ${listing?.name || ''}`" />

    <PageHeader
      title="Nuevo Proyecto"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing?.id}/projects`"
    />

    <form @submit.prevent="submit">
        <div class="card">
          <div class="card-header bg-transparent border-bottom pb-2 pt-2 d-flex justify-content-between align-items-center">
            <h6 class="text-uppercase text-muted mb-0 fw-normal">
              <i class="bi bi-plus-circle me-1"></i>Crear proyecto
            </h6>
            <div class="form-check form-switch mb-0">
              <input class="form-check-input" type="checkbox" id="project-active" v-model="form.is_active">
              <label class="form-check-label" for="project-active">Activo</label>
            </div>
          </div>
          <div class="card-body">
            <div class="row g-3 mb-3">
            <div class="col-12 col-md-8">
              <FieldText
                id="project-title"
                label="Titulo"
                v-model="form.title"
                :formError="errors.title"
                placeholder="Nombre del proyecto"
                required
                @blur="generateSlug"
              />
            </div>

            <div class="col-12 col-md-4">
              <FieldText
                id="project-slug"
                label="Slug"
                v-model="form.slug"
                :formError="errors.slug"
                placeholder="nombre-proyecto"
              />
              <small class="text-muted">Se genera automaticamente si se deja vacio.</small>
            </div>

            <div class="col-12">
              <FieldTextarea
                id="project-description"
                label="Descripcion"
                v-model="form.description"
                :formError="errors.description"
                :rows="4"
                placeholder="Describe el proyecto..."
              />
            </div>

            <div class="col-12 col-md-6">
              <FieldSelect
                id="project-category"
                label="Categoria"
                v-model="form.category_id"
                :formError="errors.category_id"
              >
                <option value="">Sin categoria</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
              </FieldSelect>
            </div>

            <div class="col-12 col-md-6">
              <FieldText
                id="project-tags"
                label="Tags"
                v-model="form.tags"
                :formError="errors.tags"
                placeholder="web, ecommerce, laravel"
              />
              <small class="text-muted">Separados por coma.</small>
            </div>

            <div class="col-12 col-md-6">
              <FieldSwitch
                id="project-featured"
                label="Proyecto destacado"
                v-model="form.is_featured"
              />
            </div>
          </div>
        </div>
        <div class="card-footer bg-transparent border-top pt-3 pb-3">
            <FormActions
              :submitText="'Guardar'"
              :submittingText="'Guardando...'"
              :cancelHref="`/member/listings/${listing?.id}/projects`"
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
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FieldSwitch from '@/Components/Fields/FieldSwitch.vue'
import FieldImage from '@/Components/Fields/FieldImage.vue'
import FormActions from '@/Components/FormActions.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const categories = computed(() => page.props.categories || [])

const errors = reactive({
  title: '',
  slug: '',
  description: '',
  tags: '',
  category_id: '',
})

const validateForm = () => {
  let isValid = true

  errors.title = ''
  errors.slug = ''
  errors.description = ''
  errors.tags = ''
  errors.category_id = ''

  if (!form.title || form.title.trim() === '') {
    errors.title = 'El titulo es obligatorio.'
    isValid = false
  } else if (form.title.length > 150) {
    errors.title = 'El titulo no puede tener mas de 150 caracteres.'
    isValid = false
  }

  return isValid
}

const sending = ref(false)
const businessMenu = computed(() => page.props.businessMenu || [])
const projectImages = ref([])

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Proyectos', href: `/member/listings/${listing.value?.id}/projects` },
  { label: 'Nuevo' },
])

const form = reactive({
  title: '',
  slug: '',
  description: '',
  tags: '',
  is_active: true,
  is_featured: false,
  sort_order: 0,
  category_id: '',
})

const generateSlug = () => {
  if (form.title && !form.slug) {
    form.slug = form.title.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '')
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
      if (typeof val === 'boolean') {
        formData.append(key, val ? '1' : '0')
      } else {
        formData.append(key, val)
      }
    }
  })
  if (projectImages.value instanceof File) {
    formData.append('image', projectImages.value)
  }
  router.post(`/member/listings/${listing.value.id}/projects`, formData, {
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
