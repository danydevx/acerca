<template>
  <div class="menu-allergens" :class="{ 'menu-allergens--inline': inline }">
    <span
      v-for="allergen in allergens"
      :key="allergen"
      class="menu-allergen"
      :class="`menu-allergen--${getVariant(allergen)}`"
      :title="getLabel(allergen)"
    >
      <i :class="getIcon(allergen)"></i>
      <span v-if="!iconOnly" class="menu-allergen__label">{{ getLabel(allergen) }}</span>
    </span>
  </div>
</template>

<script setup>
const props = defineProps({
  allergens: {
    type: Array,
    default: () => [],
  },
  iconOnly: {
    type: Boolean,
    default: false,
  },
  inline: {
    type: Boolean,
    default: false,
  },
})

const allergenData = {
  gluten: { icon: 'bi bi-bread-slice', label: 'Contiene gluten', variant: 'warning' },
  lactose: { icon: 'bi bi-droplet', label: 'Contiene lactosa', variant: 'warning' },
  nuts: { icon: 'bi bi-tree', label: 'Contiene frutos secos', variant: 'danger' },
  peanuts: { icon: 'bi bi-tree-fill', label: 'Contiene cacahuetes', variant: 'danger' },
  eggs: { icon: 'bi bi-egg', label: 'Contiene huevos', variant: 'warning' },
  soy: { icon: 'bi bi-circle-fill', label: 'Contiene soja', variant: 'warning' },
  fish: { icon: 'bi bi-moisture', label: 'Contiene pescado', variant: 'danger' },
  shellfish: { icon: 'bi bi-bucket', label: 'Contiene mariscos', variant: 'danger' },
  celery: { icon: 'bi bi-chevron-double-right', label: 'Contiene apio', variant: 'warning' },
  mustard: { icon: 'bi bi-chevron-double-right', label: 'Contiene mostaza', variant: 'warning' },
  sesame: { icon: 'bi bi-circle', label: 'Contiene sésamo', variant: 'warning' },
  sulfites: { icon: 'bi bi-wine', label: 'Contiene sulfitos', variant: 'warning' },
  vegetarian: { icon: 'bi bi-flower1', label: 'Vegetariano', variant: 'success' },
  vegan: { icon: 'bi bi-flower2', label: 'Vegano', variant: 'success' },
  halal: { icon: 'bi bi-moon', label: 'Halal', variant: 'success' },
  kosher: { icon: 'bi bi-star', label: 'Kosher', variant: 'success' },
  spicy: { icon: 'bi bi-fire', label: 'Picante', variant: 'danger' },
  mild: { icon: 'bi bi-thermometer-low', label: 'Suave', variant: 'info' },
}

const getIcon = (allergen) => allergenData[allergen]?.icon || 'bi bi-question-circle'
const getLabel = (allergen) => allergenData[allergen]?.label || allergen
const getVariant = (allergen) => allergenData[allergen]?.variant || 'default'
</script>

<style lang="scss" scoped>
.menu-allergens {
  display: flex;
  flex-wrap: wrap;
  gap: 0.375rem;

  &--inline {
    display: inline-flex;
  }
}

.menu-allergen {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  padding: 0.125rem 0.375rem;
  border-radius: var(--bulma-radius-small);
  font-size: 0.6875rem;
  font-weight: 500;

  i {
    font-size: 0.75rem;
  }

  &__label {
    white-space: nowrap;
  }

  &--default {
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text-weak);
  }

  &--warning {
    background: oklch(70% 0.15 80);
    color: oklch(30% 0.15 80);
  }

  &--danger {
    background: oklch(70% 0.15 25);
    color: oklch(30% 0.15 25);
  }

  &--success {
    background: oklch(70% 0.15 145);
    color: oklch(30% 0.15 145);
  }

  &--info {
    background: oklch(70% 0.12 250);
    color: oklch(30% 0.12 250);
  }
}
</style>
