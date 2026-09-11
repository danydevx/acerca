# FASE 1 - Auditoría de Dependencias Core → Módulos Verticales

## Módulos Objetivo
- Properties
- VCards
- Analytics
- ListingRestaurantMenu (Restaurant)

## Resumen de Dependencias Detectadas

### PROPERTIES (Core → Properties)
| Tipo | Archivo | Línea | Clasificación |
|------|---------|-------|--------------|
| Policy | app/Policies/PropertyPolicy.php | - | MOVE_TO_MODULE |
| Policy | app/Policies/PropertyTypePolicy.php | - | MOVE_TO_MODULE |
| Service | app/Services/Properties/PropertyService.php | - | MOVE_TO_MODULE |
| Service | app/Services/Properties/PropertyLimitService.php | - | MOVE_TO_MODULE |
| Service | app/Services/Properties/PropertyValueService.php | - | MOVE_TO_MODULE |
| Service | app/Services/Properties/PropertyImageService.php | - | MOVE_TO_MODULE |
| Service | app/Services/Properties/GeneralFieldService.php | - | MOVE_TO_MODULE |
| Service | app/Services/Properties/PropertyFormSchemaService.php | - | MOVE_TO_MODULE |
| Request | app/Http/Requests/Property/StorePropertyRequest.php | - | MOVE_TO_MODULE |
| Request | app/Http/Requests/Property/UpdatePropertyRequest.php | - | MOVE_TO_MODULE |
| AppServiceProvider | Gate::policy(Property::class) | 161 | MOVE_TO_MODULE |
| AppServiceProvider | Gate::policy(PropertyType::class) | 162 | MOVE_TO_MODULE |
| AppServiceProvider | PropertyTypeObserver | 64-65 | MOVE_TO_MODULE |
| AppServiceProvider | AssignLockedSections command | 102 | MOVE_TO_MODULE |
| Listing | $this->hasMany(Property::class) | 251-254 | REMOVE_FROM_LISTING |
| Controller | Member/DashboardController.php | 21 | REQUIRES_DECISION |

**Total: 16 referencias**

### VCARDS (Core → VCards)
| Tipo | Archivo | Línea | Clasificación |
|------|---------|-------|--------------|
| Policy | app/Policies/VCardPolicy.php | - | MOVE_TO_MODULE |
| Policy | app/Policies/VCardTeamPolicy.php | - | MOVE_TO_MODULE |
| Policy | app/Policies/VCardSeoSettingPolicy.php | - | MOVE_TO_MODULE |
| Policy | app/Policies/VCardPackagePolicy.php | - | MOVE_TO_MODULE |
| AppServiceProvider | Gate::policy(VCard::class) | 167 | MOVE_TO_MODULE |
| AppServiceProvider | Gate::policy(VCardTeam::class) | 168 | MOVE_TO_MODULE |
| AppServiceProvider | Gate::policy(VCardSeoSetting::class) | 169 | MOVE_TO_MODULE |
| AppServiceProvider | Gate::policy(VCardPackage::class) | 170 | MOVE_TO_MODULE |
| ApiExplorer | ApiExplorerController.php | 34 | KEEP_IN_CORE (Admin tool) |

**Total: 9 referencias**

### ANALYTICS (Core → Analytics)
| Tipo | Archivo | Línea | Clasificación |
|------|---------|-------|--------------|
| Policy | app/Policies/AnalyticsSettingPolicy.php | - | MOVE_TO_MODULE |
| AppServiceProvider | Gate::policy(AnalyticsSetting::class) | 124 | MOVE_TO_MODULE |
| Listing | $this->hasOne(AnalyticsSetting::class) | 261-264 | REMOVE_FROM_LISTING |

**Total: 3 referencias**

### RESTAURANT MENU (Core → ListingRestaurantMenu)
| Tipo | Archivo | Línea | Clasificación |
|------|---------|-------|--------------|
| Controller | Public/MenuController.php | - | MOVE_TO_MODULE |
| Controller | Admin/MenuCategoryController.php | - | MOVE_TO_MODULE |
| Controller | Admin/MenuProductController.php | - | MOVE_TO_MODULE |
| Controller | Admin/MenuProductImageController.php | - | MOVE_TO_MODULE |
| Controller | Admin/MenuProductVariantController.php | - | MOVE_TO_MODULE |
| Controller | Member/MenuCategoryController.php | - | MOVE_TO_MODULE |
| Controller | Member/MenuProductController.php | - | MOVE_TO_MODULE |
| Controller | Member/MenuProductImageController.php | - | MOVE_TO_MODULE |
| Controller | Member/MenuProductVariantController.php | - | MOVE_TO_MODULE |
| Controller | Member/DashboardController.php | 14 | REQUIRES_DECISION |
| ApiExplorer | ApiExplorerController.php | 28-29 | KEEP_IN_CORE (Admin tool) |
| Api/Business | Api/V1/Admin/BusinessController.php | 28-29 | REQUIRES_DECISION |
| Routes | web.php (use PropertyImageController) | 112 | MOVE_TO_MODULE |

**Total: 13 referencias**

## Totales
- PROPERTIES: 16
- VCARDS: 9
- ANALYTICS: 3
- RESTAURANT: 13
- **TOTAL: 41**

## listing.php Relaciones Detectadas
```php
// Vertical modules - REMOVE
$this->hasMany(\Modules\Properties\Models\Property::class, 'listing_id');  // línea 251-254
$this->hasOne(\Modules\Analytics\Models\AnalyticsSetting::class, 'listing_id');  // línea 261-264

// Módulos que son del Core Shared
$this->hasMany(ListingProduct::class, 'listing_id');  // ¿Shared o vertical?
$this->hasMany(ListingProductCategory::class, 'listing_id');  // ¿Shared o vertical?
```

## Decisions Required
1. ¿ListingProduct/ListingProductCategory es shared o vertical (Restaurant)?
2. ¿Los Controllers de Api/V1/Admin/BusinessController.php son Core o del módulo?
3. ¿Member/DashboardController.php debe mantener referencias a módulos verticales?
