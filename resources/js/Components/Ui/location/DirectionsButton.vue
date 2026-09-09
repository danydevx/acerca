<template>
  <a
    :href="directionsUrl"
    target="_blank"
    rel="noopener noreferrer"
    class="directions-button"
    :class="{ 'directions-button--icon-only': iconOnly }"
  >
    <i class="bi bi-sign-turn-right"></i>
    <span v-if="!iconOnly" class="directions-button__label">{{ label }}</span>
  </a>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  address: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    default: 'Cómo llegar',
  },
  iconOnly: {
    type: Boolean,
    default: false,
  },
  provider: {
    type: String,
    default: 'google',
    validator: (v) => ['google', 'apple', 'waze', 'maps'].includes(v),
  },
})

const providers = {
  google: 'https://www.google.com/maps/dir/?api=1&destination=',
  apple: 'http://maps.apple.com/?daddr=',
  waze: 'https://waze.com/ul?q=',
  maps: 'https://www.google.com/maps/search/?api=1&query=',
}

const directionsUrl = computed(() => {
  const base = providers[props.provider] || providers.google
  return base + encodeURIComponent(props.address)
})
</script>

<style lang="scss" scoped>
.directions-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.625rem 1rem;
  background: var(--bulma-link);
  color: var(--bulma-link-invert);
  border-radius: var(--bulma-radius);
  font-size: 0.875rem;
  font-weight: 500;
  text-decoration: none;
  transition: background-color 0.15s, transform 0.15s;

  &:hover {
    background: var(--bulma-link-hover);
    transform: translateY(-1px);
  }

  &:active {
    transform: translateY(0);
  }

  &:focus-visible {
    outline: 2px solid var(--bulma-link);
    outline-offset: 2px;
  }

  i {
    font-size: 1rem;
  }

  &--icon-only {
    padding: 0.625rem;

    .directions-button__label {
      display: none;
    }
  }
}
</style>
