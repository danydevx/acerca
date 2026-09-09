<template>
  <article class="store-card" :class="{ 'store-card--out': !item.in_stock }">
    <div class="store-card__media">
      <img :src="item.image || item.media" :alt="item.name" v-if="item.image || item.media">
      <div v-else class="store-card__placeholder">
        <i class="bi bi-box"></i>
      </div>

      <div class="store-card__badges" v-if="item.badges?.length || item.discount">
        <span v-if="item.discount" class="store-card__badge store-card__badge--sale">
          -{{ item.discount }}%
        </span>
        <span v-for="badge in item.badges" :key="badge" class="store-card__badge">
          {{ badge }}
        </span>
      </div>

      <div class="store-card__stock" v-if="!item.in_stock">
        Agotado
      </div>
    </div>

    <div class="store-card__content">
      <span class="store-card__brand" v-if="item.brand">{{ item.brand }}</span>
      <h4 class="store-card__name">{{ item.name }}</h4>

      <div class="store-card__variants" v-if="item.variants?.length">
        <span v-for="variant in item.variants.slice(0, 3)" :key="variant" class="store-card__variant">
          {{ variant }}
        </span>
        <span v-if="item.variants.length > 3" class="store-card__variant store-card__variant--more">
          +{{ item.variants.length - 3 }}
        </span>
      </div>

      <div class="store-card__footer">
        <div class="store-card__price">
          <span class="store-card__price-value">{{ formatPrice(item.price) }}</span>
          <span v-if="item.original_price" class="store-card__price-original">
            {{ formatPrice(item.original_price) }}
          </span>
        </div>

        <button
          class="store-card__cart-btn"
          type="button"
          :disabled="!item.in_stock"
          @click.stop="$emit('add', item)"
        >
          <i class="bi" :class="item.in_stock ? 'bi-bag-plus' : 'bi-x-lg'"></i>
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

defineEmits(['add', 'select'])

const formatPrice = (value) => {
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
  }).format(value)
}
</script>

<style lang="scss" scoped>
.store-card {
  --store-primary: #18181b;
  --store-accent: #6366f1;
  --store-sale: #dc2626;
  --store-bg: #ffffff;
  --store-text: #18181b;
  --store-muted: #71717a;

  background: var(--store-bg);
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 1px 3px oklch(0 0 0 / 0.06);
  transition: all 0.25s ease;
  height: 100%;
  display: flex;
  flex-direction: column;

  &:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px oklch(0 0 0 / 0.12);

    .store-card__media img {
      transform: scale(1.05);
    }

    .store-card__cart-btn {
      background: var(--store-accent);
      color: white;
      border-color: var(--store-accent);
    }
  }

  &--out {
    opacity: 0.7;

    .store-card__media::after {
      content: '';
      position: absolute;
      inset: 0;
      background: oklch(0 0 0 / 0.3);
    }
  }

  &__media {
    position: relative;
    aspect-ratio: 1 / 1;
    background: #f4f4f5;
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease;
    }
  }

  &__placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #d4d4d8;
    font-size: 3rem;
  }

  &__badges {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  &__badge {
    padding: 0.25rem 0.5rem;
    font-size: 0.625rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: 4px;
    background: var(--store-primary);
    color: white;

    &--sale {
      background: var(--store-sale);
    }
  }

  &__stock {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 0.5rem 1rem;
    background: white;
    color: var(--store-text);
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-radius: 4px;
    box-shadow: 0 4px 12px oklch(0 0 0 / 0.15);
  }

  &__content {
    padding: 1rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
  }

  &__brand {
    font-size: 0.625rem;
    font-weight: 600;
    color: var(--store-muted);
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  &__name {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--store-text);
    margin: 0;
    line-height: 1.4;
  }

  &__variants {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
    margin-top: 0.25rem;
  }

  &__variant {
    padding: 0.125rem 0.375rem;
    background: #f4f4f5;
    color: var(--store-muted);
    font-size: 0.625rem;
    font-weight: 500;
    border-radius: 3px;

    &--more {
      background: var(--store-accent);
      color: white;
    }
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 0.75rem;
  }

  &__price {
    display: flex;
    align-items: baseline;
    gap: 0.375rem;
  }

  &__price-value {
    font-size: 1.125rem;
    font-weight: 800;
    color: var(--store-text);
  }

  &__price-original {
    font-size: 0.8125rem;
    color: var(--store-muted);
    text-decoration: line-through;
  }

  &__cart-btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1.5px solid var(--store-border, #e4e4e7);
    border-radius: 8px;
    background: transparent;
    color: var(--store-text);
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.2s;

    &:disabled {
      cursor: not-allowed;
      opacity: 0.5;
    }

    &:not(:disabled):hover {
      transform: scale(1.05);
    }
  }
}
</style>
