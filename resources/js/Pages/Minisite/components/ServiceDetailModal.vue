<template>
  <OrpModal
    v-model="isOpen"
    :title="service?.name"
    size="lg"
  >
    <div class="service-detail-modal">
      <div class="service-detail-modal__gallery">
        <div v-if="service?.image" class="service-detail-modal__main-image">
          <img :src="service.image" :alt="service?.name" />
        </div>
        <div v-if="service?.gallery?.length > 1" class="service-detail-modal__thumbs">
          <a
            v-for="img in service.gallery"
            :key="img.id"
            :href="img.path"
            class="service-detail-modal__thumb glightbox"
            data-gallery="service-gallery"
            :data-title="service?.name"
          >
            <img :src="img.path" :alt="img.title || service?.name" />
          </a>
        </div>
      </div>

      <div class="service-detail-modal__body">
        <div class="service-detail-modal__header">
          <h2 class="service-detail-modal__name">{{ service?.name }}</h2>
          <div v-if="service?.price" class="service-detail-modal__price orp-price">
            <span class="orp-price__value">{{ formatCurrency(service.price) }}</span>
          </div>
        </div>

        <div class="service-detail-modal__meta orp-cluster orp-cluster--3">
          <div v-if="service?.duration_minutes" class="service-detail-modal__meta-item">
            <i class="bi bi-clock"></i>
            <span>{{ service.duration_minutes }} min</span>
          </div>
          <div v-if="service?.deposit_required" class="service-detail-modal__meta-item">
            <i class="bi bi-currency-dollar"></i>
            <span v-if="service?.deposit_amount">{{ formatCurrency(service.deposit_amount) }} anticipo</span>
            <span v-else>Anticipo</span>
          </div>
          <div v-if="service?.allows_online_booking" class="service-detail-modal__meta-item service-detail-modal__meta-item--success">
            <i class="bi bi-check-circle-fill"></i>
            <span>Reserva online</span>
          </div>
        </div>

        <p v-if="service?.description" class="service-detail-modal__description">
          {{ service.description }}
        </p>

        <div class="service-detail-modal__actions orp-stack orp-stack--3">
          <a
            v-if="service?.allows_online_booking"
            :href="`/m/${businessSlug}/citas`"
            class="orp-btn orp-btn--primary orp-btn--lg service-detail-modal__btn-primary"
          >
            <i class="bi bi-calendar-check"></i>
            Reservar ahora
          </a>
          <a
            v-if="service?.whatsapp_contact"
            :href="`https://wa.me/${service.whatsapp_contact}?text=Hola, me interesa el servicio: ${service?.name}`"
            target="_blank"
            class="orp-btn orp-btn--secondary orp-btn--lg service-detail-modal__btn-whatsapp"
          >
            <i class="bi bi-whatsapp"></i>
            Contactar por WhatsApp
          </a>
          <a
            :href="`/m/${businessSlug}/servicios/${service?.slug}`"
            class="service-detail-modal__tertiary"
          >
            Ver información completa
            <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </OrpModal>
</template>

<script setup>
import { computed, watch, nextTick, onBeforeUnmount } from 'vue'
import OrpModal from '@/Components/OrpUI/OrpModal.vue'
import GLightbox from 'glightbox'
import 'glightbox/dist/css/glightbox.min.css'
import { usePriceFormatter } from '@/Composables/usePriceFormatter'

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false,
  },
  service: {
    type: Object,
    default: null,
  },
  businessSlug: {
    type: String,
    default: '',
  },
})

const emit = defineEmits(['update:modelValue', 'close'])

const isOpen = computed({
  get: () => props.modelValue,
  set: (val) => emit('update:modelValue', val),
})

const { formatPrice } = usePriceFormatter({
  locale: 'es-MX',
  currency: '$',
  decimals: 2,
})

const formatCurrency = (value) => {
  if (value === null || value === undefined) return ''
  return formatPrice(value) || ''
}

let lightboxInstance = null

const initLightbox = () => {
  nextTick(() => {
    if (lightboxInstance) {
      lightboxInstance.destroy()
    }
    lightboxInstance = GLightbox({
      touchNavigation: true,
      loop: true,
      autoplayVideos: false,
      selector: '.service-detail-modal__gallery .glightbox',
    })
  })
}

watch(isOpen, (val) => {
  if (val) {
    initLightbox()
  } else {
    if (lightboxInstance) {
      lightboxInstance.destroy()
      lightboxInstance = null
    }
  }
})

onBeforeUnmount(() => {
  if (lightboxInstance) {
    lightboxInstance.destroy()
    lightboxInstance = null
  }
})
</script>

<style lang="less">
.service-detail-modal {
  display: flex;
  flex-direction: column;
  gap: 0;

  @media (min-width: 768px) {
    flex-direction: row;
    gap: var(--orp-space-6);
  }

  &__gallery {
    flex-shrink: 0;

    @media (min-width: 768px) {
      width: 45%;
    }
  }

  &__main-image {
    width: 100%;
    aspect-ratio: 4 / 3;
    border-radius: var(--orp-radius-lg);
    overflow: hidden;
    background: var(--orp-surface-muted);
    margin-bottom: var(--orp-space-3);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__thumbs {
    display: flex;
    gap: var(--orp-space-2);
    overflow-x: auto;
    padding-bottom: var(--orp-space-2);
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;

    &::-webkit-scrollbar {
      height: 3px;
    }

    &::-webkit-scrollbar-thumb {
      background: var(--orp-border);
      border-radius: 2px;
    }
  }

  &__thumb {
    flex: 0 0 64px;
    height: 64px;
    border-radius: var(--orp-radius-md);
    overflow: hidden;
    display: block;
    scroll-snap-align: start;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    &:hover {
      opacity: 0.85;
    }
  }

  &__body {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: var(--orp-space-4);
    padding-top: var(--orp-space-1);

    @media (min-width: 768px) {
      padding-top: 0;
    }
  }

  &__header {
    display: flex;
    flex-direction: column;
    gap: var(--orp-space-1);
  }

  &__name {
    font-size: var(--orp-font-size-xl);
    font-weight: 700;
    margin: 0;
    color: var(--orp-surface-foreground);
    line-height: 1.2;
  }

  &__price {
    .orp-price__value {
      font-size: var(--orp-font-size-2xl);
      font-weight: 700;
      color: var(--orp-surface-foreground);
    }
  }

  &__meta {
    flex-wrap: wrap;
    gap: var(--orp-space-3);
    padding: var(--orp-space-3) 0;
    border-top: 1px solid var(--orp-border);
    border-bottom: 1px solid var(--orp-border);
  }

  &__meta-item {
    display: flex;
    align-items: center;
    gap: var(--orp-space-1);
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);

    i {
      font-size: 0.875rem;
      color: var(--orp-muted-foreground);
    }

    &--success {
      color: var(--orp-success);

      i {
        color: var(--orp-success);
      }
    }
  }

  &__description {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-surface-foreground);
    line-height: 1.6;
    margin: 0;
  }

  &__actions {
    margin-top: auto;
    padding-top: var(--orp-space-2);
  }

  &__btn-primary {
    width: 100%;
    justify-content: center;
    gap: var(--orp-space-2);
  }

  &__btn-whatsapp {
    width: 100%;
    justify-content: center;
    gap: var(--orp-space-2);
    background-color: #25d366;
    border-color: #25d366;
    color: #fff;

    &:hover:not(:disabled) {
      background-color: #20bd5a;
      border-color: #20bd5a;
      color: #fff;
    }

    &:active:not(:disabled) {
      transform: scale(0.98);
    }
  }

  &__tertiary {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--orp-space-1);
    padding: var(--orp-space-2);
    font-size: var(--orp-font-size-sm);
    font-weight: 500;
    color: var(--orp-muted-foreground);
    text-decoration: none;
    transition: color var(--orp-duration-fast);

    &:hover {
      color: var(--orp-surface-foreground);
    }

    i {
      font-size: 0.75rem;
      transition: transform var(--orp-duration-fast);
    }

    &:hover i {
      transform: translateX(2px);
    }
  }
}
</style>
