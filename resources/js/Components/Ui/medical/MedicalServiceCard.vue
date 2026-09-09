<template>
  <article class="medical-card" :class="{ 'medical-card--urgent': item.urgent }">
    <div class="medical-card__header">
      <div class="medical-card__icon">
        <i :class="item.icon || 'bi bi-heart-pulse'"></i>
      </div>
      <div class="medical-card__badges" v-if="item.badges?.length">
        <span v-for="badge in item.badges" :key="badge" class="medical-card__badge">{{ badge }}</span>
      </div>
    </div>

    <div class="medical-card__content">
      <h4 class="medical-card__name">{{ item.name }}</h4>

      <p v-if="item.description" class="medical-card__description">
        {{ item.description }}
      </p>

      <div class="medical-card__meta" v-if="item.duration || item.location">
        <span v-if="item.duration" class="medical-card__meta-item">
          <i class="bi bi-clock"></i>
          {{ item.duration }}
        </span>
        <span v-if="item.location" class="medical-card__meta-item">
          <i class="bi bi-geo-alt"></i>
          {{ item.location }}
        </span>
      </div>

      <div class="medical-card__includes" v-if="item.includes?.length">
        <span class="medical-card__includes-title">Incluye:</span>
        <span v-for="inc in item.includes" :key="inc" class="medical-card__include">
          <i class="bi bi-check"></i>
          {{ inc }}
        </span>
      </div>
    </div>

    <div class="medical-card__footer">
      <div class="medical-card__price-block">
        <span v-if="item.price_from" class="medical-card__price-label">Desde</span>
        <span class="medical-card__price">{{ formatPrice(item.price || item.price_from) }}</span>
      </div>

      <button
        class="medical-card__book-btn"
        type="button"
        @click.stop="$emit('book', item)"
      >
        <i class="bi bi-calendar-plus"></i>
        Agendar
      </button>
    </div>

    <div class="medical-card__cross">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path d="M12 5v14M5 12h14"/>
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

defineEmits(['book', 'select'])

const formatPrice = (value) => {
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
  }).format(value)
}
</script>

<style lang="scss" scoped>
.medical-card {
  --med-primary: #2563eb;
  --med-secondary: #3b82f6;
  --med-accent: #06b6d4;
  --med-bg: #f8fafc;
  --med-text: #1e293b;
  --med-muted: #64748b;
  --med-success: #10b981;

  position: relative;
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 1px 3px oklch(0 0 0 / 0.05), 0 1px 2px oklch(0 0 0 / 0.1);
  transition: all 0.25s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
  border: 1px solid oklch(var(--med-primary) 8%);

  &:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px oklch(0 0 0 / 0.1);
    border-color: oklch(var(--med-primary) 20%);

    .medical-card__book-btn {
      background: var(--med-primary);
      color: white;
    }

    .medical-card__cross {
      opacity: 0.05;
    }
  }

  &--urgent {
    border-color: #ef4444;
    border-width: 2px;

    .medical-card__book-btn {
      background: #ef4444;
      color: white;
    }
  }

  &__header {
    padding: 1rem 1rem 0;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
  }

  &__icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, oklch(var(--med-primary) 10%) 0%, oklch(var(--med-accent) 10%) 100%);
    color: var(--med-primary);
    font-size: 1.25rem;
    border-radius: 10px;
  }

  &__badges {
    display: flex;
    gap: 0.25rem;
    flex-wrap: wrap;
  }

  &__badge {
    padding: 0.125rem 0.5rem;
    background: oklch(var(--med-success) 15%);
    color: var(--med-success);
    font-size: 0.625rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: 3px;
  }

  &__content {
    padding: 0.75rem 1rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  &__name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--med-text);
    margin: 0;
    line-height: 1.3;
  }

  &__description {
    font-size: 0.8125rem;
    color: var(--med-muted);
    margin: 0;
    line-height: 1.5;
  }

  &__meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
  }

  &__meta-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--med-muted);

    i {
      color: var(--med-secondary);
    }
  }

  &__includes {
    display: flex;
    flex-wrap: wrap;
    gap: 0.375rem;
    margin-top: 0.25rem;
  }

  &__includes-title {
    font-size: 0.6875rem;
    font-weight: 600;
    color: var(--med-text);
    width: 100%;
  }

  &__include {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.6875rem;
    color: var(--med-muted);

    i {
      color: var(--med-success);
      font-size: 0.75rem;
    }
  }

  &__footer {
    padding: 1rem;
    background: oklch(var(--med-primary) 3%);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
  }

  &__price-block {
    display: flex;
    flex-direction: column;
  }

  &__price-label {
    font-size: 0.625rem;
    color: var(--med-muted);
    text-transform: uppercase;
  }

  &__price {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--med-primary);
  }

  &__book-btn {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    background: transparent;
    border: 1.5px solid var(--med-primary);
    color: var(--med-primary);
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;

    i {
      font-size: 0.875rem;
    }
  }

  &__cross {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 200px;
    height: 200px;
    color: var(--med-primary);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
  }
}
</style>
