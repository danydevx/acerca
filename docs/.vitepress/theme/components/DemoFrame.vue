<script setup>
defineProps({
  theme: {
    type: String,
    default: 'light'
  }
})
</script>

<template>
  <div class="demo-frame" :data-theme="theme">
    <slot />
  </div>
</template>

<style scoped>
.demo-frame {
  padding: var(--orp-space-6);
  background: var(--orp-surface);
  border: 1px solid var(--orp-border);
  border-radius: var(--orp-radius-lg);
  margin: var(--orp-space-4) 0;
}

.demo-frame[data-theme="dark"] {
  background: var(--orp-surface);
  filter: brightness(0.9);
}
</style>
