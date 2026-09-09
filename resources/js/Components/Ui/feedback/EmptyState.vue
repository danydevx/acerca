<template>
  <div class="empty-state" :class="{ 'empty-state--compact': compact }">
    <div class="empty-state__icon">
      <i :class="icon"></i>
    </div>
    <div class="empty-state__content">
      <h4 v-if="title" class="empty-state__title">{{ title }}</h4>
      <p v-if="description" class="empty-state__description">{{ description }}</p>
      <div v-if="$slots.action" class="empty-state__actions">
        <slot name="action"></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  icon: {
    type: String,
    default: 'bi bi-inbox',
  },
  title: {
    type: String,
    default: 'No hay nada aquí',
  },
  description: {
    type: String,
    default: 'Aún no hay contenido para mostrar.',
  },
  compact: {
    type: Boolean,
    default: false,
  },
})
</script>

<style lang="scss" scoped>
.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  gap: 1rem;
  padding: 3rem 2rem;

  &--compact {
    flex-direction: row;
    padding: 1.5rem;
    text-align: left;
    gap: 1.25rem;

    .empty-state__icon {
      width: 3.5rem;
      height: 3.5rem;
      font-size: 1.5rem;
    }
  }

  &__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 5rem;
    height: 5rem;
    background: var(--bulma-scheme-main-bis);
    border-radius: 50%;
    color: var(--bulma-text-weak);

    i {
      font-size: 2.5rem;
    }
  }

  &__content {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    max-width: 320px;
  }

  &__title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__description {
    font-size: 0.9375rem;
    color: var(--bulma-text-weak);
    line-height: 1.5;
    margin: 0;
  }

  &__actions {
    margin-top: 0.75rem;
  }
}
</style>
