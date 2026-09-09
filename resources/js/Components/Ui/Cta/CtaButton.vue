<template>
  <a
    :href="href"
    class="button"
    :class="[`is-${size}`, `is-${variant}`]"
    :aria-disabled="disabled"
    @click.prevent="!disabled && $emit('click')"
  >
    <span>{{ label }}</span>
    <i v-if="icon" class="bi bi-arrow-right"></i>
  </a>
</template>

<script setup>
defineProps({
  label: { type: String, default: 'Ver detalles' },
  href: { type: String, default: '#' },
  variant: { type: String, default: 'primary', validator: (v) => ['primary', 'outline', 'ghost'].includes(v) },
  size: { type: String, default: 'sm', validator: (v) => ['sm', 'md', 'lg'].includes(v) },
  icon: { type: Boolean, default: true },
  disabled: { type: Boolean, default: false },
})

defineEmits(['click'])
</script>

<style lang="scss" scoped>
a {
  text-decoration: none;
}
</style>
