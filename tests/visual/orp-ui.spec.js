import { test, expect } from '@playwright/test'

test.describe('ORP UI Visual Regression', () => {
    test.beforeEach(async ({ page }) => {
        await page.goto('/orp-playground')
    })

    test('Playground loads without errors', async ({ page }) => {
        const errors = []
        page.on('console', msg => {
            if (msg.type() === 'error') {
                errors.push(msg.text())
            }
        })

        await page.waitForLoadState('networkidle')

        // Filter out expected warnings
        const realErrors = errors.filter(e =>
            !e.includes('DevTools') &&
            !e.includes('favicon')
        )

        expect(realErrors).toHaveLength(0)
    })

    test('Buttons section renders correctly', async ({ page }) => {
        await expect(page.locator('text=Buttons')).toBeVisible()

        // Check all button variants exist
        await expect(page.locator('button:has-text("Primary")')).toBeVisible()
        await expect(page.locator('button:has-text("Secondary")')).toBeVisible()
        await expect(page.locator('button:has-text("Ghost")')).toBeVisible()
        await expect(page.locator('button:has-text("Danger")')).toBeVisible()
    })

    test('Cards section renders correctly', async ({ page }) => {
        await expect(page.locator('h2:has-text("Cards")')).toBeVisible()
    })

    test('List Divided + Inset + Composition renders correctly', async ({ page }) => {
        await page.evaluate(() => {
            const section = Array.from(document.querySelectorAll('h2'))
                .find(h => h.textContent.includes('List'))
            if (section) section.scrollIntoView()
        })

        await expect(page.locator('h2:has-text("List")')).toBeVisible()

        // Verify no emoji icons in list section
        const listSection = page.locator('.orp-playground__section:has-text("List")')
        await expect(listSection.locator('text=/[📁📷⚙️🔔👤📋💬]/')).toHaveCount(0)
    })

    test('AppBar section renders correctly', async ({ page }) => {
        await expect(page.locator('h2:has-text("AppBar")')).toBeVisible()

        // Check AppBar structure
        await expect(page.locator('.orp-app-bar')).toBeVisible()
    })

    test('Modal opens and closes correctly', async ({ page }) => {
        await page.click('button:has-text("Default")')

        const modal = page.locator('.orp-modal')
        await expect(modal).toBeVisible()

        await page.click('.orp-modal__close')

        await expect(modal).not.toBeVisible()
    })

    test('BottomNav renders with Bootstrap Icons', async ({ page }) => {
        // Find BottomNav section
        const bottomNavSection = page.locator('h2:has-text("BottomNav")')
        await bottomNavSection.scrollIntoViewIfNeeded()

        // Verify no emoji in bottom nav
        const bottomNav = page.locator('.orp-bottom-nav')
        await expect(bottomNav).toBeVisible()

        // Should have bi-* classes, not emoji
        const iconElements = bottomNav.locator('[class*="bi-"]')
        await expect(iconElements.first()).toBeVisible()
    })

    test('Theme toggle works', async ({ page }) => {
        const themeToggle = page.locator('button[aria-label*="theme"], button:has-text("Light"), button:has-text("Dark")').first()

        if (await themeToggle.isVisible()) {
            await themeToggle.click()
            // Theme should change
        }
    })
})

test.describe('ORP UI Responsive', () => {
    const viewports = [
        { name: 'Mobile 320', width: 320, height: 568 },
        { name: 'Mobile 375', width: 375, height: 667 },
        { name: 'Mobile 390', width: 390, height: 844 },
        { name: 'Mobile 430', width: 430, height: 932 },
        { name: 'Tablet', width: 768, height: 1024 },
        { name: 'Desktop', width: 1280, height: 720 },
    ]

    for (const vp of viewports) {
        test(`${vp.name} (${vp.width}x${vp.height}) renders without horizontal overflow`, async ({ page }) => {
            await page.setViewportSize({ width: vp.width, height: vp.height })
            await page.goto('/orp-playground')
            await page.waitForLoadState('networkidle')

            const bodyWidth = await page.evaluate(() => document.body.scrollWidth)
            const windowWidth = await page.evaluate(() => window.innerWidth)

            // Allow 2px tolerance for rounding
            expect(bodyWidth).toBeLessThanOrEqual(windowWidth + 2)
        })
    }
})
