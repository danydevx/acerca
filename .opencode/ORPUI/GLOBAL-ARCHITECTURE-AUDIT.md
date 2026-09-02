# ORP UI — GLOBAL ARCHITECTURE AUDIT
# Framework-wide discovery, classification and consolidation phase

La primera familia de Patterns ya quedó cerrada:

- OrpCatalogCard — DONE
- OrpPricingCard — DONE
- OrpProfileCard — DONE
- OrpContentCard — DONE
- OrpStatCard — DONE
- OrpContactCard — DONE
- OrpActionCard — NOT JUSTIFIED

También existen piezas estructurales/componentes relevantes como:

- Card
- Stack
- Cluster
- Grid
- Button
- IconButton
- Badge
- Empty State
- Alert
- Map
- MapMarker
- y otras primitives/components existentes que deben descubrirse físicamente en el repositorio.

NO continuar creando componentes por roadmap.

Ahora debemos auditar ORP UI completo para responder:

> ¿Qué le falta realmente al framework, qué está duplicado, qué está en la capa incorrecta y qué debe consolidarse antes de seguir creciendo?

Regla principal:

DISCOVER → CLASSIFY → COMPARE → CONSOLIDATE → ONLY THEN BUILD

==================================================
1. OBJETIVO
==================================================

Realizar un audit arquitectónico completo de ORP UI.

NO es una fase de feature development.

El objetivo es producir un mapa confiable del framework y un roadmap basado en evidencia.

Debemos detectar:

- primitives faltantes
- components faltantes
- Patterns faltantes
- duplicación
- APIs inconsistentes
- CSS repetido
- hardcodes
- responsabilidades mezcladas
- componentes demasiado específicos
- abstracciones innecesarias
- responsive repetido
- accesibilidad inconsistente
- tokens faltantes
- problemas de naming
- problemas de composición
- componentes sin documentación/tests/Playground
- oportunidades reales de consolidación

==================================================
2. NO IMPLEMENTAR TODAVÍA
==================================================

IMPORTANTE:

Esta fase es principalmente READ-ONLY.

NO crear automáticamente componentes nuevos.

NO refactorizar masivamente.

NO migrar Acerca.

NO corregir cada problema encontrado.

Solo se permiten cambios triviales necesarios para ejecutar el audit si son absolutamente indispensables.

El resultado principal es:

AUDIT REPORT + PRIORITIZED ROADMAP.

==================================================
3. MODELO DE CAPAS
==================================================

Clasificar ORP usando:

ORP UI
│
├── Foundation
│
│   ├── tokens
│   ├── typography
│   ├── reset/base
│   ├── motion
│   └── design foundations
│
├── Primitives / Primary
│   ├── layout
│   ├── surfaces
│   ├── typography primitives
│   ├── media
│   └── small visual building blocks
│
├── Components
│   ├── interactive behavior
│   ├── state
│   ├── accessibility contracts
│   └── complex reusable UI
│
└── Patterns / Compositions
    └── recurring generic compositions

Fuera de ORP:

Application / Domain
└── Acerca-specific concepts

==================================================
4. CLASIFICACIÓN OBLIGATORIA
==================================================

Para CADA pieza ORP existente documentar:

NAME:
FILE:
TYPE:
CURRENT LAYER:
RECOMMENDED LAYER:
RESPONSIBILITY:
DEPENDENCIES:
GENERIC:
DOMAIN KNOWLEDGE:
HAS TOKENS:
HAS PLAYGROUND:
HAS TESTS:
HAS DOCS:
STATUS:

STATUS puede ser:

HEALTHY
REVIEW
DUPLICATED
MISPLACED
OVER-ABSTRACTED
UNDER-ABSTRACTED
INCONSISTENT
DEPRECATED CANDIDATE

==================================================
5. INVENTARIO FÍSICO
==================================================

No basarse en memoria ni en este prompt.

Recorrer físicamente:

resources/js/Components/OrpUI/

resources/less/orp-ui/

exports públicos

orp-ui.js

orp-ui.less

Playground

tests

docs

package.json

Vite config relevante

Buscar también otras rutas donde ORP esté definido.

==================================================
6. FOUNDATION AUDIT
==================================================

Auditar tokens existentes:

- colors
- surfaces
- text
- spacing
- radius
- shadows
- typography
- font weights
- line heights
- breakpoints si existen
- z-index
- motion
- transitions
- focus
- borders
- sizing

Detectar:

- tokens duplicados
- tokens sin uso
- valores hardcodeados que deberían ser tokens
- tokens excesivamente específicos
- tokens faltantes por repetición real

==================================================
7. HARDCODE AUDIT
==================================================

Buscar en ORP:

px
rem
em
hex
rgb
rgba
hsl
box-shadow
border-radius
gap
padding
margin
font-size
line-height
z-index
transition durations

No marcar todo hardcode como error.

Clasificar:

VALID LOCAL VALUE
SHOULD USE EXISTING TOKEN
NEW TOKEN CANDIDATE

Dar evidencia.

==================================================
8. COLOR AUDIT
==================================================

Buscar colores fuera del sistema de tokens.

Especialmente:

#...
rgb(...)
rgba(...)
hsl(...)

Determinar:

- legítimo
- third-party integration
- demo-only
- deuda técnica
- token candidate

==================================================
9. SPACING AUDIT
==================================================

Buscar repetición de:

padding
margin
gap

Comparar contra:

--orp-space-*

Detectar componentes que inventan spacing propio sin razón.

==================================================
10. RADIUS AUDIT
==================================================

Comparar:

Card
Media
Map
Inputs
Buttons
Badges
Patterns

Buscar radios visualmente inconsistentes.

No obligar a que todo tenga el mismo radius.

Determinar jerarquía coherente.

==================================================
11. TYPOGRAPHY AUDIT
==================================================

Auditar:

font-size
font-weight
line-height
letter-spacing
text colors

Buscar estilos repetidos para:

titles
subtitles
labels
descriptions
metadata
values

Determinar si faltan typography primitives/tokens.

NO crear todavía.

==================================================
12. MOTION AUDIT
==================================================

Buscar:

transition
animation
transform
hover motion

Evaluar:

- consistencia
- tokens
- reduced motion
- duración
- easing

Detectar motion hardcodeado repetidamente.

==================================================
13. FOCUS AUDIT
==================================================

Revisar:

Button
IconButton
links
inputs
selects
textarea
Accordion
Modal
Drawer
cards interactivas
map controls cuando corresponda

Buscar:

outline:none

sin reemplazo accesible.

Documentar estrategia actual de focus-visible.

==================================================
14. LAYOUT PRIMITIVES
==================================================

Auditar:

Stack
Cluster
Grid
Section
Container si existe
Divider
List

Preguntas:

¿Existe primitive para layout vertical?

¿horizontal/wrapping?

¿grid responsive?

¿container/content width?

¿section rhythm?

¿separator?

¿layout primitives se solapan?

==================================================
15. GRID AUDIT
==================================================

Verificar que Grid:

- no replique Bootstrap
- no tenga 12-column complexity innecesaria
- sea mobile-first
- funcione por container cuando corresponda
- use tokens
- no duplique Stack/Cluster

Buscar grids manuales dentro de ORP que deberían usarlo.

Solo reportar.

==================================================
16. STACK AUDIT
==================================================

Buscar:

display:flex
flex-direction:column
gap

en otros componentes.

Determinar cuáles son:

legítimos internos

vs

duplicación de Stack.

==================================================
17. CLUSTER AUDIT
==================================================

Buscar:

display:flex
align-items:center
flex-wrap
gap

Determinar dónde Cluster podría reducir duplicación.

No forzar Cluster en layouts con responsabilidad específica.

==================================================
18. CARD AUDIT
==================================================

Auditar OrpCard como primitive central.

Revisar:

- variants
- interactive
- outlined
- raised
- media
- header
- body
- footer
- nested interactive behavior
- tokens

Determinar si Patterns están reutilizando Card correctamente.

==================================================
19. MEDIA AUDIT
==================================================

Auditar:

Media
MediaCard si existe
Gallery
image wrappers
aspect-ratio
object-fit
overlays

Buscar múltiples implementaciones de:

image container
aspect ratio
media overlay
fallback

Determinar si existe fragmentación.

==================================================
20. AVATAR AUDIT
==================================================

Auditar:

sizes
fallback
image handling
shape
accessibility

Buscar avatars locales duplicados en Patterns.

==================================================
21. BADGE / STATUS AUDIT
==================================================

Auditar Badge.

Buscar también conceptos de:

status
state
semantic indicator

Determinar si Badge está siendo usado para responsabilidades que no le corresponden.

No crear Status todavía.

==================================================
22. BUTTON SYSTEM
==================================================

Auditar:

Button CSS
Vue Button si existe
IconButton CSS
OrpIconButton
variants
sizes
loading
disabled
links vs buttons
block
icon placement

Buscar inconsistencias entre CSS primitive y Vue API.

==================================================
23. ICON SYSTEM
==================================================

Auditar cómo ORP usa iconos.

Bootstrap Icons están permitidos.

Buscar:

- tamaños hardcodeados
- icon wrappers repetidos
- icon-only controls
- decorative icons
- aria-hidden
- accessible labels

Determinar si hace falta una primitive de icon container.

Solo reportar.

==================================================
24. FORMS AUDIT
==================================================

Auditar:

Input
Textarea
Select
Checkbox
Radio
Switch
Label
Field
Form group
help text
error state

Determinar qué existe realmente.

Buscar inconsistencias entre:

CSS classes
Vue wrappers
validation states

==================================================
25. FIELD COMPOSITION
==================================================

Pregunta importante:

¿ORP tiene una composición consistente para:

Label
Control
Help
Error

?

Si no:

FIELD / FORM CONTROL COMPOSITION puede ser candidato de alta prioridad.

No implementarlo aquí.

==================================================
26. FEEDBACK COMPONENTS
==================================================

Auditar:

Alert
Empty State
loading indicators
spinner
skeleton
progress
toast si existe

Buscar gaps reales.

==================================================
27. EMPTY STATE
==================================================

Verificar:

icon
title
description
actions
layout
responsive
accessibility

Confirmar que la decisión de NO crear ActionCard sigue siendo correcta.

==================================================
28. ALERT
==================================================

Auditar:

variants
semantic colors
role
dismiss
actions
icons

No confundir Alert con Status/Toast.

==================================================
29. OVERLAYS
==================================================

Auditar:

Modal
Drawer

Revisar:

- focus management
- Escape
- backdrop
- scroll lock
- aria
- portal/teleport
- sizes
- z-index
- mobile behavior

==================================================
30. DISCLOSURE
==================================================

Auditar:

Accordion

Buscar si existen también:

Collapse
Tabs
Disclosure

Determinar gaps, no crearlos.

==================================================
31. NAVIGATION
==================================================

Buscar primitives/components genéricos para:

Tabs
Breadcrumb
Pagination
Nav
Menu

Si no existen:

determinar si ORP realmente los necesita basándose en Acerca/Playground/evidencia.

==================================================
32. MAP SYSTEM
==================================================

Auditar:

OrpMap
OrpMapMarker

Revisar:

- Leaflet lifecycle
- OSM attribution
- marker assets
- multiple instances
- resize
- accessibility
- API
- cleanup

Listar Phase 2 candidates con evidencia.

No implementar.

==================================================
33. PATTERN FAMILY AUDIT
==================================================

Auditar juntos:

CatalogCard
PricingCard
ProfileCard
ContentCard
StatCard
ContactCard

Comparar:

- naming
- slot conventions
- title strategy
- description strategy
- meta
- actions
- media
- variants
- Card composition
- Stack/Cluster usage
- CSS
- responsive
- accessibility

==================================================
34. SLOT CONSISTENCY
==================================================

Crear matriz:

PATTERN | media/icon | eyebrow | title | description | meta | value | details | map | actions

Detectar slots conceptualmente iguales con nombres diferentes.

No renombrar todavía.

==================================================
35. PROP CONSISTENCY
==================================================

Comparar props genéricos entre Patterns:

variant
orientation
interactive
selected
disabled
mediaRatio
etc.

Detectar:

- mismo concepto, distinto nombre
- distinto default
- distinta semántica

==================================================
36. VARIANT AUDIT
==================================================

Listar todas las variants ORP.

Preguntar:

¿cada variant representa diferencia real?

Buscar:

- variants duplicadas
- aliases innecesarios
- domain variants
- variants de un solo uso

==================================================
37. INTERACTIVE CARD AUDIT
==================================================

Buscar todas las cards/patterns interactivas.

Revisar:

- nested buttons
- nested links
- tabindex
- keyboard
- click handlers
- focus
- semantics

Debe existir una estrategia coherente.

==================================================
38. INFORMATION COMPONENT RESULT
==================================================

Revisar resultado real del Information Component Discovery.

Si se creó primitive/component:

auditar adopción y responsabilidad.

Si NO se creó:

confirmar que la decisión sigue siendo válida tras el audit global.

==================================================
39. THIRD-PARTY INTEGRATIONS
==================================================

Inventariar:

- Leaflet
- GLightbox
- Bootstrap Icons
- cualquier otra integración usada por ORP

Separar claramente:

ORP responsibility

vs

third-party responsibility.

==================================================
40. PLAYGROUND COVERAGE
==================================================

Crear matriz:

COMPONENT | PLAYGROUND DEMO | STATES COVERED | RESPONSIVE DEMO | EDGE CASES

Detectar piezas sin demo.

==================================================
41. TEST COVERAGE
==================================================

Crear matriz:

COMPONENT | TEST FILE | RENDER | INTERACTION | ACCESSIBILITY | EDGE CASES

No exigir tests irrelevantes a CSS-only primitives.

==================================================
42. DOCUMENTATION COVERAGE
==================================================

Crear matriz:

COMPONENT | PURPOSE | API | EXAMPLES | ACCESSIBILITY | DO/DON'T

Detectar documentación faltante.

==================================================
43. ACCESSIBILITY GLOBAL
==================================================

Auditar sistemáticamente:

- semantics
- headings
- labels
- aria
- keyboard
- focus
- disabled
- contrast
- color-only meaning
- touch targets
- reduced motion
- modal focus
- interactive cards
- icon-only buttons

==================================================
44. RESPONSIVE GLOBAL
==================================================

Revisar ORP en:

320
375
390
430
768
1200
1440

No es necesario probar cada demo en cada tamaño si es inviable.

Priorizar componentes representativos y edge cases.

==================================================
45. MOBILE-FIRST AUDIT
==================================================

Buscar CSS donde desktop sea default y móvil se arregle después.

Clasificar:

VALID
REVIEW
SHOULD BE MOBILE-FIRST

==================================================
46. MEDIA QUERY AUDIT
==================================================

Inventariar breakpoints usados.

Detectar:

- valores arbitrarios
- breakpoints duplicados
- inconsistencias
- media queries innecesarias
- oportunidades para container queries

No migrar automáticamente.

==================================================
47. CONTAINER QUERY OPPORTUNITIES
==================================================

Detectar componentes cuyo layout depende más del ancho del componente que del viewport.

Especialmente:

Cards
Patterns
Grid compositions

Marcar:

CONTAINER QUERY CANDIDATE

solo con evidencia.

==================================================
48. CSS DUPLICATION
==================================================

Buscar bloques estructuralmente similares.

Especial atención:

display:flex
display:grid
gap
padding
border
radius
title styles
description styles
action groups
media wrappers
icon wrappers

Reportar ocurrencias concretas.

==================================================
49. DEAD CSS
==================================================

Buscar selectores ORP aparentemente no utilizados.

No eliminar.

Clasificar:

CONFIRMED USED
LIKELY USED
POSSIBLY DEAD
UNKNOWN

==================================================
50. EXPORT AUDIT
==================================================

Comparar:

archivos existentes

vs

exports de orp-ui.js

vs

imports de orp-ui.less

Detectar:

- componente no exportado
- LESS no incluido
- export huérfano
- naming inconsistente

==================================================
51. NAMING AUDIT
==================================================

Buscar inconsistencias:

OrpX
orp-x
orp_x
modifier naming
BEM naming

No hacer rename masivo.

==================================================
52. PUBLIC API AUDIT
==================================================

Determinar qué constituye API pública ORP:

- Vue exports
- CSS classes
- CSS custom properties
- tokens
- events
- slots

Identificar cambios que serían breaking changes.

==================================================
53. DOMAIN LEAK AUDIT
==================================================

Buscar términos dentro de ORP como:

product
service
property
restaurant
business
office
WhatsApp
appointment
vcard
listing
course
hotel

Clasificar cada aparición:

DEMO ONLY
DOCUMENTATION EXAMPLE
DOMAIN LEAK
FALSE POSITIVE

==================================================
54. ACERCA READ-ONLY DOGFOODING AUDIT
==================================================

Ahora sí usar Acerca como consumidor real para detectar gaps.

Revisar read-only:

- Hero
- Navigation
- Footer
- Services
- Products
- Packages
- Reviews
- Gallery
- Locations
- ContactForm
- Appointments
- Availability
- Features
- RestaurantMenu
- Properties
- vCards
- dashboards relevantes

NO modificar.

==================================================
55. ACERCA GAP INVENTORY
==================================================

Para cada necesidad repetida en Acerca:

NEED:
CURRENT LOCAL SOLUTION:
ORP SOLUTION:
GAP:
GENERIC:
FREQUENCY:
RECOMMENDATION:

==================================================
56. NO DOGFOODING MIGRATION
==================================================

Este audit NO debe cambiar Acerca.

Solo identificar:

READY TO DOGFOOD
ORP GAP
DOMAIN-SPECIFIC — KEEP LOCAL

==================================================
57. GENERICITY TEST
==================================================

Para cada candidato nuevo preguntar:

¿serviría fuera de Acerca?

¿tiene 2+ contextos?

¿tiene responsabilidad estable?

¿reduce duplicación real?

¿API pequeña?

¿ya lo resuelve otra primitive?

Si falla:

NO BUILD.

==================================================
58. CANDIDATE CLASSIFICATION
==================================================

Cada candidato debe clasificarse:

FOUNDATION
PRIMITIVE
COMPONENT
PATTERN
DOMAIN — DO NOT ADD TO ORP

==================================================
59. PRIORITY MODEL
==================================================

Asignar prioridad:

P0 — architectural correctness / accessibility / breaking issue

P1 — high reuse / high duplication / blocks dogfooding

P2 — useful improvement / moderate reuse

P3 — optional / low evidence

REJECTED — should not be built

==================================================
60. EFFORT MODEL
==================================================

Estimar:

S
M
L
XL

No usar horas exactas.

==================================================
61. RISK MODEL
==================================================

Asignar:

LOW
MEDIUM
HIGH

Considerar:

- public API
- CSS breaking changes
- accessibility
- third-party integration
- many consumers

==================================================
62. RECOMMENDED ROADMAP
==================================================

El roadmap final debe salir del audit.

NO usar un roadmap predeterminado.

Formato:

PHASE 1 — Foundation fixes
PHASE 2 — Missing primitives
PHASE 3 — Components
PHASE 4 — Pattern consolidation
PHASE 5 — Acerca dogfooding

Solo incluir fases que la evidencia justifique.

==================================================
63. QUICK WINS
==================================================

Separar mejoras:

LOW RISK + HIGH VALUE

Ejemplo:

- export faltante
- demo faltante
- token existente no usado
- inconsistencia pequeña

Pero NO implementarlas todavía.

==================================================
64. BREAKING CHANGES
==================================================

Crear sección explícita:

POTENTIAL BREAKING CHANGES

Para cada una:

CHANGE:
WHY:
AFFECTED API:
MIGRATION IMPACT:
PRIORITY:

==================================================
65. DO NOT OVER-ENGINEER
==================================================

El objetivo NO es convertir ORP en:

Bootstrap
Vuetify
Quasar
Material
Tailwind

ORP debe seguir siendo pequeño, coherente y útil para el stack real.

No agregar componentes solo porque otros frameworks los tienen.

==================================================
66. PLAYGROUND AS CONTRACT
==================================================

Evaluar si Playground representa correctamente la API pública.

Debe permitir entender:

- qué existe
- cómo se usa
- variantes
- edge cases
- composición

Proponer mejoras de organización si son necesarias.

==================================================
67. BUILD
==================================================

Ejecutar:

npm run build

para confirmar baseline.

No corregir errores no relacionados sin documentarlos.

==================================================
68. TEST BASELINE
==================================================

Ejecutar tests ORP existentes.

Registrar baseline:

PASS
FAIL

Si falla:

documentar error exacto y si parece preexistente.

==================================================
69. BROWSER BASELINE
==================================================

Abrir ORP Playground.

Revisar consola.

Registrar:

Vue warnings
asset 404
Leaflet errors
overflow
visual inconsistencies
accessibility obvious issues

==================================================
70. OUTPUT PRINCIPAL
==================================================

Crear:

ORP-GLOBAL-ARCHITECTURE-AUDIT.md

en la ubicación de documentación/planes que use actualmente el proyecto.

No inventar ubicación sin revisar convenciones.

==================================================
71. REPORT — EXECUTIVE SUMMARY
==================================================

El reporte debe comenzar:

# ORP UI — Global Architecture Audit

## Executive Summary

Framework health:

Architecture maturity:

Biggest strengths:

Biggest architectural gaps:

Highest priority next step:

Components that should NOT be created:

==================================================
72. REPORT — INVENTORY
==================================================

## ORP Inventory

### Foundation

tabla.

### Primitives

tabla.

### Components

tabla.

### Patterns

tabla.

==================================================
73. REPORT — HEALTH MATRIX
==================================================

| Item | Layer | API | Tokens | Playground | Tests | A11y | Status |
|------|------|-----|--------|------------|-------|------|--------|

==================================================
74. REPORT — DUPLICATION
==================================================

## Duplication Findings

Finding:
Files:
Occurrences:
Existing primitive:
Recommendation:
Priority:

==================================================
75. REPORT — MISSING ABSTRACTIONS
==================================================

## Missing Abstraction Candidates

Candidate:
Recommended layer:
Evidence:
Contexts:
Existing workaround:
Benefit:
Risk:
Priority:
Decision:

Decision:

BUILD
INVESTIGATE
REJECT

==================================================
76. REPORT — OVER-ABSTRACTIONS
==================================================

## Possible Over-Abstractions

Item:
Why questionable:
Existing simpler composition:
Recommendation:

==================================================
77. REPORT — API CONSISTENCY
==================================================

## API Consistency

### Slots

matrix.

### Props

matrix.

### Variants

matrix.

### Events

matrix.

==================================================
78. REPORT — TOKENS
==================================================

## Token Audit

Existing strengths:

Hardcoded values:

Missing token candidates:

Unused/redundant tokens:

Recommendations:

==================================================
79. REPORT — ACCESSIBILITY
==================================================

## Accessibility Audit

P0 issues:

P1 issues:

Good existing patterns:

Components needing deeper review:

==================================================
80. REPORT — RESPONSIVE
==================================================

## Responsive Audit

Mobile-first consistency:

Breakpoint consistency:

Overflow findings:

Container-query candidates:

==================================================
81. REPORT — DOMAIN BOUNDARY
==================================================

## ORP vs Acerca Boundary

Correctly generic:

Possible domain leaks:

Things that must remain in Acerca:

==================================================
82. REPORT — DOGFOODING
==================================================

## Acerca Dogfooding Readiness

| Acerca Area | ORP Coverage | Gap | Ready? | Recommendation |
|-------------|--------------|-----|--------|----------------|

==================================================
83. REPORT — ROADMAP
==================================================

## Recommended Roadmap

Cada item:

### [Priority] Candidate Name

Layer:
Problem:
Evidence:
Solution direction:
Affected files:
Breaking:
Effort:
Risk:
Dogfooding impact:

==================================================
84. REPORT — DO NOT BUILD
==================================================

## Rejected / Do Not Build

Incluir explícitamente componentes que parecían atractivos pero no están justificados.

Ejemplo actual:

OrpActionCard
→ NOT JUSTIFIED

Mantener esta disciplina.

==================================================
85. REPORT — NEXT SINGLE ACTION
==================================================

Cerrar con:

## Next Single Action

Recomendar UNA sola fase siguiente.

No ejecutar.

Debe explicar:

WHY THIS FIRST

WHAT IT UNBLOCKS

WHAT MUST WAIT

==================================================
86. FINAL REPORT FORMAT
==================================================

Entregar además un resumen en consola/chat:

# ORP GLOBAL AUDIT — COMPLETED

Foundation:
X findings

Primitives:
X findings

Components:
X findings

Patterns:
X findings

P0:
X

P1:
X

P2:
X

P3:
X

Rejected:
X

Build:
PASS / FAIL

Tests:
PASS / FAIL

Recommended next phase:

Audit file:

No implementation performed:
YES / NO

==================================================
87. STOP CONDITION
==================================================

STOP cuando:

- inventario completo
- clasificación completa
- duplication audit completo
- token audit completo
- API consistency audit completo
- accessibility baseline
- responsive baseline
- Acerca read-only gap audit
- prioritized roadmap
- next single action

estén documentados.

NO comenzar el siguiente item.

==================================================
FINAL INSTRUCTION
==================================================

Realiza un ORP GLOBAL ARCHITECTURE AUDIT completo.

1. No empieces creando componentes.
2. Audita físicamente el repositorio.
3. Clasifica todo en Foundation / Primitive / Component / Pattern / Domain.
4. Audita tokens y CSS hardcodeado.
5. Audita Stack / Cluster / Grid y duplicación de layout.
6. Audita Card y toda la familia de Patterns.
7. Audita forms, feedback, overlays, navigation y maps.
8. Compara slots, props, variants y events.
9. Audita accesibilidad y responsive.
10. Audita exports, LESS imports, Playground, tests y docs.
11. Usa Acerca únicamente como consumidor READ-ONLY para descubrir gaps reales.
12. No migres Acerca.
13. No implementes nuevos componentes.
14. No hagas refactor masivo.
15. Clasifica candidatos por evidencia, prioridad, esfuerzo y riesgo.
16. Incluye una sección explícita DO NOT BUILD.
17. Mantén OrpActionCard como NOT JUSTIFIED salvo nueva evidencia extraordinaria.
18. Genera ORP-GLOBAL-ARCHITECTURE-AUDIT.md.
19. Recomienda UNA sola siguiente fase.
20. NO la ejecutes.
21. STOP.

