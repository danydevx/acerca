<template>
  <MemberLayout>
    <Head title="Webhooks" />

    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
      <div>
        <h1 class="h4 mb-1">Webhooks</h1>
        <p class="text-muted mb-0">Recibe notificaciones en tus sistemas externos.</p>
      </div>
    </div>

    <div v-if="secret" class="alert alert-warning">
      <div class="fw-semibold mb-1">Copia este secreto ahora. No volvera a mostrarse.</div>
      <div class="d-flex flex-wrap align-items-center gap-2">
        <code class="bg-light border rounded px-2 py-1">{{ secret }}</code>
        <button class="btn btn-secondary rounded-pill" type="button" @click="copySecret">Copiar</button>
      </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
      <div class="card-body">
        <h2 class="h6 mb-3">Nuevo webhook</h2>
        <form class="row g-2" @submit.prevent="submit">
          <div class="col-12 col-md-4">
            <FieldText
              id="webhook-name"
              label="Nombre"
              v-model="form.name"
              :form-error="form.errors.name"
            />
          </div>
          <div class="col-12 col-md-5">
            <FieldUrl
              id="webhook-url"
              label="URL"
              v-model="form.url"
              :form-error="form.errors.url"
              placeholder="https://..."
            />
          </div>
          <div class="col-12 col-md-3">
            <FieldSelect
              id="webhook-active"
              label="Activo"
              v-model="form.is_active"
              :options="[
                { value: true, label: 'Si' },
                { value: false, label: 'No' }
              ]"
            />
          </div>
          <div class="col-12">
            <FieldCheckboxes
              id="webhook-events"
              label="Eventos"
              v-model="form.events"
              :options="availableEvents.map(e => ({ value: e, label: e }))"
              :form-error="form.errors.events"
            />
          </div>
          <div class="col-12">
            <button class="btn btn-primary rounded-pill" type="submit" :disabled="form.processing">
              {{ form.processing ? 'Guardando...' : 'Crear webhook' }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <MemberTable
      :items="endpoints"
      :columns="columns"
      :get-row-actions="getRowActions"
      empty-title="No hay webhooks registrados"
      empty-text=""
      :show-pagination="false"
    >
      <template #cell-name="{ row }">
        <strong>{{ row.name }}</strong>
      </template>
      <template #cell-url="{ row }">
        <span class="text-muted">{{ row.url }}</span>
      </template>
      <template #cell-events="{ row }">
        <span class="text-muted">{{ row.events.join(', ') }}</span>
      </template>
      <template #cell-is_active="{ row }">
        <span v-if="row.is_active" class="badge text-bg-success">Activo</span>
        <span v-else class="badge text-bg-secondary">Inactivo</span>
      </template>
      <template #cell-last_used_at="{ row }">
        <span class="text-muted">{{ row.last_used_at || '-' }}</span>
      </template>
    </MemberTable>

    <div class="modal fade" id="editWebhook" tabindex="-1" aria-hidden="true" ref="editModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Editar webhook</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="row g-2" @submit.prevent="submitEdit">
              <div class="col-12 col-md-4">
                <FieldText
                  id="edit-webhook-name"
                  label="Nombre"
                  v-model="editForm.name"
                />
              </div>
              <div class="col-12 col-md-5">
                <FieldUrl
                  id="edit-webhook-url"
                  label="URL"
                  v-model="editForm.url"
                  placeholder="https://..."
                />
              </div>
              <div class="col-12 col-md-3">
                <FieldSelect
                  id="edit-webhook-active"
                  label="Activo"
                  v-model="editForm.is_active"
                  :options="[
                    { value: true, label: 'Si' },
                    { value: false, label: 'No' }
                  ]"
                />
              </div>
              <div class="col-12">
                <FieldCheckboxes
                  id="edit-webhook-events"
                  label="Eventos"
                  v-model="editForm.events"
                  :options="availableEvents.map(e => ({ value: e, label: e }))"
                />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary rounded-pill" @click="submitEdit" :disabled="editForm.processing">
              Guardar cambios
            </button>
          </div>
        </div>
      </div>
    </div>
  </MemberLayout>
</template>

<script setup>
import { computed, ref } from 'vue'
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldUrl from '@/Components/Fields/FieldUrl.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FieldSwitch from '@/Components/Fields/FieldSwitch.vue'
import FieldCheckboxes from '@/Components/Fields/FieldCheckboxes.vue'
import MemberTable from '@/Components/Member/MemberTable.vue'

const props = defineProps({
  endpoints: {
    type: Array,
    default: () => [],
  },
  availableEvents: {
    type: Array,
    default: () => [],
  },
})

const page = usePage()
const secret = computed(() => page.props.flash?.webhook_secret || '')
const editModal = ref(null)

const form = useForm({
  name: '',
  url: '',
  events: [],
  is_active: true,
})

const editForm = useForm({
  id: null,
  name: '',
  url: '',
  events: [],
  is_active: true,
})

const columns = [
  { key: 'name', label: 'Nombre', sortable: false },
  { key: 'url', label: 'URL', sortable: false },
  { key: 'events', label: 'Eventos', sortable: false },
  { key: 'is_active', label: 'Estado', sortable: false },
  { key: 'last_used_at', label: 'Último uso', sortable: false },
  { key: 'actions', label: '', sortable: false, class: 'text-end' },
]

const getRowActions = (endpoint) => {
  return [
    { label: 'Entregas', icon: 'bi bi-truck', onClick: () => router.get(`/member/webhooks/${endpoint.id}/deliveries`) },
    { label: 'Editar', icon: 'bi bi-pencil', onClick: () => openEdit(endpoint) },
    { label: 'Probar', icon: 'bi bi-send', onClick: () => sendTest(endpoint) },
    { label: 'Regenerar secreto', icon: 'bi bi-key', onClick: () => regenerate(endpoint) },
    { label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => remove(endpoint) },
  ]
}

const submit = () => {
  form.post('/member/webhooks', {
    preserveScroll: true,
    onSuccess: () => form.reset('name', 'url', 'events'),
  })
}

const openEdit = (endpoint) => {
  editForm.id = endpoint.id
  editForm.name = endpoint.name
  editForm.url = endpoint.url
  editForm.events = [...endpoint.events]
  editForm.is_active = endpoint.is_active

  const modal = new bootstrap.Modal(editModal.value)
  modal.show()
}

const submitEdit = () => {
  if (!editForm.id) return
  editForm.put(`/member/webhooks/${editForm.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      const modal = bootstrap.Modal.getInstance(editModal.value)
      modal?.hide()
    },
  })
}

const sendTest = (endpoint) => {
  router.post(`/member/webhooks/${endpoint.id}/test`, {}, { preserveScroll: true })
}

const regenerate = (endpoint) => {
  if (!confirm('Se regenerara el secreto. El anterior dejara de ser valido.')) return
  router.post(`/member/webhooks/${endpoint.id}/regenerate-secret`, {}, { preserveScroll: true })
}

const remove = (endpoint) => {
  if (!confirm('Eliminar este webhook?')) return
  router.delete(`/member/webhooks/${endpoint.id}`)
}

const copySecret = async () => {
  if (!secret.value) return
  try {
    await navigator.clipboard.writeText(secret.value)
  } catch (error) {
    // ignore
  }
}
</script>
