<template>
  <MemberLayout>
    <Head :title="`${listing.name} - Nuevo Preset`" />
    <PageHeader
      title="Nuevo Preset"
      :breadcrumbs="breadcrumbs"
    >
      <template #actions>
        <Link :href="`/member/listings/${listing.id}/ai-chatbot/presets`" class="btn btn-outline-dark rounded-pill">
          <i class="bi bi-arrow-left me-1"></i>Volver
        </Link>
      </template>
    </PageHeader>

      <form @submit.prevent="submit">
        <div class="row g-3">
          <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-header bg-white py-3">
                <h5 class="mb-0">Información General</h5>
              </div>
              <div class="card-body">
                <FieldText
                  id="preset-name"
                  label="Nombre del Preset"
                  v-model="form.name"
                  :form-error="errors.name"
                  required
                />

                <FieldTextarea
                  id="preset-description"
                  label="Descripción"
                  v-model="form.description"
                  :rows="2"
                />

                <div class="row">
                  <div class="col-md-6">
                    <FieldSelect
                      id="preset-personality"
                      label="Personalidad"
                      v-model="form.personality"
                      :options="personalities.map(p => ({ value: p.key, label: p.display_name }))"
                      :form-error="errors.personality"
                      required
                    />
                  </div>
                  <div class="col-md-6">
                    <FieldSelect
                      id="preset-language"
                      label="Idioma"
                      v-model="form.language"
                      :options="languages.map(l => ({ value: l, label: l.toUpperCase() }))"
                      :form-error="errors.language"
                      required
                    />
                  </div>
                </div>
              </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
              <div class="card-header bg-white py-3">
                <h5 class="mb-0">Mensajes</h5>
              </div>
              <div class="card-body">
                <FieldText
                  id="preset-chatbot-name"
                  label="Nombre del Chatbot"
                  v-model="form.chatbot_name_template"
                />

                <FieldTextarea
                  id="preset-greeting"
                  label="Mensaje de Bienvenida"
                  v-model="form.greeting_message"
                  :rows="2"
                />

                <FieldTextarea
                  id="preset-fallback"
                  label="Mensaje de Fallback"
                  v-model="form.fallback_message"
                  :rows="2"
                />
              </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
              <div class="card-header bg-white py-3">
                <h5 class="mb-0">System Prompt</h5>
              </div>
              <div class="card-body">
                <FieldTextarea
                  id="preset-system-prompt"
                  label="Plantilla de System Prompt"
                  v-model="form.system_prompt_template"
                  :form-error="errors.system_prompt_template"
                  :rows="8"
                  required
                  help-text="Usa {business_name} como placeholder para el nombre del negocio."
                />
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-header bg-white py-3">
                <h5 class="mb-0">Sugerencias Iniciales</h5>
              </div>
              <div class="card-body">
                <div
                  v-for="(suggestion, index) in form.initial_suggestions"
                  :key="index"
                  class="input-group mb-2"
                >
                  <input
                    v-model="form.initial_suggestions[index]"
                    type="text"
                    class="form-control"
                    placeholder="Sugerencia..."
                  />
                  <button
                    type="button"
                    class="btn btn-outline-danger rounded-pill"
                    @click="removeSuggestion(index)"
                  >
                    <i class="bi bi-x"></i>
                  </button>
                </div>
                <button type="button"                 class="btn btn-gradient rounded-pill w-100" @click="addSuggestion">
                  <i class="bi bi-plus-lg me-1"></i>Agregar Sugerencia
                </button>
              </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
              <div class="card-header bg-white py-3">
                <h5 class="mb-0">Contextos RAG</h5>
              </div>
              <div class="card-body">
                <small class="text-muted d-block mb-2">
                  Selecciona los contextos que este preset usará para buscar información relevante (RAG).
                </small>
                <div v-if="contexts && contexts.length > 0">
                  <FieldCheckboxes
                    id="preset-contexts"
                    v-model="form.context_ids"
                    :options="contexts.map(c => ({ value: c.id, label: c.title }))"
                  />
                </div>
                <small v-else class="text-muted">
                  No hay contextos disponibles. Crea contextos en la sección de Configuración.
                </small>
              </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
              <div class="card-body">
                <FieldSwitch
                  id="preset-active"
                  label="Activo"
                  v-model="form.is_active"
                />
              </div>
            </div>

            <FormActions
              :submitText="'Crear Preset'"
              :submittingText="'Guardando...'"
              :cancelHref="`/member/listings/${listing.id}/ai-chatbot/presets`"
              :sending="saving"
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
import FormActions from '@/Components/FormActions.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FieldSwitch from '@/Components/Fields/FieldSwitch.vue'
import FieldCheckboxes from '@/Components/Fields/FieldCheckboxes.vue'

const page = usePage()
const listing = page.props.listing
const personalities = page.props.personalities || []
const languages = page.props.languages || ['es', 'en', 'pt', 'fr']
const contexts = page.props.contexts || []

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Chatbot', href: `/member/listings/${listing?.id}/ai-chatbot` },
  { label: 'Presets', href: `/member/listings/${listing?.id}/ai-chatbot/presets` },
  { label: 'Nuevo', active: true },
])

const saving = ref(false)

const form = reactive({
  name: '',
  description: '',
  personality: 'friendly',
  language: 'es',
  chatbot_name_template: '',
  greeting_message: '',
  fallback_message: '',
  system_prompt_template: '',
  initial_suggestions: ['', '', ''],
  context_ids: [],
  is_active: true,
})

const errors = reactive({
  name: '',
  personality: '',
  language: '',
  system_prompt_template: '',
})

const validateForm = () => {
  let isValid = true

  errors.name = ''
  errors.personality = ''
  errors.language = ''
  errors.system_prompt_template = ''

  if (!form.name || form.name.trim() === '') {
    errors.name = 'El nombre es obligatorio.'
    isValid = false
  } else if (form.name.length > 100) {
    errors.name = 'El nombre no puede tener más de 100 caracteres.'
    isValid = false
  }

  if (!form.personality) {
    errors.personality = 'La personalidad es obligatoria.'
    isValid = false
  }

  if (!form.language) {
    errors.language = 'El idioma es obligatorio.'
    isValid = false
  }

  if (!form.system_prompt_template || form.system_prompt_template.trim() === '') {
    errors.system_prompt_template = 'El system prompt es obligatorio.'
    isValid = false
  }

  return isValid
}

const addSuggestion = () => {
  form.initial_suggestions.push('')
}

const removeSuggestion = (index) => {
  form.initial_suggestions.splice(index, 1)
}

const submit = () => {
  if (!validateForm()) {
    toast.warning('Por favor completa los campos requeridos')
    return
  }

  saving.value = true

  const data = {
    ...form,
    initial_suggestions: form.initial_suggestions.filter(s => s.trim() !== ''),
  }

  router.post(`/member/listings/${listing.id}/ai-chatbot/presets`, data, {
    preserveScroll: true,
    onSuccess: () => {
      saving.value = false
    },
    onError: (errs) => {
      saving.value = false
      Object.keys(errs).forEach(key => {
        if (key in errors) {
          errors[key] = errs[key]
        }
      })
      toast.warning('Por favor completa los campos requeridos')
    },
    onFinish: () => {
      saving.value = false
    },
  })
}
</script>
