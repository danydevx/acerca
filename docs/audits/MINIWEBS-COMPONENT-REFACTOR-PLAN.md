# MiniWebs Component Refactor Plan

**Date:** 2026-09-09
**Priority:** Based on audit findings

---

## Priority 0 (P0) — Inconsistencias Graves

### P0.1: Eliminar Bootstrap/Bulma residuals de templates

**Archivos:**
- `Dropdown.vue` — línea 5, 7, 14
- `FileInput.vue` — líneas 15-25
- `ImageInput.vue` — líneas 11, 14, 24
- `List.vue` — líneas 6, 15-30
- `AvatarUpload.vue` — líneas 17, 20
- `EmptyState.vue` — líneas 3-11
- `BookingScheduler.vue` — línea 76
- `PricingCard.vue` — línea 18
- `CatalogCard.vue` — líneas 34-35

**Acción:** Mover todas las clases Bulma (`is-*`, `has-*`, `p-*`, `m-*`, `button`) a SCSS con selectores BEM.

**Riesgo:** Low — son cambios de ubicación de estilos, no cambios visuales.

---

### P0.2: Unificar ServiceCard/ProductCard

**Archivos:**
- `beauty/BeautyServiceCard.vue`
- `spa/SpaServiceCard.vue`
- `medical/MedicalServiceCard.vue`
- `products/ProductCard.vue`
- `services/ServiceCard.vue`

**Acción:** Crear un componente base `ServiceCard.vue` con variantes via props/slots. Mover variables `--beauty-*`, `--spa-*`, `--med-*` a theme.

**Riesgo:** Medium — cambio de contrato de props.

---

### P0.3: Reemplazar colores hardcoded white/black

**Archivos:**
- `Gallery.vue` — 3x white
- `ErrorState.vue` — white
- `SuccessState.vue` — white
- `Timeline.vue` — white
- `HeroFullBleed.vue` — 6x white
- `HeroOverlayVariant.vue` — 3x white

**Acción:** Reemplazar `white` con `var(--bulma-text-invert)` o tokens `--dl-*`.

**Riesgo:** Low — cambio de variable CSS.

---

## Priority 1 (P1) — Bulma / Spacing / Colors

### P1.1: Normalizar dimensiones hardcoded px

| Archivo | Línea | Valor actual | Sugerencia |
|---------|-------|-------------|------------|
| `EventCard.vue` | 179 | `160px` | `10rem` |
| `CatalogCard.vue` | 84 | `200px` | `12.5rem` |
| `MiniCalendar.vue` | 167 | `320px` | `20rem` |
| `MiniCalendar.vue` | 240 | `280px` | `17.5rem` |
| `Drawer.vue` | 48 | `300px` | `18.75rem` |
| `Popover.vue` | 42 | `200px` | `12.5rem` |
| `Map.vue` | 34 | `300px` | `18.75rem` (prop) |

**Riesgo:** Low.

---

### P1.2: Fix BEM violations

| Archivo | Issue | Fix |
|---------|-------|-----|
| `Callout.vue` | `.callout-icon` | `.callout__icon` |
| `CatalogPricing.vue` | `&-original` | `&__original` |
| `CatalogPricing.vue` | `&-current` | `&__current` |
| `HorizontalScroll.vue` | `dl-bulma-horizontal-scroll` | `ui-horizontal-scroll` |
| `Avatar.vue` | `ui-avatar` + `dl-bulma-avatar` | Elegir uno |
| `EmptyState.vue` | `ui-empty-state` + `dl-bulma-empty-state` | Elegir uno |

**Riesgo:** Low.

---

### P1.3: Reemplazar px en border-radius

| Archivo | Línea | Valor actual | Sugerencia |
|---------|-------|-------------|------------|
| `Drawer.vue` | 70 | `4px` | `var(--bulma-radius-small)` |
| `FileInput.vue` | 76, 121, 132 | `12px`, `6px`, `4px` | `var(--bulma-radius)` |
| `MedicalServiceCard.vue` | 93, 143, 160, 263 | `12px`, `10px`, `3px`, `6px` | `var(--bulma-radius-small)` |
| `UiDialog.vue` | 151 | `12px` | `var(--bulma-radius-large)` |

**Riesgo:** Low.

---

### P1.4: Extraer box-shadows recurrentes a variables

Los heroes tienen patrones repetidos:
```
0 4px 12px oklch(0 0 0 / 0.08) — HeroCentered, HeroClassic, HeroSplit, HeroBusiness, HeroMinimal
0 8px 32px oklch(0 0 0 / 0.12) — HeroFloating
0 -4px 20px oklch(0 0 0 / 0.15) — ActionSheet, UiSheet
```

**Acción:** Crear tokens CSS:
```css
--dl-shadow-sm: 0 4px 12px oklch(0 0 0 / 0.08);
--dl-shadow-md: 0 8px 32px oklch(0 0 0 / 0.12);
--dl-shadow-elevated: 0 -4px 20px oklch(0 0 0 / 0.15);
```

**Riesgo:** Low.

---

### P1.5: Reemplazar rgba hardcoded

| Archivo | Línea | Valor actual | Sugerencia |
|---------|-------|-------------|------------|
| `ImageInput.vue` | 120 | `rgba(0, 0, 0, 0.5)` | `var(--dl-overlay)` |
| `AvatarUpload.vue` | 90 | `oklch(0 0 0 / 0.5)` | `var(--dl-overlay)` |
| `ProgressBar.vue` | 181-186 | `rgba(255, 255, 255, 0.15)` | `var(--dl-stripe)` |
| `ProgressBar.vue` | 208 | `rgba(0, 0, 0, 0.2)` | Usar text-shadow de Bulma |

**Riesgo:** Low.

---

## Priority 2 (P2) — Componentización

### P2.1: Unificar State Components

`EmptyState`, `ErrorState`, `SuccessState`, `OfflineState` tienen estructura idéntica.

**Acción:** Crear `StateBase.vue` con slots para icon, title, message, actions.

**Riesgo:** Medium — requiere testing de cada variante.

---

### P2.2: Unificar Price Components

`Price.vue`, `CatalogPricing.vue`, `ProductPrice.vue` son similares.

**Acción:** Crear `PriceDisplay.vue` reusable.

**Riesgo:** Low.

---

### P2.3: Extraer Hero box-shadow a variable

**Acción:** En `_variables.scss` agregar:
```scss
--dl-hero-shadow: 0 4px 12px oklch(0 0 0 / 0.08);
--dl-hero-shadow-elevated: 0 8px 32px oklch(0 0 0 / 0.12);
```

**Riesgo:** Low.

---

## Priority 3 (P3) — Limpieza

### P3.1: Normalizar font-sizes

Muchos componentes tienen font-sizes hardcoded que podrían usar `is-size-*` de Bulma.

**Acción:** Reemplazar `font-size: Xrem` con clases `is-size-X` donde sea posible.

**Riesgo:** Low.

---

### P3.2: Consolidar padding/margin

**Acción:** Donde `padding: 1rem` → usar `p-4` de Bulma.

**Riesgo:** Low.

---

### P3.3: Documentar tokens faltantes

Tokens que deberían existir pero no estándocumentados:
- `--dl-overlay`
- `--dl-stripe`
- `--dl-shadow-sm`, `--dl-shadow-md`, `--dl-shadow-elevated`
- `--dl-text-invert` (para usar en lugar de `white`)

---

## Plan de Ejecución

### Fase 1: LOW RISK (Riesgo bajo, impacto alto)
1. P0.3 — Reemplazar colores hardcoded white/black
2. P1.1 — Normalizar dimensiones px→rem
3. P1.2 — Fix BEM violations
4. P1.3 — Reemplazar border-radius px
5. P1.5 — Reemplazar rgba hardcoded
6. P1.4 — Extraer box-shadows a variables

### Fase 2: MEDIUM RISK (Riesgo medio)
1. P0.1 — Eliminar Bootstrap/Bulma residuals
2. P2.2 — Unificar Price components
3. P2.3 — Extraer Hero box-shadow

### Fase 3: REFACTOR (Riesgo medio-alto)
1. P0.2 — Unificar ServiceCard (requiere testing)
2. P2.1 — Unificar State components

---

## Métricas Objetivo

| Métrica | Actual | Objetivo |
|---------|--------|----------|
| Componentes con Bootstrap residuals | 9 | 0 |
| Colores hardcoded (white/black) | 18 | 0 |
| BEM violations | 5 | 0 |
| px values no justificables | 25+ | < 10 |
| Componentes duplicados | 5+ | 0 |

---

## Verificación

Después de cada fase:
```bash
npm run build
```

---

*Plan generado por auditoría automática*
