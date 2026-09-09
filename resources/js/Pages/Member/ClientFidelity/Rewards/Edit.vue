<template>
  <MemberLayout>
    <Head :title="`Editar Recompensa - ${reward?.title}`" />

    <PageHeader
      :title="`Editar: ${reward?.title}`"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing?.id}/fidelity-rewards`"
    />

    <form @submit.prevent="submit">
        <div class="card">
          <div class="card-header bg-transparent border-bottom pb-2 pt-2 d-flex justify-content-between align-items-center">
            <h6 class="text-uppercase text-muted mb-0 fw-normal">
              <i class="bi bi-pencil-square me-1"></i>Editar recompensa
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

              <div v-if="imagePreview || form.existing_image" class="mt-3">
                <img
                  :src="imagePreview || `/storage/${form.existing_image}`"
                  alt="Preview"
                  class="img-thumbnail"
                  style="max-height: 200px;"
                />
                <div class="form-check mt-2">
                  <input
                    id="remove-image"
                    v-model="form.remove_image"
                    class="form-check-input"
                    type="checkbox"
                  />
                  <label class="form-check-label" for="remove-image">
                    Eliminar imagen actual
                  </label>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="d-flex align-items-center gap-3">
                <span class="text-muted small">
                  {{ reward?.cards_count || 0 }} tarjetas asociadas
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer bg-transparent border-top pt-3 pb-3 d-flex justify-content-between align-items-center">
          <button type="button" class="btn btn-danger rounded-pill py-2" @click="deleteReward">
            <i class="bi bi-trash me-1"></i>Eliminar
          </button>
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
import { ref, computed, watch } from 'vue'
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
const reward = computed(() => page.props.reward)
const sending = ref(false)
const errors = ref({})
const imagePreview = ref(null)

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Fidelización', href: `/member/listings/${listing.value?.id}/fidelity-cards` },
  { label: 'Recompensas', href: `/member/listings/${listing.value?.id}/fidelity-rewards` },
  { label: reward.value?.title || 'Editar' },
])

const form = ref({
  title: '',
  description: '',
  max_visits: 5,
  is_active: true,
  image: null,
  existing_image: '',
  remove_image: false,
})

watch(reward, (newReward) => {
  if (newReward) {
    form.value.title = newReward.title || ''
    form.value.description = newReward.description || ''
    form.value.max_visits = newReward.max_visits || 5
    form.value.is_active = newReward.is_active ?? true
    form.value.existing_image = newReward.image || ''
  }
}, { immediate: true })

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
  formData.append('remove_image', form.value.remove_image ? '1' : '0')
  if (form.value.image) {
    formData.append('image', form.value.image)
  }

  router.post(`/member/listings/${listing.value?.id}/fidelity-rewards/${reward.value?.id}?_method=PUT`, formData, {
    preserveScroll: true,
    onSuccess: () => {
      sending.value = false
    },
    onError: (errs) => {
      sending.value = false
      errors.value = errs
    },
  })
}

const deleteReward = () => {
  if (!confirm(`Eliminar la recompensa "${reward.value?.title}"?`)) return
  router.delete(`/member/listings/${listing.value?.id}/fidelity-rewards/${reward.value?.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      window.location.href = `/member/listings/${listing.value?.id}/fidelity-rewards`
    },
  })
}
</script>

<script>
import { defineComponent, ref } from 'vue'
export default defineComponent({
  inheritAttrs: false,
})
</script>