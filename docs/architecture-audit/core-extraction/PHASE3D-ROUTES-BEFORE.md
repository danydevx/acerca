# PHASE 3D — ROUTES AUDIT (BEFORE)

## Route Files Analyzed

| File | Lines | Classification |
|------|-------|----------------|
| `routes/web.php` | ~2020 | MAIN - Contains CORE, MODULE_OWNED, and PRODUCT_COMPOSITION |
| `routes/api.php` | ~42 | CORE - Public API endpoints |
| `routes/api/v1/admin.php` | ~98 | CORE - Admin API |
| `routes/ai_chatbot.php` | ~43 | MODULE - ListingAiChatbot routes |
| `routes/minisite_ai_chatbot.php` | ~22 | MODULE - ListingAiChatbot public routes |
| `routes/console.php` | ~47 | CORE - Scheduled tasks |

---

## web.php Route Classification

### PUBLIC ROUTES (no auth) — CORE
```
GET  /                               → DirectoryController@index
GET  /health                         → HealthController
GET  /login                          → LoginController@showLogin
POST /login                          → LoginController@store
GET  /register                       → RegisterController@showRegister
POST /register                       → RegisterController@register
POST /register/wizard                 → RegisterController@storeWizard
GET  /auth/{provider}                → SocialAuthController@redirectToProvider
GET  /auth/{provider}/callback        → SocialAuthController@handleProviderCallback
GET  /forgot-password                → PasswordResetController@showForgotPassword
POST /forgot-password                → PasswordResetController@sendResetLink
GET  /reset-password/{token}          → PasswordResetController@showVerifyCode
POST /reset-password/{token}/verify-code → PasswordResetController@verifyCode
GET  /reset-password/{token}/new-password → PasswordResetController@showResetPasswordForm
POST /reset-password/{token}          → PasswordResetController@resetPassword
GET  /email/verify                   → EmailVerificationController@notice
GET  /email/verify/{id}/{hash}       → EmailVerificationController@verify
POST /email/verification-notification → EmailVerificationController@resend
POST /logout                         → LogoutController@destroy
GET  /legal/accept                   → LegalAcceptanceController@show
POST /legal/accept                   → LegalAcceptanceController@store
GET  /pricing                        → PricingController@index
POST /pricing/select/{plan}          → PricingController@select
GET  /terminos                       → view
GET  /privacidad                     → view
GET  /maintenance                    → view (inertia)
GET  /negocios                       → DirectoryController@index
GET  /negocios/{slug}                → DirectoryController@show
POST /negocios/{slug}/appointment    → DirectoryController@storeAppointment
POST /negocios/{slug}/contact        → DirectoryController@storeContact
GET  /b/{slug}                       → PublicBusinessController@show
GET  /b/{slug}/locations             → PublicBusinessController@locations
GET  /b/{slug}/services             → PublicBusinessController@services
GET  /b/{slug}/gallery              → PublicBusinessController@gallery
GET  /b/{slug}/products             → PublicBusinessController@products
GET  /b/{slug}/packages             → PublicBusinessController@packages
GET  /b/{slug}/features             → PublicFeatureController@index
GET  /b/{slug}/book                 → PublicBusinessController@book
POST /b/{slug}/book                 → PublicBusinessController@storeBooking
GET  /b/{slug}/book/success        → PublicBusinessController@bookingSuccess
GET  /b/{slug}/contact              → PublicBusinessController@contact
POST /b/{slug}/contact              → PublicBusinessController@storeContact
GET  /b/{slug}/form/{shortcode}    → PublicBusinessController@formByShortcode
POST /b/{slug}/form/{shortcode}     → PublicBusinessController@storeFormByShortcode
GET  /b/{slug}/menu                 → MenuController@show
GET  /b/{slug}/verify/{promotionId}/{couponCode} → PromotionVerificationController@verify
POST /stripe/webhook                → StripeWebhookController@handle
```

### MEMBER DASHBOARD ROUTES (auth + verified + active) — CORE
```
GET  /member                         → redirect to dashboard
GET  /member/dashboard               → DashboardController@index
GET  /member/account                 → AccountController@show
GET  /member/profile                 → UserProfileController@editMember
GET  /member/password                → PasswordController@edit
PUT  /member/password                → PasswordController@update
GET  /member/preferences             → MemberPreferenceController@edit
PUT  /member/preferences             → MemberPreferenceController@update
GET  /member/sessions                → MemberSessionController@index
DELETE /member/sessions/others       → MemberSessionController@destroyOthers
DELETE /member/sessions/{session}    → MemberSessionController@destroy
GET  /profile                        → UserProfileController@edit
POST /profile                        → UserProfileController@update
GET  /member/onboarding/complete     → OnboardingController@complete
```

### MEMBER BILLING ROUTES (module:billing) — CORE
```
POST /member/billing/portal         → BillingController@portal
POST /member/checkout/{plan}        → CheckoutController@create
POST /member/checkout/coupon/validate → CheckoutController@validateCoupon
PUT  /member/checkout/coupon/clear  → CheckoutController@clearCoupon
GET  /member/checkout/success       → CheckoutController@success
GET  /member/checkout/cancel        → CheckoutController@cancel
GET  /member/plan-selection         → PlanSelectionController@show
PUT  /member/plan-selection/clear   → PlanSelectionController@clear
GET  /member/payments               → MemberPaymentController@index
GET  /member/invoices               → MemberInvoiceController@index
GET  /member/invoices/{invoice}     → MemberInvoiceController@show
GET  /member/invoices/{invoice}/download → MemberInvoiceController@download
```

### MEMBER NOTIFICATIONS (module:notifications) — CORE
```
GET  /member/notifications          → NotificationController@index
GET  /member/notifications/unread-count → NotificationController@unreadCount
PUT  /member/notifications/{notification}/read → NotificationController@markAsRead
PUT  /member/notifications/read-all → NotificationController@markAllAsRead
GET  /member/notification-preferences → NotificationPreferenceController@edit
PUT  /member/notification-preferences → NotificationPreferenceController@update
```

### MEMBER INTEGRATIONS (module:integrations) — CORE
```
GET  /member/integrations           → IntegrationController@index
GET  /member/integrations/docs      → IntegrationController@apiDocumentation
```

### MEMBER SUPPORT (module:support) — CORE
```
GET  /member/support                → MemberSupportTicketController@index
GET  /member/support/create          → MemberSupportTicketController@create
POST /member/support                → MemberSupportTicketController@store
GET  /member/support/{ticket}        → MemberSupportTicketController@show
POST /member/support/{ticket}/reply  → MemberSupportTicketController@reply
GET  /member/help                    → MemberHelpArticleController@index
GET  /member/help/{slug}            → MemberHelpArticleController@show
```

### MEMBER ANNOUNCEMENTS (module:announcements) — CORE
```
GET  /member/announcements/active   → MemberSystemAnnouncementController@active
PUT  /member/announcements/{announcement}/dismiss → MemberSystemAnnouncementController@dismiss
```

### MEMBER ACTIVITY (module:activity) — CORE
```
GET  /member/activity              → MemberActivityController@index
```

### MEMBER MEDIA (module:media) — CORE
```
GET  /member/files                 → MemberMediaFileController@index
POST /member/files                 → MemberMediaFileController@store
GET  /member/files/{file}           → MemberMediaFileController@show
GET  /member/files/{file}/download → MemberMediaFileController@download
DELETE /member/files/{file}         → MemberMediaFileController@destroy
```

### MEMBER API KEYS (module:api + permission) — CORE
```
GET  /member/api-keys               → MemberApiKeyController@index
POST /member/api-keys               → MemberApiKeyController@store
PUT  /member/api-keys/{apiKey}     → MemberApiKeyController@update
DELETE /member/api-keys/{apiKey}    → MemberApiKeyController@destroy
```

### MEMBER WEBHOOKS (module:webhooks + permission) — CORE
```
GET  /member/webhooks               → MemberWebhookController@index
POST /member/webhooks               → MemberWebhookController@store
PUT  /member/webhooks/{webhook}     → MemberWebhookController@update
DELETE /member/webhooks/{webhook}   → MemberWebhookController@destroy
POST /member/webhooks/{webhook}/test → MemberWebhookController@test
POST /member/webhooks/{webhook}/regenerate-secret → MemberWebhookController@regenerateSecret
GET  /member/webhooks/{webhook}/deliveries → MemberWebhookController@deliveries
POST /member/webhooks/deliveries/{delivery}/retry → MemberWebhookController@retryDelivery
```

### MEMBER LISTING CRUD — CORE
```
GET  /member/listings               → ListingModuleController@index
GET  /member/listings/create        → BusinessController@create
POST /member/listings               → BusinessController@store
GET  /member/listings/{listing}/edit → BusinessController@edit
PUT  /member/listings/{listing}     → BusinessController@update
GET  /member/listings/modules       → ListingModulesController@show
GET  /member/listings/{listing}/modules → ListingModuleController@edit
```

### MODULE_OWNED ROUTES (under /member/listings/{listing}/*)

#### Locations — ListingLocations
```
GET    /member/listings/{listing}/locations
GET    /member/listings/{listing}/locations/create
POST   /member/listings/{listing}/locations
GET    /member/listings/{listing}/locations/{location}/edit
PUT    /member/listings/{listing}/locations/{location}
DELETE /member/listings/{listing}/locations/{location}
POST   /member/listings/{listing}/locations/bulk-delete
```

#### Services — ListingServices
```
GET    /member/listings/{listing}/services
GET    /member/listings/{listing}/services/create
POST   /member/listings/{listing}/services
GET    /member/listings/{listing}/services/{service}/edit
PUT    /member/listings/{listing}/services/{service}
DELETE /member/listings/{listing}/services/{service}
POST   /member/listings/{listing}/services/{service}/clone
POST   /member/listings/{listing}/services/reorder
POST   /member/listings/{listing}/services/bulk-delete
POST   /member/listings/{listing}/services/{service}/images
DELETE /member/listings/{listing}/services/{service}/images/{image}
```

#### Service Categories — ListingServices
```
GET    /member/listings/{listing}/service-categories
POST   /member/listings/{listing}/service-categories
PUT    /member/listings/{listing}/service-categories/{category}
DELETE /member/listings/{listing}/service-categories/{category}
```

#### Team Members — ListingTeamMembers
```
GET    /member/listings/{listing}/team-members
GET    /member/listings/{listing}/team-members/create
POST   /member/listings/{listing}/team-members
GET    /member/listings/{listing}/team-members/{member}/edit
POST   /member/listings/{listing}/team-members/{member}
DELETE /member/listings/{listing}/team-members/{member}
POST   /member/listings/{listing}/team-members/reorder
POST   /member/listings/{listing}/team-members/bulk-delete
```

#### Team Member Positions — ListingTeamMembers
```
GET    /member/listings/{listing}/team-member-positions
GET    /member/listings/{listing}/team-member-positions/create
POST   /member/listings/{listing}/team-member-positions
POST   /member/listings/{listing}/team-member-positions/reorder
GET    /member/listings/{listing}/team-member-positions/{position}/edit
PUT    /member/listings/{listing}/team-member-positions/{position}
DELETE /member/listings/{listing}/team-member-positions/{position}
```

#### Packages — ListingPackages
```
GET    /member/listings/{listing}/packages
GET    /member/listings/{listing}/packages/create
POST   /member/listings/{listing}/packages
POST   /member/listings/{listing}/packages/reorder
POST   /member/listings/{listing}/packages/bulk-delete
GET    /member/listings/{listing}/packages/{package}/edit
POST   /member/listings/{listing}/packages/{package}
DELETE /member/listings/{listing}/packages/{package}
POST   /member/listings/{listing}/packages/{package}/clone
```

#### FAQs — ListingFaqs
```
GET    /member/listings/{listing}/faqs
GET    /member/listings/{listing}/faqs/create
POST   /member/listings/{listing}/faqs
GET    /member/listings/{listing}/faqs/{faq}/edit
PUT    /member/listings/{listing}/faqs/{faq}
DELETE /member/listings/{listing}/faqs/{faq}
POST   /member/listings/{listing}/faqs/reorder
POST   /member/listings/{listing}/faqs/bulk-delete
POST   /member/listings/{listing}/faqs/{faq}/clone
```

#### FAQ Categories — ListingFaqs
```
GET    /member/listings/{listing}/faq-categories
POST   /member/listings/{listing}/faq-categories
PUT    /member/listings/{listing}/faq-categories/{category}
DELETE /member/listings/{listing}/faq-categories/{category}
```

#### Minisite — ListingMinisite
```
GET    /member/listings/{listing}/minisite
POST   /member/listings/{listing}/minisite
PUT    /member/listings/{listing}/minisite
GET    /member/listings/{listing}/minisite/sections
GET    /member/listings/{listing}/minisite/sections/create
POST   /member/listings/{listing}/minisite/sections
GET    /member/listings/{listing}/minisite/sections/{section}/edit
PUT    /member/listings/{listing}/minisite/sections/{section}
DELETE /member/listings/{listing}/minisite/sections/{section}
POST   /member/listings/{listing}/minisite/sections/reorder
GET    /member/listings/{listing}/minisite-theme
PUT    /member/listings/{listing}/minisite-theme/{theme}
```

#### SEO — ListingSeo
```
GET    /member/listings/{listing}/seo
POST   /member/listings/{listing}/seo
```

#### Branding — ListingBranding
```
GET    /member/listings/{listing}/branding
POST   /member/listings/{listing}/branding
```

#### Hero — ListingHero
```
GET    /member/listings/{listing}/hero
POST   /member/listings/{listing}/hero
```

#### About — ListingAbout
```
GET    /member/listings/{listing}/about
POST   /member/listings/{listing}/about
```

#### Social Networks — ListingSocialMedia
```
GET    /member/listings/{listing}/social-networks
POST   /member/listings/{listing}/social-networks
POST   /member/listings/{listing}/social-networks/reorder
POST   /member/listings/{listing}/social-networks/{socialNetwork}
DELETE /member/listings/{listing}/social-networks/{socialNetwork}
```

#### Tasks — ListingTasks
```
GET    /member/listings/{listing}/tasks
POST   /member/listings/{listing}/tasks
PUT    /member/listings/{listing}/tasks/{task}
DELETE /member/listings/{listing}/tasks/{task}
POST   /member/listings/{listing}/tasks/{task}/archive
POST   /member/listings/{listing}/tasks/reorder
```

#### Clients — ListingClients
```
GET    /member/listings/{listing}/clients
GET    /member/listings/{listing}/clients/create
POST   /member/listings/{listing}/clients
GET    /member/listings/{listing}/clients/{client}/edit
PUT    /member/listings/{listing}/clients/{client}
DELETE /member/listings/{listing}/clients/{client}
POST   /member/listings/{listing}/clients/bulk-delete
POST   /member/listings/{listing}/clients/{client}/clone
```

#### Gallery — ListingGallery
```
GET    /member/listings/{listing}/galleries
GET    /member/listings/{listing}/galleries/create
POST   /member/listings/{listing}/galleries
GET    /member/listings/{listing}/galleries/{gallery}/edit
PUT    /member/listings/{listing}/galleries/{gallery}
DELETE /member/listings/{listing}/galleries/{gallery}
POST   /member/listings/{listing}/galleries/{gallery}/set-primary
GET    /member/listings/{listing}/gallery (legacy)
GET    /member/listings/{listing}/gallery/{gallery} (legacy)
POST   /member/listings/{listing}/gallery
PUT    /member/listings/{listing}/gallery/{image}
DELETE /member/listings/{listing}/gallery/{image}
POST   /member/listings/{listing}/gallery/reorder
POST   /member/listings/{listing}/gallery/bulk-delete
```

#### Products — ListingProducts
```
GET    /member/listings/{listing}/products
GET    /member/listings/{listing}/products/create
POST   /member/listings/{listing}/products
GET    /member/listings/{listing}/products/{product}/edit
PUT    /member/listings/{listing}/products/{product}
DELETE /member/listings/{listing}/products/{product}
POST   /member/listings/{listing}/products/{product}/clone
POST   /member/listings/{listing}/products/reorder
POST   /member/listings/{listing}/products/bulk-delete
POST   /member/listings/{listing}/products/{product}/images
DELETE /member/listings/{listing}/products/{product}/images/{image}
```

#### Product Categories — ListingProducts
```
GET    /member/listings/{listing}/product-categories
POST   /member/listings/{listing}/product-categories
PUT    /member/listings/{listing}/product-categories/{category}
DELETE /member/listings/{listing}/product-categories/{category}
```

#### Projects — ListingProjects
```
GET    /member/listings/{listing}/projects
GET    /member/listings/{listing}/projects/create
POST   /member/listings/{listing}/projects
GET    /member/listings/{listing}/projects/{project}/edit
PUT    /member/listings/{listing}/projects/{project}
DELETE /member/listings/{listing}/projects/{project}
POST   /member/listings/{listing}/projects/{project}/clone
POST   /member/listings/{listing}/projects/reorder
POST   /member/listings/{listing}/projects/bulk-delete
POST   /member/listings/{listing}/projects/{project}/images
DELETE /member/listings/{listing}/projects/{project}/images/{image}
```

#### Project Categories — ListingProjects
```
GET    /member/listings/{listing}/project-categories
POST   /member/listings/{listing}/project-categories
PUT    /member/listings/{listing}/project-categories/{category}
DELETE /member/listings/{listing}/project-categories/{category}
```

#### Appointments — ListingAppointments
```
GET    /member/listings/{listing}/appointments
GET    /member/listings/{listing}/appointments/create
POST   /member/listings/{listing}/appointments
GET    /member/listings/{listing}/appointments/{appointment}
GET    /member/listings/{listing}/appointments/{appointment}/edit
PUT    /member/listings/{listing}/appointments/{appointment}
DELETE /member/listings/{listing}/appointments/{appointment}
POST   /member/listings/{listing}/appointments/{appointment}/cancel
PUT    /member/listings/{listing}/appointments/{appointment}/reschedule
POST   /member/listings/{listing}/appointments/bulk-delete
GET    /member/listings/{listing}/appointments/availability
PUT    /member/listings/{listing}/appointments/availability/weekly
POST   /member/listings/{listing}/appointments/availability/exceptions
DELETE /member/listings/{listing}/appointments/availability/exceptions/{exception}
```

#### Slots — ListingAppointments
```
GET    /member/listings/{listing}/slots
POST   /member/listings/{listing}/slots
PUT    /member/listings/{listing}/slots/{slot}
DELETE /member/listings/{listing}/slots/{slot}
```

#### Leads — ListingLeads
```
GET    /member/listings/{listing}/leads
GET    /member/listings/{listing}/leads/create
POST   /member/listings/{listing}/leads
GET    /member/listings/{listing}/leads/export
GET    /member/listings/{listing}/leads/{lead}
GET    /member/listings/{listing}/leads/{lead}/edit
PUT    /member/listings/{listing}/leads/{lead}
DELETE /member/listings/{listing}/leads/{lead}
POST   /member/listings/{listing}/leads/bulk-delete
```

#### Contact Forms — ListingContactForm
```
GET    /member/listings/{listing}/contact-forms
GET    /member/listings/{listing}/contact-forms/api
GET    /member/listings/{listing}/contact-forms/create
POST   /member/listings/{listing}/contact-forms
GET    /member/listings/{listing}/contact-forms/{form}/edit
PUT    /member/listings/{listing}/contact-forms/{form}
DELETE /member/listings/{listing}/contact-forms/{form}
POST   /member/listings/{listing}/contact-forms/{form}/fields
PUT    /member/listings/{listing}/contact-forms/{form}/fields/{field}
DELETE /member/listings/{listing}/contact-forms/{form}/fields/{field}
POST   /member/listings/{listing}/contact-forms/{form}/reorder
GET    /member/listings/{listing}/contact-forms/{form}/submissions
GET    /member/listings/{listing}/contact-forms/export
GET    /member/listings/{listing}/contact-forms/{form}/preview
```

#### Reviews — ListingReviews
```
GET    /member/listings/{listing}/reviews
GET    /member/listings/{listing}/reviews/create
POST   /member/listings/{listing}/reviews
POST   /member/listings/{listing}/reviews/reorder
POST   /member/listings/{listing}/reviews/bulk-delete
POST   /member/listings/{listing}/reviews/{review}/clone
GET    /member/listings/{listing}/reviews/{review}/edit
PUT    /member/listings/{listing}/reviews/{review}
DELETE /member/listings/{listing}/reviews/{review}
```

#### Promotions — ListingPromotions
```
GET    /member/listings/{listing}/promotions
GET    /member/listings/{listing}/promotions/create
POST   /member/listings/{listing}/promotions
GET    /member/listings/{listing}/promotions/{promotion}/edit
PUT    /member/listings/{listing}/promotions/{promotion}
DELETE /member/listings/{listing}/promotions/{promotion}
POST   /member/listings/{listing}/promotions/reorder
POST   /member/listings/{listing}/promotions/bulk-delete
POST   /member/listings/{listing}/promotions/{promotion}/clone
POST   /member/listings/{listing}/promotions/{promotion}/regenerate-qr
```

#### Features — ListingFeatures
```
GET    /member/listings/{listing}/features
POST   /member/listings/{listing}/features
POST   /member/listings/{listing}/features/import
POST   /member/listings/{listing}/features/import/{feature}
PUT    /member/listings/{listing}/features/{feature}
DELETE /member/listings/{listing}/features/{feature}
PUT    /member/listings/{listing}/feature-assignments
DELETE /member/listings/{listing}/feature-assignments/{assignment}
POST   /member/listings/{listing}/features/reorder
DELETE /member/listings/{listing}/features/unlink-all
```

#### Menu Categories — ListingRestaurantMenu
```
GET    /member/listings/{listing}/menu-categories
POST   /member/listings/{listing}/menu-categories
PUT    /member/listings/{listing}/menu-categories/{category}
DELETE /member/listings/{listing}/menu-categories/{category}
```

#### Menu Products — ListingRestaurantMenu
```
GET    /member/listings/{listing}/menu-products
GET    /member/listings/{listing}/menu-products/create
POST   /member/listings/{listing}/menu-products
POST   /member/listings/{listing}/menu-products/reorder
POST   /member/listings/{listing}/menu-products/bulk-delete
GET    /member/listings/{listing}/menu-products/{product}/edit
PUT    /member/listings/{listing}/menu-products/{product}
DELETE /member/listings/{listing}/menu-products/{product}
POST   /member/listings/{listing}/menu-products/{product}/clone
POST   /member/listings/{listing}/menu-products/{product}/variants
PUT    /member/listings/{listing}/menu-products/{product}/variants/{variant}
DELETE /member/listings/{listing}/menu-products/{product}/variants/{variant}
POST   /member/listings/{listing}/menu-products/{product}/images
PUT    /member/listings/{listing}/menu-products/{product}/images/{image}
DELETE /member/listings/{listing}/menu-products/{product}/images/{image}
```

---

## api.php Routes — CORE
```
GET /me                              → Closure (user info)
GET v1/location-data/countries       → LocationController@getCountries
GET v1/location-data/states          → LocationController@getStates
GET v1/location-data/states/{countryCode} → LocationController@getStates
GET v1/location-data/municipalities/{stateCode} → LocationController@getMunicipalities
GET book/businesses/active           → BookingWidgetController@activeBusinesses
GET book/business/{businessSlug}/services → BookingWidgetController@services
GET book/business/{businessSlug}/packages → BookingWidgetController@packages
GET book/business/{businessSlug}/slots   → BookingWidgetController@slots
POST book/business/{businessSlug}     → BookingWidgetController@store
```

---

## api/v1/admin.php Routes — CORE
```
GET  /businesses                     → BusinessController@index
GET  /listings/{listing}              → BusinessController@show
GET  /listings/{listing}/stats      → BusinessController@stats
GET  /listings/{listing}/locations  → BusinessController@locations
GET  /listings/{listing}/gallery     → BusinessController@gallery
GET  /listings/{listing}/faqs       → BusinessController@faqs
GET  /listings/{listing}/seo        → BusinessController@seo
GET  /listings/{listing}/branding   → BusinessController@branding
GET  /listings/{listing}/hero       → BusinessController@hero
GET  /listings/{listing}/about      → BusinessController@about
GET  /listings/{listing}/services   → BusinessController@services
GET  /listings/{listing}/products   → BusinessController@products
GET  /listings/{listing}/reviews    → BusinessController@reviews
GET  /listings/{listing}/leads       → BusinessController@leads
GET  /listings/{listing}/appointments → BusinessController@appointments
GET  /listings/{listing}/appointment-slots → BusinessController@appointmentSlots
GET  /listings/{listing}/properties  → BusinessController@properties
GET  /listings/{listing}/clients     → BusinessController@clients
GET  /listings/{listing}/menu-categories → BusinessController@menuCategories
GET  /listings/{listing}/menu-products → BusinessController@menuProducts
GET  /listings/{listing}/office-hours → BusinessController@officeHours
GET  /listings/{listing}/team-members → BusinessController@teamMembers
GET  /listings/{listing}/team-member-positions → BusinessController@teamMemberPositions
GET  /listings/{listing}/packages    → BusinessController@packages
GET  /listings/{listing}/vcards     → BusinessController@vcards
GET  /listings/{listing}/fidelity-cards → BusinessController@fidelityCards
GET  /listings/{listing}/fidelity-rewards → BusinessController@fidelityRewards
GET  /users                          → UserController@index
GET  /users/{user}                   → UserController@show
GET  /users/{user}/businesses        → UserController@businesses
```

---

## ai_chatbot.php Routes — MODULE (ListingAiChatbot)
```
GET    /                              → AiChatbotController@index
POST   /settings                      → AiChatbotController@saveSettings
POST   /contexts                      → AiChatbotController@storeContext
PUT    /contexts/{contextId}          → AiChatbotController@updateContext
DELETE /contexts/{contextId}         → AiChatbotController@destroyContext
GET    /embeddings-json               → AiChatbotController@embeddingsJson
DELETE /embeddings/{type}            → AiChatbotController@destroyEmbeddings
DELETE /embedding/{id}                → AiChatbotController@destroyEmbedding
POST   /reindex                       → AiChatbotController@reindex
POST   /extract-url                   → AiChatbotController@extractUrl
GET    /history                       → ConversationHistoryController@index
GET    /history/{sessionId}           → ConversationHistoryController@show
GET    /analytics                     → ChatbotAnalyticsController@index
GET    /analytics-json                → ChatbotAnalyticsController@indexJson
GET    /presets                       → ChatbotPresetsController@index
GET    /presets/create                → ChatbotPresetsController@create
POST   /presets                       → ChatbotPresetsController@store
GET    /presets/{preset}/edit        → ChatbotPresetsController@edit
PUT    /presets/{preset}              → ChatbotPresetsController@update
DELETE /presets/{preset}             → ChatbotPresetsController@destroy
POST   /presets/{preset}/duplicate   → ChatbotPresetsController@duplicate
GET    /personalities                 → ChatbotPersonalityController@index
GET    /personalities/create          → ChatbotPersonalityController@create
POST   /personalities                 → ChatbotPersonalityController@store
GET    /personalities/{personality}/edit → ChatbotPersonalityController@edit
PUT    /personalities/{personality}  → ChatbotPersonalityController@update
DELETE /personalities/{personality}   → ChatbotPersonalityController@destroy
```

---

## minisite_ai_chatbot.php Routes — MODULE (ListingAiChatbot Public)
```
POST /chat                           → ChatController@chat
POST /stream-chat                    → ChatController@streamChat
GET  /settings                       → ChatController@getSettings
GET  /conversation                   → ChatController@conversation
POST /capture-lead                  → ChatController@captureLead
```

---

## ROUTE COUNT SUMMARY

| Category | Count | Notes |
|----------|-------|-------|
| Public web routes | ~50 | CORE |
| Member dashboard routes | ~30 | CORE |
| Module-owned member routes | ~150+ | MODULE_OWNED |
| API routes | ~40 | CORE |
| AI chatbot routes | ~30 | MODULE |
| **TOTAL** | **~300** | |

---

## MIGRATION WORKFLOW REQUIRED

### For Each Module:
1. Create `Modules/{Module}/routes/member.php`
2. Create `Modules/{Module}/routes/public.php` (if applicable)
3. Create/Update `Modules/{Module}/app/Providers/{Module}ServiceProvider.php` to register routes
4. Move controller files to `Modules/{Module}/app/Http/Controllers/`
5. Update namespaces in moved controllers
6. Remove route definitions from `routes/web.php`
7. Remove route includes from `routes/web.php`
8. Update composer autoload if needed
9. Run `php artisan optimize:clear`
10. Verify routes with `php artisan route:list`

---

## CRITICAL DEPENDENCIES

### Admin Routes (46 controllers, ~100+ routes)
All admin routes remain in `routes/web.php` grouped under `/admin/*` prefix.

### API Routes
- `routes/api.php` — CORE public API
- `routes/api/v1/admin.php` — CORE admin API (requires auth:api + role:admin)

### Middleware Preservation
All route middleware must be preserved:
- `auth`
- `verified`
- `active`
- `role:member`
- `role:admin`
- `module:{name}`
- `permission:{name}`
- `throttle`
