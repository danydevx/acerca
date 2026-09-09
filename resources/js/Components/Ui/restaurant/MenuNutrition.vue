<template>
  <div class="menu-nutrition" :class="{ 'menu-nutrition--compact': compact }">
    <div v-if="calories" class="menu-nutrition__item">
      <span class="menu-nutrition__value">{{ calories }}</span>
      <span class="menu-nutrition__label">kcal</span>
    </div>
    <div v-if="protein" class="menu-nutrition__item">
      <span class="menu-nutrition__value">{{ protein }}g</span>
      <span class="menu-nutrition__label">Proteína</span>
    </div>
    <div v-if="carbs" class="menu-nutrition__item">
      <span class="menu-nutrition__value">{{ carbs }}g</span>
      <span class="menu-nutrition__label">Carbos</span>
    </div>
    <div v-if="fat" class="menu-nutrition__item">
      <span class="menu-nutrition__value">{{ fat }}g</span>
      <span class="menu-nutrition__label">Grasa</span>
    </div>
    <div v-if="fiber" class="menu-nutrition__item">
      <span class="menu-nutrition__value">{{ fiber }}g</span>
      <span class="menu-nutrition__label">Fibra</span>
    </div>
    <div v-if="sodium" class="menu-nutrition__item">
      <span class="menu-nutrition__value">{{ sodium }}mg</span>
      <span class="menu-nutrition__label">Sodio</span>
    </div>
  </div>
</template>

<script setup>
defineProps({
  calories: {
    type: Number,
    default: null,
  },
  protein: {
    type: Number,
    default: null,
  },
  carbs: {
    type: Number,
    default: null,
  },
  fat: {
    type: Number,
    default: null,
  },
  fiber: {
    type: Number,
    default: null,
  },
  sodium: {
    type: Number,
    default: null,
  },
  compact: {
    type: Boolean,
    default: false,
  },
})
</script>

<style lang="scss" scoped>
.menu-nutrition {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;

  &--compact {
    gap: 0.5rem;
  }

  &__item {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 3rem;
  }

  &__value {
    font-size: 0.9375rem;
    font-weight: 700;
    color: var(--bulma-text);
  }

  &__label {
    font-size: 0.625rem;
    color: var(--bulma-text-weak);
    text-transform: uppercase;
    letter-spacing: 0.025em;
  }
}
</style>
