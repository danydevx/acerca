<script setup>
import { provide, readonly } from 'vue'
import OrpDialog from './OrpDialog.vue'
import { useOrpDialog } from '@/Composables/OrpUI/useOrpDialog'

const { dialogs, handleAction } = useOrpDialog()

provide('dialogs', readonly(dialogs))
</script>

<template>
    <Teleport to="body">
        <template v-for="dialog in dialogs" :key="dialog.id">
            <OrpDialog
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
                <!-- Preloader -->
                <template v-if="dialog.type === 'preloader'">
                    <div class="orp-dialog__preloader">
                        <div class="orp-spinner orp-spinner--lg"></div>
                        <p v-if="dialog.title" class="orp-dialog__preloader-text">{{ dialog.title }}</p>
                    </div>
                </template>

                <!-- Progress -->
                <template v-else-if="dialog.type === 'progress'">
                    <div class="orp-dialog__progress">
                        <div class="orp-dialog__progress-info">
                            <span class="orp-dialog__progress-label">{{ dialog.title }}</span>
                            <span class="orp-dialog__progress-value">{{ dialog.value }}%</span>
                        </div>
                        <div class="orp-progress">
                            <div class="orp-progress__bar orp-progress__bar--primary" :style="{ width: `${dialog.value}%` }"></div>
                        </div>
                    </div>
                </template>

                <!-- Prompt -->
                <template v-else-if="dialog.type === 'prompt'">
                    <div class="orp-dialog__prompt">
                        <label class="orp-dialog__prompt-label">{{ dialog.label }}</label>
                        <input
                            v-if="dialog.inputType !== 'textarea'"
                            class="orp-dialog__prompt-input"
                            :type="dialog.inputType"
                            :placeholder="dialog.placeholder"
                            v-model="dialog.value.value"
                        >
                        <textarea
                            v-else
                            class="orp-dialog__prompt-textarea"
                            :placeholder="dialog.placeholder"
                            v-model="dialog.value.value"
                            rows="3"
                        ></textarea>
                        <p v-if="dialog.error.value" class="orp-dialog__prompt-error">{{ dialog.error.value }}</p>
                    </div>
                </template>

                <!-- Default slot for custom content -->
                <template v-else>
                    <slot :dialog="dialog" />
                </template>

                <!-- Actions -->
                <template #actions>
                    <template v-for="(action, index) in dialog.actions" :key="index">
                        <button
                            v-if="action.action === 'cancel'"
                            class="orp-dialog__action orp-dialog__action--outline"
                            @click="handleAction(dialog, 'cancel')"
                        >
                            {{ action.label }}
                        </button>
                        <button
                            v-else-if="action.action === 'confirm'"
                            class="orp-dialog__action"
                            :class="action.variant === 'danger' ? 'orp-dialog__action--danger' : 'orp-dialog__action--primary'"
                            @click="handleAction(dialog, 'confirm')"
                        >
                            {{ action.label }}
                        </button>
                    </template>
                </template>
            </OrpDialog>
        </template>
    </Teleport>
</template>

<style scoped>
.orp-dialog__preloader {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: var(--orp-space-6) 0;
    text-align: center;
}

.orp-dialog__preloader-text {
    margin: var(--orp-space-4) 0 0;
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);
}

.orp-dialog__progress {
    padding: var(--orp-space-2) 0;
}

.orp-dialog__progress-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: var(--orp-space-2);
    font-size: var(--orp-font-size-sm);
}

.orp-dialog__progress-label {
    color: var(--orp-surface-foreground);
}

.orp-dialog__progress-value {
    color: var(--orp-muted-foreground);
    font-variant-numeric: tabular-nums;
}

.orp-dialog__prompt {
    display: flex;
    flex-direction: column;
    gap: var(--orp-space-2);
}

.orp-dialog__prompt-label {
    font-size: var(--orp-font-size-sm);
    font-weight: 500;
    color: var(--orp-surface-foreground);
}

.orp-dialog__prompt-input,
.orp-dialog__prompt-textarea {
    width: 100%;
    padding: var(--orp-space-3);
    font-size: var(--orp-font-size-sm);
    color: var(--orp-surface-foreground);
    background: var(--orp-surface);
    border: 1px solid var(--orp-border);
    border-radius: var(--orp-radius-md);
    transition: border-color var(--orp-duration-fast);

    &::placeholder {
        color: var(--orp-muted-foreground);
    }

    &:focus {
        outline: none;
        border-color: var(--orp-primary);
    }
}

.orp-dialog__prompt-textarea {
    resize: vertical;
    min-height: 80px;
}

.orp-dialog__prompt-error {
    margin: 0;
    font-size: var(--orp-font-size-xs);
    color: var(--orp-danger);
}

.orp-dialog__action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--orp-space-2);
    padding: var(--orp-space-2) var(--orp-space-4);
    font-size: var(--orp-font-size-sm);
    font-weight: 500;
    border-radius: var(--orp-radius-md);
    cursor: pointer;
    transition: background var(--orp-duration-fast), color var(--orp-duration-fast), border-color var(--orp-duration-fast);

    &:focus-visible {
        outline: 2px solid var(--orp-ring);
        outline-offset: 2px;
    }
}

.orp-dialog__action--outline {
    background: transparent;
    border: 1px solid var(--orp-border);
    color: var(--orp-surface-foreground);

    &:hover {
        background: var(--orp-surface-muted);
    }
}

.orp-dialog__action--primary {
    background: var(--orp-primary);
    border: 1px solid var(--orp-primary);
    color: #fff;

    &:hover {
        background: color-mix(in srgb, var(--orp-primary) 90%, #000);
    }
}

.orp-dialog__action--danger {
    background: var(--orp-danger);
    border: 1px solid var(--orp-danger);
    color: #fff;

    &:hover {
        background: color-mix(in srgb, var(--orp-danger) 90%, #000);
    }
}
</style>
