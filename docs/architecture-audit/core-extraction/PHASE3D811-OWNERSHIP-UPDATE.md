# PHASE 3D.8.1.1 — OWNERSHIP UPDATE

## MODULE_OWNED Root Controller Inventory

### Controllers Still in Root (candidates for FASE 3D.8.2)

| Controller | Routes | Owner Module | Status |
|------------|--------|-------------|--------|
| Admin\ListingLeadsController | 16 | ListingLeads | NOT MIGRATED |
| Admin\ListingPromotionController | 16 | ListingPromotions | NOT MIGRATED |
| Admin\ListingReviewController | 15 | ListingReviews | NOT MIGRATED |
| Admin\ListingSocialNetworkController | 4 | ListingSocialMedia | NOT MIGRATED |
| Admin\ListingHeroController | 4 | ListingMinisite (hero sections) | NOT MIGRATED |
| Admin\ListingContactFormController | 15 | ListingContactForm | NOT MIGRATED |
| Admin\ListingAiChatbotController | 57 | ListingAiChatbot | NOT MIGRATED |

### Controllers Classified as PLATFORM (NOT MODULE_OWNED)

| Controller | Routes | Reason |
|------------|--------|--------|
| Admin\ModuleDefinitionController | 6 | Manages platform module definitions catalog |
| Admin\ModuleSettingsController | 2 | Manages global settings for all modules |

### Controllers Migrated in Previous Sessions (FASE 3D.7.x)

- ListingMinisite → MinisiteThemeController (FASE 3D.8.1)
- ListingLocations → routes migrated (FASE 3D.7.3)
- ListingReviews → shadow routes cleaned (FASE 3D.7.2)
- ListingPromotions → shadow routes cleaned (FASE 3D.7.2)
- Gallery → shadow routes cleaned (FASE 3D.7.2)
- Faqs → shadow routes cleaned (FASE 3D.7.2)
- Clients → shadow routes cleaned (FASE 3D.7.2)

## Updated MODULE_OWNED Root Debt

**Before FASE 3D.8.2**: 7 controllers, ~127 routes

| Controller | Routes |
|------------|--------|
| ListingLeadsController | 16 |
| ListingPromotionController | 16 |
| ListingReviewController | 15 |
| ListingContactFormController | 15 |
| ListingAiChatbotController | 57 |
| ListingHeroController | 4 |
| ListingSocialNetworkController | 4 |

## Corrected Classification

The following were INCORRECTLY classified as MODULE_OWNED in FASE 3D.8:

- ModuleDefinitionController → **PLATFORM** (6 routes)
- ModuleSettingsController → **PLATFORM** (2 routes)

These should be EXCLUDED from MODULE_OWNED count.
