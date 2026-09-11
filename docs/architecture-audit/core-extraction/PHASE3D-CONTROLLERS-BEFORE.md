# PHASE 3D — CONTROLLERS AUDIT (BEFORE)

## Total Controllers: 141

---

## CLASSIFICATION SUMMARY

| Classification | Count | Description |
|---------------|-------|-------------|
| **MODULE_OWNED** | ~85 | Controllers that belong to specific listing modules |
| **CORE** | ~35 | SaaS base controllers (auth, billing, users, admin) |
| **PRODUCT_COMPOSITION** | ~5 | Controllers that compose multiple modules |
| **REQUIRES_DECISION** | ~16 | Ambiguous - needs review |

---

## MODULE_OWNED CONTROLLERS (Proposed Target Modules)

### ListingServices
- `app/Http/Controllers/Member/ServiceController.php` (also `ServicesController.php`)
- `app/Http/Controllers/Member/ServiceCategoryController.php`
- `app/Http/Controllers/Admin/ListingServicesController.php`

### ListingProducts
- `app/Http/Controllers/Member/ProductController.php`
- `app/Http/Controllers/Member/ProductCategoryController.php`

### ListingReviews
- `app/Http/Controllers/Member/ReviewController.php`
- `app/Http/Controllers/Admin/ListingReviewController.php`

### ListingPromotions
- `app/Http/Controllers/Member/PromotionController.php`
- `app/Http/Controllers/Admin/ListingPromotionController.php`

### ListingFaqs
- `app/Http/Controllers/Member/FaqController.php`
- `app/Http/Controllers/Member/FaqCategoryController.php`

### ListingGallery
- `app/Http/Controllers/Member/GalleryController.php`
- `app/Http/Controllers/Member/GalleryGroupController.php`

### ListingHero
- `app/Http/Controllers/Member/HeroController.php`
- `app/Http/Controllers/Admin/ListingHeroController.php`

### ListingAbout
- `app/Http/Controllers/Member/AboutController.php`

### ListingSeo
- `app/Http/Controllers/Member/SeoController.php`

### ListingContactForm
- `app/Http/Controllers/Member/ContactFormController.php`
- `app/Http/Controllers/Admin/ListingContactFormController.php`

### ListingTeamMembers
- `app/Http/Controllers/Member/TeamMemberController.php`
- `app/Http/Controllers/Member/TeamMemberPositionController.php`

### ListingClients
- `app/Http/Controllers/Member/ClientController.php`

### ListingTasks
- `Modules/ListingTasks/app/Http/Controllers/Member/TaskController.php` (already in module!)

### ListingLeads
- `app/Http/Controllers/Member/LeadController.php`

### ListingAppointments
- `app/Http/Controllers/Member/AppointmentController.php`
- `app/Http/Controllers/Member/AvailabilityController.php`
- `app/Http/Controllers/Member/SlotController.php`
- `app/Http/Controllers/Admin/SlotController.php`

### ListingPackages
- `app/Http/Controllers/Member/PackageController.php`

### ListingProjects
- `app/Http/Controllers/Member/ProjectController.php`
- `app/Http/Controllers/Member/ProjectCategoryController.php`

### ListingSocialMedia
- `app/Http/Controllers/Member/SocialNetworkController.php`
- `app/Http/Controllers/Admin/ListingSocialNetworkController.php`

### ListingBranding
- `app/Http/Controllers/Member/BrandingController.php`

### ListingFeatures
- `app/Http/Controllers/Member/FeatureController.php` (in module already!)
- `Modules/ListingFeatures/app/Http/Controllers/Member/FeatureController.php`

### ListingMinisite
- `app/Http/Controllers/Member/ListingMinisiteController.php`
- `app/Http/Controllers/Member/ListingMinisiteSectionController.php`
- `Modules/ListingMinisite/app/Http/Controllers/Public/ListingMinisiteController.php`
- `Modules/ListingMinisite/app/Http/Controllers/Member/ListingMinisiteSectionController.php`

### ListingRestaurantMenu
- `app/Http/Controllers/Member/MenuCategoryController.php`
- `app/Http/Controllers/Member/MenuProductController.php`
- `app/Http/Controllers/Member/MenuProductVariantController.php`
- `app/Http/Controllers/Member/MenuProductImageController.php`

### ListingAiChatbot
- `app/Http/Controllers/Member/AiChatbotController.php`

### Properties
- `app/Http/Controllers/Member/PropertyController.php`
- `app/Http/Controllers/Member/PropertyImageController.php`
- `app/Http/Controllers/Member/PropertyCategoryController.php`

### VCards
- `app/Http/Controllers/Member/VCardController.php`
- `app/Http/Controllers/Member/VCardFieldController.php`
- `app/Http/Controllers/Member/VCardContactController.php`

### ListingLocations
- `app/Http/Controllers/Member/LocationController.php`

---

## CORE CONTROLLERS (Remain in app/)

### Auth
- `app/Http/Controllers/Auth/EmailVerificationController.php`
- `app/Http/Controllers/Auth/LegalAcceptanceController.php`
- `app/Http/Controllers/Auth/LoginController.php`
- `app/Http/Controllers/Auth/LogoutController.php`
- `app/Http/Controllers/Auth/PasswordResetController.php`
- `app/Http/Controllers/Auth/RegisterController.php`
- `app/Http/Controllers/Auth/SocialAuthController.php`

### Billing/Subscriptions (SaaS Core)
- `app/Http/Controllers/Member/BillingController.php`
- `app/Http/Controllers/Member/CheckoutController.php`
- `app/Http/Controllers/Member/PlanSelectionController.php`
- `app/Http/Controllers/Member/PaymentController.php`
- `app/Http/Controllers/Member/InvoiceController.php`

### User Management
- `app/Http/Controllers/Member/AccountController.php`
- `app/Http/Controllers/Member/PasswordController.php`
- `app/Http/Controllers/Member/SessionController.php`
- `app/Http/Controllers/Member/OnboardingController.php`
- `app/Http/Controllers/Member/UserProfileController.php`

### Admin - SaaS System
- `app/Http/Controllers/Admin/DashboardController.php`
- `app/Http/Controllers/Admin/UserController.php`
- `app/Http/Controllers/Admin/RoleController.php`
- `app/Http/Controllers/Admin/PermissionController.php`
- `app/Http/Controllers/Admin/PlanController.php`
- `app/Http/Controllers/Admin/PaymentController.php`
- `app/Http/Controllers/Admin/SubscriptionController.php`
- `app/Http/Controllers/Admin/InvoiceController.php`
- `app/Http/Controllers/Admin/ApiKeyController.php`
- `app/Http/Controllers/Admin/WebhookController.php`
- `app/Http/Controllers/Admin/ActivityController.php`
- `app/Http/Controllers/Admin/SupportTicketController.php`
- `app/Http/Controllers/Admin/SupportDepartmentController.php`
- `app/Http/Controllers/Admin/SettingController.php`
- `app/Http/Controllers/Admin/QueueController.php`
- `app/Http/Controllers/Admin/SystemMonitorController.php`
- `app/Http/Controllers/Admin/SystemErrorController.php`
- `app/Http/Controllers/Admin/SecurityEventController.php`
- `app/Http/Controllers/Admin/AutomationController.php`
- `app/Http/Controllers/Admin/CouponController.php`
- `app/Http/Controllers/Admin/ExportController.php`
- `app/Http/Controllers/Admin/ReportController.php`
- `app/Http/Controllers/Admin/FeatureFlagController.php`
- `app/Http/Controllers/Admin/HelpArticleController.php`
- `app/Http/Controllers/Admin/LegalDocumentController.php`
- `app/Http/Controllers/Admin/MessageTemplateController.php`
- `app/Http/Controllers/Admin/ModuleDefinitionController.php`
- `app/Http/Controllers/Admin/ModuleSettingsController.php`
- `app/Http/Controllers/Admin/SystemAnnouncementController.php`
- `app/Http/Controllers/Admin/SystemModuleController.php`

### Listing Core Management
- `app/Http/Controllers/Member/BusinessController.php` (listing CRUD)
- `app/Http/Controllers/Member/ListingModuleController.php`
- `app/Http/Controllers/Member/ListingModulesController.php`
- `app/Http/Controllers/Admin/ListingController.php`
- `app/Http/Controllers/Admin/ListingContentController.php`
- `app/Http/Controllers/Admin/ListingModuleController.php`
- `app/Http/Controllers/Admin/MinisiteThemeController.php`

### API V1 Admin
- `app/Http/Controllers/Api/V1/Admin/BusinessController.php`
- `app/Http/Controllers/Api/V1/Admin/UserController.php`

### Integrations & Notifications
- `app/Http/Controllers/Member/IntegrationController.php`
- `app/Http/Controllers/Member/NotificationController.php`
- `app/Http/Controllers/Member/NotificationPreferenceController.php`
- `app/Http/Controllers/Member/SystemAnnouncementController.php`
- `app/Http/Controllers/Member/ActivityController.php`
- `app/Http/Controllers/Member/MediaFileController.php`

### Public Pages
- `app/Http/Controllers/Public/HomeController.php`
- `app/Http/Controllers/PricingController.php`
- `app/Http/Controllers/StripeWebhookController.php`

---

## PRODUCT_COMPOSITION CONTROLLERS

These compose multiple modules and should remain in a product/composition layer:

- `app/Http/Controllers/Public/DirectoryController.php` - Composes locations, reviews, services
- `app/Http/Controllers/Public/BusinessController.php` - Composes hero, about, services, gallery, products, reviews, promotions, contact forms, appointments
- `app/Http/Controllers/Admin/ApiExplorerController.php` - Admin tool consuming multiple modules
- `app/Http/Controllers/Admin/ListingContentController.php` - Admin composition for listing content
- `app/Http/Controllers/Public/BookingWidgetController.php` - Public booking composition

---

## REQUIRES_DECISION (Need Review)

- `app/Http/Controllers/Admin/ListingLeadsController.php` - Admin leads (MODULE: ListingLeads)
- `app/Http/Controllers/Admin/ListingAiChatbotController.php` - Admin chatbot (MODULE: ListingAiChatbot)
- `app/Http/Controllers/Member/HelpArticleController.php` - Help articles (global or module?)
- `app/Http/Controllers/Member/SupportTicketController.php` - Support (SaaS core or module?)
- `app/Http/Controllers/Member/ApiKeyController.php` - API keys (SaaS core)
- `app/Http/Controllers/Member/WebhookController.php` - Webhooks (SaaS core)
- `app/Http/Controllers/Member/MediaFileController.php` - Media files (SaaS core or media module?)
- `app/Http/Controllers/Wizard/BusinessController.php` - Onboarding wizard (SaaS core)
- `app/Http/Controllers/Public/BookingWidgetController.php` - Public booking (could be ListingAppointments module)
- `app/Http/Controllers/Public/PromotionVerificationController.php` - Public promotion verification

---

## Already in Modules! (No Action Needed)

- `Modules/ListingTasks/app/Http/Controllers/Member/TaskController.php`
- `Modules/ListingFeatures/app/Http/Controllers/Member/FeatureController.php`
- `Modules/ListingMinisite/app/Http/Controllers/Public/ListingMinisiteController.php`
- `Modules/ListingMinisite/app/Http/Controllers/Member/ListingMinisiteSectionController.php`
- `Modules/VCards/app/Http/Controllers/Member/VCardController.php`

---

## Admin Controllers - Detailed Classification

| Controller | Classification | Target Module |
|-----------|---------------|---------------|
| ActivityController | CORE | - |
| ApiExplorerController | PRODUCT_COMPOSITION | - |
| ApiKeyController | CORE | - |
| AutomationController | CORE | - |
| CouponController | CORE | - |
| DashboardController | CORE | - |
| ExportController | CORE | - |
| FeatureFlagController | CORE | - |
| HelpArticleController | REQUIRES_DECISION | - |
| InvoiceController | CORE | - |
| LegalDocumentController | CORE | - |
| ListingAiChatbotController | MODULE_OWNED | ListingAiChatbot |
| ListingContactFormController | MODULE_OWNED | ListingContactForm |
| ListingContentController | PRODUCT_COMPOSITION | - |
| ListingController | CORE | - |
| ListingHeroController | MODULE_OWNED | ListingHero |
| ListingLeadsController | MODULE_OWNED | ListingLeads |
| ListingModuleController | CORE | - |
| ListingPromotionController | MODULE_OWNED | ListingPromotions |
| ListingReviewController | MODULE_OWNED | ListingReviews |
| ListingServicesController | MODULE_OWNED | ListingServices |
| ListingSocialNetworkController | MODULE_OWNED | ListingSocialMedia |
| MessageTemplateController | CORE | - |
| MinisiteThemeController | CORE | - |
| ModuleDefinitionController | CORE | - |
| ModuleSettingsController | CORE | - |
| PaymentController | CORE | - |
| PermissionController | CORE | - |
| PlanController | CORE | - |
| PlanFeatureFlagController | CORE | - |
| QueueController | CORE | - |
| ReportController | CORE | - |
| RoleController | CORE | - |
| SecurityEventController | CORE | - |
| SettingController | CORE | - |
| SlotController | MODULE_OWNED | ListingAppointments |
| SubscriptionController | CORE | - |
| SupportDepartmentController | CORE | - |
| SupportTicketController | REQUIRES_DECISION | - |
| SystemAnnouncementController | CORE | - |
| SystemErrorController | CORE | - |
| SystemModuleController | CORE | - |
| SystemMonitorController | CORE | - |
| UserController | CORE | - |
| UserProfileController | CORE | - |
| UserSubscriptionController | CORE | - |
| WebhookController | CORE | - |

---

## Member Controllers - Detailed Classification

| Controller | Classification | Target Module |
|-----------|---------------|---------------|
| AboutController | MODULE_OWNED | ListingAbout |
| AccountController | CORE | - |
| ActivityController | CORE | - |
| AiChatbotController | MODULE_OWNED | ListingAiChatbot |
| ApiKeyController | CORE | - |
| AppointmentController | MODULE_OWNED | ListingAppointments |
| AvailabilityController | MODULE_OWNED | ListingAppointments |
| BillingController | CORE | - |
| BrandingController | MODULE_OWNED | ListingBranding |
| BusinessController | CORE | - |
| CheckoutController | CORE | - |
| ClientController | MODULE_OWNED | ListingClients |
| ContactFormController | MODULE_OWNED | ListingContactForm |
| DashboardController | CORE | - |
| FaqCategoryController | MODULE_OWNED | ListingFaqs |
| FaqController | MODULE_OWNED | ListingFaqs |
| GalleryController | MODULE_OWNED | ListingGallery |
| GalleryGroupController | MODULE_OWNED | ListingGallery |
| HelpArticleController | REQUIRES_DECISION | - |
| HeroController | MODULE_OWNED | ListingHero |
| IntegrationController | CORE | - |
| InvoiceController | CORE | - |
| LeadController | MODULE_OWNED | ListingLeads |
| ListingModuleController | CORE | - |
| ListingModulesController | CORE | - |
| LocationController | MODULE_OWNED | ListingLocations |
| MediaFileController | CORE | - |
| MinisiteThemeController | CORE | - |
| NotificationController | CORE | - |
| NotificationPreferenceController | CORE | - |
| OnboardingController | CORE | - |
| PackageController | MODULE_OWNED | ListingPackages |
| PasswordController | CORE | - |
| PaymentController | CORE | - |
| PlanSelectionController | CORE | - |
| PreferenceController | CORE | - |
| ProductCategoryController | MODULE_OWNED | ListingProducts |
| ProductController | MODULE_OWNED | ListingProducts |
| ProjectCategoryController | MODULE_OWNED | ListingProjects |
| ProjectController | MODULE_OWNED | ListingProjects |
| PromotionController | MODULE_OWNED | ListingPromotions |
| ReviewController | MODULE_OWNED | ListingReviews |
| SeoController | MODULE_OWNED | ListingSeo |
| ServiceCategoryController | MODULE_OWNED | ListingServices |
| ServiceController | MODULE_OWNED | ListingServices |
| ServicesController | MODULE_OWNED | ListingServices |
| SessionController | CORE | - |
| SlotController | MODULE_OWNED | ListingAppointments |
| SocialNetworkController | MODULE_OWNED | ListingSocialMedia |
| SupportTicketController | REQUIRES_DECISION | - |
| SystemAnnouncementController | CORE | - |
| TeamMemberController | MODULE_OWNED | ListingTeamMembers |
| TeamMemberPositionController | MODULE_OWNED | ListingTeamMembers |
| WebhookController | CORE | - |

---

## Public Controllers - Detailed Classification

| Controller | Classification | Target Module |
|-----------|---------------|---------------|
| BookingWidgetController | PRODUCT_COMPOSITION | - |
| BusinessController | PRODUCT_COMPOSITION | - |
| DirectoryController | PRODUCT_COMPOSITION | - |
| HomeController | CORE | - |
| PromotionVerificationController | MODULE_OWNED | ListingPromotions |

---

## Estimated Migration Effort

| Category | Count | Complexity |
|----------|-------|------------|
| MODULE_OWNED to move | ~85 | Medium-High |
| Already in modules | ~5 | None |
| CORE to remain | ~35 | None |
| PRODUCT_COMPOSITION | ~5 | None |
| REQUIRES_DECISION | ~16 | High (needs analysis) |

**Total Controllers to Move: ~85**
**Estimated Sessions: 4-6 sessions** (at ~15-20 controllers per session)
