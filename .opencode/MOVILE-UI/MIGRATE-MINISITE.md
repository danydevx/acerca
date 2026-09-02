# SKILL — ORP UI / Parte 25: Dogfooding — Acerca Minisite Migration

## Objetivo

Usar **Acerca Minisite** como la primera aplicación real para validar ORP UI después de `v0.1.0`.

Ruta de referencia actual:

```text
/member/listings/{listing}/minisite/sections
```

Ejemplo local indicado:

```text
http://acerca.local/member/listings/2/minisite/sections
```

Actualmente el módulo utiliza una combinación de:

```text
Laravel
Blade
Bootstrap
LESS
JavaScript / Vue donde aplique
Swiper
GLightbox
Leaflet u otras integraciones existentes
```

El problema a resolver NO es simplemente reemplazar clases Bootstrap.

El problema es:

> Las secciones funcionan como sitio web, pero visualmente todavía no transmiten una experiencia de aplicación móvil.

Esta fase debe comprobar si ORP UI realmente puede resolver ese problema dentro de una aplicación existente.

---

# 1. Filosofía de esta fase

Esta es una fase de:

```text
DOGFOODING
```

ORP UI debe utilizarse en un producto real.

El objetivo es descubrir:

```text
bugs
API friction
missing primitives
composition problems
mobile UX problems
theme problems
integration problems
documentation gaps
```

que no aparecen fácilmente en Playground.

---

# 2. Regla principal

NO migrar todo el minisite inmediatamente.

Flujo obligatorio:

```text
AUDIT
   ↓
MAP
   ↓
SELECT PILOT
   ↓
IMPLEMENT PILOT
   ↓
COMPARE
   ↓
FIX ORP IF NECESSARY
   ↓
VALIDATE
   ↓
MIGRATE INCREMENTALLY
```

---

# 3. No hacer búsqueda y reemplazo

Está prohibido hacer una migración mecánica tipo:

```text
.card
→ .orp-card

.btn
→ .orp-btn

.container
→ .orp-container
```

sin analizar la composición.

Eso produciría:

```text
Bootstrap-looking site
with ORP class names
```

y NO una aplicación móvil.

---

# 4. Objetivo visual

El minisite debe sentirse como:

```text
mobile application
```

no como:

```text
responsive Bootstrap website
```

---

# 5. Características visuales esperadas

Buscar:

```text
strong mobile hierarchy
edge-to-edge sections where appropriate
native-feeling spacing
touch-first actions
app-style navigation
safe areas
bottom actions
sheets instead of desktop-like modals where appropriate
horizontal content
rich media
clear section rhythm
less "card inside card"
fewer boxed Bootstrap patterns
```

---

# 6. No eliminar Bootstrap globalmente

Bootstrap puede seguir existiendo en la aplicación.

Especialmente:

```text
admin
editor
forms
legacy screens
other modules
```

Esta fase debe demostrar convivencia:

```text
Bootstrap
+
ORP UI
```

sin conflictos.

---

# 7. Scope inicial

Primero localizar el código que genera:

```text
/member/listings/{listing}/minisite/sections
```

y el frontend/minisite relacionado.

Auditar:

```text
routes
controllers
Blade views
Vue components
LESS
JavaScript
Vite entries
section partials
section registry/configuration
preview
public minisite renderer
```

---

# 8. No asumir Blade-only

Aunque el usuario describió un layout Blade:

inspeccionar arquitectura real.

Puede existir:

```text
Blade
Vue
Inertia
JSON configuration
dynamic components
partials
```

No reestructurar antes de entenderla.

---

# 9. Architecture report

Antes de modificar código entregar un mapa:

```text
Route
  ↓
Controller
  ↓
View / Renderer
  ↓
Section Registry
  ↓
Section Template
  ↓
CSS
  ↓
JS behavior
```

con archivos reales.

---

# 10. Identify two experiences

Distinguir claramente:

```text
A. Section Editor / Admin

B. Rendered Minisite / Preview
```

No son necesariamente la misma UI.

---

# 11. Admin boundary

El editor puede continuar utilizando Bootstrap.

No migrarlo por obligación.

---

# 12. Minisite boundary

ORP UI debe utilizarse principalmente para:

```text
rendered mobile minisite
preview of rendered minisite
```

---

# 13. Shared markup

Si preview y frontend público comparten renderer:

mantener esa ventaja.

No duplicar templates innecesariamente.

---

# 14. Inventory current sections

Crear inventario real.

Ejemplo de tabla:

| Section | Template | CSS | JS | Bootstrap | External Lib | Status |
|---|---|---|---|---|---|---|

---

# 15. Do not invent section names

Usar las secciones reales encontradas en el proyecto.

---

# 16. Section classification

Clasificar cada sección:

```text
CONTENT
ACTION
NAVIGATION
MEDIA
SOCIAL
CONTACT
LOCATION
DATA
COMPOSITE
```

---

# 17. Bootstrap dependency audit

Por sección registrar clases Bootstrap utilizadas.

Buscar especialmente:

```text
container
container-fluid
row
col-*
d-flex
gap-*
p-*
m-*
card
btn
badge
list-group
modal
nav
navbar
accordion
ratio
ratio-*
```

---

# 18. Bootstrap behavior audit

También identificar JS Bootstrap:

```text
Modal
Collapse
Dropdown
Offcanvas
Tabs
Tooltip
```

---

# 19. LESS audit

Identificar:

```text
global minisite LESS
section LESS
legacy styles
hardcoded colors
hardcoded spacing
Bootstrap overrides
!important
high specificity
```

---

# 20. Existing visual patterns

Detectar patrones repetidos como:

```text
card + card-body
container + row + columns
button rows
section title
image + text
icon + label
list of links
gallery
contact actions
```

---

# 21. ORP mapping matrix

Crear:

```text
ORP-MIGRATION-MATRIX.md
```

Formato:

| Existing Pattern | Current Tech | ORP Primitive | Composition | Keep Bootstrap? | Action |
|---|---|---|---|---:|---|

---

# 22. Mapping decisions

Cada patrón debe terminar en:

```text
REUSE ORP
COMPOSE ORP
KEEP CURRENT
REFACTOR APP
ORP GAP
EXTERNAL INTEGRATION
```

---

# 23. ORP GAP

Usar `ORP GAP` únicamente cuando:

```text
real application need exists
AND
existing ORP primitives cannot compose it reasonably
```

---

# 24. No premature component creation

Antes de crear un componente ORP nuevo preguntar:

```text
Can existing primitives compose this?
```

Si sí:

NO crear componente.

---

# 25. ORP primitives expected to be evaluated

Según disponibilidad real:

```text
App Shell
AppBar
Page
Section
Stack
Cluster
Grid
Horizontal Scroll
Hero
Media
MediaCard
Card
List
Avatar
Badge
Chip
Meta
Button
IconButton
FAB
BottomNav
Tabs
Accordion
Sheet
Drawer
Dialog
Notification
Toast
Skeleton
Spinner
Progress
Image/Gallery primitives
Video/Audio
```

No asumir que todos están publicados.

---

# 26. External integrations

Mantener herramientas especializadas existentes.

Ejemplos:

```text
Swiper
→ carousel / horizontal media

GLightbox
→ gallery lightbox

Leaflet
→ maps
```

No recrearlas en ORP.

---

# 27. Mobile shell

Evaluar convertir el minisite renderizado en una estructura conceptual:

```text
orp-app
└── orp-app-shell
    ├── header / AppBar
    ├── main
    │   └── Page
    │       └── sections
    ├── bottom navigation
    └── floating actions
```

Solo usar las APIs reales.

---

# 28. AppBar

Evaluar si el minisite necesita AppBar.

Posibles contenidos:

```text
brand
profile name
back
share
more
favorite
```

La aplicación decide acciones reales.

---

# 29. BottomNav

NO agregar BottomNav por estética.

Usarlo solo si existe navegación real entre áreas principales.

---

# 30. FAB

Puede ser apropiado para una acción primaria como:

```text
contact
WhatsApp
booking
```

pero la decisión pertenece al producto.

---

# 31. Safe areas

Probar:

```text
iPhone-style viewport
bottom safe area
top safe area
```

cuando aplique.

---

# 32. Hero/Profile

La parte superior debe ser uno de los principales casos de prueba.

Evaluar composición:

```text
Hero
Avatar/Profile Photo
Logo
Name
Professional Meta
Badges
Primary Actions
```

---

# 33. Avoid hero card trap

No envolver automáticamente todo el Hero dentro de una card blanca con sombra.

Explorar:

```text
edge-to-edge media
surface transitions
floating profile image
action clusters
rich typography
```

según diseño actual.

---

# 34. Primary actions

Acciones típicas pueden incluir:

```text
WhatsApp
Phone
Email
Website
Share
```

Usar:

```text
Button
IconButton
Cluster
Horizontal Scroll
```

según espacio.

---

# 35. Touch-first

Objetivos táctiles adecuados.

No usar links diminutos estilo desktop.

---

# 36. Content sections

Cada sección debe analizarse por intención.

No todas necesitan Card.

---

# 37. Section rhythm

Usar:

```text
Page
Section
Stack
Divider
Section Header
```

para crear ritmo vertical.

---

# 38. Card reduction

Uno de los objetivos explícitos:

```text
reduce unnecessary cards
```

Bootstrap tiende a empujar:

```text
everything → card
```

ORP debe permitir superficies más naturales.

---

# 39. Lists

Para:

```text
contact info
social links
external links
services
actions
```

evaluar `List`.

---

# 40. List variants

Cuando correspondan:

```text
Divided
Inset
Composition
```

usar implementación actual, no markup legacy.

---

# 41. Rich list composition

Puede combinar:

```text
Avatar/Icon
Content
Title
Description
Meta
Badge
Action
Chevron
```

---

# 42. Navigation semantics

Si un item navega:

usar `<a>`.

Si ejecuta acción:

usar `<button>`.

---

# 43. Social links

No crear:

```text
OrpInstagramButton
OrpFacebookButton
```

Componer Button/IconButton + icon integration.

---

# 44. Icons

Bootstrap Icons pueden utilizarse como integración opcional.

Ejemplo:

```html
<i class="orp-icon bi bi-whatsapp" aria-hidden="true"></i>
```

si el proyecto ya los tiene.

---

# 45. Gallery

Usar ORP para:

```text
layout
surface
spacing
preview
```

y Swiper/GLightbox para comportamiento especializado.

---

# 46. Gallery mobile UX

Evaluar:

```text
horizontal scroll
Swiper
grid
full-width media
```

dependiendo del contenido.

---

# 47. Video

Si existen secciones de video:

usar primitives/player de ORP si están públicos.

---

# 48. External embeds

YouTube/Vimeo embeds deben mantenerse como responsabilidad de aplicación/integración.

ORP puede controlar:

```text
aspect ratio
surface
loading state
```

---

# 49. Maps

Leaflet sigue siendo responsable del mapa.

ORP controla composición alrededor del mapa.

---

# 50. Contact section

Evaluar experiencia más de app:

```text
List
actions
Sheet
Dialog
```

en lugar de formularios/cards desktop cuando sea apropiado.

---

# 51. Forms

Si el minisite tiene formulario:

usar ORP form foundation donde pueda convivir de forma segura.

---

# 52. Form migration

No mezclar dentro del mismo control:

```text
.form-control
+
orp input styles
```

sin revisar cascade.

---

# 53. Bootstrap coexistence strategy

Preferir aislamiento estructural.

Ejemplo conceptual:

```html
<div class="minisite">
    <div class="orp-app">
        ...
    </div>
</div>
```

---

# 54. No Bootstrap reset duplication

Auditar cómo Bootstrap afecta:

```text
buttons
headings
links
forms
images
tables
```

dentro de ORP.

---

# 55. Cascade conflicts

Registrar conflictos reales.

Crear:

```text
ORP-BOOTSTRAP-CONFLICTS.md
```

si aparecen suficientes casos.

---

# 56. Fix location rule

Si Bootstrap rompe ORP:

preferir corregir robustez de ORP cuando sea un conflicto genérico.

Si solo ocurre por markup específico del minisite:

corregir aplicación.

---

# 57. No !important war

No resolver convivencia agregando:

```css
!important
```

masivamente.

---

# 58. Theme

Probar minisite con:

```text
Light
Dark
Custom
```

si el producto lo soportará.

---

# 59. Brand color

El minisite probablemente tiene color configurable.

Mapearlo a runtime CSS variables.

Ejemplo conceptual:

```css
[data-orp-theme="minisite"] {
    --orp-primary: var(--listing-primary-color);
}
```

Adaptar a arquitectura real.

---

# 60. Dynamic branding

Evitar generar cientos de reglas CSS por listing.

Preferir CSS Custom Properties inline/scoped cuando sea seguro.

---

# 61. User-supplied colors

Validar que la app siga controlando:

```text
sanitization
validation
contrast strategy
```

ORP no debe confiar ciegamente en cualquier string CSS.

---

# 62. Typography

Si minisites permiten fuente configurable:

integrarla sin romper typography scale ORP.

---

# 63. Font boundary

Aplicación decide qué fuente cargar.

ORP consume `font-family` configurada/tokens.

---

# 64. Preview parity

El preview dentro del editor debe parecerse lo máximo posible al minisite público.

---

# 65. Same renderer preference

Si arquitectura permite:

```text
same markup
same ORP CSS
same theme vars
```

para preview y frontend.

---

# 66. Avoid iframe unless justified

No introducir iframe solo para aislar estilos sin evaluar costo.

---

# 67. If iframe already exists

No eliminarlo automáticamente.

Evaluar arquitectura actual.

---

# 68. Pilot selection

Antes de migrar todas las secciones seleccionar una sección piloto.

---

# 69. Ideal pilot

Debe tener suficiente complejidad para probar ORP:

```text
media
text
actions
icons
responsive
```

pero no ser la sección más compleja.

---

# 70. Candidate pilot

Hero/Profile puede ser buen candidato SI su implementación actual permite aislarlo.

Alternativamente elegir una sección real más segura.

---

# 71. Pilot report

Antes de continuar mostrar:

```text
Current implementation
Current Bootstrap dependencies
Proposed ORP composition
Files to modify
Expected visual improvement
Risks
```

---

# 72. Implement pilot

Migrar solo el piloto.

---

# 73. Do not migrate remaining sections yet

Después del piloto:

detener expansión y validar.

---

# 74. Pilot validation

Revisar:

```text
320
375
390
430
768
```

como mínimo.

---

# 75. Desktop

Aunque sea mobile-first:

no debe romperse en desktop.

---

# 76. Visual comparison

Comparar:

```text
BEFORE
AFTER
```

si tooling de screenshots ya existe.

---

# 77. Evaluation questions

Responder:

```text
Does it feel more like an app?
Is hierarchy clearer?
Are touch actions better?
Did CSS become simpler?
Did ORP compose naturally?
Did Bootstrap create conflicts?
Did we discover an ORP gap?
```

---

# 78. ORP friction log

Crear:

```text
ORP-DOGFOODING.md
```

---

# 79. Friction categories

Usar:

```text
BUG
API FRICTION
MISSING PRIMITIVE
COMPOSITION GAP
DOC GAP
BOOTSTRAP CONFLICT
THEME ISSUE
RESPONSIVE ISSUE
A11Y ISSUE
INTEGRATION ISSUE
```

---

# 80. Entry format

```text
ID
Category
Component
Scenario
Problem
Impact
Workaround
Recommended fix
Target version
```

---

# 81. Severity

```text
BLOCKER
HIGH
MEDIUM
LOW
```

---

# 82. ORP bug rule

Si el problema es claramente genérico del framework:

corregir ORP source.

---

# 83. App bug rule

Si el problema pertenece únicamente al minisite:

no contaminar ORP con workaround específico.

---

# 84. Missing primitive rule

Un missing primitive encontrado aquí tiene mucho más peso que uno imaginado desde una component checklist.

---

# 85. v0.1 patch

Si se detectan bugs sin breaking changes:

considerar:

```text
v0.1.1
```

después de validarlos.

No versionar automáticamente.

---

# 86. Breaking API issue

Si dogfooding descubre API seriamente problemática:

registrar para:

```text
v0.2
```

salvo que el proyecto aún no haya publicado/consumido v0.1 formalmente.

---

# 87. Migration plan

Si piloto funciona:

crear orden de migración de las demás secciones.

---

# 88. Migration priority

Priorizar:

```text
high visibility
high reuse
low risk
```

---

# 89. Suggested conceptual order

No usar si inventa secciones inexistentes.

Conceptualmente:

```text
1 Hero/Profile
2 Primary Actions
3 Links/List
4 Social
5 Gallery
6 Video
7 Contact
8 Location
9 complex/custom sections
```

Adaptar al inventario real.

---

# 90. Incremental batches

Migrar en batches pequeños.

Ejemplo:

```text
2–4 related sections
→ test
→ fix
→ continue
```

---

# 91. No big-bang migration

Evitar modificar 30 templates y luego intentar descubrir qué rompió.

---

# 92. Reuse compositions

Si varias secciones repiten exactamente una composición:

primero evaluar si debe existir como:

```text
application partial
```

antes de convertirlo en ORP component.

---

# 93. Application partials

Son válidos.

Ejemplo:

```text
minisite contact action
profile social link
```

puede ser app-specific composition.

---

# 94. ORP core purity

No agregar al framework:

```text
orp-vcard-profile
orp-listing-contact
orp-social-instagram
orp-minisite-section
```

---

# 95. Domain ownership

Acerca puede tener:

```text
acerca-profile
acerca-minisite-section
```

si necesita clases/components propios.

No usar namespace ORP para domain logic.

---

# 96. CSS layers

Auditar si el proyecto utiliza `@layer`.

Si no:

no introducirlo solo por moda.

---

# 97. Import order

Documentar orden real de estilos.

Ejemplo conceptual:

```text
Bootstrap
ORP UI
Application minisite styles
```

o el orden que resulte correcto tras pruebas.

---

# 98. Avoid overriding ORP unnecessarily

Application LESS debería extender composición/domain styling, no redefinir primitives completos.

---

# 99. Vite

Auditar entradas actuales.

No crear bundle duplicado si `minisite.less` / `minisite.js` ya existen.

---

# 100. Bundle strategy

Evaluar si ORP se importa:

```text
globally
minisite-only
per entry
```

Elegir lo más razonable para arquitectura actual.

---

# 101. Performance baseline

Antes de migración registrar cuando sea posible:

```text
CSS size
JS size
DOM size
LCP
CLS
interaction responsiveness
```

No convertir esta fase en auditoría Lighthouse completa.

---

# 102. Performance after pilot

Comparar cambios importantes.

---

# 103. No visual improvement at huge cost

Si ORP migration duplica todo Bootstrap CSS y empeora mucho el bundle:

registrarlo.

No ignorarlo.

---

# 104. Lazy integrations

Swiper/GLightbox/video/maps deberían cargarse razonablemente según arquitectura existente.

No reescribir loading strategy sin necesidad.

---

# 105. Skeleton

Usar Skeleton únicamente cuando realmente existe loading async.

No poner Skeleton decorativo porque ORP lo tiene.

---

# 106. Spinner

Misma regla.

---

# 107. Dialogs

Usar Dialog para decisiones/interacciones.

No reemplazar todo link/action por Dialog.

---

# 108. Sheets

En mobile pueden reemplazar ciertos paneles/modals cuando UX lo justifique.

---

# 109. Notifications

Usarlas para eventos reales:

```text
saved
copied
shared
action completed
```

No saturar experiencia.

---

# 110. Share

Si existe compartir vCard/minisite:

aplicación puede usar Web Share API con fallback.

ORP presenta acción/feedback.

---

# 111. Clipboard

Igual:

```text
Application → Clipboard API
ORP → Button + feedback
```

---

# 112. Accessibility

Cada sección migrada debe mejorar o mantener accessibility.

---

# 113. Heading hierarchy

Revisar estructura real del minisite.

No usar `<h2>` solo por tamaño visual.

---

# 114. Links

External links deben ser claros.

---

# 115. Images

Revisar:

```text
alt
width/height
loading
object-fit
```

según contenido.

---

# 116. Touch

Revisar targets de acciones.

---

# 117. Focus

Todos los controles interactivos deben mostrar focus visible.

---

# 118. Reduced motion

Swiper/animations/ORP transitions deben respetar estrategia existente cuando sea posible.

---

# 119. Screen readers

No usar icon-only buttons sin accessible name.

---

# 120. Mobile browser test

Idealmente validar:

```text
Chrome Android
Safari iOS
```

si infraestructura/dispositivos están disponibles.

Si no:

marcar como `NOT VERIFIED`.

---

# 121. PWA-like != fake native

El objetivo es experiencia mobile app-like.

No intentar engañar al usuario imitando píxel por píxel iOS/Android.

---

# 122. ORP identity

Mantener identidad visual propia de ORP/Acerca.

---

# 123. Design language

Buscar consistencia en:

```text
radius
surface
spacing
typography
motion
icons
touch behavior
navigation
```

---

# 124. Avoid over-animation

No agregar animaciones GSAP u otras solo para hacer que parezca app.

ORP motion system debe bastar para UI básica.

---

# 125. Section transitions

No son requisito.

---

# 126. Scroll

Preferir scroll natural del documento.

No convertir minisite en nested scroll container sin necesidad.

---

# 127. Sticky elements

Usar con cuidado:

```text
AppBar
BottomNav
actions
```

sin tapar contenido.

---

# 128. Bottom safe area

Obligatorio revisar si hay BottomNav/FAB/fixed actions.

---

# 129. Deep links

Routing/deep links pertenecen a Acerca.

ORP no debe asumir router.

---

# 130. Analytics

Analytics pertenece a aplicación.

No meter tracking en ORP.

---

# 131. Listing data

ORP no debe conocer:

```text
listing_id
vcard_team_id
business IDs
analytics IDs
```

---

# 132. Blade variables

Mantener business data en Blade/app.

Ejemplo conceptual:

```php
{{ $listing->name }}
```

dentro de markup ORP es válido.

---

# 133. Escaping

No debilitar escaping Blade durante migración.

---

# 134. User HTML

Si alguna sección permite HTML del usuario:

mantener sanitización existente.

No introducir `v-html` o `{!! !!}` sin auditar seguridad.

---

# 135. URLs

No alterar reglas de URLs/media/storage salvo necesidad real.

---

# 136. Existing functionality

La migración visual NO debe romper:

```text
editing
ordering
visibility
publishing
preview
links
gallery
maps
analytics
forms
```

---

# 137. Section ordering

Si secciones son configurables:

ORP no debe interferir con orden.

---

# 138. Section visibility

Mantener lógica existente.

---

# 139. Empty sections

No renderizar shells ORP vacíos si antes no se mostraban.

---

# 140. Empty states

Solo usar Empty State cuando el usuario final realmente necesita saber que no hay contenido.

---

# 141. Admin preview

Si el editor muestra dispositivos simulados:

auditar ancho real del preview.

---

# 142. Preview CSS isolation

Evitar que CSS del editor altere minisite.

---

# 143. Bootstrap admin vs ORP preview

Este es un caso crítico de coexistencia.

Probar:

```text
Bootstrap editor
containing
ORP minisite preview
```

---

# 144. CSS collision report

Registrar selectores que crucen boundary.

---

# 145. Root scoping

Si hace falta aislamiento adicional:

evaluar scope bajo root de minisite.

No duplicar todos los selectores manualmente sin necesidad.

---

# 146. Screenshots

Tomar capturas del piloto si testing tooling ya lo permite.

Guardar fixtures de regresión.

---

# 147. Visual regression fixture

Agregar caso específico:

```text
acerca-minisite-pilot
```

o naming consistente.

---

# 148. Theme fixtures

Si aplica:

```text
acerca-minisite-light
acerca-minisite-dark
acerca-minisite-brand
```

---

# 149. Mobile fixtures

Prioridad:

```text
375
390
430
```

---

# 150. Regression after ORP changes

Si dogfooding obliga a modificar ORP core:

ejecutar suite completa de ORP.

No probar solo Acerca.

---

# 151. No application-specific regression in ORP

Tests ORP deben seguir siendo genéricos.

---

# 152. Acerca tests

Casos específicos deben vivir en proyecto Acerca.

---

# 153. Documentation feedback

Si durante implementación una API ORP fue difícil de entender:

registrar:

```text
DOC GAP
```

y mejorar docs.

---

# 154. DX evaluation

Registrar cosas como:

```text
too many classes
unclear modifier
hard to compose
prop naming confusion
missing example
unclear theme token
```

---

# 155. Composition quality

ORP debe reducir complejidad.

Si una composición requiere 15 wrappers arbitrarios:

investigar.

---

# 156. But avoid magic

No reducir markup creando un mega componente específico.

---

# 157. Completion criteria — Pilot

Piloto se considera exitoso cuando:

```text
uses real ORP package/source integration
looks app-like
works at mobile widths
works desktop
Bootstrap coexistence verified
no critical a11y regression
no functionality regression
no ORP-specific hacks
dogfooding report updated
```

---

# 158. Migration approval

Solo después del piloto exitoso continuar con el resto.

---

# 159. Completion criteria — Full migration

Parte 25 termina cuando las secciones seleccionadas para esta fase:

```text
use ORP consistently
have no unnecessary Bootstrap presentation dependency
retain application behavior
pass responsive checks
pass theme checks where applicable
pass accessibility smoke tests
```

No es obligatorio eliminar Bootstrap de todo Acerca.

---

# 160. Bootstrap removal decision

Al terminar medir cuánto Bootstrap sigue siendo necesario en el **public minisite**.

Puede recomendarse posteriormente separar bundles.

No hacerlo automáticamente.

---

# 161. Potential future optimization

Si frontend público ya no necesita Bootstrap:

registrar oportunidad:

```text
minisite bundle without Bootstrap
```

para una fase posterior.

---

# 162. Required artifacts

Crear/actualizar:

```text
ORP-MIGRATION-MATRIX.md
ORP-DOGFOODING.md
```

y si aplica:

```text
ORP-BOOTSTRAP-CONFLICTS.md
```

---

# 163. Final report

Entregar:

## Current Architecture
Archivos/rutas reales.

## Section Inventory
Lista real.

## Bootstrap Usage
Dónde y por qué.

## ORP Mapping
Resumen.

## Pilot Selected
Qué sección y razón.

## Pilot Before
Arquitectura visual/técnica.

## Pilot After
Nueva composición.

## ORP Components Used
Lista.

## External Integrations
Lista.

## Bootstrap Conflicts
Resultados.

## Mobile
Resultados.

## Desktop
Resultados.

## Themes
Resultados.

## Accessibility
Resultados.

## Performance
Cambios relevantes.

## Functional Regression
Resultados.

## ORP Bugs Found
Lista.

## API Friction
Lista.

## Missing Primitives
Lista.

## Documentation Gaps
Lista.

## Application-Specific Components
Lista.

## ORP Core Changes
Lista.

## Acerca Changes
Lista.

## Migration Plan
Siguiente batch.

## Recommendation
Continuar / corregir / detener.

---

# 164. Do not hide failures

Usar:

```text
PASS
FAIL
NOT VERIFIED
```

---

# 165. Do not automatically create v0.2 components

Si aparece un gap:

registrarlo.

Primero comprobar que se repita o sea foundational.

---

# 166. No Part 26 automatically

No crear roadmap v0.2 todavía.

Parte 25 debe generar evidencia.

---

# 167. Expected outcome

Al finalizar deberíamos poder responder:

```text
¿ORP UI hace que Acerca se sienta realmente como una aplicación móvil?
```

y también:

```text
¿Qué tan cómodo es desarrollar una aplicación real con ORP UI?
```

---

# 168. Success is not zero Bootstrap

El éxito NO es:

```text
Bootstrap usage = 0
```

El éxito es:

```text
correct responsibility
+
better mobile UX
+
clean coexistence
+
reusable ORP primitives
```

---

# 169. Success is not more ORP classes

Tampoco:

```text
more ORP classes = better migration
```

El objetivo es una composición mejor.

---

# 170. Final principle

Durante toda esta fase aplicar:

```text
Is this a framework problem?
    YES → fix ORP

Is this an Acerca-specific problem?
    YES → fix Acerca

Can existing ORP primitives compose it?
    YES → compose

Is a specialized library better?
    YES → integrate

Is Bootstrap still useful in admin?
    YES → keep it

Does the rendered minisite feel like a mobile app?
    NO → rethink composition
```

---

# Resultado esperado

La primera aplicación real de ORP UI debe demostrar:

```text
Laravel / Blade
        +
Bootstrap admin
        +
ORP UI mobile frontend
        +
Swiper / GLightbox / Leaflet
        ↓
coexisting cleanly
        ↓
Acerca Minisite
        ↓
mobile-first app-like experience
```

Esta fase es deliberadamente más importante que agregar otra lista de componentes.

A partir de aquí, las decisiones de ORP UI deben basarse cada vez más en **uso real**.

