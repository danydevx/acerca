# SKILL — ORP UI / Parte 21: Data Visualization Foundations

## Objetivo

Agregar a ORP UI una base visual consistente para **dashboards, métricas y visualización de datos**, sin convertir el framework en una librería de gráficas.

Esta fase debe permitir construir interfaces modernas con:

```text
KPIs
charts
legends
trends
comparison metrics
progress visualization
dashboard panels
chart toolbars
empty/loading/error states
```

ORP UI debe encargarse de:

```text
layout
presentation
tokens
containers
legends
labels
states
responsive composition
accessibility guidance
integration styling
```

La librería especializada de charts debe encargarse de:

```text
SVG/canvas rendering
axes
scales
datasets
tooltips engine
zoom
pan
series calculations
chart algorithms
```

---

# 1. Principio principal

NO construir un Chart.js/ECharts/ApexCharts/D3 propio.

Arquitectura:

```text
ORP UI
        ↓
Chart Shell / Legend / Metrics / States
        ↓
External chart library
        ↓
Application data
```

---

# 2. Scope

```text
Data Visualization
├── Chart Shell
├── Chart Header
├── Chart Body
├── Chart Footer
├── Chart Legend
├── Legend Item
├── Metric Card composition
├── Trend Indicator
├── Comparison Metric
├── Sparkline Container
├── Progress Ring integration
├── Meter
├── Distribution Bar
├── Segmented Progress
├── Data Color Tokens
├── Chart Empty State
├── Chart Loading State
├── Chart Error State
├── Chart Toolbar composition
└── External Chart Integration
```

---

# 3. Existing primitives first

Auditar antes de crear:

```text
orp-card
orp-stat
orp-meta
orp-badge
orp-progress
orp-progress-ring
orp-status-dot
orp-grid
orp-stack
orp-cluster
orp-empty
orp-skeleton
orp-spinner
orp-toolbar
orp-dropdown
orp-segmented
```

No duplicarlos.

---

# 4. Chart Shell

Crear un contenedor neutral:

```text
orp-chart
```

No renderiza una gráfica.

Solo proporciona estructura consistente.

---

# 5. Chart structure

Referencia conceptual:

```text
orp-chart
├── orp-chart__header
│   ├── title
│   ├── description
│   ├── meta
│   └── actions
├── orp-chart__body
│   └── external chart
├── orp-chart__legend
└── orp-chart__footer
```

---

# 6. Chart Shell vs Card

No duplicar Card.

Cuando una gráfica está dentro de Card:

```text
orp-card
└── orp-chart
```

`orp-chart` debe poder funcionar también sin Card.

---

# 7. Chart Header

Debe permitir:

```text
title
description
primary metric
comparison
time range
actions
```

Preferir composición con primitives existentes.

---

# 8. Chart Toolbar

No crear toolbar nueva.

Componer:

```text
orp-toolbar
orp-segmented
orp-select
orp-dropdown
orp-icon-btn
```

---

# 9. Time range

ORP puede presentar:

```text
7 days
30 days
90 days
Year
```

pero no debe calcular fechas ni consultar datos.

---

# 10. Chart body

`orp-chart__body` debe:

```text
provide minimum sensible size
allow responsive width
avoid overflow
support SVG
support canvas
support HTML charts
```

No imponer una librería.

---

# 11. Fixed heights

Evitar depender de una única altura rígida.

Permitir custom property:

```css
--orp-chart-height
```

si aporta valor.

---

# 12. Aspect ratio

Para charts simples puede permitirse:

```text
aspect-ratio
```

pero dashboards suelen requerir alturas controladas.

Documentar ambas estrategias.

---

# 13. Chart Legend

Crear:

```text
orp-chart-legend
```

o naming equivalente coherente con BEM actual.

Debe ser independiente de librería.

---

# 14. Legend Item

Estructura:

```text
marker
label
value optional
```

Ejemplo:

```text
● Desktop 62%
● Mobile 38%
```

---

# 15. Legend marker

No depender únicamente de color.

Cuando sea necesario, complementar con:

```text
label
pattern
symbol
text
```

---

# 16. Legend layout

Debe soportar:

```text
horizontal
wrapped
vertical
```

Mobile-first.

---

# 17. Interactive legends

Si una librería permite ocultar series al hacer click:

la aplicación maneja esa lógica.

ORP puede presentar el item como button si realmente es interactivo.

---

# 18. Non-interactive legends

No usar `<button>` si solo informa.

---

# 19. Data visualization tokens

Agregar una paleta semánticamente neutral para series.

Ejemplo conceptual:

```css
--orp-data-1
--orp-data-2
--orp-data-3
--orp-data-4
--orp-data-5
--orp-data-6
--orp-data-7
--orp-data-8
```

---

# 20. Data colors are not semantic status colors

No usar automáticamente:

```text
success
warning
danger
```

como series de charts.

Separar:

```text
semantic status colors
```

de:

```text
categorical data colors
```

---

# 21. Data token requirements

Los colores deben:

```text
work in light theme
work in dark theme
remain distinguishable
avoid excessive saturation
support custom themes
```

---

# 22. Custom theme

Un theme puede sobrescribir:

```text
--orp-data-1 ... --orp-data-8
```

sin recompilar LESS.

---

# 23. Series count

No crear 30 colores.

Base recomendada:

```text
6–8
```

Si aplicación necesita más, puede definirlos.

---

# 24. Sequential data

No crear sistema completo de color scales.

Puede documentarse cómo una aplicación define:

```text
--orp-data-sequential-1
...
```

solo si existe necesidad real.

---

# 25. Trend Indicator

Crear primitive:

```text
orp-trend
```

para representar:

```text
increase
decrease
neutral
```

---

# 26. Trend structure

```text
icon
value
label optional
```

Ejemplo:

```text
↑ 12.4%
```

---

# 27. Trend meaning

NO asumir:

```text
up = good
down = bad
```

Esto es importantísimo.

En algunos datos:

```text
errors down = good
costs up = bad
```

Separar:

```text
direction
```

de:

```text
sentiment/status
```

---

# 28. Trend API concept

Visual states pueden distinguir:

```text
direction:
up
down
flat

tone:
positive
negative
neutral
```

No acoplarlos.

---

# 29. Trend icons

Bootstrap Icons en Playground:

```text
bi-arrow-up-right
bi-arrow-down-right
bi-dash
```

Core sigue icon agnostic.

---

# 30. Comparison Metric

Pattern:

```text
current value
previous/reference value
trend
period/meta
```

Preferir composición:

```text
Stat
+
Trend
+
Meta
```

No crear Vue component si no aporta comportamiento.

---

# 31. KPI cards

Parte 18 ya contempla Stat/KPI composition.

No crear otro KPI system.

Parte 21 agrega ejemplos orientados a dashboards.

---

# 32. Metric Grid

Usar:

```text
orp-grid
```

No crear `.orp-dashboard-grid` si Grid ya resuelve el layout.

---

# 33. Sparkline

ORP NO debe dibujar sparkline compleja.

Crear únicamente contenedor/pattern:

```text
orp-sparkline
```

si hace falta para dimensiones/alineación.

---

# 34. Sparkline implementation

La aplicación puede usar:

```text
SVG
external chart library
custom tiny SVG
```

ORP solo integra visualmente.

---

# 35. Sparkline accessibility

Una sparkline puramente decorativa puede ocultarse a tecnologías asistivas.

El valor/tendencia importante debe existir como texto.

---

# 36. Meter

Evaluar primitive:

```text
orp-meter
```

pero preferir HTML nativo:

```html
<meter>
```

cuando semántica sea correcta.

---

# 37. Meter vs Progress

Documentar:

```text
progress
→ completion of a task/process

meter
→ scalar measurement within a known range
```

Ejemplos:

```text
Upload 65% → progress
Storage 65% used → meter
```

---

# 38. Meter styling

Crear styling ORP sobre `<meter>` si soporte moderno permite consistencia razonable.

No destruir semántica nativa.

---

# 39. Meter states

No convertir automáticamente rangos en danger/warning.

La aplicación puede definir tone.

---

# 40. Distribution Bar

Pattern CSS-first:

```text
orp-distribution
```

para representar partes de un total.

Ejemplo:

```text
Desktop 60
Mobile 30
Tablet 10
```

---

# 41. Distribution Bar structure

```text
bar
├── segment
├── segment
└── segment

legend
```

---

# 42. Distribution data

Aplicación proporciona porcentajes.

ORP no calcula estadísticas.

---

# 43. Distribution width

Puede utilizar custom property local:

```css
--orp-distribution-value
```

Ejemplo conceptual:

```html
<span
  class="orp-distribution__segment"
  style="--orp-distribution-value: 60%"
></span>
```

---

# 44. Distribution accessibility

La información no debe existir únicamente en ancho/color.

Proporcionar labels/values textuales.

---

# 45. Segmented Progress

Evaluar si Distribution Bar cubre este patrón.

No crear otro primitive si visualmente es lo mismo.

---

# 46. Progress Ring

Reutilizar primitive existente de Parte 11.

No crear donut chart usando Progress Ring.

---

# 47. Progress Ring vs Donut

Documentar:

```text
Progress Ring
→ one value toward completion/target

Donut Chart
→ distribution among categories
```

No mezclar semánticas.

---

# 48. Donut/Pie charts

No implementar internamente.

Usar librería externa.

ORP proporciona:

```text
Chart Shell
Legend
tokens
states
```

---

# 49. Bar charts

Externos.

---

# 50. Line charts

Externos.

---

# 51. Area charts

Externos.

---

# 52. Scatter plots

Externos.

---

# 53. Heatmaps

Externos.

---

# 54. Maps

No pertenecen a esta fase.

Leaflet sigue siendo integración especializada si aplicación lo necesita.

---

# 55. External chart libraries

ORP debe poder integrarse con opciones como:

```text
Chart.js
ApexCharts
ECharts
D3
```

sin depender de ninguna.

No instalar automáticamente.

---

# 56. Recommended integration strategy

La aplicación importa su chart library.

Luego mapea tokens ORP:

```text
--orp-data-1
--orp-data-2
--orp-border
--orp-muted-foreground
--orp-surface
--orp-foreground
```

a configuración del chart.

---

# 57. CSS variables from JS

Documentar helper conceptual:

```js
getComputedStyle(element)
  .getPropertyValue('--orp-data-1')
```

para integraciones que necesiten colores JS.

No crear global helper obligatorio salvo repetición real.

---

# 58. Theme changes

Si la librería externa cachea colores:

la aplicación/integration adapter puede necesitar actualizar chart al cambiar theme.

ORP core no debe administrar instancias externas.

---

# 59. Optional adapters

NO crear adapters oficiales en core en esta fase.

Primero documentar integración.

En futuro podrían existir paquetes:

```text
@orp-ui/chartjs
@orp-ui/echarts
```

pero quedan fuera de scope.

---

# 60. Chart Empty State

Reutilizar:

```text
orp-empty
```

Ejemplos:

```text
No data
No results
No activity
```

No crear `ChartEmpty`.

---

# 61. Chart Loading State

Reutilizar:

```text
orp-skeleton
```

preferentemente.

---

# 62. Chart Skeleton

Puede componerse con Skeleton primitives.

No crear animación nueva.

Ejemplo:

```text
header skeleton
metric skeleton
chart-area rectangle skeleton
legend skeleton
```

---

# 63. Chart Spinner

Usar Spinner para operaciones breves/indeterminadas.

Para carga inicial de dashboard, Skeleton suele comunicar mejor estructura.

---

# 64. Chart Error State

Reutilizar:

```text
orp-alert
orp-callout
orp-empty
```

según contexto.

No crear sistema de error nuevo.

---

# 65. Retry

Aplicación maneja retry.

ORP presenta Button.

---

# 66. Dashboard composition

Crear demos/patterns, no necesariamente clases nuevas.

Ejemplo:

```text
Page
├── Section Header
├── Metric Grid
│   ├── Stat Card
│   ├── Stat Card
│   ├── Stat Card
│   └── Stat Card
├── Grid
│   ├── Chart Card
│   └── Chart Card
└── Data List
```

---

# 67. Dashboard layout

Usar:

```text
orp-grid
orp-stack
orp-section
orp-card
```

No crear un dashboard layout framework paralelo.

---

# 68. Chart card

Preferir:

```text
orp-card + orp-chart
```

No crear `.orp-chart-card` si solo combina ambos.

---

# 69. Dashboard density

Debe funcionar con densidad moderada sin sacrificar legibilidad.

No agregar `compact` a todo automáticamente.

---

# 70. Chart Header responsive

En mobile:

```text
title
metric
actions
```

pueden envolver.

No permitir overflow horizontal por toolbar.

---

# 71. Legend responsive

En mobile:

```text
wrap
vertical
horizontal scroll only if justified
```

Preferir wrap.

---

# 72. Chart horizontal overflow

Charts externos deben adaptarse al container.

ORP no debe provocar overflow accidental.

---

# 73. Minimum chart width

Si un tipo de chart necesita ancho mínimo, integración externa puede usar `orp-scroll-x`.

No imponerlo globalmente.

---

# 74. Responsive matrix

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

# 75. Dashboard mobile

En 320–430px:

```text
metrics stack cleanly
charts remain readable
legends wrap
actions remain reachable
```

---

# 76. Desktop

En desktop aprovechar Grid existente.

No introducir 12-column Bootstrap clone.

---

# 77. Container queries

Si Grid/Part12 ya soporta container queries:

pueden aprovecharse.

No hacer requisito si no existen.

---

# 78. Typography

Valores grandes deben usar typography system.

No hardcodear:

```text
font-size: 42px
```

si tokens/clamp existentes resuelven.

---

# 79. Numeric alignment

Considerar:

```css
font-variant-numeric: tabular-nums;
```

para métricas donde mejore comparación.

Aplicar con cuidado.

---

# 80. Large values

Probar:

```text
9
999
12,450
1.2M
$125,430.90
99.999%
```

ORP no formatea valores.

---

# 81. Localization

Aplicación es responsable de:

```text
currency
decimal separators
dates
percentages
compact notation
```

ORP solo presenta strings.

---

# 82. Negative values

Layouts deben soportar:

```text
-12.5%
-$1,250
```

sin romper.

---

# 83. Long labels

Probar legends con labels largos.

---

# 84. Many legend items

Probar 8 series.

No diseñar para 40 categorías.

---

# 85. Data table relation

Parte 11 ya contiene Table/Data List.

Documentar que una visualización importante debería poder complementarse con datos tabulares cuando accesibilidad/precisión lo requiera.

---

# 86. Accessibility principle

Una gráfica visual nunca debe ser la única forma de acceder a información crítica.

---

# 87. Chart accessibility

Dependiendo de chart library:

proporcionar:

```text
title
description
summary
table alternative
```

cuando sea apropiado.

---

# 88. Canvas accessibility

Canvas por sí solo no comunica datos correctamente a lectores de pantalla.

Documentar alternativa textual/tabular.

---

# 89. SVG accessibility

SVG puede mejorar semántica, pero no asumir que automáticamente es accesible.

---

# 90. Color blindness

No depender únicamente de diferencias rojo/verde.

---

# 91. Contrast

Text labels y controls deben cumplir contraste WCAG correspondiente.

Para áreas de datos, buscar diferenciación suficiente sin afirmar automáticamente cumplimiento para cada combinación de series.

---

# 92. Data colors

Auditar con simulación/criterios de distinguishability si tooling disponible.

No instalar herramientas pesadas solo para esto.

---

# 93. Focus

Interactive chart controls usan focus-visible ORP.

El canvas/chart no debe ser tabbable sin razón.

---

# 94. Tooltip

Tooltips de datos pertenecen a chart library.

No crear tooltip engine en ORP.

---

# 95. Chart controls

Zoom/filter/range controls pueden usar ORP components.

La lógica pertenece a aplicación/chart library.

---

# 96. Hover-only data

No diseñar información esencial disponible únicamente en hover.

Debe existir alternativa touch/keyboard/textual según integración.

---

# 97. Touch

Chart controls deben mantener touch targets apropiados.

---

# 98. Motion

No agregar animaciones de charts en core.

La librería externa controla animación de series.

---

# 99. Reduced motion

Documentar que integraciones externas deben respetar:

```text
prefers-reduced-motion
```

y desactivar/reducir chart animations.

---

# 100. ORP motion

Solo animaciones propias como:

```text
hover
focus
state transition
```

usan motion tokens existentes.

---

# 101. Theme compatibility

Probar:

```text
Light
Dark
Custom
```

---

# 102. Dark charts

Documentar mapeo de:

```text
grid lines
axis labels
tooltip surfaces
legend text
background
series
```

a tokens ORP.

---

# 103. Chart grid color

Usar token derivado de:

```text
--orp-border
```

en ejemplos de integración.

No hardcodear gris.

---

# 104. Axis text

Usar:

```text
--orp-muted-foreground
```

o token equivalente.

---

# 105. Tooltip external styling

Cuando librería permita HTML/CSS tooltip:

puede estilizarse visualmente con tokens ORP.

No sobrescribir globalmente clases de terceros.

---

# 106. Scoped integrations

Ejemplo:

```text
.orp-chart .apexcharts-*
.orp-chart .chartjs-*
```

solo si realmente se agrega CSS de integración.

Evitar selectors frágiles.

---

# 107. No global third-party overrides

Nunca:

```css
.apexcharts-tooltip { ... }
```

global si puede afectar charts fuera de ORP.

Scope bajo `.orp-chart`.

---

# 108. Chart.js

Si se documenta:

mostrar cómo leer CSS variables y pasarlas a config.

No agregar dependencia.

---

# 109. ApexCharts

Misma regla.

---

# 110. ECharts

Misma regla.

---

# 111. D3

D3 es bajo nivel.

ORP solo aporta container/tokens.

No crear abstracción D3.

---

# 112. CSS architecture

Posibles archivos:

```text
less/components/
├── chart.less
├── trend.less
├── meter.less
└── distribution.less
```

Solo crear los necesarios.

---

# 113. Token architecture

Data colors deben vivir con tokens/theme system, no enterrados en `chart.less`.

---

# 114. LESS authoring

LESS puede definir defaults.

Runtime theming usa:

```text
--orp-data-*
```

---

# 115. Vue components

Esta fase debería necesitar muy pocos o ningún componente Vue nuevo.

Preferir CSS-first.

---

# 116. No OrpChart.vue by default

No crear wrapper Vue solo para:

```html
<div class="orp-chart">
```

---

# 117. No OrpTrend.vue by default

Si es markup simple, CSS primitive.

---

# 118. No chart library wrappers

NO crear:

```text
OrpLineChart
OrpBarChart
OrpPieChart
OrpAreaChart
```

---

# 119. Playground

Agregar categoría:

```text
Data Visualization
```

---

# 120. Playground sections

```text
Metrics
Trends
Chart Shell
Legends
Meter
Distribution
Loading States
Empty/Error States
Dashboard Composition
Chart Integration
```

---

# 121. Metrics demo

Mostrar:

```text
Basic Stat
Stat + Trend
Comparison
Metric Grid
Positive/Negative/Neutral tones
```

---

# 122. Trend demo

Debe demostrar explícitamente:

```text
up + positive
up + negative
down + positive
down + negative
flat + neutral
```

para evitar acoplar dirección con significado.

---

# 123. Chart Shell demo

Puede usar un mock visual CSS/SVG simple únicamente para demostrar layout.

No convertir mock en chart engine.

---

# 124. Legend demo

Mostrar:

```text
horizontal
wrapped
vertical
with values
interactive-looking only when actually buttons
```

---

# 125. Meter demo

Mostrar:

```text
storage
score
capacity
```

como ejemplos genéricos.

---

# 126. Distribution demo

Mostrar:

```text
2 segments
3 segments
6 segments
```

con legend textual.

---

# 127. Loading demo

Mostrar:

```text
Chart Skeleton
Metric Skeleton
Dashboard Skeleton
```

reutilizando Skeleton actual.

---

# 128. Empty demo

Reutilizar Empty State.

---

# 129. Error demo

Reutilizar Alert/Callout + Button.

---

# 130. Dashboard demo

Crear una composición visual realista usando primitives existentes.

Debe ser suficientemente pulida para mostrar que ORP ya puede construir dashboards modernos.

---

# 131. Integration demo

Si ya existe alguna librería de charts en Playground:

reutilizarla.

Si no existe:

NO instalar una automáticamente solo para la demo.

Puede documentarse integración con pseudo-config y usar SVG demo local determinista.

---

# 132. No CDN

Playground no debe cargar charts desde CDN.

---

# 133. Bootstrap audit

No usar:

```text
container
row
col-*
card
badge
progress
d-flex
gap-*
p-*
m-*
```

de Bootstrap.

Solo Bootstrap Icons opcional.

---

# 134. Namespace

Mantener:

```text
orp-*
@orp-*
--orp-*
Orp*
data-orp-*
```

---

# 135. RTL

Probar:

```html
dir="rtl"
```

en:

```text
Chart Header
Legend
Trend
Metrics
Toolbar
Distribution labels
```

No invertir significado matemático de una gráfica automáticamente.

---

# 136. Testing

Ejecutar suite de Parte 17.

---

# 137. Visual regression fixtures

Agregar:

```text
metrics-light
metrics-dark
trend-states
chart-shell-light
chart-shell-dark
chart-legend-mobile
distribution
dashboard-mobile
dashboard-desktop
dashboard-dark
```

---

# 138. Theme regression

Light/Dark/Custom.

---

# 139. Responsive regression

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

---

# 140. Accessibility tests

Auditar:

```text
legend semantics
interactive controls
keyboard
focus
text alternatives
color-only information
meter/progress semantics
```

---

# 141. Build

Confirmar:

```text
CSS build
Vue build
public exports
SSR safety
```

---

# 142. Performance

Chart foundations deben añadir muy poco JS.

Esperado:

```text
mostly CSS
```

---

# 143. Bundle

Reportar crecimiento:

```text
CSS before/after
JS before/after
```

---

# 144. Documentation

Crear/adaptar:

```text
docs/data-visualization/
├── overview.md
├── chart-shell.md
├── legends.md
├── data-colors.md
├── trends.md
├── meter.md
├── distribution.md
├── states.md
├── accessibility.md
└── integrations.md
```

---

# 145. Decision guide

Documentar:

```text
Stat vs Chart
Progress vs Meter
Progress Ring vs Donut
Distribution vs Stacked Chart
Chart vs Table
Skeleton vs Spinner
```

---

# 146. Stat vs Chart

```text
Stat
→ one important value

Chart
→ relationship/change/distribution across multiple values
```

---

# 147. Progress vs Meter

```text
Progress
→ task completion

Meter
→ measurement within range
```

---

# 148. Ring vs Donut

```text
Progress Ring
→ one completion/target value

Donut
→ categories composing a whole
```

---

# 149. Distribution vs Chart

```text
Distribution Bar
→ simple proportional composition

Stacked chart
→ richer comparison across dimensions/time
```

---

# 150. Chart vs Table

```text
Chart
→ patterns and trends

Table
→ exact values and detailed comparison
```

Muchas interfaces pueden ofrecer ambos.

---

# 151. Skeleton vs Spinner

```text
Skeleton
→ structural loading

Spinner
→ short/indeterminate operation
```

---

# 152. External integration checklist

Para cada chart library futura:

```text
responsive
theme tokens
data colors
axis colors
grid colors
tooltip
legend
reduced motion
dark theme
resize
destroy lifecycle
SSR
accessibility
```

---

# 153. Security

No usar `v-html` para chart labels/dataset names provenientes de usuario.

---

# 154. Dataset labels

Renderizar como texto salvo sanitización explícita de aplicación.

---

# 155. SSR

Chart libraries pueden depender de browser APIs.

ORP core debe seguir SSR-safe.

La aplicación es responsable de client-only initialization de librerías que lo requieran.

---

# 156. Resize

No crear ResizeObserver manager global.

Chart library/app maneja resize.

`orp-chart` solo proporciona container responsive.

---

# 157. Print

Los containers deberían degradar razonablemente al imprimir.

No prometer que canvas charts externos imprimirán correctamente; eso depende de integración.

---

# 158. High contrast

Revisar que borders/legend markers/controls sigan siendo identificables.

No depender de shadows únicamente.

---

# 159. Existing components audit

Especial atención a:

```text
Stat
Progress
Progress Ring
Status Dot
Badge
Meta
Card
Grid
Toolbar
Skeleton
Empty
```

Parte 21 debe fortalecerlos mediante composición, no reemplazarlos.

---

# 160. Completion criteria

Parte 21 termina cuando ORP UI pueda construir visualmente un dashboard moderno con:

```text
metric cards
trend indicators
chart containers
legends
data color tokens
meters
simple distributions
loading states
empty/error states
responsive chart composition
```

sin implementar algoritmos de charts.

---

# 161. Result expected

Al finalizar entregar:

## Audit

Primitives existentes reutilizados.

## New primitives

Lista exacta.

## Data tokens

Variables agregadas.

## Chart Shell

Arquitectura final.

## Trends

Dirección vs tono.

## Meter

Resultado.

## Distribution

Resultado.

## External integrations

Estrategia.

## Files created

Lista.

## Files modified

Lista.

## Public API

Cambios.

## Playground

Demos agregadas.

## Dashboard demo

Resultado.

## Accessibility

Resultado.

## Responsive

Viewports.

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

# 162. Explicit exclusions

NO implementar:

```text
chart rendering engine
LineChart component
BarChart component
PieChart component
DonutChart component
AreaChart component
ScatterPlot component
Heatmap component
D3 abstraction
Chart.js wrapper
ApexCharts wrapper
ECharts wrapper
map visualization
financial chart engine
real-time chart engine
zoom/pan engine
tooltip positioning engine
data aggregation
statistics
currency/date formatting
analytics backend
```

---

# 163. No new dependencies

No instalar automáticamente:

```text
Chart.js
ApexCharts
ECharts
D3
Highcharts
Plotly
```

La aplicación decide qué librería utilizar.

---

# 164. Do not continue automatically

No implementar Parte 22.

Terminar con reporte técnico.

---

# Regla final

ORP UI debe proporcionar el **lenguaje visual de los datos**, no el motor matemático que los dibuja.

```text
Application Data
        ↓
Chart Library
        ↓
ORP Chart Shell
        ↓
ORP Dashboard Composition
```

Y para métricas simples:

```text
Application Value
        ↓
Stat / Trend / Meter / Distribution
        ↓
ORP presentation
```

Mantener siempre:

```text
CSS first
Composition first
Accessible
Responsive
Themeable
Library agnostic
No backend coupling
No router coupling
No Bootstrap CSS dependency
```

Una vez terminada esta fase, ORP UI debe poder construir dashboards visualmente completos sin quedar amarrado a Chart.js, ApexCharts, ECharts o cualquier otra librería específica.

