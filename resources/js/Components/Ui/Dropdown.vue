<template>
  <div class="dropdown" :class="{ 'is-active': isOpen, 'is-right': isRight }">
    <div class="dropdown-trigger" @click="toggle">
      <slot name="trigger">
        <button class="button" aria-haspopup="true">
          <span>Dropdown</span>
          <span class="icon is-small">
            <i class="bi bi-chevron-down" aria-hidden="true"></i>
          </span>
        </button>
      </slot>
    </div>
    <div class="dropdown-menu" :class="`dropdown-menu--${placement}`" role="menu">
      <div class="dropdown-content">
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
.dropdown-menu--bottom-start {
  left: 0;
}

.dropdown-menu--bottom-end {
  right: 0;
}

.dropdown-menu--top-start {
  left: 0;
  top: auto;
  bottom: 100%;
}

.dropdown-menu--top-end {
  right: 0;
  top: auto;
  bottom: 100%;
}
</style>
