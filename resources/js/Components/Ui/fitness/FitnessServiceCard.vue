<template>
  <article class="fitness-card" :class="{ 'fitness-card--featured': item.featured }">
    <div class="fitness-card__glow"></div>

    <div class="fitness-card__header">
      <div class="fitness-card__icon">
        <i :class="item.icon || 'bi bi-lightning-charge'"></i>
      </div>
      <span class="fitness-card__tag" v-if="item.tag">{{ item.tag }}</span>
    </div>

    <div class="fitness-card__content">
      <h4 class="fitness-card__name">{{ item.name }}</h4>

      <p v-if="item.description" class="fitness-card__description">
        {{ item.description }}
      </p>

      <div class="fitness-card__specs" v-if="item.specs?.length">
        <span v-for="spec in item.specs" :key="spec.label" class="fitness-card__spec">
          <i :class="spec.icon"></i>
          {{ spec.label }}
        </span>
      </div>
    </div>

    <div class="fitness-card__footer">
      <div class="fitness-card__price-block">
        <span class="fitness-card__price">{{ formatPrice(item.price) }}</span>
        <span class="fitness-card__period" v-if="item.period">/{{ item.period }}</span>
      </div>

      <button
        class="fitness-card__cta"
        type="button"
        @click.stop="$emit('action', item)"
      >
        <i class="bi" :class="item.action_icon || 'bi-arrow-right'"></i>
      </button>
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

defineEmits(['action', 'select'])

const formatPrice = (value) => {
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
  }).format(value)
}
</script>

<style lang="scss" scoped>
.fitness-card {
  --fit-primary: #f97316;
  --fit-secondary: #fb923c;
  --fit-dark: #1c1917;
  --fit-bg: #fffbeb;
  --fit-text: #1c1917;
  --fit-muted: #78716c;

  position: relative;
  background: var(--fit-bg);
  border-radius: 16px;
  padding: 1.5rem;
  overflow: hidden;
  transition: all 0.3s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
  border: 2px solid oklch(var(--fit-primary) 10%);

  &:hover {
    transform: translateY(-4px) scale(1.01);
    box-shadow: 0 20px 40px oklch(0 0 0 / 0.15);
    border-color: var(--fit-primary);

    .fitness-card__glow {
      opacity: 0.15;
    }

    .fitness-card__cta {
      background: var(--fit-primary);
      color: white;
      transform: scale(1.1);
    }
  }

  &--featured {
    background: linear-gradient(135deg, var(--fit-dark) 0%, #292524 100%);
    border-color: var(--fit-primary);

    .fitness-card__name,
    .fitness-card__price {
      color: white;
    }

    .fitness-card__description,
    .fitness-card__period {
      color: oklch(1 0 0 / 0.6);
    }

    .fitness-card__tag {
      background: var(--fit-primary);
      color: white;
    }

    .fitness-card__icon {
      background: var(--fit-primary);
      color: white;
    }

    .fitness-card__spec {
      background: oklch(1 0 0 / 0.1);
      color: white;
    }

    .fitness-card__cta {
      background: var(--fit-primary);
      color: white;
    }
  }

  &__glow {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, var(--fit-primary) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.4s ease;
    pointer-events: none;
  }

  &__header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    position: relative;
    z-index: 1;
  }

  &__icon {
    width: 52px;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: oklch(var(--fit-primary) 15%);
    color: var(--fit-primary);
    font-size: 1.5rem;
    border-radius: 12px;
  }

  &__tag {
    padding: 0.25rem 0.75rem;
    background: var(--fit-dark);
    color: white;
    font-size: 0.625rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-radius: 20px;
  }

  &__content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    position: relative;
    z-index: 1;
  }

  &__name {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--fit-text);
    margin: 0;
    line-height: 1.2;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  &__description {
    font-size: 0.8125rem;
    color: var(--fit-muted);
    margin: 0;
    line-height: 1.5;
  }

  &__specs {
    display: flex;
    flex-wrap: wrap;
    gap: 0.375rem;
    margin-top: 0.25rem;
  }

  &__spec {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.625rem;
    background: oklch(var(--fit-primary) 10%);
    color: var(--fit-primary);
    font-size: 0.6875rem;
    font-weight: 600;
    border-radius: 4px;

    i {
      font-size: 0.75rem;
    }
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid oklch(var(--fit-primary) 15%);
    position: relative;
    z-index: 1;
  }

  &__price-block {
    display: flex;
    align-items: baseline;
    gap: 0.125rem;
  }

  &__price {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--fit-primary);
  }

  &__period {
    font-size: 0.75rem;
    color: var(--fit-muted);
    font-weight: 500;
  }

  &__cta {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 50%;
    background: var(--fit-dark);
    color: white;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.25s ease;
  }
}
</style>
