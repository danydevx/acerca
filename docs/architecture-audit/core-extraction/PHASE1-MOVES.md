# FASE 1 - Módulos Verticales Movidos

## Resumen de Cambios

### Policies Movidas (7)

| Original | Nuevo | Módulo |
|----------|-------|--------|
| app/Policies/PropertyPolicy.php | Modules/Properties/Policies/PropertyPolicy.php | Properties |
| app/Policies/PropertyTypePolicy.php | Modules/Properties/Policies/PropertyTypePolicy.php | Properties |
| app/Policies/VCardPolicy.php | Modules/VCards/Policies/VCardPolicy.php | VCards |
| app/Policies/VCardTeamPolicy.php | Modules/VCards/Policies/VCardTeamPolicy.php | VCards |
| app/Policies/VCardSeoSettingPolicy.php | Modules/VCards/Policies/VCardSeoSettingPolicy.php | VCards |
| app/Policies/VCardPackagePolicy.php | Modules/VCards/Policies/VCardPackagePolicy.php | VCards |
| app/Policies/AnalyticsSettingPolicy.php | Modules/Analytics/Policies/AnalyticsSettingPolicy.php | Analytics |

### Services Movidos (6)

| Original | Nuevo | Módulo |
|----------|-------|--------|
| app/Services/Properties/PropertyService.php | Modules/Properties/Services/PropertyService.php | Properties |
| app/Services/Properties/PropertyValueService.php | Modules/Properties/Services/PropertyValueService.php | Properties |
| app/Services/Properties/PropertyImageService.php | Modules/Properties/Services/PropertyImageService.php | Properties |
| app/Services/Properties/PropertyLimitService.php | Modules/Properties/Services/PropertyLimitService.php | Properties |
| app/Services/Properties/PropertyFormSchemaService.php | Modules/Properties/Services/PropertyFormSchemaService.php | Properties |
| app/Services/Properties/GeneralFieldService.php | Modules/Properties/Services/GeneralFieldService.php | Properties |

### Controllers RestaurantMenu Movidos (9)

| Original | Nuevo |
|----------|-------|
| app/Http/Controllers/Public/MenuController.php | Modules/ListingRestaurantMenu/.../Public/MenuController.php |
| app/Http/Controllers/Admin/MenuCategoryController.php | Modules/ListingRestaurantMenu/.../Admin/MenuCategoryController.php |
| app/Http/Controllers/Admin/MenuProductController.php | Modules/ListingRestaurantMenu/.../Admin/MenuProductController.php |
| app/Http/Controllers/Admin/MenuProductImageController.php | Modules/ListingRestaurantMenu/.../Admin/MenuProductImageController.php |
| app/Http/Controllers/Admin/MenuProductVariantController.php | Modules/ListingRestaurantMenu/.../Admin/MenuProductVariantController.php |
| app/Http/Controllers/Member/MenuCategoryController.php | Modules/ListingRestaurantMenu/.../Member/MenuCategoryController.php |
| app/Http/Controllers/Member/MenuProductController.php | Modules/ListingRestaurantMenu/.../Member/MenuProductController.php |
| app/Http/Controllers/Member/MenuProductImageController.php | Modules/ListingRestaurantMenu/.../Member/MenuProductImageController.php |
| app/Http/Controllers/Member/MenuProductVariantController.php | Modules/ListingRestaurantMenu/.../Member/MenuProductVariantController.php |

### Requests Movidos (2)

| Original | Nuevo |
|----------|-------|
| app/Http/Requests/Property/StorePropertyRequest.php | Modules/Properties/Http/Requests/StorePropertyRequest.php |
| app/Http/Requests/Property/UpdatePropertyRequest.php | Modules/Properties/Http/Requests/UpdatePropertyRequest.php |

### Providers Modificados

| Provider | Cambio |
|----------|--------|
| AppServiceProvider | Removed Gate::policy registrations for Properties, VCards, Analytics |
| AppServiceProvider | Removed PropertyTypeObserver registration |
| AppServiceProvider | Removed AssignLockedSections command |
| PropertiesServiceProvider | Added registerPolicies() method |
| VCardsServiceProvider | Added registerPolicies() method |
| AnalyticsServiceProvider | Added registerPolicies() method |

### Routes Actualizadas
- routes/web.php: imports de Menu*Controllers ahora apuntan a Modules/ListingRestaurantMenu/

### Archivos Eliminados

- app/Policies/PropertyPolicy.php
- app/Policies/PropertyTypePolicy.php
- app/Policies/VCardPolicy.php
- app/Policies/VCardTeamPolicy.php
- app/Policies/VCardSeoSettingPolicy.php
- app/Policies/VCardPackagePolicy.php
- app/Policies/AnalyticsSettingPolicy.php
- app/Services/Properties/ (directorio completo)
- app/Http/Requests/Property/ (directorio completo)
- Controllers RestaurantMenu en app/ (9 archivos)

## Dependencias Core → RestaurantMenu Restantes (Justificadas)

| Archivo | Razón |
|---------|-------|
| BusinessController.php | Muestra info de menú en página pública del negocio |
| DashboardController.php | Stats de productos de menú en dashboard member |
| ApiExplorerController.php | Herramienta admin - KEEP_IN_CORE |

## Validación

```
Laravel Boot: PASS
Routes: PASS
Tests: 11 passed
```
