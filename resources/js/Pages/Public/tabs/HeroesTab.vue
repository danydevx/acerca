<template>
  <div class="playground-section">
    <div class="box">
      <h3 class="title is-4">Hero Classic</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <HeroClassic
            :cover="profileData.cover"
            :avatar="profileData.avatar"
            :name="profileData.name"
            :title="profileData.title"
            :company="profileData.company"
            :description="profileData.description"
            :badges="profileData.badges"
            :socials="profileData.socials"
            :verified="true"
          />
        </div>
        <div class="column is-4">
          <HeroClassic
            :cover="profileData.cover"
            :avatar="profileData.avatar"
            :name="profileData.name"
            :title="profileData.title"
            :company="profileData.company"
            :badges="profileData.badges"
            :actions="primaryActions"
          />
        </div>
        <div class="column is-4">
          <HeroClassic
            :cover="profileData.cover"
            :avatar="profileData.avatar"
            :name="profileData.name"
            :title="profileData.title"
            :company="profileData.company"
            :description="profileData.description"
            :socials="profileData.socials"
            :actions="primaryActions"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Hero Centered Profile</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <HeroCentered
            :avatar="profileData.avatar"
            :name="profileData.name"
            :title="profileData.title"
            :company="profileData.company"
            :badges="profileData.badges"
            :socials="profileData.socials"
            :verified="true"
          />
        </div>
        <div class="column is-4">
          <HeroCentered
            :cover="profileData.cover"
            :avatar="profileData.avatar"
            :name="profileData.name"
            :title="profileData.title"
            :badges="profileData.badges"
            :description="profileData.description"
            :actions="primaryActions"
            :verified="true"
          />
        </div>
        <div class="column is-4">
          <HeroCentered
            :logo="profileData.logo"
            :name="profileData.name"
            :title="profileData.title"
            :company="profileData.company"
            :badges="profileData.badges"
            :socials="profileData.socials"
            :icon-only-socials="true"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Hero Overlay</h3>
      <div class="columns is-multiline">
        <div class="column is-6">
          <HeroOverlayVariant
            :cover="profileData.cover"
            :avatar="profileData.avatar"
            :name="profileData.name"
            :title="profileData.title"
            :badges="profileData.badges"
            :contacts="contactActions"
            :actions="primaryActions"
            :verified="true"
          />
        </div>
        <div class="column is-6">
          <HeroOverlayVariant
            :cover="restaurantData.cover"
            :avatar="restaurantData.avatar"
            :name="restaurantData.name"
            :title="restaurantData.category"
            :badges="restaurantData.badges"
            :contacts="restaurantData.contacts"
            overlay-variant="gradient-center"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Hero Split</h3>
      <div class="columns is-multiline">
        <div class="column is-6">
          <HeroSplit
            :cover="profileData.cover"
            :avatar="profileData.avatar"
            :name="profileData.name"
            :title="profileData.title"
            :company="profileData.company"
            :description="profileData.description"
            :badges="profileData.badges"
            :contacts="contactActions"
            :socials="profileData.socials"
            :verified="true"
          />
        </div>
        <div class="column is-6">
          <HeroSplit
            :cover="restaurantData.cover"
            :avatar="restaurantData.logo"
            :name="restaurantData.name"
            :title="restaurantData.category"
            :description="restaurantData.description"
            :badges="restaurantData.badges"
            :contacts="restaurantData.contacts"
            :reversed="true"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Hero Minimal</h3>
      <div class="columns is-multiline">
        <div class="column is-6">
          <HeroMinimal
            :avatar="profileData.avatar"
            :name="profileData.name"
            :title="profileData.title"
            :company="profileData.company"
            :description="profileData.description"
            :actions="primaryActions"
            :socials="profileData.socials"
            :verified="true"
          />
        </div>
        <div class="column is-6">
          <HeroMinimal
            :avatar="profileData.avatar"
            :name="profileData.name"
            :title="profileData.title"
            :company="profileData.company"
            :description="profileData.description"
            :socials="profileData.socials"
            :centered="true"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Hero Business</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <HeroBusiness
            :cover="businessData.cover"
            :logo="businessData.logo"
            :name="businessData.name"
            :category="businessData.category"
            :description="businessData.description"
            :badges="businessData.badges"
            :contacts="businessData.contacts"
            :rating="businessData.rating"
            :review-count="businessData.reviewCount"
            :show-rating="true"
            :is-open="true"
            :closes-at="'20:00'"
          />
        </div>
        <div class="column is-4">
          <HeroBusiness
            :cover="restaurantData.cover"
            :logo="restaurantData.logo"
            :name="restaurantData.name"
            :category="restaurantData.category"
            :badges="restaurantData.badges"
            :contacts="restaurantData.contacts"
            :rating="restaurantData.rating"
            :review-count="restaurantData.reviewCount"
            :show-rating="true"
            :is-open="true"
            :closes-at="'22:00'"
          />
        </div>
        <div class="column is-4">
          <HeroBusiness
            :logo="businessData.logo"
            :name="businessData.name"
            :category="businessData.category"
            :is-open="false"
            :opens-at="'09:00'"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Hero Floating</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <HeroFloating
            :cover="profileData.cover"
            :avatar="profileData.avatar"
            :name="profileData.name"
            :title="profileData.title"
            :company="profileData.company"
            :badges="profileData.badges"
            :actions="primaryActions"
            :socials="profileData.socials"
            :verified="true"
          />
        </div>
        <div class="column is-4">
          <HeroFloating
            :cover="restaurantData.cover"
            :avatar="restaurantData.logo"
            :name="restaurantData.name"
            :title="restaurantData.category"
            :badges="restaurantData.badges"
            :actions="primaryActions"
          />
        </div>
        <div class="column is-4">
          <HeroFloating
            :cover="profileData.cover"
            :avatar="profileData.avatar"
            :name="profileData.name"
            :title="profileData.title"
            :description="profileData.description"
            :actions="primaryActions"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Hero Full Bleed</h3>
      <div class="columns is-multiline">
        <div class="column is-6">
          <HeroFullBleed
            :cover="profileData.cover"
            :name="profileData.name"
            :title="profileData.title"
            :company="profileData.company"
            :badges="profileData.badges"
            :actions="primaryActions"
            :socials="profileData.socials"
          />
        </div>
        <div class="column is-6">
          <HeroFullBleed
            :cover="restaurantData.cover"
            :name="restaurantData.name"
            :title="restaurantData.category"
            :description="restaurantData.description"
            :badges="restaurantData.badges"
            :actions="primaryActions"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Hero Experimental</h3>
      <div class="columns is-multiline">
        <div class="column is-6">
          <HeroSplit
            :cover="profileData.cover"
            :avatar="profileData.avatar"
            :name="profileData.name"
            :title="profileData.title"
            :company="profileData.company"
            :badges="profileData.badges"
            :actions="primaryActions"
          />
        </div>
        <div class="column is-6">
          <HeroCentered
            :cover="restaurantData.cover"
            :avatar="restaurantData.logo"
            :name="restaurantData.name"
            :title="restaurantData.category"
            :badges="restaurantData.badges"
            :contacts="restaurantData.contacts"
            :actions="primaryActions"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import {
  HeroClassic,
  HeroCentered,
  HeroOverlayVariant,
  HeroSplit,
  HeroMinimal,
  HeroBusiness,
  HeroFloating,
  HeroFullBleed,
} from '@/Components/Ui/heroes'

const profileData = ref({
  name: 'Daniel López',
  title: 'Web Developer',
  company: 'Orpot Studio',
  description: 'Desarrollo web y soluciones digitales personalizadas.',
  avatar: 'https://picsum.photos/200/200?random=100',
  cover: 'https://picsum.photos/800/400?random=101',
  logo: '',
  badges: [
    { text: 'Verificado', variant: 'primary', icon: 'bi bi-check-circle-fill' },
    { text: 'Premium', variant: 'secondary' },
  ],
  socials: [
    { network: 'instagram', url: '#', label: 'Instagram' },
    { network: 'linkedin', url: '#', label: 'LinkedIn' },
    { network: 'github', url: '#', label: 'GitHub' },
  ],
})

const restaurantData = ref({
  name: 'La Trattoria',
  category: 'Restaurante Italiano',
  description: 'Auténtica cocina italiana con ingredientes frescos.',
  avatar: '',
  logo: 'https://picsum.photos/200/200?random=102',
  cover: 'https://picsum.photos/800/400?random=103',
  badges: [
    { text: 'Abierto', variant: 'success' },
    { text: 'Top 10', variant: 'warning' },
  ],
  contacts: [
    { type: 'phone', value: '+52 55 1234 5678', label: 'Teléfono' },
    { type: 'whatsapp', value: '+52 55 1234 5678', label: 'WhatsApp' },
    { type: 'address', value: 'Av. Roma 123, CDMX', label: 'Dirección' },
  ],
  rating: 4.8,
  reviewCount: 234,
})

const businessData = ref({
  name: 'Barbería El Reyes',
  category: 'Barbería',
  description: 'Cortes clássicos y modernos.',
  avatar: '',
  logo: 'https://picsum.photos/200/200?random=104',
  cover: 'https://picsum.photos/800/400?random=105',
  badges: [
    { text: 'Premium', variant: 'primary' },
    { text: 'Nuevo', variant: 'info' },
  ],
  contacts: [
    { type: 'phone', value: '+52 55 1234 5678', label: 'Llamar' },
    { type: 'whatsapp', value: '+52 55 1234 5678', label: 'WhatsApp' },
    { type: 'directions', value: 'Av. Centro 456, CDMX', label: 'Cómo llegar' },
  ],
  rating: 4.9,
  reviewCount: 156,
})

const primaryActions = ref([
  { label: 'Contactar', href: '#', variant: 'primary' },
  { label: 'Ver más', href: '#', variant: 'secondary' },
])

const contactActions = ref([
  { type: 'whatsapp', value: '+52 55 1234 5678', label: 'WhatsApp' },
  { type: 'phone', value: '+52 55 1234 5678', label: 'Llamar' },
  { type: 'email', value: 'contacto@ejemplo.com', label: 'Email' },
])
</script>

<style lang="scss" scoped>
.playground-section {
  padding: 1rem 0;
}

.mb-4 {
  margin-bottom: 1rem;
}
</style>
