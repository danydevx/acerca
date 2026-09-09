<template>
  <article
    class="treatment-card"
    :class="{ 'treatment-card--selected': selected }"
    role="button"
    tabindex="0"
    @click="$emit('select', treatment)"
  >
    <div class="treatment-card__header">
      <div class="treatment-card__icon">
        <i :class="treatment.icon || 'bi bi-heart-pulse'"></i>
      </div>
      <div v-if="selected" class="treatment-card__check">
        <i class="bi bi-check-lg"></i>
      </div>
    </div>

    <div class="treatment-card__content">
      <h4 class="treatment-card__name">{{ treatment.name }}</h4>
      <p v-if="treatment.description" class="treatment-card__description">
        {{ truncateText(treatment.description, 70) }}
      </p>

      <div class="treatment-card__meta">
        <span v-if="treatment.duration" class="treatment-card__duration">
          <i class="bi bi-clock"></i>
          {{ treatment.duration }} min
        </span>
        <span v-if="treatment.recovery" class="treatment-card__recovery">
          <i class="bi bi-bandaid"></i>
          {{ treatment.recovery }}
        </span>
      </div>
    </div>

    <div class="treatment-card__footer">
      <span v-if="showPrice && treatment.price" class="treatment-card__price">
        {{ formatPrice(treatment.price) }}
      </span>
      <span v-if="treatment.price_from" class="treatment-card__price-from">
        Desde {{ formatPrice(treatment.price_from) }}
      </span>
    </div>
  </article>
</template>

<script setup>
defineProps({
  treatment: {
    type: Object,
    required: true,
    default: () => ({
      name: '',
      price: 0,
      price_from: null,
      duration: null,
      recovery: null,
      description: '',
      icon: '',
    }),
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
.treatment-card {
  display: flex;
  flex-direction: column;
  padding: 1.25rem;
  background: var(--bulma-scheme-main);
  border: 2px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  cursor: pointer;
  transition: all 0.2s;
  height: 100%;

  &:hover {
    border-color: var(--bulma-info);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px oklch(0 0 0 / 0.1);
  }

  &--selected {
    border-color: var(--bulma-info);
    background: color-mix(in oklch, var(--bulma-info) 5%, var(--bulma-scheme-main));
  }

  &__header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 0.75rem;
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
      color: var(--bulma-info);
    }
  }

  &__check {
    width: 1.5rem;
    height: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bulma-info);
    color: white;
    border-radius: 50%;

    i {
      font-size: 0.875rem;
    }
  }

  &__content {
    flex: 1;
  }

  &__name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0 0 0.375rem;
  }

  &__description {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    margin: 0;
    line-height: 1.4;
  }

  &__meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-top: 0.75rem;
  }

  &__duration,
  &__recovery {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--bulma-text-weak);

    i {
      font-size: 0.875rem;
    }
  }

  &__footer {
    margin-top: 1rem;
    padding-top: 0.75rem;
    border-top: 1px solid var(--bulma-border);
    display: flex;
    align-items: baseline;
    gap: 0.5rem;
  }

  &__price {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--bulma-info);
  }

  &__price-from {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
  }
}
</style>
