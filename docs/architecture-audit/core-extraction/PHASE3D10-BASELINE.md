# FASE 3D.10 — BASELINE


## Routes: 970


## Physical root controllers: 89

Note: ListingContentController exists as orphaned file (0 routes) - to be addressed.


## Route breakdown by namespace

| Namespace | Count |
|----------|-------|
| ADMIN | 148 |
| API_ADMIN | 30 |
| AUTH | 19 |
| MEMBER | 63 |
| MODULE | 661 |
| OTHER_APP | 8 |
| PUBLIC | 24 |
| WIZARD | 2 |
| OTHER (closures) | 15 |


## Physical controller classification

### ADMIN (38 controllers)

CORE (platform infrastructure):
- ActivityController
- ApiExplorerController
- ApiKeyController
- AutomationController
- DashboardController
- ExportController
- FeatureFlagController
- HelpArticleController
- InvoiceController
- LegalDocumentController
- ListingController (PRODUCT_COMPOSITION - manages listings lifecycle)
- ListingModuleController
- ListingServicesController (module config)
- MessageTemplateController
- ModuleDefinitionController (PLATFORM)
- ModuleSettingsController (PLATFORM)
- PaymentController
- PermissionController
- PlanController
- PlanFeatureFlagController
- QueueController
- ReportController
- RoleController
- SecurityEventController
- SettingController
- SubscriptionController
- SupportDepartmentController
- SupportTicketController
- SystemAnnouncementController
- SystemErrorController
- SystemModuleController
- SystemMonitorController
- UserController
- UserProfileController
- UserSubscriptionController
- WebhookController

### API_ADMIN (2 controllers)

PLATFORM:
- Api/V1/Admin/BusinessController (API composition for admin)
- Api/V1/Admin/UserController

### AUTH (8 controllers)

CORE:
- EmailVerificationController
- LegalAcceptanceController
- LoginController
- LogoutController
- PasswordResetController
- RegisterController
- SocialAuthController

### MEMBER (27 controllers)

VERTICAL (member-specific business logic):
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
- ListingModulesController
- MediaFileController
- NotificationController
- NotificationPreferenceController
- OnboardingController
- PasswordController
- PaymentController
- PlanSelectionController
- PreferenceController
- ProjectCategoryController
- ProjectController
- SessionController
- SupportTicketController
- SystemAnnouncementController
- WebhookController

PRODUCT_COMPOSITION:
- Member/BusinessController (composes listing with multiple domains)

### PUBLIC (5 controllers)

PRODUCT_COMPOSITION:
- Public/BusinessController (public listing presentation)
- Public/DirectoryController (directory browsing)
- Public/BookingWidgetController (booking composition)

CORE:
- Public/HomeController

SUSPECTED MODULE_SPECIFIC (needs audit):
- Public/PromotionVerificationController

### WIZARD (1 controller)

PRODUCT_COMPOSITION:
- Wizard/BusinessController (onboarding composition)

### OTHER_APP (8 controllers)

CORE:
- AiTestController
- BladePlaygroundController
- BulmaPlaygroundController
- HealthController
- OrpPlaygroundController
- PlaygroundController
- PricingController
- StripeWebhookController

### ORPHANED (1 controller)

- Admin/ListingContentController (file exists but 0 routes - should be deleted)
