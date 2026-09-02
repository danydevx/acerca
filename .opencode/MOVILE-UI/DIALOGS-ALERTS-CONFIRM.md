# SKILL — ORP UI / Parte 21.7: Dialogs, Alerts & Prompt UX

## Objetivo

Agregar a ORP UI una capa completa de **dialogs de aplicación** con APIs simples para reemplazar visualmente los patrones clásicos de:

```text
alert()
confirm()
prompt()
```

sin usar los diálogos bloqueantes nativos del navegador y sin duplicar el sistema base de `Modal` ya existente.

Esta fase debe cubrir también:

```text
Vertical Buttons
Preloader Dialog
Progress Dialog
Dialogs Stack
Destructive Confirmations
Custom Dialog Content
```

La arquitectura debe mantener una separación clara:

```text
Modal
→ primitive estructural de overlay

Dialog
→ patrón de decisión/interacción sobre Modal

Alert / Confirm / Prompt
→ APIs de alto nivel construidas sobre Dialog
```

---

# 1. Scope

```text
Dialogs
├── Alert Dialog
├── Confirm Dialog
├── Prompt Dialog
├── Custom Dialog
├── Vertical Buttons
├── Preloader Dialog
├── Progress Dialog
├── Destructive Confirmation
├── Dialog Actions
├── Dialog Icons
├── Dialog Stack
├── Async Dialog Actions
├── Loading State
├── Error State
└── Dialog Service / Composable
```

---

# 2. Audit first

Antes de implementar revisar:

```text
OrpModal
OrpSheet
OrpActionSheet
OrpAlert
OrpCallout
overlay composables
focus trap
scroll lock
Escape handling
focus restore
Teleport
z-index tokens
```

No crear otro sistema de overlay.

---

# 3. Existing Modal remains foundation

Dialog debe reutilizar Modal existente.

Arquitectura:

```text
OrpModal
   ↓
OrpDialog
   ↓
Alert / Confirm / Prompt / Progress
```

No copiar:

```text
backdrop
focus trap
scroll lock
Teleport
Escape
```

---

# 4. Dialog vs Modal

Documentar claramente:

```text
Modal
→ generic blocking overlay container

Dialog
→ focused interaction or decision

Alert
→ message requiring acknowledgement

Confirm
→ decision between choices

Prompt
→ request a value from user
```

---

# 5. Dialog component

Puede justificarse:

```text
OrpDialog.vue
```

porque normaliza:

```text
title
message
icon
actions
loading
tone
button layout
```

sobre Modal.

---

# 6. Generic Dialog API

Referencia conceptual:

```vue
<OrpDialog
  v-model="open"
  title="Delete file?"
  description="This action cannot be undone."
  tone="danger"
>
  ...
</OrpDialog>
```

Adaptar a conventions reales del proyecto.

---

# 7. Dialog regions

Estructura conceptual:

```text
orp-dialog
├── icon
├── header
│   ├── title
│   └── description
├── body
└── actions
```

---

# 8. Dialog sizing

Mantener pocos tamaños:

```text
sm
md
lg
```

No crear diez variants.

Alert/Confirm suelen usar `sm` o `md`.

---

# 9. Alert Dialog

Crear API simple equivalente visual a:

```js
alert("Saved")
```

pero no bloqueante síncrona.

Ejemplo conceptual:

```js
await dialog.alert({
  title: 'Saved',
  message: 'Your changes were saved.'
})
```

---

# 10. Alert return

Puede devolver Promise resuelta cuando usuario cierra/acepta.

No intentar imitar el bloqueo síncrono de `window.alert()`.

---

# 11. Alert action

Default:

```text
OK
```

pero texto debe ser configurable/localizable.

---

# 12. Confirm Dialog

Equivalente visual a:

```js
confirm()
```

pero async.

Ejemplo:

```js
const confirmed = await dialog.confirm({
  title: 'Delete item?',
  message: 'This action cannot be undone.'
})
```

---

# 13. Confirm result

Debe resolver claramente:

```text
true
false
```

o contract equivalente bien documentado.

---

# 14. Confirm actions

Default conceptual:

```text
Cancel
Confirm
```

Aplicación puede cambiar labels.

---

# 15. Destructive Confirm

Soportar:

```text
tone="danger"
```

para acciones destructivas.

No hacer cualquier confirm rojo automáticamente.

---

# 16. Destructive semantics

El botón destructivo debe usar Button `danger` existente.

No crear estilo separado.

---

# 17. Prompt Dialog

Equivalente visual a:

```js
prompt()
```

pero async y accesible.

Ejemplo conceptual:

```js
const value = await dialog.prompt({
  title: 'Rename file',
  label: 'Name',
  value: currentName
})
```

---

# 18. Prompt input

Reutilizar Input/Field existentes.

No crear input específico.

---

# 19. Prompt result

Contract recomendado:

```text
string → accepted
null → cancelled
```

o equivalente coherente.

Documentarlo.

---

# 20. Prompt validation

ORP puede representar:

```text
required
error text
disabled confirm
```

pero validación de negocio pertenece a aplicación.

---

# 21. Prompt async validation

No meter API remota dentro de Dialog.

Aplicación puede ejecutar validación y actualizar error/loading.

---

# 22. Input types

Prompt básico puede permitir:

```text
text
password
email
number
```

solo si reutiliza Input limpiamente.

No convertir Prompt en Form Builder.

---

# 23. Prompt multiline

Puede permitir Textarea mediante custom content.

No inflar API base si slot resuelve.

---

# 24. Custom Dialog

Debe permitir composición libre mediante slots:

```text
header
default/body
actions
icon
```

---

# 25. Dialog Actions

Reutilizar:

```text
orp-btn
orp-icon-btn
```

No inventar `.orp-dialog-button`.

---

# 26. Horizontal buttons

Default:

```text
Cancel | Confirm
```

con responsive correcto.

---

# 27. Vertical Buttons

Agregar layout:

```text
orp-dialog__actions--vertical
```

o naming equivalente.

Útil cuando:

```text
hay 3+ acciones
labels son largos
mobile width es pequeño
```

---

# 28. Vertical button behavior

Botones pueden ocupar ancho completo.

Mantener orden lógico del DOM.

---

# 29. Action order

No reordenar visualmente de forma que contradiga DOM/teclado.

---

# 30. Too many actions

Si existen demasiadas opciones:

considerar ActionSheet/Dropdown en vez de Dialog.

Documentar decision guide.

---

# 31. Preloader Dialog

Crear patrón para operación indeterminada bloqueante.

Ejemplo conceptual:

```js
dialog.preloader({
  title: 'Uploading…'
})
```

---

# 32. Preloader contents

Reutilizar Spinner existente.

No crear loader nuevo.

---

# 33. Preloader accessibility

Usar:

```text
role/status semantics when appropriate
aria-busy
accessible label
```

sin `aria-live` excesivo.

---

# 34. Preloader dismissibility

Debe poder configurarse:

```text
dismissible
non-dismissible
```

según operación.

---

# 35. Non-dismissible caution

No bloquear usuario indefinidamente sin salida si proceso puede fallar.

Aplicación debe poder cerrar/cancelar programáticamente.

---

# 36. Preloader API

Puede devolver un handle:

```js
const loading = dialog.preloader(...)
loading.close()
```

o existir vía ID/service.

Elegir API coherente y pequeña.

---

# 37. Progress Dialog

Agregar patrón de progreso determinado.

Ejemplo:

```text
Uploading
42%
[progress bar]
```

---

# 38. Progress primitive

Reutilizar `orp-progress`.

No crear progress bar nueva.

---

# 39. Progress input

Aplicación proporciona:

```text
0..100
```

ORP no inventa progreso.

---

# 40. Progress API

Ejemplo conceptual:

```js
const progress = dialog.progress({
  title: 'Uploading',
  value: 0
})

progress.update(42)
progress.close()
```

o API equivalente.

---

# 41. Progress text

Puede mostrar:

```text
42%
3 of 10
Processing…
```

si aplicación proporciona texto.

---

# 42. Cancel progress

Puede incluir acción Cancel.

ORP emite evento/resuelve callback.

Aplicación cancela operación real.

---

# 43. Async action state

Confirm/Prompt pueden necesitar:

```text
loading
```

mientras aplicación procesa acción.

---

# 44. Async Confirm

Ejemplo:

```text
Delete
→ loading
→ success close
```

ORP no ejecuta delete.

---

# 45. Prevent duplicate submit

Mientras confirm action está loading:

puede deshabilitar acciones relevantes.

---

# 46. Error after async action

Dialog puede mostrar:

```text
Inline Message
Alert
Field Error
```

según contexto.

No cerrar automáticamente si la acción falla.

---

# 47. Dialog Service

Puede justificarse un composable/service:

```text
useOrpDialog()
```

para APIs imperativas:

```text
alert
confirm
prompt
preloader
progress
custom
```

---

# 48. Imperative API value

Esta fase sí necesita considerar API imperativa porque:

```text
confirm delete
show error
ask for name
show progress
```

suelen originarse desde lógica de aplicación.

---

# 49. No global plugin requirement

No exigir:

```js
app.use(OrpUI)
```

solo para dialogs.

---

# 50. Possible provider

Si un provider es técnicamente necesario para renderizar dialogs:

usar algo como:

```text
OrpDialogHost
```

pero solo tras auditar arquitectura.

---

# 51. Dialog Host

Responsabilidad:

```text
render dialogs requested by service
manage stack
resolve promises
```

No manejar negocio.

---

# 52. Host placement

Aplicación puede colocarlo una vez cerca de root:

```vue
<OrpDialogHost />
```

si esta arquitectura resulta necesaria.

---

# 53. No implicit DOM injection

Evitar que un módulo importe y monte apps Vue independientes en `document.body`.

Preferir arquitectura Vue explícita.

---

# 54. Promise API

Ejemplo conceptual:

```js
const ok = await dialog.confirm(...)
```

es deseable.

No usar callbacks exclusivamente si Promise ofrece API más moderna.

---

# 55. Callback support

Si el sistema existente usa callbacks:

pueden coexistir, pero evitar dos APIs divergentes innecesariamente.

---

# 56. Dialogs Stack

Soportar múltiples dialogs abiertos de forma controlada.

Ejemplo:

```text
Dialog A
→ opens Dialog B
```

---

# 57. Stack architecture

Mantener stack interno de descriptors.

Solo topmost dialog debe estar interactivo.

---

# 58. Escape with stack

`Escape` cierra únicamente el dialog superior si es dismissible.

---

# 59. Backdrop with stack

Backdrop click afecta únicamente dialog superior.

No cerrar toda la pila.

---

# 60. Focus with stack

Al cerrar dialog B:

focus regresa correctamente a contexto/dialog A.

---

# 61. Scroll lock with stack

Reutilizar reference-count scroll locking de Parte 13.

No desbloquear body mientras quede otro blocking overlay.

---

# 62. Z-index stack

Usar z-index tokens/overlay system.

No:

```text
10000 + index
```

sin arquitectura.

---

# 63. Stack limit

No imponer límite artificial pequeño.

Pero documentar que stacks profundos suelen ser mala UX.

---

# 64. Nested dialog caution

Preferir reemplazar contenido o usar multi-step UI cuando stack se vuelve complejo.

---

# 65. Dialog Queue vs Stack

Distinguir:

```text
Stack
→ dialogs simultaneously nested

Queue
→ dialogs shown sequentially
```

No implementar queue automáticamente salvo necesidad real.

---

# 66. Multiple alerts

Si se llaman varios alerts rápidamente:

definir comportamiento consistente.

Opciones:

```text
stack
queue
reject
```

Elegir una política clara.

---

# 67. Recommended policy

Para APIs imperativas simples:

considerar queue para alerts y stack explícito para nested custom dialogs.

Pero primero priorizar simplicidad y consistencia con Modal existente.

---

# 68. Dialog icons

Permitir slot/icon presentation.

Core icon-agnostic.

Playground puede usar Bootstrap Icons:

```text
bi-info-circle
bi-check-circle
bi-exclamation-triangle
bi-x-circle
bi-trash
bi-question-circle
```

---

# 69. Tone variants

Usar semantic tones:

```text
neutral
info
success
warning
danger
```

sin crear colores hardcoded.

---

# 70. Tone does not force icon

Aplicación puede omitir icono.

---

# 71. Alert component vs Alert Dialog

Muy importante:

```text
orp-alert
→ inline feedback inside page

Alert Dialog
→ blocking acknowledgement dialog
```

No confundirlos.

---

# 72. Callout vs Dialog

```text
Callout
→ contextual embedded information

Dialog
→ temporary blocking interaction
```

---

# 73. Confirm vs ActionSheet

```text
Confirm
→ decision about action

ActionSheet
→ choose one action from a set
```

---

# 74. Dialog vs Sheet

```text
Dialog
→ compact focused interaction

Sheet
→ larger mobile contextual workflow/content
```

---

# 75. Prompt vs Form Modal

```text
Prompt
→ one small value

Form Modal
→ multi-field workflow
```

No convertir Prompt en mini form builder.

---

# 76. Vertical Buttons vs ActionSheet

Si solo existen muchas acciones:

ActionSheet puede ser mejor.

Vertical Dialog Buttons son adecuados cuando acciones acompañan un mensaje/decision.

---

# 77. Close button

Alert/Confirm pueden no necesitar X visible.

Si existe:

usar IconButton accesible.

No insertar `×` literal como control.

---

# 78. Dismissibility

Controlar:

```text
Escape
backdrop
close button
cancel action
```

por props coherentes.

---

# 79. Critical confirm

Para decisiones destructivas importantes:

puede deshabilitar backdrop dismissal.

No convertir esto en default de todos los dialogs.

---

# 80. Destructive text confirmation

Patrón como:

```text
Type DELETE to confirm
```

queda fuera del Prompt básico o puede hacerse con Custom Dialog + Field.

No agregar API especializada.

---

# 81. Autofocus

Usar con cuidado.

---

# 82. Alert autofocus

Normalmente focus inicial en botón de acknowledgement o dialog container según accesibilidad actual de Modal.

---

# 83. Confirm autofocus

No enfocar destructivo automáticamente si eso aumenta riesgo accidental.

Preferir:

```text
Cancel
```

o dialog container según guideline adoptada.

---

# 84. Prompt autofocus

Input puede recibir focus inicial cuando sea apropiado.

---

# 85. Focus trap

Reutilizar Modal.

---

# 86. Focus restore

Reutilizar infraestructura Parte 13.

---

# 87. Initial focus option

Puede permitirse opt-in si Modal ya lo soporta.

No duplicar.

---

# 88. Semantic structure

Usar:

```text
role="dialog"
aria-modal="true"
aria-labelledby
aria-describedby
```

según Modal existente.

---

# 89. Alertdialog role

Evaluar:

```text
role="alertdialog"
```

solo cuando contenido requiere atención inmediata y comportamiento corresponde.

No usarlo para todo alert visual.

---

# 90. Accessibility labels

Title/description deben conectarse mediante IDs estables.

---

# 91. Prompt labels

Input debe tener label real.

Placeholder no sustituye label.

---

# 92. Prompt errors

Usar Field error system de Parte 14.

---

# 93. Keyboard

Requisitos:

```text
Tab
Shift+Tab
Escape
Enter
Space
```

---

# 94. Enter in confirm

No hacer Enter destructivo global automáticamente si focus está en otro control.

---

# 95. Enter in prompt

Puede confirmar si:

```text
single-line input
valid
not composing IME
```

pero debe implementarse cuidadosamente.

---

# 96. IME

No disparar confirm accidental durante composition events.

---

# 97. Textarea

Enter debe insertar nueva línea, no confirmar.

---

# 98. Escape

Cierra solo topmost dismissible dialog.

---

# 99. Button layout mobile

Probar labels largos.

No permitir botones ilegibles.

---

# 100. Responsive

Dialogs deben funcionar en:

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

# 101. Mobile width

No pegar dialog a bordes.

Respetar spacing y safe areas.

---

# 102. Tall content

Body puede scrollear sin perder acciones si arquitectura existente lo soporta.

No hacer todo body/document scroll lock incorrectamente.

---

# 103. Dialog max-height

Usar viewport-safe sizing:

```text
dvh
safe areas
```

cuando sea apropiado.

---

# 104. Landscape mobile

Probar Prompt, Progress y Vertical Buttons.

---

# 105. Themes

Probar:

```text
Light
Dark
Custom
```

---

# 106. Tone in dark theme

Danger/warning/success deben mantener contraste sin fondos chillones.

---

# 107. Preloader dark

Spinner debe verse correctamente.

---

# 108. Progress dark

Progress reutilizado debe conservar contraste.

---

# 109. Reduced motion

Respetar:

```text
prefers-reduced-motion
```

en entrada/salida.

---

# 110. Dialog animations

Reutilizar motion system de Modal.

No crear otra animación.

---

# 111. No animation duplication

Si Modal ya tiene:

```text
fade
scale
```

Dialog hereda.

---

# 112. Loading controls

Spinner dentro de Button puede reutilizar patrón existente.

---

# 113. Preloader vs Loading Button

Documentar:

```text
Loading Button
→ operation local to an action

Preloader Dialog
→ operation blocks wider interaction
```

---

# 114. Progress Dialog vs inline progress

```text
Inline Progress
→ user may continue other work

Progress Dialog
→ process intentionally blocks current workflow
```

No abusar de Dialog.

---

# 115. API naming

Posible composable:

```js
const dialog = useOrpDialog()
```

Métodos:

```text
dialog.alert()
dialog.confirm()
dialog.prompt()
dialog.preloader()
dialog.progress()
```

---

# 116. API consistency

Cada method debe compartir conventions:

```text
title
message
tone
actions
dismissible
```

cuando aplicable.

---

# 117. Avoid giant options API

No agregar 40 props para cada dialog.

Custom Dialog cubre casos avanzados.

---

# 118. Alert API conceptual

```js
await dialog.alert({
  title: 'Success',
  message: 'Changes saved.',
  tone: 'success',
  confirmText: 'OK'
})
```

---

# 119. Confirm API conceptual

```js
const confirmed = await dialog.confirm({
  title: 'Delete item?',
  message: 'This cannot be undone.',
  tone: 'danger',
  confirmText: 'Delete',
  cancelText: 'Cancel'
})
```

---

# 120. Prompt API conceptual

```js
const name = await dialog.prompt({
  title: 'Rename',
  label: 'Name',
  value: 'Document',
  confirmText: 'Save'
})
```

---

# 121. Preloader API conceptual

```js
const loader = dialog.preloader({
  title: 'Processing…'
})

await task()

loader.close()
```

---

# 122. Progress API conceptual

```js
const handle = dialog.progress({
  title: 'Uploading',
  value: 0
})

handle.update(50)
handle.update(100)
handle.close()
```

---

# 123. Handles cleanup

Handles deben ser seguros si:

```text
close twice
update after close
component unmount
```

No lanzar errores innecesarios.

---

# 124. Host unmount

Promises pendientes deben resolverse/rechazarse de forma predecible.

Documentar.

---

# 125. SSR

No acceder a:

```text
document
window
```

en module evaluation.

---

# 126. Service SSR

En SSR no intentar abrir dialog.

Puede no-op, throw controlled error o requerir client invocation.

Elegir comportamiento y documentar.

---

# 127. No browser native replacements internally

No implementar usando:

```js
window.alert()
window.confirm()
window.prompt()
```

como fallback silencioso.

---

# 128. No Bootstrap modal

No usar Bootstrap JS/CSS.

---

# 129. CSS architecture

Posibles archivos:

```text
less/components/dialog.less
```

Gran parte debe apoyarse en Modal/Button/Field/Progress existentes.

---

# 130. Vue architecture

Posibles:

```text
src/components/OrpDialog.vue
src/components/OrpDialogHost.vue
src/composables/useOrpDialog.js
```

Solo si arquitectura actual lo justifica.

---

# 131. Internal types

Proyecto usa JavaScript, no TypeScript.

Documentar shapes con JSDoc si ya es convention.

No introducir TS.

---

# 132. Public API

Exportar únicamente piezas públicas necesarias.

No exportar internals del stack manager salvo necesidad.

---

# 133. Playground

Agregar categoría:

```text
Dialogs
```

---

# 134. Playground sections

```text
Basic Dialog
Alert
Confirm
Prompt
Vertical Buttons
Preloader
Progress
Destructive Confirm
Async Action
Dialog Stack
Custom Content
```

---

# 135. Alert demos

Mostrar:

```text
neutral
success
warning
danger
```

sin abusar de tonos.

---

# 136. Confirm demos

Mostrar:

```text
normal
destructive
long message
```

---

# 137. Prompt demos

Mostrar:

```text
text input
validation error
pre-filled value
password if supported
```

---

# 138. Vertical Buttons demo

Obligatorio.

Probar:

```text
2 actions
3 actions
long labels
```

---

# 139. Preloader demo

Debe simular operación local determinista.

No network real.

---

# 140. Progress demo

Simular progreso controlado localmente.

No fake progress dentro de core.

---

# 141. Stack demo

Ejemplo:

```text
Dialog A
→ open Dialog B
→ close B
→ focus returns to A
```

---

# 142. Async demo

Simular:

```text
Confirm
→ loading
→ error
→ retry
→ success
```

con state local.

---

# 143. Playground Bootstrap audit

No usar:

```text
modal
modal-dialog
alert
btn
d-flex
gap-*
p-*
m-*
```

de Bootstrap.

Permitido:

```text
bi
bi-*
```

---

# 144. Regression

Ejecutar Parte 17.

Especialmente:

```text
Modal
Sheet
Drawer
ActionSheet
Alert
Button
Input
Field
Progress
Spinner
Dropdown
focus trap
scroll lock
```

---

# 145. Visual regression

Fixtures sugeridos:

```text
dialog-alert-light
dialog-alert-dark
dialog-confirm
dialog-confirm-danger
dialog-prompt
dialog-vertical-buttons-mobile
dialog-preloader
dialog-progress
dialog-async-error
dialog-stack
```

---

# 146. Interaction tests

Cubrir:

```text
open
confirm
cancel
Escape
backdrop
focus trap
focus restore
prompt value
prompt cancel
vertical actions
loading
progress update
stack
```

---

# 147. Promise tests

Cubrir:

```text
alert resolves
confirm true
confirm false
prompt value
prompt null
preloader close
progress close
```

---

# 148. Stack tests

Obligatorios:

```text
topmost Escape
topmost backdrop
focus restore
scroll lock reference count
z-index ordering
```

---

# 149. Accessibility tests

Auditar:

```text
dialog role
alertdialog usage
labels
descriptions
prompt input labels
keyboard
focus
disabled/loading buttons
screen reader order
```

---

# 150. Responsive tests

Priorizar:

```text
320
375
390
430
768
1440
```

más landscape.

---

# 151. Theme tests

```text
Light
Dark
Custom
```

---

# 152. RTL

Probar:

```html
dir="rtl"
```

en:

```text
horizontal actions
vertical actions
Prompt
Progress
icons
```

---

# 153. Localization

No hardcodear:

```text
OK
Cancel
Confirm
Close
```

sin estrategia de override.

Default labels pueden existir pero deben poder cambiarse.

---

# 154. Long translations

Probar textos largos.

Especialmente botones en alemán/español u otros idiomas.

---

# 155. Security

Messages deben renderizarse como texto por defecto.

No `v-html`.

---

# 156. Rich content

Si Custom Dialog permite markup mediante slots:

contenido es responsabilidad del developer.

No aceptar arbitrary HTML string API por defecto.

---

# 157. Performance

Dialog stack/service debe añadir poco JS.

No mantener watchers/listeners globales innecesarios cuando no hay dialogs.

---

# 158. Event cleanup

Todos los listeners deben limpiarse.

---

# 159. Bundle

Reportar:

```text
CSS before/after
JS before/after
```

---

# 160. Documentation

Crear/adaptar:

```text
docs/dialogs/
├── overview.md
├── alert.md
├── confirm.md
├── prompt.md
├── vertical-actions.md
├── preloader.md
├── progress.md
├── stack.md
├── async-actions.md
└── accessibility.md
```

---

# 161. Decision guide

Documentar:

```text
Alert vs Alert Dialog
Modal vs Dialog
Confirm vs ActionSheet
Prompt vs Form Modal
Preloader Dialog vs Spinner
Progress Dialog vs inline Progress
Dialog Stack vs multi-step Dialog
```

---

# 162. Alert vs Alert Dialog

```text
Alert
→ inline, non-blocking page feedback

Alert Dialog
→ blocking acknowledgement
```

---

# 163. Modal vs Dialog

```text
Modal
→ generic overlay container

Dialog
→ focused decision/message interaction
```

---

# 164. Confirm vs ActionSheet

```text
Confirm
→ yes/no or focused decision

ActionSheet
→ choose from several actions
```

---

# 165. Prompt vs Form Modal

```text
Prompt
→ one simple value

Form Modal
→ richer form
```

---

# 166. Preloader vs Spinner

```text
Spinner
→ visual loading primitive

Preloader Dialog
→ blocking loading interaction built with Spinner
```

---

# 167. Progress Dialog vs Progress

```text
Progress
→ visual progress primitive

Progress Dialog
→ blocking workflow around Progress
```

---

# 168. Stack vs Multi-step

```text
Dialog Stack
→ nested independent dialogs

Multi-step dialog
→ one workflow with several steps
```

Prefer multi-step when dialogs depend closely on each other.

---

# 169. Completion criteria

Parte 21.7 termina cuando ORP UI pueda resolver:

```text
alert
confirm
prompt
custom dialog
vertical buttons
preloader dialog
progress dialog
destructive confirm
async dialog actions
dialog stacks
```

con API clara, Promise-friendly, accesible y construida sobre Modal existente.

---

# 170. Result expected

Al finalizar entregar:

## Existing Overlay Audit

Modal/Sheet/ActionSheet/Alert revisados.

## Architecture

Modal vs Dialog vs service.

## OrpDialog

Resultado.

## Dialog Host

Si se creó y por qué.

## useOrpDialog

API final.

## Alert

Resultado.

## Confirm

Resultado.

## Prompt

Resultado.

## Vertical Buttons

Resultado.

## Preloader

Resultado.

## Progress

Resultado.

## Async Actions

Resultado.

## Dialog Stack

Resultado.

## Files created

Lista.

## Files modified

Lista.

## Public API

Cambios.

## Playground

Demos.

## Accessibility

Resultado.

## Keyboard

Resultado.

## Responsive

Resultado.

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

# 171. Explicit exclusions

NO implementar:

```text
browser alert wrapper
browser confirm wrapper
browser prompt wrapper
notification center
toast replacement
wizard framework
form builder
permissions
API requests
backend operations
native desktop dialogs
Electron dialogs
file picker dialogs
OAuth popup manager
payment confirmation engine
global error boundary system
```

---

# 172. No new dependencies

No instalar:

```text
SweetAlert
SweetAlert2
Notiflix
Bootbox
Headless UI
Radix
```

ORP ya tiene primitives suficientes para construir esta capa.

---

# 173. Do not continue automatically

No implementar Parte 22.

Terminar con reporte técnico.

---

# Regla final

Mantener:

```text
OrpModal
   ↓
OrpDialog
   ↓
useOrpDialog()
   ↓
Alert / Confirm / Prompt / Preloader / Progress
```

Y en todos los casos:

```text
ORP UI
→ presentation
→ interaction
→ focus
→ accessibility
→ promise result

Application
→ business action
→ backend
→ validation
→ async process
```

ORP debe ofrecer la conveniencia de APIs modernas tipo:

```js
await dialog.alert(...)
await dialog.confirm(...)
await dialog.prompt(...)
```

sin sacrificar la arquitectura reusable del framework.

