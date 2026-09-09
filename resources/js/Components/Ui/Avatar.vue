<template>
  <div class="ui-avatar dl-bulma-avatar is-inline-flex is-justify-content-center is-align-items-center" :class="sizeClass">
    <img
      v-if="src && !imageError"
      :src="src"
      :alt="alt"
      class="dl-bulma-avatar__image"
      @error="onImageError"
    >
    <span v-else class="dl-bulma-avatar__fallback">{{ initials }}</span>
    <span
      v-if="status"
      class="dl-bulma-avatar__status"
      :class="`dl-bulma-avatar__status--${status}`"
    ></span>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
  src: {
    type: String,
    default: '',
  },
  alt: {
    type: String,
    default: '',
  },
  name: {
    type: String,
    default: '',
  },
  size: {
    type: String,
    default: 'md',
    validator: (val) => ['sm', 'md', 'lg', 'xl'].includes(val),
  },
  status: {
    type: String,
    default: '',
    validator: (val) => ['', 'online', 'offline', 'busy'].includes(val),
  },
})

const imageError = ref(false)

const sizeClass = computed(() => `dl-bulma-avatar--${props.size}`)

const initials = computed(() => {
  if (!props.name) return '?'
  return props.name
    .split(' ')
    .map((n) => n[0])
    .slice(0, 2)
    .join('')
    .toUpperCase()
})

const onImageError = () => {
  imageError.value = true
}
</script>

<style lang="scss" scoped>
.ui-avatar {
  position: relative;
  border-radius: 50%;
  background: var(--bulma-scheme-main-bis);
  color: var(--bulma-text-weak);
  font-weight: 600;
  flex-shrink: 0;
  overflow: visible;
}

.dl-bulma-avatar {
  &--sm {
    width: 32px;
    height: 32px;
    font-size: 0.75rem;
  }

  &--md {
    width: 40px;
    height: 40px;
    font-size: 0.875rem;
  }

  &--lg {
    width: 56px;
    height: 56px;
    font-size: 1rem;
  }

  &--xl {
    width: 80px;
    height: 80px;
    font-size: 1.25rem;
  }

  &__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
  }

  &__fallback {
    line-height: 1;
  }

  &__status {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 25%;
    height: 25%;
    min-width: 8px;
    min-height: 8px;
    border-radius: 50%;
    border: 2px solid var(--bulma-scheme-main);
    box-sizing: content-box;

    &--online {
      background: var(--bulma-success);
    }

    &--offline {
      background: var(--bulma-text-weak);
    }

    &--busy {
      background: var(--bulma-danger);
    }
  }
}
</style>
