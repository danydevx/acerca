<template>
  <MemberLayout>
    <Head :title="`Analytics - ${vcard?.name || ''}`" />
 
    <PageHeader
      :title="vcard?.name || 'Analytics'"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing?.id}/vcards/${vcard?.id}/edit`"
    >
      <template #actions>
        <div class="d-flex gap-2">
          <select v-model="localRange" class="form-select form-select-sm" style="width: auto;">
            <option value="today">Hoy</option>
            <option value="7d">7 días</option>
            <option value="30d">30 días</option>
            <option value="90d">90 días</option>
            <option value="all">Todo</option>
          </select>
          <button
            class="btn btn-outline-danger btn-sm"
            @click="clearHistory"
            :disabled="clearing"
          >
            <i class="bi bi-trash me-1"></i>
            Limpiar
          </button>
        </div>
      </template>
    </PageHeader>

    <div class="vcard-analytics-page">
      <div v-if="stats.total > 0" class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
          <canvas id="visitsChart" height="100"></canvas>
        </div>
      </div>
      <div v-else class="card border-0 shadow-sm mb-4">
        <div class="card-body text-center text-muted py-5">
          <i class="bi bi-graph-up fs-1 d-block mb-2"></i>
          Sin datos para el periodo seleccionado
        </div>
      </div>

      <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-3">
              <div class="analytics-icon mb-2">
                <i class="bi bi-eye"></i>
              </div>
              <div class="fw-bold fs-4">{{ formatNumber(stats.total) }}</div>
              <div class="small text-muted">Visitas</div>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-3">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-3">
              <div class="analytics-icon mb-2">
                <i class="bi bi-people"></i>
              </div>
              <div class="fw-bold fs-4">{{ formatNumber(stats.unique) }}</div>
              <div class="small text-muted">Visitantes únicos</div>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-3">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-3">
              <div class="analytics-icon mb-2">
                <i class="bi bi-globe-americas"></i>
              </div>
              <div class="fw-bold fs-4">{{ stats.countries }}</div>
              <div class="small text-muted">Países</div>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-3">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-3">
              <div class="analytics-icon mb-2">
                <i class="bi bi-phone"></i>
              </div>
              <div class="fw-bold fs-4">{{ deviceSummary }}</div>
              <div class="small text-muted">Dispositivos</div>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
              <h6 class="mb-0"><i class="bi bi-globe2 me-2"></i>Países</h6>
            </div>
            <div class="card-body p-0">
              <div v-if="topCountries.length > 0" class="list-group list-group-flush">
                <div
                  v-for="country in topCountries"
                  :key="country.country_code"
                  class="list-group-item d-flex justify-content-between align-items-center"
                >
                  <div>
                    <span class="me-2">{{ getCountryFlag(country.country_code) }}</span>
                    <span>{{ country.country || 'Desconocido' }}</span>
                  </div>
                  <span class="badge bg-primary rounded-pill">{{ formatNumber(country.visitors) }}</span>
                </div>
              </div>
              <div v-else class="card-body text-center text-muted py-4">
                Sin datos
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
              <h6 class="mb-0"><i class="bi bi-device-hdd me-2"></i>Dispositivos</h6>
            </div>
            <div class="card-body p-0">
              <div v-if="topDevices.length > 0" class="list-group list-group-flush">
                <div
                  v-for="device in topDevices"
                  :key="device.device_type"
                  class="list-group-item d-flex justify-content-between align-items-center"
                >
                  <div>
                    <i :class="getDeviceIcon(device.device_type)" class="me-2"></i>
                    <span class="text-capitalize">{{ device.device_type || 'Otro' }}</span>
                  </div>
                  <span class="badge bg-secondary rounded-pill">{{ device.percentage }}%</span>
                </div>
              </div>
              <div v-else class="card-body text-center text-muted py-4">
                Sin datos
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
              <h6 class="mb-0"><i class="bi bi-browser-chrome me-2"></i>Navegadores</h6>
            </div>
            <div class="card-body p-0">
              <div v-if="topBrowsers.length > 0" class="list-group list-group-flush">
                <div
                  v-for="browser in topBrowsers"
                  :key="browser.browser"
                  class="list-group-item d-flex justify-content-between align-items-center"
                >
                  <div>
                    <i class="bi bi-browser-edge me-2"></i>
                    <span>{{ browser.browser }}</span>
                  </div>
                  <span class="badge bg-info rounded-pill">{{ formatNumber(browser.visits) }}</span>
                </div>
              </div>
              <div v-else class="card-body text-center text-muted py-4">
                Sin datos
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
              <h6 class="mb-0"><i class="bi bi-laptop me-2"></i>Sistemas Operativos</h6>
            </div>
            <div class="card-body p-0">
              <div v-if="topOs.length > 0" class="list-group list-group-flush">
                <div
                  v-for="os in topOs"
                  :key="os.os"
                  class="list-group-item d-flex justify-content-between align-items-center"
                >
                  <div>
                    <i class="bi bi-windows me-2"></i>
                    <span>{{ os.os }}</span>
                  </div>
                  <span class="badge bg-warning text-dark rounded-pill">{{ formatNumber(os.visits) }}</span>
                </div>
              </div>
              <div v-else class="card-body text-center text-muted py-4">
                Sin datos
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
          <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Visitas Recientes</h6>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th>Fecha</th>
                  <th>País</th>
                  <th>Dispositivo</th>
                  <th>Navegador</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="recentVisits.length === 0">
                  <td colspan="4" class="text-center text-muted py-4">Sin visitas registradas</td>
                </tr>
                <tr v-for="visit in recentVisits" :key="visit.id">
                  <td class="text-nowrap">{{ formatDate(visit.visited_at) }}</td>
                  <td>
                    <span v-if="visit.country">{{ getCountryFlag(visit.country_code) }} {{ visit.country }}</span>
                    <span v-else class="text-muted">-</span>
                  </td>
                  <td>
                    <i :class="getDeviceIcon(visit.device_type)" class="me-1"></i>
                    <span class="text-capitalize">{{ visit.device_type || 'Otro' }}</span>
                  </td>
                  <td>{{ visit.browser || '-' }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </MemberLayout>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { Head, router, usePage } from '@inertiajs/vue3'
import { toast } from 'vue3-toastify'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import { Chart, registerables } from 'chart.js'
import PageHeader from '@/Components/Admin/PageHeader.vue'
Chart.register(...registerables)

const props = defineProps({
  listing: Object,
  vcard: Object,
  range: String,
  stats: Object,
  timeSeries: Array,
  topCountries: Array,
  topDevices: Array,
  topBrowsers: Array,
  topOs: Array,
  recentVisits: Array,
})

const localRange = ref(props.range || '7d')
const clearing = ref(false)

const breadcrumbs = computed(() => [
  { title: 'Inicio', href: '/member/dashboard' },
  { title: props.listing?.name || '', href: `/member/listings/${props.listing?.id}` },
  { title: 'vCards', href: `/member/listings/${props.listing?.id}/vcards` },
  { title: props.vcard?.name || '', href: `/member/listings/${props.listing?.id}/vcards/${props.vcard?.id}/edit` },
  { title: 'Analytics', active: true },
])

const listing = computed(() => props.listing)
const vcard = computed(() => props.vcard)

const deviceSummary = computed(() => {
  if (!props.topDevices || props.topDevices.length === 0) return '-'
  return props.topDevices.length
})

watch(localRange, (newRange) => {
  router.get(
    `/member/listings/${props.listing?.id}/vcards/${props.vcard?.id}/analytics`,
    { range: newRange },
    { preserveState: true }
  )
})

const formatNumber = (num) => {
  if (num === null || num === undefined) return '0'
  return new Intl.NumberFormat('es-MX').format(num)
}

const formatDate = (dateStr) => {
  if (!dateStr) return '-'
  const date = new Date(dateStr)
  return date.toLocaleDateString('es-MX', {
    day: '2-digit',
    month: 'short',
    hour: '2-digit',
    minute: '2-digit',
  })
}

const getCountryFlag = (code) => {
  if (!code || code === 'XX') return '🌍'
  const flags = {
    MX: '🇲🇽', US: '🇺🇸', ES: '🇪🇸', AR: '🇦🇷', CO: '🇨🇴',
    PE: '🇵🇪', CL: '🇨🇱', VE: '🇻🇪', EC: '🇪🇨', GT: '🇬🇹',
    CU: '🇨🇺', DO: '🇩🇴', HN: '🇭🇳', SV: '🇸🇻', NI: '🇳🇮',
    CR: '🇨🇷', PA: '🇵🇦', BR: '🇧🇷', GB: '🇬🇧', FR: '🇫🇷',
    DE: '🇩🇪', IT: '🇮🇹', PT: '🇵🇹', CA: '🇨🇦', AU: '🇦🇺',
    JP: '🇯🇵', KR: '🇰🇷', CN: '🇨🇳', IN: '🇮🇳', RU: '🇷🇺',
  }
  return flags[code.toUpperCase()] || '🌍'
}

const getDeviceIcon = (type) => {
  const icons = {
    desktop: 'bi bi-display',
    mobile: 'bi bi-phone',
    tablet: 'bi bi-tablet',
  }
  return icons[type?.toLowerCase()] || 'bi bi-device-hdd'
}

const clearHistory = () => {
  if (!confirm('¿Eliminar todo el historial de visitas de esta tarjeta?')) return
  clearing.value = true
  router.delete(
    `/member/listings/${props.listing?.id}/vcards/${props.vcard?.id}/analytics/clear`,
    {
      onSuccess: () => {
        toast.success('Historial eliminado')
        router.reload({ only: ['stats', 'timeSeries', 'topCountries', 'topDevices', 'topBrowsers', 'topOs', 'recentVisits'] })
      },
      onFinish: () => {
        clearing.value = false
      },
    }
  )
}

let chartInstance = null

const renderChart = () => {
  const canvas = document.getElementById('visitsChart')
  if (!canvas || !props.timeSeries || props.timeSeries.length === 0) return

  if (chartInstance) {
    chartInstance.destroy()
  }

  const labels = props.timeSeries.map(d => d.date)
  const visitsData = props.timeSeries.map(d => d.visits)
  const visitorsData = props.timeSeries.map(d => d.visitors)

  chartInstance = new Chart(canvas, {
    type: 'line',
    data: {
      labels,
      datasets: [
        {
          label: 'Visitas',
          data: visitsData,
          borderColor: 'rgb(37, 99, 235)',
          backgroundColor: 'rgba(37, 99, 235, 0.1)',
          tension: 0.3,
          fill: true,
        },
        {
          label: 'Visitantes únicos',
          data: visitorsData,
          borderColor: 'rgb(16, 185, 129)',
          backgroundColor: 'rgba(16, 185, 129, 0.1)',
          tension: 0.3,
          fill: true,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: true,
          position: 'top',
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0,
          },
        },
      },
    },
  })
}

onMounted(() => {
  renderChart()
})
</script>

<style scoped>
.analytics-icon {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: var(--bs-primary-bg-subtle);
  color: var(--bs-primary);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  margin: 0 auto;
}

.list-group-item {
  border: none;
  border-bottom: 1px solid var(--bs-border-color);
  padding: 0.75rem 1rem;
}

.list-group-item:last-child {
  border-bottom: none;
}
</style>
