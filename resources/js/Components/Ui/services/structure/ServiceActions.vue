<template>
  <div class="service-actions">
    <a
      v-if="allowsOnlineBooking"
      :href="bookingUrl"
      class="button is-primary is-medium service-actions__btn-primary"
    >
      <i class="bi bi-calendar-check mr-2"></i>
      Reservar ahora
    </a>
    <a
      v-if="whatsappContact"
      :href="whatsappUrl"
      target="_blank"
      class="button is-medium service-actions__btn-whatsapp"
    >
      <i class="bi bi-whatsapp mr-2"></i>
      Contactar por WhatsApp
    </a>
    <a
      v-if="slug"
      :href="detailsUrl"
      class="service-actions__tertiary"
    >
      Ver información completa
      <i class="bi bi-arrow-right ml-1"></i>
    </a>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  allowsOnlineBooking: {
    type: Boolean,
    default: false,
  },
  whatsappContact: {
    type: String,
    default: '',
  },
  slug: {
    type: String,
    default: '',
  },
  serviceName: {
    type: String,
    default: '',
  },
  businessSlug: {
    type: String,
    default: '',
  },
})

const bookingUrl = computed(() => `/m/${props.businessSlug}/citas`)
const whatsappUrl = computed(() => {
  if (!props.whatsappContact) return '#'
  const text = encodeURIComponent(`Hola, me interesa el servicio: ${props.serviceName}`)
  return `https://wa.me/${props.whatsappContact}?text=${text}`
})
const detailsUrl = computed(() => `/m/${props.businessSlug}/servicios/${props.slug}`)
</script>

<style lang="scss" scoped>
.service-actions {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  margin-top: auto;
}

.service-actions__btn-primary {
  width: 100%;
  justify-content: center;
}

.service-actions__btn-whatsapp {
  width: 100%;
  justify-content: center;
  background-color: oklch(0.72 0.19 142);
  border-color: oklch(0.72 0.19 142);
  color: var(--bulma-scheme-main);

  &:hover:not(:disabled) {
    background-color: oklch(0.68 0.2 142);
    border-color: oklch(0.68 0.2 142);
    color: var(--bulma-scheme-main);
  }

  &:active:not(:disabled) {
    transform: scale(0.98);
  }
}

.service-actions__tertiary {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.25rem;
  padding: 0.5rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--bulma-text-weak);
  text-decoration: none;
  transition: color 0.15s;

  &:hover {
    color: var(--bulma-link);
  }

  i {
    font-size: 0.75rem;
    transition: transform 0.15s;
  }

  &:hover i {
    transform: translateX(2px);
  }
}
</style>
