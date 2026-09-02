
# SKILL — ORP UI / Parte 8: Integrations & Icon System

## Objetivo

Extender ORP UI con una capa oficial de integraciones para librerías externas ligeras y especializadas.

Esta fase integra:

```text
Icons
└── Bootstrap Icons

Media
└── GLightbox

Carousel
└── Swiper
```

La filosofía principal es:

```text
ORP UI
→ diseño, layout, tokens y convenciones

Librería externa
→ comportamiento especializado
```

ORP UI NO debe reimplementar funcionalidades que estas librerías ya resuelven correctamente.

---

# 1. Principio principal

ORP UI debe continuar siendo reutilizable e independiente.

Bootstrap Icons, GLightbox y Swiper son integraciones recomendadas.

NO convertirlas en dependencias estructurales del framework.

Un componente ORP debe poder funcionar aunque una de estas librerías no esté instalada.

---

# 2. Integraciones oficiales

Considerar oficialmente soportadas:

```text
Bootstrap Icons
GLightbox
Swiper
```

Cada integración debe estar aislada.

Estructura sugerida:

```text
orp-ui/
└── integrations/
    ├── bootstrap-icons.less
    ├── glightbox.less
    └── swiper.less
```

Adaptar a la arquitectura existente.

---

# 3. Bootstrap Icons

Bootstrap Icons será la librería recomendada para iconografía en ORP UI.

No confundir con Bootstrap CSS.

Bootstrap Icons puede utilizarse de forma independiente.

Instalación:

```bash
npm install bootstrap-icons
```

---

# 4. Import Bootstrap Icons

La aplicación puede importar:

```js
import 'bootstrap-icons/font/bootstrap-icons.css'
```

Preferir que este import ocurra en la aplicación consumidora.

ORP UI no debe cargar Bootstrap Icons automáticamente si el usuario no la utiliza.

---

# 5. ORP Icon primitive

Crear:

```text
orp-icon
```

Objetivo:

Normalizar:

```text
size
alignment
line-height
flex behavior
```

independientemente de la librería utilizada.

Ejemplo:

```html
<i class="bi bi-house orp-icon"></i>
```

---

# 6. Icon CSS

Crear base similar a:

```less
.orp-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    flex: 0 0 auto;

    line-height: 1;

    vertical-align: middle;
}
```

---

# 7. Icon sizes

Crear:

```text
orp-icon--sm
orp-icon--md
orp-icon--lg
orp-icon--xl
```

Valores orientativos:

```less
.orp-icon--sm {
    font-size: 16px;
}

.orp-icon--md {
    font-size: 20px;
}

.orp-icon--lg {
    font-size: 24px;
}

.orp-icon--xl {
    font-size: 32px;
}
```

Si existen tokens de tamaño reutilizables, emplearlos.

---

# 8. No iconos específicos de negocio

NO crear:

```text
orp-icon-home
orp-icon-profile
orp-icon-product
orp-icon-food
```

Los nombres de iconos pertenecen a Bootstrap Icons u otra librería.

ORP solo normaliza presentación.

---

# 9. Icon color

Por defecto:

```text
currentColor
```

Los iconos deben heredar color del componente padre.

No hardcodear colores.

Ejemplo:

```less
.orp-icon {
    color: currentColor;
}
```

---

# 10. Icon + Button

Verificar integración con:

```text
orp-btn
```

Ejemplo:

```html
<button class="orp-btn orp-btn--primary">

    <i
        class="
            bi bi-check-lg
            orp-icon
        "
        aria-hidden="true"
    ></i>

    Guardar

</button>
```

---

# 11. Button spacing

No obligar al usuario a agregar:

```text
orp-mr-2
```

cada vez.

Si Button contiene icono + texto, evaluar:

```text
gap
```

interno.

Ejemplo:

```less
.orp-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--orp-space-2);
}
```

Solo si esto no rompe implementación existente.

---

# 12. IconButton

Actualizar ejemplos de:

```text
OrpIconButton
```

para utilizar Bootstrap Icons.

Ejemplo:

```vue
<OrpIconButton aria-label="Cerrar">

    <i
        class="bi bi-x-lg orp-icon"
        aria-hidden="true"
    ></i>

</OrpIconButton>
```

---

# 13. AppBar icons

Reemplazar ejemplos como:

```text
←
...
+
```

por iconos reales.

Ejemplo:

```html
<i class="bi bi-arrow-left"></i>
<i class="bi bi-three-dots"></i>
<i class="bi bi-plus-lg"></i>
```

---

# 14. BottomNav icons

Ejemplo:

```html
<nav class="orp-bottom-nav">

    <a
        class="
            orp-bottom-nav__item
            orp-bottom-nav__item--active
        "
        aria-current="page"
    >

        <i
            class="
                bi bi-house-fill
                orp-icon
                orp-icon--lg
            "
            aria-hidden="true"
        ></i>

        <span class="orp-bottom-nav__label">
            Inicio
        </span>

    </a>

</nav>
```

---

# 15. Active icons

ORP UI no debe cambiar automáticamente:

```text
bi-house
→ bi-house-fill
```

según estado.

La aplicación decide qué icono utilizar.

---

# 16. Icons en List

Verificar composición:

```html
<div class="orp-list__leading">

    <i
        class="
            bi bi-person
            orp-icon
            orp-icon--lg
        "
    ></i>

</div>
```

---

# 17. Icons en Inputs

Permitir composición visual:

```text
orp-field
orp-input-wrapper
orp-input-icon
```

solo si todavía no existe una solución equivalente.

No modificar forms de forma agresiva.

---

# 18. Input icon primitive

Si existe necesidad repetida, crear:

```text
orp-input-group
orp-input-group__icon
orp-input-group__control
```

NO crear automáticamente si el framework ya tiene una primitive similar.

---

# 19. Accessibility icons

Iconos puramente decorativos:

```html
aria-hidden="true"
```

Botones que solo contienen iconos:

deben tener:

```html
aria-label
```

Ejemplo:

```html
<button
    class="orp-icon-btn"
    aria-label="Eliminar"
>

    <i
        class="bi bi-trash"
        aria-hidden="true"
    ></i>

</button>
```

---

# 20. Icon independence

ORP UI debe permitir también:

```text
inline SVG
custom SVG component
other icon font
other icon library
```

Ejemplo válido:

```html
<span class="orp-icon">
    <svg>...</svg>
</span>
```

Bootstrap Icons es recomendada, no obligatoria.

---

# 21. Bootstrap Icons integration file

Crear:

```text
integrations/bootstrap-icons.less
```

Este archivo NO debe redefinir toda la librería.

Solo aplicar ajustes dentro de contextos ORP si son necesarios.

Ejemplo:

```less
.orp-icon {

    &.bi {
        line-height: 1;
    }

}
```

Mantener integración mínima.

---

# 22. No modificar .bi global

Incorrecto:

```less
.bi {
    font-size: 20px;
}
```

Correcto:

```less
.orp-icon.bi {
    ...
}
```

No afectar aplicaciones externas.

---

# 23. GLightbox

GLightbox será la integración recomendada para:

```text
images
galleries
video
media overlays
```

Instalación:

```bash
npm install glightbox
```

---

# 24. Import GLightbox

La aplicación consumidora puede importar:

```js
import GLightbox from 'glightbox'
import 'glightbox/dist/css/glightbox.min.css'
```

ORP UI no debe inicializar GLightbox automáticamente.

---

# 25. Initialization

Ejemplo:

```js
const lightbox = GLightbox({
    selector: '.orp-lightbox'
})
```

La aplicación controla el lifecycle.

---

# 26. Lightbox trigger

Crear convención:

```text
orp-lightbox
```

Ejemplo:

```html
<a
    href="/images/image-large.jpg"
    class="orp-lightbox"
>

    <div class="orp-media orp-media--square">

        <img
            class="orp-media__content"
            src="/images/image-small.jpg"
            alt="Vista previa"
        >

    </div>

</a>
```

---

# 27. No OrpLightbox.vue

NO crear automáticamente:

```text
OrpLightbox.vue
```

GLightbox ya resuelve el comportamiento.

La aplicación puede crear un wrapper local si necesita lógica propia.

---

# 28. Galleries

Ejemplo:

```html
<div class="orp-scroll-x">

    <a
        href="/images/1-large.jpg"
        class="orp-lightbox"
        data-gallery="gallery-main"
    >
        ...
    </a>

    <a
        href="/images/2-large.jpg"
        class="orp-lightbox"
        data-gallery="gallery-main"
    >
        ...
    </a>

</div>
```

---

# 29. GLightbox + Media Card

Debe funcionar:

```html
<article class="orp-media-card">

    <a
        href="/large.jpg"
        class="
            orp-media-card__media
            orp-lightbox
        "
    >

        <div class="orp-media orp-media--landscape">

            <img
                class="orp-media__content"
                src="/thumb.jpg"
                alt=""
            >

        </div>

    </a>

    <div class="orp-media-card__body">
        ...
    </div>

</article>
```

---

# 30. GLightbox styling

Crear:

```text
integrations/glightbox.less
```

Solo para adaptar visualmente GLightbox a ORP.

No copiar su CSS.

---

# 31. Scope GLightbox adjustments

GLightbox usa elementos propios fuera del árbol ORP.

Por ello, si se requieren overrides globales, deben ser:

```text
mínimos
documentados
```

y únicamente sobre clases de GLightbox.

No reescribir toda la skin.

---

# 32. GLightbox theme alignment

Cuando sea posible adaptar:

```text
buttons
close button
navigation
background
caption
```

a tokens ORP.

Ejemplo conceptual:

```less
.glightbox-container {

    .gbtn {
        color: var(--orp-surface-foreground);
    }

}
```

Solo cuando sea necesario.

---

# 33. GLightbox dark behavior

No asumir que Dark Theme de ORP debe cambiar completamente GLightbox.

GLightbox normalmente funciona sobre overlay oscuro.

Solo corregir inconsistencias claras.

---

# 34. GLightbox accessibility

No desactivar:

```text
keyboard
close controls
focus behavior
```

mediante CSS o configuración.

---

# 35. GLightbox lifecycle Vue

Cuando una aplicación Vue tenga contenido dinámico, documentar que puede necesitar:

```text
destroy
reload
```

según lifecycle de GLightbox.

No incluir esa lógica dentro del core ORP.

---

# 36. Swiper

Swiper seguirá siendo la integración recomendada para:

```text
carousel
slider
hero slides
content slides
```

ORP UI NO debe crear un carousel propio.

---

# 37. Swiper installation

Si la aplicación no lo tiene:

```bash
npm install swiper
```

No instalar automáticamente desde ORP UI si no se utiliza.

---

# 38. Swiper integration file

Mantener:

```text
integrations/swiper.less
```

o crearlo si todavía no existe.

---

# 39. Swiper wrapper

Convención:

```text
orp-swiper
```

Ejemplo:

```html
<div class="swiper orp-swiper">
    ...
</div>
```

---

# 40. Swiper CSS scope

Evitar:

```less
.swiper-pagination-bullet {
    ...
}
```

global.

Preferir:

```less
.orp-swiper {

    .swiper-pagination-bullet {
        ...
    }

}
```

---

# 41. Swiper pagination

Adaptar:

```text
pagination dots
active dot
navigation controls
```

a tokens ORP.

Ejemplo:

```less
.orp-swiper {

    .swiper-pagination-bullet {
        background: var(--orp-muted-foreground);
    }

    .swiper-pagination-bullet-active {
        background: var(--orp-primary);
    }

}
```

---

# 42. Hero + Swiper

Ejemplo:

```html
<div class="swiper orp-swiper">

    <div class="swiper-wrapper">

        <div class="swiper-slide">

            <section class="orp-hero">
                ...
            </section>

        </div>

    </div>

    <div class="swiper-pagination"></div>

</div>
```

---

# 43. Media Card + Swiper

También debe poder utilizarse:

```html
<div class="swiper orp-swiper">

    <div class="swiper-wrapper">

        <div class="swiper-slide">

            <article class="orp-media-card">
                ...
            </article>

        </div>

    </div>

</div>
```

---

# 44. Swiper config pertenece a aplicación

ORP UI no define:

```text
autoplay
loop
slidesPerView
spaceBetween
breakpoints
modules
```

La aplicación controla configuración.

---

# 45. Horizontal Scroll vs Swiper

Documentar diferencia:

```text
orp-scroll-x
→ scroll horizontal simple sin JS
```

```text
Swiper
→ carousel interactivo avanzado
```

Preferir:

```text
orp-scroll-x
```

si solo se necesita scroll horizontal.

---

# 46. GLightbox vs Modal

Documentar:

```text
GLightbox
→ media
```

```text
OrpModal
→ contenido/interacciones de aplicación
```

No usar Modal como visor de imágenes si GLightbox resuelve mejor el caso.

---

# 47. Integration imports

Crear entrypoint opcional:

```text
orp-integrations.less
```

solo si aporta claridad.

Ejemplo:

```less
@import "integrations/bootstrap-icons.less";
@import "integrations/glightbox.less";
@import "integrations/swiper.less";
```

Pero no cargar automáticamente CSS externo de las librerías.

---

# 48. Core vs integrations

Mantener separación:

```text
orp-ui.less
→ Core ORP
```

```text
orp-integrations.less
→ Styling opcional para terceros
```

---

# 49. No dependency coupling

El core debe compilar aunque:

```text
bootstrap-icons
glightbox
swiper
```

NO estén instalados.

---

# 50. Suggested application entry

Ejemplo:

```js
import '@/orp-ui/less/orp-ui.less'
import '@/orp-ui/less/orp-integrations.less'

import 'bootstrap-icons/font/bootstrap-icons.css'

import 'swiper/css'
import 'swiper/css/pagination'

import 'glightbox/dist/css/glightbox.min.css'
```

Adaptar según necesidades reales.

---

# 51. Imports only when used

No cargar todas las integraciones obligatoriamente.

Ejemplo:

si una aplicación no utiliza GLightbox:

NO importarlo.

---

# 52. Playground

Actualizar:

```text
OrpPlayground.vue
```

Agregar categoría:

```text
Integrations
```

---

# 53. Bootstrap Icons Playground

Mostrar iconos dentro de:

```text
Button
IconButton
AppBar
BottomNav
List
Chip
Alert
MediaCard
FAB
```

---

# 54. Icon catalog

NO intentar recrear catálogo completo de Bootstrap Icons.

Solo mostrar ejemplos representativos.

Ejemplo:

```text
Navigation
Actions
Status
Media
Social
```

Un link/documentación externa puede indicar dónde consultar todos los iconos.

---

# 55. GLightbox Playground

Mostrar:

```text
single image
gallery
image inside MediaCard
horizontal gallery
```

No usar contenido de negocio específico.

---

# 56. Swiper Playground

Mostrar:

```text
Hero
Media Cards
Pagination
Navigation
```

No crear configurador gigante.

---

# 57. Integration examples

Utilizar contenido genérico:

```text
Example 1
Featured
Item
Gallery
Slide
```

No amarrar demos a:

```text
restaurant
commerce
real estate
course
```

---

# 58. Theme tests

Probar integración con:

```text
Light
Dark
```

Especialmente:

```text
Bootstrap Icons color inheritance
Swiper pagination
GLightbox triggers
```

---

# 59. Icon contrast

Los iconos deben utilizar:

```text
currentColor
```

y responder correctamente a:

```text
Button variants
Dark mode
Muted content
Danger actions
```

---

# 60. Icon vertical alignment

Probar especialmente:

```text
icons + text
icons inside buttons
icons inside list rows
icons inside badges/chips
```

No deben verse ligeramente más altos/bajos.

---

# 61. Icon touch targets

La primitive:

```text
orp-icon
```

NO define touch target.

El componente contenedor:

```text
orp-icon-btn
orp-btn
orp-bottom-nav__item
```

debe proporcionarlo.

No hacer iconos gigantes para mejorar touch.

---

# 62. No inline sizes everywhere

Evitar:

```html
<i style="font-size: 21px">
```

Preferir:

```text
orp-icon--md
orp-icon--lg
```

---

# 63. SVG compatibility

`.orp-icon` debe funcionar también con SVG.

Ejemplo:

```html
<span class="orp-icon orp-icon--lg">

    <svg
        viewBox="0 0 24 24"
        aria-hidden="true"
    >
        ...
    </svg>

</span>
```

---

# 64. SVG styling

Agregar:

```less
.orp-icon {

    svg {
        width: 1em;
        height: 1em;
        display: block;
    }

}
```

Mantener baja especificidad.

---

# 65. Documentation

Crear:

```text
docs/integrations/
├── bootstrap-icons.md
├── glightbox.md
└── swiper.md
```

---

# 66. Bootstrap Icons docs

Documentar:

```text
Installation
Import
orp-icon
sizes
buttons
navigation
accessibility
SVG alternative
```

---

# 67. GLightbox docs

Documentar:

```text
Installation
Initialization
single image
gallery
Vue dynamic content
destroy/reload
Media integration
accessibility
```

---

# 68. Swiper docs

Documentar:

```text
Installation
Imports
orp-swiper
Hero
MediaCard
Pagination
Horizontal Scroll alternative
```

---

# 69. README

Agregar sección:

```text
Recommended Integrations
```

Con:

```text
Bootstrap Icons
GLightbox
Swiper
```

Explicar que son opcionales.

---

# 70. No wrappers innecesarios

No crear:

```text
OrpBootstrapIcon.vue
OrpLightbox.vue
OrpSwiper.vue
```

solo para envolver librerías existentes.

La composición HTML es suficiente.

---

# 71. Exception wrappers

Si posteriormente existe una necesidad clara de lifecycle Vue, un wrapper puede evaluarse.

Pero NO en esta fase.

---

# 72. Dependency policy

Clasificar integraciones como:

```text
optional integrations
```

No como:

```text
core dependencies
```

---

# 73. Package future

Si ORP UI se distribuye como paquete, considerar:

```text
peerDependencies
optional peerDependencies
```

solo cuando exista una razón real.

No modificar package distribution prematuramente.

---

# 74. GLightbox CSS override audit

No utilizar:

```text
!important
```

salvo que la librería externa lo haga estrictamente necesario.

Si se necesita:

documentar por qué.

---

# 75. Swiper CSS override audit

Misma regla.

Evitar specificity wars.

---

# 76. Native fallback

Si GLightbox no está cargado:

```html
<a href="/large.jpg">
```

debe seguir funcionando como link.

Eso es progressive enhancement.

---

# 77. Swiper fallback

El markup no tiene que ser completamente funcional sin Swiper JS, pero evitar ocultar contenido innecesariamente.

Cuando sea posible, el contenido debe seguir estando en DOM.

---

# 78. Icon fallback

Si Bootstrap Icons no está disponible, el layout no debe colapsar.

Obviamente el glyph no aparecerá, pero ORP UI no debe romperse.

---

# 79. Content Security Policy

No usar CDN obligatorios.

Preferir dependencias locales vía npm.

Esto facilita:

```text
CSP
offline/PWA
version control
build reproducibility
```

---

# 80. No CDN en playground

El Playground debe consumir instalaciones locales.

No:

```text
cdn.jsdelivr.net
unpkg
```

si las dependencias ya existen por npm.

---

# 81. Version audit

Registrar versiones instaladas en documentación del proyecto si aplica.

No hardcodear documentación a una versión exacta salvo que exista necesidad.

---

# 82. Tree shaking

Para Swiper:

importar solo módulos utilizados cuando sea posible.

No obligar a cargar todas sus funcionalidades.

---

# 83. GLightbox loading

GLightbox puede cargarse solo en páginas que realmente lo utilicen.

No exigir bundle global.

---

# 84. Bootstrap Icons tradeoff

Bootstrap Icons usa icon font cuando se importa el CSS completo.

Documentar que también puede utilizarse SVG individual si una aplicación requiere optimización extrema.

No complicar ORP UI por esto.

---

# 85. ORP icon API

La API de estilos debe permanecer extremadamente simple:

```text
orp-icon
orp-icon--sm
orp-icon--md
orp-icon--lg
orp-icon--xl
```

No crear:

```text
orp-icon--rotate
orp-icon--spin
orp-icon--flip
orp-icon--pulse
orp-icon--bounce
```

todavía.

---

# 86. Spinner vs icon spin

Loading debe seguir utilizando:

```text
orp-spinner
```

No convertir cualquier Bootstrap Icon en spinner.

---

# 87. Social icons

Bootstrap Icons puede utilizarse para social icons.

ORP UI no crea clases:

```text
orp-facebook
orp-instagram
```

Ejemplo:

```html
<i class="bi bi-instagram orp-icon"></i>
```

---

# 88. Branding icons

Logos específicos pertenecen a la aplicación.

No formar parte del core.

---

# 89. Build

Ejecutar build existente.

Confirmar:

```text
ORP core compila
integrations compile
Bootstrap Icons load
GLightbox works
Swiper works
```

---

# 90. Bundle report

Reportar aproximadamente:

```text
ORP CSS
integration CSS
external library CSS
external JS
```

cuando sea fácil obtenerlo.

No optimizar prematuramente.

---

# 91. Regression audit

Después de integrar iconos verificar:

```text
Button
IconButton
AppBar
BottomNav
List
Dropdown
Popover
Drawer
Modal
Sheet
Alert
Toast
FAB
MediaCard
```

---

# 92. Replace ugly placeholder icons

En Playground reemplazar:

```text
←
→
+
×
...
★
```

cuando sean iconos de UI.

Por Bootstrap Icons equivalentes.

---

# 93. Do not replace textual symbols blindly

No reemplazar símbolos cuando realmente sean contenido.

Ejemplo:

```text
rating star
```

puede ser Unicode si eso sigue siendo apropiado.

Usar criterio.

---

# 94. Playground isolation

No utilizar Bootstrap CSS.

Solo:

```text
Bootstrap Icons
```

El playground debe continuar demostrando que ORP UI funciona sin Bootstrap framework.

---

# 95. No accidental Bootstrap dependency

Auditar imports.

No debe existir:

```js
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.css'
```

como consecuencia de integrar Bootstrap Icons.

Solo:

```js
import 'bootstrap-icons/font/bootstrap-icons.css'
```

---

# 96. Expected files

Resultado posible:

```text
less/
├── components/
│   └── icon.less
│
└── integrations/
    ├── bootstrap-icons.less
    ├── glightbox.less
    └── swiper.less
```

Más documentación correspondiente.

---

# 97. Public CSS

Agregar:

```text
orp-icon
```

al core.

Integraciones externas quedan separadas.

---

# 98. Public JS API

No agregar exports Vue nuevos en esta fase.

No debería ser necesario modificar:

```text
index.js
```

salvo documentación/export organization.

---

# 99. Integration initialization

ORP UI no ejecuta automáticamente:

```js
GLightbox()
new Swiper()
```

La aplicación controla inicialización.

---

# 100. Vue lifecycle example

Documentar ejemplo genérico:

```vue
<script setup>
import { onMounted, onBeforeUnmount } from 'vue'
import GLightbox from 'glightbox'

let lightbox = null

onMounted(() => {

    lightbox = GLightbox({
        selector: '.orp-lightbox'
    })

})

onBeforeUnmount(() => {

    lightbox?.destroy()

})
</script>
```

Solo como ejemplo de aplicación.

No convertirlo en core.

---

# 101. Generic Swiper example

```vue
<script setup>
import { onMounted } from 'vue'
import Swiper from 'swiper'
import { Pagination } from 'swiper/modules'

onMounted(() => {

    new Swiper('.example-swiper', {
        modules: [Pagination],
        pagination: {
            el: '.swiper-pagination'
        }
    })

})
</script>
```

Adaptar a la API real de la versión instalada.

No asumir configuración si ya existe implementación distinta.

---

# 102. Integration philosophy documentation

Agregar esta regla al proyecto:

```text
ORP UI should not recreate mature specialized libraries.
```

Antes de crear funcionalidad compleja preguntar:

```text
¿Existe una librería pequeña, estable y especializada que ya haga esto bien?
```

Si sí:

evaluar integración.

---

# 103. What ORP owns

ORP UI es responsable de:

```text
visual consistency
tokens
spacing
responsive behavior
accessibility integration
component composition
integration styling
```

---

# 104. What external library owns

Las librerías son responsables de:

```text
icons
carousel engine
lightbox engine
gesture handling
specialized behavior
```

---

# 105. No domain coupling

Las integraciones deben continuar siendo genéricas.

No crear:

```text
orp-product-gallery
orp-property-lightbox
orp-food-slider
```

Correcto:

```text
orp-lightbox
orp-swiper
orp-media
```

---

# 106. Criteria Bootstrap Icons

Antes de finalizar verificar:

```text
icon sizes
color inheritance
alignment
buttons
navigation
SVG compatibility
accessibility
```

---

# 107. Criteria GLightbox

Verificar:

```text
single image
gallery
keyboard
close
mobile
Media integration
Vue lifecycle example
```

---

# 108. Criteria Swiper

Verificar:

```text
Hero
MediaCard
pagination
mobile swipe
responsive layout
theme integration
```

---

# 109. Result expected

Al finalizar entregar:

## Dependencies

Indicar cuáles fueron instaladas.

## Files created

Lista.

## Files modified

Lista.

## Icon System

Documentar:

```text
orp-icon
orp-icon--sm
orp-icon--md
orp-icon--lg
orp-icon--xl
```

## Bootstrap Icons

Confirmar integración.

## GLightbox

Confirmar funcionamiento.

## Swiper

Confirmar integración.

## Playground

Indicar ejemplos agregados.

## Accessibility

Indicar revisión.

## Themes

Confirmar light/dark.

## Build

Indicar resultado.

## Bundle

Indicar impacto aproximado si está disponible.

## Conflicts

Reportar cualquier problema.

---

# 110. Alcance final Parte 8

La Parte 8 termina cuando existan:

```text
Icon System
├── orp-icon
├── Sizes
└── Bootstrap Icons integration

Media Integration
├── orp-lightbox convention
└── GLightbox integration

Carousel Integration
├── orp-swiper
└── Swiper skin
```

y estén documentadas.

No continuar automáticamente con otra fase.

---

# Regla final

ORP UI no debe competir con librerías especializadas.

La estrategia es:

```text
Bootstrap Icons
→ icons

GLightbox
→ media overlay

Swiper
→ slider/carousel

ORP UI
→ cohesive visual system
```

Todas las integraciones deben ser:

```text
optional
isolated
replaceable
generic
reusable
```

Mantener siempre:

```text
orp-
@orp-
--orp-
Orp*
```

y evitar introducir Bootstrap CSS o cualquier dependencia de framework solo por utilizar Bootstrap Icons.
