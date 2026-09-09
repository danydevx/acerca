# ORP UI — DIVIDER PRIMITIVE + SURFACE DISCOVERY

## Objetivo

Fortalecer la capa `Primitives / Primary` de ORP UI sin crecerla a ciegas.

Esta fase tiene dos tareas:

1. Auditar e implementar `Divider` si ORP todavía no lo resuelve correctamente.
2. Auditar si realmente hace falta un primitive genérico `Surface`.

`Surface` NO debe crearse automáticamente. Primero debe demostrarse que tiene una responsabilidad distinta de `Card`, `Section` y los Visual Helpers.

Seguir:

```text
DISCOVER → CLASSIFY → REUSE → IMPLEMENT DIVIDER IF NEEDED
→ AUDIT SURFACE → CREATE ONLY IF JUSTIFIED → PLAYGROUND → VERIFY
```

---

# Arquitectura

```text
ORP UI
├── Foundation
│   ├── Tokens
│   ├── Typography
│   ├── Content
│   └── Visual Foundation
├── Primitives / Primary
│   ├── Stack
│   ├── Cluster
│   ├── Grid
│   ├── Section
│   ├── Card
│   ├── Media
│   ├── Avatar
│   ├── Badge
│   ├── Price
│   ├── List
│   ├── Divider      ← revisar/crear
│   └── Surface?     ← discovery, no asumir
├── Components
└── Patterns
```

Dirección de composición:

```text
1. Spacing
2. Alignment
3. Typography
4. Divider
5. Surface
6. Card
```

ORP debe evitar que cualquier necesidad de agrupación termine convertida automáticamente en una Card.

---

# PARTE A — DIVIDER

## 1. Auditoría obligatoria

Antes de escribir código buscar:

- `Divider`
- `.orp-divider`
- `<hr>`
- `border-top`
- `border-bottom`
- separadores mediante pseudo-elementos
- reglas repetidas `1px solid var(...)`
- separadores en List
- separadores en Stack
- separadores dentro de Cards/Patterns
- tokens de border/divider
- implementación de `<hr>` en Typography/Content
- Visual Helpers relacionados con border

No duplicar una solución existente.

## 2. Responsabilidad

Divider significa:

> colocar una separación visual entre regiones.

No debe encargarse de:

- layout
- padding
- grandes márgenes
- contenido
- lógica de negocio
- colores decorativos
- sombras
- backgrounds

## 3. Divider vs Border Helper

No son lo mismo.

```html
<div class="orp-border-bottom">
```

significa:

> este elemento tiene un borde.

Mientras:

```html
<hr class="orp-divider">
```

significa:

> existe una separación entre dos regiones.

Mantener responsabilidades distintas si la auditoría confirma que ambas son útiles.

## 4. Divider vs `<hr>`

Distinguir:

```text
<hr>
→ thematic break dentro de contenido semántico

Divider
→ separación visual dentro de composición UI
```

Si la misma implementación puede servir correctamente a ambos sin confusión, reutilizar.

## 5. CSS vs Vue

Preferir un primitive CSS:

```html
<hr class="orp-divider">
```

o:

```html
<div class="orp-divider"></div>
```

No crear `OrpDivider.vue` simplemente para renderizar un `<div>`.

Vue requiere valor real adicional.

## 6. Orientación

Horizontal debe ser el comportamiento base.

Evaluar `vertical` únicamente si aparece en al menos dos contextos genéricos reales.

Posible API:

```html
<div class="orp-divider orp-divider--vertical"></div>
```

No crearla por completitud.

## 7. Estilo

Usar tokens ORP.

No hardcodear colores.

No crear matrices:

```text
divider-primary
divider-success
divider-danger
divider-dashed
divider-dotted
divider-gradient
divider-1
divider-2
divider-3
```

salvo evidencia extraordinaria.

## 8. Spacing

Divider no debe apropiarse del ritmo vertical.

Regla:

```text
Stack → gap
Divider → separator
```

ONE AXIS → ONE SPACING OWNER.

---

# PARTE B — SURFACE DISCOVERY

## 9. Hipótesis

ORP puede necesitar `Surface` si existe una necesidad repetida de crear un plano visual genérico sin convertirlo en Card.

Ejemplos conceptuales:

- región secundaria
- fondo sutil
- grupo informativo
- región de formulario
- área contextual
- capítulo visual
- área de herramientas
- contenedor de mapa
- región que contiene varias Cards

## 10. Definiciones

### Surface

```text
"This region has a visual plane."
```

### Card

```text
"This is a discrete content object/entity."
```

### Section

```text
"This is a chapter/region in the page structure."
```

### Helper

```text
"Modify one focused visual characteristic."
```

Estas responsabilidades NO deben mezclarse.

## 11. Auditar `.orp-card`

Documentar exactamente qué controla Card:

- background
- border
- radius
- padding
- shadow
- interactive states
- media
- header/body/footer
- variants

Buscar usos donde `.orp-card` se utilice únicamente porque alguien necesitaba:

```text
background
background + padding
border + radius
muted region
```

Eso es evidencia potencial de Surface.

## 12. Buscar paneles locales

Buscar en ORP y, read-only, en Acerca:

```text
.panel
.box
.region
.surface
.wrapper--muted
.section-box
.content-panel
.info-panel
```

y equivalentes.

Identificar combinaciones repetidas de:

```text
background
border
radius
padding
```

No modificar Acerca.

## 13. Acceptance Test

Crear Surface solo si casi todas son verdaderas:

1. Es completamente genérico.
2. Aparece en 2+ contextos distintos.
3. Tiene responsabilidad distinta de Card.
4. Tiene responsabilidad distinta de Section.
5. Tiene responsabilidad distinta de Helpers.
6. Reduce CSS local repetido.
7. Tiene API pequeña y estable.
8. Mejora el lenguaje de composición de ORP.
9. No se convierte en `Card Lite`.

Resultado válido:

```text
SURFACE PRIMITIVE NOT JUSTIFIED
```

## 14. Implementación

Si se justifica, preferir:

```html
<div class="orp-surface">
```

sobre:

```vue
<OrpSurface>
```

No crear wrapper Vue sin comportamiento real.

## 15. Surface no debe copiar Card

NO agregar automáticamente:

```text
__header
__body
__footer
__media
interactive
selected
clickable
```

Eso recrearía Card.

## 16. Variantes

Mantenerlas mínimas.

Posibles candidatos, solo con evidencia:

```text
default
subtle
muted
```

`raised` únicamente si existe una razón real de elevación.

NO:

```text
primary
success
warning
danger
info
purple
green
blue
```

Los colores semánticos pertenecen a componentes de estado.

## 17. Padding

Decidir explícitamente si Surface:

A. solo controla el plano visual;

o:

B. incluye un inset estándar porque los casos reales lo requieren.

No copiar automáticamente el padding de Card.

## 18. Border / Radius / Shadow

Usar Foundation tokens.

Surface debería tender a ser flat.

No convertirla en:

```text
background + border + huge radius + shadow
```

porque volveríamos al aspecto Bootstrap/SaaS-card-heavy.

La jerarquía visual sigue siendo:

```text
Whitespace
→ Divider
→ Surface
→ Card
→ Elevation cuando existe una razón
```

## 19. Composición

Surface debe poder componerse limpiamente con:

```html
<div class="orp-surface">
    <div class="orp-stack">
        ...
    </div>
</div>
```

y:

```html
<div class="orp-surface">
    <div class="orp-grid">
        ...
    </div>
</div>
```

y potencialmente:

```html
<div class="orp-surface">
    <div class="orp-stack">
        <div>...</div>
        <hr class="orp-divider">
        <div>...</div>
    </div>
</div>
```

Cada primitive conserva una sola responsabilidad.

## 20. Surface + Card

Debe ser válido:

```text
Surface
└── Grid
    ├── Card
    ├── Card
    └── Card
```

Esto permite construir capítulos visuales sin que el capítulo mismo sea otra Card.

## 21. Evitar nesting excesivo

Si el diseño produce:

```text
Surface
└── Surface
    └── Surface
        └── Card
```

revisar arquitectura.

---

# DISCOVERY MATRIX

Antes de implementar crear:

| Concept | Existing solution | Files | Contexts | Problem | Layer | Decision |
|---|---|---|---:|---|---|---|
| Horizontal separator | ? | ? | ? | ? | Primitive | ? |
| Vertical separator | ? | ? | ? | ? | Primitive | ? |
| Thematic HR | ? | ? | ? | ? | Content | ? |
| Subtle visual plane | ? | ? | ? | ? | Surface? | ? |
| Muted visual plane | ? | ? | ? | ? | Surface? | ? |
| Raised region | ? | ? | ? | ? | Surface/Card? | ? |
| Card used as panel | ? | ? | ? | ? | Surface? | ? |

Usar:

```text
REUSE
EXTEND
CREATE
KEEP LOCAL
DEFER
REJECT
```

---

# PLAYGROUND

## Divider

Si se implementa mostrar:

- horizontal
- dentro de Stack
- separación de grupos
- vertical únicamente si está soportado

## Surface

SOLO si se justifica.

Mostrar:

- subtle region
- grouped content
- Surface + Stack
- Surface + Grid
- Surface + Divider
- Surface conteniendo Cards

## Comparación obligatoria

Si Surface existe, crear una demo:

```text
PLAIN
SURFACE
CARD
```

con contenido equivalente.

Debe quedar visual y conceptualmente claro cuándo utilizar cada uno.

Si la diferencia no puede explicarse claramente:

Surface todavía no está listo.

---

# VISUAL DIRECTION

Mantener:

- modern 2026
- mobile-first
- calm
- restrained
- hierarchy before decoration
- whitespace before borders
- borders before surfaces
- surfaces before cards
- low visual noise
- no Bootstrap visual DNA
- no giant SaaS radius
- shadows only for meaningful elevation
- token-driven styling

Preguntar:

> ¿Esto podría confundirse con `.card bg-light shadow-sm` de Bootstrap?

Si la respuesta es sí, revisar la solución.

---

# ACCESSIBILITY

Divider:

- diferenciar decorative vs semantic
- no generar ruido innecesario para lectores de pantalla

Surface:

- no agregar `role="region"` automáticamente
- no inventar landmark semantics
- el consumidor decide el HTML semántico
- controles internos deben conservar focus visible

Verificar que radius/overflow no recorten focus rings.

---

# RESPONSIVE QA

Probar:

```text
320
375
390
430
768
1200
1440
```

Especialmente:

- Divider visibility
- contrast
- vertical divider si existe
- Surface padding
- viewport gutter + Surface inset
- Cards dentro de Surface
- long Spanish content
- focus rings
- horizontal page overflow

Mobile first.

---

# TOKENS

Usar exclusivamente el Foundation aprobado para:

- border
- surface
- radius
- spacing
- elevation
- text

No crear un sistema paralelo.

No hardcodear colores, sombras, radius o spacing si ya existe token ORP.

---

# VISUAL HELPERS RELATIONSHIP

Si Visual Helpers ya existe, reutilizar sus tokens/decisiones.

Pero NO construir templates como utility soup:

```html
<div class="orp-border orp-rounded-lg orp-shadow-sm ...">
```

Si una combinación repetida representa un concepto estable, debe evaluarse arquitectónicamente.

---

# SCOPE RESTRICTIONS

NO:

- modificar Acerca
- migrar Minisite
- tocar backend
- crear nuevos Card Patterns
- resucitar ActionCard
- expandir Map
- crear Container todavía
- crear Skeleton
- crear Progress
- crear Status
- construir utility framework
- iniciar automáticamente Visual Direction Audit

Acerca puede inspeccionarse read-only como evidencia.

---

# DEFERRED CANDIDATES

Durante la auditoría se puede detectar evidencia para:

```text
Container
Media improvements
Skeleton
Progress / Meter
Status
```

Solo documentar.

NO implementarlos.

---

# TESTS & BUILD

Ejecutar tests existentes.

No crear tests Vue inútiles para CSS puro.

Ejecutar:

```bash
npm run build
```

Debe pasar.

Si existe browser tooling, realizar verificación visual real del Playground.

No declarar QA visual basándose solo en lectura de LESS.

---

# REQUIRED REPORT

Generar:

```text
ORP-DIVIDER-SURFACE-DISCOVERY-REPORT.md
```

Estructura:

```text
# ORP Divider + Surface Discovery Report

## Executive Summary
## Existing Primitive Inventory
## Discovery Matrix

## Divider Audit
### Existing solutions
### Repeated separator patterns
### Divider vs Border Helper
### Divider vs HR
### Decision
### API implemented
### Rejected variants

## Surface Discovery
### Existing Card responsibility
### Existing Section responsibility
### Existing visual planes
### Card misuse / overuse evidence
### Local panel/surface patterns
### Surface vs Card
### Surface vs Section
### Surface vs Helpers
### Acceptance test
### Decision

## Surface API
Only if created.

## Surface Rejection
If not created.

## Token Usage
## Hardcoded Values
## Playground
## Accessibility
## Responsive QA
## Tests
## Build
## Files Created
## Files Modified
## Deferred Primitive Candidates
## Final Primitive Architecture
## Next Recommended Primitive
```

---

# REQUIRED VERDICTS

Divider:

```text
DIVIDER CREATED
```

or:

```text
DIVIDER EXTENDED
```

or:

```text
DIVIDER ALREADY ADEQUATE
```

Surface:

```text
SURFACE PRIMITIVE JUSTIFIED
```

or:

```text
SURFACE PRIMITIVE NOT JUSTIFIED
```

---

# NEXT PRIMITIVE

Después de esta fase, evaluar especialmente:

```text
Container
```

como siguiente Primary Primitive.

NO crearlo automáticamente.

La recomendación final debe basarse en evidencia encontrada en el repositorio.

---

# STOP CONDITION

STOP después de:

1. auditar repositorio
2. crear Discovery Matrix
3. decidir/implementar Divider
4. realizar Surface Discovery
5. implementar Surface SOLO si está justificado
6. actualizar Playground
7. QA responsive
8. QA accessibility
9. tests
10. `npm run build`
11. generar reporte
12. recomendar siguiente primitive

No continuar automáticamente.

---

# FINAL INSTRUCTION

Strengthen ORP's Primary Primitive layer without growing it blindly.

Audit first.

Divider should remain a small separator primitive.

Surface must only exist if the repository demonstrates a repeated need for a generic visual plane distinct from Card, Section and Visual Helpers.

The desired ORP composition vocabulary is:

```text
Spacing
→ Alignment
→ Typography
→ Divider
→ Surface
→ Card
```

not:

```text
Everything
→ Card
```

Keep the implementation generic, token-driven, mobile-first, visually restrained and clearly different from Bootstrap.

