<template>
  <MemberLayout>
    <Head :title="`${listing.name} - Editar Personalidad`" />
    <PageHeader
      title="Editar Personalidad"
      :breadcrumbs="breadcrumbs"
    >
      <template #actions>
        <Link :href="`/member/listings/${listing.id}/ai-chatbot/personalities`" class="btn btn-outline-dark rounded-pill">
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
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
              <h5 class="mb-0">Información General</h5>
            </div>
            <div class="card-body">
              <FieldText
                id="personality-key"
                label="Key"
                v-model="form.key"
                required
              />

              <FieldText
                id="personality-display-name"
                label="Nombre para Mostrar"
                v-model="form.display_name"
                required
              />

              <FieldTextarea
                id="personality-description"
                label="Descripción"
                v-model="form.description"
                :rows="2"
              />

              <FieldTextarea
                id="personality-system-prompt-hint"
                label="Hint para System Prompt"
                v-model="form.system_prompt_hint"
                :rows="3"
              />
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
              <h5 class="mb-0">Configuración</h5>
            </div>
            <div class="card-body">
              <FieldNumber
                id="personality-temperature"
                label="Temperatura por Defecto"
                v-model="form.default_temperature"
                :min="0"
                :max="1"
                :step="0.05"
              />

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

              <FieldNumber
                id="personality-sort-order"
                label="Orden"
                v-model="form.sort_order"
                :min="0"
              />

              <FieldSwitch
                id="personality-active"
                label="Activa"
                v-model="form.is_active"
              />
            </div>
          </div>

          <button type="submit" class="btn btn-gradient w-100" :disabled="saving">
            <span v-if="saving">Guardando...</span>
            <span v-else>Actualizar Personalidad</span>
          </button>
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
