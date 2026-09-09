<template>
  <div class="hero-identity" :class="{ 'hero-identity--centered': centered }">
    <h1 v-if="name" class="hero-identity__name" :class="nameClass">
      {{ name }}
    </h1>
    <p v-if="title" class="hero-identity__title">{{ title }}</p>
    <p v-if="company" class="hero-identity__company">
      <i v-if="showCompanyIcon" class="hero-identity__company-icon bi bi-building"></i>
      {{ company }}
    </p>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  name: {
    type: String,
    default: '',
  },
  title: {
    type: String,
    default: '',
  },
  company: {
    type: String,
    default: '',
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg', 'xl'].includes(v),
  },
  centered: {
    type: Boolean,
    default: false,
  },
  showCompanyIcon: {
    type: Boolean,
    default: true,
  },
})

const nameClass = computed(() => `hero-identity__name--${props.size}`)
</script>

<style lang="scss" scoped>
.hero-identity {
  &--centered {
    text-align: center;
  }

  &__name {
    margin: 0;
    color: var(--bulma-text);
    line-height: 1.2;

    &--sm {
      font-size: 1.25rem;
      font-weight: 600;
    }

    &--md {
      font-size: 1.5rem;
      font-weight: 700;
    }

    &--lg {
      font-size: 2rem;
      font-weight: 700;
    }

    &--xl {
      font-size: 2.5rem;
      font-weight: 700;
    }
  }

  &__title {
    margin: 0.25rem 0 0;
    font-size: 1rem;
    color: var(--bulma-text-weak);
    font-weight: 500;
  }

  &__company {
    margin: 0.25rem 0 0;
    font-size: 0.875rem;
    color: var(--bulma-link);
    display: flex;
    align-items: center;
    gap: 0.375rem;
  }

  &__company-icon {
    font-size: 0.875rem;
  }
}
</style>
