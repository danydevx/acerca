<template>
  <div class="rating-stars" :class="{ 'rating-stars--large': size === 'lg' }">
    <i
      v-for="n in 5"
      :key="n"
      class="rating-stars__star"
      :class="getStarClass(n)"
    ></i>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  value: {
    type: Number,
    required: true,
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v),
  },
})

const getStarClass = (n) => {
  const filled = n <= Math.floor(props.value)
  const half = !filled && n - 0.5 <= props.value

  if (filled) return 'bi bi-star-fill'
  if (half) return 'bi bi-star-half'
  return 'bi bi-star'
}
</script>

<style lang="scss" scoped>
.rating-stars {
  display: inline-flex;
  gap: 2px;

  &__star {
    color: var(--bulma-warning);
    font-size: 0.875rem;

    .rating-stars--large & {
      font-size: 1.5rem;
    }
  }
}
</style>
