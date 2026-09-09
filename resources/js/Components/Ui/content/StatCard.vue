<template>
  <div class="stat-card" :class="[`stat-card--${variant}`, { 'stat-card--minimal': minimal }]">
    <div v-if="$slots.icon || icon" class="stat-card__icon">
      <slot name="icon">
        <i :class="icon"></i>
      </slot>
    </div>

    <div class="stat-card__content">
      <div v-if="label" class="stat-card__label">{{ label }}</div>
      <div v-if="value || $slots.value" class="stat-card__value">
        <slot name="value">{{ value }}</slot>
      </div>
      <slot></slot>

      <div v-if="trend || $slots.trend" class="stat-card__trend" :class="trendClass">
        <slot name="trend">
          <i :class="trendIcon"></i>
          <span v-if="trend">{{ trend }}{{ trendIsPercent ? '%' : '' }}</span>
        </slot>
      </div>

      <div v-if="meta" class="stat-card__meta">{{ meta }}</div>
      <div v-if="status" class="stat-card__status" :class="[`is-${statusType}`]">
        <span class="stat-card__status-dot"></span>
        {{ status }}
      </div>
    </div>

    <div v-if="$slots.visual || showVisual" class="stat-card__visual">
      <slot name="visual">
        <div v-if="showVisual && progress !== undefined" class="stat-card__progress">
          <div class="stat-card__progress-bar" :style="{ width: `${progress}%` }"></div>
        </div>
      </slot>
    </div>

    <div v-if="$slots.actions" class="stat-card__actions">
      <slot name="actions"></slot>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  label: { type: String, default: '' },
  value: { type: [String, Number], default: '' },
  icon: { type: String, default: '' },
  trend: { type: [String, Number], default: null },
  trendIsPercent: { type: Boolean, default: true },
  meta: { type: String, default: '' },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'primary', 'success', 'warning', 'danger', 'info'].includes(v),
  },
  trendDirection: {
    type: String,
    default: 'neutral',
    validator: (v) => ['up', 'down', 'neutral'].includes(v),
  },
  trendSemantic: {
    type: String,
    default: 'neutral',
    validator: (v) => ['positive', 'negative', 'neutral'].includes(v),
  },
  status: { type: String, default: '' },
  statusType: {
    type: String,
    default: 'success',
    validator: (v) => ['success', 'warning', 'danger', 'info'].includes(v),
  },
  minimal: { type: Boolean, default: false },
  showVisual: { type: Boolean, default: false },
  progress: { type: Number, default: 0 },
})

const trendIcon = computed(() => {
  if (props.trendDirection === 'up') return 'bi bi-trend-up'
  if (props.trendDirection === 'down') return 'bi bi-trend-down'
  return 'bi bi-minus'
})

const trendClass = computed(() => {
  if (props.trendSemantic !== 'neutral') {
    return `stat-card__trend--${props.trendSemantic}`
  }
  return `stat-card__trend--${props.trendDirection === 'up' ? 'positive' : props.trendDirection === 'down' ? 'negative' : 'neutral'}`
})
</script>

<style lang="scss" scoped>
.stat-card {
  display: flex;
  flex-direction: column;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  padding: 1rem;
  gap: 0.5rem;

  &--minimal {
    padding: 0.5rem;
    border: none;
    background: transparent;
  }

  &__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 3rem;
    height: 3rem;
    border-radius: var(--bulma-radius);
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text-weak);
    margin-bottom: 0.5rem;

    i {
      font-size: 1.5rem;
    }
  }

  &__content {
    flex: 1;
  }

  &__label {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    line-height: 1.4;
  }

  &__value {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--bulma-text);
    line-height: 1.1;
    font-variant-numeric: tabular-nums;
  }

  &__trend {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    margin-top: 0.25rem;

    &--positive {
      color: var(--bulma-success);
    }

    &--negative {
      color: var(--bulma-danger);
    }

    &--neutral {
      color: var(--bulma-text-weak);
    }
  }

  &__meta {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin-top: 0.25rem;
  }

  &__status {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.8125rem;
    font-weight: 500;
    margin-top: 0.375rem;

    &-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
    }

    &.is-success {
      color: var(--bulma-success);
      .stat-card__status-dot { background: var(--bulma-success); }
    }

    &.is-warning {
      color: var(--bulma-warning);
      .stat-card__status-dot { background: var(--bulma-warning); }
    }

    &.is-danger {
      color: var(--bulma-danger);
      .stat-card__status-dot { background: var(--bulma-danger); }
    }

    &.is-info {
      color: var(--bulma-info);
      .stat-card__status-dot { background: var(--bulma-info); }
    }
  }

  &__visual {
    margin-top: 0.5rem;
  }

  &__progress {
    height: 6px;
    background: var(--bulma-border);
    border-radius: 9999px;
    overflow: hidden;
  }

  &__progress-bar {
    height: 100%;
    background: var(--bulma-primary);
    border-radius: 9999px;
    transition: width 300ms ease;
  }

  &__actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 0.5rem;
  }

  &--primary {
    .stat-card__icon {
      background: color-mix(in oklch, var(--bulma-primary) 15%, var(--bulma-scheme-main));
      color: var(--bulma-primary);
    }
  }

  &--success {
    .stat-card__icon {
      background: color-mix(in oklch, var(--bulma-success) 15%, var(--bulma-scheme-main));
      color: var(--bulma-success);
    }
  }

  &--warning {
    .stat-card__icon {
      background: color-mix(in oklch, var(--bulma-warning) 15%, var(--bulma-scheme-main));
      color: var(--bulma-warning);
    }
  }

  &--danger {
    .stat-card__icon {
      background: color-mix(in oklch, var(--bulma-danger) 15%, var(--bulma-scheme-main));
      color: var(--bulma-danger);
    }
  }

  &--info {
    .stat-card__icon {
      background: color-mix(in oklch, var(--bulma-info) 15%, var(--bulma-scheme-main));
      color: var(--bulma-info);
    }
  }
}
</style>
