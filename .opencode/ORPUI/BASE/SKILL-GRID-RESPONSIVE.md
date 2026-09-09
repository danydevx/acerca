# SKILL — ORP UI / Parte 12: Grid & Responsive Layout

## Objetivo

Extender ORP UI con primitives modernas para construir layouts responsive utilizando:

```text
CSS Grid
Flexbox
minmax()
auto-fit
auto-fill
logical properties
container queries cuando aporten valor
```

sin recrear el sistema Grid de Bootstrap.

Implementar:

```text
Responsive Layout
├── Grid
├── Grid Item
├── Auto Grid
├── Responsive Columns
├── Split Layout
├── Sidebar Layout
├── Reel / Horizontal Layout integration
├── Container Queries
└── Responsive visibility review
```

La filosofía debe ser:

```text
content-driven layout
>
device-specific columns
```

---

# 1. Principio principal

ORP UI NO debe construir un sistema como:

```text
orp-col-12
orp-col-md-6
orp-col-lg-4
orp-col-xl-3
```

Eso produciría otra utility API demasiado grande.

Preferir:

```text
orp-grid
orp-grid--2
orp-grid--3
orp-grid--4
orp-grid--auto
```

junto con primitives modernas basadas en CSS Grid.

---

# 2. Namespace

Mantener siempre:

```text
orp-
```

LESS:

```text
@orp-
```

CSS Custom Properties:

```text
--orp-
```

Vue:

```text
Orp*
```

Esta fase debe ser casi completamente:

```text
HTML + LESS/CSS
```

No crear Vue components salvo necesidad real.

---

# 3. Architecture

Agregar layout primitives en:

```text
less/
└── layout/
    ├── grid.less
    ├── split.less
    ├── sidebar-layout.less
    └── container-query.less
```

Adaptar a estructura existente si ya existe otra convención.

---

# 4. ORP Grid

Crear:

```text
orp-grid
```

Base:

```less
.orp-grid {
    display: grid;
    gap: var(--orp-grid-gap, var(--orp-space-4));
}
```

El gap debe poder modificarse sin generar decenas de clases.

---

# 5. Grid gap

Permitir variable local:

```text
--orp-grid-gap
```

Ejemplo:

```html
<div
    class="orp-grid"
    style="--orp-grid-gap: var(--orp-space-5)"
>
```

También puede integrarse con:

```text
orp-gap-*
```

si las utilities ya funcionan correctamente con Grid.

No duplicar innecesariamente.

---

# 6. Explicit columns

Crear un conjunto pequeño:

```text
orp-grid--2
orp-grid--3
orp-grid--4
```

Ejemplo:

```less
.orp-grid--2 {
    grid-template-columns: repeat(2, minmax(0, 1fr));
}

.orp-grid--3 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
}

.orp-grid--4 {
    grid-template-columns: repeat(4, minmax(0, 1fr));
}
```

No crear automáticamente:

```text
--5
--6
--7
--8
--9
--10
--11
--12
```

---

# 7. Mobile-first explicit grids

Las variantes de columnas NO deben obligatoriamente aplicarse desde mobile.

Por defecto:

```text
orp-grid
```

debe funcionar como:

```text
1 columna
```

Ejemplo:

```less
.orp-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr);
}
```

---

# 8. Responsive explicit grid

Si se necesitan clases responsive, mantener API pequeña.

Ejemplo posible:

```text
orp-grid--md-2
orp-grid--lg-3
orp-grid--xl-4
```

Pero implementar SOLO si existe necesidad clara.

Antes evaluar Auto Grid.

---

# 9. Preferred strategy

Siempre preferir primero:

```text
orp-grid--auto
```

antes de crear clases breakpoint-specific.

---

# 10. Auto Grid

Crear:

```text
orp-grid--auto
```

Basado en:

```css
repeat(auto-fit, minmax(...))
```

Ejemplo:

```less
.orp-grid--auto {
    grid-template-columns:
        repeat(
            auto-fit,
            minmax(
                min(
                    100%,
                    var(--orp-grid-min, 16rem)
                ),
                1fr
            )
        );
}
```

---

# 11. Auto Grid minimum

Variable:

```text
--orp-grid-min
```

Ejemplo:

```html
<div
    class="
        orp-grid
        orp-grid--auto
    "
    style="--orp-grid-min: 18rem"
>
```

Esto permite que contenido decida cuántas columnas caben.

---

# 12. Default Auto Grid min

Definir token razonable:

```text
--orp-grid-min: 16rem
```

Pero permitir override local.

No hardcodear distintos valores para cada negocio.

---

# 13. Auto-fit vs auto-fill

Preferir:

```text
auto-fit
```

por defecto.

Usar `auto-fill` solo si existe caso de uso claro donde columnas vacías deban conservar espacio.

No crear ambas variants sin necesidad.

---

# 14. Grid item

NO crear:

```text
orp-grid-item
```

si no añade comportamiento.

Los hijos directos pueden ser cualquier primitive:

```text
orp-card
orp-stat
orp-media-card
orp-section
```

Composition first.

---

# 15. Grid span

Aquí sí puede existir necesidad real.

Crear únicamente:

```text
orp-grid-span-2
orp-grid-span-full
```

si se utilizan repetidamente.

Ejemplo:

```less
.orp-grid-span-2 {
    grid-column: span 2;
}

.orp-grid-span-full {
    grid-column: 1 / -1;
}
```

---

# 16. Span mobile safety

`orp-grid-span-2` no debe romper layouts de una columna.

Evaluar:

```less
grid-column: span min(2, ...)
```

si browser support y sintaxis lo permiten.

Si no:

documentar uso.

---

# 17. Preferred span rule

Para contenido destacado:

```text
orp-grid-span-full
```

es más seguro y útil que generar span 1–12.

---

# 18. Equal height

CSS Grid ya proporciona tracks.

No crear:

```text
orp-equal-height
```

por defecto.

Cards pueden usar:

```css
height: 100%;
```

si necesitan llenar el track.

---

# 19. Alignment

No duplicar utilities Flex/Grid existentes.

Usar:

```text
orp-align-*
orp-justify-*
```

si funcionan para grid.

Si actualmente son flex-only:

evaluar hacerlas genéricas.

---

# 20. Grid areas

NO crear un sistema utility de:

```text
orp-area-header
orp-area-sidebar
orp-area-main
```

AppShell ya resuelve layout de aplicación.

Grid debe permanecer genérico.

---

# 21. Split Layout

Crear:

```text
orp-split
```

Objetivo:

Layouts sencillos de dos regiones.

Ejemplo:

```text
Content | Content
```

---

# 22. Split markup

```html
<div class="orp-split">

    <div class="orp-split__primary">
        ...
    </div>

    <div class="orp-split__secondary">
        ...
    </div>

</div>
```

---

# 23. Split mobile

Default:

```text
stacked
```

Ejemplo:

```less
.orp-split {
    display: grid;
    gap: var(--orp-space-5);
    grid-template-columns: minmax(0, 1fr);
}
```

---

# 24. Split desktop

A partir de breakpoint adecuado:

```text
2 columns
```

Ejemplo:

```less
@media (min-width: @orp-breakpoint-md) {

    .orp-split {
        grid-template-columns:
            minmax(0, 1fr)
            minmax(0, 1fr);
    }

}
```

---

# 25. Split proportions

Permitir modifiers limitados:

```text
orp-split--1-1
orp-split--2-1
orp-split--1-2
```

Solo si existe necesidad repetida.

---

# 26. Split custom ratio

Preferir custom properties para casos especiales:

```text
--orp-split-primary
--orp-split-secondary
```

Ejemplo conceptual:

```less
grid-template-columns:
    var(--orp-split-primary, 1fr)
    var(--orp-split-secondary, 1fr);
```

---

# 27. Avoid utility explosion

No crear:

```text
orp-split--70-30
orp-split--60-40
orp-split--40-60
orp-split--75-25
```

innecesariamente.

---

# 28. Split alignment

Permitir:

```text
align-items
```

a través de utilities existentes.

No duplicar.

---

# 29. Split reverse

NO crear reverse solo para cambiar orden visual si eso contradice orden semántico.

Si se necesita diseño alterno:

preferir cambiar DOM cuando sea correcto.

---

# 30. Sidebar Layout

Crear una primitive genérica:

```text
orp-sidebar-layout
```

No confundir con:

```text
orp-app-shell__sidebar
```

---

# 31. AppShell Sidebar vs Sidebar Layout

Documentar:

```text
orp-app-shell__sidebar
→ application-level navigation/layout region
```

```text
orp-sidebar-layout
→ generic content layout with main + secondary region
```

---

# 32. Sidebar Layout example

```html
<div class="orp-sidebar-layout">

    <aside class="orp-sidebar-layout__aside">
        ...
    </aside>

    <main class="orp-sidebar-layout__main">
        ...
    </main>

</div>
```

---

# 33. Sidebar Layout mobile

Default:

```text
single column
```

---

# 34. Sidebar Layout desktop

En breakpoint:

```text
aside | main
```

Ejemplo:

```less
@media (min-width: @orp-breakpoint-lg) {

    .orp-sidebar-layout {
        grid-template-columns:
            minmax(0, var(--orp-sidebar-layout-width))
            minmax(0, 1fr);
    }

}
```

---

# 35. Sidebar width

Crear variable:

```text
--orp-sidebar-layout-width
```

Default:

```text
18rem
```

orientativo.

No reutilizar necesariamente `--orp-sidebar-width` de AppShell porque tienen responsabilidades distintas.

---

# 36. Sidebar start/end

Permitir modifier:

```text
orp-sidebar-layout--end
```

si se necesita secundaria al final.

No crear:

```text
left/right
```

por futura compatibilidad RTL.

---

# 37. Logical naming

Preferir:

```text
start
end
inline
block
```

sobre:

```text
left
right
top
bottom
```

cuando tenga sentido.

---

# 38. Sidebar sticky

No hacer sticky automáticamente.

La aplicación puede usar una utility o modifier específico si existe necesidad.

---

# 39. Generic card grid

El patrón:

```html
<div
    class="
        orp-grid
        orp-grid--auto
    "
>

    <article class="orp-card">
        ...
    </article>

</div>
```

debe ser un caso principal.

---

# 40. Media Card Grid

Debe funcionar igual:

```html
<div
    class="
        orp-grid
        orp-grid--auto
    "
    style="--orp-grid-min: 17rem"
>

    <article class="orp-media-card">
        ...
    </article>

</div>
```

---

# 41. Stats Grid

Ejemplo:

```html
<div
    class="
        orp-grid
        orp-grid--auto
    "
    style="--orp-grid-min: 12rem"
>

    <div class="orp-stat">
        ...
    </div>

</div>
```

No crear:

```text
orp-stats-grid
```

---

# 42. Form Grid

Debe poder utilizarse:

```html
<div
    class="
        orp-grid
        orp-grid--auto
    "
    style="--orp-grid-min: 18rem"
>

    <div class="orp-field">
        ...
    </div>

</div>
```

No crear `orp-form-grid` salvo necesidad futura.

---

# 43. Data Grid naming conflict

NO llamar:

```text
orp-data-grid
```

a esta primitive.

`Data Grid` normalmente implica tabla interactiva avanzada.

Utilizar:

```text
orp-grid
```

---

# 44. Masonry

NO implementar masonry todavía.

CSS Grid normal es suficiente.

No cargar librerías.

---

# 45. Dense packing

Evitar:

```css
grid-auto-flow: dense;
```

por defecto.

Puede alterar orden visual y accesibilidad.

---

# 46. Grid order

No utilizar CSS Grid para cambiar radicalmente orden visual respecto del DOM.

Mantener lectura lógica.

---

# 47. Responsive hiding

Auditar utilities existentes:

```text
orp-d-none
orp-d-block
orp-d-flex
orp-d-grid
```

---

# 48. Responsive visibility

Evaluar una API mínima:

```text
orp-hide-sm
orp-hide-md
orp-hide-lg
```

PERO no implementarla automáticamente.

Puede generar confusión respecto a:

```text
hide below?
hide above?
hide at?
```

---

# 49. Preferred visibility naming

Si se necesita, usar nombres inequívocos:

```text
orp-hide-below-md
orp-hide-from-lg
```

Pero mantener número mínimo.

---

# 50. Avoid Bootstrap naming

No crear:

```text
orp-d-md-none
orp-d-lg-block
```

solo por copiar Bootstrap.

La API debe responder a necesidades reales de ORP.

---

# 51. Responsive behavior through layout

Antes de ocultar contenido:

preferir reorganizarlo.

Responsive no significa:

```text
desktop content
→ hide half on mobile
```

---

# 52. Container

Reutilizar:

```text
orp-container
```

existente.

No crear:

```text
orp-grid-container
```

---

# 53. Container + Grid

Patrón:

```html
<div class="orp-container">

    <div
        class="
            orp-grid
            orp-grid--auto
        "
    >
        ...
    </div>

</div>
```

---

# 54. Section + Grid

Patrón:

```html
<section class="orp-section">

    <header class="orp-section__header">
        ...
    </header>

    <div class="orp-section__body">

        <div
            class="
                orp-grid
                orp-grid--auto
            "
        >
            ...
        </div>

    </div>

</section>
```

---

# 55. Stack vs Grid

Documentar:

```text
Stack
→ vertical flow
```

```text
Grid
→ two-dimensional layout
```

---

# 56. Cluster vs Grid

```text
Cluster
→ flexible inline group that wraps
```

```text
Grid
→ aligned tracks/columns
```

---

# 57. Split vs Grid

```text
Split
→ intentional two-region layout
```

```text
Grid
→ repeated items
```

---

# 58. Sidebar Layout vs Split

```text
Split
→ two balanced or custom regions
```

```text
Sidebar Layout
→ narrow secondary + flexible main
```

---

# 59. Grid vs ScrollX

```text
Grid
→ items wrap into rows
```

```text
ScrollX
→ preserve horizontal row and scroll
```

---

# 60. Grid vs Swiper

```text
Grid
→ responsive layout
```

```text
Swiper
→ interactive carousel
```

No usar Swiper como replacement de responsive Grid.

---

# 61. Container Queries

Esta fase puede introducir Container Queries de forma limitada.

No convertir todo ORP UI a container queries.

---

# 62. Container primitive

Crear opt-in:

```text
orp-query-container
```

Ejemplo:

```less
.orp-query-container {
    container-type: inline-size;
}
```

---

# 63. Naming container

Puede utilizar:

```css
container-name
```

solo cuando ayude.

No requerir nombres para casos simples.

---

# 64. Container Query purpose

Usarlo principalmente para componentes que deben responder a:

```text
available component width
```

en lugar del viewport.

Ejemplo:

```text
MediaCard horizontal/vertical
```

---

# 65. Do not rewrite components

No cambiar automáticamente todas las media queries existentes a container queries.

Solo introducir arquitectura compatible.

---

# 66. Container query utility

No crear:

```text
orp-cq-sm
orp-cq-md
orp-cq-lg
```

como otra colección masiva.

---

# 67. Component-level queries

Si `orp-media-card` se beneficia:

podría existir:

```less
@container (min-width: 32rem) {
    ...
}
```

pero solo después de verificar que no rompe compatibilidad.

---

# 68. Container Query fallback

El componente debe seguir siendo usable sin depender críticamente de container queries si existe fallback sencillo.

---

# 69. Browser support

Verificar soporte en navegadores modernos definidos por ORP:

```text
Chrome
Edge
Firefox
Safari
iOS Safari
Android
```

No soportar IE.

---

# 70. CSS Subgrid

NO hacer `subgrid` requisito del framework todavía.

Puede evaluarse después para casos concretos.

---

# 71. Modern CSS policy

Sí se permite usar:

```text
min()
max()
clamp()
minmax()
auto-fit
auto-fill
dvh
logical properties
container queries
```

cuando mejoran API.

---

# 72. Grid custom properties

API recomendada:

```text
--orp-grid-gap
--orp-grid-min
```

Tal vez:

```text
--orp-grid-columns
```

si aporta.

---

# 73. Generic custom columns

Evaluar:

```less
.orp-grid {
    grid-template-columns:
        repeat(
            var(--orp-grid-columns, 1),
            minmax(0, 1fr)
        );
}
```

Pero tener cuidado con combinación con `--auto`.

---

# 74. Simplicity preferred

No convertir `orp-grid` en una API CSS programable demasiado sofisticada.

Mantenerla comprensible.

---

# 75. Grid columns variable option

Una opción válida:

```html
<div
    class="orp-grid"
    style="--orp-grid-columns: 3"
>
```

Pero si se implementa:

debe documentarse claramente.

---

# 76. Inline custom properties

Usar custom properties inline está permitido para layout configuration.

No considerarlo anti-pattern.

Ejemplo:

```html
<div
    class="
        orp-grid
        orp-grid--auto
    "
    style="
        --orp-grid-min: 14rem;
        --orp-grid-gap: var(--orp-space-5);
    "
>
```

Esto evita crear docenas de utilities.

---

# 77. Responsive custom properties

No se pueden cambiar inline por breakpoint fácilmente.

Para casos complejos:

la aplicación puede crear su propia clase.

ORP no debe cubrir todos los casos imaginables.

---

# 78. Application-specific layout

Ejemplo válido:

```less
.feature-grid {
    --orp-grid-min: 22rem;
}
```

La aplicación puede extender primitives ORP.

---

# 79. Framework extension philosophy

ORP UI proporciona buenas primitives.

No necesita proporcionar clase para cada layout posible.

---

# 80. Grid min-width safety

Todos los tracks flexibles deben usar:

```text
minmax(0, 1fr)
```

para evitar overflow por contenido largo.

---

# 81. Grid children

Revisar también:

```text
min-width: 0
```

en componentes que lo requieran.

---

# 82. Long content stress

Probar Grid con:

```text
long URLs
long titles
large images
code
tables
```

---

# 83. Images

Grid no debe necesitar reglas especiales para imágenes.

`orp-media` ya controla media.

---

# 84. Equal card layout

Probar:

```text
short card
long card
image card
card with footer
```

dentro de un mismo Grid.

---

# 85. Card footer alignment

ORP Grid NO debe alinear footer de cards mediante hacks.

Si Card necesita:

```css
display: flex;
flex-direction: column;
```

eso pertenece a Card.

---

# 86. Grid nested

Permitir:

```text
Grid inside Grid
```

sin efectos globales.

---

# 87. Gap nested

Cada grid debe manejar su propio:

```text
--orp-grid-gap
```

con inheritance considerada.

---

# 88. Custom property inheritance

Cuidado:

```text
--orp-grid-gap
```

hereda por defecto.

Puede provocar que grids internos hereden gap externo.

Evaluar reset local.

Ejemplo:

```less
.orp-grid {
    --orp-grid-gap-local:
        var(--orp-grid-gap, var(--orp-space-4));
}
```

o documentar herencia.

---

# 89. Prefer component-local variables

Cuando sea necesario:

```text
--orp-grid-gap
```

puede usarse intencionalmente como API heredable.

No sobreingenierizar.

---

# 90. Grid responsive defaults

Un Grid básico debe verse bien en:

```text
320px
```

sin media query.

Eso es requisito.

---

# 91. No horizontal overflow

Grid no debe provocar:

```text
body overflow-x
```

por columnas fijas.

---

# 92. Avoid fixed column widths

Incorrecto:

```css
grid-template-columns:
    repeat(3, 300px);
```

Preferir tracks flexibles.

---

# 93. Fixed sidebar exception

Sidebar Layout sí puede utilizar una anchura controlada mediante:

```text
--orp-sidebar-layout-width
```

pero main siempre debe ser:

```text
minmax(0, 1fr)
```

---

# 94. Split minimum width

En split layouts:

no activar dos columnas demasiado pronto.

Usar breakpoint que mantenga legibilidad.

---

# 95. Container query split

No es necesario usar CQ para Split inicialmente.

Viewport media queries están bien para page-level layout.

---

# 96. RTL

Usar:

```text
inline-start
inline-end
```

conceptualmente.

No depender de:

```text
margin-left
margin-right
```

si existen propiedades lógicas.

---

# 97. Grid ordering

No crear:

```text
orp-order-1
orp-order-2
...
```

todavía.

Reordenar contenido es fácil de abusar.

---

# 98. CSS Columns

NO usar multi-column layout (`columns`) como parte del Grid.

Es diferente y tiene semántica de flujo de texto.

---

# 99. Flex Grid fallback

No crear fallback Flexbox del grid.

Browsers objetivo soportan CSS Grid.

---

# 100. Responsive utilities review

Auditar utilities existentes para detectar dependencia de Bootstrap o nombres ambiguos.

Especialmente:

```text
orp-d-grid
orp-gap-*
orp-w-100
orp-flex-*
```

---

# 101. Playground

Agregar categoría:

```text
Responsive Layout
```

---

# 102. Basic Grid demo

Mostrar:

```text
1 column mobile
2/3 columns wider
```

si se implementan breakpoint modifiers.

---

# 103. Auto Grid demo

Este debe ser demo principal.

Mostrar:

```text
viewport changes
automatic column count
```

sin JS.

---

# 104. Grid minimum demos

Mostrar:

```text
12rem
16rem
20rem
```

como diferentes configuraciones.

---

# 105. Card Grid demo

Usar:

```text
orp-card
```

---

# 106. Media Card Grid demo

Usar:

```text
orp-media-card
```

---

# 107. Stats Grid demo

Usar:

```text
orp-stat
```

---

# 108. Form Grid demo

Usar fields existentes.

---

# 109. Split demo

Mostrar:

```text
1:1
2:1
```

solo si ambas variants existen.

---

# 110. Sidebar Layout demo

Mostrar:

```text
aside + main
mobile stacked
desktop side-by-side
```

---

# 111. Nested Grid demo

Mostrar un ejemplo simple para verificar isolation.

---

# 112. Container Query demo

Si se implementa CQ:

crear demo pequeño y claramente marcado:

```text
Container Query
```

No convertir playground completo.

---

# 113. Playground responsive control

Si ya existe preview responsive:

usar.

Si no:

no implementar un device simulator complejo en esta fase.

Browser resize es suficiente.

---

# 114. Responsive tests

Probar:

```text
320px
375px
390px
430px
576px
768px
992px
1200px
1440px
```

---

# 115. Grid stress test

Probar entre:

```text
1 item
2 items
3 items
7 items
20 items
```

---

# 116. Auto Grid odd counts

Comprobar:

```text
5 cards
7 cards
```

No deben producir distribuciones visualmente rotas.

---

# 117. Long content

Probar items con alturas distintas.

No forzar alturas fijas.

---

# 118. Empty Grid

Un grid vacío no debe generar espacio extraño.

---

# 119. Grid + Skeleton

Probar skeleton cards dentro del mismo layout.

---

# 120. Grid + Empty State

Cuando no hay items:

usar:

```text
orp-empty
```

NO dejar un Grid sin contenido si app quiere mensaje.

---

# 121. Light theme

Verificar.

Grid casi no debería tener colores propios.

---

# 122. Dark theme

Igual.

Layout debe ser prácticamente theme-neutral.

---

# 123. Custom theme

No debe existir impacto.

---

# 124. Accessibility

CSS Grid no cambia semántica.

Mantener elementos reales:

```text
section
article
ul
li
form
```

según contenido.

---

# 125. List Grid

Si contenido representa lista:

permitir:

```html
<ul class="orp-grid">

    <li>
        ...
    </li>

</ul>
```

No requerir `div`.

---

# 126. Focus order

Grid no debe alterar orden de teclado.

No usar:

```text
order
grid-area placement
```

que cambie lectura sin motivo.

---

# 127. Zoom

Probar al menos conceptual/visualmente:

```text
200% browser zoom
```

Grid debe reducir columnas naturalmente.

---

# 128. Container Query accessibility

CQ solo afecta layout.

No ocultar información esencial mediante CQ.

---

# 129. Performance

Esta fase debe agregar:

```text
0 JavaScript
0 dependencies
```

---

# 130. CSS performance

Evitar selectores complejos.

Grid moderno no necesita JS layout measurement.

---

# 131. No ResizeObserver

No implementar JavaScript para contar columnas.

CSS Grid ya lo resuelve.

---

# 132. No window resize listener

No usar:

```js
window.addEventListener('resize')
```

para layouts.

---

# 133. No breakpoint JS

ORP UI no debe exportar:

```js
isMobile()
isTablet()
isDesktop()
```

en esta fase.

Responsive layout pertenece a CSS.

---

# 134. Breakpoint JS future

Solo se consideraría para comportamiento que genuinamente requiera JS, no presentación.

---

# 135. Documentation

Crear:

```text
docs/layout/
├── grid.md
├── auto-grid.md
├── split.md
├── sidebar-layout.md
└── container-queries.md
```

---

# 136. Grid docs

Explicar:

```text
basic grid
explicit columns
auto grid
gap
minimum width
span
```

---

# 137. Auto Grid docs

Debe ser una sección importante.

Explicar por qué:

```text
auto-fit + minmax
```

reduce necesidad de media queries.

---

# 138. Split docs

Explicar cuándo usar:

```text
Split
vs
Grid
```

---

# 139. Sidebar Layout docs

Explicar diferencia con AppShell Sidebar.

---

# 140. Container Queries docs

Explicar:

```text
viewport query
→ page-level layout
```

```text
container query
→ component-level responsiveness
```

---

# 141. Decision guide

Agregar:

```text
Vertical flow?
→ Stack

Inline wrapping group?
→ Cluster

Repeated responsive items?
→ Grid / Auto Grid

Two primary regions?
→ Split

Narrow secondary + flexible main?
→ Sidebar Layout

Horizontal preserved row?
→ ScrollX

Interactive slides?
→ Swiper
```

---

# 142. Existing layout audit

Verificar compatibilidad con:

```text
AppShell
PageContent
Container
Section
Stack
Cluster
ScrollX
```

---

# 143. Components audit

Probar:

```text
Card
MediaCard
Stat
Table
Form fields
Empty
Skeleton
```

dentro de Grid.

---

# 144. Table in Grid

No colocar tablas directamente en columnas demasiado estrechas en demos.

Pero Grid debe permitirlo.

TableWrapper manejará overflow.

---

# 145. ORP container width

No modificar `orp-container` salvo que exista bug real.

Grid debe trabajar con su API existente.

---

# 146. CSS imports

Agregar nuevos layout files al entrypoint principal.

Ejemplo conceptual:

```less
@import "layout/grid.less";
@import "layout/split.less";
@import "layout/sidebar-layout.less";
@import "layout/container-query.less";
```

---

# 147. Import order

Mantener layout antes de componentes específicos cuando corresponda.

No romper orden existente.

---

# 148. Build

Ejecutar:

```text
existing project build
```

Confirmar:

```text
LESS compile success
Vite success
no warnings introduced
```

---

# 149. Bundle impact

JS esperado:

```text
0 bytes
```

excepto metadata/build differences.

Reportar crecimiento CSS.

---

# 150. No dependency changes

No instalar:

```text
Bootstrap
Tailwind
Foundation
CSS Grid libraries
layout libraries
```

---

# 151. Bootstrap coexistence

Si la aplicación también utiliza Bootstrap:

ORP Grid debe coexistir sin conflicto.

No usar:

```text
.row
.col
.container-fluid
```

---

# 152. Tailwind coexistence

Lo mismo.

ORP no depende ni compite con utility selectors externos.

---

# 153. Grid naming audit

Buscar globalmente posibles:

```text
.grid
.row
.columns
.col
```

creados por ORP.

Renombrar a namespace si son propios.

---

# 154. Playground isolation

El Playground debe demostrar:

```text
ORP Grid works without Bootstrap
```

No utilizar `.row`, `.col-*`, `d-grid`, etc.

---

# 155. Completion criteria

Parte 12 termina cuando existan:

```text
Responsive Layout
├── orp-grid
├── explicit small column set
├── orp-grid--auto
├── configurable minimum width
├── optional spans
├── orp-split
├── orp-sidebar-layout
└── container-query foundation
```

y todo funcione sin JavaScript.

---

# 156. Expected final report

Al finalizar entregar:

## Files created

Listar.

## Files modified

Listar.

## Grid API

Mostrar clases y custom properties.

## Explicit columns

Listar las realmente implementadas.

## Auto Grid

Explicar comportamiento.

## Split

Explicar API.

## Sidebar Layout

Explicar API.

## Container Queries

Explicar qué se implementó.

## Responsive tests

Indicar viewports probados.

## Accessibility

Indicar revisión.

## Playground

Listar demos.

## Build

Resultado.

## Bundle

CSS añadido / JS añadido.

## Conflicts

Reportar.

---

# 157. Explicit exclusions

NO implementar:

```text
12-column Bootstrap Grid
Masonry
Data Grid
Resizable panels
Drag & drop layout
Dashboard layout builder
CSS order utilities
JS breakpoint detection
Layout runtime
```

---

# 158. Do not continue automatically

No implementar Parte 13.

Terminar con reporte.

---

# Regla final

La filosofía de ORP responsive layout debe ser:

```text
Use CSS to let content decide layout
instead of encoding every device width into classes.
```

Preferir:

```html
<div
    class="
        orp-grid
        orp-grid--auto
    "
    style="--orp-grid-min: 18rem"
>
```

sobre:

```html
<div class="orp-row">

    <div class="orp-col-12 orp-col-md-6 orp-col-lg-4">
```

ORP UI debe mantenerse:

```text
modern
small
content-driven
mobile-first
CSS-first
composable
```

El sistema Grid debe resolver el 80–90% de los layouts comunes con unas cuantas primitives, no con cientos de clases responsive.

