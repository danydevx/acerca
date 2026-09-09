<template>
  <div class="ui-list dl-bulma-list" :class="[`dl-bulma-list--${variant}`]">
    <div
      v-for="(item, index) in items"
      :key="index"
      class="dl-bulma-list__item is-flex is-align-items-center is-gap-3 p-3 px-4"
      :class="{
        'dl-bulma-list__item--interactive': interactive || item.onClick,
        'dl-bulma-list__item--disabled': item.disabled,
      }"
      :tabindex="item.disabled ? -1 : 0"
      @click="!item.disabled && item.onClick && item.onClick(item)"
      @keydown.enter="!item.disabled && item.onClick && item.onClick(item)"
    >
      <div v-if="item.avatar || item.icon" class="dl-bulma-list__leading is-flex-shrink-0">
        <img
          v-if="item.avatar && !item.avatar.startsWith('bi ')"
          :src="item.avatar"
          class="dl-bulma-list__avatar image is-48x48"
          :alt="item.title"
        >
        <span v-else-if="item.icon" class="dl-bulma-list__icon is-flex is-justify-content-center is-align-items-center">
          <i :class="item.icon + ' is-size-5'" aria-hidden="true"></i>
        </span>
      </div>
      <div class="dl-bulma-list__content is-flex-grow-1">
        <div class="dl-bulma-list__title is-size-6 has-text-weight-medium">{{ item.title }}</div>
        <div v-if="item.subtitle" class="dl-bulma-list__subtitle is-size-7 has-text-grey">{{ item.subtitle }}</div>
      </div>
      <div v-if="item.badge || $slots.trailing" class="dl-bulma-list__trailing is-flex is-flex-shrink-0 is-align-items-center is-gap-2">
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

  &__avatar {
    border-radius: 50%;
    object-fit: cover;
  }

  &__icon {
    width: 40px;
    height: 40px;
    color: var(--bulma-text-weak);
  }

  &__title {
    color: var(--bulma-text);
  }

  &__subtitle {
    margin-top: 0.125rem;
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
