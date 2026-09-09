<template>
  <div class="ui-popover dl-bulma-popover is-inline-block is-relative" :class="{ 'is-active': isOpen }">
    <div class="dl-bulma-popover__trigger" @click="toggle">
      <slot name="trigger"></slot>
    </div>
    <div class="dl-bulma-popover__body p-4" :class="`dl-bulma-popover__body--${placement}`">
      <slot></slot>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: { type: Boolean, default: false },
  placement: { type: String, default: 'bottom' },
})

const emit = defineEmits(['update:modelValue'])

const isOpen = computed(() => props.modelValue)

const toggle = () => {
  emit('update:modelValue', !props.modelValue)
}
</script>

<style lang="scss" scoped>
.dl-bulma-popover {
  &__trigger {
    cursor: pointer;
  }

  &__body {
    display: none;
    position: absolute;
    z-index: 50;
    background: var(--bulma-scheme-main);
    border-radius: 8px;
    box-shadow: 0 4px 12px oklch(0 0 0 / 0.15);
    min-width: 200px;
    margin-top: 0.5rem;

    &--bottom {
      top: 100%;
      left: 0;
    }

    &--top {
      bottom: 100%;
      left: 0;
    }

    &--bottom-start {
      top: 100%;
      left: 0;
    }

    &--bottom-end {
      top: 100%;
      right: 0;
    }

    &--top-start {
      bottom: 100%;
      left: 0;
    }

    &--top-end {
      bottom: 100%;
      right: 0;
    }
  }

  &.is-active &__body {
    display: block;
  }
}
</style>
