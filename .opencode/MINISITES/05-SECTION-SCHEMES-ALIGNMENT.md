# 05 - Alineación de Section Schemes

## Problema actual

Los schemes existen en CSS (`minisite.less`) pero los componentes no los aplican:

```css
/* minisite.less - existe pero no se usa */
.section--light { background: #ffffff; color: var(--brand-text); }
.section--dark { background: var(--brand-text); color: #ffffff; }
```

```vue
<!-- SectionServices.vue - no aplica scheme -->
<section class="section-services py-6">
  <div class="section-services__inner container">
    ...
  </div>
</section>
```

## Solución: composable `useThemeScheme`

```js
// resources/js/composables/useThemeScheme.js
export function useThemeScheme(scheme) {
  const schemeClass = computed(() => {
    const validSchemes = ['light', 'dark', 'primary', 'secondary', 'accent', 'gradient', 'neutral', 'transparent']
    return validSchemes.includes(scheme) ? `section--${scheme}` : 'section--light'
  })

  return { schemeClass }
}
```

## Uso en componentes

```vue
<template>
  <section class="section-services" :class="schemeClass">
    ...
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { useThemeScheme } from '@/composables/useThemeScheme'

const props = defineProps({
  config: {
    type: Object,
    default: () => ({})
  }
})

// config.scheme viene del backend
const { schemeClass } = useThemeScheme(props.config?.scheme)
</script>
```

## Backend: pasar scheme en config

En `BusinessController.php`, cada sección ya tiene `config`:

```php
// Ya existe en renderedSections
$data = [
  'id' => section.id,
  'type' => section.section_type,
  'title' => section.title,
  'config' => $section->config, // Incluye scheme si existe
]
```

Solo se necesita asegurar que `config.scheme` se guarde y lea correctamente.

## Section schemes hardcoded en controller

```php
// BusinessController.php - estos deben venir de la DB o theme config
'sectionSchemes' => [
  'hero' => 'gradient',
  'about' => 'light',
  'services' => 'neutral',
  // ...
],
```

**Acción**: Mover estos defaults al theme config (json) en vez de hardcoded.

## Plan de implementación

1. [ ] Crear `resources/js/composables/useThemeScheme.js`
2. [ ] Actualizar cada Section component para usar `useThemeScheme`
3. [ ] Asegurar que `config.scheme` se passe desde backend
4. [ ] Mover defaults de `sectionSchemes` a theme config

## Siguiente paso

Ver `06-BULMA-SCSS-UX-RESPONSIVE.md` para estandarizar SCSS.