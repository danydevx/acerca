# PHASE 3D.8.1.1 — MODULE CONFIG CONTROLLERS

## Classification Results

### 1. ModuleDefinitionController

**File**: `app/Http/Controllers/Admin/ModuleDefinitionController.php`

**Routes** (6):
```
GET|HEAD     admin/business-module-definitions
POST         admin/business-module-definitions
GET|HEAD     admin/business-module-definitions/create
PUT          admin/business-module-definitions/{definition}
DELETE       admin/business-module-definitions/{definition}
GET|HEAD     admin/business-module-definitions/{definition}/edit
```

**Model**: `App\Models\ModuleDefinition` (Core model in `app/Models`)

**Responsibility**: Manages the catalog of available modules on the platform
- Create new module definitions
- Edit module metadata (key, name, description, icon, image)
- Toggle active/inactive
- Configure settings URL and menu visibility
- Define premium status

**Dependencies**:
- `App\Models\ModuleDefinition`
- `Illuminate\Support\Facades\Storage`
- `Inertia\Inertia`

**Classification**: **PLATFORM**

**Rationale**:
- Manages platform-wide module definitions
- NOT specific to any single business module
- `ModuleDefinition` is a Core model (not module-owned)
- Controller name contains "Module" but this refers to platform modules, not business modules

**Action**: **KEEP IN app/Http/Controllers/Admin**

---

### 2. ModuleSettingsController

**File**: `app/Http/Controllers/Admin/ModuleSettingsController.php`

**Routes** (2):
```
GET|HEAD     admin/modules/{moduleKey}/settings
PUT          admin/modules/{moduleKey}/settings
```

**Model**: `App\Models\ModuleDefinition` (Core model)

**Responsibility**: Manages global settings for all business modules
- Handles settings for: features, gallery, services, products, appointments, leads, reviews, promotions, properties
- Dynamic schema validation per module type
- Updates `ModuleDefinition.settings` JSON field

**Key Methods**:
- `show()` — Display settings form for a module
- `update()` — Save settings with dynamic validation
- `getSchemaForModule()` — Returns validation schema per module type
- `getDefaultSettings()` — Returns default values per module type

**Classification**: **PLATFORM**

**Rationale**:
- Handles settings for MULTIPLE modules (features, gallery, services, products, etc.)
- NOT specific to one module — works with all module types
- Reads from `ModuleDefinition` (Core model)
- Updates platform-level configuration

**Action**: **KEEP IN app/Http/Controllers/Admin**

---

## Summary

| Controller | Routes | Classification | Action |
|------------|--------|---------------|--------|
| ModuleDefinitionController | 6 | PLATFORM | KEEP |
| ModuleSettingsController | 2 | PLATFORM | KEEP |

## Correction to FASE 3D.8 Inventory

FASE 3D.8 incorrectly classified these as potentially MODULE_OWNED. They are actually **PLATFORM** controllers.

**Do NOT** create `Modules/ModuleManagement` or similar just to move these.
