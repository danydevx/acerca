<template>
  <Transition name="notification">
    <div
      v-if="visible"
      class="ui-notification dl-bulma-notification is-flex is-align-items-flex-start is-gap-3 p-4"
      :class="[
        `dl-bulma-notification--${tone}`,
        `dl-bulma-notification--${layout}`,
        { 'dl-bulma-notification--unread': unread && !read }
      ]"
      :role="tone === 'danger' ? 'alert' : 'status'"
    >
      <div v-if="avatar || icon" class="dl-bulma-notification__media is-flex-shrink-0">
        <img v-if="avatar" :src="avatar" :alt="title" class="dl-bulma-notification__avatar image is-48x48">
        <span v-else-if="icon" class="dl-bulma-notification__icon is-flex is-justify-content-center is-align-items-center">
          <i :class="icon + ' is-size-4'"></i>
        </span>
      </div>

      <div class="dl-bulma-notification__content is-flex-grow-1">
        <div class="dl-bulma-notification__header is-flex is-justify-content-space-between is-align-items-center is-gap-2">
          <div class="dl-bulma-notification__meta is-flex is-align-items-center is-gap-2">
            <span v-if="title" class="dl-bulma-notification__title is-size-6 has-text-weight-semibold">{{ title }}</span>
            <span v-if="time" class="dl-bulma-notification__time is-size-7 has-text-grey">{{ time }}</span>
          </div>
          <span v-if="unread && !read" class="dl-bulma-notification__badge is-flex-shrink-0"></span>
        </div>
        <span v-if="subtitle" class="dl-bulma-notification__subtitle is-size-7 has-text-grey">{{ subtitle }}</span>
        <span v-if="message" class="dl-bulma-notification__message is-size-7">{{ message }}</span>
      </div>

      <div v-if="actions.length" class="dl-bulma-notification__actions is-flex is-gap-2" :class="{ 'is-flex-direction-column': verticalActions }">
        <button
          v-for="(action, index) in actions"
          :key="index"
          class="dl-bulma-notification__action"
          :class="`dl-bulma-notification__action--${action.variant || 'default'}`"
          @click="handleAction(action)"
        >
          {{ action.label }}
        </button>
      </div>

      <button v-if="closable" class="dl-bulma-notification__close" aria-label="Close" @click="$emit('close')">
        <i class="bi bi-x"></i>
      </button>
    </div>
  </Transition>
</template>

<script setup>
defineProps({
  visible: { type: Boolean, default: true },
  title: { type: String, default: '' },
  subtitle: { type: String, default: '' },
  message: { type: String, default: '' },
  time: { type: String, default: '' },
  tone: { type: String, default: 'neutral', validator: (v) => ['neutral', 'info', 'success', 'warning', 'danger'].includes(v) },
  layout: { type: String, default: 'default', validator: (v) => ['default', 'compact', 'full'].includes(v) },
  icon: { type: String, default: '' },
  avatar: { type: String, default: '' },
  actions: { type: Array, default: () => [] },
  closable: { type: Boolean, default: true },
  unread: { type: Boolean, default: false },
  read: { type: Boolean, default: false },
  verticalActions: { type: Boolean, default: false },
})

defineEmits(['close', 'action'])

const handleAction = (action) => {
  if (action.onClick) action.onClick()
}
</script>

<style lang="scss" scoped>
.ui-notification {
  border-radius: 8px;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  position: relative;
}

.dl-bulma-notification {
  &--neutral {
    background: var(--bulma-scheme-main-bis);
    border-color: var(--bulma-border);
  }

  &--info {
    background: color-mix(in oklch, var(--bulma-info) 15%, var(--bulma-scheme-main));
    border-color: color-mix(in oklch, var(--bulma-info) 30%, transparent);

    .dl-bulma-notification__icon { color: var(--bulma-info); }
  }

  &--success {
    background: color-mix(in oklch, var(--bulma-success) 15%, var(--bulma-scheme-main));
    border-color: color-mix(in oklch, var(--bulma-success) 30%, transparent);

    .dl-bulma-notification__icon { color: var(--bulma-success); }
  }

  &--warning {
    background: color-mix(in oklch, var(--bulma-warning) 15%, var(--bulma-scheme-main));
    border-color: color-mix(in oklch, var(--bulma-warning) 30%, transparent);

    .dl-bulma-notification__icon { color: var(--bulma-warning); }
  }

  &--danger {
    background: color-mix(in oklch, var(--bulma-danger) 15%, var(--bulma-scheme-main));
    border-color: color-mix(in oklch, var(--bulma-danger) 30%, transparent);

    .dl-bulma-notification__icon { color: var(--bulma-danger); }
  }

  &--compact {
    padding: 0.75rem 1rem;
  }

  &--full {
    padding: 1.25rem;
  }

  &--unread {
    background: color-mix(in oklch, var(--bulma-info) 10%, var(--bulma-scheme-main));
    border-left: 3px solid var(--bulma-info);
  }

  &__avatar {
    border-radius: 50%;
    object-fit: cover;
  }

  &__icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
  }

  &__title {
    color: var(--bulma-text);
  }

  &__time {
    color: var(--bulma-text-weak);
  }

  &__badge {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--bulma-info);
  }

  &__subtitle {
    display: block;
    color: var(--bulma-text-weak);
    margin-top: 0.125rem;
  }

  &__message {
    display: block;
    color: var(--bulma-text);
    margin-top: 0.25rem;
  }

  &__actions {
    margin-top: 0.75rem;
  }

  &__action {
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    border: 1px solid var(--bulma-border);
    background: var(--bulma-scheme-main);
    cursor: pointer;
    transition: all 0.15s;

    &:hover {
      background: var(--bulma-scheme-main-bis);
    }

    &--primary {
      background: var(--bulma-primary);
      border-color: var(--bulma-primary);
      color: var(--bulma-primary-invert);

      &:hover {
        background: color-mix(in oklch, var(--bulma-primary) 90%, black);
      }
    }

    &--success {
      background: var(--bulma-success);
      border-color: var(--bulma-success);
      color: var(--bulma-success-invert);

      &:hover {
        background: color-mix(in oklch, var(--bulma-success) 90%, black);
      }
    }

    &--danger {
      background: var(--bulma-danger);
      border-color: var(--bulma-danger);
      color: var(--bulma-danger-invert);

      &:hover {
        background: color-mix(in oklch, var(--bulma-danger) 90%, black);
      }
    }
  }

  &__close {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    background: none;
    border: none;
    cursor: pointer;
    color: var(--bulma-text-weak);
    padding: 0.25rem;
    border-radius: 4px;

    &:hover {
      color: var(--bulma-text);
      background: var(--bulma-scheme-main-bis);
    }
  }
}

.notification-enter-active,
.notification-leave-active {
  transition: all 0.3s ease;
}

.notification-enter-from,
.notification-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>
