<template>
  <div class="preview-tab">
    <div class="preview-container">
      <div class="preview-header">
        <i class="bi bi-info-circle me-2"></i>
        Vista previa del widget de chat
      </div>

      <div v-if="!settings?.is_enabled" class="alert alert-warning mb-0">
        <i class="bi bi-exclamation-triangle me-2"></i>
        El chatbot está desactivado. Actívalo en la pestaña de Configuración para ver la vista previa.
      </div>

      <div v-else class="chat-widget-preview" :class="themeClass">
        <div class="chat-bubble" :style="{ backgroundColor: settings?.widget_color || '#3B82F6' }">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M12 2C6.48 2 2 5.58 2 10c0 1.82.62 3.49 1.64 4.83L2 22l4.17-.64A9.93 9.93 0 0012 22c5.52 0 10-3.58 10-8s-4.48-12-10-12z" fill="white"/>
            <circle cx="8" cy="10" r="1.5" :fill="settings?.widget_color || '#3B82F6'"/>
            <circle cx="12" cy="10" r="1.5" :fill="settings?.widget_color || '#3B82F6'"/>
            <circle cx="16" cy="10" r="1.5" :fill="settings?.widget_color || '#3B82F6'"/>
          </svg>
        </div>

        <div class="chat-window">
          <div class="chat-header">
            <div class="chat-header-info">
              <div class="chat-avatar">
                <img v-if="settings?.chatbot_avatar" :src="settings.chatbot_avatar" alt="Avatar" />
                <i v-else class="bi bi-robot"></i>
              </div>
              <div>
                <div class="chat-title">{{ settings?.chatbot_name || 'Asistente ' + business?.name }}</div>
                <div class="chat-status">
                  <span class="status-dot"></span> En línea
                </div>
              </div>
            </div>
            <div class="chat-header-actions">
              <button v-if="settings?.allow_reset_chat && messages.length > 0" class="chat-action-btn" @click="resetChat" title="Reiniciar chat">
                <i class="bi bi-arrow-counterclockwise"></i>
              </button>
              <button class="chat-close-btn">
                <i class="bi bi-x"></i>
              </button>
            </div>
          </div>

          <div class="chat-messages" ref="messagesContainer">
            <div v-if="messages.length === 0" class="chat-empty">
              <i class="bi bi-chat-dots"></i>
              <p>¡Hola! Soy {{ settings?.chatbot_name || 'el asistente virtual' }} de {{ business?.name }}. ¿En qué puedo ayudarte?</p>
            </div>

            <div
              v-for="(msg, index) in messages"
              :key="index"
              class="chat-message-wrapper"
              :class="msg.role"
            >
              <div class="message-content">
                {{ msg.content }}
              </div>
              <a
                v-if="msg.showCta && msg.showCta.url"
                :href="msg.showCta.url"
                target="_blank"
                class="message-cta-btn"
                :style="{ backgroundColor: settings?.widget_color || '#3B82F6' }"
              >
                <i class="bi bi-calendar-check me-1"></i>
                {{ msg.showCta.text || 'Ver más' }}
              </a>
              <a
                v-if="msg.showWhatsApp && !whatsappAccepted"
                href="#"
                @click.prevent="openWhatsApp"
                class="message-cta-btn whatsapp-btn"
              >
                <i class="bi bi-whatsapp me-1"></i>
                Continuar en WhatsApp
              </a>
            </div>

            <div v-if="isTyping" class="chat-message assistant">
              <div class="message-content typing">
                <span></span>
                <span></span>
                <span></span>
              </div>
            </div>
          </div>

          <div class="chat-input">
            <input
              type="text"
              v-model="inputMessage"
              :placeholder="settings?.is_enabled ? 'Escribe un mensaje...' : 'Chatbot desactivado'"
              :disabled="!settings?.is_enabled || sending"
              @keypress.enter="sendMessage"
            />
            <button
              class="send-btn"
              :disabled="!inputMessage.trim() || sending"
              @click="sendMessage"
            >
              <i v-if="sending" class="bi bi-hourglass-split"></i>
              <i v-else class="bi bi-send"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="preview-footer">
        <small class="text-muted">
          <i class="bi bi-lightbulb me-1"></i>
          Esta es una vista previa. El widget aparecerá en la esquina inferior derecha del minisite.
        </small>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, nextTick } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  business: Object,
  settings: Object,
})

const messages = ref([])
const inputMessage = ref('')
const sending = ref(false)
const isTyping = ref(false)
const messagesContainer = ref(null)
const localIntentCta = ref(null)

const CTA_KEYWORDS = ['agendar', 'reserva', 'cita', 'turno', 'reservar']
const CTA_MIN_EXCHANGES = 3
const ctaTriggeredAt = ref(null)
const ctaVisible = ref(false)

const whatsappEnabled = ref(false)
const whatsappNumber = ref('')
const whatsappPrefillMessage = ref('')
const whatsappTriggerAfter = ref(7)
const whatsappOfferShown = ref(false)
const whatsappAccepted = ref(false)

const sessionId = ref('preview-' + Math.random().toString(36).substring(7))

const themeClass = computed(() => {
  return props.settings?.widget_theme === 'dark' ? 'theme-dark' : 'theme-light'
})

const containsCtaKeyword = (msg) => {
  const text = msg.toLowerCase()
  return CTA_KEYWORDS.some(kw => text.includes(kw))
}

const shouldShowCta = (content, serverIntentCta) => {
  const intentCta = serverIntentCta || localIntentCta.value

  if (!intentCta || typeof intentCta !== 'object') {
    return null
  }

  const intentMap = [
    { intent: 'appointment', keywords: ['reserva', 'agendar', 'cita', 'turno', 'horario', 'disponible', 'agenda'] },
    { intent: 'purchase', keywords: ['precio', 'cost', 'comprar', 'venta', 'producto', 'cuanto cuesta', 'cuánto vale'] },
    { intent: 'contact', keywords: ['contacto', 'telefono', 'email', 'correo', 'hablar', 'comunicar'] },
    { intent: 'support', keywords: ['ayuda', 'soporte', 'problema', 'error', 'no funciona', 'ayudame'] },
  ]

  const lowerContent = content.toLowerCase()

  for (const item of intentMap) {
    if (item.keywords.some(kw => lowerContent.includes(kw))) {
      const intentConfig = intentCta[item.intent]
      if (intentConfig && typeof intentConfig === 'object' && intentConfig.enabled && intentConfig.url) {
        return intentConfig
      }
    }
  }

  return null
}

const buildWhatsAppMessage = () => {
  let message = (props.settings?.whatsapp_prefill_message || '') ? props.settings.whatsapp_prefill_message + '\n\n' : ''
  message += '--- Conversación del chat ---\n'
  messages.value.forEach((msg) => {
    const role = msg.role === 'user' ? 'Cliente' : 'Asistente'
    message += `${role}: ${msg.content}\n\n`
  })
  return message.trim()
}

const openWhatsApp = () => {
  if (!props.settings?.whatsapp_number) return
  whatsappAccepted.value = true
  const message = buildWhatsAppMessage()
  const url = `https://wa.me/${props.settings.whatsapp_number}?text=${encodeURIComponent(message)}`
  window.open(url, '_blank')
}

const containsWhatsAppKeyword = (msg) => {
  const text = msg.toLowerCase()
  return text.includes('whatsapp') || text.includes('wa.me')
}

const checkWhatsAppOffer = (aiMessage, msgIndex) => {
  if (!props.settings?.whatsapp_enabled) return
  if (whatsappAccepted.value) return

  const exchangeCount = messages.value.length / 2
  if (exchangeCount < (props.settings.whatsapp_trigger_after || 7)) return

  if (containsWhatsAppKeyword(aiMessage)) {
    messages.value[msgIndex].showWhatsApp = true
  }
}

const sendMessage = () => {
  if (!inputMessage.value.trim() || sending.value || !props.settings?.is_enabled) return

  const userMessage = inputMessage.value.trim()
  messages.value.push({
    role: 'user',
    content: userMessage,
  })

  if (containsCtaKeyword(userMessage) && ctaTriggeredAt.value === null) {
    ctaTriggeredAt.value = messages.value.length - 1
  }

  inputMessage.value = ''
  scrollToBottom()

  sending.value = true
  isTyping.value = true

  fetch(`/m/${props.business?.slug}/ai-chatbot/chat`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
    },
    body: JSON.stringify({
      message: userMessage,
      session_id: sessionId.value,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      isTyping.value = false
      sending.value = false

      if (data.success && data.message) {
        const currentIndex = messages.value.length
        let showCta = null

        if (ctaVisible.value) {
          showCta = localIntentCta.value?.appointment || null
        } else if (ctaTriggeredAt.value !== null) {
          const exchanges = Math.floor((currentIndex - ctaTriggeredAt.value) / 2)
          if (exchanges >= CTA_MIN_EXCHANGES) {
            ctaVisible.value = true
            showCta = localIntentCta.value?.appointment || null
          }
        }

        messages.value.push({
          role: 'assistant',
          content: data.message,
          showCta,
        })
        if (data.intent_cta && typeof data.intent_cta === 'object') {
          localIntentCta.value = data.intent_cta
        }

        checkWhatsAppOffer(data.message, messages.value.length - 1)
      } else {
        messages.value.push({
          role: 'assistant',
          content: data.message || 'Disculpa, estoy teniendo problemas para responder.',
          showCta: null,
        })
      }
      scrollToBottom()
    })
    .catch((err) => {
      isTyping.value = false
      sending.value = false
      messages.value.push({
        role: 'assistant',
        content: 'Disculpa, estoy teniendo problemas para responder. Intenta de nuevo.',
      })
      scrollToBottom()
    })
}

const scrollToBottom = () => {
  nextTick(() => {
    if (messagesContainer.value) {
      messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight
    }
  })
}

const resetChat = () => {
  if (confirm('¿Reiniciar la conversación?')) {
    messages.value = []
    sessionId.value = 'preview-' + Math.random().toString(36).substring(7)
  }
}
</script>

<style lang="less" scoped>
.preview-tab {
  .preview-container {
    max-width: 500px;
    margin: 0 auto;
  }

  .preview-header {
    background: #e7f1ff;
    border: 1px solid #b6d7ff;
    border-radius: 8px 8px 0 0;
    padding: 12px 16px;
    font-weight: 500;
    color: #0d6efd;
  }

  .preview-footer {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-top: none;
    border-radius: 0 0 8px 8px;
    padding: 12px 16px;
    text-align: center;
  }

  .chat-widget-preview {
    position: relative;
    border: 1px solid #e9ecef;
    border-top: none;
    background: #fff;
    height: 450px;
    display: flex;
    align-items: flex-end;
    padding: 16px;
    gap: 12px;
  }

  .chat-bubble {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: transform 0.2s;

    &:hover {
      transform: scale(1.05);
    }
  }

  .chat-window {
    flex: 1;
    max-width: 350px;
    height: 400px;
    border: 2px solid v-bind('settings?.widget_color || "#3B82F6"');
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    background: #fff;
  }

  .chat-header {
    padding: 12px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: v-bind('settings?.widget_color || "#3B82F6"');
    color: #fff;

    .chat-header-info {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .chat-avatar {
      width: 36px;
      height: 36px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
      overflow: hidden;

      img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
    }

    .chat-title {
      font-weight: 600;
      font-size: 0.9rem;
    }

    .chat-status {
      font-size: 0.75rem;
      display: flex;
      align-items: center;
      gap: 4px;
      opacity: 0.9;

      .status-dot {
        width: 8px;
        height: 8px;
        background: #4ade80;
        border-radius: 50%;
      }
    }

    .chat-close-btn {
      background: none;
      border: none;
      color: #fff;
      font-size: 1.25rem;
      cursor: pointer;
      opacity: 0.8;
      padding: 4px;

      &:hover {
        opacity: 1;
      }
    }

    .chat-header-actions {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .chat-action-btn {
      background: none;
      border: none;
      color: #fff;
      font-size: 1rem;
      cursor: pointer;
      opacity: 0.8;
      padding: 4px;

      &:hover {
        opacity: 1;
      }
    }
  }

  .chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
    background: #f8f9fa;

    .chat-empty {
      text-align: center;
      color: #6c757d;
      padding: 40px 20px;

      i {
        font-size: 3rem;
        margin-bottom: 12px;
        opacity: 0.3;
      }

      p {
        font-size: 0.9rem;
        margin: 0;
      }
    }
  }

  .chat-message-wrapper {
    margin-bottom: 12px;
    display: flex;
    flex-direction: column;

    &.user {
      align-items: flex-end;

      .message-content {
        background: #0d6efd;
        color: #fff;
        border-radius: 16px 16px 4px 16px;
      }
    }

    &.assistant {
      align-items: flex-start;

      .message-content {
        background: #fff;
        color: #212529;
        border-radius: 16px 16px 16px 4px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
      }
    }

    .message-content {
      max-width: 85%;
      padding: 10px 14px;
      font-size: 0.9rem;
      line-height: 1.4;
      white-space: pre-wrap;
      word-break: break-word;
    }

    .message-cta-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      max-width: 100%;
      margin-top: 8px;
      padding: 12px 16px;
      color: #fff;
      text-decoration: none;
      border-radius: 12px;
      font-size: 0.9rem;
      font-weight: 500;
      transition: opacity 0.2s;
      box-sizing: border-box;

      &:hover {
        opacity: 0.9;
        color: #fff;
      }

      &.whatsapp-btn {
        background: #25D366;

        &:hover {
          background: #20bd5a;
        }
      }
    }
  }

  @keyframes typing {
    0%, 60%, 100% {
      transform: translateY(0);
    }
    30% {
      transform: translateY(-4px);
    }
  }

  .chat-input {
    padding: 12px 16px;
    background: #fff;
    border-top: 1px solid #e9ecef;
    display: flex;
    gap: 8px;

    input {
      flex: 1;
      border: 1px solid #dee2e6;
      border-radius: 24px;
      padding: 10px 16px;
      font-size: 0.9rem;
      outline: none;

      &:focus {
        border-color: #0d6efd;
      }

      &:disabled {
        background: #e9ecef;
        cursor: not-allowed;
      }
    }

    .send-btn {
      width: 42px;
      height: 42px;
      border: none;
      border-radius: 50%;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: opacity 0.2s;
      background-color: v-bind('settings?.widget_color || "#3B82F6"');

      &:disabled {
        opacity: 0.5;
        cursor: not-allowed;
      }

      &:not(:disabled):hover {
        opacity: 0.9;
      }
    }
  }

  // Dark theme styles - uses widget color
  .chat-widget-preview.theme-dark {
    --widget-color: v-bind('settings?.widget_color || "#3B82F6"');

    .chat-window {
      background: #1a1a2e;
      border-color: v-bind('settings?.widget_color || "#3B82F6"');
    }

    .chat-header {
      background-color: v-bind('settings?.widget_color || "#3B82F6"');
      color: #fff;
    }

    .chat-messages {
      background: #16162a;

      .chat-empty {
        color: #9ca3af;

        i {
          opacity: 0.5;
        }
      }
    }

    .chat-message-wrapper {
      &.assistant {
        .message-content {
          background: #2a2a4a;
          color: #e5e5e5;
          box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }
      }

      &.user {
        .message-content {
          background: v-bind('settings?.widget_color || "#3B82F6"');
          color: #fff;
        }
      }
    }

    .chat-input {
      background: #1a1a2e;
      border-top-color: v-bind('settings?.widget_color || "#3B82F6"');

      input {
        background: #2a2a4a;
        border-color: v-bind('settings?.widget_color || "#3B82F6"');
        color: #e5e5e5;

        &:focus {
          border-color: v-bind('settings?.widget_color || "#3B82F6"');
        }

        &::placeholder {
          color: #9ca3af;
        }
      }
    }
  }
}
</style>
