<template>
  <div class="faq-item" :class="{ 'faq-item--open': isOpen }">
    <button
      type="button"
      class="faq-item__question"
      :aria-expanded="isOpen"
      @click="toggle"
    >
      <span class="faq-item__title">{{ question }}</span>
      <i class="faq-item__icon bi" :class="isOpen ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
    </button>
    <div v-show="isOpen" class="faq-item__answer">
      <p>{{ answer }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  question: {
    type: String,
    required: true,
  },
  answer: {
    type: String,
    required: true,
  },
  defaultOpen: {
    type: Boolean,
    default: false,
  },
})

const isOpen = ref(props.defaultOpen)

const toggle = () => {
  isOpen.value = !isOpen.value
}
</script>

<style lang="scss" scoped>
.faq-item {
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius);
  overflow: hidden;
  background: var(--bulma-scheme-main);

  &__question {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    padding: 1rem;
    border: none;
    background: transparent;
    cursor: pointer;
    text-align: left;
    gap: 1rem;
    transition: background-color 0.15s;

    &:hover {
      background: var(--bulma-scheme-main-bis);
    }

    &:focus-visible {
      outline: 2px solid var(--bulma-link);
      outline-offset: -2px;
    }
  }

  &__title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
    line-height: 1.4;
  }

  &__icon {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    flex-shrink: 0;
    transition: transform 0.2s;
  }

  &__answer {
    padding: 0 1rem 1rem;

    p {
      font-size: 0.875rem;
      color: var(--bulma-text);
      line-height: 1.6;
      margin: 0;
    }
  }

  &--open {
    .faq-item__question {
      background: var(--bulma-scheme-main-bis);
    }

    .faq-item__icon {
      color: var(--bulma-link);
    }
  }
}
</style>
