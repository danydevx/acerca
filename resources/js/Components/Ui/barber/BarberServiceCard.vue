<template>
  <article class="barber-card" :class="{ 'barber-card--selected': selected }">
    <div class="barber-card__stripe"></div>

    <div class="barber-card__header">
      <div class="barber-card__price-tag">
        <span class="barber-card__price-value">{{ formatPrice(item.price) }}</span>
        <span v-if="item.duration" class="barber-card__duration">{{ item.duration }}</span>
      </div>
    </div>

    <div class="barber-card__content">
      <div class="barber-card__icon">
        <i :class="item.icon || 'bi-scissors'"></i>
      </div>

      <h4 class="barber-card__name">{{ item.name }}</h4>

      <p v-if="item.description" class="barber-card__description">
        {{ item.description }}
      </p>

      <div class="barber-card__features" v-if="item.features?.length">
        <span v-for="feature in item.features" :key="feature" class="barber-card__feature">
          <i class="bi bi-check-circle-fill"></i>
          {{ feature }}
        </span>
      </div>
    </div>

    <div class="barber-card__footer">
      <button
        class="barber-card__book-btn"
        type="button"
        @click.stop="$emit('book', item)"
      >
        <i class="bi bi-calendar-check"></i>
        Reservar
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
  selected: {
    type: Boolean,
    default: false,
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
.barber-card {
  --barber-primary: #1a1a1a;
  --barber-accent: #c9a227;
  --barber-bg: #fafaf8;
  --barber-text: #1a1a1a;
  --barber-muted: #6b6b6b;

  position: relative;
  background: var(--barber-bg);
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 12px oklch(0 0 0 / 0.08);
  transition: all 0.25s ease;
  height: 100%;
  display: flex;
  flex-direction: column;

  &::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: repeating-linear-gradient(
      90deg,
      var(--barber-primary) 0px,
      var(--barber-primary) 8px,
      var(--barber-accent) 8px,
      var(--barber-accent) 16px
    );
  }

  &:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px oklch(0 0 0 / 0.15);

    .barber-card__book-btn {
      background: var(--barber-primary);
      color: white;
    }
  }

  &--selected {
    box-shadow: 0 0 0 3px var(--barber-accent), 0 8px 24px oklch(0 0 0 / 0.15);
  }

  &__stripe {
    height: 4px;
    background: repeating-linear-gradient(
      90deg,
      var(--barber-primary) 0px,
      var(--barber-primary) 8px,
      var(--barber-accent) 8px,
      var(--barber-accent) 16px
    );
  }

  &__header {
    padding: 1.25rem 1rem 0;
    display: flex;
    justify-content: flex-end;
  }

  &__price-tag {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.125rem;
  }

  &__price-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--barber-primary);
    line-height: 1;
  }

  &__duration {
    font-size: 0.6875rem;
    font-weight: 600;
    color: var(--barber-muted);
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  &__content {
    padding: 0.75rem 1rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  &__icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--barber-primary);
    color: var(--barber-accent);
    font-size: 1.25rem;
    border-radius: 4px;
    margin-bottom: 0.25rem;
  }

  &__name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--barber-text);
    margin: 0;
    line-height: 1.2;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  &__description {
    font-size: 0.8125rem;
    color: var(--barber-muted);
    margin: 0;
    line-height: 1.5;
  }

  &__features {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    margin-top: 0.25rem;
  }

  &__feature {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.75rem;
    color: var(--barber-text);

    i {
      color: var(--barber-accent);
      font-size: 0.875rem;
    }
  }

  &__footer {
    padding: 1rem;
    border-top: 1px solid oklch(var(--barber-primary) 10%);
  }

  &__book-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border: 2px solid var(--barber-primary);
    border-radius: 4px;
    background: transparent;
    color: var(--barber-primary);
    font-size: 0.875rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: all 0.2s;

    &:hover {
      background: var(--barber-primary);
      color: white;
    }
  }
}
</style>
