<template>
  <div class="timeline" :class="{ 'timeline--compact': compact }">
    <div
      v-for="(item, index) in items"
      :key="index"
      class="timeline__item"
      :class="{ 'timeline__item--last': index === items.length - 1 }"
    >
      <div class="timeline__marker">
        <div
          class="timeline__dot"
          :class="[`timeline__dot--${item.variant || 'default'}`]"
        >
          <i v-if="item.icon" :class="item.icon"></i>
        </div>
        <div v-if="showLine && index < items.length - 1" class="timeline__line"></div>
      </div>
      <div class="timeline__content">
        <div v-if="item.date || item.time" class="timeline__meta">
          <span v-if="item.date" class="timeline__date">{{ formatDate(item.date) }}</span>
          <span v-if="item.time" class="timeline__time">{{ item.time }}</span>
        </div>
        <h4 v-if="item.title" class="timeline__title">{{ item.title }}</h4>
        <p v-if="item.description" class="timeline__description">{{ item.description }}</p>
        <div v-if="$slots.actions" class="timeline__actions">
          <slot name="actions" :item="item" :index="index"></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  items: {
    type: Array,
    required: true,
  },
  compact: {
    type: Boolean,
    default: false,
  },
  showLine: {
    type: Boolean,
    default: true,
  },
})

const formatDate = (date) => {
  if (!date) return ''
  const d = date instanceof Date ? date : new Date(date)
  return d.toLocaleDateString('es-ES', { year: 'numeric', month: 'short', day: 'numeric' })
}
</script>

<style lang="scss" scoped>
.timeline {
  display: flex;
  flex-direction: column;

  &--compact {
    .timeline__dot {
      width: 0.75rem;
      height: 0.75rem;
    }

    .timeline__content {
      padding-top: 0;
    }

    .timeline__title {
      font-size: 0.875rem;
    }

    .timeline__description {
      font-size: 0.8125rem;
    }
  }

  &__item {
    display: flex;
    gap: 1rem;
    position: relative;
  }

  &__marker {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-shrink: 0;
  }

  &__dot {
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bulma-scheme-main-bis);
    border: 2px solid var(--bulma-border);
    z-index: 1;

    i {
      font-size: 0.5rem;
      color: white;
    }

    &--primary {
      background: var(--bulma-link);
      border-color: var(--bulma-link);
    }

    &--success {
      background: var(--bulma-success);
      border-color: var(--bulma-success);
    }

    &--warning {
      background: var(--bulma-warning);
      border-color: var(--bulma-warning);
    }

    &--danger {
      background: var(--bulma-danger);
      border-color: var(--bulma-danger);
    }

    &--active {
      background: var(--bulma-link);
      border-color: var(--bulma-link);
      animation: pulse 2s infinite;
    }
  }

  &__line {
    width: 2px;
    flex: 1;
    min-height: 1.5rem;
    background: var(--bulma-border);
    margin: 0.25rem 0;
  }

  &__content {
    flex: 1;
    padding-bottom: 1.5rem;
    min-width: 0;
  }

  &__meta {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.25rem;
  }

  &__date,
  &__time {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &__time {
    &::before {
      content: '•';
      margin-right: 0.5rem;
    }
  }

  &__title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
    line-height: 1.4;
  }

  &__description {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    line-height: 1.5;
    margin: 0.375rem 0 0;
  }

  &__actions {
    margin-top: 0.75rem;
    display: flex;
    gap: 0.5rem;
  }

  &__item--last &__content {
    padding-bottom: 0;
  }
}

@keyframes pulse {
  0%, 100% {
    box-shadow: 0 0 0 0 color-mix(in oklch, var(--bulma-link) 40%, transparent);
  }
  50% {
    box-shadow: 0 0 0 6px color-mix(in oklch, var(--bulma-link) 0%, transparent);
  }
}
</style>
