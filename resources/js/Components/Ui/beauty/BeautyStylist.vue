<template>
  <article class="beauty-stylist" :class="{ 'beauty-stylist--selected': selected }">
    <div class="beauty-stylist__avatar">
      <img v-if="stylist.avatar" :src="stylist.avatar" :alt="stylist.name">
      <div v-else class="beauty-stylist__placeholder">
        <i class="bi bi-person"></i>
      </div>
    </div>

    <div class="beauty-stylist__content">
      <h4 class="beauty-stylist__name">{{ stylist.name }}</h4>
      <p v-if="stylist.title" class="beauty-stylist__title">{{ stylist.title }}</p>
      <div v-if="stylist.tags?.length" class="beauty-stylist__tags">
        <span v-for="tag in stylist.tags.slice(0, 2)" :key="tag" class="beauty-stylist__tag">
          {{ tag }}
        </span>
      </div>
    </div>

    <button
      class="beauty-stylist__select"
      :class="{ 'beauty-stylist__select--selected': selected }"
      type="button"
      @click="$emit('select', stylist)"
    >
      <i :class="selected ? 'bi bi-check-circle-fill' : 'bi bi-circle'"></i>
    </button>
  </article>
</template>

<script setup>
defineProps({
  stylist: {
    type: Object,
    required: true,
    default: () => ({ name: '', avatar: '', title: '', tags: [] }),
  },
  selected: {
    type: Boolean,
    default: false,
  },
})

defineEmits(['select'])
</script>

<style lang="scss" scoped>
.beauty-stylist {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.75rem;
  background: var(--bulma-scheme-main);
  border: 2px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  cursor: pointer;
  transition: all 0.2s;

  &:hover {
    border-color: var(--bulma-primary);
    background: var(--bulma-scheme-main-bis);
  }

  &--selected {
    border-color: var(--bulma-primary);
    background: color-mix(in oklch, var(--bulma-primary) 5%, var(--bulma-scheme-main));
  }

  &__avatar {
    width: 3.5rem;
    height: 3.5rem;
    border-radius: 50%;
    overflow: hidden;
    background: var(--bulma-scheme-main-bis);
    flex-shrink: 0;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;

    i {
      font-size: 1.75rem;
      color: var(--bulma-text-weak);
    }
  }

  &__content {
    flex: 1;
    min-width: 0;
  }

  &__name {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__title {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    margin: 0.125rem 0 0;
  }

  &__tags {
    display: flex;
    gap: 0.25rem;
    margin-top: 0.375rem;
  }

  &__tag {
    font-size: 0.625rem;
    padding: 0.125rem 0.375rem;
    background: var(--bulma-scheme-main-ter);
    color: var(--bulma-text-weak);
    border-radius: var(--bulma-radius-small);
  }

  &__select {
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: none;
    border: none;
    cursor: pointer;
    flex-shrink: 0;

    i {
      font-size: 1.5rem;
      color: var(--bulma-border);
      transition: color 0.2s;
    }

    &:hover i {
      color: var(--bulma-primary);
    }

    &--selected i {
      color: var(--bulma-primary);
    }
  }
}
</style>
