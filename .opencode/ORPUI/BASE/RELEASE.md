# SKILL — ORP UI / Parte 24: v0.1.0 Release, Final Validation & Release Gate

## Objetivo

Cerrar formalmente **ORP UI v0.1.0**.

Esta fase NO es para agregar componentes, rediseñar APIs por gusto ni abrir nuevas líneas de desarrollo.

Parte 24 debe tomar el trabajo realizado en:

```text
Parte 21.9
→ Component Gap Audit & Framework Completeness

Parte 22
→ Documentation Site & Developer Experience

Parte 23
→ Packaging & Distribution
```

y convertirlo en una primera versión formal, reproducible y utilizable de ORP UI.

El objetivo final es llegar a:

```text
ORP UI
   ↓
validated
   ↓
documented
   ↓
packaged
   ↓
consumer-tested
   ↓
versioned
   ↓
tagged
   ↓
released as v0.1.0
```

---

# 1. Regla principal

No liberar `v0.1.0` simplemente porque:

```text
npm run build
```

termina correctamente.

El release requiere comprobar:

```text
framework completeness
public API
tests
visual regression
accessibility
responsive behavior
themes
RTL
SSR safety
package contents
consumer installation
documentation
release metadata
```

---

# 2. Release Gate

Antes de modificar la versión revisar los reportes existentes.

Buscar:

```text
COMPONENT-INVENTORY.md
COMPONENT-MATRIX.md
COMPONENT-GAPS.md
TECHNICAL-DEBT.md
V0.1-READINESS.md
DOCS-ARCHITECTURE.md
DOCS-MATRIX.md
RELEASE-CHECKLIST.md
```

Adaptar nombres/rutas si el repositorio usa otros.

---

# 3. Do not trust roadmap status

No asumir que una fase está terminada porque existe su Markdown.

Comprobar el repositorio real.

---

# 4. Release decision

El agente debe producir una de estas decisiones:

```text
READY FOR v0.1.0
```

o:

```text
NOT READY FOR v0.1.0
```

con razones concretas.

---

# 5. Blocking rule

NO liberar si existe:

```text
BLOCKER
```

sin resolver.

---

# 6. Required gaps rule

NO liberar si queda algún:

```text
REQUIRED v0.1
```

sin implementar/verificar.

---

# 7. Technical debt

Deuda:

```text
MEDIUM
LOW
```

puede permanecer si:

```text
no rompe API
no rompe accessibility crítica
no rompe build
no rompe consumers
está documentada
```

---

# 8. HIGH severity

Evaluar individualmente.

Un HIGH relacionado con:

```text
accessibility
data loss
focus
navigation
build
package
SSR
consumer integration
```

debe tratarse como blocker de release.

---

# 9. Clean working tree awareness

Antes del release revisar Git.

Ejecutar conceptualmente:

```bash
git status
```

No borrar ni sobrescribir cambios del usuario.

---

# 10. Branch

Identificar rama actual.

No asumir:

```text
main
master
develop
```

---

# 11. Release branch

No crear una rama nueva salvo que el workflow del repositorio lo requiera.

---

# 12. Version audit

Revisar versión actual en:

```text
package.json
package lockfile
docs
generated metadata
```

---

# 13. Version target

Target:

```text
0.1.0
```

---

# 14. SemVer

Documentar que ORP UI sigue Semantic Versioning.

Conceptualmente:

```text
MAJOR.MINOR.PATCH
```

---

# 15. Pre-1.0 policy

Explicar que durante `0.x` la API todavía puede evolucionar.

Pero evitar cambios arbitrarios.

---

# 16. API freeze

Antes del release revisar public API.

---

# 17. Public components

Inventariar exports reales:

```text
components
composables
CSS
LESS
tokens
utilities
```

---

# 18. Accidental exports

Eliminar exports internos accidentales antes de v0.1 si es seguro.

---

# 19. Missing exports

Corregir componentes públicos implementados pero no exportados.

---

# 20. Internal APIs

No documentar/exportar internals como públicos solo porque existen.

---

# 21. Naming audit

Última revisión de:

```text
Orp*
useOrp*
orp-*
--orp-*
@orp-*
data-orp-*
```

---

# 22. Breaking rename window

Si 21.9/22/23 detectaron nombres claramente incorrectos:

este es el último momento razonable para corregirlos antes de tag.

Documentar cambios.

---

# 23. CSS namespace

Confirmar que ORP-owned classes usan:

```text
orp-*
```

---

# 24. Generic class audit

No deben filtrarse clases globales tipo:

```text
.btn
.card
.modal
.alert
.badge
.container
.row
.col
.nav
```

---

# 25. Bootstrap audit

Confirmar:

```text
Bootstrap CSS is NOT required
```

Bootstrap Icons pueden seguir siendo integración opcional.

---

# 26. Framework independence

Confirmar que core no depende de:

```text
Laravel
Inertia
Vue Router
Bootstrap
Framework7
jQuery
Tailwind
```

---

# 27. Runtime dependency audit

Revisar `dependencies`.

Cada runtime dependency debe tener justificación.

---

# 28. Vue dependency

Si la arquitectura estableció Vue como peer dependency:

confirmarlo.

---

# 29. Optional integrations

Confirmar que:

```text
Bootstrap Icons
Swiper
GLightbox
```

no sean requeridos para importar ORP core.

---

# 30. Build clean

Ejecutar build desde estado limpio.

Usar scripts reales de `package.json`.

---

# 31. Build output

Confirmar generación de artefactos esperados, por ejemplo:

```text
dist/orp-ui.css
ES modules
component exports
LESS sources if distributed
```

Usar nombres reales.

---

# 32. No stale dist

Asegurar que `dist/` corresponde al source actual.

---

# 33. Build warnings

No ignorar warnings relevantes.

Registrar:

```text
warning
cause
impact
decision
```

---

# 34. CSS validation

Verificar CSS compilado.

Buscar:

```text
missing keyframes
broken imports
unresolved variables
duplicate major blocks
unexpected Bootstrap styles
```

---

# 35. Spinner/Skeleton final regression

Debido a bugs detectados previamente, comprobar explícitamente:

```text
Spinner
Skeleton
```

en build final.

---

# 36. Spinner

Validar:

```text
sm/md/lg
continuous motion
reduced motion
Light
Dark
Custom
button composition
```

---

# 37. Skeleton

Validar:

```text
text
multiline
circle
avatar
rectangle
card
reduced motion
Light
Dark
Custom
```

---

# 38. List final regression

Volver a comprobar:

```text
List
Divided
Inset
Composition
```

No deben reaparecer:

```text
legacy icons
old buttons
old spacing
Bootstrap styles
```

---

# 39. Dialog regression

Si público:

```text
Alert
Confirm
Prompt
Vertical Actions
Preloader
Progress
Stack
```

---

# 40. Notification regression

Si público:

```text
Basic
Compact
Full
Actions
Dismiss
Persistent
Stack
Banner
Center
Read/Unread
```

---

# 41. Table regression

Si público:

```text
basic
rich cells
sorting
selection
expanded
sticky
loading
empty
mobile
```

---

# 42. Video/audio regression

Si públicos:

```text
play/pause
seek
volume
mute
captions
speed
fullscreen feature detection
PiP feature detection
error
source change
```

---

# 43. Forms regression

Revisar:

```text
Input
Textarea
Select
Checkbox
Radio
Switch
Search
File Input
Combobox
Autocomplete
MultiSelect
TagInput
OTP
Password
Range
NumberStepper
```

solo los públicos.

---

# 44. Overlay regression

Revisar:

```text
Dropdown
Popover
Modal
Sheet
Drawer
ActionSheet
Toast
```

---

# 45. Overlay infrastructure

Especial atención a:

```text
Escape
outside click
focus trap
focus restore
scroll lock
nested overlays
topmost behavior
```

---

# 46. App Shell regression

Revisar:

```text
AppBar
BottomNav
Sidebar
FAB
safe areas
fixed bottom compensation
```

---

# 47. Tests

Ejecutar suite completa.

---

# 48. Unit/component tests

No aceptar tests rojos.

---

# 49. Interaction tests

No aceptar fallos conocidos en componentes críticos.

---

# 50. Visual regression

Ejecutar suite de Parte 17.

---

# 51. Screenshot review

No aprobar automáticamente snapshots nuevos.

Revisar diferencias visuales.

---

# 52. Snapshot update rule

Actualizar baseline solo si:

```text
change is intentional
change is reviewed
new output is correct
```

Nunca para "hacer pasar" tests.

---

# 53. Accessibility audit

Ejecutar tests automatizados existentes.

Complementar con revisión manual.

---

# 54. Critical accessibility

No liberar con:

```text
keyboard trap
unreachable controls
missing form labels
broken dialog focus
invisible focus
critical contrast failure
invalid interactive nesting
```

---

# 55. Keyboard smoke test

Revisar componentes interactivos con teclado.

---

# 56. Reduced Motion

Probar:

```text
prefers-reduced-motion: reduce
```

---

# 57. Themes

Smoke test:

```text
Light
Dark
Custom
```

---

# 58. Theme switch

Si existe runtime switching:

probarlo sin reload cuando corresponda.

---

# 59. Hardcoded theme leaks

Buscar visualmente:

```text
white patches
black text in dark mode
legacy gray backgrounds
incorrect borders
```

---

# 60. Responsive

Smoke tests mínimos:

```text
320
375
390
430
768
992
1200
1440
```

---

# 61. Mobile priority

Prestar atención a:

```text
navigation
forms
dialogs
notifications
tables
video
sheets
```

---

# 62. Landscape

Revisar:

```text
mobile landscape
tablet landscape
```

en overlays/media/navigation.

---

# 63. RTL

Ejecutar smoke tests con:

```html
dir="rtl"
```

---

# 64. RTL priority

```text
navigation
breadcrumb
pagination
list
table
dialog
notification
media controls
```

---

# 65. SSR safety

Comprobar import del package en entorno sin DOM.

---

# 66. SSR forbidden top-level access

Buscar:

```text
window
document
navigator
localStorage
matchMedia
```

en module evaluation.

---

# 67. Client-only APIs

Deben ejecutarse:

```text
onMounted
event handlers
feature detection
```

según corresponda.

---

# 68. Package test

Usar el procedimiento definido en Parte 23.

---

# 69. npm pack

Generar tarball local.

Ejemplo:

```bash
npm pack
```

según package manager real.

---

# 70. Inspect package contents

Revisar qué entra al tarball.

---

# 71. Package must include

Según arquitectura real:

```text
dist
package.json
README
LICENSE
LESS source if public
types/JSDoc artifacts if any
```

---

# 72. Package must not include unnecessary files

Evitar:

```text
screenshots
Playwright artifacts
coverage
temporary files
local env files
large fixtures
node_modules
internal scratch docs
```

---

# 73. Secrets audit

CRÍTICO.

Buscar antes de publicar:

```text
.env
API keys
tokens
credentials
private URLs
SSH keys
passwords
```

No imprimir secretos completos en reportes.

---

# 74. Consumer project

Instalar tarball en proyecto separado.

---

# 75. Consumer test

Debe probar:

```text
install
CSS import
Vue import
render
build
production build
```

---

# 76. CSS-only consumer

Si ORP soporta CSS-only primitives:

probarlos sin registrar componentes Vue.

---

# 77. Vue consumer

Probar componentes Vue públicos.

---

# 78. Bootstrap coexistence consumer

Como test de compatibilidad:

crear/verificar consumer con:

```text
Bootstrap 5 CSS
ORP UI
```

Confirmar ausencia de colisiones importantes.

---

# 79. Bootstrap Icons consumer

Probar integración opcional si está documentada.

---

# 80. Swiper consumer

Si integración oficial:

probar ejemplo mínimo.

---

# 81. GLightbox consumer

Si integración oficial:

probar ejemplo mínimo.

---

# 82. Tree shaking

Si build lo permite:

confirmar que imports parciales no obligan a cargar comportamiento innecesario.

---

# 83. Side effects

Revisar `sideEffects` del package si existe.

No marcar CSS como tree-shakeable accidentalmente.

---

# 84. Package exports

Validar `exports`.

---

# 85. Main/module/style fields

Validar campos reales del package.

No mantener rutas rotas.

---

# 86. Files field

Si `package.json` usa:

```json
"files": [...]
```

confirmar que contiene exactamente lo necesario.

---

# 87. README

README raíz debe estar listo para un consumidor nuevo.

---

# 88. README minimum

Debe contener:

```text
ORP UI
short description
status/version
installation
basic CSS usage
basic Vue usage
theming
documentation link/path
browser/support note
license
```

---

# 89. README honesty

No poner:

```text
npm install @orp/ui
```

si ese package todavía no existe públicamente.

---

# 90. Documentation build

Ejecutar build de Parte 22.

---

# 91. Docs links

Revisar:

```text
broken internal links
broken anchors
missing pages
```

---

# 92. Docs API accuracy

Comparar componentes críticos contra source.

---

# 93. Docs examples

Ejecutar/validar snippets cuando sea razonable.

---

# 94. Docs version

Mostrar:

```text
0.1.0
```

desde fuente central si arquitectura lo permite.

---

# 95. DOCS-MATRIX

Actualizar después de cualquier cambio final.

---

# 96. CHANGELOG

Crear o actualizar:

```text
CHANGELOG.md
```

---

# 97. Changelog format

Puede seguir Keep a Changelog o formato equivalente simple.

No agregar tooling solo para esto.

---

# 98. v0.1.0 changelog

Resumir por categorías:

```text
Added
Changed
Fixed
Known limitations
```

---

# 99. Do not dump roadmap

CHANGELOG debe describir lo realmente incluido.

---

# 100. Release notes

Crear:

```text
RELEASE-NOTES-0.1.0.md
```

o equivalente.

---

# 101. Release notes audience

Más legibles que el changelog.

Incluir:

```text
what ORP UI is
what v0.1 includes
installation status
major component families
theming
accessibility
integrations
known limitations
```

---

# 102. Known limitations

Ser explícito.

Ejemplos posibles según reportes:

```text
advanced calendar deferred
tree view deferred
chart rendering external
carousel external
lightbox external
push delivery application-owned
```

Solo incluir limitaciones reales.

---

# 103. License

Confirmar que exista una licencia antes de publicación pública.

---

# 104. License decision

No inventar/cambiar licencia legal automáticamente.

Si falta LICENSE y el usuario no definió una:

marcar como release blocker para publicación pública y solicitar decisión.

---

# 105. Package metadata

Revisar:

```text
name
version
description
keywords
license
repository
homepage
bugs
author
engines
peerDependencies
```

---

# 106. Do not invent URLs

No agregar:

```text
repository
homepage
bugs
```

con URLs supuestas.

Usar solo datos reales.

---

# 107. npm package name availability

No comprobar/publicar automáticamente salvo que el usuario haya decidido publicar en npm.

---

# 108. Publication modes

Distinguir:

```text
Internal release
GitHub release
npm public release
npm private release
```

---

# 109. Default release behavior

Parte 24 debe preparar el release.

No publicar externamente automáticamente.

---

# 110. No npm publish without explicit approval

NO ejecutar:

```bash
npm publish
```

sin instrucción explícita del usuario.

---

# 111. No Git push without explicit approval

NO ejecutar:

```bash
git push
git push --tags
```

sin autorización explícita.

---

# 112. Local commit

No crear commit automáticamente si el usuario no lo pidió.

Puede preparar comandos/reporte.

---

# 113. Git tag

Target:

```text
v0.1.0
```

pero no crear/pushear tag sin seguir el workflow autorizado.

---

# 114. Suggested release commands

Al finalizar puede entregar comandos exactos adaptados al repo.

Ejemplo conceptual:

```bash
git add ...
git commit -m "release: ORP UI v0.1.0"
git tag -a v0.1.0 -m "ORP UI v0.1.0"
git push origin ...
git push origin v0.1.0
```

No ejecutarlos sin permiso.

---

# 115. GitHub Release

Preparar texto usando release notes.

No crear release remoto sin permiso/conector disponible.

---

# 116. npm dry run

Si package manager lo soporta:

usar dry-run antes de publicación.

Ejemplo:

```bash
npm publish --dry-run
```

solo como validación local si no tiene efectos remotos.

---

# 117. Tarball install is mandatory

Aunque no se publique npm todavía:

consumer test desde tarball local debe pasar.

---

# 118. Package size

Registrar:

```text
tarball size
unpacked size
CSS size
JS size
```

si tooling proporciona esos valores.

---

# 119. No arbitrary size gate

No fallar release solo por un número sin baseline.

Registrar y detectar crecimientos sospechosos.

---

# 120. Browser compatibility

Confirmar target real.

---

# 121. Modern CSS

Documentar features relevantes como:

```text
CSS custom properties
logical properties
dvh
container queries
conic-gradient
```

solo si realmente se usan.

---

# 122. Polyfills

No añadir polyfills automáticamente.

---

# 123. Consumer errors

Cualquier error de import/build del tarball:

```text
BLOCKER
```

---

# 124. Missing CSS

Si consumer Vue renderiza sin estilos por package export incorrecto:

```text
BLOCKER
```

---

# 125. Import side effects

Si importar package rompe SSR:

```text
BLOCKER
```

---

# 126. Documentation mismatch

Si docs muestran API inexistente:

corregir antes de release.

---

# 127. Playground mismatch

Si Playground usa API interna/no pública:

corregir o marcar demo interno.

---

# 128. Release checklist

Actualizar:

```text
RELEASE-CHECKLIST.md
```

---

# 129. Checklist sections

```text
Code
Components
CSS
Themes
Responsive
RTL
Accessibility
Tests
Visual Regression
Build
SSR
Package
Consumer
Documentation
Metadata
Security
Git
Release
```

---

# 130. Required release artifact

Crear:

```text
V0.1.0-FINAL-REPORT.md
```

---

# 131. Final report structure

```text
Release Decision
Version
Date
Commit/branch context
Component status
Required gaps
Technical debt
Tests
Visual regression
Accessibility
Themes
Responsive
RTL
SSR
Build
Package
Consumer test
Bootstrap coexistence
Integrations
Documentation
Security
Package metadata
Changelog
Release notes
Known limitations
Files changed
Blockers
Next actions
```

---

# 132. Release decision banner

Primera sección:

```text
# READY FOR v0.1.0
```

o:

```text
# NOT READY FOR v0.1.0
```

---

# 133. Evidence

Cada PASS importante debe mencionar evidencia:

```text
command
test
file
fixture
manual verification
```

cuando sea posible.

---

# 134. Do not fake tests

Si algo no pudo probarse:

usar:

```text
NOT VERIFIED
```

No `PASS`.

---

# 135. Final fixes

Durante Parte 24 solo corregir:

```text
release blockers
regressions
package errors
docs inaccuracies
accessibility defects
critical visual defects
```

---

# 136. No feature creep

NO agregar:

```text
Calendar
Tree View
new Data Grid features
new video features
new notification features
new animations
new themes
```

solo porque aparezcan ideas durante release.

Registrar para v0.2.

---

# 137. v0.2 backlog

Crear o actualizar:

```text
V0.2-BACKLOG.md
```

con gaps/deferred ideas reales.

---

# 138. Backlog categories

```text
Candidate components
Enhancements
Developer Experience
Accessibility improvements
Integrations
Performance
Documentation
```

---

# 139. Do not promise v0.2 scope

El backlog no es compromiso.

---

# 140. Post-release strategy

Después de v0.1 la prioridad debe cambiar.

---

# 141. Dogfooding

Usar ORP UI en al menos una aplicación real.

---

# 142. Real application validation

Buscar problemas como:

```text
missing primitives
awkward APIs
CSS collisions
responsive edge cases
theme limitations
bundle friction
composition pain
```

---

# 143. Feedback-driven development

Los componentes de v0.2 deben surgir principalmente de:

```text
real application needs
consumer feedback
accessibility gaps
repeated compositions
```

no de listas de componentes de otros frameworks.

---

# 144. Release does not mean finished

`v0.1.0` significa:

```text
first coherent usable release
```

no:

```text
every UI component imaginable
```

---

# 145. Release candidate option

Si el audit encuentra incertidumbre pero no blockers, puede recomendar:

```text
0.1.0-rc.1
```

antes de final.

No cambiar target automáticamente.

---

# 146. RC use cases

RC tiene sentido si:

```text
package API needs real-world validation
docs just launched
consumer tests are limited
several apps will dogfood immediately
```

---

# 147. If RC is recommended

Explicar por qué.

No publicar RC sin permiso.

---

# 148. Final test order

Orden recomendado:

```text
1. static audits
2. build
3. unit/component tests
4. interaction tests
5. accessibility tests
6. visual regression
7. docs build
8. npm pack
9. package inspection
10. isolated consumer install
11. consumer production build
12. final report
```

---

# 149. Failure behavior

Si cualquier paso crítico falla:

detener release decision.

Corregir y repetir desde el punto apropiado.

---

# 150. Reproducibility

Registrar:

```text
Node version
package manager
package manager version
build command
test command
docs command
```

cuando sea posible.

---

# 151. Lockfile

No regenerar lockfile innecesariamente.

Si cambia:

explicar por qué.

---

# 152. Clean install

Cuando sea razonable probar instalación reproducible usando lockfile.

Ejemplo conceptual:

```bash
npm ci
```

No borrar entorno de trabajo de forma destructiva sin necesidad.

---

# 153. Security audit

Si existe tooling estándar ya disponible:

revisar dependencias.

No hacer upgrades mayores automáticos durante release.

---

# 154. Vulnerabilities

Clasificar por:

```text
runtime/dev
severity
reachability
release impact
```

No actualizar dependencias a ciegas.

---

# 155. Generated artifacts

No incluir reportes temporales en package npm salvo que estén destinados al consumidor.

---

# 156. Documentation artifacts

Docs source puede vivir en repo pero normalmente no necesita ir en tarball runtime salvo decisión explícita.

---

# 157. Playground artifacts

Playground no debe formar parte del package publicado salvo necesidad justificada.

---

# 158. Test artifacts

Excluir:

```text
coverage
screenshots diffs
test-results
playwright-report
```

del tarball.

---

# 159. Source maps

Decidir conscientemente si se distribuyen.

No removerlos solo por tamaño sin evaluar DX.

---

# 160. LESS source distribution

Si Parte 23 decidió distribuir LESS:

verificar imports relativos y archivos incluidos.

---

# 161. CSS Custom Properties contract

Los tokens públicos documentados pasan a ser parte importante del contrato v0.1.

Revisar nombres antes del release.

---

# 162. Component class contract

Las clases documentadas públicamente también son API.

Evitar renombrarlas después del tag sin SemVer consideration.

---

# 163. Accessibility contract

No documentar soporte que no se probó.

---

# 164. Browser support contract

Igual.

---

# 165. Final docs homepage

Debe mostrar claramente:

```text
ORP UI
version
what it is
getting started
documentation navigation
```

---

# 166. No fake badges

No agregar badges de:

```text
build passing
coverage
npm version
downloads
```

si no existen fuentes reales.

---

# 167. Release notes known limitations

Es mejor declarar:

```text
Tree View planned for future evaluation
```

que meter una implementación débil antes del release.

---

# 168. Git ignore audit

Revisar que archivos locales sensibles/generados estén ignorados cuando corresponda.

---

# 169. npm ignore/files audit

Revisar publicación por `files`/`.npmignore`.

---

# 170. Final consumer smoke page

El proyecto consumer debería mostrar varias familias:

```text
Button
Card
Form
Navigation
Dialog/Modal
Notification/Toast
Table
```

según componentes reales.

Esto prueba más que un solo Button.

---

# 171. Consumer theme test

Cambiar:

```text
Light
Dark
Custom
```

en consumer aislado.

---

# 172. Consumer responsive test

Probar mobile/desktop.

---

# 173. Consumer without Playground

El test debe funcionar sin importar nada desde Playground/docs.

---

# 174. Consumer from public API only

No usar rutas internas como:

```text
src/components/...
```

Solo exports públicos.

---

# 175. Final package installation instructions

README/docs deben coincidir exactamente con consumer test.

---

# 176. Release completion criteria

Parte 24 puede declarar:

```text
READY FOR v0.1.0
```

solo si:

```text
0 BLOCKERS
0 unresolved REQUIRED v0.1 gaps
build PASS
tests PASS
critical visual regression PASS
accessibility critical checks PASS
themes PASS
responsive smoke PASS
RTL smoke PASS
SSR import PASS
npm pack PASS
package contents PASS
isolated consumer install PASS
consumer production build PASS
documentation build PASS
README accurate
CHANGELOG ready
release notes ready
security/secrets audit PASS
```

---

# 177. Publication is separate

Incluso con:

```text
READY FOR v0.1.0
```

no publicar automáticamente.

---

# 178. Final user decision

El agente debe dejar listo:

```text
release locally
tag
GitHub release
npm publish
```

para que el usuario decida cuál ejecutar.

---

# 179. Expected final output

Al terminar responder con resumen:

```text
ORP UI v0.1.0
Release status: READY / NOT READY

Build:
Tests:
Accessibility:
Visual:
Package:
Consumer:
Docs:
Security:

Blockers:
Known limitations:

Recommended next command:
...
```

---

# 180. Do not continue automatically

No iniciar:

```text
Parte 25
v0.2 implementation
new components
```

---

# 181. Next phase after release

Una vez liberado:

```text
Dogfooding / Real Application Validation
```

debe ser el siguiente trabajo.

No otra ronda inmediata de component expansion.

---

# Regla final

Parte 24 debe responder una sola pregunta:

```text
¿ORP UI puede salir del repositorio de desarrollo
y ser utilizado de forma confiable por otra aplicación?
```

Si la respuesta es sí:

```text
ORP UI v0.1.0
```

está listo.

Si la respuesta es no:

no maquillar el release.

Corregir el blocker, repetir las verificaciones y volver a evaluar.

El flujo final es:

```text
Component Audit
      ↓
Documentation
      ↓
Packaging
      ↓
Final Validation
      ↓
Consumer Test
      ↓
Release Gate
      ↓
v0.1.0
      ↓
Real Applications
      ↓
Feedback
      ↓
v0.2
```

**Calidad y estabilidad tienen prioridad sobre cantidad de componentes.**

