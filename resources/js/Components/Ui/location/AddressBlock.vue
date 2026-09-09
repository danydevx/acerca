<template>
  <div class="address-block" :class="{ 'address-block--compact': compact }">
    <div class="address-block__icon">
      <i class="bi bi-geo-alt"></i>
    </div>
    <div class="address-block__content">
      <span v-if="label" class="address-block__label">{{ label }}</span>
      <span class="address-block__address">{{ address }}</span>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  address: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    default: '',
  },
  compact: {
    type: Boolean,
    default: false,
  },
})
</script>

<style lang="scss" scoped>
.address-block {
  display: flex;
  gap: 0.625rem;

  &__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    border-radius: var(--bulma-radius);
    background: color-mix(in oklch, var(--bulma-link) 10%, transparent);
    color: var(--bulma-link);
    flex-shrink: 0;

    i {
      font-size: 1rem;
    }
  }

  &__content {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
    min-width: 0;
  }

  &__label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--bulma-text-weak);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  &__address {
    font-size: 0.875rem;
    color: var(--bulma-text);
    line-height: 1.4;
  }

  &--compact {
    .address-block__icon {
      width: 1.5rem;
      height: 1.5rem;

      i {
        font-size: 0.875rem;
      }
    }

    .address-block__address {
      font-size: 0.8125rem;
    }
  }
}
</style>
