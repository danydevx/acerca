<template>
  <div class="comment" :class="{ 'comment--nested': nested }">
    <div class="comment__avatar">
      <img v-if="avatar" :src="avatar" :alt="author">
      <span v-else class="comment__avatar-placeholder">{{ initials }}</span>
    </div>

    <div class="comment__body">
      <div class="comment__header">
        <span class="comment__author">{{ author }}</span>
        <span v-if="timestamp" class="comment__timestamp">{{ timestamp }}</span>
      </div>

      <div v-if="verified" class="comment__badge">
        <i class="bi bi-patch-check-fill"></i>
        Verificado
      </div>

      <div class="comment__content">
        <slot>{{ message }}</slot>
      </div>

      <div v-if="$slots.actions || showActions" class="comment__actions">
        <slot name="actions">
          <button v-if="showActions" class="comment__action" @click="$emit('like')">
            <i :class="liked ? 'bi bi-heart-fill' : 'bi bi-heart'"></i>
            <span v-if="likes">{{ likes }}</span>
          </button>
          <button v-if="showActions" class="comment__action" @click="$emit('reply')">
            <i class="bi bi-reply"></i>
            Responder
          </button>
        </slot>
      </div>

      <div v-if="$slots.replies" class="comment__replies">
        <slot name="replies"></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  author: { type: String, default: '' },
  avatar: { type: String, default: '' },
  timestamp: { type: String, default: '' },
  message: { type: String, default: '' },
  verified: { type: Boolean, default: false },
  nested: { type: Boolean, default: false },
  likes: { type: [String, Number], default: null },
  liked: { type: Boolean, default: false },
  showActions: { type: Boolean, default: true },
})

defineEmits(['like', 'reply'])

const initials = computed(() => {
  if (!props.author) return '?'
  return props.author
    .split(' ')
    .map((n) => n[0])
    .slice(0, 2)
    .join('')
    .toUpperCase()
})
</script>

<style lang="scss" scoped>
.comment {
  display: flex;
  gap: 0.75rem;

  &--nested {
    margin-left: 3rem;
    padding-left: 1rem;
    border-left: 2px solid var(--bulma-border);
  }

  &__avatar {
    flex-shrink: 0;

    img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }
  }

  &__avatar-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text-weak);
    font-size: 0.875rem;
    font-weight: 600;
  }

  &__body {
    flex: 1;
    min-width: 0;
  }

  &__header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
  }

  &__author {
    font-weight: 600;
    color: var(--bulma-text);
  }

  &__timestamp {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &__badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--bulma-primary);
    margin-top: 0.125rem;
  }

  &__content {
    margin-top: 0.5rem;
    font-size: 0.9375rem;
    color: var(--bulma-text);
    line-height: 1.5;
  }

  &__actions {
    display: flex;
    gap: 1rem;
    margin-top: 0.5rem;
  }

  &__action {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    background: none;
    border: none;
    padding: 0;
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    cursor: pointer;

    &:hover {
      color: var(--bulma-text);
    }

    i {
      font-size: 1rem;
    }
  }

  &__replies {
    margin-top: 1rem;
  }
}
</style>
