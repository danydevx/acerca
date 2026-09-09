<template>
  <div class="ui-list dl-bulma-list" :class="[`dl-bulma-list--${variant}`]">
    <div
      v-for="(item, index) in items"
      :key="index"
      class="dl-bulma-list__item"
      :class="{
        'dl-bulma-list__item--interactive': interactive || item.onClick,
        'dl-bulma-list__item--disabled': item.disabled,
      }"
      :tabindex="item.disabled ? -1 : 0"
      @click="!item.disabled && item.onClick && item.onClick(item)"
      @keydown.enter="!item.disabled && item.onClick && item.onClick(item)"
    >
      <div v-if="item.avatar || item.icon" class="dl-bulma-list__leading">
        <img
          v-if="item.avatar && !item.avatar.startsWith('bi ')"
          :src="item.avatar"
          class="dl-bulma-list__avatar"
          :alt="item.title"
        >
        <span v-else-if="item.icon" class="dl-bulma-list__icon">
          <i :class="item.icon" aria-hidden="true"></i>
        </span>
      </div>
      <div class="dl-bulma-list__content">
        <div class="dl-bulma-list__title">{{ item.title }}</div>
        <div v-if="item.subtitle" class="dl-bulma-list__subtitle">{{ item.subtitle }}</div>
      </div>
      <div v-if="item.badge || $slots.trailing" class="dl-bulma-list__trailing">
        <span v-if="item.badge" class="dl-bulma-list__badge" :class="`dl-bulma-list__badge--${item.badgeType}`">
          {{ item.badge }}
        </span>
        <slot name="trailing" :item="item"></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  items: {
    type: Array,
    default: () => [],
  },
  variant: {
    type: String,
    default: 'default',
    validator: (val) => ['default', 'divided', 'inset'].includes(val),
  },
  interactive: {
    type: Boolean,
    default: false,
  },
})
</script>

<style lang="scss" scoped>
.ui-list {
  background: var(--bulma-scheme-main);
}

.dl-bulma-list {
  &--divided {
    .dl-bulma-list__item {
      border-bottom: 1px solid var(--bulma-border);

      &:last-child {
        border-bottom: none;
      }
    }
  }

  &--inset {
    .dl-bulma-list__item {
      padding-left: 0.75rem;
    }
  }

  &__item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;

    &--interactive {
      cursor: pointer;
      transition: background-color 0.15s;

      &:hover:not(.dl-bulma-list__item--disabled) {
        background: var(--bulma-scheme-main-bis);
      }

      &:active:not(.dl-bulma-list__item--disabled) {
        background: var(--bulma-scheme-main-ter);
      }
    }

    &--disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }
  }

  &__leading {
    flex-shrink: 0;
  }

  &__avatar {
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
    object-fit: cover;
  }

  &__icon {
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bulma-text-weak);

    i {
      font-size: 1.25rem;
    }
  }

  &__content {
    flex: 1;
    min-width: 0;
  }

  &__title {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--bulma-text);
  }

  &__subtitle {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    margin-top: 0.125rem;
  }

  &__trailing {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  &__badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 9999px;

    &--success {
      background: color-mix(in oklch, var(--bulma-success) 20%, var(--bulma-scheme-main));
      color: var(--bulma-success);
    }

    &--danger {
      background: color-mix(in oklch, var(--bulma-danger) 20%, var(--bulma-scheme-main));
      color: var(--bulma-danger);
    }

    &--info {
      background: color-mix(in oklch, var(--bulma-info) 20%, var(--bulma-scheme-main));
      color: var(--bulma-info);
    }

    &--warning {
      background: color-mix(in oklch, var(--bulma-warning) 20%, var(--bulma-scheme-main));
      color: var(--bulma-warning);
    }

    &--default {
      background: var(--bulma-scheme-main-bis);
      color: var(--bulma-text-weak);
    }
  }
}
</style>
