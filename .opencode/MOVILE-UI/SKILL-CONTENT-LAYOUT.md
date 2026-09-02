# SKILL — ORP UI / Parte 7: Content & Layout Primitives

## Objetivo

Extender ORP UI con primitives reutilizables para construir interfaces de contenido modernas y mobile-first.

Esta fase NO debe crear componentes ligados a ningún rubro o tipo de negocio.

No crear nombres como:

```text id="m7ocfm"
orp-product-card
orp-restaurant-card
orp-food-card
orp-course-card
orp-property-card
orp-service-card
orp-profile-card
```

En su lugar, construir primitives genéricas que puedan componerse para múltiples casos.

La Parte 7 implementa:

```text id="njpd6g"
Layout
├── Page
├── Section
├── Stack
├── Cluster
└── Horizontal Scroll

Content
├── Media
├── Media Card
├── Hero Banner
├── Chip
├── Meta
├── Price
├── Rating
└── Divider

Integration
└── Swiper Styling / ORP integration
```

---

# 1. Principio principal

ORP UI debe proporcionar piezas visuales genéricas.

La aplicación decide su significado.

Ejemplo:

```text id="x35cf4"
orp-media-card
```

puede representar:

```text id="g2qx2d"
producto
curso
inmueble
artículo
persona
servicio
evento
promoción
proyecto
restaurante
video
```

ORP UI no debe saber cuál de ellos es.

---

# 2. Namespace

Mantener:

```text id="6ue7rq"
orp-
```

Variables LESS:

```text id="3ltgkb"
@orp-
```

CSS Custom Properties:

```text id="m04put"
--orp-
```

Vue:

```text id="379bzp"
Orp*
```

Pero esta fase debe ser principalmente:

```text id="3n8g98"
HTML + LESS
```

---

# 3. Regla CSS-first

Los componentes de esta fase deben ser CSS-first.

No crear automáticamente:

```text id="gkupnd"
OrpPage.vue
OrpSection.vue
OrpMediaCard.vue
OrpHeroBanner.vue
OrpChip.vue
OrpPrice.vue
OrpRating.vue
```

si HTML + CSS resuelve correctamente el problema.

Crear Vue solo cuando exista comportamiento real.

---

# 4. Page

Crear:

```text id="aylzgp"
orp-page
```

Objetivo:

Representar una superficie/página de contenido.

Ejemplo:

```html id="nyekhp"
<main class="orp-page">
    ...
</main>
```

Debe proporcionar:

```text id="zuv2ir"
mobile-first spacing
background
foreground
minimum height
```

sin asumir navegación específica.

---

# 5. Page structure

Permitir:

```text id="wpvd77"
orp-page
orp-page__header
orp-page__content
orp-page__footer
```

No obligar a usar todas las partes.

---

# 6. Page width

Por defecto:

```text id="742ywh"
100%
```

No imponer `max-width` global al contenido móvil.

Cuando se quiera contener contenido desktop, reutilizar:

```text id="a0ndug"
orp-container
```

---

# 7. Page spacing

La página debe poder usar:

```text id="jawpk7"
--orp-page-padding
```

si aporta personalización.

Valor móvil sugerido:

```text id="np3418"
16px
```

No duplicar spacing tokens si puede usarse:

```text id="onfu4s"
--orp-space-4
```

---

# 8. Section

Crear:

```text id="f8zmk7"
orp-section
```

Esta debe ser una de las primitives centrales de ORP UI.

Objetivo:

Agrupar contenido con jerarquía visual consistente.

---

# 9. Section structure

Utilizar:

```text id="wjn5wi"
orp-section
orp-section__header
orp-section__title
orp-section__subtitle
orp-section__action
orp-section__body
orp-section__footer
```

Ejemplo:

```html id="pxhm3d"
<section class="orp-section">

    <header class="orp-section__header">

        <div>

            <h2 class="orp-section__title">
                Recomendados
            </h2>

            <p class="orp-section__subtitle">
                Selección para ti
            </p>

        </div>

        <a
            href="#"
            class="orp-section__action"
        >
            Ver todos
        </a>

    </header>

    <div class="orp-section__body">
        ...
    </div>

</section>
```

---

# 10. Section no conoce contenido

Una Section no debe asumir que contiene:

```text id="yzxbkb"
productos
posts
usuarios
categorías
```

Solo organiza contenido.

---

# 11. Section spacing

Mantener spacing vertical consistente.

Agregar modifier solo si aporta valor:

```text id="q62r5o"
orp-section--compact
orp-section--spacious
```

No crear diez tamaños.

---

# 12. Section action

`orp-section__action` debe poder contener:

```text id="913zal"
link
button
icon button
```

No imponer un elemento HTML concreto.

---

# 13. Stack

Crear layout primitive:

```text id="6jcf8a"
orp-stack
```

Objetivo:

Apilar elementos verticalmente con separación consistente.

Ejemplo:

```html id="qezg4m"
<div class="orp-stack orp-stack--4">
    ...
</div>
```

---

# 14. Stack spacing

Permitir una escala pequeña:

```text id="sl643e"
orp-stack--1
orp-stack--2
orp-stack--3
orp-stack--4
orp-stack--5
```

Reutilizar spacing tokens existentes.

No inventar spacing independiente.

---

# 15. Stack implementation

Preferir:

```css id="w0iuyk"
display: flex;
flex-direction: column;
gap: var(--orp-space-*);


```

No utilizar márgenes entre hijos si `gap` resuelve mejor.

---

# 16. Cluster

Crear:

```text id="y3h7uv"
orp-cluster
```

Objetivo:

Agrupar elementos horizontales que pueden envolver.

Útil para:

```text id="6i96yk"
chips
actions
badges
metadata
tags
buttons
filters
```

---

# 17. Cluster

Ejemplo:

```html id="mwri4i"
<div class="orp-cluster orp-cluster--2">

    <span class="orp-chip">
        Nuevo
    </span>

    <span class="orp-chip">
        Popular
    </span>

</div>
```

---

# 18. Cluster behavior

Utilizar:

```css id="84w3px"
display: flex;
flex-wrap: wrap;
align-items: center;
gap: var(--orp-space-*);
```

---

# 19. Horizontal Scroll

Crear:

```text id="af5mbr"
orp-scroll-x
```

o:

```text id="q9s3oi"
orp-horizontal-scroll
```

Elegir una sola convención.

Preferencia:

```text id="0x2pi6"
orp-scroll-x
```

por ser más reutilizable.

---

# 20. Scroll X objetivo

Debe permitir filas horizontales mobile-first sin JavaScript.

Ejemplo:

```html id="vt4218"
<div class="orp-scroll-x">

    <article class="orp-media-card">
        ...
    </article>

    <article class="orp-media-card">
        ...
    </article>

</div>
```

---

# 21. Scroll X implementation

Utilizar:

```css id="j1j71p"
display: flex;
overflow-x: auto;
overscroll-behavior-inline: contain;
scroll-snap-type: inline proximity;
-webkit-overflow-scrolling: touch;
```

---

# 22. Scroll X children

Los hijos deben poder:

```text id="e7q5mb"
mantener su ancho
no colapsar
snap opcional
```

No imponer una anchura específica a todos los hijos.

---

# 23. Scroll modifiers

Permitir inicialmente:

```text id="mhlobg"
orp-scroll-x--snap
orp-scroll-x--peek
```

`peek` puede dejar visible parte del siguiente elemento para comunicar que existe más contenido.

---

# 24. Scrollbars

Puede ocultarse visualmente scrollbar cuando sea apropiado.

Pero no impedir scrolling.

Debe seguir funcionando con:

```text id="34v9b1"
touch
trackpad
mouse wheel horizontal
keyboard cuando aplique
```

---

# 25. Media primitive

Crear:

```text id="62fm1l"
orp-media
```

Objetivo:

Manejar imágenes/video/contenido visual de forma consistente.

---

# 26. Media structure

Utilizar:

```text id="byotdx"
orp-media
orp-media__content
orp-media__overlay
```

Ejemplo:

```html id="1kz3bk"
<div class="orp-media">

    <img
        class="orp-media__content"
        src="..."
        alt=""
    >

</div>
```

---

# 27. Media aspect ratios

Crear modifiers:

```text id="ap67fq"
orp-media--square
orp-media--portrait
orp-media--landscape
orp-media--wide
```

Mapeo aproximado:

```text id="dqg77q"
square
1 / 1

portrait
3 / 4

landscape
4 / 3

wide
16 / 9
```

---

# 28. Media object fit

Por defecto:

```text id="mkccl7"
object-fit: cover;
```

Permitir:

```text id="lkxe0o"
orp-media--contain
```

cuando sea necesario.

---

# 29. Media rounded

No crear demasiados modifiers.

Puede reutilizar radius mediante:

```text id="n31acg"
orp-media--rounded
```

si existe uso repetido.

---

# 30. Media overlay

Permitir:

```text id="znlh3l"
orp-media__overlay
```

para:

```text id="al0698"
badges
actions
gradient
text
```

---

# 31. Media Card

Crear primitive:

```text id="76a59p"
orp-media-card
```

Esta es una de las piezas centrales de la fase.

---

# 32. Media Card structure

Utilizar:

```text id="pqxl27"
orp-media-card
orp-media-card__media
orp-media-card__body
orp-media-card__eyebrow
orp-media-card__title
orp-media-card__description
orp-media-card__meta
orp-media-card__footer
orp-media-card__actions
```

---

# 33. Media Card default

Ejemplo:

```html id="krjqhk"
<article class="orp-media-card">

    <div class="orp-media-card__media">

        <div class="orp-media orp-media--landscape">
            <img
                class="orp-media__content"
                src="..."
                alt=""
            >
        </div>

    </div>

    <div class="orp-media-card__body">

        <div class="orp-media-card__eyebrow">
            Destacado
        </div>

        <h3 class="orp-media-card__title">
            Título del contenido
        </h3>

        <p class="orp-media-card__description">
            Descripción breve del elemento.
        </p>

    </div>

</article>
```

---

# 34. Media Card variants

Crear únicamente:

```text id="1mcfiu"
orp-media-card--compact
orp-media-card--horizontal
orp-media-card--featured
orp-media-card--interactive
```

No crear variantes de negocio.

---

# 35. Compact

`compact` está pensado para:

```text id="69ri4j"
categorías
items rápidos
navegación visual
colecciones pequeñas
```

No debe asumir qué representa.

---

# 36. Horizontal card

Debe permitir:

```text id="1tqhwq"
media | content
```

en horizontal.

Ejemplo conceptual:

```text id="pj84k8"
[ image ][ title
          meta ]
```

---

# 37. Featured

Debe permitir una card visualmente dominante.

Útil para:

```text id="nj53ax"
highlight
recommendation
featured content
promotion
```

No significa específicamente “producto destacado”.

---

# 38. Interactive

`orp-media-card--interactive` debe considerar:

```text id="l9fat1"
hover
focus-visible
active
touch
```

Si toda la card es link:

preferir estructura semántica válida.

---

# 39. No nested interactive elements

Evitar:

```html id="mohh7i"
<a class="orp-media-card">
    ...
    <button>...</button>
</a>
```

si produce HTML interactivo anidado inválido.

Documentar patrones correctos.

---

# 40. Hero Banner

Crear:

```text id="zvyd53"
orp-hero
```

Objetivo:

Bloque visual destacado adaptable.

Puede contener:

```text id="7busng"
image
background image
video
gradient
text
CTA
badges
```

---

# 41. Hero structure

Utilizar:

```text id="q9bki4"
orp-hero
orp-hero__media
orp-hero__overlay
orp-hero__content
orp-hero__eyebrow
orp-hero__title
orp-hero__description
orp-hero__actions
```

---

# 42. Hero example

```html id="ygem7i"
<section class="orp-hero">

    <div class="orp-hero__media">
        ...
    </div>

    <div class="orp-hero__overlay"></div>

    <div class="orp-hero__content">

        <div class="orp-hero__eyebrow">
            Nuevo
        </div>

        <h1 class="orp-hero__title">
            Título principal
        </h1>

        <p class="orp-hero__description">
            Texto promocional o descriptivo.
        </p>

        <div class="orp-hero__actions">

            <button class="orp-btn orp-btn--primary">
                Ver más
            </button>

        </div>

    </div>

</section>
```

---

# 43. Hero no slider

`orp-hero` NO debe implementar slider por sí mismo.

Hero representa una slide/bloque.

Para múltiples slides utilizar:

```text id="hm24zo"
Swiper
```

---

# 44. Hero height

No usar una altura rígida universal.

Permitir variantes:

```text id="u9w6nh"
orp-hero--compact
orp-hero--default
orp-hero--tall
```

solo si son realmente necesarias.

Preferir:

```text id="vgsquf"
min-height
aspect-ratio
clamp()
```

cuando sea apropiado.

---

# 45. Hero content position

Permitir algunos modifiers genéricos:

```text id="jbbofr"
orp-hero--start
orp-hero--center
orp-hero--end
```

No crear posiciones específicas como:

```text id="by63ju"
bottom-left-promo
food-layout
```

---

# 46. Chip

Crear:

```text id="24trlh"
orp-chip
```

Objetivo:

Elemento compacto para:

```text id="cbenqg"
filters
tags
categories
statuses ligeros
quick actions
selection
```

---

# 47. Chip structure

Utilizar:

```text id="9s2wy1"
orp-chip
orp-chip__icon
orp-chip__label
orp-chip__remove
```

---

# 48. Chip variants

Inicialmente:

```text id="bs5z08"
orp-chip--default
orp-chip--primary
orp-chip--outline
orp-chip--selected
```

No crear semantic colors si Badge ya cubre estados.

---

# 49. Chip vs Badge

Documentar:

```text id="ecxjir"
Badge
→ informa estado / metadata
```

```text id="0lj31u"
Chip
→ representa opción, filtro, categoría o acción compacta
```

---

# 50. Interactive Chip

Cuando sea interactivo:

usar:

```html id="e1pd18"
<button class="orp-chip">
```

No convertir `span` en elemento clickeable vía JS.

---

# 51. Meta

Crear primitive:

```text id="kr9e41"
orp-meta
```

Objetivo:

Mostrar metadata secundaria.

Ejemplo:

```html id="hzm65j"
<div class="orp-meta">

    <span class="orp-meta__item">
        8 min
    </span>

    <span class="orp-meta__item">
        Hace 2 días
    </span>

</div>
```

---

# 52. Meta structure

Utilizar:

```text id="a24bki"
orp-meta
orp-meta__item
orp-meta__icon
orp-meta__separator
```

---

# 53. Meta reuse

Puede servir para:

```text id="893qi4"
date
duration
location
author
views
category
status text
```

ORP UI no interpreta el contenido.

---

# 54. Price

Crear primitive visual:

```text id="3137bc"
orp-price
```

Aunque se llame Price, debe ser un helper tipográfico para valores monetarios.

No debe implementar:

```text id="bf040u"
currency conversion
formatting
taxes
discount calculation
```

---

# 55. Price structure

```text id="0mq6jz"
orp-price
orp-price__currency
orp-price__value
orp-price__fraction
orp-price__previous
orp-price__suffix
```

Ejemplo:

```html id="50man6"
<div class="orp-price">

    <span class="orp-price__currency">
        $
    </span>

    <span class="orp-price__value">
        249
    </span>

    <span class="orp-price__fraction">
        .00
    </span>

</div>
```

---

# 56. Previous price

Permitir:

```text id="x5qtaf"
orp-price__previous
```

para visualización:

```text id="lpyii2"
$299
```

tachado.

El cálculo del descuento pertenece a la aplicación.

---

# 57. Price optionality

Price es un helper opcional.

No todas las cards deben utilizarlo.

No conectar MediaCard automáticamente con Price.

---

# 58. Rating

Crear visual primitive:

```text id="ldjyz8"
orp-rating
```

Debe poder mostrar:

```text id="8rme1s"
value
icon representation
count
```

---

# 59. Rating structure

```text id="e76wb4"
orp-rating
orp-rating__icons
orp-rating__value
orp-rating__count
```

Ejemplo:

```html id="vimyjp"
<div class="orp-rating">

    <span class="orp-rating__icons">
        ★
    </span>

    <span class="orp-rating__value">
        4.8
    </span>

    <span class="orp-rating__count">
        (128)
    </span>

</div>
```

---

# 60. Rating no logic

ORP UI NO debe:

```text id="qkryht"
calculate averages
load reviews
submit ratings
```

Solo representa visualmente metadata.

---

# 61. Rating icon independence

No añadir icon library.

Puede usar:

```text id="usbgsk"
Unicode
SVG
custom component
```

---

# 62. Divider

Crear:

```text id="v37kr4"
orp-divider
```

Uso:

```html id="wktewp"
<hr class="orp-divider">
```

Modifiers opcionales:

```text id="mkz8lu"
orp-divider--inset
orp-divider--vertical
```

Solo si existe necesidad.

---

# 63. Divider semantic

Preferir:

```html id="3u168m"
<hr>
```

cuando sea una separación semántica real.

Para división puramente visual puede utilizarse otro elemento.

---

# 64. Swiper integration

ORP UI NO debe crear su propio carousel.

Swiper puede utilizarse como dependencia externa de la aplicación.

Esta fase debe proporcionar integración visual opcional.

---

# 65. ORP + Swiper

Crear archivo:

```text id="5smztg"
integrations/swiper.less
```

solo si Swiper está presente o forma parte del stack del proyecto.

---

# 66. No modificar Swiper globalmente

No hacer:

```less id="69i6mn"
.swiper {
    ...
}
```

global.

Scopear integración:

```less id="vgzmec"
.orp-swiper {
    .swiper {
        ...
    }
}
```

o:

```text id="5k8l0a"
orp-swiper
```

en el mismo elemento.

---

# 67. Swiper wrapper

Uso posible:

```html id="u25eq8"
<div class="swiper orp-swiper">
    ...
</div>
```

---

# 68. Swiper dots

Skin para:

```text id="5ymv8j"
pagination
navigation
spacing
```

debe consumir:

```text id="0ka4zi"
--orp-primary
--orp-surface
--orp-muted
```

cuando corresponda.

---

# 69. Swiper variants

No crear configuraciones JS dentro de ORP UI.

La aplicación decide:

```text id="3dkn7m"
slidesPerView
autoplay
loop
navigation
breakpoints
```

ORP UI solo proporciona styling/integration.

---

# 70. Composición

Una de las metas principales es permitir composiciones.

Ejemplo:

```html id="46mx2f"
<section class="orp-section">

    <header class="orp-section__header">

        <h2 class="orp-section__title">
            Destacados
        </h2>

        <a class="orp-section__action">
            Ver todos
        </a>

    </header>

    <div class="orp-scroll-x orp-scroll-x--peek">

        <article class="orp-media-card orp-media-card--compact">

            <div class="orp-media-card__media">

                <div class="orp-media orp-media--square">

                    <img
                        class="orp-media__content"
                        src="..."
                        alt=""
                    >

                </div>

            </div>

            <div class="orp-media-card__body">

                <h3 class="orp-media-card__title">
                    Contenido
                </h3>

            </div>

        </article>

    </div>

</section>
```

---

# 71. Composición con metadata

```html id="0xqt22"
<article class="orp-media-card">

    <div class="orp-media-card__media">
        ...
    </div>

    <div class="orp-media-card__body">

        <div class="orp-cluster orp-cluster--2">

            <span class="orp-chip">
                Nuevo
            </span>

            <span class="orp-badge orp-badge--success">
                Disponible
            </span>

        </div>

        <h3 class="orp-media-card__title">
            Título genérico
        </h3>

        <div class="orp-meta">

            <span class="orp-meta__item">
                Metadata
            </span>

            <span class="orp-meta__item">
                Metadata
            </span>

        </div>

    </div>

</article>
```

---

# 72. Component-specific spacing

No crear:

```text id="7dt89q"
orp-media-card-margin-bottom-24
```

Usar:

```text id="hz5hg6"
Stack
Section
Gap utilities
```

para composición externa.

El componente debe manejar únicamente su spacing interno.

---

# 73. Content truncation

MediaCard debe considerar títulos largos.

Permitir modifier opcional:

```text id="6es8is"
orp-media-card__title--clamp
```

o una utility reusable si ya existe necesidad general.

Preferir CSS:

```css id="174h8n"
display: -webkit-box;
-webkit-line-clamp: 2;
-webkit-box-orient: vertical;
overflow: hidden;
```

solo si la compatibilidad objetivo lo permite.

---

# 74. Images

Toda imagen debe:

```text id="kwos97"
max-width: 100%
```

y mantener proporción.

No imponer lazy loading desde CSS.

Documentar uso:

```html id="evcw47"
loading="lazy"
```

cuando corresponda.

Hero above-the-fold puede no usar lazy loading.

La aplicación decide.

---

# 75. Image fallback

ORP UI no debe implementar sistema de placeholder remoto.

La aplicación puede utilizar:

```text id="feusvw"
local placeholder
SVG
generated image
fallback URL
```

---

# 76. Responsive media cards

`orp-media-card--horizontal` debe poder pasar a vertical si el viewport se vuelve demasiado estrecho.

Evitar layouts rotos.

Mobile-first significa que el default debe estar pensado primero para móvil.

---

# 77. Container Queries

Evaluar:

```css id="vaekuy"
@container
```

solo si aporta valor real a MediaCard.

No introducirlo solo por ser moderno.

La card idealmente debe responder al espacio disponible, no únicamente viewport.

Documentar decisión.

---

# 78. Grid

NO implementar sistema de grid completo en esta fase.

Se permite CSS Grid dentro de componentes.

La primitive Grid general se deja para la siguiente fase.

---

# 79. Hero readability

Cuando Hero tenga imagen de fondo:

asegurar contraste mediante:

```text id="mpg5ys"
overlay
gradient
text shadow discreto
```

según configuración.

No asumir que todas las imágenes tienen tonos oscuros.

---

# 80. Hero overlay

Crear:

```text id="gvcya1"
orp-hero__overlay
```

pero no imponer opacidad fija imposible de modificar.

Puede utilizar:

```text id="ldv4ng"
--orp-hero-overlay
```

si aporta valor.

---

# 81. Content tokens

Agregar únicamente tokens necesarios.

Posibles:

```text id="0tsbr9"
--orp-page-padding
--orp-section-gap
--orp-content-max-width
--orp-hero-overlay
```

No llenar root de tokens específicos si pueden usar spacing existente.

---

# 82. Card width tokens

Para scroll horizontal puede ser útil:

```text id="xl8kmo"
--orp-media-card-width
```

pero no imponer un ancho universal.

Preferir modifier:

```text id="qbc2yr"
orp-media-card--compact
```

con tamaño razonable.

---

# 83. Theme compatibility

Todos los componentes deben funcionar en:

```text id="oeop0i"
Light
Dark
Custom themes
```

No hardcodear:

```text id="2evlke"
white
black
gray
```

cuando exista token semántico.

---

# 84. Hero + theme

Hero con imagen puede utilizar colores independientes del theme.

Pero sus overlays/texto deben poder ajustarse mediante CSS variables.

No mezclar lógica de themes dentro del componente.

---

# 85. Surface model

MediaCard y Section deben reutilizar:

```text id="mqyaid"
--orp-surface
--orp-surface-foreground
--orp-border
```

cuando necesiten superficie.

No crear:

```text id="b2qkjw"
--orp-media-card-white
```

---

# 86. Playground

Actualizar:

```text id="5xj76e"
OrpPlayground.vue
```

Agregar categoría:

```text id="x9qo4f"
Content & Layout
```

---

# 87. Page playground

Mostrar:

```text id="l5ll04"
basic page
page with AppBar
page with BottomNav
page with sections
```

No introducir routing real.

---

# 88. Section playground

Mostrar:

```text id="l47w8g"
title
title + subtitle
action
body
footer
compact
```

---

# 89. Stack playground

Mostrar:

```text id="dppxz7"
gap 1
gap 2
gap 3
gap 4
gap 5
```

---

# 90. Cluster playground

Mostrar:

```text id="i7r5fm"
chips
badges
buttons
wrapped content
```

---

# 91. Horizontal scroll playground

Mostrar:

```text id="4gf8ib"
cards
compact cards
peek
snap
many items
```

---

# 92. Media playground

Mostrar:

```text id="sz50ln"
square
portrait
landscape
wide
cover
contain
```

---

# 93. Media Card playground

Mostrar:

```text id="6h2z9t"
default
compact
horizontal
featured
interactive
with badge
with meta
with price
with rating
```

Los ejemplos pueden representar contenido ficticio genérico.

No crear ejemplos exclusivamente de un rubro.

---

# 94. Hero playground

Mostrar:

```text id="vk3wx2"
image
overlay
title
description
CTA
centered
compact
```

Agregar ejemplo con Swiper solo si Swiper ya está disponible.

---

# 95. Chip playground

Mostrar:

```text id="lmdgo3"
default
primary
outline
selected
interactive
remove icon
```

---

# 96. Meta playground

Mostrar:

```text id="na5nx4"
date
duration
location
mixed metadata
```

Estos son ejemplos de contenido, no APIs específicas.

---

# 97. Price playground

Mostrar:

```text id="j61h9f"
basic
with currency
with fraction
previous price
suffix
```

---

# 98. Rating playground

Mostrar:

```text id="hv5yf0"
value
count
icon
inside card
```

---

# 99. Divider playground

Mostrar:

```text id="y29heh"
default
inset
vertical si se implementa
```

---

# 100. Responsive testing

Probar:

```text id="s0ndpg"
320px
375px
390px
430px
768px
1024px
1440px
```

Priorizar:

```text id="zf552y"
Section header
Scroll X
Media Card
Horizontal Card
Hero
Cluster wrapping
```

---

# 101. Content stress testing

Probar con:

```text id="ct9atc"
very long title
very long description
missing image
large image
many chips
many metadata items
long action text
```

La UI debe degradar correctamente.

---

# 102. Touch

Scroll horizontal debe funcionar fluidamente en touch.

Cards interactivas deben tener touch feedback.

Actions dentro de Section deben mantener target razonable.

---

# 103. Keyboard

Cards interactivas que sean links/buttons deben tener:

```text id="r50z6g"
focus-visible
```

Horizontal Scroll no debe bloquear navegación de teclado de sus hijos.

---

# 104. Accessibility

Revisar:

```text id="7901uw"
heading hierarchy
alt attributes
links
buttons
focus
color contrast
semantic sections
```

No usar:

```text id="tz0wc7"
div
```

para todo por comodidad.

---

# 105. Heading hierarchy

ORP UI NO debe imponer siempre:

```text id="f0hbxh"
h1
h2
h3
```

La documentación muestra recomendaciones.

La aplicación decide nivel correcto según contexto.

---

# 106. Price accessibility

Mantener valor monetario legible como texto.

No dividirlo de forma que screen readers produzcan lectura incoherente.

Si la composición visual dificulta accesibilidad, permitir:

```text id="dxvylw"
aria-label
```

apropiado desde la aplicación.

---

# 107. Rating accessibility

No depender únicamente de estrellas visuales.

Ejemplo:

```html id="0pz2b9"
<div
    class="orp-rating"
    aria-label="4.8 de 5"
>
```

La aplicación proporciona valor real.

---

# 108. Swiper accessibility

No deshabilitar funciones accesibles de Swiper mediante estilos.

Los dots deben mantener targets razonables.

No ocultar focus.

---

# 109. No JavaScript extra

Esta fase debe introducir prácticamente cero JavaScript propio.

La única excepción puede ser integración visual con herramientas ya existentes, pero no lógica ORP nueva.

---

# 110. No dependencies

No instalar:

```text id="a7brn4"
carousel libraries
image libraries
rating libraries
layout frameworks
Masonry
```

Swiper solo se utiliza si ya existe en aplicación o se decide externamente.

---

# 111. Build

Verificar que:

```text id="10cw80"
LESS compila
dark mode funciona
imports funcionan
Vite build funciona
```

---

# 112. CSS size

Reportar crecimiento aproximado.

Esta fase agrega CSS, pero no debería aumentar JS significativamente.

---

# 113. Documentation

Documentar:

```text id="l2lfhv"
Page
Section
Stack
Cluster
Scroll X
Media
MediaCard
Hero
Chip
Meta
Price
Rating
Divider
Swiper integration
```

---

# 114. Document composition-first philosophy

Agregar explícitamente a documentación:

```text id="n3g5dt"
Do not create business-specific UI components inside ORP UI.
```

Ejemplo incorrecto:

```text id="onnpwx"
OrpRestaurantCard
```

Ejemplo correcto:

```text id="1cvyzv"
orp-media-card
+
orp-rating
+
orp-meta
```

---

# 115. Ejemplo de reutilización

La misma estructura:

```html id="0dqopr"
<article class="orp-media-card">

    <div class="orp-media-card__media">
        ...
    </div>

    <div class="orp-media-card__body">

        <h3 class="orp-media-card__title">
            ...
        </h3>

        <div class="orp-meta">
            ...
        </div>

    </div>

</article>
```

puede representar cualquier dominio.

El significado pertenece a la aplicación.

---

# 116. No domain naming

Antes de crear cualquier nueva clase preguntar:

> ¿Este nombre describe UI o describe negocio?

Si describe negocio:

NO pertenece a ORP UI.

Correcto:

```text id="dijpyv"
orp-media-card
orp-meta
orp-chip
orp-section
```

Incorrecto:

```text id="eseczz"
orp-course-card
orp-property-price
orp-doctor-profile
orp-food-category
```

---

# 117. Application components allowed

La aplicación consumidora puede crear:

```text id="uj20za"
CourseCard.vue
PropertyCard.vue
ProfileCard.vue
ProductCard.vue
```

componiendo primitives ORP.

Eso sí pertenece a la aplicación.

---

# 118. Ejemplo aplicación

La aplicación puede hacer:

```vue id="ysu0o"
<template>

    <article class="orp-media-card">

        <div class="orp-media-card__media">
            ...
        </div>

        <div class="orp-media-card__body">

            <h3 class="orp-media-card__title">
                {{ item.name }}
            </h3>

        </div>

    </article>

</template>
```

y llamar al archivo:

```text id="s4ewmq"
ProductCard.vue
```

sin introducir:

```text id="rye9i5"
orp-product-card
```

en el framework.

---

# 119. Resultado esperado

Al finalizar entregar:

## Archivos creados

Lista.

## Archivos modificados

Lista.

## Layout primitives

```text id="vfo5fo"
orp-page
orp-section
orp-stack
orp-cluster
orp-scroll-x
```

## Content primitives

```text id="jo1jtn"
orp-media
orp-media-card
orp-hero
orp-chip
orp-meta
orp-price
orp-rating
orp-divider
```

## Integrations

Indicar si se agregó:

```text id="8251br"
orp-swiper
```

## Tokens

Listar únicamente tokens nuevos.

## Playground

Explicar ejemplos agregados.

## Responsive

Indicar viewports probados.

## Themes

Confirmar light/dark.

## Accessibility

Indicar revisión.

## Build

Indicar resultado.

## Bundle

Reportar crecimiento aproximado.

## Conflicts

Reportar problemas.

---

# 120. Alcance final Parte 7

La Parte 7 termina cuando existan:

```text id="wdd0ll"
Layout
├── Page
├── Section
├── Stack
├── Cluster
└── Horizontal Scroll

Content
├── Media
├── Media Card
├── Hero
├── Chip
├── Meta
├── Price
├── Rating
└── Divider

Integration
└── Swiper skin opcional
```

No continuar automáticamente con Parte 8.

---

# Regla final

ORP UI debe ofrecer primitives.

NO componentes de negocio.

La regla arquitectónica central es:

```text id="bi1gxu"
ORP UI
=
cómo se ve y se comporta la interfaz
```

```text id="mgb416"
Application
=
qué significa el contenido
```

Por tanto:

```text id="mhk3if"
orp-media-card
✅
```

```text id="5jkmdx"
orp-restaurant-card
❌
```

```text id="i73kv1"
orp-meta
✅
```

```text id="xgfsxw"
orp-course-duration
❌
```

```text id="xrn7dg"
orp-hero
✅
```

```text id="h8qyza"
orp-real-estate-hero
❌
```

Mantener ORP UI:

```text id="9cewao"
generic
composable
mobile-first
semantic
recyclable
low dependency
```

El framework debe crecer mediante primitives que puedan recombinarse, no mediante componentes específicos de cada proyecto.

