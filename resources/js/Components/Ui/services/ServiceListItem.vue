<template>
  <article
    class="service-list-item"
    :class="{ 'service-list-item--compact': compact }"
    tabindex="0"
    role="button"
    :aria-label="`Ver detalles de ${item?.name}`"
    @click="$emit('details', item)"
    @keydown.enter="$emit('details', item)"
    @keydown.space.prevent="$emit('details', item)"
  >
    <div v-if="showImage && (item?.image || src)" class="service-list-item__media">
      <img
        v-if="src || item?.image"
        :src="src || item.image"
        :alt="item?.name"
        loading="lazy"
      >
    </div>
    <div v-else-if="showImage" class="service-list-item__placeholder">
      <i class="bi bi-gear"></i>
    </div>

    <div class="service-list-item__content">
      <h3 class="service-list-item__title">{{ item?.name }}</h3>
      <div class="service-list-item__meta">
        <ServiceDuration
          v-if="item?.duration_minutes"
          :duration-minutes="item.duration_minutes"
          :inline="true"
        />
        <span v-if="item?.deposit_required" class="service-list-item__meta-item service-list-item__meta-item--warning">
          <i class="bi bi-currency-dollar"></i>
          <span>Anticipo</span>
        </span>
      </div>
    </div>

    <div class="service-list-item__right">
      <ServicePrice
        v-if="showPrice && (item?.price || value)"
        :price="item?.price || value"
        class="service-list-item__price"
      />
      <i class="bi bi-arrow-right"></i>
    </div>
  </article>
</template>

<script setup>
import ServiceDuration from './structure/ServiceDuration.vue'
import ServicePrice from './structure/ServicePrice.vue'

defineProps({
  item: {
    type: Object,
    default: () => ({ name: '', price: 0, image: '', description: '', duration_minutes: null, deposit_required: false }),
  },
  src: { type: String, default: '' },
  value: { type: [String, Number], default: '' },
  showImage: { type: Boolean, default: true },
  showPrice: { type: Boolean, default: true },
  compact: { type: Boolean, default: false },
})

defineEmits(['details'])
</script>

<style lang="scss" scoped>
.service-list-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.75rem;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius);
  cursor: pointer;
  transition: transform 0.15s, box-shadow 0.15s, background 0.15s;

  &:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 12px oklch(0 0 0 / 0.08);
    background: var(--bulma-scheme-main-bis);
  }

  &:active {
    transform: translateX(2px);
  }

  &:focus {
    outline: none;
    box-shadow: 0 0 0 3px color-mix(in oklch, var(--bulma-link) 30%, transparent);
  }

  &--compact {
    padding: 0.5rem;
    gap: 0.5rem;
    border: none;
    background: transparent;
    border-radius: var(--bulma-radius-small);

    &:hover {
      transform: none;
      background: var(--bulma-scheme-main-bis);
    }

    .service-list-item__media {
      width: 40px;
      height: 40px;
    }

    .service-list-item__title {
      font-size: 0.875rem;
    }

    .service-list-item__price {
      font-size: 0.875rem;
    }
  }

  &__media {
    width: 48px;
    height: 48px;
    border-radius: var(--bulma-radius);
    overflow: hidden;
    flex-shrink: 0;
    background: var(--bulma-scheme-main-bis);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__placeholder {
    width: 48px;
    height: 48px;
    border-radius: var(--bulma-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text-weak);
    flex-shrink: 0;

    i {
      font-size: 1.25rem;
    }
  }

  &__content {
    flex: 1;
    min-width: 0;
  }

  &__title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0 0 0.25rem 0;
    line-height: 1.3;
  }

  &__meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
  }

  &__meta-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;

    i {
      font-size: 0.75rem;
    }

    &--warning {
      color: var(--bulma-warning);
    }
  }

  &__right {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-shrink: 0;
  }

  &__price {
    font-size: 1rem;
    font-weight: 700;
    color: var(--bulma-text);
  }

  i.bi-chevron-right {
    color: var(--bulma-text-weak);
    font-size: 0.875rem;
  }
}
</style>
