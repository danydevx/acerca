# ORP UI — MAP COMPONENTS
# PHASE 1: OrpMap + OrpMapMarker
# LEAFLET + OPENSTREETMAP

Vamos a pausar temporalmente la creación de Patterns.

Durante el diseño de OrpContactCard descubrimos una necesidad genérica que debe resolverse primero en ORP:

MAPAS.

ORP debe proporcionar componentes Vue reutilizables para mapas, usando:

- Leaflet como motor de mapas.
- OpenStreetMap como proveedor/cartografía por defecto.

Esta fase implementará únicamente:

1. OrpMap
2. OrpMapMarker

NO implementar todavía:

- OrpContactCard
- OrpMapPopup
- OrpMapCircle
- OrpMapPolyline
- OrpMapPolygon
- clustering
- geocoding
- routing
- directions
- search
- drawing tools
- Google Maps

La regla sigue siendo:

DISCOVER → EXTRACT → REUSE → COMPOSE

==================================================
1. OBJETIVO
==================================================

Crear una pequeña base nativa de componentes ORP para integrar mapas Leaflet dentro de cualquier aplicación que utilice ORP UI.

Debe servir para:

- ubicaciones
- sucursales
- propiedades
- restaurantes
- eventos
- directorios
- perfiles
- vCards
- puntos de servicio
- mapas de contacto
- múltiples marcadores
- interfaces geográficas futuras

SIN conocer ningún dominio.

==================================================
2. ARQUITECTURA
==================================================

ORP UI
│
├── Foundation
│
├── Primitives / Primary
│   ├── Grid
│   ├── Stack
│   ├── Cluster
│   └── ...
│
├── Components
│   ├── Modal
│   ├── Drawer
│   ├── Accordion
│   │
│   └── Map
│       ├── OrpMap
│       └── OrpMapMarker
│
└── Patterns
    ├── CatalogCard
    ├── PricingCard
    ├── ProfileCard
    ├── ContentCard
    ├── StatCard
    └── ContactCard ← DESPUÉS

Map pertenece a Components porque Vue sí aporta comportamiento real:

- lifecycle
- instancia Leaflet
- montaje
- cleanup
- markers
- eventos
- reactive updates
- resize/invalidateSize

==================================================
3. AUDIT OBLIGATORIO
==================================================

ANTES de implementar:

auditar el repositorio completo.

Buscar:

- instalación actual de Leaflet
- imports de leaflet
- CSS Leaflet
- OpenStreetMap tiles
- mapas existentes
- SectionLocations
- componentes de ubicación
- vCards
- propiedades
- restaurant/location sections
- helpers geográficos
- composables relacionados
- icon configuration
- Vite configuration
- SSR/Inertia concerns
- ORP component conventions
- ORP Playground
- ORP tests

NO asumir que Leaflet debe instalarse nuevamente.

Si ya existe:

REUTILIZAR la instalación actual.

==================================================
4. DEPENDENCIAS
==================================================

Leaflet es la única librería de mapas permitida en esta fase.

OpenStreetMap será el proveedor de tiles por defecto.

NO agregar:

Google Maps
Mapbox
MapLibre
OpenLayers
HERE
Bing Maps
TomTom

NO agregar wrappers como:

vue-leaflet
vue2-leaflet
react-leaflet

ORP debe integrar Leaflet directamente.

==================================================
5. NO DUPLICAR LEAFLET
==================================================

Primero revisar:

package.json
package-lock.json
imports existentes

Si Leaflet ya está instalado:

NO reinstalar.

Si no está instalado y el proyecto realmente lo necesita:

instalar la versión compatible con el stack actual.

Documentar cualquier cambio de dependencia.

==================================================
6. RESPONSABILIDAD DE OrpMap
==================================================

OrpMap debe encargarse de:

- crear el container
- inicializar Leaflet
- configurar center
- configurar zoom
- agregar tile layer
- gestionar lifecycle
- destruir correctamente el mapa
- actualizar center/zoom cuando corresponda
- proporcionar contexto a child map components
- manejar resize de forma robusta
- exponer eventos genéricos cuando estén justificados

NO debe contener business logic.

==================================================
7. API CONCEPTUAL DE OrpMap
==================================================

Dirección aproximada:

<OrpMap
    :center="[20.6736, -103.344]"
    :zoom="14"
>
    ...
</OrpMap>

La API final debe surgir del audit.

Props genéricos posibles:

center
zoom
minZoom
maxZoom
zoomControl
scrollWheelZoom
dragging
tileUrl
tileAttribution

NO implementar todos automáticamente.

Mantener API pequeña.

==================================================
8. CENTER
==================================================

Center representa coordenadas geográficas.

Aceptar formato consistente con Leaflet o una normalización mínima claramente documentada.

Ejemplo:

[latitude, longitude]

NO aceptar objetos de negocio como:

business
office
store
property

==================================================
9. DEFAULT CENTER
==================================================

Evaluar si OrpMap debe exigir center o proporcionar default.

Evitar un default arbitrario geográfico sin justificación.

Si center es obligatorio:

documentarlo.

==================================================
10. ZOOM
==================================================

Debe existir un zoom inicial razonable/configurable.

No crear presets:

city
street
country
business

Usar número genérico compatible con Leaflet.

==================================================
11. OPENSTREETMAP
==================================================

OpenStreetMap será la configuración cartográfica por defecto.

La implementación debe incluir atribución correcta.

NO eliminar atribución de OpenStreetMap.

La atribución debe permanecer visible y cumplir los requisitos del proveedor.

==================================================
12. TILE PROVIDER
==================================================

Aunque OSM sea default, evitar acoplamiento innecesario si una API pequeña permite cambiar tileUrl/attribution.

Pero:

NO construir un sistema completo de providers.

No crear:

provider="google"
provider="mapbox"
provider="bing"

==================================================
13. TILE USAGE
==================================================

No asumir que el tile server público de OpenStreetMap es apropiado para cualquier volumen de producción.

Documentar que:

- OpenStreetMap proporciona datos/cartografía.
- El tile endpoint por defecto puede tener políticas de uso.
- aplicaciones de alto tráfico pueden requerir un proveedor de tiles compatible.

Esto es documentación, NO implementar proveedores extra.

==================================================
14. RESPONSABILIDAD DE OrpMapMarker
==================================================

OrpMapMarker representa un marcador genérico dentro de OrpMap.

Ejemplo:

<OrpMapMarker
    :position="[20.6736, -103.344]"
/>

Debe:

- obtener la instancia de mapa desde OrpMap
- crear marker Leaflet
- actualizar posición si cambia
- eliminar marker al desmontarse
- emitir eventos genéricos si están justificados

==================================================
15. CONTEXT / PROVIDE-INJECT
==================================================

Evaluar Vue provide/inject para compartir la instancia Leaflet.

Conceptualmente:

OrpMap
    provide(map context)

OrpMapMarker
    inject(map context)

No utilizar:

global variables
window.orpMap
DOM query hacks
IDs hardcodeados

==================================================
16. MULTIPLE MAPS
==================================================

Debe ser posible tener múltiples OrpMap en la misma página.

Cada mapa debe mantener:

- instancia propia
- markers propios
- lifecycle independiente

NO depender de IDs globales fijos.

==================================================
17. MULTIPLE MARKERS
==================================================

Debe funcionar:

<OrpMap>
    <OrpMapMarker ... />
    <OrpMapMarker ... />
    <OrpMapMarker ... />
</OrpMap>

No limitar a un solo marcador.

==================================================
18. MARKER ICON
==================================================

Auditar el problema conocido de assets de iconos Leaflet con bundlers.

Verificar que:

marker-icon.png
marker-icon-2x.png
marker-shadow.png

se resuelvan correctamente con Vite.

NO aceptar markers rotos en Playground.

Si el proyecto ya tiene una solución:

REUTILIZARLA.

==================================================
19. CUSTOM MARKERS
==================================================

NO construir un sistema complejo de custom markers todavía.

Evaluar únicamente si la API actual necesita un escape hatch genérico.

No crear:

businessMarker
restaurantMarker
propertyMarker

==================================================
20. POPUPS
==================================================

NO implementar OrpMapPopup en Phase 1.

Pero durante el audit:

determinar si ya existe necesidad real repetida.

Documentar:

CANDIDATE FOR PHASE 2

si corresponde.

No implementarlo automáticamente.

==================================================
21. FIT BOUNDS
==================================================

Multiple markers probablemente revelarán necesidad de fitBounds.

NO implementar automáticamente.

Auditar uso real.

Si es claramente necesario para el funcionamiento mínimo de múltiples markers:

justificarlo explícitamente.

De lo contrario:

dejarlo para Phase 2.

==================================================
22. MAP RESIZE
==================================================

Leaflet puede necesitar:

invalidateSize()

cuando el mapa:

- aparece dentro de modal
- cambia de tamaño
- estaba oculto
- cambia layout
- vive dentro de responsive containers

Diseñar una estrategia robusta.

Evaluar:

ResizeObserver

antes de hacks con setTimeout.

No ejecutar invalidateSize en loops innecesarios.

==================================================
23. RESIZE OBSERVER
==================================================

Si se usa ResizeObserver:

- desconectarlo en cleanup
- evitar leaks
- evitar loops
- verificar soporte del stack

Documentar la decisión.

==================================================
24. SSR / INERTIA
==================================================

El proyecto utiliza Laravel + Inertia + Vue.

Auditar si el componente puede ejecutarse en contextos donde:

window
document

no estén disponibles durante import/evaluation.

Evitar side effects globales innecesarios.

Leaflet debe inicializarse únicamente cuando exista DOM.

==================================================
25. LIFECYCLE
==================================================

OrpMap debe limpiar:

- Leaflet map
- tile layers si corresponde
- observers
- listeners
- context

OrpMapMarker debe limpiar:

- marker
- listeners

No dejar:

detached DOM
event listeners
Leaflet instances

==================================================
26. REACTIVITY
==================================================

Evaluar actualización reactiva de:

center
zoom
marker position

No reconstruir todo el mapa innecesariamente.

Ejemplo:

center cambia
→ setView/panTo según estrategia documentada

marker position cambia
→ setLatLng

==================================================
27. EVENTOS
==================================================

No exponer toda la API Leaflet indiscriminadamente.

Evaluar eventos realmente útiles.

Posibles:

ready
click
moveend
zoomend

Marker:

click

Pero mantener API mínima.

Si no existe evidencia:

implementar solamente los esenciales.

==================================================
28. EXPOSING INSTANCE
==================================================

Evaluar si usuarios avanzados necesitan acceso a la instancia Leaflet.

Una opción podría ser:

ready(map)

o defineExpose.

NO exponer internals sin necesidad.

Si se hace:

documentar que es escape hatch avanzado.

==================================================
29. HEIGHT
==================================================

Un mapa necesita altura explícita.

ORP debe resolver este problema de manera consistente.

NO hardcodear:

height: 400px

como única opción.

Evaluar API/tokens/modifiers existentes.

Posibles estrategias:

size variants
CSS custom property
container aspect ratio

Elegir la opción más consistente con ORP.

==================================================
30. MAP SIZES
==================================================

Si se crean tamaños:

deben ser genéricos.

Ejemplo posible:

sm
md
lg

NO:

contact
property
restaurant

Pero no crear variants si una CSS custom property resuelve mejor el problema.

==================================================
31. BORDER / RADIUS
==================================================

El mapa debe integrarse visualmente con ORP.

Usar tokens existentes para:

radius
border
surface

No inventar valores.

Debe poder vivir:

solo

o dentro de:

Card
ContactCard
Modal
Drawer

==================================================
32. OVERFLOW
==================================================

Si existe border-radius:

asegurar que tiles/map canvas respeten clipping correctamente.

No romper controles Leaflet.

==================================================
33. TOUCH / MOBILE
==================================================

Probar interacción móvil.

Especial atención:

scrollWheelZoom
touch zoom
dragging
page scroll

No impedir que el usuario pueda desplazarse por la página accidentalmente.

Auditar defaults Leaflet antes de modificarlos.

==================================================
34. ACCESSIBILITY
==================================================

Un mapa interactivo no debe ser la única forma de acceder a información esencial.

OrpMap debe permitir:

aria-label
accessible description/context

si la arquitectura ORP lo justifica.

No inventar role="application" automáticamente.

No convertir el mapa en un falso widget ARIA complejo.

==================================================
35. KEYBOARD
==================================================

Auditar comportamiento real de Leaflet.

Verificar:

- controles
- focus
- keyboard navigation
- zoom controls

No romper accesibilidad nativa de Leaflet.

==================================================
36. REDUCED MOTION
==================================================

Evaluar animaciones de:

pan
zoom
flyTo

No introducir movimientos automáticos innecesarios.

Si se implementan:

respetar prefers-reduced-motion cuando corresponda.

==================================================
37. CSS LEAFLET
==================================================

Auditar cómo se importa leaflet.css actualmente.

Evitar importarlo múltiples veces.

Debe existir una estrategia única y documentada.

==================================================
38. ORP CSS
==================================================

Crear únicamente estilos necesarios para el wrapper ORP.

Ejemplo conceptual:

.orp-map
.orp-map__canvas

No copiar CSS interno de Leaflet.

No reescribir:

.leaflet-container
.leaflet-control-zoom
.leaflet-marker-icon

salvo ajustes ORP estrictamente necesarios y justificados.

==================================================
39. NO THEME FORK
==================================================

No intentar rediseñar todo Leaflet en Phase 1.

Primero lograr:

- integración correcta
- layout consistente
- lifecycle robusto
- responsive
- accesibilidad
- API limpia

Styling avanzado puede ser otra fase.

==================================================
40. PLAYGROUND
==================================================

Agregar una sección nueva dentro del Playground existente:

Components → Map

No crear página paralela.

==================================================
41. PLAYGROUND — BASIC MAP
==================================================

Mostrar:

OrpMap

con:

- center
- zoom
- OpenStreetMap
- sin marker

Verificar tiles y atribución.

==================================================
42. PLAYGROUND — SINGLE MARKER
==================================================

Mostrar:

OrpMap
└── OrpMapMarker

con una ubicación de demostración neutral.

No utilizar datos de negocio reales.

==================================================
43. PLAYGROUND — MULTIPLE MARKERS
==================================================

Mostrar:

OrpMap
├── Marker
├── Marker
└── Marker

Validar independencia y cleanup.

==================================================
44. PLAYGROUND — REACTIVE MARKER
==================================================

Agregar demo sencilla donde pueda cambiar la posición del marker usando estado local del Playground.

Verificar:

setLatLng

o estrategia equivalente.

==================================================
45. PLAYGROUND — REACTIVE MAP
==================================================

Agregar demo controlada para cambiar:

center

o:

zoom

sin destruir/recrear la instancia completa.

==================================================
46. PLAYGROUND — MULTIPLE MAPS
==================================================

Renderizar al menos dos OrpMap simultáneamente.

Confirmar que:

- no comparten instancia
- markers no se cruzan
- no hay conflictos de IDs

==================================================
47. PLAYGROUND — RESPONSIVE
==================================================

Mostrar OrpMap dentro de:

Card

y/o:

Grid

para validar composición ORP.

No crear CSS de layout específico si Grid/Card ya lo resuelven.

==================================================
48. NO CONTACT CARD TODAVÍA
==================================================

NO implementar OrpContactCard en esta fase.

Pero puede mostrarse conceptualmente un mapa dentro de OrpCard para demostrar composición.

El ContactCard se implementará DESPUÉS.

==================================================
49. TESTS
==================================================

Usar infraestructura de tests existente.

OrpMap:

- render
- initializes Leaflet
- destroys map
- center
- zoom
- reactive updates
- multiple instances
- slot rendering
- relevant events

OrpMapMarker:

- requires map context appropriately
- creates marker
- position update
- cleanup
- multiple markers
- relevant events

No introducir testing framework nuevo.

==================================================
50. TEST ENVIRONMENT
==================================================

Leaflet depende del DOM.

Si jsdom requiere mocks específicos:

mantenerlos mínimos.

No crear tests falsos que solamente comprueben que Vue renderizó un div.

Debe verificarse comportamiento relevante cuando sea posible.

==================================================
51. BROWSER QA
==================================================

Esta fase requiere browser QA real.

Probar:

320
375
390
430
768
1200
1440

Verificar visualmente:

- tiles
- marker icons
- attribution
- controls
- clipping
- radius
- resizing
- multiple maps
- multiple markers
- page scroll
- map interaction

==================================================
52. NETWORK QA
==================================================

Confirmar en browser:

- tiles cargan
- no hay 404 de marker icons
- no hay errores Leaflet
- no hay requests a Google Maps
- attribution visible

==================================================
53. CONSOLE QA
==================================================

No deben existir:

Leaflet container is already initialized

Map container not found

marker icon 404

ResizeObserver loops

Vue warnings

memory/lifecycle warnings

==================================================
54. BUILD
==================================================

Ejecutar:

npm run build

y tests ORP.

Debe pasar.

==================================================
55. DOCUMENTACIÓN
==================================================

Documentar:

OrpMap

PURPOSE:
Generic Leaflet map container for ORP UI.

DEFAULT ENGINE:
Leaflet

DEFAULT MAP DATA/TILES:
OpenStreetMap configuration used by the implementation.

USE FOR:

- locations
- directories
- properties
- contact interfaces
- events
- geographic visualization

DO NOT USE FOR:

- geocoding
- routing
- business-specific location logic

==================================================
56. DOCUMENTAR OrpMapMarker
==================================================

PURPOSE:

Represent a generic geographic marker inside OrpMap.

USE:

<OrpMap>
    <OrpMapMarker :position="..." />
</OrpMap>

No domain assumptions.

==================================================
57. DOCUMENTAR RESPONSABILIDADES
==================================================

Debe quedar claro:

Leaflet
→ map engine

OpenStreetMap
→ map data / default tile configuration

ORP
→ Vue integration + UI contract

Application
→ business data and geographic meaning

==================================================
58. DOCUMENTAR ESCAPE HATCHES
==================================================

Si existe:

custom tile URL
ready event
Leaflet instance access

documentar como API avanzada.

No convertirla en API principal si no es necesaria.

==================================================
59. SECURITY / CONTENT
==================================================

No insertar HTML arbitrario proveniente de marker data.

Como Popup no existe todavía:

no necesitamos HTML injection.

Mantener Phase 1 simple.

==================================================
60. PERFORMANCE
==================================================

No optimizar prematuramente para miles de markers.

Phase 1 debe funcionar correctamente con cantidades pequeñas/moderadas.

Clustering pertenece a una fase futura si aparece necesidad real.

==================================================
61. PHASE 2 CANDIDATES
==================================================

Durante el audit documentar, SIN implementar:

- OrpMapPopup
- FitBounds
- custom marker system
- Circle
- Polyline
- Polygon
- GeoJSON
- clustering
- map controls
- geolocation
- map loading/error states

Clasificar:

NEEDED SOON
POSSIBLE
NO EVIDENCE

==================================================
62. NO GOOGLE MAPS
==================================================

No agregar código, dependencias, URLs o configuración de Google Maps.

La arquitectura actual usa:

Leaflet + OpenStreetMap.

==================================================
63. NO BUSINESS LOGIC
==================================================

No modificar:

Controllers
Models
Routes
Database
API
Inertia payloads
location business logic

==================================================
64. NO ACERCA MIGRATION
==================================================

NO modificar todavía:

SectionLocations
SectionProperties
vCards
Contact sections
Restaurant sections

Solo audit read-only.

==================================================
65. CRITERIO DE ÉXITO — GENERICIDAD
==================================================

El mismo OrpMap debe poder representar:

una oficina
una propiedad
un restaurante
un evento
una sucursal

sin conocer ninguno de esos conceptos.

==================================================
66. CRITERIO DE ÉXITO — COMPONENT MODEL
==================================================

Debe ser posible:

<OrpMap>
    <OrpMapMarker />
    <OrpMapMarker />
</OrpMap>

sin:

IDs manuales
Leaflet setup en el consumidor
manual cleanup
DOM queries

==================================================
67. CRITERIO DE ÉXITO — LIFECYCLE
==================================================

Montar/desmontar repetidamente OrpMap no debe generar:

duplicate initialization
listeners huérfanos
markers huérfanos
ResizeObservers activos
errores en consola

==================================================
68. CRITERIO DE ÉXITO — ORP
==================================================

El consumidor debe pensar:

"Necesito un mapa ORP."

No:

"Necesito inicializar Leaflet manualmente, encontrar un div, importar CSS, configurar tiles, destruir el mapa y corregir marker icons."

ORP debe encapsular esa infraestructura repetitiva.

==================================================
69. REPORTE FINAL
==================================================

Entregar:

# ORP MAP COMPONENTS — IMPLEMENTATION REPORT

## Existing Map Audit

Leaflet installed:
YES / NO

Existing Leaflet usage:

Existing OSM usage:

Existing map components:

Existing marker icon solution:

Existing CSS import strategy:

## Architecture

OrpMap layer:
Component

OrpMapMarker layer:
Component

Map engine:
Leaflet

Default map provider/data:
OpenStreetMap

## Files Created

List.

## Files Modified

List.

## OrpMap API

Props:
Slots:
Events:
Expose:
Defaults:

## OrpMapMarker API

Props:
Slots:
Events:
Expose:

## Context Architecture

provide/inject:
YES / NO

Reason:

## Lifecycle

Map initialization:
Map cleanup:
Marker initialization:
Marker cleanup:
Resize cleanup:

## Reactive Behavior

Center:
PASS / FAIL / NOT IMPLEMENTED

Zoom:
PASS / FAIL / NOT IMPLEMENTED

Marker position:
PASS / FAIL

## Resize Strategy

Strategy:

ResizeObserver:
YES / NO

invalidateSize:
YES / NO

## Multiple Instances

Multiple maps:
PASS / FAIL

Multiple markers:
PASS / FAIL

## Leaflet Assets

CSS:
PASS / FAIL

Marker icon:
PASS / FAIL

Retina marker:
PASS / FAIL

Shadow:
PASS / FAIL

## OpenStreetMap

Tiles:
PASS / FAIL

Attribution:
PASS / FAIL

Google Maps requests:
NONE / FOUND

## Accessibility

Map label:
Keyboard:
Controls:
Focus:
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

## Browser QA

Tiles:
Markers:
Controls:
Resize:
Multiple maps:
Multiple markers:
Console:

## Tests

OrpMap:
PASS / FAIL

OrpMapMarker:
PASS / FAIL

## Build

npm run build:

PASS / FAIL

## Dependencies Added

NONE

or list.

## Phase 2 Candidates

Candidate:
Evidence:
Priority:

## Acerca Changes

NONE

## Business Logic Changes

NONE

## Final Status

READY FOR HUMAN REVIEW

or

NEEDS MORE WORK

STOP.

==================================================
FINAL INSTRUCTION
==================================================

Implementa únicamente Phase 1 del sistema de mapas ORP:

1. Auditar la integración Leaflet existente.
2. Crear OrpMap.
3. Crear OrpMapMarker.
4. Usar Leaflet directamente.
5. Usar OpenStreetMap como configuración cartográfica por defecto.
6. Resolver correctamente lifecycle, cleanup, resize y marker assets.
7. Permitir múltiples mapas y múltiples markers.
8. Integrar ambos componentes al ORP Playground.
9. Probar reactividad básica.
10. Crear tests.
11. Ejecutar browser QA real.
12. Ejecutar npm run build.
13. Documentar candidatos para Phase 2 sin implementarlos.
14. NO implementar OrpContactCard todavía.
15. NO migrar SectionLocations ni otras partes de Acerca.
16. NO agregar Google Maps.
17. NO convertir ORP en un wrapper completo de Leaflet.
18. STOP después de OrpMap + OrpMapMarker.

