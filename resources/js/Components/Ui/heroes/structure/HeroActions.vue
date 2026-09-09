<template>
  <div
    class="hero-actions"
    :class="[
      `hero-actions--${alignment}`,
      `hero-actions--${direction}`,
      { 'hero-actions--compact': compact }
    ]"
  >
    <slot>
      <a
        v-for="(action, index) in actions"
        :key="index"
        :href="action.href || '#'"
        class="hero-actions__btn"
        :class="[
          `hero-actions__btn--${action.variant || 'primary'}`,
          { 'hero-actions__btn--icon-only': action.iconOnly }
        ]"
        :target="action.external ? '_blank' : undefined"
        :rel="action.external ? 'noopener noreferrer' : undefined"
        @click="$emit('action', action)"
      >
        <i v-if="action.icon" class="hero-actions__icon" :class="action.icon"></i>
        <span v-if="!action.iconOnly && action.label" class="hero-actions__label">{{ action.label }}</span>
      </a>
    </slot>
  </div>
</template>

<script setup>
defineProps({
  actions: {
    type: Array,
    default: () => [],
  },
  alignment: {
    type: String,
    default: 'left',
    validator: (v) => ['left', 'center', 'right'].includes(v),
  },
  direction: {
    type: String,
    default: 'row',
    validator: (v) => ['row', 'column'].includes(v),
  },
  compact: {
    type: Boolean,
    default: false,
  },
})

defineEmits(['action'])
</script>

<style lang="scss" scoped>
.hero-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;

  &--left {
    justify-content: flex-start;
  }

  &--center {
    justify-content: center;
  }

  &--right {
    justify-content: flex-end;
  }

  &--column {
    flex-direction: column;
    align-items: stretch;
  }

  &--compact {
    gap: 0.375rem;
  }

  &__btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    border-radius: var(--bulma-radius);
    font-size: 0.9375rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s;

    &--primary {
      background: var(--bulma-link);
      color: var(--bulma-link-invert);

      &:hover {
        background: var(--bulma-link-hover);
        transform: translateY(-1px);
      }
    }

    &--secondary {
      background: var(--bulma-scheme-main-bis);
      color: var(--bulma-text);

      &:hover {
        background: var(--bulma-scheme-main-ter);
      }
    }

    &--outline {
      background: transparent;
      border: 1px solid var(--bulma-border);
      color: var(--bulma-text);

      &:hover {
        border-color: var(--bulma-link);
        color: var(--bulma-link);
      }
    }

    &--ghost {
      background: transparent;
      color: var(--bulma-link);

      &:hover {
        background: var(--bulma-scheme-main-bis);
      }
    }

    &--icon-only {
      padding: 0.625rem;
      border-radius: 50%;
    }

    &:active {
      transform: translateY(0);
    }
  }

  &__icon {
    font-size: 1em;
  }
}
</style>
