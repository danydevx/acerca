
# ORP UI — GENERIC COMPOSITION PATTERNS
# SECOND PATTERN: OrpPricingCard

Vamos a continuar la nueva capa de ORP UI:

GENERIC COMPOSITION PATTERNS

Ya existe o está en proceso:

OrpCatalogCard

Ahora vamos a crear el segundo Pattern:

OrpPricingCard

IMPORTANTE:

NO estamos creando:

PackageCard
PlanCard
SubscriptionCard
MembershipCard
SaasPlanCard

Queremos abstraer el patrón común de una oferta con:

- nombre
- descripción
- valor/precio
- metadata de precio
- lista de beneficios
- badge/eyebrow
- CTA
- estados visuales

Debe poder utilizarse para representar:

- planes SaaS
- membresías
- suscripciones
- paquetes
- bundles
- tiers
- licencias
- niveles de acceso
- ofertas
- servicios con precio cerrado

sin conocer el dominio.

==================================================
1. OBJETIVO
==================================================

Crear un componente Vue reusable:

OrpPricingCard.vue

que represente genéricamente una propuesta de valor o nivel de precio.

Su responsabilidad principal es ayudar al usuario a:

ENTENDER
↓
COMPARAR
↓
ELEGIR

una oferta.

No debe contener lógica de negocio.

==================================================
2. DIFERENCIA CON OrpCatalogCard
==================================================

Antes de implementar, dejar clara esta separación:

OrpCatalogCard
→ representa una entidad dentro de una colección o catálogo.

OrpPricingCard
→ representa una oferta, tier o propuesta de valor orientada a elección.

Ejemplo:

Producto:
"Audífonos inalámbricos"
→ CatalogCard

Plan:
"Pro — $499/mes — 20 proyectos"
→ PricingCard

Servicio individual:
"Corte — $450"
→ normalmente CatalogCard

Paquete:
"Premium — $1,499 — incluye 5 beneficios"
→ PricingCard

No mezclar responsabilidades.

==================================================
3. ARQUITECTURA
==================================================

ORP UI
│
├── Foundation
├── Primitives
├── Components
└── Patterns
    ├── OrpCatalogCard
    └── OrpPricingCard     ← IMPLEMENTAR AHORA

OrpPricingCard debe componerse utilizando primitives y componentes ORP existentes.

Conceptualmente:

OrpPricingCard
     │
     ├── OrpCard
     ├── OrpBadge
     ├── OrpPrice
     ├── OrpList
     ├── OrpStack
     ├── OrpCluster
     └── OrpButton

Pero:

NO usar wrappers Vue solo por existir.

Primero revisar APIs reales y decidir qué conviene reutilizar.

==================================================
4. AUDIT OBLIGATORIO
==================================================

ANTES de escribir código, revisar físicamente:

resources/js/Components/OrpUI/

y los LESS correspondientes de:

- OrpCard
- OrpBadge
- OrpPrice
- OrpList
- OrpListItem
- OrpStack
- OrpButton
- OrpIconButton
- OrpDivider
- OrpCatalogCard, si ya existe

También revisar:

- tokens de spacing
- typography
- radius
- shadow
- surfaces
- primary
- muted
- success
- border
- focus
- transitions

Verificar APIs reales.

NO inventar:

props
slots
events
modifiers
tokens
classes

Todo gap debe documentarse como:

ORP GAP

==================================================
5. REVISAR OrpCatalogCard
==================================================

Si OrpCatalogCard ya está implementado, revisarlo.

NO duplicar:

- naming patterns
- slot conventions
- interactive conventions
- selected/disabled behavior
- CSS architecture
- accessibility patterns

Los Patterns deben sentirse parte del mismo framework.

==================================================
6. ANATOMÍA
==================================================

La anatomía conceptual será:

┌──────────────────────────────┐
│ EYEBROW / BADGE              │
│                              │
│ TITLE                        │
│ DESCRIPTION                  │
│                              │
│ VALUE                        │
│ META                         │
│                              │
│ FEATURES                     │
│                              │
│ ACTIONS                      │
└──────────────────────────────┘

Ejemplo conceptual:

┌──────────────────────────────┐
│ RECOMENDADO                  │
│                              │
│ Pro                          │
│ Para pequeños equipos        │
│                              │
│ $499                         │
│ / mes                        │
│                              │
│ ✓ 20 proyectos               │
│ ✓ 5 usuarios                 │
│ ✓ Analytics                  │
│                              │
│ [ Elegir plan ]              │
└──────────────────────────────┘

NO copiar literalmente.

==================================================
7. API BASADA EN SLOTS
==================================================

Evitar API gigante.

NO crear:

planName
monthlyPrice
yearlyPrice
billingPeriod
features
stripeId
popular
recommended
subscription
package
membership
trialDays
usersLimit
projectsLimit

Todo eso pertenece al consumidor.

Preferir slots semánticos.

Dirección conceptual:

<OrpPricingCard>
    <template #eyebrow>
        ...
    </template>

    <template #title>
        ...
    </template>

    <template #description>
        ...
    </template>

    <template #value>
        ...
    </template>

    <template #meta>
        ...
    </template>

    <template #features>
        ...
    </template>

    <template #actions>
        ...
    </template>
</OrpPricingCard>

Los nombres finales deben validarse contra las convenciones de OrpCatalogCard.

==================================================
8. EYEBROW
==================================================

La región eyebrow sirve para contenido secundario superior como:

Recomendado
Popular
Más vendido
Enterprise
Ahorra 20%

PricingCard NO interpreta esos valores.

El consumidor puede usar:

OrpBadge

u otro contenido.

No crear:

recommended="true"

solo para pintar un badge.

==================================================
9. TITLE
==================================================

Debe permitir:

Free
Basic
Pro
Premium
Enterprise
Gold
Starter

sin asumir qué representa.

Evitar hardcodear heading level incorrecto.

Seguir la misma estrategia semántica definida en OrpCatalogCard si existe.

==================================================
10. DESCRIPTION
==================================================

Región opcional.

Debe funcionar con textos como:

"Para freelancers"

"Para equipos en crecimiento"

"Todo lo necesario para comenzar"

No forzar alturas fijas salvo que haya una razón clara de comparación visual.

==================================================
11. VALUE
==================================================

La región de valor es central.

Debe poder mostrar:

$499
$1,499
Gratis
Consultar
20 créditos
Desde $100

Cuando sea dinero, el consumidor puede usar:

OrpPrice

PricingCard NO debe formatear dinero.

NO incluir internamente:

Intl.NumberFormat
currency
locale
decimals

==================================================
12. META DEL VALOR
==================================================

Debe existir una región secundaria para contextualizar el valor.

Ejemplos:

/ mes
por usuario
pago único
anual
por proyecto
+ impuestos

PricingCard NO interpreta esa información.

Evitar nombres demasiado específicos como:

billingPeriod

Preferir:

meta
valueMeta

o equivalente consistente con ORP.

==================================================
13. FEATURES
==================================================

Features debe ser una región genérica.

Puede contener:

- OrpList
- OrpListItem
- texto
- iconos
- checks
- contenido personalizado

No obligar a recibir:

features: []

salvo que exista una razón arquitectónica clara.

Preferir slot para mantener flexibilidad.

PricingCard NO debe conocer conceptos como:

users
storage
projects
support
credits

==================================================
14. ACCIONES
==================================================

La región actions debe permitir:

- 1 CTA
- múltiples CTAs
- botones
- enlaces
- icon buttons
- sin acciones

PricingCard NO debe decidir:

Comprar
Elegir plan
Suscribirme
Contactar ventas
Empezar prueba

El consumidor decide.

==================================================
15. VARIANTES
==================================================

No crear muchas variantes.

Evaluar únicamente variantes estructurales o semánticas claramente justificadas.

Posibles conceptos:

default
featured

PERO:

No implementar featured automáticamente.

Primero evaluar si:

OrpCard selected/raised/outlined

más un eyebrow ya resuelve el problema.

Evitar:

--popular
--recommended
--premium
--enterprise

porque son conceptos de dominio o marketing.

==================================================
16. ESTADO DESTACADO
==================================================

Pricing UI frecuentemente necesita resaltar una opción.

Esto debe resolverse de forma genérica.

Ejemplos posibles:

selected
emphasized
featured

Elegir UN concepto si realmente es necesario.

Debe controlar presentación, no negocio.

No debe poner automáticamente:

"Más popular"

Eso pertenece al slot eyebrow.

==================================================
17. DISABLED
==================================================

Evaluar si tiene sentido soportar disabled.

Casos:

- plan no disponible
- opción temporalmente deshabilitada
- tier futuro

Si se implementa:

- reducir énfasis visual
- impedir interacción propia del componente
- mantener legibilidad
- aria-disabled cuando corresponda

Pero no implementar por obligación.

==================================================
18. FEATURES CON CHECKS
==================================================

NO hardcodear checks.

El framework no debe asumir que cada feature:

✓ está incluida

Podrían existir:

incluida
no incluida
limitada
premium
opcional

El consumidor debe controlar iconografía y estado.

==================================================
19. COMPARACIÓN VISUAL
==================================================

PricingCard debe funcionar bien cuando aparecen varias juntas.

Ejemplo:

Free | Pro | Business

Se debe cuidar:

- alturas razonablemente consistentes
- alignment del CTA
- wrapping
- feature lists
- value hierarchy

Pero evitar JS para sincronizar alturas.

Resolver con layout/CSS cuando sea posible.

==================================================
20. LAYOUT EN GRUPO
==================================================

PricingCard no debe controlar su grid externo.

Esto:

<OrpGrid>
    <OrpPricingCard />
    <OrpPricingCard />
    <OrpPricingCard />
</OrpGrid>

es responsabilidad del consumidor.

No introducir:

columns
itemsPerRow
gridGap

dentro de PricingCard.

==================================================
21. RESPONSABILIDAD DE LA CARD
==================================================

PricingCard controla:

- composición interna
- ritmo vertical
- hierarchy
- placement de regions
- surface relationship

El container controla:

- columnas
- carousel
- grid
- spacing externo

==================================================
22. STRETCH / CTA AL FONDO
==================================================

Pricing cards suelen necesitar que las acciones permanezcan visualmente alineadas.

Evaluar una composición interna:

display flex
flex-direction column

donde actions pueda quedar al final cuando exista espacio.

Pero:

NO hacer hacks de alturas fijas.

Debe funcionar también como card individual.

==================================================
23. TOKENS
==================================================

Usar exclusivamente tokens ORP existentes cuando exista equivalente.

NO hardcodear arbitrariamente:

padding
gap
radius
shadow
color
font-size
transition

Verificar nombres reales.

==================================================
24. SURFACE
==================================================

OrpPricingCard NO debe recrear Card.

Incorrecto:

.orp-pricing-card {
    background: ...
    border: ...
    border-radius: ...
    box-shadow: ...
}

si OrpCard ya resuelve esas responsabilidades.

Preferir conceptualmente:

<OrpCard class="orp-pricing-card">
   ...
</OrpCard>

PricingCard agrega estructura y jerarquía.

==================================================
25. CSS
==================================================

Seguir naming ORP real.

Conceptualmente podría existir:

.orp-pricing-card
.orp-pricing-card__eyebrow
.orp-pricing-card__header
.orp-pricing-card__title
.orp-pricing-card__description
.orp-pricing-card__value
.orp-pricing-card__value-meta
.orp-pricing-card__features
.orp-pricing-card__actions

Pero solo crear reglas donde exista responsabilidad propia.

No duplicar CSS de:

orp-card
orp-price
orp-list
orp-button
orp-badge

==================================================
26. NO DOMAIN CSS
==================================================

PROHIBIDO:

.orp-plan-card
.orp-package-card
.orp-membership-card
.orp-subscription-card
.orp-saas-card

También prohibido:

--monthly
--annual
--enterprise
--premium
--free

El framework debe seguir neutral.

==================================================
27. INTERACTIVIDAD
==================================================

PricingCard no debe ser completamente clickable por defecto.

Normalmente la interacción vive en el CTA.

Si se evalúa interacción de toda la card:

documentar muy bien la razón.

Evitar nested interactive controls.

No generar:

<a>
    <button>
</a>

ni:

<button>
    <a>
</button>

==================================================
28. ACCESSIBILITY
==================================================

Auditar:

- semantic HTML
- heading hierarchy
- feature list semantics
- CTA focus
- focus-visible
- disabled
- emphasized/selected
- screen readers
- contrast
- keyboard
- reduced motion

Una lista de beneficios debería poder representarse semánticamente como:

ul / li

si el consumidor así lo decide.

==================================================
29. MOBILE FIRST
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

En móvil normalmente las pricing cards aparecerán:

1 por fila

o en scroll horizontal según la composición externa.

PricingCard debe funcionar correctamente en ambos casos.

==================================================
30. LONG CONTENT
==================================================

Probar:

- título largo
- descripción larga
- precio grande
- value "Consultar precio"
- 3 features
- 10+ features
- CTA largo
- múltiples acciones

No debe generar overflow.

==================================================
31. PLAYGROUND
==================================================

Agregar:

Patterns → Pricing Card

dentro del Playground existente:

http://acerca.local/orp-playground

No crear otra página.

==================================================
32. EJEMPLOS DEL PLAYGROUND
==================================================

Mostrar como mínimo:

EXAMPLE 1

Starter

Gratis

3 beneficios

CTA

--------------------------------

EXAMPLE 2

Pro

$499
/ mes

badge:
Recomendado

6 beneficios

CTA principal

--------------------------------

EXAMPLE 3

Business

$4,999
/ año

descripción

features largas

2 acciones

--------------------------------

EXAMPLE 4

Pago único

$12,000

sin eyebrow

sin meta periódica

--------------------------------

EXAMPLE 5

Consultar

sin precio monetario

CTA:
Contactar

Esto debe demostrar que `value` no está limitado a dinero.

==================================================
33. EJEMPLOS MULTIDOMINIO
==================================================

También demostrar, si cabe de forma limpia:

SaaS plan

Paquete de fotografía

Membresía de gimnasio

Licencia profesional

Los ejemplos pueden variar.

La implementación interna NO debe cambiar según dominio.

==================================================
34. ESTADOS
==================================================

Mostrar solo estados soportados realmente:

default
emphasized/selected, si existe
disabled, si existe

No documentar estados inexistentes.

==================================================
35. CONSISTENCIA CON CatalogCard
==================================================

Visualmente:

CatalogCard
PricingCard

deben sentirse parte de la misma familia.

Comparar:

- radius
- surfaces
- spacing scale
- typography
- badge treatment
- button treatment
- focus
- motion

Pero no deben ser la misma composición.

==================================================
36. TESTS
==================================================

Seguir infraestructura de tests actual.

Agregar tests para:

- render
- title slot
- description slot
- value slot
- meta slot
- features slot
- actions slot
- optional regions absent
- emphasized/selected si existe
- disabled si existe
- class composition
- accessibility básica

No introducir testing framework nuevo.

==================================================
37. BROWSER QA
==================================================

Usar browser QA existente.

Preferir Puppeteer + Chrome headless si sigue configurado.

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
- pricing hierarchy
- long values
- features
- CTA
- multiple cards
- highlighted card
- focus
- touch

No declarar PASS sin inspección real.

==================================================
38. BUILD
==================================================

Ejecutar:

npm run build

y tests ORP existentes.

Debe pasar.

==================================================
39. DOCUMENTACIÓN
==================================================

Documentar claramente:

PURPOSE

Represent a pricing/value proposition intended for comparison or selection.

USE FOR

- pricing tiers
- memberships
- packages
- licenses
- subscriptions
- offers

DO NOT USE FOR

- generic catalog entities → OrpCatalogCard
- generic surfaces → OrpCard
- simple media/content → OrpMediaCard
- people → futuro OrpProfileCard
- metrics → futuro OrpStatCard

==================================================
40. NO DOGFOODING TODAVÍA
==================================================

NO modificar:

SectionPackages.vue
SectionProducts.vue
SectionServices.vue

NO reemplazar cards reales de Acerca todavía.

Esta fase es solo:

OrpPricingCard
+
Playground
+
Tests
+
Documentation

Después se hará dogfooding.

==================================================
41. CRITERIO DE ÉXITO
==================================================

Debe ser posible representar con el mismo componente:

Plan SaaS

Membresía

Paquete

Licencia

Oferta anual

sin que OrpPricingCard contenga referencias internas a:

plan
package
subscription
membership
stripe
saas

==================================================
42. SEGUNDO CRITERIO
==================================================

Debe reducir drásticamente el CSS necesario para crear pricing cards consistentes.

La aplicación debería aportar:

datos
features
actions

ORP debería aportar:

layout
hierarchy
spacing
surface composition
responsive behavior
visual consistency

==================================================
43. NO SOBREABSTRAER
==================================================

Preferimos:

7 slots claros
1-2 props justificadas

antes que:

25 props
10 variants
muchos booleans

No resolver necesidades hipotéticas.

Resolver el patrón común real.

==================================================
44. ARCHIVOS
==================================================

Determinar primero las convenciones reales del repositorio.

Probablemente habrá algo equivalente a:

resources/js/Components/OrpUI/OrpPricingCard.vue

resources/less/orp-ui/_pricing-card.less

y modificaciones a:

entry/index LESS
Playground
tests

Pero seguir arquitectura real.

No asumir rutas si el proyecto usa otra convención.

==================================================
45. NO TOCAR
==================================================

No modificar:

Controllers
Routes
Models
Database
API
Inertia
Minisite business logic
Packages
Products
Services
Properties
RestaurantMenu

==================================================
46. REPORTE FINAL
==================================================

Entregar:

# ORP PRICING CARD — IMPLEMENTATION REPORT

## Audit

Reviewed:

- OrpCard:
- OrpPrice:
- OrpBadge:
- OrpList:
- OrpListItem:
- OrpStack:
- OrpButton:
- OrpCatalogCard:

Capabilities reused:

ORP gaps:

--------------------------------

## Architecture

Pattern:
OrpPricingCard

Layer:
Pattern / Composition

Purpose:

Difference from OrpCatalogCard:

--------------------------------

## API

Props:

Slots:

Events:

Variants/states:

--------------------------------

## Internal composition

Uses:

OrpCard:
OrpPrice:
OrpBadge:
OrpList:
OrpStack:
Other:

Duplicated primitive CSS:
YES / NO

--------------------------------

## Generic validation

SaaS plan:
PASS / FAIL

Membership:
PASS / FAIL

Package:
PASS / FAIL

License:
PASS / FAIL

Non-monetary value:
PASS / FAIL

--------------------------------

## Playground

Added:
YES / NO

Examples:

States:

--------------------------------

## Accessibility

Semantic structure:
Feature list:
Keyboard:
Focus:
Contrast:
Disabled:
Reduced motion:

PASS / FAIL / NOT VERIFIED

--------------------------------

## Responsive QA

320:
375:
390:
430:
768:
1200:
1440:

--------------------------------

## Tests

Added:

Result:
PASS / FAIL

--------------------------------

## Build

npm run build:

PASS / FAIL

--------------------------------

## Acerca changes

NONE

--------------------------------

## Future dogfooding

Potential candidates only:

- SectionPackages
- pricing/tier interfaces
- memberships
- bundled offers

Do NOT modify them.

--------------------------------

## Final status

READY FOR HUMAN REVIEW

or

NEEDS MORE WORK

STOP.

==================================================
FINAL INSTRUCTION
==================================================

Implementa únicamente:

OrpPricingCard

su estilo necesario,

su integración en el ORP Playground,

tests,

y documentación.

No migres SectionPackages todavía.

Primero queremos validar que PricingCard sea verdaderamente genérica y coherente con OrpCatalogCard.

STOP after OrpPricingCard.