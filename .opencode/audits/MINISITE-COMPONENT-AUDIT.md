# MINISITE COMPONENT AUDIT REPORT

## Summary

```
Total componentes encontrados: 47
READY: 18
MINOR: 8
REFACTOR: 3
LEGACY: 6
DUPLICATE: 2

Con props: 29
Sin props: 0 (todos tienen props)
Con emits: 15
Con slots: 4
Con v-model: 6

Con Bootstrap residual: 6 (old_components)
Con contenido hardcodeado: 8
Con llamadas API directas: 0
Componentes monolíticos: 2
```

---

## MATRIX DE COMPONENTES

| Component | Type | Props | Emits | Slots | Hardcoded | Bootstrap | Status |
|-----------|------|-------|-------|-------|-----------|-----------|--------|
| ProductCard | Domain | YES | YES | NO | NO | NO | READY |
| ServiceCard | Domain | YES | YES | NO | NO | NO | READY |
| ProductListItem | Structure | YES | YES | NO | NO | NO | READY |
| ServiceListItem | Structure | YES | YES | NO | NO | NO | READY |
| ProductDetailModal | Domain | YES | YES | NO | NO | NO | READY |
| ServiceDetailModal | Domain | YES | YES | NO | NO | NO | READY |
| SectionProducts | Section | YES | YES | NO | NO | NO | READY |
| SectionServices | Section | YES | YES | NO | NO | NO | READY |
| SectionGallery | Section | YES | YES | NO | NO | NO | READY |
| SectionLocations | Section | YES | YES | NO | NO | NO | READY |
| SectionReviews | Section | YES | YES | NO | YES | NO | MINOR |
| SectionContactForm | Section | YES | YES | YES | NO | NO | READY |
| SectionAppointments | Section | YES | YES | NO | NO | NO | READY |
| SectionAvailability | Section | YES | YES | NO | NO | NO | READY |
| SectionFaqs | Section | YES | YES | NO | NO | NO | READY |
| SectionFeatures | Section | YES | YES | NO | NO | NO | READY |
| SectionAbout | Section | YES | YES | NO | NO | NO | READY |
| SectionPackages | Section | YES | YES | NO | NO | NO | READY |
| SectionPromotions | Section | YES | YES | NO | NO | NO | READY |
| SectionRestaurantMenu | Section | YES | YES | NO | NO | NO | READY |
| SectionHero | Section | YES | YES | NO | NO | NO | READY |
| MinisiteLayout | Layout | YES | NO | YES | NO | NO | READY |
| NavigationMenu | Layout | YES | YES | NO | NO | NO | MINOR |
| Footer | Layout | YES | NO | NO | NO | NO | READY |
| HeroLeft | Layout | YES | NO | NO | NO | NO | READY |
| HeroCenter | Layout | YES | NO | NO | NO | NO | READY |
| HeroRight | Layout | YES | NO | NO | NO | NO | READY |
| HeroSimple | Layout | YES | NO | NO | NO | NO | READY |
| themes/base/Show | Theme | YES | NO | NO | NO | NO | READY |
| themes/base/Products | Theme | YES | YES | NO | NO | NO | READY |
| themes/base/Services | Theme | YES | YES | NO | NO | NO | READY |
| themes/base/Menu | Theme | YES | YES | NO | NO | NO | READY |
| themes/base/Gallery | Theme | YES | YES | NO | NO | NO | READY |
| themes/base/Locations | Theme | YES | YES | NO | NO | NO | READY |
| themes/base/Reviews | Theme | YES | YES | NO | NO | NO | READY |
| themes/base/Contact | Theme | YES | YES | NO | NO | NO | READY |
| themes/base/Appointments | Theme | YES | YES | NO | NO | NO | READY |
| themes/base/ProductDetail | Theme | YES | YES | NO | NO | NO | READY |
| themes/base/ServiceDetail | Theme | YES | YES | NO | NO | NO | READY |
| themes/base/Promotions | Theme | YES | YES | NO | NO | NO | READY |
| themes/base/PromotionDetail | Theme | YES | YES | NO | NO | NO | READY |
| themes/base/Faqs | Theme | YES | YES | NO | NO | NO | READY |
| themes/base/Properties | Theme | YES | YES | NO | NO | NO | READY |
| themes/base/PropertyDetail | Theme | YES | YES | NO | NO | NO | READY |
| old_components/products/ProductCard | LEGACY | YES | YES | NO | NO | YES | LEGACY |
| old_components/products/ProductListItem | LEGACY | YES | YES | NO | NO | YES | LEGACY |
| old_components/products/ProductDetailModal | LEGACY | YES | YES | NO | NO | YES | LEGACY |

---

## DETALLE POR COMPONENTE

### ProductCard.vue
**Path:** `resources/js/Pages/Minisite/components/ProductCard.vue`
**Type:** Domain Component
**Status:** READY

**Current Props:**
- item: Object (required)
- showImage: Boolean (default: true)
- showPrice: Boolean (default: true)
- showComparePrice: Boolean (default: true)
- showDescription: Boolean (default: false)
- showStock: Boolean (default: false)
- carousel: Boolean (default: false)

**Current Emits:**
- details

**Hardcoded:** NONE
**Bootstrap:** NONE

**Analysis:** Well-structured component. Uses ORP design tokens. Can receive data from Laravel via props. Clean BEM naming.

---

### ServiceCard.vue
**Path:** `resources/js/Pages/Minisite/components/ServiceCard.vue`
**Type:** Domain Component
**Status:** READY

**Current Props:**
- item: Object (required)
- showImage: Boolean (default: true)
- showPrice: Boolean (default: true)
- showDescription: Boolean (default: false)
- carousel: Boolean (default: false)

**Current Emits:**
- details

**Hardcoded:** NONE
**Bootstrap:** NONE

**Missing Props:**
- showComparePrice (not applicable to services)

**Analysis:** Similar structure to ProductCard. Clean implementation.

---

### ProductListItem.vue
**Path:** `resources/js/Pages/Minisite/components/ProductListItem.vue`
**Type:** Structure Component
**Status:** READY

**Current Props:**
- item: Object (required)
- showImage: Boolean (default: true)
- showPrice: Boolean (default: true)
- showComparePrice: Boolean (default: true)
- showDescription: Boolean (default: false)
- showStock: Boolean (default: false)

**Current Emits:**
- details

**Hardcoded:** "En stock", "Agotado" labels
**Bootstrap:** NONE

---

### ServiceListItem.vue
**Path:** `resources/js/Pages/Minisite/components/ServiceListItem.vue`
**Type:** Structure Component
**Status:** READY

**Current Props:**
- item: Object (required)
- showImage: Boolean (default: true)
- showPrice: Boolean (default: true)
- showDescription: Boolean (default: false)

**Current Emits:**
- details

**Hardcoded:** "Anticipo", "min" labels
**Bootstrap:** NONE

---

### ProductDetailModal.vue
**Path:** `resources/js/Pages/Minisite/components/ProductDetailModal.vue`
**Type:** Domain Component
**Status:** READY

**Current Props:**
- modelValue: Boolean
- product: Object (default: null)
- businessSlug: String
- orderSettings: Object
- showStock: Boolean (default: false)

**Current Emits:**
- update:modelValue
- close

**Hardcoded:** "Agregar al carrito", "Contactar por WhatsApp", "Ver información completa", WhatsApp URL pattern
**Bootstrap:** NONE

**v-model:** YES (correct implementation)

**API Dependency:** Uses useCart composable internally

---

### ServiceDetailModal.vue
**Path:** `resources/js/Pages/Minisite/components/ServiceDetailModal.vue`
**Type:** Domain Component
**Status:** READY

**Current Props:**
- modelValue: Boolean
- service: Object (default: null)
- businessSlug: String

**Current Emits:**
- update:modelValue
- close

**Hardcoded:** "Reservar ahora", "Contactar por WhatsApp", "Ver información completa", "Anticipo", "Reserva online"
**Bootstrap:** NONE

**v-model:** YES (correct implementation)

---

### SectionProducts.vue
**Path:** `resources/js/Pages/Minisite/components/SectionProducts.vue`
**Type:** Section
**Status:** READY

**Current Props:**
- title: String
- subtitle: String
- description: String
- items: Array (default: [])
- config: Object (default: {})
- buttons: Array (default: [])
- businessSlug: String
- orderSettings: Object

**Current Emits:**
- None directly, but manages internal state

**Slots:** YES - uses slot for content projection via `<slot />`

**Hardcoded:** "Sin productos", "No hay productos disponibles en este momento.", "Ver todos los productos"
**Bootstrap:** NONE

**Internal State:**
- selectedProduct (ref)
- showProductModal (computed v-model)

**Monolithic Candidate:** Contains ProductCard, ProductListItem, ProductDetailModal orchestration

---

### SectionServices.vue
**Path:** `resources/js/Pages/Minisite/components/SectionServices.vue`
**Type:** Section
**Status:** READY

**Current Props:**
- title: String
- subtitle: String
- description: String
- items: Array (default: [])
- config: Object (default: {})
- buttons: Array (default: [])
- businessSlug: String

**Hardcoded:** "Sin servicios", "No hay servicios disponibles en este momento.", "Ver todos los servicios"
**Bootstrap:** NONE

---

### MinisiteLayout.vue
**Path:** `resources/js/Pages/Minisite/components/MinisiteLayout.vue`
**Type:** Layout
**Status:** READY

**Current Props:**
- business: Object (required)
- heroLayout: String (default: 'left')
- heroTitle: String
- heroSubtitle: String
- heroBackgroundImage: String
- heroShowSocial: Boolean
- footerText: String
- footerShowSocial: Boolean
- socialNetworks: Array

**Slots:** YES - `<slot />` for content projection

**Hardcoded:** NONE
**Bootstrap:** NONE

**API Dependency:** Calls window.Analytics.init on mount

---

### NavigationMenu.vue
**Path:** `resources/js/Pages/Minisite/components/NavigationMenu.vue`
**Type:** Layout
**Status:** MINOR

**Current Props:**
- business: Object
- existingSections: Array

**Current Emits:**
- sectionClick

**Hardcoded:** Menu item labels may be hardcoded
**Bootstrap:** NONE

**Missing Documentation:** Need to audit full component

---

### HeroCenter.vue
**Path:** `resources/js/Pages/Minisite/components/HeroCenter.vue`
**Type:** Layout
**Status:** READY

**Current Props:**
- business: Object
- title: String
- subtitle: String
- backgroundImage: String
- showSocial: Boolean (default: false)
- socialNetworks: Array

**Hardcoded:** Social icon mapping (facebook, instagram, twitter, etc.)
**Bootstrap:** NONE

---

## old_components - LEGACY COMPONENTS

### old_components/products/ProductCard.vue
**Path:** `resources/js/Pages/Minisite/old_components/products/ProductCard.vue`
**Type:** LEGACY
**Status:** LEGACY

**Issues:**
- Uses Bootstrap classes: `card`, `card-image`, `card-content`, `tag`, `is-danger`, `is-light`, `is-clickable`
- Uses Bulma classes: `image is-4by3`, `has-background-grey-light`
- Mixed Bootstrap/Bulma - NOT proper Minisite component
- Should be replaced with new ProductCard.vue

---

### old_components/products/ProductListItem.vue
**Status:** LEGACY
**Issues:** Same as above - uses Bootstrap classes

---

### old_components/products/ProductDetailModal.vue
**Status:** LEGACY
**Issues:** Uses Bootstrap modal classes

---

## PRIORITIZACIÓN

### P0 - Bloqueantes
1. **old_components still in use** - These legacy Bootstrap components may be imported somewhere in the codebase. Need to verify they're not being used.

### P1 - Importantes
1. **SectionProducts/SectionServices hardcoded labels** - "Sin productos", "Ver todos los productos" should be configurable via props or i18n
2. **WhatsApp URL hardcoded** - Pattern `https://wa.me/${number}?text=...` is duplicated across modals
3. **NavigationMenu emits** - Unclear what sectionClick emit does

### P2 - Mejoras
1. **ProductCard/ServiceCard duplication** - Both share ~80% identical structure. Consider extracting common base or shared structure components
2. **Price formatting locale hardcoded** - All components use `locale: 'es-MX'`. Should be configurable
3. **Section orchestration** - Sections like SectionProducts contain too much logic (view mode switching, modal management)

### P3 - Opcionales
1. **Hero variants** - HeroLeft, HeroCenter, HeroRight have duplicated styles
2. **Slots usage** - Only MinisiteLayout and SectionContactForm use slots. Others could benefit

---

## COMPONENTES MONOLÍTICOS CANDIDATOS A SEPARACIÓN

### SectionProducts.vue (298 lines)
Contains:
- ProductCard rendering (grid/carousel/list modes)
- ProductListItem rendering
- ProductDetailModal orchestration
- View mode logic
- Empty state handling
- Button rendering

**Recommendation:** Extract:
- ProductCardGrid.vue
- ProductCardCarousel.vue
- ProductCardList.vue
- Keep SectionProducts as orchestrator only

### SectionServices.vue (284 lines)
Same structure issues as SectionProducts

---

## MAPA DE DEPENDENCIAS

```
MinisiteLayout
├── HeroLeft/HeroCenter/HeroRight
├── NavigationMenu
├── [slot] ← Sections rendered here
│   ├── SectionProducts
│   │   ├── ProductCard
│   │   ├── ProductListItem
│   │   └── ProductDetailModal
│   ├── SectionServices
│   │   ├── ServiceCard
│   │   ├── ServiceListItem
│   │   └── ServiceDetailModal
│   ├── SectionGallery
│   ├── SectionLocations
│   ├── SectionReviews
│   ├── SectionContactForm
│   ├── SectionAppointments
│   ├── SectionAvailability
│   ├── SectionFaqs
│   ├── SectionFeatures
│   ├── SectionAbout
│   ├── SectionPackages
│   ├── SectionPromotions
│   └── SectionRestaurantMenu
└── Footer

themes/base/Show (orchestrator)
├── NavigationMenu
├── MinisiteLayout
└── Sections...
```

---

## HALLAZGOS ADICIONALES

### Bootstrap Residual (OLD_COMPONENTS)
6 components in `old_components/` still use Bootstrap classes:
- `card`, `card-image`, `card-content`
- `tag`, `is-danger`, `is-light`
- `has-background-*`, `has-text-*`
- `mb-2`, `ml-2`, `mt-3`, `p-3`

### ORP Design Tokens Used
Components properly use ORP tokens:
- `--orp-surface`, `--orp-surface-foreground`
- `--orp-surface-muted`
- `--orp-primary`
- `--orp-success`, `--orp-warning`
- `--orp-border`
- `--orp-radius-*`
- `--orp-space-*`
- `--orp-duration-*`
- `--orp-font-size-*`

### BEM Compliance
Most components follow BEM naming:
- `product-card__media`, `product-card__image`
- `service-card__body`, `service-card__title`

Some inconsistencies found in old_components.

---

## RECOMENDACIONES DE PRÓXIMA FASE

1. **Verify old_components usage** - Search codebase for imports from `old_components/`
2. **Standardize price formatting** - Extract `usePriceFormatter` locale configuration
3. **Extract shared card logic** - ProductCard and ServiceCard share ~80% code
4. **Add i18n support** - Hardcoded labels should use translation system
5. **Section refactoring** - Extract view-mode components from SectionProducts/SectionServices
6. **WhatsApp URL builder** - Create shared utility for WhatsApp link generation
