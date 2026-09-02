# ORP UI — PHASE: GENERIC COMPOSITION PATTERNS
# FIRST PATTERN: OrpCatalogCard

Vamos a comenzar una nueva capa dentro de ORP UI:

GENERIC COMPOSITION PATTERNS

Hasta ahora ORP UI tiene principalmente:

- design tokens
- CSS primitives
- Vue UI components
- layout primitives
- interaction components

Ahora necesitamos componentes de composición de mayor nivel que resuelvan patrones reales de interfaces SIN conocer el dominio de la aplicación.

IMPORTANTE:

NO estamos creando componentes específicos para Acerca.

NO estamos creando:

ProductCard
ServiceCard
PropertyCard
RestaurantItem
PackageCard

Queremos abstraer el patrón común que existe detrás de todos ellos.

El primer componente será:

OrpCatalogCard

==================================================
1. OBJETIVO
==================================================

Crear un componente Vue reusable:

OrpCatalogCard.vue

que represente genéricamente un elemento dentro de un catálogo.

Debe poder utilizarse para representar, entre otros:

- productos
- servicios
- propiedades
- platillos
- habitaciones
- cursos
- experiencias
- eventos
- paquetes
- membresías
- planes
- artículos comerciales
- cualquier entidad similar

ORP NO debe saber qué tipo de entidad está mostrando.

Por lo tanto:

NO usar nombres de dominio dentro de su API.

PROHIBIDO introducir props como:

product
service
property
durationMinutes
stock
deposit
bedrooms
bathrooms
sku
booking
restaurant
whatsapp
addToCart

Todo eso pertenece a las aplicaciones consumidoras.

==================================================
2. ARQUITECTURA DE ORP
==================================================

Considerar conceptualmente ORP en estas capas:

ORP UI
│
├── Foundation
│   ├── Tokens
│   ├── Typography
│   └── Utilities
│
├── Primitives
│   ├── Card
│   ├── Media
│   ├── Badge
│   ├── Price
│   ├── Stack
│   ├── Cluster
│   └── Button
│
├── Components
│   ├── Modal
│   ├── Drawer
│   ├── Accordion
│   ├── Tabs
│   └── Inputs
│
└── Patterns
    └── CatalogCard      ← IMPLEMENTAR AHORA

OrpCatalogCard es un PATTERN.

No reemplaza a OrpCard.

Debe COMPONER primitives/componentes existentes de ORP.

Conceptualmente:

OrpCatalogCard
     │
     ├── OrpCard
     ├── media primitive/component
     ├── badge primitive/component
     ├── price primitive/component
     ├── stack/cluster
     └── actions

Pero solamente usar componentes Vue cuando su API real haga sentido.

No envolver componentes porque sí.

==================================================
3. PRIMER PASO OBLIGATORIO: AUDIT
==================================================

ANTES de escribir OrpCatalogCard:

auditar físicamente el ORP actual.

Revisar como mínimo:

resources/js/Components/OrpUI/

y los LESS correspondientes de:

Card
Media
MediaCard
Badge
Price
Button
IconButton
Stack
Cluster

Verificar:

- APIs reales
- props
- slots
- variantes
- tamaños
- clases
- tokens
- estados interactivos
- responsive
- accessibility

NO asumir APIs basándote en nombres.

No inventar:

props
slots
modifiers
classes
tokens

Si algo no existe, documentarlo como:

ORP GAP

==================================================
4. REVISAR EL PLAYGROUND
==================================================

Existe:

http://acerca.local/orp-playground

Revisar cómo está construido.

Identificar:

- archivo/ruta del Playground
- organización actual
- navegación
- ejemplos
- cómo registra/renderiza componentes
- cómo presenta variantes

El nuevo Pattern debe aparecer ahí.

NO crear otro playground.

NO crear otra página de documentación.

Extender el sistema existente.

==================================================
5. CONCEPTO DE CATALOG CARD
==================================================

CatalogCard representa:

"Una entidad visual dentro de una colección o catálogo."

Su anatomía general será:

┌───────────────────────────────┐
│                               │
│             MEDIA             │
│                               │
│  BADGES / OVERLAY             │
│                               │
├───────────────────────────────┤
│                               │
│ TITLE                         │
│ DESCRIPTION                   │
│                               │
│ META                          │
│                               │
│ PRICE / VALUE                 │
│                               │
├───────────────────────────────┤
│ ACTIONS                       │
└───────────────────────────────┘

Esta anatomía NO implica que todas las regiones sean obligatorias.

La card debe funcionar correctamente aunque solamente tenga:

media + title

o:

title + description

o:

title + price

o:

media + title + meta + actions

etc.

==================================================
6. API: COMPOSICIÓN, NO FORMULARIO DE 40 PROPS
==================================================

CRÍTICO:

NO construir una API gigante como:

showImage
showPrice
showDescription
showBadge
showMeta
showButton
showStock
showDuration
showCategory
showComparePrice
showRating
...

Eso convertiría OrpCatalogCard en un componente rígido.

Preferir una API pequeña y slots semánticos.

La dirección esperada es aproximadamente:

<OrpCatalogCard>
    <template #media>
        ...
    </template>

    <template #overlay>
        ...
    </template>

    <template #title>
        ...
    </template>

    <template #description>
        ...
    </template>

    <template #meta>
        ...
    </template>

    <template #value>
        ...
    </template>

    <template #actions>
        ...
    </template>
</OrpCatalogCard>

Los nombres exactos deben decidirse después del audit.

Mantenerlos genéricos.

Por ejemplo:

#value

puede ser preferible a:

#price

si queremos permitir:

$450
Gratis
Desde $500
Consultar
20 créditos
4.8 estrellas
etc.

Sin embargo, si el audit demuestra que Price es un primitive central y `price` resulta más consistente con ORP, documentar la decisión.

La API final debe ser:

- pequeña
- semántica
- genérica
- predecible
- extensible

==================================================
7. PROPS PERMITIDAS
==================================================

Los props deben controlar comportamiento/presentación del PATTERN, no datos del negocio.

Ejemplos conceptualmente válidos:

variant
orientation
interactive
disabled
selected
mediaRatio

SOLO si realmente son necesarios.

No agregarlos automáticamente.

Cada prop debe justificar su existencia.

Preferir:

slots + CSS

antes que decenas de props booleanas.

==================================================
8. DEFAULT SLOT
==================================================

Evaluar si tiene sentido disponer de default slot.

Pero evitar una API ambigua donde:

#title
#description
#meta

compitan con un default slot que haga exactamente lo mismo.

Documentar claramente la decisión.

==================================================
9. MEDIA
==================================================

La región media debe ser reusable.

Debe aceptar:

- img
- picture
- video thumbnail
- placeholder
- custom media

No asumir que siempre existe una imagen.

No recibir directamente conceptos como:

productImage
serviceImage

Preferir slot.

Debe existir una estrategia consistente para:

- aspect ratio
- overflow
- object-fit
- border radius
- placeholder
- overlay

Utilizar tokens ORP.

==================================================
10. OVERLAY
==================================================

Debe existir una región apropiada para contenido sobre media cuando sea necesaria.

Ejemplos:

Popular
Nuevo
Oferta
45 min
Disponible
Destacado

Pero CatalogCard NO interpreta esos valores.

Simplemente proporciona la región.

El consumidor decide usar:

OrpBadge

u otro contenido.

==================================================
11. TITLE
==================================================

Debe existir una región semántica para el título.

No hardcodear:

h2
h3
h4

sin evaluar accesibilidad y contexto.

Una card puede aparecer dentro de diferentes niveles de documento.

Evaluar estrategia:

slot puro

o

prop configurable para heading level

SOLO si aporta valor real.

Evitar heading hierarchy incorrecta.

==================================================
12. DESCRIPTION
==================================================

La descripción debe ser opcional.

Debe funcionar con contenido corto o relativamente largo.

Si se aplica line clamp:

debe ser una decisión explícita.

No cortar contenido arbitrariamente desde JavaScript.

Preferir CSS cuando corresponda.

==================================================
13. META
==================================================

`meta` es una región extremadamente importante.

Puede contener:

- duración
- categoría
- ubicación
- disponibilidad
- rating
- características
- etiquetas
- autor
- capacidad
- etc.

ORP NO debe interpretar esos datos.

Ejemplo:

<template #meta>
    <div class="orp-cluster ...">
        <OrpBadge>45 min</OrpBadge>
        <span>Disponible</span>
    </div>
</template>

CatalogCard solamente define dónde vive la metadata.

==================================================
14. VALUE / PRICE
==================================================

Debe permitir representar valores destacados.

Ejemplos:

$450
$1,499
Desde $800
Gratis
Consultar
20 créditos

Cuando el consumidor represente dinero, debe poder utilizar:

OrpPrice

CatalogCard NO debe implementar formatting monetario.

NO:

Intl.NumberFormat
currency
locale
decimals

dentro de CatalogCard.

Eso pertenece a otra responsabilidad.

==================================================
15. ACTIONS
==================================================

Debe permitir:

- botones
- links
- icon buttons
- múltiples acciones
- ninguna acción

CatalogCard NO debe decidir:

Comprar
Reservar
Agregar al carrito
WhatsApp
Ver propiedad

Solo proporciona la región.

Utilizar primitives ORP desde el consumidor.

==================================================
16. INTERACTIVIDAD
==================================================

Necesitamos resolver correctamente cards interactivas.

Analizar:

- card completamente clickable
- card con acciones internas
- keyboard navigation
- Enter/Space
- focus-visible
- disabled state
- selected state
- nested interactive elements

CRÍTICO:

NO generar HTML inválido como:

<a>
    ...
    <button>
    ...
</a>

o:

<button>
    ...
    <a>
    ...
</button>

Si la card tiene acciones internas, la estrategia debe evitar nested interactive controls.

Documentar la estrategia seleccionada.

==================================================
17. VARIANTES
==================================================

No crear muchas variantes inicialmente.

Implementar solamente variantes que representen diferencias estructurales claras.

Evaluar como máximo inicialmente:

default / vertical
horizontal

Por ejemplo:

VERTICAL

┌─────────────┐
│    MEDIA    │
├─────────────┤
│ CONTENT     │
│ VALUE       │
│ ACTION      │
└─────────────┘

HORIZONTAL

┌──────┬──────────────────┐
│MEDIA │ TITLE            │
│      │ META             │
│      │ VALUE        →   │
└──────┴──────────────────┘

Pero:

NO implementar `horizontal` simplemente porque está mencionado aquí.

Primero comprobar si:

OrpMediaCard

ya resuelve correctamente ese problema.

No duplicar capacidades existentes.

Si MediaCard ya cubre horizontal perfectamente, CatalogCard puede mantenerse vertical en esta primera fase.

==================================================
18. MOBILE FIRST
==================================================

CatalogCard debe diseñarse mobile-first.

Probar como mínimo:

320
375
390
430

Después:

768
1200
1440

No diseñar desktop y luego comprimir.

Debe sentirse apropiada para interfaces modernas móviles.

==================================================
19. TOUCH
==================================================

Acciones táctiles:

mínimo aproximadamente 44px cuando corresponda.

No crear iconos diminutos difíciles de pulsar.

Usar OrpIconButton si corresponde.

==================================================
20. RESPONSIVE
==================================================

La CARD no debería depender demasiado del viewport global.

Debe intentar comportarse correctamente dentro de diferentes containers.

Evitar media queries de página cuando sea posible.

Evaluar container queries solamente si ORP ya las utiliza o si existe una razón arquitectónica clara.

No introducirlas gratuitamente.

==================================================
21. TOKENS
==================================================

PROHIBIDO hardcodear arbitrariamente:

colors
spacing
radius
shadows
font sizes
transitions
z-index

si ORP ya tiene token equivalente.

Usar:

var(--orp-space-*)
var(--orp-radius-*)
var(--orp-shadow-*)
var(--orp-font-size-*)
var(--orp-*)
etc.

Verificar nombres reales antes de usarlos.

==================================================
22. ICONOS
==================================================

ORP utiliza Bootstrap Icons como integración de iconografía.

CatalogCard NO debe incluir un icono específico por defecto.

El consumidor decide los iconos.

No introducir otra librería.

==================================================
23. CSS
==================================================

El Pattern debe tener su propio LESS siguiendo las convenciones reales del framework.

Ejemplo conceptual:

.orp-catalog-card
.orp-catalog-card__media
.orp-catalog-card__overlay
.orp-catalog-card__body
.orp-catalog-card__title
.orp-catalog-card__description
.orp-catalog-card__meta
.orp-catalog-card__value
.orp-catalog-card__actions

Pero antes revisar convenciones existentes.

No duplicar estilos que ya proporciona:

.orp-card
.orp-card__media
.orp-card__body
.orp-card__footer

CatalogCard debe apoyarse en Card.

No recrearla.

==================================================
24. COMPOSITION OVER DUPLICATION
==================================================

Ejemplo incorrecto:

.orp-catalog-card {
    background: ...
    border: ...
    border-radius: ...
    box-shadow: ...
}

si OrpCard ya proporciona todo eso.

Preferir conceptualmente:

<OrpCard class="orp-catalog-card">
    ...
</OrpCard>

CatalogCard agrega COMPOSICIÓN.

Card agrega SURFACE.

==================================================
25. NO DOMAIN CSS
==================================================

PROHIBIDO:

.orp-product-*
.orp-service-*
.orp-property-*
.orp-menu-item-*
.orp-package-*

También evitar:

--product
--service
--restaurant
--real-estate

El framework debe permanecer neutral.

==================================================
26. ACCESSIBILITY
==================================================

Auditar:

- semantic HTML
- heading hierarchy
- keyboard
- focus-visible
- screen readers
- interactive state
- disabled
- selected
- image alt responsibility
- actions
- reduced motion

No imponer alt automáticamente si el framework no conoce el contenido.

El consumidor debe poder proporcionar semántica correcta.

==================================================
27. REDUCED MOTION
==================================================

Si existe:

hover lift
scale
transform
animation

respetar:

prefers-reduced-motion

y seguir convenciones ORP existentes.

No introducir animaciones exageradas.

==================================================
28. PLAYGROUND
==================================================

Agregar una sección específica:

Patterns → Catalog Card

o la estructura equivalente que utilice actualmente el Playground.

Mostrar ejemplos REALES de generalidad.

Como mínimo:

EXAMPLE 1 — generic merchandise

Imagen
"Audífonos inalámbricos"
"Cancelación activa de ruido"
"Nuevo"
"$1,499"

EXAMPLE 2 — generic appointment offering

Imagen
"Corte premium"
"45 min"
"$450"
acción

EXAMPLE 3 — generic real estate/listing

Imagen
"Loft Centro"
"2 habitaciones · 1 baño"
"$18,000 / mes"

EXAMPLE 4 — no image

Título
Descripción
Metadata
Value
Action

EXAMPLE 5 — minimal

Title + value

IMPORTANTE:

Estos son únicamente ejemplos del Playground.

NO deben generar lógica específica dentro de CatalogCard.

==================================================
29. ESTADOS DEL PLAYGROUND
==================================================

También demostrar:

- default
- interactive
- long title
- long description
- multiple badges/meta
- without media
- without value
- without actions
- disabled, si el componente soporta disabled
- selected, si se decide soportarlo

No crear estados artificiales solo para llenar documentación.

==================================================
30. DOGFOODING
==================================================

NO migrar todavía:

ServiceCard.vue
ProductCard.vue
SectionServices.vue
SectionProducts.vue

Esta fase es exclusivamente:

CREAR Y VALIDAR OrpCatalogCard.

Después nosotros decidiremos cómo dogfoodarlo dentro de Acerca.

Esto evita diseñar el Pattern condicionado por la implementación actual de Services.

==================================================
31. TESTS
==================================================

Revisar cómo se prueban actualmente los componentes ORP.

Agregar tests consistentes con el proyecto.

Como mínimo comprobar:

- renders
- slots principales
- ausencia de regiones opcionales
- classes/variants
- interactive behavior si existe
- disabled behavior si existe
- emitted events si existen
- accessibility básica

NO introducir un framework nuevo de testing.

==================================================
32. BROWSER QA
==================================================

El Playground debe revisarse visualmente en navegador.

Usar Puppeteer/Chrome headless si esa infraestructura sigue disponible.

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
- image crop
- long titles
- descriptions
- metadata wrapping
- value
- actions
- touch targets
- focus
- hover
- cards without media
- cards without actions

No declarar PASS si no hubo inspección real.

==================================================
33. BUILD
==================================================

Ejecutar:

npm run build

Debe pasar.

Si existe comando específico de tests ORP, ejecutarlo también.

==================================================
34. DOCUMENTACIÓN
==================================================

Documentar OrpCatalogCard siguiendo el sistema existente del proyecto.

Debe quedar claro:

PURPOSE

Represent generic catalog/listing entities.

USE FOR

items with combinations of:

media
title
description
metadata
value
actions

DO NOT USE FOR

generic containers → OrpCard
simple media/content → OrpMediaCard, si corresponde
pricing comparison → futuro OrpPricingCard
profile/person → futuro OrpProfileCard

Esto es importante para evitar que CatalogCard termine convirtiéndose en "la card para todo".

==================================================
35. FUTUROS PATTERNS
==================================================

NO implementarlos todavía.

Solamente documentar como posible roadmap:

OrpCatalogCard      ← NOW
OrpPricingCard
OrpProfileCard
OrpContentCard
OrpStatCard
OrpContactCard
OrpActionCard
OrpInfoCard

No crear archivos vacíos.

No crear APIs futuras.

==================================================
36. CRITERIO PRINCIPAL DE ÉXITO
==================================================

Al terminar debería ser posible construir:

un servicio

un producto

una propiedad

un platillo

un curso

usando exactamente:

OrpCatalogCard

SIN que OrpCatalogCard contenga una sola referencia conceptual a:

service
product
property
restaurant
course

Ese es el criterio arquitectónico principal.

==================================================
37. SEGUNDO CRITERIO DE ÉXITO
==================================================

El consumidor debería necesitar MUCHO MENOS CSS para crear una card comercial consistente.

Queremos pasar de algo como:

ServiceCard.vue
+ 100-200 líneas de estilos específicos

a conceptualmente:

OrpCatalogCard
+ pequeños estilos de composición del dominio

No necesariamente cero CSS.

El framework debe resolver el patrón común.

La aplicación debe resolver diferencias del dominio.

==================================================
38. NO SOBREABSTRAER
==================================================

Si durante la implementación descubres que alguna región no tiene todavía suficiente evidencia para abstraerse:

NO inventarla.

Mantener el componente pequeño.

Es preferible:

7 slots sólidos

que:

25 props
14 variants
9 eventos
y una API imposible de mantener.

==================================================
39. ARCHIVOS
==================================================

Antes de crear archivos, determinar las convenciones reales del repositorio.

Probablemente necesitaremos algo equivalente a:

resources/js/Components/OrpUI/OrpCatalogCard.vue

resources/less/orp-ui/_catalog-card.less

y actualización del entry/index correspondiente.

PERO:

NO asumir esas rutas automáticamente.

Primero revisar cómo están registrados/importados los componentes y estilos existentes.

Seguir exactamente la arquitectura real.

==================================================
40. NO TOCAR
==================================================

No modificar:

Controllers
Routes de Minisite
Database
Models
API
Inertia payload
Services
Products
Packages
Properties
RestaurantMenu
business logic

No cambiar la arquitectura del Minisite.

Esta tarea pertenece a ORP UI.

==================================================
41. REPORTE FINAL
==================================================

Entregar:

# ORP CATALOG CARD — IMPLEMENTATION REPORT

## Audit

Existing primitives inspected:

- Card:
- Media:
- MediaCard:
- Badge:
- Price:
- Button:
- IconButton:
- Stack:
- Cluster:

Existing capabilities reused:

ORP gaps discovered:

## Architecture

Pattern:
OrpCatalogCard

Layer:
Pattern / Composition

Purpose:

Why CatalogCard instead of ProductCard/ServiceCard:

## API

Props:

Slots:

Events:

Variants:

Interactive strategy:

## Internal composition

Uses:

- OrpCard:
- Media:
- Stack:
- Cluster:
- other:

Duplicated primitive CSS:
YES / NO

If YES explain why.

## Generic validation

Merchandise:
PASS / FAIL

Appointment offering:
PASS / FAIL

Property/listing:
PASS / FAIL

No media:
PASS / FAIL

Minimal:
PASS / FAIL

## Accessibility

Semantic structure:
Keyboard:
Focus:
Nested interactive controls:
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

Added:
YES / NO

Examples:

States demonstrated:

## Tests

Tests added:

Result:
PASS / FAIL

## Build

npm run build:

PASS / FAIL

## ORP core changes

Files created:

Files modified:

## Minisite changes

NONE

## Business logic changes

NONE

## Future dogfooding candidates

Do NOT modify them, only list likely candidates.

## Final status

READY FOR HUMAN REVIEW

or

NEEDS MORE WORK

STOP.

==================================================
FINAL INSTRUCTION
==================================================

Implementa solamente OrpCatalogCard y su integración/documentación dentro del ORP Playground.

No migres Services ni Products todavía.

Primero quiero revisar visualmente y arquitectónicamente el nuevo Pattern.

Cuando esté aprobado, lo utilizaremos como foundation para reducir ServiceCard, ProductCard y otras composiciones del Minisite.

STOP after OrpCatalogCard.
