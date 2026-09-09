<template>
  <div
    class="ui-empty-state dl-bulma-empty-state is-flex is-flex-direction-column"
    :class="{ 'is-align-items-center has-text-centered': centered }"
  >
    <div v-if="icon" class="dl-bulma-empty-state__icon is-size-1">
      <i :class="icon"></i>
    </div>
    <div v-if="title" class="dl-bulma-empty-state__title is-size-5 has-text-weight-semibold">{{ title }}</div>
    <div v-if="description" class="dl-bulma-empty-state__description is-size-7 has-text-grey">{{ description }}</div>
    <div v-if="$slots.action" class="dl-bulma-empty-state__action mt-4">
      <slot name="action"></slot>
    </div>
  </div>
</template>

<script setup>
defineProps({
  icon: { type: String, default: 'bi bi-inbox' },
  title: { type: String, default: '' },
  description: { type: String, default: '' },
  centered: { type: Boolean, default: false },
})
</script>

<style lang="scss" scoped>
.dl-bulma-empty-state {
  padding: 2rem 1rem;

  &__icon {
    color: var(--bulma-text-weak);
    margin-bottom: 1rem;
  }

  &__title {
    color: var(--bulma-text);
    margin: 0 0 0.5rem;
  }

  &__description {
    margin: 0;
    max-width: 300px;
  }
}
</style>
