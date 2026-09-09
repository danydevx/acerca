<template>
  <div class="ui-notification-center dl-bulma-notification-center">
    <div v-if="notifications.length === 0" class="ui-notification-center__empty has-text-centered py-6 px-4">
      <div class="ui-notification-center__empty-icon is-size-1 has-text-grey">
        <i class="bi bi-bell-slash"></i>
      </div>
      <p class="ui-notification-center__empty-title is-size-6 has-text-weight-semibold">{{ emptyTitle }}</p>
      <p v-if="emptyMessage" class="ui-notification-center__empty-message is-size-7 has-text-grey">{{ emptyMessage }}</p>
    </div>

    <div v-else>
      <div v-for="(group, groupIndex) in groupedNotifications" :key="groupIndex" class="ui-notification-center__group">
        <h4 v-if="group.label" class="ui-notification-center__group-label is-size-7 has-text-weight-semibold is-uppercase">{{ group.label }}</h4>
        <div class="ui-notification-center__list is-flex is-flex-direction-column">
          <div
            v-for="(notification, index) in group.items"
            :key="index"
            class="ui-notification-center__item is-flex is-align-items-flex-start is-gap-3 p-3 px-4"
            :class="{ 'ui-notification-center__item--unread': notification.unread }"
          >
            <div v-if="notification.avatar" class="ui-notification-center__avatar is-flex-shrink-0">
              <img :src="notification.avatar" :alt="notification.title" class="image is-48x48">
            </div>
            <div v-else-if="notification.icon" class="ui-notification-center__icon is-flex is-justify-content-center is-align-items-center" :style="iconStyle(notification.tone)">
              <i :class="notification.icon + ' is-size-4'"></i>
            </div>
            <div class="ui-notification-center__content is-flex-grow-1">
              <div class="ui-notification-center__header is-flex is-justify-content-space-between is-align-items-center is-gap-2">
                <span class="ui-notification-center__title is-size-6 has-text-weight-semibold">{{ notification.title }}</span>
                <span class="ui-notification-center__time is-size-7 has-text-grey is-flex-shrink-0">{{ notification.time }}</span>
              </div>
              <p class="ui-notification-center__message is-size-7 has-text-grey mt-1">{{ notification.message }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  notifications: {
    type: Array,
    default: () => [],
  },
  emptyTitle: {
    type: String,
    default: 'No notifications yet',
  },
  emptyMessage: {
    type: String,
    default: "We'll notify you when something happens",
  },
})

const groupedNotifications = computed(() => {
  const groups = []
  const today = []
  const yesterday = []
  const older = []

  props.notifications.forEach((notif) => {
    if (notif.dateGroup === 'today') {
      today.push(notif)
    } else if (notif.dateGroup === 'yesterday') {
      yesterday.push(notif)
    } else {
      older.push(notif)
    }
  })

  if (today.length) groups.push({ label: 'Today', items: today })
  if (yesterday.length) groups.push({ label: 'Yesterday', items: yesterday })
  if (older.length) groups.push({ label: 'Older', items: older })

  return groups
})

const iconStyle = (tone) => {
  const toneMap = {
    info: { bgVar: '--bulma-info', colorVar: '--bulma-info' },
    success: { bgVar: '--bulma-success', colorVar: '--bulma-success' },
    warning: { bgVar: '--bulma-warning', colorVar: '--bulma-warning' },
    danger: { bgVar: '--bulma-danger', colorVar: '--bulma-danger' },
    neutral: { bgVar: '--bulma-scheme-main-bis', colorVar: '--bulma-text-weak' },
  }
  const config = toneMap[tone] || toneMap.neutral
  return {
    background: `color-mix(in oklch, var(${config.bgVar}) 15%, var(--bulma-scheme-main))`,
    color: `var(${config.colorVar})`,
  }
}
</script>

<style lang="scss" scoped>
.ui-notification-center {
  &__empty {
    color: var(--bulma-text-weak);
  }

  &__empty-title {
    color: var(--bulma-text);
    margin: 0 0 0.5rem;
  }

  &__empty-message {
    margin: 0;
  }

  &__group {
    &:not(:last-child) {
      margin-bottom: 1.5rem;
    }
  }

  &__group-label {
    color: var(--bulma-text-weak);
    margin: 0 0 0.75rem;
    padding: 0 1rem;
  }

  &__item {
    transition: background-color 0.15s;
    cursor: pointer;

    &:hover {
      background: var(--bulma-scheme-main-bis);
    }

    &--unread {
      background: color-mix(in oklch, var(--bulma-info) 10%, var(--bulma-scheme-main));

      &:hover {
        background: color-mix(in oklch, var(--bulma-info) 15%, var(--bulma-scheme-main));
      }
    }
  }

  &__icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
  }

  &__title {
    color: var(--bulma-text);
  }

  &__message {
    margin: 0.25rem 0 0;
  }
}
</style>
