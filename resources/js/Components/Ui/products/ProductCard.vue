<template>
  <article
    class="product-card"
    :class="{
      'product-card--carousel': carousel,
      'product-card--horizontal': horizontal,
      'product-card--minimal': minimal,
    }"
    tabindex="0"
    role="button"
    :aria-label="`Ver detalles de ${item?.name}`"
    @click="$emit('details', item)"
    @keydown.enter="$emit('details', item)"
    @keydown.space.prevent="$emit('details', item)"
  >
    <div v-if="showImage && (item?.image || src)" class="product-card__media">
      <img
        v-if="src || item?.image"
        :src="src || item.image"
        :alt="item?.name"
        loading="lazy"
      >
      <ProductBadges
        v-if="showBadges && !minimal"
        :discount-percent="discountPercent"
        :show-stock="showStock"
        :quantity="item?.quantity"
        class="product-card__badges"
      />
    </div>
    <div v-else-if="showImage && !minimal" class="product-card__placeholder">
      <i class="bi bi-image"></i>
    </div>

    <div class="product-card__content">
      <h3 class="product-card__title">{{ item?.name }}</h3>

      <p
        v-if="showDescription && item?.description && !minimal"
        class="product-card__description"
      >
        {{ truncateText(item.description, 80) }}
      </p>

      <ProductPrice
        v-if="showPrice && (item?.price || value)"
        :price="item?.price || value"
        :compare-at-price="item?.compare_at_price"
        :show-compare-price="showComparePrice"
        class="product-card__price"
      />

      <div v-if="showCta && !minimal" class="product-card__cta">
        <CtaArrow v-if="ctaVariant === 'arrow'" :href="ctaHref" :size="ctaSize" @click="$emit('details', item)" />
        <CtaButton v-else-if="ctaVariant === 'button'" :label="ctaLabel" :href="ctaHref" :size="ctaSize" :variant="ctaVariantBtn" @click="$emit('details', item)" />
        <CtaIcon v-else :icon="ctaIcon" :label="ctaLabel" :href="ctaHref" :size="ctaSize" @click="$emit('details', item)" />
      </div>
    </div>
  </article>
</template>

<script setup>
import { computed } from 'vue'
import CtaArrow from '@/Components/Ui/Cta/CtaArrow.vue'
import CtaButton from '@/Components/Ui/Cta/CtaButton.vue'
import CtaIcon from '@/Components/Ui/Cta/CtaIcon.vue'
import ProductBadges from './structure/ProductBadges.vue'
import ProductPrice from './structure/ProductPrice.vue'

const props = defineProps({
  item: {
    type: Object,
    default: () => ({ name: '', price: 0, compare_at_price: null, image: '', description: '', quantity: null }),
  },
  src: { type: String, default: '' },
  value: { type: [String, Number], default: '' },
  showImage: { type: Boolean, default: true },
  showPrice: { type: Boolean, default: true },
  showComparePrice: { type: Boolean, default: true },
  showDescription: { type: Boolean, default: false },
  showStock: { type: Boolean, default: false },
  showBadges: { type: Boolean, default: true },
  carousel: { type: Boolean, default: false },
  horizontal: { type: Boolean, default: false },
  minimal: { type: Boolean, default: false },
  ctaVariant: { type: String, default: 'button', validator: (v) => ['arrow', 'button', 'icon'].includes(v) },
  ctaLabel: { type: String, default: 'Ver detalles' },
  ctaHref: { type: String, default: '#' },
  ctaIcon: { type: String, default: 'bi bi-arrow-right' },
  ctaSize: { type: String, default: 'sm' },
  ctaVariantBtn: { type: String, default: 'primary' },
  showCta: { type: Boolean, default: true },
})

defineEmits(['details'])

const discountPercent = computed(() => {
  if (!props.item?.compare_at_price || !props.item?.price) return 0
  return Math.round((1 - props.item.price / props.item.compare_at_price) * 100)
})

const truncateText = (text, length) => {
  if (!text || text.length <= length) return text
  return text.substring(0, length) + '...'
}
</script>

<style lang="scss" scoped>
.product-card {
  display: flex;
  flex-direction: column;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  transition: transform 0.15s, box-shadow 0.15s;
  height: 100%;
  cursor: pointer;

  &:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px oklch(0 0 0 / 0.1);

    .product-card__media img {
      transform: scale(1.05);
    }
  }

  &:active {
    transform: scale(0.98);
  }

  &:focus {
    outline: none;
    box-shadow: 0 0 0 3px color-mix(in oklch, var(--bulma-link) 30%, transparent);
  }

  &--carousel {
    flex: 0 0 clamp(200px, 50vw, 280px);
    scroll-snap-align: start;
    margin-right: 1rem;

    &:last-child {
      margin-right: 0;
    }
  }

  &--horizontal {
    flex-direction: row;

    .product-card__media {
      width: 140px;
      aspect-ratio: 1;
      flex-shrink: 0;
    }

    .product-card__content {
      flex: 1;
      padding: 0.875rem;
    }
  }

  &--minimal {
    flex-direction: row;
    border-radius: var(--bulma-radius);
    border: none;
    background: transparent;

    &:hover {
      transform: none;
      box-shadow: none;
      background: var(--bulma-scheme-main-bis);
    }

    &:active {
      transform: none;
    }

    .product-card__media {
      width: 48px;
      height: 48px;
      border-radius: var(--bulma-radius);
      aspect-ratio: 1;
      flex-shrink: 0;
    }

    .product-card__content {
      flex: 1;
      padding: 0.5rem 0.75rem;
      gap: 0.25rem;
    }

    .product-card__title {
      font-size: 0.875rem;
    }
  }

  &__media {
    position: relative;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    background: var(--bulma-scheme-main-bis);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.15s;
    }
  }

  &__placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    aspect-ratio: 4 / 3;
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text-weak);

    i {
      font-size: 2rem;
    }
  }

  &__badges {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
  }

  &__content {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    flex: 1;
  }

  &__title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
    line-height: 1.3;
  }

  &__description {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    margin: 0;
    line-height: 1.4;
  }

  &__price {
    display: flex;
    align-items: baseline;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: auto;
  }

  &__cta {
    display: flex;
    align-items: center;
    padding: 0 1rem 1rem;
  }
}
</style>
