import { ref, onUnmounted } from 'vue'

export function usePositioning(options = {}) {
    const { placement = 'bottom-start', offset = 8 } = options

    const position = ref({ top: 0, left: 0 })
    const adjustedPlacement = ref(placement)

    const compute = (triggerEl, floatingEl) => {
        if (!triggerEl || !floatingEl) return

        const triggerRect = triggerEl.getBoundingClientRect()
        const floatingRect = floatingEl.getBoundingClientRect()

        const viewportHeight = window.innerHeight
        const viewportWidth = window.innerWidth

        let top = 0
        let left = 0

        const [p, v] = placement.split('-')
        const vertical = p
        const horizontal = v

        if (vertical === 'bottom') {
            top = triggerRect.bottom + offset
        } else if (vertical === 'top') {
            top = triggerRect.top - floatingRect.height - offset
        }

        if (horizontal === 'start') {
            left = triggerRect.left
        } else if (horizontal === 'end') {
            left = triggerRect.right - floatingRect.width
        }

        if (top + floatingRect.height > viewportHeight - offset) {
            top = triggerRect.top - floatingRect.height - offset
            adjustedPlacement.value = `top-${horizontal}`
        } else if (top < offset) {
            top = triggerRect.bottom + offset
            adjustedPlacement.value = `bottom-${horizontal}`
        }

        if (left + floatingRect.width > viewportWidth - offset) {
            left = triggerRect.right - floatingRect.width
            adjustedPlacement.value = `${vertical}-end`
        } else if (left < offset) {
            left = triggerRect.left
            adjustedPlacement.value = `${vertical}-start`
        }

        position.value = { top, left }
    }

    return { position, adjustedPlacement, compute }
}
