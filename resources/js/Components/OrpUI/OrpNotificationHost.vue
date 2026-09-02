<script setup>
import { useOrpNotifications } from '@/Composables/OrpUI/useOrpNotifications'
import OrpNotification from './OrpNotification.vue'

const props = defineProps({
    position: {
        type: String,
        default: 'bottom-end',
        validator: (v) => ['top-start', 'top-center', 'top-end', 'bottom-start', 'bottom-center', 'bottom-end'].includes(v)
    },
    maxVisible: {
        type: Number,
        default: 3
    }
})

const { notifications, remove } = useOrpNotifications()

const visibleNotifications = notifications.slice(0, props.maxVisible)
</script>

<template>
    <Teleport to="body">
        <TransitionGroup
            name="orp-notification-stack"
            tag="div"
            class="orp-notification-stack"
            :class="`orp-notification-stack--${position}`"
        >
            <OrpNotification
                v-for="notification in visibleNotifications"
                :key="notification.id"
                :id="notification.id"
                v-model="notification.visible"
                :title="notification.title"
                :subtitle="notification.subtitle"
                :message="notification.message"
                :time="notification.time"
                :tone="notification.tone"
                :layout="notification.layout"
                :icon="notification.icon"
                :avatar="notification.avatar"
                :image="notification.image"
                :actions="notification.actions"
                :closable="notification.closable"
                :dismissible="notification.dismissible"
                :duration="notification.duration"
                :persistent="notification.persistent"
                :clickable="notification.clickable"
                :href="notification.href"
                :loading="notification.loading"
                :progress="notification.progress"
                :unread="notification.unread"
                :read="notification.read"
                :close-on-click="notification.closeOnClick"
                :close-on-action="notification.closeOnAction"
                :vertical-actions="notification.verticalActions"
                @close="remove(notification.id)"
                @action="notification.onAction"
                @click="notification.onClick"
            >
                <template v-if="notification.$slots.media" #media>
                    <component :is="() => notification.$slots.media()" />
                </template>
                <template v-if="notification.$slots.message" #message>
                    <component :is="() => notification.$slots.message()" />
                </template>
                <template v-if="notification.$slots.actions" #actions>
                    <component :is="() => notification.$slots.actions()" />
                </template>
            </OrpNotification>
        </TransitionGroup>
    </Teleport>
</template>
