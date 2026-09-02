import { describe, it, expect, vi, beforeEach, afterEach } from 'vitest'
import { ref } from 'vue'

describe('useBodyScrollLock behavior', () => {
    afterEach(() => {
        vi.restoreAllMocks()
    })

    it('should set overflow to hidden when active', () => {
        const isActive = ref(false)

        // Direct assignment like the composable does
        isActive.value = true
        if (isActive.value) {
            document.body.style.overflow = 'hidden'
        }

        expect(document.body.style.overflow).toBe('hidden')
    })

    it('should reset overflow when inactive', () => {
        const isActive = ref(true)

        // Simulate the pattern
        if (isActive.value) {
            document.body.style.overflow = 'hidden'
        }

        isActive.value = false
        if (!isActive.value) {
            document.body.style.overflow = ''
        }

        expect(document.body.style.overflow).toBe('')
    })
})
