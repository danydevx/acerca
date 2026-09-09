<template>
  <div class="profile-avatar">
    <img v-if="src" :src="src" :alt="name">
    <span v-else class="profile-avatar__initials">{{ computedInitials }}</span>
    <span v-if="status" class="profile-avatar__status" :class="[`is-${status}`]"></span>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  src: { type: String, default: '' },
  name: { type: String, required: true },
  initials: { type: String, default: '' },
  status: { type: String, default: '' },
})

const computedInitials = computed(() => {
  if (props.initials) return props.initials
  if (!props.name) return '?'
  const parts = props.name.split(' ')
  if (parts.length >= 2) {
    return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase()
  }
  return props.name.substring(0, 2).toUpperCase()
})
</script>

<style lang="scss" scoped>
.profile-avatar {
  position: relative;
  width: 80px;
  height: 80px;
  flex-shrink: 0;

  img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
  }
}

.profile-avatar__initials {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background: var(--bulma-primary);
  color: var(--bulma-primary-invert);
  font-size: 1.5rem;
  font-weight: 600;
}

.profile-avatar__status {
  position: absolute;
  bottom: 2px;
  right: 2px;
  width: 16px;
  height: 16px;
  border-radius: 50%;
  border: 2px solid var(--bulma-scheme-main);

  &.is-online { background: var(--bulma-success); }
  &.is-offline { background: var(--bulma-text-weak); }
  &.is-busy { background: var(--bulma-danger); }
  &.is-away { background: var(--bulma-warning); }
}
</style>
