<template>
  <div class="config-tab">
    <div v-if="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-2"></i>{{ successMessage }}
      <button type="button" class="btn-close" @click="successMessage = null"></button>
    </div>

    <div v-if="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle me-2"></i>{{ errorMessage }}
      <button type="button" class="btn-close" @click="errorMessage = null"></button>
    </div>

    <form @submit.prevent="saveSettings">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0"><i class="bi bi-robot me-2"></i>Configuración del Chatbot</h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <FieldSelect
                id="chatbot-provider"
                label="Proveedor de IA"
                v-model="form.provider"
                :options="[
                  { value: 'openai', label: 'OpenAI' },
                  { value: 'minimax', label: 'MiniMax' }
                ]"
              />
            </div>

            <div class="col-12 col-md-6">
              <FieldText
                id="chatbot-api-key"
                label="API Key"
                v-model="form.api_key"
                type="password"
                placeholder="sk-..."
                autocomplete="off"
                help-text="Tu API key se guarda de forma segura y encriptada"
              />
            </div>

            <div class="col-12 col-md-6">
              <FieldSelect
                id="chatbot-model"
                label="Modelo de Chat"
                v-model="form.model"
                :options="[
                  { value: 'gpt-4o-mini', label: 'GPT-4o Mini (Recomendado)' },
                  { value: 'gpt-4o', label: 'GPT-4o' },
                  { value: 'gpt-4-turbo', label: 'GPT-4 Turbo' },
                  { value: 'gpt-3.5-turbo', label: 'GPT-3.5 Turbo' }
                ]"
              />
            </div>

            <div class="col-12 col-md-6">
              <FieldSelect
                id="chatbot-embedding-model"
                label="Modelo de Embeddings"
                v-model="form.embedding_model"
                :options="[
                  { value: 'text-embedding-3-small', label: 'text-embedding-3-small (Recomendado)' },
                  { value: 'text-embedding-3-large', label: 'text-embedding-3-large' },
                  { value: 'text-embedding-ada-002', label: 'text-embedding-ada-002' }
                ]"
              />
            </div>

            <div class="col-12">
              <FieldTextarea
                id="chatbot-system-prompt"
                label="System Prompt"
                v-model="form.system_prompt"
                placeholder="Eres un asistente amigable de {business_name}..."
                :rows="4"
                help-text="Usa {business_name} para incluir el nombre del negocio automáticamente."
              />
            </div>

            <div class="col-12 col-md-6">
              <FieldSelect
                id="chatbot-preset"
                label="Preset Principal"
                v-model="form.preset_id"
                :options="presetOptions"
              />
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label class="form-label">Presets Adicionales (opcional)</label>
                <div class="d-flex flex-wrap gap-2 mb-2">
                  <div
                    v-for="presetId in form.additional_preset_ids"
                    :key="presetId"
                    class="badge bg-primary d-flex align-items-center gap-1"
                  >
                    {{ getPresetName(presetId) }}
                    <button type="button" class="btn-close btn-close-white" @click="removeAdditionalPreset(presetId)"></button>
                  </div>
                </div>
                <select v-model="newAdditionalPreset" class="form-select" @change="addAdditionalPreset">
                  <option :value="null">Agregar preset adicional...</option>
                  <option
                    v-for="preset in availableAdditionalPresets"
                    :key="preset.id"
                    :value="preset.id"
                  >
                    {{ preset.name }} {{ preset.business_id ? '(Propio)' : '' }}
                  </option>
                </select>
                <div class="form-text">Los presets adicionales se usan como contexto adicional en las conversaciones</div>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <FieldText
                id="chatbot-name"
                label="Nombre del Chatbot"
                v-model="form.chatbot_name"
                placeholder="Asistente Virtual"
                :maxlength="100"
                help-text="Nombre que aparecerá en el chat"
              />
            </div>

            <div class="col-12 col-md-6">
              <div class="mb-3">
                <label class="form-label">Logo del Chatbot</label>
                <input
                  type="file"
                  accept="image/jpeg,image/png"
                  @change="onAvatarChange"
                  class="form-control"
                />
                <div class="form-text">JPG o PNG, máximo 1MB</div>
                <div v-if="form.chatbot_avatar_preview || form.chatbot_avatar" class="mt-2">
                  <img
                    :src="form.chatbot_avatar_preview || form.chatbot_avatar"
                    alt="Avatar"
                    class="rounded"
                    style="max-height: 60px; object-fit: contain;"
                  />
                </div>
              </div>
            </div>

            <div class="col-12 col-md-4">
              <FieldColorpicker
                id="widget-color"
                label="Color del Widget"
                v-model="form.widget_color"
              />
            </div>

            <div class="col-12 col-md-4">
              <FieldSelect
                id="widget-theme"
                label="Tema del Widget"
                v-model="form.widget_theme"
                :options="[
                  { value: 'light', label: 'Light' },
                  { value: 'dark', label: 'Dark' }
                ]"
              />
            </div>

            <div class="col-12 col-md-4">
              <FieldSwitch
                id="allow-reset-chat"
                label="Permitir reiniciar chat"
                v-model="form.allow_reset_chat"
              />
            </div>

            <div class="col-12 col-md-4">
              <FieldNumber
                id="max-conversations"
                label="Conversaciones/mes"
                v-model="form.max_conversations_month"
                :min="1"
                :max="10000"
              />
            </div>

            <div class="col-12 col-md-4">
              <FieldNumber
                id="max-messages"
                label="Mensajes/conversación"
                v-model="form.max_messages_conversation"
                :min="1"
                :max="500"
              />
            </div>

            <div class="col-12 col-md-4">
              <FieldNumber
                id="max-tokens"
                label="Tokens máx. por respuesta"
                v-model="form.max_tokens_response"
                :min="100"
                :max="4000"
              />
            </div>

            <div class="col-12 col-md-4">
              <FieldNumber
                id="rag-max-results"
                label="Resultados RAG máx."
                v-model="form.rag_max_results"
                :min="1"
                :max="20"
                help-text="Fragmentos de contexto retrievalados"
              />
            </div>

            <div class="col-12 col-md-4">
              <FieldNumber
                id="rag-min-similarity"
                label="Similitud mínima RAG"
                v-model="form.rag_min_similarity"
                :min="0"
                :max="1"
                :step="0.05"
                help-text="0 = cualquier cosa, 1 = idéntico"
              />
            </div>

            <div class="col-12 col-md-4">
              <FieldSelect
                id="chatbot-personality"
                label="Personalidad"
                v-model="form.personality"
                :options="[
                  { value: 'professional', label: 'Profesional' },
                  { value: 'friendly', label: 'Amigable' },
                  { value: 'formal', label: 'Formal' },
                  { value: 'casual', label: 'Casual' }
                ]"
              />
            </div>

            <div class="col-12 col-md-4">
              <FieldSelect
                id="response-length"
                label="Longitud de Respuesta"
                v-model="form.response_length"
                :options="[
                  { value: 'short', label: 'Corta' },
                  { value: 'medium', label: 'Media' },
                  { value: 'long', label: 'Larga' }
                ]"
              />
            </div>

            <div class="col-12 col-md-4">
              <FieldSwitch
                id="expandable-responses"
                label="Respuestas expandibles"
                v-model="form.expandable_responses"
              />
            </div>

            <div class="col-12 col-md-4">
              <FieldSwitch
                id="show-citations"
                label="Mostrar fuentes"
                v-model="form.show_citations"
              />
            </div>

            <div class="col-12">
              <FieldSwitch
                id="chatbot-enabled"
                label="Chatbot habilitado"
                v-model="form.is_enabled"
                help-text="Cuando está desactivado, el chatbot no aparece en el minisite"
              />
            </div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-link-45deg me-2"></i>CTA por Intencion</h5>
          </div>
          <div class="card-body">
            <div class="alert alert-info small mb-3">
              <i class="bi bi-info-circle me-1"></i>
              Configura botones CTA específicos según la intención de la pregunta del usuario.
            </div>
            <div class="row g-3">
              <div class="col-md-6">
                <div class="intent-cta-item p-3 border rounded">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-primary">Reservas/Citas</span>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch" v-model="form.intent_appointment_enabled" id="intentAppointment" />
                    </div>
                  </div>
                  <input type="text" v-model="form.intent_appointment_text" class="form-control form-control-sm mb-2" placeholder="Texto del botón" />
                  <input type="text" v-model="form.intent_appointment_url" class="form-control form-control-sm mb-2" placeholder="URL (ej: /reservas)" />
                  <input type="text" v-model="form.intent_appointment_keywords" class="form-control form-control-sm" placeholder="Keywords (separadas por coma): agendar, reserva, cita" />
                </div>
              </div>

              <div class="col-md-6">
                <div class="intent-cta-item p-3 border rounded">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-success"> Compras/Precios</span>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch" v-model="form.intent_purchase_enabled" id="intentPurchase" />
                    </div>
                  </div>
                  <input type="text" v-model="form.intent_purchase_text" class="form-control form-control-sm mb-2" placeholder="Texto del botón" />
                  <input type="text" v-model="form.intent_purchase_url" class="form-control form-control-sm mb-2" placeholder="URL (ej: /productos)" />
                  <input type="text" v-model="form.intent_purchase_keywords" class="form-control form-control-sm" placeholder="Keywords (separadas por coma): precio, comprar, producto" />
                </div>
              </div>

              <div class="col-md-6">
                <div class="intent-cta-item p-3 border rounded">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-info">Contacto</span>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch" v-model="form.intent_contact_enabled" id="intentContact" />
                    </div>
                  </div>
                  <input type="text" v-model="form.intent_contact_text" class="form-control form-control-sm mb-2" placeholder="Texto del botón" />
                  <input type="text" v-model="form.intent_contact_url" class="form-control form-control-sm mb-2" placeholder="URL (ej: /contacto)" />
                  <input type="text" v-model="form.intent_contact_keywords" class="form-control form-control-sm" placeholder="Keywords (separadas por coma): contacto, telefono, email" />
                </div>
              </div>

              <div class="col-md-6">
                <div class="intent-cta-item p-3 border rounded">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-warning text-dark">Soporte/Ayuda</span>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch" v-model="form.intent_support_enabled" id="intentSupport" />
                    </div>
                  </div>
                  <input type="text" v-model="form.intent_support_text" class="form-control form-control-sm mb-2" placeholder="Texto del botón" />
                  <input type="text" v-model="form.intent_support_url" class="form-control form-control-sm mb-2" placeholder="URL (ej: /soporte)" />
                  <input type="text" v-model="form.intent_support_keywords" class="form-control form-control-sm" placeholder="Keywords (separadas por coma): ayuda, soporte, problema" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-whatsapp me-2"></i>WhatsApp</h5>
          </div>
          <div class="card-body">
            <div class="alert alert-info small mb-3">
              <i class="bi bi-info-circle me-1"></i>
              Ofrece al usuario continuar la conversación por WhatsApp. El botón aparecerá automáticamente cuando el chatbot lo mencione.
            </div>
            <div class="row g-3">
              <div class="col-12">
                <div class="form-check form-switch mb-3">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                    v-model="form.whatsapp_enabled"
                    id="whatsappEnabled"
                  />
                  <label class="form-check-label" for="whatsappEnabled">
                    <strong>Habilitar oferta de WhatsApp</strong>
                    <div class="form-text">El chatbot podrá ofrecer continuar por WhatsApp</div>
                  </label>
                </div>
              </div>

              <div v-if="form.whatsapp_enabled" class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">
                    Número de WhatsApp
                    <i class="bi bi-question-circle text-muted ms-1" style="cursor: help;" title="Número con código de país, ej: 521234567890"></i>
                  </label>
                  <input
                    type="text"
                    v-model="form.whatsapp_number"
                    class="form-control"
                    placeholder="521234567890"
                  />
                </div>
              </div>

              <div v-if="form.whatsapp_enabled" class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">
                    Mensaje pre-llenado
                    <i class="bi bi-question-circle text-muted ms-1" style="cursor: help;" title="Mensaje que aparecerá pre-llenado en WhatsApp"></i>
                  </label>
                  <input
                    type="text"
                    v-model="form.whatsapp_prefill_message"
                    class="form-control"
                    placeholder="Hola, vengo del chat de..."
                  />
                </div>
              </div>

              <div v-if="form.whatsapp_enabled" class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">
                    Activar después de
                    <i class="bi bi-question-circle text-muted ms-1" style="cursor: help;" title="Número de intercambios de mensajes antes de permitir ofrecer WhatsApp"></i>
                  </label>
                  <div class="input-group">
                    <input
                      type="number"
                      v-model.number="form.whatsapp_trigger_after"
                      class="form-control"
                      min="1"
                      max="20"
                    />
                    <span class="input-group-text">mensajes</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

          <div class="card mb-4">
            <div class="card-header">
              <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i>Captura de Leads</h5>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-12">
                  <div class="form-check form-switch mb-3">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                    v-model="form.lead_capture_enabled"
                    id="leadCaptureEnabled"
                  />
                  <label class="form-check-label" for="leadCaptureEnabled">
                    <strong>Captura de leads</strong>
                    <div class="form-text">Muestra un formulario sutil para collects correos electrónicos</div>
                  </label>
                </div>
              </div>

              <div v-if="form.lead_capture_enabled" class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">
                    Titulo del mensaje
                    <i class="bi bi-question-circle text-muted ms-1" style="cursor: help;" title="Titulo que aparecera en el popup de captura de email."></i>
                  </label>
                  <input
                    type="text"
                    v-model="form.lead_capture_title"
                    class="form-control"
                    placeholder="¿Te gustaría recibir noticias sobre nosotros?"
                    maxlength="200"
                  />
                </div>
              </div>

              <div v-if="form.lead_capture_enabled" class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Descripcion</label>
                  <input
                    type="text"
                    v-model="form.lead_capture_description"
                    class="form-control"
                    placeholder="Déjanos tu correo y te mantendremos informado."
                    maxlength="500"
                  />
                </div>
              </div>

              <div v-if="form.lead_capture_enabled" class="col-12">
                <div class="alert alert-info small">
                  <i class="bi bi-info-circle me-1"></i>
                  El formulario de captura aparecera automaticamente despues de 3 mensajes del usuario.
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-clock me-2"></i>Pausa Programada</h5>
          </div>
          <div class="card-body">
            <div class="alert alert-info small mb-3">
              <i class="bi bi-info-circle me-1"></i>
              Programa horarios en los que el chatbot no estará disponible. Útil para evitar uso fuera de horario laboral o durante días específicos.
            </div>
            <div class="row g-3">
              <div class="col-12">
                <div class="form-check form-switch mb-3">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                    v-model="form.scheduled_pause_enabled"
                    id="scheduledPauseEnabled"
                  />
                  <label class="form-check-label" for="scheduledPauseEnabled">
                    <strong>Activar pausa programada</strong>
                    <div class="form-text">El chatbot se ocultará automáticamente según el horario configurado</div>
                  </label>
                </div>
              </div>

              <div v-if="form.scheduled_pause_enabled" class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Hora de inicio de pausa</label>
                  <input
                    type="time"
                    v-model="form.scheduled_pause_start"
                    class="form-control"
                  />
                  <div class="form-text">Cuando comienza la pausa</div>
                </div>
              </div>

              <div v-if="form.scheduled_pause_enabled" class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Hora de fin de pausa</label>
                  <input
                    type="time"
                    v-model="form.scheduled_pause_end"
                    class="form-control"
                  />
                  <div class="form-text">Cuando termina la pausa</div>
                </div>
              </div>

              <div v-if="form.scheduled_pause_enabled" class="col-12">
                <div class="mb-3">
                  <label class="form-label d-block">Días de la semana</label>
                  <div class="form-text mb-2">Selecciona los días en que apply la pausa</div>
                  <div class="d-flex flex-wrap gap-3">
                    <div class="form-check" v-for="day in weekDays" :key="day.value">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        :id="'day-' + day.value"
                        :checked="form.scheduled_pause_days.includes(day.value)"
                        @change="togglePauseDay(day.value)"
                      />
                      <label class="form-check-label" :for="'day-' + day.value">
                        {{ day.label }}
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div v-if="form.scheduled_pause_enabled" class="col-12">
                <div class="alert alert-warning small">
                  <i class="bi bi-exclamation-triangle me-1"></i>
                  <strong>Nota:</strong> Durante la pausa, el widget del chatbot no se mostrará. Los usuarios tampoco podrán interactuar con él. <span v-if="form.scheduled_pause_start && form.scheduled_pause_end">El horario de pausa es de {{ form.scheduled_pause_start }} a {{ form.scheduled_pause_end }}.</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <FormActions
          :submitText="'Guardar Configuracion'"
          :submittingText="'Guardando...'"
          :sending="saving"
        />
      </div>
    </form>
  </div>
</template>

<script setup>
import { computed, ref, reactive, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FieldNumber from '@/Components/Fields/FieldNumber.vue'
import FieldSwitch from '@/Components/Fields/FieldSwitch.vue'
import FieldColorpicker from '@/Components/Fields/FieldColorpicker.vue'
import FormActions from '@/Components/FormActions.vue'

const props = defineProps({
  business: Object,
  settings: Object,
  presets: {
    type: Array,
    default: () => [],
  },
})

const emit = defineEmits(['saved'])

const saving = ref(false)
const successMessage = ref(null)
const errorMessage = ref(null)

const defaultForm = {
  provider: 'openai',
  api_key: '',
  model: 'gpt-4o-mini',
  embedding_model: 'text-embedding-3-small',
  system_prompt: '',
  chatbot_name: '',
  chatbot_avatar: '',
  chatbot_avatar_preview: '',
  preset_id: null,
  additional_preset_ids: [],
  personality: 'friendly',
  response_length: 'medium',
  expandable_responses: true,
  show_citations: true,
  max_conversations_month: 500,
  max_messages_conversation: 50,
  max_tokens_response: 500,
  widget_color: '#3B82F6',
  widget_theme: 'light',
  is_enabled: false,
  allow_reset_chat: false,
  url_import_max_chars: 5000,
  rag_min_similarity: 0.25,
  rag_max_results: 5,
  lead_capture_enabled: false,
  lead_capture_title: '¿Te gustaría recibir noticias sobre nosotros?',
  lead_capture_description: 'Déjanos tu correo y te mantendremos informado.',
  intent_appointment_enabled: false,
  intent_appointment_text: 'Agendar cita',
  intent_appointment_url: '',
  intent_appointment_keywords: 'agendar, reserva, cita, turno',
  intent_purchase_enabled: false,
  intent_purchase_text: 'Ver precios',
  intent_purchase_url: '',
  intent_purchase_keywords: 'precio, comprar, producto',
  intent_contact_enabled: false,
  intent_contact_text: 'Contactar',
  intent_contact_url: '',
  intent_contact_keywords: 'contacto, telefono, email',
  intent_support_enabled: false,
  intent_support_text: 'Obtener ayuda',
  intent_support_url: '',
  intent_support_keywords: 'ayuda, soporte, problema',
  whatsapp_enabled: false,
  whatsapp_number: '',
  whatsapp_prefill_message: '',
  whatsapp_trigger_after: 7,
  scheduled_pause_enabled: false,
  scheduled_pause_start: '22:00',
  scheduled_pause_end: '08:00',
  scheduled_pause_days: [],
}

const form = reactive({ ...defaultForm })

  watch(
  () => props.settings,
  (newSettings) => {
    if (newSettings) {
      form.provider = newSettings.provider || 'openai'
      form.api_key = newSettings.api_key || ''
      form.model = newSettings.model || 'gpt-4o-mini'
      form.embedding_model = newSettings.embedding_model || 'text-embedding-3-small'
      form.system_prompt = newSettings.system_prompt || ''
      form.chatbot_name = newSettings.chatbot_name || ''
      form.chatbot_avatar = newSettings.chatbot_avatar || ''
      form.chatbot_avatar_preview = ''
      form.preset_id = newSettings.preset_id || null
      form.additional_preset_ids = newSettings.additional_preset_ids || []
      form.personality = newSettings.personality || 'friendly'
      form.response_length = newSettings.response_length || 'medium'
      form.expandable_responses = newSettings.expandable_responses ?? true
      form.show_citations = newSettings.show_citations ?? true
      form.max_conversations_month = newSettings.max_conversations_month || 500
      form.max_messages_conversation = newSettings.max_messages_conversation || 50
      form.max_tokens_response = newSettings.max_tokens_response || 500
      form.widget_color = newSettings.widget_color || '#3B82F6'
      form.widget_theme = newSettings.widget_theme || 'light'
      form.is_enabled = newSettings.is_enabled || false
      form.allow_reset_chat = newSettings.allow_reset_chat || false
      form.url_import_max_chars = newSettings.url_import_max_chars || 5000
      form.rag_min_similarity = newSettings.rag_min_similarity ?? 0.25
      form.rag_max_results = newSettings.rag_max_results || 5

      const rawIntentCta = newSettings?.intent_cta
      const intentCta = typeof rawIntentCta === 'string' ? JSON.parse(rawIntentCta) : (rawIntentCta || {})
      form.intent_appointment_enabled = intentCta.appointment?.enabled || false
      form.intent_appointment_text = intentCta.appointment?.text || 'Agendar cita'
      form.intent_appointment_url = intentCta.appointment?.url || ''
      form.intent_appointment_keywords = intentCta.appointment?.keywords || 'agendar, reserva, cita, turno'
      form.intent_purchase_enabled = intentCta.purchase?.enabled || false
      form.intent_purchase_text = intentCta.purchase?.text || 'Ver precios'
      form.intent_purchase_url = intentCta.purchase?.url || ''
      form.intent_purchase_keywords = intentCta.purchase?.keywords || 'precio, comprar, producto'
      form.intent_contact_enabled = intentCta.contact?.enabled || false
      form.intent_contact_text = intentCta.contact?.text || 'Contactar'
      form.intent_contact_url = intentCta.contact?.url || ''
      form.intent_contact_keywords = intentCta.contact?.keywords || 'contacto, telefono, email'
      form.intent_support_enabled = intentCta.support?.enabled || false
      form.intent_support_text = intentCta.support?.text || 'Obtener ayuda'
      form.intent_support_url = intentCta.support?.url || ''
      form.intent_support_keywords = intentCta.support?.keywords || 'ayuda, soporte, problema'

      form.lead_capture_enabled = newSettings.lead_capture_enabled || false
      form.lead_capture_title = newSettings.lead_capture_title || '¿Te gustaría recibir noticias sobre nosotros?'
      form.lead_capture_description = newSettings.lead_capture_description || 'Déjanos tu correo y te mantendremos informado.'

      form.whatsapp_enabled = newSettings.whatsapp_enabled || false
      form.whatsapp_number = newSettings.whatsapp_number || ''
      form.whatsapp_prefill_message = newSettings.whatsapp_prefill_message || ''
      form.whatsapp_trigger_after = newSettings.whatsapp_trigger_after || 7

      form.scheduled_pause_enabled = newSettings.scheduled_pause_enabled || false
      form.scheduled_pause_start = newSettings.scheduled_pause_start || '22:00'
      form.scheduled_pause_end = newSettings.scheduled_pause_end || '08:00'
      form.scheduled_pause_days = newSettings.scheduled_pause_days || []
    }
  },
  { immediate: true }
)

const newAdditionalPreset = ref(null)

const presetOptions = computed(() => [
  { value: null, label: 'Ninguno (personalizado)' },
  ...props.presets.map(p => ({
    value: p.id,
    label: `${p.name}${p.business_id ? ' (Propio)' : ''}`
  }))
])

const availableAdditionalPresets = computed(() => {
  return props.presets.filter(p =>
    p.id !== form.preset_id &&
    !form.additional_preset_ids.includes(p.id)
  )
})

const weekDays = [
  { value: 'sunday', label: 'Domingo' },
  { value: 'monday', label: 'Lunes' },
  { value: 'tuesday', label: 'Martes' },
  { value: 'wednesday', label: 'Miércoles' },
  { value: 'thursday', label: 'Jueves' },
  { value: 'friday', label: 'Viernes' },
  { value: 'saturday', label: 'Sábado' },
]

const togglePauseDay = (day) => {
  const index = form.scheduled_pause_days.indexOf(day)
  if (index === -1) {
    form.scheduled_pause_days.push(day)
  } else {
    form.scheduled_pause_days.splice(index, 1)
  }
}

const getPresetName = (presetId) => {
  const preset = props.presets.find(p => p.id === presetId)
  return preset ? preset.name : 'Preset #' + presetId
}

const addAdditionalPreset = () => {
  if (newAdditionalPreset.value && !form.additional_preset_ids.includes(newAdditionalPreset.value)) {
    form.additional_preset_ids.push(newAdditionalPreset.value)
  }
  newAdditionalPreset.value = null
}

const removeAdditionalPreset = (presetId) => {
  form.additional_preset_ids = form.additional_preset_ids.filter(id => id !== presetId)
}

const saveSettings = () => {
  saving.value = true
  successMessage.value = null
  errorMessage.value = null

  const formData = new FormData()
  formData.append('provider', form.provider)
  formData.append('api_key', form.api_key)
  formData.append('model', form.model)
  formData.append('embedding_model', form.embedding_model)
  formData.append('system_prompt', form.system_prompt)
  formData.append('chatbot_name', form.chatbot_name)
  formData.append('preset_id', form.preset_id || '')
  form.additional_preset_ids.forEach(id => {
    formData.append('additional_preset_ids[]', id)
  })
  formData.append('personality', form.personality)
  formData.append('response_length', form.response_length)
  formData.append('expandable_responses', form.expandable_responses ? '1' : '0')
  formData.append('show_citations', form.show_citations ? '1' : '0')
  formData.append('max_conversations_month', form.max_conversations_month)
  formData.append('max_messages_conversation', form.max_messages_conversation)
  formData.append('max_tokens_response', form.max_tokens_response)
  formData.append('widget_color', form.widget_color)
  formData.append('widget_theme', form.widget_theme)
  formData.append('is_enabled', form.is_enabled ? '1' : '0')
  formData.append('allow_reset_chat', form.allow_reset_chat ? '1' : '0')
  formData.append('url_import_max_chars', form.url_import_max_chars)
  formData.append('rag_min_similarity', form.rag_min_similarity)
  formData.append('rag_max_results', form.rag_max_results)
  formData.append('scheduled_pause_enabled', form.scheduled_pause_enabled ? '1' : '0')
  formData.append('scheduled_pause_start', form.scheduled_pause_start || '')
  formData.append('scheduled_pause_end', form.scheduled_pause_end || '')
  form.scheduled_pause_days.forEach(day => {
    formData.append('scheduled_pause_days[]', day)
  })

  const intentCta = JSON.stringify({
    appointment: { enabled: form.intent_appointment_enabled, text: form.intent_appointment_text, url: form.intent_appointment_url, keywords: form.intent_appointment_keywords },
    purchase: { enabled: form.intent_purchase_enabled, text: form.intent_purchase_text, url: form.intent_purchase_url, keywords: form.intent_purchase_keywords },
    contact: { enabled: form.intent_contact_enabled, text: form.intent_contact_text, url: form.intent_contact_url, keywords: form.intent_contact_keywords },
    support: { enabled: form.intent_support_enabled, text: form.intent_support_text, url: form.intent_support_url, keywords: form.intent_support_keywords },
  })
  formData.append('intent_cta', intentCta)

  const whatsappSettings = JSON.stringify({
    enabled: form.whatsapp_enabled,
    number: form.whatsapp_number,
    prefill_message: form.whatsapp_prefill_message,
    trigger_after: form.whatsapp_trigger_after,
  })
  formData.append('whatsapp_settings', whatsappSettings)

  const leadCaptureSettings = JSON.stringify({
    enabled: form.lead_capture_enabled,
    title: form.lead_capture_title,
    description: form.lead_capture_description,
  })
  formData.append('lead_capture_settings', leadCaptureSettings)

  if (form.chatbot_avatar_file) {
    formData.append('chatbot_avatar', form.chatbot_avatar_file)
  }

  router.post(`/member/listings/${props.business.id}/ai-chatbot/settings`, formData, {
    preserveScroll: true,
    onSuccess: () => {
      emit('saved')
      form.chatbot_avatar_preview = ''
      delete form.chatbot_avatar_file
    },
    onError: (errors) => {
      errorMessage.value = Object.values(errors)[0] || 'Error al guardar.'
    },
    onFinish: () => {
      saving.value = false
    },
  })
}

const onAvatarChange = (event) => {
  const file = event.target.files[0]
  if (file) {
    if (file.size > 1024 * 1024) {
      alert('La imagen debe ser menor a 1MB')
      event.target.value = ''
      return
    }
    if (!['image/jpeg', 'image/png'].includes(file.type)) {
      alert('Solo se permiten archivos JPG o PNG')
      event.target.value = ''
      return
    }
    form.chatbot_avatar_file = file
    form.chatbot_avatar_preview = URL.createObjectURL(file)
  }
}
</script>

<style lang="less" scoped>
.config-tab {
  .card {
    border: 1px solid #e9ecef;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    padding: 16px 20px;
  }

  .card-footer {
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    padding: 16px 20px;
  }

  .form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 8px;
  }

  .color-input-wrapper {
    display: flex;
    gap: 8px;

    .color-input {
      width: 50px;
      height: 38px;
      padding: 2px;
      border: 1px solid #ced4da;
      border-radius: 4px;
      cursor: pointer;
    }

    .color-text {
      flex: 1;
      max-width: 120px;
    }
  }

  code {
    background: #e9ecef;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.875em;
  }

  .stat-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 16px;
    text-align: center;

    .stat-value {
      font-size: 1.5rem;
      font-weight: 700;
      color: #0d6efd;
    }

    .stat-label {
      font-size: 0.875rem;
      color: #6c757d;
      margin-top: 4px;
    }
  }
}
</style>
