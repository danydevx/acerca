<template>
  <UiModal
    v-model="isOpen"
    :title="service?.name"
    size="lg"
  >
    <div class="service-detail-modal">
      <ServiceGallery
        :main-image="service?.image"
        :images="service?.gallery || []"
        :name="service?.name"
        class="service-detail-modal__gallery"
      />

      <div class="service-detail-modal__body">
        <div class="service-detail-modal__header">
          <h2 class="service-detail-modal__name">{{ service?.name }}</h2>
          <div v-if="service?.price" class="service-detail-modal__price">
            <span class="service-detail-modal__price-value">{{ formattedPrice }}</span>
          </div>
        </div>

        <ServiceMeta
          :duration-minutes="service?.duration_minutes"
          :deposit-required="service?.deposit_required"
          :deposit-amount="service?.deposit_amount"
          :allows-online-booking="service?.allows_online_booking"
        />

        <p v-if="service?.description" class="service-detail-modal__description">
          {{ service.description }}
        </p>

        <ServiceActions
          :allows-online-booking="service?.allows_online_booking"
          :whatsapp-contact="service?.whatsapp_contact"
          :slug="service?.slug"
          :service-name="service?.name"
          :business-slug="businessSlug"
        />
      </div>
    </div>
  </UiModal>
</template>

<script setup>
import { computed } from 'vue'
import UiModal from '@/Components/Ui/Modal.vue'
import ServiceGallery from './structure/ServiceGallery.vue'
import ServiceMeta from './structure/ServiceMeta.vue'
import ServiceActions from './structure/ServiceActions.vue'

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

const formatCurrency = (value) => {
  if (value === null || value === undefined) return ''
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
    minimumFractionDigits: 0,
    maximumFractionDigits: 2,
  }).format(value)
}

const formattedPrice = computed(() => formatCurrency(props.service?.price))
</script>

<style lang="scss" scoped>
.service-detail-modal {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;

  @media (min-width: 768px) {
    flex-direction: row;
  }

  &__gallery {
    flex-shrink: 0;

    @media (min-width: 768px) {
      width: 45%;
    }
  }

  &__body {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  &__header {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  &__name {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--bulma-text);
    margin: 0;
    line-height: 1.2;
  }

  &__price {
    &-value {
      font-size: 1.75rem;
      font-weight: 700;
      color: var(--bulma-text);
    }
  }

  &__description {
    font-size: 0.9375rem;
    color: var(--bulma-text);
    line-height: 1.6;
    margin: 0;
  }
}
</style>
