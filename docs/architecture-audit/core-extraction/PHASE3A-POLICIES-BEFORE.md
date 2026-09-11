# PHASE 3A — POLICIES INVENTORY (BEFORE)

**Date:** 2026-09-10
**Goal:** Document all policies in AppServiceProvider before migration

---

## GATE::POLICY IN AppServiceProvider (Lines 117-156)

| # | Model Class | Policy Class | Module | Status |
|---|------------|--------------|--------|--------|
| 1 | User | UserPolicy | CORE | KEEP |
| 2 | ApiKey | ApiKeyPolicy | CORE | KEEP |
| 3 | WebhookEndpoint | WebhookEndpointPolicy | CORE | KEEP |
| 4 | SupportTicket | SupportTicketPolicy | CORE | KEEP |
| 5 | MediaFile | MediaFilePolicy | CORE | KEEP |
| 6 | Payment | PaymentPolicy | CORE | KEEP |
| 7 | Subscription | SubscriptionPolicy | CORE | KEEP |
| 8 | Listing | BusinessPolicy | CORE | KEEP |
| 9 | ListingModule | ListingModulePolicy | CORE | KEEP |
| 10 | ListingLocation | ListingLocationPolicy | ListingLocations | MOVE |
| 11 | ListingSchedule | ListingSchedulePolicy | ListingOfficeHours | MOVE |
| 12 | ListingGalleryImage | ListingGalleryImagePolicy | ListingGallery | MOVE |
| 13 | ListingHero | ListingHeroPolicy | ListingHero | MOVE |
| 14 | ListingAbout | ListingAboutPolicy | ListingAbout | MOVE |
| 15 | ListingProduct | ListingProductPolicy | ListingProducts | MOVE |
| 16 | ListingProductCategory | ListingProductCategoryPolicy | ListingProducts | MOVE |
| 17 | ListingProject | ListingProjectPolicy | Properties | MOVE |
| 18 | ListingProjectCategory | ListingProjectCategoryPolicy | Properties | MOVE |
| 19 | ListingService | ListingServicePolicy | ListingServices | MOVE |
| 20 | ListingPromotion | ListingPromotionPolicy | ListingPromotions | MOVE |
| 21 | ListingLead | ListingLeadPolicy | ListingLeads | MOVE |
| 22 | ListingAppointment | ListingAppointmentPolicy | ListingAppointments | MOVE |
| 23 | ListingClient | ListingClientPolicy | ListingClients | MOVE |
| 24 | ListingGallery | ListingGalleryPolicy | ListingGallery | MOVE |
| 25 | ListingAppointmentSlot | ListingAppointmentSlotPolicy | ListingAppointments | MOVE |
| 26 | ListingAvailability | ListingAvailabilityPolicy | ListingAppointments | MOVE |
| 27 | ListingSocialNetwork | ListingSocialNetworkPolicy | ListingSocialMedia | MOVE |
| 28 | ListingReview | ListingReviewPolicy | ListingReviews | MOVE |
| 29 | ListingFaq | ListingFaqPolicy | ListingFaqs | MOVE |
| 30 | ListingFaqCategory | ListingFaqCategoryPolicy | ListingFaqs | MOVE |
| 31 | ListingFeature | ListingFeaturePolicy | ListingFeatures | MOVE |
| 32 | ListingSeoSetting | ListingSeoSettingPolicy | ListingSeo | MOVE |
| 33 | ListingBrandingSetting | ListingBrandingSettingPolicy | ListingBranding | MOVE |
| 34 | ListingTask | ListingTaskPolicy | ListingTasks | MOVE |
| 35 | ListingMinisiteSetting | ListingMinisitePolicy | ListingMinisite | MOVE |
| 36 | ListingMinisiteSection | ListingMinisitePolicy | ListingMinisite | MOVE |
| 37 | Listing | ListingMinisitePolicy | ListingMinisite | MOVE (DUPLICATE!) |
| 38 | ListingTeamMember | ListingTeamMemberPolicy | ListingTeamMembers | MOVE |
| 39 | TeamMemberPosition | ListingTeamMemberPolicy | ListingTeamMembers | MOVE |
| 40 | ListingPackage | ListingPackagePolicy | ListingPackages | MOVE |

**TOTAL: 40 Gate::policy registrations**
- CORE (keep): 9
- MODULE (move): 31

---

## ALREADY REGISTERED IN MODULE PROVIDERS

| Module | Policies | Status |
|--------|----------|--------|
| Properties | PropertyPolicy, PropertyTypePolicy | ✓ Already in PropertiesServiceProvider |
| VCards | VCardPolicy, VCardTeamPolicy, VCardSeoSettingPolicy, VCardPackagePolicy | ✓ Already in VCardsServiceProvider |
| Analytics | AnalyticsSettingPolicy | ✓ Already in AnalyticsServiceProvider |

---

## MODULES NEEDING POLICY REGISTRATION

| Module | Policies to Register |
|--------|---------------------|
| ListingGallery | ListingGalleryImagePolicy, ListingGalleryPolicy |
| ListingHero | ListingHeroPolicy |
| ListingAbout | ListingAboutPolicy |
| ListingProducts | ListingProductPolicy, ListingProductCategoryPolicy |
| ListingServices | ListingServicePolicy |
| ListingPromotions | ListingPromotionPolicy |
| ListingLeads | ListingLeadPolicy |
| ListingAppointments | ListingAppointmentPolicy, ListingAppointmentSlotPolicy, ListingAvailabilityPolicy |
| ListingClients | ListingClientPolicy |
| ListingSocialMedia | ListingSocialNetworkPolicy |
| ListingReviews | ListingReviewPolicy |
| ListingFaqs | ListingFaqPolicy, ListingFaqCategoryPolicy |
| ListingFeatures | ListingFeaturePolicy |
| ListingSeo | ListingSeoSettingPolicy |
| ListingBranding | ListingBrandingSettingPolicy |
| ListingTasks | ListingTaskPolicy |
| ListingMinisite | ListingMinisitePolicy |
| ListingTeamMembers | ListingTeamMemberPolicy |
| ListingPackages | ListingPackagePolicy |
| ListingLocations | ListingLocationPolicy |
| ListingOfficeHours | ListingSchedulePolicy |

---

## DUPLICATE/INCORRECT REGISTRATIONS

1. **Line 124 & 152**: `Listing` registered twice with different policies (BusinessPolicy and ListingMinisitePolicy)
   - Line 152 is incorrect - ListingMinisitePolicy is for ListingMinisite models, not Listing itself

2. **Line 153**: `ListingSchedule` registered (OK - it's module, but should be in module provider)

---

## IMPORT STATEMENTS TO REMOVE

```php
use App\Policies\ListingAboutPolicy;
use App\Policies\ListingAppointmentPolicy;
use App\Policies\ListingAppointmentSlotPolicy;
use App\Policies\ListingAvailabilityPolicy;
use App\Policies\ListingBrandingSettingPolicy;
use App\Policies\ListingClientPolicy;
use App\Policies\ListingFaqCategoryPolicy;
use App\Policies\ListingFaqPolicy;
use App\Policies\ListingFeaturePolicy;
use App\Policies\ListingGalleryImagePolicy;
use App\Policies\ListingGalleryPolicy;
use App\Policies\ListingHeroPolicy;
use App\Policies\ListingLeadPolicy;
use App\Policies\ListingLocationPolicy;
use App\Policies\ListingProductCategoryPolicy;
use App\Policies\ListingProductPolicy;
use App\Policies\ListingProjectPolicy;
use App\Policies\ListingProjectCategoryPolicy;
use App\Policies\ListingPromotionPolicy;
use App\Policies\ListingReviewPolicy;
use App\Policies\ListingSeoSettingPolicy;
use App\Policies\ListingServicePolicy;
use App\Policies\ListingSocialNetworkPolicy;
use App\Policies\ListingTeamMemberPolicy;
use App\Policies\ListingPackagePolicy;
use App\Policies\ListingTaskPolicy;
// Note: ListingMinisitePolicy is in Modules\ListingMinisite\Policies
```

---

## TARGET STATE

AppServiceProvider should only have:
- 9 CORE policy registrations
- 0 module policy registrations
