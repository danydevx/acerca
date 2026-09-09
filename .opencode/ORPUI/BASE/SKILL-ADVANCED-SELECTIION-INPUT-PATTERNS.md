# SKILL — ORP UI / Parte 15: Advanced Selection & Input Patterns

## Objetivo

Extender el sistema de formularios de ORP UI con controles de selección y entrada que requieren comportamiento interactivo real y que ya no se resuelven suficientemente bien con HTML + CSS únicamente.

Implementar y/o consolidar:

```text
Advanced Inputs
├── Combobox
├── Autocomplete
├── MultiSelect
├── Tag Input
├── OTP / PIN Input
├── Password Field
├── Range / Slider
└── Number Stepper
```

Esta fase debe priorizar:

```text
keyboard accessibility
ARIA correctness
mobile UX
composition
predictable v-model APIs
native HTML when possible
low dependency
no backend coupling
```

Mantener la filosofía:

```text
Native when possible
Vue when behavior justifies it
```

---

# 1. Principio principal

No convertir ORP UI en una librería gigantesca de formularios.

Los componentes de esta fase solo deben existir cuando aporten comportamiento que no puede resolverse limpiamente con HTML + CSS.

Mantener:

```text
ORP UI
→ interaction + presentation + semantics

Application
→ data source + validation + API + business rules
```

---

# 2. Dependencias

No instalar nuevas dependencias automáticamente.

NO agregar:

```text
Vue Select
Vue Multiselect
Headless UI
Radix
Floating UI
Choices.js
Select2
Downshift
Fuse.js
```

Implementar únicamente el comportamiento necesario.

Si durante la implementación se detecta que una dependencia especializada sería claramente superior, documentar la recomendación pero NO instalarla.

---

# 3. Namespace

Mantener convenciones existentes:

```text
CSS
orp-*

LESS
@orp-*

CSS variables
--orp-*

Vue
Orp*

JS hooks
data-orp-*
```

---

# 4. Integración con Parte 14

Todos los componentes deben funcionar dentro de:

```text
orp-field
orp-field-group
```

y soportar correctamente:

```text
label
help
error
disabled
required
invalid
```

No duplicar Field dentro de cada componente.

---

# 5. Validation

Los componentes deben representar:

```text
valid
invalid
disabled
readonly
required
```

cuando aplique.

Pero NO deben implementar reglas de validación de negocio.

La aplicación decide si un valor es válido.

---

# 6. v-model convention

Todos los componentes Vue deben usar:

```text
modelValue
update:modelValue
```

como API principal.

Evitar APIs diferentes entre componentes.

---

# 7. IDs

Cuando un componente necesite relaciones ARIA internas, generar IDs estables.

Ejemplo:

```text
trigger
listbox
option
description
```

No hardcodear IDs compartidos.

---

# 8. Combobox

Crear:

```text
OrpCombobox.vue
```

Solo si no existe ya un componente equivalente.

Objetivo:

```text
text input
+
option list
+
single selection
```

---

# 9. Combobox use case

Ejemplos genéricos:

```text
Select country
Select category
Select person
Select item
```

No crear variantes de dominio.

Incorrecto:

```text
OrpProductSelector
OrpCountryCombobox
OrpUserSelector
```

---

# 10. Combobox props

API de referencia:

```text
modelValue
options
placeholder
disabled
readonly
clearable
searchable
optionLabel
optionValue
noResultsText
```

No agregar props innecesarias.

Adaptar a convenciones existentes.

---

# 11. Option structure

Referencia:

```js
[
    {
        value: 'mx',
        label: 'México'
    },
    {
        value: 'us',
        label: 'Estados Unidos'
    }
]
```

Permitir objetos genéricos.

---

# 12. Option mapping

Si se soportan objetos arbitrarios:

```text
optionLabel
optionValue
```

deben resolverlos.

No asumir:

```text
id
name
```

como estructura universal.

---

# 13. Combobox events

Referencia:

```text
update:modelValue
change
search
open
close
```

Solo mantener eventos que tengan utilidad real.

No emitir eventos redundantes.

---

# 14. Combobox semantics

Implementar patrón ARIA Combobox correctamente.

Input:

```text
role="combobox"
aria-expanded
aria-controls
aria-autocomplete
```

Lista:

```text
role="listbox"
```

Opciones:

```text
role="option"
```

---

# 15. aria-activedescendant

Preferir mantener focus en input y controlar opción activa mediante:

```text
aria-activedescendant
```

cuando arquitectura lo permita.

Esto evita mover focus continuamente entre input y opciones.

---

# 16. Combobox keyboard

Debe soportar:

```text
ArrowDown
ArrowUp
Enter
Escape
Home
End
```

cuando corresponda.

---

# 17. ArrowDown

Debe:

```text
open list if closed
move active option
```

---

# 18. ArrowUp

Debe mover selección activa hacia arriba.

---

# 19. Enter

Si existe opción activa:

```text
select option
close list
```

---

# 20. Escape

Debe:

```text
close list
```

sin cerrar accidentalmente Modal/Popover padre cuando el Combobox todavía tiene algo que cerrar.

---

# 21. Home / End

Cuando lista está abierta:

pueden mover a:

```text
first option
last option
```

si no interfieren con edición normal del texto.

---

# 22. Tab

No secuestrar Tab innecesariamente.

Debe permitir continuar navegación del formulario.

---

# 23. Combobox filtering

Si `searchable`:

filtrado local simple puede existir.

No implementar fuzzy search complejo.

---

# 24. Search normalization

Puede usar comparación:

```text
case-insensitive
```

simple.

No agregar Fuse.js.

---

# 25. Remote search

Combobox NO realiza fetch.

Debe poder emitir:

```text
search
```

para que aplicación consulte API.

---

# 26. Loading

Permitir estado:

```text
loading
```

si existe necesidad.

Mostrar:

```text
orp-spinner
```

o mensaje.

No ejecutar request internamente.

---

# 27. No results

Mostrar mensaje configurable.

Ejemplo:

```text
No hay resultados
```

---

# 28. Clearable

Si existe selección:

permitir botón clear opcional.

Usar:

```text
orp-icon-btn
```

o estructura equivalente.

Debe tener:

```text
aria-label
```

---

# 29. Combobox mobile

En móvil:

input y opciones deben mantener targets cómodos.

No convertir automáticamente a Modal/Sheet.

---

# 30. Long option lists

NO implementar virtualización.

Documentar limitación.

---

# 31. Autocomplete

Evaluar si realmente necesita componente separado.

Conceptualmente:

```text
Combobox
→ user selects known option

Autocomplete
→ user types and receives suggestions
```

---

# 32. Prefer shared foundation

No duplicar toda lógica entre:

```text
OrpCombobox
OrpAutocomplete
```

Si ambos comparten:

```text
keyboard
listbox
active option
outside click
Escape
```

extraer lógica interna.

---

# 33. Possible composable

Solo si elimina duplicación real:

```text
useOrpListbox.js
```

o:

```text
useOrpCombobox.js
```

No exportarlo públicamente automáticamente.

---

# 34. Autocomplete value

Autocomplete puede permitir texto libre.

Esto lo diferencia de Combobox estricto.

---

# 35. Autocomplete API

Referencia:

```text
modelValue
suggestions
placeholder
disabled
loading
minChars
```

Eventos:

```text
update:modelValue
search
select
```

---

# 36. No debounce coupling

No implementar debounce obligatorio.

La aplicación puede decidir:

```text
debounce duration
API request strategy
caching
```

Si existe debounce opcional, debe ser mínimo y justificarse.

Preferencia: no incluirlo.

---

# 37. Request race conditions

ORP UI no gestiona requests.

La aplicación debe resolver respuestas fuera de orden.

---

# 38. MultiSelect

Crear:

```text
OrpMultiSelect.vue
```

para selección múltiple de opciones predefinidas.

---

# 39. MultiSelect value

`modelValue` debe ser array.

Ejemplo:

```js
['vue', 'laravel']
```

o array de valores según `optionValue`.

---

# 40. MultiSelect options

Misma estructura genérica que Combobox.

---

# 41. MultiSelect display

Opciones seleccionadas pueden representarse mediante:

```text
orp-chip
```

reutilizando Parte 7.

No crear un nuevo sistema visual de tags interno.

---

# 42. Selected chip

Ejemplo conceptual:

```html
<span class="orp-chip orp-chip--selected">
    Vue
</span>
```

---

# 43. Remove action

Cada selección removible debe tener botón accesible.

Ejemplo:

```text
Remove Vue
```

como `aria-label`.

---

# 44. MultiSelect keyboard

Debe permitir:

```text
ArrowDown
ArrowUp
Enter
Escape
Backspace
```

---

# 45. Backspace

Si input está vacío:

Backspace puede eliminar última selección.

Solo si comportamiento es predecible.

---

# 46. Duplicate selections

No permitir duplicados.

---

# 47. Disabled options

Opciones pueden soportar:

```text
disabled
```

---

# 48. Maximum selections

No implementar regla obligatoria.

Puede existir prop:

```text
max
```

solo si existe necesidad real.

La app sigue validando.

---

# 49. MultiSelect filtering

Reutilizar estrategia del Combobox.

---

# 50. MultiSelect remote options

No fetch interno.

Emitir search si aplica.

---

# 51. MultiSelect empty

Cuando no hay selección:

mostrar placeholder.

---

# 52. MultiSelect overflow

Muchas selecciones pueden crecer demasiado.

Soportar wrapping correctamente.

No imponer horizontal scroll como default.

---

# 53. Optional collapse

NO implementar:

```text
+12 more
```

automáticamente en esta fase.

---

# 54. Tag Input

Crear:

```text
OrpTagInput.vue
```

solo para entrada libre de valores.

---

# 55. Tag Input vs MultiSelect

Documentar claramente:

```text
MultiSelect
→ predefined options

TagInput
→ free user-entered values
```

---

# 56. Tag Input model

`modelValue`:

```js
[
    'Vue',
    'Laravel',
    'PHP'
]
```

---

# 57. Tag creation

Permitir crear tag mediante:

```text
Enter
```

y opcionalmente:

```text
comma
```

si API lo permite.

---

# 58. Tag separator

Si existe prop:

```text
separator
```

mantener simple.

No construir parser complejo.

---

# 59. Tag trim

Eliminar espacios externos.

Ejemplo:

```text
" Vue "
→
"Vue"
```

---

# 60. Empty tags

No permitir.

---

# 61. Duplicate tags

Default:

no permitir duplicados.

---

# 62. Duplicate comparison

Puede ser case-insensitive si se documenta.

No aplicar lógica lingüística compleja.

---

# 63. Tag removal

Usar Chip + botón remove accesible.

---

# 64. Backspace tags

Con input vacío:

Backspace puede eliminar último tag.

---

# 65. Paste

Si usuario pega:

```text
Vue, Laravel, PHP
```

NO parsear múltiples tags automáticamente salvo que se implemente explícitamente.

Mantener comportamiento predecible.

---

# 66. Tag validation

ORP no decide:

```text
allowed tags
forbidden words
maximum business tags
```

La app controla reglas.

---

# 67. Tag maximum

Puede existir prop `max` solo como restricción UX opcional.

Backend debe validar.

---

# 68. OTP / PIN Input

Crear:

```text
OrpOtpInput.vue
```

Nombre público recomendado:

```text
OrpOtpInput
```

porque describe patrón técnico genérico.

---

# 69. OTP scope

Debe servir para:

```text
verification code
PIN
short numeric/alphanumeric code
```

sin asumir autenticación específica.

---

# 70. OTP model

Preferir string:

```js
"123456"
```

en lugar de array de caracteres como API pública.

---

# 71. OTP length

Prop:

```text
length
```

Referencia default:

```text
6
```

solo si existe necesidad de default.

---

# 72. OTP inputmode

Para códigos numéricos:

```html
inputmode="numeric"
```

---

# 73. OTP autocomplete

Para códigos de un solo uso:

considerar:

```html
autocomplete="one-time-code"
```

---

# 74. OTP paste

Debe soportar pegar código completo.

Ejemplo:

```text
123456
```

y distribuirlo correctamente.

---

# 75. OTP navigation

Soportar:

```text
ArrowLeft
ArrowRight
Backspace
Delete
```

---

# 76. Auto advance

Al introducir carácter válido:

mover al siguiente campo.

---

# 77. Backspace

Si campo está vacío:

volver al anterior.

---

# 78. OTP invalid

Estado invalid debe integrarse con:

```text
orp-field--invalid
aria-invalid
```

---

# 79. OTP semantics

No anunciar cada input como campo completamente independiente sin contexto.

Usar label/group accesible.

---

# 80. OTP security

No implementar lógica de autenticación.

No almacenar códigos.

No verificar OTP.

---

# 81. OTP masking

Si se requiere PIN secreto:

puede existir:

```text
type="password"
```

o variante.

No hacerlo default para códigos de verificación.

---

# 82. Password Field

Crear:

```text
OrpPasswordInput.vue
```

o consolidar componente existente.

---

# 83. Password purpose

Resolver únicamente:

```text
password input
+
visibility toggle
```

---

# 84. Password model

API estándar:

```text
modelValue
update:modelValue
```

---

# 85. Password toggle

Botón real:

```html
<button type="button">
```

con label dinámico:

```text
Mostrar contraseña
Ocultar contraseña
```

---

# 86. Password icons

Ejemplos pueden usar Bootstrap Icons:

```text
bi-eye
bi-eye-slash
```

ORP core no depende de ellos.

---

# 87. Password autocomplete

No desactivar autocomplete.

La aplicación debe poder configurar:

```text
current-password
new-password
```

---

# 88. Password managers

No romper gestores de contraseñas mediante hacks.

---

# 89. Password strength

NO implementar medidor de fuerza.

---

# 90. Password rules

NO validar:

```text
uppercase
numbers
symbols
minimum length
```

internamente.

---

# 91. Password generation

NO implementar.

---

# 92. Range / Slider

Priorizar:

```html
<input type="range">
```

nativo.

No crear slider completamente custom si no hace falta.

---

# 93. Range styling

Crear:

```text
orp-range
```

para estilizar input nativo.

---

# 94. Range model

Si existe wrapper Vue:

solo crearlo si aporta valor real.

CSS native range puede ser suficiente.

---

# 95. Range props

HTML nativo ya ofrece:

```text
min
max
step
value
disabled
```

No duplicar innecesariamente.

---

# 96. Range label

Debe integrarse con `orp-field`.

---

# 97. Range value display

Aplicación puede componer:

```text
orp-meta
orp-badge
```

para mostrar valor.

No imponer tooltip flotante.

---

# 98. Range accessibility

Usar input nativo conserva semántica.

No reemplazar con div + pointer handlers.

---

# 99. Range themes

Track/thumb deben funcionar en:

```text
Light
Dark
Custom
```

---

# 100. Range browser audit

Probar:

```text
Chrome
Firefox
Safari
iOS Safari
```

porque pseudo-elementos difieren.

---

# 101. Dual Range

NO implementar range de dos thumbs.

Eso requiere componente especializado.

---

# 102. Number Stepper

Crear:

```text
OrpNumberInput.vue
```

o:

```text
OrpNumberStepper.vue
```

Elegir nombre según arquitectura existente.

Preferencia si incluye botones:

```text
OrpNumberStepper
```

---

# 103. Number Stepper structure

```text
decrement button
number input
increment button
```

---

# 104. Number Stepper semantics

El input debe seguir siendo:

```html
<input type="number">
```

cuando sea apropiado.

---

# 105. Number Stepper props

Referencia:

```text
modelValue
min
max
step
disabled
readonly
```

---

# 106. Increment

Debe respetar:

```text
step
max
```

---

# 107. Decrement

Debe respetar:

```text
step
min
```

---

# 108. Decimal precision

Evitar errores evidentes de floating point.

Ejemplo:

```text
0.1 + 0.2
```

No construir librería matemática.

Normalizar según precisión derivada de `step` si es necesario.

---

# 109. Number buttons

Botones deben tener:

```text
aria-label="Incrementar"
aria-label="Disminuir"
```

o labels configurables/localizables.

---

# 110. Number keyboard

Input nativo debe seguir permitiendo entrada manual.

No obligar a usar botones.

---

# 111. Number mobile

Usar:

```text
inputmode
```

adecuado si aporta.

---

# 112. Number invalid

Debe integrarse con Field.

---

# 113. Shared Listbox behavior

Combobox, Autocomplete y MultiSelect comparten mucha lógica.

Auditar posibilidad de un composable interno.

Ejemplo:

```text
useOrpListbox
```

Responsabilidades posibles:

```text
open state
active index
keyboard navigation
option ids
selection navigation
```

---

# 114. Keep composable small

NO meter dentro:

```text
API requests
filtering business rules
validation
templates
styles
```

---

# 115. Outside click

Combobox/Autocomplete/MultiSelect deben cerrar al click fuera.

Reutilizar infraestructura de Parte 13 si existe.

---

# 116. Escape handling

Reutilizar:

```text
useOrpEscape
```

si ya existe y encaja.

---

# 117. Overlay behavior

Listas desplegables son anchored overlays ligeros.

Normalmente:

```text
no scroll lock
no focus trap
outside click
Escape
```

---

# 118. Positioning

No construir un Floating UI clone.

Implementar posicionamiento simple.

---

# 119. Overflow

Probar dentro de:

```text
Modal
Sheet
Drawer
Card
AppShell
```

---

# 120. Teleport

No usar Teleport automáticamente.

Solo si clipping/stacking actual lo requiere.

---

# 121. Mobile dropdowns

Si lista no cabe:

permitir scroll interno razonable.

No convertir automáticamente a Sheet.

---

# 122. Option touch target

Opciones:

aprox:

```text
44px
```

de altura/touch target como referencia.

---

# 123. Option active state

Diferenciar:

```text
hover
keyboard active
selected
disabled
```

---

# 124. Active vs Selected

No confundir:

```text
active
→ currently highlighted by keyboard

selected
→ current value
```

---

# 125. Option icons

Permitir composición con:

```text
orp-icon
```

sin exigir Bootstrap Icons.

---

# 126. Option metadata

Si se necesita contenido secundario:

permitir estructura genérica.

No convertir opciones en cards complejas.

---

# 127. Empty states

Reutilizar conceptos existentes.

Para dropdown pequeño:

mensaje simple.

No insertar automáticamente `orp-empty` completo dentro de una lista diminuta.

---

# 128. Loading state

Usar Spinner existente.

---

# 129. Disabled state

Todos los componentes deben soportar disabled de forma consistente.

---

# 130. Readonly

Solo componentes donde tenga sentido.

Readonly no debe ser alias de disabled.

---

# 131. Required

Integrar con Field/ARIA.

No crear validación automática.

---

# 132. Error

No agregar prop `errorMessage` a cada componente si Field ya lo resuelve.

---

# 133. Focus ring

Reutilizar:

```text
--orp-ring
```

y patrones de Parte 14.

---

# 134. Control sizing

Mantener alturas/tokens de Forms Foundation.

No crear tamaños independientes.

---

# 135. CSS architecture

Archivos sugeridos:

```text
less/
└── forms/
    ├── combobox.less
    ├── multiselect.less
    ├── tag-input.less
    ├── otp.less
    ├── password.less
    ├── range.less
    └── number-stepper.less
```

Autocomplete puede compartir estilos con Combobox.

---

# 136. Vue architecture

Posibles componentes:

```text
src/components/forms/
├── OrpCombobox.vue
├── OrpAutocomplete.vue
├── OrpMultiSelect.vue
├── OrpTagInput.vue
├── OrpOtpInput.vue
├── OrpPasswordInput.vue
└── OrpNumberStepper.vue
```

No crear wrapper Vue para Range si CSS nativo basta.

---

# 137. Internal composables

Solo si son necesarios:

```text
src/composables/
├── useOrpListbox.js
└── useOrpOptionNavigation.js
```

No exportar automáticamente.

---

# 138. Public exports

Actualizar `index.js` únicamente con componentes públicos realmente implementados.

---

# 139. No global plugin

No requerir:

```js
app.use(OrpUI)
```

---

# 140. Tree shaking

Mantener imports individuales compatibles con ESM.

---

# 141. Themes

Todos los nuevos controles deben funcionar con:

```text
Light
Dark
Custom
```

---

# 142. Semantic tokens

Reutilizar:

```text
--orp-background
--orp-foreground
--orp-surface
--orp-surface-muted
--orp-border
--orp-input
--orp-ring
--orp-primary
--orp-danger
--orp-muted-foreground
```

---

# 143. New tokens

Agregar únicamente si reducen hardcodes reales.

Posibles:

```text
--orp-option-height
--orp-control-menu-max-height
```

No crear tokens por cada componente.

---

# 144. Dropdown surface

Combobox/MultiSelect menus deben usar mismos tokens visuales que Dropdown/Popover cuando corresponda.

---

# 145. Z-index

Reutilizar escala de Parte 13.

No introducir:

```text
z-index: 99999
```

---

# 146. Shadows

Reutilizar shadow tokens.

---

# 147. Radius

Reutilizar radius tokens.

---

# 148. Motion

Usar:

```text
--orp-duration-fast
--orp-duration-normal
--orp-ease-standard
```

---

# 149. Reduced motion

Respetar:

```text
prefers-reduced-motion
```

---

# 150. Accessibility audit

Revisar especialmente:

```text
Combobox
Autocomplete
MultiSelect
OTP
Password visibility
Number Stepper
```

---

# 151. Keyboard-only test

Todos deben poder operarse sin mouse.

---

# 152. Screen reader test

Verificar:

```text
expanded state
selected option
active option
disabled option
labels
descriptions
errors
```

---

# 153. Combobox ARIA audit

No inventar roles.

Seguir patrón ARIA de combobox/listbox.

---

# 154. MultiSelect ARIA

Revisar semántica para selección múltiple.

Listbox puede usar:

```text
aria-multiselectable="true"
```

cuando corresponda.

---

# 155. OTP accessibility

No hacer que screen reader anuncie seis veces información redundante.

---

# 156. Password toggle accessibility

El estado del botón debe ser comprensible.

---

# 157. Range accessibility

Mantener input nativo siempre que sea posible.

---

# 158. Number Stepper accessibility

Botones + input deben tener nombres claros.

---

# 159. Mobile testing

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

# 160. Mobile keyboard

Probar:

```text
Combobox
Autocomplete
TagInput
OTP
Password
Number
```

con teclado virtual.

---

# 161. iOS Safari

Revisar especialmente:

```text
focus
viewport
keyboard
input zoom
OTP paste
range
```

---

# 162. Android

Revisar:

```text
inputmode
OTP
autocomplete
dropdown scrolling
```

---

# 163. Long content

Probar opciones con textos largos.

---

# 164. Large option set

Probar:

```text
100
500
1000
```

opciones para detectar degradación evidente.

No implementar virtualización.

---

# 165. Empty options

Combobox debe comportarse correctamente con:

```js
[]
```

---

# 166. Dynamic options

Probar options cambiando mientras dropdown está abierto.

No dejar active index inválido.

---

# 167. Selected option removed

Si aplicación elimina opción seleccionada:

componente no debe romperse.

Definir comportamiento predecible.

---

# 168. Async simulation

Playground puede simular:

```text
loading
delayed suggestions
no results
```

sin API real.

---

# 169. Playground

Agregar categoría:

```text
Advanced Inputs
```

---

# 170. Combobox demos

Mostrar:

```text
Basic
Searchable
Clearable
Disabled
No results
Loading
Long options
Invalid Field
```

---

# 171. Autocomplete demos

Mostrar:

```text
Local suggestions
Async simulation
Free text
```

---

# 172. MultiSelect demos

Mostrar:

```text
Basic
Multiple selected
Search
Disabled option
Many selections
Invalid
```

---

# 173. Tag Input demos

Mostrar:

```text
Basic
Add
Remove
Duplicate attempt
Max example if supported
```

---

# 174. OTP demos

Mostrar:

```text
4 digits
6 digits
Paste
Invalid
Disabled
```

---

# 175. Password demos

Mostrar:

```text
Hidden
Visible
Disabled
Invalid
```

---

# 176. Range demos

Mostrar:

```text
Default
Min/max
Step
Disabled
```

---

# 177. Number Stepper demos

Mostrar:

```text
Basic
Min/max
Decimal step
Disabled
Invalid
```

---

# 178. Field integration demos

Cada componente debe mostrarse dentro de:

```text
orp-field
```

con al menos un ejemplo de:

```text
label
help
error
```

---

# 179. Overlay integration

Probar Combobox dentro de:

```text
Modal
Sheet
Drawer
```

---

# 180. AppShell integration

Probar dropdown cerca de bordes del viewport.

---

# 181. Dark theme

Mostrar todos los controles en dark.

---

# 182. Bootstrap isolation

Playground NO debe usar Bootstrap CSS.

Bootstrap Icons puede seguir siendo integración opcional.

---

# 183. Documentation

Crear:

```text
docs/forms/
├── combobox.md
├── autocomplete.md
├── multiselect.md
├── tag-input.md
├── otp-input.md
├── password-input.md
├── range.md
└── number-stepper.md
```

---

# 184. Selection guide

Documentar:

```text
Known small list?
→ Select

Known list + search?
→ Combobox

Free text + suggestions?
→ Autocomplete

Multiple known options?
→ MultiSelect

Multiple free values?
→ TagInput
```

---

# 185. Select vs Combobox

```text
Select
→ native, simple, mobile-friendly

Combobox
→ searchable/custom option selection
```

Preferir Select cuando sea suficiente.

---

# 186. Combobox vs Autocomplete

```text
Combobox
→ value normally comes from known options

Autocomplete
→ text can remain free-form
```

---

# 187. MultiSelect vs TagInput

```text
MultiSelect
→ known options

TagInput
→ user-created values
```

---

# 188. OTP vs regular Input

Usar OTP solo cuando la experiencia de código corto realmente lo justifique.

No usar para cualquier número.

---

# 189. Range vs NumberStepper

```text
Range
→ approximate/visual adjustment

NumberStepper
→ precise numeric adjustment
```

---

# 190. Password Input docs

Explicar que:

```text
visibility toggle
≠
password validation
```

---

# 191. No business naming

Prohibido:

```text
orp-country-select
orp-product-combobox
orp-skill-tags
orp-quantity-stepper
```

El framework proporciona primitives.

La aplicación les da significado.

---

# 192. No API knowledge

No props como:

```text
endpoint
apiUrl
fetchUrl
resource
```

en estos componentes.

---

# 193. No Laravel knowledge

No importar:

```text
@inertiajs/vue3
```

ni conocer errores Laravel.

---

# 194. No router knowledge

Estos componentes no navegan.

---

# 195. No schema validation

No integrar:

```text
Zod
Yup
VeeValidate
```

---

# 196. No data caching

Autocomplete no mantiene cache global.

---

# 197. No global stores

No introducir Pinia.

---

# 198. Build

Ejecutar build completo.

Confirmar:

```text
LESS compiles
Vue compiles
Vite succeeds
no new warnings
```

---

# 199. JS impact

Esta fase sí agregará JavaScript.

Reportar crecimiento aproximado.

Identificar cuánto corresponde a:

```text
Combobox
Autocomplete
MultiSelect
TagInput
OTP
Password
NumberStepper
```

---

# 200. CSS impact

Reportar crecimiento.

Evitar duplicación entre:

```text
Combobox
Autocomplete
MultiSelect
```

---

# 201. Regression audit

Verificar que Parte 15 no rompa:

```text
Input
Select
Checkbox
Radio
Switch
SearchInput
FileInput
Segmented
Field
Modal
Sheet
Drawer
Dropdown
Popover
```

---

# 202. Public API audit

Listar nuevos exports.

---

# 203. Accessibility report

Entregar resumen específico de:

```text
keyboard
ARIA
focus
screen reader relationships
mobile
```

---

# 204. Result expected

Al finalizar entregar:

## Files created

Lista.

## Files modified

Lista.

## Components

Listar componentes implementados.

## Internal composables

Listar solo los realmente creados.

## Public exports

Mostrar cambios en `index.js`.

## Combobox behavior

Explicar:

```text
keyboard
selection
search
ARIA
```

## MultiSelect behavior

Explicar:

```text
selection
chips
keyboard
duplicates
```

## Tag Input behavior

Explicar creación/eliminación.

## OTP behavior

Explicar:

```text
auto advance
backspace
paste
```

## Password behavior

Explicar visibility toggle.

## Range

Explicar styling/browser support.

## Number Stepper

Explicar:

```text
min
max
step
manual input
```

## Themes

Confirmar:

```text
Light
Dark
Custom
```

## Playground

Listar demos.

## Accessibility

Resultado.

## Responsive

Viewports probados.

## Build

Resultado.

## Bundle

Impacto CSS/JS.

## Regressions

Problemas encontrados/corregidos.

---

# 205. Completion criteria

Parte 15 termina cuando ORP UI tenga soluciones reutilizables y accesibles para:

```text
single searchable selection
autocomplete suggestions
multiple selection
free tags
short codes
password visibility
range values
precise numeric adjustment
```

sin acoplarse a:

```text
backend
router
validation library
API
domain
external UI library
```

---

# 206. Explicit exclusions

NO implementar en esta fase:

```text
DatePicker
Calendar
TimePicker custom
Date Range Picker
Rich Text Editor
Address Autocomplete
Google Places
Mention Input
Tree Select
Cascading Select
Dual Range Slider
Color Picker advanced
Form Wizard
Schema Validation
Virtualized Select
Command Palette
```

---

# 207. Do not continue automatically

No implementar Parte 16.

Terminar con reporte técnico.

---

# Regla final

Mantener esta jerarquía:

```text
Native HTML
    ↓
¿resuelve correctamente el problema?
    ↓
YES → style it with ORP
NO  → evaluate Vue component
```

No crear componentes Vue simplemente para que todo tenga un componente.

Especialmente:

```text
Select
Range
Number
```

deben conservar capacidades nativas siempre que sea posible.

Para componentes interactivos:

```text
Combobox
Autocomplete
MultiSelect
TagInput
OTP
PasswordInput
NumberStepper
```

ORP UI controla:

```text
interaction
keyboard
ARIA
visual state
```

La aplicación controla:

```text
data
API
validation
business rules
persistence
```

La meta de Parte 15 es cubrir inputs avanzados comunes sin sacrificar la filosofía ligera y reutilizable de ORP UI.

