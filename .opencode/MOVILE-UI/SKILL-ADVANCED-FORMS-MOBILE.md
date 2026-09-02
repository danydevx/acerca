# SKILL — ORP UI / Parte 6: Advanced Forms & Mobile UX

## Objetivo

Extender ORP UI con controles de formulario avanzados y componentes de experiencia móvil de uso frecuente.

Esta fase implementa:

```text
Forms
├── Checkbox
├── Radio
├── Segmented Control
├── Search Input
├── File Input

Feedback
├── Progress
├── Spinner
├── Skeleton
└── Empty State

Mobile Actions
├── Action Sheet
└── Floating Action Button
```

Actualizar también el playground existente.

No implementar todavía:

```text
DatePicker
Calendar
Autocomplete complejo
Combobox
Rich Text
DataTable
TreeView
Stepper
Wizard
Drag & Drop
Virtual List
Charts
Command Palette
```

---

# 1. Principio de esta fase

Mantener la filosofía de ORP UI:

```text
Visual simple
→ HTML + LESS

Estado reutilizable
→ Vue

Interacción compleja
→ evaluar componente Vue

Problema especializado
→ evaluar dependencia madura
```

No crear wrappers Vue innecesarios.

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
OrpSegmented
OrpSearchInput
OrpFileInput
OrpActionSheet
```

---

# 3. Estructura sugerida

Agregar únicamente lo necesario:

```text
orp-ui/
│
├── components/
│   ├── OrpSegmented.vue
│   ├── OrpSearchInput.vue
│   ├── OrpFileInput.vue
│   └── OrpActionSheet.vue
│
├── less/
│   └── components/
│       ├── checkbox.less
│       ├── radio.less
│       ├── segmented.less
│       ├── search-input.less
│       ├── file-input.less
│       ├── progress.less
│       ├── spinner.less
│       ├── skeleton.less
│       ├── empty-state.less
│       ├── action-sheet.less
│       └── fab.less
```

Adaptar a la estructura real existente.

No reorganizar fases anteriores sin razón.

---

# 4. Checkbox

Crear componente visual CSS:

```text
orp-checkbox
```

Preferir input nativo:

```html
<label class="orp-checkbox">

    <input
        class="orp-checkbox__input"
        type="checkbox"
    >

    <span class="orp-checkbox__control"></span>

    <span class="orp-checkbox__label">
        Acepto los términos
    </span>

</label>
```

---

# 5. Checkbox estructura

Utilizar:

```text
orp-checkbox
orp-checkbox__input
orp-checkbox__control
orp-checkbox__label
orp-checkbox__description
```

Debe soportar:

```text
checked
unchecked
disabled
focus-visible
```

---

# 6. Checkbox indeterminate

Preparar estilos para:

```text
indeterminate
```

pero no crear lógica compleja.

Si la aplicación utiliza Vue:

```js
input.indeterminate = true
```

puede gestionarse externamente.

---

# 7. Checkbox accessibility

El input real no debe desaparecer mediante:

```css
display: none;
```

si eso elimina accesibilidad.

Puede ocultarse visualmente mediante técnica accesible.

Debe conservar:

```text
keyboard
focus
form semantics
screen reader support
```

---

# 8. Radio

Crear:

```text
orp-radio
```

Estructura:

```html
<label class="orp-radio">

    <input
        class="orp-radio__input"
        type="radio"
        name="plan"
        value="basic"
    >

    <span class="orp-radio__control"></span>

    <span class="orp-radio__label">
        Básico
    </span>

</label>
```

---

# 9. Radio estructura

Utilizar:

```text
orp-radio
orp-radio__input
orp-radio__control
orp-radio__label
orp-radio__description
```

Mantener apariencia consistente con Checkbox.

---

# 10. Radio groups

No crear automáticamente:

```text
OrpRadioGroup.vue
```

salvo que exista necesidad clara.

HTML nativo con:

```text
name
value
checked
```

es suficiente para muchos casos.

---

# 11. Segmented Control

Crear componente Vue:

```text
OrpSegmented.vue
```

Objetivo:

Permitir elegir una opción entre pocas alternativas.

Ejemplo:

```vue
<OrpSegmented
    v-model="view"
    :items="views"
/>
```

---

# 12. Segmented items

Ejemplo:

```js
const views = [
    {
        value: 'grid',
        label: 'Grid'
    },
    {
        value: 'list',
        label: 'Lista'
    }
]
```

---

# 13. Segmented API

Props:

```text
modelValue
items
disabled
fullWidth
```

Emitir:

```text
update:modelValue
change
```

No agregar props innecesarias.

---

# 14. Segmented CSS

Utilizar:

```text
orp-segmented
orp-segmented__item
orp-segmented__item--active
```

No usar:

```text
.active
```

global.

---

# 15. Segmented semantics

Dependiendo del caso, puede implementarse con:

```html
button
```

o radio buttons.

Preferir radio semantics cuando represente selección exclusiva dentro de un formulario.

Preferir buttons cuando controle únicamente vista/UI.

Documentar ambas posibilidades.

---

# 16. Segmented mobile

Debe funcionar especialmente bien en:

```text
320px
375px
430px
```

Cuando las labels sean demasiado largas:

* permitir truncado razonable;
* no comprimir hasta volverse ilegible.

No utilizarlo para diez opciones.

---

# 17. Search Input

Crear:

```text
OrpSearchInput.vue
```

porque tiene comportamiento reutilizable:

```text
search icon
clear button
v-model
Escape
```

---

# 18. Search Input uso

```vue
<OrpSearchInput
    v-model="search"
    placeholder="Buscar..."
/>
```

---

# 19. Search Input API

Props:

```text
modelValue
placeholder
disabled
clearable
autofocus
```

Emitir:

```text
update:modelValue
search
clear
```

---

# 20. Search Input estructura

Utilizar:

```text
orp-search
orp-search__icon
orp-search__input
orp-search__clear
```

---

# 21. Search Input semantics

Utilizar:

```html
<input type="search">
```

cuando sea apropiado.

No reemplazar comportamiento nativo sin necesidad.

---

# 22. Search clear

Cuando exista contenido y:

```text
clearable = true
```

mostrar botón accesible.

Ejemplo:

```html
<button
    type="button"
    aria-label="Limpiar búsqueda"
>
```

---

# 23. Search Escape

Cuando el input tenga focus y contenido:

```text
Escape
```

puede limpiar búsqueda.

No capturar Escape cuando no corresponda.

---

# 24. File Input

Crear:

```text
OrpFileInput.vue
```

porque puede simplificar:

```text
file selection
filename display
validation hooks
preview events
```

Sin embargo, mantener internamente:

```html
<input type="file">
```

nativo.

---

# 25. File Input API

Props:

```text
accept
multiple
disabled
label
help
maxSize
```

`maxSize` puede utilizarse para validación simple.

No implementar uploader completo.

---

# 26. File Input events

Emitir:

```text
change
invalid
```

Opcional:

```text
update:modelValue
```

solo si la API realmente utiliza `File` o `File[]`.

No serializar archivos.

---

# 27. File Input structure

Utilizar:

```text
orp-file
orp-file__input
orp-file__dropzone
orp-file__icon
orp-file__label
orp-file__help
orp-file__name
orp-file__error
```

---

# 28. File Input dropzone

Puede permitir:

```text
dragenter
dragover
drop
```

pero implementar solo drag & drop básico.

NO crear aún:

```text
sortable files
upload progress
multi-upload manager
chunk uploads
cloud upload
```

---

# 29. File Input mobile

No depender del drag & drop.

En móvil debe funcionar perfectamente mediante:

```text
tap
native picker
camera/gallery when browser supports accept
```

---

# 30. File validation

Puede validar:

```text
file size
accept MIME/type básico
```

No intentar hacer validación completa de seguridad en frontend.

La documentación debe aclarar que backend debe validar archivos.

---

# 31. Progress

Crear componente CSS:

```text
orp-progress
```

Puede apoyarse en:

```html
<progress>
```

si el styling requerido es viable.

Alternativamente estructura:

```html
<div
    class="orp-progress"
    role="progressbar"
    aria-valuenow="65"
    aria-valuemin="0"
    aria-valuemax="100"
>
    <div
        class="orp-progress__bar"
        style="width: 65%"
    ></div>
</div>
```

---

# 32. Progress variants

Crear:

```text
orp-progress--primary
orp-progress--success
orp-progress--warning
orp-progress--danger
```

No crear demasiadas variantes.

---

# 33. Progress size

Inicialmente:

```text
orp-progress--sm
orp-progress--md
```

Solo si aportan diferencia real.

---

# 34. Progress accessibility

Cuando represente progreso real:

utilizar:

```text
role="progressbar"
aria-valuenow
aria-valuemin
aria-valuemax
```

Cuando sea indeterminado:

omitir `aria-valuenow`.

---

# 35. Spinner

Crear:

```text
orp-spinner
```

Componente CSS puro.

Ejemplo:

```html
<span
    class="orp-spinner"
    aria-hidden="true"
></span>
```

Cuando represente loading:

acompañar con texto accesible.

Ejemplo:

```html
<span class="orp-sr-only">
    Cargando
</span>
```

---

# 36. Spinner sizes

Permitir:

```text
orp-spinner--sm
orp-spinner--md
orp-spinner--lg
```

---

# 37. Spinner reduced motion

Cuando:

```text
prefers-reduced-motion: reduce
```

reducir animación.

No dejar al usuario sin indicador visual.

Puede mostrarse estado estático.

---

# 38. Skeleton

Crear:

```text
orp-skeleton
```

CSS puro.

Uso:

```html
<div class="orp-skeleton orp-skeleton--text"></div>
```

---

# 39. Skeleton variants

Crear inicialmente:

```text
orp-skeleton--text
orp-skeleton--circle
orp-skeleton--rect
```

No generar decenas de tipos.

---

# 40. Skeleton sizing

Debe permitir estilos externos:

```html
<div
    class="orp-skeleton orp-skeleton--rect"
    style="height: 180px"
></div>
```

sin exigir prop Vue.

---

# 41. Skeleton animation

Usar shimmer o pulse ligero.

No hacer animaciones agresivas.

Respetar:

```text
prefers-reduced-motion
```

---

# 42. Skeleton accessibility

Skeleton es decorativo.

No llenar screen readers con bloques irrelevantes.

El contenedor que está cargando puede utilizar:

```text
aria-busy="true"
```

---

# 43. Empty State

Crear componente visual CSS:

```text
orp-empty
```

No necesita Vue inicialmente.

Estructura:

```html
<section class="orp-empty">

    <div class="orp-empty__media">
        ...
    </div>

    <h2 class="orp-empty__title">
        No hay resultados
    </h2>

    <p class="orp-empty__description">
        Intenta cambiar los filtros.
    </p>

    <div class="orp-empty__actions">
        ...
    </div>

</section>
```

---

# 44. Empty State use cases

Debe funcionar para:

```text
No data
No search results
No notifications
No files
No contacts
First-use state
```

No crear variantes específicas para cada caso.

---

# 45. Empty State icon independence

No instalar icon library.

Permitir:

```text
SVG
image
component
```

dentro de:

```text
orp-empty__media
```

---

# 46. Action Sheet

Crear:

```text
OrpActionSheet.vue
```

Aunque `OrpSheet` ya existe, ActionSheet tiene semántica más específica:

```text
lista de acciones rápidas
```

especialmente móvil.

---

# 47. ActionSheet vs Sheet

Mantener diferencia:

```text
OrpSheet
→ contenedor libre
```

```text
OrpActionSheet
→ grupo de acciones
```

No duplicar todo el código.

`OrpActionSheet` puede reutilizar internamente:

```text
OrpSheet
```

si esto mantiene API simple.

---

# 48. ActionSheet uso

```vue
<OrpActionSheet
    v-model="actionsOpen"
    :actions="actions"
/>
```

---

# 49. ActionSheet data

Ejemplo:

```js
const actions = [
    {
        value: 'edit',
        label: 'Editar'
    },
    {
        value: 'share',
        label: 'Compartir'
    },
    {
        value: 'delete',
        label: 'Eliminar',
        variant: 'danger'
    }
]
```

---

# 50. ActionSheet API

Props:

```text
modelValue
title
actions
cancelLabel
showCancel
closeOnSelect
```

Emitir:

```text
update:modelValue
select
cancel
```

---

# 51. ActionSheet structure

Utilizar:

```text
orp-action-sheet
orp-action-sheet__title
orp-action-sheet__group
orp-action-sheet__item
orp-action-sheet__item--danger
orp-action-sheet__cancel
```

---

# 52. ActionSheet touch

Cada acción debe tener touch target amplio.

Como referencia:

```text
mínimo aproximado 48px de alto
```

En este componente puede ser ligeramente mayor que el mínimo general.

---

# 53. ActionSheet accessibility

Las acciones deben utilizar:

```html
button
```

reales.

No:

```html
div
```

clickeables.

---

# 54. ActionSheet disabled

Permitir opcionalmente:

```js
{
    label: 'Editar',
    disabled: true
}
```

Debe renderizar:

```text
disabled
```

real.

---

# 55. ActionSheet icons

Permitir icon opcional solo si la API existente lo puede soportar sin acoplarse a librería.

No exigir iconos.

---

# 56. Floating Action Button

Crear CSS:

```text
orp-fab
```

Puede ser simplemente una especialización de IconButton.

Ejemplo:

```html
<button
    class="orp-fab"
    aria-label="Crear"
>
    +
</button>
```

---

# 57. FAB structure

Utilizar:

```text
orp-fab
orp-fab__icon
orp-fab__label
```

Puede soportar label extendido:

```html
<button class="orp-fab orp-fab--extended">
    <span class="orp-fab__icon">
        +
    </span>

    <span class="orp-fab__label">
        Crear
    </span>
</button>
```

---

# 58. FAB variants

Crear:

```text
orp-fab--primary
orp-fab--secondary
orp-fab--extended
```

No crear diez variantes.

---

# 59. FAB positioning

Crear modifiers opcionales:

```text
orp-fab--fixed
orp-fab--bottom-end
```

Si se implementa fixed:

respetar:

```text
safe-area-inset-bottom
safe-area-inset-right
```

---

# 60. FAB y BottomNav

Cuando exista:

```text
orp-bottom-nav--fixed
```

FAB debe poder colocarse por encima.

Utilizar tokens existentes:

```text
--orp-bottom-nav-height
```

Evitar valores mágicos duplicados.

---

# 61. FAB mobile first

En desktop sigue funcionando, pero está diseñado principalmente para interfaces móviles.

No debe convertirse automáticamente en botón enorme en desktop.

---

# 62. Nuevos tokens

Agregar únicamente los necesarios.

Ejemplo:

```less
@orp-control-size-sm: 32px;
@orp-control-size-md: 44px;
@orp-control-size-lg: 52px;

@orp-fab-size: 56px;

@orp-progress-height-sm: 4px;
@orp-progress-height-md: 8px;
```

No duplicar tokens existentes.

---

# 63. Form control consistency

Revisar que:

```text
Input
Select
Textarea
Switch
Checkbox
Radio
Search
File
```

compartan visualmente:

```text
border
focus ring
disabled state
font
radius
spacing
```

No deben parecer librerías diferentes.

---

# 64. Focus ring

Todo control debe reutilizar:

```text
--orp-ring
```

No crear focus colors distintos por componente.

---

# 65. Validation

Checkbox, Radio y FileInput deben poder integrarse con:

```text
orp-field--error
orp-error
```

existentes.

No crear:

```text
orp-checkbox-error
orp-file-error-text-v2
```

si ya existe un sistema de errores.

---

# 66. Form composition

Debe ser posible:

```html
<div class="orp-field orp-field--error">

    <label class="orp-label">
        Foto de perfil
    </label>

    ...

    <div class="orp-error">
        Archivo demasiado grande.
    </div>

</div>
```

---

# 67. Loading buttons

No crear todavía:

```text
OrpLoadingButton
```

Permitir composición:

```html
<button
    class="orp-btn orp-btn--primary"
    disabled
>

    <span class="orp-spinner orp-spinner--sm"></span>

    Guardando

</button>
```

Si hace falta spacing, reutilizar utilities existentes.

---

# 68. Button aria-busy

Cuando un botón esté realizando acción:

```html
<button
    aria-busy="true"
    disabled
>
```

cuando corresponda.

---

# 69. Loading states

Documentar tres patrones:

```text
Spinner
→ acción corta
```

```text
Progress
→ progreso medible
```

```text
Skeleton
→ carga estructural de contenido
```

No usar spinner para todo.

---

# 70. Skeleton composition

Ejemplo:

```html
<div class="orp-card">

    <div class="orp-card__body">

        <div
            class="
                orp-skeleton
                orp-skeleton--text
            "
        ></div>

        <div
            class="
                orp-skeleton
                orp-skeleton--text
            "
        ></div>

    </div>

</div>
```

No crear:

```text
OrpSkeletonCard
```

todavía.

---

# 71. Search debouncing

NO implementar debounce automáticamente dentro de:

```text
OrpSearchInput
```

porque la aplicación debe decidir:

```text
API search
local filtering
instant results
manual submit
```

Puede emitir cambios normalmente.

La aplicación puede aplicar debounce externamente.

---

# 72. SearchInput no conoce API

No hacer:

```js
fetch()
axios()
router.get()
```

dentro del componente.

Solo controlar UI.

---

# 73. FileInput no sube archivos

Regla obligatoria:

```text
OrpFileInput
```

NO hace:

```text
POST
upload
S3
Laravel Storage
Cloudinary
```

Solo selecciona y valida UI.

La aplicación controla upload.

---

# 74. ActionSheet no ejecuta acciones

No implementar:

```js
if action === delete → API delete
```

Emitir:

```text
select
```

y dejar que la aplicación actúe.

---

# 75. ActionSheet reusable logic

Si reutiliza `OrpSheet`:

no duplicar:

```text
Escape
Backdrop
Scroll lock
Focus restore
Teleport
Safe areas
```

---

# 76. Reduced motion

Revisar:

```text
Spinner
Skeleton
ActionSheet
FAB
Progress
```

Respetar:

```text
prefers-reduced-motion
```

---

# 77. Spinner animation token

Utilizar tokens de motion existentes:

```text
--orp-duration-*
--orp-ease-standard
```

cuando tenga sentido.

El spinner puede tener duración específica si la animación continua lo requiere.

---

# 78. Skeleton theme

Skeleton debe verse correctamente en:

```text
Light
Dark
Custom themes
```

No utilizar:

```text
#eee
#ddd
```

hardcoded sin tokens.

Crear semantic token si es realmente necesario:

```text
--orp-skeleton
--orp-skeleton-highlight
```

---

# 79. Theme audit

Probar todos los nuevos componentes en:

```text
light
dark
```

Especialmente:

```text
Checkbox
Radio
Search
File
Progress
Skeleton
ActionSheet
FAB
```

---

# 80. Responsive testing

Probar:

```text
320px
375px
390px
430px
768px
1024px
```

Prioridad:

```text
Segmented labels
File Input
Action Sheet
FAB
Search
```

---

# 81. Touch testing

Probar físicamente o simular:

```text
Checkbox
Radio
Segmented
Search clear
File picker
ActionSheet actions
FAB
```

No depender de hover.

---

# 82. Keyboard testing

Probar:

```text
Tab
Shift+Tab
Space
Enter
Escape
Arrow keys cuando aplique
```

Especialmente:

```text
Checkbox
Radio
Segmented
Search
ActionSheet
```

---

# 83. Native form behavior

Preservar comportamiento nativo siempre que sea posible.

Especialmente:

```text
checkbox
radio
search
file
```

No reinventar controles solo para hacerlos visualmente distintos.

---

# 84. Utility audit

Antes de crear utility nueva:

revisar si ya existe.

No agregar:

```text
orp-rounded-56
orp-size-44
orp-top-17
```

solo para resolver un componente.

Preferir componente + token.

---

# 85. Vue components públicos

Actualizar:

```text
index.js
```

con:

```js
export { default as OrpSegmented } from './components/OrpSegmented.vue'
export { default as OrpSearchInput } from './components/OrpSearchInput.vue'
export { default as OrpFileInput } from './components/OrpFileInput.vue'
export { default as OrpActionSheet } from './components/OrpActionSheet.vue'
```

No exportar componentes CSS como Vue.

---

# 86. Public API

La Parte 6 debe mantener claramente:

```text
CSS-only
```

para:

```text
Checkbox
Radio
Progress
Spinner
Skeleton
Empty State
FAB
```

Y Vue para:

```text
Segmented
Search Input
File Input
Action Sheet
```

si la implementación realmente necesita comportamiento.

---

# 87. CSS classes nuevas

Añadir:

```text
orp-checkbox
orp-radio
orp-segmented
orp-search
orp-file
orp-progress
orp-spinner
orp-skeleton
orp-empty
orp-action-sheet
orp-fab
```

Todas dentro del namespace ORP.

---

# 88. Playground

Actualizar:

```text
OrpPlayground.vue
```

Agregar nuevas categorías:

```text
Advanced Forms
Loading
Empty States
Mobile Actions
```

---

# 89. Checkbox playground

Mostrar:

```text
Unchecked
Checked
Disabled
With description
Error
```

---

# 90. Radio playground

Mostrar:

```text
2 options
3 options
Selected
Disabled
With description
```

---

# 91. Segmented playground

Mostrar:

```text
2 items
3 items
Full width
With active state
Long labels
```

---

# 92. Search playground

Mostrar:

```text
Empty
With text
Clearable
Disabled
Search event
```

---

# 93. FileInput playground

Mostrar:

```text
Image
PDF
Multiple
Max size
Invalid file
Selected filename
```

No realizar uploads reales.

---

# 94. Progress playground

Mostrar:

```text
25%
50%
75%
100%
Indeterminate si se implementa
```

---

# 95. Spinner playground

Mostrar:

```text
Small
Medium
Large
Inside button
```

---

# 96. Skeleton playground

Mostrar:

```text
Text
Avatar
Card
Image placeholder
```

Construir composiciones usando clases, no nuevos componentes.

---

# 97. Empty State playground

Mostrar:

```text
No results
First item
Error-like empty state
With CTA
```

---

# 98. ActionSheet playground

Mostrar:

```text
Basic
With destructive action
With cancel
Disabled action
Long labels
```

---

# 99. FAB playground

Mostrar:

```text
Default
Secondary
Extended
Fixed
With BottomNav
```

---

# 100. Documentation

Crear documentación para:

```text
Checkbox
Radio
Segmented
SearchInput
FileInput
Progress
Spinner
Skeleton
EmptyState
ActionSheet
FAB
```

---

# 101. Documentar cuándo usar cada uno

Especialmente:

```text
Tabs vs Segmented
Sheet vs ActionSheet
Button vs FAB
Spinner vs Progress vs Skeleton
```

Esto evita uso inconsistente dentro de aplicaciones.

---

# 102. Tabs vs Segmented

Documentar:

```text
Tabs
→ cambia secciones/contenido
```

```text
Segmented
→ selecciona modo/opción pequeña
```

Ejemplo:

```text
Tabs:
Perfil | Enlaces | Galería

Segmented:
Grid | Lista
```

---

# 103. Sheet vs ActionSheet

```text
Sheet
→ contenido libre
```

```text
ActionSheet
→ lista breve de acciones
```

---

# 104. Button vs FAB

```text
Button
→ acciones dentro del flujo
```

```text
FAB
→ acción primaria flotante de una pantalla
```

No colocar múltiples FAB sin una razón fuerte.

---

# 105. Loading guidance

Documentar:

```text
Spinner
→ espera corta
```

```text
Progress
→ porcentaje/proceso medible
```

```text
Skeleton
→ contenido cuya estructura se conoce
```

---

# 106. Accessibility audit

Antes de finalizar revisar:

```text
labels
keyboard
native inputs
aria
focus
disabled
loading semantics
touch targets
reduced motion
```

---

# 107. No breaking changes

No modificar APIs anteriores salvo bug.

Especialmente:

```text
OrpSheet
OrpModal
OrpTabs
OrpSwitch
OrpDropdown
OrpDrawer
```

---

# 108. Build

Ejecutar el build existente.

Verificar que nuevos componentes:

```text
compile
import correctly
tree-shake
```

cuando aplique.

---

# 109. Bundle growth

Comparar aproximadamente crecimiento en:

```text
CSS
JS
```

La Parte 6 no debería introducir dependencias nuevas.

Reportar crecimiento relevante.

---

# 110. Dependencias

No instalar automáticamente:

```text
file upload libraries
drag/drop libraries
form frameworks
validation frameworks
icon packs
animation libraries
```

Esta fase debe poder resolverse con:

```text
Vue
HTML
CSS/LESS
browser APIs
```

---

# 111. Criterios de calidad

Antes de terminar verificar:

## Checkbox

* native input;
* keyboard;
* disabled;
* focus.

## Radio

* group semantics;
* keyboard;
* native behavior.

## Segmented

* `v-model`;
* mobile-friendly;
* selection accessible.

## Search

* native search input;
* clear;
* keyboard;
* no API coupling.

## FileInput

* native picker;
* size validation;
* accept;
* no upload coupling.

## Progress

* ARIA;
* theme;
* percentage.

## Spinner

* reduced motion;
* accessible loading pattern.

## Skeleton

* dark mode;
* reduced motion;
* decorative semantics.

## Empty State

* semantic content;
* actions reusable.

## ActionSheet

* reuse Sheet behavior;
* touch;
* focus;
* accessibility.

## FAB

* touch;
* safe area;
* BottomNav coexistence.

---

# 112. Resultado esperado

Al finalizar entregar:

## Archivos creados

Lista completa.

## Archivos modificados

Lista.

## Nuevos componentes Vue

```text
OrpSegmented
OrpSearchInput
OrpFileInput
OrpActionSheet
```

## Nuevos CSS components

```text
orp-checkbox
orp-radio
orp-segmented
orp-search
orp-file
orp-progress
orp-spinner
orp-skeleton
orp-empty
orp-action-sheet
orp-fab
```

## Nuevos tokens

Listar únicamente tokens realmente agregados.

## Playground

Indicar ejemplos disponibles.

## Accessibility

Explicar pruebas realizadas.

## Themes

Confirmar funcionamiento light/dark.

## Build

Indicar resultado.

## Bundle

Reportar cambios aproximados si están disponibles.

## Conflicts

Reportar conflictos encontrados.

---

# 113. Alcance final Parte 6

La Parte 6 termina cuando estén funcionales:

```text
Advanced Forms
├── Checkbox
├── Radio
├── Segmented Control
├── Search Input
└── File Input

Loading & Feedback
├── Progress
├── Spinner
├── Skeleton
└── Empty State

Mobile Actions
├── Action Sheet
└── FAB
```

No continuar automáticamente con Parte 7.

---

# Regla final

ORP UI ya tiene suficientes primitives para construir una aplicación móvil o SaaS moderna.

A partir de esta fase, agregar componentes debe responder a necesidades reales.

No perseguir una checklist de Bootstrap, Framework7 o shadcn.

La prioridad sigue siendo:

```text
semantic HTML
+
mobile-first
+
LESS
+
BEM
+
CSS Custom Properties
+
Vue only when useful
```

Mantener ORP UI pequeño, identificable y fácil de mantener:

```text
orp-
@orp-
--orp-
Orp*
```
