# SKILL — ORP UI / Parte 21.9: Component Gap Audit & Framework Completeness

## Objetivo

Realizar una auditoría integral de ORP UI antes de entrar a Documentation, Packaging y Release.

**Esta fase NO es una fase de expansión indiscriminada de componentes.**

Su objetivo es responder con evidencia:

```text
¿Qué componentes existen?
¿Qué componentes están completos?
¿Qué componentes están incompletos?
¿Qué componentes están duplicados?
¿Qué APIs son inconsistentes?
¿Qué demos siguen usando estilos legacy?
¿Qué componentes fallan en mobile/dark/RTL/a11y?
¿Qué huecos reales existen?
¿Qué debe entrar antes de v0.1.0?
¿Qué debe posponerse a v0.2.0?
¿Qué debe quedar fuera del core?
```

El resultado debe convertirse en el **inventario oficial y mapa de completitud de ORP UI**.

---

# 1. Regla principal

No crear componentes nuevos al comenzar esta fase.

Primero:

```text
DISCOVER
→ INVENTORY
→ AUDIT
→ CLASSIFY
→ PRIORITIZE
→ FIX
→ VERIFY
```

Solo después de completar el audit se pueden implementar componentes faltantes clasificados como **REQUIRED FOR v0.1.0**.

---

# 2. No asumir el roadmap

El agente debe inspeccionar el repositorio real.

No asumir que un componente existe solo porque apareció en una especificación anterior.

Comprobar:

```text
source files
LESS
Vue components
exports
Playground
tests
docs
compiled CSS
```

---

# 3. Sources of truth

Auditar al menos:

```text
src/
less/
styles/
components/
composables/
playground/
docs/
tests/
dist/
package.json
Vite config
public exports
```

adaptando rutas a la estructura real.

---

# 4. Component Inventory

Construir un inventario real por categorías.

Formato recomendado:

| Component | Source | CSS | Vue | Playground | Tests | Docs | Status |
|---|---|---|---|---|---|---|---|

---

# 5. Status vocabulary

Usar únicamente:

```text
COMPLETE
NEEDS POLISH
INCOMPLETE
BROKEN
LEGACY
DUPLICATED
MISSING
EXTERNAL
OUT OF SCOPE
```

---

# 6. Release classification

Además asignar:

```text
BLOCKER v0.1
REQUIRED v0.1
NICE TO HAVE v0.1
DEFER v0.2
EXTERNAL
OUT OF CORE
```

---

# 7. Audit categories

Revisar como mínimo:

```text
Foundation
Layout
Navigation
Forms
Selection
Feedback
Overlays
Dialogs
Notifications
Data Display
Tables
Data Visualization
Media
Files
Content
Rich UI
Utilities
Integrations
Accessibility
Motion
Themes
Responsive
RTL
Public API
Build
Testing
Documentation
```

---

# 8. Foundation

Auditar:

```text
tokens
semantic colors
spacing
radius
shadows
typography
motion
z-index
breakpoints
container
reset
focus ring
safe areas
```

Buscar:

```text
hardcoded values
duplicate variables
dead tokens
legacy names
unused tokens
theme leaks
```

---

# 9. Utilities

Inventariar realmente:

```text
display
flex
alignment
gap
spacing
width
text
visibility
responsive helpers
```

Verificar namespace:

```text
orp-*
```

Nunca depender de Bootstrap.

---

# 10. Spacing regression

Volver a verificar el problema previamente detectado en:

```text
Flex & Gap
Spacing
Padding
Margin
```

Confirmar que:

```text
orp-p-*
orp-m-*
orp-gap-*
```

funcionan en CSS compilado y Playground.

---

# 11. Layout

Auditar:

```text
Container
Page
Section
Stack
Cluster
Grid
Split
Sidebar Layout
Horizontal Scroll
App Shell
safe-area helpers
```

Buscar duplicación entre:

```text
utilities
layout primitives
component-specific layout
```

---

# 12. Navigation

Auditar:

```text
AppBar
BottomNav
Breadcrumb
Pagination
Navigation List
Navigation Group
Navigation Rail
Stepper
Back/Forward patterns
Drawer navigation
Responsive navigation
Tabs
Tabs overflow
Command Menu
Context Menu
Overflow Menu
Page Actions
Selection Bar
Shortcut Hint
Navigation Search
```

---

# 13. Forms foundation

Auditar:

```text
Field
Label
Help
Error
Input
Textarea
Select
Checkbox
Radio
Switch
```

Verificar:

```text
disabled
readonly
required
invalid
focus
placeholder
help
error
```

---

# 14. Advanced forms

Auditar:

```text
Segmented
SearchInput
FileInput
Combobox
Autocomplete
MultiSelect
TagInput
OTP/PIN
Password Field
Range
NumberStepper
```

---

# 15. Potential form gaps

Comprobar si realmente faltan:

```text
Date Picker
Time Picker
DateTime Picker
Calendar
Color Picker
Rating Input
```

NO implementarlos automáticamente.

Clasificarlos.

---

# 16. Native-first test

Para cada gap preguntar:

```text
¿HTML nativo ya lo resuelve suficientemente?
```

Ejemplo:

```text
input[type=date]
input[type=time]
input[type=color]
```

Si sí:

preferir styling/documentation antes de crear componente complejo.

---

# 17. Feedback

Auditar:

```text
Alert
Callout
Notice
Status Banner
Inline Message
Result State
Connection State
Toast
Spinner
Progress
Progress Ring
Skeleton
Empty State
```

---

# 18. Spinner regression

Obligatorio volver a verificar:

```text
continuous rotation
transform-origin
size stability
sm/md/lg
dark
custom theme
reduced motion
compiled keyframes
```

---

# 19. Skeleton regression

Obligatorio:

```text
text
multiline
circle
avatar
rectangle
card
dark
reduced motion
no flicker
no layout shift
```

---

# 20. Motion audit

Buscar globalmente:

```text
animation:
transition:
@keyframes
duration values
easing values
```

Clasificar:

```text
tokenized
hardcoded
legacy
duplicated
broken
```

---

# 21. Overlays

Auditar:

```text
Modal
Sheet
Drawer
ActionSheet
Dropdown
Popover
Toast
```

Verificar infraestructura compartida:

```text
Escape
outside click
focus trap
focus restore
scroll lock
Teleport
z-index
nested overlays
```

---

# 22. Dialogs

Auditar implementación de Parte 21.7:

```text
Dialog
Alert Dialog
Confirm Dialog
Prompt Dialog
Vertical Buttons
Preloader Dialog
Progress Dialog
Async Actions
Dialog Stack
```

Si aún no están implementados:

clasificarlos como pendientes según roadmap, no fingir que existen.

---

# 23. Notifications

Auditar Parte 21.8:

```text
Notification
Compact
Full Layout
Actions
Dismiss
Persistent
Loading
Progress
Stack
Banner
Notification Center
Read/Unread
```

---

# 24. Toast vs Notification

Buscar duplicación.

Definir claramente:

```text
Toast
→ brief feedback

Notification
→ richer app event
```

Si comparten manager/timers/host:

considerar reutilización interna.

---

# 25. Data Display

Auditar:

```text
List
Data List
Key/Value
Stat
Definition List
Timeline
Status Dot
Badge
Avatar
Meta
Price
Rating
Divider
```

---

# 26. List regression

Obligatorio revisar nuevamente:

```text
List
Divided
Inset
Composition
```

Buscar:

```text
legacy buttons
old icons
Unicode arrows
duplicate SVG
old spacing
old border
hardcoded colors
Bootstrap leakage
```

---

# 27. List composition

Debe reutilizar:

```text
Avatar
Badge
Icon
IconButton
Meta
Switch
```

No mantener versiones antiguas internas.

---

# 28. Tables

Auditar Parte 11 + 21.5:

```text
Table
variants
rich cells
sorting
selection
select all
expanded rows
sticky header
sticky column
toolbar
pagination
loading
empty
no results
error
responsive strategies
```

---

# 29. Table completeness

Clasificar si:

```text
orp-table
```

es suficiente como primitive y si:

```text
OrpDataTable
```

ya existe / debe existir antes de v0.1.

No asumir.

---

# 30. Data Visualization

Auditar:

```text
Chart Shell
Chart Header
Chart Body
Chart Footer
Legend
Metric composition
Trend
Comparison Metric
Sparkline Container
Meter
Distribution
Data color tokens
Loading/Empty/Error
```

---

# 31. Chart boundary

Confirmar que ORP NO se haya convertido accidentalmente en chart engine.

No deben aparecer componentes core tipo:

```text
OrpLineChart
OrpBarChart
OrpPieChart
```

salvo decisión explícita posterior.

---

# 32. Media primitives

Auditar:

```text
Media
MediaCard
Hero
Image Preview
Image Grid
Gallery Grid
Media Preview
Avatar Upload
Cover Upload
```

---

# 33. Video / Audio

Auditar Parte 21.6:

```text
Video Player
Audio Player
poster
play/pause
timeline
time
volume
mute
fullscreen
PiP
captions
speed
loading
buffering
error
vertical video
playlist composition
```

Si aún no se implementó:

marcar correctamente.

---

# 34. Files

Auditar:

```text
FileInput
Dropzone
File Item
File List
Attachment List
Upload Progress
Upload States
File Meta
File Type Presentation
Empty Media
```

---

# 35. Rich UI

Auditar:

```text
Stat Card
KPI Card
Feature Card
Pricing Card
Testimonial
Profile Card
Split Card
Overlay Card
Banner Card
Toolbar
Action Bar
Search Bar
Filter Bar
Filter Chips
Sort Control
Pagination Bar
Comment
Comment Thread
Chat Bubble
Message Group
Typing Indicator
Presence
Activity Feed
Section Header
Profile Header
Stats Overview
Avatar Group
Step Header
```

---

# 36. Composition test

Para cada Rich UI component preguntar:

```text
¿Es realmente un componente?
¿O debería ser una composición documentada?
```

Eliminar abstracciones innecesarias antes de release.

---

# 37. Icon system

Auditar:

```text
orp-icon
sizes
currentColor
alignment
icon buttons
decorative semantics
```

---

# 38. Legacy icon audit

Buscar:

```text
→
←
>
<
+
...
×
Unicode symbols
inline duplicate SVG
old icon classes
```

No reemplazar símbolos tipográficos legítimos.

Solo los usados como iconos de UI.

---

# 39. Bootstrap Icons

Confirmar:

```text
optional integration
Playground allowed
core agnostic
```

No importar Bootstrap CSS.

---

# 40. Swiper

Confirmar:

```text
external integration
orp-swiper styling scoped
no wrapper unnecessary
```

---

# 41. GLightbox

Confirmar:

```text
external integration
orp-lightbox progressive enhancement
no duplicate viewer
```

---

# 42. Integration gaps

Comprobar si realmente hace falta documentación/patterns para:

```text
Leaflet
Chart.js
ApexCharts
ECharts
HLS.js
```

Clasificar como integrations, NO core dependencies.

---

# 43. Potential missing components audit

Investigar específicamente estos candidatos:

```text
Tooltip
Calendar
Date Picker
Time Picker
Color Picker
Rating Input
Tree View
Tree Navigation
Carousel
Code Block
Copy Button
Keyboard Key
Resizable Panel
Split Pane
Scroll Area
Back to Top
Visually Hidden
Aspect Ratio
```

---

# 44. Tooltip

Revisar si existe.

Si falta, determinar si debe ser:

```text
REQUIRED v0.1
```

porque es un primitive de UI común.

Debe ser simple, accesible y no convertirse en Floating UI clone.

---

# 45. Calendar / Date Picker

Evaluar con cuidado.

Preguntar:

```text
¿native input es suficiente para v0.1?
```

Un calendar/date picker completo puede posponerse a v0.2.

---

# 46. Time Picker

Misma regla.

No recrear selector móvil del sistema sin necesidad.

---

# 47. Color Picker

Preferir native-first para v0.1 salvo requisito real.

---

# 48. Rating Input

Ya existe Rating como display según roadmap.

Comprobar si falta versión interactiva.

No confundir:

```text
Rating display
Rating input
```

---

# 49. Tree View

Evaluar.

Probablemente:

```text
DEFER v0.2
```

salvo que ORP ya tenga casos reales.

Tree requiere:

```text
keyboard navigation
expand/collapse
selection
ARIA tree semantics
```

y merece fase propia.

---

# 50. Carousel

No crear carousel.

Swiper ya es integración oficial.

Clasificar:

```text
EXTERNAL
```

---

# 51. Code Block

Evaluar para Documentation Site.

Puede ser docs-only y no core.

---

# 52. Copy Button

Puede ser composition:

```text
Button/IconButton + Clipboard API
```

Evaluar si helper/composable realmente aporta valor.

---

# 53. Kbd

Parte 20 introdujo `orp-kbd`.

Verificar que exista y esté documentado.

---

# 54. Aspect Ratio

Evaluar si `orp-media` ya lo resuelve.

No duplicar.

---

# 55. Scroll Area

Preferir scroll nativo.

No construir custom scrollbar component salvo necesidad real.

---

# 56. Back to Top

Probablemente app pattern, no core component.

Clasificar.

---

# 57. Visually Hidden

Comprobar utility accesible:

```text
orp-sr-only
```

o naming actual.

Si falta, probablemente REQUIRED v0.1.

---

# 58. Component Gap Matrix

Crear archivo:

```text
COMPONENT-GAPS.md
```

con columnas:

| Candidate | Exists | Needed | v0.1 | v0.2 | External | Reason |
|---|---:|---:|---:|---:|---:|---|

---

# 59. Completeness Matrix

Crear:

```text
COMPONENT-MATRIX.md
```

Formato:

| Component | CSS | Vue | Playground | Mobile | Dark | Custom | RTL | A11y | Tests | Docs | Status |
|---|---:|---:|---:|---:|---:|---:|---:|---:|---:|---:|---|

---

# 60. Score

Calcular métricas reales:

```text
components total
complete
needs polish
incomplete
broken
legacy
missing required
test coverage by component
playground coverage
docs coverage
```

No inventar porcentajes.

---

# 61. v0.1 readiness score

Puede calcularse como:

```text
required components passing / total required
```

pero documentar fórmula.

---

# 62. Public API audit

Inventariar exports reales:

```text
Vue components
composables
CSS
LESS
tokens
utilities
```

---

# 63. Missing exports

Detectar componentes implementados pero no exportados.

---

# 64. Dead exports

Detectar exports de componentes inexistentes/legacy.

---

# 65. Naming consistency

Buscar inconsistencias:

```text
OrpX
ORPX
orpX
useORP*
useOrp*
```

Mantener conventions oficiales.

---

# 66. Props consistency

Auditar patrones comunes:

```text
size
variant
tone
disabled
loading
modelValue
open
dismissible
```

No renombrar masivamente sin razón.

---

# 67. Event consistency

Auditar:

```text
update:modelValue
open
close
dismiss
change
select
confirm
cancel
```

Identificar inconsistencias.

---

# 68. Controlled vs uncontrolled

Documentar filosofía ORP.

Preferir controlled APIs donde aplicación deba ser source of truth.

---

# 69. Slots audit

Buscar:

```text
duplicate slot names
inconsistent action slots
header/footer naming
```

---

# 70. CSS namespace audit

Buscar clases ORP no prefijadas.

---

# 71. Bootstrap leakage audit

Buscar:

```text
.btn
.card
.modal
.alert
.badge
.container
.row
.col-*
.d-flex
.gap-*
.p-*
.m-*
.table
```

Distinguir etiquetas HTML de clases CSS.

---

# 72. Framework7 leakage

Buscar:

```text
f7-*
framework7
page-content
list-block
navbar-inner
```

o estilos/copias antiguas.

---

# 73. Tailwind leakage

Buscar utility classes accidentales si Playground/core no debe depender de Tailwind.

---

# 74. Hardcoded color audit

Buscar:

```text
#
rgb(
rgba(
hsl(
```

Clasificar valores legítimos vs valores que deberían usar tokens.

---

# 75. Hardcoded spacing audit

Buscar medidas repetidas:

```text
padding
margin
gap
```

que deberían usar tokens.

No tokenizar cada pixel automáticamente.

---

# 76. Radius audit

Buscar radii fuera del sistema.

---

# 77. Shadow audit

Buscar shadows legacy.

---

# 78. z-index audit

Buscar valores arbitrarios.

---

# 79. !important audit

Objetivo:

```text
0 unnecessary !important
```

Documentar excepciones reales.

---

# 80. Specificity audit

Buscar selectors demasiado profundos.

Preferir BEM simple.

---

# 81. Dead CSS

Detectar selectors sin uso cuando sea razonablemente posible.

No borrar solo por heurística sin comprobar.

---

# 82. Duplicate CSS

Buscar componentes con estilos copiados.

---

# 83. Theme audit

Cada componente visual debe clasificarse:

```text
Light PASS/FAIL
Dark PASS/FAIL
Custom PASS/FAIL
```

---

# 84. Theme hardcodes

Especial atención a:

```text
white
black
gray
shadows
overlays
skeleton
spinner
notifications
dialogs
tables
```

---

# 85. Responsive audit

Cada componente debe revisarse en:

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

No todos requieren screenshot en todos los tamaños, pero sí cobertura representativa.

---

# 86. Landscape

Revisar componentes sensibles:

```text
Dialog
Sheet
Video
BottomNav
Notification
Table
Form
```

---

# 87. RTL audit

Categorías prioritarias:

```text
navigation
breadcrumbs
pagination
lists
tables
dialogs
notifications
media controls
icons
```

---

# 88. Accessibility audit

WCAG 2.2 AA como referencia.

Revisar:

```text
semantics
labels
focus
keyboard
contrast
motion
touch targets
ARIA
screen reader behavior
disabled states
error states
```

---

# 89. Keyboard matrix

Crear tabla real por componente interactivo:

| Component | Tab | Shift+Tab | Enter | Space | Escape | Arrows | Home/End |
|---|---|---|---|---|---|---|---|

---

# 90. Focus audit

Revisar:

```text
focus-visible
focus trap
focus restore
initial focus
focus after dismiss
```

---

# 91. Reduced motion

Auditar todos los components con animation/transition.

---

# 92. Playground completeness

Cada componente público debería tener:

```text
basic demo
important variants
important states
dark example where needed
mobile behavior
```

---

# 93. Playground classification

Cada demo:

```text
PASS
NEEDS POLISH
LEGACY
BROKEN
```

---

# 94. Playground visual legacy audit

Buscar especialmente:

```text
old buttons
old icons
old cards
hardcoded demo CSS
Bootstrap utility usage
duplicate demo-only styles
```

---

# 95. Playground must consume ORP

No arreglar demos creando CSS paralelo que esconda defectos del core.

---

# 96. Tests audit

Inventariar:

```text
component tests
interaction tests
visual tests
accessibility tests
```

---

# 97. Critical components requiring tests

Antes de v0.1 deben tener cobertura fuerte:

```text
Modal
Sheet
Drawer
Dropdown
Popover
Tabs
forms
advanced inputs
DataTable if public
VideoPlayer if public
Dialogs
Notifications
```

---

# 98. Visual regression

Usar Parte 17 como base.

Agregar fixtures de las fases 21.5–21.8 si ya están implementadas.

---

# 99. Build audit

Ejecutar build limpio.

Confirmar:

```text
no warnings relevantes
CSS generated
ESM generated
exports valid
assets valid
```

---

# 100. SSR audit

Importar package en entorno sin DOM cuando sea posible.

Buscar acceso top-level a:

```text
window
document
localStorage
navigator
```

---

# 101. Dependency audit

Revisar `package.json`.

Clasificar:

```text
dependency
devDependency
peerDependency
```

Vue debe seguir siendo peer dependency si así está definido.

---

# 102. Dependency policy

No instalar paquetes durante audit salvo que sean estrictamente necesarios para tooling ya aprobado.

---

# 103. Bundle audit

Medir:

```text
CSS size
CSS gzip if tooling exists
JS size
JS gzip if tooling exists
```

No inventar números.

---

# 104. Tree shaking

Verificar imports individuales cuando arquitectura lo permita.

---

# 105. Side effects

Revisar que importar un componente no:

```text
registre listeners globales
modifique DOM
inyecte estilos runtime inesperados
```

---

# 106. Documentation readiness

Antes de Parte 22 identificar:

```text
components without docs
components with outdated docs
examples missing
API inconsistencies
migration notes needed
```

---

# 107. Naming freeze candidate

Después de esta fase proponer qué APIs pueden congelarse para v0.1.

---

# 108. Breaking changes

Este es el último buen momento antes del release para corregir:

```text
bad names
bad props
bad events
duplicate components
```

---

# 109. Do not preserve mistakes blindly

Como aún no existe release estable:

se permiten breaking changes internas justificadas.

Pero documentarlas.

---

# 110. Component deprecation

Si existen duplicates/legacy:

preferir:

```text
remove before v0.1
```

en vez de comenzar el framework con deprecated APIs.

---

# 111. Required vs nice-to-have

Un componente solo entra a v0.1 si cumple al menos uno:

```text
common foundational UI primitive
needed by multiple existing components
real gap in current apps
needed for accessibility/completeness
small enough to harden properly
```

---

# 112. Defer rule

Mover a v0.2 si:

```text
complex interaction model
specialized domain
large accessibility surface
requires specialized dependency
no current real use case
duplicates native browser functionality sufficiently
```

---

# 113. External rule

Clasificar como EXTERNAL si una librería especializada ya resuelve mejor:

```text
carousel → Swiper
lightbox → GLightbox
maps → Leaflet
charts → Chart.js/ApexCharts/ECharts/etc.
advanced streaming → HLS.js/Shaka
```

---

# 114. Out of Core rule

Ejemplos probables:

```text
Kanban
Rich Text Editor
File Manager
Spreadsheet
Advanced Calendar Scheduler
Diagram Editor
Page Builder
```

No son primitives del core.

---

# 115. Proposed v0.1 gap shortlist

El agente debe determinarlo con evidencia.

No obstante, prestar especial atención a si faltan primitives pequeños como:

```text
Tooltip
Visually Hidden
Aspect Ratio helper
interactive Rating
```

Estos podrían ser candidatos razonables.

No implementarlos hasta terminar la matriz.

---

# 116. Tooltip acceptance test

Si se decide REQUIRED v0.1:

debe incluir:

```text
hover
focus
Escape
accessible relationship
no essential information only in tooltip
basic viewport handling
reduced motion
touch strategy
```

Sin recrear Floating UI.

---

# 117. Date Picker acceptance decision

Si native input es suficiente:

documentar:

```text
DEFER v0.2
```

No crear un calendario solo para aumentar component count.

---

# 118. Tree View acceptance decision

Por defecto considerar:

```text
DEFER v0.2
```

hasta que exista caso real y fase propia.

---

# 119. Notification/Dialog completeness

Dado que fueron detectados como gaps reales antes de esta fase:

si las Partes 21.7/21.8 ya se implementaron, deben recibir prioridad alta de hardening.

---

# 120. Tables completeness

Lo mismo para Parte 21.5.

No considerar "hecho" solo porque existe CSS.

Debe pasar:

```text
mobile
dark
keyboard
selection
sorting
sticky
loading
empty
tests
```

según scope implementado.

---

# 121. Video completeness

Si Parte 21.6 está implementada:

probar APIs de browser con feature detection.

No convertir fallos de PiP/fullscreen no soportados en fallos generales del player.

---

# 122. Gap decision record

Para cada componente candidato registrar:

```text
Decision
Reason
Evidence
Release target
Dependencies
Accessibility complexity
```

---

# 123. Technical debt register

Crear:

```text
TECHNICAL-DEBT.md
```

solo con deuda real encontrada.

Campos:

```text
ID
Area
Severity
Description
Impact
Recommended fix
Release target
```

---

# 124. Severity

Usar:

```text
BLOCKER
HIGH
MEDIUM
LOW
```

---

# 125. Blockers

Ejemplos:

```text
build broken
public component unusable
keyboard trap
focus loss in modal
CSS namespace collision
Bootstrap dependency in core
SSR import crash
```

---

# 126. High severity

Ejemplos:

```text
major dark-theme failure
mobile overflow
broken selection
inaccessible control
missing public export
```

---

# 127. Medium

Ejemplos:

```text
visual inconsistency
missing state
weak demo
minor API inconsistency
```

---

# 128. Low

Ejemplos:

```text
small polish
docs wording
minor spacing
```

---

# 129. Release gate

No recomendar Parte 22 como "ready" hasta que:

```text
0 BLOCKER
0 unresolved REQUIRED-v0.1 gaps
critical components tested
build passes
Playground critical demos pass
public API inventory exists
```

---

# 130. Documentation can begin with minor debt

No exigir perfección absoluta.

`MEDIUM/LOW` pueden permanecer si están registrados y no comprometen API/core quality.

---

# 131. Required artifacts

Al terminar crear:

```text
COMPONENT-INVENTORY.md
COMPONENT-MATRIX.md
COMPONENT-GAPS.md
TECHNICAL-DEBT.md
V0.1-READINESS.md
```

en ubicación adecuada del repo.

---

# 132. V0.1 Readiness report

Debe contener:

```text
Executive summary
Inventory totals
Complete components
Incomplete components
Broken components
Legacy components
Required gaps
Deferred v0.2 components
External integrations
Accessibility status
Theme status
Responsive status
RTL status
Testing status
Documentation status
Build status
Bundle status
Blockers
Recommended next action
```

---

# 133. Recommended next action

El resultado debe terminar en una de estas decisiones:

```text
A. READY FOR PART 22
B. FIX BLOCKERS BEFORE PART 22
C. IMPLEMENT REQUIRED GAPS BEFORE PART 22
```

No decir simplemente "looks good".

---

# 134. If required gaps exist

Implementar únicamente los marcados:

```text
REQUIRED v0.1
```

después de presentar la matriz.

No implementar NICE TO HAVE.

---

# 135. Re-run audit after fixes

Después de corregir blockers/gaps:

actualizar matrices y readiness.

---

# 136. Final verification

Ejecutar:

```text
build
tests
visual regression
namespace audit
Bootstrap leakage audit
theme smoke tests
mobile smoke tests
```

---

# 137. Expected final state

Idealmente:

```text
Foundation          COMPLETE
Layout              COMPLETE
Navigation          COMPLETE
Forms               COMPLETE
Feedback            COMPLETE
Overlays            COMPLETE
Dialogs             COMPLETE
Notifications       COMPLETE
Data Display        COMPLETE
Tables              COMPLETE
Media               COMPLETE
Files               COMPLETE
Rich UI             COMPLETE
Integrations        DEFINED
Accessibility       PASS
Themes              PASS
Responsive          PASS
Build               PASS
```

No falsificar COMPLETE si la evidencia no lo soporta.

---

# 138. What NOT to do

No usar esta fase como excusa para agregar:

```text
30 new components
enterprise widgets
domain-specific UI
random animations
new dependencies
framework integrations
```

---

# 139. Explicit exclusions

No implementar automáticamente:

```text
Calendar scheduler
Kanban
Tree Grid
Rich Text Editor
WYSIWYG
File Manager
Spreadsheet
Pivot Grid
Page Builder
Diagram Editor
Maps engine
Chart engine
Carousel engine
Lightbox engine
Streaming engine
Drag/drop builder
```

---

# 140. No new dependencies

No instalar nuevas dependencias de UI.

Si el audit descubre una necesidad que requiere dependencia especializada:

clasificar:

```text
EXTERNAL
```

o:

```text
DEFER v0.2
```

---

# 141. Do not start Documentation Site

No implementar Parte 22 dentro de esta fase.

Parte 21.9 termina con:

```text
audit
fixes required for release
matrices
readiness report
```

---

# Regla final

Esta fase cambia la pregunta de:

```text
¿Qué otro componente podemos agregar?
```

a:

```text
¿Qué necesita realmente ORP UI para ser un framework coherente, estable y publicable?
```

La prioridad es:

```text
completeness
> consistency
> accessibility
> reliability
> component count
```

Y el flujo final debe ser:

```text
ORP UI current codebase
        ↓
Component Inventory
        ↓
Completeness Matrix
        ↓
Gap Analysis
        ↓
Required v0.1 fixes
        ↓
Regression
        ↓
V0.1 Readiness
        ↓
Part 22 — Documentation Site
```

No avanzar a Parte 22 automáticamente.

