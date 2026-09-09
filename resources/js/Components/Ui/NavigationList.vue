<template>
  <nav class="nav-list" :class="[`nav-list--${variant}`]">
    <slot>
      <ul class="nav-list__items">
        <li v-for="(item, index) in items" :key="index" class="nav-list__item">
          <a
            :href="item.href || '#'"
            class="nav-list__link"
            :class="{ 'is-active': activeIndex === index }"
            @click.prevent="onClick(item, index)"
          >
            <span v-if="item.icon" class="nav-list__icon"><i :class="item.icon"></i></span>
            <span class="nav-list__label">{{ item.label }}</span>
            <span v-if="item.badge" class="nav-list__badge" :class="[`is-${item.badgeType || 'primary'}`]">
              {{ item.badge }}
            </span>
          </a>
        </li>
      </ul>
    </slot>
  </nav>
</template>

<script setup>
defineProps({
  items: { type: Array, default: () => [] },
  variant: { type: String, default: 'default' },
  activeIndex: { type: Number, default: -1 },
})

const emit = defineEmits(['click'])

const onClick = (item, index) => {
  emit('click', item, index)
}
</script>

<style lang="scss" scoped>
.nav-list {
  &__items {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  &__item {
    &:not(:last-child) {
      border-bottom: 1px solid var(--bulma-border);
    }
  }

  &__link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    color: var(--bulma-text);
    text-decoration: none;
    transition: background 150ms;
    cursor: pointer;

    &:hover {
      background: var(--bulma-scheme-main-bis);
    }

    &.is-active {
      background: color-mix(in oklch, var(--bulma-link) 10%, var(--bulma-scheme-main));
      color: var(--bulma-link);
      border-left: 3px solid var(--bulma-link);
    }
  }

  &__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.5rem;
    color: var(--bulma-text-weak);

    i {
      font-size: 1.125rem;
    }
  }

  &__label {
    flex: 1;
  }

  &__badge {
    padding: 0.125rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;

    &.is-primary {
      background: color-mix(in oklch, var(--bulma-primary) 20%, transparent);
      color: var(--bulma-primary);
    }

    &.is-info {
      background: color-mix(in oklch, var(--bulma-info) 20%, transparent);
      color: var(--bulma-info);
    }

    &.is-danger {
      background: color-mix(in oklch, var(--bulma-danger) 20%, transparent);
      color: var(--bulma-danger);
    }
  }

  &--horizontal {
    .nav-list__items {
      display: flex;
      gap: 0.5rem;
    }

    .nav-list__item {
      border-bottom: none;

      &:not(:last-child) {
        border-bottom: none;
      }
    }

    .nav-list__link {
      padding: 0.5rem 1rem;
      border-radius: var(--bulma-radius);

      &.is-active {
        background: var(--bulma-link);
        color: var(--bulma-link-invert);
        border-left: none;
      }
    }
  }

  &--bordered {
    .nav-list__item:not(:last-child) {
      border-bottom: 1px solid var(--bulma-border);
    }
  }

  &--pills {
    .nav-list__link {
      border-radius: var(--bulma-radius);

      &:hover {
        background: var(--bulma-scheme-main-bis);
      }

      &.is-active {
        background: var(--bulma-link);
        color: var(--bulma-link-invert);
      }
    }
  }
}
</style>
