<template>
  <MemberLayout>
    <Head title="Nueva Recompensa" />

    <PageHeader
      title="Nueva Recompensa"
      :breadcrumbs="breadcrumbs"
      backHref="/member/listings/fidelity-rewards"
    />

    <form @submit.prevent="submit">
        <div class="card">
          <div class="card-header bg-transparent border-bottom pb-2 pt-2 d-flex justify-content-between align-items-center">
            <h6 class="text-uppercase text-muted mb-0 fw-normal">
              <i class="bi bi-plus-circle me-1"></i>Crear recompensa
            </h6>
            <div class="form-check form-switch mb-0">
              <input class="form-check-input" type="checkbox" id="reward-active" v-model="form.is_active">
              <label class="form-check-label" for="reward-active">Activo</label>
            </div>
          </div>
          <div class="card-body">
            <div class="row g-3 mb-3">
            <div class="col-12">
              <FieldText
                id="reward-title"
                label="Título"
                v-model="form.title"
                :form-error="errors.title"
                placeholder="ej. Café gratis"
                required
              />
            </div>

            <div class="col-12">
              <FieldTextarea
                id="reward-description"
                label="Descripción"
                v-model="form.description"
                :rows="3"
                placeholder="Descripción del premio que obtendrá el cliente..."
              />
            </div>

            <div class="col-md-6">
              <FieldNumber
                id="reward-max-visits"
                label="Número de visitas"
                v-model="form.max_visits"
                :form-error="errors.max_visits"
                :min="2"
                :max="100"
                placeholder="ej. 5"
                help-text="Cantidad de visitas para completar la tarjeta"
                required
              />
            </div>

            <div class="col-md-6">
              <FieldSwitch
                id="reward-is-active"
                label="Estado"
                v-model="form.is_active"
              />
            </div>

            <div class="col-12">
              <label class="form-label">Imagen</label>
              <input
                id="reward-image"
                type="file"
                class="form-control"
                :class="{ 'is-invalid': errors.image }"
                accept="image/jpeg,image/png,image/webp"
                @change="handleImageChange"
              />
              <div v-if="errors.image" class="invalid-feedback">{{ errors.image }}</div>
              <div class="form-text">Imagen representativa del premio (opcional)</div>

              <div v-if="imagePreview" class="mt-3">
                <img :src="imagePreview" alt="Preview" class="img-thumbnail" style="max-height: 200px;" />
              </div>
            </div>
          </div>
          </div>
          <div class="card-footer bg-transparent border-top pt-3 pb-3">
            <FormActions
              :submitText="'Guardar'"
              :submittingText="'Guardando...'"
              :cancelHref="`/member/listings/${listing?.id}/fidelity-rewards`"
              :sending="sending"
            />
          </div>
        </div>
      </form>
  </MemberLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FieldNumber from '@/Components/Fields/FieldNumber.vue'
import FieldSwitch from '@/Components/Fields/FieldSwitch.vue'
import FormActions from '@/Components/FormActions.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const sending = ref(false)
const imagePreview = ref(null)

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Fidelización', href: `/member/listings/${listing.value?.id}/fidelity-cards` },
  { label: 'Recompensas', href: `/member/listings/${listing.value?.id}/fidelity-rewards` },
  { label: 'Nueva' },
])

const form = ref({
  title: '',
  description: '',
  max_visits: 5,
  is_active: true,
  image: null,
})

const errors = ref({})

const handleImageChange = (e) => {
  const file = e.target.files[0]
  if (file) {
    form.value.image = file
    imagePreview.value = URL.createObjectURL(file)
  }
}

const submit = () => {
  sending.value = true
  errors.value = {}

  const formData = new FormData()
  formData.append('title', form.value.title)
  formData.append('description', form.value.description || '')
  formData.append('max_visits', form.value.max_visits)
  formData.append('is_active', form.value.is_active ? '1' : '0')
  if (form.value.image) {
    formData.append('image', form.value.image)
  }

  router.post(`/member/listings/${listing.value?.id}/fidelity-rewards`, formData, {
    onSuccess: () => {
      sending.value = false
    },
    onError: (errs) => {
      sending.value = false
      errors.value = errs
    },
  })
}
</script>
