<template>
  <div class="rating" :class="{ 'rating--inline': inline }">
    <div class="rating__stars">
      <i
        v-for="n in 5"
        :key="n"
        class="rating__star"
        :class="getStarClass(n)"
      ></i>
    </div>
    <span v-if="showValue" class="rating__value">{{ displayValue }}</span>
    <span v-if="count !== null && showCount" class="rating__count">({{ formattedCount }})</span>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  value: {
    type: Number,
    required: true,
  },
  count: {
    type: Number,
    default: null,
  },
  max: {
    type: Number,
    default: 5,
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v),
  },
  showValue: {
    type: Boolean,
    default: false,
  },
  showCount: {
    type: Boolean,
    default: true,
  },
  inline: {
    type: Boolean,
    default: false,
  },
  decimals: {
    type: Number,
    default: 1,
  },
})

const displayValue = computed(() => {
  return props.value.toFixed(props.decimals)
})

const formattedCount = computed(() => {
  if (props.count === null) return ''
  if (props.count >= 1000000) {
    return (props.count / 1000000).toFixed(1) + 'M'
  }
  if (props.count >= 1000) {
    return (props.count / 1000).toFixed(1) + 'k'
  }
  return props.count.toString()
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
.rating {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;

  &--inline {
    display: inline-flex;
  }

  &__stars {
    display: flex;
    gap: 0.0625rem;
  }

  &__star {
    color: var(--bulma-warning);
    font-size: 0.875rem;

    .rating--inline & {
      font-size: 0.75rem;
    }
  }

  &__value {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin-left: 0.25rem;
  }

  &__count {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
  }
}
</style>
