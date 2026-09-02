import { reactive, readonly } from 'vue'

const notifications = reactive([])
let notificationId = 0

export function useOrpNotifications() {
    const show = (options = {}) => {
        const {
            title = '',
            subtitle = '',
            message = '',
            time = '',
            tone = 'neutral',
            layout = 'default',
            icon = '',
            avatar = '',
            image = '',
            actions = [],
            closable = true,
            dismissible = true,
            duration = 0,
            persistent = false,
            clickable = false,
            href = '',
            loading = false,
            progress = null,
            unread = false,
            read = false,
            closeOnClick = false,
            closeOnAction = false,
            verticalActions = false,
            onAction = null,
            onClick = null,
            $slots = {}
        } = options

        const id = ++notificationId
        const notificationState = reactive({
            id,
            title,
            subtitle,
            message,
            time,
            tone,
            layout,
            icon,
            avatar,
            image,
            actions,
            closable,
            dismissible,
            duration,
            persistent,
            clickable,
            href,
            loading,
            progress,
            unread,
            read,
            closeOnClick,
            closeOnAction,
            verticalActions,
            onAction,
            onClick,
            $slots,
            visible: true,
            modelValue: true
        })

        notifications.push(notificationState)

        return {
            id,
            close: (reason = 'manual') => {
                notificationState.visible = false
                notificationState.modelValue = false
                const index = notifications.findIndex(n => n.id === id)
                if (index !== -1) {
                    notifications.splice(index, 1)
                }
            },
            update: (newProps) => {
                Object.assign(notificationState, newProps)
            },
            state: notificationState
        }
    }

    const remove = (id) => {
        const index = notifications.findIndex(n => n.id === id)
        if (index !== -1) {
            notifications.splice(index, 1)
        }
    }

    const clear = () => {
        notifications.splice(0, notifications.length)
    }

    const neutral = (options = {}) => show({ ...options, tone: 'neutral' })
    const info = (options = {}) => show({ ...options, tone: 'info' })
    const success = (options = {}) => show({ ...options, tone: 'success' })
    const warning = (options = {}) => show({ ...options, tone: 'warning' })
    const danger = (options = {}) => show({ ...options, tone: 'danger' })

    return {
        notifications: readonly(notifications),
        show,
        remove,
        clear,
        neutral,
        info,
        success,
        warning,
        danger
    }
}
