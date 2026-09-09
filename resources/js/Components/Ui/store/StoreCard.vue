<template>
  <article
    class="store-card"
    :class="{
      'store-card--sale': item.discount,
      'store-card--out-of-stock': !item.in_stock,
      'store-card--featured': item.featured
    }"
    role="button"
    tabindex="0"
    @click="$emit('click', item)"
  >
    <div class="store-card__media">
      <img v-if="item.image" :src="item.image" :alt="item.name" loading="lazy">
      <div v-else class="store-card__placeholder">
        <i class="bi bi-bag"></i>
      </div>

      <div v-if="item.discount" class="store-card__discount">-{{ item.discount }}%</div>
      <div v-if="item.featured" class="store-card__badge store-card__badge--featured">
        <i class="bi bi-star-fill"></i>Destacado
      </div>
      <div v-if="!item.in_stock" class="store-card__overlay">
        <span>Agotado</span>
      </div>
    </div>

    <div class="store-card__content">
      <p v-if="item.brand" class="store-card__brand">{{ item.brand }}</p>
      <h4 class="store-card__name">{{ item.name }}</h4>

      <div v-if="item.variants?.length" class="store-card__variants">
        <span v-for="v in item.variants.slice(0, 3)" :key="v" class="store-card__variant">
          {{ v }}
        </span>
        <span v-if="item.variants.length > 3" class="store-card__variant store-card__variant--more">
          +{{ item.variants.length - 3 }}
        </span>
      </div>

      <div class="store-card__footer">
        <div class="store-card__price-group">
          <span v-if="showPrice" class="store-card__price">
            {{ formatPrice(item.price) }}
          </span>
          <span v-if="showPrice && item.original_price" class="store-card__original-price">
            {{ formatPrice(item.original_price) }}
          </span>
        </div>

        <button
          v-if="showAddToCart && item.in_stock"
          class="store-card__cart"
          type="button"
          @click.stop="$emit('addToCart', item)"
        >
          <i class="bi bi-cart-plus"></i>
        </button>
      </div>
    </div>
  </article>
</template>

<script setup>
defineProps({
  item: {
    type: Object,
    required: true,
    default: () => ({
      name: '',
      price: 0,
      original_price: null,
      image: '',
      brand: '',
      variants: [],
      discount: null,
      featured: false,
      in_stock: true,
    }),
  },
  showPrice: {
    type: Boolean,
    default: true,
  },
  showAddToCart: {
    type: Boolean,
    default: true,
  },
})

defineEmits(['click', 'addToCart'])

const formatPrice = (value) => {
  if (value === null || value === undefined) return ''
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
  }).format(value)
}
</script>

<style lang="scss" scoped>
.store-card {
  display: flex;
  flex-direction: column;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  cursor: pointer;
  transition: all 0.2s;
  height: 100%;

  &:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px oklch(0 0 0 / 0.12);

    .store-card__media img {
      transform: scale(1.05);
    }
  }

  &--sale {
    .store-card__price {
      color: var(--bulma-danger);
    }
  }

  &--out-of-stock {
    opacity: 0.7;
    pointer-events: none;
  }

  &--featured {
    border-color: var(--bulma-warning);
  }

  &__media {
    position: relative;
    aspect-ratio: 1;
    overflow: hidden;
    background: var(--bulma-scheme-main-bis);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s;
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

  &__discount {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    padding: 0.25rem 0.5rem;
    background: var(--bulma-danger);
    color: white;
    font-size: 0.6875rem;
    font-weight: 700;
    border-radius: var(--bulma-radius-small);
  }

  &__badge {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    font-size: 0.6875rem;
    font-weight: 600;
    border-radius: var(--bulma-radius-small);

    &--featured {
      background: var(--bulma-warning);
      color: white;
    }
  }

  &__overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;

    span {
      padding: 0.5rem 1rem;
      background: var(--bulma-scheme-main);
      color: var(--bulma-text);
      font-weight: 600;
      border-radius: var(--bulma-radius);
    }
  }

  &__content {
    padding: 0.875rem;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    flex: 1;
  }

  &__brand {
    font-size: 0.6875rem;
    font-weight: 600;
    color: var(--bulma-text-weak);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin: 0;
  }

  &__name {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
    line-height: 1.3;
  }

  &__variants {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
    margin-top: 0.25rem;
  }

  &__variant {
    font-size: 0.625rem;
    padding: 0.125rem 0.375rem;
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text-weak);
    border-radius: var(--bulma-radius-small);

    &--more {
      background: var(--bulma-scheme-main-ter);
    }
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 0.5rem;
  }

  &__price-group {
    display: flex;
    align-items: baseline;
    gap: 0.5rem;
  }

  &__price {
    font-size: 1rem;
    font-weight: 700;
    color: var(--bulma-text);
  }

  &__original-price {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    text-decoration: line-through;
  }

  &__cart {
    width: 2.25rem;
    height: 2.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.2s;

    &:hover {
      background: var(--bulma-link-hover);
      transform: scale(1.1);
    }

    i {
      font-size: 1.125rem;
    }
  }
}
</style>
