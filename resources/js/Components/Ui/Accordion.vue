<template>
  <div class="ui-accordion dl-bulma-accordion box">
    <div
      v-for="(item, index) in items"
      :key="item.value"
      class="dl-bulma-accordion__item"
    >
      <div class="dl-bulma-accordion__header">
        <button
          class="dl-bulma-accordion__trigger is-flex is-justify-content-space-between is-align-items-center"
          :aria-expanded="isOpen(item.value)"
          :aria-controls="`accordion-content-${index}`"
          @click="toggle(item.value)"
        >
          <span class="dl-bulma-accordion__title is-size-6 has-text-weight-medium">{{ item.title }}</span>
          <span class="dl-bulma-accordion__icon" :class="{ 'is-open': isOpen(item.value) }">
            <i class="bi bi-chevron-down"></i>
          </span>
        </button>
      </div>
      <div
        :id="`accordion-content-${index}`"
        class="dl-bulma-accordion__content"
        :class="{ 'is-open': isOpen(item.value) }"
        role="region"
      >
        <div class="dl-bulma-accordion__body pt-4 pb-4" v-html="item.content"></div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  items: {
    type: Array,
    default: () => [],
    validator: (val) => val.every((item) => 'value' in item && 'title' in item && 'content' in item),
  },
  modelValue: {
    type: [String, Array],
    default: null,
  },
  multiple: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['update:modelValue'])

const isOpen = (value) => {
  if (props.multiple) {
    return Array.isArray(props.modelValue) && props.modelValue.includes(value)
  }
  return props.modelValue === value
}

const toggle = (value) => {
  if (props.multiple) {
    const current = Array.isArray(props.modelValue) ? [...props.modelValue] : []
    const index = current.indexOf(value)
    if (index > -1) {
      current.splice(index, 1)
    } else {
      current.push(value)
    }
    emit('update:modelValue', current)
  } else {
    emit('update:modelValue', props.modelValue === value ? null : value)
  }
}
</script>

<style lang="scss" scoped>
.dl-bulma-accordion {
  padding: 0;
  overflow: hidden;

  &__item {
    border-bottom: 1px solid var(--bulma-border);

    &:last-child {
      border-bottom: none;
    }
  }

  &__header {
    background: var(--bulma-scheme-main);
  }

  &__trigger {
    width: 100%;
    background: none;
    border: none;
    cursor: pointer;
    text-align: left;
    color: var(--bulma-text);
    transition: background-color 0.2s;
    padding: 1rem;
    margin: 0;

    &:hover {
      background-color: var(--bulma-scheme-main-bis);
    }

    &:focus-visible {
      outline: 2px solid var(--bulma-link);
      outline-offset: -2px;
    }
  }

  &__title {
    flex: 1;
    padding-right: 0.75rem;
  }

  &__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s ease;
    color: var(--bulma-text-weak);
    font-size: 0.875rem;

    &.is-open {
      transform: rotate(180deg);
    }
  }

  &__content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
    background: var(--bulma-scheme-main-bis);
    padding-left: 1rem;
    padding-right: 1rem;

    &.is-open {
      max-height: 500px;
    }
  }

  &__body {
    color: var(--bulma-text);
    line-height: 1.6;
  }
}
</style>
