import { onUnmounted, watch } from 'vue'

export function useEscapeKey(isActive, callback) {
    let handler = null

    const attach = () => {
        if (typeof document === 'undefined') return
        handler = (e) => {
            if (e.key === 'Escape') {
                callback()
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
