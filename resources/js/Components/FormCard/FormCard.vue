<template>
  <div class="card">
    <div v-if="title" class="card-header">
      <h5 class="mb-0">{{ title }}</h5>
    </div>
    <div class="card-body">
      <slot />
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    default: null
  }
})
</script>
