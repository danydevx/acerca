<template>
  <button
    type="button"
    class="share-button"
    :class="{ 'share-button--icon-only': iconOnly }"
    :disabled="disabled || !canShare"
    @click="handleShare"
  >
    <i class="bi bi-share"></i>
    <span v-if="!iconOnly" class="share-button__label">{{ label }}</span>
  </button>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

const props = defineProps({
  title: {
    type: String,
    default: '',
  },
  text: {
    type: String,
    default: '',
  },
  url: {
    type: String,
    default: '',
  },
  label: {
    type: String,
    default: 'Compartir',
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

const emit = defineEmits(['share', 'error'])

const canShare = ref(false)

onMounted(() => {
  canShare.value = navigator.share ? true : false
})

const handleShare = async () => {
  if (!canShare.value) {
    emit('error', 'Web Share API not supported')
    return
  }

  try {
    await navigator.share({
      title: props.title,
      text: props.text,
      url: props.url || window.location.href,
    })
    emit('share', { title: props.title, text: props.text, url: props.url })
  } catch (err) {
    if (err.name !== 'AbortError') {
      emit('error', err)
    }
  }
}
</script>

<style lang="scss" scoped>
.share-button {
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

  i {
    font-size: 1rem;
  }
}
</style>
