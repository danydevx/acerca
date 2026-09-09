# SKILL — ORP UI / Parte 5: Framework Foundation, Theming & Distribution

## Objetivo

Consolidar ORP UI como un framework reutilizable y portable.

Esta fase NO debe agregar una gran cantidad de componentes visuales nuevos.

El objetivo es fortalecer:

```text
Architecture
Theming
Dark Mode
Build
Exports
Documentation
Versioning
Distribution
Developer Experience
```

Al finalizar esta fase, ORP UI debe estar preparado para vivir:

```text
dentro de una aplicación
```

o posteriormente como:

```text
paquete independiente
```

sin depender del proyecto donde nació.

---

# 1. Alcance de esta fase

Implementar:

```text
Core
├── Theme tokens
├── Dark mode
├── Custom themes
├── CSS architecture cleanup
├── Public API
├── Entry points
├── Build strategy
├── Documentation
├── Versioning strategy
└── Distribution preparation
```

No agregar todavía:

```text
Calendar
DatePicker
DataTable
Command Palette
Rich Text Editor
Autocomplete
Complex Charts
Virtual Lists
Drag & Drop
```

---

# 2. Mantener namespace

Todo ORP UI debe continuar utilizando:

```text
orp-
```

LESS:

```text
@orp-
```

CSS Custom Properties:

```text
--orp-
```

Vue:

```text
OrpComponentName
```

Data attributes:

```text
data-orp-*
```

---

# 3. Revisar arquitectura existente

Antes de modificar:

1. revisar archivos creados en Partes 1–4;
2. detectar duplicación;
3. revisar imports LESS;
4. revisar tokens existentes;
5. revisar composables;
6. revisar API pública de componentes;
7. detectar inconsistencias de naming.

No reescribir todo.

Aplicar refactors pequeños y justificados.

---

# 4. Theme tokens

Reorganizar los colores para utilizar tokens semánticos.

Evitar que los componentes dependan directamente de:

```text
blue
gray
white
black
```

Preferir conceptos como:

```text
background
foreground
surface
surface-muted
primary
primary-foreground
secondary
secondary-foreground
muted
muted-foreground
border
input
ring
success
warning
danger
info
```

---

# 5. Variables CSS principales

Definir una base similar a:

```css
:root {

    --orp-background: #f7f8fa;
    --orp-foreground: #17191d;

    --orp-surface: #ffffff;
    --orp-surface-foreground: #17191d;

    --orp-surface-muted: #f1f3f5;

    --orp-primary: #1769ff;
    --orp-primary-foreground: #ffffff;

    --orp-secondary: #eef1f5;
    --orp-secondary-foreground: #24262b;

    --orp-muted: #eef1f5;
    --orp-muted-foreground: #6b7280;

    --orp-border: #e1e5ea;
    --orp-input: #d7dce2;
    --orp-ring: #1769ff;

    --orp-success: #198754;
    --orp-warning: #f0ad00;
    --orp-danger: #dc3545;
    --orp-info: #0d6efd;

}
```

Los valores concretos pueden ajustarse.

Lo importante es la semántica.

---

# 6. Foreground tokens

Toda superficie importante debe considerar color de foreground.

Ejemplo:

```text
--orp-primary
--orp-primary-foreground

--orp-secondary
--orp-secondary-foreground

--orp-surface
--orp-surface-foreground
```

Esto facilita themes futuros.

---

# 7. Componentes no deben hardcodear colores

Incorrecto:

```less
.orp-btn--primary {
    background: #1769ff;
    color: white;
}
```

Correcto:

```less
.orp-btn--primary {
    background: var(--orp-primary);
    color: var(--orp-primary-foreground);
}
```

---

# 8. Dark Mode

Implementar dark mode mediante CSS Custom Properties.

Preferir:

```html
<html class="orp-dark">
```

o:

```html
<html data-orp-theme="dark">
```

Elegir UNA estrategia.

Preferencia:

```html
data-orp-theme
```

porque permitirá futuros themes.

Ejemplo:

```html
<html data-orp-theme="dark">
```

---

# 9. Dark theme

Crear:

```css
[data-orp-theme="dark"] {

    --orp-background: #111318;
    --orp-foreground: #f4f5f7;

    --orp-surface: #181b21;
    --orp-surface-foreground: #f4f5f7;

    --orp-surface-muted: #21252c;

    --orp-primary: #5b8cff;
    --orp-primary-foreground: #ffffff;

    --orp-secondary: #252a32;
    --orp-secondary-foreground: #f4f5f7;

    --orp-muted: #252a32;
    --orp-muted-foreground: #a6adb8;

    --orp-border: #303640;
    --orp-input: #3a404b;
    --orp-ring: #5b8cff;

}
```

Los valores pueden ajustarse después.

---

# 10. System theme

No obligar a utilizar JavaScript para dark mode.

Permitir opcionalmente:

```css
@media (prefers-color-scheme: dark)
```

pero no mezclar automáticamente ambas estrategias sin definir prioridad.

La arquitectura debe permitir:

```text
light
dark
system
```

desde la aplicación.

---

# 11. Theme manager

NO crear todavía un sistema complejo.

Puede crearse un composable pequeño:

```text
useOrpTheme.js
```

solo si aporta valor.

API posible:

```js
setTheme('dark')
setTheme('light')
setTheme('system')
```

Pero ORP UI debe seguir funcionando sin él.

---

# 12. Persistencia

Si se implementa `useOrpTheme`, puede soportar:

```text
localStorage
```

como opción.

No imponer persistencia automáticamente.

La aplicación debe poder decidir.

---

# 13. Custom themes

Permitir temas propios mediante:

```html
<html data-orp-theme="brand">
```

Ejemplo:

```css
[data-orp-theme="brand"] {
    --orp-primary: #7c3aed;
    --orp-primary-foreground: #ffffff;
}
```

No crear múltiples themes completos todavía.

Documentar cómo hacerlo.

---

# 14. Theme inheritance

Los componentes deben obtener colores mediante:

```text
CSS Custom Properties
```

no mediante imports LESS específicos por theme.

Esto permite cambiar theme sin recompilar CSS.

---

# 15. LESS vs CSS Variables

Definir claramente:

```text
LESS
→ authoring/build tokens
```

```text
CSS Custom Properties
→ runtime theming
```

Ejemplo:

```less
@orp-primary-default: #1769ff;

:root {
    --orp-primary: @orp-primary-default;
}
```

Los componentes deben consumir preferentemente:

```css
var(--orp-primary)
```

---

# 16. Radius tokens

Consolidar:

```text
--orp-radius-sm
--orp-radius-md
--orp-radius-lg
--orp-radius-xl
--orp-radius-pill
```

No crear radios arbitrarios dentro de componentes.

---

# 17. Spacing tokens

Mantener escala existente:

```text
--orp-space-1
--orp-space-2
--orp-space-3
--orp-space-4
--orp-space-5
--orp-space-6
```

Evitar aumentar la escala salvo necesidad real.

---

# 18. Typography tokens

Consolidar:

```text
--orp-font-family
--orp-font-size-sm
--orp-font-size-md
--orp-font-size-lg
--orp-font-size-xl
--orp-line-height
```

Puede mantenerse parte en LESS si no se necesita runtime customization.

---

# 19. Shadows

Centralizar:

```text
--orp-shadow-sm
--orp-shadow-md
--orp-shadow-lg
```

Usar en:

```text
Card
Dropdown
Popover
Modal
Drawer
Toast
```

según necesidad.

---

# 20. Motion tokens

Crear una escala pequeña:

```css
--orp-duration-fast: 150ms;
--orp-duration-normal: 200ms;
--orp-duration-slow: 300ms;

--orp-ease-standard: cubic-bezier(.2, .8, .2, 1);
```

Los componentes interactivos deben reutilizar estos tokens.

---

# 21. Z-index tokens

Consolidar escala existente.

Ejemplo:

```text
--orp-z-sticky
--orp-z-fixed
--orp-z-dropdown
--orp-z-popover
--orp-z-backdrop
--orp-z-modal
--orp-z-sheet
--orp-z-toast
```

Puede permanecer internamente en LESS si no necesita personalización pública.

---

# 22. CSS architecture audit

Revisar todos los componentes.

Detectar:

```text
hardcoded colors
hardcoded shadows
duplicate transitions
duplicate radii
duplicate spacing
excess specificity
!important
deep nesting
global selectors
```

Corregir solo cuando sea necesario.

---

# 23. Specificity

Mantener especificidad baja.

Preferir:

```less
.orp-card {}
.orp-card__body {}
.orp-card--raised {}
```

Evitar:

```less
body .app main .orp-card .orp-card__body {}
```

---

# 24. CSS Layers

Evaluar el uso de:

```css
@layer
```

solo si el pipeline actual lo soporta correctamente.

Estructura posible:

```css
@layer orp-reset;
@layer orp-base;
@layer orp-components;
@layer orp-utilities;
```

No adoptarlo si genera problemas con LESS/Vite o compatibilidad existente.

Documentar decisión.

---

# 25. Entry point principal

Mantener un entrypoint:

```text
orp-ui.less
```

que cargue todo.

Ejemplo:

```less
// Abstracts
@import "abstracts/variables.less";
@import "abstracts/mixins.less";
@import "abstracts/breakpoints.less";

// Themes
@import "themes/light.less";
@import "themes/dark.less";

// Base
@import "base/reset.less";
@import "base/root.less";
@import "base/typography.less";

// Utilities
...

// Components
...
```

---

# 26. Themes directory

Crear si aporta claridad:

```text
less/
└── themes/
    ├── light.less
    └── dark.less
```

No duplicar componentes dentro de themes.

Solo definir variables.

---

# 27. Public JS API

Revisar:

```text
index.js
```

Debe exportar solo lo público.

Ejemplo:

```js
export { default as OrpTabs } from './components/OrpTabs.vue'
export { default as OrpModal } from './components/OrpModal.vue'
export { default as OrpSheet } from './components/OrpSheet.vue'
export { default as OrpSwitch } from './components/OrpSwitch.vue'

export { default as OrpToast } from './components/OrpToast.vue'
export { default as OrpAccordion } from './components/OrpAccordion.vue'
export { default as OrpDropdown } from './components/OrpDropdown.vue'
export { default as OrpPopover } from './components/OrpPopover.vue'
export { default as OrpDrawer } from './components/OrpDrawer.vue'
export { default as OrpIconButton } from './components/OrpIconButton.vue'
```

---

# 28. Internal modules

Composables internos no deben exportarse automáticamente.

Ejemplo:

```text
usePositioning
useRestoreFocus
```

mantener internos si solo son implementation details.

Exportar únicamente cuando exista uso externo claro.

---

# 29. Tree shaking

Mantener exports individuales.

Preferir:

```js
import {
    OrpModal,
    OrpSheet
} from '@orp/ui'
```

No crear un objeto gigante:

```js
ORP.Modal
ORP.Sheet
```

---

# 30. Global plugin

NO hacer obligatorio:

```js
app.use(OrpUI)
```

Puede estudiarse como opción.

Pero los imports individuales siguen siendo la API principal.

---

# 31. Import CSS

Documentar claramente:

```js
import '@orp/ui/dist/orp-ui.css'
```

para una futura versión empaquetada.

Mientras siga local:

```js
import '@/orp-ui/less/orp-ui.less'
```

---

# 32. Build independiente

Preparar un build separado del proyecto principal.

Objetivo futuro:

```text
src LESS
→ dist/orp-ui.css
```

y:

```text
Vue components
→ dist JS modules
```

No romper el build actual de Vite.

---

# 33. Distribution structure

Preparar conceptualmente:

```text
orp-ui/
├── src/
│   ├── components/
│   ├── composables/
│   ├── less/
│   └── index.js
│
├── dist/
│   ├── orp-ui.css
│   ├── orp-ui.es.js
│   └── orp-ui.umd.js
│
├── package.json
├── README.md
└── CHANGELOG.md
```

No generar UMD si no existe necesidad actual.

Priorizar ESM.

---

# 34. Package naming

No publicar todavía automáticamente.

Pero preparar el proyecto para nombres posibles:

```text
orp-ui
@orpot/ui
@orpot/orp-ui
```

No registrar ni publicar paquetes sin instrucción explícita.

---

# 35. package.json futuro

Preparar una estructura limpia.

Ejemplo conceptual:

```json
{
    "name": "@orpot/ui",
    "version": "0.1.0",
    "type": "module",
    "main": "./dist/orp-ui.js",
    "module": "./dist/orp-ui.js",
    "style": "./dist/orp-ui.css"
}
```

Adaptar cuando realmente exista build.

---

# 36. Vue peer dependency

Si se empaqueta posteriormente:

Vue debe ser:

```text
peerDependency
```

no dependency embebida.

Ejemplo conceptual:

```json
{
    "peerDependencies": {
        "vue": "^3.5.0"
    }
}
```

No fijar versión exacta sin necesidad.

---

# 37. No bundlear Vue

El bundle de ORP UI NO debe incluir su propia copia de Vue.

Esto evitará:

```text
duplicated Vue runtime
larger bundle
reactivity issues
```

---

# 38. LESS como source

Considerar distribuir también:

```text
src/less
```

en el paquete futuro.

Esto permitiría a usuarios avanzados modificar tokens antes de compilar.

Pero el uso principal debe seguir permitiendo importar CSS compilado.

---

# 39. Public CSS

La distribución final debe proporcionar:

```text
orp-ui.css
```

sin obligar al consumidor a utilizar LESS.

---

# 40. Source maps

En desarrollo/build de librería:

generar source maps si el pipeline lo permite.

No son obligatorios para producción final.

---

# 41. Minification

Preparar:

```text
orp-ui.css
orp-ui.min.css
```

solo si realmente tiene sentido.

Con bundlers modernos puede bastar con una versión.

No duplicar artefactos sin necesidad.

---

# 42. Component documentation

Crear documentación por componente.

Estructura sugerida:

```text
docs/
├── getting-started.md
├── theming.md
├── accessibility.md
├── components/
│   ├── button.md
│   ├── card.md
│   ├── app-bar.md
│   ├── bottom-nav.md
│   ├── modal.md
│   ├── sheet.md
│   ├── dropdown.md
│   └── ...
```

No hace falta crear un sitio completo todavía.

Markdown es suficiente.

---

# 43. Getting Started

Crear:

```text
getting-started.md
```

Debe explicar:

```text
Installation
Import CSS
Import Vue components
Basic example
Namespace
Browser support
```

---

# 44. Theming documentation

Crear:

```text
theming.md
```

Explicar:

```text
CSS variables
light theme
dark theme
custom theme
runtime theme switch
branding
```

Ejemplo:

```css
[data-orp-theme="my-brand"] {
    --orp-primary: #ff5500;
    --orp-primary-foreground: #ffffff;
}
```

---

# 45. Accessibility documentation

Crear:

```text
accessibility.md
```

Documentar principios:

```text
semantic HTML
keyboard
focus-visible
aria
touch targets
reduced motion
native controls
```

No afirmar cumplimiento WCAG total si no existe auditoría completa.

---

# 46. README

Crear un README general.

Debe incluir:

```text
ORP UI
description
philosophy
features
quick start
components
theming
Vue usage
namespace
roadmap
license placeholder
```

---

# 47. README philosophy

Explicar claramente:

```text
Mobile-first
Semantic CSS
Vue only for behavior
No utility soup
No mandatory runtime dependencies
Accessible by design
Framework-friendly
```

---

# 48. Component inventory

Documentar todos los componentes existentes.

Ejemplo:

```text
Foundation
- Container
- Button
- Card

Navigation
- AppBar
- BottomNav
- Drawer

Data Display
- Avatar
- Badge
- List

Forms
- Input
- Textarea
- Select
- Switch

Interactive
- Tabs
- Modal
- Sheet
- Accordion
- Dropdown
- Popover

Feedback
- Alert
- Toast
```

---

# 49. Stable vs experimental

Permitir marcar componentes:

```text
stable
experimental
```

No todo tiene que considerarse estable desde el inicio.

Por ejemplo:

```text
Dropdown positioning
Popover
```

pueden considerarse experimentales si su positioning todavía es básico.

---

# 50. Versioning

Adoptar Semantic Versioning:

```text
MAJOR.MINOR.PATCH
```

Ejemplo:

```text
0.1.0
```

Mientras ORP UI esté en desarrollo:

```text
0.x
```

puede permitir cambios de API.

---

# 51. Version initial

Si todavía no existe versión:

usar:

```text
0.1.0
```

como referencia inicial.

No declarar:

```text
1.0.0
```

hasta que la API esté razonablemente estable.

---

# 52. CHANGELOG

Crear:

```text
CHANGELOG.md
```

Formato sencillo.

Ejemplo:

```text
## 0.1.0

### Added

- Foundation
- Button
- Card
- AppBar
- BottomNav
- Modal
- Sheet
```

No necesita automatización todavía.

---

# 53. Breaking changes

Documentar cualquier cambio que rompa:

```text
class names
props
events
slots
CSS variables
```

---

# 54. API naming audit

Revisar props existentes.

Mantener consistencia:

```text
modelValue
variant
size
position
placement
disabled
closeOnEscape
closeOnBackdrop
closeOnOutside
```

Evitar sinónimos innecesarios.

---

# 55. CSS naming audit

Revisar todos los modifiers.

Mantener:

```text
--primary
--secondary
--success
--warning
--danger
```

No mezclar:

```text
--error
--negative
--critical
```

para el mismo concepto.

---

# 56. Playground como documentación viva

Actualizar `OrpPlayground.vue`.

Agregar:

```text
Theme Switcher
```

que permita probar:

```text
Light
Dark
```

sin necesidad de crear un Theme Manager complejo.

---

# 57. Playground custom theme

Agregar opcionalmente:

```text
Brand Demo
```

para demostrar que cambiar variables transforma todo ORP UI.

---

# 58. Theme testing

Revisar todos los componentes en:

```text
Light
Dark
```

Especialmente:

```text
Button
Card
AppBar
BottomNav
Input
Modal
Sheet
Dropdown
Popover
Drawer
Toast
Alert
```

---

# 59. Contrast

Revisar visualmente contraste.

Especial atención:

```text
muted text
disabled states
warning
danger
borders
dark theme
focus rings
```

No afirmar ratios específicos sin medición.

---

# 60. Disabled theme states

No hardcodear:

```text
opacity: .2
```

si destruye legibilidad.

Mantener estados visibles tanto en light como dark.

---

# 61. Focus ring token

Centralizar:

```text
--orp-ring
```

Todos los componentes interactivos deben utilizarlo.

Ejemplo:

```less
&:focus-visible {
    outline: 2px solid var(--orp-ring);
    outline-offset: 2px;
}
```

---

# 62. Body styling

ORP UI no debe asumir control completo del `body`.

Evitar:

```css
body {
    background: ...
}
```

salvo que esté claramente dentro de un modo opt-in.

Puede utilizar:

```text
orp-app
```

como wrapper opcional.

---

# 63. Orp App wrapper

Evaluar crear:

```text
orp-app
```

para aplicar:

```text
font
background
foreground
min-height
```

Ejemplo:

```html
<div class="orp-app">
    ...
</div>
```

Esto ayuda a evitar estilos globales agresivos.

---

# 64. orp-app

Puede contener:

```less
.orp-app {
    min-height: 100dvh;
    background: var(--orp-background);
    color: var(--orp-foreground);
    font-family: var(--orp-font-family);
}
```

No debe ser obligatorio para usar componentes individuales.

---

# 65. Browser support

Definir soporte razonable para navegadores modernos.

Priorizar:

```text
current Chrome
current Edge
current Firefox
current Safari
modern Android browsers
modern iOS Safari
```

No implementar soporte específico para Internet Explorer.

---

# 66. Modern CSS

Se permite usar:

```text
CSS Custom Properties
clamp()
min()
max()
dvh
logical properties
prefers-reduced-motion
prefers-color-scheme
```

si existe soporte razonable en navegadores modernos.

---

# 67. Logical properties

Preferir:

```css
padding-inline
margin-inline
inset-inline
```

cuando mejore adaptabilidad.

Esto prepara ORP UI para futuro soporte RTL.

---

# 68. RTL future compatibility

No implementar RTL completo todavía.

Pero evitar asumir siempre:

```text
left = start
right = end
```

cuando pueda utilizarse:

```text
inline-start
inline-end
```

---

# 69. Icons

Mantener independencia de iconos.

Documentar ejemplos con:

```text
SVG
Lucide
Bootstrap Icons
custom icons
```

pero no agregar dependencia obligatoria.

---

# 70. Dependencies audit

Revisar package dependencies utilizadas por ORP UI.

Eliminar únicamente las introducidas específicamente por ORP UI que ya no sean necesarias.

No eliminar dependencias del proyecto principal.

---

# 71. Bundle analysis

Si existe build independiente:

reportar tamaño aproximado de:

```text
CSS
JS
```

No establecer todavía un límite rígido.

El objetivo es detectar crecimiento inesperado.

---

# 72. Side effects

Los componentes Vue no deben ejecutar efectos globales al importarse.

Incorrecto:

```js
document.body.classList.add(...)
```

al importar módulo.

Los side effects solo deben ocurrir cuando el componente está activo.

---

# 73. SSR friendliness

Evitar acceder directamente a:

```text
window
document
localStorage
```

durante evaluación inicial del módulo.

Acceder dentro de:

```text
onMounted
```

o comprobando disponibilidad.

Esto prepara ORP UI para SSR futuro.

---

# 74. SSR no obligatorio

No implementar SSR específico todavía.

Solo evitar decisiones que lo hagan imposible sin motivo.

---

# 75. Testing strategy

Crear una estrategia mínima de testing.

No es necesario introducir inmediatamente una suite enorme.

Documentar pruebas:

```text
visual
responsive
keyboard
theme
interaction
```

---

# 76. Unit tests

Para componentes con lógica clara, evaluar tests posteriormente.

Prioridades:

```text
Modal
Sheet
Tabs
Accordion
Dropdown
Drawer
Switch
```

No instalar herramientas de testing si el proyecto todavía no las utiliza sin justificarlo.

---

# 77. Visual regression

No implementar infraestructura completa todavía.

El playground debe funcionar como referencia visual manual.

---

# 78. Documentation examples

Todo ejemplo debe usar:

```text
orp-
```

No mezclar Bootstrap en documentación principal.

Puede existir una sección separada de coexistencia.

---

# 79. Bootstrap coexistence docs

Documentar:

```html
<div class="container">
    Bootstrap
</div>

<div class="orp-container">
    ORP UI
</div>
```

Explicar que ORP UI evita colisiones por namespace.

---

# 80. Framework integration docs

Documentar ejemplos ligeros para:

```text
Plain HTML
Vue
Laravel + Inertia
```

Sin hacer que ORP UI dependa de ninguno.

---

# 81. Vue integration

Ejemplo:

```vue
<script setup>
import { OrpModal } from '@orpot/ui'
import { ref } from 'vue'

const open = ref(false)
</script>
```

---

# 82. Laravel/Inertia documentation

La documentación puede mostrar que la aplicación controla navegación.

Ejemplo conceptual:

```vue
<script setup>
import { router } from '@inertiajs/vue3'
</script>
```

pero este import debe estar:

```text
en la aplicación
```

nunca:

```text
dentro de ORP UI
```

---

# 83. CSS only usage

Demostrar que muchos componentes pueden usarse sin Vue.

Ejemplo:

```html
<button class="orp-btn orp-btn--primary">
    Guardar
</button>

<div class="orp-card">
    ...
</div>

<span class="orp-badge orp-badge--success">
    Activo
</span>
```

---

# 84. Distribution principle

ORP UI debe tener dos capas:

```text
Core CSS
```

y:

```text
Optional Vue Components
```

El CSS debe ser usable sin importar Vue.

---

# 85. Arquitectura conceptual final

```text
ORP UI
│
├── Core CSS
│   ├── Tokens
│   ├── Themes
│   ├── Base
│   ├── Utilities
│   └── CSS Components
│
└── Vue
    ├── Interactive Components
    └── Small Composables
```

Esta separación es obligatoria.

---

# 86. No runtime JS para CSS components

Componentes como:

```text
Button
Card
Badge
Avatar
Alert
Input
List
```

deben seguir funcionando sin JS de ORP UI.

---

# 87. Public API documentation

Crear tabla o documento simple:

```text
Component
Type
CSS class
Vue component
Status
```

Ejemplo:

```text
Button
CSS
orp-btn
-
stable
```

```text
Modal
Vue
orp-modal
OrpModal
stable
```

---

# 88. Naming de paquete

No mezclar nombre de marca y namespace.

Definir:

```text
Brand:
ORP UI
```

```text
CSS namespace:
orp-
```

```text
Vue prefix:
Orp
```

```text
Possible package:
@orpot/ui
```

---

# 89. License

No asumir licencia definitiva sin decisión del propietario.

Crear placeholder o documentar:

```text
License: TBD
```

si todavía no fue definida.

---

# 90. Git tags

Documentar estrategia futura:

```text
v0.1.0
v0.2.0
v0.2.1
```

No crear tags automáticamente salvo instrucción.

---

# 91. Roadmap

Crear sección:

```text
Roadmap
```

Ejemplo:

```text
0.1 Foundation
0.2 Application components
0.3 Themes & package
0.4 Advanced forms
0.5 Data display
1.0 Stable API
```

Es orientativo.

No comprometer fechas.

---

# 92. Migration notes

Cuando existan breaking changes:

crear notas simples.

Ejemplo:

```text
orp-modal--large
→ orp-modal--lg
```

Documentar cambio.

---

# 93. Deprecations

No eliminar APIs inmediatamente cuando ORP UI ya tenga consumidores.

En futuras versiones se puede marcar:

```text
deprecated
```

antes de retirar.

No implementar sistema complejo ahora.

---

# 94. Playground estructura

Organizar el playground por categorías:

```text
Foundation
Navigation
Content
Forms
Interactive
Feedback
Floating
Themes
```

Esto facilitará crecer sin convertirlo en una página caótica.

---

# 95. Playground no producción

Mantener playground fuera del bundle principal cuando sea posible.

No exportarlo desde:

```text
index.js
```

---

# 96. Build test

Verificar que:

```text
npm run build
```

o el comando equivalente existente siga funcionando.

No romper Vite.

---

# 97. Lint/build errors

No ocultar errores con:

```text
ignore
skip
force
```

Corregir la causa cuando sea parte de ORP UI.

---

# 98. Resultado esperado

Al finalizar entregar:

## Architecture audit

Explicar cambios realizados.

## Themes

Mostrar:

```text
Light
Dark
Custom theme example
```

## Tokens

Listar nuevos semantic tokens.

## CSS

Indicar cualquier refactor.

## Public API

Listar exports disponibles.

## Documentation

Listar archivos creados.

## Build

Explicar cómo se compila actualmente.

## Distribution

Explicar qué falta antes de publicar como paquete.

## Version

Indicar versión propuesta.

Ejemplo:

```text
0.1.0
```

## Conflicts

Reportar cualquier problema encontrado.

---

# 99. Criterios de finalización

La Parte 5 termina cuando:

```text
Light theme funciona
Dark theme funciona
```

todos los componentes existentes utilizan semantic tokens donde corresponda;

existe una API pública clara;

existe documentación inicial;

existe estrategia de build;

existe preparación para distribución;

el playground permite probar themes;

y el build actual continúa funcionando.

---

# 100. No publicar automáticamente

No ejecutar:

```text
npm publish
```

No crear releases.

No crear tags remotos.

No cambiar repositorios.

No publicar documentación.

Todo eso requiere instrucción explícita.

---

# Regla final

La Parte 5 no busca hacer ORP UI más grande.

Busca hacerlo más sólido.

Priorizar:

```text
consistency
theming
documentation
portability
maintainability
stable APIs
```

sobre:

```text
more components
more utilities
more dependencies
more abstractions
```

ORP UI debe continuar siendo reconocible por:

```text
orp-
@orp-
--orp-
Orp*
```

y mantener su filosofía:

```text
Mobile-first
Semantic CSS
Vue for behavior
Low dependency
Accessible
Framework-friendly
```
