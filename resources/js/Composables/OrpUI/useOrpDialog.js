import { ref, reactive, readonly } from 'vue'

const dialogs = reactive([])
let dialogId = 0

export function useOrpDialog() {
    const alert = async (options = {}) => {
        const {
            title = '',
            description = '',
            tone = 'neutral',
            icon = '',
            confirmText = 'OK',
            closeOnBackdrop = true,
            dismissible = true,
            size = 'sm'
        } = options

        const id = ++dialogId
        const dialogState = {
            id,
            type: 'alert',
            modelValue: true,
            title,
            description,
            tone,
            icon,
            size,
            closeOnBackdrop,
            dismissible,
            verticalActions: false,
            showClose: false,
            actions: [
                { label: confirmText, variant: 'primary', action: 'confirm' }
            ],
            resolve: null,
            reject: null
        }

        dialogs.push(dialogState)

        return new Promise((resolve) => {
            dialogState.resolve = resolve
        }).finally(() => {
            const index = dialogs.findIndex(d => d.id === id)
            if (index !== -1) {
                dialogs.splice(index, 1)
            }
        })
    }

    const confirm = async (options = {}) => {
        const {
            title = '',
            description = '',
            tone = 'neutral',
            icon = '',
            confirmText = 'Confirm',
            cancelText = 'Cancel',
            closeOnBackdrop = true,
            dismissible = true,
            size = 'sm',
            verticalActions = false
        } = options

        const id = ++dialogId
        const dialogState = {
            id,
            type: 'confirm',
            modelValue: true,
            title,
            description,
            tone,
            icon,
            size,
            closeOnBackdrop,
            dismissible,
            verticalActions,
            showClose: false,
            actions: [
                { label: cancelText, variant: 'outline', action: 'cancel' },
                { label: confirmText, variant: tone === 'danger' ? 'danger' : 'primary', action: 'confirm', danger: tone === 'danger' }
            ],
            resolve: null,
            reject: null
        }

        dialogs.push(dialogState)

        return new Promise((resolve) => {
            dialogState.resolve = resolve
        }).finally(() => {
            const index = dialogs.findIndex(d => d.id === id)
            if (index !== -1) {
                dialogs.splice(index, 1)
            }
        })
    }

    const prompt = async (options = {}) => {
        const {
            title = '',
            description = '',
            label = '',
            placeholder = '',
            value = '',
            confirmText = 'Save',
            cancelText = 'Cancel',
            inputType = 'text',
            closeOnBackdrop = true,
            dismissible = true,
            size = 'sm',
            verticalActions = false
        } = options

        const id = ++dialogId
        const promptValue = ref(value)
        const promptError = ref('')
        const loading = ref(false)

        const dialogState = reactive({
            id,
            type: 'prompt',
            modelValue: true,
            title,
            description,
            tone: 'neutral',
            size,
            closeOnBackdrop,
            dismissible,
            verticalActions,
            showClose: false,
            label,
            placeholder,
            inputType,
            value: promptValue,
            error: promptError,
            loading,
            actions: [
                { label: cancelText, variant: 'outline', action: 'cancel' },
                { label: confirmText, variant: 'primary', action: 'confirm' }
            ],
            resolve: null,
            reject: null
        })

        dialogs.push(dialogState)

        return new Promise((resolve) => {
            dialogState.resolve = resolve
        }).finally(() => {
            const index = dialogs.findIndex(d => d.id === id)
            if (index !== -1) {
                dialogs.splice(index, 1)
            }
        })
    }

    const preloader = (options = {}) => {
        const {
            title = 'Loading...',
            dismissible = false,
            size = 'sm'
        } = options

        const id = ++dialogId
        const dialogState = {
            id,
            type: 'preloader',
            modelValue: true,
            title,
            size,
            closeOnBackdrop: false,
            dismissible,
            showClose: false,
            resolve: null,
            reject: null
        }

        dialogs.push(dialogState)

        return {
            close: () => {
                dialogState.modelValue = false
                const index = dialogs.findIndex(d => d.id === id)
                if (index !== -1) {
                    dialogs.splice(index, 1)
                }
            },
            update: (newTitle) => {
                dialogState.title = newTitle
            }
        }
    }

    const progress = (options = {}) => {
        const {
            title = 'Progress',
            value = 0,
            dismissible = false,
            size = 'sm'
        } = options

        const id = ++dialogId
        const dialogState = reactive({
            id,
            type: 'progress',
            modelValue: true,
            title,
            value,
            size,
            closeOnBackdrop: false,
            dismissible,
            showClose: false,
            resolve: null,
            reject: null
        })

        dialogs.push(dialogState)

        return {
            update: (newValue) => {
                dialogState.value = Math.min(100, Math.max(0, newValue))
            },
            close: () => {
                dialogState.modelValue = false
                const index = dialogs.findIndex(d => d.id === id)
                if (index !== -1) {
                    dialogs.splice(index, 1)
                }
            }
        }
    }

    const custom = (options = {}) => {
        const {
            component: DialogComponent,
            props: dialogProps = {},
            size = 'md',
            dismissible = true,
            closeOnBackdrop = true
        } = options

        const id = ++dialogId
        const dialogState = {
            id,
            type: 'custom',
            component: DialogComponent,
            props: dialogProps,
            modelValue: true,
            size,
            closeOnBackdrop,
            dismissible,
            showClose: true,
            resolve: null,
            reject: null
        }

        dialogs.push(dialogState)

        return {
            close: () => {
                dialogState.modelValue = false
                const index = dialogs.findIndex(d => d.id === id)
                if (index !== -1) {
                    dialogs.splice(index, 1)
                }
            }
        }
    }

    const handleAction = (dialog, action) => {
        if (action === 'confirm') {
            if (dialog.type === 'prompt') {
                dialog.resolve(dialog.value.value)
            } else {
                dialog.resolve(true)
            }
        } else if (action === 'cancel') {
            if (dialog.type === 'prompt') {
                dialog.resolve(null)
            } else {
                dialog.resolve(false)
            }
        }
        dialog.modelValue = false
    }

    return {
        dialogs: readonly(dialogs),
        alert,
        confirm,
        prompt,
        preloader,
        progress,
        custom,
        handleAction
    }
}
