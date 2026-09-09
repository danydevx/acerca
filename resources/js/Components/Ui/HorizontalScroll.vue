<template>
  <div class="ui-horizontal-scroll dl-bulma-horizontal-scroll" :class="{ 'dl-bulma-horizontal-scroll--snap': snap, 'dl-bulma-horizontal-scroll--peek': peek }">
    <slot></slot>
  </div>
</template>

<script setup>
defineProps({
  snap: { type: Boolean, default: true },
  peek: { type: Boolean, default: false },
})
</script>

<style lang="scss" scoped>
.dl-bulma-horizontal-scroll {
  display: flex;
  gap: 0.75rem;
  overflow-x: auto;
  padding-bottom: 0.5rem;
  scroll-snap-type: x mandatory;
  -webkit-overflow-scrolling: touch;

  &::-webkit-scrollbar {
    height: 4px;
  }

  &::-webkit-scrollbar-track {
    background: var(--bulma-border);
    border-radius: 2px;
  }

  &::-webkit-scrollbar-thumb {
    background: var(--bulma-text-weak);
    border-radius: 2px;

    &:hover {
      background: var(--bulma-text);
    }
  }

  &--snap {
    scroll-snap-type: x mandatory;

    > * {
      scroll-snap-align: start;
      flex-shrink: 0;
    }
  }

  &--peek {
    padding-left: 1rem;
    padding-right: 1rem;

    &:not(:first-child) {
      margin-left: -1rem;
    }

    &:not(:last-child) {
      margin-right: -1rem;
    }
  }
}
</style>
