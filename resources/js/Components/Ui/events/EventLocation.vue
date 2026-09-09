<template>
  <div class="event-location" :class="{ 'event-location--compact': compact }">
    <i class="bi bi-geo-alt"></i>
    <div class="event-location__content">
      <span v-if="name" class="event-location__name">{{ name }}</span>
      <span v-if="address" class="event-location__address">{{ address }}</span>
    </div>
    <a
      v-if="directionsUrl"
      :href="directionsUrl"
      target="_blank"
      rel="noopener noreferrer"
      class="event-location__directions"
      aria-label="Obtener direcciones"
    >
      <i class="bi bi-box-arrow-up-right"></i>
    </a>
  </div>
</template>

<script setup>
const props = defineProps({
  name: {
    type: String,
    default: '',
  },
  address: {
    type: String,
    default: '',
  },
  directionsUrl: {
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
.event-location {
  display: inline-flex;
  align-items: flex-start;
  gap: 0.5rem;
  font-size: 0.875rem;
  color: var(--bulma-text);

  i {
    color: var(--bulma-text-weak);
    font-size: 1rem;
    flex-shrink: 0;
    margin-top: 0.125rem;
  }

  &__content {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
  }

  &__name {
    font-weight: 500;
  }

  &__address {
    color: var(--bulma-text-weak);
    font-size: 0.8125rem;
  }

  &__directions {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.75rem;
    height: 1.75rem;
    border-radius: var(--bulma-radius);
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text-weak);
    text-decoration: none;
    flex-shrink: 0;
    transition: background-color 0.15s, color 0.15s;

    &:hover {
      background: var(--bulma-scheme-main-ter);
      color: var(--bulma-link);
    }

    i {
      font-size: 0.75rem;
      margin: 0;
    }
  }

  &--compact {
    font-size: 0.8125rem;

    i {
      font-size: 0.875rem;
    }
  }
}
</style>
