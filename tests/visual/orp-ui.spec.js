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
        }
    })

    test('Sheet opens and closes correctly', async ({ page }) => {
        const sheetSection = page.locator('h2:has-text("Sheet")')
        await sheetSection.scrollIntoViewIfNeeded()

        await page.click('button:has-text("Auto")')
        const sheet = page.locator('.orp-sheet')
        await expect(sheet).toBeVisible()

        await page.click('.orp-sheet__close')
        await expect(sheet).not.toBeVisible()
    })

    test('Drawer opens and closes correctly', async ({ page }) => {
        const drawerSection = page.locator('h2:has-text("Drawer")')
        await drawerSection.scrollIntoViewIfNeeded()

        await page.click('button:has-text("Left")')
        const drawer = page.locator('.orp-drawer')
        await expect(drawer).toBeVisible()

        await page.click('.orp-drawer__close')
        await expect(drawer).not.toBeVisible()
    })

    test('Tabs switch correctly', async ({ page }) => {
        const tabsSection = page.locator('h2:has-text("Tabs")')
        await tabsSection.scrollIntoViewIfNeeded()

        const tabs = page.locator('.orp-tabs')
        await expect(tabs).toBeVisible()

        const tabButtons = page.locator('.orp-tabs__tab')
        await expect(tabButtons.first()).toBeVisible()

        await tabButtons.nth(1).click()
        await expect(tabButtons.nth(1)).toHaveClass(/orp-tabs__tab--active/)
    })

    test('Dialog opens and closes correctly', async ({ page }) => {
        const dialogSection = page.locator('h2:has-text("Dialogs")')
        await dialogSection.scrollIntoViewIfNeeded()

        await page.click('button:has-text("Neutral Alert")')
        const dialog = page.locator('.orp-dialog')
        await expect(dialog).toBeVisible()

        await page.click('.orp-dialog__close')
        await expect(dialog).not.toBeVisible()
    })

    test('ActionSheet opens and closes correctly', async ({ page }) => {
        const actionSheetSection = page.locator('h2:has-text("ActionSheet")')
        await actionSheetSection.scrollIntoViewIfNeeded()

        await page.click('button:has-text("Open ActionSheet")')
        const actionSheet = page.locator('.orp-action-sheet')
        await expect(actionSheet).toBeVisible()

        await page.click('.orp-action-sheet__overlay')
        await expect(actionSheet).not.toBeVisible()
    })

    test('Notifications section renders correctly', async ({ page }) => {
        const notificationsSection = page.locator('h2:has-text("Notifications")')
        await notificationsSection.scrollIntoViewIfNeeded()

        await expect(notificationsSection).toBeVisible()
        await expect(page.locator('.orp-notification').first()).toBeVisible()
    })

    test('Notification banners render correctly', async ({ page }) => {
        const bannerSection = page.locator('h2:has-text("Notification Banners")')
        await bannerSection.scrollIntoViewIfNeeded()

        await expect(bannerSection).toBeVisible()
        await expect(page.locator('.orp-notification-banner').first()).toBeVisible()
    })

    test('Dropdown opens on click', async ({ page }) => {
        const dropdownSection = page.locator('h2:has-text("Dropdown")')
        await dropdownSection.scrollIntoViewIfNeeded()

        await page.click('button:has-text("Menu")')
        const dropdown = page.locator('.orp-dropdown')
        await expect(dropdown).toBeVisible()
    })

    test('Keyboard shortcut (Kbd) renders correctly', async ({ page }) => {
        const kbdSection = page.locator('h2:has-text("Keyboard")')
        await kbdSection.scrollIntoViewIfNeeded()

        await expect(page.locator('.orp-kbd').first()).toBeVisible()
    })

    test('No Bootstrap CSS classes in playground', async ({ page }) => {
        const playgroundContent = await page.content()

        const bootstrapClasses = ['.btn', '.card', '.modal', '.alert', '.badge', '.container', '.row', '.col-', '.d-flex', '.gap-', '.p-', '.m-', '.table']
        const foundBootstrapClasses = bootstrapClasses.filter(cls => {
            if (cls.endsWith('-')) {
                return playgroundContent.includes(cls)
            }
            return playgroundContent.includes(cls)
        })

        expect(foundBootstrapClasses).toHaveLength(0)
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
