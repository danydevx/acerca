<template>
  <a
    :href="href"
    class="button is-small is-ghost"
    :class="[`is-${size}`]"
    :aria-disabled="disabled"
    @click.prevent="!disabled && $emit('click')"
  >
    <i class="bi bi-arrow-right"></i>
  </a>
</template>

<script setup>
defineProps({
  href: { type: String, default: '#' },
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
