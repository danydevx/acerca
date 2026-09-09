<template>
  <div class="ui-dropdown" :class="{ 'ui-dropdown--active': isOpen, 'ui-dropdown--right': isRight }">
    <div class="ui-dropdown__trigger" @click="toggle">
      <slot name="trigger">
        <button class="ui-dropdown__button" aria-haspopup="true">
          <span>Dropdown</span>
          <span class="ui-dropdown__icon">
            <i class="bi bi-chevron-down" aria-hidden="true"></i>
          </span>
        </button>
      </slot>
    </div>
    <div class="ui-dropdown__menu" :class="`ui-dropdown__menu--${placement}`" role="menu">
      <div class="ui-dropdown__content">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: { type: Boolean, default: false },
  placement: { type: String, default: 'bottom-start' },
})

const emit = defineEmits(['update:modelValue'])

const isOpen = computed(() => props.modelValue)
const isRight = computed(() => props.placement === 'bottom-end' || props.placement === 'top-end')

const toggle = () => {
  emit('update:modelValue', !props.modelValue)
}
</script>

<style lang="scss" scoped>
.ui-dropdown {
  position: relative;
  display: inline-block;

  &--active {
    .ui-dropdown__menu {
      display: block;
    }
  }

  &--right {
    .ui-dropdown__menu {
      right: 0;
    }
  }

  &__trigger {
    display: inline-flex;
  }

  &__button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--bulma-text);
    background: var(--bulma-scheme-main);
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius);
    cursor: pointer;
    transition: all 0.15s;

    &:hover {
      background: var(--bulma-scheme-main-bis);
      border-color: var(--bulma-border-hover);
    }
  }

  &__icon {
    display: flex;
    align-items: center;
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &__menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 99;
    min-width: 10rem;
    margin-top: 0.25rem;
    padding: 0.5rem 0;
    background: var(--bulma-scheme-main);
    border-radius: var(--bulma-radius);
    box-shadow: var(--bulma-shadow);

    &--bottom-start {
      left: 0;
    }

    &--bottom-end {
      right: 0;
    }

    &--top-start {
      top: auto;
      bottom: 100%;
      left: 0;
      margin-top: 0;
      margin-bottom: 0.25rem;
    }

    &--top-end {
      top: auto;
      bottom: 100%;
      right: 0;
      margin-top: 0;
      margin-bottom: 0.25rem;
    }
  }

  &__content {
    padding: 0.5rem 0;
  }
}
</style>
