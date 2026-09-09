# SKILL — ORP UI / Parte 4: Application Components

## Objetivo

Extender ORP UI con componentes de aplicación reutilizables y mobile-first.

Esta fase implementa:

```text
Feedback
├── Toast
└── Alert

Disclosure
├── Accordion
└── Collapsible

Floating UI
├── Dropdown
└── Popover

Navigation
├── Drawer
└── IconButton
```

Actualizar también el playground existente.

No implementar todavía:

```text
DatePicker
Calendar
Autocomplete
Command Palette
Tooltip complejo
DataTable
Carousel
TreeView
Stepper
Wizard
FileUploader
RichText
VirtualList
```

---

# 1. Principio de esta fase

ORP UI debe seguir siendo:

```text
small
mobile-first
accessible
framework-agnostic
low-dependency
```

La Parte 4 agrega interacción, pero NO debe convertir el proyecto en una colección enorme de JavaScript.

Regla:

```text
CSS cuando sea suficiente
Vue cuando exista estado
Dependencias externas solo cuando exista complejidad real
```

---

# 2. Namespace

Mantener obligatoriamente:

```text
orp-
```

Variables LESS:

```text
@orp-
```

CSS Custom Properties:

```text
--orp-
```

Componentes Vue:

```text
OrpToast
OrpAccordion
OrpDropdown
OrpPopover
OrpDrawer
OrpIconButton
```

---

# 3. Arquitectura sugerida

Agregar:

```text
orp-ui/
│
├── components/
│   ├── OrpToast.vue
│   ├── OrpAccordion.vue
│   ├── OrpDropdown.vue
│   ├── OrpPopover.vue
│   ├── OrpDrawer.vue
│   └── OrpIconButton.vue
│
├── composables/
│   ├── useClickOutside.js
│   └── usePositioning.js
│
├── less/
│   ├── components/
│   │   ├── toast.less
│   │   ├── alert.less
│   │   ├── accordion.less
│   │   ├── collapsible.less
│   │   ├── dropdown.less
│   │   ├── popover.less
│   │   ├── drawer.less
│   │   └── icon-button.less
```

Adaptar a la estructura existente.

No reorganizar fases anteriores.

---

# 4. Toast

Crear:

```text
OrpToast.vue
```

Uso básico:

```vue
<OrpToast
    v-model="showToast"
    message="Cambios guardados"
/>
```

Debe funcionar como notificación temporal.

---

# 5. Toast API

Props mínimas:

```text
modelValue
message
variant
duration
position
closable
```

Variantes:

```text
default
success
warning
danger
```

Posiciones iniciales:

```text
top
bottom
```

No implementar todavía:

```text
top-left
top-right
bottom-left
bottom-right
center
custom coordinates
```

---

# 6. Toast markup

Utilizar:

```text
orp-toast
orp-toast__content
orp-toast__message
orp-toast__action
orp-toast__close
```

Variantes:

```text
orp-toast--success
orp-toast--warning
orp-toast--danger
orp-toast--top
orp-toast--bottom
```

---

# 7. Toast timing

Cuando `duration > 0`:

cerrar automáticamente.

Ejemplo:

```text
3000ms
```

debe ser un valor razonable por defecto.

No utilizar timers permanentes.

Limpiar siempre:

```text
setTimeout
```

al cerrar o desmontar.

---

# 8. Toast accesibilidad

Utilizar según contexto:

```html
role="status"
```

para mensajes normales.

Y:

```html
role="alert"
```

para mensajes urgentes/error.

No utilizar `alert` para todo.

---

# 9. Toast y reduced motion

Animación:

```text
opacity
transform
```

Ejemplo:

```text
translateY()
```

Respetar:

```css
prefers-reduced-motion
```

---

# 10. No crear todavía Toast Manager global

NO implementar:

```js
toast.success()
toast.error()
```

global en esta fase.

Primero resolver:

```vue
<OrpToast v-model="..." />
```

Una API programática puede estudiarse después.

---

# 11. Alert

Crear componente CSS semántico:

```text
orp-alert
```

No necesita Vue inicialmente.

Uso:

```html
<div class="orp-alert orp-alert--success">
    Cambios guardados correctamente.
</div>
```

Variantes:

```text
orp-alert--info
orp-alert--success
orp-alert--warning
orp-alert--danger
```

---

# 12. Alert structure

Permitir:

```text
orp-alert
orp-alert__icon
orp-alert__content
orp-alert__title
orp-alert__message
orp-alert__actions
```

No crear API Vue si HTML + CSS es suficiente.

---

# 13. Accordion

Crear:

```text
OrpAccordion.vue
```

Debe permitir múltiples items.

Ejemplo:

```vue
<OrpAccordion :items="items" />
```

Datos:

```js
const items = [
    {
        value: 'one',
        title: 'Información',
        content: '...'
    }
]
```

---

# 14. Accordion API

Props:

```text
items
multiple
modelValue
```

`modelValue` puede representar:

```text
string
```

para single mode.

O:

```text
array
```

cuando:

```text
multiple = true
```

Mantener API consistente.

---

# 15. Accordion markup

Utilizar:

```text
orp-accordion
orp-accordion__item
orp-accordion__trigger
orp-accordion__icon
orp-accordion__content
```

Estado:

```text
orp-accordion__item--open
```

---

# 16. Accordion semántica

El trigger debe ser:

```html
<button>
```

No:

```html
<div @click>
```

Usar:

```text
aria-expanded
aria-controls
```

y IDs relacionados correctamente.

---

# 17. Accordion animation

No animar directamente:

```text
height: auto
```

con JavaScript complicado.

Preferir solución sencilla.

Puede utilizarse:

```text
CSS Grid
grid-template-rows
```

o un approach CSS razonable.

No crear un motor de medición de alturas salvo que sea necesario.

---

# 18. Accordion multiple

Cuando:

```text
multiple = false
```

abrir un item cierra el anterior.

Cuando:

```text
multiple = true
```

se permiten múltiples abiertos.

---

# 19. Collapsible

Además del Accordion, crear estilos/component behavior simple para:

```text
orp-collapsible
```

La diferencia:

```text
Accordion
= colección de secciones
```

```text
Collapsible
= una sola sección expandible
```

Puede implementarse como Vue si aporta utilidad real.

No duplicar lógica innecesariamente.

---

# 20. Dropdown

Crear:

```text
OrpDropdown.vue
```

Objetivo:

Mostrar un menú contextual relacionado con un trigger.

Ejemplo:

```vue
<OrpDropdown>
    <template #trigger>
        ...
    </template>

    ...
</OrpDropdown>
```

---

# 21. Dropdown markup

Utilizar:

```text
orp-dropdown
orp-dropdown__trigger
orp-dropdown__menu
orp-dropdown__item
orp-dropdown__divider
orp-dropdown__label
```

---

# 22. Dropdown API

Props mínimas:

```text
modelValue
placement
closeOnSelect
closeOnOutside
```

Placements iniciales:

```text
bottom-start
bottom-end
top-start
top-end
```

No soportar 20 variantes de posicionamiento todavía.

---

# 23. Dropdown slots

Soportar:

```text
trigger
default
```

Ejemplo:

```vue
<OrpDropdown>

    <template #trigger>
        <button class="orp-icon-btn">
            ...
        </button>
    </template>

    <button class="orp-dropdown__item">
        Editar
    </button>

</OrpDropdown>
```

---

# 24. Click Outside

Crear un composable reusable:

```text
useClickOutside.js
```

Debe:

* registrar listener cuando sea necesario;
* ignorar el trigger;
* desmontar correctamente;
* no dejar listeners globales.

No utilizar dependencia externa para esta necesidad simple.

---

# 25. Posicionamiento

Dropdown y Popover necesitan posicionamiento.

Primero implementar una estrategia sencilla mediante:

```text
getBoundingClientRect()
```

y coordenadas calculadas.

No intentar replicar Floating UI.

---

# 26. usePositioning

Si existe duplicación clara, crear:

```text
usePositioning.js
```

Responsabilidades limitadas:

```text
trigger rect
floating rect
placement
viewport boundaries simples
```

No implementar:

```text
collision engine completo
arrow middleware
flip middleware complejo
auto placement avanzado
nested scrolling engine
```

---

# 27. Viewport collision

Como mínimo, evitar que el menú salga completamente del viewport.

Si:

```text
bottom
```

no cabe, puede intentar:

```text
top
```

Implementación simple.

No buscar perfección de Floating UI.

---

# 28. Dropdown keyboard

Soportar como mínimo:

```text
Escape
```

para cerrar.

Y navegación razonable mediante:

```text
Tab
```

No implementar aún navegación completa con ArrowUp/ArrowDown si complica demasiado la versión inicial.

Si se implementa, hacerlo correctamente.

---

# 29. Dropdown semantics

Cuando se use como menú:

```text
role="menu"
```

y:

```text
role="menuitem"
```

solo cuando realmente tenga semántica de menú.

No aplicar ARIA incorrectamente a contenido arbitrario.

---

# 30. Popover

Crear:

```text
OrpPopover.vue
```

Popover es similar a Dropdown pero permite contenido más libre.

Ejemplo:

```vue
<OrpPopover>

    <template #trigger>
        ...
    </template>

    <div>
        Información adicional
    </div>

</OrpPopover>
```

---

# 31. Dropdown vs Popover

Mantener diferencia clara:

```text
Dropdown
→ lista de acciones
```

```text
Popover
→ contenido contextual
```

No crear dos componentes idénticos con nombres diferentes.

Pueden compartir composables internos.

---

# 32. Popover markup

Utilizar:

```text
orp-popover
orp-popover__content
orp-popover__arrow
```

El arrow es opcional.

No complicar posicionamiento por soportarlo si genera mucho código.

Puede omitirse inicialmente.

---

# 33. Popover API

Props:

```text
modelValue
placement
closeOnOutside
closeOnEscape
```

Slots:

```text
trigger
default
```

---

# 34. Teleport Dropdown / Popover

Considerar:

```vue
<Teleport to="body">
```

para evitar problemas de:

```text
overflow hidden
stacking context
z-index
```

Especialmente si ya existe esta estrategia en Modal y Sheet.

---

# 35. Z-index floating elements

Extender escala:

```less
@orp-z-dropdown: 500;
@orp-z-popover: 600;
@orp-z-backdrop: 900;
@orp-z-modal: 1000;
@orp-z-sheet: 1100;
@orp-z-toast: 1200;
```

Mantener escala clara.

---

# 36. Drawer

Crear:

```text
OrpDrawer.vue
```

Drawer es navegación/panel lateral.

Uso:

```vue
<OrpDrawer v-model="showMenu">
    ...
</OrpDrawer>
```

---

# 37. Drawer direction

Inicialmente soportar:

```text
left
right
```

No:

```text
top
bottom
```

porque bottom ya pertenece conceptualmente a Sheet.

---

# 38. Drawer markup

Utilizar:

```text
orp-drawer
orp-drawer__backdrop
orp-drawer__panel
orp-drawer__header
orp-drawer__body
orp-drawer__footer
orp-drawer__close
```

Modifiers:

```text
orp-drawer--left
orp-drawer--right
```

---

# 39. Drawer API

Props:

```text
modelValue
position
title
closeOnBackdrop
closeOnEscape
```

Slots:

```text
header
default
footer
```

Mantener API consistente con:

```text
Modal
Sheet
```

---

# 40. Drawer behavior

Debe soportar:

```text
open
close
Escape
backdrop
scroll lock
focus restore
```

Reusar composables existentes cuando aplique.

No duplicar lógica de Modal y Sheet.

---

# 41. Drawer animation

Usar:

```text
transform: translateX()
```

No animar:

```text
left
right
width
```

si se puede evitar.

---

# 42. Drawer width

Definir token:

```less
@orp-drawer-width: 320px;
```

Y limitar:

```css
max-width: 85vw;
```

aproximadamente para móvil.

No permitir que el drawer cubra accidentalmente más del viewport de forma incómoda.

---

# 43. IconButton

Crear:

```text
OrpIconButton.vue
```

Este componente sí puede justificar Vue por accesibilidad y API consistente.

Uso:

```vue
<OrpIconButton aria-label="Cerrar">
    <CloseIcon />
</OrpIconButton>
```

---

# 44. IconButton CSS

Clases:

```text
orp-icon-btn
orp-icon-btn--primary
orp-icon-btn--ghost
orp-icon-btn--danger
orp-icon-btn--sm
orp-icon-btn--md
orp-icon-btn--lg
```

No usar:

```text
orp-btn-icon
```

si ya se adopta `orp-icon-btn` como nombre.

Mantener consistencia.

---

# 45. IconButton tamaño

Garantizar touch target razonable.

Aunque el icono mida:

```text
20px
```

el botón puede medir:

```text
44px
```

No reducir hit area al tamaño del SVG.

---

# 46. IconButton accessibility

Requerir:

```text
aria-label
```

cuando no exista texto visible.

Si no se proporciona, mostrar warning en desarrollo si es razonable.

No complicar producción con validaciones innecesarias.

---

# 47. IconButton y AppBar

Actualizar examples para mostrar:

```text
orp-app-bar
+
OrpIconButton
```

Ejemplo:

```vue
<OrpIconButton aria-label="Volver">
    ...
</OrpIconButton>
```

---

# 48. FAB

NO crear FAB como componente separado todavía.

Si se necesita visualmente, puede explorarse mediante modifier:

```text
orp-icon-btn--floating
```

solo si existe un caso real.

No implementarlo por anticipado.

---

# 49. Alert y Toast consistencia

Compartir semantic variants:

```text
info
success
warning
danger
```

No usar:

```text
error
```

en un componente y:

```text
danger
```

en otro.

Mantener:

```text
danger
```

como nombre técnico consistente.

La interfaz puede decir "Error".

---

# 50. Nuevos semantic tokens

Considerar tokens:

```less
@orp-info: #0dcaf0;
```

y CSS variable:

```text
--orp-info
```

si todavía no existe.

También:

```text
--orp-backdrop
```

de fases anteriores.

No duplicar colores.

---

# 51. Surface elevation

Dropdown, Popover, Drawer y Toast pueden necesitar elevación.

Crear una escala pequeña si todavía no existe:

```less
@orp-shadow-sm:
    0 1px 2px rgba(0, 0, 0, .06);

@orp-shadow-md:
    0 8px 24px rgba(0, 0, 0, .12);

@orp-shadow-lg:
    0 16px 40px rgba(0, 0, 0, .16);
```

Exponer CSS variables si aporta valor:

```text
--orp-shadow-sm
--orp-shadow-md
--orp-shadow-lg
```

---

# 52. No abusar de shadows

ORP UI debe mantener estilo moderno pero limpio.

No aplicar sombras fuertes a todos los componentes.

Usar elevation según contexto:

```text
card raised
dropdown
popover
drawer
toast
```

---

# 53. Focus management

Drawer, Dropdown y Popover deben considerar focus.

Al cerrar mediante:

```text
Escape
outside
selection
```

devolver focus al trigger cuando tenga sentido.

---

# 54. Scroll

Dropdown/Popover con contenido largo deben tener:

```text
max-height
overflow-y: auto
```

cuando sea necesario.

No permitir que crezcan indefinidamente fuera del viewport.

---

# 55. Mobile behavior de Dropdown

En móvil, menús demasiado grandes pueden ser incómodos.

No convertir automáticamente Dropdown en Sheet todavía.

Pero diseñar API sin impedir que en una futura versión exista:

```text
responsive behavior
```

---

# 56. Drawer safe area

Drawer debe considerar:

```text
safe-area-inset-top
safe-area-inset-bottom
```

cuando cubra toda la altura.

---

# 57. Toast safe area

Toast top:

considerar:

```css
env(safe-area-inset-top)
```

Toast bottom:

considerar:

```css
env(safe-area-inset-bottom)
```

---

# 58. No router

Drawer y Dropdown no deben conocer rutas.

Ejemplo:

```vue
<button
    class="orp-dropdown__item"
    @click="goProfile"
>
```

La aplicación decide qué hace.

---

# 59. No Laravel/Inertia

No importar:

```text
Laravel
@inertiajs/vue3
Vue Router
```

dentro de ORP UI.

---

# 60. Composables existentes

Revisar los composables de Parte 3:

```text
useBodyScrollLock
useEscapeKey
useRestoreFocus
```

Reutilizarlos en:

```text
Drawer
Dropdown
Popover
```

cuando corresponda.

No duplicar implementación.

---

# 61. No crear mega composable

Evitar:

```text
useEverythingOverlay.js
```

Preferir composables pequeños:

```text
useEscapeKey
useClickOutside
useBodyScrollLock
useRestoreFocus
usePositioning
```

---

# 62. Playground

Actualizar:

```text
OrpPlayground.vue
```

con secciones nuevas.

---

# 63. Toast playground

Mostrar:

```text
default
success
warning
danger
top
bottom
auto dismiss
closable
```

---

# 64. Alert playground

Mostrar:

```text
info
success
warning
danger
with title
with actions
```

---

# 65. Accordion playground

Mostrar:

```text
single
multiple
long content
disabled item si se implementa
```

---

# 66. Dropdown playground

Mostrar:

```text
bottom-start
bottom-end
with divider
with destructive item
click outside
Escape
```

---

# 67. Popover playground

Mostrar:

```text
text
card-like content
top
bottom
long content
```

---

# 68. Drawer playground

Mostrar:

```text
left
right
header
body
footer
long scroll
```

---

# 69. IconButton playground

Mostrar:

```text
primary
ghost
danger

sm
md
lg

disabled
focus
```

---

# 70. Responsive testing

Probar:

```text
320px
375px
390px
430px
768px
1024px
```

Especialmente:

```text
Dropdown viewport collision
Popover positioning
Drawer width
Toast safe area
Accordion long content
IconButton touch
```

---

# 71. Keyboard testing

Probar:

```text
Tab
Shift+Tab
Escape
Enter
Space
```

según corresponda.

Especialmente:

```text
Accordion
Dropdown
Popover
Drawer
IconButton
```

---

# 72. Touch testing

Verificar:

```text
touch targets
outside click/tap
drawer controls
dropdown trigger
accordion trigger
toast close
```

No depender exclusivamente de hover.

---

# 73. Desktop testing

Aunque ORP UI es mobile-first, comprobar desktop.

Especialmente:

```text
Dropdown
Popover
Drawer
```

porque se usarán mucho con mouse.

---

# 74. Hover

Hover nunca debe ser la única forma de acceder a funcionalidad.

Dropdown no debe abrirse solamente mediante:

```text
:hover
```

Debe funcionar por:

```text
click
keyboard
```

---

# 75. Dependencies

Esta fase debe intentar no agregar dependencias.

No instalar automáticamente:

```text
Floating UI
Popper
Headless UI
Radix
VueUse
```

para casos simples.

Pero si el posicionamiento de Dropdown/Popover empieza a crecer excesivamente, detenerse y documentar que una librería especializada podría ser mejor en una fase posterior.

No reinventar un motor completo de floating elements.

---

# 76. Performance

Listeners globales:

* registrar solo mientras componentes estén abiertos;
* remover al desmontar.

No mantener:

```text
document click
document keydown
window resize
window scroll
```

permanentemente cuando no hagan falta.

---

# 77. Resize / Scroll reposition

Dropdown y Popover pueden recalcular posición cuando estén abiertos.

Escuchar:

```text
resize
scroll
```

solo mientras están visibles.

Throttle solo si realmente es necesario.

No agregar dependencias.

---

# 78. CSS architecture

Agregar imports:

```less
@import "components/toast.less";
@import "components/alert.less";
@import "components/accordion.less";
@import "components/collapsible.less";
@import "components/dropdown.less";
@import "components/popover.less";
@import "components/drawer.less";
@import "components/icon-button.less";
```

Mantener orden lógico.

---

# 79. Exports

Actualizar:

```text
index.js
```

para:

```js
export { default as OrpToast } from './components/OrpToast.vue'
export { default as OrpAccordion } from './components/OrpAccordion.vue'
export { default as OrpDropdown } from './components/OrpDropdown.vue'
export { default as OrpPopover } from './components/OrpPopover.vue'
export { default as OrpDrawer } from './components/OrpDrawer.vue'
export { default as OrpIconButton } from './components/OrpIconButton.vue'
```

Exportar composables solo si son útiles públicamente.

Preferir mantener internos:

```text
useClickOutside
usePositioning
```

hasta existir caso real externo.

---

# 80. Ejemplo Toast

```vue
<script setup>
import { ref } from 'vue'
import { OrpToast } from '@/orp-ui'

const saved = ref(false)
</script>

<template>

    <button
        class="orp-btn orp-btn--primary"
        @click="saved = true"
    >
        Guardar
    </button>

    <OrpToast
        v-model="saved"
        variant="success"
        message="Cambios guardados"
    />

</template>
```

---

# 81. Ejemplo Accordion

```vue
<script setup>
import { ref } from 'vue'
import { OrpAccordion } from '@/orp-ui'

const open = ref('profile')

const items = [
    {
        value: 'profile',
        title: 'Perfil',
        content: 'Información del perfil'
    },
    {
        value: 'contact',
        title: 'Contacto',
        content: 'Información de contacto'
    }
]
</script>

<template>

    <OrpAccordion
        v-model="open"
        :items="items"
    />

</template>
```

---

# 82. Ejemplo Dropdown

```vue
<OrpDropdown>

    <template #trigger>

        <OrpIconButton aria-label="Más opciones">
            ...
        </OrpIconButton>

    </template>

    <button class="orp-dropdown__item">
        Editar
    </button>

    <button class="orp-dropdown__item">
        Duplicar
    </button>

    <div class="orp-dropdown__divider"></div>

    <button
        class="
            orp-dropdown__item
            orp-dropdown__item--danger
        "
    >
        Eliminar
    </button>

</OrpDropdown>
```

---

# 83. Ejemplo Popover

```vue
<OrpPopover placement="bottom-start">

    <template #trigger>

        <OrpIconButton aria-label="Información">
            ...
        </OrpIconButton>

    </template>

    <div class="orp-p-4">
        Información adicional.
    </div>

</OrpPopover>
```

---

# 84. Ejemplo Drawer

```vue
<script setup>
import { ref } from 'vue'
import {
    OrpDrawer,
    OrpIconButton
} from '@/orp-ui'

const menu = ref(false)
</script>

<template>

    <OrpIconButton
        aria-label="Abrir menú"
        @click="menu = true"
    >
        ...
    </OrpIconButton>

    <OrpDrawer
        v-model="menu"
        position="left"
        title="Menú"
    >

        <div class="orp-list">

            <button class="orp-list__item orp-list__item--interactive">
                Inicio
            </button>

            <button class="orp-list__item orp-list__item--interactive">
                Perfil
            </button>

        </div>

    </OrpDrawer>

</template>
```

---

# 85. Alert ejemplo

```html
<div class="orp-alert orp-alert--warning">

    <div class="orp-alert__content">

        <div class="orp-alert__title">
            Atención
        </div>

        <div class="orp-alert__message">
            Algunos cambios aún no se han guardado.
        </div>

    </div>

</div>
```

---

# 86. Documentation

Cada componente Vue nuevo debe documentar:

```text
Description
Usage
Props
Events
Slots
Accessibility
Keyboard behavior
Examples
```

Especialmente:

```text
OrpDropdown
OrpPopover
OrpDrawer
```

porque tienen comportamiento.

---

# 87. Consistencia de API

Mantener:

```text
modelValue
closeOnOutside
closeOnEscape
placement
position
variant
```

No inventar nombres diferentes para el mismo concepto.

---

# 88. No breaking changes

No romper componentes anteriores:

```text
Button
Card
AppBar
BottomNav
Avatar
Badge
List
Tabs
Modal
Sheet
Switch
Forms
```

Si se detecta una necesidad de mejora estructural:

documentarla.

No cambiar APIs ya utilizadas sin necesidad.

---

# 89. Criterios de calidad

Antes de finalizar:

## Toast

* auto dismiss;
* close;
* safe area;
* accessibility.

## Accordion

* single;
* multiple;
* keyboard;
* semantic buttons.

## Dropdown

* click outside;
* Escape;
* positioning;
* viewport basic collision;
* focus return.

## Popover

* positioning;
* outside;
* Escape;
* content flexible.

## Drawer

* left/right;
* backdrop;
* escape;
* scroll lock;
* focus;
* safe areas.

## IconButton

* accessible label;
* touch target;
* variants;
* focus.

---

# 90. Resultado esperado

Entregar al finalizar:

## Archivos creados

Lista.

## Archivos modificados

Lista.

## Nuevos componentes Vue

```text
OrpToast
OrpAccordion
OrpDropdown
OrpPopover
OrpDrawer
OrpIconButton
```

## Nuevos componentes CSS

```text
orp-toast
orp-alert
orp-accordion
orp-collapsible
orp-dropdown
orp-popover
orp-drawer
orp-icon-btn
```

## Nuevos composables

Listar únicamente si fueron necesarios.

## Tokens

Listar nuevos tokens.

## Playground

Indicar casos disponibles.

## Accessibility

Explicar:

```text
keyboard
focus
ARIA
Escape
touch
```

## Conflictos

Reportar conflictos.

---

# 91. Alcance final Parte 4

La Parte 4 termina cuando estén funcionales:

```text
Feedback
├── Toast
└── Alert

Disclosure
├── Accordion
└── Collapsible

Floating
├── Dropdown
└── Popover

Navigation
├── Drawer
└── IconButton
```

NO continuar automáticamente con Parte 5.

---

# Regla final

Con esta fase ORP UI empieza a tener componentes de aplicación más avanzados.

Aun así, mantener la filosofía:

```text
ORP UI != framework gigantesco
```

No crear funcionalidades porque Bootstrap, Framework7 o shadcn las tengan.

Agregar únicamente aquello que resuelve necesidades comunes.

Si una implementación empieza a requerir demasiado código especializado, evaluar una dependencia madura antes de reconstruir una librería completa dentro de ORP UI.

Priorizar siempre:

```text
semantic HTML
mobile-first
accessibility
predictable APIs
low dependencies
small components
reusability
```

