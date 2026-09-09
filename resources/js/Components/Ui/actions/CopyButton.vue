<template>
  <button
    type="button"
    class="copy-button"
    :class="{
      'copy-button--icon-only': iconOnly,
      'copy-button--success': copied,
    }"
    :disabled="disabled"
    @click="handleCopy"
  >
    <i :class="copied ? 'bi bi-check' : 'bi bi-clipboard'"></i>
    <span v-if="!iconOnly" class="copy-button__label">
      {{ copied ? 'Copiado' : label }}
    </span>
  </button>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  text: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    default: 'Copiar',
  },
  iconOnly: {
    type: Boolean,
    default: false,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['copy', 'error'])

const copied = ref(false)
let timeout = null

const handleCopy = async () => {
  try {
    await navigator.clipboard.writeText(props.text)
    copied.value = true
    emit('copy', props.text)

    if (timeout) clearTimeout(timeout)
    timeout = setTimeout(() => {
      copied.value = false
    }, 2000)
  } catch (err) {
    emit('error', err)
  }
}
</script>

<style lang="scss" scoped>
.copy-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.625rem 1rem;
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius);
  background: var(--bulma-scheme-main);
  color: var(--bulma-text);
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.15s;

  &:hover:not(:disabled) {
    background: var(--bulma-scheme-main-bis);
    border-color: var(--bulma-link);
    color: var(--bulma-link);
  }

  &:focus-visible {
    outline: 2px solid var(--bulma-link);
    outline-offset: 2px;
  }

  &:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  &--icon-only {
    padding: 0.625rem;
  }

  &--success {
    border-color: var(--bulma-success);
    color: var(--bulma-success);

    &:hover:not(:disabled) {
      background: color-mix(in oklch, var(--bulma-success) 10%, transparent);
    }
  }

  i {
    font-size: 1rem;
  }
}
</style>
