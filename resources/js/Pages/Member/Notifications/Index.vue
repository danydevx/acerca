<template>
  <MemberLayout>
    <Head title="Notificaciones" />

    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
      <div>
        <h1 class="h4 mb-1">Notificaciones</h1>
        <p class="text-muted mb-0">Consulta tus eventos recientes y alertas internas.</p>
      </div>
      <div class="d-flex align-items-center gap-2">
        <div class="text-muted small">{{ unreadCount }} sin leer</div>
        <button
          type="button"
          class="btn btn-secondary rounded-pill"
          :disabled="!hasUnread"
          @click="markAllAsRead"
        >
          Marcar todas
        </button>
      </div>
    </div>

    <div class="app-datatable">
      <div class="app-datatable__header">
        <div>
          <h6 class="text-uppercase text-muted mb-0 fw-normal">
            <i class="bi bi-bell me-1"></i>Notificaciones
          </h6>
          <small class="text-muted">{{ unreadCount }} sin leer</small>
        </div>
        <div class="app-datatable__controls">
          <button
            type="button"
            class="btn btn-outline-primary rounded-pill"
            :disabled="!hasUnread"
            @click="markAllAsRead"
          >
            <i class="bi bi-check-all me-1"></i>Marcar todas como leidas
          </button>
        </div>
      </div>
      <div class="app-datatable__table-wrapper">
        <div v-if="notifications.data.length === 0" class="app-datatable__empty">
          <i class="bi bi-bell-slash"></i>
          <div class="app-datatable__empty-title">Aun no tienes notificaciones.</div>
        </div>

        <div v-else class="notifications-list">
          <div
            v-for="notification in notifications.data"
            :key="notification.id"
            class="notification-item"
            :class="{ 'notification-item--unread': !notification.is_read }"
          >
            <div class="notification-content">
              <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                <span class="fw-semibold">{{ notification.title }}</span>
                <span class="badge bg-secondary-subtle text-body">{{ formatType(notification.type) }}</span>
                <span
                  v-if="!notification.is_read"
                  class="badge bg-warning text-dark"
                >
                  No leida
                </span>
              </div>
              <div v-if="notification.message" class="text-muted mb-2">
                {{ notification.message }}
              </div>
              <div class="text-muted small">{{ formatDate(notification.created_at) }}</div>
            </div>
            <div class="notification-actions d-flex align-items-center gap-2">
              <Link
                v-if="notification.url"
                :href="notification.url"
                class="btn btn-primary btn-sm rounded-pill"
              >
                <i class="bi bi-eye me-1"></i>Ver
              </Link>
              <button
                v-if="!notification.is_read"
                type="button"
                class="btn btn-outline-secondary btn-sm rounded-pill"
                @click="markAsRead(notification)"
              >
                <i class="bi bi-check2 me-1"></i>Marcar leida
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="app-datatable__footer">
        <div class="text-muted small">
          Mostrando {{ notifications.data.length }} de {{ notifications.total }} notificaciones
        </div>
        <Pagination :links="notifications.links" />
      </div>
    </div>
  </MemberLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import Pagination from '@/Components/Member/Pagination.vue'

const props = defineProps({
  notifications: {
    type: Object,
    required: true,
  },
  unreadCount: {
    type: Number,
    default: 0,
  },
})

const hasUnread = computed(() => props.unreadCount > 0)

const markAsRead = (notification) => {
  router.put(`/member/notifications/${notification.id}/read`, {}, {
    preserveScroll: true,
  })
}

const markAllAsRead = () => {
  router.put('/member/notifications/read-all', {}, {
    preserveScroll: true,
  })
}

const formatType = (value) => {
  if (!value) return 'system'
  return value.replace('_', ' ')
}

const formatDate = (value) => {
  if (!value) return '-'
  const parsed = new Date(value)
  if (Number.isNaN(parsed.getTime())) {
    return value
  }
  return parsed.toLocaleString()
}
</script>

<style scoped>
.notifications-list {
  display: flex;
  flex-direction: column;
}

.notification-item {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1rem;
  padding: 1rem 1.25rem;
  border-bottom: 1px solid var(--bs-border-color);
  transition: background-color 0.15s;
}

.notification-item:hover {
  background-color: var(--bs-tertiary-bg);
}

.notification-item:last-child {
  border-bottom: none;
}

.notification-item--unread {
  background-color: var(--bs-info-bg-subtle);
}

.notification-item--unread:hover {
  background-color: var(--bs-warning-bg-subtle);
}

.notification-content {
  flex: 1;
  min-width: 0;
}

.notification-actions {
  flex-shrink: 0;
}
</style>
