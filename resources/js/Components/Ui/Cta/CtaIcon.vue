<template>
  <a
    :href="href"
    class="button"
    :class="[`is-${size}`, `is-${variant}`]"
    :aria-label="label"
    :aria-disabled="disabled"
    @click.prevent="!disabled && $emit('click')"
  >
    <i :class="icon"></i>
  </a>
</template>

<script setup>
defineProps({
  icon: { type: String, default: 'bi bi-arrow-right' },
  label: { type: String, required: true },
  href: { type: String, default: '#' },
  variant: { type: String, default: 'ghost', validator: (v) => ['primary', 'outline', 'ghost'].includes(v) },
  size: { type: String, default: 'sm', validator: (v) => ['sm', 'md', 'lg'].includes(v) },
  disabled: { type: Boolean, default: false },
})

defineEmits(['click'])
</script>

<style lang="scss" scoped>
a {
  text-decoration: none;
}
</style>
