<template>
  <div class="pricing-card" :class="[`pricing-card--${variant}`, { 'pricing-card--emphasized': emphasized, 'pricing-card--horizontal': horizontal }]">
    <div v-if="badge" class="pricing-card__badge" :class="[`pricing-card__badge--${badgeType || 'primary'}`]">{{ badge }}</div>
    <div class="pricing-card__header">
      <div v-if="eyebrow" class="pricing-card__eyebrow">{{ eyebrow }}</div>
      <h3 class="pricing-card__title">{{ title }}</h3>
      <p v-if="subtitle" class="pricing-card__subtitle">{{ subtitle }}</p>
    </div>
    <div class="pricing-card__price">
      <span v-if="price" class="pricing-card__amount">${{ price }}</span>
      <span v-if="priceLabel" class="pricing-card__price-label">{{ priceLabel }}</span>
    </div>
    <div v-if="$slots.features" class="pricing-card__features">
      <slot name="features"></slot>
    </div>
    <div v-if="$slots.actions || action" class="pricing-card__actions">
      <slot name="actions">
        <button v-if="action" class="pricing-card__btn" :class="emphasized ? 'pricing-card__btn--primary' : 'pricing-card__btn--outline'">{{ action }}</button>
      </slot>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: { type: String, required: true },
  subtitle: { type: String, default: '' },
  eyebrow: { type: String, default: '' },
  price: { type: [String, Number], default: '' },
  priceLabel: { type: String, default: '' },
  badge: { type: String, default: '' },
  badgeType: { type: String, default: 'primary' },
  emphasized: { type: Boolean, default: false },
  horizontal: { type: Boolean, default: false },
  variant: { type: String, default: 'default' },
  action: { type: String, default: '' },
})
</script>

<style lang="scss" scoped>
.pricing-card {
  position: relative;
  display: flex;
  flex-direction: column;
  padding: 1.5rem;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  text-align: center;
  transition: all 150ms;

  &--elevated {
    border: none;
    box-shadow: var(--dl-shadow-sm);
  }

  &--borderless {
    border: none;
    background: transparent;
  }

  &--gradient {
    border: none;
    background: linear-gradient(135deg, var(--bulma-primary) 0%, color-mix(in oklch, var(--bulma-primary) 70%, black) 100%);

    .pricing-card__header,
    .pricing-card__title,
    .pricing-card__subtitle,
    .pricing-card__amount,
    .pricing-card__price-label,
    .pricing-card__eyebrow {
      color: var(--bulma-primary-invert);
    }

    .pricing-card__eyebrow {
      opacity: 0.8;
    }
  }

  &--horizontal {
    flex-direction: row;
    align-items: center;
    text-align: left;
    gap: 1.5rem;

    .pricing-card__price {
      margin-left: auto;
    }
  }

  &__badge {
    position: absolute;
    top: -0.75rem;
    left: 50%;
    transform: translateX(-50%);
    padding: 0.25rem 1rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--bulma-scheme-main);
    white-space: nowrap;

    &--primary { background: var(--bulma-primary); }
    &--info { background: var(--bulma-info); }
    &--success { background: var(--bulma-success); }
    &--warning { background: var(--bulma-warning); }
    &--danger { background: var(--bulma-danger); }
  }

  &__header {
    margin-bottom: 0.5rem;
  }

  &__eyebrow {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--bulma-text-weak);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.25rem;
  }

  &__title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0 0 0.25rem;
  }

  &__subtitle {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin: 0 0 1rem;
  }

  &__price {
    display: flex;
    align-items: baseline;
    justify-content: center;
    gap: 0.25rem;
    margin-bottom: 1rem;
  }

  &__amount {
    font-size: 2rem;
    font-weight: 700;
    color: var(--bulma-text);
    line-height: 1;
  }

  &__price-label {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
  }

  &__features {
    flex: 1;
    margin-bottom: 1rem;
  }

  &__actions {
    margin-top: auto;
  }

  &__btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.625rem 1.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: var(--bulma-radius);
    cursor: pointer;
    transition: all 0.15s;

    &--primary {
      background: var(--bulma-primary);
      color: var(--bulma-primary-invert);
      border: 1px solid var(--bulma-primary);

      &:hover {
        background: color-mix(in oklch, var(--bulma-primary) 85%, black);
      }
    }

    &--outline {
      background: transparent;
      color: var(--bulma-link);
      border: 1px solid var(--bulma-link);

      &:hover {
        background: var(--bulma-link);
        color: var(--bulma-link-invert);
      }
    }
  }
}
</style>
