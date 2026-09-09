<template>
  <div class="booking-service-info">
    <div class="booking-service-info__header">
      <h3 class="booking-service-info__title">{{ service.title }}</h3>
      <span v-if="service.provider" class="booking-service-info__provider">
        <i class="bi bi-person"></i>
        {{ service.provider }}
      </span>
    </div>

    <p v-if="service.description" class="booking-service-info__description">
      {{ service.description }}
    </p>

    <div v-if="meta.length" class="booking-service-info__meta">
      <div
        v-for="(item, index) in meta"
        :key="index"
        class="booking-service-info__meta-item"
      >
        <i :class="item.icon"></i>
        <span>{{ item.label }}</span>
      </div>
    </div>

    <div v-if="service.price" class="booking-service-info__price">
      <span class="booking-service-info__price-label">Precio</span>
      <span class="booking-service-info__price-value">{{ service.price }}</span>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  service: {
    type: Object,
    required: true,
  },
})

const meta = computed(() => {
  const items = []

  if (props.service.duration) {
    items.push({
      icon: 'bi bi-clock',
      label: `${props.service.duration} min`,
    })
  }

  if (props.service.locationType === 'online') {
    items.push({
      icon: 'bi bi-camera-video',
      label: 'Videollamada',
    })
  } else if (props.service.locationType === 'phone') {
    items.push({
      icon: 'bi bi-telephone',
      label: 'Llamada telefónica',
    })
  } else if (props.service.locationType === 'in_person') {
    items.push({
      icon: 'bi bi-geo-alt',
      label: props.service.location || 'Presencial',
    })
  }

  if (props.service.guests) {
    items.push({
      icon: 'bi bi-people',
      label: `${props.service.guests} persona${props.service.guests > 1 ? 's' : ''}`,
    })
  }

  return items
})
</script>

<style lang="scss" scoped>
.booking-service-info {
  display: flex;
  flex-direction: column;
  gap: 1rem;

  &__header {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  &__title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__provider {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.875rem;
    color: var(--bulma-text-weak);

    i {
      font-size: 0.875rem;
    }
  }

  &__description {
    font-size: 0.875rem;
    color: var(--bulma-text);
    line-height: 1.5;
    margin: 0;
  }

  &__meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding-top: 0.5rem;
    border-top: 1px solid var(--bulma-border);
  }

  &__meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8125rem;
    color: var(--bulma-text);

    i {
      width: 1.25rem;
      color: var(--bulma-text-weak);
      text-align: center;
    }
  }

  &__price {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 0.75rem;
    margin-top: auto;
  }

  &__price-label {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
  }

  &__price-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--bulma-link);
  }
}
</style>
