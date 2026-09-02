# ORP UI — GENERIC COMPOSITION PATTERNS
# SEVENTH PATTERN: OrpContactCard
# AFTER MAP + INFORMATION DISCOVERY

Continuamos el roadmap de ORP UI.

Estado conceptual:

1. OrpCatalogCard
2. OrpPricingCard
3. OrpProfileCard
4. Grid — Primitive / Primary
5. OrpContentCard
6. OrpStatCard
7. OrpMap + OrpMapMarker
8. Information Component Discovery
9. OrpContactCard ← IMPLEMENTAR AHORA

Siguiente paso después de esta fase:

10. OrpActionCard

Esta fase debe aplicar:

DISCOVER → EXTRACT → REUSE → COMPOSE

pero ya parte de dos descubrimientos previos importantes:

- ORP tiene/puede tener componentes nativos de mapas basados en Leaflet + OpenStreetMap.
- ORP ya auditó cómo representar información repetida tipo icon + content / label + value.

NO volver a inventar esas piezas dentro de ContactCard.

==================================================
1. OBJETIVO PRINCIPAL
==================================================

Crear:

OrpContactCard.vue

como Pattern genérico para representar un punto de contacto, ubicación, canal de atención o conjunto de información útil para comunicarse con una entidad.

Debe poder utilizarse para:

- oficinas
- sucursales
- tiendas
- ubicaciones
- puntos de atención
- soporte
- departamentos
- profesionales
- organizaciones
- negocios
- servicios
- directorios
- vCards
- puntos geográficos de contacto

SIN conocer el dominio.

NO crear:

OfficeCard
StoreCard
LocationCard
BranchCard
BusinessContactCard
WhatsAppCard
AddressCard
SupportCard

==================================================
2. DEFINICIÓN
==================================================

OrpContactCard representa:

"Una entidad o punto de contacto acompañado de detalles, contexto, mapa opcional y acciones relacionadas."

Ejemplo conceptual:

┌──────────────────────────────┐
│ Oficina Guadalajara          │
│ Sucursal principal           │
│                              │
│ [icon] Av. Vallarta 1234     │
│ [icon] 33 1234 5678          │
│ [icon] hola@empresa.com      │
│ [icon] Lun–Vie · 9–18 h      │
│                              │
│ ┌──────────────────────────┐ │
│ │     MAPA LEAFLET / OSM   │ │
│ └──────────────────────────┘ │
│                              │
│ [Cómo llegar] [Contactar]    │
└──────────────────────────────┘

Pero ContactCard NO interpreta esos detalles.

==================================================
3. RESPONSABILIDAD
==================================================

ContactCard debe resolver:

- composición visual
- jerarquía
- agrupación de información
- región de mapa opcional
- acciones

NO debe resolver:

- geocoding
- routing
- formatting
- phone parsing
- mailto generation
- WhatsApp URLs
- horarios
- lat/lng business rules
- fetching

==================================================
4. DIFERENCIA CON ProfileCard
==================================================

ProfileCard:

representa identidad.

Ejemplo:

Daniel López
Desarrollador Web

ContactCard:

representa información orientada a comunicación/localización.

Ejemplo:

Oficina Guadalajara
Dirección
Teléfono
Horario
Mapa
Acciones

No fusionarlos.

==================================================
5. DIFERENCIA CON CatalogCard
==================================================

CatalogCard:

"What is this item?"

ContactCard:

"How do I find or contact this entity?"

Ejemplo:

Departamento Centro — $18,000
→ CatalogCard

Sucursal Centro — Av. Juárez 100
→ ContactCard

==================================================
6. ARQUITECTURA
==================================================

ORP UI
│
├── Foundation
│
├── Primitives / Primary
│   ├── Grid
│   ├── Stack
│   ├── Cluster
│   ├── Card
│   └── ...
│
├── Components
│   ├── OrpMap
│   ├── OrpMapMarker
│   ├── Information primitive/component si fue justificado
│   └── ...
│
└── Patterns
    ├── OrpCatalogCard
    ├── OrpPricingCard
    ├── OrpProfileCard
    ├── OrpContentCard
    ├── OrpStatCard
    └── OrpContactCard ← AHORA

ContactCard debe COMPONER ORP existente.

==================================================
7. AUDIT OBLIGATORIO
==================================================

ANTES de implementar:

auditar físicamente:

- OrpCard
- Stack
- Cluster
- Grid
- Badge
- Avatar
- Button
- IconButton
- Divider
- List
- OrpMap
- OrpMapMarker
- component/primitive de información si fue creado
- CatalogCard
- ProfileCard
- ContentCard
- StatCard

También:

- ORP Playground
- LESS
- tokens
- tests
- docs

NO asumir APIs.

==================================================
8. AUDIT DEL DISCOVERY DE INFO
==================================================

Leer el resultado del Architectural Discovery Pass anterior.

Determinar:

- si se creó OrpInfoItem
- si se creó OrpMetaItem
- si no se creó nada
- si Stack/Cluster/List/Grid fueron suficientes

ContactCard debe respetar esa decisión.

NO crear una segunda solución local.

==================================================
9. AUDIT READ-ONLY DE ACERCA
==================================================

Revisar solamente como evidencia:

- SectionLocations
- vCards
- Footer/contact sections
- SectionProperties
- RestaurantMenu
- Contact forms
- business profile/location UI

NO migrar.

==================================================
10. ANATOMÍA
==================================================

Anatomía conceptual:

┌──────────────────────────────┐
│ TITLE                        │
│ SUBTITLE / CONTEXT           │
│                              │
│ DETAILS                      │
│                              │
│ MAP                          │
│                              │
│ META / STATUS                │
│                              │
│ ACTIONS                      │
└──────────────────────────────┘

Todas las regiones deben ser opcionales salvo la estructura mínima que defina el Pattern.

==================================================
11. API SLOT-FIRST
==================================================

Dirección conceptual:

<OrpContactCard>

    <template #title>
        ...
    </template>

    <template #subtitle>
        ...
    </template>

    <template #details>
        ...
    </template>

    <template #map>
        ...
    </template>

    <template #meta>
        ...
    </template>

    <template #actions>
        ...
    </template>

</OrpContactCard>

Los nombres finales deben seguir convenciones reales de Patterns existentes.

==================================================
12. NO DOMAIN PROPS
==================================================

PROHIBIDO diseñar API alrededor de:

phone
email
whatsapp
address
street
city
state
zip
country
openingHours
latitude
longitude
website
directionsUrl

El consumidor compone esos datos.

==================================================
13. DETAILS
==================================================

Details puede contener:

- information items
- metadata
- links
- labels
- values
- custom content

Ejemplos:

[icon] Guadalajara

Teléfono
33 1234 5678

Email
hola@example.com

El Pattern NO interpreta esos datos.

==================================================
14. REUTILIZAR INFO PRIMITIVE
==================================================

Si el Discovery Pass creó una primitive/component de información:

REUTILIZARLA.

Ejemplo conceptual:

<template #details>
    <div class="orp-stack ...">
        <OrpInfoItem>...</OrpInfoItem>
        <OrpInfoItem>...</OrpInfoItem>
    </div>
</template>

No crear:

.contact-card__detail-row

si eso duplica una primitive ya existente.

==================================================
15. SI NO EXISTE INFO COMPONENT
==================================================

Si el Discovery Pass concluyó que:

Stack + Cluster + typography

son suficientes:

usar esa composición.

NO crear OrpInfoItem dentro de esta fase solo porque ContactCard lo necesita.

La decisión anterior manda.

==================================================
16. MAP SLOT
==================================================

ContactCard debe tener una región explícita para mapas.

Ejemplo:

<template #map>
    <OrpMap
        :center="[20.6736, -103.344]"
        :zoom="14"
    >
        <OrpMapMarker
            :position="[20.6736, -103.344]"
        />
    </OrpMap>
</template>

ContactCard no conoce Leaflet directamente.

==================================================
17. MAP COMPONENT RESPONSIBILITY
==================================================

La relación debe ser:

ContactCard
    ↓
#map slot
    ↓
OrpMap
    ↓
OrpMapMarker
    ↓
Leaflet
    ↓
OpenStreetMap

ContactCard NO debe:

- importar Leaflet
- inicializar mapas
- manejar markers
- llamar invalidateSize
- manejar tiles
- manejar attribution

==================================================
18. MAP OPTIONAL
==================================================

La card debe funcionar perfectamente sin mapa.

No dejar:

- espacio vacío
- padding extraño
- border vacío
- min-height innecesario

si #map no existe.

==================================================
19. MULTIPLE MARKERS
==================================================

El slot debe permitir:

<OrpMap>
    <OrpMapMarker />
    <OrpMapMarker />
</OrpMap>

ContactCard no debe limitar la cantidad.

==================================================
20. MAP HEIGHT
==================================================

El tamaño debe provenir de OrpMap y su API/tokens.

NO hardcodear altura Leaflet dentro de ContactCard salvo ajuste estrictamente compositivo y documentado.

==================================================
21. STATUS / META
==================================================

Puede incluir:

Abierto
Cerrado
Disponible
24/7
Atención con cita

Pero ContactCard no interpreta estados.

Reutilizar:

Badge
Status

si existen.

==================================================
22. ACTIONS
==================================================

Debe permitir:

- link
- button
- icon button
- custom actions
- ninguna acción

Ejemplos del consumidor:

Cómo llegar
Contactar
Llamar
Enviar email
Abrir sitio

ContactCard NO genera URLs automáticamente.

==================================================
23. WHATSAPP
==================================================

No crear:

orp-btn--whatsapp

WhatsApp pertenece al dominio/integración de la aplicación.

Puede ser simplemente:

<OrpButton ...>

con contenido y URL proporcionados por el consumidor.

==================================================
24. DIRECTIONS
==================================================

ContactCard NO debe implementar routing.

Un botón "Cómo llegar" puede enlazar a:

- OpenStreetMap
- Apple Maps
- otra URL
- aplicación externa

pero el consumidor decide.

No integrar Google Maps por defecto.

==================================================
25. OPENSTREETMAP
==================================================

Los ejemplos del Playground con mapa deben usar:

Leaflet + OpenStreetMap

según la infraestructura ORP ya creada.

NO Google Maps.

==================================================
26. MEDIA
==================================================

No confundir mapa con media genérica.

Si la card necesita foto además del mapa:

evaluar composición con slots existentes.

NO inflar API sin evidencia.

==================================================
27. ORIENTATION
==================================================

Evaluar si ContactCard necesita:

vertical
horizontal

solo si hay evidencia real.

Caso horizontal posible en desktop:

┌─────────────────────┬─────────────────────┐
│ CONTACT INFO        │ MAP                 │
└─────────────────────┴─────────────────────┘

No crear variante si Grid/container composition puede resolverlo mejor.

==================================================
28. GRID
==================================================

Si el layout horizontal usa dos regiones:

evaluar Grid primitive existente.

No crear:

display:grid

local si ORP Grid lo resuelve.

==================================================
29. STACK
==================================================

Usar Stack para:

- title/subtitle/details
- vertical information rhythm
- actions stack cuando sea necesario

No recrear flex column genérico.

==================================================
30. CLUSTER
==================================================

Usar Cluster para:

- actions
- status/meta
- compact details
- icon + text

cuando corresponda.

==================================================
31. CARD
==================================================

ContactCard debe componer OrpCard.

NO recrear:

surface
shadow
border
radius
hover states

si Card ya lo proporciona.

==================================================
32. CSS
==================================================

CSS local debe limitarse a composición.

Conceptualmente:

.orp-contact-card
.orp-contact-card__header
.orp-contact-card__title
.orp-contact-card__subtitle
.orp-contact-card__details
.orp-contact-card__map
.orp-contact-card__meta
.orp-contact-card__actions

Seguir naming real.

==================================================
33. NO DOMAIN CSS
==================================================

PROHIBIDO:

.orp-office-card
.orp-store-card
.orp-location-card
.orp-branch-card
.orp-whatsapp-contact
.orp-phone-row
.orp-address-row

==================================================
34. TOKENS
==================================================

Usar tokens ORP existentes.

No hardcodear:

spacing
colors
radius
shadows
font-size
map radius
icon sizes

==================================================
35. MOBILE FIRST
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

==================================================
36. MOBILE MAP
==================================================

En móvil:

- mapa no debe provocar overflow
- controles Leaflet deben ser utilizables
- mapa no debe bloquear page scroll innecesariamente
- acciones deben seguir accesibles
- detalles largos deben envolver

==================================================
37. LONG DETAILS
==================================================

Probar:

- dirección larga
- email largo
- URL larga
- horario largo
- multiline
- múltiples detalles
- sin iconos
- con iconos

==================================================
38. ACCESSIBILITY
==================================================

Auditar:

- heading semantics
- link purpose
- focus
- icon labels
- map accessible labeling
- reading order
- contrast
- touch targets
- nested interactive elements

==================================================
39. MAP ACCESSIBILITY
==================================================

El mapa NO debe ser la única fuente de información de ubicación.

Si una ubicación existe:

debe poder expresarse también en texto dentro de details cuando el consumidor lo necesite.

ContactCard debe permitir esta composición.

==================================================
40. CLICKABLE CARD
==================================================

ContactCard NO debe ser clickable por defecto.

Normalmente contiene múltiples links/actions.

Whole-card interaction puede provocar nested interactions.

Evitarla salvo evidencia muy fuerte.

==================================================
41. PLAYGROUND
==================================================

Agregar:

Patterns → Contact Card

al Playground existente.

No crear nueva página.

==================================================
42. PLAYGROUND — BASIC
==================================================

Ejemplo:

Oficina Centro
Información de contacto
sin mapa

Demostrar versión mínima.

==================================================
43. PLAYGROUND — WITH DETAILS
==================================================

Mostrar múltiples detalles usando la solución de info aprobada previamente.

No crear markup ad hoc si ya existe primitive.

==================================================
44. PLAYGROUND — WITH MAP
==================================================

Ejemplo completo usando:

OrpMap
OrpMapMarker
Leaflet
OpenStreetMap

No usar mapa falso.

==================================================
45. PLAYGROUND — MULTIPLE MARKERS
==================================================

Mostrar un ContactCard donde el slot map contenga varios markers si tiene sentido.

Esto demuestra que ContactCard no controla el mapa.

==================================================
46. PLAYGROUND — ACTIONS
==================================================

Mostrar:

Cómo llegar
Contactar

como acciones genéricas.

No integrar lógica externa.

==================================================
47. PLAYGROUND — WITHOUT MAP
==================================================

Verificar explícitamente que la versión sin mapa mantenga buena composición.

==================================================
48. PLAYGROUND — LONG CONTENT
==================================================

Probar:

- title largo
- subtitle
- dirección larga
- múltiples links
- varias acciones
- mapa

==================================================
49. PLAYGROUND — COLLECTION
==================================================

Mostrar varias ContactCards usando ORP Grid.

Ejemplo:

3 ubicaciones

No crear CSS grid local.

==================================================
50. PLAYGROUND — MAP + GRID
==================================================

Verificar que múltiples ContactCards con mapas no generen:

- conflictos Leaflet
- duplicate initialization
- IDs compartidos
- overflow
- performance issues evidentes

==================================================
51. MAP LIFECYCLE QA
==================================================

Si los ejemplos permiten mount/unmount:

verificar que OrpMap mantenga cleanup correcto.

ContactCard no debe interferir con lifecycle.

==================================================
52. NEW COMPONENT DISCOVERY
==================================================

Durante ContactCard todavía pueden aparecer piezas repetidas.

Pero el umbral ahora debe ser ALTO.

No crear nueva abstraction salvo:

- 2+ contextos reales
- responsabilidad clara
- dominio independiente
- API pequeña
- primitive existente insuficiente

==================================================
53. NO MAP EXPANSION
==================================================

NO aprovechar esta fase para implementar:

OrpMapPopup
routing
geolocation
clustering
polygons
GeoJSON

Si aparece necesidad:

documentar Phase 2 candidate.

==================================================
54. TESTS
==================================================

Agregar tests según infraestructura existente.

ContactCard:

- render
- slots
- optional map
- details
- meta
- actions
- absence of regions
- variant si realmente existe
- accessibility básica

No testear Leaflet internals dentro de ContactCard si ya están cubiertos por OrpMap tests.

==================================================
55. BROWSER QA
==================================================

Probar:

320
375
390
430
768
1200
1440

Revisar:

- sin mapa
- con mapa
- multiple markers
- details
- long content
- actions
- multiple cards
- Grid
- focus
- overflow
- Leaflet controls

==================================================
56. CONSOLE QA
==================================================

No aceptar:

Vue warnings
Leaflet initialization errors
marker icon 404
ResizeObserver warnings
nested interactive warnings
console errors

==================================================
57. BUILD
==================================================

Ejecutar:

npm run build

y tests ORP.

Debe pasar.

==================================================
58. DOCUMENTACIÓN
==================================================

Documentar:

PURPOSE

Represent a contact point or contact-oriented entity with optional structured details, map and actions.

USE FOR

- offices
- locations
- branches
- contact points
- support points
- organizations
- directory entries

DO NOT USE FOR

person identity
→ OrpProfileCard

catalog entity
→ OrpCatalogCard

editorial content
→ OrpContentCard

metric
→ OrpStatCard

generic surface
→ OrpCard

==================================================
59. DOCUMENTAR MAP COMPOSITION
==================================================

Debe quedar explícito:

ContactCard does not implement maps.

It composes:

OrpMap
OrpMapMarker

through its map region/slot.

==================================================
60. DOCUMENTAR BUSINESS DATA
==================================================

ContactCard does not know:

phone
email
address
hours
latitude
longitude
WhatsApp
routing URLs

Those belong to the consumer.

==================================================
61. NO ACERCA MIGRATION
==================================================

NO modificar todavía:

SectionLocations
vCards
SectionProperties
RestaurantMenu
Footer
Contact forms
Minisite

Solo ORP Playground.

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

==================================================
63. CRITERIO DE ÉXITO — GENERICIDAD
==================================================

El mismo ContactCard debe poder representar:

oficina
sucursal
punto de soporte
departamento
ubicación profesional
punto de servicio

sin saber qué tipo de entidad es.

==================================================
64. CRITERIO DE ÉXITO — MAP
==================================================

ContactCard debe poder contener un mapa real mediante:

OrpMap + OrpMapMarker

sin importar Leaflet directamente.

==================================================
65. CRITERIO DE ÉXITO — INFORMATION
==================================================

Los detalles no deben introducir una tercera implementación de:

icon + content
label + value
metadata

Debe reutilizar la decisión arquitectónica previa.

==================================================
66. CRITERIO DE ÉXITO — ORP COMPOSITION
==================================================

La implementación debe apoyarse en:

Card
Stack
Cluster
Grid
Map
MapMarker
Info/Meta primitive si existe
Button/IconButton

y mantener CSS específico bajo.

==================================================
67. REPORTE FINAL
==================================================

Entregar:

# ORP CONTACT CARD — IMPLEMENTATION REPORT

## Existing ORP Audit

Reviewed:

- Card
- Stack
- Cluster
- Grid
- Button
- IconButton
- Badge/Status
- Information primitive/component
- Map
- MapMarker
- CatalogCard
- ProfileCard
- ContentCard
- StatCard

## Information Discovery Result Used

Previous decision:

Implementation reused:

New local duplicate introduced:
YES / NO

## OrpContactCard Architecture

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

## Map Integration

Map slot:
YES / NO

OrpMap reused:
YES / NO

OrpMapMarker reused:
YES / NO

Direct Leaflet import:
YES / NO

Expected:
NO

OpenStreetMap demo:
YES / NO

## Details Composition

Information primitive reused:
YES / NO / NOT CREATED

Stack:
YES / NO

Cluster:
YES / NO

List:
YES / NO

## Generic Validation

Office:
PASS / FAIL

Branch:
PASS / FAIL

Support point:
PASS / FAIL

Without map:
PASS / FAIL

With map:
PASS / FAIL

Multiple markers:
PASS / FAIL

Long content:
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

Map:
YES / NO

MapMarker:
YES / NO

Button/IconButton:
YES / NO

## CSS Duplication

Generic grid duplicated:
YES / NO

Generic stack duplicated:
YES / NO

Info row duplicated:
YES / NO

Leaflet styling duplicated:
YES / NO

If YES:
justify.

## Accessibility

Heading:
Details:
Links:
Actions:
Map:
Keyboard:
Focus:
Touch:
Contrast:

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

Basic:
YES / NO

Details:
YES / NO

Map:
YES / NO

Multiple markers:
YES / NO

Actions:
YES / NO

No map:
YES / NO

Long content:
YES / NO

Grid collection:
YES / NO

## Tests

ContactCard:
PASS / FAIL

## Build

npm run build:

PASS / FAIL

## Console

Leaflet errors:
NONE / FOUND

Vue warnings:
NONE / FOUND

Asset 404:
NONE / FOUND

## New Abstractions Created

NONE

or list with justification.

## Phase 2 Map Candidates

List only.

DO NOT IMPLEMENT.

## Acerca Changes

NONE

## Business Logic Changes

NONE

## Final Status

READY FOR HUMAN REVIEW

or

NEEDS MORE WORK

STOP.

==================================================
FINAL INSTRUCTION
==================================================

Implementa:

1. OrpContactCard.
2. Reutiliza la decisión del Information Discovery Pass.
3. Integra el slot de mapa mediante OrpMap + OrpMapMarker.
4. No importes Leaflet directamente dentro de ContactCard.
5. Usa OpenStreetMap en los demos.
6. Usa Card, Stack, Cluster, Grid y demás primitives existentes antes de escribir layout genérico.
7. Agrega ContactCard al ORP Playground.
8. Incluye demos con y sin mapa.
9. Incluye collection usando ORP Grid.
10. Ejecuta tests.
11. Ejecuta browser QA real.
12. Ejecuta npm run build.
13. No agregues Google Maps.
14. No expandas la API de mapas en esta fase.
15. No migres Acerca todavía.
16. No agregues business logic.
17. STOP después de OrpContactCard y únicamente las abstracciones estrictamente justificadas descubiertas en esta fase.

