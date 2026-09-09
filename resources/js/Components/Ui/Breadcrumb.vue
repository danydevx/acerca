<template>
  <nav class="breadcrumb" :class="{ 'breadcrumb--separator': separator, 'breadcrumb--rtl': rtl }" aria-label="breadcrumbs">
    <slot>
      <ul class="breadcrumb__list">
        <li v-for="(item, index) in items" :key="index" class="breadcrumb__item" :class="{ 'is-active': index === items.length - 1 }">
          <a v-if="index < items.length - 1" :href="item.href || '#'" class="breadcrumb__link" @click.prevent="$emit('click', item, index)">
            <span v-if="item.icon" class="breadcrumb__icon"><i :class="item.icon"></i></span>
            {{ item.label }}
          </a>
          <span v-else class="breadcrumb__current">
            <span v-if="item.icon" class="breadcrumb__icon"><i :class="item.icon"></i></span>
            {{ item.label }}
          </span>
          <span v-if="index < items.length - 1" class="breadcrumb__separator-icon">
            <i :class="separatorIcon"></i>
          </span>
        </li>
      </ul>
    </slot>
  </nav>
</template>

<script setup>
defineProps({
  items: { type: Array, default: () => [] },
  separator: { type: String, default: 'arrow' },
  separatorIcon: { type: String, default: 'bi bi-chevron-right' },
  rtl: { type: Boolean, default: false },
})

defineEmits(['click'])
</script>

<style lang="scss" scoped>
.breadcrumb {
  &__list {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    list-style: none;
    margin: 0;
    padding: 0;
    font-size: 0.875rem;
  }

  &__item {
    display: flex;
    align-items: center;

    &:not(.is-active) {
      color: var(--bulma-link);
    }

    &.is-active .breadcrumb__current {
      color: var(--bulma-text-weak);
    }
  }

  &__link {
    color: var(--bulma-link);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.25rem;

    &:hover {
      color: var(--bulma-link-hover);
    }
  }

  &__current {
    color: var(--bulma-text-weak);
    display: flex;
    align-items: center;
    gap: 0.25rem;
  }

  &__icon {
    display: inline-flex;

    i {
      font-size: 0.75rem;
    }
  }

  &__separator-icon {
    display: inline-flex;
    margin: 0 0.5rem;
    color: var(--bulma-text-weak);

    i {
      font-size: 0.625rem;
    }
  }

  &--separator {
    .breadcrumb__list {
      gap: 0.5rem;
    }

    .breadcrumb__item:not(:last-child)::after {
      content: '';
      display: block;
      width: 0;
      height: 0;
      border-top: 4px solid transparent;
      border-bottom: 4px solid transparent;
      border-left: 6px solid var(--bulma-text-weak);
      margin-left: 0.5rem;
    }

    .breadcrumb__separator-icon {
      display: none;
    }
  }

  &--rtl {
    direction: rtl;

    .breadcrumb__item {
      flex-direction: row-reverse;
    }

    .breadcrumb__link,
    .breadcrumb__current {
      flex-direction: row-reverse;
    }
  }
}
</style>
