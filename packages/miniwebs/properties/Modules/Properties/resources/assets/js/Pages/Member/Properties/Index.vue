<template>
  <MemberLayout>
    <Head :title="`Propiedades - ${listing?.name || ''}`" />

    <PageHeader
      title="Propiedades"
      :breadcrumbs="breadcrumbs"
      :backHref="'/member/listings'"
    >
      <template #actions>
        <Link :href="`/member/listings/${listing?.id}/properties/create`" class="btn btn-primary rounded-pill">
          <i class="bi bi-plus-lg me-1"></i>
          Nueva Propiedad
        </Link>
      </template>
    </PageHeader>

    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body py-2">
        <div class="d-flex flex-wrap align-items-center gap-2">
          <div class="input-group input-group-sm" style="min-width: 200px; max-width: 280px;">
            <input
              type="text"
              v-model="searchQuery"
              class="form-control"
              placeholder="Buscar..."
              @keyup.enter="filterProperties"
            />
            <button class="btn btn-secondary" @click="filterProperties" type="button">
              <i class="bi bi-search"></i>
            </button>
          </div>
          <select v-model="filters.property_type_id" class="form-select form-select-sm" @change="filterProperties" style="width: auto; min-width: 90px;">
            <option :value="null">Tipo</option>
            <option v-for="type in propertyTypes" :key="type.id" :value="type.id">{{ type.name }}</option>
          </select>
          <select v-model="filters.operation_type" class="form-select form-select-sm" @change="filterProperties" style="width: auto; min-width: 90px;">
            <option :value="null">Operación</option>
            <option v-for="op in operationOptions" :key="op" :value="op">{{ getOperationLabel(op) }}</option>
          </select>
          <select v-model="filters.status" class="form-select form-select-sm" @change="filterProperties" style="width: auto; min-width: 90px;">
            <option :value="null">Estatus</option>
            <option v-for="st in statusOptions" :key="st" :value="st">{{ getStatusLabel(st) }}</option>
          </select>
          <select v-model="filters.state" class="form-select form-select-sm" @change="onStateChange" style="width: auto; min-width: 90px;">
            <option :value="null">Estado</option>
            <option v-for="st in availableStates" :key="st" :value="st">{{ getStateName(st) }}</option>
          </select>
          <select v-model="filters.municipality" class="form-select form-select-sm" @change="filterProperties" :disabled="!filters.state" style="width: auto; min-width: 120px;">
            <option :value="null">Municipio</option>
            <option v-for="mu in availableMunicipalities" :key="mu" :value="mu">{{ getMunicipalityName(mu) }}</option>
          </select>
          <button v-if="hasActiveFilters" type="button" class="btn btn-outline-secondary btn-sm rounded-pill" @click="clearFilters">
            <i class="bi bi-x-lg me-1"></i>Limpiar
          </button>
        </div>

        <div v-if="hasActiveFilters" class="mt-2 d-flex flex-wrap gap-2">
          <span class="badge bg-light text-dark border" v-if="filters.property_type_id">
            Tipo: {{ getPropertyTypeName(filters.property_type_id) }}
            <button class="btn-close btn-close-sm ms-1" @click="filters.property_type_id = null; filterProperties()"></button>
          </span>
          <span class="badge bg-light text-dark border" v-if="filters.operation_type">
            {{ getOperationLabel(filters.operation_type) }}
            <button class="btn-close btn-close-sm ms-1" @click="filters.operation_type = null; filterProperties()"></button>
          </span>
          <span class="badge bg-light text-dark border" v-if="filters.status">
            {{ getStatusLabel(filters.status) }}
            <button class="btn-close btn-close-sm ms-1" @click="filters.status = null; filterProperties()"></button>
          </span>
          <span class="badge bg-light text-dark border" v-if="filters.state">
            {{ getStateName(filters.state) }}
            <button class="btn-close btn-close-sm ms-1" @click="filters.state = null; filters.municipality = null; filterProperties()"></button>
          </span>
          <span class="badge bg-light text-dark border" v-if="filters.municipality">
            {{ getMunicipalityName(filters.municipality) }}
            <button class="btn-close btn-close-sm ms-1" @click="filters.municipality = null; filterProperties()"></button>
          </span>
          <span class="badge bg-light text-dark border" v-if="searchQuery">
            "{{ searchQuery }}"
            <button class="btn-close btn-close-sm ms-1" @click="searchQuery = ''; filterProperties()"></button>
          </span>
        </div>
      </div>
    </div>

    <BaseDataTable
      ref="dataTableRef"
      :endpoint="`/member/listings/${listing?.id}/properties`"
      :columns="columns"
      :initial-data="dataTable"
      :initial-per-page="perPage"
      :reorderable="true"
      :reorder-endpoint="`/member/listings/${listing?.id}/properties/reorder`"
      search-placeholder="Buscar propiedades..."
      empty-title="No hay propiedades"
      empty-text="Comienza creando tu primera propiedad."
      @updated="onDataTableUpdated"
    >
      <template #header-actions>
        <BulkSelect
          v-model:selectedIds="selectedIds"
          :current-page-ids="currentPageIds"
          :delete-endpoint="`/member/listings/${listing?.id}/properties/bulk-delete`"
          item-name="propiedades"
          @deleted="onBulkDeleted"
        />
      </template>

      <template #cell-checkbox="{ row }">
        <BulkSelectRowCheckbox
          :id="row.id"
          v-model:selectedIds="selectedIds"
        />
      </template>

      <template #cell-image="{ row }">
        <img
          v-if="row.main_image_url"
          :src="row.main_image_url"
          class="rounded"
          style="width: 48px; height: 48px; object-fit: cover;"
        />
        <div v-else class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
          <i class="bi bi-house text-muted"></i>
        </div>
      </template>

      <template #cell-title="{ row }">
        <strong>{{ row.title }}</strong>
        <p v-if="row.description" class="text-muted small mb-0">{{ row.description.substring(0, 60) }}...</p>
      </template>

      <template #cell-property_type="{ row }">
        <span class="badge bg-light text-dark">{{ row.property_type_name || '-' }}</span>
      </template>

      <template #cell-is_featured="{ row }">
        <span v-if="row.is_featured" class="badge bg-warning text-dark">
          <i class="bi bi-star-fill"></i>
        </span>
        <span v-else class="text-muted">-</span>
      </template>

      <template #cell-created_at="{ row }">
        <small class="text-muted">{{ formatDate(row.created_at) }}</small>
      </template>

      <template #cell-location="{ row }">
        <small>{{ row.location || '-' }}</small>
      </template>

      <template #cell-operation_type="{ row }">
        <span class="badge bg-info">{{ row.operation_label }}</span>
      </template>

      <template #cell-price="{ row }">
        <span class="fw-semibold">{{ row.formatted_price }}</span>
      </template>

      <template #cell-status="{ row }">
        <span :class="getStatusBadgeClass(row.status)">
          {{ row.status_label }}
        </span>
      </template>

      <template #cell-actions="{ row }">
        <MemberTableActions :actions="getRowActions(row)" />
      </template>
    </BaseDataTable>
  </MemberLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import BaseDataTable from '@/Components/DataTable/BaseDataTable.vue'
import MemberTableActions from '@/Components/Member/MemberTableActions.vue'
import { BulkSelect, BulkSelectRowCheckbox } from '@/Components/BulkSelect'

const props = defineProps({
  propertyTypes: Array,
  statusOptions: Array,
  operationOptions: Array,
  filters: Object,
  availableStates: Array,
  availableMunicipalities: Array,
})

const page = usePage()
const listing = computed(() => page.props.listing)
const dataTable = computed(() => page.props.dataTable)
const businessMenu = computed(() => page.props.businessMenu || [])

const breadcrumbs = computed(() => {
  const path = window.location.pathname
  const businessMatch = path.match(/^\/member\/listings\/(\d+)/)
  if (businessMatch) {
    const businessId = parseInt(businessMatch[1])
    const biz = businessMenu.value.find(b => b.id === businessId)
    if (biz) {
      return [
        { label: 'Inicio', href: `/member/listings/${biz.id}/modules` },
        { label: 'Propiedades', active: true },
      ]
    }
  }
  return [
    { label: 'Inicio', href: '/member/dashboard' },
    { label: 'Propiedades', active: true },
  ]
})

const columns = [
  { key: 'checkbox', label: '', sortable: false, width: '40px' },
  { key: 'image', label: '', sortable: false, width: '60px' },
  { key: 'title', label: 'Título', sortable: true },
  { key: 'property_type', label: 'Tipo', sortable: true },
  { key: 'operation_type', label: 'Operación', sortable: true },
  { key: 'price', label: 'Precio', sortable: true },
  { key: 'location', label: 'Ubicación', sortable: false },
  { key: 'is_featured', label: '', sortable: false, width: '50px' },
  { key: 'created_at', label: 'Fecha', sortable: true },
  { key: 'status', label: 'Estado', sortable: true },
  { key: 'actions', label: 'Acciones', sortable: false },
]

const dataTableRef = ref(null)
const duplicating = ref(null)
const perPage = ref(10)
const selectedIds = ref([])
const searchQuery = ref(props.filters?.search || '')

const filters = ref({
  property_type_id: props.filters?.property_type_id || null,
  operation_type: props.filters?.operation_type || null,
  status: props.filters?.status || null,
  state: props.filters?.state || null,
  municipality: props.filters?.municipality || null,
})

const currentPageIds = computed(() => {
  if (!dataTable.value?.data) return []
  return dataTable.value.data.map(row => row.id)
})

const hasActiveFilters = computed(() => {
  return filters.value.property_type_id ||
    filters.value.operation_type ||
    filters.value.status ||
    filters.value.state ||
    filters.value.municipality ||
    searchQuery.value
})

const onDataTableUpdated = (data) => {
  perPage.value = data.per_page
  selectedIds.value = []
}

const onBulkDeleted = () => {
  if (dataTableRef.value) {
    dataTableRef.value.reload()
  }
}

const filterProperties = () => {
  let url = `/member/listings/${listing.value.id}/properties?`
  const params = []

  if (filters.value.property_type_id) {
    params.push(`property_type=${filters.value.property_type_id}`)
  }
  if (filters.value.operation_type) {
    params.push(`operation=${filters.value.operation_type}`)
  }
  if (filters.value.status) {
    params.push(`status=${filters.value.status}`)
  }
  if (filters.value.state) {
    params.push(`state=${filters.value.state}`)
  }
  if (filters.value.municipality) {
    params.push(`municipality=${filters.value.municipality}`)
  }
  if (searchQuery.value) {
    params.push(`search=${encodeURIComponent(searchQuery.value)}`)
  }

  url += params.join('&')
  window.location.href = url
}

const onStateChange = () => {
  filters.value.municipality = null
  filterProperties()
}

const searchProperties = () => {
  filterProperties()
}

const clearFilters = () => {
  filters.value = {
    property_type_id: null,
    operation_type: null,
    status: null,
    state: null,
    municipality: null,
  }
  searchQuery.value = ''
  window.location.href = `/member/listings/${listing.value.id}/properties`
}

const getOperationLabel = (op) => {
  const labels = { sale: 'Venta', rent: 'Renta', transfer: 'Traspaso' }
  return labels[op] || op
}

const getStatusLabel = (st) => {
  const labels = {
    draft: 'Borrador',
    published: 'Publicada',
    paused: 'Pausada',
    rented: 'Rentada',
    sold: 'Vendida',
    transferred: 'Traspasada',
    archived: 'Archivada',
  }
  return labels[st] || st
}

const getStateName = (code) => {
  const states = {
    JAL: 'Jalisco',
    CDMX: 'Ciudad de México',
    NL: 'Nuevo León',
    GTO: 'Guanajuato',
    VER: 'Veracruz',
    PUE: 'Puebla',
    MEX: 'Estado de México',
    CHP: 'Chiapas',
    OAX: 'Oaxaca',
    GRO: 'Guerrero',
    MIC: 'Michoacán',
    TAM: 'Tamaulipas',
    SLP: 'San Luis Potosí',
    QUE: 'Querétaro',
    YUC: 'Yucatán',
    QRO: 'Querétaro',
    HGO: 'Hidalgo',
    MOR: 'Morelos',
    CAMP: 'Campeche',
    TAB: 'Tabasco',
    TLA: 'Tlaxcala',
    ROO: 'Quintana Roo',
    SIN: 'Sinaloa',
    NAY: 'Nayarit',
    COL: 'Colima',
    AGS: 'Aguascalientes',
    DGO: 'Durango',
    ZAC: 'Zacatecas',
    BCS: 'Baja California Sur',
    SON: 'Sonora',
    CHH: 'Chihuahua',
    COA: 'Coahuila',
  }
  return states[code] || code
}

const getPropertyTypeName = (id) => {
  const type = props.propertyTypes.find(t => t.id === id)
  return type ? type.name : id
}

const getMunicipalityName = (code) => {
  const municipalities = {
    ACG: 'Acatlán de Juárez',
    AJU: 'Ajitlán de los Ade',
    AM: 'Amacueca',
    AT: 'Atemajac',
    ATL: 'Atengo',
    ATY: 'Atenguillo',
    ATO: 'Atotonilco el Alto',
    AUT: 'Autlán de Navarro',
    AYU: 'Ayutla',
    BAR: 'Barra de Navidad',
    CAB: 'Cabo Corrientes',
    CAN: 'Cañadas de Obregón',
    CAS: 'Casimiro Castillo',
    CHU: 'Chiquilistlán',
    COA: 'Coatepec',
    COL: 'Colotlán',
    CON: 'Concepción de Buenos Aires',
    CUA: 'Cuautla',
    DEG: 'Degollado',
    ENC: 'Encarnación de Díaz',
    ETZ: 'Etzatlán',
    GDL: 'Guadalajara',
    GOM: 'Gómez Farías',
    GUA: 'Guachinango',
    HOST: 'Hostotipaquillo',
    HUE: 'Huejúcar',
    HUEJ: 'Huejuquilla el Alto',
    IXT: 'Ixtlahuacán de los Membrillos',
    IXTLA: 'Ixtlahuacán del Río',
    JAM: 'Jamay',
    JES: 'Jesús María',
    JIL: 'Jilotlán de los Dolores',
    JOC: 'Jocotepec',
    LAG: 'Lagos de Moreno',
    MAG: 'Magdalena',
    MAN: 'Manzanillo de la Paz',
    MAS: 'Mascota',
    MD: 'Mazamitla',
    MIX: 'Mixtlán',
    OC: 'Ocotlán',
    OJUE: 'Ojuelos de Jalisco',
    POP: 'Puerto Vallarta',
    PUR: 'Purificación',
    SAD: 'San Antonio de los Alcalá',
    SDG: 'San Gabriel',
    SDJ: 'San Juan de los Lagos',
    SDN: 'San Martín Hidalgo',
    SDP: 'San Miguel el Alto',
    SDS: 'San Sebastián del Sur',
    T: 'Talpa de Allende',
    TAM: 'Tamazula de Gordiano',
    TAP: 'Tapalpa',
    TEC: 'Tecolotlán',
    TEL: 'Tequila',
    TEU: 'Teuchitlán',
    TLA: 'Tlajomulco de Zúñiga',
    TLM: 'Tonalá',
    TNA: 'Tenamaxtlán',
    TON: 'Tonaya',
    TOT: 'Tototlán',
    UN: 'Unión de San Antonio',
    UTR: 'Unión de Tula',
    VAL: 'Valle de Guadalupe',
    VALJ: 'Valle de Juárez',
    VCA: 'Villa Corona',
    VCAZ: 'Villa García',
    VCHO: 'Villa Hidalgo',
    VGU: 'Villa Guerrero',
    YAH: 'Yahualica',
    YUR: 'Yurécuaro',
    ZAP: 'Zapotiltic',
    ZAPO: 'Zapotlanejo',
    ZMG: 'Zapotlán el Grande',
  }
  return municipalities[code] || code
}

const formatDate = (date) => {
  if (!date) return '-'
  const d = new Date(date)
  return d.toLocaleDateString('es-MX', { day: '2-digit', month: 'short', year: 'numeric' })
}

const getStatusBadgeClass = (status) => {
  const classes = {
    draft: 'badge bg-secondary',
    published: 'badge bg-success',
    paused: 'badge bg-warning',
    rented: 'badge bg-info',
    sold: 'badge bg-primary',
    transferred: 'badge bg-dark',
    archived: 'badge bg-secondary',
  }
  return classes[status] || 'badge bg-secondary'
}

const getRowActions = (row) => {
  const actions = [
    { label: 'Editar', icon: 'bi bi-pencil', onClick: () => router.get(`/member/listings/${listing.value.id}/properties/${row.id}/edit`) },
  ]

  if (row.status !== 'published') {
    actions.push({ label: 'Publicar', icon: 'bi bi-eye', onClick: () => changeStatus(row, 'published') })
  }
  if (row.status !== 'paused') {
    actions.push({ label: 'Pausar', icon: 'bi bi-pause', onClick: () => changeStatus(row, 'paused') })
  }
  if (row.status !== 'archived') {
    actions.push({ label: 'Archivar', icon: 'bi bi-archive', onClick: () => changeStatus(row, 'archived') })
  }

  actions.push({ label: 'Duplicar', icon: 'bi bi-copy', onClick: () => duplicateProperty(row) })
  actions.push({ label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => deleteProperty(row) })

  return actions
}

const changeStatus = (property, status) => {
  router.post(`/member/listings/${listing.value.id}/properties/${property.id}/change-status`, {
    status,
  }, {
    preserveScroll: true,
    onSuccess: () => {
      if (dataTableRef.value) {
        dataTableRef.value.reload()
      }
    },
  })
}

const duplicateProperty = (property) => {
  if (confirm(`Duplicar la propiedad "${property.title}"?`)) {
    duplicating.value = property.id
    router.post(`/member/listings/${listing.value.id}/properties/${property.id}/duplicate`, {}, {
      preserveScroll: true,
      onSuccess: () => {
        duplicating.value = null
        if (dataTableRef.value) {
          dataTableRef.value.reload()
        }
      },
      onError: () => {
        duplicating.value = null
      },
    })
  }
}

const deleteProperty = (property) => {
  if (confirm(`Eliminar la propiedad "${property.title}"?`)) {
    router.delete(`/member/listings/${listing.value.id}/properties/${property.id}`, {
      preserveScroll: true,
      onFinish: () => {
        if (dataTableRef.value) {
          dataTableRef.value.reload()
        }
      },
    })
  }
}
</script>
