import { onUnmounted, watch } from 'vue'

export function useRestoreFocus(isActive) {
    let previousActiveElement = null

    const capture = () => {
        if (typeof document === 'undefined') return
        previousActiveElement = document.activeElement
    }

    const restore = () => {
        if (previousActiveElement && typeof previousActiveElement.focus === 'function') {
            previousActiveElement.focus()
            previousActiveElement = null
        }
    }

    watch(isActive, (active) => {
        if (active) {
            capture()
        } else {
            restore()
        }
    }, { immediate: true })

    onUnmounted(() => {
        restore()
    })
}
