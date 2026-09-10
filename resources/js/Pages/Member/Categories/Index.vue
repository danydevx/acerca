<template>
  <MemberLayout>
    <Head title="Categorías del Menú" />

    <PageHeader
      title="Categorías del Menú"
      :breadcrumbs="breadcrumbs"
      :backHref="'/member/listings'"
    >
      <template #tabs>
        <div class="dropdown">
          <button class="btn btn-secondary rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="bi bi-cup-hot me-1"></i>Menú
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <Link :href="`/member/listings/${listing?.id}/menu-products`" class="dropdown-item">
                <i class="bi bi-cup-hot me-2"></i>Productos
              </Link>
            </li>
            <li>
              <Link :href="`/member/listings/${listing?.id}/menu-categories`" class="dropdown-item active">
                <i class="bi bi-folder me-2"></i>Categorías
              </Link>
            </li>
          </ul>
        </div>
      </template>
      <template #actions>
        <button @click="openCreateModal" class="btn btn-primary rounded-pill">
          <i class="bi bi-plus-lg me-1"></i>Nueva Categoría
        </button>
      </template>
    </PageHeader>

    <div class="py-3">
      <div v-if="$page.props.flash?.success" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $page.props.flash.success }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <div v-if="$page.props.flash?.error" class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $page.props.flash.error }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>

      <div v-if="categories.length === 0" class="alert alert-info">
        No hay categorías creadas. Crea tu primera categoría para empezar.
      </div>

      <div class="row g-3">
        <div v-for="category in categories" :key="category.id" class="col-12 col-md-6 col-lg-4">
          <div class="card h-100">
            <div v-if="category.images && category.images.length > 0" class="card-img-top overflow-hidden" style="max-height: 120px;">
              <img :src="category.images[0].path" class="w-100 h-100 object-fit-cover" :alt="category.title" style="min-height: 120px;" />
            </div>
            <div class="card-header d-flex justify-content-between align-items-center">
              <div class="text-truncate">
                <span :class="{ 'text-muted': !category.active }">
                  <strong class="text-truncate">{{ category.title }}</strong>
                  <span v-if="!category.active" class="badge bg-secondary ms-2">Inactiva</span>
                </span>
                <small class="text-muted d-block">{{ category.children?.length || 0 }} subcategorías, {{ category.products?.length || 0 }} productos</small>
              </div>
              <MemberTableActions :actions="[
                { label: 'Editar', icon: 'bi bi-pencil', onClick: () => editCategory(category) },
                { label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => deleteCategory(category) }
              ]" />
            </div>
            <div class="card-body py-2">
              <p v-if="category.description" class="text-muted small mb-0 text-truncate">{{ category.description }}</p>
            </div>
            <div class="card-footer bg-transparent py-2">
              <Link :href="`/member/listings/${listing?.id}/menu-products?category=${category.id}`" class="btn btn-sm btn-link text-decoration-none">
                <i class="bi bi-box-seam me-1"></i>Ver productos
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div ref="modalElement" class="modal fade" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ editingCategory ? 'Editar Categoría' : 'Nueva Categoría' }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form @submit.prevent="submitForm">
            <div class="modal-body">
              <div class="mb-3">
                <FieldText
                  id="category-title"
                  label="Nombre de la categoría"
                  v-model="form.title"
                  required
                />
              </div>
              <div class="mb-3">
                <FieldTextarea
                  id="category-description"
                  label="Descripción"
                  v-model="form.description"
                  :rows="2"
                />
              </div>
              <div class="mb-3">
                <FieldSelect
                  id="category-parent"
                  label="Categoría padre"
                  v-model="form.parent_id"
                >
                  <option :value="null">Ninguna (categoría principal)</option>
                  <option v-for="cat in flatCategories" :key="cat.id" :value="cat.id">
                    {{ cat.nested_title }}
                  </option>
                </FieldSelect>
              </div>
              <div class="mb-3">
                <label class="form-label">Imagen</label>
                <input
                  ref="imageInput"
                  type="file"
                  class="form-control"
                  accept="image/jpeg,image/png,image/webp,image/gif"
                  @change="handleImageChange"
                />
                <div v-if="imagePreview" class="mt-2">
                  <img :src="imagePreview" class="img-thumbnail" style="max-height: 120px;" alt="Preview" />
                </div>
                <small class="text-muted d-block">JPG, PNG o WebP, máx 5MB</small>
                <button
                  v-if="editingCategory?.images?.length > 0"
                  type="button"
                  class="btn btn-sm btn-outline-danger rounded-pill mt-2"
                  @click="removeImage"
                >
                  <i class="bi bi-trash me-1"></i>Eliminar imagen
                </button>
              </div>
              <div class="mb-3">
                <FieldSwitch
                  id="category-active"
                  label="Activa"
                  v-model="form.active"
                />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary rounded-pill" :disabled="sending">
                {{ sending ? 'Guardando...' : 'Guardar' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </MemberLayout>
</template>

<script setup>
import { ref, computed, onMounted, nextTick } from 'vue'
import { Head, usePage, Link, router } from '@inertiajs/vue3'
import { Modal } from 'bootstrap'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import MemberTableActions from '@/Components/Member/MemberTableActions.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FieldSwitch from '@/Components/Fields/FieldSwitch.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const categories = computed(() => page.props.categories || [])
const businessMenu = computed(() => page.props.businessMenu || [])

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Menú', href: `/member/listings/${listing.value?.id}/menu-products` },
  { label: 'Categorías' },
])

const modalElement = ref(null)
let categoryModal = null

const editingCategory = ref(null)
const sending = ref(false)
const imagePreview = ref(null)
const imageInput = ref(null)

const form = ref({
  title: '',
  description: '',
  parent_id: null,
  image: null,
  remove_image: false,
  active: true,
})

const flatCategories = computed(() => {
  const flat = []
  const flatten = (cats, prefix = '') => {
    cats.forEach(cat => {
      flat.push({
        id: cat.id,
        title: cat.title,
        nested_title: prefix + cat.title,
      })
      if (cat.children && cat.children.length) {
        flatten(cat.children, prefix + cat.title + ' > ')
      }
    })
  }
  flatten(categories.value || [])
  return flat
})

const openCreateModal = () => {
  editingCategory.value = null
  imagePreview.value = null
  if (imageInput.value) imageInput.value.value = ''
  form.value = {
    title: '',
    description: '',
    parent_id: null,
    image: null,
    remove_image: false,
    active: true,
  }
  nextTick(() => categoryModal.show())
}

const editCategory = (category) => {
  editingCategory.value = category
  imagePreview.value = null
  if (imageInput.value) imageInput.value.value = ''
  form.value = {
    title: category.title,
    description: category.description || '',
    parent_id: category.parent_id,
    image: null,
    remove_image: false,
    active: category.active,
  }
  if (category.images?.length > 0) {
    imagePreview.value = category.images[0].path
  }
  nextTick(() => categoryModal.show())
}

const handleImageChange = (e) => {
  const file = e.target.files[0]
  if (!file) return
  if (file.size > 5 * 1024 * 1024) {
    alert('El archivo supera el tamaño máximo de 5MB.')
    return
  }
  const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif']
  if (!allowedTypes.includes(file.type)) {
    alert('Solo se permiten imágenes (JPEG, PNG, WebP, GIF).')
    return
  }
  form.value.image = file
  imagePreview.value = URL.createObjectURL(file)
}

const deleteCategory = (category) => {
  if (!confirm(`Eliminar la categoría "${category.title}"?`)) return
  router.delete(`/member/listings/${listing.value.id}/menu-categories/${category.id}`, {
    preserveScroll: true,
  })
}

const removeImage = () => {
  form.value.remove_image = true
  imagePreview.value = null
  if (imageInput.value) imageInput.value.value = ''
}

const closeModal = () => {
  categoryModal.hide()
}

const submitForm = () => {
  sending.value = true
  const data = new FormData()
  data.append('title', form.value.title)
  data.append('description', form.value.description || '')
  data.append('parent_id', form.value.parent_id || '')
  data.append('active', form.value.active ? '1' : '0')

  if (form.value.image) {
    data.append('image', form.value.image)
  }
  if (form.value.remove_image) {
    data.append('remove_image', '1')
  }

  if (editingCategory.value) {
    data.append('_method', 'PUT')
    router.post(`/member/listings/${listing.value.id}/menu-categories/${editingCategory.value.id}`, data, {
      preserveScroll: true,
      onFinish: () => {
        sending.value = false
        closeModal()
      },
    })
  } else {
    router.post(`/member/listings/${listing.value.id}/menu-categories`, data, {
      preserveScroll: true,
      onFinish: () => {
        sending.value = false
        closeModal()
      },
    })
  }
}

onMounted(() => {
  categoryModal = new Modal(modalElement.value)
})
</script>
