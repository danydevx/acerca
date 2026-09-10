<template>
  <MemberLayout>
    <Head title="Sesiones" />

    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
      <div>
        <h1 class="h4 mb-1">Sesiones activas</h1>
        <p class="text-muted mb-0">Gestiona las sesiones abiertas en tu cuenta.</p>
      </div>
      <button class="btn btn-danger btn-sm" type="button" @click="closeOthers">
        Cerrar otras sesiones
      </button>
    </div>

    <MemberTable
      :items="sessions"
      :columns="columns"
      :get-row-actions="getRowActions"
      empty-title="No hay sesiones activas"
      empty-text=""
      :show-pagination="false"
    >
      <template #cell-is_current="{ row }">
        <span v-if="row.is_current" class="badge text-bg-success">Sesion actual</span>
        <span v-else class="badge text-bg-secondary">Activa</span>
      </template>
      <template #cell-ip_address="{ row }">
        <span class="text-muted">{{ row.ip_address || '-' }}</span>
      </template>
      <template #cell-user_agent="{ row }">
        <span class="text-muted">{{ row.user_agent }}</span>
      </template>
      <template #cell-last_activity="{ row }">
        <span class="text-muted">{{ row.last_activity }}</span>
      </template>
    </MemberTable>
  </MemberLayout>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import MemberTable from '@/Components/Member/MemberTable.vue'

const props = defineProps({
  sessions: {
    type: Array,
    default: () => [],
  },
})

const columns = [
  { key: 'is_current', label: 'Estado', sortable: false },
  { key: 'ip_address', label: 'IP', sortable: false },
  { key: 'user_agent', label: 'Dispositivo', sortable: false },
  { key: 'last_activity', label: 'Ultima actividad', sortable: false },
  { key: 'actions', label: 'Acciones', sortable: false, class: 'text-end' },
]

const getRowActions = (session) => {
  return [
    { label: 'Cerrar', icon: 'bi bi-x-circle', danger: true, disabled: session.is_current, onClick: () => closeSession(session) },
  ]
}

const closeSession = (session) => {
  if (session.is_current) return
  if (!confirm('Cerrar esta sesion?')) return
  router.delete(`/member/sessions/${session.id}`, { preserveScroll: true })
}

const closeOthers = () => {
  if (!confirm('Cerrar todas las otras sesiones?')) return
  router.delete('/member/sessions/others', { preserveScroll: true })
}
</script>
