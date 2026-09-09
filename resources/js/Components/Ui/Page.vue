<template>
  <div class="page">
    <header v-if="$slots.header || title" class="page__header">
      <slot name="header">
        <div v-if="title" class="page__title">{{ title }}</div>
        <div v-if="subtitle" class="page__subtitle">{{ subtitle }}</div>
      </slot>
    </header>

    <main class="page__content">
      <slot></slot>
    </main>

    <footer v-if="$slots.footer" class="page__footer">
      <slot name="footer"></slot>
    </footer>
  </div>
</template>

<script setup>
defineProps({
  title: { type: String, default: '' },
  subtitle: { type: String, default: '' },
})
</script>

<style lang="scss" scoped>
.page {
  display: flex;
  flex-direction: column;
  min-height: 100dvh;
  background: var(--bulma-scheme-main);
  color: var(--bulma-text);

  &__header {
    flex-shrink: 0;
    padding: 1.5rem;
    border-bottom: 1px solid var(--bulma-border);
  }

  &__title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__subtitle {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin: 0.25rem 0 0;
  }

  &__content {
    flex: 1;
    padding: 1.5rem;
  }

  &__footer {
    flex-shrink: 0;
    padding: 1.5rem;
    border-top: 1px solid var(--bulma-border);
  }
}
</style>
