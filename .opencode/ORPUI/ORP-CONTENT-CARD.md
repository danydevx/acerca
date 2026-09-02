# ORP UI — GENERIC COMPOSITION PATTERNS
# FOURTH PATTERN: OrpContentCard
# + COMPONENT DISCOVERY / EXTRACTION RULE

Vamos a continuar desarrollando la capa de Patterns de ORP UI.

Actualmente tenemos o estamos construyendo:

1. OrpCatalogCard
2. OrpPricingCard
3. OrpProfileCard
4. OrpContentCard ← IMPLEMENTAR AHORA

Además ya existe la regla arquitectónica:

DISCOVER → EXTRACT → REUSE → COMPOSE

Cada nuevo Pattern debe servir también como un Architectural Discovery Pass para detectar primitives/components genéricos que ORP todavía no tenga.

IMPORTANTE:

No queremos solamente crear otra Card.

Queremos que esta fase ayude a madurar ORP como sistema.

==================================================
1. OBJETIVO PRINCIPAL
==================================================

Crear:

OrpContentCard.vue

como Pattern genérico para representar una pieza de contenido editorial, informativo o publicable.

Debe poder utilizarse para:

- artículos
- noticias
- posts
- blog
- tutoriales
- recursos
- casos de estudio
- proyectos editoriales
- guías
- documentación destacada
- publicaciones
- contenido relacionado
- eventos cuando se presenten como contenido editorial

SIN conocer el dominio.

NO crear:

BlogCard
ArticleCard
NewsCard
PostCard
TutorialCard
CaseStudyCard
ProjectCard

==================================================
2. DEFINICIÓN DEL PATTERN
==================================================

OrpContentCard representa:

"Una pieza de contenido que el usuario puede identificar, explorar y potencialmente abrir o consumir."

Su objetivo principal NO es vender.

Su objetivo principal NO es representar una persona.

Su objetivo principal NO es comparar precios.

Su objetivo es comunicar:

- qué contenido es
- de qué trata
- qué contexto tiene
- quién/cuándo lo publicó, si aplica
- cómo acceder a él

==================================================
3. DIFERENCIA CON OTROS PATTERNS
==================================================

OrpCatalogCard

→ representa una entidad dentro de un catálogo.

Ejemplo:

"Corte premium — $450"

"Loft Centro — $18,000"

--------------------------------

OrpPricingCard

→ representa una propuesta de valor destinada a comparación/selección.

Ejemplo:

"Pro — $499 / mes"

--------------------------------

OrpProfileCard

→ representa una identidad o perfil.

Ejemplo:

"Daniel López — Desarrollador Web"

--------------------------------

OrpContentCard

→ representa contenido editorial/informativo.

Ejemplo:

"Cómo mejorar Core Web Vitals"

"Guía para integrar APIs REST"

"10 tendencias de diseño web"

No mezclar responsabilidades.

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
    ├── OrpCatalogCard
    ├── OrpPricingCard
    ├── OrpProfileCard
    └── OrpContentCard     ← IMPLEMENTAR AHORA

OrpContentCard debe componerse usando primitives/components existentes.

No recrear capacidades ya presentes en ORP.

==================================================
5. AUDIT OBLIGATORIO
==================================================

ANTES de escribir OrpContentCard:

auditar físicamente:

resources/js/Components/OrpUI/

LESS ORP

ORP Playground

y especialmente:

- Card
- Media
- MediaCard
- Avatar
- Badge
- Stack
- Cluster
- Grid
- Button
- IconButton
- Divider
- List
- CatalogCard
- PricingCard
- ProfileCard

Verificar APIs reales.

NO asumir:

props
slots
events
classes
modifiers
tokens

No inventar APIs porque parezcan lógicas.

==================================================
6. AUDIT DE CONTENIDO EXISTENTE — READ ONLY
==================================================

Se permite revisar componentes reales del proyecto para descubrir necesidades.

Buscar interfaces relacionadas con:

- noticias
- posts
- blog
- recursos
- proyectos
- promociones con estructura editorial
- contenido destacado
- FAQs relacionadas
- cards informativas
- elementos con fecha/autor/categoría

También revisar ejemplos del Playground.

ESTE AUDIT ES READ-ONLY.

NO migrar componentes de Acerca.

==================================================
7. REPEATED UI INVENTORY
==================================================

Antes de implementar, identificar piezas repetidas.

Para cada una:

CONCEPT:
USED IN:
CURRENT IMPLEMENTATION:
EXISTING ORP SOLUTION:
DOMAIN SPECIFIC:
EXTRACTION CANDIDATE:
DECISION:
REASON:

Prestar atención especialmente a:

- eyebrow/category
- author identity
- metadata
- date/time
- reading time
- icon + text
- avatar + name
- action row
- media overlay
- tags
- status
- byline

==================================================
8. DISCOVER → EXTRACT → REUSE
==================================================

Antes de escribir markup/CSS nuevo:

¿ORP ya lo resuelve?
→ REUSE

Si NO:

¿es específico de ContentCard?
→ mantener en ContentCard

Si NO:

¿aparece en 2+ contextos reales?
→ evaluar extracción

Si se extrae:

debe convertirse en Primitive o Component ORP independiente.

Debe tener:

- responsabilidad clara
- API pequeña
- demo propia en Playground
- tests aplicables
- documentación

==================================================
9. NO EXTRAER TODO
==================================================

No convertir cada wrapper en componente Vue.

Un nuevo componente debe justificar su existencia.

Responder:

1. ¿Tiene responsabilidad propia?
2. ¿Es independiente del dominio?
3. ¿Se reutiliza en al menos dos contextos?
4. ¿Reduce duplicación real?
5. ¿Tiene API estable?
6. ¿No existe ya otra primitive equivalente?

Si no:

NO EXTRAER.

==================================================
10. COMPONENTES EMERGENTES POSIBLES
==================================================

Durante ContentCard podrían aparecer conceptos como:

OrpMetaItem
OrpMetaList
OrpByline
OrpTagList
OrpEyebrow
OrpActionGroup
OrpIdentity
OrpTimestamp

Estos nombres son SOLO ejemplos.

NO son requisitos.

NO implementarlos automáticamente.

Si `Avatar + text + metadata` ya puede resolverse correctamente mediante primitives existentes:

REUTILIZAR.

==================================================
11. ANATOMÍA
==================================================

Anatomía conceptual:

┌──────────────────────────────┐
│                              │
│            MEDIA             │
│                              │
│ CATEGORY / EYEBROW           │
│                              │
├──────────────────────────────┤
│                              │
│ TITLE                        │
│                              │
│ EXCERPT                      │
│                              │
│ META                         │
│                              │
│ AUTHOR / DATE / CONTEXT      │
│                              │
│ ACTION                       │
└──────────────────────────────┘

No todas las regiones son obligatorias.

==================================================
12. COMPOSICIÓN FLEXIBLE
==================================================

Debe funcionar correctamente con:

media + title

title + excerpt

title + meta

media + title + excerpt + meta

media + category + title + author

title + action

etc.

No dejar espacios vacíos cuando un slot no existe.

==================================================
13. API BASADA EN SLOTS
==================================================

Evitar una API enorme como:

title
authorName
authorAvatar
publishedAt
category
readingTime
tags
featured
image
excerpt
url
showDate
showAuthor
showCategory

Preferir slots semánticos.

Dirección conceptual:

<OrpContentCard>

    <template #media>
        ...
    </template>

    <template #eyebrow>
        ...
    </template>

    <template #title>
        ...
    </template>

    <template #excerpt>
        ...
    </template>

    <template #meta>
        ...
    </template>

    <template #byline>
        ...
    </template>

    <template #actions>
        ...
    </template>

</OrpContentCard>

Los nombres finales deben compararse con las convenciones de Patterns existentes.

==================================================
14. MEDIA
==================================================

La región media debe aceptar contenido flexible:

- img
- picture
- thumbnail
- video thumbnail
- illustration
- custom media

No asumir siempre una imagen.

Reutilizar Media/MediaCard si corresponde.

No implementar otro sistema de aspect ratio si ORP ya tiene uno.

==================================================
15. EYEBROW
==================================================

La región superior puede representar:

Tecnología
Tutorial
Noticias
Caso de estudio
Nuevo
Destacado

ContentCard NO interpreta el contenido.

Puede utilizar:

OrpBadge
texto
link
custom content

No crear props:

category
featured
newsType

salvo evidencia arquitectónica extremadamente fuerte.

==================================================
16. TITLE
==================================================

Es la identidad principal del contenido.

Debe funcionar con títulos:

cortos

y

largos de múltiples líneas.

No truncar mediante JavaScript.

Si existe line clamp:

debe ser CSS y estar claramente justificado.

==================================================
17. HEADING SEMANTICS
==================================================

No hardcodear h2/h3/h4 sin considerar contexto.

Seguir la estrategia definida en otros Patterns.

Si los Patterns existentes ya resolvieron heading semantics:

reutilizar la misma convención.

No crear una segunda solución.

==================================================
18. EXCERPT
==================================================

Región opcional para resumen/descripción.

Ejemplos:

"Aprende cómo reducir el LCP..."

"Una guía práctica para integrar..."

Debe soportar contenido variable.

No asumir que siempre existe.

==================================================
19. META
==================================================

Meta puede representar:

- fecha
- tiempo de lectura
- categoría secundaria
- número de comentarios
- duración
- dificultad
- ubicación
- tipo de recurso

ContentCard no interpreta esos valores.

Aquí debemos reutilizar cualquier primitive de metadata descubierta previamente.

==================================================
20. BYLINE
==================================================

Byline representa contexto de autoría/origen.

Ejemplos:

Avatar + Daniel López

Por María García

Equipo ORP

Puede incluir:

avatar
name
source
date

PERO:

no crear un componente Byline automáticamente.

Primero revisar si ProfileCard/Identity/Avatar/Cluster ya permiten resolverlo de forma suficientemente limpia.

==================================================
21. REUTILIZACIÓN DE PROFILE / IDENTITY
==================================================

Si OrpProfileCard ya existe:

NO usar ProfileCard completo dentro de ContentCard salvo que tenga sentido.

Una card completa dentro de otra card probablemente sería incorrecta.

Pero ProfileCard puede revelar primitives internas reutilizables.

Ejemplo:

Avatar
Identity row
MetaItem

Reutilizar primitives, no necesariamente Patterns completos.

==================================================
22. ACTIONS
==================================================

Debe permitir:

- link
- button
- icon button
- custom action
- ninguna acción

Ejemplos del consumidor:

Leer artículo
Ver proyecto
Abrir recurso
Continuar
Ver caso

ContentCard NO debe hardcodear ninguna acción.

==================================================
23. CARD CLICKABLE
==================================================

Este Pattern sí tiene un caso frecuente:

toda la card puede abrir el contenido.

Evaluar cuidadosamente una estrategia genérica para card interactiva.

Debe evitar:

<a>
   ...
   <button>
</a>

Si la card completa es clickable y también existen acciones internas:

resolver correctamente nested interactive controls.

Revisar cómo CatalogCard maneja interactividad.

No inventar otra estrategia si ya existe una buena.

==================================================
24. STRETCHED LINK
==================================================

Evaluar si ORP ya tiene una estrategia equivalente a stretched-link.

No implementar hacks de pseudo-elementos sin revisar accesibilidad.

La solución debe preservar:

- text selection cuando sea razonable
- focus
- keyboard
- acciones internas

==================================================
25. VARIANTES
==================================================

No crear demasiadas variantes.

Evaluar únicamente:

vertical

horizontal

si existe evidencia real.

No crear:

news
blog
tutorial
featuredArticle
project
caseStudy

Las variantes describen layout, no dominio.

==================================================
26. VERTICAL
==================================================

Conceptualmente:

┌────────────────────────┐
│ MEDIA                  │
├────────────────────────┤
│ EYEBROW                │
│ TITLE                  │
│ EXCERPT                │
│ META                   │
│ BYLINE                 │
└────────────────────────┘

==================================================
27. HORIZONTAL
==================================================

Solo si se justifica:

┌─────────┬────────────────────┐
│ MEDIA   │ EYEBROW            │
│         │ TITLE              │
│         │ EXCERPT            │
│         │ META               │
└─────────┴────────────────────┘

Antes de implementar:

revisar OrpMediaCard.

No duplicar su responsabilidad.

==================================================
28. TAGS
==================================================

No crear Tag system automáticamente.

Revisar si:

OrpBadge
Cluster

ya resuelven:

[tag] [tag] [tag]

Si sí:

REUSE.

Si existen necesidades más complejas repetidas:

documentar candidato.

==================================================
29. DATE / TIME
==================================================

ContentCard NO debe formatear fechas internamente.

NO incluir:

Intl.DateTimeFormat

date-fns

moment

dayjs

ni lógica equivalente.

El consumidor entrega contenido ya formateado o utiliza otra responsabilidad dedicada.

==================================================
30. READING TIME
==================================================

NO crear:

readingTime prop

como concepto obligatorio.

Debe poder representarse dentro de:

meta

Ejemplo:

5 min de lectura

ContentCard no sabe qué significa.

==================================================
31. AUTHOR
==================================================

NO crear:

authorName
authorAvatar
authorUrl

como API rígida.

Usar:

byline slot

o primitive genérica si el audit la justifica.

==================================================
32. GRID
==================================================

Grid ya pertenece a Primitives / Primary.

Los ejemplos múltiples de ContentCard deben usar Grid cuando corresponda.

Conceptualmente:

<div class="orp-grid orp-grid--auto-md">

    <OrpContentCard />

    <OrpContentCard />

    <OrpContentCard />

</div>

NO crear:

.content-card-grid {
    display: grid;
    ...
}

si Grid ya resuelve la necesidad.

Esta fase debe comenzar a DOGFOODEAR ORP dentro del propio Playground.

==================================================
33. STACK / CLUSTER
==================================================

Reutilizar:

Stack

para ritmo vertical.

Cluster

para metadata/actions/tags cuando corresponda.

No recrear:

display:flex
gap
flex-wrap

localmente si primitives existentes ya lo solucionan.

==================================================
34. TOKENS
==================================================

Usar tokens ORP existentes.

NO hardcodear arbitrariamente:

spacing
colors
radius
shadow
font sizes
transitions

si existe equivalente.

==================================================
35. CSS
==================================================

ContentCard debe componer Card.

No recrear surface.

CSS específico debe limitarse a:

- composición
- hierarchy
- placement
- responsive behavior
- content-specific layout

Conceptualmente:

.orp-content-card
.orp-content-card__media
.orp-content-card__eyebrow
.orp-content-card__body
.orp-content-card__title
.orp-content-card__excerpt
.orp-content-card__meta
.orp-content-card__byline
.orp-content-card__actions

Pero seguir naming real.

==================================================
36. NO DOMAIN CSS
==================================================

PROHIBIDO:

.orp-blog-card
.orp-news-card
.orp-post-card
.orp-article-card
.orp-tutorial-card

También:

--news
--blog
--tutorial
--project

==================================================
37. MOBILE FIRST
==================================================

Diseñar primero:

320
375
390
430

Luego:

768
1200
1440

Revisar:

- media crop
- long title
- excerpt
- metadata wrapping
- author/byline
- actions
- horizontal variant si existe

==================================================
38. TOUCH
==================================================

Acciones táctiles deben tener targets apropiados.

Usar OrpIconButton cuando corresponda.

Icon-only actions requieren accessible name.

==================================================
39. ACCESSIBILITY
==================================================

Auditar:

- article semantics
- heading hierarchy
- media alt
- decorative media
- links
- keyboard
- focus-visible
- clickable card
- nested interactions
- byline
- contrast
- reduced motion

==================================================
40. SEMANTIC ARTICLE
==================================================

Evaluar si:

<article>

es un default apropiado.

Pero no imponerlo ciegamente si el Pattern puede aparecer en contextos donde otra semántica sea necesaria.

Seguir convenciones ORP existentes para root element configurable si ya existen.

No crear complejidad innecesaria.

==================================================
41. PLAYGROUND
==================================================

Agregar:

Patterns → Content Card

dentro del Playground existente.

No crear página paralela.

==================================================
42. PLAYGROUND — EXAMPLES
==================================================

Mostrar como mínimo:

EXAMPLE 1 — Article

Media
Tecnología
"Cómo mejorar Core Web Vitals"
Excerpt
Author/date
Action

--------------------------------

EXAMPLE 2 — Tutorial

Media
Tutorial
"Integrando una API REST con Laravel"
Metadata:
12 min
Intermedio

--------------------------------

EXAMPLE 3 — Case Study

Media
"Caso de estudio: Academia Internacional de Globos"
Excerpt
Metadata
Action

--------------------------------

EXAMPLE 4 — No Media

Category
Title
Excerpt
Meta

--------------------------------

EXAMPLE 5 — Minimal

Title
Meta

--------------------------------

EXAMPLE 6 — Long Content

Long title
Long excerpt
multiple metadata
byline
action

==================================================
43. PLAYGROUND — COLLECTION
==================================================

Agregar ejemplo de múltiples ContentCards usando la primitive Grid existente.

No crear CSS grid local.

Probar al menos:

3-6 cards

con diferentes longitudes de contenido.

==================================================
44. PLAYGROUND — HORIZONTAL
==================================================

Solo si horizontal fue realmente implementado.

Mostrar un ejemplo real.

Si no existe:

NO documentarlo.

==================================================
45. PLAYGROUND — INTERACTIVE
==================================================

Si ContentCard soporta card clickable:

mostrar:

- keyboard focus
- hover
- focus-visible

y un ejemplo con acción interna para verificar que no existan nested interactive problems.

==================================================
46. COMPONENTES EMERGENTES
==================================================

Si durante esta fase se crea una nueva primitive/component:

debe agregarse al Playground en su categoría correcta.

Debe tener demos independientes.

Ejemplo:

Components → Meta Item

NO esconderlo solamente dentro de ContentCard.

==================================================
47. TESTS
==================================================

Agregar tests siguiendo infraestructura actual.

ContentCard:

- render
- slots
- optional regions
- interactive behavior si existe
- variants si existen
- class composition
- accessibility básica

Nuevos components:

tests propios.

No introducir testing framework nuevo.

==================================================
48. BROWSER QA
==================================================

Usar browser QA existente.

Preferir Puppeteer/Chrome headless si está disponible.

Probar:

320
375
390
430
768
1200
1440

Revisar:

- overflow
- media
- title wrapping
- excerpt
- metadata
- byline
- actions
- Grid collection
- clickable behavior
- focus

No declarar PASS sin inspección real.

==================================================
49. CONTENT EDGE CASES
==================================================

Probar:

- sin media
- sin excerpt
- sin meta
- sin byline
- sin actions
- título largo
- metadata larga
- image missing/fallback si Media lo soporta
- action label largo
- varias cards con alturas distintas

==================================================
50. BUILD
==================================================

Ejecutar:

npm run build

y tests ORP existentes.

Debe pasar.

==================================================
51. DOCUMENTACIÓN
==================================================

Documentar:

PURPOSE

Represent editorial or informational content intended to be identified, previewed and opened/consumed.

USE FOR

- articles
- news
- posts
- tutorials
- resources
- case studies
- guides
- editorial projects

DO NOT USE FOR

catalog entities
→ OrpCatalogCard

pricing/value propositions
→ OrpPricingCard

people/identity
→ OrpProfileCard

generic surfaces
→ OrpCard

==================================================
52. DOCUMENTAR DIFERENCIA Catalog vs Content
==================================================

Esta diferencia debe quedar especialmente clara.

CatalogCard:

"What is this item and what value/attributes does it have?"

ContentCard:

"What is this content about and why should I open/read it?"

Esto evitará usar ambas cards indistintamente.

==================================================
53. NO DOGFOODING EN ACERCA TODAVÍA
==================================================

NO modificar:

SectionServices
SectionProducts
SectionPackages
SectionReviews
SectionLocations
SectionGallery
SectionFeatures
SectionProperties
RestaurantMenu
Hero
Navigation
Footer

El dogfooding de esta fase ocurre solamente dentro de ORP Playground usando primitives ORP como Grid/Stack/Cluster.

==================================================
54. NO BUSINESS LOGIC
==================================================

No modificar:

Controllers
Routes
Models
Database
API
Inertia
business logic

==================================================
55. CRITERIO DE ÉXITO DEL PATTERN
==================================================

Debe ser posible representar con el mismo OrpContentCard:

artículo
noticia
tutorial
recurso
caso de estudio
guía

sin que el componente contenga referencias internas a esos dominios.

==================================================
56. CRITERIO DE ÉXITO DE COMPOSICIÓN
==================================================

ContentCard debe utilizar ORP para resolver problemas genéricos.

No queremos encontrar dentro de ContentCard grandes bloques reinventando:

Card
Grid
Stack
Cluster
Badge
Avatar
Buttons

El Pattern debe COMPOSER.

==================================================
57. CRITERIO DE ÉXITO DEL SISTEMA
==================================================

Al terminar debemos poder responder:

¿Qué piezas repetidas descubrimos?

¿Qué piezas ya resolvía ORP?

¿Qué nuevas abstractions fueron necesarias?

¿Qué decidimos no abstraer?

¿ContentCard redujo duplicación gracias a Grid/Stack/Cluster/Card?

==================================================
58. NO SOBREABSTRAER
==================================================

No crear componentes hipotéticos.

Es preferible:

slots + primitives existentes

a:

OrpAuthor
OrpArticleDate
OrpReadingTime
OrpCategory
OrpPostMeta

si esos conceptos solamente existen dentro del dominio editorial.

Extraer solamente conceptos verdaderamente genéricos.

==================================================
59. REPORTE FINAL
==================================================

Entregar:

# ORP CONTENT CARD — IMPLEMENTATION REPORT

## Existing ORP Audit

Reviewed:

- Card
- Media
- MediaCard
- Avatar
- Badge
- Stack
- Cluster
- Grid
- Button
- IconButton
- CatalogCard
- PricingCard
- ProfileCard

## Repeated UI Inventory

For each:

Concept:
Seen in:
Existing ORP solution:
Extraction candidate:
Decision:
Reason:

## New ORP Components Created

If none:

NONE

If created:

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

## OrpContentCard Architecture

Layer:
Pattern

Purpose:

Difference from CatalogCard:

Internal composition:

## API

Props:
Slots:
Events:
Variants:
Interactive strategy:

## Generic Validation

Article:
PASS / FAIL

Tutorial:
PASS / FAIL

Case Study:
PASS / FAIL

No Media:
PASS / FAIL

Minimal:
PASS / FAIL

Long Content:
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

Badge:
YES / NO

Avatar:
YES / NO

Other:

## Local Layout Duplication

Custom display:grid introduced:
YES / NO

Custom generic flex layout introduced:
YES / NO

If YES:
justify why existing ORP primitive was insufficient.

## Accessibility

Semantics:
Heading:
Media:
Keyboard:
Focus:
Clickable card:
Nested interactions:
Icon actions:
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

## Playground

ContentCard added:
YES / NO

Collection using ORP Grid:
YES / NO

Interactive example:
YES / NO / NOT IMPLEMENTED

New components:
YES / NO

## Tests

ContentCard:
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

Did this phase reuse Grid?
YES / NO

Did this phase reuse existing primitives?
YES / NO

Did this phase reduce generic CSS duplication?
YES / NO

Were new abstractions created only with evidence?
YES / NO

## Future Dogfooding Candidates

List only.

Do NOT modify them.

## Final Status

READY FOR HUMAN REVIEW

or

NEEDS MORE WORK

STOP.

==================================================
FINAL INSTRUCTION
==================================================

Implementa:

1. OrpContentCard.
2. Su integración en ORP Playground.
3. Ejemplos individuales.
4. Una colección usando la primitive Grid existente.
5. Tests.
6. Documentación.
7. Audit explícito de piezas repetidas.
8. Si y SOLO SI existe evidencia suficiente, crear primitives/components ORP genéricos faltantes.
9. Todo nuevo componente debe tener demo independiente, tests y documentación.
10. Reutilizar Grid, Stack, Cluster, Card y demás primitives existentes antes de escribir layout CSS genérico nuevo.
11. No migrar componentes de Acerca todavía.
12. No crear abstracciones editoriales específicas disfrazadas de componentes genéricos.
13. STOP después de ContentCard y las abstracciones estrictamente justificadas descubiertas durante esta fase.

