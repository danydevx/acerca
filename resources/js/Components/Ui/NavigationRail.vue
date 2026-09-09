<template>
  <nav class="nav-rail" :class="{ 'nav-rail--extended': extended }">
    <slot>
      <ul class="nav-rail__items">
        <li v-for="(item, index) in items" :key="index" class="nav-rail__item">
          <a
            :href="item.href || '#'"
            class="nav-rail__link"
            :class="{ 'is-active': activeIndex === index }"
            :title="item.label"
            @click.prevent="onClick(item, index)"
          >
            <span class="nav-rail__icon">
              <i :class="item.icon"></i>
            </span>
            <span v-if="extended" class="nav-rail__label">{{ item.label }}</span>
          </a>
        </li>
      </ul>
    </slot>
  </nav>
</template>

<script setup>
defineProps({
  items: { type: Array, default: () => [] },
  activeIndex: { type: Number, default: 0 },
  extended: { type: Boolean, default: false },
})

const emit = defineEmits(['click'])

const onClick = (item, index) => {
  emit('click', item, index)
}
</script>

<style lang="scss" scoped>
.nav-rail {
  display: flex;
  flex-direction: column;
  width: 4rem;
  background: var(--bulma-scheme-main);
  border-right: 1px solid var(--bulma-border);
  padding: 1rem 0;

  &--extended {
    width: 12rem;
    padding: 1rem 0.5rem;

    .nav-rail__link {
      justify-content: flex-start;
      padding: 0.75rem 1rem;
      gap: 0.75rem;
    }
  }

  &__items {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  &__link {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 0.75rem;
    color: var(--bulma-text-weak);
    text-decoration: none;
    border-radius: var(--bulma-radius);
    transition: all 150ms;
    cursor: pointer;

    &:hover {
      background: var(--bulma-scheme-main-bis);
      color: var(--bulma-text);
    }

    &.is-active {
      background: color-mix(in oklch, var(--bulma-link) 10%, var(--bulma-scheme-main));
      color: var(--bulma-link);
    }
  }

  &__icon {
    display: flex;
    align-items: center;
    justify-content: center;

    i {
      font-size: 1.25rem;
    }
  }

  &__label {
    font-size: 0.875rem;
    font-weight: 500;
    white-space: nowrap;
  }
}
</style>
