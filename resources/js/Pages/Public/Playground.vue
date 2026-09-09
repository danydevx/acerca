<template>
  <div class="playground">
    <header class="playground__header">
      <div class="container">
        <h1 class="playground__title">Minisite Component Playground</h1>
        <p class="playground__subtitle">Prueba y personaliza los componentes del minisite</p>
      </div>
    </header>

    <div class="container" style="padding: 2rem 1.5rem;">
      <nav class="playground-tabs">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          class="playground-tabs__item"
          :class="{ 'playground-tabs__item--active': activeTab === tab.id }"
          @click="activeTab = tab.id"
        >
          {{ tab.label }}
        </button>
      </nav>

      <!-- HEROES TAB -->
      <div v-if="activeTab === 'heroes'" class="playground-section">
        <div class="playground-controls">
          <div class="control-group">
            <label>Title</label>
            <input v-model="hero.title" type="text" />
          </div>
          <div class="control-group">
            <label>Subtitle</label>
            <input v-model="hero.subtitle" type="text" />
          </div>
          <div class="control-group">
            <label>Background Image URL</label>
            <input v-model="hero.backgroundImage" type="text" placeholder="https://..." />
          </div>
          <div class="control-group">
            <label>
              <input v-model="hero.showSocial" type="checkbox" />
              Show Social
            </label>
          </div>
          <div class="control-group">
            <label>Variant</label>
            <select v-model="hero.variant">
              <option value="default">Default</option>
              <option value="dark">Dark</option>
              <option value="gradient">Gradient</option>
              <option value="light">Light</option>
            </select>
          </div>
        </div>

        <div class="component-grid">
          <div class="component-item">
            <h3 class="component-item__title">HeroLeft</h3>
            <div class="component-item__preview">
              <HeroLeft
                :business="business"
                :title="hero.title"
                :subtitle="hero.subtitle"
                :background-image="hero.backgroundImage"
                :show-social="hero.showSocial"
                :social-networks="socialNetworks"
                :config="{ variant: hero.variant }"
              />
            </div>
            <pre class="component-item__code">{{ heroLeftCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">HeroCenter</h3>
            <div class="component-item__preview">
              <HeroCenter
                :business="business"
                :title="hero.title"
                :subtitle="hero.subtitle"
                :background-image="hero.backgroundImage"
                :show-social="hero.showSocial"
                :social-networks="socialNetworks"
                :config="{ variant: hero.variant }"
              />
            </div>
            <pre class="component-item__code">{{ heroCenterCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">HeroRight</h3>
            <div class="component-item__preview">
              <HeroRight
                :business="business"
                :title="hero.title"
                :subtitle="hero.subtitle"
                :background-image="hero.backgroundImage"
                :show-social="hero.showSocial"
                :social-networks="socialNetworks"
                :config="{ variant: hero.variant }"
              />
            </div>
            <pre class="component-item__code">{{ heroRightCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">HeroSimple</h3>
            <div class="component-item__preview">
              <HeroSimple
                :title="hero.title"
                :background-image="hero.backgroundImage"
                business-slug="mi-negocio"
              />
            </div>
            <pre class="component-item__code">{{ heroSimpleCode }}</pre>
          </div>
        </div>
      </div>

      <!-- SECTIONS TAB -->
      <div v-if="activeTab === 'sections'" class="playground-section">
        <div class="playground-controls">
          <div class="control-group">
            <label>Title</label>
            <input v-model="section.title" type="text" />
          </div>
          <div class="control-group">
            <label>Subtitle</label>
            <input v-model="section.subtitle" type="text" />
          </div>
          <div class="control-group">
            <label>Description</label>
            <textarea v-model="section.description" rows="2"></textarea>
          </div>
          <div class="control-group">
            <label>Items Count</label>
            <input v-model.number="section.itemsCount" type="number" min="0" max="20" />
          </div>
          <div class="control-group">
            <label>Scheme</label>
            <select v-model="section.scheme">
              <option value="light">Light</option>
              <option value="dark">Dark</option>
              <option value="primary">Primary</option>
              <option value="secondary">Secondary</option>
              <option value="accent">Accent</option>
              <option value="neutral">Neutral</option>
              <option value="gradient">Gradient</option>
            </select>
          </div>
        </div>

        <div class="component-grid">
          <div class="component-item">
            <h3 class="component-item__title">SectionHero</h3>
            <div class="component-item__preview">
              <SectionHero
                :business="business"
                :title="section.title"
                :subtitle="section.subtitle"
                :config="{ layout: 'left', variant: hero.variant }"
              />
            </div>
            <pre class="component-item__code">{{ sectionHeroCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">SectionServices</h3>
            <div class="component-item__preview">
              <SectionServices
                :title="section.title"
                :subtitle="section.subtitle"
                :description="section.description"
                :items="mockServices"
                :config="{ scheme: section.scheme }"
              />
            </div>
            <pre class="component-item__code">{{ sectionServicesCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">SectionProducts</h3>
            <div class="component-item__preview">
              <SectionProducts
                :title="section.title"
                :subtitle="section.subtitle"
                :items="mockProducts"
                :config="{ scheme: section.scheme }"
              />
            </div>
            <pre class="component-item__code">{{ sectionProductsCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">SectionGallery</h3>
            <div class="component-item__preview">
              <SectionGallery
                :title="section.title"
                :items="mockGallery"
                :config="{ scheme: section.scheme }"
              />
            </div>
            <pre class="component-item__code">{{ sectionGalleryCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">SectionLocations</h3>
            <div class="component-item__preview">
              <SectionLocations
                :title="section.title"
                :items="mockLocations"
                :config="{ scheme: section.scheme }"
              />
            </div>
            <pre class="component-item__code">{{ sectionLocationsCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">SectionReviews</h3>
            <div class="component-item__preview">
              <SectionReviews
                :title="section.title"
                :items="mockReviews"
                :config="{ scheme: section.scheme }"
              />
            </div>
            <pre class="component-item__code">{{ sectionReviewsCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">SectionContactForm</h3>
            <div class="component-item__preview">
              <SectionContactForm
                :title="section.title"
                :subtitle="section.subtitle"
                :config="{ scheme: section.scheme }"
              />
            </div>
            <pre class="component-item__code">{{ sectionContactCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">SectionAbout</h3>
            <div class="component-item__preview">
              <SectionAbout
                :title="section.title"
                :content="section.description"
                :config="{ scheme: section.scheme }"
              />
            </div>
            <pre class="component-item__code">{{ sectionAboutCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">SectionFaqs</h3>
            <div class="component-item__preview">
              <SectionFaqs
                :title="section.title"
                :items="mockFaqs"
                :config="{ scheme: section.scheme }"
              />
            </div>
            <pre class="component-item__code">{{ sectionFaqsCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">SectionFooter</h3>
            <div class="component-item__preview">
              <SectionFooter
                :business="business"
                :show-social="true"
                :social-networks="socialNetworks"
              />
            </div>
            <pre class="component-item__code">{{ sectionFooterCode }}</pre>
          </div>
        </div>
      </div>

      <!-- CARDS TAB -->
      <div v-if="activeTab === 'cards'" class="playground-section">
        <div class="playground-controls">
          <div class="control-group">
            <label>Title</label>
            <input v-model="card.title" type="text" />
          </div>
          <div class="control-group">
            <label>Description</label>
            <textarea v-model="card.description" rows="2"></textarea>
          </div>
          <div class="control-group">
            <label>Price</label>
            <input v-model="card.price" type="text" />
          </div>
          <div class="control-group">
            <label>Show Image</label>
            <select v-model="card.showImage">
              <option :value="true">Yes</option>
              <option :value="false">No</option>
            </select>
          </div>
        </div>

        <div class="component-grid">
          <div class="component-item">
            <h3 class="component-item__title">ServiceCard</h3>
            <div class="component-item__preview">
              <ServiceCard
                :item="mockService"
                :show-image="card.showImage"
              />
            </div>
            <pre class="component-item__code">{{ serviceCardCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">ServiceListItem</h3>
            <div class="component-item__preview">
              <ServiceListItem
                :item="mockService"
              />
            </div>
            <pre class="component-item__code">{{ serviceListCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">ProductCard</h3>
            <div class="component-item__preview">
              <ProductCard
                :item="mockProduct"
                :show-image="card.showImage"
              />
            </div>
            <pre class="component-item__code">{{ productCardCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">ProductListItem</h3>
            <div class="component-item__preview">
              <ProductListItem
                :item="mockProduct"
              />
            </div>
            <pre class="component-item__code">{{ productListCode }}</pre>
          </div>
        </div>
      </div>

      <!-- SHARED TAB -->
      <div v-if="activeTab === 'shared'" class="playground-section">
        <div class="component-grid">
          <div class="component-item">
            <h3 class="component-item__title">Footer</h3>
            <div class="component-item__preview">
              <Footer
                :business="business"
                :show-social="true"
                :social-networks="socialNetworks"
              />
            </div>
            <pre class="component-item__code">{{ footerCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">NavigationMenu</h3>
            <div class="component-item__preview">
              <NavigationMenu
                :business="business"
                :config="{}"
              />
            </div>
            <pre class="component-item__code">{{ navCode }}</pre>
          </div>
        </div>
      </div>

      <!-- COMPOSED UI TAB -->
      <div v-if="activeTab === 'composed'" class="playground-section">
        <div class="component-grid">
          <div class="component-item">
            <h3 class="component-item__title">BookingScheduler — Barber</h3>
            <div class="component-item__preview">
              <BookingScheduler
                :service="barberService"
                :availability="mockAvailability"
                :timezone="timezone"
                select-date-message="Selecciona una fecha para ver horarios"
                empty-slots-message="No hay turnos disponibles"
                confirm-text="Reservar"
                @confirm="handleBookingConfirm"
              />
            </div>
            <pre class="component-item__code">{{ bookingSchedulerCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">BookingScheduler — Beauty Salon</h3>
            <div class="component-item__preview">
              <BookingScheduler
                :service="beautyService"
                :availability="mockAvailability"
                :timezone="timezone"
                select-date-message="Selecciona una fecha para ver horarios"
                empty-slots-message="No hay turnos disponibles"
                confirm-text="Agendar"
                @confirm="handleBookingConfirm"
              />
            </div>
            <pre class="component-item__code">{{ bookingSchedulerCode }}</pre>
          </div>

          <div class="component-item">
            <h3 class="component-item__title">BookingScheduler — Professional</h3>
            <div class="component-item__preview">
              <BookingScheduler
                :service="professionalService"
                :availability="mockAvailability"
                :timezone="timezone"
                select-date-message="Selecciona una fecha para ver horarios"
                empty-slots-message="No hay disponibilidad"
                confirm-text="Confirmar cita"
                @confirm="handleBookingConfirm"
              />
            </div>
            <pre class="component-item__code">{{ bookingSchedulerCode }}</pre>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import HeroLeft from '@/Pages/Minisite/components/HeroLeft.vue'
import HeroCenter from '@/Pages/Minisite/components/HeroCenter.vue'
import HeroRight from '@/Pages/Minisite/components/HeroRight.vue'
import HeroSimple from '@/Pages/Minisite/components/HeroSimple.vue'
import SectionHero from '@/Pages/Minisite/components/SectionHero.vue'
import SectionServices from '@/Pages/Minisite/components/SectionServices.vue'
import SectionProducts from '@/Pages/Minisite/components/SectionProducts.vue'
import SectionGallery from '@/Pages/Minisite/components/SectionGallery.vue'
import SectionLocations from '@/Pages/Minisite/components/SectionLocations.vue'
import SectionReviews from '@/Pages/Minisite/components/SectionReviews.vue'
import SectionContactForm from '@/Pages/Minisite/components/SectionContactForm.vue'
import SectionAbout from '@/Pages/Minisite/components/SectionAbout.vue'
import SectionFaqs from '@/Pages/Minisite/components/SectionFaqs.vue'
import SectionFooter from '@/Pages/Minisite/components/SectionFooter.vue'
import ServiceCard from '@/Pages/Minisite/components/ServiceCard.vue'
import ServiceListItem from '@/Pages/Minisite/components/ServiceListItem.vue'
import ProductCard from '@/Pages/Minisite/components/ProductCard.vue'
import ProductListItem from '@/Pages/Minisite/components/ProductListItem.vue'
import Footer from '@/Pages/Minisite/components/Footer.vue'
import NavigationMenu from '@/Pages/Minisite/components/NavigationMenu.vue'
import BookingScheduler from '@/Components/Ui/booking/BookingScheduler.vue'

const tabs = [
  { id: 'heroes', label: 'Heroes' },
  { id: 'sections', label: 'Sections' },
  { id: 'cards', label: 'Cards' },
  { id: 'shared', label: 'Shared' },
  { id: 'composed', label: 'Composed UI' },
]

const activeTab = ref('heroes')

const hero = ref({
  title: 'Barbería Central',
  subtitle: 'Los mejores cortes de la ciudad',
  backgroundImage: '',
  showSocial: true,
  variant: 'default',
})

const section = ref({
  title: 'Nuestros Servicios',
  subtitle: 'Calidad garantizada',
  description: 'Ofrecemos una amplia gama de servicios de barbería y grooming para hombre.',
  itemsCount: 6,
  scheme: 'light',
})

const card = ref({
  title: 'Corte de Cabello',
  description: 'Corte clásico con acabado profesional, incluye lavado y secado.',
  price: '$250',
  showImage: true,
})

const business = {
  name: 'Barbería Central',
  logo: 'https://picsum.photos/seed/logo1/200/200',
  slug: 'barberia-central',
  description: 'La mejor barbería de la ciudad.',
}

const socialNetworks = [
  { platform: 'Facebook', url: 'https://facebook.com' },
  { platform: 'Instagram', url: 'https://instagram.com' },
  { platform: 'WhatsApp', url: 'https://wa.me/5215512345678' },
]

const mockServices = computed(() => Array.from({ length: section.value.itemsCount }, (_, i) => ({
  id: i + 1,
  name: `Servicio ${i + 1}`,
  description: 'Descripción del servicio',
  price: 250 + i * 50,
  duration_minutes: 30 + i * 15,
})))

const mockProducts = computed(() => Array.from({ length: section.value.itemsCount }, (_, i) => ({
  id: i + 1,
  title: `Producto ${i + 1}`,
  description: 'Descripción del producto',
  price: 350 + i * 100,
  image: 'https://picsum.photos/seed/prod' + i + '/400/300',
})))

const mockGallery = computed(() => Array.from({ length: Math.min(section.value.itemsCount, 8) }, (_, i) => ({
  id: i + 1,
  path: `https://picsum.photos/seed/gal${i}/800/600`,
  title: `Imagen ${i + 1}`,
})))

const mockLocations = computed(() => [{
  id: 1,
  name: 'Sucursal Principal',
  address: 'Av. Principal #123',
  city: 'Ciudad de México',
  state: 'CDMX',
  phone: '55 1234 5678',
}])

const mockReviews = computed(() => Array.from({ length: Math.min(section.value.itemsCount, 4) }, (_, i) => ({
  id: i + 1,
  client_name: `Cliente ${i + 1}`,
  rating: 4 + (i % 2),
  comment: 'Excelente servicio, muy profesional.',
  created_at: new Date().toISOString(),
})))

const mockFaqs = computed(() => Array.from({ length: Math.min(section.value.itemsCount, 5) }, (_, i) => ({
  id: i + 1,
  question: `Pregunta frecuente número ${i + 1}?`,
  answer: 'Esta es la respuesta a la pregunta frecuente.',
})))

const mockService = {
  id: 1,
  name: 'Corte de Cabello',
  description: 'Corte clásico con acabado profesional, incluye lavado y secado.',
  price: 250,
  duration_minutes: 45,
  image: 'https://picsum.photos/seed/service1/400/300',
}

const mockProduct = {
  id: 1,
  name: 'Pomada Capilar',
  title: 'Pomada Capilar',
  description: 'Pomada para cabello con fijacion fuerte.',
  price: 350,
  compare_at_price: 450,
  image: 'https://picsum.photos/seed/product1/400/300',
}

const heroLeftCode = computed(() => `<HeroLeft
  :business="business"
  title="${hero.value.title}"
  subtitle="${hero.value.subtitle}"
  :background-image="${hero.value.backgroundImage || ''}"
  :show-social="${hero.value.showSocial}"
  :social-networks="socialNetworks"
  :config="{ variant: '${hero.value.variant}' }"
/>`)

const heroCenterCode = computed(() => `<HeroCenter
  :business="business"
  title="${hero.value.title}"
  subtitle="${hero.value.subtitle}"
  :background-image="${hero.value.backgroundImage || ''}"
  :show-social="${hero.value.showSocial}"
  :social-networks="socialNetworks"
  :config="{ variant: '${hero.value.variant}' }"
/>`)

const heroRightCode = computed(() => `<HeroRight
  :business="business"
  title="${hero.value.title}"
  subtitle="${hero.value.subtitle}"
  :background-image="${hero.value.backgroundImage || ''}"
  :show-social="${hero.value.showSocial}"
  :social-networks="socialNetworks"
  :config="{ variant: '${hero.value.variant}' }"
/>`)

const heroSimpleCode = computed(() => `<HeroSimple
  title="${hero.value.title}"
  business-slug="mi-negocio"
  :background-image="${hero.value.backgroundImage || ''}"
/>`)

const sectionHeroCode = computed(() => `<SectionHero
  :business="business"
  title="${section.value.title}"
  subtitle="${section.value.subtitle}"
  :config="{ layout: 'left', variant: '${hero.value.variant}' }"
/>`)

const sectionServicesCode = computed(() => `<SectionServices
  title="${section.value.title}"
  subtitle="${section.value.subtitle}"
  :items="services"
  :config="{ scheme: '${section.value.scheme}' }"
/>`)

const sectionProductsCode = computed(() => `<SectionProducts
  title="${section.value.title}"
  :items="products"
  :config="{ scheme: '${section.value.scheme}' }"
/>`)

const sectionGalleryCode = computed(() => `<SectionGallery
  title="${section.value.title}"
  :items="galleryImages"
  :config="{ scheme: '${section.value.scheme}' }"
/>`)

const sectionLocationsCode = computed(() => `<SectionLocations
  title="${section.value.title}"
  :items="locations"
  :config="{ scheme: '${section.value.scheme}' }"
/>`)

const sectionReviewsCode = computed(() => `<SectionReviews
  title="${section.value.title}"
  :items="reviews"
  :config="{ scheme: '${section.value.scheme}' }"
/>`)

const sectionContactCode = computed(() => `<SectionContactForm
  title="${section.value.title}"
  subtitle="${section.value.subtitle}"
  :config="{ scheme: '${section.value.scheme}' }"
/>`)

const sectionAboutCode = computed(() => `<SectionAbout
  title="${section.value.title}"
  content="${section.value.description}"
  :config="{ scheme: '${section.value.scheme}' }"
/>`)

const sectionFaqsCode = computed(() => `<SectionFaqs
  title="${section.value.title}"
  :items="faqs"
  :config="{ scheme: '${section.value.scheme}' }"
/>`)

const sectionFooterCode = `<SectionFooter
  :business="business"
  :show-social="true"
  :social-networks="socialNetworks"
/>`

const serviceCardCode = computed(() => `<ServiceCard
  :item="service"
  :show-image="${card.value.showImage}"
/>`)

const serviceListCode = `<ServiceListItem
  :item="service"
/>`

const productCardCode = computed(() => `<ProductCard
  :item="product"
  :show-image="${card.value.showImage}"
/>`)

const productListCode = `<ProductListItem
  :item="product"
/>`

const footerCode = `<Footer
  :business="business"
  :show-social="true"
  :social-networks="socialNetworks"
/>`

const navCode = `<NavigationMenu
  :business="business"
  :config="{}"
/>`

const timezone = {
  label: 'Ciudad de México (GMT-6)',
  value: 'America/Mexico_City',
}

const barberService = {
  title: 'Corte clásico',
  provider: 'Marivi Ruiz',
  duration: 30,
  description: 'Corte tradicional con acabado profesional, incluye lavado y secado.',
  locationType: 'in_person',
  price: '$250',
}

const beautyService = {
  title: 'Manicure gel',
  provider: 'Ana López',
  duration: 45,
  description: 'Uñas en gel con diseño personalizado y duración de 3 semanas.',
  locationType: 'in_person',
  location: 'Sucursal Centro',
  price: '$450',
}

const professionalService = {
  title: 'Consultoría inicial',
  provider: 'Dr. García',
  duration: 60,
  description: 'Consulta de valoración para nuevos pacientes. Incluye historial clínico.',
  locationType: 'online',
  price: '$800',
}

const mockAvailability = {
  '2026-09-08': ['10:00', '10:30', '11:00', '11:30', '14:00', '14:30', '15:00', '15:30', '16:00'],
  '2026-09-09': ['09:00', '09:30', '10:00', '10:30', '11:00', '13:00', '13:30', '14:00'],
  '2026-09-10': ['10:00', '10:30', '11:00', '11:30', '12:00', '14:30', '15:00', '15:30', '16:00', '16:30'],
  '2026-09-11': ['09:00', '09:30', '10:00', '10:30', '11:00', '14:00', '14:30', '15:00'],
  '2026-09-14': ['10:00', '10:30', '11:00', '11:30', '14:00', '14:30', '15:00', '15:30'],
  '2026-09-15': ['09:00', '09:30', '10:00', '10:30', '11:00', '13:30', '14:00', '14:30', '15:00'],
  '2026-09-16': ['10:00', '10:30', '11:00', '11:30', '12:00', '14:00', '14:30', '15:00', '15:30', '16:00'],
}

const bookingSchedulerCode = computed(() => `<BookingScheduler
  :service="service"
  :availability="availability"
  :timezone="timezone"
  @confirm="handleBookingConfirm"
/>`)

const handleBookingConfirm = (data) => {
  console.log('Booking confirmed:', data)
  alert(`Reserva confirmada para ${data.date.toLocaleDateString('es-ES')} a las ${data.time}`)
}
</script>

<style lang="scss">
.playground {
  min-height: 100vh;
  background: #f9fafb;
}

.playground__header {
  background: linear-gradient(135deg, #3B82F6 0%, #6B7280 100%);
  color: white;
  padding: 3rem 1.5rem;
}

.playground__title {
  font-size: 2rem;
  font-weight: 700;
  margin: 0 0 0.5rem;
}

.playground__subtitle {
  opacity: 0.85;
  margin: 0;
}

.playground-tabs {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
  margin-bottom: 1.5rem;
  border-bottom: 2px solid #e5e7eb;
  padding-bottom: 0.5rem;

  &__item {
    padding: 0.75rem 1.25rem;
    border: none;
    background: transparent;
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    border-radius: 8px 8px 0 0;
    transition: all 0.2s;

    &:hover {
      background: #f3f4f6;
      color: #374151;
    }

    &--active {
      color: #3B82F6;
      border-bottom: 2px solid #3B82F6;
      margin-bottom: -2px;
    }
  }
}

.playground-section {
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.playground-controls {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 1rem;
  padding: 1.5rem;
  background: white;
  border-radius: 12px;
  margin-bottom: 2rem;
  border: 1px solid #e5e7eb;

  .control-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;

    label {
      font-size: 0.875rem;
      font-weight: 500;
      color: #374151;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    input[type="text"],
    input[type="number"],
    textarea,
    select {
      padding: 0.5rem 0.75rem;
      border: 1px solid #e5e7eb;
      border-radius: 6px;
      font-size: 0.875rem;

      &:focus {
        outline: none;
        border-color: #3B82F6;
      }
    }

    textarea {
      resize: vertical;
      min-height: 60px;
    }

    input[type="checkbox"] {
      width: 18px;
      height: 18px;
    }
  }
}

.component-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(100%, 1fr));
  gap: 2rem;
}

.component-item {
  background: white;
  border-radius: 12px;
  border: 1px solid #e5e7eb;
  overflow: hidden;

  &__title {
    font-size: 1rem;
    font-weight: 600;
    color: #374151;
    padding: 1rem 1.5rem;
    margin: 0;
    border-bottom: 1px solid #e5e7eb;
    background: #f9fafb;
  }

  &__preview {
    padding: 1rem;
    min-height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f5f5f5;
  }

  &__code {
    background: #1f2937;
    color: #10B981;
    padding: 1rem 1.5rem;
    margin: 0;
    font-size: 0.8125rem;
    overflow-x: auto;
    font-family: 'Monaco', 'Menlo', 'Courier New', monospace;
    white-space: pre-wrap;
    word-break: break-all;
  }
}


</style>
