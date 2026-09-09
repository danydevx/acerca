# SKILL — ORP UI / Parte 20: Advanced Navigation & Command UX

## Objetivo

Agregar a ORP UI una capa de navegación y acciones rápidas para aplicaciones modernas, complementando los primitives existentes sin convertir el framework en router, gestor de permisos o sistema de comandos de negocio.

Esta fase debe resolver patrones como:

```text
Command Bar
Quick Actions
Context Menu
Navigation Drawer composition
Responsive navigation
Tab overflow
Page actions
Selection actions
Keyboard shortcuts presentation
```

Mantener:

```text
ORP UI
→ presentation
→ interaction
→ keyboard UX
→ accessibility

Application
→ routes
→ permissions
→ business commands
→ data
→ API
→ navigation state
```

---

# 1. Scope

```text
Advanced Navigation
├── Command Bar
├── Command Menu
├── Quick Actions
├── Context Menu
├── Overflow Menu
├── Navigation Drawer Pattern
├── Responsive Navigation Pattern
├── Tabs Overflow
├── Page Actions
├── Selection Bar
├── Shortcut Hint
└── Navigation Search Pattern
```

No reemplazar:

```text
AppBar
BottomNav
Navigation List
Navigation Rail
Breadcrumb
Pagination
Stepper
Tabs
Drawer
Dropdown
Popover
Toolbar
Action Bar
SearchInput
```

La meta es componerlos y cubrir comportamientos que realmente requieren interacción adicional.

---

# 2. Audit first

Antes de crear componentes:

Auditar:

```text
OrpDropdown
OrpPopover
OrpDrawer
OrpTabs
OrpSearchInput
OrpModal
OrpSheet
orp-nav
orp-nav-rail
orp-toolbar
orp-icon-btn
orp-chip
```

Buscar:

```text
duplicate keyboard logic
duplicate outside click
duplicate Escape handling
duplicate listbox/menu behavior
legacy navigation patterns
old icons
Bootstrap leakage
```

No crear componentes duplicados.

---

# 3. Command UX philosophy

Un Command Menu NO es un router.

ORP recibe comandos/items y emite selección.

La aplicación decide qué ocurre.

Ejemplo:

```text
User selects "Configuración"
        ↓
ORP emits item
        ↓
Application
        ↓
router.push(...)
```

ORP nunca debe importar:

```text
vue-router
@inertiajs/vue3
```

---

# 4. Command Bar

Crear pattern:

```text
orp-command-bar
```

para acciones frecuentes o navegación rápida.

Puede contener:

```text
search
commands
shortcut hints
groups
recent items
```

---

# 5. Command Bar vs Toolbar

Documentar:

```text
Toolbar
→ visible tools related to current context

Command Bar
→ entry point for finding/executing actions quickly
```

No convertir Toolbar en Command Menu.

---

# 6. Command Menu

Puede justificar Vue.

Nombre posible:

```text
OrpCommandMenu.vue
```

solo si no existe equivalente.

Debe ser genérico.

---

# 7. Command Menu API

Referencia conceptual:

```text
modelValue
items
placeholder
disabled
emptyText
```

Items pueden incluir:

```text
id
label
description
icon
group
disabled
keywords
shortcut
```

No agregar:

```text
route
permission
endpoint
actionClass
Laravel route
```

como requisitos core.

---

# 8. Command selection

Emitir:

```text
select
update:modelValue
open
close
search
```

solo donde sea útil.

La aplicación ejecuta acción.

---

# 9. Command search

Filtering local simple puede existir.

No implementar fuzzy search complejo.

No agregar Fuse.js.

---

# 10. Remote commands

Si aplicación necesita resultados remotos:

ORP puede emitir:

```text
search
```

La aplicación proporciona items.

No hacer fetch interno.

---

# 11. Command groups

Soportar agrupación visual:

```text
Navigation
Actions
Recent
```

como labels genéricos.

No hardcodear grupos.

---

# 12. Command keyboard

Prioridad alta:

```text
ArrowDown
ArrowUp
Enter
Escape
Home
End
```

Tab no debe quedar atrapado incorrectamente.

---

# 13. Command accessibility

Evaluar patrón ARIA correcto según implementación.

Puede compartir fundamentos con:

```text
Combobox
Listbox
Dialog
```

No inventar roles.

Si Command Menu se abre como dialog:

```text
role="dialog"
```

y focus management apropiado.

---

# 14. Command trigger

Puede abrirse desde:

```text
Button
IconButton
Search-like trigger
```

No imponer un único trigger.

---

# 15. Keyboard shortcut

Aplicación puede registrar:

```text
Ctrl/Cmd + K
```

pero ORP NO debe instalar global shortcut automáticamente al importar módulo.

---

# 16. Optional shortcut behavior

Si `OrpCommandMenu` ofrece shortcut:

debe ser opt-in.

Debe:

```text
register on mount
cleanup on unmount
avoid module-level listeners
```

---

# 17. Shortcut conflicts

No secuestrar shortcuts del navegador.

No capturar:

```text
Ctrl+L
Ctrl+T
Ctrl+W
```

---

# 18. Shortcut Hint

Crear CSS primitive:

```text
orp-kbd
```

usando semántica:

```html
<kbd>
```

Para mostrar:

```text
⌘K
Ctrl K
Esc
Enter
```

---

# 19. Shortcut Hint style

Debe usar:

```text
surface
border
radius
muted foreground
typography tokens
```

No parecer botón interactivo si no lo es.

---

# 20. Platform labels

ORP no necesita detectar Mac/Windows automáticamente.

Aplicación puede decidir:

```text
⌘K
Ctrl K
```

---

# 21. Quick Actions

Crear pattern genérico:

```text
orp-quick-actions
```

solo si agrega layout útil.

Puede componerse con:

```text
Grid
Button
IconButton
Card
```

---

# 22. Quick Action item

Estructura conceptual:

```text
icon
label
description optional
shortcut optional
```

No crear acciones de negocio específicas.

---

# 23. Quick Actions examples

Playground puede usar:

```text
Create
Search
Share
Settings
Help
```

como demos genéricas.

No convertirlas en API interna.

---

# 24. Context Menu

Puede justificar Vue por:

```text
position
outside click
Escape
keyboard
focus
```

Pero primero auditar Dropdown/Popover.

---

# 25. Context Menu vs Dropdown

```text
Dropdown
→ menu opened from visible trigger

Context Menu
→ contextual actions opened from pointer/keyboard context
```

Si no hay necesidad real, no duplicar Dropdown.

---

# 26. Context Menu API

Si se implementa:

```text
OrpContextMenu.vue
```

debe recibir items/actions genéricos.

No ejecutar negocio.

---

# 27. Context Menu trigger

Debe poder abrirse mediante:

```text
contextmenu event
keyboard
explicit trigger if needed
```

No hacer mouse-only UX.

---

# 28. Context Menu keyboard

Debe existir alternativa de teclado.

No depender únicamente de right-click.

---

# 29. Context Menu semantics

Si realmente representa menu de acciones:

usar:

```text
role="menu"
role="menuitem"
```

con comportamiento de teclado correspondiente.

No usar menu semantics a medias.

---

# 30. Context Menu positioning

No construir un Popper/Floating UI clone.

Soportar posicionamiento básico dentro de viewport.

Si collision detection avanzada se vuelve necesaria:

reportar recomendación de librería especializada.

No instalar automáticamente.

---

# 31. Context Menu boundaries

Evitar que aparezca fuera de viewport.

Implementar corrección básica:

```text
x
y
viewport width
viewport height
menu dimensions
```

sin crear engine complejo.

---

# 32. Overflow Menu

NO crear componente nuevo si:

```text
IconButton + Dropdown
```

ya lo resuelve.

Documentar pattern:

```text
More actions
→ IconButton
→ bi-three-dots
→ Dropdown
```

---

# 33. Legacy ellipsis

No usar:

```text
...
⋮
```

como iconos visuales si Bootstrap Icons está disponible en demo.

Usar:

```text
bi-three-dots
bi-three-dots-vertical
```

Core sigue icon-agnostic.

---

# 34. Navigation Drawer

No crear otro Drawer.

Crear pattern de composición:

```text
OrpDrawer
+
orp-nav
+
Profile/Header optional
+
Footer actions
```

---

# 35. Navigation Drawer structure

Referencia:

```text
Drawer
├── Header
├── Navigation
│   ├── Groups
│   └── Items
└── Footer
```

La aplicación proporciona URLs/actions.

---

# 36. Mobile navigation

Pattern recomendado:

```text
AppBar
→ menu trigger
→ Drawer
→ Navigation List
```

No convertir automáticamente desktop sidebar en Drawer.

---

# 37. Responsive navigation

Documentar composición:

```text
Mobile
→ AppBar + BottomNav/Drawer

Tablet
→ AppBar + Navigation Rail

Desktop
→ AppShell Sidebar + Navigation
```

Esto es patrón, no transformación automática.

---

# 38. No JS breakpoint navigation

No usar:

```js
window.innerWidth
isMobile
```

para decidir arquitectura.

CSS controla visibilidad/layout.

La aplicación puede renderizar estructuras semánticas apropiadas si necesita diferencias reales.

---

# 39. Navigation Rail integration

No modificar Navigation Rail para volverlo sidebar completo.

Mantener:

```text
Rail
→ compact navigation

Sidebar
→ larger navigation/content region
```

---

# 40. Tabs Overflow

Auditar Tabs existente.

Problema a resolver:

muchas tabs en mobile.

---

# 41. Tabs mobile strategy

Preferir:

```text
horizontal scroll
```

con:

```text
overflow-x:auto
overscroll behavior
optional scroll snap
```

No esconder tabs arbitrariamente.

---

# 42. Tabs overflow indicators

Opcional:

```text
subtle edge fade
```

para indicar contenido fuera de viewport.

No agregar flechas JS salvo necesidad real.

---

# 43. Tabs active visibility

Cuando cambia tab programáticamente, puede ser útil asegurar que tab activa sea visible.

Solo agregar `scrollIntoView` si comportamiento actual realmente lo necesita.

Debe ser:

```text
on interaction
SSR-safe
reduced-motion aware
```

---

# 44. Tabs desktop

No cambiar comportamiento desktop si ya funciona.

---

# 45. Page Actions

Crear pattern:

```text
orp-page-actions
```

solo si Toolbar/Cluster no lo resuelven.

Patrón conceptual:

```text
Page title/context
+
primary action
+
secondary actions
+
overflow
```

---

# 46. Page Actions mobile

En mobile:

```text
primary action visible
secondary actions may wrap or overflow menu
```

Pero ORP no debe mover acciones automáticamente mediante JS.

---

# 47. Action priority

ORP puede proporcionar estilos/layout.

La aplicación decide qué acción es primary.

---

# 48. Selection Bar

Pattern para acciones sobre selección actual.

Ejemplo:

```text
3 selected
Delete
Move
More
```

Genérico.

---

# 49. Selection Bar responsibility

ORP presenta:

```text
selection count
actions
dismiss/clear action
```

La aplicación controla:

```text
selected IDs
selection logic
bulk action
```

---

# 50. Selection Bar positioning

Puede funcionar:

```text
inline
sticky
bottom mobile
```

solo si se justifican variants genéricas.

---

# 51. Bottom Selection Bar

Debe respetar:

```text
safe-area
BottomNav
FAB
```

No usar magic numbers.

Reutilizar AppShell tokens.

---

# 52. Selection Bar accessibility

Cambios de selección pueden anunciarse mediante región apropiada solo si realmente aporta valor.

No llenar UI de `aria-live`.

---

# 53. Navigation Search

Pattern:

```text
SearchInput
+
Navigation results
```

Puede reutilizar Command Menu/Combobox.

No crear otro search engine.

---

# 54. Search in Drawer

Puede componerse:

```text
Drawer
+ SearchInput
+ filtered Navigation
```

Filtering pertenece a aplicación salvo helper local muy simple.

---

# 55. Search in Navigation

No modificar automáticamente URLs o active route.

---

# 56. Back / Forward actions

Continuar usando:

```text
orp-icon-btn
```

No crear componentes nuevos.

Bootstrap Icons demo:

```text
bi-arrow-left
bi-arrow-right
```

Pero considerar RTL.

---

# 57. RTL navigation arrows

No codificar:

```text
left = back
right = forward
```

como regla arquitectónica universal.

La aplicación/contexto decide.

---

# 58. Breadcrumb overflow

Auditar Breadcrumb actual para mobile.

Estrategias posibles:

```text
horizontal scroll
ellipsis in intermediate items
```

sin JS collapse complejo.

---

# 59. Pagination mobile

Auditar Pagination.

Debe seguir siendo usable en 320px.

Puede usar:

```text
previous
current
next
```

como composición de aplicación si muchos números no caben.

ORP no genera automáticamente qué páginas mostrar.

---

# 60. Stepper responsive

Auditar Stepper.

En mobile:

```text
vertical
compact horizontal
```

según variant existente.

No usar JS breakpoint detection.

---

# 61. AppBar actions

Auditar AppBar para:

```text
back
title
primary action
overflow
```

No convertir AppBar en Toolbar gigante.

---

# 62. BottomNav

No agregar veinte items.

Documentar que BottomNav debe contener navegación primaria limitada.

Overflow/secondary navigation puede ir a Drawer/More pattern.

---

# 63. More navigation

Puede ser:

```text
BottomNav item
→ opens Drawer/Sheet
```

La aplicación controla comportamiento.

ORP no crea ruta especial "More".

---

# 64. Command Menu and Modal

Reutilizar infraestructura de overlay/focus existente cuando sea apropiado.

No implementar segundo sistema de:

```text
focus trap
scroll lock
Escape
Teleport
```

---

# 65. Command Menu and Combobox

Auditar lógica compartida:

```text
search
active item
ArrowUp/Down
Enter
aria-activedescendant
```

Extraer composable interno solo si existe duplicación real.

---

# 66. Possible internal composable

Ejemplo:

```text
useOrpListNavigation
```

solo si Combobox/Command/Menu comparten lógica de verdad.

No crear abstracción especulativa.

---

# 67. Dropdown reuse

Overflow Menu y muchas acciones deben usar Dropdown existente.

No duplicar.

---

# 68. Popover reuse

Quick contextual content puede usar Popover.

Context Menu no debe convertirse en Popover si semántica de menu es necesaria.

---

# 69. Drawer reuse

Navigation Drawer usa Drawer existente.

No crear `OrpNavigationDrawer.vue` salvo que composición repetida y API aporten valor real.

---

# 70. Sheet reuse

Mobile command/actions pueden usar Sheet solo si UX lo requiere.

No convertir todo Dropdown en Sheet automáticamente.

---

# 71. Icons

Usar Bootstrap Icons en Playground:

```text
bi-search
bi-command
bi-list
bi-three-dots
bi-arrow-left
bi-arrow-right
bi-funnel
bi-gear
bi-plus
bi-check
```

Siempre:

```html
<i class="orp-icon bi ..." aria-hidden="true"></i>
```

para decorativos.

---

# 72. Icon-only controls

Requieren:

```text
aria-label
```

---

# 73. Shortcut styling

`orp-kbd` debe funcionar dentro de:

```text
Command Menu
Dropdown
Navigation
Buttons
Help text
```

---

# 74. Theme compatibility

Probar:

```text
Light
Dark
Custom
```

Especialmente:

```text
Command Menu
Context Menu
Selection Bar
Navigation Drawer
Tabs overflow
```

---

# 75. Tokens

Usar semantic tokens actuales.

No hardcodear:

```text
white
black
#ddd
shadow
radius
z-index
```

---

# 76. Z-index

Command/Context Menu deben respetar sistema de overlays de Parte 13.

No usar:

```text
9999
99999
```

---

# 77. Stacking

Probar:

```text
Command Menu over AppShell
Dropdown in Drawer
Context Menu over content
Selection Bar + BottomNav
Popover from Toolbar
```

---

# 78. Motion

Usar motion tokens.

Animaciones sutiles:

```text
opacity
scale
translate
```

---

# 79. Reduced motion

Respetar:

```text
prefers-reduced-motion: reduce
```

No hacer smooth scroll obligatorio para Tabs.

---

# 80. Accessibility

Prioridad alta.

Auditar:

```text
focus order
focus restore
keyboard
ARIA
accessible names
active states
disabled states
touch
```

---

# 81. Menu semantics

Usar `role="menu"` únicamente para menu de acciones cuando se implemente comportamiento esperado.

Navigation normal debe seguir usando:

```text
nav
a
ul/ol
```

según corresponda.

---

# 82. Disabled navigation

No crear anchors falsamente disabled sin estrategia semántica.

Preferir no renderizar enlace activo si acción no existe, o manejar `aria-disabled` + bloqueo apropiado cuando sea necesario.

---

# 83. Current route

Aplicación establece:

```text
aria-current="page"
```

ORP no detecta pathname.

---

# 84. Active command

Distinguir:

```text
active keyboard item
selected item
current route
```

No usar una sola clase `.active` para todo.

---

# 85. Touch targets

Mantener aproximadamente:

```text
44 × 44px
```

donde corresponda.

Especialmente:

```text
Context Menu
Overflow Menu
Tabs
Navigation Drawer
Selection Bar
```

---

# 86. Mobile tests

Prioridad:

```text
320
375
390
430
```

---

# 87. Full responsive matrix

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

# 88. Landscape

Probar Command Menu y Navigation Drawer en landscape mobile.

---

# 89. Long labels

Probar:

```text
long command names
long navigation labels
long tab names
long shortcut labels
```

---

# 90. Many items

Probar:

```text
20+ commands
many navigation items
many tabs
```

No implementar virtualization.

---

# 91. Command Menu scrolling

Lista interna puede scrollear.

Header/search debe permanecer usable.

No bloquear toda página incorrectamente.

---

# 92. Empty commands

Usar Empty State o mensaje simple.

No crear `CommandEmpty`.

---

# 93. Loading commands

Si aplicación busca remotamente:

usar Spinner/Skeleton existente.

No crear loading primitive nuevo.

---

# 94. Error commands

Usar Inline Message/Alert según contexto.

No agregar fetch/retry interno.

---

# 95. CSS architecture

Posibles archivos:

```text
less/components/
├── command.less
├── context-menu.less
├── quick-actions.less
├── selection-bar.less
└── keyboard.less
```

Solo crear los necesarios.

Tabs/Nav existentes deben modificarse en sus archivos actuales.

---

# 96. Vue architecture

Posibles:

```text
src/components/OrpCommandMenu.vue
src/components/OrpContextMenu.vue
```

solo si comportamiento lo justifica.

No crear Vue wrappers para:

```text
QuickActions
SelectionBar
PageActions
NavigationDrawer
```

si HTML/CSS composition es suficiente.

---

# 97. Public exports

Actualizar `index.js` únicamente con nuevos componentes públicos reales.

---

# 98. No plugin requirement

No introducir:

```js
app.use(OrpUI)
```

como requisito.

---

# 99. SSR

No acceder a:

```text
window
document
navigator
```

durante module evaluation.

---

# 100. Event cleanup

Global shortcuts/context listeners deben limpiarse al desmontar.

---

# 101. No dependencies

No instalar:

```text
cmdk
Floating UI
Popper
Headless UI
Radix
Fuse.js
```

automáticamente.

---

# 102. Specialized dependency rule

Si positioning/collision/fuzzy-search evoluciona a necesidad compleja:

reportar recomendación externa.

No recrear una librería especializada dentro de ORP.

---

# 103. Playground

Agregar categoría:

```text
Advanced Navigation
```

---

# 104. Playground sections

```text
Command Menu
Quick Actions
Context Menu
Overflow Menu
Navigation Drawer
Responsive Navigation
Tabs Overflow
Selection Bar
Shortcut Hints
```

---

# 105. Command demos

Mostrar:

```text
Basic
Grouped
Search
Disabled item
Shortcut hints
Empty
Loading simulation
```

---

# 106. Command keyboard demo

Incluir indicación:

```text
↑ ↓ Navigate
Enter Select
Esc Close
```

usando `orp-kbd`.

---

# 107. Quick Actions demo

Usar acciones genéricas.

No business-specific.

---

# 108. Context Menu demo

Mostrar:

```text
pointer open
keyboard alternative
disabled action
danger action
```

---

# 109. Overflow demo

Mostrar:

```text
IconButton
+
Dropdown
```

No componente nuevo si no es necesario.

---

# 110. Navigation Drawer demo

Componer:

```text
Drawer
Navigation
Navigation Groups
Avatar/Profile optional
Footer actions
```

---

# 111. Responsive navigation demo

Mostrar conceptualmente:

```text
Mobile → BottomNav + Drawer
Tablet → Rail
Desktop → Sidebar
```

sin router.

---

# 112. Tabs Overflow demo

Usar suficientes tabs para forzar overflow en 320px.

---

# 113. Selection Bar demo

Simular selección local:

```text
0
1
3
```

items.

No backend.

---

# 114. Bootstrap audit

No usar Bootstrap CSS:

```text
btn
dropdown-menu
nav
navbar
container
row
col-*
d-flex
gap-*
p-*
m-*
```

Las clases `.orp-nav` sí son propias.

Permitido:

```text
bi
bi-*
```

---

# 115. Regression

Ejecutar Parte 17.

Revisar especialmente:

```text
Dropdown
Popover
Drawer
Tabs
Navigation
AppBar
BottomNav
Modal
SearchInput
Combobox
Toolbar
```

---

# 116. Visual regression

Fixtures sugeridos:

```text
command-menu-light
command-menu-dark
command-menu-mobile
context-menu
navigation-drawer-mobile
tabs-overflow-mobile
selection-bar-mobile
responsive-navigation-desktop
```

---

# 117. Keyboard tests

Obligatorios para:

```text
Command Menu
Context Menu
Tabs overflow behavior
Navigation Drawer focus
```

---

# 118. Command tests

Cubrir:

```text
open
close
search
ArrowDown
ArrowUp
Home
End
Enter
Escape
disabled
selection
focus restore
```

---

# 119. Context Menu tests

Cubrir:

```text
contextmenu
keyboard open
outside click
Escape
Arrow navigation
Enter
disabled
viewport correction
focus restore
```

si componente existe.

---

# 120. Shortcut tests

Si shortcut global opt-in existe:

```text
register
open
prevent unwanted duplicate listeners
cleanup
```

---

# 121. Tabs tests

Agregar:

```text
many tabs
horizontal overflow
active tab
keyboard
focus
```

---

# 122. Drawer regression

Navigation composition no debe romper:

```text
focus trap
Escape
scroll lock
restore focus
```

---

# 123. Selection Bar safe area

Probar con:

```text
BottomNav
without BottomNav
FAB
```

No debe cubrir contenido.

---

# 124. RTL

Probar:

```html
dir="rtl"
```

en:

```text
Command Menu
Context Menu
Navigation
Tabs
Selection Bar
```

---

# 125. Themes

Probar:

```text
Light
Dark
Custom
```

---

# 126. Reduced motion

Probar:

```text
Command open/close
Context Menu
Tabs scroll behavior
Drawer
```

---

# 127. Documentation

Crear/adaptar:

```text
docs/navigation/
├── command-menu.md
├── quick-actions.md
├── context-menu.md
├── overflow-menu.md
├── navigation-drawer.md
├── responsive-navigation.md
├── tabs-overflow.md
├── selection-bar.md
└── keyboard-shortcuts.md
```

---

# 128. Decision guide

Documentar:

```text
Toolbar vs Command Bar
Dropdown vs Context Menu
Popover vs Context Menu
Drawer vs Navigation Drawer pattern
BottomNav vs Rail vs Sidebar
Tabs vs Navigation
Quick Actions vs Toolbar
Selection Bar vs Action Bar
```

---

# 129. Toolbar vs Command

```text
Toolbar
→ visible actions for current context

Command Menu
→ searchable actions/navigation

Quick Actions
→ small prominent action set
```

---

# 130. Dropdown vs Context Menu

```text
Dropdown
→ visible trigger

Context Menu
→ contextual invocation
```

Ambos pueden compartir styling/logic, pero semántica de interacción cambia.

---

# 131. Selection Bar vs Action Bar

```text
Action Bar
→ actions related to current view/context

Selection Bar
→ actions specifically related to selected items
```

---

# 132. Navigation decision

```text
BottomNav
→ primary mobile destinations

Navigation Rail
→ compact tablet/desktop destinations

Sidebar
→ larger desktop navigation

Drawer
→ temporary mobile/secondary navigation

Command Menu
→ fast search/action/navigation
```

---

# 133. Performance

JS growth debe mantenerse razonable.

Los componentes nuevos interactivos justifican algo de JS, pero evitar engines complejos.

---

# 134. Bundle report

Reportar:

```text
CSS before/after
JS before/after
new public components
```

---

# 135. Existing bug awareness

No ocultar problemas detectados previamente en:

```text
Spinner
Skeleton
legacy List demos
```

Si aparecen durante regresión, reportarlos/corregirlos según scope autorizado.

---

# 136. Completion criteria

Parte 20 termina cuando ORP UI pueda resolver:

```text
searchable commands
quick actions
contextual actions
overflow actions
mobile navigation drawer composition
responsive navigation patterns
many-tabs mobile UX
selection actions
keyboard shortcut presentation
```

sin acoplarse a router/backend/business logic.

---

# 137. Result expected

Al finalizar entregar:

## Audit

Componentes existentes reutilizados.

## New components

Solo los justificados.

## New CSS patterns

Lista.

## Internal composables

Si se crearon y por qué.

## Files created

Lista.

## Files modified

Lista.

## Public API

Cambios.

## Playground

Demos agregadas.

## Keyboard

Matriz probada.

## Accessibility

Resultado.

## Responsive

Viewports.

## Themes

Light/Dark/Custom.

## RTL

Resultado.

## Reduced Motion

Resultado.

## Bootstrap audit

Confirmar ausencia de Bootstrap CSS.

## Build

Resultado.

## Tests

Resultado.

## Visual regression

Resultado.

## Bundle

Crecimiento CSS/JS.

## Regressions

Problemas encontrados/corregidos.

## Remaining issues

Fuera de scope.

---

# 138. Explicit exclusions

NO implementar:

```text
router
route registry
permissions engine
backend command system
global application search backend
fuzzy search engine
command history persistence
AI command assistant
Popper clone
Floating UI clone
virtualized command list
drag navigation
mega menu builder
site map generator
notification center
desktop window manager
```

---

# 139. No new dependencies

No instalar nuevas dependencias automáticamente.

Mantener filosofía:

```text
CSS first
Vue only when behavior justifies it
native semantics
small internal composables
```

---

# 140. Do not continue automatically

No implementar Parte 21.

Terminar con reporte técnico.

---

# Regla final

La arquitectura debe conservar:

```text
ORP UI
├── Navigation appearance
├── Command interaction
├── Keyboard UX
├── Focus
└── Accessibility

Application
├── Routes
├── Permissions
├── Business actions
├── API
└── Navigation decisions
```

ORP UI debe permitir construir una navegación moderna y rápida sin saber **a dónde navega** ni **qué hace realmente cada comando**.

```text
ORP presents the action.
Application owns the action.
```

