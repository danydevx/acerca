# SKILL — ORP UI / Parte 9: App Layout & Shell

## Objetivo

Extender ORP UI con primitives estructurales para construir aplicaciones completas mobile-first y responsive.

Esta fase NO debe agregar componentes de negocio.

El objetivo es resolver correctamente:

```text
App structure
Viewport
Safe areas
Sticky regions
Fixed navigation
Content scrolling
Mobile → desktop adaptation
```

Implementar:

```text
App Layout
├── App Shell
├── App Body
├── Main Content
├── Sidebar Region
├── Header Region
├── Bottom Region
├── Page Content
├── Safe Area helpers
└── Responsive layout behavior
```

---

# 1. Principio principal

ORP UI debe resolver layout repetitivo de aplicación.

La aplicación NO debería tener que repetir manualmente:

```css
padding-top: 56px;
padding-bottom: 72px;
height: calc(100vh - ...);
```

en cada proyecto.

ORP UI debe proporcionar una estructura predecible y reusable.

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

Esta fase debe ser principalmente:

```text
HTML + LESS
```

No crear wrappers Vue salvo necesidad clara.

---

# 3. App Shell

Crear:

```text
orp-app-shell
```

Objetivo:

Ser el contenedor estructural principal de una aplicación.

Ejemplo:

```html
<div class="orp-app-shell">

    <header class="orp-app-shell__header">
        ...
    </header>

    <main class="orp-app-shell__main">
        ...
    </main>

    <nav class="orp-app-shell__bottom">
        ...
    </nav>

</div>
```

---

# 4. App Shell responsibilities

Debe resolver:

```text
viewport height
background
foreground
mobile layout
safe areas
fixed/sticky regions
content area
```

No debe resolver:

```text
routing
permissions
business logic
authentication
```

---

# 5. Height strategy

Preferir:

```css
min-height: 100dvh;
```

con fallback razonable si es necesario.

Ejemplo:

```less
.orp-app-shell {
    min-height: 100vh;
    min-height: 100dvh;
}
```

---

# 6. No hardcoded viewport hacks

Evitar depender de:

```css
height: 100vh;
```

como única solución.

Especialmente en mobile puede producir problemas con:

```text
browser chrome
virtual keyboard
dynamic viewport
```

---

# 7. App Shell base

Referencia:

```less
.orp-app-shell {
    position: relative;
    display: flex;
    flex-direction: column;

    min-height: 100vh;
    min-height: 100dvh;

    background: var(--orp-background);
    color: var(--orp-foreground);
}
```

---

# 8. App Body

Crear:

```text
orp-app-shell__body
```

Objetivo:

Contenedor flexible entre regiones estructurales.

Ejemplo:

```html
<div class="orp-app-shell">

    <aside class="orp-app-shell__sidebar">
        ...
    </aside>

    <div class="orp-app-shell__body">

        <header class="orp-app-shell__header">
            ...
        </header>

        <main class="orp-app-shell__main">
            ...
        </main>

    </div>

</div>
```

---

# 9. Main Content

Crear:

```text
orp-app-shell__main
```

Debe:

```text
grow
allow content scrolling
not overflow horizontally
```

Base:

```less
.orp-app-shell__main {
    flex: 1 1 auto;
    min-width: 0;
}
```

---

# 10. Main scroll strategy

No imponer scroll interno por defecto si no hace falta.

Por defecto:

```text
document scroll
```

debe seguir siendo válido.

Agregar modifier opcional:

```text
orp-app-shell--contained-scroll
```

solo si existe necesidad real de scroll interno.

---

# 11. Contained scroll

Cuando se utilice:

```text
orp-app-shell--contained-scroll
```

la estructura puede usar:

```less
.orp-app-shell--contained-scroll {
    height: 100dvh;
    overflow: hidden;
}

.orp-app-shell--contained-scroll .orp-app-shell__main {
    overflow-y: auto;
}
```

Usar con cuidado.

---

# 12. Document scroll preferred

Para páginas normales:

preferir scroll del documento.

Esto evita problemas con:

```text
mobile keyboard
anchor links
browser navigation
accessibility
nested scroll containers
```

---

# 13. Header Region

Crear:

```text
orp-app-shell__header
```

Debe funcionar con:

```text
orp-app-bar
```

Ejemplo:

```html
<header class="orp-app-shell__header">

    <div class="orp-app-bar">
        ...
    </div>

</header>
```

---

# 14. Sticky Header

Permitir modifier:

```text
orp-app-shell__header--sticky
```

Implementar:

```less
position: sticky;
top: 0;
z-index: var(--orp-z-sticky);
```

considerando safe area.

---

# 15. Safe top

El header puede necesitar:

```css
env(safe-area-inset-top)
```

No duplicar el safe area si `orp-app-bar` ya lo maneja.

Definir una única responsabilidad.

Preferencia:

```text
App Shell
→ layout / safe area
```

```text
AppBar
→ contenido visual
```

---

# 16. Evitar doble safe area

No permitir:

```text
AppShell top safe area
+
AppBar top safe area
```

simultáneamente por defecto.

Auditar implementación existente.

---

# 17. Bottom Region

Crear:

```text
orp-app-shell__bottom
```

Diseñado para contener:

```text
BottomNav
mobile actions
persistent bottom controls
```

Ejemplo:

```html
<nav class="orp-app-shell__bottom">

    <div class="orp-bottom-nav">
        ...
    </div>

</nav>
```

---

# 18. Fixed Bottom Region

Permitir:

```text
orp-app-shell__bottom--fixed
```

Debe fijarse al fondo.

Ejemplo conceptual:

```less
.orp-app-shell__bottom--fixed {
    position: fixed;
    inset-inline: 0;
    bottom: 0;
}
```

---

# 19. Main content compensation

Si bottom region está fixed:

el contenido debe tener espacio suficiente para no quedar debajo.

No repetir:

```css
padding-bottom: 80px;
```

manualmente.

---

# 20. Bottom offset token

Utilizar:

```text
--orp-bottom-nav-height
```

existente.

También considerar:

```text
env(safe-area-inset-bottom)
```

Ejemplo conceptual:

```less
.orp-app-shell--has-fixed-bottom {

    .orp-app-shell__main {
        padding-bottom:
            calc(
                var(--orp-bottom-nav-height)
                + env(safe-area-inset-bottom)
            );
    }

}
```

---

# 21. Avoid magic numbers

No usar:

```css
padding-bottom: 74px;
```

si existe token.

---

# 22. App Shell modifiers

Crear únicamente los necesarios.

Posibles:

```text
orp-app-shell--has-header
orp-app-shell--has-bottom
orp-app-shell--has-sidebar
orp-app-shell--contained-scroll
```

Evitar combinaciones interminables.

---

# 23. Prefer structural detection where reasonable

Si CSS moderno lo permite y es seguro, evaluar:

```css
:has()
```

pero no hacer que todo el layout dependa de él inicialmente.

La API basada en modifiers explícitos puede ser más predecible.

---

# 24. Page Content

Crear:

```text
orp-page-content
```

Objetivo:

Proporcionar spacing estándar para contenido de página.

Ejemplo:

```html
<main class="orp-app-shell__main">

    <div class="orp-page-content">
        ...
    </div>

</main>
```

---

# 25. Page Content padding

Debe utilizar spacing tokens.

Ejemplo:

```less
.orp-page-content {
    padding-inline: var(--orp-space-4);
    padding-block: var(--orp-space-4);
}
```

---

# 26. Page Content max width

En mobile:

```text
width: 100%
```

En desktop puede permitir max width opcional.

Modifier:

```text
orp-page-content--contained
```

---

# 27. Contained content

Ejemplo:

```less
.orp-page-content--contained {
    width: min(
        100%,
        var(--orp-content-max-width)
    );

    margin-inline: auto;
}
```

---

# 28. Content max-width token

Definir si todavía no existe:

```text
--orp-content-max-width
```

Valor orientativo:

```text
1200px
```

No imponer este ancho a todas las interfaces.

---

# 29. Full width content

Debe seguir siendo posible:

```html
<div class="orp-page-content orp-page-content--fluid">
```

si el modifier aporta claridad.

No es obligatorio crear `--fluid` si default ya es fluido.

---

# 30. Sidebar Region

Crear:

```text
orp-app-shell__sidebar
```

Objetivo:

Reservar una región lateral para desktop/tablet.

No implementar navegación específica.

---

# 31. Sidebar width

Agregar token:

```text
--orp-sidebar-width
```

Valor inicial orientativo:

```text
280px
```

LESS:

```text
@orp-sidebar-width
```

---

# 32. Sidebar mobile behavior

Por defecto en mobile:

```text
sidebar hidden
```

si se utiliza como región desktop.

La aplicación puede usar:

```text
OrpDrawer
```

para navegación mobile.

---

# 33. Sidebar desktop behavior

A partir de breakpoint razonable:

```text
lg
```

puede mostrarse.

Ejemplo conceptual:

```less
@media (min-width: @orp-breakpoint-lg) {

    .orp-app-shell--has-sidebar {
        flex-direction: row;
    }

}
```

---

# 34. Sidebar fixed vs sticky

Preferir:

```text
sticky
```

sobre fixed cuando sea posible.

Esto reduce problemas de:

```text
width compensation
viewport height
scroll synchronization
```

---

# 35. Sidebar structure

Permitir:

```text
orp-app-shell__sidebar-header
orp-app-shell__sidebar-body
orp-app-shell__sidebar-footer
```

solo si realmente aporta reutilización.

No crear estructura excesiva.

---

# 36. Desktop App layout

Objetivo conceptual:

```text
┌──────────┬────────────────────────────┐
│ Sidebar  │ Header                     │
│          ├────────────────────────────┤
│          │                            │
│          │ Main                       │
│          │                            │
└──────────┴────────────────────────────┘
```

---

# 37. Mobile App layout

Objetivo:

```text
┌────────────────────────────┐
│ AppBar                     │
├────────────────────────────┤
│                            │
│ Content                    │
│                            │
├────────────────────────────┤
│ BottomNav                  │
└────────────────────────────┘
```

---

# 38. Same markup where possible

No exigir dos layouts completamente distintos.

La misma estructura debe adaptarse mediante CSS cuando sea razonable.

---

# 39. BottomNav desktop

Permitir que:

```text
orp-bottom-nav
```

pueda ocultarse en desktop mediante layout shell.

No hacerlo directamente dentro de BottomNav si eso reduce reutilización.

Preferir regla contextual:

```less
@media (min-width: @orp-breakpoint-lg) {

    .orp-app-shell--has-sidebar
    .orp-app-shell__bottom {
        display: none;
    }

}
```

---

# 40. Sidebar mobile fallback

ORP UI no debe convertir automáticamente sidebar en Drawer.

La aplicación controla:

```text
menu button
drawer open state
routing
```

---

# 41. AppBar responsive

El AppBar puede permanecer visible en desktop.

No ocultarlo automáticamente.

La aplicación puede decidir:

```text
desktop header
mobile header
both
```

---

# 42. FAB integration

Resolver posicionamiento de:

```text
orp-fab
```

dentro del App Shell.

Evitar que colisione con:

```text
BottomNav
safe area
viewport edge
```

---

# 43. FAB region

Evaluar crear:

```text
orp-app-shell__fab
```

Ejemplo:

```html
<div class="orp-app-shell__fab">

    <button class="orp-fab">
        ...
    </button>

</div>
```

---

# 44. FAB positioning

Base conceptual:

```less
.orp-app-shell__fab {
    position: fixed;

    inset-inline-end: var(--orp-space-4);

    bottom:
        calc(
            var(--orp-bottom-nav-height)
            + env(safe-area-inset-bottom)
            + var(--orp-space-4)
        );
}
```

---

# 45. FAB without BottomNav

Debe poder funcionar también sin BottomNav.

Usar modifier estructural o token fallback.

---

# 46. FAB desktop

En desktop:

puede permanecer fixed o cambiar comportamiento.

No imponer transformación automática.

---

# 47. Safe area helpers

Crear una cantidad mínima de primitives:

```text
orp-safe-top
orp-safe-bottom
orp-safe-inline
orp-safe-all
```

Solo si existe necesidad repetida.

---

# 48. Safe Top

Ejemplo:

```less
.orp-safe-top {
    padding-top: env(safe-area-inset-top);
}
```

---

# 49. Safe Bottom

```less
.orp-safe-bottom {
    padding-bottom: env(safe-area-inset-bottom);
}
```

---

# 50. Safe Inline

Considerar:

```css
env(safe-area-inset-left)
env(safe-area-inset-right)
```

usando logical properties cuando sea posible.

---

# 51. Safe Area fallback

`env()` ya resuelve normalmente a cero cuando no aplica.

No agregar JavaScript.

---

# 52. Avoid double safe areas

Documentar claramente:

Safe helpers NO deben aplicarse indiscriminadamente.

Ejemplo incorrecto:

```text
AppShell
+ AppBar
+ PageContent
```

todos sumando safe-top.

---

# 53. Scroll behavior

Definir dos patrones oficiales:

```text
Document Scroll
Contained App Scroll
```

Documentarlos.

---

# 54. Document Scroll

Default recomendado.

```html
<body>

    <div class="orp-app-shell">
        ...
    </div>

</body>
```

El navegador maneja scroll.

---

# 55. Contained App Scroll

Solo para interfaces específicas tipo:

```text
mail
chat
dashboard
editor
```

No ligarlo al negocio; son ejemplos de interacción.

---

# 56. Scroll restoration

ORP UI NO controla:

```text
scroll restoration
route scroll position
Inertia scroll behavior
```

Eso pertenece a la aplicación/router.

---

# 57. Sticky regions

Permitir sticky en:

```text
Header
Section Header opcional
Sidebar
```

pero evitar demasiados elementos sticky simultáneamente.

---

# 58. Sticky z-index

Reutilizar tokens existentes.

No crear:

```text
z-index: 9999
```

---

# 59. Content overflow

Aplicar:

```css
min-width: 0;
```

en regiones flex/grid que lo requieran.

Esto evita overflow por:

```text
long text
images
tables
code
```

---

# 60. Horizontal overflow

App Shell no debería necesitar:

```css
overflow-x: hidden;
```

como parche global.

Corregir el elemento que provoca overflow.

Solo usarlo si existe razón documentada.

---

# 61. Responsive breakpoints

Reutilizar:

```text
@orp-breakpoint-sm
@orp-breakpoint-md
@orp-breakpoint-lg
@orp-breakpoint-xl
```

No crear breakpoints específicos del AppShell salvo necesidad real.

---

# 62. Mobile-first

CSS base:

```text
mobile
```

Media queries:

```text
larger screens
```

No diseñar desktop primero para después deshacerlo en mobile.

---

# 63. Sidebar breakpoint

Valor recomendado inicial:

```text
lg
```

pero permitir ajustar mediante LESS si el proyecto lo requiere.

---

# 64. App Shell container queries

No usar Container Queries para estructura principal inicialmente.

Viewport breakpoints son suficientes para shell.

Container queries siguen siendo útiles dentro de componentes.

---

# 65. Layout primitive: Region

NO crear:

```text
orp-region
```

solo porque suena abstracto.

AppShell + PageContent + Section ya cubren la mayoría de casos.

Evitar abstraer sin necesidad.

---

# 66. Layout primitive: Spacer

No crear componentes spacer.

Usar:

```text
Stack
Gap
Spacing utilities
```

---

# 67. App shell background

Usar:

```text
--orp-background
```

No crear:

```text
--orp-app-shell-gray
```

---

# 68. Sidebar surface

Sidebar puede utilizar:

```text
--orp-surface
--orp-border
```

por defecto.

---

# 69. Header surface

Header puede utilizar:

```text
--orp-surface
```

o quedar transparente dependiendo de AppBar.

No duplicar visual styling si AppBar ya lo controla.

---

# 70. Separation of responsibility

Mantener:

```text
AppShell
→ positioning/layout
```

```text
AppBar
→ header UI
```

```text
BottomNav
→ navigation UI
```

```text
Drawer
→ mobile overlay navigation
```

```text
PageContent
→ page spacing
```

---

# 71. Navigation independence

AppShell NO conoce:

```text
links
routes
Inertia
Vue Router
Laravel
```

---

# 72. No Vue wrapper automatically

NO crear:

```text
OrpAppShell.vue
OrpPageContent.vue
```

automáticamente.

HTML + CSS debe ser suficiente.

---

# 73. Vue slot wrapper future

Si posteriormente se detecta mucha repetición:

puede evaluarse:

```text
OrpAppShell.vue
```

con slots:

```text
header
sidebar
default
bottom
fab
```

Pero NO en esta fase.

---

# 74. Layout example mobile

```html
<div
    class="
        orp-app-shell
        orp-app-shell--has-header
        orp-app-shell--has-bottom
    "
>

    <header
        class="
            orp-app-shell__header
            orp-app-shell__header--sticky
        "
    >

        <div class="orp-app-bar">

            <div class="orp-app-bar__content">

                <h1 class="orp-app-bar__title">
                    Aplicación
                </h1>

            </div>

        </div>

    </header>


    <main class="orp-app-shell__main">

        <div class="orp-page-content">

            <section class="orp-section">
                ...
            </section>

        </div>

    </main>


    <nav
        class="
            orp-app-shell__bottom
            orp-app-shell__bottom--fixed
        "
    >

        <div class="orp-bottom-nav">
            ...
        </div>

    </nav>

</div>
```

---

# 75. Example with FAB

```html
<div
    class="
        orp-app-shell
        orp-app-shell--has-bottom
    "
>

    <main class="orp-app-shell__main">
        ...
    </main>

    <div class="orp-app-shell__fab">

        <button
            class="
                orp-fab
                orp-fab--primary
            "
            aria-label="Crear"
        >

            <i
                class="
                    bi bi-plus-lg
                    orp-icon
                "
                aria-hidden="true"
            ></i>

        </button>

    </div>

    <nav class="orp-app-shell__bottom">
        ...
    </nav>

</div>
```

---

# 76. Desktop example

```html
<div
    class="
        orp-app-shell
        orp-app-shell--has-sidebar
    "
>

    <aside class="orp-app-shell__sidebar">

        <div class="orp-stack orp-stack--3">
            ...
        </div>

    </aside>

    <div class="orp-app-shell__body">

        <header
            class="
                orp-app-shell__header
                orp-app-shell__header--sticky
            "
        >
            ...
        </header>

        <main class="orp-app-shell__main">

            <div
                class="
                    orp-page-content
                    orp-page-content--contained
                "
            >
                ...
            </div>

        </main>

    </div>

</div>
```

---

# 77. Sidebar navigation

Do not create business/navigation-specific markup.

The application may combine:

```text
orp-list
orp-icon
orp-badge
```

inside sidebar.

---

# 78. Mobile Drawer example

Application may do:

```vue
<OrpDrawer v-model="menuOpen">
    ...
</OrpDrawer>
```

AppShell does not open it.

---

# 79. Layout transitions

Responsive layout changes should generally NOT animate.

Do not animate:

```text
mobile → desktop
sidebar appearing from breakpoint
```

unless there is explicit interaction.

---

# 80. Reduced motion

Any actual AppShell animation must respect:

```text
prefers-reduced-motion
```

But this phase should need minimal animation.

---

# 81. Keyboard

App layout must not change tab order unexpectedly.

Preferred DOM ordering:

```text
header
sidebar where semantically appropriate
main
bottom
```

Review actual accessibility.

---

# 82. Skip link compatibility

AppShell should work with:

```html
<a href="#main-content">
    Skip to content
</a>
```

Main:

```html
<main
    id="main-content"
    class="orp-app-shell__main"
>
```

Do not prevent this pattern.

---

# 83. Landmark elements

Encourage:

```text
header
nav
main
aside
footer
```

instead of only divs.

ORP classes must be element-agnostic.

---

# 84. Mobile keyboard

Test forms inside AppShell with virtual keyboard.

Especially:

```text
fixed BottomNav
Sheet
inputs near bottom
```

Ensure layout does not become unusable.

---

# 85. Fixed bottom + keyboard

Do not add complex JavaScript to detect keyboard in this phase.

Document known behavior.

Prefer modern viewport units and flexible layout.

---

# 86. Modal interaction

Modal, Sheet and Drawer use Teleport.

AppShell must not interfere via:

```text
overflow
transform
z-index
```

on unnecessary ancestors.

---

# 87. Avoid transform on shell

Do NOT add:

```css
transform: translateZ(0);
```

to AppShell as performance hack.

It can create stacking context issues.

---

# 88. Z-index audit

Test:

```text
Sticky AppBar
BottomNav
FAB
Dropdown
Popover
Drawer
Modal
Sheet
Toast
GLightbox
```

Ensure layers are coherent.

---

# 89. GLightbox interaction

GLightbox must render over AppShell.

Do not give shell z-index unnecessarily.

---

# 90. AppShell z-index

Default:

```text
auto
```

unless there is a specific reason.

---

# 91. BottomNav stacking

Bottom region should use:

```text
--orp-z-fixed
```

or equivalent existing token.

FAB should sit appropriately relative to it.

---

# 92. Desktop Sidebar stacking

Sticky sidebar should not sit over:

```text
Modal
Drawer
Dropdown
```

incorrectly.

---

# 93. Theme compatibility

Test:

```text
Light
Dark
Custom
```

AppShell should use semantic tokens.

---

# 94. Full bleed content

Allow content to escape PageContent padding when needed.

Do not invent hacky negative margins automatically.

Document pattern:

```text
AppShell Main
├── Hero full width
└── PageContent
```

Example:

```html
<main class="orp-app-shell__main">

    <section class="orp-hero">
        ...
    </section>

    <div class="orp-page-content">
        ...
    </div>

</main>
```

---

# 95. Full-width sections

This pattern is preferable to:

```text
negative margin hacks
```

---

# 96. Layout + Section

PageContent should compose naturally:

```html
<div class="orp-page-content">

    <div class="orp-stack orp-stack--5">

        <section class="orp-section">
            ...
        </section>

        <section class="orp-section">
            ...
        </section>

    </div>

</div>
```

---

# 97. AppShell + ScrollX

Horizontal scroll components must not create document-level overflow.

Test:

```text
orp-scroll-x
inside PageContent
inside Section
```

---

# 98. Edge-to-edge horizontal scroll

Mobile interfaces often need content scrolling to viewport edge.

Evaluate modifier:

```text
orp-scroll-x--edge
```

only if repeated need exists.

Do not add automatically.

---

# 99. Responsive content padding

PageContent can increase padding progressively.

Example:

```less
.orp-page-content {
    padding-inline: var(--orp-space-4);
}

@media (min-width: @orp-breakpoint-md) {

    .orp-page-content {
        padding-inline: var(--orp-space-5);
    }

}
```

Keep scale modest.

---

# 100. AppShell tokens

Add only needed tokens.

Potential:

```text
--orp-sidebar-width
--orp-content-max-width
--orp-page-padding
```

Reuse existing:

```text
--orp-app-bar-height
--orp-bottom-nav-height
--orp-space-*
```

---

# 101. LESS variables

Possible:

```less
@orp-sidebar-width: 280px;
@orp-content-max-width: 1200px;
```

Expose runtime variables when useful.

---

# 102. Do not duplicate header height

Do not create:

```text
--orp-shell-header-height
```

if:

```text
--orp-app-bar-height
```

already represents it.

---

# 103. CSS files

Suggested:

```text
less/
└── layout/
    ├── app-shell.less
    ├── page-content.less
    └── safe-area.less
```

If architecture already uses another convention, adapt.

---

# 104. Import order

Layout should load after:

```text
tokens
base
```

and before highly specific components when sensible.

Example:

```text
Abstracts
Themes
Base
Layout
Utilities
Components
Integrations
```

Do not reorder whole framework without reason.

---

# 105. Playground

Update:

```text
OrpPlayground.vue
```

Add:

```text
Application Layout
```

---

# 106. Playground AppShell

Create isolated demos for:

```text
Basic Shell
Sticky AppBar
Fixed BottomNav
FAB + BottomNav
Sidebar Desktop
Contained Content
Full-width Hero
```

---

# 107. Playground shell height

Do not make demos require scrolling the entire documentation page endlessly.

Can use controlled preview frames where appropriate.

But preview styles must also use ORP or isolated playground CSS, not Bootstrap.

---

# 108. Preview frames

If creating demo frame:

```text
orp-demo-device
```

belongs to Playground only.

Do NOT put demo classes in ORP core.

---

# 109. Responsive testing

Test:

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

# 110. Mobile tests

Check:

```text
Sticky AppBar
BottomNav
FAB
safe area
ScrollX
forms near bottom
long content
```

---

# 111. Tablet tests

Check:

```text
content width
sidebar breakpoint
padding
header
```

---

# 112. Desktop tests

Check:

```text
sidebar
main width
contained content
sticky regions
dropdowns
modals
```

---

# 113. Landscape mobile

Test approximate landscape viewport.

Check AppBar and BottomNav do not consume excessive space.

---

# 114. Safe Area testing

If device simulator supports it, test:

```text
notch
home indicator
```

If not, verify calculations manually.

---

# 115. Content stress test

Test:

```text
very long page
very short page
empty page
large image
horizontal scroll
form
modal
drawer
```

---

# 116. No domain-specific layouts

Do not create:

```text
orp-dashboard-shell
orp-commerce-shell
orp-restaurant-layout
orp-profile-page
orp-admin-layout
```

These belong to applications.

Correct:

```text
orp-app-shell
orp-page-content
orp-section
```

---

# 117. No business assumptions

AppShell must not assume:

```text
user account
cart
notifications
dashboard
```

It only provides regions.

---

# 118. Layout composition rule

Before creating a new layout class ask:

> Does this describe screen structure or a particular application?

If it describes a specific application:

do not add it to ORP UI.

---

# 119. Accessibility audit

Review:

```text
landmarks
keyboard order
skip links
focus
fixed navigation
zoom
scroll
```

---

# 120. Focus visibility

Fixed regions must not hide focused elements behind:

```text
AppBar
BottomNav
```

Evaluate:

```css
scroll-padding-top
scroll-padding-bottom
```

where useful.

---

# 121. Scroll padding

Potential:

```less
html {
    scroll-padding-top: var(--orp-app-bar-height);
}
```

BUT do not set globally unless clearly opt-in.

Better scoped or documented.

---

# 122. Shell scroll padding

For contained scroll:

```less
.orp-app-shell__main {
    scroll-padding-top: var(--orp-app-bar-height);
    scroll-padding-bottom: var(--orp-bottom-nav-height);
}
```

only if relevant.

---

# 123. Build

Run existing build.

Confirm:

```text
LESS compiles
Vite build succeeds
themes work
integrations work
```

---

# 124. CSS growth

Report approximate CSS increase.

JS increase should be:

```text
zero or practically zero
```

for this phase.

---

# 125. No new dependencies

Do NOT install layout libraries.

No:

```text
CSS framework
grid framework
viewport library
safe area library
```

Everything should be possible with native CSS/LESS.

---

# 126. Documentation

Create documentation:

```text
docs/layout/
├── app-shell.md
├── page-content.md
├── safe-areas.md
└── responsive-layout.md
```

Adapt paths to existing docs architecture.

---

# 127. App Shell docs

Document:

```text
basic shell
header
main
bottom
sidebar
FAB
scroll modes
```

---

# 128. Safe Areas docs

Explain:

```text
what safe areas are
where ORP applies them
how to avoid duplication
```

---

# 129. Responsive docs

Explain official pattern:

```text
Mobile
→ AppBar + Main + BottomNav
```

```text
Desktop
→ Sidebar + Body + Main
```

as an example, not mandatory layout.

---

# 130. Documentation warning

Explicitly document:

```text
Do not add manual padding for fixed BottomNav when AppShell already compensates for it.
```

Likewise for safe areas.

---

# 131. AppShell + Bootstrap Icons

Examples can use:

```text
Bootstrap Icons
```

but AppShell itself must not depend on them.

---

# 132. AppShell + GLightbox

Verify overlays render correctly.

No special integration should be needed.

---

# 133. AppShell + Swiper

Verify:

```text
Hero Swiper
Media Card Swiper
```

inside Main without overflow issues.

---

# 134. Existing components audit

Specifically test:

```text
AppBar
BottomNav
Drawer
FAB
Modal
Sheet
Toast
Dropdown
Popover
```

inside new shell.

---

# 135. Avoid changing APIs

Do not rewrite existing AppBar or BottomNav APIs unless a real layout bug requires it.

Prefer integration through AppShell.

---

# 136. Backward compatibility

Existing applications that use:

```text
orp-app-bar
orp-bottom-nav
```

without AppShell should continue working.

AppShell is additive.

---

# 137. Result expected

At completion report:

## Files created

List.

## Files modified

List.

## Layout primitives

```text
orp-app-shell
orp-app-shell__body
orp-app-shell__header
orp-app-shell__main
orp-app-shell__bottom
orp-app-shell__sidebar
orp-app-shell__fab
orp-page-content
```

## Safe Area

List helpers or internal behavior implemented.

## Tokens

List only new tokens.

## Responsive

Explain mobile/tablet/desktop behavior.

## Playground

List new demos.

## Accessibility

Explain checks.

## Themes

Confirm Light/Dark.

## Integrations

Confirm Icons/Swiper/GLightbox still work.

## Build

Report result.

## Bundle

Report approximate CSS/JS impact.

## Conflicts

Report problems found.

---

# 138. Completion criteria

Parte 9 ends when:

```text
AppShell works mobile-first
Sticky AppBar works
Fixed BottomNav works
Main content is not hidden
FAB avoids BottomNav
Safe areas work
Desktop Sidebar pattern works
PageContent works
Themes work
Overlays render correctly
Build passes
```

---

# 139. Do not continue automatically

Do not implement:

```text
Breadcrumb
Pagination
Stepper
Sidebar navigation groups
Command bar
Navigation rail
```

These belong to a later navigation phase.

---

# Final Rule

Parte 9 exists to eliminate repeated application-layout hacks.

The developer should be able to compose:

```text
AppShell
+
AppBar
+
PageContent
+
Section
+
BottomNav
+
FAB
```

without manually calculating heights and offsets.

Keep the separation:

```text
ORP UI
→ structure and layout
```

```text
Application
→ navigation and meaning
```

Never create domain-specific shells.

Prefer:

```text
orp-app-shell
```

over:

```text
orp-dashboard
orp-shop-layout
orp-admin-shell
orp-profile-layout
```

ORP UI must remain:

```text
generic
mobile-first
responsive
composable
predictable
low-dependency
```
