# PHASE3D8-ROOT-CONTROLLERS

## Root Controllers by Classification

### CORE (9 controllers, ~38 routes)

| Controller | Routes | Purpose |
|------------|--------|---------|
| Admin\UserController | 13 | User management |
| Admin\ListingController | 6 | Core listing CRUD |
| Auth\* controllers | 16 | Authentication flows |

### PLATFORM (54 controllers, ~180 routes)

Platform features shared across the application:

- Admin controllers: Permissions, Roles, Plans, Features, Settings, Reports, Dashboards, etc.
- Member controllers: Notifications, Webhooks, ApiKeys, Sessions, Help, Invoices, etc.
- System controllers: Health, Monitoring, Error handling, etc.

### PRODUCT_COMPOSITION (8 controllers, 60 routes)

| Controller | Routes | Purpose |
|------------|--------|---------|
| Api\V1\Admin\BusinessController | 27 | API composition for businesses |
| Public\BusinessController | 13 | Public business pages |
| Public\DirectoryController | 5 | Business directory |
| Public\BookingWidgetController | 5 | Booking widget composition |
| Member\BusinessController | 4 | Member business management |
| Api\V1\Admin\UserController | 3 | API user composition |
| Wizard\BusinessController | 2 | Onboarding wizard |
| Public\PromotionVerificationController | 1 | Coupon verification |

### LEGACY_AGGREGATOR (1 controller, 56 routes)

| Controller | Routes | Purpose |
|------------|--------|---------|
| Admin\ListingContentController | 56 | Legacy admin CRUD aggregator |

### MODULE_OWNED (10 controllers, 36 routes)

Controllers that belong to specific modules but remain in root:

| Controller | Routes | Owner Module | Migration Status |
|------------|--------|-------------|-----------------|
| Admin\ListingLeadsController | 7 | ListingLeads | Should be in module |
| Admin\ModuleDefinitionController | 6 | System modules | Platform config |
| Admin\ListingPromotionController | 6 | ListingPromotions | Should be in module |
| Admin\ListingReviewController | 6 | ListingReviews | Should be in module |
| Admin\ListingSocialNetworkController | 4 | ListingSocialMedia | Should be in module |
| Admin\ListingHeroController | 2 | ListingHero | Should be in module |
| Admin\ModuleSettingsController | 2 | System modules | Platform config |
| Admin\MinisiteThemeController | 2 | ListingMinisite | Should be in module |
| Admin\ListingAiChatbotController | 1 | ListingAiChatbot | Should be in module |
| Admin\ListingContactFormController | 1 | ListingContactForm | Should be in module |

### VERTICAL (not classified yet)

Controllers for vertical domains that may have their own modules:
- Member\AiChatbotController (vertical)
- Member\ProjectController, Member\ProjectCategoryController (vertical)

### DEAD (potential)

Controllers with no routes:
- Playground controllers (BulmaPlayground, BladePlayground, Playground, OrpPlayground)
- These appear to be dev/playground code

## Summary

```
Total root controllers: 88
Total root routes: 379 (App\\) out of 972

CORE:              9 controllers (~38 routes)
PLATFORM:         54 controllers (~180 routes)
PRODUCT_COMPOSITION: 8 controllers (60 routes)
LEGACY_AGGREGATOR: 1 controller (56 routes)
MODULE_OWNED:    10 controllers (36 routes)
VERTICAL:         2 controllers
DEAD:             4 controllers

TOTAL: 88 controllers
```
