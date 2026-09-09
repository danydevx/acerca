<template>
  <button
    type="button"
    class="favorite-button"
    :class="{
      'favorite-button--active': isFavorited,
      'favorite-button--icon-only': iconOnly,
    }"
    :aria-label="isFavorited ? 'Quitar de favoritos' : 'Agregar a favoritos'"
    @click="toggle"
  >
    <i :class="isFavorited ? 'bi bi-heart-fill' : 'bi bi-heart'"></i>
    <span v-if="!iconOnly && showLabel" class="favorite-button__label">
      {{ isFavorited ? 'Guardado' : 'Guardar' }}
    </span>
  </button>
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false,
  },
  iconOnly: {
    type: Boolean,
    default: false,
  },
  showLabel: {
    type: Boolean,
    default: true,
  },
})

const emit = defineEmits(['update:modelValue', 'toggle'])

const isFavorited = computed(() => props.modelValue)

const toggle = () => {
  emit('update:modelValue', !props.modelValue)
  emit('toggle', !props.modelValue)
}
</script>

<script>
import { computed } from 'vue'
export default {
  name: 'FavoriteButton'
}
</script>

<style lang="scss" scoped>
.favorite-button {
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

  &:hover {
    border-color: var(--bulma-danger);
    color: var(--bulma-danger);
  }

  &:focus-visible {
    outline: 2px solid var(--bulma-link);
    outline-offset: 2px;
  }

  &--active {
    border-color: var(--bulma-danger);
    color: var(--bulma-danger);
    background: color-mix(in oklch, var(--bulma-danger) 10%, transparent);

    i {
      animation: heartBeat 0.3s ease;
    }
  }

  &--icon-only {
    padding: 0.625rem;
  }

  i {
    font-size: 1rem;
  }
}

@keyframes heartBeat {
  0% { transform: scale(1); }
  50% { transform: scale(1.3); }
  100% { transform: scale(1); }
}
</style>
