<template>
  <article class="spa-card" :class="{ 'spa-card--premium': item.premium }">
    <div class="spa-card__leaf spa-card__leaf--left"></div>
    <div class="spa-card__leaf spa-card__leaf--right"></div>

    <div class="spa-card__content">
      <div class="spa-card__icon" v-if="item.icon">
        <i :class="item.icon"></i>
      </div>

      <div class="spa-card__header">
        <span class="spa-card__duration" v-if="item.duration">{{ item.duration }}</span>
        <h4 class="spa-card__name">{{ item.name }}</h4>
      </div>

      <p v-if="item.description" class="spa-card__description">
        {{ item.description }}
      </p>

      <div class="spa-card__benefits" v-if="item.benefits?.length">
        <span v-for="benefit in item.benefits" :key="benefit" class="spa-card__benefit">
          <i class="bi bi-droplet-fill"></i>
          {{ benefit }}
        </span>
      </div>

      <div class="spa-card__footer">
        <div class="spa-card__price">
          <span class="spa-card__price-value">{{ formatPrice(item.price) }}</span>
          <span class="spa-card__price-label">/ sesión</span>
        </div>

        <button
          class="spa-card__book-btn"
          type="button"
          @click.stop="$emit('book', item)"
        >
          Reservar
        </button>
      </div>
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

defineEmits(['book', 'select'])

const formatPrice = (value) => {
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
  }).format(value)
}
</script>

<style lang="scss" scoped>
.spa-card {
  --spa-primary: #5c8a6e;
  --spa-secondary: #8fbc8f;
  --spa-accent: #c4a35a;
  --spa-bg: #f8faf8;
  --spa-text: #2d3d32;
  --spa-muted: #7a8a7c;

  position: relative;
  background: var(--spa-bg);
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 2px 16px oklch(0 0 0 / 0.05);
  transition: all 0.35s ease;
  height: 100%;

  &:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px oklch(0 0 0 / 0.1);

    .spa-card__leaf {
      transform: translateY(0) rotate(0deg);
      opacity: 0.15;
    }

    .spa-card__book-btn {
      background: var(--spa-primary);
      color: white;
    }
  }

  &--premium {
    background: linear-gradient(135deg, #f8faf8 0%, #e8f0e8 100%);
    border: 1px solid oklch(var(--spa-primary) 20%);

    .spa-card__icon {
      background: linear-gradient(135deg, var(--spa-primary) 0%, var(--spa-secondary) 100%);
      color: white;
    }
  }

  &__leaf {
    position: absolute;
    width: 80px;
    height: 120px;
    background: linear-gradient(135deg, var(--spa-secondary) 0%, var(--spa-primary) 100%);
    border-radius: 50% 0 50% 0;
    opacity: 0.08;
    transition: all 0.5s ease;
    pointer-events: none;

    &--left {
      top: -20px;
      left: -20px;
      transform: translateY(10px) rotate(-30deg);
    }

    &--right {
      bottom: -30px;
      right: -20px;
      transform: translateY(-10px) rotate(150deg);
    }
  }

  &__content {
    padding: 1.5rem;
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    height: 100%;
  }

  &__icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: oklch(var(--spa-primary) 15%);
    color: var(--spa-primary);
    font-size: 1.5rem;
    border-radius: 12px;
  }

  &__header {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  &__duration {
    font-size: 0.6875rem;
    font-weight: 600;
    color: var(--spa-accent);
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  &__name {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--spa-text);
    margin: 0;
    line-height: 1.3;
  }

  &__description {
    font-size: 0.8125rem;
    color: var(--spa-muted);
    margin: 0;
    line-height: 1.6;
  }

  &__benefits {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
  }

  &__benefit {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.625rem;
    background: oklch(var(--spa-secondary) 15%);
    color: var(--spa-primary);
    font-size: 0.6875rem;
    font-weight: 500;
    border-radius: 20px;

    i {
      font-size: 0.625rem;
    }
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 1rem;
  }

  &__price {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
  }

  &__price-value {
    font-size: 1.375rem;
    font-weight: 700;
    color: var(--spa-primary);
  }

  &__price-label {
    font-size: 0.75rem;
    color: var(--spa-muted);
  }

  &__book-btn {
    padding: 0.625rem 1.5rem;
    border: none;
    border-radius: 25px;
    background: transparent;
    border: 1.5px solid var(--spa-primary);
    color: var(--spa-primary);
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
  }
}
</style>
