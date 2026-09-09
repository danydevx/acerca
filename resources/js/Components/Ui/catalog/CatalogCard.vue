<template>
  <div class="catalog-card" :class="[`catalog-card--${variant}`, { 'catalog-card--horizontal': horizontal }]">
    <div v-if="$slots.media || src" class="catalog-card__media">
      <slot name="media">
        <img v-if="src" :src="src" :alt="title">
        <div v-else class="catalog-card__placeholder"><i class="bi bi-image"></i></div>
      </slot>
      <CatalogBadge
        v-if="badge"
        :badge="badge"
        :type="badgeType"
        class="catalog-card__badge"
      />
    </div>
    <div class="catalog-card__content">
      <div v-if="eyebrow" class="catalog-card__eyebrow">{{ eyebrow }}</div>
      <h3 v-if="title" class="catalog-card__title">{{ title }}</h3>
      <p v-if="description" class="catalog-card__description">{{ description }}</p>
      <div v-if="$slots.meta || meta.length" class="catalog-card__meta">
        <slot name="meta">{{ meta }}</slot>
      </div>
      <div v-if="$slots.value || value" class="catalog-card__value">
        <slot name="value">
          <CatalogPricing
            :value="value"
            :original-value="originalValue"
            :discount="discount"
            :unit="unit"
          />
        </slot>
      </div>
      <div v-if="$slots.actions || showActions" class="catalog-card__actions">
        <slot name="actions">
          <button v-if="showActions" class="button is-small" :class="primaryAction ? 'is-primary' : ''">{{ primaryAction || 'Details' }}</button>
          <button v-if="showActions && secondaryAction" class="button is-small is-outlined">{{ secondaryAction }}</button>
        </slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import CatalogBadge from './structure/CatalogBadge.vue'
import CatalogPricing from './structure/CatalogPricing.vue'

defineProps({
  variant: { type: String, default: 'default' },
  src: { type: String, default: '' },
  eyebrow: { type: String, default: '' },
  title: { type: String, default: '' },
  description: { type: String, default: '' },
  meta: { type: Array, default: () => [] },
  value: { type: [String, Number], default: '' },
  originalValue: { type: [String, Number], default: '' },
  discount: { type: Number, default: 0 },
  unit: { type: String, default: '' },
  badge: { type: String, default: '' },
  badgeType: { type: String, default: 'primary' },
  horizontal: { type: Boolean, default: false },
  showActions: { type: Boolean, default: false },
  primaryAction: { type: String, default: '' },
  secondaryAction: { type: String, default: '' },
})
</script>

<style lang="scss" scoped>
.catalog-card {
  display: flex;
  flex-direction: column;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  transition: box-shadow 150ms;

  &:hover {
    box-shadow: 0 4px 12px oklch(0 0 0 / 0.1);
  }

  &--horizontal {
    flex-direction: row;

    .catalog-card__media {
      width: 200px;
      aspect-ratio: 4 / 3;
    }

    .catalog-card__content {
      flex: 1;
      padding: 1rem;
    }
  }

  &__media {
    position: relative;
    aspect-ratio: 4 / 3;
    background: var(--bulma-scheme-main-bis);
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bulma-text-weak);
    font-size: 2rem;
  }

  &__badge {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
  }

  &__content {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  &__eyebrow {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--bulma-text-weak);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  &__title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
    line-height: 1.3;
  }

  &__description {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  &__meta {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
  }

  &__value {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
    margin-top: auto;
  }

  &__actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.5rem;
  }
}
</style>
