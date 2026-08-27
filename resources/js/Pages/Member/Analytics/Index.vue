<template>
  <MemberLayout>
    <Head :title="`Analytics - ${listing?.name || ''}`" />

    <PageHeader
      title="Analytics"
      :breadcrumbs="breadcrumbs"
    >
      <template #actions>
        <div class="d-flex gap-2">
          <select v-model="localRange" class="form-select form-select-sm" style="width: auto;">
            <option value="today">Hoy</option>
            <option value="yesterday">Ayer</option>
            <option value="last_7_days">Últimos 7 días</option>
            <option value="last_30_days">Últimos 30 días</option>
            <option value="this_month">Este mes</option>
            <option value="previous_month">Mes anterior</option>
          </select>
          <Link
            :href="`/member/listings/${listing?.id}/analytics/settings`"
            class="btn btn-outline-primary btn-sm"
          >
            <i class="bi bi-gear me-1"></i>Configuración
          </Link>
        </div>
      </template>
    </PageHeader>

    <div class="analytics-page">
      <div v-if="timeSeries.length > 0" class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
          <canvas id="analyticsChart" height="100"></canvas>
        </div>
      </div>
      <div v-else class="card border-0 shadow-sm mb-4">
        <div class="card-body text-center text-muted py-5">
          <i class="bi bi-graph-up fs-1 d-block mb-2"></i>
          Sin datos para el periodo seleccionado
        </div>
      </div>

      <div class="row g-3">
        <div class="col-6 col-md-4 col-lg-2">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-3">
              <div class="analytics-icon mb-2">
                <i class="bi bi-eye"></i>
              </div>
              <div class="fw-bold fs-4">{{ formatNumber(kpis.pageviews) }}</div>
              <div class="small text-muted">Vistas</div>
              <div v-if="kpiChanges.pageviews" class="small mt-1" :class="getChangeClass(kpiChanges.pageviews.direction)">
                <i :class="getChangeIcon(kpiChanges.pageviews.direction)"></i>
                {{ kpiChanges.pageviews.change }}%
              </div>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-4 col-lg-2">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-3">
              <div class="analytics-icon mb-2">
                <i class="bi bi-people"></i>
              </div>
              <div class="fw-bold fs-4">{{ formatNumber(kpis.unique_visitors) }}</div>
              <div class="small text-muted">Visitantes</div>
              <div v-if="kpiChanges.unique_visitors" class="small mt-1" :class="getChangeClass(kpiChanges.unique_visitors.direction)">
                <i :class="getChangeIcon(kpiChanges.unique_visitors.direction)"></i>
                {{ kpiChanges.unique_visitors.change }}%
              </div>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-4 col-lg-2">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-3">
              <div class="analytics-icon mb-2">
                <i class="bi bi-clock"></i>
              </div>
              <div class="fw-bold fs-4">{{ formatNumber(kpis.sessions) }}</div>
              <div class="small text-muted">Sesiones</div>
              <div v-if="kpiChanges.sessions" class="small mt-1" :class="getChangeClass(kpiChanges.sessions.direction)">
                <i :class="getChangeIcon(kpiChanges.sessions.direction)"></i>
                {{ kpiChanges.sessions.change }}%
              </div>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-4 col-lg-2">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-3">
              <div class="analytics-icon mb-2">
                <i class="bi bi-lightning"></i>
              </div>
              <div class="fw-bold fs-4">{{ formatNumber(kpis.events) }}</div>
              <div class="small text-muted">Eventos</div>
              <div v-if="kpiChanges.events" class="small mt-1" :class="getChangeClass(kpiChanges.events.direction)">
                <i :class="getChangeIcon(kpiChanges.events.direction)"></i>
                {{ kpiChanges.events.change }}%
              </div>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-4 col-lg-2">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-3">
              <div class="analytics-icon mb-2">
                <i class="bi bi-check-circle"></i>
              </div>
              <div class="fw-bold fs-4">{{ formatNumber(kpis.conversions) }}</div>
              <div class="small text-muted">Conversiones</div>
              <div v-if="kpiChanges.conversions" class="small mt-1" :class="getChangeClass(kpiChanges.conversions.direction)">
                <i :class="getChangeIcon(kpiChanges.conversions.direction)"></i>
                {{ kpiChanges.conversions.change }}%
              </div>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-4 col-lg-2">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-3">
              <div class="analytics-icon mb-2">
                <i class="bi bi-bar-chart"></i>
              </div>
              <div class="fw-bold fs-4">{{ kpis.avg_pages_per_session }}</div>
              <div class="small text-muted">Promedio/Sesión</div>
            </div>
          </div>
        </div>
      </div>

      <h2 class="h6 text-muted mt-4 mb-3 text-uppercase tracking-wide">Detalle</h2>

      <div class="row g-3">
        <div class="col-6 col-lg-3">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
              <div class="analytics-icon analytics-icon-lg mb-3 mx-auto">
                <i class="bi bi-file-earmark-text"></i>
              </div>
              <div class="fw-bold fs-5 mb-1">{{ topPages.length || '-' }}</div>
              <div class="small text-muted">Páginas rastreadas</div>
            </div>
          </div>
        </div>

        <div class="col-6 col-lg-3">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
              <div class="analytics-icon analytics-icon-lg mb-3 mx-auto">
                <i class="bi bi-share"></i>
              </div>
              <div class="fw-bold fs-5 mb-1">{{ trafficSources.length || '-' }}</div>
              <div class="small text-muted">Fuentes de tráfico</div>
            </div>
          </div>
        </div>

        <div class="col-6 col-lg-3">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
              <div class="analytics-icon analytics-icon-lg mb-3 mx-auto">
                <i class="bi bi-phone"></i>
              </div>
              <div class="fw-bold fs-5 mb-1">{{ topDevices.length || '-' }}</div>
              <div class="small text-muted">Dispositivos</div>
            </div>
          </div>
        </div>

        <div class="col-6 col-lg-3">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
              <div class="analytics-icon analytics-icon-lg mb-3 mx-auto">
                <i class="bi bi-globe-americas"></i>
              </div>
              <div class="fw-bold fs-5 mb-1">{{ topCountries.length || '-' }}</div>
              <div class="small text-muted">Países</div>
            </div>
          </div>
        </div>
      </div>

      <h2 class="h6 text-muted mt-4 mb-3 text-uppercase tracking-wide">Dispositivos</h2>

      <div class="row g-3 mb-4">
        <div v-for="device in topDevices" :key="device.device_type" class="col-4 col-lg-2">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-3">
              <div class="analytics-icon mb-2">
                <i :class="getDeviceIcon(device.device_type)"></i>
              </div>
              <div class="fw-bold">{{ formatNumber(device.visits) }}</div>
              <div class="small text-muted text-capitalize">{{ device.device_type || 'Otro' }}</div>
            </div>
          </div>
        </div>
        <div v-if="topDevices.length === 0" class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center text-muted py-4">
              Sin datos de dispositivos
            </div>
          </div>
        </div>
      </div>

      <h2 class="h6 text-muted mt-4 mb-3 text-uppercase tracking-wide">Top Eventos</h2>

      <div class="row g-3 mb-4">
        <div v-for="event in topEvents.slice(0, 6)" :key="event.event_name" class="col-6 col-md-4 col-lg-2">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-3">
              <div class="analytics-icon mb-2">
                <i :class="getEventIcon(event.event_name)"></i>
              </div>
              <div class="fw-bold">{{ formatNumber(event.total) }}</div>
              <div class="small text-muted text-truncate" :title="event.event_name">{{ event.event_name }}</div>
            </div>
          </div>
        </div>
        <div v-if="topEvents.length === 0" class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center text-muted py-4">
              Sin eventos registrados
            </div>
          </div>
        </div>
      </div>

      <h2 class="h6 text-muted mt-4 mb-3 text-uppercase tracking-wide">Top Países</h2>

      <div class="row g-3 mb-4">
        <div v-for="country in topCountries.slice(0, 6)" :key="country.country_code" class="col-6 col-md-4 col-lg-2">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-3">
              <div class="analytics-icon mb-2">
                <i class="bi bi-globe2"></i>
              </div>
              <div class="fw-bold">{{ formatNumber(country.visitors) }}</div>
              <div class="small text-muted">{{ country.country || 'Desconocido' }}</div>
            </div>
          </div>
        </div>
        <div v-if="topCountries.length === 0" class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center text-muted py-4">
              Sin datos de ubicación
            </div>
          </div>
        </div>
      </div>
    </div>
  </MemberLayout>
</template>

<script setup>
import { ref, watch, onMounted, computed } from 'vue'
import { Head, Link, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import { Chart, registerables } from 'chart.js'

Chart.register(...registerables)

const page = usePage()
const listing = computed(() => page.props.listing)
const localRange = ref(page.props.range || 'last_7_days')

const kpis = computed(() => page.props.kpis || {
  pageviews: 0,
  unique_visitors: 0,
  sessions: 0,
  events: 0,
  conversions: 0,
  avg_pages_per_session: 0,
})

const kpiChanges = computed(() => page.props.kpiChanges || {})
const timeSeries = computed(() => page.props.timeSeries || [])
const topPages = computed(() => page.props.topPages || [])
const trafficSources = computed(() => page.props.trafficSources || [])
const topCountries = computed(() => page.props.topCountries || [])
const devices = computed(() => page.props.devices || [])
const browsers = computed(() => page.props.browsers || [])
const operatingSystems = computed(() => page.props.operatingSystems || [])
const topEvents = computed(() => page.props.topEvents || [])

const topDevices = computed(() => {
  return devices.value.slice(0, 4)
})

const breadcrumbs = computed(() => [
  { title: 'Panel', href: '/member' },
  { title: listing.value?.name || '', href: `/member/listings/${listing.value?.id}` },
  { title: 'Analytics', href: '#' },
])

watch(localRange, (newRange) => {
  window.location.href = `/member/listings/${listing.value?.id}/analytics?range=${newRange}`
})

const formatNumber = (num) => {
  if (num === null || num === undefined) return '0'
  return new Intl.NumberFormat('es-MX').format(num)
}

const getChangeClass = (direction) => {
  if (direction === 'up') return 'text-success'
  if (direction === 'down') return 'text-danger'
  return 'text-muted'
}

const getChangeIcon = (direction) => {
  if (direction === 'up') return 'bi bi-arrow-up'
  if (direction === 'down') return 'bi bi-arrow-down'
  return 'bi bi-dash'
}

const getDeviceIcon = (type) => {
  const icons = {
    desktop: 'bi bi-display',
    mobile: 'bi bi-phone',
    tablet: 'bi bi-tablet',
  }
  return icons[type?.toLowerCase()] || 'bi bi-device-hdd'
}

const getEventIcon = (eventName) => {
  const icons = {
    whatsapp_click: 'bi bi-whatsapp',
    phone_click: 'bi bi-telephone',
    email_click: 'bi bi-envelope',
    contact_form_submit: 'bi bi-chat-left-text',
    appointment_click: 'bi bi-calendar-event',
    product_click: 'bi bi-box-seam',
    service_click: 'bi bi-briefcase',
    property_click: 'bi bi-house',
    map_click: 'bi bi-geo-alt',
    social_click: 'bi bi-heart',
    download_vcard: 'bi bi-person-badge',
    download_file: 'bi bi-file-arrow-down',
    gallery_open: 'bi bi-images',
    video_play: 'bi bi-play-circle',
    cta_click: 'bi bi-cursor',
  }
  return icons[eventName] || 'bi bi-check2'
}

let chartInstance = null

const renderChart = () => {
  const canvas = document.getElementById('analyticsChart')
  if (!canvas || timeSeries.value.length === 0) return

  if (chartInstance) {
    chartInstance.destroy()
  }

  const labels = timeSeries.value.map(d => d.date)
  const pageviewsData = timeSeries.value.map(d => d.pageviews)
  const visitorsData = timeSeries.value.map(d => d.visitors)

  chartInstance = new Chart(canvas, {
    type: 'line',
    data: {
      labels,
      datasets: [
        {
          label: 'Vistas',
          data: pageviewsData,
          borderColor: 'rgb(75, 192, 192)',
          backgroundColor: 'rgba(75, 192, 192, 0.1)',
          tension: 0.3,
          fill: true,
        },
        {
          label: 'Visitantes',
          data: visitorsData,
          borderColor: 'rgb(54, 162, 235)',
          backgroundColor: 'rgba(54, 162, 235, 0.1)',
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
}

.analytics-icon-lg {
  width: 64px;
  height: 64px;
  font-size: 1.75rem;
}
</style>
