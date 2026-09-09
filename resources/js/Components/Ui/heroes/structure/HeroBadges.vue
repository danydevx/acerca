<template>
  <div
    class="hero-badges"
    :class="[
      `hero-badges--${alignment}`,
      `hero-badges--${direction}`
    ]"
  >
    <slot>
      <HeroBadge
        v-for="(badge, index) in badges"
        :key="index"
        :text="badge.text"
        :icon="badge.icon"
        :variant="badge.variant || 'default'"
        :rounded="rounded"
      />
    </slot>
  </div>
</template>

<script setup>
import HeroBadge from './HeroBadge.vue'

defineProps({
  badges: {
    type: Array,
    default: () => [],
  },
  alignment: {
    type: String,
    default: 'left',
    validator: (v) => ['left', 'center', 'right'].includes(v),
  },
  direction: {
    type: String,
    default: 'row',
    validator: (v) => ['row', 'column'].includes(v),
  },
  rounded: {
    type: Boolean,
    default: false,
  },
})
</script>

<style lang="scss" scoped>
.hero-badges {
  display: flex;
  flex-wrap: wrap;
  gap: 0.375rem;

  &--left {
    justify-content: flex-start;
  }

  &--center {
    justify-content: center;
  }

  &--right {
    justify-content: flex-end;
  }

  &--column {
    flex-direction: column;
    align-items: flex-start;
  }
}
</style>
