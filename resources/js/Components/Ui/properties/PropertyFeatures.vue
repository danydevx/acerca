<template>
  <div class="property-features" :class="{ 'property-features--inline': inline }">
    <div v-if="beds !== null" class="property-features__item">
      <i class="bi bi-house"></i>
      <span>{{ beds }} {{ bedsLabel }}</span>
    </div>
    <div v-if="baths !== null" class="property-features__item">
      <i class="bi bi-droplet"></i>
      <span>{{ baths }} {{ bathsLabel }}</span>
    </div>
    <div v-if="area !== null" class="property-features__item">
      <i class="bi bi-rulers"></i>
      <span>{{ formattedArea }} {{ areaUnit }}</span>
    </div>
    <div v-if="parking !== null" class="property-features__item">
      <i class="bi bi-car-front"></i>
      <span>{{ parking }} {{ parkingLabel }}</span>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  beds: {
    type: Number,
    default: null,
  },
  baths: {
    type: Number,
    default: null,
  },
  area: {
    type: Number,
    default: null,
  },
  areaUnit: {
    type: String,
    default: 'm²',
  },
  parking: {
    type: Number,
    default: null,
  },
  inline: {
    type: Boolean,
    default: false,
  },
})

const bedsLabel = computed(() => props.beds === 1 ? 'hab' : 'hab')
const bathsLabel = computed(() => props.baths === 1 ? 'baño' : 'baños')
const parkingLabel = computed(() => props.parking === 1 ? 'est.' : 'est.')

const formattedArea = computed(() => {
  if (props.area === null) return ''
  return props.area.toLocaleString('es-ES')
})
</script>

<style lang="scss" scoped>
.property-features {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;

  &--inline {
    flex-wrap: nowrap;
    gap: 0.5rem;
  }

  &__item {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.8125rem;
    color: var(--bulma-text);

    i {
      font-size: 0.9375rem;
      color: var(--bulma-text-weak);
    }
  }
}
</style>
