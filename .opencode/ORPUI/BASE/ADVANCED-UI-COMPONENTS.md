# SKILL — ORP UI / Parte 18: Rich UI Components

## Objetivo

Ampliar ORP UI con una capa de **componentes compuestos y visualmente más ricos** para que el framework pueda resolver interfaces modernas de SaaS, dashboards, sitios, aplicaciones móviles y herramientas administrativas sin sentirse limitado a primitives básicos.

Esta fase debe reutilizar todo lo construido anteriormente.

No reemplazar:

- Card
- List
- Avatar
- Badge
- Meta
- Button
- IconButton
- Stack
- Cluster
- Grid
- Section
- Progress
- Skeleton
- Empty State
- Dropdown
- Popover
- Modal
- Sheet
- Navigation
- Forms

La meta es **componerlos**.

---

# 1. Scope

```text
Rich UI
├── Rich Cards
│   ├── Stat Card
│   ├── KPI Card
│   ├── Feature Card
│   ├── Pricing Card
│   ├── Testimonial
│   ├── Profile Card
│   ├── Split Card
│   ├── Overlay Card
│   └── Banner Card
│
├── Toolbars & Filters
│   ├── Toolbar
│   ├── Action Bar
│   ├── Search Bar
│   ├── Filter Bar
│   ├── Filter Chips
│   ├── Sort Control
│   └── Pagination Bar
│
├── Feedback & Status
│   ├── Callout
│   ├── Notice
│   ├── Status Banner
│   ├── Inline Message
│   ├── Result State
│   └── Connection State
│
├── Communication
│   ├── Comment
│   ├── Comment Thread
│   ├── Chat Bubble
│   ├── Message Group
│   ├── Typing Indicator
│   ├── Presence
│   └── Activity Feed
│
└── Content Composition
    ├── Section Header
    ├── Profile Header
    ├── Stats Overview
    ├── Avatar Group
    └── Step Header
```

---

# 2. Regla principal

Antes de crear un componente nuevo preguntar:

```text
¿Es realmente un componente?
```

o:

```text
¿es solamente una composición de primitives existentes?
```

Preferir composición.

Ejemplo:

```text
Stat Card
=
Card
+ Stat
+ Meta
+ Badge
```

No duplicar internamente los estilos de esos primitives.

---

# 3. UI vs negocio

ORP UI describe **cómo se presenta algo**, no qué significa para un negocio.

Permitido:

```text
orp-stat-card
orp-feature-card
orp-profile-card
orp-toolbar
orp-callout
orp-comment
orp-activity
```

No permitido:

```text
orp-product-card
orp-course-card
orp-property-card
orp-restaurant-card
orp-order-card
orp-invoice-card
orp-customer-card
```

La aplicación crea esos componentes componiendo ORP UI.

---

# 4. CSS-first

La mayoría de esta fase debe ser:

```text
HTML
+
LESS
+
existing ORP primitives
```

Crear Vue únicamente cuando exista:

```text
state
interaction
events
keyboard behavior
dynamic composition difficult to express semantically
```

No crear `OrpStatCard.vue` solo porque el nombre suene a componente.

---

# 5. Rich Card strategy

No crear diez sistemas de Card independientes.

Auditar primero `.orp-card`.

Cuando una variante sea principalmente visual, preferir modifier:

```text
.orp-card--glass
.orp-card--gradient
.orp-card--overlay
.orp-card--split
```

Solo agregar modifiers si representan patrones reutilizables reales.

---

# 6. Glass Card

Evaluar modifier:

```text
orp-card--glass
```

Características:

- translucent surface
- subtle border
- backdrop blur cuando exista soporte
- theme-aware
- readable foreground

Debe tener fallback correcto si `backdrop-filter` no existe.

No hardcodear blanco transparente pensando únicamente en Light Theme.

---

# 7. Gradient Card

Evaluar:

```text
orp-card--gradient
```

No imponer un gradiente azul fijo.

Debe poder utilizar custom properties.

Ejemplo conceptual:

```css
--orp-card-gradient-start
--orp-card-gradient-end
```

Solo crear tokens si existe uso repetido.

---

# 8. Elevated Card

No crear `OrpElevatedCard`.

Revisar si:

```text
orp-card--raised
```

ya resuelve el patrón.

Consolidar en lugar de duplicar.

---

# 9. Split Card

Patrón:

```text
Card
├── Media
└── Content
```

Puede usar:

```text
orp-card--split
```

o composición con Grid/Split.

Debe funcionar:

```text
stacked mobile
side-by-side desktop
```

sin JS breakpoint detection.

---

# 10. Overlay Card

Patrón:

```text
Media
└── Overlay content
```

Debe reutilizar:

```text
orp-media
orp-card
```

y mantener contraste legible.

No convertirlo en componente de producto/evento.

---

# 11. Banner Card

Card horizontal/prominente para:

```text
announcement
promotion
feature
CTA
status
```

sin conocer significado de negocio.

Debe permitir:

```text
media
content
actions
```

---

# 12. Stat Card

Crear patrón de composición:

```text
orp-stat-card
```

solo si realmente agrega layout consistente sobre `orp-stat`.

Estructura conceptual:

```text
Stat Card
├── Icon
├── Label
├── Value
├── Trend
└── Meta
```

Debe reutilizar `orp-stat`.

No calcular métricas.

---

# 13. KPI Card

Auditar si KPI Card es realmente diferente de Stat Card.

Si solo cambia contenido:

**NO crear componente separado.**

Documentar:

```text
KPI Card
→ use Stat Card composition
```

Evitar duplicación conceptual.

---

# 14. Feature Card

Patrón genérico para explicar una característica.

```text
Feature
├── Icon / Media
├── Title
├── Description
└── Action
```

Puede implementarse como:

```text
orp-feature
```

en lugar de otro Card si Card no es necesario.

Debe funcionar dentro de Grid.

---

# 15. Pricing Card

Puede existir como composición visual genérica porque pricing es un patrón UI transversal.

Estructura:

```text
Pricing
├── Header
├── Name
├── Description
├── Price
├── Features
├── CTA
└── Optional badge
```

Reutilizar:

```text
orp-price
orp-list
orp-badge
orp-btn
orp-card
```

ORP NO decide:

```text
billing
currency conversion
discount
tax
subscription
checkout
```

---

# 16. Featured pricing

Puede existir modifier:

```text
--featured
```

pero debe ser visual únicamente.

No asumir que featured = recommended por lógica.

---

# 17. Testimonial

Patrón:

```text
Testimonial
├── Quote
├── Avatar
├── Name
├── Meta
└── Rating optional
```

Usar semántica apropiada:

```html
<blockquote>
```

cuando corresponda.

No hardcodear cinco estrellas.

---

# 18. Profile Card

Patrón genérico:

```text
Profile
├── Avatar
├── Name
├── Description / Meta
├── Badges
└── Actions
```

No llamarlo:

```text
UserCard
EmployeeCard
CustomerCard
```

si puede seguir siendo genérico.

---

# 19. Toolbar

Crear primitive importante:

```text
orp-toolbar
```

Estructura:

```text
orp-toolbar
├── orp-toolbar__leading
├── orp-toolbar__title
├── orp-toolbar__content
└── orp-toolbar__actions
```

Debe funcionar con:

```text
Button
IconButton
SearchInput
Dropdown
Filter controls
```

---

# 20. Toolbar responsive

Mobile-first.

Debe permitir:

```text
wrap
stack
overflow
```

según composición.

No asumir que siempre cabe horizontalmente.

No usar JS para detectar mobile.

---

# 21. Action Bar

Auditar diferencia con Toolbar.

Referencia:

```text
Toolbar
→ general tools/context

Action Bar
→ actions over current content/selection
```

Si visualmente son iguales, usar Toolbar + modifier/contexto.

No duplicar CSS.

---

# 22. Search Bar

No duplicar `OrpSearchInput`.

Search Bar es composición:

```text
SearchInput
+ optional filters
+ optional actions
```

Puede resolverse con Toolbar.

Crear clase propia solo si aporta layout reutilizable real.

---

# 23. Filter Bar

Patrón:

```text
Filter Bar
├── Search
├── Filter controls
├── Filter chips
├── Sort
└── Clear filters
```

No gestionar estado de filtros.

La aplicación controla:

```text
selected filters
query
sorting
API
URL
```

---

# 24. Filter Chips

Reutilizar:

```text
orp-chip
```

No crear otro componente Chip.

Deben poder representar:

```text
active filter
removable filter
selected category
```

---

# 25. Sort Control

Preferir composición:

```text
Select
```

o:

```text
Button + Dropdown
```

No crear motor de sorting.

ORP solo presenta el control.

---

# 26. Pagination Bar

Composición:

```text
Pagination
+ Meta
+ optional page size
```

No duplicar `.orp-pagination`.

La aplicación controla páginas y URLs.

---

# 27. Callout

Crear:

```text
orp-callout
```

Para contenido contextual importante dentro de una página.

Estructura:

```text
icon
title
description
actions
```

Variantes semánticas:

```text
info
success
warning
danger
```

Reutilizar semantic tokens.

---

# 28. Alert vs Callout

Documentar:

```text
Alert
→ immediate system/user feedback

Callout
→ contextual information embedded in content
```

No fusionarlos si tienen semánticas diferentes.

---

# 29. Notice

Auditar si Notice aporta algo distinto de Callout/Alert.

Si no:

NO crear `.orp-notice`.

Documentar composición apropiada.

---

# 30. Status Banner

Patrón ancho para estado importante:

```text
icon
message
meta
actions
```

Ejemplos conceptuales:

```text
offline
maintenance
warning
success
```

Pero nombres de clases siguen genéricos.

---

# 31. Connection State

No crear lógica de red.

ORP puede proporcionar presentación para:

```text
online
offline
reconnecting
```

La aplicación detecta el estado.

---

# 32. Inline Message

Feedback pequeño asociado a una región de contenido.

No duplicar Field Error.

Debe usarse para mensajes generales dentro de un bloque.

---

# 33. Result State

Consolidar estados de resultado usando `orp-empty`.

Ejemplos:

```text
success
error
no-results
offline
```

No crear cuatro componentes distintos.

Extender Empty State solo si arquitectura lo justifica.

---

# 34. Communication primitives

Agregar componentes visuales genéricos para interfaces colaborativas/sociales.

Scope:

```text
Comment
Comment Thread
Chat Bubble
Message Group
Typing Indicator
Presence
Activity Feed
```

No agregar networking/backend.

---

# 35. Comment

Crear patrón:

```text
orp-comment
```

Estructura:

```text
avatar
header
author
meta
body
actions
replies optional
```

No incluir lógica de:

```text
likes
permissions
editing
deleting
API
```

---

# 36. Comment semantics

Usar HTML semántico razonable.

Acciones reales deben ser:

```text
button
anchor
```

No `div @click`.

---

# 37. Comment Thread

Preferir composición de Comments.

No crear JS de árbol.

Puede existir:

```text
orp-comment-thread
```

para spacing/connector visual.

---

# 38. Thread depth

No soportar profundidad infinita visual complicada.

Mantener nesting razonable.

En mobile reducir indentación para evitar perder ancho.

---

# 39. Chat Bubble

Crear:

```text
orp-chat
orp-chat__bubble
```

o estructura equivalente coherente con BEM actual.

Debe soportar visualmente:

```text
incoming
outgoing
```

sin saber quién es el usuario.

---

# 40. Chat semantics

No asumir:

```text
AI
customer support
WhatsApp
SMS
```

Debe ser genérico.

---

# 41. Message content

Soportar:

```text
text
meta/time
status
avatar optional
```

No implementar rich text parser.

---

# 42. Message Group

Permitir agrupar mensajes consecutivos visualmente.

No implementar lógica automática de agrupación.

La aplicación decide agrupación.

---

# 43. Typing Indicator

Crear primitive visual ligero.

Ejemplo:

```text
three animated dots
```

Debe:

- usar motion tokens
- respetar reduced motion
- no depender de JS
- tener accessible text cuando sea semánticamente necesario

No repetir los bugs actuales de Spinner/Skeleton.

---

# 44. Presence

Crear:

```text
orp-presence
```

o reutilizar Status Dot si ya resuelve el caso.

Estados visuales posibles:

```text
online
away
busy
offline
```

No depender únicamente de color.

Si Status Dot puede resolverlo, NO crear primitive duplicado.

---

# 45. Activity Feed

Crear patrón:

```text
orp-activity
```

o composición basada en Timeline/List.

Estructura conceptual:

```text
icon/avatar
content
meta
actions optional
```

Auditar si Timeline ya cubre la mayor parte.

No duplicar Timeline si no es necesario.

---

# 46. Section Header

Agregar patrón reusable:

```text
orp-section-header
```

solo si `orp-section__header` actual no resuelve suficientemente.

Debe permitir:

```text
eyebrow
title
description
actions
```

Primero auditar `orp-section`.

---

# 47. Profile Header

Patrón de composición:

```text
cover optional
avatar
name
meta
badges
actions
```

Debe ser genérico.

No incluir seguidores, posts, etc. como API interna.

---

# 48. Stats Overview

Composición:

```text
Grid
+
Stat
```

No crear componente si Grid + Stat ya lo resuelven.

Puede existir demo/pattern documentado sin CSS nuevo.

---

# 49. Avatar Group

Crear primitive:

```text
orp-avatar-group
```

para avatares superpuestos o agrupados.

Debe reutilizar Avatar.

---

# 50. Avatar Group overflow

Puede mostrar:

```text
+3
```

como indicador visual si la aplicación proporciona el número.

ORP no calcula usuarios ocultos automáticamente salvo que exista componente Vue justificado.

---

# 51. Avatar Group accessibility

Las imágenes deben conservar alt adecuado según contexto.

El indicador `+N` debe tener significado accesible cuando sea interactivo/informativo.

---

# 52. Step Header

Composición para procesos:

```text
title
description
step meta
progress optional
actions
```

Reutilizar:

```text
Stepper
Progress
Meta
```

No implementar wizard.

---

# 53. Composition-first examples

El Playground debe demostrar composiciones reales:

```text
Toolbar
+ SearchInput
+ Dropdown
+ Button

Card
+ Stat
+ Badge

Profile
+ Avatar
+ Badge
+ IconButton

Filter Bar
+ SearchInput
+ Chip
+ Select

Comment
+ Avatar
+ Meta
+ IconButton
```

---

# 54. No duplicated internals

Un Rich Component no debe recrear:

```text
button styles
badge styles
avatar styles
icon styles
dropdown styles
input styles
```

Debe reutilizarlos.

---

# 55. Icons

Usar integración actual:

```text
Bootstrap Icons
```

en demos.

Ejemplo:

```html
<i class="orp-icon bi bi-funnel" aria-hidden="true"></i>
```

Core sigue siendo icon-library agnostic.

---

# 56. Visual polish

Esta fase sí debe elevar la calidad visual del framework.

Revisar:

```text
hierarchy
spacing
density
surface
border
shadow
radius
typography
icons
hover
focus
active
disabled
```

Todo mediante tokens actuales.

---

# 57. No hardcoded visual system

No introducir arbitrariamente:

```text
#fff
#000
#ddd
box-shadow: ...
border-radius: 14px
transition: .2s
```

cuando ya existen tokens.

---

# 58. Theme compatibility

Todos los nuevos patterns deben probarse en:

```text
Light
Dark
Custom
```

Especialmente:

```text
glass
gradient
overlay
callout
chat bubbles
toolbar
pricing
```

---

# 59. Glass theme audit

Glass en dark no debe verse como una capa blanca lavada.

Usar tokens/custom properties apropiados.

---

# 60. Overlay contrast

Overlay Cards deben mantener contraste de texto sobre media.

Puede existir overlay gradient visual, pero debe ser configurable y theme-safe.

---

# 61. Motion

Esta fase debe respetar el sistema de motion.

Revisar particularmente:

```text
Typing Indicator
interactive cards
toolbar transitions
filter chips
```

Usar:

```text
--orp-duration-fast
--orp-duration-normal
--orp-duration-slow
--orp-ease-standard
```

---

# 62. Reduced motion

Todo motion decorativo debe responder a:

```text
prefers-reduced-motion: reduce
```

No repetir problemas de Spinner/Skeleton.

---

# 63. Responsive

Probar:

```text
320
375
390
430
576
768
992
1200
1440
```

---

# 64. Mobile priorities

Especialmente:

```text
Toolbar wrapping
Filter Bar
Pricing Card
Profile Header
Comment Thread
Chat Bubble
Action Bar
Avatar Group
```

---

# 65. Long content

Probar:

```text
long titles
long names
long descriptions
many chips
many toolbar actions
long comments
long chat messages
large prices
```

No depender de truncation para que todo funcione.

---

# 66. Touch

Acciones interactivas deben conservar touch targets razonables.

No crear iconos diminutos sin área táctil suficiente.

---

# 67. Accessibility

Todos los rich patterns deben mantener semántica de primitives.

No agregar roles innecesarios.

---

# 68. Interactive Card

Si toda una card navega:

preferir anchor semántico.

Evitar nested interactive elements inválidos.

Si contiene múltiples botones independientes, no envolver toda la Card en un `<a>`.

---

# 69. Pricing accessibility

Lista de features debe ser lista semántica cuando corresponda.

CTA debe ser anchor/button según acción real.

---

# 70. Testimonial accessibility

Usar:

```text
blockquote
cite
```

cuando sea apropiado.

---

# 71. Toolbar accessibility

Toolbar no necesita `role="toolbar"` automáticamente.

Usarlo únicamente cuando el conjunto realmente represente un toolbar interactivo y se implemente la semántica correspondiente.

No inventar ARIA.

---

# 72. Filters

Inputs deben conservar labels accesibles.

Icon-only filter buttons requieren `aria-label`.

---

# 73. Communication accessibility

Comment/Chat deben mantener orden DOM lógico.

No usar CSS visual para invertir el orden semántico.

---

# 74. Presence accessibility

Nunca comunicar online/offline únicamente por color.

Agregar texto accesible/contextual.

---

# 75. Typing Indicator accessibility

La animación visual puede ser decorativa.

Cuando sea necesario anunciar estado, usar texto accesible como:

```text
Escribiendo…
```

La aplicación decide cuándo aparece.

---

# 76. RTL

Usar logical properties.

Probar:

```html
dir="rtl"
```

especialmente:

```text
Toolbar
Profile
Comment
Chat
Avatar Group
Filter Bar
```

---

# 77. CSS architecture

Posibles archivos:

```text
less/components/
├── toolbar.less
├── callout.less
├── feature.less
├── pricing.less
├── testimonial.less
├── profile.less
├── comment.less
├── chat.less
├── avatar-group.less
└── activity.less
```

Pero NO crear un archivo por concepto si solo necesita composición existente.

---

# 78. Card modifiers

Si se justifican:

```text
less/components/card.less
```

puede incorporar:

```text
--glass
--gradient
--overlay
--split
```

Mantener Card coherente.

---

# 79. Avoid modifier explosion

No terminar con:

```text
orp-card--blue
orp-card--red
orp-card--pricing
orp-card--user
orp-card--product
orp-card--dashboard
```

Modifiers describen presentación, no dominio.

---

# 80. Vue components

No crear automáticamente wrappers Vue.

Candidatos que podrían justificar Vue solo si existe comportamiento:

```text
FilterBar
TypingIndicator
AvatarGroup
```

pero primero intentar HTML/CSS composition.

---

# 81. Toolbar Vue

No crear `OrpToolbar.vue` si CSS + semantic HTML es suficiente.

---

# 82. Pricing Vue

No crear `OrpPricingCard.vue` solo para iterar features.

La aplicación puede renderizar sus datos.

---

# 83. Comment Vue

No crear lógica de replies, editing, likes, API.

Puede ser CSS primitive/pattern.

---

# 84. Chat Vue

No manejar mensajes, sockets, streaming o typing state.

ORP solo presenta.

---

# 85. Playground

Agregar categoría:

```text
Rich UI
```

Subsecciones:

```text
Rich Cards
Toolbars & Filters
Feedback
Communication
Content Composition
```

---

# 86. Playground — Rich Cards

Mostrar:

```text
Stat Card
Feature Card
Pricing Cards
Testimonial
Profile Card
Glass Card
Gradient Card
Split Card
Overlay Card
Banner Card
```

Solo si los patterns fueron realmente implementados.

---

# 87. Playground — Toolbar

Mostrar:

```text
Basic Toolbar
Toolbar with Search
Toolbar with Filters
Toolbar with Actions
Mobile wrapping
```

---

# 88. Playground — Filter Bar

Mostrar:

```text
Search
Filter chips
Select
Sort
Clear
```

La demo puede manejar estado local simple.

No API.

---

# 89. Playground — Feedback

Mostrar:

```text
Callout info
Callout success
Callout warning
Callout danger
Status Banner
Result State
```

Evitar demos redundantes si Alert/Empty ya cubren alguno.

---

# 90. Playground — Communication

Mostrar:

```text
Comment
Comment Thread
Incoming Chat
Outgoing Chat
Message Group
Typing Indicator
Activity Feed
Presence
```

---

# 91. Playground — Content

Mostrar:

```text
Profile Header
Avatar Group
Stats Overview
Step Header
```

---

# 92. Existing components audit

Antes de agregar nuevos estilos revisar si ya existen soluciones equivalentes.

Especialmente:

```text
Card
MediaCard
List
Timeline
Stat
Status Dot
Alert
Empty
Section
Meta
Chip
Badge
Avatar
```

No duplicar.

---

# 93. Skeleton integration

Rich components deben poder mostrar loading usando Skeleton actual.

Ejemplos:

```text
Stat Card loading
Profile loading
Comment loading
Pricing loading
```

No crear skeleton especial por componente salvo necesidad real.

---

# 94. Spinner integration

Buttons/actions pueden reutilizar Spinner actual.

No crear loading indicator nuevo.

Antes, confirmar que bugs de Spinner/Skeleton hayan sido corregidos o reportarlos.

---

# 95. Empty integration

Filter/Search results deben poder componer `orp-empty`.

No crear `NoResultsCard`.

---

# 96. Dropdown integration

Toolbar/FilterBar pueden usar Dropdown existente.

No implementar menú nuevo.

---

# 97. Popover integration

Acciones contextuales pueden usar Popover existente.

---

# 98. Drawer/Sheet integration

En mobile, aplicación puede mover filtros a Drawer/Sheet.

ORP Toolbar no debe hacerlo automáticamente.

---

# 99. Swiper integration

Rich Cards pueden utilizarse dentro de Swiper.

ORP no crea carousel.

Agregar demo opcional:

```text
Media/Feature Cards + Swiper
```

solo usando integración existente.

---

# 100. GLightbox integration

Overlay/Media Cards pueden contener links `.orp-lightbox`.

No agregar Lightbox propio.

---

# 101. Grid integration

Rich Cards deben funcionar dentro de:

```text
orp-grid
orp-grid--auto
```

---

# 102. Stack / Cluster integration

Usar:

```text
orp-stack
orp-cluster
```

para composición y spacing externo.

No duplicar utilities.

---

# 103. AppShell integration

Toolbar debe poder utilizarse dentro de:

```text
AppShell main
PageContent
Section
```

sin conocer routing.

---

# 104. Navigation independence

Ningún componente nuevo debe importar:

```text
vue-router
@inertiajs/vue3
```

---

# 105. Backend independence

No incluir:

```text
fetch
axios
Laravel routes
API endpoints
WebSockets
```

---

# 106. No business state

No manejar:

```text
cart
orders
users
subscriptions
messages backend
notifications backend
```

---

# 107. Performance

Esta fase debe agregar principalmente CSS.

JS growth esperado:

```text
zero
or very small
```

salvo interacción realmente necesaria.

---

# 108. CSS growth

Reportar crecimiento de CSS.

Buscar reutilización antes de añadir reglas.

---

# 109. Regression

Ejecutar tests de Parte 17 si ya existen.

Revisar especialmente:

```text
Card
List
Avatar
Badge
Button
IconButton
Grid
Stack
Cluster
Alert
Timeline
Stat
```

---

# 110. Visual regression

Agregar fixtures para Rich UI.

Casos recomendados:

```text
rich-cards-light
rich-cards-dark
toolbar-mobile
toolbar-desktop
filters-mobile
pricing-light
pricing-dark
profile-header
comments-mobile
chat-light
chat-dark
```

---

# 111. Motion regression

Agregar fixture/revisión para:

```text
Typing Indicator
```

y cualquier nuevo elemento animado.

---

# 112. Bootstrap audit

Playground NO debe usar:

```text
container
row
col-*
card
btn
badge
d-flex
gap-*
p-*
m-*
```

de Bootstrap.

Permitido:

```text
bi
bi-*
```

como Bootstrap Icons.

---

# 113. Namespace

Mantener:

```text
orp-*
@orp-*
--orp-*
Orp*
data-orp-*
```

---

# 114. Documentation

Crear/adaptar:

```text
docs/rich-ui/
├── cards.md
├── toolbar.md
├── filters.md
├── callout.md
├── profile.md
├── comments.md
├── chat.md
├── activity.md
└── composition.md
```

Solo crear docs para patterns que realmente queden en framework.

---

# 115. Decision guide

Documentar:

```text
Card vs MediaCard vs Feature
Alert vs Callout
List vs Activity Feed
Timeline vs Activity Feed
Status Dot vs Presence
Toolbar vs Action Bar
Chip vs Filter Chip
Empty vs Result State
```

---

# 116. Card decision

```text
Card
→ generic container

MediaCard
→ content centered around media

Feature
→ explains a capability/concept

Stat
→ displays metric

Pricing
→ displays plan/value proposition
```

---

# 117. Toolbar decision

```text
Toolbar
→ tools related to current context

Action Bar
→ actions over selected/current content

Filter Bar
→ filtering/search/sort composition
```

Si no existe diferencia visual/estructural real, usar composición/modifiers.

---

# 118. Communication decision

```text
List
→ generic collection

Timeline
→ chronological sequence

Activity Feed
→ actor/action/meta composition

Comment
→ authored content + actions/replies

Chat
→ conversational message sequence
```

---

# 119. Completion criteria

Parte 18 termina cuando ORP UI pueda construir interfaces visualmente ricas mediante primitives genéricos y composición, incluyendo:

```text
modern cards
stats
features
pricing
profiles
toolbars
filters
contextual feedback
comments
chat
activity
avatar groups
```

sin introducir lógica de negocio ni dependencias innecesarias.

---

# 120. Result expected

Al finalizar entregar:

## Audit

Qué primitives existentes fueron reutilizados.

## New patterns

Lista exacta.

## New components

Solo los realmente necesarios.

## Card modifiers

Lista y justificación.

## Files created

Lista.

## Files modified

Lista.

## Public API

Cambios, si existen.

## Playground

Demos agregadas.

## Themes

Light/Dark/Custom.

## Responsive

Viewports probados.

## Accessibility

Resultado.

## RTL

Resultado.

## Motion

Resultado, especialmente reduced motion.

## Bootstrap audit

Confirmar que no existe dependencia de Bootstrap CSS.

## Build

Resultado.

## Tests

Resultado de Parte 17.

## Bundle

Crecimiento CSS/JS.

## Regressions

Problemas encontrados/corregidos.

## Remaining issues

Deuda técnica fuera de esta fase.

---

# 121. Explicit exclusions

NO implementar:

```text
Product Card
Course Card
Property Card
Restaurant Card
Order Card
Invoice Card
Customer Card
Checkout
Shopping Cart
Notification Center backend
Chat backend
WebSockets
Realtime messaging
Rich Text
Kanban
Calendar
Scheduler
Charts
DataTable
File Manager
Media Manager
Drag & Drop builder
```

---

# 122. No automatic dependencies

No instalar nuevas dependencias.

Seguir usando opcionalmente:

```text
Bootstrap Icons
Swiper
GLightbox
```

como integraciones existentes.

---

# 123. Do not continue automatically

No implementar Parte 19.

Terminar con reporte técnico.

---

# Regla final

La Parte 18 debe seguir esta jerarquía:

```text
Primitive existing?
        ↓
       YES
        ↓
Compose it
        ↓
Does composition repeat enough?
        ↓
       YES
        ↓
Create generic pattern
        ↓
Does it require behavior/state?
        ↓
       YES
        ↓
Consider Vue
```

No convertir cada bloque bonito del Playground en un componente Vue.

ORP UI debe sentirse más completo y visualmente rico sin perder lo que lo hace ligero:

```text
CSS first
Composition first
Mobile first
Accessible
Themeable
No business coupling
No router coupling
No backend coupling
No Bootstrap CSS dependency
```

La aplicación decide **qué significa** el contenido.

ORP UI decide **cómo se presenta y se compone**.
