<template>
  <div
    class="ui-spinner dl-bulma-spinner"
    :class="`dl-bulma-spinner--${size}`"
    role="status"
    :aria-label="label"
  >
    <span class="is-sr-only">{{ label }}</span>
  </div>
</template>

<script setup>
defineProps({
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v)
  },
  label: {
    type: String,
    default: 'Loading'
  }
})
</script>

<style lang="scss" scoped>
.dl-bulma-spinner {
  border: 3px solid var(--bulma-scheme-main-bis);
  border-top-color: var(--bulma-primary);
  border-radius: 50%;
  animation: dl-bulma-spin 0.8s linear infinite;

  &--sm {
    width: 16px;
    height: 16px;
  }

  &--md {
    width: 24px;
    height: 24px;
  }

  &--lg {
    width: 48px;
    height: 48px;
  }
}

@keyframes dl-bulma-spin {
  to {
    transform: rotate(360deg);
  }
}
</style>
