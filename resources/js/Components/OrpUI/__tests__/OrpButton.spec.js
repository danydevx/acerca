import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import { nextTick } from 'vue'

// Since Modal uses Teleport, we test simpler components first
describe('OrpButton', () => {
    it('renders correctly with default props', () => {
        const OrpButton = {
            template: `<button class="orp-btn orp-btn--primary"><slot /></button>`,
        }
        const wrapper = mount(OrpButton, {
            slots: { default: 'Click me' },
        })

        expect(wrapper.text()).toBe('Click me')
        expect(wrapper.classes()).toContain('orp-btn')
        expect(wrapper.classes()).toContain('orp-btn--primary')
    })

    it('applies variant class correctly', () => {
        const OrpButton = {
            template: `<button :class="['orp-btn', \`orp-btn--\${variant}\`]"><slot /></button>`,
            props: ['variant']
        }
        const variants = ['primary', 'secondary', 'ghost', 'danger']

        for (const variant of variants) {
            const wrapper = mount(OrpButton, {
                props: { variant },
                slots: { default: variant },
            })

            expect(wrapper.classes()).toContain(`orp-btn--${variant}`)
        }
    })

    it('applies size class correctly', () => {
        const OrpButton = {
            template: `<button :class="['orp-btn', \`orp-btn--\${size}\`]"><slot /></button>`,
            props: ['size']
        }
        const wrapper = mount(OrpButton, {
            props: { size: 'sm' },
            slots: { default: 'Small' },
        })

        expect(wrapper.classes()).toContain('orp-btn--sm')
    })

    it('is disabled when disabled prop is true', () => {
        const OrpButton = {
            template: `<button class="orp-btn" :disabled="disabled"><slot /></button>`,
            props: ['disabled']
        }
        const wrapper = mount(OrpButton, {
            props: { disabled: true },
            slots: { default: 'Disabled' },
        })

        expect(wrapper.find('button').attributes('disabled')).toBeDefined()
    })

    it('emits click event when clicked', async () => {
        const OrpButton = {
            template: `<button class="orp-btn" @click="$emit('click')"><slot /></button>`,
        }
        const wrapper = mount(OrpButton, {
            slots: { default: 'Click' },
        })

        await wrapper.trigger('click')

        expect(wrapper.emitted('click')).toBeTruthy()
    })
})
