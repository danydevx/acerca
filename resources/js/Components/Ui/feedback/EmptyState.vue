<template>
  <div
    class="empty-state"
    :class="[
      `empty-state--${variant}`,
      { 'empty-state--compact': compact }
    ]"
  >
    <div class="empty-state__icon-wrapper">
      <div class="empty-state__icon">
        <i :class="icon"></i>
      </div>
      <div v-if="variant === 'illustration'" class="empty-state__illustration">
        <svg viewBox="0 0 120 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M20 60C20 60 30 40 60 40C90 40 100 60 100 60" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <circle cx="60" cy="30" r="10" stroke="currentColor" stroke-width="2"/>
        </svg>
      </div>
    </div>
    <div class="empty-state__content">
      <h4 v-if="title" class="empty-state__title">{{ title }}</h4>
      <p v-if="description" class="empty-state__description">{{ description }}</p>
      <div v-if="$slots.action" class="empty-state__actions">
        <slot name="action"></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  icon: {
    type: String,
    default: 'bi bi-inbox',
  },
  title: {
    type: String,
    default: 'No hay nada aquí',
  },
  description: {
    type: String,
    default: 'Aún no hay contenido para mostrar.',
  },
  compact: {
    type: Boolean,
    default: false,
  },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'soft', 'outlined', 'filled', 'illustration'].includes(v),
  },
})
</script>

<style lang="scss" scoped>
.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  gap: 1.25rem;
  padding: 3rem 2rem;

  &--compact {
    flex-direction: row;
    padding: 1.5rem;
    text-align: left;
    gap: 1.25rem;

    .empty-state__icon {
      width: 3.5rem;
      height: 3.5rem;
      font-size: 1.5rem;
    }
  }

  &--soft {
    background: var(--bulma-scheme-main-bis);
    border-radius: var(--bulma-radius-large);

    .empty-state__icon {
      background: var(--bulma-scheme-main);
      box-shadow: var(--dl-shadow-sm);
    }
  }

  &--outlined {
    border: 2px dashed var(--bulma-border);
    border-radius: var(--bulma-radius-large);

    .empty-state__icon {
      background: transparent;
      border: 2px dashed var(--bulma-border);
    }
  }

  &--filled {
    background: var(--bulma-scheme-main-bis);
    border-radius: var(--bulma-radius-large);

    .empty-state__icon {
      background: var(--bulma-primary);
      color: var(--bulma-primary-invert);
    }
  }

  &--illustration {
    .empty-state__icon-wrapper {
      position: relative;
    }

    .empty-state__icon {
      background: transparent;
      color: var(--bulma-text-weak);
      animation: float 3s ease-in-out infinite;
    }

    .empty-state__illustration {
      position: absolute;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: center;

      svg {
        width: 100%;
        height: 100%;
        opacity: 0.5;
      }
    }
  }

  &__icon-wrapper {
    position: relative;
  }

  &__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 5rem;
    height: 5rem;
    background: var(--bulma-scheme-main-bis);
    border-radius: 50%;
    color: var(--bulma-text-weak);
    transition: all 0.3s ease;

    i {
      font-size: 2.5rem;
    }
  }

  &:hover .empty-state__icon {
    transform: scale(1.05);
    box-shadow: var(--dl-shadow-md);
  }

  &__content {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    max-width: 320px;
  }

  &__title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__description {
    font-size: 0.9375rem;
    color: var(--bulma-text-weak);
    line-height: 1.5;
    margin: 0;
  }

  &__actions {
    margin-top: 0.75rem;
  }
}

@keyframes float {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-8px);
  }
}
</style>
