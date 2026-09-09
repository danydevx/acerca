# ORPUI → BULMA MIGRATION

## Objetivo

Migrar todos los componentes, estilos, tokens y consumidores de **OrpUI** dentro de `resources/js/Pages/Minisite` hacia la arquitectura oficial del proyecto basada en:

```text
Bulma SCSS
→ Theme API --dl-*
→ Section Context --dl-section-*
→ BEM
→ SCSS UX/específico
→ Vue
```

Esta tarea es una **migración arquitectónica**, no un rediseño.

Preservar en lo posible:
- comportamiento;
- datos;
- responsive;
- accesibilidad;
- eventos;
- props funcionales;
- slots;
- estados;
- apariencia actual cuando sea razonable.

---

# 1. PRINCIPIO CENTRAL

OrpUI deja de funcionar como framework/primitives propios.

Bulma será el framework CSS base.

NO realizar una migración de nombres como:

```text
OrpButton → DlButton
OrpCard → DlCard
OrpGrid → DlGrid
OrpStack → DlStack
OrpSurface → DlSurface
```

Eso sólo recrearía OrpUI con otro namespace.

La migración correcta es:

```text
Componente OrpUI
      ↓
Auditar responsabilidad
      ↓
¿Bulma ya lo resuelve?
      ├── Sí → usar Bulma
      └── No → determinar si es componente funcional o de dominio
```

---

# 2. AUDITAR ANTES DE MODIFICAR

Antes de eliminar o reemplazar cualquier componente, crear un inventario completo.

Buscar como mínimo:

```text
Orp*.vue
orp-
.orp-
--orp-
@orp-
imports de OrpUI
exports/barrels de OrpUI
consumidores de OrpUI
mixins/helpers ORP
utilities ORP
LESS/SCSS ORP
themes que dependan de ORP
```

Revisar también imports dinámicos y resolvers.

## Entregable de auditoría

Crear una matriz:

| Componente ORP | Tipo | Consumidores | Bulma equivalente | Acción | Riesgo |
|---|---|---|---|---|---|
| OrpButton | primitive | ... | `.button` | replace | low |
| OrpCard | primitive | ... | `.card` | replace | low |
| OrpModal | functional | ... | `.modal` | refactor | medium |
| OrpContactCard | domain | ... | `.card` como base | rename/refactor | medium |

No comenzar borrando archivos.

---

# 3. CLASIFICAR CADA COMPONENTE

Cada componente ORP debe caer en una de estas categorías.

## A. Primitive duplicado por Bulma

Ejemplos posibles:

```text
OrpButton
OrpCard
OrpBadge
OrpContainer
OrpColumns
OrpGrid
OrpStack
OrpCluster
OrpSurface
```

Acción preferida:

```text
REPLACE
```

Usar Bulma directamente y eliminar el primitive cuando no tenga consumidores.

## B. Wrapper Vue con comportamiento real

Ejemplos posibles:

```text
OrpModal
OrpIconButton
```

Si el componente aporta:
- estado;
- lifecycle;
- focus management;
- keyboard behavior;
- emits;
- slots;
- accesibilidad;
- API reutilizable;

puede seguir existiendo como componente Vue, pero reconstruido sobre Bulma y renombrado semánticamente cuando corresponda.

Acción:

```text
REFACTOR / KEEP FUNCTIONAL WRAPPER
```

## C. Componente de dominio

Ejemplos:

```text
OrpContactCard
OrpProductCard
OrpServiceCard
OrpLocationCard
OrpReviewCard
```

Estos representan conceptos reales del producto y no primitives del framework.

Migrar conceptualmente a:

```text
ContactCard.vue
ProductCard.vue
ServiceCard.vue
LocationCard.vue
ReviewCard.vue
```

Implementarlos con:

```text
HTML semántico + Bulma + BEM + --dl-* + Vue
```

Acción:

```text
RENAME + REFACTOR
```

## D. Componente muerto/duplicado

Si no tiene consumidores o está reemplazado por otra implementación:

```text
DELETE
```

Sólo después de verificar referencias.

---

# 4. BULMA FIRST

Antes de escribir un reemplazo propio consultar la documentación de Bulma.

## Elements

```text
Block
https://bulma.io/documentation/elements/block/

Box
https://bulma.io/documentation/elements/box/

Button
https://bulma.io/documentation/elements/button/

Content
https://bulma.io/documentation/elements/content/

Delete
https://bulma.io/documentation/elements/delete/

Icon
https://bulma.io/documentation/elements/icon/

Image
https://bulma.io/documentation/elements/image/

Notification
https://bulma.io/documentation/elements/notification/

Progress
https://bulma.io/documentation/elements/progress/

Table
https://bulma.io/documentation/elements/table/

Tag
https://bulma.io/documentation/elements/tag/

Title
https://bulma.io/documentation/elements/title/
```

## Components

```text
Breadcrumb
https://bulma.io/documentation/components/breadcrumb/

Card
https://bulma.io/documentation/components/card/

Dropdown
https://bulma.io/documentation/components/dropdown/

Menu
https://bulma.io/documentation/components/menu/

Message
https://bulma.io/documentation/components/message/

Modal
https://bulma.io/documentation/components/modal/

Navbar
https://bulma.io/documentation/components/navbar/

Pagination
https://bulma.io/documentation/components/pagination/

Panel
https://bulma.io/documentation/components/panel/

Tabs
https://bulma.io/documentation/components/tabs/
```

## Layout / Grid

```text
Container
https://bulma.io/documentation/layout/container/

Hero
https://bulma.io/documentation/layout/hero/

Section
https://bulma.io/documentation/layout/section/

Level
https://bulma.io/documentation/layout/level/

Media Object
https://bulma.io/documentation/layout/media-object/

Footer
https://bulma.io/documentation/layout/footer/

Columns
https://bulma.io/documentation/columns/basics/

Smart Grid
https://bulma.io/documentation/grid/smart-grid/

Fixed Grid
https://bulma.io/documentation/grid/fixed-grid/
```

## Helpers / Sass

```text
Spacing
https://bulma.io/documentation/helpers/spacing-helpers/

Typography
https://bulma.io/documentation/helpers/typography-helpers/

Visibility
https://bulma.io/documentation/helpers/visibility-helpers/

Flexbox
https://bulma.io/documentation/helpers/flexbox-helpers/

Responsive Mixins
https://bulma.io/documentation/sass/responsive-mixins/

Sass Variables
https://bulma.io/documentation/customize/list-of-sass-variables/
```

---

# 5. MATRIZ DE MIGRACIÓN ORP → BULMA

Usar esta tabla como orientación, pero validar primero los componentes reales existentes.

| ORP | Destino preferido |
|---|---|
| OrpButton | Bulma `.button` |
| OrpCard | Bulma `.card` |
| OrpBadge | Bulma `.tag` |
| OrpContainer | Bulma `.container` |
| OrpGrid | Bulma Grid / Columns |
| OrpColumns | Bulma Columns |
| OrpStack | Bulma Flexbox + Spacing helpers |
| OrpCluster | Bulma Flexbox helpers |
| OrpSurface | Theme API / Section Context / Bulma |
| OrpIconButton | Bulma `.button` + `.icon`; wrapper sólo si aporta comportamiento |
| OrpModal | Vue wrapper funcional sobre Bulma `.modal` si sigue siendo útil |
| OrpEmpty | `EmptyState.vue` sólo si representa una UI de producto reutilizable |
| OrpContactCard | `ContactCard.vue` + Bulma Card + BEM |
| OrpProductCard | `ProductCard.vue` + Bulma Card + BEM |
| OrpServiceCard | `ServiceCard.vue` + Bulma Card + BEM |

No asumir que todos estos componentes existen. Auditar primero.

---

# 6. BEM ES OBLIGATORIO PARA CSS PROPIO

Todo componente propio migrado debe usar BEM.

Ejemplo:

```html
<article class="card product-card">
    <div class="card-image product-card__media">
        ...
    </div>

    <div class="card-content product-card__content">
        <h3 class="title is-5 product-card__title">
            {{ product.name }}
        </h3>

        <div class="content product-card__description">
            ...
        </div>

        <div class="buttons product-card__actions">
            ...
        </div>
    </div>
</article>
```

Bulma:

```text
card
card-image
card-content
title
is-5
content
buttons
```

Acerca/BEM:

```text
product-card
product-card__media
product-card__content
product-card__title
product-card__description
product-card__actions
```

No renombrar clases Bulma a BEM.

---

# 7. HTML SEMÁNTICO

Durante la migración aprovechar para corregir markup cuando pueda hacerse sin cambiar comportamiento.

Preferir:

```text
section
article
header
footer
nav
figure
figcaption
address
time
ul/li
button
a
```

Regla:

```text
<a>      = navegación
<button> = acción
```

No usar `<a href="#">` como botón.

Mantener jerarquía correcta de headings.

Bulma controla apariencia; HTML controla significado.

---

# 8. MIGRAR TOKENS `--orp-*`

Auditar todos los tokens antes de sustituirlos.

Clasificar cada token.

## Si es configurable desde Admin/theme

Migrar al contrato:

```text
--dl-*
```

Ejemplo conceptual:

```text
--orp-primary → --dl-primary
```

pero sólo después de revisar cómo se inyecta actualmente.

## Si Bulma ya resuelve la responsabilidad

No crear automáticamente un equivalente `--dl-*`.

Ejemplo:

```text
--orp-space-md
```

no debería convertirse automáticamente en:

```text
--dl-space-md
```

si Bulma ya proporciona spacing suficiente.

## Si es contexto de Section

Migrar a:

```text
--dl-section-*
```

Contrato:

```text
--dl-section-bg
--dl-section-surface
--dl-section-text
--dl-section-heading
--dl-section-muted
--dl-section-link
--dl-section-accent
--dl-section-border
```

---

# 9. SECTIONS

Las Sections migradas deben usar Bulma + BEM.

Ejemplo:

```html
<section
    class="section section-products section--scheme-color section--align-center"
>
    <div class="container section-products__container">
        ...
    </div>
</section>
```

Modificadores compartidos:

```text
section--scheme-light
section--scheme-dark
section--scheme-color
section--scheme-gradient

section--align-left
section--align-center
section--align-right

section--layout-default
section--layout-reverse
```

No mantener clases ORP equivalentes si ya existe este contrato.

---

# 10. NO CONTAMINAR PROPS VUE CON CSS

Durante la migración detectar props como:

```text
padding
margin
radius
shadow
background
textColor
borderColor
fontSize
```

Determinar si pueden eliminarse sin romper API pública.

La configuración visual debe resolverse preferentemente mediante:

```text
Bulma
--dl-*
--dl-section-*
BEM
SCSS
```

Props deben representar principalmente:
- datos;
- comportamiento;
- estado;
- variantes semánticas reales.

---

# 11. RESPONSIVE

No migrar dimensiones rígidas de ORP literalmente.

Antes de escribir responsive CSS:

1. revisar Bulma Columns;
2. revisar Bulma Grid;
3. revisar responsive helpers;
4. revisar responsive Sass mixins.

Para CSS propio preferir cuando corresponda:

```text
rem
%
fr
minmax()
clamp()
min()
max()
dvh
```

`px` no está prohibido, pero evitar dimensiones rígidas innecesarias.

---

# 12. EFECTOS UX

Si OrpUI contenía:
- shadows;
- hover effects;
- transitions;
- borders;
- focus effects;

no copiarlos automáticamente componente por componente.

Clasificar:

```text
¿Bulma lo resuelve?
    ↓ no
¿Es configurable por theme?
    → --dl-*
¿Es reutilizable?
    → SCSS UX compartido
¿Es exclusivo?
    → BEM SCSS del componente
```

Respetar `prefers-reduced-motion`.

---

# 13. THEMES

La migración ORP no debe provocar que cada theme copie componentes.

Regla:

```text
diferencia visual
→ theme.scss

diferencia estructural real
→ Theme Component Override
```

Componente canónico:

```text
components/products/ProductCard.vue
```

Override excepcional:

```text
themes/modern/products/ProductCard.vue
```

El override debe preservar props/emits/slots/API pública.

---

# 14. DEPENDENCIAS COMPARTIDAS

No reemplazar capacidades existentes de:

```text
Swiper
GLightbox
Leaflet
```

con código ORP o implementaciones por theme.

Estas dependencias deben vivir en componentes funcionales compartidos.

Ejemplo:

```text
GalleryCarousel.vue → Swiper
GalleryItem.vue     → GLightbox
LocationMap.vue     → Leaflet
```

---

# 15. ORDEN RECOMENDADO DE MIGRACIÓN

## Fase 1 — Audit

Inventariar todo OrpUI y sus consumidores.

No eliminar nada.

## Fase 2 — Primitives simples

Migrar primero elementos de bajo riesgo:

```text
Button
Badge/Tag
Box/Card base
Container
Spacing helpers
Flex helpers
```

## Fase 3 — Layout primitives

Migrar:

```text
Grid
Columns
Stack
Cluster
Surface
```

usando Bulma/Theme API.

## Fase 4 — Functional wrappers

Migrar:

```text
Modal
IconButton
EmptyState
```

conservando comportamiento necesario.

## Fase 5 — Domain components

Migrar:

```text
ContactCard
ProductCard
ServiceCard
LocationCard
ReviewCard
ProfileHero
etc.
```

Eliminar prefijo `Orp` cuando el componente represente dominio de Acerca.

## Fase 6 — Sections

Actualizar consumidores Section por Section.

No hacer una sustitución global sin verificar visualmente.

## Fase 7 — Tokens

Completar migración:

```text
--orp-* → Bulma / --dl-* / --dl-section-* / eliminación
```

según clasificación.

## Fase 8 — Cleanup

Eliminar OrpUI sólo después de verificar que no existen consumidores activos.

---

# 16. ESTRATEGIA POR COMPONENTE

Para cada componente ORP ejecutar este proceso:

```text
1. Abrir componente.
2. Identificar responsabilidad.
3. Buscar todos sus consumidores.
4. Identificar props/emits/slots.
5. Identificar estilos/tokens usados.
6. Consultar equivalente Bulma.
7. Clasificar: replace / refactor / rename / delete.
8. Migrar un componente.
9. Actualizar consumidores.
10. Ejecutar build/tests aplicables.
11. Verificar UI.
12. Sólo entonces continuar con el siguiente.
```

Evitar migraciones masivas sin puntos de verificación.

---

# 17. CRITERIOS DE ACEPTACIÓN

La migración estará completa cuando:

- Bulma sea la base UI del Minisite;
- no exista un framework primitive paralelo llamado OrpUI;
- primitives duplicados hayan desaparecido;
- componentes de dominio estén preservados y renombrados semánticamente;
- todo CSS propio siga BEM;
- variables configurables utilicen el contrato `--dl-*`;
- Sections consuman `--dl-section-*`;
- Bulma resuelva grid/layout/spacing/typography cuando sea posible;
- themes no dupliquen componentes innecesariamente;
- Swiper/GLightbox/Leaflet sigan funcionando;
- no existan imports ORP activos innecesarios;
- no existan tokens `--orp-*` activos innecesarios;
- build/tests aplicables pasen;
- apariencia y comportamiento no hayan sufrido regresiones importantes.

---

# 18. REPORTE FINAL OBLIGATORIO

Entregar:

```text
ORPUI → BULMA MIGRATION REPORT

1. ORP components found
2. Components replaced by Bulma
3. Functional wrappers retained/refactored
4. Domain components renamed/refactored
5. Components deleted
6. ORP tokens migrated
7. ORP tokens deleted
8. BEM changes
9. Semantic HTML changes
10. Consumers updated
11. Themes updated
12. Remaining ORP references
13. Build result
14. Tests result
15. Visual/regression warnings
16. Recommended next migration target
```

Incluir además la matriz final:

| Old ORP | New implementation | Action | Status |
|---|---|---|---|

---

# 19. REGLA FINAL PARA EL AGENTE

Antes de crear cualquier reemplazo propio preguntarse:

```text
¿Bulma ya lo hace?
    ↓ no
¿Es configuración del Admin/theme?
    → --dl-*
¿Es contexto de Section?
    → --dl-section-*
¿Es UX reutilizable?
    → SCSS compartido
¿Es específico del componente?
    → BEM SCSS
¿Es comportamiento/dominio real?
    → componente Vue semántico
```

No recrear OrpUI bajo otro nombre.

El objetivo final es simplificar:

```text
ORPUI + estilos propios + framework
```

hacia:

```text
Bulma + BEM + Theme API + componentes Vue de dominio
```

