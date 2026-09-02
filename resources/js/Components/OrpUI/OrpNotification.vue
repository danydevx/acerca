<script setup>
import { ref, watch, computed, onUnmounted } from 'vue'

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: true
    },
    id: {
        type: [String, Number],
        default: () => `notification-${Date.now()}-${Math.random().toString(36).slice(2, 9)}`
    },
    title: {
        type: String,
        default: ''
    },
    subtitle: {
        type: String,
        default: ''
    },
    message: {
        type: String,
        default: ''
    },
    time: {
        type: String,
        default: ''
    },
    tone: {
        type: String,
        default: 'neutral',
        validator: (v) => ['neutral', 'info', 'success', 'warning', 'danger'].includes(v)
    },
    layout: {
        type: String,
        default: 'default',
        validator: (v) => ['default', 'compact', 'full'].includes(v)
    },
    icon: {
        type: String,
        default: ''
    },
    avatar: {
        type: String,
        default: ''
    },
    image: {
        type: String,
        default: ''
    },
    actions: {
        type: Array,
        default: () => []
    },
    closable: {
        type: Boolean,
        default: true
    },
    dismissible: {
        type: Boolean,
        default: true
    },
    duration: {
        type: Number,
        default: 0
    },
    persistent: {
        type: Boolean,
        default: false
    },
    clickable: {
        type: Boolean,
        default: false
    },
    href: {
        type: String,
        default: ''
    },
    loading: {
        type: Boolean,
        default: false
    },
    progress: {
        type: Number,
        default: null
    },
    unread: {
        type: Boolean,
        default: false
    },
    read: {
        type: Boolean,
        default: false
    },
    closeOnClick: {
        type: Boolean,
        default: false
    },
    closeOnAction: {
        type: Boolean,
        default: false
    },
    verticalActions: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['update:modelValue', 'close', 'action', 'click'])

const timer = ref(null)
const isVisible = ref(props.modelValue)

const close = (reason = 'manual') => {
    isVisible.value = false
    emit('update:modelValue', false)
    emit('close', { id: props.id, reason })
}

const handleAction = (action) => {
    emit('action', { id: props.id, action })
    if (props.closeOnAction || action.closeOnClick) {
        close('action')
    }
}

const handleClick = (event) => {
    if (props.closeOnClick) {
        close('click')
    }
    emit('click', { id: props.id, event })
}

const clearTimer = () => {
    if (timer.value) {
        clearTimeout(timer.value)
        timer.value = null
    }
}

const startTimer = () => {
    clearTimer()
    const duration = props.duration > 0 ? props.duration : (props.persistent ? 0 : 5000)
    if (duration > 0) {
        timer.value = setTimeout(() => {
            close('timeout')
        }, duration)
    }
}

watch(() => props.modelValue, (isOpen) => {
    isVisible.value = isOpen
    if (isOpen) {
        startTimer()
    } else {
        clearTimer()
    }
}, { immediate: true })

onUnmounted(() => {
    clearTimer()
})

const tag = computed(() => {
    if (props.href) return 'a'
    if (props.clickable || props.closeOnClick) return 'button'
    return 'div'
})

const componentClass = computed(() => [
    'orp-notification',
    `orp-notification--${props.tone}`,
    `orp-notification--${props.layout}`,
    {
        'orp-notification--loading': props.loading,
        'orp-notification--progress': props.progress !== null,
        'orp-notification--unread': props.unread && !props.read,
        'orp-notification--read': props.read,
        'orp-notification--clickable': props.clickable && !props.href,
        'orp-notification--dismissible': props.dismissible && props.closable
    }
])

const role = computed(() => {
    if (props.tone === 'danger') return 'alert'
    return 'status'
})

const ariaLive = computed(() => {
    if (props.tone === 'danger') return 'assertive'
    return 'polite'
})
</script>

<template>
    <Transition name="orp-notification">
        <div
            v-if="isVisible"
            :class="componentClass"
            :role="role"
            :aria-live="ariaLive"
            :aria-atomic="true"
        >
            <component
                :is="tag"
                v-if="tag === 'a'"
                :href="href"
                class="orp-notification__link"
                @click="handleClick"
            >
                <slot name="media">
                    <div v-if="avatar" class="orp-notification__avatar">
                        <img :src="avatar" :alt="title || 'Notification avatar'" />
                    </div>
                    <div v-else-if="icon" class="orp-notification__icon">
                        <i :class="icon"></i>
                    </div>
                </slot>

                <div class="orp-notification__content">
                    <div class="orp-notification__header">
                        <div class="orp-notification__meta">
                            <span v-if="title" class="orp-notification__title">{{ title }}</span>
                            <span v-if="time" class="orp-notification__time">{{ time }}</span>
                        </div>
                    </div>
                    <span v-if="subtitle" class="orp-notification__subtitle">{{ subtitle }}</span>
                    <span v-if="message" class="orp-notification__message">{{ message }}</span>
                    <img v-if="image" :src="image" class="orp-notification__image" :alt="title || 'Notification image'" />
                </div>
            </component>

            <template v-else>
                <slot name="media">
                    <div v-if="avatar" class="orp-notification__avatar">
                        <img :src="avatar" :alt="title || 'Notification avatar'" />
                    </div>
                    <div v-else-if="icon" class="orp-notification__icon">
                        <i :class="icon"></i>
                    </div>
                </slot>

                <div class="orp-notification__content">
                    <div class="orp-notification__header">
                        <div class="orp-notification__meta">
                            <span v-if="title" class="orp-notification__title">{{ title }}</span>
                            <span v-if="time" class="orp-notification__time">{{ time }}</span>
                        </div>
                    </div>
                    <span v-if="subtitle" class="orp-notification__subtitle">{{ subtitle }}</span>
                    <span v-if="message" class="orp-notification__message">
                        <slot name="message">{{ message }}</slot>
                    </span>
                    <img v-if="image" :src="image" class="orp-notification__image" :alt="title || 'Notification image'" />
                </div>
            </template>

            <div
                v-if="clickable || href"
                class="orp-notification__clickable-overlay"
                @click="handleClick"
            ></div>

            <div v-if="actions.length || $slots.actions" class="orp-notification__actions" :class="{ 'orp-notification__actions--vertical': verticalActions }">
                <slot name="actions">
                    <button
                        v-for="(action, index) in actions"
                        :key="index"
                        class="orp-notification__action"
                        :class="[
                            action.variant ? `orp-notification__action--${action.variant}` : ''
                        ]"
                        @click="handleAction(action)"
                    >
                        {{ action.label }}
                    </button>
                </slot>
            </div>

            <div v-if="progress !== null" class="orp-notification__progress">
                <div class="orp-notification__progress-bar" :style="{ width: `${progress}%` }"></div>
            </div>

            <button
                v-if="closable && dismissible"
                class="orp-notification__close"
                aria-label="Dismiss notification"
                @click="close('manual')"
            >
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
    </Transition>
</template>

<style scoped>
.orp-notification__link {
    display: contents;
    text-decoration: none;
    color: inherit;
}

.orp-notification__clickable-overlay {
    position: absolute;
    inset: 0;
    cursor: pointer;
}
</style>
