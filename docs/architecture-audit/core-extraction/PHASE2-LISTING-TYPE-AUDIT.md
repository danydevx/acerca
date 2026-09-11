# PHASE 2 — LISTING TYPE AUDIT

**Date:** 2026-09-10
**Goal:** Audit all ListingType usages, classify them, and determine the future of this enum

---

## LISTINGTYPE DEFINITION (Current)

Location: `Modules/Listings/app/Enums/ListingType.php`

Contains 18 values grouped into:
- **Professional Services:** BARBER_SHOP, BEAUTY_SALON, DENTIST, MEDICAL_CLINIC, DOCTOR, SPA, VETERINARIAN, PHYSIOTHERAPIST, PSYCHOLOGIST, NUTRITIONIST, TATTOO_STUDIO
- **Events:** WEDDING, BIRTHDAY, BABY_SHOWER, CORPORATE, GRADUATION
- **Generic:** GENERIC

---

## USAGE ANALYSIS

### TYPE: VALIDATION
| File | Line | Usage |
|------|------|-------|
| app/Http/Controllers/Wizard/BusinessController.php | 47 | `array_column(ListingType::cases(), 'value')` to validate input |
| app/Http/Controllers/Member/BusinessController.php | 68 | `array_column(ListingType::cases(), 'value')` to validate input |
| app/Http/Controllers/Member/BusinessController.php | 72 | `Rule::in($validTypes)` validation rule |
| resources/js/Pages/Member/Listings/Create.vue | 31 | `<option v-for="type in listingTypes">` dropdown population |

### TYPE: DISPLAY
| File | Line | Usage |
|------|------|-------|
| Modules/Listings/Enums/ListingType.php | 25 | `label()` method - returns human-readable name |
| Modules/Listings/Enums/ListingType.php | 48 | `icon()` method - returns Bootstrap icon class |
| Modules/Listings/Enums/ListingType.php | 71 | `color()` method - returns hex color |
| app/Http/Controllers/Public/DirectoryController.php | 31 | `ListingType::cases()` to populate type filter |
| app/Http/Controllers/Public/DirectoryController.php | 128 | `ListingType::cases()` to populate type filter |
| app/Http/Controllers/Wizard/BusinessController.php | 20 | `ListingType::cases()` to populate wizard dropdown |
| app/Http/Controllers/Member/BusinessController.php | 46 | Maps `ListingType::cases()` to `{value, label}` for frontend |
| resources/js/Pages/Member/Listings/Create.vue | 29 | `v-for="type in listingTypes"` dropdown options |

### TYPE: THEME_MAPPING (PROBLEMATIC)
| File | Line | Usage |
|------|------|-------|
| app/Models/MinisiteTheme.php | 36-54 | `getByListingType()` hardcoded mapping of type → theme slug |

### TYPE: BUSINESS_LOGIC
| File | Line | Usage |
|------|------|-------|
| Modules/Listings/app/Models/Listing.php | 75 | `wasChanged('listing_type')` to detect type changes |
| Modules/Listings/app/Models/Listing.php | 84 | `assignMinisiteTheme()` triggered on type change |

### TYPE: MODULE_ENABLEMENT
| File | Line | Usage |
|------|------|-------|
| Modules/Listings/app/Models/Listing.php | 59 | `Casts: 'listing_type' => ListingType::class` |

### TYPE: SEEDING
| File | Line | Usage |
|------|------|-------|
| Modules/ListingAiChatbot/database/seeders/PresetSeeder.php | 17,52,87,122,156 | Sets `listing_type = null` for global presets |

### TYPE: FILTERING
| File | Line | Usage |
|------|------|-------|
| Modules/ListingAiChatbot/app/Http/Controllers/Admin/ChatbotPresetController.php | 26-27 | Filter presets by `listing_type` |
| Modules/ListingAiChatbot/app/Http/Controllers/Admin/ChatbotPresetController.php | 36-39 | Get distinct listing_types from listings for dropdown |
| Modules/ListingAiChatbot/app/Models/ChatbotPreset.php | 92-97 | `getForListingType()` scope |

### TYPE: ROUTING
| File | Line | Usage |
|------|------|-------|
| app/Http/Controllers/Public/DirectoryController.php | 96 | `where('listing_type', $type)` URL filter |

### TYPE: API_RESPONSE
| File | Line | Usage |
|------|------|-------|
| app/Http/Resources/Api/V1/BusinessListResource.php | 16 | Returns `listing_type->value ?? listing_type` |
| app/Http/Resources/Api/V1/BusinessResource.php | 16 | Returns `listing_type->value ?? listing_type` |
| app/Http/Controllers/Public/BusinessController.php | 205 | Returns `listing_type->value ?? listing_type` |

### TYPE: TEST_DATA
| File | Line | Usage |
|------|------|-------|
| tests/Feature/ListingIsolationTest.php | 34,43 | Sets `'listing_type' => 'generic'` |
| tests/Feature/Member/GalleryBulkUploadTest.php | 29,54 | Sets `'listing_type' => 'generic'` |

---

## PROBLEMATIC USAGES

### 1. MinisiteTheme::getByListingType() — THEME_MAPPING
**File:** `app/Models/MinisiteTheme.php:34-58`
**Problem:** Theme model knows about 15+ vertical business types
**Recommendation:** Remove this method. Theme assignment should be:
- Explicit (user selects), OR
- Handled by product-specific config

### 2. Listing::assignMinisiteTheme() — BUSINESS_LOGIC
**File:** `Modules/Listings/app/Models/Listing.php:81-89`
**Problem:** Listing model automatically assigns theme based on type
**Recommendation:** Remove automatic assignment. Let user choose or product handle it.

### 3. Listing::boot() with listing_type change detection — BUSINESS_LOGIC
**File:** `Modules/Listings/app/Models/Listing.php:74-78`
**Problem:** Type change triggers theme reassignment
**Recommendation:** Remove this observer behavior

---

## NON-PROBLEMATIC USAGES

These are acceptable:
- **VALIDATION** — Ensuring user picks a valid type ✓
- **DISPLAY** — Showing type label/icon/color to users ✓
- **FILTERING** — Filtering chatbots/presets by type ✓
- **SEEDING** — Seeding global presets with null type ✓
- **API_RESPONSE** — Returning type in API responses ✓
- **TEST_DATA** — Using 'generic' for tests ✓

---

## RECOMMENDATION: THREE-TIER TYPE SYSTEM

### Tier 1: CORE TYPE (stored in Listing.listing_type as string)
Simple, extensible, no vertical knowledge in Core:
```php
// Core: Modules/Listings/app/Enums/ListingType.php
enum ListingType: string
{
    case GENERIC = 'generic';
    case BUSINESS = 'business';
    case EVENT = 'event';
}
```

### Tier 2: PRODUCT-SPECIFIC ENUMS (stored in module tables or config)
Each product defines its own valid types:
```php
// restaurant-saas config
return [
    'restaurant' => 'Restaurant',
    'bar' => 'Bar',
    'cafe' => 'Café',
];

// invitations-saas config
return [
    'wedding' => 'Wedding',
    'birthday' => 'Birthday',
    'baby_shower' => 'Baby Shower',
];

// realestate-saas config
return [
    'agency' => 'Agency',
    'broker' => 'Broker',
    'developer' => 'Developer',
];
```

### Tier 3: MODULE-SPECIFIC TYPES
Modules can define their own types independent of Listing:
```php
// ChatbotPreset.listing_type stores product-specific string
// Not coupled to the Core enum
```

---

## IMPLEMENTATION PATH

1. **Phase 2a:** Create new `GenericListingType` enum with GENERIC, BUSINESS, EVENT
2. **Phase 2b:** Update Listing model to use string cast (not enum) for listing_type
3. **Phase 2c:** Remove `getByListingType()` from MinisiteTheme
4. **Phase 2d:** Remove `assignMinisiteTheme()` from Listing boot
5. **Phase 2e:** Create product-specific type configuration files
6. **Phase 2f:** Migrate existing data (optional, for backwards compatibility)

---

## BACKWARDS COMPATIBILITY STRATEGY

The `listing_type` column stores a string. We can:
1. Keep `ListingType` enum with all current values for validation
2. But remove the hardcoded coupling in MinisiteTheme
3. Products can add their own type validation via module-specific logic

This way existing listings with 'wedding', 'barber_shop' etc keep working.
New products define their own type sets without polluting Core.
