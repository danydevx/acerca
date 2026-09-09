<template>
  <Teleport to="body">
    <Transition :name="`drawer-${placement}`">
      <div v-if="modelValue" class="ui-drawer dl-bulma-drawer" :class="`dl-bulma-drawer--${placement}`">
        <div class="dl-bulma-drawer__backdrop" @click="$emit('update:modelValue', false)"></div>
        <div class="dl-bulma-drawer__panel">
          <div class="dl-bulma-drawer__header is-flex is-justify-content-space-between is-align-items-center p-4">
            <h3 v-if="title" class="dl-bulma-drawer__title is-size-5 has-text-weight-semibold">{{ title }}</h3>
            <button class="dl-bulma-drawer__close" @click="$emit('update:modelValue', false)">
              <i class="bi bi-x-lg"></i>
            </button>
          </div>
          <div class="dl-bulma-drawer__body p-4">
            <slot></slot>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
defineProps({
  modelValue: { type: Boolean, default: false },
  placement: { type: String, default: 'left' },
  title: { type: String, default: '' },
})

defineEmits(['update:modelValue'])
</script>

<style lang="scss" scoped>
.dl-bulma-drawer {
  position: fixed;
  inset: 0;
  z-index: 100;

  &__backdrop {
    position: absolute;
    inset: 0;
    background: var(--dl-overlay);
  }

  &__panel {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 18.75rem;
    max-width: 90vw;
    background: var(--bulma-scheme-main);
    display: flex;
    flex-direction: column;
    box-shadow: var(--dl-shadow-elevated);
  }

  &--left &__panel {
    left: 0;
  }

  &--right &__panel {
    right: 0;
  }

  &__close {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--bulma-text-weak);
    padding: 0.5rem;
    border-radius: var(--bulma-radius-small);

    &:hover {
      background: var(--bulma-scheme-main-bis);
      color: var(--bulma-text);
    }
  }

  &__body {
    flex: 1;
    overflow-y: auto;
  }
}

.drawer-left-enter-from,
.drawer-left-leave-to {
  opacity: 0;

  .dl-bulma-drawer__panel {
    transform: translateX(-100%);
  }
}

.drawer-right-enter-from,
.drawer-right-leave-to {
  opacity: 0;

  .dl-bulma-drawer__panel {
    transform: translateX(100%);
  }
}

.drawer-left-enter-active,
.drawer-left-leave-active,
.drawer-right-enter-active,
.drawer-right-leave-active {
  transition: opacity 0.3s ease;

  .dl-bulma-drawer__panel {
    transition: transform 0.3s ease;
  }
}
</style>
