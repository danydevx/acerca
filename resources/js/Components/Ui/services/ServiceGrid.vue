<template>
  <div class="service-grid" :class="[`service-grid--cols-${columns}`]">
    <slot>
      <ServiceCard
        v-for="item in items"
        :key="item.id"
        :item="item"
        :variant="cardVariant"
        @select="$emit('select', $event)"
        @action="$emit('action', $event)"
      />
    </slot>
  </div>
</template>

<script setup>
import ServiceCard from './ServiceCard.vue'

defineProps({
  items: {
    type: Array,
    default: () => [],
  },
  columns: {
    type: Number,
    default: 3,
    validator: (v) => [2, 3, 4].includes(v),
  },
  cardVariant: {
    type: String,
    default: 'default',
  },
})

defineEmits(['select', 'action'])
</script>

<style lang="scss" scoped>
.service-grid {
  display: grid;
  gap: 1rem;

  &--cols-2 {
    grid-template-columns: repeat(2, 1fr);
  }

  &--cols-3 {
    grid-template-columns: repeat(3, 1fr);
  }

  &--cols-4 {
    grid-template-columns: repeat(4, 1fr);
  }

  @media (max-width: 1024px) {
    &--cols-4 {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  @media (max-width: 768px) {
    &--cols-3,
    &--cols-4 {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 480px) {
    grid-template-columns: 1fr;
  }
}
</style>
