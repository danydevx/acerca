<template>
  <article
    class="service-card orp-card orp-card--interactive"
    :class="{ 'service-card--carousel': carousel }"
    @click="$emit('details', item)"
    @keydown.enter="$emit('details', item)"
    @keydown.space.prevent="$emit('details', item)"
    tabindex="0"
    :aria-label="`Ver detalles de ${item.name}`"
    role="button"
  >
    <div class="service-card__media orp-card__media">
      <img
        v-if="showImage && item.image"
        :src="item.image"
        :alt="item.name"
        class="service-card__image"
        loading="lazy"
      />
      <div v-else class="service-card__image-placeholder">
        <i class="bi bi-briefcase"></i>
      </div>
      <div v-if="item.duration_minutes" class="service-card__duration orp-badge orp-badge--secondary">
        <i class="bi bi-clock"></i>
        {{ item.duration_minutes }} min
      </div>
    </div>

    <div class="service-card__body orp-card__body">
      <h3 class="service-card__title">{{ item.name }}</h3>
      <p v-if="showDescription && item.description" class="service-card__desc">
        {{ truncateText(item.description, 48) }}
      </p>
    </div>

    <footer class="service-card__footer orp-card__footer">
      <div v-if="showPrice && item.price" class="service-card__price orp-price">
        <span class="orp-price__value">{{ formatCurrency(item.price) }}</span>
      </div>
      <div class="service-card__action">
        <i class="bi bi-chevron-right"></i>
      </div>
    </footer>
  </article>
</template>

<script setup>
import { usePriceFormatter } from '@/Composables/usePriceFormatter'

const props = defineProps({
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
  carousel: {
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

const truncateText = (text, length) => {
  if (!text || text.length <= length) return text
  return text.substring(0, length) + '...'
}
</script>

<style lang="less">
.service-card {
  &__media {
    position: relative;
    width: 100%;
    aspect-ratio: 4 / 3;
    overflow: hidden;
  }

  &__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--orp-duration-fast);
  }

  &__image-placeholder {
    width: 100%;
    height: 100%;
    background: var(--orp-surface-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--orp-muted-foreground);
    font-size: 2.5rem;
  }

  &__duration {
    position: absolute;
    top: var(--orp-space-2);
    right: var(--orp-space-2);
    font-size: 0.7rem;
    padding: 2px 6px;
    opacity: 0.9;
  }

  &__body {
    padding: var(--orp-space-3) var(--orp-space-3) var(--orp-space-2);
  }

  &__title {
    font-size: var(--orp-font-size-base);
    font-weight: 600;
    margin: 0 0 var(--orp-space-1);
    color: var(--orp-surface-foreground);
    line-height: 1.3;
  }

  &__desc {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: var(--orp-space-2) var(--orp-space-3) var(--orp-space-3);
    border-top: none;
  }

  &__price {
    .orp-price__value {
      font-size: var(--orp-font-size-lg);
      font-weight: 700;
      color: var(--orp-surface-foreground);
    }
  }

  &__action {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: var(--orp-radius-full);
    background: var(--orp-surface-muted);
    color: var(--orp-muted-foreground);
    transition: background var(--orp-duration-fast), color var(--orp-duration-fast);
  }

  &--carousel {
    flex: 0 0 clamp(240px, 65vw, 300px);
    scroll-snap-align: start;
    margin-right: var(--orp-space-3);

    &:last-child {
      margin-right: 0;
    }
  }

  &--interactive {
    cursor: pointer;

    &:active {
      .service-card__image {
        transform: scale(0.98);
      }
      .service-card__action {
        background: var(--orp-border);
        color: var(--orp-surface-foreground);
      }
    }

    &:focus-visible {
      outline: 2px solid var(--orp-ring);
      outline-offset: 2px;
    }
  }
}
</style>
