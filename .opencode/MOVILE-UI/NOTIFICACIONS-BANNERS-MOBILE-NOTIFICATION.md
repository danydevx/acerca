# SKILL — ORP UI / Parte 21.8: Notifications, Banners & Mobile Notification UX

## Objetivo

Agregar a ORP UI una capa completa de **notificaciones visuales de aplicación**, inspirada en patrones de sistemas móviles modernos pero manteniendo una arquitectura web accesible, reusable y sin dependencia de plataformas específicas.

Esta fase debe cubrir notificaciones tipo:

```text
mobile notification card
app notification
system-style notification
inline notification
notification banner
notification center item
notification stack
actionable notification
persistent notification
temporary notification
```

ORP UI debe encargarse de:

```text
visual presentation
layout
states
actions
dismiss behavior
stacking
timing
accessibility
responsive behavior
themes
```

La aplicación sigue siendo responsable de:

```text
push delivery
service workers
Web Push
FCM
APNs
backend events
notification persistence
read/unread storage
permissions
routing
analytics
```

---

# 1. Scope

```text
Notifications
├── Notification
│   ├── Basic
│   ├── Compact
│   ├── Full Layout
│   ├── With Icon
│   ├── With Avatar
│   ├── With Image
│   ├── With Timestamp
│   ├── With Subtitle
│   ├── With Actions
│   ├── Clickable
│   ├── Dismissible
│   └── Persistent
│
├── Notification Banner
│   ├── Top
│   ├── Bottom
│   ├── Sticky
│   └── Temporary
│
├── Notification Stack
│   ├── Multiple Notifications
│   ├── Max Visible
│   ├── Queue
│   └── Dismiss
│
├── Notification Center
│   ├── Notification List
│   ├── Read
│   ├── Unread
│   ├── Group
│   ├── Section
│   └── Empty State
│
├── Notification Actions
│   ├── Primary Action
│   ├── Secondary Action
│   ├── Close
│   └── Overflow
│
└── Notification States
    ├── Info
    ├── Success
    ├── Warning
    ├── Danger
    ├── Loading
    ├── Read
    └── Unread
```

---

# 2. Existing primitives audit

Antes de implementar revisar:

```text
Toast
Alert
Callout
Banner Card
List
Avatar
Badge
Status Dot
Icon
IconButton
Button
Dropdown
Popover
Drawer
Sheet
BottomNav
AppBar
Stack
Cluster
Media
Meta
```

No duplicar estos primitives.

---

# 3. Notification vs Toast vs Alert

Documentar claramente:

```text
Toast
→ small transient feedback

Notification
→ richer app event/message

Alert
→ inline contextual warning/feedback

Notification Banner
→ temporary/persistent message near viewport edge

Notification Center
→ collection/history of notifications
```

---

# 4. Core Notification primitive

Crear un primitive genérico:

```text
orp-notification
```

Debe ser CSS-first siempre que no exista comportamiento.

---

# 5. Suggested structure

```text
orp-notification
├── media
│   ├── icon
│   └── avatar
├── content
│   ├── header
│   │   ├── title
│   │   └── time
│   ├── subtitle
│   └── message
├── actions
└── close
```

---

# 6. Mobile notification visual language

La notificación debe poder adoptar un look moderno tipo móvil:

```text
rounded
elevated
compact
soft surface
clear hierarchy
timestamp aligned to edge
large radius
touch-friendly
```

pero sin copiar exactamente iOS/Android/Framework7.

---

# 7. Generic visual identity

ORP debe tener identidad propia.

No crear:

```text
orp-notification--ios
orp-notification--android
orp-notification--framework7
```

en core.

---

# 8. Core content

Soportar:

```text
title
subtitle
message
timestamp
icon
avatar
image
actions
close
```

La aplicación provee el contenido y formato del timestamp.

---

# 9. Layouts

Implementar únicamente layouts genéricos:

```text
default
compact
full
```

Evitar variantes de dominio.

---

# 10. Actions composition

Reutilizar:

```text
Button
IconButton
Dropdown
```

No crear estilos paralelos de botones.

---

# 11. Vertical actions

En mobile permitir acciones verticales cuando:

```text
hay varias acciones
labels son largos
ancho disponible es pequeño
```

Reutilizar patrones de Parte 21.7.

---

# 12. Clickable Notification

Si representa navegación:

usar `<a>`.

Si representa una acción:

usar `<button>`.

No usar `<div @click>`.

---

# 13. Nested interactions

Si hay actions internas, no envolver toda la notificación en un enlace.

Usar área principal navegable + acciones separadas.

---

# 14. Dismissible Notification

Agregar control de cierre reutilizando IconButton.

Playground puede usar:

```text
bi-x-lg
```

No usar `×` como control visual legado.

---

# 15. CSS-first vs Vue

Una notificación estática debe funcionar solo con HTML + LESS.

Crear `OrpNotification.vue` únicamente si comportamiento real lo justifica.

---

# 16. Notification Banner

Agregar un patrón de banner de notificación para:

```text
top
bottom
in-flow
fixed
temporary
persistent
```

No duplicar Toast.

---

# 17. Safe areas

Top/Bottom banners deben respetar:

```text
env(safe-area-inset-top)
env(safe-area-inset-bottom)
```

y la arquitectura de App Shell.

---

# 18. Bottom navigation compensation

Si existe BottomNav fixed:

usar tokens/regiones existentes.

No hardcodear offsets.

---

# 19. Notification Stack

Agregar comportamiento de stack para múltiples notificaciones.

Posiciones razonables:

```text
top-start
top-center
top-end
bottom-start
bottom-center
bottom-end
```

En mobile priorizar top/bottom full-width-with-margin.

---

# 20. Max visible + queue

Permitir un límite visible, por ejemplo 3.

Las demás pueden permanecer en cola.

No mostrar 20 overlays simultáneamente.

---

# 21. Notification Manager

Puede justificarse:

```text
useOrpNotifications()
```

con API imperativa pequeña:

```js
const notifications = useOrpNotifications()

const item = notifications.show({
  title: 'Upload complete',
  message: 'Your file is ready.'
})

item.close()
item.update({...})
```

---

# 22. Temporary vs Persistent

Soportar:

```text
auto-dismiss
persistent
```

Las notificaciones accionables no deben desaparecer demasiado rápido.

---

# 23. Timers

Si hay auto-dismiss:

- pausar mientras el usuario interactúa con la notificación cuando sea razonable,
- limpiar timers al desmontar,
- no depender de animaciones para la lógica.

---

# 24. Click to close

Puede existir opción:

```text
closeOnClick
```

si no entra en conflicto con navegación o acciones.

---

# 25. Close callbacks / reasons

Si aporta valor, emitir una razón clara:

```text
manual
timeout
action
programmatic
```

No inflar la API sin necesidad.

---

# 26. Notification tones

Soportar:

```text
neutral
info
success
warning
danger
```

Usar tokens semánticos existentes.

No depender solo de color.

---

# 27. Loading notification

Reutilizar Spinner.

Ejemplo:

```text
Uploading file…
```

---

# 28. Updateable notifications

Debe soportarse el patrón:

```text
Uploading…
→ Processing…
→ Complete
```

mediante actualización programática.

---

# 29. Progress notification

Reutilizar Progress.

La aplicación provee el porcentaje.

ORP solo lo muestra.

---

# 30. Notification Center

Crear patrones de composición para una vista persistente de notificaciones.

Usar:

```text
Page
Section
List
Notification
Empty
Tabs/Segmented
```

según sea necesario.

No implementar persistencia ni backend.

---

# 31. Read / Unread

Soportar estado visual:

```text
read
unread
```

La aplicación controla el estado real.

---

# 32. Unread indication

No depender solo del color.

Puede combinar:

```text
status dot
font weight
label
```

---

# 33. Groups

Permitir composición por:

```text
Today
Yesterday
Earlier
```

pero la aplicación calcula grupos/fechas.

---

# 34. Mark as read

ORP emite la interacción.

La app actualiza store/backend.

---

# 35. Empty center

Reutilizar Empty State.

---

# 36. Notification badge

No crear `OrpNotificationBell`.

Componer:

```text
IconButton + Badge
```

en AppBar.

---

# 37. Desktop notification center

Puede componerse como:

```text
Popover + Notification List
```

---

# 38. Mobile notification center

Puede componerse como:

```text
Sheet + Notification Center
```

No crear Drawer/Sheet paralelo.

---

# 39. Web Push boundary

ORP UI NO:

```text
solicita permisos
registra service workers
usa PushManager
usa Firebase Messaging
usa Browser Notification API
```

---

# 40. Browser Notification vs ORP Notification

Documentar:

```text
new Notification()
→ OS/browser-level notification

OrpNotification
→ in-app notification UI
```

---

# 41. Accessibility

No usar `role="alert"` para todas las notificaciones.

Definir estrategia de live regions según importancia.

Notificaciones históricas del Notification Center no son live regions.

---

# 42. Interactive notifications

No deben usar:

```text
focus trap
scroll lock
aria-modal
```

Son no modales.

---

# 43. Close accessibility

El botón de cierre debe tener accessible name.

Ejemplo:

```text
Dismiss notification
```

localizable/configurable.

---

# 44. Touch

Acciones y cierre deben mantener targets adecuados.

---

# 45. Focus

Mantener `focus-visible` claro y no robar foco cuando aparece una notificación.

---

# 46. Escape

No implementar un listener global de Escape para vaciar el stack.

Si se implementa algún comportamiento de Escape, debe ser local y justificado.

---

# 47. Responsive

Probar:

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

# 48. RTL

Probar:

```text
media
timestamp
actions
close
stack positions
```

Usar logical properties.

---

# 49. Themes

Obligatorio:

```text
Light
Dark
Custom
```

---

# 50. Glass / translucency

Puede existir como mejora opcional solo si ORP ya soporta superficies translúcidas.

Debe tener fallback opaco y buen contraste.

---

# 51. Motion

Reutilizar tokens de motion.

Respetar:

```text
prefers-reduced-motion
```

No añadir librerías.

---

# 52. Z-index

Usar la arquitectura semántica de overlays existente.

Auditar convivencia con:

```text
Dropdown
Popover
Toast
Notification
Modal
Dialog
Sheet
```

No usar valores arbitrarios gigantes.

---

# 53. Notification vs Toast coexistence

Auditar si comparten infraestructura interna.

Objetivo:

```text
Toast
→ compact feedback

Notification
→ richer message/event
```

No construir dos managers idénticos.

---

# 54. Potential internal manager reuse

Si Toast ya tiene:

```text
timers
queue
host
transitions
close/update
```

reutilizar internals cuando tenga sentido.

No romper su API pública.

---

# 55. CSS architecture

Posibles archivos:

```text
less/components/notification.less
less/components/notification-stack.less
```

Separar solo si mejora mantenimiento.

---

# 56. Vue architecture

Posibles:

```text
src/components/feedback/OrpNotification.vue
src/components/feedback/OrpNotificationHost.vue
src/composables/useOrpNotifications.js
```

solo si la arquitectura lo justifica.

---

# 57. Host

Si hay manager imperativo:

```text
OrpNotificationHost
```

renderiza el stack.

La aplicación lo monta explícitamente.

No crear una segunda Vue app dentro de `document.body`.

---

# 58. SSR

No acceder a:

```text
window
document
```

durante module evaluation.

Timers solo en client.

---

# 59. Security

Mensajes como texto por defecto.

No `v-html`.

Para contenido avanzado usar slots/component composition.

---

# 60. Playground

Agregar categoría:

```text
Notifications
```

con demos:

```text
Basic
Compact
Full Layout
With Icon
With Avatar
With Image
With Actions
Dismissible
Click to Close
Persistent
Loading
Progress
Stack
Top Banner
Bottom Banner
Notification Center
Read / Unread
Dark Theme
```

---

# 61. Mandatory mobile-style demo

Crear un ejemplo visual comparable conceptualmente a una notificación móvil:

```text
[icon]  Application                  now
        Subtitle
        Notification message
```

Debe verse moderno, elevado, redondeado y táctil, pero con identidad ORP propia.

---

# 62. Full layout demo

Mostrar:

```text
icon/avatar
title
subtitle
message
actions
close
```

---

# 63. Required interaction demos

Obligatorios:

```text
With close button
Click to close
Callback/event on close
Persistent
Programmatic update
Stack
```

---

# 64. Notification Center demo

Mostrar:

```text
Today
Earlier
Unread
Read
Empty
```

---

# 65. AppBar composition demo

Mostrar:

```text
IconButton + Badge
```

para campana/contador.

No crear componente adicional.

---

# 66. Bootstrap audit

Playground NO debe usar clases Bootstrap CSS como:

```text
alert
toast
card
btn
d-flex
p-*
m-*
position-fixed
```

Bootstrap Icons sí están permitidos.

---

# 67. Tests

Ejecutar suite de Parte 17 y añadir pruebas de:

```text
show
close
manual dismiss
auto dismiss
persistent
click to close
actions
update
stack
queue/max-visible if implemented
cleanup
stable ids
```

---

# 68. Accessibility tests

Cubrir:

```text
accessible title/message
dismiss label
button semantics
live-region behavior
non-modal behavior
focus
keyboard
contrast
```

---

# 69. Visual regression

Fixtures sugeridos:

```text
notification-basic-light
notification-basic-dark
notification-full
notification-actions
notification-avatar
notification-loading
notification-progress
notification-stack
notification-mobile-top
notification-mobile-bottom
notification-center
notification-center-unread
```

---

# 70. Documentation

Crear/adaptar:

```text
docs/notifications/
├── overview.md
├── notification.md
├── banners.md
├── stack.md
├── actions.md
├── notification-center.md
├── read-unread.md
├── manager.md
├── accessibility.md
└── web-push-boundary.md
```

---

# 71. Decision guide

Documentar:

```text
Toast vs Notification
Alert vs Notification
Notification vs Dialog
Banner vs Notification
Notification Stack vs Notification Center
Browser Notification API vs ORP Notification
```

---

# 72. Completion criteria

Parte 21.8 termina cuando ORP UI pueda ofrecer:

```text
mobile-style notification
compact/full layouts
icon/avatar/image
timestamp/subtitle/message
actions
dismiss
click-to-close
temporary/persistent
loading/progress
programmatic update
notification stack
queue/max-visible if justified
top/bottom banners
notification center
read/unread
AppBar badge composition
```

sin convertirse en un sistema de push/backend.

---

# 73. Result expected

Al finalizar entregar:

## Existing Feedback Audit
Toast/Alert/Callout revisados.

## Architecture
Notification vs Toast vs Alert.

## Notification Primitive
API final.

## Vue Component
Si se creó y por qué.

## Notification Manager
API final.

## Notification Host
Si existe.

## Layouts
Compact/Full.

## Actions
Resultado.

## Dismiss
Resultado.

## Temporary/Persistent
Resultado.

## Updateable Notifications
Resultado.

## Stack
Resultado.

## Queue
Resultado si aplica.

## Banner
Top/Bottom.

## Loading/Progress
Resultado.

## Notification Center
Resultado.

## Read/Unread
Resultado.

## AppBar Integration
Badge composition.

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

# 74. Explicit exclusions

NO implementar:

```text
Web Push backend
Push API
Firebase Cloud Messaging
APNs
Service Worker registration
browser permission prompts
Notification API wrapper
email notifications
SMS notifications
database persistence
read/unread backend
analytics backend
cross-device sync
real-time WebSocket transport
SSE transport
native mobile push
gesture/swipe engine
```

---

# 75. No new dependencies

No instalar:

```text
Notyf
Notistack
Vue Toastification
SweetAlert
Framework7
```

ORP debe construir esta capa con sus primitives actuales.

---

# 76. Do not continue automatically

No implementar Parte 22.

Terminar con reporte técnico.

---

# Regla final

Mantener esta separación:

```text
External event
      ↓
Application
      ↓
ORP Notification Manager
      ↓
Notification Stack / Banner / Center
      ↓
User
```

Y:

```text
ORP UI
→ visual notification
→ timing
→ stacking
→ actions
→ dismiss
→ accessibility

Application
→ source of event
→ persistence
→ routing
→ backend action
→ read/unread storage

Platform
→ Web Push / OS notification
```

La meta es que ORP pueda mostrar notificaciones con la calidad visual de una app móvil moderna, sin convertirse en un servicio de notificaciones push.

