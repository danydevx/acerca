
# SKILL — ORP UI / Parte 2: Navigation & Content

## Objetivo

Extender ORP UI sobre la Foundation creada en la Parte 1.

Esta fase debe agregar únicamente componentes esenciales de navegación y contenido mobile-first.

No modificar la filosofía, namespace ni arquitectura base.

Toda nueva clase debe seguir usando:

```text
orp-
```

Toda variable LESS:

```text
@orp-
```

Toda CSS Custom Property:

```text
--orp-
```

---

# 1. Alcance de esta fase

Implementar únicamente:

```text
Navigation
├── AppBar
└── BottomNav

Content
├── Avatar
├── Badge
└── List
```

Actualizar también el playground existente para mostrar estos componentes.

NO implementar todavía:

```text
Modal
Sheet
Tabs
Dropdown
Toast
Accordion
Drawer
Offcanvas
Carousel
Forms avanzados
Theme manager
Router integration
```

---

# 2. Regla principal

Antes de crear componentes Vue, evaluar si el componente puede resolverse correctamente con HTML semántico + CSS.

Preferir CSS para:

```text
Avatar
Badge
List
AppBar visual
```

Crear Vue únicamente si el comportamiento realmente lo justifica.

BottomNav puede comenzar como HTML + CSS.

No debe conocer Inertia, Vue Router ni Laravel.

---

# 3. AppBar

Crear el componente CSS:

```text
orp-app-bar
```

Objetivo:

Crear una barra superior mobile-first para interfaces tipo aplicación.

Debe soportar:

```text
leading action
title
subtitle opcional
trailing actions
sticky opcional
```

Estructura sugerida:

```html
<header class="orp-app-bar">

    <div class="orp-app-bar__leading">
        ...
    </div>

    <div class="orp-app-bar__content">
        <h1 class="orp-app-bar__title">
            Mi cuenta
        </h1>
    </div>

    <div class="orp-app-bar__actions">
        ...
    </div>

</header>
```

---

# 4. AppBar modifiers

Crear inicialmente:

```text
orp-app-bar--sticky
orp-app-bar--transparent
orp-app-bar--bordered
```

No crear más variantes sin necesidad.

---

# 5. AppBar dimensiones

Agregar tokens:

```less
@orp-app-bar-height: 56px;
```

Y CSS Custom Property:

```css
--orp-app-bar-height
```

Touch targets internos:

```text
mínimo aproximado 44x44px
```

para botones de navegación o acciones.

---

# 6. Safe Area en AppBar

Considerar:

```css
env(safe-area-inset-top)
```

Especialmente si se utiliza en una PWA fullscreen.

Ejemplo conceptual:

```less
.orp-app-bar {
    padding-top: env(safe-area-inset-top);
}
```

No duplicar padding cuando la aplicación ya maneje safe areas externamente.

Mantener implementación simple y documentar el comportamiento.

---

# 7. AppBar title

Crear:

```text
orp-app-bar__title
orp-app-bar__subtitle
```

El título debe:

* truncar correctamente textos largos;
* evitar romper el layout;
* mantener jerarquía visual clara.

Ejemplo:

```less
.orp-app-bar__title {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
```

---

# 8. Bottom Navigation

Crear:

```text
orp-bottom-nav
```

Debe funcionar como navegación inferior mobile-first.

Estructura sugerida:

```html
<nav class="orp-bottom-nav">

    <button class="orp-bottom-nav__item orp-bottom-nav__item--active">
        <span class="orp-bottom-nav__icon">
            ...
        </span>

        <span class="orp-bottom-nav__label">
            Inicio
        </span>
    </button>

</nav>
```

---

# 9. BottomNav items

Cada item debe soportar:

```text
icon
label
active state
badge opcional
disabled opcional
```

Clases:

```text
orp-bottom-nav__item
orp-bottom-nav__icon
orp-bottom-nav__label
orp-bottom-nav__badge
```

Modifier:

```text
orp-bottom-nav__item--active
```

No usar:

```text
.active
```

global.

---

# 10. BottomNav no controla routing

Regla obligatoria:

ORP UI no debe decidir cómo navega la aplicación.

Incorrecto:

```js
router.visit('/home')
```

dentro del componente.

Correcto:

```html
<button
    class="orp-bottom-nav__item"
    @click="goHome"
>
```

La aplicación decide la navegación.

---

# 11. BottomNav fixed

Crear opcionalmente:

```text
orp-bottom-nav--fixed
```

Debe:

* fijarse al fondo;
* respetar safe area inferior;
* evitar quedar tapado por barras del dispositivo;
* tener z-index razonable.

Agregar token:

```less
@orp-bottom-nav-height: 64px;
```

CSS variable:

```css
--orp-bottom-nav-height
```

---

# 12. Safe Area BottomNav

Considerar:

```css
env(safe-area-inset-bottom)
```

Ejemplo:

```less
.orp-bottom-nav {
    padding-bottom: env(safe-area-inset-bottom);
}
```

La altura visual no debe quedar inconsistente entre Android, iOS y desktop.

---

# 13. BottomNav responsive

BottomNav está pensado principalmente para móvil.

En desktop:

* puede seguir funcionando;
* no debe romper;
* no debe crecer excesivamente.

No implementar automáticamente una transformación completa a sidebar.

Eso corresponde a una futura fase.

---

# 14. Avatar

Crear:

```text
orp-avatar
```

Debe funcionar con:

```html
<div class="orp-avatar">
    <img src="..." alt="Nombre">
</div>
```

Variantes iniciales de tamaño:

```text
orp-avatar--sm
orp-avatar--md
orp-avatar--lg
orp-avatar--xl
```

---

# 15. Avatar fallback

Debe poder utilizarse sin imagen.

Ejemplo:

```html
<div class="orp-avatar orp-avatar--md">
    <span class="orp-avatar__fallback">
        DL
    </span>
</div>
```

Crear:

```text
orp-avatar__image
orp-avatar__fallback
```

No implementar lógica automática para generar iniciales en CSS.

Eso corresponde a la aplicación o un futuro componente Vue.

---

# 16. Avatar status

Permitir indicador visual:

```text
orp-avatar__status
```

Modifiers iniciales:

```text
orp-avatar__status--online
orp-avatar__status--offline
orp-avatar__status--busy
```

No crear estados adicionales sin necesidad.

---

# 17. Badge

Crear:

```text
orp-badge
```

Variantes iniciales:

```text
orp-badge--primary
orp-badge--secondary
orp-badge--success
orp-badge--warning
orp-badge--danger
```

Opcionalmente:

```text
orp-badge--outline
```

---

# 18. Badge tamaño

Mantener Badge pequeño.

No necesita inicialmente:

```text
sm
md
lg
xl
```

si no existe una necesidad real.

Debe funcionar bien dentro de:

```text
cards
lists
bottom navigation
headings
```

---

# 19. Badge semántica

No utilizar color como único indicador cuando represente estados importantes.

Ejemplo:

Correcto:

```html
<span class="orp-badge orp-badge--success">
    Activo
</span>
```

No depender únicamente de un punto verde sin texto cuando la información sea importante.

---

# 20. List

Crear un componente visual flexible:

```text
orp-list
```

Debe servir para interfaces como:

```text
settings
contacts
menus
actions
navigation
simple data lists
```

Estructura sugerida:

```html
<div class="orp-list">

    <div class="orp-list__item">

        <div class="orp-list__leading">
            ...
        </div>

        <div class="orp-list__content">

            <div class="orp-list__title">
                Perfil
            </div>

            <div class="orp-list__subtitle">
                Editar información personal
            </div>

        </div>

        <div class="orp-list__trailing">
            ...
        </div>

    </div>

</div>
```

---

# 21. List elementos

Crear:

```text
orp-list
orp-list__item
orp-list__leading
orp-list__content
orp-list__title
orp-list__subtitle
orp-list__trailing
```

No crear estructuras innecesariamente profundas.

---

# 22. List variants

Crear inicialmente:

```text
orp-list--divided
orp-list--inset
```

No crear más variantes hasta necesitarlas.

---

# 23. Interactive List Item

Permitir:

```text
orp-list__item--interactive
```

Debe tener estados:

```text
hover
focus-visible
active
disabled
```

En mobile el estado `active` debe ser perceptible al tocar.

---

# 24. List y botones

Cuando un item completo sea interactivo, preferir elementos semánticos apropiados.

Por ejemplo:

```html
<button class="orp-list__item orp-list__item--interactive">
```

o:

```html
<a class="orp-list__item orp-list__item--interactive">
```

en vez de hacer:

```html
<div onclick="...">
```

---

# 25. Divider

Para `orp-list--divided`, los divisores deben:

* respetar el layout;
* no atravesar innecesariamente avatar/icon;
* utilizar:

```css
var(--orp-border)
```

Evitar colores hardcoded.

---

# 26. Iconos

ORP UI no debe incorporar obligatoriamente una librería de iconos.

AppBar, BottomNav y List deben aceptar cualquier implementación:

```html
<svg>
```

o componentes Vue externos.

No instalar:

```text
Font Awesome
Lucide
Bootstrap Icons
Material Icons
```

como dependencia del framework.

---

# 27. Utilities nuevas

No agregar utilities nuevas salvo que sean necesarias para estos componentes.

Si aparece una necesidad repetida, evaluar primero si pertenece:

```text
al componente
```

o:

```text
a utilities
```

No convertir cada declaración CSS en una utility.

---

# 28. Variables nuevas

Agregar únicamente tokens necesarios.

Ejemplo:

```less
@orp-app-bar-height: 56px;
@orp-bottom-nav-height: 64px;

@orp-avatar-sm: 32px;
@orp-avatar-md: 40px;
@orp-avatar-lg: 56px;
@orp-avatar-xl: 72px;
```

Y exponer solo las CSS Custom Properties que tengan valor para theming o personalización.

No es obligatorio exponer cada variable LESS.

---

# 29. CSS custom properties

Agregar:

```css
--orp-app-bar-height
--orp-bottom-nav-height
```

Considerar también variables específicas solo si facilitan personalización futura.

Evitar llenar `:root` con decenas de propiedades innecesarias.

---

# 30. Z-index

Definir una escala mínima si AppBar sticky y BottomNav fixed lo necesitan.

Ejemplo:

```less
@orp-z-sticky: 100;
@orp-z-fixed: 200;
```

No usar arbitrariamente:

```text
999999
9999999
```

La escala debe poder crecer posteriormente para:

```text
modal
sheet
toast
dropdown
```

---

# 31. Animaciones

Usar transiciones pequeñas.

Principalmente:

```text
background-color
color
opacity
transform
box-shadow
```

Duración orientativa:

```text
150ms
200ms
250ms
```

Respetar:

```css
prefers-reduced-motion
```

---

# 32. Accesibilidad AppBar

Los botones de AppBar que tengan únicamente icono deben tener:

```html
aria-label
```

Ejemplo:

```html
<button
    class="orp-btn orp-btn--ghost"
    aria-label="Volver"
>
    ...
</button>
```

---

# 33. Accesibilidad BottomNav

Usar:

```html
<nav aria-label="Navegación principal">
```

Cuando el elemento represente la página actual, permitir:

```html
aria-current="page"
```

Ejemplo:

```html
<a
    class="orp-bottom-nav__item orp-bottom-nav__item--active"
    aria-current="page"
>
```

---

# 34. Accesibilidad Avatar

Las imágenes deben incluir `alt` apropiado.

Si el avatar es puramente decorativo:

```html
alt=""
```

Si identifica a una persona:

```html
alt="Daniel López"
```

La aplicación decide el texto.

---

# 35. Playground

Actualizar:

```text
OrpPlayground.vue
```

Agregar una sección por cada componente.

## AppBar

Mostrar:

```text
Default
Bordered
Transparent
Sticky demo
Long title
Leading/trailing actions
```

## BottomNav

Mostrar:

```text
3 items
4 items
Active state
Badge
Fixed demo
```

## Avatar

Mostrar:

```text
sm
md
lg
xl
image
fallback
status
```

## Badge

Mostrar:

```text
primary
secondary
success
warning
danger
outline
```

## List

Mostrar:

```text
default
divided
inset
with avatar
with badge
interactive
title + subtitle
leading/trailing
```

---

# 36. Pruebas visuales

Validar al menos:

```text
320px
375px
430px
768px
1024px
```

Revisar especialmente:

```text
AppBar overflow
BottomNav labels
BottomNav safe area
List long text
Avatar alignment
Badge alignment
```

---

# 37. Long text

Todos los componentes deben considerar textos largos.

Especialmente:

```text
AppBar title
BottomNav labels
List title
List subtitle
Badge
```

No dejar que un string inesperado destruya el layout.

Cuando corresponda utilizar:

```css
min-width: 0;
overflow: hidden;
text-overflow: ellipsis;
```

No truncar texto automáticamente si eso perjudica información importante.

---

# 38. Touch

Revisar elementos interactivos en dispositivos táctiles.

Como referencia:

```text
44x44px
```

para targets importantes.

BottomNav y AppBar tienen prioridad alta en este punto.

---

# 39. No usar JavaScript si no hace falta

Esta fase debería requerir prácticamente cero JavaScript interno.

AppBar:

```text
CSS
```

BottomNav:

```text
CSS
```

Avatar:

```text
CSS
```

Badge:

```text
CSS
```

List:

```text
CSS
```

Los eventos y acciones pertenecen a la aplicación.

---

# 40. No crear wrappers Vue innecesarios

NO crear automáticamente:

```text
OrpAppBar.vue
OrpBottomNav.vue
OrpAvatar.vue
OrpBadge.vue
OrpList.vue
```

Primero implementar HTML + CSS.

Si durante la implementación se detecta que un wrapper Vue aporta una ventaja clara y repetible, documentar esa propuesta, pero NO implementarlo todavía sin necesidad.

---

# 41. Compatibilidad

Verificar que los nuevos estilos no afecten:

```text
Bootstrap
Swiper
GLightbox
Leaflet
otros estilos existentes
```

Nunca estilizar tags mediante selectores globales excesivamente agresivos.

Incorrecto:

```less
nav {
    ...
}
```

Correcto:

```less
.orp-bottom-nav {
    ...
}
```

---

# 42. Archivos

Agregar los archivos necesarios dentro de la estructura existente.

Referencia:

```text
less/
├── components/
│   ├── app-bar.less
│   ├── bottom-nav.less
│   ├── avatar.less
│   ├── badge.less
│   └── list.less
```

Actualizar:

```text
orp-ui.less
```

para importar los nuevos componentes en un orden consistente.

---

# 43. Orden de imports

Mantener una arquitectura similar:

```less
// Abstracts
@import "abstracts/variables.less";
@import "abstracts/mixins.less";
@import "abstracts/breakpoints.less";

// Base
@import "base/reset.less";
@import "base/root.less";
@import "base/typography.less";

// Utilities
...

// Components
@import "components/button.less";
@import "components/card.less";

@import "components/app-bar.less";
@import "components/bottom-nav.less";
@import "components/avatar.less";
@import "components/badge.less";
@import "components/list.less";
```

No utilizar imports duplicados.

---

# 44. Calidad

Antes de finalizar verificar:

```text
orp-app-bar
orp-bottom-nav
orp-avatar
orp-badge
orp-list
```

Todos:

* usan namespace;
* usan tokens existentes;
* son mobile-first;
* tienen baja especificidad;
* funcionan sin JavaScript;
* funcionan con touch;
* consideran accesibilidad;
* no conocen Laravel/Inertia;
* no afectan frameworks externos.

---

# 45. No modificar Foundation innecesariamente

No reescribir la Parte 1 porque ahora exista una idea "mejor".

Modificar Foundation únicamente cuando:

1. exista un error;
2. falte un token realmente necesario;
3. exista inconsistencia arquitectónica;
4. la Parte 2 requiera una extensión claramente justificada.

Si se modifica algo existente, explicarlo al finalizar.

---

# 46. Resultado esperado

Al finalizar entregar:

## Archivos creados

Listar archivos nuevos.

## Archivos modificados

Listar modificaciones.

## Nuevos tokens

Indicar variables agregadas.

## Componentes

Mostrar ejemplos mínimos de:

```text
AppBar
BottomNav
Avatar
Badge
List
```

## Playground

Indicar cómo probarlos.

## Responsive

Indicar tamaños revisados.

## Conflictos

Reportar cualquier conflicto encontrado.

---

# 47. Ejemplo final esperado

La siguiente composición debe poder construirse únicamente con ORP UI:

```html
<div class="orp-container">

    <header class="orp-app-bar orp-app-bar--bordered">

        <div class="orp-app-bar__leading">
            <button
                class="orp-btn orp-btn--ghost"
                aria-label="Volver"
            >
                ←
            </button>
        </div>

        <div class="orp-app-bar__content">

            <div class="orp-app-bar__title">
                Mi perfil
            </div>

        </div>

    </header>


    <div class="orp-list orp-list--divided">

        <button
            class="orp-list__item orp-list__item--interactive"
        >

            <div class="orp-list__leading">

                <div class="orp-avatar orp-avatar--md">

                    <span class="orp-avatar__fallback">
                        DL
                    </span>

                    <span
                        class="
                            orp-avatar__status
                            orp-avatar__status--online
                        "
                    ></span>

                </div>

            </div>

            <div class="orp-list__content">

                <div class="orp-list__title">
                    Daniel López
                </div>

                <div class="orp-list__subtitle">
                    Editar perfil
                </div>

            </div>

            <div class="orp-list__trailing">

                <span
                    class="
                        orp-badge
                        orp-badge--success
                    "
                >
                    Activo
                </span>

            </div>

        </button>

    </div>

</div>


<nav
    class="
        orp-bottom-nav
        orp-bottom-nav--fixed
    "
    aria-label="Navegación principal"
>

    <button
        class="
            orp-bottom-nav__item
            orp-bottom-nav__item--active
        "
        aria-current="page"
    >

        <span class="orp-bottom-nav__icon">
            ...
        </span>

        <span class="orp-bottom-nav__label">
            Inicio
        </span>

    </button>

    <button class="orp-bottom-nav__item">

        <span class="orp-bottom-nav__icon">
            ...
        </span>

        <span class="orp-bottom-nav__label">
            Perfil
        </span>

    </button>

</nav>
```

---

# Regla final

Esta fase debe hacer que ORP UI empiece a sentirse como un sistema de interfaz mobile-first, pero sin aumentar innecesariamente la complejidad.

Priorizar siempre:

```text
HTML semántico
+
CSS/LESS
+
BEM
+
Design Tokens
```

antes que:

```text
abstracciones Vue
JavaScript
dependencias externas
```

La Parte 2 termina cuando estén correctamente implementados y documentados:

```text
orp-app-bar
orp-bottom-nav
orp-avatar
orp-badge
orp-list
```

No continuar automáticamente con Modal, Sheet, Tabs ni otros componentes.
