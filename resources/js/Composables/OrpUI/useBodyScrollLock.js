import { watch, onUnmounted } from 'vue'

export function useBodyScrollLock(isActive) {
    let scrollbarWidth = 0
    let originalOverflow = ''
    let originalPaddingRight = ''

    const lock = () => {
        if (typeof document === 'undefined') return

        scrollbarWidth = window.innerWidth - document.documentElement.clientWidth
        originalOverflow = document.body.style.overflow
        originalPaddingRight = getComputedStyle(document.documentElement).paddingRight

        document.body.style.overflow = 'hidden'
        document.body.style.paddingRight = `${scrollbarWidth}px`
    }

    const unlock = () => {
        if (typeof document === 'undefined') return

        document.body.style.overflow = originalOverflow
        document.body.style.paddingRight = originalPaddingRight
        scrollbarWidth = 0
        originalOverflow = ''
        originalPaddingRight = ''
    }

    watch(isActive, (active) => {
        if (active) {
            lock()
        } else {
            unlock()
        }
    }, { immediate: true })

    onUnmounted(() => {
        unlock()
    })

    return { lock, unlock }
}
