# ORP UI — GENERIC INFORMATION COMPONENTS
# DISCOVERY PHASE: MetaItem / InfoItem
# BEFORE OrpContactCard

Continuamos el roadmap de ORP UI.

Ya se definió/implementó la primera fase de mapas:

- OrpMap
- OrpMapMarker
- Leaflet
- OpenStreetMap

Antes de regresar a OrpContactCard debemos resolver otra necesidad que apareció repetidamente:

estructuras genéricas del tipo:

[icon] contenido

[icon] label + value

label + value

icon + title + description

Estas estructuras aparecen potencialmente en:

- ContactCard
- ProfileCard
- ContentCard
- StatCard
- Locations
- metadata
- detalles
- horarios
- teléfonos
- emails
- direcciones
- características
- información auxiliar

Esta fase NO debe asumir que necesitamos un componente llamado exactamente:

OrpMetaItem
OrpInfoItem

Primero debemos AUDITAR.

La regla obligatoria es:

DISCOVER → EXTRACT → REUSE → COMPOSE

==================================================
1. OBJETIVO
==================================================

Realizar un Architectural Discovery Pass enfocado en pequeñas unidades de información repetidas dentro de ORP.

Determinar si ORP necesita uno o más componentes/primitives genéricos para representar información estructurada.

Ejemplos conceptuales:

[icon] Guadalajara

[icon] 33 1234 5678

[icon] hola@example.com

[icon] Lun–Vie · 9:00–18:00

--------------------------------

Teléfono
33 1234 5678

--------------------------------

[icon]
Dirección
Av. Vallarta 1234

NO comenzar creando componentes.

Primero descubrir el patrón real.

==================================================
2. POSIBLES RESULTADOS
==================================================

Esta fase puede concluir:

A)

ORP ya puede resolverlo correctamente usando:

Stack
Cluster
Badge
Avatar
typography
etc.

Resultado:

NO NEW COMPONENT.

--------------------------------

B)

Existe una primitive claramente repetida.

Resultado posible:

OrpInfoItem

--------------------------------

C)

Existen dos responsabilidades diferentes.

Por ejemplo:

OrpInfoItem
OrpInfoList

--------------------------------

D)

Existe otra abstracción mejor que los nombres propuestos.

Usar la arquitectura que revele el audit.

==================================================
3. NO IMPLEMENTAR POR NOMBRE
==================================================

NO asumir que deben existir:

OrpMetaItem
OrpInfoItem
OrpDetailItem
OrpContactItem
OrpLabelValue
OrpInfoList

Los nombres son candidatos.

Primero determinar:

qué problema existe realmente.

==================================================
4. AUDIT ORP
==================================================

Revisar físicamente:

- Stack
- Cluster
- List
- ListItem
- Badge
- Avatar
- Card
- Divider
- typography helpers
- icon patterns
- Link
- Button
- IconButton

Y especialmente Patterns:

- CatalogCard
- PricingCard
- ProfileCard
- ContentCard
- StatCard

Buscar markup repetido.

==================================================
5. AUDIT DEL PLAYGROUND
==================================================

Revisar todo ORP Playground.

Buscar ejemplos donde se repita:

icon + text

label + value

icon + label + value

title + secondary text

metadata rows

detail lists

No mirar solamente Components.

Revisar:

Primitives
Components
Patterns

==================================================
6. AUDIT READ-ONLY EN ACERCA
==================================================

Revisar como evidencia adicional:

- SectionLocations
- SectionServices
- SectionProducts
- SectionProperties
- SectionRestaurantMenu
- SectionContactForm
- vCards
- Hero/profile information
- Footer/contact information
- appointment/location UI

NO modificar esos archivos.

==================================================
7. REPEATED UI INVENTORY
==================================================

Crear inventario.

Para cada estructura:

CONCEPT:
FILES:
NUMBER OF OCCURRENCES:
MARKUP SHAPE:
CURRENT CSS:
EXISTING ORP SOLUTION:
DOMAIN SPECIFIC:
GENERIC:
EXTRACTION CANDIDATE:
DECISION:
REASON:

No decir "repeated" sin evidencia.

==================================================
8. DISTINGUIR META DE INFO
==================================================

Analizar si realmente existen dos conceptos.

META:

información secundaria/contextual compacta.

Ejemplos:

5 min
12 comentarios
Guadalajara
Actualizado ayer

INFO:

dato estructurado con mayor significado.

Ejemplos:

Teléfono
33 1234 5678

Dirección
Av. Vallarta 1234

Horario
9:00–18:00

Determinar si esta distinción aporta valor real.

Si no:

NO crear dos componentes.

==================================================
9. SEMÁNTICA
==================================================

La abstracción debe representar estructura visual/semántica genérica.

NO debe conocer:

phone
email
address
whatsapp
openingHours
author
readingTime
location
stock
duration

Estos son datos del consumidor.

==================================================
10. SLOT-FIRST
==================================================

Si se crea un componente:

preferir composición.

Ejemplo conceptual:

<OrpInfoItem>
    <template #icon>
        ...
    </template>

    <template #label>
        Teléfono
    </template>

    <template #value>
        33 1234 5678
    </template>
</OrpInfoItem>

Pero la API final debe surgir del audit.

==================================================
11. SIMPLE CONTENT
==================================================

Debe poder funcionar también sin label.

Ejemplo:

<OrpInfoItem>
    <template #icon>...</template>

    Guadalajara
</OrpInfoItem>

No obligar estructuras innecesarias.

==================================================
12. ICON
==================================================

El icono debe ser opcional.

Puede contener:

Bootstrap Icon
SVG
custom content

No hardcodear iconos según tipo.

PROHIBIDO:

type="phone"
type="email"
type="address"

si eso provoca lógica/iconografía de dominio.

==================================================
13. LABEL
==================================================

Label debe ser opcional.

No asumir que todos los items necesitan:

label:
value:

==================================================
14. VALUE / CONTENT
==================================================

El contenido puede ser:

texto
link
badge
custom component

Ejemplo:

Email
<a>hola@example.com</a>

ORP no debe transformar automáticamente texto en links.

==================================================
15. LINKS
==================================================

NO generar automáticamente:

tel:
mailto:
https:
whatsapp:

El consumidor decide semántica y URL.

El componente solamente presenta/componen contenido.

==================================================
16. LIST CONTAINER
==================================================

Si existen múltiples InfoItems:

evaluar si Stack/List existentes ya resuelven el grupo.

Ejemplo:

<div class="orp-stack ...">
    <OrpInfoItem />
    <OrpInfoItem />
    <OrpInfoItem />
</div>

Si esto es suficiente:

NO crear OrpInfoList.

==================================================
17. CUÁNDO CREAR InfoList
==================================================

Solo crear container específico si agrega responsabilidad real:

- semantics
- consistent separators
- density
- alignment
- responsive behavior
- shared layout contract

No crear wrapper por comodidad.

==================================================
18. ALIGNMENT
==================================================

Investigar si varios items requieren:

icon column alignment

label column alignment

value alignment

Si existe esa necesidad:

determinar si pertenece al item, container o Grid.

No resolver con magic pixel widths.

==================================================
19. GRID
==================================================

Si label/value necesitan layout bidimensional:

evaluar Grid.

No crear CSS grid local automáticamente.

Pero tampoco forzar Grid si Cluster/Stack son más correctos.

==================================================
20. STACK / CLUSTER
==================================================

Reutilizar:

Stack
Cluster

antes de escribir:

display:flex
gap
align-items

localmente.

==================================================
21. ICON CONTAINER
==================================================

Buscar repetición del patrón:

rounded icon background + icon

Ejemplo:

┌────┐
│ 📍 │  Guadalajara
└────┘

Puede existir en:

StatCard
ContactCard futuro
Feature UI
Profile metadata
Actions

Evaluar si ORP ya tiene una primitive adecuada.

NO crear OrpIconBox automáticamente.

==================================================
22. STATUS
==================================================

Si algunos datos incluyen estados:

reutilizar Badge/Status existente.

No introducir status logic dentro de InfoItem.

==================================================
23. TREND
==================================================

Si StatCard ya creó Trend/Delta:

InfoItem NO debe duplicarlo.

Puede recibirlo como contenido.

==================================================
24. MAP RELATIONSHIP
==================================================

Esta fase ocurre después de:

OrpMap
OrpMapMarker

Pero InfoItem NO debe conocer mapas.

ContactCard futuro podrá componer:

OrpInfoItem
OrpMap
OrpMapMarker

como piezas independientes.

==================================================
25. RESPONSIVE
==================================================

La solución debe funcionar en:

320
375
390
430
768
1200
1440

Probar:

- labels largos
- values largos
- links largos
- email largo
- address-like text largo
- icon + multiline
- sin icon
- sin label

==================================================
26. TEXT WRAPPING
==================================================

Especial atención a:

long URLs
emails
IDs
technical values

No permitir overflow horizontal.

No usar truncation destructiva por defecto.

==================================================
27. DENSITY
==================================================

Evaluar si existe evidencia para:

compact
default

No crear variants sin necesidad.

==================================================
28. ORIENTATION
==================================================

Evaluar:

vertical:

Label
Value

horizontal:

Label     Value

Pero solo implementar ambas si aparecen realmente.

No construir mini grid system dentro del componente.

==================================================
29. ACCESSIBILITY
==================================================

Auditar:

- semantic grouping
- links
- labels
- icon decorative state
- icon accessible names
- color independence
- reading order

Iconos decorativos deben poder ocultarse de assistive technology según composición.

==================================================
30. HTML SEMANTICS
==================================================

Evaluar si algunos casos encajan naturalmente con:

dl
dt
dd

Pero NO forzar description list semantics a todos los usos.

Ejemplo:

label/value structured data
→ podría ser dl/dt/dd

icon + simple metadata
→ probablemente no.

Si existen dos semánticas diferentes:

no esconderlas bajo una abstracción incorrecta.

==================================================
31. COMPONENT VS CSS PRIMITIVE
==================================================

Pregunta obligatoria:

¿esto necesita Vue?

Si solamente resuelve:

display
gap
alignment

quizá debe ser CSS primitive.

Si resuelve:

slots
semantic structure
variants
accessibility contract

Vue puede estar justificado.

Documentar la decisión.

==================================================
32. NO UTILITY SOUP
==================================================

La solución tampoco debe obligar al consumidor a escribir:

orp-cluster
orp-stack
orp-gap-x
orp-align-y
orp-text-z
orp-icon-size-x

en cada item.

Si una composición se repite suficientemente:

abstraerla puede estar justificado.

==================================================
33. CSS
==================================================

Si se crea InfoItem:

CSS específico debe limitarse a su responsabilidad.

Conceptualmente:

.orp-info-item
.orp-info-item__icon
.orp-info-item__content
.orp-info-item__label
.orp-info-item__value

No crear estilos de:

phone
email
address
hours
location

==================================================
34. TOKENS
==================================================

Usar tokens ORP.

No hardcodear:

spacing
font size
colors
radius
icon sizes

si existe token apropiado.

==================================================
35. PLAYGROUND
==================================================

Si se crea una nueva primitive/component:

agregarla al Playground en su categoría correcta.

NO colocarla solamente dentro de ContactCard porque ContactCard aún no se implementará.

==================================================
36. PLAYGROUND — SIMPLE
==================================================

Ejemplo:

[icon] Guadalajara

==================================================
37. PLAYGROUND — LABEL VALUE
==================================================

Ejemplo:

Teléfono
33 1234 5678

El contenido es demo; el componente no sabe que es teléfono.

==================================================
38. PLAYGROUND — ICON + LABEL + VALUE
==================================================

Ejemplo:

[icon]
Horario
Lun–Vie · 9:00–18:00

==================================================
39. PLAYGROUND — LINK CONTENT
==================================================

Ejemplo donde value contiene un <a>.

Verificar focus y wrapping.

==================================================
40. PLAYGROUND — MULTIPLE ITEMS
==================================================

Mostrar varios items usando:

Stack
List
Grid

según arquitectura resultante.

Demostrar que no necesitamos un container nuevo si primitives existentes bastan.

==================================================
41. PLAYGROUND — LONG CONTENT
==================================================

Probar:

label largo
value largo
multiline
URL larga

==================================================
42. CROSS-PATTERN VALIDATION
==================================================

Si se crea una abstracción nueva:

demostrar al menos DOS contextos genéricos.

Por ejemplo:

Context A:
contact information

Context B:
profile/content metadata

No modificar los Patterns existentes solo para demostrarlo si eso implica refactor innecesario.

Puede demostrarse en Playground.

==================================================
43. NO MASS REFACTOR
==================================================

NO modificar todos los Patterns existentes.

Si se descubre que podrían usar el nuevo componente:

documentar:

FUTURE REFACTOR CANDIDATE

No realizar migración masiva en esta fase.

==================================================
44. TESTS
==================================================

Si NO se crea componente:

no inventar tests.

Si se crea:

probar:

- render
- icon optional
- label optional
- content/value
- slots
- variants reales
- links/content
- accessibility structure
- long content classes

Usar infraestructura existente.

==================================================
45. BROWSER QA
==================================================

Si existe nueva UI:

probar:

320
375
390
430
768
1200
1440

Revisar:

- wrapping
- alignment
- icon
- labels
- values
- links
- multiple items
- focus
- overflow

==================================================
46. BUILD
==================================================

Ejecutar:

npm run build

si se modificó código.

Ejecutar tests ORP relevantes.

==================================================
47. DOCUMENTACIÓN
==================================================

Si se crea un componente:

documentar:

PURPOSE

USE FOR

DO NOT USE FOR

API

SLOTS

SEMANTICS

ACCESSIBILITY

COMPOSITION WITH STACK/CLUSTER/GRID

==================================================
48. NO CONTACTCARD TODAVÍA
==================================================

NO implementar OrpContactCard.

Esta fase prepara las piezas necesarias.

Después de esta fase:

OrpContactCard podrá usar:

Card
Stack
Cluster
Grid
Map
MapMarker
Info/Meta primitive si fue justificada
Button
IconButton

==================================================
49. NO BUSINESS LOGIC
==================================================

No modificar:

Controllers
Models
Routes
Database
API
Inertia payloads

==================================================
50. NO ACERCA MIGRATION
==================================================

No modificar:

SectionLocations
SectionServices
SectionProducts
SectionProperties
vCards
Footer
Contact sections

Audit únicamente.

==================================================
51. CRITERIO DE ÉXITO
==================================================

La fase es exitosa incluso si la conclusión es:

NO NEW COMPONENT REQUIRED.

No medir éxito por cantidad de archivos creados.

Medir éxito por:

- evidencia
- reducción de duplicación
- arquitectura coherente
- API genérica
- no sobreabstracción

==================================================
52. REPORTE FINAL
==================================================

Entregar:

# ORP INFORMATION COMPONENT DISCOVERY — REPORT

## Existing ORP Audit

Reviewed:

- Stack
- Cluster
- Grid
- List
- Card
- Badge
- Avatar
- typography
- existing metadata primitives
- CatalogCard
- PricingCard
- ProfileCard
- ContentCard
- StatCard
- Map components

## Repeated UI Inventory

For each:

Concept:
Files:
Occurrences:
Shape:
Existing ORP solution:
Generic:
Extraction candidate:
Decision:
Reason:

## Meta vs Info Decision

Are these different concepts:
YES / NO

Reason:

## Component vs CSS Primitive Decision

Vue required:
YES / NO

Reason:

## New Abstraction Decision

New abstraction needed:
YES / NO

If NO:

Existing composition to use:

If YES:

Name:
Layer:
Purpose:
Why existing primitives are insufficient:

## API

Props:
Slots:
Events:
Variants:

## Semantic Strategy

Simple metadata:
Label/value:
Links:
Icons:
dl/dt/dd decision:

## Existing Primitive Reuse

Stack:
YES / NO

Cluster:
YES / NO

Grid:
YES / NO

List:
YES / NO

Badge/Status:
YES / NO / N/A

## New Components Created

NONE

or for each:

Name:
Layer:
Files:
Playground:
Tests:
Docs:

## Abstractions Rejected

Candidate:
Reason:

## Cross-context Validation

Context 1:
PASS / FAIL

Context 2:
PASS / FAIL

## Responsive QA

320:
375:
390:
430:
768:
1200:
1440:

## Accessibility

Semantics:
Icons:
Links:
Reading order:
Focus:
Color independence:

PASS / FAIL / NOT VERIFIED

## Tests

PASS / FAIL / NOT APPLICABLE

## Build

PASS / FAIL / NOT REQUIRED

## Future Refactor Candidates

List only.

DO NOT MODIFY.

## Acerca Changes

NONE

## Business Logic Changes

NONE

## ContactCard Readiness

Can ContactCard now compose information without domain-specific local markup?

YES / NO

Missing pieces:

## Final Status

READY FOR CONTACT CARD

or

NEEDS MORE ARCHITECTURAL WORK

STOP.

==================================================
FINAL INSTRUCTION
==================================================

1. Audita primero.
2. No crees OrpInfoItem/OrpMetaItem por intuición.
3. Busca repetición real dentro de ORP y, como evidencia secundaria, Acerca.
4. Determina si el problema requiere Vue, CSS primitive o simplemente composición con Stack/Cluster/Grid/List.
5. Si no hace falta una nueva abstracción, documenta esa conclusión y STOP.
6. Si hace falta, crea la abstracción mínima y genérica.
7. Toda abstracción nueva debe tener Playground, tests y documentación.
8. No introducir conceptos de teléfono/email/dirección/horario en la API.
9. No refactorizar masivamente Patterns existentes.
10. No implementar OrpContactCard todavía.
11. No modificar Acerca.
12. STOP cuando ORP tenga una decisión arquitectónica clara sobre este patrón de información.

