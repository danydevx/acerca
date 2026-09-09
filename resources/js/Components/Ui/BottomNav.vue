<template>
  <div class="bottom-nav" :class="[`bottom-nav--${variant}`]">
    <slot></slot>
  </div>
</template>

<script setup>
defineProps({
  variant: { type: String, default: 'default' },
})
</script>

<style lang="scss" scoped>
.bottom-nav {
  display: flex;
  justify-content: space-around;
  align-items: center;
  height: 4rem;
  background: var(--bulma-scheme-main);
  border-top: 1px solid var(--bulma-border);

  &--labeled {
    height: auto;
    padding: 0.5rem 0;

    :deep(.bottom-nav__item) {
      flex-direction: column;
      gap: 0.25rem;
      padding: 0.5rem;
    }
  }

  &--filled {
    background: var(--bulma-scheme-main-bis);
  }
}

:deep(.bottom-nav__item) {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  flex: 1;
  height: 100%;
  padding: 0.75rem;
  color: var(--bulma-text-weak);
  text-decoration: none;
  font-size: 0.75rem;
  transition: color 150ms;
  cursor: pointer;

  &:hover {
    color: var(--bulma-text);
  }

  &.is-active {
    color: var(--bulma-link);
  }

  i {
    font-size: 1.25rem;
  }
}
</style>
