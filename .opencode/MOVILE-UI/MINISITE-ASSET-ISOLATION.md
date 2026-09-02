# SKILL — ORP UI / Parte 26.1: Public Minisite Asset Isolation

## Objetivo

Aislar correctamente los assets del **minisite público** de Acerca para que las rutas públicas:

```text
/m/{slug}
```

NO carguen estilos ni dependencias visuales del área administrativa.

Caso detectado:

```text
http://acerca.local/m/invitaciones
```

El HTML actual está cargando assets como:

```text
admin-*.css
app-*.css
runtime-dom-*.css
leaflet-*.css
```

y el minisite público todavía recibe estilos de Bootstrap/administración.

Esto invalida parcialmente el dogfooding de ORP UI porque cualquier sección migrada puede seguir heredando estilos ajenos.

---

# 1. Problema principal

El frontend público debe estar separado visualmente del admin.

Arquitectura deseada:

```text
ADMIN / MEMBER
Laravel + Inertia + Vue
Bootstrap
admin.less
app.js
        │
        └── /member/*
             /admin/*
             dashboard
             editor
             modules
```

y:

```text
PUBLIC MINISITE
/m/{slug}
        │
        ├── ORP UI
        ├── minisite.less
        ├── minisite.js
        ├── Swiper cuando aplique
        ├── GLightbox cuando aplique
        └── Leaflet cuando aplique

        X Bootstrap CSS
        X admin.less
        X admin-*.css
```

---

# 2. Regla principal

NO continuar con una migración masiva de secciones ORP mientras:

```text
/m/{slug}
```

siga cargando:

```text
admin.css
Bootstrap CSS
admin layout styles
```

Primero corregir aislamiento de assets.

---

# 3. Evidencia actual

El HTML público de:

```text
/m/invitaciones
```

ha mostrado un asset compilado similar a:

```text
/build/assets/admin-XXXXXXXX.css
```

cargado directamente desde `<head>`.

Esto debe desaparecer del minisite público.

---

# 4. Primera tarea

Auditar cómo se construye realmente:

```text
/m/{slug}
```

Localizar:

```text
route
controller
Inertia render
Blade root
Vue entry
Minisite.themes.base.Show
Vite imports
LESS imports
```

---

# 5. No asumir origen

No asumir que `admin.css` viene necesariamente del Blade.

Puede entrar desde:

```text
@vite(...)
resources/js/app.js
dynamic import
Vue root
LESS import
shared layout
Inertia root
Vite entry dependency graph
```

Encontrar causa real.

---

# 6. Component target

La respuesta actual indica algo similar a:

```text
Minisite.themes.base.Show
```

Localizar ese componente.

---

# 7. Root Blade audit

Localizar el Blade que contiene:

```html
<div id="app">
```

y revisar:

```php
@vite(...)
```

---

# 8. Vite entry audit

Revisar:

```text
vite.config.js
```

y entradas actuales.

Ya existe conceptualmente una arquitectura con:

```text
resources/less/admin.less
resources/less/minisite.less
resources/js/app.js
resources/js/minisite.js
```

Confirmar nombres reales.

---

# 9. Required asset map

Crear temporalmente un mapa:

```text
ENTRY
   ↓
IMPORTS
   ↓
CSS
   ↓
ROUTES USING IT
```

---

# 10. Identify admin entry

Determinar qué entry contiene:

```text
Bootstrap
admin.less
admin components
dashboard styles
```

---

# 11. Identify minisite entry

Determinar qué entry debería contener:

```text
ORP UI
minisite.less
minisite JS
public-only integrations
```

---

# 12. Bootstrap source audit

Buscar import directo/indirecto de:

```text
bootstrap
bootstrap/dist/css/bootstrap.css
bootstrap/dist/css/bootstrap.min.css
bootstrap/scss/bootstrap
admin.less
```

---

# 13. LESS dependency graph

Revisar si:

```text
minisite.less
```

importa accidentalmente:

```text
admin.less
app.less
bootstrap
shared bootstrap variables
```

---

# 14. JS dependency graph

Revisar si:

```text
minisite.js
```

importa:

```text
app.js
admin.less
Bootstrap JS
Bootstrap CSS
```

---

# 15. Shared app.js problem

Si:

```text
app.js
```

se usa para TODO el sistema y contiene:

```js
import '../less/admin.less'
```

el minisite NO debería usar ese mismo entry.

---

# 16. Correct architectural goal

Preferir:

```text
Admin entry
resources/js/app.js
resources/less/admin.less
```

y:

```text
Public minisite entry
resources/js/minisite.js
resources/less/minisite.less
```

Adaptar a estructura real.

---

# 17. Do not duplicate Vue runtime blindly

Separar entries no significa necesariamente duplicar todo el framework en producción.

Vite puede crear chunks compartidos.

Eso está bien.

---

# 18. CSS isolation matters more

El requisito crítico es:

```text
admin CSS must not be part of minisite CSS graph
```

---

# 19. Blade strategy

Si Laravel Blade decide qué assets cargar:

usar entry correspondiente al contexto.

Ejemplo conceptual:

```php
@if ($isMinisite)
    @vite([
        'resources/less/minisite.less',
        'resources/js/minisite.js',
    ])
@else
    @vite([
        'resources/less/admin.less',
        'resources/js/app.js',
    ])
@endif
```

NO copiar literalmente sin revisar arquitectura.

---

# 20. Better layout separation

Si ya existen layouts distintos:

preferir:

```text
layouts/app.blade.php
layouts/minisite.blade.php
```

o equivalentes existentes.

No inventar layouts adicionales si ya hay separación adecuada.

---

# 21. Inertia root consideration

Si admin y minisite usan Inertia:

investigar cómo se selecciona root view.

Laravel/Inertia permite root templates distintos.

Usar arquitectura real antes de cambiarla.

---

# 22. Potential root view strategy

Conceptualmente podría existir:

```text
app.blade.php
```

para administración y:

```text
minisite.blade.php
```

para frontend público.

Solo implementar si encaja con proyecto actual.

---

# 23. No Bootstrap removal from project

NO eliminar:

```text
bootstrap
bootstrap-icons
admin.less
admin components
```

del proyecto completo.

---

# 24. Bootstrap can remain admin-only

Resultado deseado:

```text
/member/*
→ Bootstrap remains

/m/*
→ Bootstrap absent
```

---

# 25. Bootstrap Icons distinction

Bootstrap Icons NO es Bootstrap CSS.

Puede mantenerse en minisite si ORP lo usa como integración opcional.

---

# 26. Required final HTML check

Después de build:

inspeccionar HTML de:

```text
/m/invitaciones
```

---

# 27. Expected CSS

Debe existir algo equivalente a:

```text
minisite-*.css
ORP UI CSS
integration CSS actually required
```

---

# 28. Forbidden CSS

No debe aparecer:

```text
admin-*.css
bootstrap.css
bootstrap.min.css
```

ni un bundle que incluya Bootstrap internamente.

---

# 29. Important caveat

El nombre del archivo no basta.

Un archivo llamado:

```text
minisite-*.css
```

podría contener Bootstrap si se importó indirectamente.

También inspeccionar contenido/dependency graph.

---

# 30. Detect Bootstrap signatures

Buscar en CSS final selectores característicos como:

```text
.container
.row
.btn
.btn-primary
.card
.form-control
.navbar
.modal
```

---

# 31. False positives

No asumir que una sola coincidencia significa Bootstrap completo.

Revisar origen.

---

# 32. ORP namespace

Confirmar presencia esperada:

```text
.orp-*
--orp-*
```

---

# 33. Admin namespace

Si admin tiene clases no prefijadas:

deben quedar fuera del minisite.

---

# 34. Global reset audit

Bootstrap también afecta:

```text
body
button
input
a
h1-h6
img
table
```

Por eso eliminar solo `.btn` no es suficiente.

---

# 35. Visual baseline before fix

Tomar screenshot actual si tooling existente lo permite.

---

# 36. Visual test after isolation

Después de quitar admin/Bootstrap CSS:

NO empezar inmediatamente a "arreglar" todos los cambios visuales.

Primero observar qué queda realmente con ORP.

---

# 37. Expected temporary breakage

Es posible que aparezcan secciones sin estilo.

Eso es información útil.

Significa que dependían accidentalmente de Bootstrap.

---

# 38. Do not restore Bootstrap

Si una sección pierde estilo:

migrarla correctamente.

No volver a importar Bootstrap al minisite.

---

# 39. Section classification after isolation

Clasificar:

```text
ORP READY
BOOTSTRAP DEPENDENT
PARTIALLY MIGRATED
UNSTYLED
BROKEN
EXTERNAL
```

---

# 40. Update migration matrix

Actualizar:

```text
.opencode/plans/ORP-MIGRATION-MATRIX.md
```

con una columna:

```text
Bootstrap Dependency After Isolation
```

---

# 41. Update dogfooding log

Registrar esta detección como:

```text
BOOTSTRAP CONFLICT
```

o:

```text
APPLICATION ARCHITECTURE
```

según causa real.

---

# 42. Severity

Este problema debe considerarse al menos:

```text
HIGH
```

para el objetivo de ORP dogfooding.

---

# 43. Why HIGH

Porque afecta:

```text
visual consistency
CSS ownership
framework validation
bundle size
predictability
component debugging
```

---

# 44. Build verification

Ejecutar scripts reales.

Por ejemplo:

```bash
npm run build
```

solo si ese es el script real.

---

# 45. No manual dist patching

No editar archivos dentro de:

```text
public/build
dist
```

como solución.

Corregir source.

---

# 46. Vite manifest

Confirmar que manifest final contiene entry del minisite.

---

# 47. Production parity

No validar solo con Vite dev server.

También validar build producción.

---

# 48. Dev mode

Después de corregir arquitectura:

probar también:

```text
npm run dev
```

si aplica.

---

# 49. HMR

Asegurar que minisite siga recibiendo HMR correctamente en desarrollo.

---

# 50. Leaflet

El HTML actual también muestra:

```text
leaflet-*.css
```

No eliminarlo automáticamente.

---

# 51. Leaflet loading decision

Verificar si:

```text
/m/invitaciones
```

realmente necesita Leaflet.

---

# 52. If map not present

Registrar oportunidad de lazy/conditional loading.

No convertirlo en blocker de esta fase.

---

# 53. Swiper / GLightbox

Misma lógica.

Solo cargar globalmente si arquitectura lo justifica.

---

# 54. Scope of this skill

El objetivo principal es:

```text
ADMIN CSS ISOLATION
```

No convertir esta fase en optimización completa de code splitting.

---

# 55. Bootstrap JS

También revisar si minisite descarga Bootstrap JS.

---

# 56. Bootstrap JS forbidden when unused

Si el minisite ORP ya no usa:

```text
Bootstrap Modal
Dropdown
Collapse
Offcanvas
```

no debería cargar Bootstrap JS innecesariamente.

---

# 57. Popper

Si solo entra por Bootstrap:

registrar/remover del minisite dependency graph cuando corresponda.

---

# 58. Admin JS

No debe ejecutarse en minisite público.

Ejemplos:

```text
admin sidebar
dashboard widgets
admin listeners
admin plugins
```

---

# 59. Public JS

Debe inicializar solo lo necesario.

---

# 60. Inertia shared props

El HTML actual muestra muchos datos administrativos/globales.

Auditar también esto.

---

# 61. Important secondary finding

El minisite público parece recibir props como:

```text
auth
permissions
roles
modules
notificationUnreadCount
businessMenu
features
```

Revisar si realmente son necesarias en `/m/{slug}`.

---

# 62. Security/performance concern

No asumir que compartir props es una vulnerabilidad.

Pero minimizar datos públicos innecesarios mejora:

```text
payload
privacy surface
clarity
performance
```

---

# 63. Shared middleware audit

Revisar:

```text
HandleInertiaRequests
share()
middleware
global props
```

---

# 64. Do not remove required props blindly

El minisite puede necesitar algunas.

Clasificar:

```text
REQUIRED
ADMIN ONLY
GLOBAL
UNKNOWN
```

---

# 65. This is secondary

Primero assets CSS/JS.

Luego shared props si el cambio es seguro.

---

# 66. Auth public route

Si `/m/{slug}` es público:

verificar comportamiento tanto:

```text
logged in
logged out
```

---

# 67. Important test

Abrir minisite en sesión incógnita/no autenticada.

Debe renderizar igual salvo funciones intencionalmente personalizadas.

---

# 68. Admin CSS hidden by auth

No permitir que asset selection dependa accidentalmente de usuario autenticado.

Debe depender del tipo de página.

---

# 69. Cache

Si hay cache de Blade/Vite:

limpiarlo solo con comandos seguros/reales cuando sea necesario.

---

# 70. Laravel optimization

Después de cambios de layout/config, ejecutar según flujo del proyecto:

```text
optimize:clear
```

solo si corresponde.

---

# 71. Do not destroy production cache blindly

Este es entorno local de referencia.

Para producción documentar pasos.

---

# 72. CSP

Separar entries no debe introducir CDN innecesarios.

---

# 73. Asset URLs

Mantener Vite helpers.

No hardcodear:

```text
/build/assets/archivo-hash.css
```

---

# 74. Hashed filenames

Siempre gestionados por manifest/Vite.

---

# 75. Mobile regression

Después de aislamiento probar:

```text
320
375
390
430
```

---

# 76. Desktop regression

Probar:

```text
768
1200
1440
```

---

# 77. Key visual checks

```text
body background
typography
buttons
lists
cards
forms
gallery
hero
navigation
footer
```

---

# 78. ORP tokens

Confirmar que brand theme continúa funcionando.

---

# 79. Theme root

Verificar dónde se aplican:

```text
data-orp-theme
--orp-primary
--orp-background
```

---

# 80. Bootstrap absence effect

Buscar especialmente cambios en:

```text
box-sizing
button reset
heading margins
paragraph margins
form controls
images
```

---

# 81. ORP foundation responsibility

Si ORP necesita un reset mínimo para funcionar sin Bootstrap:

eso sí es un posible issue del framework.

---

# 82. Do not recreate Bootstrap reset

ORP Foundation debe seguir siendo minimalista.

Corregir solo gaps reales.

---

# 83. Record ORP dependency assumptions

Si un componente ORP solo se veía bien porque Bootstrap normalizaba algo:

registrarlo como:

```text
BUG
```

o:

```text
FOUNDATION GAP
```

---

# 84. Tests

Agregar un test/fixture de consumo sin Bootstrap si tooling lo permite.

---

# 85. Required regression fixture

Conceptualmente:

```text
public-minisite-no-bootstrap
```

---

# 86. Test principle

Debe demostrar:

```text
ORP UI works without Bootstrap CSS present
```

---

# 87. Consumer test reuse

Puede reutilizar ideas de Parte 23:

```text
ORP CSS-only
ORP + Vue
Bootstrap coexistence
```

Pero este caso prueba ausencia.

---

# 88. CSS order

Documentar orden final.

Ejemplo conceptual:

```text
ORP core
minisite theme
minisite application styles
external integrations
```

Usar orden real.

---

# 89. No circular imports

Evitar:

```text
admin.less
→ shared.less
→ minisite.less
→ admin.less
```

---

# 90. Shared LESS

Si existe CSS verdaderamente compartido:

extraer/usar un archivo neutral.

Ejemplo conceptual:

```text
shared/base.less
```

pero solo si hay evidencia.

---

# 91. Shared file must be neutral

No debe contener:

```text
Bootstrap overrides
admin sidebar styles
dashboard cards
```

---

# 92. ORP source ownership

No meter estilos Acerca en ORP package para resolver imports.

---

# 93. Minisite source ownership

Styles domain-specific deben quedarse en:

```text
minisite.less
section styles
Acerca Vue components
```

---

# 94. Completion criteria

Esta fase se considera completa cuando:

```text
/m/invitaciones builds
/m/invitaciones renders
admin CSS is absent
Bootstrap CSS is absent
ORP CSS is present
minisite CSS is present
required external integration CSS is present
no critical console errors
brand theme works
mobile smoke passes
desktop smoke passes
```

---

# 95. Additional required check

La administración debe seguir funcionando.

Probar al menos una ruta:

```text
/member/*
```

que use Bootstrap.

---

# 96. Admin expected result

```text
Bootstrap CSS PRESENT
admin CSS PRESENT
ORP only where intentionally used
```

---

# 97. No collateral damage

La separación no debe romper:

```text
admin navigation
forms
modals
dashboard
editor
```

---

# 98. Final report

Crear:

```text
.opencode/plans/ORP-MINISITE-ASSET-ISOLATION.md
```

---

# 99. Report structure

```text
# ORP Minisite Asset Isolation

## Root Cause

## Current Asset Graph

## Admin Entry

## Minisite Entry

## Bootstrap Source

## Files Modified

## Vite Changes

## Blade/Inertia Changes

## LESS Changes

## JS Changes

## Before HTML Assets

## After HTML Assets

## Bootstrap CSS Check

## Admin CSS Check

## ORP CSS Check

## External Integrations

## Shared Props Audit

## Mobile Verification

## Desktop Verification

## Admin Regression

## ORP Issues Found

## Remaining Bootstrap-dependent Sections

## Status
```

---

# 100. Status

Finalizar con una:

```text
PASS — MINISITE ASSETS ISOLATED
```

o:

```text
FAIL — ADMIN/BOOTSTRAP STILL LEAKING
```

---

# 101. Evidence format

Mostrar listado final aproximado:

```text
PUBLIC /m/invitaciones

admin.css:
ABSENT

bootstrap.css:
ABSENT

orp-ui.css:
PRESENT

minisite.css:
PRESENT

leaflet.css:
PRESENT / NOT REQUIRED

swiper.css:
PRESENT / NOT REQUIRED

glightbox.css:
PRESENT / NOT REQUIRED
```

---

# 102. Do not fake filenames

Usar nombres reales del manifest final.

---

# 103. Do not continue migration automatically

Al terminar esta fase:

NO migrar Gallery/Products/Hero automáticamente.

Primero reportar resultado.

---

# 104. Next action after PASS

Si aislamiento pasa:

retomar:

```text
Parte 26 — Acerca Minisite Migration & Real-World Framework Feedback
```

con un entorno limpio de Bootstrap.

---

# 105. Next action after FAIL

Si sigue entrando Bootstrap/admin CSS:

detener la migración ORP y resolver root cause.

---

# Regla final

Antes:

```text
ORP component
+
Bootstrap global CSS
+
admin CSS
=
resultado visual ambiguo
```

Después:

```text
ORP UI
+
minisite styles
+
specialized integrations
=
public mobile UI
```

El minisite público debe poder demostrar que ORP UI funciona **sin necesitar Bootstrap como dependencia visual oculta**.

