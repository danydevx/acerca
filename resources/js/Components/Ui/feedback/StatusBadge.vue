<template>
  <span
    class="status-badge"
    :class="`status-badge--${normalizedType}`"
  >
    <i v-if="showIcon" class="status-badge__icon" :class="iconClass"></i>
    <span class="status-badge__label">{{ label || type }}</span>
  </span>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  type: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    default: '',
  },
  showIcon: {
    type: Boolean,
    default: true,
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v),
  },
})

const typeConfig = {
  active: { icon: 'bi bi-check-circle', label: 'Activo' },
  inactive: { icon: 'bi bi-x-circle', label: 'Inactivo' },
  pending: { icon: 'bi bi-clock', label: 'Pendiente' },
  approved: { icon: 'bi bi-check', label: 'Aprobado' },
  rejected: { icon: 'bi bi-x', label: 'Rechazado' },
  success: { icon: 'bi bi-check-circle', label: 'Éxito' },
  error: { icon: 'bi bi-exclamation-circle', label: 'Error' },
  warning: { icon: 'bi bi-exclamation-triangle', label: 'Advertencia' },
  info: { icon: 'bi bi-info-circle', label: 'Info' },
  new: { icon: 'bi bi-plus-circle', label: 'Nuevo' },
  draft: { icon: 'bi bi-pencil', label: 'Borrador' },
  published: { icon: 'bi bi-globe', label: 'Publicado' },
  archived: { icon: 'bi bi-archive', label: 'Archivado' },
  featured: { icon: 'bi bi-star', label: 'Destacado' },
  sale: { icon: 'bi bi-tag', label: 'En oferta' },
  sold: { icon: 'bi bi-bag-check', label: 'Vendido' },
  rented: { icon: 'bi bi-key', label: 'Rentado' },
}

const normalizedType = computed(() => props.type.toLowerCase().replace(/ /g, '-'))
const config = computed(() => typeConfig[normalizedType.value] || { icon: 'bi bi-circle', label: props.type })
const iconClass = computed(() => config.value.icon)
</script>

<style lang="scss" scoped>
.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
  padding: 0.25rem 0.625rem;
  font-size: 0.75rem;
  font-weight: 600;
  border-radius: var(--bulma-radius-rounded);
  text-transform: uppercase;
  letter-spacing: 0.03em;
  white-space: nowrap;

  &__icon {
    font-size: 0.6875rem;
  }

  &--active {
    background: color-mix(in oklch, var(--bulma-success) 15%, transparent);
    color: var(--bulma-success);
  }

  &--inactive {
    background: color-mix(in oklch, var(--bulma-grey) 15%, transparent);
    color: var(--bulma-grey);
  }

  &--pending {
    background: color-mix(in oklch, var(--bulma-warning) 15%, transparent);
    color: var(--bulma-warning);
  }

  &--approved,
  &--success,
  &--published {
    background: color-mix(in oklch, var(--bulma-success) 15%, transparent);
    color: var(--bulma-success);
  }

  &--rejected,
  &--error {
    background: color-mix(in oklch, var(--bulma-danger) 15%, transparent);
    color: var(--bulma-danger);
  }

  &--warning {
    background: color-mix(in oklch, var(--bulma-warning) 15%, transparent);
    color: var(--bulma-warning);
  }

  &--info,
  &--draft {
    background: color-mix(in oklch, var(--bulma-info) 15%, transparent);
    color: var(--bulma-info);
  }

  &--new,
  &--featured {
    background: color-mix(in oklch, var(--bulma-primary) 15%, transparent);
    color: var(--bulma-primary);
  }

  &--archived {
    background: color-mix(in oklch, var(--bulma-grey-light) 15%, transparent);
    color: var(--bulma-grey);
  }

  &--sale {
    background: color-mix(in oklch, var(--bulma-danger) 15%, transparent);
    color: var(--bulma-danger);
  }

  &--sold,
  &--rented {
    background: color-mix(in oklch, var(--bulma-success) 15%, transparent);
    color: var(--bulma-success);
  }
}
</style>
