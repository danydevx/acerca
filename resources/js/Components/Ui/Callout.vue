<template>
  <div class="callout" :class="[`callout--${type}`, { 'callout--dismissible': dismissible }]">
    <div class="callout-icon">
      <i :class="iconName"></i>
    </div>
    <div class="callout-content">
      <div v-if="title" class="callout-title">{{ title }}</div>
      <div class="callout-body">
        <slot>{{ message }}</slot>
      </div>
    </div>
    <button v-if="dismissible" class="callout-close" aria-label="Dismiss" @click="$emit('dismiss')">
      <i class="bi bi-x"></i>
    </button>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  type: {
    type: String,
    default: 'info',
    validator: (v) => ['info', 'success', 'warning', 'danger', 'tip'].includes(v),
  },
  title: { type: String, default: '' },
  message: { type: String, default: '' },
  icon: { type: String, default: '' },
  dismissible: { type: Boolean, default: false },
})

defineEmits(['dismiss'])

const iconName = computed(() => {
  if (props.icon) return props.icon

  const icons = {
    info: 'bi bi-info-circle',
    success: 'bi bi-check-circle',
    warning: 'bi bi-exclamation-triangle',
    danger: 'bi bi-x-circle',
    tip: 'bi bi-lightbulb',
  }
  return icons[props.type] || icons.info
})
</script>

<style lang="scss" scoped>
.callout {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  padding: 1rem;
  border-radius: var(--bulma-radius);
  border: 1px solid;

  &--info {
    background: color-mix(in oklch, var(--bulma-info) 15%, var(--bulma-scheme-main));
    border-color: color-mix(in oklch, var(--bulma-info) 30%, transparent);
    color: var(--bulma-text);

    .callout-icon { color: var(--bulma-info); }
  }

  &--success {
    background: color-mix(in oklch, var(--bulma-success) 15%, var(--bulma-scheme-main));
    border-color: color-mix(in oklch, var(--bulma-success) 30%, transparent);
    color: var(--bulma-text);

    .callout-icon { color: var(--bulma-success); }
  }

  &--warning {
    background: color-mix(in oklch, var(--bulma-warning) 15%, var(--bulma-scheme-main));
    border-color: color-mix(in oklch, var(--bulma-warning) 30%, transparent);
    color: var(--bulma-text);

    .callout-icon { color: var(--bulma-warning); }
  }

  &--danger {
    background: color-mix(in oklch, var(--bulma-danger) 15%, var(--bulma-scheme-main));
    border-color: color-mix(in oklch, var(--bulma-danger) 30%, transparent);
    color: var(--bulma-text);

    .callout-icon { color: var(--bulma-danger); }
  }

  &--tip {
    background: color-mix(in oklch, var(--bulma-primary) 15%, var(--bulma-scheme-main));
    border-color: color-mix(in oklch, var(--bulma-primary) 30%, transparent);
    color: var(--bulma-text);

    .callout-icon { color: var(--bulma-primary); }
  }

  &--dismissible {
    position: relative;
    padding-right: 2.5rem;
  }
}

.callout-icon {
  flex-shrink: 0;
  font-size: 1.25rem;
  margin-top: 0.125rem;
}

.callout-content {
  flex: 1;
  min-width: 0;
}

.callout-title {
  font-weight: 600;
  margin-bottom: 0.25rem;
}

.callout-body {
  font-size: 0.875rem;
  line-height: 1.5;
}

.callout-close {
  position: absolute;
  top: 0.5rem;
  right: 0.5rem;
  background: none;
  border: none;
  cursor: pointer;
  color: var(--bulma-text-weak);
  padding: 0.25rem;
  border-radius: 4px;

  &:hover {
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text);
  }
}
</style>
