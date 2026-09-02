# ORP UI — PRIMITIVES / PRIMARY
# GRID SYSTEM

Vamos a detener temporalmente la creación de nuevos Patterns para completar una pieza fundamental que falta en ORP UI:

GRID

IMPORTANTE:

Grid NO es un Pattern.

Grid NO es un componente de dominio.

Grid NO debe llamarse `OrpGridCard`, `ProductGrid`, `ServiceGrid` ni nada equivalente.

Grid pertenece a la capa:

PRIMITIVES / PRIMARY

del ORP Playground y del sistema ORP UI.

La intención es que Grid sea una primitive de layout al mismo nivel conceptual que:

- Stack
- Cluster
- Section

y que posteriormente pueda ser utilizada por:

- CatalogCard collections
- PricingCard collections
- ProfileCard collections
- ContentCard collections
- StatCard collections
- dashboards
- galleries
- forms
- cualquier layout bidimensional repetitivo

==================================================
1. OBJETIVO
==================================================

Crear una primitive de layout:

Grid

para ORP UI.

Su responsabilidad es resolver layouts bidimensionales repetitivos de forma:

- simple
- reusable
- mobile-first
- responsive
- basada en CSS Grid moderno
- consistente con los tokens ORP
- independiente del dominio
- independiente de Bootstrap
- independiente de Tailwind

Grid debe reducir la necesidad de que cada componente de Acerca o cada Pattern implemente manualmente:

display: grid;
grid-template-columns: ...;
gap: ...;
media queries...

==================================================
2. UBICACIÓN ARQUITECTÓNICA
==================================================

La arquitectura conceptual debe quedar:

ORP UI
│
├── Foundation
│
├── Primitives / Primary
│   ├── Section
│   ├── Stack
│   ├── Cluster
│   ├── Grid          ← IMPLEMENTAR AHORA
│   ├── Card
│   ├── Media
│   ├── Avatar
│   ├── Badge
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
    ├── CatalogCard
    ├── PricingCard
    ├── ProfileCard
    └── ...

Grid debe aparecer en el ORP Playground dentro de la categoría real utilizada para:

Primitives
Primary
Layout Primitives

o la categoría equivalente existente.

NO colocar Grid bajo Patterns.

==================================================
3. NO ASUMIR QUE NECESITAMOS OrpGrid.vue
==================================================

CRÍTICO:

No crear automáticamente:

OrpGrid.vue

Grid puede y probablemente debe comenzar como una primitive CSS.

Ejemplo conceptual:

<div class="orp-grid">
    ...
</div>

Antes de crear un wrapper Vue, responder:

¿Vue aporta comportamiento real?

¿Necesitamos props dinámicas?

¿Necesitamos semántica especial?

¿Necesitamos events?

¿Necesitamos estado?

Si la respuesta es NO:

preferir CSS primitive.

No crear componentes Vue que solamente sustituyan:

<div class="orp-grid">

sin aportar valor.

==================================================
4. AUDIT OBLIGATORIO
==================================================

ANTES de implementar Grid:

auditar físicamente ORP UI.

Revisar:

- Stack
- Cluster
- Section
- Container si existe
- layout utilities existentes
- spacing tokens
- breakpoints
- responsive conventions
- CSS variables
- LESS architecture
- Playground
- CatalogCard
- PricingCard

También buscar en todo ORP:

display: grid

grid-template-columns

grid-auto-flow

repeat(

minmax(

gap:

column-gap:

row-gap:

Buscar implementaciones repetidas.

El objetivo es descubrir qué necesidades reales de Grid ya existen.

==================================================
5. AUDIT EN ACERCA — SOLO LECTURA
==================================================

También se permite revisar componentes del Minisite/Acerca únicamente para descubrir necesidades reales.

Buscar:

display: grid

y patrones repetidos en:

Services
Products
Packages
Reviews
Locations
Gallery
Properties
RestaurantMenu
Features
Appointments
etc.

IMPORTANTE:

ESTE AUDIT ES READ-ONLY.

NO modificar componentes de Acerca durante esta fase.

Usar esa evidencia únicamente para diseñar correctamente la primitive Grid.

==================================================
6. PRINCIPIO DE DISEÑO
==================================================

NO queremos recrear Bootstrap Grid.

NO queremos recrear Vuestic Flex Grid.

NO queremos:

row
col-12
col-sm-6
col-md-4
col-lg-3

ni:

xs12
sm6
md4
lg3

ni:

offset-md-2
push
pull

ni cientos de utilities responsive.

Queremos aprovechar CSS Grid moderno.

==================================================
7. RESPONSABILIDADES DE LAYOUT
==================================================

Definir claramente:

STACK

Layout principalmente vertical.

Ejemplo:

A
B
C

--------------------------------

CLUSTER

Layout horizontal/flexible para elementos pequeños que pueden envolver.

Ejemplo:

[A] [B] [C] [D]

--------------------------------

GRID

Layout bidimensional de elementos repetitivos.

Ejemplo:

[A] [B] [C]

[D] [E] [F]

Esta distinción debe quedar documentada en Playground.

==================================================
8. GRID BASE
==================================================

Debe existir una clase base:

.orp-grid

Conceptualmente:

display: grid;

y un gap predeterminado basado en tokens ORP.

No hardcodear spacing arbitrario.

Verificar la escala real de spacing.

==================================================
9. COLUMNAS FIJAS
==================================================

Evaluar soporte para una cantidad pequeña de columnas.

Por ejemplo:

.orp-grid--2
.orp-grid--3
.orp-grid--4

Posiblemente:

.orp-grid--1
.orp-grid--5
.orp-grid--6

SOLO si existe evidencia real.

No crear:

orp-grid--1
...
orp-grid--12

automáticamente.

No necesitamos un sistema de 12 columnas salvo evidencia concreta.

==================================================
10. AUTO GRID
==================================================

Esta debe ser una de las capacidades principales.

Queremos que Grid pueda adaptarse automáticamente al espacio disponible.

Conceptualmente:

grid-template-columns:
    repeat(
        auto-fit,
        minmax(
            min(100%, var(--orp-grid-min)),
            1fr
        )
    );

La implementación exacta debe validarse contra soporte del proyecto y convenciones ORP.

La intención es permitir:

container ancho
→ más columnas

container mediano
→ menos columnas

container pequeño
→ una columna

SIN necesitar múltiples media queries.

==================================================
11. CONTAINER-DRIVEN RESPONSIVENESS
==================================================

Preferir que Grid responda al espacio disponible en su container cuando sea posible.

Esto permite reutilizarlo dentro de:

- page
- section
- modal
- drawer
- sidebar
- dashboard
- nested layout

No depender innecesariamente de viewport breakpoints.

==================================================
12. AUTO GRID PRESETS
==================================================

Evaluar presets genéricos de tamaño mínimo.

Ejemplo conceptual:

.orp-grid--auto-sm
.orp-grid--auto-md
.orp-grid--auto-lg

Estos nombres representan tamaño mínimo aproximado del item.

NO representan dispositivos.

NO significan:

mobile
tablet
desktop

Deben basarse en tokens/variables coherentes.

Ejemplo conceptual:

--orp-grid-min-sm
--orp-grid-min-md
--orp-grid-min-lg

Pero:

NO inventar tokens sin revisar Foundation.

Si hace falta un token nuevo:

documentar por qué pertenece a ORP Foundation.

==================================================
13. CUSTOM PROPERTY
==================================================

Evaluar permitir personalización avanzada mediante CSS custom property:

style="--orp-grid-min: ..."

o mediante una clase/contexto consumidor.

Pero evitar convertir la API principal en valores arbitrarios.

Los presets deben cubrir los casos comunes.

La custom property puede ser escape hatch.

==================================================
14. GAP
==================================================

Grid debe integrarse con la escala de spacing ORP.

Revisar cómo Stack y Cluster representan gaps.

Idealmente Grid debe seguir la misma convención.

Ejemplo conceptual:

.orp-grid--gap-1
.orp-grid--gap-2
.orp-grid--gap-3
...

PERO:

NO inventar naming distinto si Stack/Cluster ya tienen una convención.

La consistencia es más importante que este ejemplo.

==================================================
15. ROW GAP / COLUMN GAP
==================================================

Evaluar si realmente necesitamos controles separados para:

row-gap
column-gap

No agregarlos por anticipación.

Si los casos reales encontrados durante audit lo justifican:

implementar una solución consistente.

Si no:

un solo gap es suficiente inicialmente.

==================================================
16. ALIGN / JUSTIFY
==================================================

No copiar toda la API de flexbox de Vuestic.

Grid NO necesita automáticamente:

align-start
align-end
align-baseline
justify-space-around
justify-space-evenly
etc.

Primero revisar qué responsabilidades ya cubren utilities/primitives ORP.

Solo añadir alignment específico si existe una necesidad real de Grid.

==================================================
17. NO GridItem INICIALMENTE
==================================================

NO crear:

OrpGridItem
.orp-grid-item

en esta primera fase salvo evidencia fuerte.

Los hijos deben poder participar directamente:

<div class="orp-grid orp-grid--auto-md">

    <article>...</article>

    <article>...</article>

    <article>...</article>

</div>

Esto mantiene la primitive simple.

==================================================
18. SPANS
==================================================

NO implementar inicialmente:

span-2
span-3
start-2
end-4

salvo que el audit encuentre necesidades repetidas reales.

Si aparecen:

documentarlas como posible:

GRID PHASE 2

No construirlas preventivamente.

==================================================
19. FULL WIDTH ITEMS
==================================================

Buscar si existen casos repetidos donde un hijo deba ocupar:

grid-column: 1 / -1

Si existe evidencia clara, evaluar una pequeña utility genérica.

Ejemplo conceptual:

.orp-grid__full

o equivalente.

Pero no implementarla sin evidencia.

==================================================
20. MOBILE FIRST
==================================================

Grid debe funcionar correctamente primero en:

320
375
390
430

Después:

768
1200
1440

No diseñar desktop y luego agregar media queries para arreglar móvil.

==================================================
21. OVERFLOW SAFETY
==================================================

Probar contenido con:

- textos largos
- imágenes
- botones
- cards
- precios grandes
- metadata
- inputs

Grid no debe provocar horizontal overflow accidental.

Revisar especialmente:

min-width
minmax()
1fr
min(100%, ...)

==================================================
22. TOKENS
==================================================

PROHIBIDO hardcodear arbitrariamente:

gap
breakpoints
minimum widths
spacing

si ORP ya tiene tokens equivalentes.

Si necesitamos tokens específicos de Grid:

crear únicamente los estrictamente necesarios.

Documentar:

NAME
PURPOSE
WHY EXISTING TOKEN DOES NOT WORK

==================================================
23. BREAKPOINTS
==================================================

Antes de crear cualquier breakpoint:

revisar si ORP ya define breakpoints oficiales.

NO crear una segunda escala.

No copiar directamente:

640
1024
1440
1920

de Vuestic.

Si Auto Grid resuelve el problema:

preferir Auto Grid.

==================================================
24. CSS API PEQUEÑA
==================================================

Queremos una API fácil de memorizar.

Una dirección posible:

orp-grid

orp-grid--2
orp-grid--3
orp-grid--4

orp-grid--auto-sm
orp-grid--auto-md
orp-grid--auto-lg

más la convención existente de gap.

Pero la API final debe surgir del audit.

No implementar clases solamente porque aparecen en este prompt.

==================================================
25. EJEMPLO DE USO CON PATTERNS
==================================================

Queremos poder terminar usando algo conceptualmente similar a:

<div class="orp-grid orp-grid--auto-md">

    <OrpCatalogCard />

    <OrpCatalogCard />

    <OrpCatalogCard />

</div>

Grid:

resuelve layout.

CatalogCard:

resuelve composición visual del item.

Aplicación:

resuelve datos y dominio.

==================================================
26. NO ACOPLAR GRID A CARDS
==================================================

Grid debe funcionar igualmente con:

Cards
Forms
Stats
Images
Panels
Custom HTML

NO crear CSS como:

.orp-grid > .orp-card

salvo una razón extremadamente clara.

Grid no debe conocer a sus hijos.

==================================================
27. EQUAL HEIGHT
==================================================

CSS Grid naturalmente puede ayudar a mantener items alineados.

Pero Grid NO debe imponer hacks de:

height
min-height

a sus hijos.

Los componentes internos deben resolver su propio stretch cuando corresponda.

==================================================
28. PLAYGROUND
==================================================

Agregar Grid dentro de:

Primitives / Primary

o categoría equivalente real del ORP Playground.

NO colocarla bajo Patterns.

Debe tener una sección propia y clara.

==================================================
29. PLAYGROUND — BASIC
==================================================

Mostrar:

Basic Grid

con items visuales simples.

No utilizar Cards complejas en el primer ejemplo.

Queremos ver claramente el comportamiento del layout.

==================================================
30. PLAYGROUND — FIXED COLUMNS
==================================================

Mostrar las variantes realmente implementadas.

Por ejemplo:

2 columns

3 columns

4 columns

No mostrar clases inexistentes.

==================================================
31. PLAYGROUND — AUTO GRID
==================================================

Este ejemplo es prioritario.

Mostrar cómo los items cambian automáticamente:

4
↓
3
↓
2
↓
1

según el espacio disponible.

Idealmente usar un contenedor redimensionable si el Playground ya tiene infraestructura para ello.

Si no:

mostrar ejemplos a diferentes anchuras.

==================================================
32. PLAYGROUND — GAP
==================================================

Mostrar:

small gap
default gap
large gap

siguiendo exactamente la escala ORP existente.

==================================================
33. PLAYGROUND — REAL WORLD
==================================================

Agregar un ejemplo utilizando un Pattern existente.

Preferentemente:

CatalogCard

Ejemplo:

<div class="orp-grid orp-grid--auto-md">
    <OrpCatalogCard />
    <OrpCatalogCard />
    <OrpCatalogCard />
</div>

También puede mostrarse PricingCard si aporta valor.

NO modificar internamente esos Patterns para hacer el demo.

==================================================
34. PLAYGROUND — NESTED CONTAINER
==================================================

Mostrar Grid dentro de un container más estrecho.

Queremos comprobar que Auto Grid responde al espacio disponible y no únicamente al viewport.

==================================================
35. PLAYGROUND — LONG CONTENT
==================================================

Probar items con diferentes cantidades de contenido.

Verificar:

- no overflow
- columnas estables
- wrapping correcto

==================================================
36. ACCESSIBILITY
==================================================

Grid es principalmente layout.

NO debe alterar innecesariamente la semántica del contenido.

Evitar:

role="grid"

por defecto.

CSS Grid visual NO equivale a ARIA grid.

No introducir roles ARIA sin necesidad.

Los elementos hijos mantienen su propia semántica.

==================================================
37. DOM
==================================================

Mantener markup mínimo.

Ideal:

<div class="orp-grid">
    <article>...</article>
    <article>...</article>
</div>

No agregar wrappers internos innecesarios.

==================================================
38. DISCOVERY DE NUEVAS PRIMITIVES
==================================================

Aplicar la regla:

DISCOVER → EXTRACT → REUSE

Mientras se audita Grid, pueden aparecer otras necesidades de layout repetidas.

Ejemplos conceptuales:

Container
Switcher
Sidebar
Reel
AutoLayout

NO crear ninguna automáticamente.

Para cada candidato documentar:

CONCEPT
WHERE FOUND
CURRENT DUPLICATION
EXISTING ORP SOLUTION
REUSE POTENTIAL
DECISION

Solo implementar una primitive adicional si existe evidencia fuerte y es necesaria para evitar duplicación inmediata.

==================================================
39. NO SOBRECONSTRUIR ORP
==================================================

No queremos crear ahora:

Grid
GridItem
GridRow
GridColumn
GridArea
GridContainer
GridResponsive
GridAuto
GridMasonry

Queremos:

GRID

pequeña y sólida.

Agregar capacidades después cuando aparezcan casos reales.

==================================================
40. MASONRY
==================================================

NO implementar Masonry en esta fase.

Es otro patrón/problema.

Si Gallery necesita Masonry:

documentarlo separadamente.

==================================================
41. CAROUSEL
==================================================

Grid NO debe resolver carousel.

Scroll horizontal / carousel pertenece a otra primitive/pattern.

No mezclar:

grid
slider
reel
swiper

==================================================
42. TESTS
==================================================

Seguir infraestructura actual de tests ORP.

Si Grid es CSS-only:

no crear tests Vue artificiales.

Probar según las herramientas reales disponibles.

Validar al menos:

- clase base
- modifiers
- compiled CSS
- Playground rendering
- visual behavior

Si existen tests CSS/snapshot adecuados:

utilizarlos.

No introducir framework nuevo.

==================================================
43. BROWSER QA
==================================================

Usar infraestructura existente.

Preferir Puppeteer + Chrome headless si está disponible.

Probar:

320
375
390
430
768
1200
1440

Revisar:

- fixed columns
- auto grid
- gaps
- nested container
- long content
- CatalogCard example
- PricingCard example si existe
- overflow

No declarar PASS sin inspección real.

==================================================
44. RESIZE QA
==================================================

Para Auto Grid:

probar cambios continuos de ancho.

No comprobar solamente screenshots estáticos.

Queremos detectar:

- saltos extraños
- overflow
- columnas demasiado estrechas
- layout intermedio roto

==================================================
45. BUILD
==================================================

Ejecutar:

npm run build

Debe pasar.

Ejecutar también tests ORP existentes cuando corresponda.

==================================================
46. DOCUMENTACIÓN
==================================================

Documentar:

# Grid

PURPOSE

Create responsive two-dimensional layouts for repeated content.

USE GRID WHEN

- items repeat in rows/columns
- cards need responsive columns
- stats need columns
- forms need multi-column regions
- repeated content needs automatic layout

USE STACK WHEN

content primarily flows vertically.

USE CLUSTER WHEN

small items primarily flow horizontally and wrap.

DO NOT USE GRID FOR

carousel
masonry
navigation cluster
simple vertical spacing

==================================================
47. DOCUMENTAR AUTO GRID
==================================================

Explicar especialmente la diferencia entre:

FIXED GRID

y

AUTO GRID

Fixed:

"quiero exactamente N columnas"

Auto:

"quiero tantas columnas como quepan respetando un tamaño mínimo razonable"

Auto debería ser la opción recomendada para muchos layouts responsive.

==================================================
48. DOGFOODING FUTURO
==================================================

Después de aprobar Grid podremos revisar:

SectionServices
SectionProducts
SectionPackages
SectionReviews
SectionLocations
SectionFeatures
SectionProperties
RestaurantMenu

para reemplazar CSS Grid local repetido.

NO hacerlo en esta fase.

==================================================
49. NO TOCAR
==================================================

No modificar:

Controllers
Routes
Models
Database
API
Inertia payloads
business logic

No migrar componentes del Minisite.

No modificar CatalogCard/PricingCard salvo que exista un error real que impida demostrar Grid; si ocurre, documentarlo y mantener el cambio mínimo.

==================================================
50. CRITERIO DE ÉXITO
==================================================

Al terminar debemos poder escribir:

<div class="orp-grid orp-grid--auto-md">
    ...
</div>

y obtener un layout responsive usable sin escribir:

display: grid

grid-template-columns

media queries

gap

en cada componente consumidor.

==================================================
51. SEGUNDO CRITERIO DE ÉXITO
==================================================

La API debe ser suficientemente pequeña como para poder recordarla sin documentación constante.

Si terminamos con decenas o cientos de clases:

la implementación está sobre-diseñada.

==================================================
52. TERCER CRITERIO DE ÉXITO
==================================================

Grid debe sentirse como hermana de:

Stack
Cluster

No como un framework responsive separado dentro de ORP.

==================================================
53. REPORTE FINAL
==================================================

Entregar:

# ORP GRID PRIMITIVE — IMPLEMENTATION REPORT

## Architecture

Layer:

PRIMITIVE / PRIMARY

Vue component created:
YES / NO

If YES:
justify why Vue was necessary.

## Existing Layout Audit

Stack:
Cluster:
Section:
Container:
Existing grid utilities:

## Grid Usage Audit

Repeated grid implementations found:

Acerca components reviewed:

Common patterns:

## API

Base class:

Fixed column modifiers:

Auto modifiers:

Gap modifiers:

CSS custom properties:

Breakpoints used:

## Tokens

Existing tokens reused:

New tokens:

Justification:

## Auto Grid

Implementation:

Container responsive:
YES / NO

Viewport dependent:
YES / NO

Explain.

## GridItem

Created:
YES / NO

Expected answer unless strongly justified:

NO

## Playground

Location:

Basic:
PASS / FAIL

Fixed columns:
PASS / FAIL

Auto Grid:
PASS / FAIL

Gap:
PASS / FAIL

Nested container:
PASS / FAIL

Real-world Pattern example:
PASS / FAIL

Long content:
PASS / FAIL

## Accessibility

ARIA roles added:
YES / NO

Expected normally:
NO

Semantic children preserved:
PASS / FAIL

## Responsive QA

320:
375:
390:
430:
768:
1200:
1440:

## Resize QA

Continuous resizing tested:
YES / NO

Result:

## New Primitive Candidates Discovered

For each:

Concept:
Evidence:
Decision:
Reason:

## Tests

Result:

## Build

npm run build:

PASS / FAIL

## Acerca Modifications

NONE

## Business Logic Changes

NONE

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

Implementa únicamente la primitive:

Grid

dentro de ORP UI y su ORP Playground.

Debe pertenecer a:

Primitives / Primary

NO a Patterns.

No crear `OrpGrid.vue` salvo que el audit demuestre que Vue aporta una necesidad real.

Preferir una primitive CSS pequeña basada en CSS Grid moderno.

No recrear Bootstrap Grid.

No copiar el sistema de 12 columnas de Vuestic.

No crear GridItem salvo evidencia fuerte.

Priorizar Auto Grid basado en tamaño mínimo del item y espacio disponible.

Integrar Grid con los tokens y convenciones reales de Stack/Cluster.

Agregar demos claros al Playground.

Ejecutar QA responsive, resize QA, tests aplicables y build.

No hacer dogfooding en Acerca todavía.

STOP after Grid.
