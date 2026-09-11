<template>
  <MemberLayout>
    <Head :title="`Ticket #${ticket.id}`" />

    <PageHeader :title="ticket.subject" :breadcrumbs="breadcrumbs">
      <template #actions>
        <Link href="/member/support" class="btn btn-outline-secondary rounded-pill">
          <i class="bi bi-arrow-left me-1"></i>Volver
        </Link>
      </template>
    </PageHeader>

    <div class="row g-3">
      <div class="col-12 col-lg-4">
        <div class="app-datatable">
          <div class="app-datatable__header">
            <h6 class="text-uppercase text-muted mb-0 fw-normal">
              <i class="bi bi-info-circle me-1"></i>Informacion del ticket
            </h6>
          </div>
          <div class="app-datatable__table-wrapper">
            <dl class="row p-3 mb-0">
              <dt class="col-4 text-muted small text-uppercase">Estado</dt>
              <dd class="col-8">
                <span class="badge" :class="statusClass(ticket.status)">{{ ticket.status }}</span>
              </dd>
              <dt class="col-4 text-muted small text-uppercase">Prioridad</dt>
              <dd class="col-8 fw-semibold">{{ ticket.priority || '-' }}</dd>
              <dt class="col-4 text-muted small text-uppercase">Categoria</dt>
              <dd class="col-8 fw-semibold">{{ ticket.department || '-' }}</dd>
              <dt class="col-4 text-muted small text-uppercase">Creado</dt>
              <dd class="col-8">{{ ticket.created_at }}</dd>
              <dt class="col-4 text-muted small text-uppercase">Ultima respuesta</dt>
              <dd class="col-8">{{ ticket.last_reply_at || '-' }}</dd>
            </dl>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-8 d-flex flex-column">
        <div class="app-datatable flex-grow-1 d-flex flex-column">
          <div class="app-datatable__header">
            <h6 class="text-uppercase text-muted mb-0 fw-normal">
              <i class="bi bi-chat-left-text me-1"></i>Conversacion
            </h6>
          </div>
          <div class="app-datatable__table-wrapper flex-grow-1" style="min-height: 400px;">
            <div v-if="ticket.messages.length === 0" class="app-datatable__empty">
              <i class="bi bi-chat-dots"></i>
              <div class="app-datatable__empty-title">Sin mensajes aun</div>
              <div class="app-datatable__empty-text">Inicia la conversacion.</div>
            </div>

            <div v-else class="chat-messages p-3">
              <div
                v-for="(message, index) in ticket.messages"
                :key="message.id"
                class="chat-bubble mb-3"
                :class="message.is_admin ? 'chat-bubble-admin' : 'chat-bubble-user'"
              >
                <div class="chat-header">
                  <div class="chat-avatar">
                    <i :class="message.is_admin ? 'bi bi-headset' : 'bi bi-person'"></i>
                  </div>
                  <div class="chat-meta">
                    <span class="chat-author">{{ message.is_admin ? 'Soporte' : (message.author?.name || 'Usuario') }}</span>
                    <span class="chat-time">{{ message.created_at }}</span>
                  </div>
                </div>
                <div class="chat-content">
                  {{ message.message }}
                </div>
              </div>
            </div>
          </div>

          <div class="app-datatable__footer" v-if="ticket.status !== 'closed'">
            <form @submit.prevent="submit" class="p-3">
              <div class="mb-3">
                <FieldTextarea
                  id="ticket-reply"
                  label="Tu respuesta"
                  v-model="form.message"
                  :formError="form.errors.message"
                  placeholder="Escribe tu mensaje aqui..."
                  rows="3"
                  required
                />
              </div>
              <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary rounded-pill" :disabled="form.processing || !form.message">
                  <i class="bi bi-send me-1"></i>
                  {{ form.processing ? 'Enviando...' : 'Enviar respuesta' }}
                </button>
              </div>
            </form>
          </div>

          <div class="app-datatable__footer text-center" v-else>
            <span class="text-muted">
              <i class="bi bi-lock me-1"></i>Este ticket esta cerrado
            </span>
          </div>
        </div>
      </div>
    </div>
  </MemberLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'

const props = defineProps({
  ticket: {
    type: Object,
    required: true,
  },
})

const form = useForm({
  message: '',
})

const submit = () => {
  form.post(`/member/support/${props.ticket.id}/reply`)
}

const breadcrumbs = computed(() => [
  { label: 'Soporte', href: '/member/support' },
  { label: `Ticket #${props.ticket.id}`, active: true },
])

const statusClass = (value) => {
  if (value === 'open') return 'bg-success'
  if (value === 'pending') return 'bg-warning text-dark'
  if (value === 'answered') return 'bg-primary'
  if (value === 'closed') return 'bg-secondary'
  return 'bg-secondary'
}
</script>

<style scoped>
.chat-messages {
  max-height: 500px;
  overflow-y: auto;
}

.chat-bubble {
  max-width: 85%;
  padding: 12px 16px;
  border-radius: 12px;
  position: relative;
}

.chat-bubble-user {
  background: var(--bs-info-bg-subtle);
  border-bottom-left-radius: 4px;
  margin-right: auto;
}

.chat-bubble-admin {
  background: var(--bs-primary-bg-subtle);
  border-bottom-right-radius: 4px;
  margin-left: auto;
}

.chat-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 8px;
}

.chat-avatar {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
}

.chat-bubble-user .chat-avatar {
  background: var(--bs-secondary-bg);
  color: var(--bs-secondary-color);
}

.chat-bubble-admin .chat-avatar {
  background: var(--bs-primary);
  color: white;
}

.chat-meta {
  display: flex;
  flex-direction: column;
}

.chat-author {
  font-weight: 600;
  font-size: 13px;
}

.chat-bubble-user .chat-author {
  color: var(--bs-body-color);
}

.chat-bubble-admin .chat-author {
  color: var(--bs-primary);
}

.chat-time {
  font-size: 11px;
  color: var(--bs-secondary-color);
}

.chat-content {
  font-size: 14px;
  line-height: 1.5;
  color: var(--bs-body-color);
  white-space: pre-wrap;
}
</style>
