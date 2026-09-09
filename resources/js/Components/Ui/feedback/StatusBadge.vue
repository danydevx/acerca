<template>
  <span
    class="status-badge"
    :class="[
      `status-badge--${normalizedType}`,
      `status-badge--${variant}`,
      `status-badge--${size}`,
      { 'status-badge--dot-only': dotOnly },
    ]"
  >
    <span v-if="showDot" class="status-badge__dot"></span>
    <i v-if="showIcon && !dotOnly" class="status-badge__icon" :class="iconClass"></i>
    <span v-if="!dotOnly" class="status-badge__label">{{ label || config.label }}</span>
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
  showDot: {
    type: Boolean,
    default: false,
  },
  dotOnly: {
    type: Boolean,
    default: false,
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v),
  },
  variant: {
    type: String,
    default: 'soft',
    validator: (v) => ['soft', 'solid', 'outlined', 'dot'].includes(v),
  },
})

const typeConfig = {
  active: { icon: 'bi bi-check-circle-fill', label: 'Activo', color: 'success' },
  inactive: { icon: 'bi bi-x-circle-fill', label: 'Inactivo', color: 'grey' },
  pending: { icon: 'bi bi-clock-fill', label: 'Pendiente', color: 'warning' },
  approved: { icon: 'bi bi-check-lg', label: 'Aprobado', color: 'success' },
  rejected: { icon: 'bi bi-x-lg', label: 'Rechazado', color: 'danger' },
  success: { icon: 'bi bi-check-circle-fill', label: 'Éxito', color: 'success' },
  error: { icon: 'bi bi-exclamation-circle-fill', label: 'Error', color: 'danger' },
  warning: { icon: 'bi bi-exclamation-triangle-fill', label: 'Advertencia', color: 'warning' },
  info: { icon: 'bi bi-info-circle-fill', label: 'Info', color: 'info' },
  new: { icon: 'bi bi-plus-circle-fill', label: 'Nuevo', color: 'primary' },
  draft: { icon: 'bi bi-pencil', label: 'Borrador', color: 'info' },
  published: { icon: 'bi bi-globe', label: 'Publicado', color: 'success' },
  archived: { icon: 'bi bi-archive-fill', label: 'Archivado', color: 'grey' },
  featured: { icon: 'bi bi-star-fill', label: 'Destacado', color: 'warning' },
  sale: { icon: 'bi bi-tag-fill', label: 'En oferta', color: 'danger' },
  sold: { icon: 'bi bi-bag-check-fill', label: 'Vendido', color: 'success' },
  rented: { icon: 'bi bi-key-fill', label: 'Rentado', color: 'info' },
  open: { icon: 'bi bi-door-open-fill', label: 'Abierto', color: 'success' },
  closed: { icon: 'bi bi-door-closed-fill', label: 'Cerrado', color: 'grey' },
  online: { icon: 'bi bi-wifi', label: 'En línea', color: 'success' },
  offline: { icon: 'bi bi-wifi-off', label: 'Sin conexión', color: 'grey' },
}

const normalizedType = computed(() => props.type.toLowerCase().replace(/ /g, '-'))
const config = computed(() => typeConfig[normalizedType.value] || { icon: 'bi bi-circle', label: props.type, color: 'info' })
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
  transition: all 0.2s ease;

  &:hover {
    transform: translateY(-1px);
  }

  &__dot {
    width: 0.5rem;
    height: 0.5rem;
    border-radius: 50%;
    background: currentColor;
    animation: pulse-dot 2s infinite;
  }

  &__icon {
    font-size: 0.6875rem;
  }

  &--sm {
    padding: 0.125rem 0.5rem;
    font-size: 0.6875rem;

    .status-badge__dot {
      width: 0.375rem;
      height: 0.375rem;
    }

    .status-badge__icon {
      font-size: 0.625rem;
    }
  }

  &--lg {
    padding: 0.375rem 0.875rem;
    font-size: 0.8125rem;

    .status-badge__dot {
      width: 0.625rem;
      height: 0.625rem;
    }

    .status-badge__icon {
      font-size: 0.75rem;
    }
  }

  &--dot-only {
    padding: 0.375rem;
    border-radius: 50%;
    width: 1.5rem;
    height: 1.5rem;
    justify-content: center;
  }

  &--dot {
    padding: 0;
    background: transparent;
    border: none;
    color: inherit;

    .status-badge__dot {
      animation: none;
    }

    .status-badge__icon,
    .status-badge__label {
      display: none;
    }
  }

  &--solid {
    border: none;

    &.status-badge--active,
    &.status-badge--approved,
    &.status-badge--success,
    &.status-badge--published,
    &.status-badge--sold,
    &.status-badge--rented,
    &.status-badge--open,
    &.status-badge--online {
      background: var(--bulma-success);
      color: var(--bulma-success-invert);
    }

    &.status-badge--inactive,
    &.status-badge--closed,
    &.status-badge--offline,
    &.status-badge--archived {
      background: var(--bulma-grey);
      color: var(--bulma-grey-invert);
    }

    &.status-badge--pending,
    &.status-badge--warning,
    &.status-badge--featured {
      background: var(--bulma-warning);
      color: var(--bulma-warning-invert);
    }

    &.status-badge--rejected,
    &.status-badge--error,
    &.status-badge--sale {
      background: var(--bulma-danger);
      color: var(--bulma-danger-invert);
    }

    &.status-badge--info,
    &.status-badge--draft,
    &.status-badge--new {
      background: var(--bulma-info);
      color: var(--bulma-info-invert);
    }
  }

  &--outlined {
    background: transparent;
    border: 1px solid currentColor;

    &.status-badge--active,
    &.status-badge--approved,
    &.status-badge--success,
    &.status-badge--published,
    &.status-badge--sold,
    &.status-badge--rented,
    &.status-badge--open,
    &.status-badge--online {
      color: var(--bulma-success);
    }

    &.status-badge--inactive,
    &.status-badge--closed,
    &.status-badge--offline,
    &.status-badge--archived {
      color: var(--bulma-grey);
    }

    &.status-badge--pending,
    &.status-badge--warning,
    &.status-badge--featured {
      color: var(--bulma-warning);
    }

    &.status-badge--rejected,
    &.status-badge--error,
    &.status-badge--sale {
      color: var(--bulma-danger);
    }

    &.status-badge--info,
    &.status-badge--draft,
    &.status-badge--new {
      color: var(--bulma-info);
    }
  }

  &--soft {
    &.status-badge--active,
    &.status-badge--approved,
    &.status-badge--success,
    &.status-badge--published,
    &.status-badge--sold,
    &.status-badge--rented,
    &.status-badge--open,
    &.status-badge--online {
      background: color-mix(in oklch, var(--bulma-success) 15%, transparent);
      color: var(--bulma-success);
    }

    &.status-badge--inactive,
    &.status-badge--closed,
    &.status-badge--offline,
    &.status-badge--archived {
      background: color-mix(in oklch, var(--bulma-grey) 15%, transparent);
      color: var(--bulma-grey);
    }

    &.status-badge--pending,
    &.status-badge--warning,
    &.status-badge--featured {
      background: color-mix(in oklch, var(--bulma-warning) 15%, transparent);
      color: var(--bulma-warning);
    }

    &.status-badge--rejected,
    &.status-badge--error,
    &.status-badge--sale {
      background: color-mix(in oklch, var(--bulma-danger) 15%, transparent);
      color: var(--bulma-danger);
    }

    &.status-badge--info,
    &.status-badge--draft,
    &.status-badge--new {
      background: color-mix(in oklch, var(--bulma-info) 15%, transparent);
      color: var(--bulma-info);
    }
  }
}

@keyframes pulse-dot {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}
</style>
