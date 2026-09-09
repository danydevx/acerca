<template>
  <nav class="pagination" :class="[`pagination--${size}`, { 'pagination--rounded': rounded }]" role="navigation" aria-label="pagination">
    <a
      v-if="showPrevNext"
      class="pagination-previous"
      :class="{ 'is-disabled': modelValue === 1 }"
      @click.prevent="setPage(modelValue - 1)"
    >
      <i class="bi bi-chevron-left"></i>
    </a>

    <ul class="pagination-list">
      <li v-for="page in visiblePages" :key="page">
        <span v-if="page === '...'" class="pagination-ellipsis">&hellip;</span>
        <a
          v-else
          class="pagination-link"
          :class="{ 'is-current': page === modelValue }"
          @click.prevent="setPage(page)"
        >{{ page }}</a>
      </li>
    </ul>

    <a
      v-if="showPrevNext"
      class="pagination-next"
      :class="{ 'is-disabled': modelValue === totalPages }"
      @click.prevent="setPage(modelValue + 1)"
    >
      <i class="bi bi-chevron-right"></i>
    </a>
  </nav>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: { type: Number, default: 1 },
  totalPages: { type: Number, default: 10 },
  maxVisible: { type: Number, default: 7 },
  size: { type: String, default: 'default', validator: (v) => ['small', 'default', 'medium', 'large'].includes(v) },
  rounded: { type: Boolean, default: false },
  showPrevNext: { type: Boolean, default: true },
})

const emit = defineEmits(['update:modelValue'])

const visiblePages = computed(() => {
  const { modelValue: current, totalPages: total, maxVisible } = props

  if (total <= maxVisible) {
    return Array.from({ length: total }, (_, i) => i + 1)
  }

  const pages = []

  if (current <= 4) {
    for (let i = 1; i <= 5; i++) pages.push(i)
    pages.push('...')
    pages.push(total)
  } else if (current >= total - 3) {
    pages.push(1)
    pages.push('...')
    for (let i = total - 4; i <= total; i++) pages.push(i)
  } else {
    pages.push(1)
    pages.push('...')
    for (let i = current - 1; i <= current + 1; i++) pages.push(i)
    pages.push('...')
    pages.push(total)
  }

  return pages
})

const setPage = (page) => {
  if (page < 1 || page > props.totalPages || page === props.modelValue) return
  emit('update:modelValue', page)
}
</script>

<style lang="scss" scoped>
.pagination {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;

  &--small { font-size: 0.75rem; }
  &--large { font-size: 1.25rem; }

  &-previous,
  &-next {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 2.5rem;
    height: 2.5rem;
    padding: 0 0.75rem;
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius);
    color: var(--bulma-text);
    text-decoration: none;
    cursor: pointer;
    transition: all 150ms;

    &:hover:not(.is-disabled) {
      border-color: var(--bulma-link);
      color: var(--bulma-link);
    }

    &.is-disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }
  }

  &-rounded {
    .pagination-previous,
    .pagination-next,
    .pagination-link {
      border-radius: 9999px;
    }
  }

  &-list {
    display: flex;
    align-items: center;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 0.25rem;
  }

  &-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 2.5rem;
    height: 2.5rem;
    padding: 0 0.75rem;
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius);
    color: var(--bulma-text);
    text-decoration: none;
    cursor: pointer;
    transition: all 150ms;

    &:hover:not(.is-current) {
      border-color: var(--bulma-link);
      color: var(--bulma-link);
    }

    &.is-current {
      background: var(--bulma-link);
      border-color: var(--bulma-link);
      color: var(--bulma-link-invert);
      cursor: default;
    }
  }

  &-ellipsis {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 2.5rem;
    height: 2.5rem;
    color: var(--bulma-text-weak);
  }
}
</style>
