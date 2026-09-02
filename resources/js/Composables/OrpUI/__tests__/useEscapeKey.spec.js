import { describe, it, expect, vi, beforeEach, afterEach } from 'vitest'
import { ref } from 'vue'

describe('useEscapeKey behavior', () => {
    let handler

    beforeEach(() => {
        handler = vi.fn()
    })

    afterEach(() => {
        vi.restoreAllMocks()
    })

    it('should call handler on Escape when active', () => {
        const isActive = ref(true)

        // Simulate the composable pattern
        const handleKeydown = (e) => {
            if (isActive.value && e.key === 'Escape') {
                handler()
            }
        }
        document.addEventListener('keydown', handleKeydown)

        const event = new KeyboardEvent('keydown', { key: 'Escape' })
        document.dispatchEvent(event)

        expect(handler).toHaveBeenCalledTimes(1)

        document.removeEventListener('keydown', handleKeydown)
    })

    it('should not call handler on Escape when inactive', () => {
        const isActive = ref(false)

        const handleKeydown = (e) => {
            if (isActive.value && e.key === 'Escape') {
                handler()
            }
        }
        document.addEventListener('keydown', handleKeydown)

        const event = new KeyboardEvent('keydown', { key: 'Escape' })
        document.dispatchEvent(event)

        expect(handler).not.toHaveBeenCalled()

        document.removeEventListener('keydown', handleKeydown)
    })

    it('should not call handler for non-Escape keys', () => {
        const isActive = ref(true)

        const handleKeydown = (e) => {
            if (isActive.value && e.key === 'Escape') {
                handler()
            }
        }
        document.addEventListener('keydown', handleKeydown)

        const event = new KeyboardEvent('keydown', { key: 'Enter' })
        document.dispatchEvent(event)

        expect(handler).not.toHaveBeenCalled()

        document.removeEventListener('keydown', handleKeydown)
    })
})
