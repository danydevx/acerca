<template>
  <Teleport to="body">
    <template v-for="dialog in dialogs" :key="dialog.id">
      <UiDialog
        v-model="dialog.modelValue"
        :title="dialog.title"
        :description="dialog.description"
        :tone="dialog.tone"
        :icon="dialog.icon"
        :size="dialog.size"
        :close-on-backdrop="dialog.closeOnBackdrop"
        :dismissible="dialog.dismissible"
        :vertical-actions="dialog.verticalActions"
        :show-close="dialog.showClose"
      >
        <template v-if="dialog.type === 'preloader'">
          <div class="dl-bulma-dialog-host__preloader">
            <div class="dl-bulma-spinner dl-bulma-spinner--lg"></div>
            <p v-if="dialog.title" class="dl-bulma-dialog-host__preloader-text">{{ dialog.title }}</p>
          </div>
        </template>

        <template v-else-if="dialog.type === 'progress'">
          <div class="dl-bulma-dialog-host__progress">
            <div class="dl-bulma-dialog-host__progress-info">
              <span class="dl-bulma-dialog-host__progress-label">{{ dialog.title }}</span>
              <span class="dl-bulma-dialog-host__progress-value">{{ dialog.value }}%</span>
            </div>
            <div class="dl-bulma-progress">
              <div class="dl-bulma-progress__bar dl-bulma-progress__bar--primary" :style="{ width: `${dialog.value}%` }"></div>
            </div>
          </div>
        </template>

        <template v-else-if="dialog.type === 'prompt'">
          <div class="dl-bulma-dialog-host__prompt">
            <label class="dl-bulma-dialog-host__prompt-label">{{ dialog.label }}</label>
            <input
              v-if="dialog.inputType !== 'textarea'"
              class="dl-bulma-dialog-host__prompt-input"
              :type="dialog.inputType"
              :placeholder="dialog.placeholder"
              v-model="dialog.value.value"
            >
            <textarea
              v-else
              class="dl-bulma-dialog-host__prompt-textarea"
              :placeholder="dialog.placeholder"
              v-model="dialog.value.value"
              rows="3"
            ></textarea>
            <p v-if="dialog.error.value" class="dl-bulma-dialog-host__prompt-error">{{ dialog.error.value }}</p>
          </div>
        </template>

        <template #actions>
          <template v-for="(action, index) in dialog.actions" :key="index">
            <button
              v-if="action.action === 'cancel'"
              class="button"
              @click="handleAction(dialog, 'cancel')"
            >
              {{ action.label }}
            </button>
            <button
              v-else-if="action.action === 'confirm'"
              class="button"
              :class="action.variant === 'danger' ? 'is-danger' : 'is-primary'"
              @click="handleAction(dialog, 'confirm')"
            >
              {{ action.label }}
            </button>
          </template>
        </template>
      </UiDialog>
    </template>
  </Teleport>
</template>

<script setup>
import UiDialog from './UiDialog.vue'
import { useUiDialog } from '@/Composables/useUiDialog'

const { dialogs, handleAction } = useUiDialog()
</script>

<style lang="scss" scoped>
.dl-bulma-dialog-host {
  &__preloader {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1.5rem 0;
    text-align: center;
  }

  &__preloader-text {
    margin: 1rem 0 0;
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
  }

  &__progress {
    padding: 0.5rem 0;
  }

  &__progress-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
  }

  &__progress-label {
    color: var(--bulma-text);
  }

  &__progress-value {
    color: var(--bulma-text-weak);
    font-variant-numeric: tabular-nums;
  }

  &__prompt {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  &__prompt-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--bulma-text);
  }

  &__prompt-input,
  &__prompt-textarea {
    width: 100%;
    padding: 0.75rem;
    font-size: 0.875rem;
    color: var(--bulma-text);
    background: var(--bulma-scheme-main);
    border: 1px solid var(--bulma-border);
    border-radius: 6px;
    transition: border-color 0.2s;

    &::placeholder {
      color: var(--bulma-text-weak);
    }

    &:focus {
      outline: none;
      border-color: var(--bulma-link);
    }
  }

  &__prompt-textarea {
    resize: vertical;
    min-height: 80px;
  }

  &__prompt-error {
    margin: 0;
    font-size: 0.75rem;
    color: var(--bulma-danger);
  }
}

.dl-bulma-progress {
  height: 8px;
  background: var(--bulma-scheme-main-bis);
  border-radius: 4px;
  overflow: hidden;

  &__bar {
    height: 100%;
    border-radius: 4px;
    transition: width 0.3s ease;

    &--primary {
      background: var(--bulma-primary);
    }
  }
}

.dl-bulma-spinner {
  border: 3px solid var(--bulma-scheme-main-bis);
  border-top-color: var(--bulma-primary);
  border-radius: 50%;
  animation: dl-bulma-spin 0.8s linear infinite;

  &--lg {
    width: 48px;
    height: 48px;
  }
}

@keyframes dl-bulma-spin {
  to {
    transform: rotate(360deg);
  }
}
</style>
