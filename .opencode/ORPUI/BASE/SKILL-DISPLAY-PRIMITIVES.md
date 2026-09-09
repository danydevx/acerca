# SKILL — ORP UI / Parte 10: Navigation Primitives

## Objetivo

Extender ORP UI con primitives de navegación reutilizables y desacopladas del router.

Implementar:

```text
Navigation
├── Breadcrumb
├── Pagination
├── Navigation List
├── Navigation Group
├── Navigation Rail
├── Stepper
└── Back / Forward action patterns
```

No implementar routing.

No importar:

```text
@inertiajs/vue3
vue-router
Laravel routes
```

La aplicación decide navegación y URLs.

---

# 1. Principio principal

ORP UI representa navegación.

La aplicación ejecuta navegación.

Ejemplo correcto:

```html
<a href="/profile" class="orp-nav-item">
    Perfil
</a>
```

También correcto en Vue:

```vue
<button
    class="orp-nav-item"
    @click="goProfile"
>
    Perfil
</button>
```

ORP UI no debe saber qué hace `goProfile`.

---

# 2. Namespace

Mantener:

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

---

# 3. Filosofía CSS-first

Esta fase debe ser mayormente:

```text
HTML + LESS
```

Crear Vue solamente si existe estado que realmente lo justifique.

No crear automáticamente:

```text
OrpBreadcrumb.vue
OrpPagination.vue
OrpNavigationList.vue
```

si HTML semántico + CSS es suficiente.

---

# 4. Breadcrumb

Crear:

```text
orp-breadcrumb
```

Objetivo:

Representar jerarquía de navegación.

Ejemplo:

```html
<nav
    class="orp-breadcrumb"
    aria-label="Breadcrumb"
>
    <ol class="orp-breadcrumb__list">

        <li class="orp-breadcrumb__item">

            <a
                href="/"
                class="orp-breadcrumb__link"
            >
                Inicio
            </a>

        </li>

        <li class="orp-breadcrumb__item">

            <a
                href="/cuenta"
                class="orp-breadcrumb__link"
            >
                Cuenta
            </a>

        </li>

        <li
            class="
                orp-breadcrumb__item
                orp-breadcrumb__item--current
            "
            aria-current="page"
        >
            Perfil
        </li>

    </ol>
</nav>
```

---

# 5. Breadcrumb structure

Crear:

```text
orp-breadcrumb
orp-breadcrumb__list
orp-breadcrumb__item
orp-breadcrumb__link
orp-breadcrumb__separator
orp-breadcrumb__item--current
```

---

# 6. Breadcrumb separator

El separador debe ser puramente visual.

Puede utilizar:

```text
Bootstrap Icons
```

si la integración está disponible.

Ejemplo:

```html
<i
    class="bi bi-chevron-right orp-icon"
    aria-hidden="true"
></i>
```

También debe poder funcionar sin icon library.

---

# 7. Breadcrumb accessibility

Usar:

```html
<nav aria-label="Breadcrumb">
```

y:

```html
aria-current="page"
```

en el elemento actual.

El separador no debe ser leído innecesariamente por screen readers.

---

# 8. Breadcrumb mobile

En pantallas pequeñas evitar que destruya layout.

Evaluar:

```text
horizontal scroll
ellipsis
collapsed middle items
```

Pero no implementar JS de colapsado todavía.

La solución inicial puede permitir overflow horizontal controlado.

---

# 9. Pagination

Crear:

```text
orp-pagination
```

Debe servir tanto para páginas tradicionales como datasets.

---

# 10. Pagination structure

```text
orp-pagination
orp-pagination__list
orp-pagination__item
orp-pagination__link
orp-pagination__item--active
orp-pagination__item--disabled
orp-pagination__ellipsis
```

---

# 11. Pagination example

```html
<nav
    class="orp-pagination"
    aria-label="Paginación"
>
    <ul class="orp-pagination__list">

        <li class="orp-pagination__item">

            <a
                href="?page=1"
                class="orp-pagination__link"
                aria-label="Página anterior"
            >
                <i
                    class="bi bi-chevron-left orp-icon"
                    aria-hidden="true"
                ></i>
            </a>

        </li>

        <li
            class="
                orp-pagination__item
                orp-pagination__item--active
            "
        >
            <a
                href="?page=2"
                class="orp-pagination__link"
                aria-current="page"
            >
                2
            </a>
        </li>

    </ul>
</nav>
```

---

# 12. Pagination states

Soportar:

```text
active
disabled
hover
focus-visible
```

No usar `.active` global.

---

# 13. Pagination mobile

Los targets deben mantener tamaño táctil razonable.

No intentar mostrar 20 páginas en móvil.

ORP UI solo da estilos.

La aplicación decide qué páginas renderizar.

---

# 14. Pagination compact

Permitir modifier opcional:

```text
orp-pagination--compact
```

solo si aporta valor.

No crear múltiples tamaños sin necesidad.

---

# 15. Navigation List

Crear:

```text
orp-nav
```

Objetivo:

Ser una primitive genérica para navegación vertical u horizontal.

---

# 16. Navigation structure

Crear:

```text
orp-nav
orp-nav__item
orp-nav__link
orp-nav__icon
orp-nav__label
orp-nav__meta
orp-nav__badge
orp-nav__group
orp-nav__group-title
```

---

# 17. Navigation example

```html
<nav class="orp-nav">

    <a
        href="/"
        class="
            orp-nav__link
            orp-nav__link--active
        "
        aria-current="page"
    >

        <span class="orp-nav__icon">

            <i
                class="bi bi-house orp-icon"
                aria-hidden="true"
            ></i>

        </span>

        <span class="orp-nav__label">
            Inicio
        </span>

    </a>

</nav>
```

---

# 18. Navigation variants

Inicialmente:

```text
orp-nav--vertical
orp-nav--horizontal
```

Default puede ser vertical si eso encaja mejor con implementación existente.

---

# 19. Navigation active state

Usar:

```text
orp-nav__link--active
```

y:

```html
aria-current="page"
```

cuando corresponda.

---

# 20. Navigation disabled

Si existe item no disponible:

preferir:

```text
disabled button
```

si es acción.

Para links, evitar links falsamente clickeables.

Puede utilizar:

```text
aria-disabled="true"
```

y comportamiento adecuado.

---

# 21. Navigation Group

Crear:

```text
orp-nav-group
```

o utilizar:

```text
orp-nav__group
```

Elegir UNA convención.

Preferencia:

```text
orp-nav__group
```

si siempre vive dentro de navegación.

---

# 22. Navigation Group title

Ejemplo:

```html
<div class="orp-nav__group">

    <div class="orp-nav__group-title">
        Cuenta
    </div>

    <a class="orp-nav__link">
        Perfil
    </a>

    <a class="orp-nav__link">
        Seguridad
    </a>

</div>
```

---

# 23. No business naming

No crear:

```text
orp-admin-nav
orp-account-nav
orp-shop-nav
orp-course-nav
```

Correcto:

```text
orp-nav
orp-nav__group
```

---

# 24. Nav inside Sidebar

`orp-nav` debe funcionar dentro de:

```text
orp-app-shell__sidebar
```

sin estilos especiales específicos del shell.

---

# 25. Nav inside Drawer

También debe funcionar dentro de:

```text
OrpDrawer
```

sin duplicar implementación.

---

# 26. Navigation Rail

Crear:

```text
orp-nav-rail
```

Objetivo:

Navegación vertical compacta basada principalmente en iconos.

Útil para layouts desktop/tablet.

---

# 27. Navigation Rail structure

```text
orp-nav-rail
orp-nav-rail__item
orp-nav-rail__icon
orp-nav-rail__label
orp-nav-rail__item--active
```

---

# 28. Navigation Rail example

```html
<nav
    class="orp-nav-rail"
    aria-label="Navegación principal"
>

    <a
        href="/"
        class="
            orp-nav-rail__item
            orp-nav-rail__item--active
        "
        aria-current="page"
    >

        <i
            class="
                bi bi-house
                orp-icon
                orp-icon--lg
            "
            aria-hidden="true"
        ></i>

        <span class="orp-nav-rail__label">
            Inicio
        </span>

    </a>

</nav>
```

---

# 29. Rail vs BottomNav

Documentar:

```text
BottomNav
→ mobile bottom navigation
```

```text
Navigation Rail
→ compact vertical navigation
```

No hacer que uno se transforme mágicamente en el otro.

---

# 30. Navigation Rail dimensions

Agregar token solo si hace falta:

```text
--orp-nav-rail-width
```

Valor inicial orientativo:

```text
72px
```

No hardcodear en múltiples lugares.

---

# 31. Navigation Rail touch

Aunque se use en desktop/tablet:

mantener targets cómodos.

No reducir item al tamaño exacto del icono.

---

# 32. Navigation Rail labels

Puede tener:

```text
icon + small label
```

No convertirlo en sidebar completo.

Sidebar + `orp-nav` cubre navegación más extensa.

---

# 33. Stepper

Crear:

```text
orp-stepper
```

Objetivo:

Representar progreso entre pasos.

Debe ser genérico.

Puede servir para:

```text
setup
checkout
form flow
onboarding
configuration
process
```

pero no conocer el significado.

---

# 34. Stepper structure

Crear:

```text
orp-stepper
orp-stepper__item
orp-stepper__indicator
orp-stepper__number
orp-stepper__icon
orp-stepper__content
orp-stepper__title
orp-stepper__description
orp-stepper__connector
```

---

# 35. Stepper states

Modifiers:

```text
orp-stepper__item--active
orp-stepper__item--complete
orp-stepper__item--disabled
```

No usar clases globales.

---

# 36. Stepper example

```html
<ol class="orp-stepper">

    <li
        class="
            orp-stepper__item
            orp-stepper__item--complete
        "
    >

        <div class="orp-stepper__indicator">

            <i
                class="bi bi-check orp-icon"
                aria-hidden="true"
            ></i>

        </div>

        <div class="orp-stepper__content">

            <div class="orp-stepper__title">
                Información
            </div>

        </div>

    </li>

    <li
        class="
            orp-stepper__item
            orp-stepper__item--active
        "
        aria-current="step"
    >

        <div class="orp-stepper__indicator">
            2
        </div>

        <div class="orp-stepper__content">

            <div class="orp-stepper__title">
                Detalles
            </div>

        </div>

    </li>

</ol>
```

---

# 37. Stepper semantics

Preferir:

```html
<ol>
```

porque representa secuencia.

Usar:

```html
aria-current="step"
```

para paso actual.

---

# 38. Stepper horizontal

Crear:

```text
orp-stepper--horizontal
```

---

# 39. Stepper vertical

Crear:

```text
orp-stepper--vertical
```

---

# 40. Stepper responsive

En móvil:

horizontal puede ser útil para pocos pasos.

Para muchos pasos:

vertical puede ser más legible.

ORP no debe decidir automáticamente sin necesidad.

---

# 41. Stepper no wizard

Stepper es visual.

NO controlar:

```text
next
previous
validation
form state
API calls
```

La aplicación controla flujo.

---

# 42. Interactive Stepper

Si los pasos son clickeables:

usar:

```html
button
```

o:

```html
a
```

según contexto.

No hacer clickeable un `div`.

---

# 43. Back action pattern

No crear necesariamente un nuevo componente.

Documentar composición:

```html
<button
    class="orp-icon-btn"
    aria-label="Volver"
>

    <i
        class="
            bi bi-arrow-left
            orp-icon
        "
        aria-hidden="true"
    ></i>

</button>
```

---

# 44. Back / Forward icons

Bootstrap Icons recomendados:

```text
bi-arrow-left
bi-arrow-right
bi-chevron-left
bi-chevron-right
```

La aplicación decide semántica exacta.

---

# 45. Directional logical considerations

Preparar para futuro RTL.

Evitar asumir siempre que:

```text
left = back
right = forward
```

en arquitectura interna.

La aplicación puede elegir iconos según dirección.

---

# 46. Navigation tokens

Agregar solo si hacen falta.

Posibles:

```text
--orp-nav-item-height
--orp-nav-rail-width
--orp-stepper-indicator-size
```

No duplicar spacing/radius tokens.

---

# 47. Navigation item height

Referencia:

```text
44px - 48px
```

para targets principales.

No imponer exactamente el mismo tamaño a todos los componentes si visualmente no corresponde.

---

# 48. Icon system

Usar:

```text
orp-icon
```

existente.

No crear nuevos helpers de iconos para navegación.

---

# 49. Badge integration

Navigation debe aceptar:

```text
orp-badge
```

Ejemplo:

```html
<span class="orp-nav__badge">

    <span class="orp-badge orp-badge--danger">
        3
    </span>

</span>
```

---

# 50. Nav metadata

`orp-nav__meta` puede contener:

```text
shortcut
count
small state
text
```

No asumir negocio.

---

# 51. Navigation + Tooltip

Navigation Rail con icon-only podría necesitar tooltip.

NO implementar tooltip propio en esta fase.

Si label está visible, tooltip no es necesario.

Si en el futuro existe modo icon-only, evaluar integración posterior.

---

# 52. Breadcrumb + AppBar

En desktop puede componerse:

```html
<header class="orp-app-shell__header">

    <div class="orp-app-bar">
        ...
    </div>

    <nav class="orp-breadcrumb">
        ...
    </nav>

</header>
```

No acoplar Breadcrumb a AppBar.

---

# 53. Breadcrumb + PageContent

También puede vivir dentro de:

```text
orp-page-content
```

La aplicación decide.

---

# 54. Pagination + Section

Debe funcionar dentro de:

```text
orp-section__footer
```

sin hacks.

---

# 55. Pagination + Card

También puede vivir dentro de card/footer.

No crear variant específica.

---

# 56. Navigation states consistency

Usar semantic tokens existentes.

Por ejemplo:

```text
--orp-primary
--orp-muted
--orp-muted-foreground
--orp-surface
--orp-border
--orp-ring
```

---

# 57. Active states

No utilizar únicamente color.

Puede combinar:

```text
background
font weight
indicator
icon fill
```

según componente.

---

# 58. Focus

Todos los links/buttons deben tener:

```text
:focus-visible
```

utilizando:

```text
--orp-ring
```

---

# 59. Hover

Hover es complemento.

No debe ser requisito para entender navegación.

---

# 60. Touch

Revisar especialmente:

```text
Pagination
Navigation items
Rail items
Stepper interactive items
Breadcrumb links
```

---

# 61. Mobile nav overflow

Horizontal navigation puede utilizar:

```text
overflow-x: auto
```

cuando tenga demasiados items.

No comprimir labels indefinidamente.

---

# 62. Horizontal nav

`orp-nav--horizontal` puede integrarse con scroll-x behavior si hace falta.

No duplicar lógica.

---

# 63. Navigation separator

No crear divisores específicos cuando:

```text
orp-divider
```

ya existe.

Componer.

---

# 64. Navigation groups spacing

Usar:

```text
Stack
spacing tokens
```

cuando sea posible.

---

# 65. No routing hooks

No crear:

```text
useOrpNavigation()
useOrpRouter()
```

ORP UI no es router.

---

# 66. No route detection

No intentar detectar URL actual mediante:

```js
window.location.pathname
```

para agregar active states automáticamente.

La aplicación proporciona estado activo.

---

# 67. No global navigation configuration

No crear:

```js
const navItems = [...]
```

global dentro del framework.

Eso pertenece a cada aplicación.

---

# 68. CSS architecture

Agregar archivos similares a:

```text
less/
└── components/
    ├── breadcrumb.less
    ├── pagination.less
    ├── nav.less
    ├── nav-rail.less
    └── stepper.less
```

Adaptar según estructura existente.

---

# 69. No Vue exports needed

Esta fase idealmente no agrega nuevos exports Vue.

Si toda implementación es CSS-first:

```text
index.js
```

no debería necesitar cambios relevantes.

---

# 70. Playground

Agregar categoría:

```text
Navigation
```

al playground.

---

# 71. Breadcrumb playground

Mostrar:

```text
2 levels
4 levels
long title
current page
with Bootstrap Icon separator
mobile overflow
```

---

# 72. Pagination playground

Mostrar:

```text
basic
active
disabled previous
ellipsis
many pages
compact if implemented
```

---

# 73. Navigation List playground

Mostrar:

```text
vertical
horizontal
icons
badge
groups
active
disabled
```

---

# 74. Navigation Rail playground

Mostrar:

```text
3 items
5 items
active
badge
icons
```

---

# 75. Stepper playground

Mostrar:

```text
horizontal
vertical
active
complete
disabled
3 steps
5 steps
```

---

# 76. Generic demo content

Usar labels genéricas:

```text
Inicio
Explorar
Actividad
Perfil
Configuración
Detalles
Confirmación
```

No crear ejemplos ligados a rubros concretos.

---

# 77. AppShell integration demo

Crear demo:

```text
Desktop:
Sidebar / Navigation Rail + Main

Mobile:
BottomNav + Main
```

Solo para demostrar composición.

No hacer responsive router logic.

---

# 78. Responsive testing

Probar:

```text
320px
375px
390px
430px
768px
1024px
1280px
1440px
```

---

# 79. Breadcrumb stress test

Probar:

```text
very long labels
many levels
```

Evitar romper layout.

---

# 80. Pagination stress test

Probar:

```text
1 page
3 pages
50 pages represented selectively
```

ORP UI no genera números automáticamente.

---

# 81. Navigation stress test

Probar:

```text
long labels
icon + label
badge
multiple groups
```

---

# 82. Stepper stress test

Probar:

```text
long titles
long descriptions
5 steps
```

---

# 83. Theme testing

Verificar:

```text
Light
Dark
Custom
```

Todos los navigation primitives deben responder a semantic tokens.

---

# 84. Bootstrap Icons integration

Usar Bootstrap Icons en ejemplos.

Pero componentes deben seguir funcionando con:

```text
SVG
text
other icon libraries
```

---

# 85. No Bootstrap CSS

Auditar playground.

No utilizar:

```text
nav
pagination
breadcrumb
d-flex
gap-*
```

de Bootstrap.

Solo:

```text
orp-*
```

más Bootstrap Icons.

---

# 86. Accessibility audit

Revisar:

```text
aria-current
aria-label
semantic nav
ordered lists
focus
keyboard
touch
```

---

# 87. Breadcrumb semantics

Breadcrumb debe usar:

```text
nav + ol
```

preferentemente.

---

# 88. Pagination semantics

Pagination debe usar:

```text
nav
```

con label descriptivo.

---

# 89. Navigation semantics

No añadir:

```text
role="navigation"
```

si ya se utiliza `<nav>` sin necesidad.

Evitar ARIA redundante.

---

# 90. Stepper accessibility

No inventar roles ARIA inexistentes.

Usar HTML semántico +:

```text
aria-current="step"
```

cuando aplique.

---

# 91. Current state

No depender únicamente de:

```text
font-weight
color
```

para usuarios con dificultades visuales.

---

# 92. Reduced motion

Esta fase debería necesitar prácticamente cero animación.

Si se agrega transition:

respetar tokens existentes.

---

# 93. Build

Ejecutar build.

Confirmar:

```text
LESS compiles
Vite succeeds
Dark mode works
Bootstrap Icons still work
```

---

# 94. Bundle

JS nuevo esperado:

```text
0
```

o prácticamente cero.

CSS growth debe reportarse.

---

# 95. Documentation

Crear:

```text
docs/navigation/
├── breadcrumb.md
├── pagination.md
├── navigation.md
├── navigation-rail.md
└── stepper.md
```

---

# 96. Navigation documentation

Explicar diferencia entre:

```text
BottomNav
Navigation List
Navigation Rail
Breadcrumb
Stepper
```

---

# 97. BottomNav vs Navigation Rail

Documentar:

```text
BottomNav
→ primary mobile navigation
```

```text
Navigation Rail
→ compact vertical navigation
```

---

# 98. Breadcrumb vs Navigation

```text
Breadcrumb
→ location/hierarchy
```

```text
Navigation
→ destinations/actions
```

---

# 99. Stepper vs Tabs

```text
Tabs
→ parallel content sections
```

```text
Stepper
→ sequential process
```

---

# 100. Pagination vs Load More

ORP UI implementa Pagination.

No implementar Load More behavior.

La aplicación puede utilizar:

```text
orp-btn
```

para un patrón de cargar más.

---

# 101. Infinite Scroll

NO implementar infinite scroll en esta fase.

Es comportamiento de aplicación/datos.

---

# 102. Result expected

Al finalizar entregar:

## Files created

Lista.

## Files modified

Lista.

## Navigation primitives

```text
orp-breadcrumb
orp-pagination
orp-nav
orp-nav-rail
orp-stepper
```

## Tokens

Listar únicamente nuevos tokens.

## Playground

Listar demos.

## Responsive

Indicar pruebas.

## Themes

Confirmar light/dark.

## Accessibility

Indicar checks.

## Build

Reportar resultado.

## Bundle

Reportar impacto CSS/JS.

## Conflicts

Reportar cualquier problema.

---

# 103. Completion criteria

Parte 10 termina cuando existan:

```text
Navigation
├── Breadcrumb
├── Pagination
├── Navigation List
├── Navigation Groups
├── Navigation Rail
└── Stepper
```

y puedan componerse con:

```text
AppShell
AppBar
BottomNav
Drawer
Sidebar
PageContent
```

sin routing interno.

---

# Regla final

ORP UI debe proporcionar navegación visual.

Nunca controlar navegación real.

Mantener separación:

```text
ORP UI
→ appearance + states + semantics
```

```text
Application
→ URLs + router + permissions + active route
```

No crear:

```text
orp-admin-nav
orp-shop-nav
orp-user-navigation
orp-course-stepper
```

Crear únicamente primitives genéricas:

```text
orp-nav
orp-breadcrumb
orp-pagination
orp-nav-rail
orp-stepper
```

Mantener ORP UI:

```text
generic
composable
mobile-first
accessible
router-independent
low-dependency
```
