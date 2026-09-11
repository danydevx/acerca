# PHASE3D72-GLOBAL-INVENTORY

## Root Controllers Classification

### MODULE_OWNED Root Controllers: 0

All member CRUD controllers for the 6 target domains have been moved to their respective modules.

### Remaining Root Controllers (by classification)

#### CORE (Platform features)
- AccountController
- ActivityController
- ApiKeyController
- BillingController
- CheckoutController
- DashboardController
- HelpArticleController
- IntegrationController
- InvoiceController
- ListingModuleController
- NotificationController
- NotificationPreferenceController
- OnboardingController
- PasswordController
- PaymentController
- PlanSelectionController
- PreferenceController
- SessionController
- SupportTicketController
- SystemAnnouncementController
- UserProfileController
- WebhookController

#### PRODUCT_COMPOSITION
- BusinessController (Member/Member layer)
- PublicBusinessController
- DirectoryController
- BookingWidgetController
- PromotionVerificationController

#### LEGACY_AGGREGATOR
- ListingContentController (manages products, services, galleries, locations, reviews, promotions, faqs, appointments via admin routes)

#### SYSTEM_GEOGRAPHY
- LocationController (admin/locations/* - countries, states, municipalities)

### Root Routes Classification

#### MODULE_OWNED (for target 6 domains): 0

All member CRUD routes for Reviews, Promotions, Faqs, Clients, Gallery, Appointments point to `Modules\*` controllers.

#### LEGACY_AGGREGATOR routes in web.php

These are admin routes via ListingContentController - NOT member routes:

```
admin/listings/{listing}/reviews/*
admin/listings/{listing}/promotions/*
admin/listings/{listing}/faqs/*
admin/listings/{listing}/galleries/*
admin/listings/{listing}/appointments/*
admin/listings/{listing}/locations/*
```

#### PRODUCT_COMPOSITION routes

```
b/{slug}/gallery → PublicBusinessController
b/{slug}/verify/{promotionId}/{couponCode} → PromotionVerificationController
negocios/{slug}/appointment → DirectoryController
```

#### SYSTEM_GEOGRAPHY routes

All `admin/locations/countries|states|municipalities` and `api/v1/location-data/*` routes belong to `Modules\Locations` (CORE_SYSTEM_DATA).
