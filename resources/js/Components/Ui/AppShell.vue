<template>
  <div class="app-shell" :class="{ 'app-shell--safe-top': safeTop, 'app-shell--safe-bottom': safeBottom }">
    <header v-if="$slots.header || title" class="app-shell__header">
      <slot name="header">
        <div class="app-shell__header-content">
          <button v-if="showBack" class="app-shell__back" @click="$emit('back')">
            <i class="bi bi-arrow-left"></i>
          </button>
          <h1 class="app-shell__title">{{ title }}</h1>
          <div class="app-shell__actions">
            <slot name="actions"></slot>
          </div>
        </div>
      </slot>
    </header>
    <main class="app-shell__main">
      <slot></slot>
    </main>
    <nav v-if="$slots.bottom" class="app-shell__bottom">
      <slot name="bottom"></slot>
    </nav>
    <Teleport to="body">
      <div v-if="$slots.fab" class="app-shell__fab-container">
        <slot name="fab"></slot>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
defineProps({
  title: { type: String, default: '' },
  showBack: { type: Boolean, default: false },
  safeTop: { type: Boolean, default: false },
  safeBottom: { type: Boolean, default: false },
})

defineEmits(['back'])
</script>

<style lang="scss" scoped>
.app-shell {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background: var(--bulma-scheme-main);

  &--safe-top {
    padding-top: env(safe-area-inset-top);
  }

  &--safe-bottom {
    padding-bottom: env(safe-area-inset-bottom);
  }

  &__header {
    position: sticky;
    top: 0;
    z-index: 30;
    background: var(--bulma-scheme-main);
    border-bottom: 1px solid var(--bulma-border);
  }

  &__header-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
  }

  &__back {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    padding: 0;
    background: transparent;
    border: none;
    border-radius: var(--bulma-radius);
    color: var(--bulma-text);
    cursor: pointer;

    &:hover {
      background: var(--bulma-scheme-main-bis);
    }
  }

  &__title {
    flex: 1;
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  &__main {
    flex: 1;
    padding-bottom: env(safe-area-inset-bottom);
  }

  &__bottom {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 40;
    background: var(--bulma-scheme-main);
    border-top: 1px solid var(--bulma-border);
    padding-bottom: env(safe-area-inset-bottom);
  }

  &__fab-container {
    position: fixed;
    bottom: calc(4rem + env(safe-area-inset-bottom));
    right: 1rem;
    z-index: 50;
  }
}
</style>
