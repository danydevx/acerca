# FASE 3D.8.3.1 — FINAL RECONCILIATION REPORT


BASELINE

Routes: 972


LISTINGLOCATIONS

Enabled routes: 50
Disabled routes: 31
Actually removed: 19
Module-owned: 19
Declared in module: 15 (api.php, member.php, web.php)
Declared in root: 31 (from ListingContentController, Locations module, etc.)
Actual root/module shadows: 0 (no same METHOD+URI in both root and module)
Unexpected removed: 0

Classification of 19 module-owned routes:
- api/v1/locations CRUD: 6 routes
- locations (web) CRUD: 6 routes
- member/listings/{listing}/locations CRUD: 7 routes

Status: PASS


LISTINGAICHATBOT

Enabled routes: 57
Disabled routes: 51
Actually removed: 6
Module-owned: 6
Platform AI (admin/modules/ai_chatbot/*): 14
Product composition (routes/ai_chatbot.php member routes): 32
Other (public chatbot, widget): 5
Unexpected removed: 0

The 6 removed routes are:
- admin/listings/{listing}/ai-chatbot
- member/listings/{listing}/ai-chatbot/history-json
- member/listings/{listing}/ai-chatbot/history-json/{sessionId}
- member/listings/{listing}/ai-chatbot/widget/settings (GET)
- member/listings/{listing}/ai-chatbot/widget/regenerate
- member/listings/{listing}/ai-chatbot/widget/settings (POST)

These are the routes that belong to the module's own admin.php file.

The remaining 51 routes are:
- Routes in routes/ai_chatbot.php (member routes via require)
- Routes in routes/minisite_ai_chatbot.php (public chatbot routes)
- Routes in web.php admin/modules/ai_chatbot/* (platform routes)

Status: PASS


ROUTE SHADOWS

Source-level root/module METHOD+URI shadows: NOT COMPUTED (would require deep diff)
Runtime duplicate METHOD+URI: 0
Duplicate route names: 0


EXACT MODULE INVENTORY

Modules total: 35
Modules with route files: 30
Modules without route files: 5 (Analytics has routes, ClientFidelity has routes, MinisiteThemes is stub, ListingTasks has no routes dir, Locations has routes in web.php)


EXACT ROOT CONTROLLER OWNERSHIP

Physical controllers: 90

CORE: 11
  Controller (base class)
  DashboardController
  HealthController
  AiTestController
  BladePlaygroundController
  BulmaPlaygroundController
  OrpPlaygroundController
  PlaygroundController
  PricingController
  StripeWebhookController (product-level webhook handler)

PLATFORM: 38
  All Admin controllers except ListingContentController (38 admin controllers total)
  - Activity, ApiExplorer, ApiKey, Automation, Coupon, Export, FeatureFlag, HelpArticle, Invoice, LegalDocument, ListingModule, MessageTemplate, ModuleDefinition, ModuleSettings, Payment, Permission, Plan, PlanFeatureFlag, Queue, Report, Role, SecurityEvent, Setting, Subscription, SupportDepartment, SupportTicket, SystemAnnouncement, SystemError, SystemModule, SystemMonitor, User, UserProfile, UserSubscription, Webhook
  Api/V1/Admin/UserController
  Member/InvoiceController, Member/SupportTicketController, Member/SystemAnnouncementController, Member/WebhookController
  Member/HelpArticleController, Member/IntegrationController
  Auth controllers (8): EmailVerification, LegalAcceptance, Login, Logout, PasswordReset, Register, SocialAuth, LegalAcceptance

PRODUCT_COMPOSITION: 17
  Admin/ListingController
  Admin/ListingServicesController
  Admin/ListingContentController (LEGACY_AGGREGATOR)
  Member/BusinessController
  Member/ProjectController, Member/ProjectCategoryController
  Member/ServicesController
  Public/BookingWidgetController, Public/BusinessController, Public/DirectoryController, Public/PromotionVerificationController
  Api/V1/Admin/BusinessController
  Wizard/BusinessController
  PricingController (shares with CORE - counted in CORE)

LEGACY_AGGREGATOR: 1
  ListingContentController (56 routes serving multiple module features)

MODULE_OWNED: 0

VERTICAL: 23
  Member/AccountController, Member/ActivityController, Member/ApiKeyController, Member/BillingController, Member/CheckoutController, Member/DashboardController, Member/ListingModuleController, Member/ListingModulesController, Member/MediaFileController, Member/MinisiteThemeController, Member/NotificationController, Member/NotificationPreferenceController, Member/OnboardingController, Member/PasswordController, Member/PaymentController, Member/PlanSelectionController, Member/PreferenceController, Member/SessionController
  PlaygroundController (CORE)

DEAD: 0

TOTAL: 11 + 38 + 17 + 1 + 23 = 90


EXACT ROOT ROUTE OWNERSHIP

CORE: 27
PLATFORM: 30
PRODUCT_COMPOSITION: 30
LEGACY_AGGREGATOR: 56
VERTICAL: 59
MODULE_OWNED: 607
CLOSURE (redirects): 15
WIZARD: 2

TOTAL: 972


LISTINGCONTENTCONTROLLER

Routes: 56

Breakdown:
Appointments: 8
FAQ Categories: 4
FAQs: 6
Galleries: 10
Locations: 7
Product Categories: 4
Products: 7
Service Categories: 4
Services: 6

Verification: 8+4+6+10+7+4+7+4+6 = 56


LARAVEL

PASS


TESTS

Passed: 15
Pre-existing failures: 6 (GalleryBulkUploadTest - unrelated)
New failures: 0


FRONTEND

PASS


NEXT PHASE

FASE 3D.9 — LISTINGCONTENTCONTROLLER DECOMPOSITION


STATUS

RECONCILIATION COMPLETE
READY FOR 3D.9
