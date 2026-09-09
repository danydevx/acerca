<template>
  <span
    class="property-status"
    :class="`property-status--${normalizedStatus}`"
  >
    {{ label }}
  </span>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  status: {
    type: String,
    required: true,
  },
})

const statusConfig = {
  for_sale: { label: 'En Venta', variant: 'sale' },
  for_rent: { label: 'En Renta', variant: 'rent' },
  sold: { label: 'Vendido', variant: 'sold' },
  rented: { label: 'Rentado', variant: 'rented' },
  pending: { label: 'Pendiente', variant: 'pending' },
  new: { label: 'Nuevo', variant: 'new' },
  reduced: { label: 'Reducido', variant: 'reduced' },
  exclusive: { label: 'Exclusivo', variant: 'exclusive' },
}

const normalizedStatus = computed(() => {
  return props.status.toLowerCase().replace(/ /g, '_')
})

const label = computed(() => {
  return statusConfig[normalizedStatus.value]?.label || props.status
})
</script>

<style lang="scss" scoped>
.property-status {
  display: inline-block;
  padding: 0.25rem 0.5rem;
  font-size: 0.6875rem;
  font-weight: 600;
  text-transform: uppercase;
  border-radius: var(--bulma-radius-small);
  white-space: nowrap;

  &--for_sale,
  &--sale {
    background: color-mix(in oklch, var(--bulma-link) 15%, transparent);
    color: var(--bulma-link);
  }

  &--for_rent,
  &--rent {
    background: color-mix(in oklch, var(--bulma-success) 15%, transparent);
    color: var(--bulma-success);
  }

  &--sold,
  &--rented {
    background: color-mix(in oklch, var(--bulma-danger) 15%, transparent);
    color: var(--bulma-danger);
  }

  &--pending {
    background: color-mix(in oklch, var(--bulma-warning) 15%, transparent);
    color: var(--bulma-warning);
  }

  &--new {
    background: color-mix(in oklch, var(--bulma-info) 15%, transparent);
    color: var(--bulma-info);
  }

  &--reduced {
    background: color-mix(in oklch, var(--bulma-success) 20%, transparent);
    color: var(--bulma-success);
  }

  &--exclusive {
    background: color-mix(in oklch, var(--bulma-primary) 15%, transparent);
    color: var(--bulma-primary);
  }
}
</style>
