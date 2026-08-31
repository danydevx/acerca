<template>
  <MemberLayout>
    <Head :title="`Editar Proyecto - ${listing?.name || ''}`" />

    <PageHeader
      title="Editar Proyecto"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing?.id}/projects`"
    />

    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <form @submit.prevent="submit">
          <div class="row g-3 mb-3">
            <div class="col-12 col-md-8">
              <FieldText
                id="project-title"
                label="Titulo"
                v-model="form.title"
                :formError="errors.title"
                placeholder="Nombre del proyecto"
                required
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

            <div class="col-12 col-md-6">
              <FieldSwitch
                id="project-active"
                label="Proyecto activo"
                v-model="form.is_active"
              />
            </div>

            <div class="col-12">
              <FieldImage
                id="project-image"
                label="Imagen principal"
                v-model="projectImages"
                :initialPreview="initialPreview"
                :maxFiles="1"
                :maxSizeMb="2"
                accept="image/jpeg"
                @update:keep="onImageKeepChange"
              />
              <small class="text-muted">JPG, max 2MB</small>
            </div>

            <div class="col-12">
              <ProjectImageUpload
                :businessId="listing?.id"
                :projectId="project?.id"
                :images="projectImagesList"
                :maxFiles="10"
                :maxSizeMb="2"
                label="Galería de imágenes"
                @updated="reloadPage"
              />
            </div>
          </div>

          <FormActions :submitText="'Guardar'" :submittingText="'Guardando...'" :cancelHref="`/member/listings/${listing?.id}/projects`" :sending="sending" />
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
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FieldSwitch from '@/Components/Fields/FieldSwitch.vue'
import FieldImage from '@/Components/Fields/FieldImage.vue'
import ProjectImageUpload from '@/Components/Fields/ProjectImageUpload.vue'
import FormActions from '@/Components/FormActions.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const project = computed(() => page.props.project)
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
const keepImage = ref(true)
const projectImages = ref([])
const projectImagesList = computed(() => page.props.projectImages || [])

const initialPreview = computed(() => {
  if (!project.value?.image) return []
  return [project.value.image]
})

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Proyectos', href: `/member/listings/${listing.value?.id}/projects` },
  { label: project.value?.title || 'Editar' },
])

const form = reactive({
  title: project.value?.title || '',
  slug: project.value?.slug || '',
  description: project.value?.description || '',
  tags: project.value?.tags || '',
  is_active: project.value?.is_active ?? true,
  is_featured: project.value?.is_featured ?? false,
  sort_order: project.value?.sort_order || 0,
  category_id: project.value?.category_id || '',
})

const onImageKeepChange = (keep) => {
  keepImage.value = keep
}

const reloadPage = () => {
  router.reload({ preserveScroll: true })
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

  if (!keepImage.value) {
    formData.append('_remove_image', '1')
  }

  formData.append('_method', 'PUT')

  router.post(`/member/listings/${listing.value.id}/projects/${project.value.id}`, formData, {
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
