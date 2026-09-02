import { onUnmounted, watch } from 'vue'

const FOCUSABLE_SELECTORS = [
    'a[href]',
    'button:not([disabled])',
    'input:not([disabled])',
    'select:not([disabled])',
    'textarea:not([disabled])',
    '[tabindex]:not([tabindex="-1"])',
    '[contenteditable]'
].join(', ')

function getFocusableElements(container) {
    if (!container || typeof document === 'undefined') return []
    return Array.from(container.querySelectorAll(FOCUSABLE_SELECTORS))
}

function getFirstFocusable(container) {
    const elements = getFocusableElements(container)
    return elements.length > 0 ? elements[0] : null
}

function getLastFocusable(container) {
    const elements = getFocusableElements(container)
    return elements.length > 0 ? elements[elements.length - 1] : null
}

export function useFocusTrap(isActive, containerRef) {
    let handler = null

    const handleTabKey = (e) => {
        if (!containerRef.value) return

        const focusableElements = getFocusableElements(containerRef.value)
        if (focusableElements.length === 0) return

        const first = focusableElements[0]
        const last = focusableElements[focusableElements.length - 1]

        if (e.shiftKey) {
            if (document.activeElement === first) {
                e.preventDefault()
                last.focus()
            }
        } else {
            if (document.activeElement === last) {
                e.preventDefault()
                first.focus()
            }
        }
    }

    const attach = () => {
        if (typeof document === 'undefined') return

        const focusable = getFirstFocusable(containerRef.value)
        if (focusable) {
            focusable.focus()
        } else if (containerRef.value) {
            containerRef.value.setAttribute('tabindex', '-1')
            containerRef.value.focus()
        }

        handler = (e) => {
            if (e.key === 'Tab') {
                handleTabKey(e)
            }
        }
        document.addEventListener('keydown', handler)
    }

    const detach = () => {
        if (handler && typeof document !== 'undefined') {
            document.removeEventListener('keydown', handler)
            handler = null
        }
    }

    watch(isActive, (active) => {
        if (active) {
            attach()
        } else {
            detach()
        }
    }, { immediate: true })

    onUnmounted(() => {
        detach()
    })
}
