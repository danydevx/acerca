# FASE 1 - Auditoría Final de Dependencias

## DEPENDENCIAS CORE → PROPERTIES
**Antes: 16**
**Después: 4**

| Tipo | Archivo | Clasificación |
|------|---------|--------------|
| Controller | ApiExplorerController | KEEP_IN_CORE (Admin tool) |
| Controller | Member/DashboardController | REQUIRES_DECISION |
| Request | StorePropertyRequest | MOVIDO |
| Request | UpdatePropertyRequest | MOVIDO |

**Eliminadas:**
- `Listing::properties()` relación removida

## DEPENDENCIAS CORE → VCARDS
**Antes: 9**
**Después: 2**

| Tipo | Archivo | Clasificación |
|------|---------|--------------|
| Controller | ApiExplorerController | KEEP_IN_CORE (Admin tool) |

**Eliminadas:**
- 5 policies movidas a Modules/VCards/Policies/
- Gate::policy registrations removidas de AppServiceProvider

## DEPENDENCIAS CORE → ANALYTICS
**Antes: 3**
**Después: 1**

| Tipo | Archivo | Clasificación |
|------|---------|--------------|
| Controller | ApiExplorerController | KEEP_IN_CORE (Admin tool) |

**Eliminadas:**
- `Listing::analyticsSetting()` relación removida
- AnalyticsSettingPolicy movido a Modules/Analytics/Policies/
- Gate::policy registration removida de AppServiceProvider

## DEPENDENCIAS CORE → RESTAURANT MENU
**Antes: 13**
**Después: 13** (sin cambios)

| Tipo | Archivo | Clasificación |
|------|---------|--------------|
| Controllers | MenuCategory/Product controllers | MOVE_TO_MODULE (pendiente) |

## ARCHIVOS MOVIDOS
- 7 Policies: app/Policies/ → Modules/*/Policies/
- 6 Services: app/Services/Properties/ → Modules/Properties/Services/
- 2 Requests: app/Http/Requests/Property/ → Modules/Properties/Http/Requests/

## POLICIES MOVIDAS
- PropertyPolicy, PropertyTypePolicy → Modules/Properties/Policies/
- VCardPolicy, VCardTeamPolicy, VCardSeoSettingPolicy, VCardPackagePolicy → Modules/VCards/Policies/
- AnalyticsSettingPolicy → Modules/Analytics/Policies/

## SERVICES MOVIDOS
- PropertyService, PropertyValueService, PropertyImageService, PropertyLimitService, PropertyFormSchemaService, GeneralFieldService → Modules/Properties/Services/

## PROVIDERS MODIFICADOS
- AppServiceProvider: removidas registrations de módulos verticales
- PropertiesServiceProvider: añadida registerPolicies()
- VCardsServiceProvider: añadida registerPolicies()
- AnalyticsServiceProvider: añadida registerPolicies()

## LISTING RELATIONS ELIMINADAS
- `properties()` - HasMany hacia Property
- `analyticsSetting()` - HasOne hacia AnalyticsSetting

## LARAVEL BOOT: PASS
## TESTS: 11 passed (tests de aislamiento OK)
## BUILD: PASS

## CORE PUEDE ARRANCAR SIN VERTICALES: SÍ

## ESTADO: PARTIAL - FASE 1 CONTINÚA

**Pendiente:**
- Controllers de RestaurantMenu en app/Http/Controllers/*/Menu* → Modules/ListingRestaurantMenu/
- Requests de Property en el módulo
- Verificar que no haya más errores 500 en páginas de member
