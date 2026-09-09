<template>
  <div
    class="social-links"
    :class="{
      'social-links--horizontal': horizontal,
      'social-links--stacked': !horizontal,
      'social-links--icon-only': iconOnly,
    }"
  >
    <SocialButton
      v-for="(item, index) in items"
      :key="index"
      :network="item.network"
      :url="item.url"
      :icon-only="iconOnly"
      :show-label="!iconOnly"
    />
  </div>
</template>

<script setup>
import SocialButton from './SocialButton.vue'

defineProps({
  items: {
    type: Array,
    required: true,
  },
  horizontal: {
    type: Boolean,
    default: false,
  },
  iconOnly: {
    type: Boolean,
    default: false,
  },
})
</script>

<style lang="scss" scoped>
.social-links {
  &--horizontal {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    flex-direction: row;
  }

  &--stacked {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
  }

  &--icon-only {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;

    &.social-links--stacked {
      flex-direction: row;
    }
  }
}
</style>
