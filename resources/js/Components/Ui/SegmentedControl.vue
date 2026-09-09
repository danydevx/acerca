<template>
  <div class="ui-segmented dl-bulma-segmented is-inline-flex" :class="[`dl-bulma-segmented--${variant}`]">
    <button
      v-for="option in options"
      :key="option.value"
      class="dl-bulma-segmented__item"
      :class="{ 'is-selected': modelValue === option.value }"
      @click="$emit('update:modelValue', option.value)"
    >
      <i v-if="option.icon" :class="option.icon"></i>
      <span v-if="option.label">{{ option.label }}</span>
    </button>
  </div>
</template>

<script setup>
defineProps({
  options: { type: Array, default: () => [] },
  modelValue: { type: [String, Number], default: null },
  variant: { type: String, default: 'default' },
})

defineEmits(['update:modelValue'])
</script>

<style lang="scss" scoped>
.dl-bulma-segmented {
  &--default {
    background: var(--bulma-scheme-main-bis);
    border-radius: 8px;
    padding: 4px;
    gap: 4px;

    .dl-bulma-segmented__item {
      padding: 0.5rem 1rem;
      border-radius: 6px;
      border: none;
      background: transparent;
      color: var(--bulma-text-weak);
      cursor: pointer;
      font-size: 0.875rem;
      font-weight: 500;
      transition: all 0.2s;

      &:hover:not(.is-selected) {
        color: var(--bulma-text);
      }

      &.is-selected {
        background: var(--bulma-scheme-main);
        color: var(--bulma-text);
        box-shadow: 0 1px 3px oklch(0 0 0 / 0.1);
      }
    }
  }

  &--grid {
    background: transparent;
    border: 1px solid var(--bulma-border);
    border-radius: 8px;
    padding: 4px;
    gap: 4px;

    .dl-bulma-segmented__item {
      padding: 0.5rem 1rem;
      border-radius: 6px;
      border: none;
      background: transparent;
      color: var(--bulma-text-weak);
      cursor: pointer;
      font-size: 0.875rem;
      font-weight: 500;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      gap: 0.5rem;

      i {
        font-size: 1rem;
      }

      &:hover:not(.is-selected) {
        color: var(--bulma-text);
        background: var(--bulma-scheme-main-bis);
      }

      &.is-selected {
        background: var(--bulma-link);
        color: var(--bulma-link-invert);
      }
    }
  }

  &--lista {
    background: transparent;
    border-bottom: 1px solid var(--bulma-border);
    border-radius: 0;
    padding: 0;
    gap: 0;

    .dl-bulma-segmented__item {
      padding: 0.75rem 1.25rem;
      border-radius: 0;
      border: none;
      background: transparent;
      color: var(--bulma-text-weak);
      cursor: pointer;
      font-size: 0.875rem;
      font-weight: 500;
      transition: all 0.2s;
      border-bottom: 2px solid transparent;
      margin-bottom: -1px;

      &:hover:not(.is-selected) {
        color: var(--bulma-text);
      }

      &.is-selected {
        color: var(--bulma-link);
        border-bottom-color: var(--bulma-link);
      }
    }
  }

  &--compact {
    background: var(--bulma-scheme-main-bis);
    border-radius: 6px;
    padding: 2px;
    gap: 2px;

    .dl-bulma-segmented__item {
      padding: 0.375rem 0.75rem;
      border-radius: 4px;
      border: none;
      background: transparent;
      color: var(--bulma-text-weak);
      cursor: pointer;
      font-size: 0.75rem;
      font-weight: 500;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      gap: 0.375rem;

      i {
        font-size: 0.875rem;
      }

      &:hover:not(.is-selected) {
        color: var(--bulma-text);
      }

      &.is-selected {
        background: var(--bulma-scheme-main);
        color: var(--bulma-text);
        box-shadow: 0 1px 2px oklch(0 0 0 / 0.1);
      }
    }
  }
}
</style>
