<template>
  <div class="booking-timezone">
    <i class="bi bi-globe-americas"></i>
    <span class="booking-timezone__label">{{ timezone.label }}</span>
  </div>
</template>

<script setup>
defineProps({
  timezone: {
    type: Object,
    required: true,
  },
})
</script>

<style lang="scss" scoped>
.booking-timezone {
  display: flex;
  align-items: center;
  gap: 0.375rem;
  font-size: 0.8125rem;
  color: var(--bulma-text-weak);

  i {
    font-size: 0.875rem;
  }
}
</style>
