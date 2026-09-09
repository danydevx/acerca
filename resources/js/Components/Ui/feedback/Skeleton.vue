<template>
  <div class="skeleton" :class="[`skeleton--${variant}`]" :style="customStyle"></div>
</template>

<script setup>
const props = defineProps({
  variant: {
    type: String,
    default: 'text',
    validator: (v) => ['text', 'title', 'avatar', 'avatar-sm', 'avatar-lg', 'thumbnail', 'rect', 'circle', 'circle-sm', 'circle-lg', 'button', 'badge', 'card', 'image'].includes(v),
  },
  width: {
    type: String,
    default: null,
  },
  height: {
    type: String,
    default: null,
  },
  borderRadius: {
    type: String,
    default: null,
  },
})

const customStyle = {
  width: props.width || undefined,
  height: props.height || undefined,
  borderRadius: props.borderRadius || undefined,
}
</script>

<style lang="scss" scoped>
.skeleton {
  background: linear-gradient(
    90deg,
    var(--bulma-scheme-main-bis) 25%,
    var(--bulma-scheme-main-ter) 50%,
    var(--bulma-scheme-main-bis) 75%
  );
  background-size: 200% 100%;
  animation: skeleton-loading 1.5s ease-in-out infinite;
  border-radius: var(--bulma-radius);

  &--text {
    height: 1rem;
    width: 100%;
    border-radius: var(--bulma-radius-small);
  }

  &--title {
    height: 1.5rem;
    width: 60%;
    border-radius: var(--bulma-radius-small);
  }

  &--avatar {
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
  }

  &--avatar-sm {
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
  }

  &--avatar-lg {
    width: 4.5rem;
    height: 4.5rem;
    border-radius: 50%;
  }

  &--thumbnail {
    width: 5rem;
    height: 5rem;
    border-radius: var(--bulma-radius);
  }

  &--rect {
    border-radius: var(--bulma-radius);
  }

  &--circle {
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
  }

  &--circle-sm {
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 50%;
  }

  &--circle-lg {
    width: 5rem;
    height: 5rem;
    border-radius: 50%;
  }

  &--button {
    height: 2.5rem;
    width: 6rem;
    border-radius: var(--bulma-radius);
  }

  &--badge {
    height: 1.5rem;
    width: 4rem;
    border-radius: var(--bulma-radius-rounded);
  }

  &--card {
    width: 100%;
    height: 200px;
    border-radius: var(--bulma-radius-large);
  }

  &--image {
    width: 100%;
    aspect-ratio: 16 / 9;
    border-radius: var(--bulma-radius-large);
  }
}

@keyframes skeleton-loading {
  0% {
    background-position: 200% 0;
  }
  100% {
    background-position: -200% 0;
  }
}
</style>
