# SKILL — ORP UI / Parte 21.5: Advanced Tables & Data Grid UX

## Objetivo

Evolucionar el `Table` básico existente en ORP UI hacia una experiencia completa para **tablas de datos modernas**, manteniendo HTML semántico, accesibilidad, mobile-first y separación estricta entre presentación y lógica de datos.

Esta fase debe permitir construir:

```text
admin tables
SaaS tables
user lists
audit logs
reports
inventory views
data management screens
```

sin introducir lógica específica de esos dominios.

ORP UI debe encargarse de:

```text
table presentation
column definitions
sorting interaction
selection interaction
expanded rows
row actions
sticky behavior
responsive UX
loading/empty/error states
toolbar composition
pagination presentation
accessibility
```

La aplicación sigue siendo responsable de:

```text
database queries
API requests
server-side sorting
filtering
pagination data
permissions
exports
business actions
formatting
persistence
```

---

# 1. Scope

```text
Advanced Tables
├── Table Foundation Audit
├── Table Variants
├── Column Definitions
├── Sortable Headers
├── Row Selection
├── Select All
├── Row Actions
├── Expandable Rows
├── Sticky Header
├── Sticky Columns
├── Column Alignment
├── Column Priority
├── Table Toolbar
├── Search / Filters composition
├── Bulk Actions
├── Pagination Bar
├── Page Size
├── Result Count
├── Loading Rows
├── Empty State
├── No Results State
├── Error State
├── Responsive Strategies
└── Optional OrpDataTable
```

---

# 2. Existing foundation

Parte 11 ya introdujo:

```text
Table
Data List
Key/Value
Stat
Definition List
Timeline
```

NO reemplazar esa base sin auditarla.

Primero revisar:

```text
table.less
table markup
responsive wrapper
existing modifiers
Playground examples
documentation
```

---

# 3. Core principle

Mantener dos niveles:

```text
orp-table
→ semantic CSS primitive

OrpDataTable
→ optional Vue orchestration component
```

No obligar a usar Vue para una tabla simple.

---

# 4. Basic table remains CSS-first

Una tabla estática debe poder seguir usando:

```html
<div class="orp-table-wrap">
  <table class="orp-table">
    ...
  </table>
</div>
```

sin Vue.

---

# 5. DataTable justification

`OrpDataTable.vue` sí puede justificarse porque coordina:

```text
columns
rows
sorting
selection
expanded rows
loading
empty
slots
events
```

sin ejecutar lógica de negocio.

---

# 6. ORP DataTable is not a data engine

NO implementar internamente:

```text
database sorting
remote filtering
HTTP requests
server pagination
CSV export
Excel export
permissions
CRUD
```

---

# 7. Data flow

Arquitectura esperada:

```text
User interaction
       ↓
OrpDataTable
       ↓
event
       ↓
Application
       ↓
API / local state
       ↓
new rows
       ↓
OrpDataTable
```

---

# 8. Sorting example

```text
User clicks "Name"
       ↓
emit:
{
  key: "name",
  direction: "asc"
}
       ↓
Application handles sorting
```

---

# 9. Filtering example

```text
SearchInput
       ↓
Application state
       ↓
API/local filter
       ↓
rows
```

DataTable no necesita filtrar internamente por defecto.

---

# 10. Pagination example

```text
Pagination
       ↓
page-change
       ↓
Application
       ↓
fetch page
       ↓
rows
```

---

# 11. Table variants

Auditar/implementar solo variantes genéricas justificadas:

```text
default
striped
bordered
hoverable
compact
comfortable
fixed
```

---

# 12. Variant naming

Ejemplo:

```text
orp-table--striped
orp-table--bordered
orp-table--hover
orp-table--compact
orp-table--fixed
```

Adaptar al naming existente.

---

# 13. Avoid variants explosion

NO:

```text
orp-table--users
orp-table--orders
orp-table--products
orp-table--admin
orp-table--blue
```

---

# 14. Density

Preferir dos densidades claras:

```text
compact
comfortable/default
```

No crear cinco tamaños.

---

# 15. Striped rows

Debe usar semantic surface tokens.

No hardcodear gris.

---

# 16. Hover rows

Hover no debe ser la única indicación de interactividad.

En touch no existe hover.

---

# 17. Fixed layout

Permitir:

```css
table-layout: fixed;
```

como modifier cuando la aplicación necesite columnas controladas.

No imponerlo por defecto.

---

# 18. Column definitions

Si existe `OrpDataTable`, API conceptual:

```js
const columns = [
  {
    key: 'name',
    label: 'Name',
    sortable: true
  },
  {
    key: 'status',
    label: 'Status'
  }
]
```

---

# 19. Column API

Posibles propiedades:

```text
key
label
sortable
align
width
minWidth
priority
```

Mantener API pequeña.

---

# 20. Do not overconfigure columns

No crear una mega configuración tipo enterprise grid:

```text
formatter callbacks
validators
editors
aggregation
grouping
pivot
formula
```

fuera de scope.

---

# 21. Cell slots

Preferir slots para contenido complejo.

Referencia:

```vue
<template #cell-user="{ row, value }">
  ...
</template>
```

---

# 22. Generic slot fallback

Debe existir render simple para:

```text
string
number
```

---

# 23. Slot naming

Definir API consistente.

Ejemplo:

```text
#cell-{key}
#header-{key}
#row-actions
#expanded
#empty
#loading
```

No crear múltiples nombres equivalentes.

---

# 24. Raw HTML

No usar `v-html` para valores de celdas por defecto.

---

# 25. Sorting

Headers sortable deben ser interactivos semánticamente.

Preferir:

```html
<th>
  <button>...</button>
</th>
```

en lugar de `th @click`.

---

# 26. Sort states

Soportar:

```text
none
ascending
descending
```

---

# 27. aria-sort

Usar:

```text
aria-sort="ascending"
aria-sort="descending"
aria-sort="none"
```

en header correspondiente según semántica correcta.

---

# 28. Sort icon

Bootstrap Icons en Playground:

```text
bi-arrow-down-up
bi-sort-up
bi-sort-down
```

o iconos disponibles equivalentes.

Core sigue icon agnostic.

---

# 29. Sort cycle

Comportamiento recomendado:

```text
none
→ asc
→ desc
→ none
```

o:

```text
asc ↔ desc
```

Debe definirse claramente y mantenerse consistente.

No cambiar arbitrariamente por tabla.

---

# 30. Controlled sorting

Preferir estado controlado:

```text
sortKey
sortDirection
```

proporcionado por aplicación.

---

# 31. Local sorting

No incluir automáticamente.

Puede documentarse que aplicación puede ordenar localmente si dataset es pequeño.

---

# 32. Multi-column sorting

Fuera de scope inicial.

No construir enterprise grid.

---

# 33. Row selection

Soportar selección opcional.

Usar Checkbox ORP existente.

---

# 34. Selectable API

Conceptualmente:

```text
selectable
selectedKeys
rowKey
```

---

# 35. Row key

Debe existir identificador estable.

No usar index como identidad por defecto cuando rows cambian.

---

# 36. Selection events

Ejemplo:

```text
selection-change
row-select
select-all
```

Evitar eventos redundantes si uno basta.

---

# 37. Controlled selection

La aplicación debe poder controlar:

```text
selectedKeys
```

---

# 38. Select all

Checkbox del header:

```text
unchecked
checked
indeterminate
```

---

# 39. Select all semantics

Debe reflejar rows actualmente representados según contrato.

Documentar claramente si significa:

```text
visible rows
current page
```

ORP no debe asumir "todos los registros del servidor".

---

# 40. Server-side select all

Fuera de scope.

La aplicación decide si seleccionar 10 visibles significa 10 o 20,000 registros.

---

# 41. Disabled rows

Puede existir:

```text
selectable(row) = false
```

solo si API no se vuelve compleja.

Alternativa: aplicación proporciona estado de fila.

---

# 42. Selection Bar

Reutilizar Parte 20.

Cuando `selectedKeys.length > 0`, aplicación puede mostrar:

```text
orp-selection-bar
```

No duplicarla dentro de DataTable.

---

# 43. Bulk actions

Composición:

```text
Selection Bar
+
Button
+
Dropdown
```

La aplicación ejecuta acciones.

---

# 44. Row actions

Usar:

```text
Button
IconButton
Dropdown
```

No crear botones especiales de tabla.

---

# 45. Overflow row actions

Pattern recomendado:

```text
IconButton
+
Dropdown
```

con Bootstrap Icon demo:

```text
bi-three-dots
```

---

# 46. Row click

No hacer toda fila clickable automáticamente.

Puede generar conflictos con:

```text
checkbox
links
buttons
dropdowns
```

---

# 47. Clickable row pattern

Si se necesita navegación:

preferir link explícito en celda principal.

Si toda fila necesita interacción, documentar cuidadosamente semántica y nested controls.

---

# 48. Expanded rows

Soportar opcionalmente:

```text
expandable
expandedKeys
```

---

# 49. Expand button

Debe ser botón real.

Usar IconButton actual.

---

# 50. Expanded content

Renderizar fila adicional:

```html
<tr>
  <td colspan="...">
```

con slot.

---

# 51. Expanded semantics

El trigger debe usar:

```text
aria-expanded
aria-controls
```

cuando sea apropiado.

---

# 52. Expanded content use

Para:

```text
details
metadata
secondary content
```

No convertir DataTable en tree grid.

---

# 53. Nested tables

Permitidas por aplicación, pero no optimizar específicamente en esta fase.

---

# 54. Tree Grid

Fuera de scope.

---

# 55. Sticky header

Agregar soporte opt-in:

```text
orp-table--sticky-header
```

o wrapper modifier coherente.

---

# 56. Sticky requirements

Debe funcionar cuando tabla vive en un contenedor scrollable.

No convertir document scroll en contained scroll automáticamente.

---

# 57. Sticky background

Header sticky debe tener surface opaca adecuada.

No permitir que filas se vean detrás.

---

# 58. Sticky z-index

Usar semantic z-index layer existente.

No `999`.

---

# 59. Sticky first column

Puede agregarse opt-in.

Especialmente útil en tablas anchas.

---

# 60. Sticky column visual separation

Usar:

```text
border
subtle shadow
```

mediante tokens.

---

# 61. Multiple sticky columns

Fuera de scope inicial salvo que implementación resulte trivial y robusta.

---

# 62. Sticky intersection

Probar celda:

```text
header + first column
```

para z-index/background correcto.

---

# 63. Column alignment

Soportar:

```text
start
center
end
```

Preferir logical alignment.

---

# 64. Numeric columns

Normalmente:

```text
text-align: end
```

pero no imponer automáticamente según tipo.

---

# 65. Tabular numbers

Puede existir utility/pattern:

```text
font-variant-numeric: tabular-nums
```

para métricas.

Reutilizar si Parte 21 ya lo introdujo.

---

# 66. Cell composition

Demostrar celdas con:

```text
Avatar + text
Badge
Status Dot
Progress
Trend
Meta
Button
Dropdown
```

sin crear tipos de celda específicos.

---

# 67. User cell

NO crear:

```text
orp-table-user-cell
```

si:

```text
Avatar + Stack/Media
```

lo resuelve.

---

# 68. Status cell

Reutilizar Badge/Status Dot.

---

# 69. Progress cell

Reutilizar Progress.

---

# 70. Currency cell

ORP no formatea currency.

Aplicación proporciona string.

---

# 71. Date cell

ORP no formatea fechas.

---

# 72. Boolean cell

Aplicación decide:

```text
Yes/No
Badge
Icon
Switch
```

según semántica.

---

# 73. Editable cells

NO implementar spreadsheet editing en esta fase.

---

# 74. Inline actions

Forms dentro de celdas pueden funcionar, pero no crear editing engine.

---

# 75. Responsive philosophy

Una tabla sigue siendo una tabla.

NO transformar automáticamente:

```text
<tr>
```

en Cards.

---

# 76. Responsive strategies

Soportar/documentar cuatro estrategias:

```text
A. Horizontal Scroll
B. Sticky First Column
C. Priority Columns
D. Explicit alternative Data List
```

---

# 77. Strategy A — Horizontal Scroll

Default más seguro:

```text
orp-table-wrap
overflow-x: auto
```

---

# 78. Scroll affordance

Puede existir edge shadow/fade sutil para indicar overflow.

No agregar JS complejo.

---

# 79. Strategy B — Sticky First Column

Opt-in.

Útil para mantener contexto.

---

# 80. Strategy C — Priority Columns

Permitir clases/modifiers para ocultar columnas de baja prioridad en breakpoints.

Mantener API pequeña.

Ejemplo conceptual:

```text
orp-table__cell--priority-low
```

pero auditar si utilities responsive existentes lo resuelven mejor.

---

# 81. Column priority warning

Ocultar datos es decisión de producto.

ORP no debe decidir automáticamente qué columna desaparece.

---

# 82. Strategy D — Data List

Aplicación puede renderizar:

```text
Table desktop
Data List mobile
```

si el caso lo requiere.

ORP proporciona ambos primitives.

---

# 83. No DOM morphing

No convertir tabla a lista mediante JS.

---

# 84. Mobile table

Probar mínimo:

```text
320
375
390
430
```

---

# 85. Full responsive matrix

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

# 86. Table Toolbar

No crear toolbar paralela.

Componer:

```text
orp-toolbar
+
SearchInput
+
Select
+
Dropdown
+
Button
```

---

# 87. Toolbar content

Ejemplo:

```text
Search
Filters
Sort
View options
Primary action
```

La aplicación decide.

---

# 88. Filters

Reutilizar Filter Bar de Parte 18.

No implementar filtering dentro de Table.

---

# 89. Search

Reutilizar SearchInput.

No filtrar automáticamente rows.

---

# 90. Sort control mobile

Si sortable headers no son cómodos en una UI alternativa mobile, aplicación puede usar Select/Dropdown.

No duplicar lógica.

---

# 91. Column visibility

Puede existir pattern de Dropdown con checkboxes.

Pero DataTable no necesita implementar column manager completo en esta fase.

---

# 92. Column visibility state

Si se implementa, debe ser controlado por aplicación.

No persistir automáticamente en localStorage.

---

# 93. Pagination

Reutilizar Pagination de Parte 10.

---

# 94. Pagination Bar

Composición:

```text
Result Count
Pagination
Page Size
```

Puede existir CSS pattern solo si aporta layout repetible.

---

# 95. Result count

Usar Meta/Text.

Ejemplo:

```text
1–20 of 248
```

ORP no calcula total/range salvo helper trivial claramente justificado.

Preferir aplicación.

---

# 96. Page size

Usar Select.

Ejemplo:

```text
10
20
50
100
```

Aplicación controla valor.

---

# 97. Page events

Conceptualmente:

```text
page-change
page-size-change
```

si DataTable integra footer.

---

# 98. DataTable pagination coupling

Preferir no meter Pagination dentro de `OrpDataTable` obligatoriamente.

Puede componerse externamente.

Esto mantiene DataTable más ligero.

---

# 99. Loading state

Debe soportar:

```text
loading
```

sin destruir estructura de tabla.

---

# 100. Skeleton rows

Crear composición con Skeleton existente.

No crear animación nueva.

---

# 101. Skeleton columns

Las skeleton rows deben aproximar layout real.

No necesitan copiar exactamente contenido.

---

# 102. Loading accessibility

Usar:

```text
aria-busy
```

en región apropiada.

No anunciar cada skeleton.

---

# 103. Existing data while loading

No borrar automáticamente rows si aplicación quiere conservar datos durante refresh.

Puede mostrar estado de updating sin layout shift.

---

# 104. Empty state

Reutilizar `orp-empty`.

No crear `DataTableEmpty`.

---

# 105. Empty vs No Results

Documentar:

```text
Empty
→ dataset has no records

No Results
→ filters/search produced no matches
```

Visualmente pueden usar mismo Empty primitive.

---

# 106. Error state

Reutilizar:

```text
Alert
Callout
Empty
```

según contexto.

---

# 107. Retry

Button emite/aplicación ejecuta.

No fetch interno.

---

# 108. Table caption

Soportar y documentar:

```html
<caption>
```

cuando tabla necesite nombre/contexto accesible.

---

# 109. Headers

Usar correctamente:

```text
th
scope="col"
scope="row"
```

según estructura.

---

# 110. Complex headers

Multi-row/grouped headers quedan fuera de scope inicial.

No construir grid enterprise.

---

# 111. Accessibility

Tabla debe conservar semántica nativa siempre que sea posible.

No reemplazar `<table>` con div grid solo para facilitar CSS.

---

# 112. ARIA grid

NO usar:

```text
role="grid"
```

por defecto.

Una tabla HTML semántica es preferible.

---

# 113. Keyboard navigation

No implementar spreadsheet arrow-key navigation en tabla normal.

Tab debe navegar controles interactivos naturalmente.

---

# 114. Sorting keyboard

Sort buttons deben funcionar con:

```text
Tab
Enter
Space
```

por semántica nativa.

---

# 115. Selection keyboard

Checkboxes usan comportamiento nativo.

---

# 116. Expanded rows keyboard

Expand button nativo.

---

# 117. Focus-visible

Usar sistema ORP actual.

---

# 118. Row hover vs focus

Si fila contiene link/action principal, focus debe ser visible en el control real.

No confiar solo en hover de fila.

---

# 119. Screen reader sorting

El estado debe estar disponible mediante `aria-sort`.

---

# 120. Selection announcements

No crear live region excesiva.

Checkbox state suele ser suficiente.

Selection Bar puede mostrar conteo textual.

---

# 121. Touch

Row actions, checkboxes y pagination deben mantener targets adecuados.

---

# 122. Themes

Probar:

```text
Light
Dark
Custom
```

---

# 123. Dark table

Revisar especialmente:

```text
striped rows
hover
selected rows
sticky header
sticky column shadow
borders
disabled rows
```

---

# 124. Selected row

No depender únicamente de color.

Checkbox/selection state debe seguir siendo visible.

---

# 125. Semantic tokens

Usar tokens actuales.

No hardcodear colores de tabla.

---

# 126. Borders

Usar:

```text
--orp-border
```

o equivalente.

---

# 127. Surfaces

Usar:

```text
--orp-surface
--orp-surface-muted
```

o equivalentes.

---

# 128. Hover

Derivar del sistema de interacción actual.

No introducir color aislado solo para tables.

---

# 129. Density tokens

Reutilizar spacing scale.

No crear paddings mágicos.

---

# 130. RTL

Probar:

```html
dir="rtl"
```

Especialmente:

```text
alignment
sticky first logical column
row actions
sort icons
pagination composition
```

---

# 131. Sticky logical edge

Preferir:

```text
inset-inline-start
```

cuando sea viable.

---

# 132. Long content

Probar:

```text
long names
long emails
long URLs
long statuses
large numeric values
```

---

# 133. Wrapping

Definir comportamiento claro por default.

No aplicar `white-space: nowrap` a toda tabla indiscriminadamente.

---

# 134. Truncation

Usar solo en columnas que explícitamente lo requieran.

Debe existir acceso al contenido completo si es importante.

---

# 135. Tooltips

No crear tooltip automático para cada truncation.

Aplicación decide.

---

# 136. Empty cells

No insertar `"—"` automáticamente si eso cambia significado.

Aplicación puede proporcionar fallback.

---

# 137. Data formatting

Fuera de ORP:

```text
dates
currency
percentages
phone numbers
localization
```

---

# 138. OrpDataTable API — conceptual

```vue
<OrpDataTable
  :columns="columns"
  :rows="rows"
  row-key="id"
  :loading="loading"
  :sort-key="sortKey"
  :sort-direction="sortDirection"
  :selected-keys="selectedKeys"
  selectable
  expandable
  @sort-change="onSort"
  @selection-change="onSelection"
  @row-expand="onExpand"
>
</OrpDataTable>
```

Adaptar a convenciones reales del proyecto.

---

# 139. Do not blindly implement API

Primero revisar cómo ORP maneja:

```text
v-model
props naming
events naming
slots
boolean props
```

Mantener consistencia.

---

# 140. DataTable rows

No mutar array recibido.

---

# 141. DataTable sorting

No ordenar `rows` internamente salvo modo explícito futuro.

---

# 142. DataTable filtering

No filtrar rows.

---

# 143. DataTable pagination

No hacer slice automático.

---

# 144. DataTable selection

Puede coordinar selected keys porque es estado UI.

Preferir controlled API.

---

# 145. DataTable expansion

Puede coordinar expanded keys de forma controlada o v-model coherente.

---

# 146. Slots

Debe ser posible crear contenido rico sin que DataTable conozca dominios.

Ejemplo:

```vue
<template #cell-name="{ row }">
  <div class="orp-media">
    <OrpAvatar ... />
    ...
  </div>
</template>
```

---

# 147. Header slots

Permitir personalización solo si realmente útil.

No complicar API innecesariamente.

---

# 148. Row actions slot

Recomendado:

```text
#actions
```

o equivalente consistente.

---

# 149. Expanded slot

Recomendado:

```text
#expanded
```

---

# 150. Empty slot

Puede permitir custom Empty State.

---

# 151. Loading slot

Puede permitir custom loading, manteniendo default simple.

---

# 152. CSS architecture

Posibles archivos:

```text
less/components/table.less
less/components/data-table.less
```

Preferir ampliar `table.less` y separar solo si crece demasiado.

---

# 153. Vue architecture

Si se justifica:

```text
src/components/data/OrpDataTable.vue
```

o ubicación coherente con estructura existente.

---

# 154. Internal composables

Solo si hay duplicación real:

```text
useOrpSelection
useOrpSort
```

No abstraer prematuramente.

---

# 155. No dependencies

No instalar:

```text
DataTables
AG Grid
TanStack Table
Handsontable
Tabulator
PrimeVue DataTable
```

automáticamente.

---

# 156. Specialized grid rule

Si requerimientos futuros incluyen:

```text
virtualization
100k rows
column resize
column reorder
pivot
aggregation
grouping
tree grid
spreadsheet editing
copy/paste ranges
formula engine
```

recomendar librería especializada.

No recrearla en ORP core.

---

# 157. Performance

Para datasets grandes:

ORP espera que aplicación use:

```text
server pagination
virtualization library
specialized grid
```

según caso.

---

# 158. Reasonable client rows

No prometer rendimiento enterprise con miles de DOM rows.

---

# 159. Stable keys

Vue rows deben usar keys estables.

---

# 160. Playground

Agregar categoría:

```text
Advanced Tables
```

---

# 161. Playground sections

```text
Basic
Variants
Rich Cells
Sorting
Selection
Expanded Rows
Sticky Header
Sticky Column
Toolbar
Pagination
Loading
Empty
No Results
Error
Responsive
```

---

# 162. Basic demo

Tabla semántica simple sin Vue si es posible.

---

# 163. Variants demo

Mostrar:

```text
default
striped
bordered
compact
hover
```

sin saturar visualmente.

---

# 164. Rich Cells demo

Componer:

```text
Avatar
Badge
Status Dot
Progress
Trend
Meta
IconButton
Dropdown
```

---

# 165. Sorting demo

Estado local simple en Playground puede simular sort.

Debe demostrar eventos/API.

---

# 166. Selection demo

Mostrar:

```text
select row
select all
indeterminate
selection bar
```

---

# 167. Expanded demo

Mostrar contenido secundario genérico.

---

# 168. Sticky demo

Usar suficientes filas para scroll real.

---

# 169. Sticky column demo

Usar tabla suficientemente ancha.

---

# 170. Toolbar demo

Componer:

```text
SearchInput
Filter
Button
Overflow
```

---

# 171. Pagination demo

Componer:

```text
result count
page size
pagination
```

---

# 172. Loading demo

Skeleton rows.

---

# 173. Empty demo

Empty State.

---

# 174. No Results demo

Empty State con copy diferente.

---

# 175. Error demo

Callout/Alert + Retry Button.

---

# 176. Responsive demo

Obligatorio demostrar:

```text
horizontal scroll
sticky column
priority columns if implemented
```

---

# 177. Mobile alternative demo

Puede mostrar lado a lado/documentar:

```text
Table
vs
Data List
```

pero NO hacer transformación automática.

---

# 178. Playground data

Usar datos ficticios deterministas.

No API externa.

---

# 179. Bootstrap audit

Playground NO debe usar:

```text
table
table-striped
table-hover
container
row
col-*
d-flex
gap-*
p-*
m-*
btn
badge
dropdown-menu
```

de Bootstrap.

La etiqueta HTML `<table>` obviamente sí se usa.

Bootstrap Icons:

```text
bi
bi-*
```

permitidos.

---

# 180. Namespace

Mantener:

```text
orp-*
@orp-*
--orp-*
Orp*
data-orp-*
```

---

# 181. Regression

Ejecutar suite de Parte 17.

Revisar especialmente:

```text
Table Part11
Checkbox
Badge
Avatar
Progress
Trend
Dropdown
Toolbar
Selection Bar
Pagination
Skeleton
Empty
```

---

# 182. Visual regression

Fixtures recomendados:

```text
table-basic-light
table-basic-dark
table-rich-cells
table-compact
table-sort
table-selection
table-expanded
table-sticky-header
table-sticky-column
table-loading
table-empty
table-mobile-scroll
table-mobile-selection
```

---

# 183. Interaction tests

Si `OrpDataTable` existe, cubrir:

```text
sort event
selection
select all
indeterminate
disabled rows if supported
expand/collapse
slots
loading
empty
```

---

# 184. Accessibility tests

Cubrir:

```text
table semantics
caption
headers
scope
aria-sort
checkbox labels
expanded rows
focus
keyboard
```

---

# 185. Responsive tests

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

# 186. Theme tests

```text
Light
Dark
Custom
```

---

# 187. RTL tests

Especialmente sticky/alignment/actions.

---

# 188. Build

Confirmar:

```text
CSS
Vue
ESM exports
SSR
```

---

# 189. Bundle

Reportar:

```text
CSS before/after
JS before/after
```

---

# 190. Documentation

Crear/adaptar:

```text
docs/data/table.md
docs/data/data-table.md
docs/data/table-sorting.md
docs/data/table-selection.md
docs/data/table-responsive.md
docs/data/table-accessibility.md
```

---

# 191. Decision guide

Documentar:

```text
Table vs DataTable
Table vs Data List
Table vs specialized Grid
Horizontal Scroll vs Priority Columns
Row Action vs Row Navigation
Progress vs Status
```

---

# 192. Table vs DataTable

```text
Table
→ semantic data presentation

DataTable
→ coordinated interactive table UI
```

---

# 193. Table vs Data List

```text
Table
→ comparison across columns

Data List
→ item-oriented content
```

---

# 194. DataTable vs specialized Grid

```text
OrpDataTable
→ normal application tables

Specialized Grid
→ virtualization, pivot, spreadsheet editing, huge datasets
```

---

# 195. Responsive decision

```text
Need exact column comparison?
→ Table + horizontal scroll

Need first column context?
→ sticky first column

Some columns are optional?
→ explicit priority strategy

Content is item-oriented on mobile?
→ application renders Data List
```

---

# 196. Row interaction decision

```text
Navigation
→ explicit anchor preferred

Action
→ button

Multiple actions
→ Dropdown

Selection
→ Checkbox

Details
→ Expand button
```

---

# 197. Completion criteria

Parte 21.5 termina cuando ORP UI pueda construir una tabla SaaS/admin moderna con:

```text
semantic table
rich cells
sorting UI
selection
select all
bulk actions
expanded rows
sticky header
sticky first column
toolbar
pagination composition
loading
empty
no results
error
mobile strategies
```

sin convertirse en un enterprise data-grid engine.

---

# 198. Result expected

Al finalizar entregar:

## Existing Table Audit

Estado de Parte 11.

## Architecture

`orp-table` vs `OrpDataTable`.

## Variants

Lista final.

## Sorting

API/eventos.

## Selection

API/eventos.

## Expanded Rows

Resultado.

## Sticky

Header/column.

## Responsive

Estrategias implementadas.

## Toolbar

Composición.

## Pagination

Composición.

## States

Loading/Empty/No Results/Error.

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

## Themes

Light/Dark/Custom.

## RTL

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

# 199. Explicit exclusions

NO implementar:

```text
AG Grid clone
DataTables clone
TanStack Table clone
virtualization engine
infinite table
100k-row DOM rendering
column drag/reorder
column resizing engine
pivot tables
grouping engine
aggregation engine
formula engine
spreadsheet editing
range selection
copy/paste ranges
tree grid
nested hierarchy engine
CSV export engine
Excel export engine
PDF export engine
backend filtering
backend sorting
API requests
database queries
permission system
```

---

# 200. No new dependencies

No instalar nuevas dependencias automáticamente.

Esta fase debe construirse con:

```text
Vue 3
HTML semantic tables
LESS
existing ORP primitives
existing ORP composables where appropriate
```

---

# 201. Do not continue automatically

No implementar Parte 22.

Terminar con reporte técnico.

---

# Regla final

Mantener esta separación:

```text
Application
├── data
├── query
├── filters
├── sorting implementation
├── pagination implementation
├── permissions
└── actions

             ↓

OrpDataTable
├── columns
├── rows
├── sort interaction
├── selection
├── expansion
├── slots
└── events

             ↓

orp-table
├── semantic HTML
├── visual styling
├── responsive wrapper
├── sticky behavior
└── theme
```

ORP UI debe cubrir el punto medio entre una tabla HTML demasiado básica y un grid empresarial demasiado pesado.

La meta es:

```text
Powerful enough for most SaaS/admin applications.
Small enough to remain ORP UI.
```

