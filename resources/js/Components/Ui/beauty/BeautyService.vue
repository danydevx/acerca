<template>
  <article
    class="beauty-service"
    :class="{ 'beauty-service--selected': selected }"
    role="button"
    tabindex="0"
    @click="$emit('select', service)"
  >
    <div class="beauty-service__image">
      <img v-if="service.image" :src="service.image" :alt="service.name">
      <div v-else class="beauty-service__placeholder">
        <i class="bi bi-stars"></i>
      </div>
      <div v-if="service.badge" class="beauty-service__badge">{{ service.badge }}</div>
    </div>

    <div class="beauty-service__content">
      <h4 class="beauty-service__name">{{ service.name }}</h4>
      <p v-if="service.description" class="beauty-service__description">
        {{ truncateText(service.description, 50) }}
      </p>
      <div class="beauty-service__meta">
        <span v-if="service.duration" class="beauty-service__duration">
          <i class="bi bi-clock"></i>
          {{ service.duration }} min
        </span>
      </div>
      <div class="beauty-service__footer">
        <span v-if="showPrice && service.price" class="beauty-service__price">
          {{ formatPrice(service.price) }}
        </span>
        <button
          class="beauty-service__btn"
          :class="{ 'beauty-service__btn--selected': selected }"
          type="button"
          @click.stop="selected ? $emit('deselect', service) : $emit('select', service)"
        >
          <i :class="selected ? 'bi bi-check' : 'bi bi-plus'"></i>
        </button>
      </div>
    </div>
  </article>
</template>

<script setup>
defineProps({
  service: {
    type: Object,
    required: true,
    default: () => ({ name: '', price: 0, duration: null, description: '', image: '', badge: '' }),
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

defineEmits(['select', 'deselect'])

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
.beauty-service {
  display: flex;
  flex-direction: column;
  background: var(--bulma-scheme-main);
  border: 2px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  cursor: pointer;
  transition: all 0.2s;

  &:hover {
    border-color: var(--bulma-primary);
    transform: translateY(-4px);
    box-shadow: 0 8px 24px oklch(0 0 0 / 0.1);
  }

  &--selected {
    border-color: var(--bulma-primary);
    background: color-mix(in oklch, var(--bulma-primary) 5%, var(--bulma-scheme-main));
  }

  &__image {
    position: relative;
    aspect-ratio: 4 / 3;
    background: var(--bulma-scheme-main-bis);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;

    i {
      font-size: 3rem;
      color: var(--bulma-text-weak);
    }
  }

  &__badge {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    padding: 0.25rem 0.5rem;
    background: var(--bulma-primary);
    color: var(--bulma-primary-invert);
    font-size: 0.6875rem;
    font-weight: 600;
    border-radius: var(--bulma-radius-small);
  }

  &__content {
    padding: 0.875rem;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
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
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  &__meta {
    margin-top: 0.25rem;
  }

  &__duration {
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
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 0.5rem;
  }

  &__price {
    font-size: 1rem;
    font-weight: 700;
    color: var(--bulma-primary);
  }

  &__btn {
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    background: var(--bulma-primary);
    color: var(--bulma-primary-invert);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;

    &:hover {
      transform: scale(1.1);
    }

    &--selected {
      background: var(--bulma-success);
    }
  }
}
</style>
