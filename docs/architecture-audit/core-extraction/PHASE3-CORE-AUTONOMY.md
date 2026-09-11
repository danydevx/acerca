# PHASE 3 — CORE AUTONOMY

**Date:** 2026-09-10
**Goal:** Make Core independent, remove module dependencies from Core infrastructure

---

## CURRENT STATE SUMMARY

### Core Location
```
app/
├── Models/ (User, ApiKey, MediaFile, Payment, Subscription, SupportTicket, WebhookEndpoint, MinisiteTheme)
├── Policies/ (many module-specific policies still here)
├── Http/Controllers/
│   ├── Admin/ (mixed - Core + Module controllers)
│   ├── Member/ (mixed - Core + Module controllers)
│   ├── Public/ (mixed)
│   └── Wizard/ (Core - business creation)
├── Services/
└── Providers/AppServiceProvider.php (module policy registrations)

Modules/Listings/ (CORE - but contains vertical knowledge)
```

---

## PROBLEM 1: APP SERVICE PROVIDER — MODULE POLICY BLOAT

**File:** `app/Providers/AppServiceProvider.php`

**Issue:** Registers 40+ Gate::policy() for module models. Core should NOT know about module policies.

**Current state (partial):**
```php
Gate::policy(\Modules\ListingGallery\Models\ListingGalleryImage::class, ListingGalleryImagePolicy::class);
Gate::policy(\Modules\ListingHero\Models\ListingHero::class, ListingHeroPolicy::class);
Gate::policy(\Modules\ListingAbout\Models\ListingAbout::class, ListingAboutPolicy::class);
Gate::policy(\Modules\ListingProducts\Models\ListingProduct::class, ListingProductPolicy::class);
Gate::policy(\Modules\ListingServices\Models\ListingService::class, ListingServicePolicy::class);
Gate::policy(\Modules\ListingAppointments\Models\ListingAppointment::class, ListingAppointmentPolicy::class);
// ... 30+ more
```

**Classification:**
- CORE policies (keep): User, ApiKey, WebhookEndpoint, SupportTicket, MediaFile, Payment, Subscription, Listing (BusinessPolicy), ListingModule
- MODULE policies (move to module ServiceProviders): All others

**Action Required:** Each module should register its own policies in its ServiceProvider.

---

## PROBLEM 2: LISTING MODEL — 32 RELATIONSHIPS

**File:** `Modules/Listings/app/Models/Listing.php`

**Current relationships (32 total):**

| Relationship | Type | Classification |
|-------------|------|----------------|
| user() | BelongsTo | CORE ✓ |
| locations() | HasMany | BASE ✓ |
| modules() | HasMany | CORE ✓ |
| products() | HasMany | SHARED - remove from Listing |
| productCategories() | HasMany | SHARED - remove from Listing |
| projects() | HasMany | VERTICAL - remove from Listing |
| projectCategories() | HasMany | VERTICAL - remove from Listing |
| services() | HasMany | SHARED - remove from Listing |
| leads() | HasMany | BASE - consider keeping |
| appointments() | HasMany | SHARED - remove from Listing |
| appointmentSlots() | HasMany | SHARED - remove from Listing |
| availability() | HasMany | SHARED - remove from Listing |
| availabilityExceptions() | HasMany | SHARED - remove from Listing |
| galleryImages() | HasMany | BASE - remove from Listing |
| galleries() | HasMany | BASE - remove from Listing |
| reviews() | HasMany | SHARED - remove from Listing |
| promotions() | HasMany | SHARED - remove from Listing |
| minisiteTheme() | BelongsTo | BASE/THEME - acceptable |
| hero() | HasOne | BASE - remove from Listing |
| about() | HasOne | BASE - remove from Listing |
| socialNetworks() | HasMany | BASE - remove from Listing |
| features() | HasMany | BASE - remove from Listing |
| listingFeatures() | HasMany | BASE - remove from Listing |
| faqs() | HasMany | BASE - remove from Listing |
| faqCategories() | HasMany | BASE - remove from Listing |
| seoSetting() | HasOne | BASE - remove from Listing |
| contactForms() | HasMany | BASE - remove from Listing |
| contactFormFields() | HasMany | BASE - remove from Listing |
| tasks() | HasMany | VERTICAL - remove from Listing |
| clients() | HasMany | VERTICAL - remove from Listing |
| teamMembers() | HasMany | VERTICAL - remove from Listing |
| teamMemberPositions() | HasMany | VERTICAL - remove from Listing |
| packages() | HasMany | SHARED - remove from Listing |

**CORE relationships (3):** user, locations, modules

**Relationships to remove from Listing (29):** All others should be accessed via direct queries from their respective modules.

---

## PROBLEM 3: forceDeleteWithRelations()

**File:** `Modules/Listings/app/Models/Listing.php:291-317`

```php
public function forceDeleteWithRelations(): void
{
    ListingLocation::where('listing_id', $this->id)->delete();
    ListingService::where('listing_id', $this->id)->delete();
    ListingAppointment::where('listing_id', $this->id)->delete();
    // ... 15 more direct references
}
```

**Issue:** Listing knows about 15+ module tables. This is reverse dependency (Core → Modules).

**Solution:**
1. Use FK ON DELETE CASCADE where possible
2. Emit ListingDeleted event
3. Modules listen and clean up their own data

---

## PROBLEM 4: syncAllModules() with ModuleDefinition

**File:** `Modules/Listings/app/Models/Listing.php:261-289`

```php
public function syncAllModules(): void
{
    $definitions = ModuleDefinition::where('is_active', true)->get();
    // ModuleDefinition is app/Models/ModuleDefinition - Core model
    // But $definitions comes from the MODULES system
}
```

**Issue:** ModuleDefinition is in app/Models (Core) but holds list of ALL modules including verticals.

**Classification:** ModuleDefinition should be moved to Modules/ListingModules/ or stay Core but only hold Core module definitions.

---

## PROBLEM 5: ROUTES — 641 route definitions

**File:** `routes/web.php` (641 routes)

**Module imports in routes/web.php:**
```
Modules\ListingAiChatbot\ (ai_chatbot.php, minisite_ai_chatbot.php)
Modules\Locations\ (admin LocationController)
Modules\ListingRestaurantMenu\ (menu categories, products, variants, images)
Modules\ListingProducts\ (ListingProductImageController)
Modules\ListingProjects\ (ListingProjectImageController)
Modules\ListingServices\ (ServiceImageController)
Modules\Properties\ (PropertyImageController)
Modules\ListingFeatures\ (FeatureController)
Modules\ListingTasks\ (TaskController)
Modules\ListingMinisite\ (ListingMinisiteController, ListingMinisiteSectionController)
Modules\ListingOfficeHours\ (ListingSchedule)
```

**Assessment:** Most routes are member-facing module routes. Core routes include:
- Auth routes (login, register, password reset)
- Public directory/business routes
- Member dashboard, account, billing
- Admin routes

---

## PROBLEM 6: CONTROLLERS IN app/Http/Controllers/

**Core Controllers (should stay):**
- Auth/* (all)
- Admin/DashboardController
- Admin/UserController (user management)
- Admin/RoleController, PermissionController
- Admin/System* (system health)
- Member/DashboardController, AccountController
- Member/BillingController, PlanSelectionController
- Member/OnboardingController
- Public/DirectoryController, BusinessController
- Wizard/BusinessController
- HealthController

**Module Controllers (should move):**
- Admin/ListingHeroController → ListingHero module
- Admin/ListingLeadsController → ListingLeads module
- Admin/ListingPromotionController → ListingPromotions module
- Admin/ListingReviewController → ListingReviews module
- Admin/ListingSocialNetworkController → ListingSocialMedia module
- Member/AboutController → ListingAbout module
- Member/HeroController → ListingHero module
- Member/GalleryController → ListingGallery module
- Member/ProductController → ListingProducts module
- Member/ServiceController → ListingServices module
- Member/AppointmentController → ListingAppointments module
- Member/LeadController → ListingLeads module
- Member/ReviewController → ListingReviews module
- Member/PromotionController → ListingPromotions module
- Member/SeoController → ListingSeo module
- Member/FaqController → ListingFaqs module
- Member/FeatureController → ListingFeatures module
- Member/PackageController → ListingPackages module
- Member/ClientController → ListingClients module
- Member/TeamMemberController → ListingTeamMembers module
- Member/TaskController → ListingTasks module
- Member/LocationController → ListingLocations module
- Member/ContactFormController → ListingContactForm module
- Member/BrandingController → ListingBranding module

---

## METRICS: BEFORE vs AFTER

### Core → Module References

| Metric | BEFORE | AFTER |
|--------|--------|-------|
| AppServiceProvider Gate::policy registrations for modules | 38 | 0 (move to module providers) |
| Listing model relationships to modules | 29 | 0 (remove non-Core) |
| forceDeleteWithRelations() module references | 15 | 0 (use CASCADE + events) |
| syncAllModules() ModuleDefinition coupling | 1 | 1 (acceptable) |

### Listing Relationships

| Metric | BEFORE | AFTER |
|--------|--------|-------|
| Total relationships | 32 | 3 (user, locations, modules) |
| Non-Core relationships | 29 | 0 |

### Routes

| Metric | Count |
|--------|-------|
| Total routes in web.php | 641 |
| Core routes | ~100 |
| Module routes | ~541 |

### Controllers

| Metric | Count |
|--------|-------|
| Controllers in app/Http/Controllers | ~80 |
| Core controllers | ~25 |
| Module controllers (should move) | ~55 |

---

## ACTION PLAN

### Phase 3a: AppServiceProvider Cleanup
1. Remove all Gate::policy for module models from AppServiceProvider
2. Each module's ServiceProvider should register its own policies
3. Keep only Core policies in AppServiceProvider

### Phase 3b: Listing Thinning
1. Remove 29 non-Core relationships from Listing
2. Create scopes in module models: `Product::forListing($id)`
3. Update all consumers to use `Product::forListing($listing->id)` instead of `$listing->products()`

### Phase 3c: forceDeleteWithRelations() Removal
1. Add FK ON DELETE CASCADE to module tables
2. Create ListingDeleted event
3. Modules register listeners for cleanup

### Phase 3d: Controller Organization
1. Identify which admin/member controllers serve Core vs Modules
2. Move module controllers to their respective modules
3. Keep only Core controllers in app/Http/Controllers/

### Phase 3e: Route Organization
1. Keep Core routes in routes/web.php
2. Move module routes to module route files
3. Use `require module_path('ModuleName', 'routes/web.php')`

---

## DEPENDENCY CYCLES DETECTED

**None currently detected.** Modules depend on Core (Listings), not vice versa.

---

## CORE BOOT TEST

**Test:** Disable all optional modules, keep only Listings, Auth, Billing

**Expected:** User can register, login, create listing, manage listing basics

**Result:** Should work with current architecture

---

## COMPOSITION TESTS

### Invitations-saas
```
Core + Themes + Media + ListingGuests + Leads + ContactForms
```
**Requires:** Properties? NO. RestaurantMenu? NO. Appointments? OPTIONAL.

### RealEstate-saas
```
Core + Themes + Media + Properties + Leads + ListingProjects
```
**Requires:** RestaurantMenu? NO. Appointments? OPTIONAL. VCards? NO.

### Restaurant-saas
```
Core + Themes + Media + RestaurantMenu + Products + Orders + Reviews
```
**Requires:** Properties? NO. VCards? NO. ListingProjects? NO.

---

## EXTRACTION READINESS

| Criterion | Status |
|-----------|--------|
| Core → Vertical = 0 | NOT MET (AppServiceProvider has 38 module policy refs) |
| Core → Shared = 0 | NOT MET (Listing has 15+ shared rels) |
| Core → Base = 0 | NOT MET (Listing has 10+ base rels) |
| Listing thin (3 rels) | NOT MET (has 32) |
| forceDeleteWithRelations removed | NOT MET |
| Core routes isolated | NOT MET |
| Controllers organized | NOT MET |

**Overall Status: NOT READY FOR PHASE 4**

**Estimated work:** 2-3 sessions to complete Phase 3 cleanup.
