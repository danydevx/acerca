<template>
  <div
    class="ui-tabs dl-bulma-tabs"
    :class="[
      `dl-bulma-tabs--${variant}`,
      { 'dl-bulma-tabs--stretch': stretch }
    ]"
  >
    <div
      class="dl-bulma-tabs__list"
      role="tablist"
    >
      <button
        v-for="(item, index) in items"
        :key="item.value"
        class="dl-bulma-tabs__item"
        :class="{ 'is-active': modelValue === item.value }"
        role="tab"
        :aria-selected="modelValue === item.value"
        @click="select(item.value)"
        @keydown="handleKeydown($event, index)"
      >
        {{ item.label }}
      </button>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  items: {
    type: Array,
    required: true
  },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'pill', 'underline'].includes(v)
  },
  stretch: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['update:modelValue', 'change'])

const select = (value) => {
  emit('update:modelValue', value)
  emit('change', value)
}

const handleKeydown = (e, index) => {
  const len = props.items.length

  if (e.key === 'ArrowRight') {
    e.preventDefault()
    const next = (index + 1) % len
    emit('update:modelValue', props.items[next].value)
  } else if (e.key === 'ArrowLeft') {
    e.preventDefault()
    const prev = (index - 1 + len) % len
    emit('update:modelValue', props.items[prev].value)
  } else if (e.key === 'Home') {
    e.preventDefault()
    emit('update:modelValue', props.items[0].value)
  } else if (e.key === 'End') {
    e.preventDefault()
    emit('update:modelValue', props.items[len - 1].value)
  }
}
</script>

<style lang="scss" scoped>
.dl-bulma-tabs {
  &__list {
    display: flex;
    gap: 0.25rem;
  }

  &--stretch {
    .dl-bulma-tabs__list {
      width: 100%;

      .dl-bulma-tabs__item {
        flex: 1;
      }
    }
  }

  &--default {
    .dl-bulma-tabs__list {
      background: var(--bulma-scheme-main-bis);
      border-radius: 8px;
      padding: 4px;
    }

    .dl-bulma-tabs__item {
      padding: 0.5rem 1rem;
      border-radius: 6px;
      border: none;
      background: transparent;
      color: var(--bulma-text-weak);
      cursor: pointer;
      font-size: 0.875rem;
      font-weight: 500;
      transition: all 0.2s;

      &:hover:not(.is-active) {
        color: var(--bulma-text);
      }

      &.is-active {
        background: var(--bulma-scheme-main);
        color: var(--bulma-text);
        box-shadow: 0 1px 3px oklch(0 0 0 / 0.1);
      }
    }
  }

  &--pill {
    .dl-bulma-tabs__list {
      gap: 0;
    }

    .dl-bulma-tabs__item {
      padding: 0.5rem 1rem;
      border-radius: 9999px;
      border: none;
      background: transparent;
      color: var(--bulma-text-weak);
      cursor: pointer;
      font-size: 0.875rem;
      font-weight: 500;
      transition: all 0.2s;

      &:hover:not(.is-active) {
        color: var(--bulma-text);
        background: var(--bulma-scheme-main-bis);
      }

      &.is-active {
        background: var(--bulma-link);
        color: var(--bulma-link-invert);
      }
    }
  }

  &--underline {
    .dl-bulma-tabs__list {
      gap: 0;
      border-bottom: 1px solid var(--bulma-border);
    }

    .dl-bulma-tabs__item {
      padding: 0.75rem 1rem;
      border-radius: 0;
      border: none;
      background: transparent;
      color: var(--bulma-text-weak);
      cursor: pointer;
      font-size: 0.875rem;
      font-weight: 500;
      transition: all 0.2s;
      border-bottom: 2px solid transparent;
      margin-bottom: -1px;

      &:hover:not(.is-active) {
        color: var(--bulma-text);
      }

      &.is-active {
        color: var(--bulma-link);
        border-bottom-color: var(--bulma-link);
      }
    }
  }
}
</style>
