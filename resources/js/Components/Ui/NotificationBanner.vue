<template>
  <div
    class="dl-bulma-notification-banner is-flex is-align-items-center is-gap-3 p-4"
    :class="[`dl-bulma-notification-banner--${tone}`]"
  >
    <div v-if="icon" class="dl-bulma-notification-banner__icon">
      <i :class="icon"></i>
    </div>
    <div class="dl-bulma-notification-banner__content is-flex-grow-1">
      <div v-if="title" class="dl-bulma-notification-banner__title is-size-6 has-text-weight-semibold">{{ title }}</div>
      <div v-if="message" class="dl-bulma-notification-banner__message is-size-7 has-text-grey">{{ message }}</div>
    </div>
    <div v-if="actions.length" class="dl-bulma-notification-banner__actions is-flex is-gap-2 is-flex-shrink-0">
      <button
        v-for="(action, index) in actions"
        :key="index"
        class="dl-bulma-notification-banner__action"
        :class="`dl-bulma-notification-banner__action--${action.variant || 'default'}`"
        @click="action.onClick && action.onClick()"
      >
        {{ action.label }}
      </button>
    </div>
    <button v-if="closable" class="dl-bulma-notification-banner__close" aria-label="Dismiss" @click="$emit('close')">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>
</template>

<script setup>
defineProps({
  tone: { type: String, default: 'info', validator: (v) => ['info', 'neutral', 'success', 'warning', 'danger'].includes(v) },
  icon: { type: String, default: '' },
  title: { type: String, default: '' },
  message: { type: String, default: '' },
  actions: { type: Array, default: () => [] },
  closable: { type: Boolean, default: true },
})

defineEmits(['close'])
</script>

<style lang="scss" scoped>
.dl-bulma-notification-banner {
  border-radius: 8px;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  flex-wrap: wrap;

  &--info {
    background: color-mix(in oklch, var(--bulma-info) 15%, var(--bulma-scheme-main));
    border-color: color-mix(in oklch, var(--bulma-info) 30%, transparent);

    .dl-bulma-notification-banner__icon { color: var(--bulma-info); }
  }

  &--neutral {
    background: var(--bulma-scheme-main-bis);
    border-color: var(--bulma-border);

    .dl-bulma-notification-banner__icon { color: var(--bulma-text-weak); }
  }

  &--success {
    background: color-mix(in oklch, var(--bulma-success) 15%, var(--bulma-scheme-main));
    border-color: color-mix(in oklch, var(--bulma-success) 30%, transparent);

    .dl-bulma-notification-banner__icon { color: var(--bulma-success); }
  }

  &--warning {
    background: color-mix(in oklch, var(--bulma-warning) 15%, var(--bulma-scheme-main));
    border-color: color-mix(in oklch, var(--bulma-warning) 30%, transparent);

    .dl-bulma-notification-banner__icon { color: var(--bulma-warning); }
  }

  &--danger {
    background: color-mix(in oklch, var(--bulma-danger) 15%, var(--bulma-scheme-main));
    border-color: color-mix(in oklch, var(--bulma-danger) 30%, transparent);

    .dl-bulma-notification-banner__icon { color: var(--bulma-danger); }
  }

  &__icon {
    font-size: 1.5rem;
    flex-shrink: 0;
  }

  &__content {
    min-width: 200px;
  }

  &__title {
    color: var(--bulma-text);
  }

  &__message {
    color: var(--bulma-text-weak);
    margin-top: 0.25rem;
  }

  &__actions {
    flex-shrink: 0;
  }

  &__action {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    border: 1px solid var(--bulma-border);
    background: var(--bulma-scheme-main);
    cursor: pointer;
    transition: all 0.15s;

    &:hover {
      background: var(--bulma-scheme-main-bis);
    }

    &--primary {
      background: var(--bulma-primary);
      border-color: var(--bulma-primary);
      color: var(--bulma-primary-invert);

      &:hover {
        background: color-mix(in oklch, var(--bulma-primary) 90%, black);
      }
    }
  }

  &__close {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--bulma-text-weak);
    padding: 0.25rem;
    border-radius: 4px;
    flex-shrink: 0;

    &:hover {
      color: var(--bulma-text);
      background: var(--bulma-scheme-main-bis);
    }
  }
}
</style>
