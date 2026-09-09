# SKILL — ORP UI / Parte 23: Packaging, Distribution & Consumer Integration

## Objetivo

Preparar **ORP UI** para ser consumido como un framework/librería real fuera de su repositorio de desarrollo.

Esta fase ocurre después de:

```text
21.9 — Component Gap Audit & Framework Completeness
22   — Documentation Site & Developer Experience
```

La meta es pasar de:

```text
source repository
```

a:

```text
installable package
→ predictable imports
→ stable public API
→ distributable CSS
→ Vue ESM modules
→ optional LESS source
→ optional integrations
→ consumer smoke tests
→ release-ready package
```

**Parte 23 NO publica todavía la versión estable.**

La publicación/release formal pertenece a Parte 24.

---

# 1. Principio principal

ORP UI debe poder instalarse en una aplicación nueva sin depender de la estructura interna del repositorio.

Un consumidor NO debería importar:

```text
../../src/components/...
../../less/components/...
```

Debe consumir únicamente la API pública del package.

---

# 2. Audit previo obligatorio

Antes de modificar packaging revisar:

```text
package.json
vite.config.*
rollup config si existe
src/
less/
dist/
exports actuales
peerDependencies
dependencies
devDependencies
sideEffects
README/docs
COMPONENT-INVENTORY.md
COMPONENT-MATRIX.md
V0.1-READINESS.md
DOCS-MATRIX.md
```

No reemplazar tooling funcional solo para seguir esta especificación.

---

# 3. Distribution targets

ORP UI debe poder distribuir, según lo que realmente exista:

```text
CSS bundle
Vue JavaScript ESM
public composables
public utilities/helpers
LESS source (optional)
theme/tokens entry points (if useful)
type declarations only if they already exist naturally
```

No introducir TypeScript únicamente para generar tipos.

---

# 4. Expected package model

Conceptualmente:

```text
@orp/ui
├── JavaScript / Vue
├── CSS
├── LESS source
└── optional integration styles
```

**No asumir que `@orp/ui` es el nombre real.**

Usar el nombre verdadero de `package.json`.

Si todavía no existe nombre definitivo, documentar la decisión pendiente.

---

# 5. Package name audit

Comprobar:

```text
name
version
description
license
repository
homepage
bugs
keywords
author
```

No inventar URLs/repositorios que no existan.

---

# 6. Version

Parte 23 debe preparar el package para:

```text
0.1.0
```

pero no publicar automáticamente.

Si la versión actual difiere, reportarlo.

---

# 7. SemVer

Documentar política:

```text
PATCH
→ bug fixes compatible with public API

MINOR
→ backward-compatible features/components

MAJOR
→ breaking public API changes
```

Mientras ORP esté en `0.x`, explicar que APIs pueden evolucionar, pero evitar cambios arbitrarios.

---

# 8. Public API freeze

Usar resultados de Parte 21.9 y 22 para definir qué entra a `v0.1.0`.

Crear:

```text
PUBLIC-API.md
```

---

# 9. PUBLIC-API.md

Debe inventariar:

```text
CSS entry points
LESS entry points
Vue components
composables
helpers
runtime tokens
optional integrations
```

---

# 10. Internal vs public

Clasificar source como:

```text
PUBLIC
INTERNAL
DOCS ONLY
PLAYGROUND ONLY
TEST ONLY
```

No exportar internals accidentalmente.

---

# 11. JavaScript entry point

Preferir un entry point claro, por ejemplo conceptual:

```js
import {
  OrpModal,
  OrpSheet,
  OrpDialog
} from 'orp-ui'
```

Usar nombres reales.

---

# 12. Direct imports

Evaluar soporte para imports específicos:

```js
import { OrpModal } from 'orp-ui'
```

como API principal.

Subpath imports solo si aportan valor real.

---

# 13. Avoid deep imports

Consumidores no deberían depender de:

```text
orp-ui/src/components/feedback/...
```

El `exports` map debe impedir o desalentar deep imports internos.

---

# 14. ESM first

ORP UI debe priorizar:

```text
ES Modules
```

para Vite y tooling moderno.

No agregar CommonJS solo por tradición.

---

# 15. CommonJS decision

Evaluar necesidad real.

Si consumidores objetivo son:

```text
Vue 3
Vite
modern bundlers
```

ESM puede ser suficiente.

Documentar decisión.

---

# 16. UMD/IIFE decision

NO generar automáticamente:

```text
UMD
IIFE
CDN global build
```

salvo caso de uso real.

Puede diferirse.

---

# 17. Vue peer dependency

Vue debe permanecer como:

```text
peerDependency
```

si ORP exporta Vue components.

Evitar empaquetar una segunda copia de Vue.

---

# 18. Vue version range

Definir rango compatible basado en código/tests reales.

No usar rango excesivamente amplio sin evidencia.

---

# 19. Runtime dependencies

Objetivo:

```text
minimal runtime dependencies
```

Auditar cada dependency.

---

# 20. Optional integrations

Estos NO deben convertirse en runtime dependencies obligatorias del core:

```text
Bootstrap Icons
Swiper
GLightbox
Leaflet
Chart.js
ApexCharts
ECharts
HLS.js
```

según integración real.

---

# 21. Bootstrap Icons

Mantener como integración opcional.

ORP core sigue siendo icon-agnostic.

---

# 22. Swiper

No bundlear Swiper dentro de ORP core.

---

# 23. GLightbox

No bundlear GLightbox dentro de ORP core.

---

# 24. Specialized integrations

Leaflet/charts/streaming siguen siendo responsabilidad de aplicación salvo adapter explícitamente aprobado en futuro.

---

# 25. Dependency classification

Crear tabla:

| Package | Current type | Needed at runtime | Final type | Reason |
|---|---|---:|---|---|

---

# 26. CSS distribution

Debe existir un entry point principal equivalente a:

```text
dist/orp-ui.css
```

si ése sigue siendo el nombre oficial.

---

# 27. CSS bundle completeness

Confirmar que incluye en orden correcto:

```text
foundation
tokens
reset/base
utilities
layout
components
```

según arquitectura real.

---

# 28. CSS import order

No depender de imports accidentales del Playground.

El bundle distribuido debe funcionar por sí mismo.

---

# 29. Compiled keyframes

Confirmar especialmente que se distribuyen keyframes usados por:

```text
Spinner
Skeleton
Toast
Notification
Modal/Sheet transitions
Typing Indicator
```

según implementación.

---

# 30. CSS namespace

Ejecutar audit final para confirmar que ORP-owned selectors usan:

```text
orp-*
```

salvo selectors base deliberados y documentados.

---

# 31. Global selectors

Revisar cuidadosamente:

```text
html
body
button
input
a
img
*
```

Los globals deben pertenecer únicamente a foundation/reset intencional.

---

# 32. Consumer coexistence test

Probar ORP junto a una aplicación con CSS externo.

Especialmente Bootstrap, porque es un escenario real del ecosistema del usuario.

---

# 33. Bootstrap coexistence

Crear consumer smoke test donde existan simultáneamente:

```text
Bootstrap CSS
ORP UI CSS
Bootstrap Icons
```

Verificar que ORP no rompe Bootstrap y Bootstrap no destruye ORP en componentes críticos.

---

# 34. No Bootstrap dependency

Coexistencia != dependencia.

ORP debe seguir funcionando sin Bootstrap.

---

# 35. CSS custom properties

Los runtime tokens públicos deben sobrevivir al build sin transformarse en valores hardcoded.

---

# 36. Theme distribution

Confirmar:

```text
Light
Dark
Custom
```

usando el package distribuido, no source LESS.

---

# 37. Dark theme consumer test

Probar desde aplicación externa:

```html
<html data-orp-theme="dark">
```

si ésa sigue siendo la API oficial.

---

# 38. Custom theme consumer test

Sobrescribir variables desde aplicación externa.

Ejemplo conceptual:

```css
[data-orp-theme="brand"] {
  --orp-primary: ...;
}
```

---

# 39. LESS source distribution

Si se decide distribuir LESS:

mantenerlo explícitamente como API avanzada.

---

# 40. LESS consumer boundary

Consumidores normales deberían poder usar ORP solo con CSS compilado.

LESS NO debe ser requisito.

---

# 41. LESS package paths

Si se exporta source, definir paths estables.

No obligar a importar internals arbitrarios.

---

# 42. LESS variables vs CSS variables

Documentar:

```text
LESS variables
→ build-time authoring

CSS custom properties
→ runtime theming
```

---

# 43. CSS minification

Generar build optimizado para distribución.

Si tooling actual produce minificado automáticamente, usarlo.

---

# 44. Development CSS

No es obligatorio distribuir versión unminified separada si sourcemaps/source ya resuelven debugging.

---

# 45. Sourcemaps

Evaluar:

```text
JS sourcemaps
CSS sourcemaps
```

para package publicado.

Documentar decisión.

---

# 46. JavaScript build

Generar módulos sin bundlear Vue.

---

# 47. Build externals

Configurar Vue como external cuando corresponda.

---

# 48. Browser globals

No ejecutar acceso a:

```text
window
document
localStorage
navigator
```

en module evaluation.

---

# 49. SSR smoke test

Crear test que pueda importar package en entorno Node sin DOM.

Objetivo:

```text
import package
→ no crash
```

---

# 50. Browser-only behavior

Debe inicializarse en lifecycle/client-side.

---

# 51. Tree shaking

Verificar que bundlers modernos puedan eliminar exports no usados cuando sea razonable.

---

# 52. sideEffects

Auditar `package.json`.

No poner:

```json
"sideEffects": false
```

a ciegas si provocaría eliminación de CSS imports necesarios.

---

# 53. CSS side effects

Si package usa imports CSS como side effects, declararlos correctamente.

---

# 54. Export map

Definir `exports` explícitos.

Ejemplo conceptual, NO copiar sin adaptar:

```json
{
  ".": {
    "import": "./dist/orp-ui.js"
  },
  "./style.css": "./dist/orp-ui.css"
}
```

---

# 55. Optional LESS export

Conceptualmente:

```text
./less
```

solo si se decide soportarlo.

---

# 56. Optional tokens export

Evaluar un path estable para tokens si existe caso real.

No fragmentar package con 30 subpaths.

---

# 57. `main`, `module`, `exports`

Auditar compatibilidad.

Preferir `exports` moderno sin romper tooling objetivo innecesariamente.

---

# 58. `files`

Definir exactamente qué se publica.

Por ejemplo:

```text
dist/
less/ if public
README
LICENSE
```

según package real.

---

# 59. Do not publish repository garbage

Evitar publicar:

```text
playground screenshots
test artifacts
coverage
node_modules
local configs
private notes
raw temp files
visual regression output unnecessary to consumers
```

---

# 60. npm pack inspection

Antes de publicar ejecutar:

```bash
npm pack --dry-run
```

o equivalente compatible con package manager real.

---

# 61. Tarball inspection

Inspeccionar lista real de archivos.

Registrar:

```text
package size
unpacked size
file count
```

sin inventar números.

---

# 62. Local package install test

Crear tarball local:

```bash
npm pack
```

sin publicar.

Instalar ese tarball en consumer fixtures.

---

# 63. Why tarball testing matters

No probar solamente mediante symlink/workspace.

El tarball revela errores de:

```text
missing files
bad exports
bad paths
missing CSS
package.json
```

---

# 64. Consumer fixtures

Crear aplicaciones mínimas de prueba fuera del source package.

Idealmente:

```text
consumer-vue-vite
consumer-css-only
consumer-bootstrap-coexistence
```

pueden vivir en `tests/fixtures` o equivalente.

---

# 65. Vue + Vite consumer

Debe probar:

```text
install package
import CSS
import Vue component
render component
production build
```

---

# 66. CSS-only consumer

Debe probar que primitives CSS-first funcionan sin Vue.

Ejemplos:

```text
Button
Card
List
Grid
Table
Alert
```

según inventario.

---

# 67. Bootstrap coexistence fixture

Debe importar:

```text
Bootstrap CSS
Bootstrap Icons
ORP UI CSS
```

Probar componentes ORP y Bootstrap lado a lado.

---

# 68. Consumer fixture policy

Fixtures son testing infrastructure.

No forman parte del package publicado.

---

# 69. Smoke components

El consumer Vue debe usar una muestra transversal:

```text
Button/Card or CSS primitive
form control
Modal/Dialog
Notification/Toast
Table
layout primitive
```

según API real.

---

# 70. Complex component smoke tests

Si públicos, incluir:

```text
OrpCommandMenu
OrpDataTable
OrpVideoPlayer
OrpDialog
OrpNotificationHost
```

solo si realmente existen.

---

# 71. No mandatory global install

Si ORP fue diseñado para direct imports, consumer test debe demostrarlo.

No agregar `app.use(OrpUI)` solo por comodidad.

---

# 72. Optional plugin decision

Evaluar si un Vue plugin agregador aporta valor real.

Por defecto:

```text
NO
```

si direct imports son suficientes.

---

# 73. Auto registration

No agregar auto-registration global de todos los componentes.

Perjudica tree shaking y claridad.

---

# 74. Auto CSS injection

Preferir import CSS explícito.

No inyectar todo el CSS dinámicamente desde JavaScript sin razón.

---

# 75. Composables packaging

Auditar composables públicos como:

```text
useOrpTheme
useOrpNotifications
useOrpDialog
```

solo si existen.

---

# 76. Internal composables

No exportar automáticamente:

```text
useFocusTrap
useOutsideClick
useScrollLock
```

si son internals de implementación.

---

# 77. API stability

Separar claramente:

```text
public composable
internal composable
```

---

# 78. Styles for integrations

Si ORP distribuye styles específicos para integraciones, evaluar subpaths como:

```text
/integrations/swiper.css
/integrations/glightbox.css
```

solo si realmente mejora consumo.

---

# 79. Do not force integrations

Importar core CSS no debe obligar a instalar Swiper/GLightbox.

---

# 80. Integration docs synchronization

Actualizar Parte 22 con paths reales finales.

---

# 81. Package metadata

Auditar keywords razonables como:

```text
vue
vue3
ui
component-library
design-system
mobile-first
```

sin keyword stuffing.

---

# 82. License

Comprobar que exista licencia antes de publicación pública.

No elegir licencia por el usuario sin una decisión previa si aún no existe.

Reportar como BLOCKER si package público requiere decisión.

---

# 83. README package-level

Crear/actualizar README orientado al consumidor.

Debe ser mucho más corto que Documentation Site.

---

# 84. README minimum

```text
ORP UI
short description
status/version
installation
CSS import
Vue example
theming example
documentation link if available
browser support summary
license
```

---

# 85. No fake npm badges

No agregar badges de:

```text
npm downloads
version
coverage
build
```

si no existen todavía.

---

# 86. Documentation URL

No inventar URL pública de docs.

Si deployment aún no existe, indicar local/docs build.

---

# 87. CHANGELOG preparation

Crear:

```text
CHANGELOG.md
```

si no existe.

Para pre-release puede incluir:

```text
## [Unreleased]
```

---

# 88. Changelog policy

Registrar cambios orientados a consumidores:

```text
Added
Changed
Fixed
Removed
```

No convertir changelog en git log.

---

# 89. Release notes preparation

Preparar estructura, pero release notes definitivas pertenecen a Parte 24.

---

# 90. Package scripts

Auditar/normalizar scripts, por ejemplo:

```text
build
test
test:unit
test:e2e
test:visual
lint if exists
docs:dev
docs:build
pack:check
```

No agregar scripts que no funcionan.

---

# 91. Prepack

Evaluar script:

```text
prepack
```

para asegurar build antes de tarball.

---

# 92. Prepublish safety

No configurar publicación automática accidental.

---

# 93. npm lifecycle caution

Evitar scripts que hagan:

```text
git push
npm publish
release creation
```

automáticamente durante instalación/build.

---

# 94. Package manager

Respetar lockfile/tooling existente.

No migrar npm ↔ pnpm ↔ yarn en esta fase sin razón.

---

# 95. Node version

Documentar versión mínima basada en tooling real.

Puede usarse `engines` si está justificado.

---

# 96. Browser target

Alinear Vite/build target con browser support documentado en Parte 22.

---

# 97. Modern CSS compatibility

Revisar features usadas:

```text
CSS custom properties
grid
logical properties
container queries if used
:has() if used
color-mix() if used
```

Documentar requerimientos reales.

---

# 98. Prefixing

Usar pipeline existente para compatibilidad.

No agregar prefijos manuales arbitrarios.

---

# 99. Asset handling

Auditar si package distribuye:

```text
fonts
images
SVG
```

Idealmente ORP core no debería requerir assets difíciles de resolver.

---

# 100. Icon assets

ORP no debe empaquetar Bootstrap Icons por accidente.

---

# 101. Font policy

No hacer una Google Font runtime dependency obligatoria del core.

---

# 102. CSS font stack

Preferir stack configurable/tokenizado.

---

# 103. CSP compatibility

Evitar necesidad de inline script/eval.

Documentar cualquier limitación real.

---

# 104. Package security audit

Ejecutar herramientas disponibles del package manager para detectar vulnerabilidades relevantes.

No hacer upgrades mayores indiscriminados solo para obtener cero warnings.

---

# 105. Dependency vulnerabilities

Clasificar:

```text
runtime relevant
dev-only
false/non-impacting
requires action
```

---

# 106. License dependency audit

Si tooling disponible, revisar licencias de runtime dependencies.

Especialmente antes de publicación pública.

---

# 107. Accessibility package smoke test

El tarball instalado debe mantener los resultados a11y obtenidos en source.

---

# 108. Visual regression from dist

Agregar al menos una ejecución donde Playground/fixture consuma `dist` en lugar de source.

Esto detecta imports faltantes.

---

# 109. Dist integrity

No confiar en que source funcionando significa dist funcionando.

---

# 110. Dist-only test

Crear modo/test que temporalmente no permita imports desde `src`.

---

# 111. Clean build

Probar desde estado limpio:

```text
remove dist
build
verify outputs
```

No depender de archivos viejos.

---

# 112. Reproducible build

Dos builds equivalentes no deberían depender de estado local oculto.

---

# 113. Git ignored build

Decidir si `dist/` se versiona o se genera para release.

Documentar decisión.

No cambiar estrategia sin revisar CI/release flow.

---

# 114. CI packaging check

Preparar job/check que pueda ejecutar:

```text
install
build
test
docs build
pack dry-run
consumer smoke test
```

sin publicar.

---

# 115. CI boundaries

Parte 23 puede crear verificación de packaging.

Parte 24 decidirá release/publish workflow.

---

# 116. GitHub Actions

Si repo ya usa GitHub Actions, integrar checks allí.

No asumir GitHub si repo usa otro CI.

---

# 117. Secrets

Packaging checks NO deben requerir token npm.

---

# 118. Registry decision

Preparar para registry, pero no publicar.

Posibles futuros:

```text
npm public registry
GitHub Packages
private registry
```

No elegir uno arbitrariamente si no está decidido.

---

# 119. Public npm readiness

Si objetivo es npm público, comprobar:

```text
package name availability — manual/external check later if needed
license
repository metadata
files
exports
README
version
```

No reservar/publicar nombre automáticamente.

---

# 120. Scoped package decision

Evaluar:

```text
@scope/package
```

vs package sin scope.

No renombrar package sin aprobación si ya tiene consumidores.

---

# 121. Package size budget

Registrar tamaño real del tarball y bundles.

No imponer budget arbitrario sin baseline.

---

# 122. Bundle report

Crear:

```text
PACKAGE-SIZE.md
```

con:

```text
JS size
CSS size
tarball size
unpacked size
file count
largest files
```

si tooling permite obtenerlos.

---

# 123. Bundle growth

Comparar con baseline anterior si existe.

---

# 124. Tree-shaking consumer test

Crear consumer que importe uno o pocos components y revisar bundle cuando tooling permita análisis razonable.

No prometer perfect per-component CSS tree shaking si ORP distribuye un CSS bundle global.

---

# 125. CSS strategy honesty

Documentar si:

```text
JS tree-shakeable
CSS global bundle
```

es la arquitectura actual.

No vender modular CSS si no existe.

---

# 126. Future modular CSS

Puede registrarse para v0.2 si aporta valor.

No reestructurar todo antes de v0.1 sin necesidad.

---

# 127. Import examples verification

Todos los imports mostrados en README/docs deben ejecutarse en consumer fixture.

---

# 128. Documentation build after packaging

Actualizar docs con paths finales y ejecutar:

```text
docs build
```

---

# 129. API docs synchronization

Comparar:

```text
PUBLIC-API.md
DOCS-MATRIX.md
actual exports
```

No permitir drift evidente.

---

# 130. Component exports verification

Crear script/test que compruebe que componentes públicos esperados son importables.

---

# 131. CSS export verification

Comprobar que path CSS documentado existe dentro del tarball.

---

# 132. LESS export verification

Lo mismo si se publica LESS.

---

# 133. Package consumer errors

No deben aparecer errores como:

```text
Module not found
Package subpath not exported
Cannot resolve CSS
Vue duplicated
window is not defined
missing keyframes
```

---

# 134. Error classification

Packaging failures son:

```text
BLOCKER
```

para Parte 24.

---

# 135. Consumer matrix

Crear:

```text
CONSUMER-MATRIX.md
```

Ejemplo:

| Scenario | Install | Import | Dev | Build | Runtime | Status |
|---|---:|---:|---:|---:|---:|---|

---

# 136. Minimum consumer scenarios

```text
Vue 3 + Vite
CSS-only
Vue + Bootstrap coexistence
SSR import smoke test
```

---

# 137. Optional Laravel/Inertia consumer

Dado que ORP se usa en ese ecosistema, puede agregarse smoke integration si ya existe fixture/app disponible.

No hacer Laravel dependencia del package.

---

# 138. Inertia boundary

Ningún import core debe requerir:

```text
@inertiajs/vue3
```

---

# 139. Router boundary

Ningún component core debe requerir Vue Router.

---

# 140. SSR boundary

Ningún import core debe requerir browser environment para simplemente cargar el módulo.

---

# 141. Global state boundary

No agregar store global obligatorio.

---

# 142. CSS reset boundary

Documentar qué reset/base styles aplica ORP para que consumidores sepan el impacto.

---

# 143. `orp-app`

Documentar si sigue siendo root opcional para theme/background/font.

No hacerlo obligatorio si arquitectura dice que es opcional.

---

# 144. `orp-app-shell`

Mantener separado de `orp-app` en package/docs.

---

# 145. Public token stability

Tokens documentados se consideran parte importante de API pública.

Evitar renombrarlos después de v0.1 sin migration note.

---

# 146. CSS class stability

Clases públicas documentadas también son API.

Registrar esta realidad.

---

# 147. Vue props/events stability

Props/events documentados son API pública.

---

# 148. Internal DOM structure

No prometer estabilidad de markup interno salvo que consumidores deban depender de él.

---

# 149. Styling extension policy

Documentar cómo personalizar ORP:

Preferir:

```text
CSS variables
composition
public modifiers
```

sobre selectors profundos contra internals.

---

# 150. Consumer overrides

Evitar recomendar:

```css
.orp-component > div:nth-child(2) {...}
```

---

# 151. Package release checklist

Crear:

```text
RELEASE-CHECKLIST.md
```

pero Parte 24 lo ejecutará formalmente.

---

# 152. Checklist sections

```text
Code
Tests
Accessibility
Docs
Build
Package
Consumers
Version
Changelog
Registry
Git
Release
Post-release
```

---

# 153. Parte 23 checklist status

Marcar todo lo preparatorio.

Dejar publicación/tag/release como pendiente de Parte 24.

---

# 154. No publish

NO ejecutar:

```bash
npm publish
```

---

# 155. No Git tag

NO crear todavía:

```text
v0.1.0
```

---

# 156. No GitHub Release

NO crear release público.

---

# 157. No registry token

No solicitar/configurar token de publicación todavía salvo que Parte 24 lo requiera.

---

# 158. No automatic version bump

No cambiar versión sin comprobar estado actual y estrategia.

Puede recomendar valor para Parte 24.

---

# 159. Packaging regression tests

Después de cualquier cambio en build/package.json ejecutar nuevamente:

```text
unit tests
interaction tests
visual tests where relevant
build
docs build
consumer builds
npm pack dry-run
```

---

# 160. Spinner/Skeleton dist check

Dado el historial de bugs, verificar específicamente desde tarball:

```text
Spinner animation
Skeleton animation
reduced motion
Dark theme
```

---

# 161. List dist check

Verificar desde tarball:

```text
Divided
Inset
Composition
current buttons/icons
```

---

# 162. Dialog dist check

Verificar:

```text
Alert
Confirm
Prompt
Preloader
Progress
Stack
```

si públicos.

---

# 163. Notification dist check

Verificar:

```text
basic
full
stack
banner
center
```

si públicos.

---

# 164. Table dist check

Verificar CSS y comportamiento interactivo desde consumer package.

---

# 165. Media dist check

Verificar Video/Audio si forman parte del API público.

---

# 166. External integration dist check

Probar al menos:

```text
Bootstrap Icons
Swiper
GLightbox
```

si siguen siendo integraciones oficiales.

---

# 167. Installation from tarball docs

Durante desarrollo puede documentarse cómo probar tarball localmente, pero no convertirlo en instalación principal de usuario final.

---

# 168. Local development workflow

Documentar para maintainers:

```text
build library
pack locally
install fixture
run smoke test
```

---

# 169. CONTRIBUTING readiness

Si repo será colaborativo, preparar/actualizar:

```text
CONTRIBUTING.md
```

con instrucciones mínimas.

No requisito si proyecto seguirá privado y de un solo maintainer, pero reportar decisión.

---

# 170. Contributing minimum

Si se crea:

```text
setup
branch/workflow
coding conventions
component rules
tests
docs
build
```

---

# 171. Component contribution rule

Recordar:

```text
primitive existing?
→ compose it

behavior required?
→ consider Vue

specialized engine?
→ integrate externally
```

---

# 172. Code of Conduct

No crear automáticamente si no es necesario para el proyecto actual.

Puede decidirse antes de open-source release.

---

# 173. Security policy

Puede prepararse `SECURITY.md` si ORP será público.

No inventar email/contacto de seguridad.

---

# 174. Repository cleanliness

Antes de release identificar:

```text
TODOs
FIXMEs
console.log
debugger
temporary files
unused fixtures
local absolute paths
```

---

# 175. Source maps privacy

Si sourcemaps se publican, confirmar que no contienen rutas/datos sensibles inesperados.

---

# 176. Package secrets audit

Buscar accidentalmente:

```text
API keys
tokens
.env
credentials
private URLs
```

No imprimir secretos encontrados en reporte; solo indicar archivo/tipo de problema de forma segura.

---

# 177. NPM ignore / files

Preferir `files` allowlist cuando sea práctico.

No depender exclusivamente de `.npmignore` complejo.

---

# 178. README examples test

Ejecutar/copiar literalmente los ejemplos principales en fixture.

---

# 179. Package provenance/signing

Fuera de scope de Parte 23 salvo que tooling actual ya lo use.

Puede evaluarse en Parte 24.

---

# 180. Release automation

No construir release automation completa todavía.

Parte 23 puede dejar CI preparado.

---

# 181. Changesets / semantic-release

NO instalar automáticamente:

```text
Changesets
semantic-release
release-it
standard-version
```

Decidir solo si realmente se necesita en Parte 24/futuro.

---

# 182. Monorepo tooling

No convertir repo a monorepo solo por docs/fixtures.

---

# 183. Package architecture simplicity

Preferir:

```text
one package
clear exports
few entry points
```

para v0.1.

---

# 184. Future packages

No separar ahora en:

```text
@orp/core
@orp/vue
@orp/theme
@orp/icons
```

salvo evidencia fuerte de que repo ya requiere esa arquitectura.

---

# 185. Release candidate option

Parte 23 puede recomendar probar:

```text
0.1.0-rc.1
```

antes de stable si consumer tests reales lo justifican.

No publicar RC automáticamente.

---

# 186. Release readiness classification

Al final usar:

```text
READY FOR RELEASE
READY FOR RELEASE CANDIDATE
NOT READY FOR RELEASE
```

---

# 187. Blockers for Part 24

Ejemplos:

```text
package cannot install
bad exports
missing CSS
Vue bundled twice
SSR import crash
consumer build fails
critical docs imports wrong
license unresolved for public release
runtime dependency missing
```

---

# 188. Required artifacts

Crear/actualizar:

```text
PUBLIC-API.md
PACKAGE-SIZE.md
CONSUMER-MATRIX.md
RELEASE-CHECKLIST.md
CHANGELOG.md
README.md
```

según necesidad real.

---

# 189. Final report

Entregar:

## Package Metadata
Estado.

## Version
Actual y propuesta.

## Public API
Resumen.

## Entry Points
Lista real.

## CSS Distribution
Resultado.

## LESS Distribution
Resultado/decisión.

## Vue Build
Resultado.

## Peer Dependencies
Resultado.

## Runtime Dependencies
Resultado.

## Optional Integrations
Resultado.

## Export Map
Resultado.

## sideEffects
Resultado.

## SSR
Resultado.

## Tree Shaking
Resultado.

## npm pack
Resultado real.

## Package Size
Valores reales.

## Consumer Vue + Vite
PASS/FAIL.

## CSS-only Consumer
PASS/FAIL.

## Bootstrap Coexistence
PASS/FAIL.

## Theme Consumer Tests
PASS/FAIL.

## Integrations
PASS/FAIL.

## Documentation Sync
Resultado.

## README
Resultado.

## Changelog
Resultado.

## CI Packaging Check
Resultado.

## Security/Secrets Audit
Resultado.

## Files Created
Lista.

## Files Modified
Lista.

## Blockers
Lista.

## Release Readiness

```text
READY FOR RELEASE
```

or

```text
READY FOR RELEASE CANDIDATE
```

or

```text
NOT READY FOR RELEASE
```

con razones concretas.

---

# 190. Completion criteria

Parte 23 termina cuando:

```text
public API is explicit
package exports are valid
CSS package works standalone
Vue is not duplicated
runtime dependencies are minimal
optional integrations remain optional
clean build passes
SSR import smoke test passes
npm pack dry-run passes
tarball installs successfully
Vue consumer builds
CSS-only consumer works
Bootstrap coexistence is verified
themes work from distributed package
docs use final import paths
README is consumer-ready
release checklist exists
no publishing has occurred
```

---

# 191. Explicit exclusions

No hacer todavía:

```text
npm publish
Git tag
GitHub Release
registry credentials
production CDN
release announcement
v0.2 development
component expansion
major architecture rewrite
monorepo migration
```

---

# 192. Do not continue automatically

No ejecutar Parte 24.

Terminar con readiness report.

---

# Regla final

Parte 23 debe demostrar esta cadena completa:

```text
ORP source
   ↓
clean build
   ↓
distribution package
   ↓
local tarball
   ↓
fresh consumer application
   ↓
import ORP
   ↓
render ORP
   ↓
production consumer build
```

Si ORP solamente funciona dentro de su propio Playground, **todavía no está empaquetado correctamente**.

La prueba real de Parte 23 es:

```text
Can a completely separate application install ORP UI
and use it without knowing its internal repository structure?
```

Solo cuando la respuesta sea **sí**, ORP UI estará listo para pasar a:

```text
Parte 24 — v0.1.0 Release
```

