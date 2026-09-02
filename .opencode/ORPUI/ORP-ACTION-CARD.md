# ORP UI — GENERIC COMPOSITION PATTERNS
# EIGHTH PATTERN: OrpActionCard
# FINAL PATTERN OF THE FIRST CARD FAMILY
# + ARCHITECTURAL DISCOVERY PASS

Continuamos el roadmap de ORP UI.

Estado actual reportado:

1. OrpCatalogCard
2. OrpPricingCard
3. OrpProfileCard
4. Grid — Primitive / Primary
5. OrpContentCard
6. OrpStatCard
7. OrpMap + OrpMapMarker
8. Information Component Discovery
9. OrpContactCard
10. OrpActionCard ← IMPLEMENTAR AHORA

OrpContactCard ya fue implementado con:

- slots: title, subtitle, details, map, meta, actions
- variante horizontal
- composición con Card / Stack / Grid
- demos en Playground
- build correcto

OrpActionCard será el último Pattern de esta primera familia de Cards.

Después de esta fase NO continuar automáticamente creando más Cards.

El siguiente paso será un:

ORP GLOBAL ARCHITECTURE AUDIT

para detectar primitives/components/patterns realmente faltantes antes de ampliar el framework.

Regla permanente:

DISCOVER → EXTRACT → REUSE → COMPOSE

==================================================
1. OBJETIVO PRINCIPAL
==================================================

Crear:

OrpActionCard.vue

como Pattern genérico para presentar:

- una acción principal
- una decisión
- un siguiente paso
- un acceso rápido
- una invitación
- una tarea
- una recomendación accionable

Debe poder utilizarse para:

- onboarding
- quick actions
- shortcuts
- setup steps
- upgrade prompts
- configuration prompts
- empty-state follow-ups
- dashboard actions
- workflow actions
- account actions
- next-step cards
- calls to action

SIN conocer el dominio.

NO crear:

UpgradeCard
OnboardingCard
SetupCard
DashboardActionCard
PaymentActionCard
CreateAccountCard
AddProductCard
QuickLinkCard

==================================================
2. DEFINICIÓN
==================================================

OrpActionCard representa:

"Una acción o siguiente paso claramente identificable, acompañado opcionalmente de contexto, iconografía, estado y acciones secundarias."

Ejemplo conceptual:

┌──────────────────────────────┐
│ [ICON]                       │
│                              │
│ Completa tu perfil           │
│ Agrega información para      │
│ mejorar tu presencia.        │
│                              │
│ [Completar perfil]           │
└──────────────────────────────┘

Otro ejemplo:

┌──────────────────────────────┐
│ Importar contenido           │
│                              │
│ Puedes importar información  │
│ desde otra fuente.           │
│                              │
│ [Importar]   [Más tarde]     │
└──────────────────────────────┘

==================================================
3. DIFERENCIA CON Card
==================================================

OrpCard:

→ superficie genérica.

OrpActionCard:

→ composición con intención accionable.

No usar ActionCard simplemente porque una Card contiene un botón.

Debe existir una acción/siguiente paso como propósito central.

==================================================
4. DIFERENCIA CON CatalogCard
==================================================

CatalogCard:

"What is this item?"

ActionCard:

"What can/should I do next?"

==================================================
5. DIFERENCIA CON PricingCard
==================================================

PricingCard:

"What option/value proposition should I choose?"

ActionCard:

"What action can I take?"

Una PricingCard puede tener CTA.

Eso NO la convierte en ActionCard.

==================================================
6. DIFERENCIA CON ContentCard
==================================================

ContentCard:

"What is this content about?"

ActionCard:

"What should/can I do?"

==================================================
7. DIFERENCIA CON ContactCard
==================================================

ContactCard:

"How do I find/contact this entity?"

ActionCard:

"What is the next action?"

==================================================
8. ARQUITECTURA
==================================================

ORP UI
│
├── Foundation
│
├── Primitives / Primary
│
├── Components
│   ├── Map
│   └── ...
│
└── Patterns
    ├── OrpCatalogCard
    ├── OrpPricingCard
    ├── OrpProfileCard
    ├── OrpContentCard
    ├── OrpStatCard
    ├── OrpContactCard
    └── OrpActionCard       ← AHORA

ActionCard debe COMPONER ORP existente.

==================================================
9. AUDIT OBLIGATORIO
==================================================

ANTES de implementar:

auditar físicamente:

- OrpCard
- Stack
- Cluster
- Grid
- Badge / Status
- Button
- IconButton
- Empty
- Alert si existe
- Progress si existe
- information primitive si existe
- CatalogCard
- PricingCard
- ProfileCard
- ContentCard
- StatCard
- ContactCard

Revisar:

- slots
- props
- events
- variants
- CSS
- tokens
- Playground
- tests

NO asumir APIs.

==================================================
10. AUDIT DE ACTION UI EXISTENTE
==================================================

Buscar dentro de ORP y, como evidencia secundaria read-only, Acerca:

- CTA cards
- onboarding prompts
- setup prompts
- empty states
- dashboard shortcuts
- action panels
- upgrade prompts
- create-new cards
- quick actions
- incomplete-state prompts
- dismissible prompts
- icon + title + description + button
- title + description + actions

NO modificar Acerca.

==================================================
11. REPEATED UI INVENTORY
==================================================

Documentar:

CONCEPT:
SEEN IN:
EXISTING ORP SOLUTION:
DOMAIN SPECIFIC:
EXTRACTION CANDIDATE:
DECISION:
REASON:

Prestar atención a:

- ActionGroup
- icon container
- status
- progress
- dismiss action
- primary/secondary action composition
- full-card interaction
- Empty-state overlap

==================================================
12. ACTIONCARD VS EMPTY STATE
==================================================

ORP ya tiene `.orp-empty` o equivalente.

Auditar cuidadosamente el solapamiento.

Empty State:

→ comunica ausencia de contenido/datos.

Action Card:

→ comunica una acción disponible o siguiente paso.

Ejemplo:

"No tienes proyectos. Crear proyecto."
→ Empty State

"Configura las notificaciones."
→ ActionCard

No duplicar Empty State dentro de ActionCard.

==================================================
13. ACTIONCARD VS ALERT
==================================================

Si existe Alert:

Alert:

→ comunica estado/mensaje que requiere atención.

ActionCard:

→ presenta una acción o tarea como unidad visual.

Ejemplo:

"Tu pago falló."
→ Alert

"Configura un método de pago."
→ ActionCard

No fusionar responsabilidades.

==================================================
14. ACTIONCARD VS QUICK ACTION
==================================================

Evaluar si existe una diferencia entre:

ActionCard completa

y

un simple shortcut/button.

Ejemplo:

[+] Crear

probablemente NO necesita ActionCard.

Evitar usar una Card para acciones que deberían ser botones.

==================================================
15. ANATOMÍA
==================================================

Anatomía conceptual:

┌──────────────────────────────┐
│ ICON / VISUAL                │
│                              │
│ EYEBROW / STATUS             │
│                              │
│ TITLE                        │
│ DESCRIPTION                  │
│                              │
│ META / PROGRESS              │
│                              │
│ ACTIONS                      │
└──────────────────────────────┘

Todas las regiones deben ser opcionales según composición real.

==================================================
16. API SLOT-FIRST
==================================================

Dirección conceptual:

<OrpActionCard>

    <template #icon>
        ...
    </template>

    <template #eyebrow>
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

    <template #actions>
        ...
    </template>

</OrpActionCard>

Revisar naming de Patterns existentes.

No crear convenciones nuevas innecesarias.

==================================================
17. ACTION ES EL PROPÓSITO, NO UN PROP
==================================================

NO diseñar:

actionLabel
actionUrl
secondaryActionLabel
secondaryActionUrl
onAction

como API rígida si slots + Button/Link existentes resuelven mejor.

El consumidor debe poder componer:

OrpButton
anchor
IconButton
router/inertia link
custom action

==================================================
18. NO DOMAIN PROPS
==================================================

PROHIBIDO:

upgrade
completeProfile
setupPayment
createProject
verifyEmail
connectAccount
importData
addLocation

La card no sabe qué acción representa.

==================================================
19. ICON / VISUAL
==================================================

Debe aceptar:

- icon
- SVG
- illustration
- custom visual
- ningún visual

No mapear acciones a iconos internamente.

==================================================
20. ICON CONTAINER
==================================================

Auditar si ORP ya tiene una solución para:

icon dentro de superficie redondeada.

Si existe:

REUSE.

Si no existe pero aparece repetidamente en múltiples Patterns:

documentar candidato.

NO crear automáticamente.

==================================================
21. TITLE
==================================================

Debe ser claro y dominante.

No hardcodear heading level incorrecto.

Seguir estrategia semántica de otros Patterns.

==================================================
22. DESCRIPTION
==================================================

Explica:

- por qué realizar la acción
- qué ocurrirá
- qué falta
- qué beneficio existe

Pero ActionCard no interpreta el texto.

Debe soportar varias líneas.

==================================================
23. EYEBROW / STATUS
==================================================

Puede contener:

Recomendado
Pendiente
Nuevo
Opcional
Paso 2

Usar Badge/Status existente.

No crear:

status="pending"

como business logic salvo que exista una API genérica ORP ya establecida.

==================================================
24. META
==================================================

Puede contener contexto secundario:

2 minutos
3 pasos restantes
Última actualización...
Requiere permisos

Usar primitives existentes.

No interpretar esos datos.

==================================================
25. PROGRESS
==================================================

ActionCard puede contener progreso.

Ejemplo:

Perfil 70% completo

Pero NO implementar Progress dentro de ActionCard.

Si ORP ya tiene Progress:

REUSE mediante slot.

Si no existe:

no crearlo únicamente para decorar el demo.

Documentar candidato si existe evidencia real.

==================================================
26. ACTIONS
==================================================

Debe soportar:

- una acción primaria
- primaria + secundaria
- icon action
- custom action
- ninguna acción explícita si toda la card es interactiva y eso fue justificado

No imponer número fijo de acciones.

==================================================
27. PRIMARY ACTION
==================================================

Ejemplo:

[Continuar]

El consumidor decide:

- label
- href
- handler
- disabled
- loading
- navigation

ActionCard solamente compone.

==================================================
28. SECONDARY ACTION
==================================================

Ejemplo:

[Ahora no]

No crear estilo nuevo si OrpButton ghost/secondary ya existe.

==================================================
29. DISMISS
==================================================

Algunos prompts son dismissible.

NO implementar dismiss state automáticamente.

Si se necesita:

el consumidor puede colocar IconButton en una región apropiada.

ActionCard no debe mantener:

dismissed=true

ni persistencia.

==================================================
30. FULL CARD CLICKABLE
==================================================

Evaluar cuidadosamente.

Algunas ActionCards podrían funcionar como shortcut completo.

Pero si existen botones internos:

NO crear nested interactions.

Reutilizar estrategia de Card/CatalogCard/ContentCard si existe.

No inventar una tercera solución.

==================================================
31. INTERACTIVE SEMANTICS
==================================================

No convertir `<div>` en botón mediante:

@click
tabindex="0"

si puede usarse semántica nativa.

Si existe whole-card interaction:

debe ser accesible por teclado.

==================================================
32. LOADING
==================================================

ActionCard no administra loading global.

El botón/acción puede usar su propia API de loading si ORP la tiene.

No crear:

loading

en ActionCard salvo evidencia estructural real.

==================================================
33. DISABLED
==================================================

No deshabilitar toda la Card arbitrariamente.

Si una acción está disabled:

usar API del componente de acción.

Solo crear card-level disabled si existe una necesidad genérica demostrada.

==================================================
34. VARIANTES
==================================================

Mantener variantes mínimas.

NO crear:

upgrade
onboarding
setup
dangerAction
successAction
payment

Evaluar únicamente variantes estructurales:

default
horizontal
compact

solo si existe evidencia.

==================================================
35. HORIZONTAL
==================================================

Si ContactCard ya estableció una convención horizontal:

auditar si puede reutilizarse conceptualmente.

Ejemplo:

┌──────┬──────────────────────────┬───────────┐
│ ICON │ TITLE + DESCRIPTION      │ ACTION    │
└──────┴──────────────────────────┴───────────┘

Solo implementar si resulta útil y responsive.

==================================================
36. MOBILE FIRST
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

En móvil:

- acciones pueden apilarse
- textos deben envolver
- visual no debe dominar
- touch targets correctos
- no overflow

==================================================
37. BUTTON LAYOUT
==================================================

Usar Stack/Cluster.

No crear manualmente:

display:flex
gap
flex-wrap

si Cluster resuelve las acciones.

==================================================
38. CARD
==================================================

Componer OrpCard.

No duplicar:

surface
radius
border
shadow
interactive states

==================================================
39. STACK
==================================================

Usar Stack para jerarquía vertical.

No recrear vertical rhythm local genérico.

==================================================
40. CLUSTER
==================================================

Usar Cluster para:

- actions
- meta
- status
- compact header

==================================================
41. GRID
==================================================

Usar Grid para colecciones de ActionCards.

No crear:

.action-card-grid {
    display:grid;
}

==================================================
42. CSS
==================================================

CSS específico debe limitarse a composición/hierarchy.

Conceptualmente:

.orp-action-card
.orp-action-card__visual
.orp-action-card__eyebrow
.orp-action-card__body
.orp-action-card__title
.orp-action-card__description
.orp-action-card__meta
.orp-action-card__actions

Seguir convenciones reales.

==================================================
43. TOKENS
==================================================

Usar exclusivamente tokens ORP disponibles para:

- spacing
- typography
- color
- radius
- borders
- shadows
- transitions

No hardcodear valores si existe token.

==================================================
44. NO SPECIAL CTA COLOR
==================================================

No crear colores exclusivos de ActionCard.

Las acciones deben usar variants existentes de Button/Badge/Card.

No crear:

orp-btn--action
orp-btn--upgrade

==================================================
45. ACCESSIBILITY
==================================================

Auditar:

- heading semantics
- button/link semantics
- keyboard
- focus-visible
- icon-only actions
- disabled actions
- color independence
- reading order
- touch targets
- reduced motion

==================================================
46. ACTION LABELS
==================================================

Los demos deben usar acciones con propósito comprensible.

Evitar múltiples botones llamados únicamente:

"Click"
"Go"
"Open"

pero el Pattern no debe imponer copy.

==================================================
47. PLAYGROUND
==================================================

Agregar:

Patterns → Action Card

al Playground existente.

No crear página separada.

==================================================
48. PLAYGROUND — BASIC
==================================================

Ejemplo:

Completa tu perfil

Agrega la información necesaria para terminar la configuración.

[Continuar]

==================================================
49. PLAYGROUND — ICON
==================================================

Ejemplo con:

icon
title
description
action

No crear icon mapping.

==================================================
50. PLAYGROUND — PRIMARY + SECONDARY
==================================================

Ejemplo:

Importar contenido

[Importar] [Más tarde]

Demostrar composición con botones ORP existentes.

==================================================
51. PLAYGROUND — STATUS
==================================================

Ejemplo:

Pendiente

Configura las notificaciones

[Configurar]

Usar Badge/Status existente.

==================================================
52. PLAYGROUND — META / PROGRESS
==================================================

Si ORP ya tiene Progress:

mostrar un ejemplo.

Si NO:

usar meta simple.

NO crear Progress solo para este demo.

==================================================
53. PLAYGROUND — NO EXPLICIT BUTTON
==================================================

Solo si whole-card interaction está soportada correctamente.

Demostrar shortcut card.

Si no existe estrategia segura:

NO crear este ejemplo.

==================================================
54. PLAYGROUND — LONG CONTENT
==================================================

Probar:

- title largo
- description larga
- meta
- dos acciones
- icon

==================================================
55. PLAYGROUND — COLLECTION
==================================================

Mostrar varias ActionCards usando ORP Grid.

Ejemplos conceptuales:

Configurar perfil
Importar contenido
Agregar integración
Revisar configuración

El dominio de los demos no debe entrar en la API.

==================================================
56. PLAYGROUND — MOBILE ACTIONS
==================================================

Verificar específicamente:

375px

con dos acciones de labels largos.

No deben provocar overflow.

==================================================
57. EMPTY STATE COMPARISON
==================================================

Agregar en documentación o Playground una comparación breve:

Empty:
No existen elementos.

ActionCard:
Hay un siguiente paso disponible.

No duplicar estilos completos para esta comparación.

==================================================
58. CROSS-PATTERN CONSISTENCY
==================================================

Comparar visualmente con:

CatalogCard
PricingCard
ProfileCard
ContentCard
StatCard
ContactCard

ActionCard debe sentirse parte de la misma familia ORP.

No debe parecer un sistema visual nuevo.

==================================================
59. DISCOVERY PASS
==================================================

Durante implementación revisar posibles piezas repetidas:

- ActionGroup
- Icon container
- Progress
- Status
- dismiss control

Pero el umbral para nuevas abstracciones debe ser ALTO.

Ya existe suficiente ORP para componer la mayoría.

==================================================
60. ACTIONGROUP
==================================================

No crear OrpActionGroup si:

Cluster ya resuelve correctamente el problema.

Solo justificarlo si aporta:

- semantics
- responsive action ordering
- alignment contract
- accessibility
- behavior

más allá de un wrapper flex.

==================================================
61. TESTS
==================================================

Agregar tests según infraestructura existente:

- render
- slots
- optional regions
- actions
- status/meta
- variant si existe
- interactive strategy si existe
- accessibility básica

No introducir framework nuevo.

==================================================
62. BROWSER QA
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

- title
- description
- icon
- status
- meta
- actions
- multiple buttons
- Grid collection
- long content
- focus
- keyboard
- overflow

==================================================
63. CONSOLE QA
==================================================

No aceptar:

Vue warnings
nested interactive warnings
console errors
missing icon/assets
layout overflow

==================================================
64. BUILD
==================================================

Ejecutar:

npm run build

y tests ORP.

Debe pasar.

==================================================
65. DOCUMENTACIÓN
==================================================

Documentar:

PURPOSE

Represent a clearly actionable next step, task, prompt or shortcut.

USE FOR

- onboarding
- setup
- quick actions
- workflow next steps
- dashboard prompts
- configuration prompts
- actionable recommendations

DO NOT USE FOR

generic surfaces
→ OrpCard

empty data
→ Empty State

alerts/status messages
→ Alert

catalog entities
→ OrpCatalogCard

pricing
→ OrpPricingCard

profiles
→ OrpProfileCard

editorial content
→ OrpContentCard

metrics
→ OrpStatCard

contact/location
→ OrpContactCard

==================================================
66. NO ACERCA DOGFOODING
==================================================

NO modificar todavía:

Minisite
Dashboard
Analytics
vCards
SectionServices
SectionProducts
SectionLocations
Hero
Footer

Solo ORP + Playground.

==================================================
67. NO BUSINESS LOGIC
==================================================

No modificar:

Controllers
Routes
Models
Database
API
Inertia payloads

No implementar:

completion tracking
dismiss persistence
onboarding state
permissions
upgrade logic

==================================================
68. CRITERIO DE ÉXITO — GENERICIDAD
==================================================

El mismo OrpActionCard debe poder representar:

- onboarding step
- setup prompt
- quick action
- configuration task
- actionable recommendation

sin conocer esos dominios.

==================================================
69. CRITERIO DE ÉXITO — PURPOSE
==================================================

Debe existir una diferencia clara entre:

OrpCard
y
OrpActionCard.

Si ActionCard termina siendo solamente:

OrpCard + title + button

sin aportar una composición reusable y consistente:

revisar si realmente está justificada.

NO crear Pattern por cumplir roadmap.

==================================================
70. CRITERIO DE ABORT
==================================================

IMPORTANTE:

Si después del audit se demuestra que:

Card + Stack + Cluster + Button

ya resuelven ActionCard de manera limpia, consistente y sin duplicación significativa:

NO crear OrpActionCard.

Documentar:

ACTION CARD PATTERN NOT JUSTIFIED

y explicar por qué.

El roadmap no obliga a crear abstracciones innecesarias.

==================================================
71. PRIMERA FAMILIA DE PATTERNS
==================================================

Si ActionCard sí se justifica, esta fase cierra la primera familia:

Catalog
Pricing
Profile
Content
Stat
Contact
Action

NO agregar más Card Patterns automáticamente.

==================================================
72. SIGUIENTE FASE
==================================================

Después de esta implementación:

STOP.

El siguiente trabajo será:

ORP GLOBAL ARCHITECTURE AUDIT

Ese audit deberá revisar el framework completo antes de decidir nuevos primitives/components/patterns.

NO realizar ese audit completo dentro de este prompt.

==================================================
73. REPORTE FINAL
==================================================

Entregar:

# ORP ACTION CARD — IMPLEMENTATION REPORT

## Existing ORP Audit

Reviewed:

- Card
- Stack
- Cluster
- Grid
- Button
- IconButton
- Badge/Status
- Empty
- Alert
- Progress
- CatalogCard
- PricingCard
- ProfileCard
- ContentCard
- StatCard
- ContactCard

## Existing Action UI Audit

Repeated structures:

Existing solutions:

Duplication found:

## Pattern Justification

Is OrpActionCard justified:
YES / NO

Why:

If NO:

ACTION CARD PATTERN NOT JUSTIFIED

Explain existing composition to use.

STOP implementation.

## Repeated UI Inventory

Concept:
Seen in:
Existing ORP solution:
Extraction candidate:
Decision:
Reason:

## OrpActionCard Architecture

Layer:
Pattern

Purpose:

Difference from OrpCard:

Difference from Empty:

Difference from Alert:

Internal composition:

## API

Props:
Slots:
Events:
Variants:
Interactive strategy:

## Generic Validation

Onboarding:
PASS / FAIL

Setup:
PASS / FAIL

Quick action:
PASS / FAIL

Primary + secondary:
PASS / FAIL

Status:
PASS / FAIL

Long content:
PASS / FAIL

## ORP Primitive Reuse

Card:
YES / NO

Stack:
YES / NO

Cluster:
YES / NO

Grid:
YES / NO

Button:
YES / NO

IconButton:
YES / NO

Badge/Status:
YES / NO / N/A

Progress:
YES / NO / N/A

## New Abstractions Created

NONE

or:

Name:
Layer:
Evidence:
API:
Playground:
Tests:

## Abstractions Rejected

Candidate:
Reason:

## CSS Duplication

Generic flex duplicated:
YES / NO

Generic grid duplicated:
YES / NO

Button styles duplicated:
YES / NO

Card surface duplicated:
YES / NO

## Accessibility

Heading:
Buttons:
Links:
Keyboard:
Focus:
Icon actions:
Touch:
Color independence:
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

Basic:
YES / NO

Icon:
YES / NO

Primary + secondary:
YES / NO

Status:
YES / NO

Meta/progress:
YES / NO

Long content:
YES / NO

Grid collection:
YES / NO

## Tests

ActionCard:
PASS / FAIL / NOT CREATED

## Build

npm run build:

PASS / FAIL

## Acerca Changes

NONE

## Business Logic Changes

NONE

## First Pattern Family Status

CatalogCard:
DONE

PricingCard:
DONE

ProfileCard:
DONE

ContentCard:
DONE

StatCard:
DONE

ContactCard:
DONE

ActionCard:
DONE / NOT JUSTIFIED

## Next Recommended Phase

ORP GLOBAL ARCHITECTURE AUDIT

Do NOT start it automatically.

## Final Status

READY FOR GLOBAL AUDIT

or

NEEDS MORE WORK

STOP.

==================================================
FINAL INSTRUCTION
==================================================

1. Audita primero si OrpActionCard realmente está justificada.
2. No la implementes solo porque aparece en el roadmap.
3. Compara especialmente contra Card + Stack + Cluster + Button, Empty y Alert.
4. Si no aporta una composición reusable clara, documenta NOT JUSTIFIED y STOP.
5. Si sí está justificada, crea OrpActionCard como Pattern genérico.
6. Usa slots y primitives ORP existentes.
7. No introduzcas props de dominio.
8. No dupliques Button, Card, Stack, Cluster, Status o Progress.
9. Agrega demos al Playground.
10. Usa ORP Grid para colecciones.
11. Ejecuta tests y browser QA.
12. Ejecuta npm run build.
13. No migres Acerca.
14. No agregues business logic.
15. No crees más Card Patterns después de esta fase.
16. STOP.
17. El siguiente paso será un ORP GLOBAL ARCHITECTURE AUDIT independiente.

