<template>
  <div class="playground-section">
    <div class="box">
      <h3 class="title is-4">Callout</h3>
      <div class="columns is-multiline">
        <div class="column is-6">
          <UiCallout type="info" title="Info Callout">
            This is an informational callout for important notices.
          </UiCallout>
        </div>
        <div class="column is-6">
          <UiCallout type="success" title="Success Callout">
            Operation completed successfully.
          </UiCallout>
        </div>
        <div class="column is-6">
          <UiCallout type="warning" title="Warning Callout">
            Please review your settings before proceeding.
          </UiCallout>
        </div>
        <div class="column is-6">
          <UiCallout type="danger" title="Danger Callout">
            This action cannot be undone.
          </UiCallout>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Empty State</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <UiEmptyState
            title="No items found"
            message="There are no items to display at this time."
          />
        </div>
        <div class="column is-4">
          <UiEmptyState
            title="No results"
            message="Try adjusting your search or filters."
            icon="search"
          />
        </div>
        <div class="column is-4">
          <UiEmptyState
            title="No notifications"
            message="You're all caught up!"
            icon="bell"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Skeleton Loaders</h3>
      <div class="columns is-multiline">
        <div class="column is-3">
          <UiSkeleton width="100%" height="100px" />
          <p class="mt-2">Rectangle</p>
        </div>
        <div class="column is-3">
          <UiSkeleton width="100px" height="100px" type="circle" />
          <p class="mt-2">Circle</p>
        </div>
        <div class="column is-6">
          <UiSkeleton width="100%" height="60px" type="text" :lines="2" />
          <p class="mt-2">Text Lines</p>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Toast Notifications</h3>
      <div class="buttons">
        <button class="button is-success" @click="showToast('success')">Success Toast</button>
        <button class="button is-danger" @click="showToast('error')">Error Toast</button>
        <button class="button is-warning" @click="showToast('warning')">Warning Toast</button>
        <button class="button is-info" @click="showToast('info')">Info Toast</button>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Progress Bars</h3>
      <div class="mb-4">
        <UiProgress :value="25" max="100" type="primary" show-value />
        <p class="is-size-7 mt-1">Primary - 25%</p>
      </div>
      <div class="mb-4">
        <UiProgress :value="50" max="100" type="success" />
        <p class="is-size-7 mt-1">Success - 50%</p>
      </div>
      <div class="mb-4">
        <UiProgress :value="75" max="100" type="warning" />
        <p class="is-size-7 mt-1">Warning - 75%</p>
      </div>
      <div class="mb-4">
        <UiProgress :value="90" max="100" type="danger" />
        <p class="is-size-7 mt-1">Danger - 90%</p>
      </div>
      <div class="mb-4">
        <UiProgress :value="100" max="100" type="info" />
        <p class="is-size-7 mt-1">Info - 100%</p>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Spinners</h3>
      <div class="level">
        <div class="level-item has-text-centered">
          <UiSpinner size="sm" />
          <p class="mt-2">Small</p>
        </div>
        <div class="level-item has-text-centered">
          <UiSpinner size="md" />
          <p class="mt-2">Medium</p>
        </div>
        <div class="level-item has-text-centered">
          <UiSpinner size="lg" />
          <p class="mt-2">Large</p>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Notifications</h3>
      <UiNotification type="info" title="Information">
        This is an informational notification.
      </UiNotification>
      <UiNotification type="success" title="Success" dismissible>
        Your profile has been updated successfully.
      </UiNotification>
      <UiNotification type="warning" title="Warning" dismissible>
        Please complete all required fields.
      </UiNotification>
      <UiNotification type="danger" title="Error" dismissible>
        Something went wrong. Please try again.
      </UiNotification>
    </div>

    <div class="box">
      <h3 class="title is-4">Notification Banners</h3>
      <UiNotificationBanner type="info" title="Scheduled Maintenance">
        System will be under maintenance on Sunday at 2:00 AM.
      </UiNotificationBanner>
      <UiNotificationBanner type="success" title="New Feature Available" dismissible>
        Check out our new dashboard analytics.
      </UiNotificationBanner>
      <UiNotificationBanner type="warning" title="Security Update Required" dismissible>
        Please update your password immediately.
      </UiNotificationBanner>
      <UiNotificationBanner type="danger" title="Service Disruption" dismissible>
        Some features may be temporarily unavailable.
      </UiNotificationBanner>
    </div>

    <div class="box">
      <h3 class="title is-4">Interactive Progress</h3>
      <div class="mb-3">
        <UiProgress :value="progressValue" max="100" type="primary" show-value />
      </div>
      <div class="buttons">
        <button class="button is-small" @click="progressValue = Math.max(0, progressValue - 10)">-10</button>
        <button class="button is-small" @click="progressValue = Math.min(100, progressValue + 10)">+10</button>
        <button class="button is-small is-warning" @click="progressValue = 50">Reset 50%</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import UiCallout from '@/Components/Ui/Callout.vue'
import UiEmptyState from '@/Components/Ui/EmptyState.vue'
import UiSkeleton from '@/Components/Ui/Skeleton.vue'
import UiToast from '@/Components/Ui/Toast.vue'
import UiProgress from '@/Components/Ui/UiProgress.vue'
import UiSpinner from '@/Components/Ui/UiSpinner.vue'
import UiNotification from '@/Components/Ui/Notification.vue'
import UiNotificationBanner from '@/Components/Ui/NotificationBanner.vue'

const progressValue = ref(35)

const showToast = (type) => {
  const messages = {
    success: 'Changes saved successfully!',
    error: 'Failed to save changes.',
    warning: 'Your session will expire soon.',
    info: 'New update available.'
  }
  alert(messages[type])
}
</script>

<style lang="scss" scoped>
.playground-section {
  padding: 1rem 0;
}

.mb-4 {
  margin-bottom: 1.5rem;
}
</style>
