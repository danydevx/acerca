<template>
  <div class="playground-section">
    <div class="tabs mb-4">
      <ul>
        <li
          v-for="industry in industries"
          :key="industry.id"
          :class="{ 'is-active': activeIndustry === industry.id }"
        >
          <a @click="activeIndustry = industry.id">{{ industry.label }}</a>
        </li>
      </ul>
    </div>

    <div class="box">
      <h3 class="title is-4">Generic Service Components</h3>
      <p class="subtitle is-6">Componentes reutilizables para cualquier industria</p>

      <div class="tabs mb-4">
        <ul>
          <li :class="{ 'is-active': activeComponent === 'card' }">
            <a @click="activeComponent = 'card'">ServiceCard</a>
          </li>
          <li :class="{ 'is-active': activeComponent === 'row' }">
            <a @click="activeComponent = 'row'">ServiceRow</a>
          </li>
          <li :class="{ 'is-active': activeComponent === 'grid' }">
            <a @click="activeComponent = 'grid'">ServiceGrid</a>
          </li>
          <li :class="{ 'is-active': activeComponent === 'list' }">
            <a @click="activeComponent = 'list'">ServiceList</a>
          </li>
          <li :class="{ 'is-active': activeComponent === 'section' }">
            <a @click="activeComponent = 'section'">ServiceSection</a>
          </li>
          <li :class="{ 'is-active': activeComponent === 'featured' }">
            <a @click="activeComponent = 'featured'">ServiceFeatured</a>
          </li>
          <li :class="{ 'is-active': activeComponent === 'carousel' }">
            <a @click="activeComponent = 'carousel'">ServiceCarousel</a>
          </li>
          <li :class="{ 'is-active': activeComponent === 'toggle' }">
            <a @click="activeComponent = 'toggle'">ServiceToggle</a>
          </li>
          <li :class="{ 'is-active': activeComponent === 'compare' }">
            <a @click="activeComponent = 'compare'">ServiceCompare</a>
          </li>
          <li :class="{ 'is-active': activeComponent === 'stepper' }">
            <a @click="activeComponent = 'stepper'">ServiceStepper</a>
          </li>
          <li :class="{ 'is-active': activeComponent === 'filter' }">
            <a @click="activeComponent = 'filter'">ServiceFilter</a>
          </li>
        </ul>
      </div>

      <div v-if="activeComponent === 'card'">
        <h5 class="title is-6 mb-3">Variants</h5>
        <div class="columns is-multiline">
          <div class="column is-3">
            <ServiceCard :item="sampleItem" variant="default" />
          </div>
          <div class="column is-3">
            <ServiceCard :item="sampleItem" variant="compact" />
          </div>
          <div class="column is-3">
            <ServiceCard :item="sampleItem" variant="minimal" />
          </div>
          <div class="column is-3">
            <ServiceCard :item="sampleItem" variant="featured" />
          </div>
        </div>
        <hr>
        <h5 class="title is-6 mb-3">Grid</h5>
        <ServiceGrid :items="currentDataset" :columns="3" />
      </div>

      <div v-if="activeComponent === 'row'">
        <h5 class="title is-6 mb-3">Variants</h5>
        <div class="columns">
          <div class="column is-6">
            <ServiceRow v-for="item in currentDataset.slice(0, 3)" :key="item.id" :item="item" variant="default" />
          </div>
          <div class="column is-6">
            <ServiceRow v-for="item in currentDataset.slice(0, 3)" :key="item.id" :item="item" variant="rich" />
          </div>
        </div>
      </div>

      <div v-if="activeComponent === 'grid'">
        <h5 class="title is-6 mb-3">Columns: 2, 3, 4</h5>
        <p class="mb-3">Grid responsive con {{ currentDataset.length }} items</p>
        <ServiceGrid :items="currentDataset" :columns="3" />
      </div>

      <div v-if="activeComponent === 'list'">
        <ServiceList :items="currentDataset" :visible-count="4" />
      </div>

      <div v-if="activeComponent === 'section'">
        <ServiceSection
          title="Servicios Disponibles"
          description="Explora nuestra variedad de servicios"
          :categories="currentCategories"
        >
          <template #default>
            <ServiceGrid :items="currentDataset" :columns="3" />
          </template>
          <template #footer>
            <div class="has-text-centered">
              <button class="button is-link is-light">Ver todos los servicios</button>
            </div>
          </template>
        </ServiceSection>
      </div>

      <div v-if="activeComponent === 'featured'">
        <h5 class="title is-6 mb-3">Variants</h5>
        <div class="columns">
          <div class="column is-6">
            <ServiceFeatured :item="sampleItem" variant="default" />
          </div>
          <div class="column is-6">
            <ServiceFeatured :item="sampleItem" variant="horizontal" />
          </div>
        </div>
        <div class="columns mt-4">
          <div class="column is-4">
            <ServiceFeatured :item="sampleItem" variant="minimal" />
          </div>
          <div class="column is-8">
            <ServiceFeatured :item="sampleItem" variant="split" />
          </div>
        </div>
      </div>

      <div v-if="activeComponent === 'carousel'">
        <h5 class="title is-6 mb-3">ServiceCarousel con slides</h5>
        <ServiceCarousel
          :items="currentDataset"
          :slides-per-view="3"
          :gap="16"
          title="Servicios Destacados"
          description="Desliza para ver más opciones"
        />
      </div>

      <div v-if="activeComponent === 'toggle'">
        <h5 class="title is-6 mb-3">ServiceToggle - Selección múltiple</h5>
        <div class="columns">
          <div class="column is-6">
            <ServiceToggle
              title="Selecciona servicios"
              description="Elige los servicios que necesitas"
              :items="currentDataset"
              :multiple="true"
              show-media
            />
          </div>
          <div class="column is-6">
            <h6 class="title is-6">Variante: Compact</h6>
            <ServiceToggle
              :items="currentDataset.slice(0, 4)"
              :multiple="false"
              variant="compact"
            />
          </div>
        </div>
      </div>

      <div v-if="activeComponent === 'compare'">
        <ServiceCompare
          title="Compara Planes"
          description="Encuentra el plan perfecto para ti"
          :items="compareItems"
          :features="compareFeatures"
        />
      </div>

      <div v-if="activeComponent === 'stepper'">
        <ServiceStepper
          title="Reserva tu Cita"
          :steps="stepperSteps"
          :initial-step="1"
        >
          <template #body-1>
            <p>Selecciona el servicio que necesitas.</p>
            <ServiceToggle :items="currentDataset.slice(0, 3)" :multiple="false" />
          </template>
          <template #body-2>
            <p>Elige la fecha y hora preferida.</p>
            <div class="notification is-info is-light">Calendario de disponibilidad</div>
          </template>
          <template #body-3>
            <p>Confirma los detalles de tu reserva.</p>
            <div class="notification is-success is-light">Resumen de la reserva</div>
          </template>
        </ServiceStepper>
      </div>

      <div v-if="activeComponent === 'filter'">
        <div class="columns">
          <div class="column is-4">
            <ServiceFilter
              title="Filtros"
              :filters="filterOptions"
              :show-apply="true"
            />
          </div>
          <div class="column is-8">
            <h6 class="title is-6">Resultados</h6>
            <ServiceGrid :items="currentDataset" :columns="2" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import {
  ServiceCard,
  ServiceRow,
  ServiceGrid,
  ServiceList,
  ServiceSection,
  ServiceFeatured,
  ServiceCarousel,
  ServiceToggle,
  ServiceCompare,
  ServiceStepper,
  ServiceFilter,
} from '@/Components/Ui/services/index.js'

const activeIndustry = ref('restaurant')
const activeComponent = ref('card')

const industries = [
  { id: 'restaurant', label: 'Restaurant' },
  { id: 'barber', label: 'Barber' },
  { id: 'beauty', label: 'Beauty' },
  { id: 'spa', label: 'Spa' },
  { id: 'medical', label: 'Medical' },
  { id: 'store', label: 'Store' },
  { id: 'cafe', label: 'Café' },
  { id: 'fitness', label: 'Fitness' },
]

const sampleItem = {
  id: 1,
  name: 'Servicio Destacado',
  description: 'Descripción del servicio con información relevante para el cliente',
  price: 350,
  image: 'https://picsum.photos/400/300?random=100',
  badge: 'Popular',
  meta: [{ icon: 'bi-clock', label: '45 min' }, { icon: 'bi-star', label: '4.9' }],
  actions: [{ id: 'book', label: 'Reservar', icon: 'bi-calendar' }],
}

const restaurantData = [
  { id: 1, name: 'Filete de Res', description: 'Corte ribeye 300g con guarnición', price: 450, image: 'https://picsum.photos/400/300?random=101', badge: 'Chef', meta: [{ icon: 'bi-clock', label: '25 min' }], actions: [{ id: 'order', label: 'Ordenar', icon: 'bi-bag' }] },
  { id: 2, name: 'Enchiladas Verdes', description: 'Tres enchiladas con salsa verde', price: 135, image: 'https://picsum.photos/400/300?random=102', badge: 'Popular', meta: [{ icon: 'bi-clock', label: '15 min' }], actions: [{ id: 'order', label: 'Ordenar', icon: 'bi-bag' }] },
  { id: 3, name: 'Paella Valenciana', description: 'Arroz con mariscos y pollo', price: 380, image: 'https://picsum.photos/400/300?random=103', discount: 15, original_price: 450, meta: [{ icon: 'bi-people', label: '2 personas' }], actions: [{ id: 'order', label: 'Ordenar', icon: 'bi-bag' }] },
  { id: 4, name: 'Ceviche', description: 'Pescado fresco en citrus', price: 220, image: 'https://picsum.photos/400/300?random=104', meta: [{ icon: 'bi-clock', label: '20 min' }], actions: [{ id: 'order', label: 'Ordenar', icon: 'bi-bag' }] },
  { id: 5, name: 'Tacos al Pastor', description: 'Tres tacos con todo', price: 105, image: 'https://picsum.photos/400/300?random=105', meta: [{ icon: 'bi-fire', label: '450 kcal' }], actions: [{ id: 'order', label: 'Ordenar', icon: 'bi-bag' }] },
  { id: 6, name: 'Mole Poblano', description: 'Pollo en mole tradicional', price: 195, image: 'https://picsum.photos/400/300?random=106', meta: [{ icon: 'bi-clock', label: '30 min' }], actions: [{ id: 'order', label: 'Ordenar', icon: 'bi-bag' }] },
]

const barberData = [
  { id: 1, name: 'Corte Clásico', description: 'Corte tradicional con acabado', price: 180, image: 'https://picsum.photos/400/300?random=201', badge: '30 min', meta: [{ icon: 'bi-scissors', label: 'Corte' }], actions: [{ id: 'book', label: 'Reservar', icon: 'bi-calendar' }] },
  { id: 2, name: 'Corte + Barba', description: 'Corte completo con barba', price: 280, image: 'https://picsum.photos/400/300?random=202', badge: 'Popular', meta: [{ icon: 'bi-brush', label: '45 min' }], actions: [{ id: 'book', label: 'Reservar', icon: 'bi-calendar' }] },
  { id: 3, name: 'Afeitado Clásico', description: 'Afeitado con navaja', price: 150, image: 'https://picsum.photos/400/300?random=203', badge: 'Premium', meta: [{ icon: 'bi-droplet', label: '25 min' }], actions: [{ id: 'book', label: 'Reservar', icon: 'bi-calendar' }] },
]

const beautyData = [
  { id: 1, name: 'Manicure Gel', description: 'Gel resistente 3 semanas', price: 350, image: 'https://picsum.photos/400/300?random=301', badge: '45 min', meta: [{ icon: 'bi-hand', label: 'Manos' }], actions: [{ id: 'book', label: 'Agendar', icon: 'bi-calendar' }] },
  { id: 2, name: 'Maquillaje', description: 'Profesional para eventos', price: 800, image: 'https://picsum.photos/400/300?random=302', badge: '2 hrs', meta: [{ icon: 'bi-star', label: 'Featured' }], actions: [{ id: 'book', label: 'Agendar', icon: 'bi-calendar' }] },
  { id: 3, name: 'Peinado', description: 'Con planchada y finish', price: 450, image: 'https://picsum.photos/400/300?random=303', badge: '1 hora', meta: [{ icon: 'bi-scissors', label: 'Cabello' }], actions: [{ id: 'book', label: 'Agendar', icon: 'bi-calendar' }] },
]

const spaData = [
  { id: 1, name: 'Masaje Relajante', description: 'Aceites esenciales lavanda', price: 850, badge: '90 min', meta: [{ icon: 'bi-flower1', label: 'Relajante' }], actions: [{ id: 'book', label: 'Reservar', icon: 'bi-calendar' }] },
  { id: 2, name: 'Facial Hidratante', description: 'Mascarilla colágeno', price: 650, badge: '60 min', meta: [{ icon: 'bi-stars', label: 'Facial' }], actions: [{ id: 'book', label: 'Reservar', icon: 'bi-calendar' }] },
  { id: 3, name: 'Masaje Piedras', description: 'Piedras volcánicas', price: 1200, badge: '2 hrs', meta: [{ icon: 'bi-sun', label: 'Premium' }], actions: [{ id: 'book', label: 'Reservar', icon: 'bi-calendar' }] },
]

const medicalData = [
  { id: 1, name: 'Consulta General', description: 'Revisión completa', price: 500, image: 'https://picsum.photos/400/300?random=501', badge: '30 min', meta: [{ icon: 'bi-heart-pulse', label: 'General' }], actions: [{ id: 'book', label: 'Agendar', icon: 'bi-calendar' }] },
  { id: 2, name: 'Limpieza Dental', description: 'Ultrasonido y pulido', price: 800, image: 'https://picsum.photos/400/300?random=502', badge: '45 min', meta: [{ icon: 'bi-brightness', label: 'Dental' }], actions: [{ id: 'book', label: 'Agendar', icon: 'bi-calendar' }] },
  { id: 3, name: 'Check-up', description: 'Paquete integral', price: 2500, image: 'https://picsum.photos/400/300?random=503', badge: 'Paquete', meta: [{ icon: 'bi-clipboard', label: 'Laboratorio' }], actions: [{ id: 'book', label: 'Agendar', icon: 'bi-calendar' }] },
]

const storeData = [
  { id: 1, name: 'Reloj Smart Pro', description: 'GPS, HR, resistencia agua', price: 2499, image: 'https://picsum.photos/400/400?random=601', badge: 'Nuevo', meta: [{ icon: 'bi-shield', label: 'Garantía' }], actions: [{ id: 'buy', label: 'Comprar', icon: 'bi-bag' }] },
  { id: 2, name: 'Audífonos Wireless', description: 'Bluetooth 5.2, ANC', price: 1529, image: 'https://picsum.photos/400/400?random=602', discount: 15, badge: 'Ahorra', meta: [{ icon: 'bi-battery', label: '30 hrs' }], actions: [{ id: 'buy', label: 'Comprar', icon: 'bi-bag' }] },
  { id: 3, name: 'Cargador MagSafe', description: 'Inalámbrico 15W', price: 599, image: 'https://picsum.photos/400/400?random=603', badge: 'Compatible', meta: [{ icon: 'bi-lightning', label: 'Fast' }], actions: [{ id: 'buy', label: 'Comprar', icon: 'bi-bag' }] },
]

const cafeData = [
  { id: 1, name: 'Espresso', description: 'Shot simple o doble', price: 45, badge: 'Single', meta: [{ icon: 'bi-cup-hot', label: 'Solo' }], actions: [{ id: 'order', label: 'Ordenar', icon: 'bi-bag' }] },
  { id: 2, name: 'Cappuccino', description: 'Leche espumada', price: 65, badge: 'Popular', meta: [{ icon: 'bi-cup', label: '12oz' }], actions: [{ id: 'order', label: 'Ordenar', icon: 'bi-bag' }] },
  { id: 3, name: 'Cold Brew', description: 'Filtrado 24 horas', price: 75, badge: 'Refrescante', meta: [{ icon: 'bi-snow2', label: '16oz' }], actions: [{ id: 'order', label: 'Ordenar', icon: 'bi-bag' }] },
]

const fitnessData = [
  { id: 1, name: 'Membresía Mensual', description: 'Acceso ilimitado gym', price: 899, badge: 'Popular', meta: [{ icon: 'bi-calendar', label: '30 días' }], actions: [{ id: 'join', label: 'Unirme', icon: 'bi-person-plus' }] },
  { id: 2, name: 'Pack 10 Clases', description: 'Yoga, pilates, crossfit', price: 1200, badge: 'Ahorra', meta: [{ icon: 'bi-calendar-check', label: '10 sesiones' }], actions: [{ id: 'join', label: 'Unirme', icon: 'bi-person-plus' }] },
  { id: 3, name: 'Training Personal', description: 'Sesión 1-on-1', price: 450, badge: '1-on-1', meta: [{ icon: 'bi-person', label: 'Personal' }], actions: [{ id: 'book', label: 'Agendar', icon: 'bi-calendar' }] },
]

const datasets = { restaurant: restaurantData, barber: barberData, beauty: beautyData, spa: spaData, medical: medicalData, store: storeData, cafe: cafeData, fitness: fitnessData }
const currentDataset = computed(() => datasets[activeIndustry.value] || [])

const currentCategories = computed(() => {
  if (!currentDataset.value.length) return []
  const icons = [...new Set(currentDataset.value.flatMap(item => item.meta?.map(m => m.icon) || []))]
  return icons.map((icon, idx) => ({ id: icon || `cat-${idx}`, label: icon?.replace('bi-', '') || `Categoría ${idx + 1}`, icon }))
})

const compareItems = [
  { id: 1, name: 'Básico', price: 299, period: 'mes', badge: '', featured: false },
  { id: 2, name: 'Profesional', price: 599, period: 'mes', badge: 'Popular', featured: true },
  { id: 3, name: 'Empresarial', price: 1299, period: 'mes', badge: '', featured: false },
]

const compareFeatures = [
  { id: 1, name: 'Servicios incluidos', values: { 1: '5 servicios', 2: '15 servicios', 3: true } },
  { id: 2, name: 'Usuarios', values: { 1: '1 usuario', 2: '5 usuarios', 3: 'Ilimitado' } },
  { id: 3, name: 'Soporte 24/7', values: { 1: false, 2: true, 3: true } },
  { id: 4, name: 'API Access', values: { 1: false, 2: false, 3: true } },
  { id: 5, name: 'Capacitación', values: { 1: false, 2: true, 3: true } },
]

const stepperSteps = [
  { id: 1, title: 'Servicio', description: 'Selecciona el servicio' },
  { id: 2, title: 'Fecha', description: 'Elige fecha y hora' },
  { id: 3, title: 'Confirmar', description: 'Revisa y confirma' },
]

const filterOptions = [
  {
    id: 'category',
    label: 'Categoría',
    type: 'chips',
    options: [
      { id: 'cat1', label: 'Popular' },
      { id: 'cat2', label: 'Nuevos' },
      { id: 'cat3', label: 'Oferta' },
    ],
  },
  {
    id: 'price',
    label: 'Precio',
    type: 'range',
    min: 0,
    max: 2000,
    step: 50,
    prefix: '$',
  },
  {
    id: 'rating',
    label: 'Calificación',
    type: 'checkbox',
    options: [
      { id: '5', label: '5 estrellas', count: 12 },
      { id: '4', label: '4+ estrellas', count: 25 },
      { id: '3', label: '3+ estrellas', count: 8 },
    ],
  },
]
</script>

<style lang="scss" scoped>
.playground-section {
  padding: 1rem 0;
}

.mb-4 {
  margin-bottom: 1rem;
}

.mb-3 {
  margin-bottom: 0.75rem;
}

.mt-4 {
  margin-top: 1.5rem;
}
</style>
