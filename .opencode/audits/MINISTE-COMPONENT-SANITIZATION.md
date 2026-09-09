# Minisite Component Sanitization Report

**Date:** 2026-09-04
**Phase:** 1 - Hardcoded Labels & Duplication
**Scope:** `resources/js/Pages/Minisite/components/`

---

## Summary

| Category | Found | Fixed | Remaining |
|----------|-------|-------|-----------|
| Hardcoded labels | 8 | 6 | 2 |
| WhatsApp URL duplication | 3 files | 0 | 3 |
| Hardcoded menu items | 1 file | 1 | 0 |

---

## Changes Applied

### 1. Created Utility: `utils/whatsApp.js`

Shared utility for building WhatsApp URLs. Located at:
```
resources/js/Pages/Minisite/components/utils/whatsApp.js
```

**Not yet integrated** into ProductDetailModal, ServiceDetailModal, SectionPackages (see remaining issues).

---

### 2. NavigationMenu.vue

**Issue:** Hardcoded `menuOrder` array with Spanish labels and fixed URLs.

**Fix:** Added `menuItems` prop. If provided, uses it directly. Otherwise, falls back to computed menu from `business` + `existingSections`.

```javascript
// New prop
menuItems: {
  type: Array,
  default: null,  // null = use computed menu
}
```

**Usage:**
```vue
<!-- Default behavior (unchanged) -->
<NavigationMenu :business="business" :existing-sections="sections" />

<!-- Custom menu items -->
<NavigationMenu :business="business" :existing-sections="sections" :menu-items="customMenu" />
```

---

### 3. SectionProducts.vue

**Issue:** Hardcoded labels "Sin productos", "Ver todos los productos".

**Fix:** Added `labels` prop with defaults:

```javascript
labels: {
  type: Object,
  default: () => ({
    empty: 'Sin productos',
    emptyDescription: 'No hay productos disponibles en este momento.',
    viewAll: 'Ver todos los productos',
  }),
}
```

---

### 4. SectionServices.vue

**Issue:** Hardcoded labels "Sin servicios", "Ver todos los servicios".

**Fix:** Added `labels` prop with defaults:

```javascript
labels: {
  type: Object,
  default: () => ({
    empty: 'Sin servicios',
    emptyDescription: 'No hay servicios disponibles en este momento.',
    viewAll: 'Ver todos los servicios',
  }),
}
```

---

### 5. ProductCard.vue

**Issue:** Hardcoded "Agotado" label.

**Fix:** Added `labels.outOfStock` prop:

```javascript
labels: {
  type: Object,
  default: () => ({
    outOfStock: 'Agotado',
  }),
}
```

---

### 6. ProductListItem.vue

**Issue:** Hardcoded "En stock" / "Agotado" labels.

**Fix:** Added `labels.inStock` and `labels.outOfStock` props:

```javascript
labels: {
  type: Object,
  default: () => ({
    inStock: 'En stock',
    outOfStock: 'Agotado',
  }),
}
```

---

## Remaining Issues

### WhatsApp URL Duplication (3 files)

| File | Line | Pattern |
|------|------|---------|
| ProductDetailModal.vue | ~75 | `https://wa.me/${product.whatsapp_contact}?text=...` |
| ServiceDetailModal.vue | ~65 | `https://wa.me/${service.whatsapp_contact}?text=...` |
| SectionPackages.vue | ~57 | `https://wa.me/${item.whatsapp}?text=...` |

**Action:** Refactor to use `utils/whatsApp.js`:
```javascript
import { buildWhatsAppUrl } from './utils/whatsApp'

// Usage
const url = buildWhatsAppUrl(item.whatsapp, 'Hola, me interesa...')
```

---

### Pre-existing Build Error

**File:** `resources/js/Pages/Public/Playground.vue`
**Issue:** Case-sensitive import path: `hero/HeroLeft.vue` should be `HeroLeft.vue`

```
Could not load /resources/js/Pages/Minisite/components/hero/HeroLeft.vue
```

**Status:** OUT OF SCOPE for this phase. Requires separate fix.

---

## Files Modified

| File | Changes |
|------|---------|
| `components/utils/whatsApp.js` | Created |
| `components/NavigationMenu.vue` | Added `menuItems` prop |
| `components/SectionProducts.vue` | Added `labels` prop |
| `components/SectionServices.vue` | Added `labels` prop |
| `components/ProductCard.vue` | Added `labels.outOfStock` |
| `components/ProductListItem.vue` | Added `labels.inStock`, `labels.outOfStock` |

---

## Build Status

**Build error exists** but is **pre-existing** and unrelated to these changes:
- Error in `Playground.vue` - case-sensitive path issue

All edited files are syntactically valid.

---

## Next Phase Recommendations

1. Integrate `whatsApp.js` utility into ProductDetailModal, ServiceDetailModal, SectionPackages
2. Add `labels` props to ServiceCard and ServiceListItem (likely same pattern as ProductCard/ProductListItem)
3. Fix pre-existing Playground.vue import path
4. Audit ServiceDetailModal for hardcoded labels
5. Audit ProductDetailModal for hardcoded labels
