# SKILL — ORP UI / Parte 14: Forms Foundation Audit & Validation UX

## Objetivo

Consolidar el sistema de formularios de ORP UI para que todos los controles existentes compartan una misma arquitectura visual, semántica y de validación.

Auditar y normalizar:

```text
Forms
├── Field
├── Label
├── Help Text
├── Error Text
├── Required / Optional state
├── Input
├── Textarea
├── Select
├── Checkbox
├── Radio
├── Switch
├── Search Input
├── File Input
├── Segmented Control
├── Validation states
├── Field Groups
└── Form Layout patterns
```

Esta fase debe resolver:

```text
consistency
validation UX
accessibility
error messaging
required state
disabled state
read-only state
mobile usability
composition
```

sin acoplar ORP UI a:

```text
Laravel validation
Inertia forms
VeeValidate
Yup
Zod
Formik
backend responses
```

---

# 1. Principio principal

ORP UI representa el estado de un formulario.

La aplicación decide si ese estado es válido.

Mantener separación:

```text
ORP UI
→ visual state + semantics + accessibility

Application
→ validation rules + backend errors + form submission
```

Ejemplo:

```html
<div class="orp-field orp-field--invalid">

    <label
        class="orp-field__label"
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
        class="orp-field__error"
    >
        Ingresa un correo válido.
    </div>

</div>
```

ORP UI no decide por qué el correo es inválido.

---

# 2. Namespace

Mantener:

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
Orp*
```

No crear clases globales como:

```text
.form-control
.form-label
.invalid
.is-invalid
```

---

# 3. Audit first

Antes de agregar nuevas clases:

auditar implementación existente de:

```text
Input
Textarea
Select
Checkbox
Radio
Switch
SearchInput
FileInput
Segmented
```

Revisar:

```text
label
help
error
border
focus
disabled
required
invalid
spacing
font
height
icons
ARIA
```

Identificar inconsistencias antes de modificar.

---

# 4. Field primitive

Crear o consolidar:

```text
orp-field
```

Debe ser el contenedor genérico de un control.

Estructura recomendada:

```text
orp-field
├── orp-field__label
├── control
├── orp-field__help
└── orp-field__error
```

---

# 5. Field example

```html
<div class="orp-field">

    <label
        for="name"
        class="orp-field__label"
    >
        Nombre
    </label>

    <input
        id="name"
        class="orp-input"
        type="text"
    >

    <div class="orp-field__help">
        Escribe tu nombre completo.
    </div>

</div>
```

---

# 6. Field must be control-agnostic

`orp-field` debe funcionar con:

```text
Input
Textarea
Select
Checkbox
Radio
Switch
SearchInput
FileInput
Segmented Control
```

No crear:

```text
orp-input-field
orp-select-field
orp-checkbox-field
```

si no existe una necesidad real.

---

# 7. Field spacing

Usar spacing tokens existentes.

Ejemplo conceptual:

```less
.orp-field {
    display: grid;
    gap: var(--orp-space-2);
}
```

No hardcodear márgenes independientes en cada control.

---

# 8. Field label

Crear:

```text
orp-field__label
```

Debe utilizar:

```text
semantic foreground
typography tokens
appropriate font weight
```

---

# 9. Label relationship

Siempre preferir:

```html
<label for="field-id">
```

sobre labels visuales sin asociación.

---

# 10. No placeholder as label

Placeholder NO sustituye label.

Incorrecto:

```html
<input placeholder="Email">
```

sin label accesible.

---

# 11. Visually hidden label

Si diseño no muestra label:

permitir patrón con utility accesible existente.

Ejemplo:

```html
<label
    for="search"
    class="orp-visually-hidden"
>
    Buscar
</label>
```

Si `orp-visually-hidden` no existe, evaluar crearla como utility de accesibilidad.

---

# 12. Required state

Definir convención visual para campos requeridos.

Ejemplo:

```html
<label class="orp-field__label">

    Nombre

    <span
        class="orp-field__required"
        aria-hidden="true"
    >
        *
    </span>

</label>
```

---

# 13. Required semantics

El input real debe usar:

```html
required
```

cuando la validación HTML nativa aplica.

El asterisco es solo visual.

---

# 14. Required accessibility

Si `required` no puede usarse por alguna razón:

considerar:

```html
aria-required="true"
```

pero no duplicar ARIA si `required` ya es suficiente.

---

# 15. Optional state

Permitir:

```text
orp-field__optional
```

Ejemplo:

```html
<span class="orp-field__optional">
    Opcional
</span>
```

---

# 16. Required vs Optional strategy

Elegir una convención y documentarla.

Ejemplo recomendado:

```text
Required fields
→ marker *

Optional fields
→ no marker
```

o:

```text
Required
→ no visual marker if most fields required
Optional
→ explicit "Opcional"
```

No mezclar patrones arbitrariamente.

---

# 17. Help text

Crear:

```text
orp-field__help
```

Ejemplo:

```html
<div
    id="username-help"
    class="orp-field__help"
>
    Entre 3 y 20 caracteres.
</div>
```

---

# 18. Help semantics

Conectar mediante:

```html
aria-describedby="username-help"
```

si ayuda es relevante para comprender el campo.

---

# 19. Error text

Crear:

```text
orp-field__error
```

Debe usar:

```text
--orp-danger
```

o token semántico equivalente.

---

# 20. Error placement

Default:

```text
directly below control
```

No mostrar error lejos del campo correspondiente.

---

# 21. Error semantics

Control inválido:

```html
aria-invalid="true"
```

Error:

```html
aria-describedby="email-error"
```

---

# 22. Error live announcement

No agregar:

```html
role="alert"
```

a todos los errores automáticamente.

Puede provocar demasiados anuncios simultáneos.

Para validación dinámica:

la aplicación decide estrategia live.

---

# 23. Multiple descriptions

Un campo puede tener:

```text
help
error
```

Ejemplo:

```html
aria-describedby="password-help password-error"
```

La aplicación debe actualizar según estado.

---

# 24. Field invalid modifier

Crear:

```text
orp-field--invalid
```

si aporta control visual.

Ejemplo:

```html
<div class="orp-field orp-field--invalid">
```

---

# 25. Control invalid state

Los controles también pueden responder a:

```text
aria-invalid="true"
```

Preferir selectores accesibles cuando sea viable:

```less
.orp-input[aria-invalid="true"] {
    ...
}
```

Esto reduce necesidad de duplicar clases.

---

# 26. Preferred invalid strategy

Permitir ambas vías:

```text
aria-invalid
orp-field--invalid
```

pero evitar exigir:

```text
orp-input--invalid
orp-select--invalid
orp-textarea--invalid
```

en cada componente si no hace falta.

---

# 27. Valid state

NO mostrar verde automáticamente por campo válido.

La validación positiva constante puede generar ruido visual.

---

# 28. Success validation

Si existe necesidad:

permitir:

```text
orp-field--valid
```

pero no usar por default.

---

# 29. Warning state

No agregar validation warning universal a todos los controles si no existe necesidad.

Error/invalid es prioritario.

---

# 30. Input foundation

Auditar:

```text
orp-input
```

Debe cubrir:

```text
text
email
password
number
tel
url
date native
time native
```

sin estilos rotos.

---

# 31. Input height

Usar token consistente.

Posible:

```text
--orp-control-height
```

si todavía no existe.

Referencia:

```text
44px - 48px
```

para default mobile-friendly.

---

# 32. Control tokens

Evaluar consolidar:

```text
--orp-control-height
--orp-control-padding-inline
--orp-control-border
--orp-control-background
--orp-control-foreground
--orp-control-placeholder
```

solo si realmente reducen duplicación.

---

# 33. Input base

Referencia conceptual:

```less
.orp-input {
    inline-size: 100%;
    min-inline-size: 0;

    border:
        1px solid
        var(--orp-input);

    border-radius:
        var(--orp-radius-md);

    background:
        var(--orp-surface);

    color:
        var(--orp-foreground);
}
```

---

# 34. Focus state

Todos los controles deben compartir lenguaje de focus.

Usar:

```text
--orp-ring
```

Ejemplo:

```less
.orp-input:focus-visible {
    outline:
        2px solid
        var(--orp-ring);

    outline-offset: 2px;
}
```

Si sistema actual usa box-shadow, mantener consistencia.

---

# 35. Avoid removing outline blindly

No usar:

```css
outline: none;
```

sin reemplazo visible.

---

# 36. Placeholder

Usar token:

```text
--orp-muted-foreground
```

o control-specific token si existe.

No hacer placeholder demasiado claro.

---

# 37. Disabled input

Debe verse claramente disabled.

Ejemplo:

```text
lower contrast
different surface
not-allowed cursor optional
```

pero mantener legibilidad.

---

# 38. Disabled semantics

Usar atributo:

```html
disabled
```

No solo clase visual.

---

# 39. Read-only state

Auditar:

```html
readonly
```

Debe diferenciarse de disabled.

Readonly:

```text
still readable
still focusable
may be selectable
```

---

# 40. Readonly styling

Puede usar surface muted sutil.

No parecer completamente deshabilitado.

---

# 41. Autofill

Auditar browser autofill.

Especialmente Chrome/Safari.

No dejar texto ilegible por estilos automáticos.

---

# 42. Number input

No esconder automáticamente spinners nativos.

Solo si diseño lo requiere explícitamente.

---

# 43. Date/time inputs

No construir DatePicker custom.

Estilizar inputs nativos de forma razonable.

---

# 44. Password inputs

No implementar show/hide password automáticamente en primitive CSS.

Si ya existe componente interactivo:

auditar aparte.

---

# 45. Input prefixes/suffixes

Evaluar primitive:

```text
orp-input-group
```

solo si existe necesidad repetida.

---

# 46. Input Group

Si se implementa:

```text
orp-input-group
orp-input-group__prefix
orp-input-group__control
orp-input-group__suffix
```

Debe servir para:

```text
icon
currency symbol
domain prefix
action button
```

sin business logic.

---

# 47. Input Group example

```html
<div class="orp-input-group">

    <span class="orp-input-group__prefix">
        $
    </span>

    <input
        class="orp-input orp-input-group__control"
        type="number"
    >

</div>
```

---

# 48. Input Group icons

Puede usar Bootstrap Icons.

No depender de ellos.

---

# 49. Input Group buttons

Si suffix es acción:

usar botón real.

Ejemplo:

```html
<button
    type="button"
    class="orp-icon-btn"
    aria-label="Mostrar contraseña"
>
```

---

# 50. Textarea

Auditar:

```text
orp-textarea
```

Debe compartir:

```text
border
radius
focus
disabled
invalid
placeholder
```

con Input.

---

# 51. Textarea resize

Default recomendado:

```css
resize: vertical;
```

No bloquear resize sin razón.

---

# 52. Textarea minimum height

Usar valor razonable.

No hardcodear demasiado grande.

---

# 53. Autosize

NO implementar autosize JS en esta fase.

---

# 54. Select

Auditar:

```text
orp-select
```

Preferir `<select>` nativo.

---

# 55. Native select

No reemplazar automáticamente por custom select.

Nativo ofrece:

```text
keyboard
mobile picker
accessibility
low JS
```

---

# 56. Select arrow

Puede personalizarse visualmente con CSS.

No eliminar usabilidad nativa.

---

# 57. Select invalid

Debe responder a:

```html
aria-invalid="true"
```

igual que Input.

---

# 58. Select disabled

Usar atributo nativo.

---

# 59. Multiple select

No optimizar diseño para `<select multiple>` si no existe uso.

Pero no romperlo deliberadamente.

---

# 60. Checkbox

Auditar:

```text
orp-checkbox
```

Estructura recomendada:

```text
orp-checkbox
├── native input
├── visual control
└── content
    ├── label
    └── description
```

---

# 61. Checkbox native semantics

El `<input type="checkbox">` debe seguir existiendo.

No recrear checkbox únicamente con divs.

---

# 62. Checkbox label click

Toda área razonable de label debe ser clickeable.

---

# 63. Checkbox description

Permitir:

```text
orp-checkbox__description
```

para texto secundario.

---

# 64. Checkbox invalid

Si grupo es inválido:

mostrar error asociado al field/group.

No colorear cada checkbox innecesariamente.

---

# 65. Checkbox group

Crear:

```text
orp-field-group
```

o primitive equivalente para grupos de controles.

---

# 66. Field Group

Objetivo:

Agrupar controles relacionados.

Ejemplo:

```html
<fieldset class="orp-field-group">

    <legend class="orp-field-group__legend">
        Preferencias
    </legend>

    <div class="orp-stack orp-stack--3">
        ...
    </div>

</fieldset>
```

---

# 67. Prefer fieldset

Para Checkbox/Radio groups:

usar:

```text
fieldset
legend
```

cuando semánticamente corresponde.

---

# 68. Field Group classes

Posibles:

```text
orp-field-group
orp-field-group__legend
orp-field-group__help
orp-field-group__error
```

---

# 69. Radio

Auditar:

```text
orp-radio
```

Misma filosofía que Checkbox.

---

# 70. Radio groups

Siempre que sea una única pregunta con múltiples opciones:

preferir:

```html
<fieldset>
    <legend>
```

---

# 71. Radio keyboard

Con inputs nativos:

browser ya resuelve buena parte de navegación.

No reemplazar comportamiento innecesariamente.

---

# 72. Switch

Auditar componente/control:

```text
orp-switch
```

---

# 73. Switch semantics

Preferir checkbox nativo debajo.

Si usa role switch:

```html
role="switch"
```

solo si implementación cumple comportamiento esperado.

---

# 74. Switch purpose

Switch representa:

```text
immediate binary setting
```

Checkbox representa:

```text
selection / agreement / option
```

Documentar diferencia.

---

# 75. Switch labels

Siempre debe tener label accesible.

---

# 76. Search Input

Auditar:

```text
OrpSearchInput
```

Debe integrarse visualmente con `orp-field`.

---

# 77. Search Input labels

Placeholder:

```text
Buscar...
```

no sustituye label accesible.

---

# 78. Search clear button

Si `clearable`:

usar button real con:

```text
aria-label
```

---

# 79. Search Escape

Si ya existe:

```text
Escape → clear
```

documentarlo.

No hacer que Escape además cierre overlays padres accidentalmente sin coordinación.

---

# 80. File Input

Auditar:

```text
OrpFileInput
```

Debe integrarse con Field/error/help.

---

# 81. File validation

Frontend puede detectar:

```text
size
accept
```

como ayuda UX.

Backend debe seguir validando.

---

# 82. File invalid event

Mantener:

```text
invalid
```

si ya forma parte de API.

---

# 83. File names

Mostrar nombre(s) seleccionados de forma legible.

No hacer parsing de negocio.

---

# 84. File drag and drop

Si existe:

asegurar que click/keyboard sigan funcionando.

Drag-and-drop es enhancement.

---

# 85. Segmented Control

Auditar:

```text
OrpSegmented
```

Debe alinearse visualmente con controles.

---

# 86. Segmented semantics

Usar:

```text
radio semantics
```

si representa selección exclusiva dentro de formulario.

Usar:

```text
buttons
```

si cambia vista/interfaz.

No mezclar sin criterio.

---

# 87. Segmented invalid

Si forma parte de formulario obligatorio:

error pertenece al Field Group.

---

# 88. Form Control consistency

Todos deben compartir al menos:

```text
font size
focus ring
disabled opacity/contrast
border color
radius family
error color
spacing rhythm
```

---

# 89. Same exact appearance not required

Checkbox y Textarea no deben verse idénticos.

Consistency significa:

```text
same design language
```

no:

```text
same rectangle everywhere
```

---

# 90. Control sizes

Auditar tamaños existentes:

```text
sm
md
lg
```

No agregar tamaños a todo automáticamente.

---

# 91. Default size

`md` puede ser default implícito.

---

# 92. Small controls

No hacer `sm` menor a touch target cuando se use en mobile para acciones importantes.

---

# 93. Large controls

Usar solo donde aporta.

---

# 94. Form layout

No crear un sistema gigante específico para forms.

Reutilizar:

```text
orp-stack
orp-grid
orp-cluster
orp-section
orp-split
```

---

# 95. Simple vertical form

Patrón:

```html
<form>

    <div class="orp-stack orp-stack--4">

        <div class="orp-field">
            ...
        </div>

        <div class="orp-field">
            ...
        </div>

    </div>

</form>
```

---

# 96. Responsive form

Usar:

```text
orp-grid
orp-grid--auto
```

cuando múltiples campos pueden compartir fila.

---

# 97. Form Grid example

```html
<div
    class="
        orp-grid
        orp-grid--auto
    "
    style="--orp-grid-min: 16rem"
>

    <div class="orp-field">
        ...
    </div>

    <div class="orp-field">
        ...
    </div>

</div>
```

---

# 98. Full-width field

Usar:

```text
orp-grid-span-full
```

para campos como:

```text
Textarea
File Input
```

si es apropiado.

---

# 99. Form actions

Usar:

```text
orp-cluster
```

para botones.

Ejemplo:

```html
<div
    class="
        orp-cluster
        orp-cluster--3
    "
>
```

---

# 100. Mobile actions

En móvil puede ser mejor:

```text
buttons block/full width
```

pero no imponerlo globalmente.

---

# 101. Form Section

Para formularios largos:

componer:

```text
orp-section
```

No crear:

```text
orp-form-section
```

si Section ya resuelve.

---

# 102. Fieldset styling

No eliminar border de fieldset globalmente fuera de namespace.

---

# 103. Form reset

Auditar reset actual.

No aplicar CSS destructivo a:

```text
input
select
textarea
button
fieldset
legend
```

globalmente sin namespace/control.

---

# 104. Browser appearance

Usar:

```css
appearance: none;
```

solo cuando existe implementación visual de reemplazo.

---

# 105. Validation architecture

ORP debe admitir errores provenientes de:

```text
client validation
server validation
HTML validation
custom business rules
```

sin saber su origen.

---

# 106. Laravel example

Documentar como integración, no dependencia.

Ejemplo conceptual:

```vue
<div
    class="orp-field"
    :class="{
        'orp-field--invalid': form.errors.email
    }"
>
```

Esto puede vivir en docs de integración.

No en core.

---

# 107. Inertia example

También puede documentarse externamente:

```vue
<input
    class="orp-input"
    :aria-invalid="Boolean(form.errors.email)"
>
```

No importar Inertia en ORP UI.

---

# 108. Validation libraries

No agregar adapters para:

```text
VeeValidate
Zod
Yup
```

en esta fase.

---

# 109. Error source agnostic

API visual debe ser simplemente:

```text
invalid
error message
description
```

---

# 110. Server errors

Errores backend suelen aparecer después de submit.

ORP debe soportarlos igual que error frontend.

---

# 111. Error persistence

No ocultar error automáticamente por timeout.

Errores de formulario son persistentes hasta resolverlos.

---

# 112. Error color

Usar:

```text
--orp-danger
```

pero revisar contraste.

---

# 113. Error icon

No requerir icono.

Si se usa:

Bootstrap Icons opcional:

```text
bi-exclamation-circle
```

---

# 114. Invalid border

No usar borde extremadamente grueso.

Sutil pero claro.

---

# 115. Multiple error signals

Idealmente:

```text
border/state
+
error text
```

No depender solo de color.

---

# 116. Form-level error

Definir patrón para error global.

Usar:

```text
orp-alert
```

Ejemplo:

```html
<div class="orp-alert orp-alert--danger">
    Revisa los campos marcados.
</div>
```

No crear:

```text
orp-form-error-summary
```

todavía salvo necesidad.

---

# 117. Error Summary

Puede documentarse composición:

```text
Alert
+
links to fields
```

pero no necesita componente propio en esta fase.

---

# 118. Success message

Después de submit:

usar:

```text
orp-alert--success
```

o Toast según contexto.

No formar parte de Field.

---

# 119. Form loading

Para submit:

botón puede quedar disabled/loading según API existente.

No bloquear formulario entero automáticamente.

---

# 120. Busy state

Form puede usar:

```html
aria-busy="true"
```

cuando corresponda.

---

# 121. Spinner in submit

Componer:

```text
orp-spinner
```

dentro de Button si implementación lo soporta.

No crear spinner exclusivo.

---

# 122. Disabled while submitting

La aplicación decide qué controles se deshabilitan.

ORP solo muestra estado.

---

# 123. Autocomplete

No deshabilitar:

```html
autocomplete
```

globalmente.

---

# 124. Inputmode

Documentar uso correcto:

```text
numeric
decimal
tel
email
url
```

para mobile keyboards.

---

# 125. Type choice

Preferir tipos nativos adecuados:

```html
type="email"
type="tel"
type="url"
```

cuando correspondan.

---

# 126. Mobile form UX

Revisar:

```text
control height
keyboard
zoom
spacing
touch targets
fixed bottom actions
safe area
```

---

# 127. iOS zoom

Evitar inputs con font-size demasiado pequeño.

Referencia:

```text
16px
```

para prevenir zoom automático no deseado en Safari iOS.

---

# 128. Touch targets

Checkbox/Radio/Switch deben tener área clickeable suficientemente grande aunque indicador visual sea pequeño.

---

# 129. Form inside Modal

Probar:

```text
Input
Textarea
Select
Search
File
```

dentro de `OrpModal`.

---

# 130. Form inside Sheet

Probar teclado virtual y scrolling.

---

# 131. Form inside Drawer

Probar focus y layout.

---

# 132. Form inside Popover

Solo casos pequeños.

No diseñar formularios enormes dentro de Popover.

---

# 133. Sticky form actions

NO implementar componente específico.

AppShell/Sheet puede resolver regiones fixed/sticky si hace falta.

---

# 134. Character count

No implementar automáticamente.

Aplicación puede componer:

```text
orp-meta
orp-text-muted
```

---

# 135. Password strength

NO implementar.

Eso es lógica especializada.

---

# 136. Input mask

NO implementar.

Puede ser integración externa futura.

---

# 137. Currency input

NO implementar formatting.

Aplicación controla valor y locale.

---

# 138. Phone mask

NO implementar.

---

# 139. Date picker

NO implementar custom DatePicker.

Seguir usando native input o futura integración especializada.

---

# 140. Autocomplete / Combobox

NO implementar todavía.

Es componente interactivo complejo.

---

# 141. Multi-select custom

NO implementar.

---

# 142. Rich text

NO implementar.

---

# 143. Color picker

No implementar custom.

Native:

```html
input type="color"
```

puede funcionar si app lo desea.

---

# 144. Range

Auditar `input[type="range"]` solo si ya se usa.

No convertirlo en nuevo componente grande.

---

# 145. Hidden input

No estilizar.

---

# 146. Form semantics

Usar:

```text
form
fieldset
legend
label
button
```

correctamente.

No reemplazar semántica con divs.

---

# 147. Button type

Documentar:

```html
type="submit"
type="button"
type="reset"
```

No depender del default implícito dentro de formularios.

---

# 148. Reset button

No estilizar/comportarse distinto.

La app decide si usarlo.

---

# 149. Form submit

ORP no intercepta:

```text
submit
```

globalmente.

---

# 150. Prevent default

No debe existir dentro del framework salvo componente Vue que lo requiera internamente.

---

# 151. Native validation

ORP UI debe coexistir con Constraint Validation API.

No desactivar:

```text
required
min
max
pattern
```

---

# 152. Browser validation UI

No intentar reemplazar automáticamente tooltips nativos.

Aplicación puede usar `novalidate` si implementa validación propia.

---

# 153. `novalidate`

ORP UI no lo agrega automáticamente.

---

# 154. Accessible errors

Al submit con errores:

la aplicación debe poder mover focus a:

```text
first invalid field
```

pero ORP no debe hacerlo globalmente.

Puede documentarse.

---

# 155. Scroll to error

No implementar automáticamente.

---

# 156. IDs

No generar IDs en CSS primitives.

Vue components interactivos deben generar IDs estables cuando sea necesario.

---

# 157. Vue component IDs

Para Search/File/Segmented:

auditar IDs/labels/aria relationships.

---

# 158. Vue v-model consistency

Componentes Vue de forms deben usar:

```text
modelValue
update:modelValue
```

consistentemente.

---

# 159. Change events

Mantener:

```text
change
```

solo donde aporta.

No emitir cinco eventos redundantes por control.

---

# 160. Input events

No duplicar `update:modelValue` y eventos nativos innecesariamente.

---

# 161. Error props

No agregar `error` prop a todos los componentes si Field ya maneja error.

Preferir composition.

---

# 162. Component isolation

Ejemplo:

```vue
<OrpSearchInput
    v-model="query"
/>
```

puede vivir dentro:

```html
<div class="orp-field orp-field--invalid">
```

sin que SearchInput necesite conocer todo Field.

---

# 163. Field Vue component?

NO crear automáticamente:

```text
OrpField.vue
```

HTML + CSS suele ser suficiente.

---

# 164. Future OrpField

Solo evaluar si existe necesidad real de:

```text
automatic ids
aria-describedby wiring
error slot
help slot
```

pero no en esta fase.

---

# 165. Form composition beats configuration

Preferir:

```html
<div class="orp-field">
```

sobre APIs tipo:

```vue
<OrpField
    label="..."
    help="..."
    error="..."
    required
    size="..."
    layout="..."
>
```

si no hay beneficio claro.

---

# 166. Design tokens

Auditar si hacen falta tokens adicionales.

Posibles:

```text
--orp-control-height
--orp-control-padding-inline
--orp-control-background
--orp-control-foreground
--orp-control-placeholder
--orp-control-disabled-background
```

Solo agregar los que realmente eviten hardcodes.

---

# 167. Input token

Ya existe:

```text
--orp-input
```

Revisar si representa:

```text
border color
```

y documentarlo claramente.

No reutilizar ambiguamente para background.

---

# 168. Semantic naming

Si `--orp-input` es border:

considerar en futuro:

```text
--orp-control-border
```

pero evitar breaking change innecesario.

---

# 169. Theme compatibility

Todos los controles deben funcionar en:

```text
Light
Dark
Custom
```

---

# 170. Dark inputs

Revisar especialmente:

```text
background
placeholder
border
focus
disabled
autofill
native select
```

---

# 171. Custom themes

No hardcodear white/black dentro de controles.

---

# 172. Validation contrast

Danger state debe mantener contraste suficiente en dark.

---

# 173. Bootstrap coexistence

ORP Forms debe funcionar aunque una aplicación cargue Bootstrap.

No utilizar:

```text
form-control
form-select
form-check
input-group
is-invalid
```

---

# 174. Playground isolation

Playground de Forms debe usar únicamente:

```text
orp-*
```

y Bootstrap Icons opcionales.

No Bootstrap CSS.

---

# 175. CSS architecture

Organizar:

```text
less/
└── forms/
    ├── field.less
    ├── controls.less
    ├── input.less
    ├── textarea.less
    ├── select.less
    ├── checkbox.less
    ├── radio.less
    ├── switch.less
    ├── input-group.less
    └── validation.less
```

Adaptar si estructura actual ya agrupa forms de otra manera.

---

# 176. Avoid duplicated CSS

Si Input/Textarea/Select comparten:

```text
border
background
focus
disabled
invalid
```

crear mixin interno.

Ejemplo:

```text
.orp-control-base()
```

No crear clase pública innecesaria.

---

# 177. LESS mixins

Puede existir:

```text
.orp-control-base()
.orp-control-focus()
.orp-control-disabled()
.orp-control-invalid()
```

si simplifica mantenimiento.

---

# 178. No deep nesting

Mantener BEM plano.

---

# 179. No `!important`

No usar salvo caso excepcional documentado.

---

# 180. Browser normalization

Revisar:

```text
font inheritance
line-height
border-box
appearance
```

sin reset agresivo.

---

# 181. Typography inheritance

Inputs/buttons/selects deben usar:

```css
font: inherit;
```

o equivalente desde reset.

---

# 182. Width

Inputs habituales:

```text
width: 100%
```

dentro de Field.

Pero Checkbox/Radio/Switch no.

---

# 183. Global selectors

Evitar:

```less
input,
select,
textarea {
    width: 100%;
}
```

porque puede afectar controles no ORP.

---

# 184. File input native button

Si se estiliza:

usar:

```text
::file-selector-button
```

cuando corresponda.

---

# 185. Browser support

Mantener:

```text
Chrome
Edge
Firefox
Safari
iOS Safari
Android
```

---

# 186. Responsive tests

Probar:

```text
320
375
390
430
768
1024
1440
```

---

# 187. Form stress test

Crear formulario de prueba con:

```text
Text
Email
Password
Number
Textarea
Select
Checkbox
Radio
Switch
Search
File
Segmented
```

---

# 188. Validation stress test

Probar:

```text
normal
required
invalid
disabled
readonly
long help
long error
multiple errors on page
```

---

# 189. Long labels

Probar labels de varias líneas.

No romper control.

---

# 190. Long error messages

Probar mensajes multilínea.

---

# 191. Empty label edge

No permitir labels vacíos en demos.

---

# 192. Localization

Probar textos más largos.

No asumir que:

```text
Optional
Required
Error
```

serán siempre cortos.

---

# 193. RTL readiness

Usar logical properties:

```text
padding-inline
margin-inline
inset-inline
```

cuando aplique.

---

# 194. Checkbox RTL

Control/label spacing debe soportar RTL razonablemente.

---

# 195. Accessibility testing

Revisar:

```text
labels
fieldset/legend
required
aria-invalid
aria-describedby
focus-visible
keyboard
disabled
readonly
```

---

# 196. Keyboard test

Completar formulario solo con teclado.

---

# 197. Screen reader relationships

Verificar que:

```text
label
help
error
```

sean asociables correctamente.

---

# 198. Touch test

Checkbox/Radio/Switch deben poder activarse fácilmente en mobile.

---

# 199. Zoom test

Revisar a:

```text
200%
```

sin pérdida de contenido.

---

# 200. Playground

Agregar categoría:

```text
Forms & Validation
```

---

# 201. Playground Field demos

Mostrar:

```text
Label
Help
Required
Optional
Invalid
Disabled
Readonly
```

---

# 202. Playground Controls

Mostrar:

```text
Input
Textarea
Select
Checkbox
Radio
Switch
Search
File
Segmented
```

---

# 203. Validation demo

Crear formulario completo con errores intencionales.

---

# 204. Responsive form demo

Mostrar:

```text
Stack mobile
Grid wider
```

usando Parte 12.

---

# 205. Field Group demo

Mostrar:

```text
Checkbox group
Radio group
```

con:

```text
fieldset
legend
help
error
```

---

# 206. Input Group demo

Si se implementa:

mostrar:

```text
prefix text
prefix icon
suffix icon button
```

---

# 207. Modal form demo

Reutilizar Modal existente y verificar integración.

---

# 208. Sheet form demo

Verificar teclado/mobile.

---

# 209. Theme playground

Probar controles en:

```text
Light
Dark
```

y custom theme si Playground ya lo permite.

---

# 210. Documentation

Crear:

```text
docs/forms/
├── field.md
├── validation.md
├── input.md
├── textarea.md
├── select.md
├── checkbox-radio.md
├── switch.md
├── input-group.md
├── form-layout.md
└── accessibility.md
```

---

# 211. Field docs

Explicar:

```text
label
required
optional
help
error
```

---

# 212. Validation docs

Explicar claramente:

```text
ORP displays validation
ORP does not validate data
```

---

# 213. Laravel / Inertia integration docs

Puede existir sección:

```text
docs/integrations/forms-inertia.md
```

con ejemplos opcionales.

Pero core sigue independiente.

---

# 214. Validation decision guide

Documentar:

```text
Need field-specific explanation?
→ Help text

Field invalid?
→ aria-invalid + Field error

Whole form failed?
→ Alert + field errors

Temporary submit feedback?
→ Toast

Successful persistent confirmation?
→ Alert
```

---

# 215. Control decision guide

```text
Free text?
→ Input

Long text?
→ Textarea

Small predefined list?
→ Select

Independent yes/no option?
→ Checkbox

One choice among many?
→ Radio

Immediate on/off setting?
→ Switch

View/choice toggle?
→ Segmented

Search?
→ SearchInput

File selection?
→ FileInput
```

---

# 216. Switch vs Checkbox docs

Explicitar diferencia.

No usar Switch para:

```text
accept terms
select multiple items
```

---

# 217. Segmented vs Radio

Documentar:

```text
Radio
→ form choice, often vertical/list
```

```text
Segmented
→ compact exclusive choice or view switch
```

---

# 218. Select vs Radio

```text
Few visible options?
→ Radio

Many options?
→ Select
```

---

# 219. Native-first philosophy

ORP Forms debe priorizar:

```text
native HTML controls
```

cuando son suficientes.

Eso reduce:

```text
JS
bugs
accessibility work
mobile issues
```

---

# 220. No dependency additions

No instalar:

```text
VeeValidate
Zod
Yup
Formik
Mask libraries
Date picker libraries
Select2
Choices.js
```

---

# 221. Specialized component rule

Si se necesita algo como:

```text
Combobox
DatePicker
MaskedInput
RichText
```

debe evaluarse como fase independiente o integración externa.

---

# 222. Build

Ejecutar build.

Confirmar:

```text
LESS compiles
Vue compiles
Vite succeeds
no new warnings
```

---

# 223. Bundle

CSS puede crecer moderadamente.

JS debería crecer:

```text
0
```

o casi cero salvo ajustes a componentes Vue existentes.

Reportar impacto.

---

# 224. Regression audit

Verificar que cambios visuales no rompan:

```text
Modal forms
Sheet forms
Drawer forms
SearchInput
FileInput
Segmented
```

---

# 225. Existing API compatibility

No cambiar props/emits existentes salvo bug o inconsistencia importante.

---

# 226. Result expected

Al finalizar entregar:

## Files created

Lista.

## Files modified

Lista.

## Field architecture

Mostrar:

```text
orp-field
orp-field__label
orp-field__required
orp-field__optional
orp-field__help
orp-field__error
```

## Field Groups

Mostrar clases implementadas.

## Controls audited

Listar:

```text
Input
Textarea
Select
Checkbox
Radio
Switch
SearchInput
FileInput
Segmented
```

## Validation

Explicar:

```text
invalid state
aria-invalid
aria-describedby
errors
```

## New tokens

Listar únicamente nuevos tokens.

## Mixins

Listar si fueron creados.

## Playground

Listar nuevos ejemplos.

## Accessibility

Reportar revisión.

## Themes

Confirmar Light/Dark/Custom.

## Responsive

Reportar viewports.

## Build

Resultado.

## Bundle

Impacto CSS/JS.

## Regressions

Problemas encontrados/corregidos.

---

# 227. Completion criteria

Parte 14 termina cuando todos los controles existentes compartan:

```text
consistent field layout
consistent labels
consistent help
consistent errors
consistent focus
consistent disabled state
consistent invalid state
accessible relationships
mobile-friendly sizing
```

y ORP UI siga sin saber:

```text
where validation came from
which backend is used
which framework submitted the form
```

---

# 228. Explicit exclusions

NO implementar:

```text
Combobox
Autocomplete
DatePicker
Calendar
TimePicker custom
MaskedInput
RichText
Password strength meter
MultiSelect custom
Tag input
OTP input
Address autocomplete
Form wizard
Schema validation
Backend validation adapters
```

---

# 229. Do not continue automatically

No implementar Parte 15.

Terminar con reporte técnico.

---

# Regla final

La arquitectura de formularios debe mantenerse:

```text
Field
├── Label
├── Control
├── Help
└── Error
```

El Field proporciona contexto.

El Control proporciona interacción.

La aplicación proporciona validación.

Nunca convertir ORP UI en una librería de formularios acoplada a backend.

Mantener:

```text
ORP UI
→ presentation + semantics + states

Application
→ values + rules + validation + submit
```

La meta de Parte 14 es que cualquier desarrollador pueda conectar:

```text
Laravel
Inertia
Vue
REST API
plain HTML
```

al mismo sistema visual de formularios sin modificar ORP UI.
