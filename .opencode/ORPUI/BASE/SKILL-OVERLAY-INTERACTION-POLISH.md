SKILL — ORP UI / Parte 13: Overlay & Interaction Polish
Objetivo

Consolidar y pulir todos los componentes interactivos y overlays existentes de ORP UI.

Auditar y mejorar:

Interactions
├── Modal
├── Sheet
├── Drawer
├── Action Sheet
├── Dropdown
├── Popover
├── Toast
├── Tooltip strategy
├── Focus management
├── Scroll lock
├── Escape handling
├── Outside click
├── Z-index system
├── Portal / Teleport behavior
└── Mobile interaction consistency

Esta fase debe priorizar:

behavior consistency
accessibility
focus
keyboard
mobile UX
stacking
cleanup

No agregar componentes nuevos sin necesidad clara.

1. Principio principal

Todos los overlays deben sentirse parte del mismo sistema.

No permitir que:

Modal
Sheet
Drawer
Popover
Dropdown

implementen cada uno:

Escape
outside click
focus
scroll lock
z-index
Teleport

de forma completamente distinta.

Buscar una arquitectura común donde tenga sentido.

2. No construir un mega overlay manager

No crear una abstracción enorme que haga todo.

Evitar algo como:

OrpOverlayEngine

con cientos de opciones.

Preferir pequeñas primitives internas compartidas.

3. Audit first

Antes de modificar código:

auditar implementación actual de:

OrpModal
OrpSheet
OrpDrawer
OrpActionSheet
OrpDropdown
OrpPopover
OrpToast

Documentar:

Teleport
Escape
focus
outside click
scroll lock
ARIA
z-index
transitions
mobile behavior

por componente.

4. Shared interaction responsibilities

Identificar lógica repetida.

Posibles utilidades internas:

useOrpEscape
useOrpOutsideClick
useOrpScrollLock
useOrpFocusTrap
useOrpRestoreFocus

Crear solo si eliminan duplicación real.

No exportarlas públicamente automáticamente.

5. Internal composables

Ubicación sugerida:

src/
└── composables/
    ├── useOrpEscape.js
    ├── useOrpOutsideClick.js
    ├── useOrpScrollLock.js
    ├── useOrpFocusTrap.js
    └── useOrpRestoreFocus.js

Adaptar a arquitectura actual.

6. SSR safety

Los composables no deben tocar:

window
document
localStorage

durante module evaluation.

Solo dentro de:

onMounted
event handlers

o guards adecuados.

7. Modal

Auditar OrpModal.

Debe soportar consistentemente:

Escape
backdrop click
focus trap
restore focus
scroll lock
aria-modal
role dialog
Teleport
8. Modal props

Mantener API pequeña.

Referencia:

modelValue
title
closeOnEscape
closeOnBackdrop
showClose

No inflar API si ya existe otra estable.

Preservar backward compatibility.

9. Modal events

Referencia:

update:modelValue
open
close

Solo conservar/agregar si encaja con API actual.

10. Modal semantics

Contenedor principal:

role="dialog"
aria-modal="true"

Si existe título visible:

usar:

aria-labelledby

Si no:

permitir:

aria-label
11. Modal title ID

Generar IDs de forma estable.

No hardcodear:

id="modal-title"

para múltiples instancias.

12. Focus entry

Al abrir Modal:

focus debe ir a:

first meaningful interactive element

o al dialog container si no existe uno adecuado.

No enfocar arbitrariamente botón cerrar si existe mejor objetivo.

13. Focus trap

Mientras Modal está abierto:

Tab y Shift+Tab deben permanecer dentro del dialog.

No permitir fuga al contenido del fondo.

14. Focus restore

Al cerrar:

restaurar focus al elemento que abrió Modal cuando siga disponible.

15. Modal backdrop

Backdrop debe:

block pointer interaction
cover viewport

sin hacks de dimensiones.

16. Backdrop click

Cerrar solo si click ocurrió realmente en backdrop.

No cerrar al hacer click dentro del contenido.

17. Modal Escape

Escape debe cerrar si:

closeOnEscape !== false
18. Escape propagation

Si existen overlays anidados:

solo el overlay superior debería responder.

Ejemplo:

Modal
└── Dropdown

Escape primero debería cerrar Dropdown.

No cerrar ambos simultáneamente.

19. Overlay stack

Definir concepto de overlay activo superior.

No necesariamente crear manager global complejo.

Pero comportamiento debe ser coherente.

20. Sheet

Auditar OrpSheet.

Debe reutilizar en lo posible:

Escape
Backdrop
Focus
Scroll lock
Teleport

de Modal.

21. Sheet difference

Sheet no es Modal visualmente.

Mantener:

Modal
→ centered dialog
Sheet
→ edge-attached surface
22. Sheet positions

Si ya existen:

bottom
start
end

preservar.

No agregar top/start/end innecesariamente si no existe necesidad.

23. Mobile Sheet

Bottom Sheet debe:

respect safe-area-bottom
have sensible max-height
allow internal content scroll
24. Sheet viewport

Preferir:

100dvh

para límites modernos.

No depender solo de 100vh.

25. Sheet max height

Ejemplo conceptual:

max-height: min(90dvh, 48rem);

No fijar valor sin revisar diseño actual.

26. Sheet internal scroll

Cuando contenido crece:

sheet
→ stays inside viewport
content
→ scrolls

No hacer scroll simultáneo de fondo.

27. Drawer

Auditar OrpDrawer.

Debe compartir infraestructura de overlay.

28. Drawer semantics

Dependiendo del uso:

puede usar:

role="dialog"
aria-modal="true"

si bloquea interacción del fondo.

29. Drawer placement

Preferir logical directions:

start
end

sobre:

left
right

para preparar RTL.

30. Drawer mobile

Target principal:

mobile navigation
secondary panel
filters

pero framework no debe conocer contenido.

31. Drawer desktop

No forzar Drawer a convertirse en Sidebar.

AppShell ya cubre sidebar persistente.

32. Action Sheet

OrpActionSheet debe reutilizar OrpSheet.

No duplicar:

backdrop
Escape
scroll lock
focus
Teleport
33. Action Sheet role

Representa lista de acciones.

Acciones deben ser:

button

salvo que sean navegación real.

34. Action Sheet destructive action

Permitir visual:

danger

sin ejecutar ninguna lógica.

35. Cancel action

En mobile:

cancel debe estar claramente separado cuando diseño lo amerite.

Mantener consistencia con safe area.

36. Dropdown

Auditar OrpDropdown.

Aquí comportamiento difiere de overlays bloqueantes.

Dropdown normalmente:

does NOT lock body scroll
does NOT trap focus permanently
37. Dropdown keyboard

Soportar razonablemente:

Enter
Space
Escape
ArrowDown
ArrowUp
Home
End

si implementa patrón de menú.

38. Dropdown semantics

No usar automáticamente:

role="menu"

si contenido no es realmente menú de acciones.

ARIA menu tiene expectativas específicas.

Si es simple disclosure:

puede ser mejor semántica básica.

39. Dropdown trigger

Trigger debe exponer:

aria-expanded
aria-controls

cuando corresponda.

40. Dropdown outside click

Debe cerrar al click fuera.

No cerrar antes de que acción interna pueda ejecutarse.

41. Dropdown Escape

Escape:

closes dropdown
restores focus to trigger
42. Dropdown focus

Al abrir con teclado:

focus puede moverse al primer item.

Al abrir con pointer:

evitar comportamiento incómodo si no hace falta.

43. Dropdown positioning

No construir Popper.js propio.

Si positioning actual es simple:

mantener.

No implementar collision engine complejo en esta fase.

44. Dropdown viewport collision

Sí revisar casos básicos:

right edge
bottom edge
small screens

Si la solución requiere un motor completo:

documentar limitación.

45. Popover

Auditar OrpPopover.

Debe diferenciarse claramente de Dropdown.

46. Popover purpose

Popover puede contener:

rich content
small form
metadata
actions

pero no sustituye Modal.

47. Popover behavior

Normalmente:

outside click → close
Escape → close
no scroll lock
no full focus trap
48. Popover focus

Si contiene controles interactivos:

focus debe poder entrar de forma natural.

Al cerrar con Escape:

volver al trigger.

49. Popover semantics

Usar:

role="dialog"

solo si comportamiento realmente corresponde.

No añadir roles por decoración.

50. Tooltip strategy

No implementar Tooltip complejo todavía si no existe.

Primero definir estrategia oficial.

51. Native title

No recomendar title como solución principal para información importante.

Es inconsistente en:

touch
keyboard
accessibility
52. Tooltip requirement

Si ORP necesita Tooltip posteriormente:

deberá soportar:

hover
focus
Escape
touch consideration
aria-describedby
53. Tooltip exclusions

Parte 13 puede limitarse a:

document strategy

sin crear componente si no existe necesidad fuerte.

54. Toast

Auditar OrpToast.

Debe tener comportamiento coherente de:

queue
duration
manual close
pause strategy
ARIA
stacking
55. Toast region

Crear o consolidar:

orp-toast-region

si ya existe concepto similar.

56. Toast placement

Preferir logical naming:

block-start
block-end
inline-end

internamente si es práctico.

API puede mantenerse simple.

57. Default toast location

Elegir una ubicación consistente.

Mobile recomendado:

near bottom but above BottomNav/safe area

Desktop puede ser:

top/end

pero no cambiar automáticamente sin necesidad.

58. Toast + AppShell

Toast no debe quedar oculto detrás de:

BottomNav
FAB
safe area
59. Toast accessibility

Para mensajes no críticos:

role="status"
aria-live="polite"

Para errores urgentes:

evaluar:

role="alert"

No convertir todos en alert.

60. Toast duration

No cerrar mensajes importantes demasiado rápido.

Si se usa auto-dismiss:

duración debe permitir lectura razonable.

61. Toast hover/focus pause

Si toast tiene:

link
button
close

evaluar pausar temporizador durante:

hover
focus
62. Toast queue

No permitir que 20 Toasts cubran viewport.

Definir estrategia simple:

max visible
queue

si la arquitectura actual lo permite.

63. Toast state management

Si ya existe un store/composable:

auditar.

No introducir Pinia solo para Toast.

64. No new dependency

No instalar librería Toast.

65. Alert vs Toast

Documentar:

Alert
→ persistent inline feedback
Toast
→ temporary global feedback
66. Modal vs Sheet

Documentar:

Modal
→ focused centered interaction
Sheet
→ contextual edge interaction
67. Sheet vs Drawer
Sheet
→ temporary surface attached to viewport edge
Drawer
→ navigation or larger secondary panel

Visualmente pueden parecer similares, pero intención difiere.

68. Dropdown vs Popover
Dropdown
→ short list of actions/options
Popover
→ richer contextual content
69. ActionSheet vs Dropdown
ActionSheet
→ mobile action list, blocking overlay
Dropdown
→ anchored lightweight actions
Focus Management
70. Shared focus strategy

Definir una política oficial para:

Modal
Sheet
Drawer
ActionSheet

Todos los blocking overlays deben:

capture appropriate focus
trap focus
restore focus
71. Tabbable detection

Si se crea helper:

debe encontrar elementos relevantes como:

a[href]
button:not([disabled])
input:not([disabled])
select:not([disabled])
textarea:not([disabled])
[tabindex]:not([tabindex="-1"])

Evitar implementación gigantesca.

72. Hidden elements

No incluir elementos realmente ocultos.

Pero no construir selector ultra complejo si no hace falta.

73. Dialog fallback focus

Overlay container debería poder tener:

tabindex="-1"

para recibir focus cuando no existen elementos interactivos.

74. Autofocus

Respetar autofocus con cuidado.

No depender exclusivamente de atributo HTML dentro de Teleport si no funciona consistentemente.

75. Restore target safety

Antes de restaurar:

verificar que trigger:

still exists
is focusable enough
Scroll Lock
76. Shared scroll lock

Blocking overlays deben compartir scroll lock.

77. Avoid body jump

Al bloquear scroll:

no provocar cambio brusco por desaparición de scrollbar en desktop.

Evaluar:

scrollbar-gutter: stable

como estrategia moderna.

78. Preferred strategy

Si browser support es suficiente:

html {
    scrollbar-gutter: stable;
}

solo si se considera adecuado globalmente.

No agregar sin revisar impacto.

79. Body lock

Una opción:

body.orp-scroll-locked {
    overflow: hidden;
}

Pero aplicar/remover desde composable.

80. No generic class

No usar:

modal-open

por parecido a Bootstrap.

Usar:

orp-scroll-locked
81. Nested overlay scroll locks

Si Modal abre Sheet:

cerrar Sheet no debe desbloquear scroll si Modal sigue abierto.

Necesario:

reference count

o mecanismo equivalente.

82. Scroll lock counter

Implementar internamente algo como:

lock count

si existen overlays anidados.

No exponer públicamente.

83. iOS behavior

Probar:

iOS Safari

conceptualmente/real si disponible.

Scroll lock puede comportarse distinto.

No meter hacks antiguos sin necesidad.

Escape Management
84. Escape listener

Evitar que cada componente registre listeners globales sin coordinación.

85. Top overlay only

Si existen múltiples overlays:

Escape debe afectar al último abierto.

86. Escape and inputs

Escape en:

SearchInput
Dropdown
Popover

puede tener comportamiento local antes de cerrar overlay padre.

No interceptar indiscriminadamente.

Outside Click
87. Outside click helper

Debe considerar:

trigger
panel
Teleported content

según componente.

88. Pointer events

Preferir:

pointerdown

o estrategia consistente.

No mezclar:

click
mousedown
touchstart

arbitrariamente entre componentes.

89. Mobile pointer

Usar Pointer Events cuando sea suficiente.

90. Trigger click race

Evitar:

click trigger → opens dropdown
document click → immediately closes dropdown
Teleport
91. Teleport strategy

Blocking overlays deberían usar:

<Teleport to="body">

si arquitectura existente ya lo hace.

92. Teleport exceptions

Dropdown/Popover pueden necesitar Teleport solo si:

overflow clipping
stacking context

lo justifica.

No hacerlo automáticamente si positioning simple funciona mejor inline.

93. SSR

Teleport debe mantenerse compatible con SSR/hydration según soporte Vue.

No tocar DOM durante import.

Z-index
94. Consolidate z-index tokens

Auditar tokens existentes.

Crear una escala clara.

Referencia conceptual:

--orp-z-base
--orp-z-sticky
--orp-z-dropdown
--orp-z-popover
--orp-z-fixed
--orp-z-backdrop
--orp-z-modal
--orp-z-toast

No usar números gigantes independientes.

95. Suggested hierarchy

Conceptualmente:

base
sticky
dropdown
popover
fixed navigation
backdrop
drawer/sheet/modal
toast
external full-screen overlay

Pero revisar cómo GLightbox debe convivir.

96. Numeric values

Ejemplo orientativo:

--orp-z-base: 0;
--orp-z-sticky: 100;
--orp-z-dropdown: 200;
--orp-z-popover: 300;
--orp-z-fixed: 400;
--orp-z-backdrop: 900;
--orp-z-modal: 1000;
--orp-z-toast: 1100;

No copiar estos valores sin revisar implementación actual.

97. GLightbox

GLightbox debe poder quedar sobre AppShell y overlays normales cuando sea apropiado.

No intentar forzarlo bajo Modal sin razón.

98. No z-index 999999

Prohibir números arbitrarios como:

9999
99999
2147483647

salvo integración externa inevitable y documentada.

99. Stacking contexts

Auditar propiedades que crean stacking contexts:

transform
filter
opacity
isolation
position + z-index
100. AppShell

No agregar z-index al shell solo para “arreglar” overlays.

Motion
101. Shared motion tokens

Usar:

--orp-duration-fast
--orp-duration-normal
--orp-duration-slow
--orp-ease-standard
102. Modal animation

Referencia:

backdrop → opacity
dialog → opacity + subtle scale

No animaciones grandes.

103. Sheet animation

Mover desde su edge natural.

Bottom Sheet:

translateY

Drawer start/end:

translateX
104. Dropdown animation

Sutil:

opacity
small translate

No scale dramático.

105. Popover animation

Misma familia visual que Dropdown.

106. Toast animation

Entrada/salida breve.

No hacer bounce.

107. Reduced motion

Todos los overlays deben respetar:

@media (prefers-reduced-motion: reduce)

Reducir o eliminar transforms/transitions innecesarias.

108. Transition consistency

No permitir:

Modal = 180ms
Sheet = 347ms
Dropdown = 120ms
Toast = 600ms

sin intención.

Usar sistema.

Mobile UX
109. Touch targets

Triggers y close buttons:

aprox:

44x44px

como referencia.

110. Close icon

Usar Bootstrap Icons en ejemplos:

bi-x-lg

pero componente no depende de Bootstrap Icons.

111. Bottom Sheet grabber

Puede existir elemento visual:

orp-sheet__handle

si ya tiene valor UX.

No hacerlo draggable automáticamente.

112. Drag to dismiss

NO implementar drag-to-dismiss en esta fase.

Requeriría:

gesture tracking
velocity
threshold
pointer state

y aumentaría complejidad.

113. Swipe drawer

NO implementar swipe gestures.

114. Native mobile expectations

En móvil priorizar:

safe areas
large targets
clear close behavior
stable scroll

antes que gestures.

115. Virtual keyboard

Probar:

Modal with form
Sheet with input
Popover with input

con teclado virtual.

116. Input visibility

Focus en campo no debe quedar oculto por teclado o fixed region.

No agregar JS de viewport si no es estrictamente necesario.

Styling
117. Overlay surfaces

Todos deben usar semantic tokens:

--orp-surface
--orp-surface-foreground
--orp-border
--orp-background
--orp-ring
118. Backdrop token

Agregar si no existe:

--orp-backdrop

Ejemplo:

--orp-backdrop: rgb(0 0 0 / 0.45);

Dark theme puede ajustar.

119. Surface radius

Usar radius tokens existentes.

No crear radio diferente para cada overlay sin motivo.

120. Modal radius

Desktop puede usar:

--orp-radius-lg

Mobile fullscreen variation puede no necesitar radius.

121. Bottom Sheet radius

Solo corners del edge superior:

usar logical corner properties cuando sea práctico.

122. Drawer radius

Normalmente poco o ninguno dependiendo edge.

No forzar card look.

123. Shadow

Usar shadow tokens.

No hardcodear sombras independientes.

Modal Responsive Behavior
124. Modal width

Usar:

min()
clamp()

cuando aporte.

Ejemplo conceptual:

inline-size: min(32rem, calc(100vw - 2rem));
125. Modal sizes

Si ya existen:

sm
md
lg

mantener pocas.

No construir 8 tamaños.

126. Mobile Modal

En pantallas pequeñas:

mantener margin segura.

No convertir automáticamente todo Modal a fullscreen.

127. Fullscreen variant

Puede existir:

orp-modal--fullscreen

solo si ya hay necesidad.

No hacerlo por defecto.

Drawer Responsive Behavior
128. Drawer width

Usar custom property:

--orp-drawer-size

si aporta.

129. Drawer max width

Evitar drawer de 90% en desktop.

Usar límites razonables.

Dropdown / Popover Responsive Behavior
130. Minimum width

Dropdown debería al menos poder igualar trigger si diseño lo requiere.

No imponer siempre.

131. Max width

Popover debe tener max inline size para evitar textos eternos.

132. Mobile overflow

Si anchored overlay no cabe:

permitir fallback simple.

No construir positioning engine complejo.

Event APIs
133. Model convention

Componentes controlados deben utilizar:

modelValue
update:modelValue

consistentemente.

134. Open close naming

No mezclar:

visible
isOpen
opened
show
active

entre nuevos componentes.

Preservar compatibilidad, pero establecer convención futura.

Preferencia:

modelValue
135. Event payload

Eventos como:

select
close

deben tener payloads simples y documentados.

136. No DOM event leakage

No exponer eventos nativos arbitrarios como API pública salvo utilidad clara.

Disabled / Busy states
137. Overlay triggers

Trigger disabled no debe abrir overlay.

138. Modal busy

No agregar busy global al Modal salvo API existente.

La aplicación puede deshabilitar botones.

139. Prevent close during critical operation

Si se necesita:

usar props existentes como:

closeOnEscape
closeOnBackdrop

No crear “lock mode” enorme.

Accessibility
140. Audit keyboard

Probar:

Tab
Shift+Tab
Enter
Space
Escape
Arrow keys where relevant
141. Screen reader labels

Todos los close icon buttons requieren:

aria-label
142. Decorative icons

Usar:

aria-hidden="true"
143. Background inertness

Para blocking overlays:

evaluar uso de:

inert

en contenido de fondo si arquitectura lo permite.

144. Inert

No hacerlo requisito si complica Vue/Teleport.

Focus trap + backdrop puede ser suficiente inicialmente.

145. ARIA hidden

No aplicar aria-hidden de forma agresiva a body children sin gestionar nesting correctamente.

146. Dialog description

Si existe descripción:

usar:

aria-describedby

cuando aporte.

Testing
147. Interaction matrix

Crear matriz de pruebas para:

Modal
Sheet
Drawer
ActionSheet
Dropdown
Popover
Toast
148. Each component test

Revisar:

mouse
touch
keyboard
Escape
outside click
focus
theme
mobile
desktop
149. Nested overlays

Probar:

Modal → Dropdown
Modal → Popover
Modal → Sheet if allowed
Drawer → Dropdown
150. Avoid ridiculous nesting

No optimizar para:

Modal → Sheet → Drawer → Popover → Dropdown

pero sistema no debe colapsar con uno o dos niveles legítimos.

151. Scroll tests

Probar:

short page
long page
scroll position mid-page
open Modal
close Modal

El usuario debe regresar a misma posición.

152. Scroll lock nested test
open Modal
open Sheet
close Sheet

Body debe seguir bloqueado.

Luego:

close Modal

Body vuelve a scroll normal.

153. Focus restore test
trigger
→ open
→ navigate inside
→ close
→ focus trigger
154. Focus trap test

Tab cycling:

first → ... → last → first

Shift+Tab inverso.

155. No tabbable test

Modal sin botones/inputs no debe romper JS.

156. Escape nested test
Modal
└── Dropdown

Primer Escape:

Dropdown closes

Segundo Escape:

Modal closes
157. Outside click test

Dropdown:

inside click → stays/open or executes
outside click → closes
158. Mobile test widths

Probar:

320
375
390
430
768
1024
1440
159. iOS safe area

Probar Sheet/Drawer/Toast en simulación de:

notch
home indicator
160. Dark theme

Revisar:

backdrop
surface
shadow
border
focus
161. Custom theme

Asegurar que no existan colores hardcoded nuevos.

Playground
162. Playground category

Agregar:

Overlay & Interaction
163. Modal demos

Mostrar:

Basic
Long content
Form
No close button
Backdrop disabled
Nested dropdown
164. Sheet demos

Mostrar:

Bottom
Long content
Form
Safe area
165. Drawer demos

Mostrar:

Start
End if supported
Navigation
Long content
166. Action Sheet demo

Mostrar:

Normal action
Disabled
Danger
Cancel
167. Dropdown demos

Mostrar:

Basic
Keyboard
Long menu
Near viewport edge
168. Popover demos

Mostrar:

Text
Actions
Form content
169. Toast demos

Mostrar:

Info
Success
Warning
Danger
Long message
Action
Multiple
170. Playground keyboard instructions

Agregar pequeño bloque:

Try Tab / Shift+Tab / Escape

para pruebas manuales.

CSS Architecture
171. Files

Auditar/ordenar:

less/
└── components/
    ├── modal.less
    ├── sheet.less
    ├── drawer.less
    ├── action-sheet.less
    ├── dropdown.less
    ├── popover.less
    └── toast.less
172. Shared overlay CSS

Si existe suficiente repetición:

crear:

less/
└── abstracts/
    └── overlay.less

o mixins.

No crear clase pública .orp-overlay obligatoriamente.

173. Backdrop reuse

Puede existir primitive interna:

.orp-backdrop

si Modal/Drawer/Sheet comparten realmente markup.

Si es pública:

documentarla.

174. Avoid deep nesting

No escribir:

.orp-modal {
    .orp-modal__dialog {
        .orp-modal__content {
            .orp-modal__body {

Preferir BEM plano.

175. No !important

Eliminar los existentes cuando sea razonable.

Reportar cualquier excepción.

Vue Architecture
176. Public components

Mantener exports existentes.

Ejemplo:

OrpModal
OrpSheet
OrpDrawer
OrpActionSheet
OrpDropdown
OrpPopover
OrpToast
177. Internal composables

No exportar automáticamente:

useOrpScrollLock
useOrpFocusTrap
178. Public composable exception

Solo exportar si existe valor real para aplicaciones externas.

No hacerlo en esta fase salvo necesidad demostrada.

179. No plugin requirement

No introducir:

app.use(OrpUI)

como requisito.

180. Toast API exception

Si Toast requiere servicio global ya existente:

mantenerlo opcional y bien documentado.

No obligar todo ORP UI a plugin global.

External Integration
181. Bootstrap Icons

Usar en demos:

close
chevron
more
check
warning

sin dependencia interna.

182. GLightbox

Verificar convivencia.

GLightbox debe abrir/cerrar sin romper:

body scroll
z-index
focus restoration
183. Swiper

Dropdown/Popover dentro de slide no deben romperse por overflow si se puede evitar.

Documentar limitaciones si Swiper clipping afecta anchored overlays.

184. External overlay priority

No intentar controlar internamente todos los overlays de terceros.

Solo evitar conflictos obvios.

Documentation
185. Docs

Crear/actualizar:

docs/interactions/
├── modal.md
├── sheet.md
├── drawer.md
├── action-sheet.md
├── dropdown.md
├── popover.md
├── toast.md
├── focus-management.md
├── scroll-lock.md
└── overlay-stacking.md
186. Overlay decision guide

Documentar:

Need centered blocking interaction?
→ Modal

Need edge-attached blocking surface?
→ Sheet

Need temporary secondary panel/navigation?
→ Drawer

Need mobile action list?
→ ActionSheet

Need anchored action list?
→ Dropdown

Need anchored rich content?
→ Popover

Need temporary global feedback?
→ Toast

Need persistent inline feedback?
→ Alert
187. Focus docs

Explicar:

initial focus
focus trapping
focus restoration
nested overlays
188. Scroll lock docs

Explicar cuándo:

Modal
Sheet
Drawer
ActionSheet

bloquean body.

Y cuándo:

Dropdown
Popover
Toast

no deberían hacerlo.

189. Z-index docs

Documentar escala oficial.

No depender de “sube el z-index hasta que funcione”.

190. Keyboard docs

Tabla conceptual:

Component    Escape    Trap Focus    Outside Click

Modal        Yes       Yes           Optional close
Sheet        Yes       Yes           Optional close
Drawer       Yes       Yes           Optional close
ActionSheet  Yes       Yes           Optional close
Dropdown     Yes       No            Yes
Popover      Yes       No            Yes
Toast        No        No            No

Adaptar a implementación final.

Build and Quality
191. Build

Ejecutar build existente.

Confirmar:

Vue compile
LESS compile
Vite build
no new warnings
192. JS growth

Esta fase puede aumentar JS ligeramente por:

focus
scroll lock
overlay coordination

Reportar tamaño.

193. No dependencies

No instalar:

focus-trap library
floating-ui
popper
headless-ui
radix
bootstrap

en esta fase.

194. Exception rule

Si al implementar correctamente focus trap o positioning se descubre que una dependencia especializada sería claramente mejor:

NO instalar automáticamente.

Reportar recomendación.

195. Regression

Verificar que APIs existentes sigan funcionando.

No romper aplicaciones existentes sin razón.

196. Backward compatibility

Cambios internos de composables son preferibles a cambios públicos.

197. Public API changes

Si una API existente es inconsistente:

documentar problema.

Solo modificar si:

bug
accessibility issue
architecture conflict

lo justifica.

198. Result expected

Al finalizar entregar:

Files created

Lista.

Files modified

Lista.

Overlay audit

Estado de:

Modal
Sheet
Drawer
ActionSheet
Dropdown
Popover
Toast
Shared composables

Lista de los realmente creados.

Focus

Explicar:

trap
initial
restore
Scroll lock

Explicar implementación y nested locks.

Escape

Explicar manejo de top overlay.

Outside click

Explicar estrategia.

Z-index

Mostrar escala final.

Mobile

Reportar safe areas y viewport tests.

Accessibility

Reportar keyboard/ARIA.

Themes

Confirmar Light/Dark/Custom.

Playground

Listar demos.

Build

Resultado.

Bundle

Impacto CSS/JS.

Regressions

Problemas encontrados/corregidos.

199. Completion criteria

Parte 13 termina cuando:

Modal
Sheet
Drawer
ActionSheet
Dropdown
Popover
Toast

tengan comportamiento consistente en:

Escape
focus
scroll
outside interactions
z-index
mobile
themes
accessibility

según naturaleza de cada componente.

200. Explicit exclusions

NO implementar en esta fase:

drag to dismiss
swipe gestures
Floating UI engine
Popper clone
complex tooltip system
context menu
command palette
tour / onboarding overlay
spotlight
notification center
201. Do not continue automatically

No implementar Parte 14.

Terminar con reporte técnico.

Regla final

Un overlay en ORP UI no debe sentirse como una isla independiente.

Todos deben compartir un lenguaje común de interacción:

open
focus
interact
close
restore

pero sin forzar el mismo comportamiento donde no corresponde.

Mantener:

Blocking overlays
→ Modal / Sheet / Drawer / ActionSheet
→ focus trap + scroll lock
Anchored overlays
→ Dropdown / Popover
→ outside click + Escape + focus restore
Feedback
→ Toast
→ non-blocking

La meta de Parte 13 no es que ORP UI tenga más componentes.

La meta es que los componentes que ya existen se comporten como un framework maduro:

predictable
accessible
consistent
mobile-friendly
low-dependency
maintainable

