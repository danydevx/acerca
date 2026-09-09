<template>
  <BaseButton variant="info" v-bind="$attrs">
    <slot />
  </BaseButton>
</template>

<script setup>
import BaseButton from './BaseButton.vue'

defineOptions({
  inheritAttrs: false
})
</script>
