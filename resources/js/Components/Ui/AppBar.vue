<template>
  <header class="ui-app-bar dl-bulma-app-bar" :class="{ 'dl-bulma-app-bar--bordered': bordered }">
    <div v-if="$slots.leading" class="dl-bulma-app-bar__leading">
      <slot name="leading"></slot>
    </div>
    <div class="dl-bulma-app-bar__content">
      <div class="dl-bulma-app-bar__title">
        <slot name="title">{{ title }}</slot>
      </div>
      <div v-if="subtitle || $slots.subtitle" class="dl-bulma-app-bar__subtitle">
        <slot name="subtitle">{{ subtitle }}</slot>
      </div>
    </div>
    <div v-if="$slots.actions" class="dl-bulma-app-bar__actions">
      <slot name="actions"></slot>
    </div>
  </header>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    default: '',
  },
  subtitle: {
    type: String,
    default: '',
  },
  bordered: {
    type: Boolean,
    default: false,
  },
})
</script>

<style lang="scss" scoped>
.dl-bulma-app-bar {
  display: flex;
  align-items: center;
  padding: 0.75rem 1rem;
  background: var(--bulma-scheme-main);
  min-height: 56px;

  &--bordered {
    border-bottom: 1px solid var(--bulma-border);
  }

  &__leading {
    display: flex;
    align-items: center;
    margin-right: 0.5rem;

    :deep(.button) {
      padding: 0.5rem;
      height: auto;
      border: none;
      background: transparent;

      &:hover {
        background: var(--bulma-scheme-main-bis);
      }
    }
  }

  &__content {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-width: 0;
  }

  &__title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--bulma-text);
    line-height: 1.2;
  }

  &__subtitle {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin-top: 0.125rem;
  }

  &__actions {
    display: flex;
    align-items: center;
    margin-left: 0.5rem;

    :deep(.button) {
      padding: 0.5rem;
      height: auto;
      border: none;
      background: transparent;

      &:hover {
        background: var(--bulma-scheme-main-bis);
      }
    }
  }
}
</style>
