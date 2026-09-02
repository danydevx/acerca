# SKILL — ORP UI / Parte 1: Foundation

## Rol

Actúa como arquitecto frontend senior especializado en:

* Vue 3
* Composition API
* JavaScript
* LESS
* BEM
* CSS moderno
* Mobile First
* Responsive Design
* Progressive Web Apps
* Interfaces app-like
* Design Systems
* Accesibilidad
* Performance frontend

Tu objetivo es iniciar **ORP UI**, un UI Kit ligero, modular, reutilizable y mobile-first desarrollado bajo el branding de **Orpot**.

ORP UI toma inspiración conceptual de proyectos como:

* Bootstrap
* Framework7
* shadcn/ui
* Basecoat

pero NO debe copiar su implementación ni depender de ellos.

La filosofía principal es:

> Mobile First. Lightweight. Semantic. Composable.

Esta primera fase debe ser deliberadamente pequeña.

NO construir todo el framework.

---

# 1. Objetivo de ORP UI

ORP UI será un pequeño sistema de interfaz reutilizable para aplicaciones web modernas, especialmente interfaces mobile-first construidas con Vue 3.

Debe proporcionar progresivamente:

1. Design tokens.
2. CSS Custom Properties.
3. Estilos base.
4. Utilities esenciales.
5. Componentes CSS semánticos.
6. Componentes Vue cuando exista comportamiento real.
7. Patrones comunes de aplicaciones móviles.
8. Responsive design para tablet y desktop.

ORP UI debe poder utilizarse en proyectos con:

```text
Laravel
Inertia
Vue 3
Vite
```

pero NO debe depender directamente de Laravel ni Inertia.

También debe poder funcionar en cualquier aplicación Vue 3.

---

# 2. Stack obligatorio

Utilizar:

* Vue 3
* Composition API
* `<script setup>`
* JavaScript
* LESS
* CSS Custom Properties
* BEM
* CSS moderno
* Vite

NO utilizar para construir ORP UI:

* React
* TypeScript
* Tailwind
* Bootstrap
* Framework7
* jQuery

Si alguna de estas tecnologías ya existe en el proyecto, NO eliminarla.

ORP UI debe poder coexistir con ellas.

---

# 3. Namespace obligatorio

Toda clase perteneciente a ORP UI debe comenzar con:

```text
orp-
```

Ejemplos:

```text
orp-container
orp-btn
orp-card

orp-d-flex
orp-gap-2
orp-mb-3
```

Esto permite identificar inmediatamente qué estilos pertenecen a ORP UI.

Nunca crear clases globales propias como:

```text
.btn
.card
.container
.row
.modal
.nav
.badge
```

---

# 4. BEM

Los componentes deben utilizar BEM.

Formato:

```text
orp-[component]
orp-[component]__[element]
orp-[component]--[modifier]
```

Ejemplo:

```html
<article class="orp-card orp-card--raised">

    <header class="orp-card__header">
        Título
    </header>

    <div class="orp-card__body">
        Contenido
    </div>

    <footer class="orp-card__footer">
        Acciones
    </footer>

</article>
```

LESS:

```less
.orp-card {

    &__header {}

    &__body {}

    &__footer {}

    &--raised {}

    &--outlined {}

}
```

Evitar selectores profundamente anidados.

Incorrecto:

```less
.page {
    .content {
        .card {
            .body {
                button {}
            }
        }
    }
}
```

---

# 5. Namespace de variables

El namespace `orp` debe extenderse también a las variables internas y públicas.

## LESS

Utilizar:

```less
@orp-primary
@orp-background
@orp-surface
@orp-text
@orp-radius-md
@orp-space-4
```

Nunca:

```less
@primary
@background
@radius
```

## CSS Custom Properties

Utilizar:

```css
--orp-primary
--orp-background
--orp-surface
--orp-text
--orp-radius-md
--orp-space-4
```

Nunca:

```css
--primary
--background
--card
--radius
```

Esto evita conflictos con Bootstrap, themes externos, shadcn, aplicaciones existentes u otros frameworks.

---

# 6. Filosofía de componentes

No todo debe convertirse en un componente Vue.

Esta es una regla fundamental de ORP UI.

Un elemento principalmente visual debe poder utilizarse mediante HTML semántico + clases ORP UI.

Por ejemplo:

```html
<div class="orp-card">
    <div class="orp-card__body">
        Contenido
    </div>
</div>
```

No es obligatorio crear:

```vue
<OrpCard>
```

solo porque Vue está disponible.

Crear componentes Vue únicamente cuando proporcionen valor real mediante:

* estado;
* eventos;
* slots;
* accesibilidad;
* comportamiento reutilizable;
* lógica;
* una API que simplifique considerablemente su utilización.

ORP UI debe evitar crear wrappers Vue innecesarios.

---

# 7. Arquitectura inicial

Crear únicamente la estructura necesaria para esta primera fase.

Referencia:

```text
orp-ui/
│
├── less/
│   │
│   ├── abstracts/
│   │   ├── variables.less
│   │   ├── mixins.less
│   │   └── breakpoints.less
│   │
│   ├── base/
│   │   ├── reset.less
│   │   ├── root.less
│   │   └── typography.less
│   │
│   ├── utilities/
│   │   ├── display.less
│   │   ├── flex.less
│   │   ├── spacing.less
│   │   ├── sizing.less
│   │   └── text.less
│   │
│   ├── components/
│   │   ├── button.less
│   │   └── card.less
│   │
│   └── orp-ui.less
│
├── examples/
│   └── OrpPlayground.vue
│
└── index.js
```

Esta estructura es una referencia.

Adaptarla a la arquitectura existente del proyecto cuando sea necesario.

NO reorganizar todo el proyecto para adaptarlo a ORP UI.

ORP UI debe adaptarse al proyecto, no al revés.

No crear carpetas vacías únicamente porque aparezcan en esta estructura.

---

# 8. Design Tokens

Crear un sistema pequeño de design tokens.

Inicialmente definir:

## Colors

```less
@orp-primary: #1769ff;
@orp-secondary: #6c757d;

@orp-success: #198754;
@orp-warning: #ffc107;
@orp-danger: #dc3545;

@orp-background: #f6f7f9;
@orp-surface: #ffffff;

@orp-text: #16181d;
@orp-text-muted: #6c727f;

@orp-border: #e6e8ec;
```

Estos valores son valores iniciales.

La arquitectura debe permitir cambiarlos posteriormente.

---

# 9. Spacing System

Utilizar una escala pequeña y predecible.

```less
@orp-space-0: 0;
@orp-space-1: 4px;
@orp-space-2: 8px;
@orp-space-3: 12px;
@orp-space-4: 16px;
@orp-space-5: 24px;
@orp-space-6: 32px;
```

No crear inicialmente una escala enorme.

Evitar valores arbitrarios como:

```text
13px
17px
27px
```

cuando un token existente sea suficientemente cercano.

---

# 10. Border Radius

Definir:

```less
@orp-radius-sm: 8px;
@orp-radius-md: 12px;
@orp-radius-lg: 18px;
@orp-radius-xl: 24px;
@orp-radius-pill: 999px;
```

---

# 11. Typography Tokens

Definir inicialmente:

```less
@orp-font-family:
    Inter,
    system-ui,
    -apple-system,
    BlinkMacSystemFont,
    "Segoe UI",
    sans-serif;

@orp-font-size-sm: 0.875rem;
@orp-font-size-md: 1rem;
@orp-font-size-lg: 1.125rem;
@orp-font-size-xl: 1.5rem;

@orp-line-height: 1.5;
```

No depender obligatoriamente de Google Fonts.

Si Inter no está disponible, utilizar el system stack.

NO instalar una fuente como dependencia del framework.

---

# 12. CSS Custom Properties

Exponer los tokens principales mediante CSS Custom Properties.

Ejemplo:

```less
:root {

    --orp-primary: @orp-primary;
    --orp-secondary: @orp-secondary;

    --orp-success: @orp-success;
    --orp-warning: @orp-warning;
    --orp-danger: @orp-danger;

    --orp-background: @orp-background;
    --orp-surface: @orp-surface;

    --orp-text: @orp-text;
    --orp-text-muted: @orp-text-muted;

    --orp-border: @orp-border;

    --orp-space-1: @orp-space-1;
    --orp-space-2: @orp-space-2;
    --orp-space-3: @orp-space-3;
    --orp-space-4: @orp-space-4;
    --orp-space-5: @orp-space-5;
    --orp-space-6: @orp-space-6;

    --orp-radius-sm: @orp-radius-sm;
    --orp-radius-md: @orp-radius-md;
    --orp-radius-lg: @orp-radius-lg;
    --orp-radius-xl: @orp-radius-xl;

}
```

Los componentes deben preferir CSS Custom Properties cuando esto facilite theming futuro.

Ejemplo:

```less
.orp-card {
    background: var(--orp-surface);
    color: var(--orp-text);
    border-radius: var(--orp-radius-lg);
}
```

---

# 13. Theming futuro

La primera fase NO necesita implementar un sistema completo de themes.

Sin embargo, la arquitectura debe permitir posteriormente:

```text
Light
Dark
Custom Brand
```

Por eso los componentes NO deben llenar su código con colores hardcoded.

Incorrecto:

```less
.orp-card {
    background: #fff;
    color: #16181d;
}
```

Correcto:

```less
.orp-card {
    background: var(--orp-surface);
    color: var(--orp-text);
}
```

---

# 14. Reset mínimo

Crear un reset pequeño.

NO construir un normalize.css completo.

Incluir únicamente reglas necesarias como:

```less
*,
*::before,
*::after {
    box-sizing: border-box;
}

img,
svg,
video {
    max-width: 100%;
}

button,
input,
textarea,
select {
    font: inherit;
}
```

Ser conservador con estilos globales.

ORP UI debe poder convivir con aplicaciones existentes.

---

# 15. Mobile First

Todo ORP UI debe diseñarse primero para móvil.

Base:

```less
.orp-container {
    width: 100%;
    padding-inline: var(--orp-space-4);
}
```

Después ampliar progresivamente.

Ejemplo:

```less
@media (min-width: @orp-breakpoint-md) {

    .orp-container {
        max-width: 720px;
        margin-inline: auto;
    }

}
```

NO escribir desktop primero para después corregir móvil.

---

# 16. Breakpoints

Definir inicialmente:

```less
@orp-breakpoint-sm: 576px;
@orp-breakpoint-md: 768px;
@orp-breakpoint-lg: 992px;
@orp-breakpoint-xl: 1200px;
```

Estos breakpoints deben centralizarse.

No escribir media queries con valores arbitrarios repetidos por toda la arquitectura.

---

# 17. Container

Crear:

```text
orp-container
```

Debe:

* ocupar 100% en móvil;
* tener padding lateral adecuado;
* centrar contenido progresivamente en pantallas mayores;
* permitir lectura cómoda en desktop;
* seguir siendo mobile-first.

Ejemplo:

```html
<main class="orp-container">
    ...
</main>
```

No implementar todavía un grid completo.

NO crear:

```text
orp-row
orp-col-6
orp-col-md-4
```

en esta fase.

---

# 18. Utilities

Crear solamente utilities esenciales.

El objetivo NO es recrear Bootstrap.

## Display

Inicialmente:

```text
orp-d-none
orp-d-block
orp-d-flex
orp-d-grid
```

## Flex

```text
orp-flex-row
orp-flex-column

orp-align-start
orp-align-center
orp-align-end

orp-justify-start
orp-justify-center
orp-justify-between
orp-justify-end
```

## Gap

```text
orp-gap-1
orp-gap-2
orp-gap-3
orp-gap-4
orp-gap-5
```

## Width

```text
orp-w-100
```

## Text

```text
orp-text-left
orp-text-center
orp-text-right
orp-text-muted
```

No agregar utilities adicionales sin necesidad real.

---

# 19. Spacing Utilities

Crear una primera escala sencilla.

Margin:

```text
orp-m-0

orp-mt-1
orp-mt-2
orp-mt-3
orp-mt-4
orp-mt-5

orp-mb-1
orp-mb-2
orp-mb-3
orp-mb-4
orp-mb-5
```

Padding:

```text
orp-p-0

orp-p-1
orp-p-2
orp-p-3
orp-p-4
orp-p-5
```

No generar cientos de combinaciones automáticamente.

Agregar nuevas utilities conforme aparezcan necesidades reales.

---

# 20. Button

Crear el primer componente visual:

```text
orp-btn
```

Debe funcionar inicialmente como:

```html
<button class="orp-btn orp-btn--primary">
    Guardar
</button>
```

Variantes iniciales:

```text
orp-btn--primary
orp-btn--secondary
orp-btn--ghost
orp-btn--danger
```

Tamaños:

```text
orp-btn--sm
orp-btn--md
orp-btn--lg
```

Block:

```text
orp-btn--block
```

Ejemplo:

```html
<button
    class="
        orp-btn
        orp-btn--primary
        orp-btn--lg
        orp-btn--block
    "
>
    Continuar
</button>
```

Debe contemplar:

```text
hover
focus-visible
active
disabled
```

---

# 21. Touch Targets

ORP UI es mobile-first.

Los controles interactivos deben considerar touch.

Como regla general:

```text
mínimo aproximado: 44 × 44px
```

Especialmente:

```text
buttons
links interactivos
icon buttons
navigation items
```

No diseñar controles únicamente pensando en mouse.

---

# 22. Focus

No eliminar:

```css
outline
```

sin proporcionar una alternativa accesible.

Utilizar:

```css
:focus-visible
```

cuando corresponda.

Ejemplo conceptual:

```less
.orp-btn {

    &:focus-visible {
        outline: 2px solid var(--orp-primary);
        outline-offset: 2px;
    }

}
```

---

# 23. Card

Crear:

```text
orp-card
```

Estructura:

```html
<article class="orp-card">

    <header class="orp-card__header">
        ...
    </header>

    <div class="orp-card__body">
        ...
    </div>

    <footer class="orp-card__footer">
        ...
    </footer>

</article>
```

Variantes iniciales:

```text
orp-card--outlined
orp-card--raised
orp-card--interactive
```

No agregar más variantes hasta necesitarlas.

---

# 24. Card interactiva

Cuando se utilice:

```text
orp-card--interactive
```

debe contemplar:

```text
hover
focus
active
touch
```

Las animaciones deben ser discretas.

Preferir:

```text
transform
opacity
box-shadow
```

con transiciones pequeñas.

No utilizar animaciones exageradas.

---

# 25. Vue

En esta primera fase NO crear automáticamente:

```text
OrpButton.vue
OrpCard.vue
```

Primero implementar Button y Card como componentes CSS semánticos.

Ejemplo:

```vue
<template>

    <article class="orp-card orp-card--raised">

        <div class="orp-card__body">

            <h2>
                Mi aplicación
            </h2>

            <p class="orp-text-muted">
                Ejemplo de ORP UI.
            </p>

            <button class="orp-btn orp-btn--primary orp-btn--block">
                Continuar
            </button>

        </div>

    </article>

</template>
```

Esto es completamente válido.

Crear wrappers Vue posteriormente únicamente si existe una ventaja clara.

---

# 26. Independencia de Inertia

ORP UI NO debe importar:

```js
@inertiajs/vue3
```

El framework no debe conocer el router de Inertia.

La aplicación puede hacer:

```js
import { router } from '@inertiajs/vue3'
```

pero ORP UI no.

---

# 27. Independencia de Laravel

ORP UI nunca debe conocer:

```text
Controllers
Models
Laravel Routes
Blade
Auth
Policies
Eloquent
APIs
```

El framework es exclusivamente frontend.

---

# 28. Safe Areas

Aunque AppBar y BottomNav todavía no se implementarán, preparar ORP UI para dispositivos modernos.

Considerar desde el diseño:

```css
env(safe-area-inset-top)
env(safe-area-inset-right)
env(safe-area-inset-bottom)
env(safe-area-inset-left)
```

No es necesario crear componentes específicos todavía.

---

# 29. Reduced Motion

Preparar estilos para usuarios que soliciten menos movimiento.

```less
@media (prefers-reduced-motion: reduce) {

    *,
    *::before,
    *::after {
        scroll-behavior: auto;
    }

}
```

No desactivar globalmente cosas innecesarias.

Aplicar especialmente a componentes que posteriormente incorporen animaciones.

---

# 30. Performance

Priorizar:

* CSS pequeño;
* selectores simples;
* poca especificidad;
* evitar `!important`;
* evitar nesting profundo;
* evitar JavaScript cuando CSS sea suficiente;
* evitar dependencias;
* evitar componentes Vue innecesarios.

ORP UI debe funcionar bien en dispositivos móviles modestos.

---

# 31. Dependencias

NO instalar ninguna dependencia nueva durante esta fase salvo que sea estrictamente necesaria.

Antes de instalar cualquier paquete:

1. detener la implementación;
2. explicar qué problema resuelve;
3. comprobar si CSS, LESS o Vue nativo pueden resolverlo;
4. justificar el peso añadido.

Para esta Fase 1 debería ser posible trabajar sin nuevas dependencias, asumiendo que Vue, LESS y Vite ya están disponibles.

---

# 32. Coexistencia con Bootstrap

Si Bootstrap está instalado:

NO eliminarlo.

NO modificar sus archivos.

NO sobrescribir directamente:

```less
.btn {}
.card {}
.container {}
.modal {}
```

ORP UI utiliza exclusivamente:

```text
orp-*
```

Ejemplo:

```html
<div class="container">
    Bootstrap
</div>

<div class="orp-container">
    ORP UI
</div>
```

Ambos deben poder coexistir.

---

# 33. Coexistencia con otras librerías

ORP UI tampoco debe modificar directamente:

```text
swiper-*
glightbox-*
leaflet-*
f7-*
```

Cada librería mantiene su propio namespace.

Debe ser inmediatamente reconocible:

```text
orp-*        ORP UI
swiper-*     Swiper
glightbox-*  GLightbox
leaflet-*    Leaflet
```

---

# 34. Playground

Crear un playground visual sencillo.

Por ejemplo:

```text
OrpPlayground.vue
```

Debe mostrar inicialmente:

## Typography

* headings;
* paragraphs;
* muted text.

## Colors

Muestras básicas de:

```text
primary
secondary
success
warning
danger
surface
background
```

## Buttons

Mostrar:

```text
Primary
Secondary
Ghost
Danger

Small
Medium
Large

Block

Disabled
```

## Cards

Mostrar:

```text
Default
Outlined
Raised
Interactive
```

## Utilities

Incluir algunos ejemplos de:

```text
flex
gap
spacing
alignment
```

El playground es para desarrollo y validación visual.

No debe formar parte obligatoria del frontend de producción.

---

# 35. Pruebas responsive

Validar como mínimo aproximadamente:

```text
320px
375px
430px
768px
1024px
1440px
```

Priorizar especialmente:

```text
375px
430px
```

porque ORP UI es mobile-first.

No asumir que "responsive" significa solamente que no aparece scroll horizontal.

Revisar también:

* legibilidad;
* touch targets;
* spacing;
* tamaño de botones;
* cards;
* longitud de texto;
* jerarquía visual.

---

# 36. Criterios de calidad

Antes de terminar esta fase verificar:

### Namespace

Todas las clases propias comienzan con:

```text
orp-
```

### LESS

Las variables internas comienzan con:

```text
@orp-
```

### CSS Variables

Las variables públicas comienzan con:

```text
--orp-
```

### BEM

Los componentes siguen:

```text
orp-component
orp-component__element
orp-component--modifier
```

### Mobile

La implementación parte desde móvil.

### Dependencies

No se agregaron dependencias innecesarias.

### Isolation

No se modificaron estilos de frameworks externos.

### Accessibility

Button tiene estados:

```text
focus
disabled
active
```

y touch target apropiado.

---

# 37. Lo que NO debe hacerse todavía

NO implementar:

```text
AppBar
BottomNav
Modal
Sheet
Tabs
Dropdown
Toast
Accordion
Carousel
Gallery
DatePicker
Calendar
Drawer
Offcanvas
Navigation Router
Grid complejo
Icon system
Theme manager
```

Eso pertenece a fases posteriores.

Tampoco crear 30 utilities "por si acaso".

---

# 38. Alcance exacto de Fase 1

Implementar únicamente:

```text
Foundation
├── Design Tokens
├── CSS Custom Properties
├── Breakpoints
├── Reset mínimo
├── Typography
├── Container
│
├── Utilities
│   ├── Display
│   ├── Flex
│   ├── Gap
│   ├── Spacing
│   ├── Width
│   └── Text
│
├── Components
│   ├── Button
│   └── Card
│
└── Playground
```

Nada más.

---

# 39. Primera tarea para el agente

Antes de modificar código:

1. Analizar la estructura actual del proyecto.
2. Identificar dónde se cargan los archivos LESS.
3. Identificar la configuración de Vite.
4. Identificar si Bootstrap u otros frameworks están presentes.
5. Identificar los estilos globales existentes.
6. Elegir una ubicación para ORP UI que genere el menor acoplamiento posible.

Después implementar exclusivamente la Fase 1.

NO modificar:

```text
Laravel
Controllers
Models
Database
Authentication
Inertia routing
Business logic
```

salvo que sea estrictamente necesario para crear una ruta temporal al playground.

Si es posible montar el playground sin alterar rutas de producción, preferirlo.

---

# 40. Resultado esperado

Al finalizar entregar un resumen con:

## Archivos creados

```text
...
```

## Archivos modificados

```text
...
```

## Arquitectura

Explicar brevemente dónde vive ORP UI y cómo se carga.

## Import

Mostrar cómo importar el entrypoint:

```js
import '.../orp-ui.less'
```

o el mecanismo apropiado según la arquitectura existente.

## Ejemplo

Mostrar un ejemplo mínimo:

```html
<div class="orp-container">

    <article class="orp-card orp-card--raised">

        <div class="orp-card__body">

            <h2>ORP UI</h2>

            <p class="orp-text-muted">
                Mobile-first UI Kit by Orpot.
            </p>

            <button class="orp-btn orp-btn--primary orp-btn--block">
                Continuar
            </button>

        </div>

    </article>

</div>
```

## Conflictos

Reportar cualquier conflicto detectado con:

```text
Bootstrap
estilos globales
Vite
LESS
otras librerías
```

NO ocultar conflictos aplicando hacks.

---

# 41. Regla final

ORP UI debe crecer a partir de necesidades reales.

No intentar construir Bootstrap.

No intentar construir Framework7.

No intentar construir shadcn/ui completo.

La primera versión debe ser pequeña, limpia y fácil de entender.

Cuando exista duda entre:

```text
más abstracción
```

y:

```text
código simple
```

preferir código simple.

Cuando exista duda entre:

```text
nuevo componente Vue
```

y:

```text
HTML + CSS semántico
```

preferir HTML + CSS semántico si no existe comportamiento que justifique Vue.

Cuando exista duda entre:

```text
nueva dependencia
```

y:

```text
CSS/Vue nativo
```

preferir CSS/Vue nativo.

Todo código propio de ORP UI debe ser inmediatamente identificable por su namespace:

```text
orp-
@orp-
--orp-
```
