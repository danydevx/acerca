import { onUnmounted, watch } from 'vue'

export function useClickOutside(containerRef, callback, options = {}) {
    const { enabled = true } = options
    let handler = null

    const onMouseDown = (e) => {
        if (!containerRef.value) return
        if (!containerRef.value.contains(e.target)) {
            callback(e)
        }
    }

    const attach = () => {
        if (typeof document === 'undefined') return
        document.addEventListener('mousedown', handler, true)
    }

    const detach = () => {
        if (typeof document !== 'undefined') {
            document.removeEventListener('mousedown', handler, true)
        }
    }

    handler = onMouseDown

    watch(() => enabled, (isEnabled) => {
        if (isEnabled) {
            attach()
        } else {
            detach()
        }
    }, { immediate: true })

    onUnmounted(() => {
        detach()
    })
}
