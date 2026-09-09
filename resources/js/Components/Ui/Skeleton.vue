<template>
  <div class="ui-skeleton dl-bulma-skeleton" :class="[`dl-bulma-skeleton--${variant}`]" :style="skeletonStyle"></div>
</template>

<script setup>
const props = defineProps({
  variant: { type: String, default: 'text' },
  width: { type: String, default: null },
  height: { type: String, default: null },
})

const skeletonStyle = {
  width: props.width || undefined,
  height: props.height || undefined,
}
</script>

<style lang="scss" scoped>
.ui-skeleton {
  border-radius: 4px;
}

.dl-bulma-skeleton {
  background: linear-gradient(
    90deg,
    var(--bulma-scheme-main-bis) 25%,
    var(--bulma-scheme-main-ter) 50%,
    var(--bulma-scheme-main-bis) 75%
  );
  background-size: 200% 100%;
  animation: dl-bulma-skeleton-loading 1.5s infinite;

  &--text {
    height: 1rem;
    width: 100%;
    border-radius: 4px;
  }

  &--title {
    height: 1.5rem;
    width: 60%;
    border-radius: 4px;
  }

  &--avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
  }

  &--thumbnail {
    width: 80px;
    height: 80px;
    border-radius: 8px;
  }

  &--rect {
    border-radius: 8px;
  }

  &--circle {
    border-radius: 50%;
  }
}

@keyframes dl-bulma-skeleton-loading {
  0% {
    background-position: 200% 0;
  }
  100% {
    background-position: -200% 0;
  }
}
</style>
