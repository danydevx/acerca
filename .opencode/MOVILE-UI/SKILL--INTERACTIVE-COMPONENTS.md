# SKILL — ORP UI / Parte 3: Interactive Components

## Objetivo

Extender ORP UI con los primeros componentes interactivos reales.

Esta fase introduce componentes Vue cuando exista comportamiento reutilizable.

Implementar únicamente:

```text
Interactive
├── Tabs
├── Modal
├── Sheet
└── Switch

Forms
├── Input
├── Textarea
└── Select
```

Actualizar también el playground existente.

No implementar todavía:

```text
Dropdown
Toast
Accordion
Drawer
Offcanvas
DatePicker
Calendar
Autocomplete
Command palette
Tooltip
Popover
Carousel
Theme manager
Router integration
```

---

# 1. Principio de esta fase

A partir de esta etapa, ORP UI combina:

```text
LESS/CSS
+
Vue 3
+
Composition API
```

pero Vue debe utilizarse solamente donde exista:

* estado;
* apertura/cierre;
* eventos;
* sincronización mediante `v-model`;
* accesibilidad dinámica;
* interacción reutilizable.

No convertir todos los controles visuales en wrappers Vue sin necesidad.

---

# 2. Namespace

Mantener obligatoriamente:

```text
orp-
```

para CSS.

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
OrpTabs
OrpModal
OrpSheet
OrpSwitch
```

El prefijo visual sigue siendo ORP.

---

# 3. Estructura sugerida

Agregar una estructura similar a:

```text
orp-ui/
│
├── components/
│   ├── OrpTabs.vue
│   ├── OrpModal.vue
│   ├── OrpSheet.vue
│   └── OrpSwitch.vue
│
├── less/
│   ├── components/
│   │   ├── tabs.less
│   │   ├── modal.less
│   │   ├── sheet.less
│   │   ├── switch.less
│   │   ├── input.less
│   │   ├── textarea.less
│   │   └── select.less
│
└── index.js
```

Adaptar a la estructura real creada en las fases anteriores.

No reorganizar todo el proyecto innecesariamente.

---

# 4. Tabs

Crear un componente Vue:

```text
OrpTabs.vue
```

Debe controlar únicamente el estado de selección.

API sugerida:

```vue
<OrpTabs
    v-model="activeTab"
    :items="tabs"
/>
```

Datos:

```js
const tabs = [
    {
        value: 'profile',
        label: 'Perfil'
    },
    {
        value: 'contact',
        label: 'Contacto'
    }
]
```

---

# 5. Tabs markup

El componente debe generar una estructura semántica similar a:

```html
<div class="orp-tabs">
    <div
        class="orp-tabs__list"
        role="tablist"
    >
        <button
            class="orp-tabs__item orp-tabs__item--active"
            role="tab"
            aria-selected="true"
        >
            Perfil
        </button>
    </div>
</div>
```

---

# 6. Tabs API

Props mínimas:

```text
modelValue
items
```

Opcionales:

```text
variant
stretch
```

No agregar decenas de props.

Eventos:

```text
update:modelValue
change
```

---

# 7. Tabs variants

Crear inicialmente:

```text
orp-tabs--default
orp-tabs--pill
orp-tabs--underline
```

Si una variante no aporta diferencia real, omitirla.

---

# 8. Tabs scrollable

En mobile, cuando existan demasiadas tabs:

```text
orp-tabs__list
```

debe permitir scroll horizontal.

Evitar que cinco o seis tabs reduzcan su ancho hasta volverse ilegibles.

Utilizar:

```css
overflow-x: auto;
```

cuando corresponda.

No mostrar scrollbar innecesariamente si puede ocultarse sin perjudicar accesibilidad.

---

# 9. Tabs keyboard accessibility

Implementar navegación con teclado cuando sea razonable:

```text
ArrowLeft
ArrowRight
Home
End
```

Mantener:

```text
role="tablist"
role="tab"
aria-selected
```

No agregar complejidad innecesaria si la implementación todavía no incluye paneles internos.

---

# 10. Separar Tabs de contenido

Preferir que `OrpTabs` controle selección, mientras la aplicación decide qué contenido renderizar.

Ejemplo:

```vue
<OrpTabs
    v-model="activeTab"
    :items="tabs"
/>

<section v-if="activeTab === 'profile'">
    ...
</section>
```

Evitar construir un sistema de tabs excesivamente complejo en esta primera versión.

---

# 11. Modal

Crear:

```text
OrpModal.vue
```

Debe utilizar:

```vue
v-model
```

Ejemplo:

```vue
<OrpModal v-model="showModal">
    ...
</OrpModal>
```

---

# 12. Modal API

Props iniciales:

```text
modelValue
title
closeOnBackdrop
closeOnEscape
```

Opcional:

```text
size
```

Mantener pocos tamaños:

```text
sm
md
lg
```

No crear:

```text
xs
xl
2xl
3xl
fullscreen-md-down
```

todavía.

---

# 13. Modal events

Emitir:

```text
update:modelValue
open
opened
close
closed
```

Si no existe animación que justifique separar:

```text
open/opened
close/closed
```

simplificar a:

```text
open
close
```

No crear eventos redundantes.

---

# 14. Modal structure

Utilizar:

```text
orp-modal
orp-modal__backdrop
orp-modal__dialog
orp-modal__header
orp-modal__title
orp-modal__body
orp-modal__footer
orp-modal__close
```

Ejemplo:

```html
<div class="orp-modal">
    <div class="orp-modal__backdrop"></div>

    <section
        class="orp-modal__dialog"
        role="dialog"
        aria-modal="true"
    >
        ...
    </section>
</div>
```

---

# 15. Modal teletransportado

Utilizar Vue:

```vue
<Teleport to="body">
```

cuando esto evite problemas de:

```text
overflow
z-index
stacking context
```

El modal no debe quedar atrapado dentro de contenedores de la aplicación.

---

# 16. Modal escape

Soportar:

```text
Escape
```

cuando:

```text
closeOnEscape = true
```

Registrar listeners únicamente cuando el modal esté abierto.

Eliminar listeners al cerrar o desmontar.

---

# 17. Modal backdrop

Cuando:

```text
closeOnBackdrop = true
```

hacer click en el backdrop debe cerrar.

Hacer click dentro del dialog NO debe cerrar.

---

# 18. Modal focus

Gestionar focus de forma razonable.

Al abrir:

1. recordar elemento activo;
2. mover focus al modal o primer elemento interactivo;
3. al cerrar, devolver focus al elemento anterior cuando siga existiendo.

No implementar un focus trap gigantesco desde cero si puede resolverse de forma sencilla.

Pero evitar que el usuario de teclado pierda completamente el contexto.

---

# 19. Scroll lock

Mientras el Modal esté abierto:

bloquear scroll del `body`.

Restaurarlo correctamente al cerrar.

No dejar:

```css
overflow: hidden
```

pegado después de desmontar.

---

# 20. Z-index

Extender la escala:

```less
@orp-z-sticky: 100;
@orp-z-fixed: 200;
@orp-z-backdrop: 900;
@orp-z-modal: 1000;
@orp-z-sheet: 1100;
```

No utilizar valores absurdos.

---

# 21. Sheet

Crear:

```text
OrpSheet.vue
```

Un Sheet es un panel que aparece desde la parte inferior, pensado principalmente para móvil.

Uso:

```vue
<OrpSheet v-model="showActions">
    ...
</OrpSheet>
```

---

# 22. Sheet structure

Utilizar:

```text
orp-sheet
orp-sheet__backdrop
orp-sheet__panel
orp-sheet__handle
orp-sheet__header
orp-sheet__title
orp-sheet__body
orp-sheet__footer
```

Ejemplo:

```html
<div class="orp-sheet">

    <div class="orp-sheet__backdrop"></div>

    <section
        class="orp-sheet__panel"
        role="dialog"
        aria-modal="true"
    >

        <div class="orp-sheet__handle"></div>

        ...

    </section>

</div>
```

---

# 23. Sheet API

Props iniciales:

```text
modelValue
title
showHandle
closeOnBackdrop
closeOnEscape
```

Opcional:

```text
height
```

Pero preferir valores semánticos:

```text
auto
half
large
```

en vez de obligar al usuario a enviar valores arbitrarios.

---

# 24. Sheet no draggable todavía

NO implementar drag-to-close en esta fase.

No construir reconocimiento de gestures todavía.

El handle es visual inicialmente.

Soportar:

```text
open
close
backdrop
escape
```

Eso es suficiente.

Gestos pueden pertenecer a una fase posterior.

---

# 25. Sheet animation

Utilizar principalmente:

```text
transform: translateY(...)
opacity
```

Evitar animar:

```text
height
top
bottom
```

si puede resolverse con transform.

Duración aproximada:

```text
200ms - 300ms
```

Respetar:

```css
prefers-reduced-motion
```

---

# 26. Sheet safe area

El panel debe contemplar:

```css
env(safe-area-inset-bottom)
```

Especialmente para acciones inferiores.

---

# 27. Código compartido Modal / Sheet

Modal y Sheet compartirán varias necesidades:

```text
Escape listener
body scroll lock
focus restore
backdrop
Teleport
```

Si existe duplicación clara, crear composables pequeños.

Por ejemplo:

```text
useBodyScrollLock.js
useEscapeKey.js
useRestoreFocus.js
```

Pero NO crear un gigantesco:

```text
useOverlaySystem.js
```

con demasiada abstracción.

---

# 28. Composable useBodyScrollLock

Si se crea:

```text
useBodyScrollLock
```

debe:

* bloquear únicamente mientras sea necesario;
* restaurar estado original;
* soportar desmontaje;
* evitar dejar efectos secundarios globales.

---

# 29. Switch

Crear:

```text
OrpSwitch.vue
```

Uso:

```vue
<OrpSwitch v-model="notifications" />
```

Puede soportar:

```vue
<OrpSwitch
    v-model="notifications"
    label="Notificaciones"
/>
```

---

# 30. Switch semantics

Preferir utilizar internamente:

```html
<input type="checkbox">
```

en lugar de reinventar completamente el control con `div`.

Esto proporciona:

```text
keyboard
forms
disabled
accessibility
browser semantics
```

y luego estilizar visualmente.

---

# 31. Switch structure

Utilizar:

```text
orp-switch
orp-switch__input
orp-switch__control
orp-switch__thumb
orp-switch__label
```

Estado checked debe derivarse del input.

No depender exclusivamente de clases agregadas manualmente.

---

# 32. Switch API

Props:

```text
modelValue
label
disabled
name
value
```

Emitir:

```text
update:modelValue
change
```

No agregar funcionalidades avanzadas todavía.

---

# 33. Forms foundation

Esta fase debe agregar estilos semánticos para formularios.

Implementar CSS para:

```text
orp-field
orp-label
orp-input
orp-textarea
orp-select
orp-help
orp-error
```

No crear wrappers Vue automáticamente.

---

# 34. Field

Estructura sugerida:

```html
<div class="orp-field">

    <label
        class="orp-label"
        for="email"
    >
        Correo electrónico
    </label>

    <input
        id="email"
        class="orp-input"
        type="email"
    >

    <div class="orp-help">
        Nunca compartiremos tu correo.
    </div>

</div>
```

---

# 35. Input

Crear:

```text
orp-input
```

Debe contemplar:

```text
default
hover
focus-visible
disabled
readonly
error
```

Usar los design tokens.

No hardcodear colores.

---

# 36. Input sizes

Inicialmente usar un único tamaño bien diseñado.

No crear:

```text
sm
md
lg
```

hasta existir necesidad real.

En mobile debe respetar touch y legibilidad.

---

# 37. Input font-size

En mobile, evitar tamaños demasiado pequeños.

Especialmente considerar iOS.

Utilizar aproximadamente:

```text
16px
```

para inputs estándar cuando sea necesario evitar zoom automático.

---

# 38. Error state

Utilizar modifier:

```text
orp-input--error
```

o estado contextual:

```text
orp-field--error
```

Elegir una estrategia consistente.

Preferencia:

```html
<div class="orp-field orp-field--error">
```

para permitir estilizar:

```text
input
label
error message
```

como conjunto.

---

# 39. Error accessibility

Cuando exista error:

```html
<input
    aria-invalid="true"
    aria-describedby="email-error"
>
```

Mensaje:

```html
<div
    id="email-error"
    class="orp-error"
>
    Ingresa un correo válido.
</div>
```

---

# 40. Textarea

Crear:

```text
orp-textarea
```

Debe compartir apariencia con Input.

Permitir:

```css
resize: vertical;
```

por defecto.

No desactivar resize completamente salvo razón clara.

---

# 41. Select

Crear:

```text
orp-select
```

Utilizar:

```html
<select>
```

nativo.

No construir todavía un custom select con dropdown JavaScript.

Ejemplo:

```html
<select class="orp-select">
    <option>...</option>
</select>
```

El select nativo suele ofrecer mejor experiencia móvil.

---

# 42. Form groups

No crear un sistema gigante de formularios.

No implementar todavía:

```text
input groups
floating labels
autocomplete
combobox
date picker
file uploader
rich text
```

---

# 43. CSS tokens nuevos

Agregar únicamente los necesarios.

Por ejemplo:

```less
@orp-control-height: 48px;

@orp-overlay-background:
    rgba(0, 0, 0, 0.48);

@orp-modal-width-sm: 320px;
@orp-modal-width-md: 480px;
@orp-modal-width-lg: 720px;
```

Exponer CSS variables solo cuando ayuden al theming.

---

# 44. Borders

Forms y overlays deben reutilizar:

```text
--orp-border
--orp-radius-*
--orp-surface
--orp-text
```

No crear tokens duplicados como:

```text
--orp-input-border-gray
--orp-modal-border-gray
```

cuando pueden compartir semantic tokens.

---

# 45. Overlay backdrop

Crear una variable:

```css
--orp-backdrop
```

si Modal y Sheet utilizan el mismo concepto.

Ejemplo:

```less
@orp-backdrop: rgba(0, 0, 0, .48);
```

---

# 46. CSS architecture

Agregar:

```text
less/components/
├── tabs.less
├── modal.less
├── sheet.less
├── switch.less
├── field.less
├── input.less
├── textarea.less
└── select.less
```

Si varios form controls comparten mucho código, puede utilizarse:

```text
forms.less
```

pero mantener el archivo legible.

---

# 47. Vue component exports

Actualizar:

```text
index.js
```

para exportar únicamente componentes Vue reales.

Ejemplo:

```js
export { default as OrpTabs } from './components/OrpTabs.vue'
export { default as OrpModal } from './components/OrpModal.vue'
export { default as OrpSheet } from './components/OrpSheet.vue'
export { default as OrpSwitch } from './components/OrpSwitch.vue'
```

No exportar CSS como componentes Vue.

---

# 48. Uso sin instalación global

ORP UI debe permitir:

```js
import {
    OrpModal,
    OrpSheet
} from '@/orp-ui'
```

No exigir inicialmente:

```js
app.use(OrpUi)
```

Los imports individuales ayudan a mantener la arquitectura explícita.

Una instalación global puede estudiarse en el futuro.

---

# 49. No Inertia

Los componentes NO deben importar:

```js
@inertiajs/vue3
```

Ejemplo correcto:

```vue
<OrpModal v-model="showDelete">

    <button
        class="orp-btn orp-btn--danger"
        @click="deleteItem"
    >
        Eliminar
    </button>

</OrpModal>
```

La aplicación decide qué hace `deleteItem`.

---

# 50. No router

Tabs, Modal y Sheet no deben conocer:

```text
Vue Router
Inertia Router
Laravel routes
```

---

# 51. No global event bus

No implementar un event bus global para:

```text
openModal()
openSheet()
```

todavía.

Preferir estado local:

```js
const showModal = ref(false)
```

y:

```vue
<OrpModal v-model="showModal" />
```

Esto mantiene el flujo simple.

---

# 52. Playground

Actualizar `OrpPlayground.vue`.

Agregar sección:

```text
Interactive Components
```

---

# 53. Tabs playground

Mostrar:

```text
Default
Pill
Underline
2 tabs
4 tabs
Overflow horizontal
```

Mostrar selección funcional.

---

# 54. Modal playground

Crear botones:

```text
Open Small Modal
Open Default Modal
Open Large Modal
```

Probar:

```text
backdrop close
escape
focus
scroll lock
```

---

# 55. Sheet playground

Mostrar:

```text
Auto
Half
Large
```

Probar:

```text
open
close
backdrop
escape
safe area
```

---

# 56. Switch playground

Mostrar:

```text
Unchecked
Checked
Disabled
With label
```

Debe ser realmente interactivo con `v-model`.

---

# 57. Forms playground

Mostrar:

```text
Input
Input focus
Disabled
Readonly
Error

Textarea

Select

Help text
Error text
```

---

# 58. Mobile testing

Probar especialmente:

```text
320px
375px
390px
430px
```

También:

```text
768px
1024px
```

Revisar:

```text
Modal width
Sheet height
keyboard
forms
touch
safe areas
scroll
```

---

# 59. Virtual keyboard

Forms y Sheet deben probarse con la idea de teclado móvil.

Evitar layouts rígidos que dependan exclusivamente de:

```text
100vh
```

Preferir cuando corresponda:

```css
100dvh
```

o layouts flexibles.

No asumir que viewport móvil siempre permanece estable al abrir teclado.

---

# 60. Viewport units

Cuando se requiera altura de viewport, preferir:

```text
dvh
```

sobre:

```text
vh
```

en interfaces móviles modernas.

Utilizar fallback si fuera necesario.

---

# 61. Scroll dentro de Modal

Modal debe permitir contenido largo.

Estructura recomendada:

```text
dialog
├── header
├── body → scroll
└── footer
```

No hacer que toda la página detrás se desplace.

---

# 62. Scroll dentro de Sheet

Sheet debe permitir:

```text
header fijo
body scrollable
footer visible
```

cuando el contenido lo requiera.

Evitar bloquear contenido inaccesible debajo del viewport.

---

# 63. Focus-visible

Todos los controles deben tener estado:

```text
:focus-visible
```

incluyendo:

```text
Tabs
Modal close
Sheet actions
Switch
Input
Textarea
Select
```

---

# 64. Disabled

Los estados disabled deben:

* seguir siendo legibles;
* no depender solo de opacity extrema;
* impedir interacción;
* reflejar semántica nativa cuando sea posible.

Preferir:

```html
disabled
```

real en controles HTML.

---

# 65. Reduced motion

Modal y Sheet deben respetar:

```css
@media (prefers-reduced-motion: reduce)
```

Reducir o eliminar transitions significativas.

---

# 66. No JS animations

No utilizar JavaScript para animar Modal o Sheet.

Utilizar:

```text
Vue Transition
+
CSS transform
+
opacity
```

---

# 67. Vue Transition

Puede utilizarse:

```vue
<Transition name="orp-modal">
```

y:

```vue
<Transition name="orp-sheet">
```

Las clases generadas por Vue pueden seguir su convención normal:

```text
orp-modal-enter-active
orp-modal-leave-active
```

Mantener el prefijo ORP.

---

# 68. Performance

Evitar:

* watchers innecesarios;
* timers;
* listeners globales permanentes;
* DOM queries repetidas;
* animaciones de layout;
* dependencias de overlay externas.

---

# 69. Dependencias

Esta fase debe ser posible sin instalar dependencias adicionales.

NO instalar automáticamente:

```text
Headless UI
Floating UI
Radix
Focus Trap
Bootstrap JS
Framework7
```

Si aparece una necesidad fuerte, documentarla antes.

---

# 70. Reusar Foundation

No duplicar estilos existentes de:

```text
Button
Card
Badge
Typography
Spacing
```

Modal y Sheet deben utilizar por ejemplo:

```html
<button class="orp-btn orp-btn--primary">
```

en vez de inventar:

```text
orp-modal-button
```

---

# 71. Ejemplo Modal

Debe ser posible:

```vue
<script setup>
import { ref } from 'vue'
import { OrpModal } from '@/orp-ui'

const open = ref(false)
</script>

<template>

    <button
        class="orp-btn orp-btn--primary"
        @click="open = true"
    >
        Abrir modal
    </button>

    <OrpModal
        v-model="open"
        title="Eliminar registro"
    >

        <p>
            Esta acción no se puede deshacer.
        </p>

        <template #footer>

            <button
                class="orp-btn orp-btn--ghost"
                @click="open = false"
            >
                Cancelar
            </button>

            <button
                class="orp-btn orp-btn--danger"
            >
                Eliminar
            </button>

        </template>

    </OrpModal>

</template>
```

---

# 72. Ejemplo Sheet

```vue
<script setup>
import { ref } from 'vue'
import { OrpSheet } from '@/orp-ui'

const actions = ref(false)
</script>

<template>

    <button
        class="orp-btn orp-btn--primary"
        @click="actions = true"
    >
        Contactar
    </button>

    <OrpSheet
        v-model="actions"
        title="Contacto"
    >

        <div class="orp-d-flex orp-flex-column orp-gap-3">

            <button
                class="orp-btn orp-btn--primary orp-btn--block"
            >
                WhatsApp
            </button>

            <button
                class="orp-btn orp-btn--secondary orp-btn--block"
            >
                Llamar
            </button>

        </div>

    </OrpSheet>

</template>
```

---

# 73. Ejemplo Tabs

```vue
<script setup>
import { ref } from 'vue'
import { OrpTabs } from '@/orp-ui'

const active = ref('profile')

const tabs = [
    {
        value: 'profile',
        label: 'Perfil'
    },
    {
        value: 'contact',
        label: 'Contacto'
    },
    {
        value: 'links',
        label: 'Enlaces'
    }
]
</script>

<template>

    <OrpTabs
        v-model="active"
        :items="tabs"
    />

    <section v-if="active === 'profile'">
        ...
    </section>

</template>
```

---

# 74. Ejemplo Form

```html
<div class="orp-field">

    <label
        class="orp-label"
        for="name"
    >
        Nombre
    </label>

    <input
        id="name"
        class="orp-input"
        type="text"
        placeholder="Tu nombre"
    >

    <div class="orp-help">
        Este nombre será público.
    </div>

</div>
```

---

# 75. Ejemplo error

```html
<div class="orp-field orp-field--error">

    <label
        class="orp-label"
        for="email"
    >
        Email
    </label>

    <input
        id="email"
        class="orp-input"
        type="email"
        aria-invalid="true"
        aria-describedby="email-error"
    >

    <div
        id="email-error"
        class="orp-error"
    >
        Ingresa un correo electrónico válido.
    </div>

</div>
```

---

# 76. Documentación

Documentar los componentes Vue con:

```text
Description
Usage
Props
Events
Slots
Accessibility
Examples
```

Especialmente:

```text
OrpTabs
OrpModal
OrpSheet
OrpSwitch
```

---

# 77. Slots Modal

Soportar:

```text
default
header
footer
```

No crear slots excesivamente específicos.

El slot `header` puede reemplazar el título predeterminado.

---

# 78. Slots Sheet

Soportar:

```text
default
header
footer
```

Mantener API consistente con Modal cuando sea razonable.

---

# 79. Slots Tabs

No son obligatorios inicialmente.

La API basada en:

```text
items
```

es suficiente.

Si aparece necesidad de tabs complejas con iconos, evaluar posteriormente soporte mediante slots.

---

# 80. Component consistency

Modal y Sheet deben compartir convenciones.

Por ejemplo:

```text
v-model
title
closeOnBackdrop
closeOnEscape
header slot
footer slot
```

No llamar una prop:

```text
dismissOnBackdrop
```

en uno y:

```text
closeOnOutsideClick
```

en otro.

---

# 81. Naming consistency

Utilizar siempre inglés en API técnica.

Ejemplo:

```text
modelValue
closeOnBackdrop
closeOnEscape
disabled
label
items
variant
```

La interfaz visible puede estar en cualquier idioma.

---

# 82. No overengineering

No implementar todavía:

```text
nested modals
nested sheets
modal stack manager
global overlay manager
route-driven modal
portal registry
gesture engine
dynamic focus trap framework
```

Resolver correctamente el caso común primero.

---

# 83. Criterios de calidad

Antes de terminar:

## Tabs

* funciona con `v-model`;
* accessible roles;
* mobile scroll;
* keyboard razonable.

## Modal

* open/close;
* backdrop;
* Escape;
* Teleport;
* body lock;
* restore focus;
* responsive.

## Sheet

* open/close;
* safe area;
* responsive;
* scroll interno;
* no drag todavía.

## Switch

* input checkbox real;
* keyboard;
* disabled;
* `v-model`.

## Forms

* labels;
* focus;
* disabled;
* error;
* help;
* mobile friendly.

---

# 84. No romper fases anteriores

No modificar APIs existentes de:

```text
orp-btn
orp-card
orp-app-bar
orp-bottom-nav
orp-avatar
orp-badge
orp-list
```

salvo que exista bug real.

Si se necesita cambiar algo:

1. explicar motivo;
2. comprobar impacto;
3. evitar breaking changes cuando sea posible.

---

# 85. Resultado esperado

Al finalizar entregar:

## Archivos creados

Listar nuevos archivos.

## Archivos modificados

Listar archivos existentes modificados.

## Vue components

Listar:

```text
OrpTabs
OrpModal
OrpSheet
OrpSwitch
```

## CSS components

Listar:

```text
orp-tabs
orp-modal
orp-sheet
orp-switch
orp-field
orp-label
orp-input
orp-textarea
orp-select
orp-help
orp-error
```

## Tokens

Listar nuevos tokens.

## Playground

Indicar cómo probar cada componente.

## Accessibility

Explicar brevemente:

```text
focus
keyboard
aria
scroll lock
Escape
```

## Conflictos

Reportar cualquier conflicto con:

```text
Bootstrap
Vue
Inertia
existing CSS
Vite
```

---

# 86. Alcance final de Parte 3

La Parte 3 termina exactamente cuando existan:

```text
Interactive
├── OrpTabs
├── OrpModal
├── OrpSheet
└── OrpSwitch

Forms
├── orp-field
├── orp-label
├── orp-input
├── orp-textarea
├── orp-select
├── orp-help
└── orp-error
```

y estén integrados en el playground.

NO continuar automáticamente con Parte 4.

---

# Regla final

ORP UI ya comienza a tener JavaScript en esta fase.

Eso no significa que cada componente futuro deba utilizar Vue.

Mantener siempre la regla:

```text
Visual simple
→ HTML + LESS
```

```text
Estado / interacción reutilizable
→ Vue
```

```text
Comportamiento complejo especializado
→ evaluar dependencia existente
```

Priorizar:

```text
semántica
accesibilidad
mobile-first
bajo acoplamiento
consistencia
simplicidad
```

sobre cantidad de componentes.
