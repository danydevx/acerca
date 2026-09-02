<template>
  <div class="nav-menu">
    <header class="nav-menu__header">
      <OrpIconButton
        variant="ghost"
        size="md"
        aria-label="Abrir menú"
        @click="isOpen = true"
      >
        <i class="bi bi-list"></i>
      </OrpIconButton>
      <div class="nav-menu__brand">
        <div v-if="business?.logo" class="orp-avatar orp-avatar--md">
          <img :src="business.logo" :alt="business.name" class="orp-avatar__image" />
        </div>
        <span class="nav-menu__name">{{ business?.name }}</span>
      </div>
    </header>

    <OrpDrawer
      v-model="isOpen"
      position="left"
      :title="business?.name"
    >
      <ul class="orp-list orp-list--divided">
        <li v-for="item in menuItems" :key="item.url" class="orp-list__item orp-list__item--interactive">
          <a :href="item.url" class="orp-list__content" @click="isOpen = false">
            <i v-if="item.icon" :class="item.icon"></i>
            <span>{{ item.name }}</span>
          </a>
        </li>
      </ul>
    </OrpDrawer>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import OrpDrawer from '@/Components/OrpUI/OrpDrawer.vue'
import OrpIconButton from '@/Components/OrpUI/OrpIconButton.vue'

const props = defineProps({
  business: {
    type: Object,
    default: () => ({}),
  },
  existingSections: {
    type: Array,
    default: () => [],
  },
})

const isOpen = ref(false)

const menuOrder = [
  { key: 'services', name: 'Servicios', url: '/servicios', icon: 'bi bi-briefcase' },
  { key: 'products', name: 'Productos', url: '/productos', icon: 'bi bi-box' },
  { key: 'restaurant_menu', name: 'Menú', url: '/menu', icon: 'bi bi-cup-hot' },
  { key: 'gallery', name: 'Galería', url: '/galeria', icon: 'bi bi-images' },
  { key: 'appointments', name: 'Citas y Reservas', url: '/citas', icon: 'bi bi-calendar-check' },
  { key: 'promotions', name: 'Promociones', url: '/promociones', icon: 'bi bi-tag' },
  { key: 'locations', name: 'Ubicaciones', url: '/ubicaciones', icon: 'bi bi-geo-alt' },
  { key: 'reviews', name: 'Reseñas', url: '/resenas', icon: 'bi bi-star' },
  { key: 'properties', name: 'Propiedades', url: '/propiedades', icon: 'bi bi-building' },
  { key: 'faqs', name: 'Preguntas Frecuentes', url: '/preguntas-frecuentes', icon: 'bi bi-question-circle' },
  { key: 'contact_form', name: 'Contacto', url: '/contacto', icon: 'bi bi-envelope' },
]

const menuItems = computed(() => {
  const baseUrl = `/m/${props.business?.slug || ''}`
  const items = [{ key: 'home', name: 'Inicio', url: baseUrl, icon: 'bi bi-house' }]

  for (const menuItem of menuOrder) {
    const sectionExists = props.existingSections.includes(menuItem.key)
    if (sectionExists) {
      items.push({ ...menuItem, url: baseUrl + menuItem.url })
    }
  }

  return items
})
</script>

<style lang="less">
.nav-menu {
  &__header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: var(--orp-app-bar-height, 64px);
    background: var(--orp-background);
    display: flex;
    align-items: center;
    padding: 0 var(--orp-space-2);
    z-index: var(--orp-z-fixed);
    box-shadow: var(--orp-shadow-sm);
  }

  &__brand {
    display: flex;
    align-items: center;
    gap: var(--orp-space-2);
    margin-left: var(--orp-space-2);
    flex: 1;
    min-width: 0;
  }

  &__name {
    font-weight: 600;
    font-size: var(--orp-font-size-lg);
    color: var(--orp-foreground);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
}
</style>
