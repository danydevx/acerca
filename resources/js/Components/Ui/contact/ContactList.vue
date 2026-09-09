<template>
  <div
    class="contact-list"
    :class="{
      'contact-list--stacked': stacked,
      'contact-list--grid': !stacked,
    }"
  >
    <ContactAction
      v-for="(item, index) in items"
      :key="index"
      :type="item.type"
      :value="item.value"
      :label="item.label"
      :icon-only="iconOnly"
      :primary="item.primary"
      :disabled="item.disabled"
      @click="$emit('action', item)"
    />
  </div>
</template>

<script setup>
import ContactAction from './ContactAction.vue'

defineProps({
  items: {
    type: Array,
    required: true,
  },
  stacked: {
    type: Boolean,
    default: false,
  },
  iconOnly: {
    type: Boolean,
    default: false,
  },
})

defineEmits(['action'])
</script>

<style lang="scss" scoped>
.contact-list {
  &--stacked {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  &--grid {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
  }
}
</style>
