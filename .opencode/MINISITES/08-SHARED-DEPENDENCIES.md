# 08 - Dependencias Compartidas

## Inventario actual

### NPM packages usados en minisite
- `bulma` - Framework CSS
- `glightbox` - Galería lightbox
- `@popperjs/core` - Tooltips/popovers (dependencia de Bulma)

### Iconos
- Bootstrap Icons (`bi bi-*`) via CDN o npm

### Vue composables/hooks
- No hay estructura compartida actual
- `useCart` importado de `@/composables/useCart`

## Decisiones

### 1. Mantener Bulma

Bulma se mantiene. No se migra a Tailwind u otro framework.

### 2. Estructura de shared

```
resources/js/
├── composables/
│   ├── useThemeScheme.js      # Section schemes
│   ├── useThemeResolver.js    # Theme resolution
│   ├── useMinisiteSettings.js  # Settings del negocio
│   └── useCart.js              # Ya existe
└── utils/
    ├── colors.js               # Helper de colores
    └── format.js               # Formatters (precio, fecha)
```

### 3. Dependencias a consolidar

| Dependencia | Uso | Decisión |
|-------------|-----|----------|
| bulma | CSS framework | Mantener |
| glightbox | Lightbox | Mantener |
| bootstrap-icons | Iconos | Mantener |
| @popperjs/core | Popovers | Bulma ya incluye |

### 4. No agregar dependencias nuevas

El roadmap indica no crear nuevas dependencias sin necesidad.

## useMinisiteSettings composable

```js
// resources/js/composables/useMinisiteSettings.js
import { computed } from 'vue'

export function useMinisiteSettings(business, settings) {
  const primaryColor = computed(() => settings?.primary_color || '#3B82F6')
  const cardRadius = computed(() => settings?.card_radius || 12)
  const buttonRadius = computed(() => settings?.button_radius || 8)

  const cssVars = computed(() => ({
    '--dl-primary': primaryColor.value,
    '--dl-card-radius': `${cardRadius.value}px`,
    '--dl-button-radius': `${buttonRadius.value}px`,
  }))

  return { primaryColor, cardRadius, buttonRadius, cssVars }
}
```

## useCart ya existe

```js
// @/composables/useCart.js - ya existe
import { useCart } from '@/composables/useCart'
```

## Utils compartidos

```js
// resources/js/utils/format.js
export function formatPrice(amount, currency = 'USD') {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency,
  }).format(amount)
}

export function formatDuration(minutes) {
  if (minutes < 60) return `${minutes}min`
  const hours = Math.floor(minutes / 60)
  const mins = minutes % 60
  return mins > 0 ? `${hours}h ${mins}min` : `${hours}h`
}
```

## Plan de implementación

1. [ ] Crear `resources/js/composables/useThemeScheme.js`
2. [ ] Crear `resources/js/composables/useThemeResolver.js`
3. [ ] Crear `resources/js/composables/useMinisiteSettings.js`
4. [ ] Crear `resources/js/utils/format.js`
5. [ ] Verificar que imports funcionan correctamente

## Siguiente paso

Ver `09-CLEANUP-LEGACY.md` para limpiar código obsoleto.