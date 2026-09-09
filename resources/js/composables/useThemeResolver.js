import { computed } from 'vue'

const THEMES = {
  base: {
    name: 'Base',
    components: {
      SectionServices: { viewMode: 'carousel', showImage: true, showPrice: true },
      SectionAbout: { layout: 'centered', showImage: true, showDescription: true },
      SectionGallery: { viewMode: 'grid', showCaptions: true },
      SectionFeatures: { columns: 3 },
    },
  },
  professional: {
    name: 'Professional',
    components: {
      SectionServices: { viewMode: 'grid', showImage: true, showPrice: true },
      SectionAbout: { layout: 'left', showImage: true, showDescription: true },
      SectionGallery: { viewMode: 'carousel', showCaptions: false },
      SectionFeatures: { columns: 4 },
    },
  },
}

export function useThemeResolver(themeSlug) {
  const slug = computed(() => {
    if (!themeSlug) return 'base'
    if (typeof themeSlug === 'function') return themeSlug()
    if (typeof themeSlug === 'object') return themeSlug.value
    return themeSlug
  })

  const currentTheme = computed(() => {
    return THEMES[slug.value] || THEMES.base
  })

  const resolveComponentConfig = (componentName) => {
    return currentTheme.value.components?.[componentName] || {}
  }

  return {
    currentTheme,
    resolveComponentConfig,
    THEMES,
  }
}