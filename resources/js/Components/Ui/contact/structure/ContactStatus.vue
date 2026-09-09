<template>
  <div v-if="status" class="contact-status" :class="[`is-${type}`]">
    <span class="contact-status__dot"></span>
    {{ status }}
  </div>
</template>

<script setup>
defineProps({
  status: { type: String, default: '' },
  type: {
    type: String,
    default: 'success',
    validator: (v) => ['success', 'warning', 'danger', 'info'].includes(v),
  },
})
</script>

<style lang="scss" scoped>
.contact-status {
  display: flex;
  align-items: center;
  gap: 0.375rem;
  font-size: 0.8125rem;
  font-weight: 500;

  &__dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
  }

  &.is-success {
    color: var(--bulma-success);
    .contact-status__dot { background: var(--bulma-success); }
  }

  &.is-warning {
    color: var(--bulma-warning);
    .contact-status__dot { background: var(--bulma-warning); }
  }

  &.is-danger {
    color: var(--bulma-danger);
    .contact-status__dot { background: var(--bulma-danger); }
  }

  &.is-info {
    color: var(--bulma-info);
    .contact-status__dot { background: var(--bulma-info); }
  }
}
</style>
