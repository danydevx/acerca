<template>
  <MemberLayout>
    <Head title="API Keys" />

    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
      <div>
        <h1 class="h4 mb-1">API Keys</h1>
        <p class="text-muted mb-0">Gestiona claves para integraciones externas.</p>
      </div>
    </div>

    <div v-if="plainKey" class="alert alert-warning">
      <div class="fw-semibold mb-1">Copia esta API key ahora. No volvera a mostrarse.</div>
      <div class="d-flex flex-wrap align-items-center gap-2">
        <code class="bg-secondary-subtle border rounded px-2 py-1">{{ plainKey }}</code>
        <button class="btn btn-secondary rounded-pill btn-sm" type="button" @click="copyKey">Copiar</button>
      </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
      <div class="card-body">
        <h2 class="h6 mb-3">Crear API key</h2>
        <form class="row g-2" @submit.prevent="submit">
          <div class="col-12 col-md-5">
            <FieldText
              id="apikey-name"
              label="Nombre"
              v-model="form.name"
              :form-error="form.errors.name"
              placeholder="Ej: Integracion CRM"
              required
            />
          </div>
          <div class="col-12 col-md-3">
            <FieldText
              id="apikey-expires"
              label="Expira (opcional)"
              v-model="form.expires_at"
              type="date"
              :form-error="form.errors.expires_at"
            />
          </div>
          <div class="col-12 col-md-4 d-flex align-items-end">
            <button class="btn btn-primary rounded-pill w-100" type="submit" :disabled="form.processing">
              {{ form.processing ? 'Creando...' : 'Crear API key' }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <MemberTable
      :items="apiKeys"
      :columns="columns"
      :get-row-actions="getRowActions"
      empty-title="No hay API keys creadas"
      empty-text=""
      :show-pagination="false"
    >
      <template #cell-name="{ row }">
        <strong>{{ row.name }}</strong>
      </template>
      <template #cell-key_prefix="{ row }">
        <span class="text-muted">{{ row.key_prefix || '-' }}</span>
      </template>
      <template #cell-status="{ row }">
        <span v-if="row.revoked_at" class="badge text-bg-secondary">Revocada</span>
        <span v-else-if="row.is_active" class="badge text-bg-success">Activa</span>
        <span v-else class="badge text-bg-warning">Inactiva</span>
      </template>
      <template #cell-last_used_at="{ row }">
        <span class="text-muted">{{ row.last_used_at || '-' }}</span>
      </template>
      <template #cell-expires_at="{ row }">
        <span class="text-muted">{{ row.expires_at || '-' }}</span>
      </template>
      <template #cell-created_at="{ row }">
        <span class="text-muted">{{ row.created_at }}</span>
      </template>
    </MemberTable>
  </MemberLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head, router, useForm, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import MemberTable from '@/Components/Member/MemberTable.vue'

const props = defineProps({
  apiKeys: {
    type: Array,
    default: () => [],
  },
})

const page = usePage()
const plainKey = computed(() => page.props.flash?.api_key_plain || '')

const form = useForm({
  name: '',
  expires_at: '',
})

const columns = [
  { key: 'name', label: 'Nombre', sortable: false },
  { key: 'key_prefix', label: 'Prefijo', sortable: false },
  { key: 'status', label: 'Estado', sortable: false },
  { key: 'last_used_at', label: 'Último uso', sortable: false },
  { key: 'expires_at', label: 'Expira', sortable: false },
  { key: 'created_at', label: 'Creada', sortable: false },
  { key: 'actions', label: '', sortable: false, class: 'text-end' },
]

const getRowActions = (key) => {
  const actions = []
  if (!key.revoked_at) {
    actions.push({ label: key.is_active ? 'Desactivar' : 'Activar', icon: 'bi bi-toggle-on', onClick: () => toggleKey(key) })
  }
  actions.push({ label: 'Revocar', icon: 'bi bi-x-circle', danger: true, disabled: !!key.revoked_at, onClick: () => revokeKey(key) })
  return actions
}

const submit = () => {
  form.post('/member/api-keys', {
    preserveScroll: true,
    onSuccess: () => form.reset('name', 'expires_at'),
  })
}

const toggleKey = (key) => {
  router.put(`/member/api-keys/${key.id}`, {
    name: key.name,
    is_active: !key.is_active,
    expires_at: key.expires_at || null,
  })
}

const revokeKey = (key) => {
  if (!confirm('Vas a revocar esta API key. Esta accion no se puede deshacer.')) return
  router.delete(`/member/api-keys/${key.id}`)
}

const copyKey = async () => {
  if (!plainKey.value) return
  try {
    await navigator.clipboard.writeText(plainKey.value)
  } catch (error) {
    // ignore
  }
}
</script>
