# ORP UI — GENERIC COMPOSITION PATTERNS
# FIFTH PATTERN: OrpStatCard
# + ARCHITECTURAL DISCOVERY PASS

Vamos a continuar desarrollando la capa de Patterns de ORP UI.

Estado conceptual actual:

1. OrpCatalogCard
2. OrpPricingCard
3. OrpProfileCard
4. Grid — Primitive / Primary
5. OrpContentCard
6. OrpStatCard ← IMPLEMENTAR AHORA

Siguientes candidatos, NO implementar todavía:

7. OrpContactCard
8. OrpActionCard

Esta fase mantiene la regla:

DISCOVER → EXTRACT → REUSE → COMPOSE

No queremos solamente crear otra Card.

OrpStatCard debe ayudarnos a descubrir qué primitives/components genéricos necesita ORP para dashboards, analytics, métricas y estados cuantitativos.

==================================================
1. OBJETIVO PRINCIPAL
==================================================

Crear:

OrpStatCard.vue

como Pattern genérico para presentar una métrica, KPI, valor cuantitativo o indicador resumido.

Debe poder utilizarse para:

- dashboards
- analytics
- KPIs
- ventas
- visitas
- usuarios
- conversiones
- ingresos
- rendimiento
- inventario resumido
- métricas operativas
- progreso resumido
- actividad
- estadísticas
- indicadores de negocio
- métricas técnicas

SIN conocer el dominio.

NO crear:

SalesCard
AnalyticsCard
VisitorsCard
RevenueCard
UsersCard
DashboardMetricCard
KpiSalesCard

==================================================
2. DEFINICIÓN
==================================================

OrpStatCard representa:

"Un valor o indicador principal acompañado opcionalmente de contexto, comparación, tendencia, estado, visualización y acciones."

Ejemplos conceptuales:

Ventas
$128,450
↑ 12.5%
vs. mes anterior

--------------------------------

Visitas
18,429
↑ 8.2%

--------------------------------

Usuarios activos
842
124 conectados

--------------------------------

Conversión
4.8%
↓ 0.6%
últimos 30 días

El Pattern NO interpreta qué significa cada valor.

==================================================
3. DIFERENCIA CON OTROS PATTERNS
==================================================

CatalogCard
→ entidad de catálogo.

PricingCard
→ propuesta de valor/precio para selección.

ProfileCard
→ identidad/persona/perfil.

ContentCard
→ contenido editorial/informativo.

StatCard
→ métrica o indicador resumido.

No usar StatCard como una Card genérica solo porque contiene un número.

==================================================
4. ARQUITECTURA
==================================================

ORP UI
│
├── Foundation
│
├── Primitives / Primary
│   ├── Stack
│   ├── Cluster
│   ├── Grid
│   ├── Card
│   ├── Badge
│   ├── Avatar
│   ├── Price
│   └── ...
│
├── Components
│   ├── Modal
│   ├── Drawer
│   ├── Accordion
│   └── ...
│
└── Patterns
    ├── OrpCatalogCard
    ├── OrpPricingCard
    ├── OrpProfileCard
    ├── OrpContentCard
    └── OrpStatCard       ← AHORA

StatCard debe COMPONER primitives/components existentes.

==================================================
5. AUDIT OBLIGATORIO
==================================================

ANTES de implementar:

auditar físicamente ORP.

Revisar:

- OrpCard
- OrpBadge
- OrpPrice
- OrpStack
- OrpCluster
- Grid primitive
- OrpButton
- OrpIconButton
- OrpDivider
- progress/meter si existen
- status primitives si existen
- icons
- typography/value styles
- CatalogCard
- PricingCard
- ProfileCard
- ContentCard

Revisar también:

- LESS
- tokens
- Playground
- tests
- naming conventions

NO asumir APIs.

==================================================
6. AUDIT READ-ONLY EN EL PROYECTO
==================================================

Buscar interfaces existentes con métricas.

Por ejemplo:

- analytics
- dashboard
- counters
- views
- leads
- appointments
- sales
- ratings
- users
- inventory
- statistics

Buscar estructuras repetidas como:

label + number

icon + number

number + percentage

value + delta

value + progress

value + contextual text

ESTE AUDIT ES READ-ONLY.

NO migrar Acerca.

==================================================
7. REPEATED UI INVENTORY
==================================================

Crear inventario interno:

CONCEPT:
SEEN IN:
CURRENT IMPLEMENTATION:
EXISTING ORP SOLUTION:
DOMAIN SPECIFIC:
EXTRACTION CANDIDATE:
DECISION:
REASON:

Prestar especial atención a:

- Trend / Delta
- Status
- Progress
- Meter
- Metric value
- Icon container
- MetaItem
- Comparison
- Sparkline container
- action groups

==================================================
8. ARCHITECTURAL DISCOVERY PASS
==================================================

Esta fase es especialmente importante para descubrir componentes faltantes.

Ejemplo:

↑ 12.5%
↓ 4.2%
→ 0.3%

Si esta estructura aparece en varios contextos, evaluar una primitive/component genérica.

Nombre posible:

OrpTrend
OrpDelta

PERO:

NO asumir que debe existir.

Primero demostrar reutilización.

==================================================
9. REGLA DE EXTRACCIÓN
==================================================

Antes de crear una nueva primitive/component:

1. ¿Tiene responsabilidad clara?
2. ¿Es independiente del dominio?
3. ¿Aparece en 2+ contextos reales?
4. ¿Reduce duplicación?
5. ¿Su API puede ser pequeña?
6. ¿Tiene semántica propia?
7. ¿ORP no lo resuelve ya?

Si no:

mantener composición con primitives existentes.

==================================================
10. ANATOMÍA
==================================================

Anatomía conceptual:

┌────────────────────────────┐
│ LABEL                ICON  │
│                            │
│ VALUE                      │
│ TREND / STATUS             │
│                            │
│ META / CONTEXT             │
│                            │
│ VISUAL                     │
│                            │
│ ACTIONS                    │
└────────────────────────────┘

Todas las regiones salvo el valor/contexto principal pueden ser opcionales según la API final.

==================================================
11. SLOT-FIRST API
==================================================

Preferir slots genéricos.

Dirección conceptual:

<OrpStatCard>

    <template #icon>
        ...
    </template>

    <template #label>
        ...
    </template>

    <template #value>
        ...
    </template>

    <template #trend>
        ...
    </template>

    <template #meta>
        ...
    </template>

    <template #visual>
        ...
    </template>

    <template #actions>
        ...
    </template>

</OrpStatCard>

Comparar naming con Patterns existentes antes de decidir.

==================================================
12. NO DOMAIN PROPS
==================================================

PROHIBIDO diseñar API alrededor de:

sales
revenue
visitors
users
orders
conversion
currency
previousMonth
todayVisitors
activeUsers
stock
appointments

StatCard no conoce esos conceptos.

==================================================
13. LABEL
==================================================

Label identifica la métrica.

Ejemplos:

Ventas
Visitas
Conversión
Usuarios activos
Tiempo promedio

No debe imponer heading incorrecto.

Seguir estrategia semántica de Patterns existentes.

==================================================
14. VALUE
==================================================

Value es la información visual dominante.

Puede contener:

842

18,429

4.8%

$128,450

98 ms

1.4 GB

El Pattern NO debe formatear el valor.

NO usar internamente:

Intl.NumberFormat
Intl.DateTimeFormat
currency formatting
unit conversion

El consumidor entrega el contenido.

==================================================
15. PRICE NO ES SIEMPRE VALUE
==================================================

Si el valor es monetario:

el consumidor puede utilizar OrpPrice si resulta semánticamente apropiado.

Pero StatCard NO debe depender obligatoriamente de OrpPrice.

Una métrica puede ser:

porcentaje
cantidad
tiempo
peso
score
ratio
texto corto

==================================================
16. TREND / DELTA
==================================================

Trend puede representar cambio relativo.

Ejemplos:

↑ 12.5%
↓ 4.2%
→ 0.3%

Pero NO asumir:

up = success
down = danger

En algunos dominios:

menos errores = positivo

más tiempo de respuesta = negativo

Por lo tanto:

StatCard NO debe inferir semántica desde el signo.

==================================================
17. POSIBLE PRIMITIVE TREND
==================================================

Evaluar si ORP necesita una primitive/component genérica para tendencia.

Si se crea, debe separar:

DIRECTION

de:

SEMANTIC INTENT

Ejemplo conceptual:

direction:
up
down
neutral

intent:
positive
negative
neutral

No vincular automáticamente:

up → green

down → red

La API exacta debe surgir del audit.

==================================================
18. COLOR NO ES SUFICIENTE
==================================================

Si Trend/Status usa color:

también debe existir señal no cromática:

- icon
- arrow
- text
- symbol
- accessible label

No comunicar aumento/disminución únicamente mediante color.

==================================================
19. META
==================================================

Meta aporta contexto.

Ejemplos:

vs. mes anterior
últimos 30 días
actualizado hace 5 min
de 1,000 usuarios
objetivo mensual

StatCard no interpreta ese contenido.

Reutilizar primitives de metadata si ya fueron creadas.

==================================================
20. ICON
==================================================

Icon es opcional.

Puede ser:

Bootstrap Icon
custom icon
avatar-like symbol
custom content

StatCard no hardcodea iconos.

No crear una lista de iconos por tipo de KPI.

==================================================
21. VISUAL
==================================================

Visual permite contenido complementario.

Ejemplos:

- sparkline
- progress bar
- mini chart
- meter
- visualization
- custom graphic

StatCard NO debe implementar un charting engine.

==================================================
22. CHARTS
==================================================

NO agregar:

Chart.js
ApexCharts
ECharts
D3
dependencias nuevas

El slot visual debe aceptar una visualización externa si el consumidor la necesita.

==================================================
23. SPARKLINE
==================================================

No crear OrpSparkline automáticamente.

Primero buscar evidencia.

Si varios contextos realmente necesitan una mini visualización consistente:

documentarla como candidato.

Solo implementarla si existe infraestructura suficiente y reutilización demostrada.

==================================================
24. PROGRESS
==================================================

Auditar si ORP ya tiene:

Progress
ProgressBar
Meter

Si existe:

REUSE.

Si no existe y aparece en múltiples contextos:

evaluar nueva primitive.

No implementar progress únicamente porque un demo de StatCard podría verse bonito.

==================================================
25. STATUS
==================================================

Puede existir contenido como:

Online
Healthy
Warning
Delayed
Completed

Pero StatCard no interpreta estados.

Reutilizar OrpBadge/Status si existe.

No crear status-specific props.

==================================================
26. ACTIONS
==================================================

Actions puede contener:

Ver detalles
Abrir reporte
Actualizar
Más opciones
IconButton

StatCard no define acciones específicas.

==================================================
27. INTERACTIVIDAD
==================================================

StatCard NO debe ser clickable por defecto.

Muchas métricas son puramente informativas.

Si existe variante interactiva:

seguir estrategia de Card/Patterns existentes.

Evitar nested interactive controls.

==================================================
28. VARIANTES
==================================================

Mantener variantes mínimas.

No crear:

sales
revenue
analytics
dangerKpi
successKpi
dashboard

Evaluar únicamente variantes estructurales reales.

Ejemplos posibles:

default
compact

pero solo si existe evidencia.

==================================================
29. EMPHASIS
==================================================

Evaluar si existe necesidad genérica de enfatizar una métrica.

No crear:

featuredRevenue
importantSales

Si ORP Card ya tiene variantes suficientes:

REUSE.

==================================================
30. GRID
==================================================

Las métricas suelen aparecer en grupos.

Usar la primitive Grid existente.

Ejemplo conceptual:

<div class="orp-grid orp-grid--auto-sm">

    <OrpStatCard />

    <OrpStatCard />

    <OrpStatCard />

    <OrpStatCard />

</div>

NO crear:

.stats-grid {
    display: grid;
}

si Grid ya lo resuelve.

==================================================
31. STACK
==================================================

Usar Stack para ritmo vertical interno cuando corresponda.

No recrear:

display:flex;
flex-direction:column;
gap:...

si Stack ya resuelve el problema.

==================================================
32. CLUSTER
==================================================

Usar Cluster para:

- label + icon
- trend + context
- actions
- compact metadata

cuando corresponda.

No crear flex wrappers genéricos innecesarios.

==================================================
33. CARD
==================================================

StatCard debe componer OrpCard.

NO recrear:

background
border
radius
shadow
surface states

si Card ya los proporciona.

==================================================
34. CSS
==================================================

CSS específico únicamente para composición de la métrica.

Conceptualmente:

.orp-stat-card
.orp-stat-card__header
.orp-stat-card__label
.orp-stat-card__icon
.orp-stat-card__value
.orp-stat-card__trend
.orp-stat-card__meta
.orp-stat-card__visual
.orp-stat-card__actions

Seguir convenciones reales del repo.

==================================================
35. TYPOGRAPHY
==================================================

El valor debe tener jerarquía visual fuerte.

Pero:

reutilizar typography tokens existentes.

No inventar:

font-size: 42px

si ORP ya tiene escala tipográfica.

Auditar especialmente números grandes y responsive.

==================================================
36. TABULAR NUMBERS
==================================================

Evaluar si métricas se benefician de:

font-variant-numeric: tabular-nums;

Si se utiliza:

debe justificarse como mejora genérica para métricas.

No aplicarlo globalmente sin audit.

==================================================
37. MOBILE FIRST
==================================================

Diseñar primero:

320
375
390
430

Después:

768
1200
1440

Revisar especialmente grids de 2-6 StatCards.

==================================================
38. LONG VALUES
==================================================

Probar:

$1,234,567,890

100.000%

1,024,384 usuarios

99 días 23 horas

Valores no deben:

- desbordarse
- colisionar con iconos
- romper actions
- generar horizontal scroll

==================================================
39. LONG LABELS
==================================================

Probar:

"Tiempo promedio de resolución"

"Usuarios activos durante los últimos 30 días"

La card debe degradar correctamente.

==================================================
40. ACCESSIBILITY
==================================================

Auditar:

- semantics
- heading strategy
- trend meaning
- color independence
- icon labels
- keyboard
- focus
- actions
- contrast
- reduced motion

Si una tendencia tiene significado:

debe ser comprensible para screen readers.

==================================================
41. PLAYGROUND
==================================================

Agregar:

Patterns → Stat Card

al Playground existente.

No crear otro playground.

==================================================
42. PLAYGROUND — BASIC METRIC
==================================================

Ejemplo:

Visitas
18,429

Sin adornos innecesarios.

Demostrar versión mínima.

==================================================
43. PLAYGROUND — TREND
==================================================

Ejemplo:

Ventas
$128,450
↑ 12.5%
vs. mes anterior

Si existe nueva primitive Trend:

usarla.

==================================================
44. PLAYGROUND — NEGATIVE / POSITIVE SEMANTICS
==================================================

Demostrar que dirección y semántica no son lo mismo.

Ejemplo:

Errores
32
↓ 18%
Positive

Tiempo de respuesta
480 ms
↑ 12%
Negative

Esto es importante para validar la arquitectura.

==================================================
45. PLAYGROUND — STATUS
==================================================

Ejemplo:

Servicios activos
24
Healthy

Usar primitive existente apropiada.

==================================================
46. PLAYGROUND — VISUAL
==================================================

Mostrar un ejemplo con contenido visual simple.

Puede ser:

progress existente
CSS demo simple
placeholder visual

NO agregar chart library.

==================================================
47. PLAYGROUND — ACTION
==================================================

Ejemplo con:

Ver reporte

o icon action.

Demostrar que actions son opcionales.

==================================================
48. PLAYGROUND — COLLECTION
==================================================

Crear grupo de StatCards usando ORP Grid.

Probar:

4 métricas

y:

6 métricas

No CSS Grid local.

==================================================
49. PLAYGROUND — EDGE CASES
==================================================

Mostrar/probar:

- solo label + value
- sin icon
- sin trend
- sin meta
- sin actions
- valor largo
- label largo
- trend neutral
- visual
- action

==================================================
50. NUEVOS COMPONENTES DESCUBIERTOS
==================================================

Si se crea:

Trend
Status
Progress
MetaItem
u otra primitive/component

debe tener:

- categoría correcta
- demo independiente
- API documentada
- tests
- accessibility
- uso genérico demostrado

No esconderla dentro de StatCard.

==================================================
51. PLAYGROUND DE COMPONENTES EMERGENTES
==================================================

Ejemplo:

si se crea OrpTrend:

Primitives / Components → Trend

Debe mostrar independientemente:

up
down
neutral
positive
negative
long value
icon semantics

según API real.

==================================================
52. NO DOMAIN CSS
==================================================

PROHIBIDO:

.orp-sales-card
.orp-revenue-card
.orp-visitors-card
.orp-analytics-card

También modifiers:

--sales
--revenue
--conversion

==================================================
53. NO FORMATTING LOGIC
==================================================

StatCard no debe convertir:

1000 → 1K

0.25 → 25%

128450 → $128,450

El consumidor es responsable del formato.

==================================================
54. NO DATA FETCHING
==================================================

StatCard no:

- hace API requests
- carga analytics
- calcula estadísticas
- consulta endpoints
- refresca datos

Es presentación/composición.

==================================================
55. TESTS
==================================================

Agregar tests según infraestructura actual.

StatCard:

- render
- slots
- optional regions
- variants si existen
- actions
- accessibility básica

Cualquier primitive nueva:

tests propios.

No introducir framework nuevo.

==================================================
56. BROWSER QA
==================================================

Preferir Puppeteer/Chrome headless si existe.

Probar:

320
375
390
430
768
1200
1440

Revisar:

- Grid
- long values
- long labels
- trend
- meta
- icon
- visual
- actions
- focus
- overflow

No declarar PASS sin inspección real.

==================================================
57. RESIZE QA
==================================================

Probar colección de StatCards durante resize continuo.

Especialmente Auto Grid.

Verificar que no existan:

- cards demasiado estrechas
- valores cortados
- saltos extraños
- overflow

==================================================
58. BUILD
==================================================

Ejecutar:

npm run build

y tests ORP existentes.

Debe pasar.

==================================================
59. DOCUMENTACIÓN
==================================================

Documentar:

PURPOSE

Represent a metric, KPI or summarized quantitative indicator.

USE FOR

- dashboards
- analytics
- KPIs
- operational metrics
- technical metrics
- summarized statistics

DO NOT USE FOR

catalog entities
→ OrpCatalogCard

pricing offers
→ OrpPricingCard

profiles
→ OrpProfileCard

editorial content
→ OrpContentCard

generic surfaces
→ OrpCard

==================================================
60. DOCUMENTAR TREND SEMANTICS
==================================================

Si existe Trend:

documentar claramente:

DIRECTION ≠ SEMANTIC INTENT

Ejemplo:

Errors ↓
can be positive.

Latency ↑
can be negative.

No acoplar visual semantics al signo matemático.

==================================================
61. NO DOGFOODING EN ACERCA TODAVÍA
==================================================

NO modificar:

Analytics module
Dashboard
SectionServices
SectionProducts
SectionPackages
SectionReviews
SectionLocations
Minisite

Solo ORP + Playground.

==================================================
62. NO BUSINESS LOGIC
==================================================

No modificar:

Controllers
Routes
Models
Database
API
Inertia payloads
analytics collection
business logic

==================================================
63. CRITERIO DE ÉXITO
==================================================

El mismo OrpStatCard debe poder representar:

Ventas
Visitas
Usuarios
Conversión
Errores
Latencia
Almacenamiento
Progreso

sin conocer ninguno de esos dominios.

==================================================
64. CRITERIO DE ÉXITO DE COMPOSICIÓN
==================================================

La implementación debe reutilizar:

Card
Grid
Stack
Cluster
Badge/Status si aplica

en vez de reimplementar layout genérico.

==================================================
65. CRITERIO DE ÉXITO DEL DISCOVERY PASS
==================================================

Debemos poder responder:

¿Necesitamos realmente una primitive Trend/Delta?

¿Ya existe una solución para Status?

¿Existe Progress?

¿Se repite MetaItem?

¿Qué abstracciones rechazamos?

No es obligatorio crear nuevas primitives.

Es obligatorio AUDITAR.

==================================================
66. REPORTE FINAL
==================================================

Entregar:

# ORP STAT CARD — IMPLEMENTATION REPORT

## Existing ORP Audit

Reviewed:

- Card
- Badge
- Price
- Stack
- Cluster
- Grid
- Button
- IconButton
- Progress/Meter if existing
- Status if existing
- CatalogCard
- PricingCard
- ProfileCard
- ContentCard

## Repeated UI Inventory

Concept:
Seen in:
Existing ORP solution:
Extraction candidate:
Decision:
Reason:

## Trend / Delta Decision

Needed:
YES / NO

Existing solution:

New primitive created:
YES / NO

Reason:

Direction separated from semantic intent:
YES / NO / NOT APPLICABLE

## New ORP Components Created

If none:

NONE

For each:

Name:
Layer:
Problem:
Generic use cases:
API:
Playground:
Tests:

## Abstractions Rejected

Concept:
Reason:

## OrpStatCard Architecture

Layer:
Pattern

Purpose:

Internal composition:

## API

Props:
Slots:
Events:
Variants:
Interactive strategy:

## Generic Validation

Basic metric:
PASS / FAIL

Currency-like value:
PASS / FAIL

Percentage:
PASS / FAIL

Positive trend:
PASS / FAIL

Negative trend:
PASS / FAIL

Direction vs semantic intent:
PASS / FAIL

Status:
PASS / FAIL

Visual:
PASS / FAIL

Long value:
PASS / FAIL

Long label:
PASS / FAIL

## ORP Primitive Reuse

Card:
YES / NO

Grid:
YES / NO

Stack:
YES / NO

Cluster:
YES / NO

Badge/Status:
YES / NO / N/A

Progress:
YES / NO / N/A

## Generic CSS Duplication

Custom generic grid introduced:
YES / NO

Custom generic stack introduced:
YES / NO

Custom generic cluster introduced:
YES / NO

If YES:
justify.

## Accessibility

Semantics:
Trend:
Color independence:
Keyboard:
Focus:
Icon actions:
Contrast:
Reduced motion:

PASS / FAIL / NOT VERIFIED

## Responsive QA

320:
375:
390:
430:
768:
1200:
1440:

## Resize QA

Tested:
YES / NO

Result:

## Playground

StatCard:
YES / NO

Grid collection:
YES / NO

Trend example:
YES / NO

Status example:
YES / NO

Visual example:
YES / NO

New primitives independently documented:
YES / NO / NONE

## Tests

StatCard:
PASS / FAIL

New components:
PASS / FAIL / NONE

## Build

npm run build:

PASS / FAIL

## Acerca Changes

NONE

## Business Logic Changes

NONE

## ORP Architecture Result

Did StatCard reuse Grid?
YES / NO

Did it reduce layout duplication?
YES / NO

Were new primitives created only with evidence?
YES / NO

## Future Dogfooding Candidates

List only.

Do NOT modify.

## Final Status

READY FOR HUMAN REVIEW

or

NEEDS MORE WORK

STOP.

==================================================
FINAL INSTRUCTION
==================================================

Implementa:

1. OrpStatCard.
2. Su integración en ORP Playground.
3. Colecciones usando la primitive Grid existente.
4. Tests.
5. Documentación.
6. Audit explícito de Trend/Delta, Status, Progress, metadata y otras piezas repetidas.
7. Si y SOLO SI existe evidencia suficiente, crear primitives/components ORP genéricos faltantes.
8. Cualquier nueva primitive/component debe tener demo independiente, API, tests y documentación.
9. Reutilizar Grid, Stack, Cluster y Card antes de escribir layout CSS genérico.
10. No agregar librerías de charts.
11. No implementar formatting ni business logic.
12. No migrar Acerca todavía.
13. STOP después de StatCard y las abstracciones estrictamente justificadas descubiertas durante esta fase.

