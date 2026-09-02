import { ref, watch, onMounted } from 'vue'

const THEME_KEY = 'orp-ui-theme'

const currentTheme = ref('light')

export function useOrpTheme() {
    const setTheme = (theme) => {
        currentTheme.value = theme
        document.documentElement.setAttribute('data-orp-theme', theme)

        if (typeof localStorage !== 'undefined') {
            localStorage.setItem(THEME_KEY, theme)
        }
    }

    const toggleTheme = () => {
        setTheme(currentTheme.value === 'light' ? 'dark' : 'light')
    }

    const initTheme = () => {
        const stored = localStorage?.getItem(THEME_KEY)
        const systemDark = window.matchMedia?.('(prefers-color-scheme: dark)').matches

        const initial = stored || (systemDark ? 'dark' : 'light')
        setTheme(initial)
    }

    onMounted(() => {
        initTheme()
    })

    return {
        theme: currentTheme,
        setTheme,
        toggleTheme
    }
}
