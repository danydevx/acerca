<template>
  <div class="review-summary">
    <div class="review-summary__overall">
      <div class="review-summary__score">
        <span class="review-summary__value">{{ average.toFixed(1) }}</span>
        <span class="review-summary__max">/5</span>
      </div>
      <RatingStars :value="average" />
      <span class="review-summary__count">{{ total }} reseñas</span>
    </div>

    <div v-if="distribution.length" class="review-summary__distribution">
      <div
        v-for="item in distribution"
        :key="item.stars"
        class="review-summary__bar"
      >
        <span class="review-summary__bar-label">{{ item.stars }}</span>
        <div class="review-summary__bar-track">
          <div
            class="review-summary__bar-fill"
            :style="{ width: item.percent + '%' }"
          ></div>
        </div>
        <span class="review-summary__bar-count">{{ item.count }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import RatingStars from './RatingStars.vue'

const props = defineProps({
  average: {
    type: Number,
    required: true,
  },
  total: {
    type: Number,
    required: true,
  },
  distribution: {
    type: Array,
    default: () => [],
  },
})

const distribution = computed(() => {
  if (props.distribution.length) return props.distribution

  return [
    { stars: 5, count: Math.round(props.total * 0.6), percent: 60 },
    { stars: 4, count: Math.round(props.total * 0.25), percent: 25 },
    { stars: 3, count: Math.round(props.total * 0.1), percent: 10 },
    { stars: 2, count: Math.round(props.total * 0.03), percent: 3 },
    { stars: 1, count: Math.round(props.total * 0.02), percent: 2 },
  ]
})
</script>

<style lang="scss" scoped>
.review-summary {
  display: flex;
  flex-direction: column;
  gap: 1rem;

  &__overall {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
    padding: 1rem;
    background: var(--bulma-scheme-main-bis);
    border-radius: var(--bulma-radius);
  }

  &__score {
    display: flex;
    align-items: baseline;
    gap: 0.125rem;
  }

  &__value {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--bulma-text);
    line-height: 1;
  }

  &__max {
    font-size: 1rem;
    color: var(--bulma-text-weak);
  }

  &__count {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    margin-top: 0.25rem;
  }

  &__distribution {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
  }

  &__bar {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  &__bar-label {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    width: 0.75rem;
    text-align: right;
  }

  &__bar-track {
    flex: 1;
    height: 6px;
    background: var(--bulma-scheme-main-bis);
    border-radius: 3px;
    overflow: hidden;
  }

  &__bar-fill {
    height: 100%;
    background: var(--bulma-warning);
    border-radius: 3px;
    transition: width 0.3s ease;
  }

  &__bar-count {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    width: 2rem;
    text-align: right;
  }
}
</style>
