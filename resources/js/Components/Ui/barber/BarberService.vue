<template>
  <article
    class="barber-service"
    :class="{ 'barber-service--selected': selected }"
    role="button"
    tabindex="0"
    @click="$emit('select', service)"
    @keydown.enter="$emit('select', service)"
    @keydown.space.prevent="$emit('select', service)"
  >
    <div class="barber-service__icon">
      <i :class="service.icon || 'bi bi-scissors'"></i>
    </div>
    <div class="barber-service__content">
      <h4 class="barber-service__name">{{ service.name }}</h4>
      <p v-if="service.description" class="barber-service__description">
        {{ truncateText(service.description, 60) }}
      </p>
      <div class="barber-service__meta">
        <span v-if="service.duration" class="barber-service__duration">
          <i class="bi bi-clock"></i>
          {{ service.duration }} min
        </span>
        <span v-if="showPrice && service.price" class="barber-service__price">
          {{ formatPrice(service.price) }}
        </span>
      </div>
    </div>
    <div class="barber-service__action">
      <i class="bi" :class="selected ? 'bi-check-circle-fill' : 'bi-circle'"></i>
    </div>
  </article>
</template>

<script setup>
defineProps({
  service: {
    type: Object,
    required: true,
    default: () => ({ name: '', price: 0, duration: null, description: '', icon: '' }),
  },
  selected: {
    type: Boolean,
    default: false,
  },
  showPrice: {
    type: Boolean,
    default: true,
  },
})

defineEmits(['select'])

const formatPrice = (value) => {
  if (value === null || value === undefined) return ''
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
  }).format(value)
}

const truncateText = (text, length) => {
  if (!text || text.length <= length) return text
  return text.substring(0, length) + '...'
}
</script>

<style lang="scss" scoped>
.barber-service {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.875rem;
  background: var(--bulma-scheme-main);
  border: 2px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  cursor: pointer;
  transition: all 0.2s;

  &:hover {
    border-color: var(--bulma-link);
    background: var(--bulma-scheme-main-bis);
  }

  &--selected {
    border-color: var(--bulma-link);
    background: color-mix(in oklch, var(--bulma-link) 8%, var(--bulma-scheme-main));
  }

  &__icon {
    width: 3rem;
    height: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bulma-scheme-main-bis);
    border-radius: var(--bulma-radius);
    flex-shrink: 0;

    i {
      font-size: 1.5rem;
      color: var(--bulma-text);
    }
  }

  &__content {
    flex: 1;
    min-width: 0;
  }

  &__name {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__description {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    margin: 0.125rem 0 0;
  }

  &__meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-top: 0.25rem;
  }

  &__duration {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--bulma-text-weak);

    i {
      font-size: 0.875rem;
    }
  }

  &__price {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-success);
  }

  &__action {
    flex-shrink: 0;

    i {
      font-size: 1.5rem;
      color: var(--bulma-border);
    }

    .barber-service--selected & i {
      color: var(--bulma-link);
    }
  }
}
</style>
