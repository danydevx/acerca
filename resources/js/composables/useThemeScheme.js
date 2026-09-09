import { computed } from 'vue'

const VALID_SCHEMES = ['light', 'dark', 'primary', 'secondary', 'accent', 'gradient', 'neutral', 'transparent']

export function useThemeScheme(scheme) {
  const schemeClass = computed(() => {
    const schemeValue = typeof scheme === 'function' ? scheme() : scheme
    if (!schemeValue || !VALID_SCHEMES.includes(schemeValue)) {
      return 'section--light'
    }
    return `section--${schemeValue}`
  })

  return { schemeClass, VALID_SCHEMES }
}