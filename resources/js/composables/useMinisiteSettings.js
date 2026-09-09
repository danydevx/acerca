import { computed } from 'vue'

export function useMinisiteSettings(setting, branding) {
  const primaryColor = computed(() => setting?.primary_color || branding?.primary_color || '#3B82F6')
  const secondaryColor = computed(() => setting?.secondary_color || branding?.secondary_color || '#6B7280')
  const accentColor = computed(() => setting?.accent_color || branding?.accent_color || '#10B981')
  const backgroundColor = computed(() => setting?.background_color || branding?.background_color || '#FFFFFF')
  const foregroundColor = computed(() => setting?.foreground_color || branding?.foreground_color || '#111827')

  const cardRadius = computed(() => setting?.card_radius || branding?.card_radius || 12)
  const buttonRadius = computed(() => setting?.button_radius || branding?.button_radius || 8)

  const cssVars = computed(() => ({
    '--dl-primary': primaryColor.value,
    '--dl-secondary': secondaryColor.value,
    '--dl-accent': accentColor.value,
    '--dl-background': backgroundColor.value,
    '--dl-foreground': foregroundColor.value,
    '--dl-card-radius': `${cardRadius.value}px`,
    '--dl-button-radius': `${buttonRadius.value}px`,
  }))

  return {
    primaryColor,
    secondaryColor,
    accentColor,
    backgroundColor,
    foregroundColor,
    cardRadius,
    buttonRadius,
    cssVars,
  }
}