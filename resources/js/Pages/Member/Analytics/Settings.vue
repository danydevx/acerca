<template>
  <MemberLayout>
    <Head :title="`Analytics - Configuración - ${listing?.name || ''}`" />

    <PageHeader
      title="Analytics - Configuración"
      :breadcrumbs="breadcrumbs"
    >
      <template #actions>
        <Link
          :href="`/member/listings/${listing?.id}/analytics`"
          class="btn btn-outline-primary btn-sm"
        >
          <i class="bi bi-arrow-left me-1"></i>Volver
        </Link>
      </template>
    </PageHeader>

    <div class="analytics-settings-page">
      <form @submit.prevent="submitForm">
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white py-3">
            <h6 class="mb-0 text-uppercase small">General</h6>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <div class="form-check form-switch">
                  <input
                    id="is_enabled"
                    v-model="form.is_enabled"
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                  />
                  <label class="form-check-label" for="is_enabled">
                    <strong>Habilitar Analytics</strong>
                    <small class="d-block text-muted">Activa o desactiva el tracking para este negocio</small>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white py-3">
            <h6 class="mb-0 text-uppercase small">Qué Registrar</h6>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <div class="form-check form-switch mb-3">
                  <input
                    id="track_pageviews"
                    v-model="form.track_pageviews"
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                  />
                  <label class="form-check-label" for="track_pageviews">
                    Vistas de página
                    <small class="d-block text-muted">Registra cada visita a las páginas públicas</small>
                  </label>
                </div>
                <div class="form-check form-switch mb-3">
                  <input
                    id="track_events"
                    v-model="form.track_events"
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                  />
                  <label class="form-check-label" for="track_events">
                    Eventos
                    <small class="d-block text-muted">Clics en WhatsApp, teléfono, formularios, etc.</small>
                  </label>
                </div>
                <div class="form-check form-switch mb-3">
                  <input
                    id="track_referrers"
                    v-model="form.track_referrers"
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                  />
                  <label class="form-check-label" for="track_referrers">
                    Procedencia (referrers)
                    <small class="d-block text-muted">De dónde vienen los visitantes</small>
                  </label>
                </div>
                <div class="form-check form-switch">
                  <input
                    id="track_utm"
                    v-model="form.track_utm"
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                  />
                  <label class="form-check-label" for="track_utm">
                    Parámetros UTM
                    <small class="d-block text-muted">Campañas de marketing y fuentes de tráfico</small>
                  </label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check form-switch mb-3">
                  <input
                    id="track_device"
                    v-model="form.track_device"
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                  />
                  <label class="form-check-label" for="track_device">
                    Información del dispositivo
                    <small class="d-block text-muted">Navegador, sistema operativo, tipo de dispositivo</small>
                  </label>
                </div>
                <div class="form-check form-switch">
                  <input
                    id="track_location"
                    v-model="form.track_location"
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                  />
                  <label class="form-check-label" for="track_location">
                    Ubicación aproximada
                    <small class="d-block text-muted">País, región y ciudad basados en IP (no GPS)</small>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white py-3">
            <h6 class="mb-0 text-uppercase small">Privacidad</h6>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <div class="form-check form-switch mb-3">
                  <input
                    id="store_full_ip"
                    v-model="form.store_full_ip"
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                  />
                  <label class="form-check-label" for="store_full_ip">
                    Almacenar IPs completas
                    <small class="d-block text-muted">Por defecto solo se guarda un hash. Esta opción puede ser relevante para compliance.</small>
                  </label>
                </div>
                <div class="form-check form-switch">
                  <input
                    id="exclude_bots"
                    v-model="form.exclude_bots"
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                  />
                  <label class="form-check-label" for="exclude_bots">
                    Excluir bots y crawlers
                    <small class="d-block text-muted">No contar visitas de robots conocidos en las estadísticas</small>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white py-3">
            <h6 class="mb-0 text-uppercase small">Sesión y Retención</h6>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Timeout de sesión</label>
                <select v-model="form.session_timeout_minutes" class="form-select">
                  <option :value="15">15 minutos</option>
                  <option :value="30">30 minutos</option>
                  <option :value="60">1 hora</option>
                  <option :value="120">2 horas</option>
                </select>
                <small class="text-muted">Tiempo de inactividad para cerrar una sesión</small>
              </div>
              <div class="col-md-6">
                <label class="form-label">Retención de datos</label>
                <select v-model="form.data_retention_months" class="form-select">
                  <option :value="3">3 meses</option>
                  <option :value="6">6 meses</option>
                  <option :value="12">12 meses</option>
                  <option :value="24">24 meses</option>
                  <option :value="36">36 meses</option>
                </select>
                <small class="text-muted">Los datos más antiguos se eliminarán automáticamente</small>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <Link
            :href="`/member/listings/${listing?.id}/analytics`"
            class="btn btn-outline-secondary"
          >
            Cancelar
          </Link>
          <button type="submit" class="btn btn-primary" :disabled="saving">
            <span v-if="saving"><i class="bi bi-hourglass-split me-1"></i>Guardando...</span>
            <span v-else><i class="bi bi-check me-1"></i>Guardar cambios</span>
          </button>
        </div>
      </form>
    </div>
  </MemberLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, Link, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const setting = computed(() => page.props.setting)

const saving = ref(false)

const form = ref({
  is_enabled: setting.value?.is_enabled ?? true,
  track_pageviews: setting.value?.track_pageviews ?? true,
  track_events: setting.value?.track_events ?? true,
  track_referrers: setting.value?.track_referrers ?? true,
  track_utm: setting.value?.track_utm ?? true,
  track_device: setting.value?.track_device ?? true,
  track_location: setting.value?.track_location ?? true,
  store_full_ip: setting.value?.store_full_ip ?? false,
  exclude_bots: setting.value?.exclude_bots ?? true,
  session_timeout_minutes: setting.value?.session_timeout_minutes ?? 30,
  data_retention_months: setting.value?.data_retention_months ?? 12,
})

const breadcrumbs = computed(() => [
  { title: 'Panel', href: '/member' },
  { title: listing.value?.name || '', href: `/member/listings/${listing.value?.id}` },
  { title: 'Analytics', href: `/member/listings/${listing.value?.id}/analytics` },
  { title: 'Configuración', href: '#' },
])

const submitForm = () => {
  saving.value = true
  window.axios
    .post(`/member/listings/${listing.value?.id}/analytics/settings`, form.value)
    .then(() => {
      window.location.href = `/member/listings/${listing.value?.id}/analytics`
    })
    .catch(() => {
      saving.value = false
    })
}
</script>
