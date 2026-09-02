# SKILL — ORP UI / Parte 21.6: Video, Audio & Rich Media Components

## Objetivo

Agregar a ORP UI una capa moderna, reusable y accesible para **video, audio y rich media**, basada primero en APIs nativas del navegador y sin convertir ORP en un motor de streaming.

Esta fase debe permitir construir:

```text
video players
audio players
video cards
media previews
playlists
course/media viewers
marketing video sections
media galleries
```

sin introducir componentes específicos de negocio.

ORP UI debe encargarse de:

```text
player UI
controls
layout
interaction
keyboard UX
accessibility
loading/error states
responsive behavior
theming
fullscreen/PiP presentation
```

El navegador o la aplicación siguen siendo responsables de:

```text
media source URLs
streaming infrastructure
HLS/DASH engines
DRM
transcoding
CDN
analytics
ads
permissions
backend
```

---

# 1. Scope

```text
Rich Media
├── Video Player
│   ├── Poster
│   ├── Controls
│   ├── Play / Pause
│   ├── Timeline / Scrubber
│   ├── Current Time
│   ├── Duration
│   ├── Volume
│   ├── Mute
│   ├── Fullscreen
│   ├── Picture in Picture
│   ├── Captions
│   └── Playback Speed
│
├── Audio Player
│   ├── Play / Pause
│   ├── Timeline
│   ├── Time
│   ├── Volume
│   └── Playback Speed
│
├── Media Presentation
│   ├── Video Poster
│   ├── Video Thumbnail
│   ├── Video Card
│   ├── Media Meta
│   ├── Media Actions
│   └── Playlist
│
└── States
    ├── Loading
    ├── Buffering
    ├── Error
    ├── Unsupported
    └── Empty
```

---

# 2. Existing primitives first

Auditar antes de crear:

```text
orp-media
orp-media-card
orp-card
orp-icon
orp-icon-btn
orp-btn
orp-range
orp-progress
orp-spinner
orp-skeleton
orp-empty
orp-alert
orp-meta
orp-badge
orp-list
orp-toolbar
orp-dropdown
orp-popover
orp-lightbox
orp-grid
orp-stack
orp-cluster
```

No duplicarlos.

---

# 3. Architecture

Mantener:

```text
Browser Media API
        ↓
OrpVideoPlayer / OrpAudioPlayer
        ↓
ORP controls and presentation
        ↓
Application
```

La aplicación proporciona fuentes y lógica externa.

---

# 4. Native-first

Usar primero:

```html
<video>
<audio>
<track>
```

y APIs nativas.

No recrear decodificación/media playback.

---

# 5. Video Player

En esta fase sí puede justificarse:

```text
OrpVideoPlayer.vue
```

porque coordina estado real del elemento `<video>`.

---

# 6. Video responsibilities

Puede coordinar:

```text
play
pause
currentTime
duration
volume
muted
buffering
ended
fullscreen
picture-in-picture
playbackRate
text tracks
```

---

# 7. Video does not own

NO debe manejar internamente:

```text
API fetch
authorization
signed URL generation
video analytics backend
DRM
transcoding
adaptive bitrate
ads
```

---

# 8. Basic API

Referencia conceptual:

```vue
<OrpVideoPlayer
  src="/video.mp4"
  poster="/poster.jpg"
  preload="metadata"
  :autoplay="false"
  :muted="false"
  :loop="false"
/>
```

Adaptar a convenciones reales de ORP.

---

# 9. Sources

Debe considerarse soporte para HTML nativo:

```html
<source>
```

sin crear API exageradamente compleja.

Puede aceptar:

```text
src
type
```

o slots/sources si la arquitectura lo justifica.

---

# 10. Multiple sources

Si se soportan:

```text
MP4
WebM
```

usar `<source>` nativo.

No seleccionar codecs manualmente.

---

# 11. Poster

Usar:

```text
poster
```

nativo cuando corresponda.

ORP puede añadir overlay de play.

---

# 12. Poster overlay

Debe permitir:

```text
play icon
optional duration
optional title/meta
```

sin convertirlo en business card.

---

# 13. Play / Pause

Usar Button/IconButton existente visualmente.

No crear estilo de botón separado.

---

# 14. Icons

Playground puede usar Bootstrap Icons:

```text
bi-play-fill
bi-pause-fill
bi-volume-up-fill
bi-volume-mute-fill
bi-fullscreen
bi-fullscreen-exit
bi-picture-in-picture
bi-badge-cc
bi-speedometer2
```

Core sigue icon-library agnostic.

---

# 15. Playback state

Sincronizar con eventos reales:

```text
play
pause
ended
```

No asumir que `video.play()` siempre tiene éxito.

---

# 16. play() promise

Manejar rechazo de:

```js
video.play()
```

sin romper UI.

Autoplay puede ser bloqueado por navegador.

---

# 17. Autoplay

No forzar autoplay.

Si se usa:

documentar restricciones del navegador.

---

# 18. Muted autoplay

La aplicación decide si usa:

```text
autoplay + muted
```

ORP no lo activa automáticamente.

---

# 19. Timeline / Scrubber

Reutilizar Range de Parte 15 si es apropiado.

No crear slider engine nuevo.

---

# 20. Timeline value

Conceptualmente:

```text
min = 0
max = duration
value = currentTime
```

---

# 21. Seeking

Al cambiar timeline:

```js
video.currentTime = value
```

---

# 22. Scrubbing UX

Evitar actualizaciones costosas innecesarias.

Debe funcionar con:

```text
mouse
touch
keyboard
```

gracias al input range nativo.

---

# 23. Buffered ranges

Puede visualizarse opcionalmente.

No es requisito si complica Range existente.

---

# 24. Progress vs scrubber

Documentar:

```text
Progress
→ read-only playback progress

Range
→ interactive seeking
```

El player necesita Range para seek.

---

# 25. Time display

Mostrar:

```text
current time
duration
```

Ejemplo:

```text
01:24 / 05:36
```

---

# 26. Time formatting

Puede existir helper interno pequeño:

```text
formatMediaTime(seconds)
```

porque es comportamiento específico del player y reutilizable.

---

# 27. Time helper

Debe manejar:

```text
NaN
Infinity
0
minutes
hours
```

---

# 28. Duration unknown

Antes de metadata:

mostrar estado apropiado.

No renderizar:

```text
NaN:NaN
```

---

# 29. Volume

Usar Range o control nativo estilizado.

Rango:

```text
0..1
```

---

# 30. Mute

Mute y volume deben sincronizarse.

Si usuario cambia volumen desde browser/API externa, UI debe actualizarse mediante eventos.

---

# 31. volumechange

Escuchar:

```text
volumechange
```

---

# 32. Volume mobile

En algunos dispositivos/browser el volumen puede estar controlado por sistema.

La UI debe degradar correctamente.

---

# 33. Fullscreen

Usar Fullscreen API nativa.

Conceptualmente:

```js
element.requestFullscreen()
document.exitFullscreen()
```

---

# 34. Fullscreen feature detection

Antes de mostrar/usar control:

verificar soporte.

No asumir disponibilidad.

---

# 35. Fullscreen state

Escuchar:

```text
fullscreenchange
```

---

# 36. Fullscreen target

Preferir fullscreen del player container para conservar controles custom.

---

# 37. Picture in Picture

Usar API nativa cuando exista.

Conceptualmente:

```js
video.requestPictureInPicture()
document.exitPictureInPicture()
```

---

# 38. PiP feature detection

Control solo cuando sea soportado.

No mostrar botón roto.

---

# 39. PiP events

Sincronizar:

```text
enterpictureinpicture
leavepictureinpicture
```

si se implementa.

---

# 40. Captions

Usar `<track>` nativo.

Ejemplo:

```html
<track
  kind="captions"
  srclang="es"
  label="Español"
/>
```

---

# 41. Captions are important

No tratarlas como decoración.

Player debe permitir activar/desactivar tracks disponibles si se construyen controles custom.

---

# 42. Text tracks

Usar:

```text
video.textTracks
```

cuando sea necesario.

No crear parser WebVTT.

---

# 43. WebVTT

El navegador procesa WebVTT.

ORP no implementa parser.

---

# 44. Caption menu

Puede reutilizar:

```text
Dropdown
```

para seleccionar:

```text
Off
English
Español
```

---

# 45. Caption styling

Evitar interferir agresivamente con preferencias del usuario.

Si se estilizan cues:

hacerlo con cautela.

---

# 46. Playback speed

Permitir valores comunes:

```text
0.5
0.75
1
1.25
1.5
2
```

---

# 47. Speed menu

Reutilizar Dropdown.

No crear menu propio.

---

# 48. playbackRate

Sincronizar con:

```text
ratechange
```

---

# 49. Keyboard controls

Cuando el player tiene foco/contexto apropiado, considerar:

```text
Space / K → play/pause
ArrowLeft → seek backward
ArrowRight → seek forward
ArrowUp → volume up
ArrowDown → volume down
M → mute
F → fullscreen
C → captions
```

---

# 50. Keyboard caution

No capturar teclas globalmente indiscriminadamente.

Shortcuts deben funcionar solo cuando player está activo/enfocado según estrategia definida.

---

# 51. Inputs inside player

Si foco está en:

```text
Range
Button
Dropdown
```

no romper comportamiento nativo con shortcuts globales.

---

# 52. Space

No impedir Space de un Button.

---

# 53. Seek interval

Puede usar:

```text
5s
```

como default razonable si se implementan shortcuts.

Idealmente configurable sin sobrecargar API.

---

# 54. Accessibility

Player custom debe ser al menos tan usable como controls nativos.

Si no puede garantizarse, permitir:

```text
native controls
```

como fallback.

---

# 55. Native controls fallback

Considerar prop:

```text
controls="native"
```

o estrategia equivalente solo si encaja con API.

No complicar sin necesidad.

---

# 56. Control labels

Icon buttons requieren labels:

```text
Play
Pause
Mute
Unmute
Enter fullscreen
Exit fullscreen
Picture in picture
Captions
Playback speed
```

localizados por aplicación/framework según estrategia existente.

---

# 57. No icon-only semantics

El icono no es accessible name.

---

# 58. Time accessibility

No anunciar cada `timeupdate` mediante `aria-live`.

Sería extremadamente molesto.

---

# 59. Buffering

Detectar mediante eventos:

```text
waiting
playing
canplay
```

según implementación.

---

# 60. Buffering UI

Puede mostrar Spinner existente sobre media.

No crear spinner nuevo.

---

# 61. Spinner regression

Confirmar que bugs previos de Spinner estén corregidos antes de usarlo como overlay.

---

# 62. Loading

Antes de metadata/poster:

puede usar Skeleton/Spinner según contexto.

---

# 63. Error state

Escuchar:

```text
error
```

del media element.

Mostrar estado genérico.

---

# 64. Media errors

No intentar diagnosticar backend/CDN internamente.

Emitir error/evento para aplicación.

---

# 65. Unsupported media

Mostrar fallback:

```text
This media cannot be played.
```

o copy configurable.

---

# 66. Empty source

No romper player.

Mostrar Empty/Error state apropiado.

---

# 67. Ended

Al terminar:

```text
show replay state
```

puede ser útil.

---

# 68. Replay

Reutilizar play control.

No crear botón especial si no hace falta.

---

# 69. Loop

Usar atributo nativo.

---

# 70. Preload

Permitir valores nativos:

```text
none
metadata
auto
```

No forzar `auto`.

---

# 71. playsinline

Mobile-first:

soportar:

```text
playsinline
```

especialmente iOS.

---

# 72. Controls auto-hide

Puede considerarse para player custom.

Debe ser simple.

No ocultar controles mientras:

```text
focused
keyboard navigation
menu open
paused
```

---

# 73. Auto-hide complexity

Si introduce demasiados bugs de accesibilidad, mantener controles visibles.

Correctness > cinematic effect.

---

# 74. Controls overlay

Usar gradiente/surface para legibilidad.

Debe ser theme-aware cuando corresponda.

---

# 75. Video aspect ratio

Reutilizar `orp-media`.

Soportar:

```text
16:9
4:3
1:1
9:16
custom
```

sin hardcodear solo 16:9.

---

# 76. Vertical video

Debe funcionar correctamente.

Importante para mobile/social content.

---

# 77. object-fit

Permitir:

```text
contain
cover
```

según pattern.

No recortar videos automáticamente.

---

# 78. Responsive video

Debe ser:

```text
max-inline-size: 100%
```

y adaptarse al container.

---

# 79. Video Player shell

Posible estructura:

```text
orp-video
├── orp-video__media
├── orp-video__poster
├── orp-video__state
└── orp-video__controls
    ├── primary
    ├── timeline
    └── actions
```

Adaptar a BEM real.

---

# 80. Controls desktop

Ejemplo:

```text
Play
Time
Timeline
Volume
Captions
Speed
PiP
Fullscreen
```

---

# 81. Controls mobile

No intentar meter todo en una sola línea.

Puede:

```text
hide non-essential visible controls
move secondary controls to Dropdown
wrap intelligently
```

sin JS breakpoint detection.

---

# 82. More menu

Usar:

```text
IconButton + Dropdown
```

para controles secundarios si es necesario.

---

# 83. No JS breakpoint

CSS decide layout.

No:

```js
if (window.innerWidth < 768)
```

---

# 84. Audio Player

Puede justificarse:

```text
OrpAudioPlayer.vue
```

si comparte suficientes comportamientos con Video.

---

# 85. Audit abstraction first

Antes de crear Video y Audio separados, evaluar si lógica común puede vivir en:

```text
useOrpMediaPlayer
```

sin forzar una abstracción visual común.

---

# 86. Shared media composable

Solo si reduce duplicación real de:

```text
play
pause
time
duration
volume
mute
rate
events
```

---

# 87. Avoid mega MediaPlayer

No crear un componente gigantesco lleno de:

```text
if video
if audio
```

si dos wrappers pequeños son más claros.

---

# 88. Audio structure

Conceptual:

```text
orp-audio
├── artwork optional
├── content
│   ├── title/meta
│   └── timeline
└── controls
```

---

# 89. Audio artwork

Reutilizar Media/Avatar según contexto.

No asumir música.

Puede ser:

```text
podcast
voice note
generic audio
```

---

# 90. Audio controls

```text
play/pause
timeline
time
volume
speed
```

---

# 91. Audio download

No agregar automáticamente.

Aplicación decide.

---

# 92. Waveform

NO implementar waveform engine.

Si se necesita:

integrar librería especializada en futuro.

---

# 93. Video Card

Parte 7 ya tiene MediaCard.

Antes de crear `orp-video-card`, verificar si:

```text
MediaCard
+
play overlay
+
duration
+
meta
```

lo resuelve.

Preferir composition.

---

# 94. Video Thumbnail

Pattern:

```text
orp-media
+
play overlay
+
duration badge
```

No necesariamente nuevo component.

---

# 95. Duration badge

Reutilizar Badge/Meta.

---

# 96. Media Meta

Reutilizar `orp-meta`.

Ejemplos:

```text
duration
resolution
date
author
```

La aplicación proporciona valores.

---

# 97. Playlist

Crear pattern de composición:

```text
orp-list
+
media thumbnail
+
title
+
duration
+
active state
```

No crear playlist engine.

---

# 98. Playlist responsibilities

ORP presenta:

```text
items
active item
states
```

La aplicación decide:

```text
next media
previous media
autoplay next
queue
```

---

# 99. Playlist Vue

No crear `OrpPlaylist.vue` si List + local application state lo resuelve.

---

# 100. Active playlist item

Usar estado semántico claro:

```text
aria-current
```

cuando represente media actual.

---

# 101. Playlist mobile

Puede vivir:

```text
below player
horizontal ScrollX
Sheet
```

según aplicación.

ORP no mueve playlist automáticamente.

---

# 102. Media Viewer

No duplicar GLightbox.

Para imágenes:

usar GLightbox existente.

Para video simple:

Video Player.

---

# 103. GLightbox video

Si GLightbox soporta video externo/interno y aplicación lo necesita:

documentar integración opcional.

No acoplar core.

---

# 104. Swiper

Puede usarse para:

```text
video thumbnails
media carousel
playlist previews
```

como integración externa.

No crear carousel.

---

# 105. YouTube / Vimeo

No integrar SDKs automáticamente.

Puede permitirse composición con:

```html
<iframe>
```

si aplicación lo requiere.

---

# 106. Embed component

NO crear `OrpYouTube` o `OrpVimeo` en core.

---

# 107. Responsive iframe

Reutilizar `orp-media`/aspect-ratio wrapper.

---

# 108. Embed security

Aplicación es responsable de:

```text
trusted URL
sandbox policy
allow attributes
privacy-enhanced embeds
```

---

# 109. HLS

HTML `<video>` puede soportar HLS nativamente en algunos browsers.

ORP no debe asumir soporte universal.

---

# 110. HLS.js

Fuera de core.

Puede integrarse externamente.

---

# 111. DASH

Fuera de core.

---

# 112. DRM

Fuera de core.

---

# 113. Streaming quality selector

No implementar si browser/player no expone múltiples qualities de forma simple.

Pertenece a HLS/DASH integration.

---

# 114. Subtitles selector

Sí puede existir porque usa text tracks nativos.

---

# 115. Audio tracks selector

Fuera de scope inicial.

---

# 116. Chapters

Puede soportarse mediante `<track kind="chapters">` en futuro.

No construir chapter navigation en esta fase salvo que resulte trivial tras audit.

---

# 117. Media Session API

No hacer requisito.

Podría documentarse como integración futura para audio.

---

# 118. Analytics

Player puede emitir eventos:

```text
play
pause
ended
seeked
error
```

La aplicación puede usarlos para analytics.

ORP no envía analytics.

---

# 119. Event API

Exponer eventos útiles sin duplicar todos los eventos nativos innecesariamente.

---

# 120. Native element access

Considerar `ref`/expose del media element si ORP conventions lo permiten.

Esto permite integraciones avanzadas sin inflar API.

---

# 121. SSR

No acceder a:

```text
window
document
HTMLMediaElement
```

durante module evaluation.

---

# 122. Browser APIs

Fullscreen/PiP deben verificarse solo en client.

---

# 123. Cleanup

Eliminar event listeners en unmount.

---

# 124. Source change

Cuando cambia `src`:

sincronizar estado correctamente.

No conservar duration/time del video anterior.

---

# 125. Race conditions

Evitar que eventos de source anterior dejen UI inconsistente.

---

# 126. Performance

No actualizar todo Vue tree en cada frame.

`timeupdate` nativo suele ser suficiente.

No usar `requestAnimationFrame` continuo salvo necesidad real.

---

# 127. Timeline precision

No necesita actualización de 60fps.

---

# 128. Media preload

No cargar archivos pesados automáticamente en Playground.

Usar assets pequeños/locales.

---

# 129. Playground assets

No CDN.

Usar media local determinista con licencia/propiedad adecuada para el proyecto.

---

# 130. Themes

Probar:

```text
Light
Dark
Custom
```

---

# 131. Player surface

Video suele ser visualmente oscuro por naturaleza, pero controles no deben hardcodear una arquitectura incompatible con themes.

---

# 132. Overlay contrast

Controles sobre video deben conservar legibilidad con contenido claro u oscuro.

Puede usarse overlay/gradient neutral apropiado.

---

# 133. Data colors

No usar `--orp-data-*` de Parte 21 para controles.

Esos tokens son para visualización de datos.

---

# 134. Semantic tokens

Usar tokens ORP apropiados para:

```text
surface
foreground
muted
border
ring
danger
```

---

# 135. Motion

Usar motion tokens actuales.

---

# 136. Reduced motion

Respetar:

```text
prefers-reduced-motion
```

en:

```text
control transitions
poster overlay
menus
loading UI
```

No altera reproducción del video automáticamente.

---

# 137. Accessibility — captions

Player debe funcionar con tracks.

No esconder captions detrás de interacción inaccesible.

---

# 138. Accessibility — keyboard

Todo control debe ser alcanzable.

Orden lógico:

```text
play
timeline
volume
secondary actions
```

o equivalente razonable.

---

# 139. Accessibility — focus

Usar `focus-visible` y `--orp-ring`.

---

# 140. Accessibility — controls visibility

No auto-ocultar controles mientras un control interno tiene foco.

---

# 141. Accessibility — touch

Targets adecuados.

Especialmente:

```text
play
mute
captions
fullscreen
```

---

# 142. Accessibility — status

No usar `aria-live` para cada buffering/time change.

Errores importantes sí pueden comunicarse apropiadamente.

---

# 143. Accessibility — poster

Poster es parte visual del video.

No duplicar alt text si el `<video>` ya tiene contexto accesible.

---

# 144. Video title

El contexto alrededor del player debe proporcionar título cuando sea necesario.

No inventarlo desde filename.

---

# 145. Audio title

Misma regla.

---

# 146. RTL

Probar:

```html
dir="rtl"
```

en controls/layout.

---

# 147. Timeline direction

No invertir automáticamente el significado temporal solo por RTL.

Playback sigue avanzando de inicio a fin según convención del control/browser.

Auditar comportamiento del range nativo.

---

# 148. Time strings

No reordenarlas arbitrariamente.

---

# 149. Responsive matrix

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

# 150. Landscape

Obligatorio probar video en mobile landscape.

---

# 151. Fullscreen mobile

Probar donde browser/tooling lo permita.

Documentar limitaciones del entorno de tests.

---

# 152. Vertical video demo

Agregar demo 9:16.

---

# 153. Audio mobile

Probar 320px con labels/time largos.

---

# 154. CSS architecture

Posibles archivos:

```text
less/components/
├── video.less
├── audio.less
└── media-player.less
```

No crear los tres si uno/dos bastan.

---

# 155. Vue architecture

Posibles:

```text
src/components/media/OrpVideoPlayer.vue
src/components/media/OrpAudioPlayer.vue
```

y quizá:

```text
src/composables/useOrpMediaPlayer.js
```

solo si audit demuestra reutilización real.

---

# 156. Public exports

Exportar componentes reales desde entry point.

---

# 157. No plugin requirement

No `app.use()` obligatorio.

---

# 158. Native controls compatibility

No aplicar CSS global a:

```text
video
audio
```

que afecte aplicaciones fuera de ORP.

Todo scoped bajo clases `orp-*`.

---

# 159. Third-party player compatibility

ORP core no debe romper:

```text
Video.js
Plyr
HLS.js
Shaka
```

si una aplicación los usa por separado.

---

# 160. No global media selectors

Evitar:

```css
video { ... }
audio { ... }
```

salvo reset mínimo ya existente y justificado.

Preferir:

```text
.orp-video
.orp-audio
```

---

# 161. Playground

Agregar categoría:

```text
Rich Media
```

---

# 162. Playground sections

```text
Video Player
Video States
Vertical Video
Captions
Playback Speed
Audio Player
Video Cards
Playlist
Media Integrations
```

---

# 163. Video basic demo

Mostrar:

```text
poster
play/pause
timeline
time
volume
fullscreen
```

---

# 164. Advanced controls demo

Mostrar si están soportados:

```text
PiP
captions
speed
```

---

# 165. Video states demo

Mostrar:

```text
loading
buffering
error
unsupported
ended/replay
```

sin depender de fallos de red aleatorios.

Estados deben poder simularse determinísticamente.

---

# 166. Vertical demo

Mostrar video:

```text
9:16
```

dentro de layout mobile.

---

# 167. Captions demo

Usar WebVTT local.

---

# 168. Audio demo

Mostrar:

```text
basic
with artwork
long title
playback speed
```

---

# 169. Video Card demo

Preferir MediaCard composition.

Mostrar:

```text
thumbnail
play overlay
duration
title
meta
```

---

# 170. Playlist demo

Usar List.

Mostrar:

```text
active
played
upcoming
```

solo como estados visuales genéricos.

---

# 171. Integration demo

Documentar:

```text
Swiper + media cards
GLightbox + media
external HLS player boundary
```

No instalar dependencias.

---

# 172. Bootstrap audit

No usar Bootstrap CSS:

```text
ratio
btn
card
d-flex
position-absolute
p-*
m-*
row
col-*
```

Permitido:

```text
bi
bi-*
```

---

# 173. Namespace

Mantener:

```text
orp-*
@orp-*
--orp-*
Orp*
data-orp-*
```

---

# 174. Tests

Ejecutar suite Parte 17.

---

# 175. Video unit/component tests

Cubrir:

```text
play
pause
time update
duration
seek
volume
mute
ended
error
source change
cleanup
```

---

# 176. Fullscreen tests

Mockear browser API si test environment no la soporta.

No hacer tests frágiles dependientes de fullscreen real.

---

# 177. PiP tests

Misma estrategia.

---

# 178. Captions tests

Cubrir selección de tracks si control custom existe.

---

# 179. Playback rate tests

Cubrir:

```text
rate selection
ratechange
```

---

# 180. Keyboard tests

Cubrir shortcuts implementados y asegurar que no interfieran con Buttons/Range/Dropdown.

---

# 181. Audio tests

Cubrir lógica compartida y controles principales.

---

# 182. Visual regression

Fixtures sugeridos:

```text
video-player-light
video-player-dark
video-player-mobile
video-player-landscape
video-player-vertical
video-buffering
video-error
video-captions-menu
audio-player-light
audio-player-dark
video-card
media-playlist
```

---

# 183. Reduced motion regression

Revisar controles/overlays/loading.

---

# 184. Theme regression

```text
Light
Dark
Custom
```

---

# 185. Responsive regression

Priorizar:

```text
320
375
390
430
768
992
1440
```

más landscape.

---

# 186. Browser testing

Cuando sea posible probar:

```text
Chromium
Firefox
WebKit
```

porque media APIs difieren.

---

# 187. Feature detection report

Reportar soporte detectado/limitaciones para:

```text
Fullscreen
PiP
text tracks
volume behavior
```

---

# 188. Documentation

Crear/adaptar:

```text
docs/media/
├── video-player.md
├── audio-player.md
├── captions.md
├── keyboard.md
├── fullscreen-pip.md
├── video-cards.md
├── playlists.md
├── streaming-integrations.md
└── accessibility.md
```

---

# 189. Decision guide

Documentar:

```text
Native controls vs OrpVideoPlayer
Video Player vs MediaCard
Video Player vs GLightbox
Native MP4 vs HLS integration
Progress vs Timeline
Video vs iframe embed
```

---

# 190. Native controls vs custom

```text
Native controls
→ simplest, maximum browser-native behavior

OrpVideoPlayer
→ consistent ORP visual language and controls
```

Permitir elegir.

---

# 191. Video Player vs MediaCard

```text
MediaCard
→ preview/navigation

VideoPlayer
→ actual playback
```

---

# 192. Video Player vs GLightbox

```text
VideoPlayer
→ embedded playback

GLightbox
→ expanded/lightbox presentation
```

---

# 193. Native source vs streaming

```text
MP4/WebM
→ native video

HLS/DASH/DRM
→ specialized integration
```

---

# 194. Timeline vs Progress

```text
Timeline/Range
→ user can seek

Progress
→ display only
```

---

# 195. iframe vs Video

```text
Owned/direct media URL
→ video element

YouTube/Vimeo/etc.
→ provider embed/integration
```

---

# 196. Security

No usar `v-html` para:

```text
titles
captions labels
media metadata
playlist labels
```

---

# 197. Media URLs

ORP accepts URLs supplied by application.

Application is responsible for trust/access policies.

---

# 198. Cross-origin

Documentar que:

```text
CORS
captions
canvas extraction
streaming
```

pueden depender de configuración del servidor.

ORP no resuelve CORS.

---

# 199. DRM/security

No intentar bypass o manejar DRM.

---

# 200. Completion criteria

Parte 21.6 termina cuando ORP UI pueda proporcionar:

```text
modern HTML5 video player
play/pause
seek
time
volume/mute
fullscreen
PiP when supported
captions
playback speed
loading/buffering/error states
audio player
video preview/card composition
playlist composition
mobile/landscape/vertical video support
keyboard/accessibility
```

sin convertirse en streaming engine.

---

# 201. Result expected

Al finalizar entregar:

## Existing Media Audit

Primitives reutilizados.

## Architecture

Video/Audio/shared composable decision.

## Video Player

API final.

## Controls

Lista.

## Timeline

Implementación.

## Volume

Resultado.

## Fullscreen

Resultado.

## PiP

Resultado.

## Captions

Resultado.

## Playback Speed

Resultado.

## Keyboard

Shortcuts implementados.

## Audio Player

Resultado.

## Video Cards

Composición.

## Playlist

Composición.

## States

Loading/Buffering/Error/Unsupported.

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

Viewports + landscape + vertical.

## Themes

Light/Dark/Custom.

## RTL

Resultado.

## Reduced Motion

Resultado.

## Browser APIs

Feature detection/limitations.

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

# 202. Explicit exclusions

NO implementar:

```text
video transcoding
video hosting
CDN
HLS engine
DASH engine
DRM
adaptive bitrate engine
quality selector for streaming manifests
ad insertion
VAST
video analytics backend
watch history backend
recommendation engine
waveform engine
audio visualization
video editor
audio editor
screen recording
webcam recording
live streaming
WebRTC
video conferencing
subtitle editor
WebVTT parser
YouTube SDK wrapper
Vimeo SDK wrapper
Video.js clone
Plyr clone
```

---

# 203. No new dependencies

No instalar automáticamente:

```text
Video.js
Plyr
HLS.js
Shaka Player
Dash.js
WaveSurfer
```

La aplicación puede integrarlos cuando realmente sean necesarios.

---

# 204. Do not continue automatically

No implementar Parte 22.

Terminar con reporte técnico.

---

# Regla final

La arquitectura debe permanecer:

```text
Media Source
     ↓
Browser <video>/<audio>
     ↓
ORP Player UI
     ↓
User interaction
     ↓
Native Media API
```

Para streaming avanzado:

```text
Streaming Source
     ↓
Specialized Library
     ↓
HTMLMediaElement
     ↓
ORP-compatible presentation
```

ORP debe ofrecer una experiencia multimedia moderna sin intentar resolver problemas que pertenecen a un motor especializado de streaming.

```text
ORP UI
= controls + presentation + accessibility

Browser
= playback engine

Application
= source + business logic

Specialized library
= advanced streaming
```

