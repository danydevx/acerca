<template>
  <div class="ui-search dl-bulma-search is-relative is-flex is-align-items-center" :class="{ 'is-focused': isFocused }">
    <i class="bi bi-search dl-bulma-search__icon pl-3 is-size-6"></i>
    <input
      ref="inputRef"
      :value="modelValue"
      :placeholder="placeholder"
      class="dl-bulma-search__input is-size-7"
      type="text"
      @input="$emit('update:modelValue', $event.target.value)"
      @focus="isFocused = true"
      @blur="isFocused = false"
    >
    <button v-if="modelValue" class="dl-bulma-search__clear" @click="clear">
      <i class="bi bi-x is-size-7"></i>
    </button>
  </div>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
  modelValue: { type: String, default: '' },
  placeholder: { type: String, default: 'Search...' },
})

const emit = defineEmits(['update:modelValue'])

const isFocused = ref(false)
const inputRef = ref(null)

const clear = () => {
  emit('update:modelValue', '')
  inputRef.value?.focus()
}
</script>

<style lang="scss" scoped>
.dl-bulma-search {
  background: var(--bulma-scheme-main-bis);
  border: 1px solid transparent;
  border-radius: 8px;
  transition: all 0.2s;

  &.is-focused {
    background: var(--bulma-scheme-main);
    border-color: var(--bulma-link);
    box-shadow: 0 0 0 3px color-mix(in oklch, var(--bulma-link) 20%, transparent);
  }

  &__icon {
    position: absolute;
    color: var(--bulma-text-weak);
    pointer-events: none;
  }

  &__input {
    width: 100%;
    padding: 0.625rem 2.5rem 0.625rem 2.5rem;
    background: transparent;
    border: none;
    color: var(--bulma-text);
    outline: none;

    &::placeholder {
      color: var(--bulma-text-weak);
    }
  }

  &__clear {
    position: absolute;
    right: 0.5rem;
    background: var(--bulma-border);
    border: none;
    border-radius: 50%;
    width: 1.5rem;
    height: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--bulma-text-weak);
    transition: all 0.15s;

    &:hover {
      background: var(--bulma-text-weak);
      color: var(--bulma-scheme-main);
    }
  }
}
</style>
