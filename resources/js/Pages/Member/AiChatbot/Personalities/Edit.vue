<template>
  <MemberLayout>
    <Head :title="`${listing.name} - Editar Personalidad`" />
    <PageHeader
      title="Editar Personalidad"
      :breadcrumbs="breadcrumbs"
    >
      <template #actions>
        <Link :href="`/member/listings/${listing.id}/ai-chatbot/personalities`" class="btn btn-secondary rounded-pill">
          <i class="bi bi-arrow-left me-1"></i>Volver
        </Link>
      </template>
    </PageHeader>

    <div v-if="$page.props.flash?.error" class="alert alert-danger">
      {{ $page.props.flash.error }}
    </div>

    <div v-if="$page.props.errors && Object.keys($page.props.errors).length" class="alert alert-danger">
      <ul class="mb-0">
        <li v-for="(error, key) in $page.props.errors" :key="key">{{ error }}</li>
      </ul>
    </div>

    <form v-if="personality" @submit.prevent="submit">
      <div class="row g-3">
        <div class="col-lg-8">
          <div class="card border-0 shadow-sm mb-4 bg-body-bg">
            <div class="card-header bg-transparent border-bottom pb-2 pt-2">
              <h6 class="text-uppercase text-muted mb-0 fw-normal">
                <i class="bi bi-person-gear me-1"></i>Información General
              </h6>
            </div>
            <div class="card-body">
              <div class="row g-3 mb-3">
                <div class="col-12">
                  <FieldText
                    id="personality-key"
                    label="Key"
                    v-model="form.key"
                    required
                  />
                </div>
                <div class="col-12">
                  <FieldText
                    id="personality-display-name"
                    label="Nombre para Mostrar"
                    v-model="form.display_name"
                    required
                  />
                </div>
                <div class="col-12">
                  <FieldTextarea
                    id="personality-description"
                    label="Descripción"
                    v-model="form.description"
                    :rows="2"
                  />
                </div>
                <div class="col-12">
                  <FieldTextarea
                    id="personality-system-prompt-hint"
                    label="Hint para System Prompt"
                    v-model="form.system_prompt_hint"
                    :rows="3"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card border-0 shadow-sm mb-4 bg-body-bg">
            <div class="card-header bg-transparent border-bottom pb-2 pt-2">
              <h6 class="text-uppercase text-muted mb-0 fw-normal">
                <i class="bi bi-gear me-1"></i>Configuración
              </h6>
            </div>
            <div class="card-body">
              <div class="row g-3 mb-3">
                <div class="col-12">
                  <FieldNumber
                    id="personality-temperature"
                    label="Temperatura por Defecto"
                    v-model="form.default_temperature"
                    :min="0"
                    :max="1"
                    :step="0.05"
                  />
                </div>
                <div class="col-12">
                  <FieldSelect
                    id="personality-response-length"
                    label="Longitud de Respuesta por Defecto"
                    v-model="form.default_response_length"
                    :options="[
                      { value: 'short', label: 'Corta' },
                      { value: 'medium', label: 'Media' },
                      { value: 'long', label: 'Larga' }
                    ]"
                  />
                </div>
                <div class="col-12">
                  <FieldNumber
                    id="personality-sort-order"
                    label="Orden"
                    v-model="form.sort_order"
                    :min="0"
                  />
                </div>
                <div class="col-12">
                  <FieldSwitch
                    id="personality-active"
                    label="Activa"
                    v-model="form.is_active"
                  />
                </div>
              </div>
            </div>
          </div>

          <FormActions
            :submitText="'Actualizar Personalidad'"
            :submittingText="'Guardando...'"
            :cancelHref="`/member/listings/${listing.id}/ai-chatbot/personalities`"
            :sending="saving"
          />
        </div>
      </div>
    </form>
  </MemberLayout>
</template>

<script setup>
import { computed, reactive, ref, watchEffect } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FieldNumber from '@/Components/Fields/FieldNumber.vue'
import FieldSwitch from '@/Components/Fields/FieldSwitch.vue'
import FormActions from '@/Components/FormActions.vue'

const page = usePage()
const listing = page.props.listing
const personality = computed(() => page.props.personality)
const saving = ref(false)

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Chatbot', href: `/member/listings/${listing?.id}/ai-chatbot` },
  { label: 'Personalidades', href: `/member/listings/${listing?.id}/ai-chatbot/personalities` },
  { label: personality.value?.display_name || 'Editar', active: true },
])

const form = reactive({
  key: '',
  display_name: '',
  description: '',
  system_prompt_hint: '',
  default_temperature: 0.70,
  default_response_length: 'medium',
  is_active: true,
  sort_order: 0,
})

const initializeForm = () => {
  if (personality.value) {
    form.key = personality.value.key || ''
    form.display_name = personality.value.display_name || ''
    form.description = personality.value.description || ''
    form.system_prompt_hint = personality.value.system_prompt_hint || ''
    form.default_temperature = parseFloat(personality.value.default_temperature) || 0.70
    form.default_response_length = personality.value.default_response_length || 'medium'
    form.is_active = personality.value.is_active ?? true
    form.sort_order = personality.value.sort_order || 0
  }
}

watchEffect(() => {
  if (personality.value) {
    initializeForm()
  }
})

const submit = () => {
  saving.value = true
  router.put(`/member/listings/${listing.id}/ai-chatbot/personalities/${personality.value.id}`, form, {
    onFinish: () => {
      saving.value = false
    },
  })
}
</script>
