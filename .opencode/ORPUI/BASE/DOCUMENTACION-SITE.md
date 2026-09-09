# SKILL — ORP UI / Parte 22: Documentation Site & Developer Experience

## Objetivo

Construir la **documentación oficial de ORP UI** como producto técnico usable, navegable y mantenible.

Esta fase NO debe agregar componentes nuevos al framework.

Parte 22 parte del resultado de:

```text
Parte 21.9
→ Component Inventory
→ Component Matrix
→ Component Gaps
→ Technical Debt
→ v0.1 Readiness
```

La documentación debe reflejar **el código real**, no solamente los roadmaps o especificaciones históricas.

La meta es que un desarrollador pueda:

```text
entender ORP UI
instalarlo
configurarlo
usar CSS primitives
usar Vue components
usar composables
personalizar themes
integrar iconos
integrar Swiper/GLightbox
entender accessibility
copiar ejemplos
encontrar APIs
resolver problemas
```

sin tener que leer el source code.

---

# 1. Regla principal

La documentación debe ser:

```text
accurate
searchable
copyable
mobile-friendly
accessible
version-aware
maintainable
```

No construir una landing de marketing disfrazada de documentación.

---

# 2. Source of truth

Antes de escribir docs leer:

```text
COMPONENT-INVENTORY.md
COMPONENT-MATRIX.md
COMPONENT-GAPS.md
TECHNICAL-DEBT.md
V0.1-READINESS.md
package.json
public exports
LESS entry points
CSS build output
Vue source
Playground
tests
```

Si un componente no existe realmente:

NO documentarlo como disponible.

---

# 3. Documentation architecture

Estructura propuesta:

```text
ORP UI Docs
├── Introduction
├── Getting Started
├── Foundations
├── Layout
├── Components
├── Forms
├── Navigation
├── Feedback
├── Overlays
├── Dialogs
├── Notifications
├── Data Display
├── Tables
├── Data Visualization
├── Media
├── Files
├── Rich UI
├── Integrations
├── Accessibility
├── Theming
├── Utilities
├── API
├── Guides
└── Release / Migration
```

Adaptar a inventario real.

---

# 4. Documentation technology

Primero auditar tooling existente.

No instalar automáticamente:

```text
VitePress
Docusaurus
Storybook
Nuxt Content
Astro Starlight
```

Si ya existe una solución adecuada:

reutilizarla.

Si no existe:

evaluar la alternativa más pequeña compatible con el proyecto.

---

# 5. Preferred principle

La documentación debe evitar convertirse en otro framework dentro del framework.

Preferir:

```text
Vite-compatible
Vue-friendly
Markdown-friendly
static build
simple deployment
low maintenance
```

---

# 6. Tooling decision report

Antes de implementar registrar:

```text
existing tooling
options evaluated
chosen solution
reason
dependencies added
build impact
```

Si no es necesario agregar dependencia, mejor.

---

# 7. Documentation package isolation

Si docs requieren dependencias:

deben ser dev/docs dependencies.

No aumentar runtime dependencies de ORP UI.

---

# 8. Documentation visual identity

La documentación debe usar ORP UI tanto como sea razonable.

Objetivo:

```text
ORP documents ORP
```

Esto también funciona como integración real del framework.

---

# 9. Avoid circular fragility

El shell de documentación puede tener CSS mínimo propio para layout editorial si es necesario.

Pero los ejemplos/componentes deben consumir ORP real.

No crear versiones fake de componentes.

---

# 10. Docs shell

Necesidades:

```text
top navigation
sidebar
content area
table of contents
mobile navigation
search
previous/next navigation
version indicator
theme toggle
```

---

# 11. Responsive docs

Debe funcionar en:

```text
320
375
390
430
768
992
1200
1440
```

---

# 12. Mobile navigation

En mobile:

```text
AppBar
+
Drawer/Sheet navigation
```

o composición equivalente usando ORP.

No mantener sidebar desktop comprimido a 320px.

---

# 13. Desktop navigation

Layout recomendado:

```text
Sidebar
Content
On-page TOC
```

cuando exista espacio suficiente.

---

# 14. Documentation navigation hierarchy

No hacer sidebar con cientos de links al mismo nivel.

Usar categorías claras.

Ejemplo:

```text
Components
  Actions
  Data Display
  Feedback
  Navigation
  Overlays
  Forms
```

---

# 15. Introduction

Crear:

```text
What is ORP UI?
Design principles
Architecture
What ORP UI is not
Browser support
Framework boundaries
```

---

# 16. Philosophy page

Documentar principios:

```text
mobile-first
CSS-first
semantic HTML
Vue when behavior justifies it
composition over duplication
runtime CSS variables
icon agnostic
framework agnostic core
accessibility
no unnecessary dependencies
```

---

# 17. ORP vs application boundary

Página importante:

```text
ORP UI owns
→ presentation
→ interaction
→ accessibility

Application owns
→ routing
→ API
→ permissions
→ business logic
→ persistence
```

---

# 18. Getting Started

Debe incluir:

```text
Installation
CSS import
Vue imports
Optional integrations
First component
First layout
Theming
```

---

# 19. Installation

Documentar instalación real según package actual.

No inventar nombre npm si todavía no está publicado.

Si package aún es local:

explicarlo correctamente.

---

# 20. CSS import

Documentar entry point real.

Ejemplo conceptual:

```js
import 'orp-ui/dist/orp-ui.css'
```

Usar ruta verdadera del build.

---

# 21. LESS usage

Si source LESS se distribuye:

documentar:

```text
entry point
variables
when to consume LESS
when to prefer CSS variables
```

---

# 22. Vue usage

Ejemplo:

```js
import { OrpSomething } from '...'
```

solo con exports reales.

---

# 23. No mandatory plugin

Si ORP no requiere:

```js
app.use()
```

dejarlo explícito.

---

# 24. Foundations docs

Crear páginas para:

```text
Colors
Typography
Spacing
Radius
Shadows
Motion
Z-index
Breakpoints
Focus
Safe Areas
```

---

# 25. Token documentation

Mostrar:

```text
token
value/default
purpose
example
```

para tokens públicos.

---

# 26. CSS Custom Properties

Documentar semantic runtime tokens:

```text
--orp-background
--orp-foreground
--orp-surface
--orp-surface-foreground
--orp-surface-muted
--orp-primary
--orp-primary-foreground
--orp-secondary
--orp-secondary-foreground
--orp-muted
--orp-muted-foreground
--orp-border
--orp-input
--orp-ring
--orp-success
--orp-warning
--orp-danger
--orp-info
```

solo si siguen vigentes.

---

# 27. Data colors

Documentar por separado:

```text
--orp-data-1
...
--orp-data-N
```

si realmente existen.

Explicar:

```text
categorical data colors != semantic status colors
```

---

# 28. Motion docs

Documentar:

```text
duration tokens
easing
reduced motion
```

---

# 29. Layout docs

Cubrir:

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
```

solo los existentes.

---

# 30. Utilities docs

Crear referencia compacta de:

```text
display
flex
alignment
gap
spacing
width
text
visibility
```

No hacer una página gigantesca imposible de navegar.

---

# 31. Utility examples

Mostrar visualmente:

```text
orp-gap-*
orp-p-*
orp-m-*
```

para evitar regresiones como las detectadas anteriormente.

---

# 32. Component documentation template

Cada componente público debe seguir una plantilla consistente.

---

# 33. Component page structure

```text
# Component Name

Summary
When to use
When not to use
Basic example
Variants
States
Composition
API
Accessibility
Keyboard
Responsive behavior
Theming
Related components
```

No todas las secciones necesitan contenido si no aplican.

---

# 34. CSS primitive page

Para componentes CSS-first:

```text
HTML example
classes
modifiers
CSS variables
composition
accessibility
```

No inventar API Vue.

---

# 35. Vue component page

Para Vue:

```text
Import
Basic usage
Props
Events
Slots
v-model behavior
Methods/exposed API if any
Accessibility
Examples
```

---

# 36. Composable page

Documentar:

```text
import
return value
methods
lifecycle behavior
SSR considerations
example
```

---

# 37. API tables

Props:

| Prop | Type | Default | Description |

Events:

| Event | Payload | Description |

Slots:

| Slot | Props | Description |

Usar tipos reales del JavaScript/JSDoc/source.

---

# 38. No invented defaults

Si source no tiene default:

no poner uno por intuición.

---

# 39. Live examples

Los ejemplos deben renderizar componentes reales.

---

# 40. Code + Preview pattern

Preferir:

```text
Preview
Code
```

o:

```text
Code
Preview
```

de forma consistente.

---

# 41. Copy code

Agregar botón de copiar si se puede resolver de forma ligera.

Puede usar:

```text
IconButton
Clipboard API
```

No requiere componente core nuevo.

---

# 42. Copy feedback

Usar Toast/inline state ORP si corresponde.

---

# 43. Editable playground

NO construir editor online completo en esta fase.

---

# 44. Demo isolation

Ejemplos interactivos no deben contaminar estado entre páginas.

---

# 45. Deterministic examples

No depender de:

```text
external APIs
random values
remote images
network timing
```

para demos fundamentales.

---

# 46. Component categories

Basarse en inventario real.

Una posible estructura:

```text
Actions
Content
Data Display
Feedback
Forms
Layout
Media
Navigation
Overlays
Utilities
```

---

# 47. Buttons

Documentar variantes, sizes, disabled/loading si existen, icon composition y accessibility.

---

# 48. Cards

Documentar primitive y composiciones.

Evitar documentar cada domain card como componente.

---

# 49. Lists

La documentación de List debe mostrar explícitamente:

```text
Basic
Divided
Inset
Composition
```

usando estilos/iconos actuales.

No reutilizar demos legacy.

---

# 50. Forms

Organizar docs en:

```text
Form Foundation
Input
Textarea
Select
Checkbox
Radio
Switch
Search
File Input
Segmented
Combobox
Autocomplete
MultiSelect
TagInput
OTP
Password
Range
Number Stepper
```

según inventario.

---

# 51. Validation guide

Página transversal:

```text
Field
Help
Error
aria-describedby
aria-invalid
required
disabled
readonly
```

---

# 52. Navigation docs

Cubrir:

```text
AppBar
BottomNav
Tabs
Breadcrumb
Pagination
Nav
Rail
Stepper
Drawer navigation
Command UX
```

según implementación.

---

# 53. Overlay guide

Crear una página que ayude a elegir:

```text
Dropdown
Popover
Modal
Dialog
Sheet
Drawer
ActionSheet
```

---

# 54. Overlay accessibility

Explicar:

```text
blocking vs non-blocking
focus trap
Escape
outside click
focus restore
scroll lock
```

---

# 55. Dialog docs

Si Parte 21.7 está implementada:

```text
Dialog
Alert Dialog
Confirm
Prompt
Vertical Buttons
Preloader
Progress
Stack
Async Actions
```

---

# 56. Promise API

Mostrar APIs reales como:

```js
await dialog.confirm(...)
```

solo si existen.

---

# 57. Notifications docs

Si Parte 21.8 está implementada:

```text
Notification
Compact
Full
Actions
Dismiss
Persistent
Stack
Banner
Notification Center
Read/Unread
```

---

# 58. Notification decision guide

Explicar:

```text
Toast vs Notification
Alert vs Notification
Notification vs Dialog
Banner vs Notification
```

---

# 59. Tables docs

Si Parte 21.5 está implementada:

```text
Table
DataTable
Sorting
Selection
Expanded Rows
Sticky Header
Sticky Column
Toolbar
Pagination
States
Responsive
```

---

# 60. Table vs DataTable

Página/section clara:

```text
Table
→ semantic presentation

DataTable
→ coordinated interactive UI
```

---

# 61. Mobile tables

Documentar estrategias:

```text
horizontal scroll
sticky first column
priority columns
explicit Data List alternative
```

No enseñar transformación automática a cards.

---

# 62. Data Visualization docs

Documentar:

```text
Chart Shell
Legend
Metric
Trend
Meter
Distribution
Data colors
States
External integrations
```

---

# 63. External charts guide

Explicar cómo mapear CSS variables de ORP a librerías externas.

No crear adapters falsos.

---

# 64. Files docs

Cubrir:

```text
File Input
Dropzone
File Item
File List
Attachments
Upload Progress
Image Preview
Gallery
Avatar/Cover Upload
States
```

---

# 65. Upload boundary

Explicar:

```text
ORP
→ UI

Application
→ actual upload
```

---

# 66. Media docs

Si Parte 21.6 está implementada:

```text
Video Player
Audio Player
Captions
Fullscreen
PiP
Playback Speed
Video Cards
Playlist composition
Streaming integrations
```

---

# 67. Streaming boundary

Documentar:

```text
native MP4/WebM
vs
HLS/DASH/DRM specialized libraries
```

---

# 68. Rich UI docs

Distinguir:

```text
primitive
component
composition pattern
```

Esto evita que usuarios crean que cada ejemplo es una API nueva.

---

# 69. Integrations

Crear sección oficial:

```text
Bootstrap Icons
Swiper
GLightbox
```

y cualquier otra integración oficialmente aceptada tras 21.9.

---

# 70. Bootstrap Icons

Explicar que:

```text
Bootstrap Icons optional
Bootstrap CSS NOT required
```

---

# 71. Swiper

Mostrar integración scoped:

```text
orp-swiper
```

sin wrapper ORP innecesario.

---

# 72. GLightbox

Mostrar progressive enhancement.

---

# 73. Accessibility section

Debe ser una sección principal, no una nota al pie.

---

# 74. Accessibility overview

Cubrir:

```text
WCAG reference
semantic HTML
keyboard
focus
ARIA
contrast
touch targets
motion
screen readers
```

---

# 75. Keyboard guide

Crear matriz general de keyboard behavior para componentes complejos.

---

# 76. Reduced Motion

Página/section específica.

---

# 77. RTL

Documentar soporte:

```text
dir="rtl"
logical properties
known limitations
```

---

# 78. Theming

Crear guía completa.

---

# 79. Theme architecture

Explicar:

```text
LESS
→ authoring/build

CSS Custom Properties
→ runtime theme
```

---

# 80. Light theme

Documentar default real.

---

# 81. Dark theme

Ejemplo:

```html
<html data-orp-theme="dark">
```

si sigue siendo API oficial.

---

# 82. Custom theme

Ejemplo:

```html
<html data-orp-theme="brand">
```

con override de variables.

---

# 83. Theme demo

Mostrar un mismo conjunto de componentes en:

```text
Light
Dark
Custom
```

---

# 84. Theme toggle

Docs site puede incluir theme switcher.

Debe reutilizar arquitectura real de ORP.

---

# 85. System theme

Si existe composable/system mode real:

documentarlo.

Si no existe:

no inventarlo.

---

# 86. Guides

Crear guías prácticas.

Ejemplos:

```text
Build a mobile app shell
Build a settings screen
Build a form
Build a dashboard
Build a data table screen
Build a notification center
Build a media screen
```

---

# 87. Guides are compositions

No introducir nuevos components solo para completar tutorial.

---

# 88. Example app patterns

Los guides deben mostrar cómo primitives se combinan.

Esto es crucial para la filosofía composition-first.

---

# 89. Search

La documentación debe tener búsqueda si el tooling elegido lo permite de forma razonable.

---

# 90. Search requirements

Buscar al menos:

```text
page title
headings
component names
API names
keywords
```

---

# 91. No external SaaS requirement

No hacer Algolia obligatorio para docs iniciales.

Preferir search estático/local si tooling lo permite.

---

# 92. Search keyboard

Si existe:

```text
Cmd/Ctrl + K
```

puede reutilizar Command UX de ORP.

---

# 93. Search accessibility

Debe ser navegable por teclado.

---

# 94. On-page TOC

Generar desde headings si tooling lo permite.

---

# 95. Heading hierarchy

No saltar niveles arbitrariamente.

---

# 96. Anchor links

Cada heading importante debe poder enlazarse.

---

# 97. Previous / Next

Al final de páginas:

```text
Previous
Next
```

según navegación real.

---

# 98. Breadcrumb

Puede reutilizar ORP Breadcrumb.

---

# 99. Version display

Mostrar versión actual del package.

No hardcodearla en múltiples archivos.

---

# 100. Version source

Preferir:

```text
package.json
```

o build metadata.

---

# 101. Versioned docs

Para v0.1 no construir un sistema enorme de versiones si aún no hace falta.

Pero arquitectura no debe impedir:

```text
v0.1
v0.2
v1
```

en futuro.

---

# 102. Changelog

Preparar espacio para:

```text
CHANGELOG
```

pero la política final pertenece a Parte 23/24.

---

# 103. Migration docs

No son necesarias si todavía no hay versiones públicas anteriores.

Sí documentar breaking changes internas relevantes si ya existen consumidores.

---

# 104. Browser support

Documentar browsers realmente soportados.

No inventar matriz sin tests/build target.

---

# 105. SSR guide

Documentar componentes/composables SSR-safe y cualquier limitación conocida.

---

# 106. Vue integration

Documentar:

```text
Vue 3
script setup
direct imports
v-model conventions
```

---

# 107. Laravel/Inertia example

ORP core no depende de Laravel/Inertia.

Puede existir una guía opcional:

```text
Using ORP UI with Laravel + Inertia + Vue
```

solo como integration guide.

---

# 108. No Laravel coupling

No mover código Laravel/Inertia al package core.

---

# 109. Playground relationship

Definir claramente:

```text
Playground
→ development/QA showcase

Documentation Site
→ public developer reference
```

---

# 110. Reuse demos

Cuando sea viable, compartir fixtures/examples.

Evitar dos versiones divergentes del mismo demo.

---

# 111. Avoid copy drift

Idealmente los snippets provienen del mismo ejemplo que renderiza preview, o existe proceso claro para mantenerlos sincronizados.

---

# 112. Example code quality

Todos los snippets deben:

```text
use current classes
use current API
avoid Bootstrap CSS
avoid legacy icons
be accessible
be minimal
```

---

# 113. Bootstrap leakage audit

Escanear docs/examples por:

```text
btn
card
modal
alert
container
row
col-*
d-flex
gap-*
p-*
m-*
```

como clases Bootstrap.

Bootstrap Icons siguen permitidos donde se documente integración.

---

# 114. Legacy code audit

No copiar snippets viejos del Playground sin revisarlos.

Especialmente:

```text
List
Spinner
Skeleton
Modal
forms
```

---

# 115. Syntax highlighting

Si tooling lo incluye:

usar highlighting.

No agregar una dependencia pesada solo por highlighting si el docs engine ya lo resuelve.

---

# 116. Code blocks

Deben permitir:

```text
HTML
Vue
JavaScript
CSS
LESS
```

---

# 117. Line wrapping

Snippets deben ser legibles en mobile.

Usar horizontal scroll donde sea necesario.

---

# 118. Copy button accessibility

Accessible label:

```text
Copy code
```

y estado:

```text
Copied
```

sin depender solo de icono.

---

# 119. Images

No depender de screenshots cuando un live demo puede comunicar mejor.

---

# 120. Visual examples

Screenshots pueden usarse para:

```text
responsive comparisons
theme comparisons
integration outcomes
```

pero no sustituir ejemplos ejecutables.

---

# 121. Content language

Elegir un idioma principal consistente para docs.

Si proyecto decide inglés para API/docs técnicas:

mantener nombres técnicos en inglés.

No mezclar páginas mitad español/mitad inglés sin estrategia.

---

# 122. Internationalization

No construir sistema completo de traducciones de docs en v0.1 salvo requisito real.

---

# 123. SEO

Como documentación pública, incluir:

```text
title
description
canonical strategy if needed
semantic headings
Open Graph basics
```

sin convertir esta fase en proyecto SEO.

---

# 124. Metadata

Cada página debería poder definir:

```text
title
description
category
```

si tooling lo soporta.

---

# 125. Performance

Docs deben cargar rápido.

Evitar cargar todos los componentes Vue en cada página si no son necesarios.

---

# 126. Lazy demos

Demos pesados como:

```text
video
Swiper
GLightbox
```

pueden cargarse solo donde se usan.

---

# 127. External assets

Evitar dependencias remotas innecesarias.

---

# 128. Fonts

Preferir estrategia ya definida por ORP/docs.

No bloquear docs por múltiples fuentes externas.

---

# 129. Accessibility of docs site

Auditar el sitio de documentación como producto:

```text
skip link
landmarks
sidebar keyboard
mobile nav
search
focus
contrast
heading order
code blocks
links
theme toggle
```

---

# 130. Skip link

Debe existir:

```text
Skip to content
```

o equivalente.

---

# 131. Active navigation

Usar:

```text
aria-current
```

donde corresponda.

---

# 132. Mobile menu focus

Si usa Drawer/Sheet:

reutilizar focus management de ORP.

---

# 133. Dark mode docs

No solo shell.

Los live examples también deben poder comprobarse correctamente.

---

# 134. Example theme isolation

Evitar que el theme del docs shell haga imposible demostrar Light dentro de Dark docs.

Puede ser necesario un demo frame/container con theme explícito.

---

# 135. Demo canvas

Crear un primitive docs-only, por ejemplo:

```text
DemoFrame
```

NO exportarlo como ORP component.

---

# 136. DemoFrame responsibilities

```text
preview surface
padding
theme selection
responsive width simulation if needed
```

No recrear browser emulator complejo.

---

# 137. Component status

Si 21.9 deja algún componente:

```text
experimental
```

mostrarlo claramente.

No presentarlo como estable.

---

# 138. Experimental API

Si existe, documentar:

```text
may change before v1
```

sin abusar de la etiqueta.

---

# 139. Deprecated

Idealmente v0.1 no debería arrancar con deprecated APIs.

Si existen:

documentar replacement.

---

# 140. Known limitations

Cada componente complejo puede incluir:

```text
Known limitations
```

cuando sea relevante.

Especialmente:

```text
Video APIs
PiP
native inputs
sticky tables
browser differences
```

---

# 141. Accessibility warnings

Si un pattern requiere responsabilidad de aplicación:

documentarlo.

Ejemplo:

```text
Chart must have textual alternative.
```

---

# 142. API reference generation

No construir generador automático complejo en esta fase salvo tooling existente.

Manual/structured Markdown es aceptable.

---

# 143. Source links

Si repo será público, puede prepararse espacio para:

```text
View source
```

pero no hardcodear URLs inexistentes.

---

# 144. Edit page links

Opcional.

No requisito v0.1.

---

# 145. 404

Docs site debe tener página 404 útil.

---

# 146. Error handling

Una demo rota no debe tumbar toda la documentación.

---

# 147. Build

Agregar build de docs separado del package build cuando corresponda.

Ejemplo conceptual:

```text
npm run build
npm run docs:build
```

según tooling real.

---

# 148. Dev command

Ejemplo conceptual:

```text
npm run docs:dev
```

solo si se configura realmente.

---

# 149. Preview command

Si tooling lo permite:

```text
docs:preview
```

---

# 150. CI readiness

Parte 22 puede preparar docs para CI, pero deployment automático pertenece a decisión de infraestructura/Parte 23 si no existe.

---

# 151. Broken link check

Agregar/verificar chequeo de enlaces internos si tooling lo soporta.

---

# 152. Build warnings

No ignorar:

```text
broken anchors
duplicate headings
missing pages
bad imports
```

---

# 153. Documentation completeness matrix

Crear:

```text
DOCS-MATRIX.md
```

con:

| Component | Overview | Example | API | A11y | Mobile | Theme | Status |
|---|---:|---:|---:|---:|---:|---:|---|

---

# 154. Coverage target

Todo componente público v0.1 debe tener al menos:

```text
summary
basic usage
API/classes
accessibility notes where applicable
```

---

# 155. Critical docs

Antes de considerar Parte 22 completa deben estar muy bien documentados:

```text
Installation
Theming
Button
Forms
Modal/Dialog
Navigation
Table/DataTable
Notifications
Accessibility
Integrations
```

según inventario real.

---

# 156. Guides minimum

Crear al menos guías suficientes para demostrar composición real.

Sugeridas:

```text
Mobile App Shell
Settings Form
Dashboard
Data Table Screen
Notification Center
```

No es obligatorio usar exactamente esas si el inventario indica otras mejores.

---

# 157. Mobile App Shell guide

Debe combinar piezas existentes, por ejemplo:

```text
AppShell
AppBar
Page
BottomNav
FAB
```

---

# 158. Dashboard guide

Puede combinar:

```text
Grid
Stat
Trend
Chart Shell
Table
Toolbar
```

---

# 159. Data Table guide

Mostrar:

```text
Toolbar
Search
Filters
Table/DataTable
Pagination
Selection
```

sin backend real.

---

# 160. Notification Center guide

Mostrar:

```text
AppBar badge
Sheet/Popover
Notification List
Read/Unread
Empty
```

---

# 161. Form guide

Mostrar:

```text
Field
Input
Select
Checkbox
validation
Button
```

---

# 162. No fake business APIs

Usar datos locales deterministas.

---

# 163. Testing docs

Ejecutar tests existentes después de integrar docs.

---

# 164. Docs visual regression

Capturar al menos:

```text
home/intro
component page desktop
component page mobile
dark mode
sidebar
mobile navigation
code preview
table docs
dialog docs
notification docs
```

---

# 165. Docs accessibility test

Si axe u otra herramienta ya está disponible:

usarla en páginas críticas.

No agregar dependencia automáticamente si no existe sin justificarla.

---

# 166. Responsive testing

Obligatorio:

```text
320
375
390
430
768
992
1200
1440
```

en shell y páginas representativas.

---

# 167. RTL

La documentación no necesariamente debe estar escrita RTL, pero debe existir forma de demostrar/testear componentes RTL.

---

# 168. Component RTL demos

Puede existir toggle:

```text
LTR / RTL
```

en DemoFrame docs-only si resulta sencillo.

---

# 169. Theme demo controls

Puede existir:

```text
Light / Dark / Custom
```

en demos.

No convertirlo en component core.

---

# 170. Viewport demo controls

Opcional:

```text
Mobile / Tablet / Desktop
```

si puede hacerse ligero.

No construir iframe simulator complejo.

---

# 171. Search indexing

No indexar páginas internas/fixtures que no deban aparecer.

---

# 172. Documentation URL structure

Preferir rutas estables:

```text
/getting-started/installation
/foundations/colors
/components/button
/forms/input
/feedback/notification
/data/table
```

según tooling.

---

# 173. Avoid unnecessary nesting

No crear URLs de seis niveles.

---

# 174. Naming alignment

URL/page/component title debe corresponder con API real.

---

# 175. Cross-links

Agregar links entre componentes relacionados:

```text
Alert ↔ Dialog ↔ Notification ↔ Toast
Table ↔ Data List
Progress ↔ Meter
MediaCard ↔ Video
Modal ↔ Sheet ↔ Drawer
```

---

# 176. Decision guides

Estas páginas son especialmente importantes porque ORP tiene muchos primitives.

Crear guías como:

```text
Choosing an overlay
Choosing feedback UI
Choosing data display
Choosing responsive layout
Choosing a media pattern
```

---

# 177. Feedback decision

Ejemplo:

```text
Small temporary result?
→ Toast

Rich incoming event?
→ Notification

Contextual message?
→ Alert/Callout

Requires decision?
→ Dialog
```

---

# 178. Overlay decision

```text
Anchored action?
→ Dropdown/Popover

Focused decision?
→ Dialog

Large mobile workflow?
→ Sheet

Navigation panel?
→ Drawer
```

---

# 179. Data display decision

```text
Compare columns?
→ Table

Item-oriented information?
→ Data List

Single metrics?
→ Stat

Visualization shell?
→ Chart
```

---

# 180. Documentation anti-patterns

NO:

```text
document roadmap-only components as real
duplicate component CSS in docs
use Bootstrap CSS for docs demos
copy old Playground markup blindly
hide broken components with docs-only CSS
invent props/events
invent package install commands
```

---

# 181. Explicit exclusions

No construir en Parte 22:

```text
online code sandbox
visual component builder
Figma plugin
AI documentation chatbot
full localization system
analytics platform
user accounts
comments
CMS
documentation SaaS
complex versioning backend
```

---

# 182. No component expansion

Si durante docs se descubre un componente faltante:

registrarlo en:

```text
COMPONENT-GAPS.md
```

No implementarlo automáticamente salvo que sea un BLOCKER/REQUIRED v0.1 ya aprobado en Parte 21.9.

---

# 183. Files expected

Dependiendo de tooling, crear estructura similar a:

```text
docs/
├── index
├── getting-started/
├── foundations/
├── layout/
├── components/
├── forms/
├── navigation/
├── feedback/
├── overlays/
├── dialogs/
├── notifications/
├── data/
├── media/
├── files/
├── integrations/
├── accessibility/
├── guides/
└── api/
```

No forzar extensiones/rutas si tooling usa otra convención.

---

# 184. Required artifact

Crear:

```text
DOCS-ARCHITECTURE.md
DOCS-MATRIX.md
```

---

# 185. DOCS-ARCHITECTURE

Debe documentar:

```text
tooling
directory structure
navigation model
demo architecture
theme behavior
search
build
deployment readiness
maintenance strategy
```

---

# 186. Final report

Al finalizar entregar:

## Documentation Tooling
Qué se eligió y por qué.

## Architecture
Estructura final.

## Navigation
Desktop/mobile.

## Search
Resultado.

## Getting Started
Estado.

## Foundations
Estado.

## Components
Cobertura.

## Forms
Cobertura.

## Navigation Components
Cobertura.

## Feedback
Cobertura.

## Dialogs
Cobertura.

## Notifications
Cobertura.

## Tables
Cobertura.

## Data Visualization
Cobertura.

## Media
Cobertura.

## Files
Cobertura.

## Integrations
Cobertura.

## Accessibility
Cobertura.

## Theming
Cobertura.

## Utilities
Cobertura.

## Guides
Lista.

## API Reference
Estado.

## Demo System
Resultado.

## Theme Demos
Resultado.

## Responsive
Resultado.

## Accessibility Audit
Resultado.

## Bootstrap Leakage
Resultado.

## Broken Links
Resultado.

## Build
Resultado.

## Tests
Resultado.

## Visual Regression
Resultado.

## DOCS-MATRIX
Resumen.

## Files Created
Lista.

## Files Modified
Lista.

## Remaining Documentation Gaps
Lista.

## Ready for Part 23?
YES / NO + reason.

---

# 187. Completion criteria

Parte 22 termina cuando:

```text
docs build passes
navigation works
mobile docs work
dark theme works
search works or justified alternative exists
all public v0.1 components are inventoried in docs
critical components have full docs
examples use current ORP APIs
no Bootstrap CSS dependency exists
no roadmap-only component is presented as available
accessibility guide exists
theming guide exists
integration guides exist
DOCS-MATRIX exists
```

---

# 188. Do not continue automatically

No implementar Parte 23.

Terminar con reporte técnico y decisión:

```text
READY FOR PART 23
```

o:

```text
NOT READY FOR PART 23
```

con razones concretas.

---

# Regla final

La documentación debe convertirse en una prueba de calidad del propio framework:

```text
If ORP UI is difficult to document,
its API may be too complicated.

If a component requires huge explanations,
its abstraction may be wrong.

If examples need custom hacks,
the component may be incomplete.
```

Por eso Parte 22 no es solamente escribir Markdown.

Es:

```text
ORP UI
   ↓
Real public API
   ↓
Clear documentation
   ↓
Copyable examples
   ↓
Developer understanding
   ↓
Framework adoption
```

La meta final es que un desarrollador nuevo pueda pasar de:

```text
"What is ORP UI?"
```

a:

```text
"I can build an application with this."
```

sin leer el código fuente.

