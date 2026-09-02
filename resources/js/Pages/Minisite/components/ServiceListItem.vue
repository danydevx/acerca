<template>
  <article
    class="service-list-item"
    @click="$emit('details', item)"
    @keydown.enter="$emit('details', item)"
    @keydown.space.prevent="$emit('details', item)"
    tabindex="0"
    :aria-label="`Ver detalles de ${item.name}`"
    role="button"
  >
    <div class="service-list-item__image">
      <img
        v-if="showImage && item.image"
        :src="item.image"
        :alt="item.name"
        loading="lazy"
      />
      <div v-else class="service-list-item__image-placeholder">
        <i class="bi bi-briefcase"></i>
      </div>
    </div>

    <div class="service-list-item__content">
      <h3 class="service-list-item__name">{{ item.name }}</h3>
      <div class="service-list-item__meta">
        <span v-if="item.duration_minutes" class="service-list-item__duration">
          <i class="bi bi-clock"></i>
          {{ item.duration_minutes }} min
        </span>
        <span v-if="item.deposit_required" class="service-list-item__deposit">
          <i class="bi bi-currency-dollar"></i>
          Anticipo
        </span>
      </div>
    </div>

    <div class="service-list-item__right">
      <div v-if="showPrice && item.price" class="service-list-item__price orp-price">
        <span class="orp-price__value">{{ formatCurrency(item.price) }}</span>
      </div>
      <div class="service-list-item__arrow">
        <i class="bi bi-chevron-right"></i>
      </div>
    </div>
  </article>
</template>

<script setup>
import { usePriceFormatter } from '@/Composables/usePriceFormatter'

defineProps({
  item: {
    type: Object,
    required: true,
  },
  showImage: {
    type: Boolean,
    default: true,
  },
  showPrice: {
    type: Boolean,
    default: true,
  },
  showDescription: {
    type: Boolean,
    default: false,
  },
})

defineEmits(['details'])

const { formatPrice } = usePriceFormatter({
  locale: 'es-MX',
  currency: '$',
  decimals: 2,
})

const formatCurrency = (value) => {
  if (value === null || value === undefined) return ''
  return formatPrice(value) || ''
}
</script>

<style lang="less">
.service-list-item {
  display: flex;
  align-items: center;
  gap: var(--orp-space-3);
  padding: var(--orp-space-3);
  background: var(--orp-surface);
  border-radius: var(--orp-radius-lg);
  cursor: pointer;
  transition: background var(--orp-duration-fast);

  &:active {
    background: var(--orp-surface-muted);
  }

  &:focus-visible {
    outline: 2px solid var(--orp-ring);
    outline-offset: 2px;
  }

  &__image {
    flex-shrink: 0;
    width: 56px;
    height: 56px;
    border-radius: var(--orp-radius-md);
    overflow: hidden;
    background: var(--orp-surface-muted);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--orp-muted-foreground);
    font-size: 1.25rem;
  }

  &__content {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 2px;
  }

  &__name {
    font-size: var(--orp-font-size-base);
    font-weight: 600;
    margin: 0;
    color: var(--orp-surface-foreground);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.3;
  }

  &__meta {
    display: flex;
    align-items: center;
    gap: var(--orp-space-3);
  }

  &__duration,
  &__deposit {
    display: flex;
    align-items: center;
    gap: 3px;
    font-size: var(--orp-font-size-xs);
    color: var(--orp-muted-foreground);
    line-height: 1;

    i {
      font-size: 0.7rem;
    }
  }

  &__deposit {
    color: var(--orp-warning);
  }

  &__right {
    display: flex;
    align-items: center;
    gap: var(--orp-space-2);
    flex-shrink: 0;
  }

  &__price {
    .orp-price__value {
      font-size: var(--orp-font-size-base);
      font-weight: 700;
      color: var(--orp-surface-foreground);
    }
  }

  &__arrow {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    color: var(--orp-muted-foreground);
    font-size: 0.875rem;
  }
}
</style>
