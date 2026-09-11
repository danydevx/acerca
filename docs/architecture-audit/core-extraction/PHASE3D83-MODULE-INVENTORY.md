# PHASE 3D.8.3 — MODULE INVENTORY

## Module Count
- **Total modules**: 35 (all enabled)
- **Modules with route files**: ~30
- **Modules without routes**: ListingTasks (routes in web.php), MinisiteThemes (stub)

## Module Structure Summary

| Module | module.json | Providers | RouteServiceProvider | Route Files |
|--------|-------------|-----------|---------------------|-------------|
| Analytics | ✓ | AnalyticsServiceProvider | ✗ | member.php, public.php |
| ClientFidelity | ✓ | ServiceProvider, RouteServiceProvider | ✓ (broken*) | api.php, web.php |
| ListingAbout | ✓ | ListingAboutServiceProvider, RouteServiceProvider | ✓ | member.php |
| ListingAiChatbot | ✓ | EventServiceProvider, ListingAiChatbotServiceProvider, RouteServiceProvider | ✓ | admin.php, member.php, public.php, widget.php |
| ListingAppointments | ✓ | EventServiceProvider, ListingAppointmentsServiceProvider, RouteServiceProvider | ✓ | admin.php, api.php, member.php |
| ListingBranding | ✓ | ListingBrandingServiceProvider, RouteServiceProvider | ✓ | member.php |
| ListingCheckin | ✓ | ListingCheckinServiceProvider, RouteServiceProvider | ✓ | web.php |
| ListingClients | ✓ | ListingClientsServiceProvider, RouteServiceProvider | ✓ | member.php |
| ListingContactForm | ✓ | EventServiceProvider, ListingContactFormServiceProvider, RouteServiceProvider | ✓ | admin.php, api.php, member.php, web.php |
| ListingFaqs | ✓ | ListingFaqsServiceProvider, RouteServiceProvider | ✓ | member.php |
| ListingFeatures | ✓ | EventServiceProvider, FeaturesServiceProvider, RouteServiceProvider | ✓ | api.php, member.php, public.php, web.php |
| ListingGallery | ✓ | EventServiceProvider, ListingGalleryServiceProvider, RouteServiceProvider | ✓ | api.php, member.php, web.php |
| ListingGuests | ✓ | ListingGuestsServiceProvider, RouteServiceProvider | ✓ | web.php |
| ListingHero | ✓ | ListingHeroServiceProvider, RouteServiceProvider | ✓ | admin.php, member.php |
| ListingLeads | ✓ | EventServiceProvider, ListingLeadsServiceProvider, RouteServiceProvider | ✓ | admin.php, api.php, member.php, web.php |
| ListingLocations | ✓ | EventServiceProvider, ListingLocationsServiceProvider, ListingLocationsRouteServiceProvider | ✓ | api.php, member.php, web.php |
| ListingMinisite | ✓ | ListingMinisiteServiceProvider (NO RouteServiceProvider) | ✗ | member.php, public.php |
| ListingModules | ✓ | EventServiceProvider, ListingModulesServiceProvider, RouteServiceProvider | ✓ | api.php, web.php |
| ListingOfficeHours | ✓ | ListingOfficeHoursServiceProvider, RouteServiceProvider | ✓ | web.php |
| ListingPackages | ✓ | ListingPackagesServiceProvider, RouteServiceProvider | ✓ | member.php |
| ListingProducts | ✓ | EventServiceProvider, ListingProductsServiceProvider, RouteServiceProvider | ✓ | api.php, member.php, web.php |
| ListingProjects | ✓ | ListingProjectsServiceProvider, RouteServiceProvider | ✓ | member.php |
| ListingPromotions | ✓ | ListingPromotionsServiceProvider, RouteServiceProvider | ✓ | admin.php, member.php, public.php |
| ListingRestaurantMenu | ✓ | RestaurantMenuServiceProvider (NO RouteServiceProvider) | ✗ | web.php |
| ListingReviews | ✓ | ListingReviewsServiceProvider, RouteServiceProvider | ✓ | admin.php, member.php |
| Listings | ✓ | EventServiceProvider, ListingsServiceProvider, RouteServiceProvider | ✓ | api.php, web.php |
| ListingSeo | ✓ | ListingSeoServiceProvider, RouteServiceProvider | ✓ | member.php |
| ListingServices | ✓ | EventServiceProvider, ListingServicesServiceProvider, RouteServiceProvider | ✓ | api.php, member.php, web.php |
| ListingSocialMedia | ✓ | ListingSocialMediaServiceProvider, RouteServiceProvider | ✓ | admin.php, member.php |
| ListingTasks | ✓ | ListingTasksServiceProvider | ✗ (no routes needed) | (no routes dir) |
| ListingTeamMembers | ✓ | ListingTeamMembersServiceProvider, RouteServiceProvider | ✓ | member.php |
| Locations | ✓ | LocationsServiceProvider (NO RouteServiceProvider) | ✗ | admin.php |
| MinisiteThemes | ✗ | ✗ | ✗ | ✗ (stub module) |
| Orders | ✓ | OrdersServiceProvider, RouteServiceProvider | ✓ | api.php, web.php |
| Properties | ✓ | PropertiesServiceProvider, RouteServiceProvider | ✓ | admin.php, api.php, member.php, web.php |
| VCards | ✓ | RouteServiceProvider, VCardsServiceProvider | ✓ | member.php, public.php, web.php |

## Note on RouteServiceProvider "broken" Assessment

*Earlier analysis incorrectly flagged modules where `boot()` doesn't call `$this->map()`. This is NOT a bug because Laravel's `RouteServiceProvider` base class automatically calls `map()` via the `loadRoutes()` method in `register()`.

## Real Issues Found

1. **MinisiteThemes** - Incomplete/stub module with no routes, providers, or module.json
2. **ListingMinisite** - Uses `loadRoutesFrom()` directly in ServiceProvider instead of RouteServiceProvider
3. **RestaurantMenu** - Routes loaded via web.php, no module RouteServiceProvider
4. **Locations** - Routes loaded via web.php (admin routes), no module RouteServiceProvider
5. **Shadow Routes** - Many modules have duplicate routes in web.php (see PHASE3D83-ORPHAN-ROUTE-FILES.md)
