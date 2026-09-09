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
      :text-only="textOnly"
      :show-label="true"
      :variant="variant"
      :size="size"
      :color-scheme="colorScheme"
      :layout="layout"
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
  textOnly: {
    type: Boolean,
    default: false,
  },
  layout: {
    type: String,
    default: 'start',
    validator: (v) => ['start', 'end', 'top', 'bottom'].includes(v),
  },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'filled', 'outlined', 'rounded', 'pill', 'soft', 'gradient'].includes(v),
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v),
  },
  colorScheme: {
    type: String,
    default: 'auto',
    validator: (v) => ['auto', 'brand', 'whatsapp', 'facebook', 'instagram', 'linkedin', 'youtube', 'twitter'].includes(v),
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
