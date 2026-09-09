<template>
  <button
    :type="type"
    class="btn rounded-pill"
    :class="buttonClass"
    :disabled="disabled || loading"
  >
    <span v-if="loading" class="spinner-border spinner-border-sm me-1" role="status"></span>
    <slot />
  </button>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  variant: {
    type: String,
    default: 'primary'
  },
  type: {
    type: String,
    default: 'button'
  },
  size: {
    type: String,
    default: null
  },
  disabled: {
    type: Boolean,
    default: false
  },
  loading: {
    type: Boolean,
    default: false
  },
  block: {
    type: Boolean,
    default: false
  }
})

const buttonClass = computed(() => {
  const classes = [`btn-${props.variant}`]
  if (props.size) classes.push(`btn-${props.size}`)
  if (props.block) classes.push('w-100')
  return classes
})
</script>
