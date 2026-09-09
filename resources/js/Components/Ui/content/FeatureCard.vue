<template>
  <div
    class="feature-card"
    :class="{
      'feature-card--horizontal': horizontal,
      'feature-card--clickable': clickable,
    }"
    @click="clickable && $emit('click')"
  >
    <div v-if="icon" class="feature-card__icon">
      <i :class="icon"></i>
    </div>
    <div class="feature-card__content">
      <h4 v-if="title" class="feature-card__title">{{ title }}</h4>
      <p v-if="description" class="feature-card__description">{{ description }}</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  icon: {
    type: String,
    default: '',
  },
  title: {
    type: String,
    default: '',
  },
  description: {
    type: String,
    default: '',
  },
  horizontal: {
    type: Boolean,
    default: false,
  },
  clickable: {
    type: Boolean,
    default: false,
  },
})

defineEmits(['click'])
</script>

<style lang="scss" scoped>
.feature-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  gap: 0.75rem;
  padding: 1.25rem;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  transition: all 0.15s;

  &--horizontal {
    flex-direction: row;
    text-align: left;
  }

  &--clickable {
    cursor: pointer;

    &:hover {
      border-color: var(--bulma-link);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px oklch(0 0 0 / 0.1);
    }
  }

  &__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 3rem;
    height: 3rem;
    border-radius: var(--bulma-radius);
    background: color-mix(in oklch, var(--bulma-link) 10%, transparent);
    color: var(--bulma-link);
    flex-shrink: 0;

    i {
      font-size: 1.5rem;
    }
  }

  &__content {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    min-width: 0;
  }

  &__title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__description {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    line-height: 1.4;
    margin: 0;
  }
}
</style>
