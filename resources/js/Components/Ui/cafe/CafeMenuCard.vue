<template>
  <article class="cafe-card">
    <div class="cafe-card__header">
      <div class="cafe-card__cup">
        <i :class="item.icon || 'bi bi-cup-hot'"></i>
      </div>
      <div class="cafe-card__info">
        <span class="cafe-card__size" v-if="item.size">{{ item.size }}</span>
        <h4 class="cafe-card__name">{{ item.name }}</h4>
      </div>
    </div>

    <p v-if="item.description" class="cafe-card__description">
      {{ item.description }}
    </p>

    <div class="cafe-card__extras" v-if="item.extras?.length">
      <span v-for="extra in item.extras" :key="extra" class="cafe-card__extra">
        {{ extra }}
      </span>
    </div>

    <div class="cafe-card__footer">
      <span class="cafe-card__price">{{ formatPrice(item.price) }}</span>

      <button
        class="cafe-card__add"
        type="button"
        @click.stop="$emit('add', item)"
      >
        <i class="bi bi-plus"></i>
      </button>
    </div>

    <div class="cafe-card__beans">
      <svg viewBox="0 0 24 24" fill="currentColor">
        <ellipse cx="12" cy="12" rx="8" ry="5" transform="rotate(-30 12 12)"/>
      </svg>
    </div>
  </article>
</template>

<script setup>
const props = defineProps({
  item: {
    type: Object,
    required: true,
  },
})

defineEmits(['add', 'select'])

const formatPrice = (value) => {
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
  }).format(value)
}
</script>

<style lang="scss" scoped>
.cafe-card {
  --cafe-primary: #92400e;
  --cafe-secondary: #b45309;
  --cafe-cream: #fef3c7;
  --cafe-bg: #fffbf5;
  --cafe-text: #1c1917;
  --cafe-muted: #78716c;

  position: relative;
  background: var(--cafe-bg);
  border-radius: 12px;
  padding: 1.25rem;
  display: flex;
  flex-direction: column;
  gap: 0.625rem;
  transition: all 0.25s ease;
  border: 1px solid oklch(var(--cafe-primary) 10%);

  &:hover {
    transform: translateX(4px);
    box-shadow: -4px 4px 16px oklch(0 0 0 / 0.08);

    .cafe-card__add {
      background: var(--cafe-primary);
      color: white;
    }

    .cafe-card__beans {
      opacity: 0.08;
      transform: rotate(15deg);
    }
  }

  &__header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  &__cup {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--cafe-cream) 0%, oklch(var(--cafe-primary) 15%) 100%);
    color: var(--cafe-primary);
    font-size: 1.25rem;
    border-radius: 8px;
    flex-shrink: 0;
  }

  &__info {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
  }

  &__size {
    font-size: 0.625rem;
    font-weight: 600;
    color: var(--cafe-muted);
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  &__name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--cafe-text);
    margin: 0;
    line-height: 1.2;
  }

  &__description {
    font-size: 0.8125rem;
    color: var(--cafe-muted);
    margin: 0;
    line-height: 1.5;
  }

  &__extras {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
  }

  &__extra {
    padding: 0.125rem 0.5rem;
    background: var(--cafe-cream);
    color: var(--cafe-secondary);
    font-size: 0.625rem;
    font-weight: 500;
    border-radius: 20px;
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 0.25rem;
  }

  &__price {
    font-size: 1.125rem;
    font-weight: 800;
    color: var(--cafe-primary);
  }

  &__add {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 50%;
    background: oklch(var(--cafe-primary) 10%);
    color: var(--cafe-primary);
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s;

    &:hover {
      transform: scale(1.1);
    }
  }

  &__beans {
    position: absolute;
    bottom: 0.5rem;
    right: 0.5rem;
    width: 24px;
    height: 24px;
    color: var(--cafe-primary);
    opacity: 0.05;
    transition: all 0.4s ease;
    pointer-events: none;
  }
}
</style>
