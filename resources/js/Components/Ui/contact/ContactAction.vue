<template>
  <component
    :is="tag"
    :href="!disabled && href"
    :target="external ? '_blank' : undefined"
    :rel="external ? 'noopener noreferrer' : undefined"
    class="contact-action"
    :class="{
      'contact-action--primary': primary,
      'contact-action--icon-only': iconOnly,
      'contact-action--disabled': disabled,
    }"
    :aria-label="ariaLabel"
    @click="handleClick"
  >
    <span class="contact-action__icon">
      <i :class="iconClass"></i>
    </span>
    <span v-if="!iconOnly" class="contact-action__content">
      <span v-if="label" class="contact-action__label">{{ label }}</span>
      <span v-if="value" class="contact-action__value">{{ value }}</span>
    </span>
  </component>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  type: {
    type: String,
    required: true,
    validator: (v) => ['phone', 'whatsapp', 'email', 'website', 'address', 'directions', 'telegram', 'messenger', 'custom'].includes(v),
  },
  value: {
    type: String,
    default: '',
  },
  label: {
    type: String,
    default: '',
  },
  iconOnly: {
    type: Boolean,
    default: false,
  },
  primary: {
    type: Boolean,
    default: false,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  external: {
    type: Boolean,
    default: true,
  },
})

const emit = defineEmits(['click'])

const typeIcons = {
  phone: 'bi bi-telephone',
  whatsapp: 'bi bi-whatsapp',
  email: 'bi bi-envelope',
  website: 'bi bi-globe',
  address: 'bi bi-geo-alt',
  directions: 'bi bi-sign-turn-right',
  telegram: 'bi bi-telegram',
  messenger: 'bi bi-messenger',
  custom: 'bi bi-link',
}

const typeLabels = {
  phone: 'Llamar',
  whatsapp: 'WhatsApp',
  email: 'Email',
  website: 'Sitio web',
  address: 'Dirección',
  directions: 'Cómo llegar',
  telegram: 'Telegram',
  messenger: 'Messenger',
  custom: 'Enlace',
}

const generateHref = (type, value) => {
  if (!value) return '#'
  switch (type) {
    case 'phone':
      return `tel:${value.replace(/\s/g, '')}`
    case 'whatsapp':
      const waNumber = value.replace(/\D/g, '')
      return `https://wa.me/${waNumber}`
    case 'email':
      return `mailto:${value}`
    case 'website':
      const url = value.startsWith('http') ? value : `https://${value}`
      return url
    case 'address':
      return `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(value)}`
    case 'directions':
      return `https://www.google.com/maps/dir/?api=1&destination=${encodeURIComponent(value)}`
    case 'telegram':
      return `https://t.me/${value.replace('@', '')}`
    case 'messenger':
      return `https://m.me/${value}`
    default:
      return value
  }
}

const iconClass = computed(() => typeIcons[props.type] || typeIcons.custom)
const tag = computed(() => (props.disabled || !props.value ? 'span' : 'a'))
const href = computed(() => generateHref(props.type, props.value))
const ariaLabel = computed(() => {
  const action = typeLabels[props.type] || 'Enlace'
  return props.value ? `${action}: ${props.value}` : action
})

const handleClick = (e) => {
  if (props.disabled) {
    e.preventDefault()
    return
  }
  emit('click', { type: props.type, value: props.value })
}
</script>

<style lang="scss" scoped>
.contact-action {
  display: inline-flex;
  align-items: center;
  gap: 0.625rem;
  padding: 0.625rem 0.875rem;
  border-radius: var(--bulma-radius);
  background: var(--bulma-scheme-main-bis);
  color: var(--bulma-text);
  text-decoration: none;
  font-size: 0.875rem;
  cursor: pointer;
  transition: background-color 0.15s, transform 0.15s;

  &:hover:not(.contact-action--disabled) {
    background: var(--bulma-scheme-main-ter);
    transform: translateY(-1px);
  }

  &:active:not(.contact-action--disabled) {
    transform: translateY(0);
  }

  &:focus-visible {
    outline: 2px solid var(--bulma-link);
    outline-offset: 2px;
  }

  &--primary {
    background: var(--bulma-link);
    color: var(--bulma-link-invert);

    &:hover:not(.contact-action--disabled) {
      background: var(--bulma-link-hover);
    }
  }

  &--icon-only {
    padding: 0.625rem;
  }

  &--disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  &__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.5rem;
    height: 1.5rem;
    flex-shrink: 0;

    i {
      font-size: 1.125rem;
    }
  }

  &__content {
    display: flex;
    flex-direction: column;
    min-width: 0;
  }

  &__label {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    line-height: 1.2;
  }

  &__value {
    font-weight: 500;
    line-height: 1.3;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
}
</style>
