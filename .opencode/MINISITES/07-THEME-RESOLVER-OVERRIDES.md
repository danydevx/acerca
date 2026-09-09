# 07 - Theme Resolver y Overrides

## Arquitectura actual

No existe Theme Resolver. `themes/base/` contiene páginas detalle, no themes.

## Arquitectura objetivo

```
resources/js/
├── composables/
│   └── useThemeResolver.js    # Resuelve theme activo
├── Pages/Minisite/
│   ├── themes/
│   │   ├── base/               # Theme base (default)
│   │   ├── professional/      # Theme variant
│   │   └── playful/           # Theme variant
│   └── components/
└── Components/Minisite/
    └── ThemeOverrides.vue      # Override por theme
```

## useThemeResolver composable

```js
// resources/js/composables/useThemeResolver.js
import { computed } from 'vue'

export function useThemeResolver(themeSlug) {
  // Theme configs cargados del backend
  const themes = {
    base: {
      name: 'Base',
      components: {
        SectionServices: { viewMode: 'carousel' },
        SectionAbout: { layout: 'centered' },
      },
      css: {}
    },
    professional: {
      name: 'Professional',
      components: {
        SectionServices: { viewMode: 'grid' },
        SectionAbout: { layout: 'left' },
      },
      css: {}
    }
  }

  const currentTheme = computed(() => {
    return themes[themeSlug?.value] || themes.base
  })

  const resolveComponentConfig = (componentName) => {
    return currentTheme.value.components?.[componentName] || {}
  }

  return {
    currentTheme,
    resolveComponentConfig
  }
}
```

## Override de componentes por theme

```vue
<!-- ThemeOverrideSectionServices.vue (professional theme) -->
<template>
  <section class="section-services section-services--grid" :class="schemeClass">
    <div class="section-services__inner container">
      <header v-if="title || subtitle" class="section-services__header">
        <h2 v-if="title" class="section-services__title">{{ title }}</h2>
        <p v-if="subtitle" class="section-services__subtitle">{{ subtitle }}</p>
      </header>

      <!-- Grid view en vez de carousel -->
      <div class="section-services__grid">
        <ServiceCard v-for="item in items" :key="item.id" :item="item" />
      </div>
    </div>
  </section>
</template>
```

## Theme override en Show.vue

```vue
<script setup>
import { useThemeResolver } from '@/composables/useThemeResolver'

const props = defineProps({
  theme: Object, // viene del backend: { slug: 'professional' }
  // ...
})

const { resolveComponentConfig } = useThemeResolver(
  computed(() => props.theme?.slug)
)

// Override config para components
const sectionServicesConfig = computed(() => ({
  ...props.config,
  ...resolveComponentConfig('SectionServices')
}))
</script>

<template>
  <MinisiteLayout>
    <SectionServices
      v-if="section.type === 'services'"
      v-bind="section"
      :config="sectionServicesConfig"
    />
    <!-- ... -->
  </MinisiteLayout>
</template>
```

## CSS overrides por theme

```scss
// En theme professional
.theme-professional {
  .section-services {
    &--grid {
      .section-services__grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }
  }
}
```

## Plan de implementación

1. [ ] Crear `useThemeResolver.js` composable
2. [ ] Definir estructura de `themes/` directory
3. [ ] Implementar ThemeOverrideSectionServices como demo
4. [ ] Conectar theme resolution en Show.vue

## Nota sobre themes/base

La carpeta actual `themes/base/` contiene páginas detalle tipo:
- `Services.vue` - Lista de servicios
- `ProductDetail.vue` - Detalle de producto

Estas NO son overrides de theme, sino páginas internas del minisite. Deben:
- Quedar en `themes/base/` (son páginas, no components)
- O moverse a `Pages/Minisite/` si el enrutamiento lo requiere

## Siguiente paso

Ver `08-SHARED-DEPENDENCIES.md` para unificar dependencias.