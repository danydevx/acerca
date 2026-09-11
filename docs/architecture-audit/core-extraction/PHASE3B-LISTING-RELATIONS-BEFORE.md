# PHASE3B - LISTING RELATIONS INVENTORY (BEFORE)

## Summary
- **Total relationships in Listing.php**: 33
- **Core relationships**: 3 (user, modules, minisiteTheme)
- **BASE relationships**: 1 (locations)
- **VERTICAL relationships**: 29

---

## Complete Relation Inventory

| # | Relation | Model | Module | Classification | Removal Risk |
|---|----------|-------|--------|----------------|--------------|
| 1 | user() | User | Core | CORE | NONE |
| 2 | locations() | ListingLocation | ListingLocations | BASE | LOW |
| 3 | modules() | ListingModule | ListingModules | CORE | NONE |
| 4 | products() | ListingProduct | ListingProducts | VERTICAL | HIGH |
| 5 | productCategories() | ListingProductCategory | ListingProducts | VERTICAL | HIGH |
| 6 | projects() | ListingProject | ListingProjects | VERTICAL | HIGH |
| 7 | projectCategories() | ListingProjectCategory | ListingProjects | VERTICAL | HIGH |
| 8 | services() | ListingService | ListingServices | VERTICAL | HIGH |
| 9 | leads() | ListingLead | ListingLeads | VERTICAL | HIGH |
| 10 | appointments() | ListingAppointment | ListingAppointments | VERTICAL | HIGH |
| 11 | appointmentSlots() | ListingAppointmentSlot | ListingAppointments | VERTICAL | HIGH |
| 12 | availability() | ListingAvailability | ListingAppointments | VERTICAL | HIGH |
| 13 | availabilityExceptions() | ListingAvailabilityException | ListingAppointments | VERTICAL | HIGH |
| 14 | galleryImages() | ListingGalleryImage | ListingGallery | VERTICAL | HIGH |
| 15 | galleries() | ListingGallery | ListingGallery | VERTICAL | HIGH |
| 16 | reviews() | ListingReview | ListingReviews | VERTICAL | HIGH |
| 17 | promotions() | ListingPromotion | ListingPromotions | VERTICAL | HIGH |
| 18 | minisiteTheme() | MinisiteTheme | Core | CORE | NONE |
| 19 | hero() | ListingHero | ListingHero | VERTICAL | HIGH |
| 20 | about() | ListingAbout | ListingAbout | VERTICAL | HIGH |
| 21 | socialNetworks() | ListingSocialNetwork | ListingSocialMedia | VERTICAL | HIGH |
| 22 | features() | Feature | ListingFeatures | VERTICAL | HIGH |
| 23 | listingFeatures() | ListingFeature | ListingFeatures | VERTICAL | HIGH |
| 24 | faqs() | ListingFaq | ListingFaqs | VERTICAL | HIGH |
| 25 | faqCategories() | ListingFaqCategory | ListingFaqs | VERTICAL | HIGH |
| 26 | seoSetting() | ListingSeoSetting | ListingSeo | VERTICAL | HIGH |
| 27 | contactForms() | ListingContactForm | ListingContactForm | VERTICAL | HIGH |
| 28 | contactFormFields() | ListingContactFormField | ListingContactForm | VERTICAL | HIGH |
| 29 | tasks() | ListingTask | ListingTasks | VERTICAL | HIGH |
| 30 | clients() | ListingClient | ListingClients | VERTICAL | HIGH |
| 31 | teamMembers() | ListingTeamMember | ListingTeamMembers | VERTICAL | HIGH |
| 32 | teamMemberPositions() | TeamMemberPosition | ListingTeamMembers | VERTICAL | HIGH |
| 33 | packages() | ListingPackage | ListingPackages | VERTICAL | HIGH |

---

## Classification Criteria

### CORE
Relationships that Listing genuinely cannot exist without:
- `user()` - Every listing belongs to a user
- `modules()` - Module enablement is core functionality
- `minisiteTheme()` - Theme assignment is core

### BASE
Relationships that exist in the base Listing but may move to modules:
- `locations()` - May be needed by multiple vertical modules (RealEstate, Restaurant, etc.)

### VERTICAL
Relationships that belong to specific modules and should be extracted:
- All other 29 relationships

---

## Module Dependency Map

```
Listing (Core)
├── user() [CORE]
├── modules() [CORE]
├── minisiteTheme() [CORE]
├── locations() [BASE] → Used by RealEstate, Restaurant, etc.
├── products() [VERTICAL] → ListingProducts module
├── productCategories() [VERTICAL] → ListingProducts module
├── projects() [VERTICAL] → ListingProjects module
├── projectCategories() [VERTICAL] → ListingProjects module
├── services() [VERTICAL] → ListingServices module
├── leads() [VERTICAL] → ListingLeads module
├── appointments() [VERTICAL] → ListingAppointments module
├── appointmentSlots() [VERTICAL] → ListingAppointments module
├── availability() [VERTICAL] → ListingAppointments module
├── availabilityExceptions() [VERTICAL] → ListingAppointments module
├── galleryImages() [VERTICAL] → ListingGallery module
├── galleries() [VERTICAL] → ListingGallery module
├── reviews() [VERTICAL] → ListingReviews module
├── promotions() [VERTICAL] → ListingPromotions module
├── hero() [VERTICAL] → ListingHero module
├── about() [VERTICAL] → ListingAbout module
├── socialNetworks() [VERTICAL] → ListingSocialMedia module
├── features() [VERTICAL] → ListingFeatures module
├── listingFeatures() [VERTICAL] → ListingFeatures module
├── faqs() [VERTICAL] → ListingFaqs module
├── faqCategories() [VERTICAL] → ListingFaqs module
├── seoSetting() [VERTICAL] → ListingSeo module
├── contactForms() [VERTICAL] → ListingContactForm module
├── contactFormFields() [VERTICAL] → ListingContactForm module
├── tasks() [VERTICAL] → ListingTasks module
├── clients() [VERTICAL] → ListingClients module
├── teamMembers() [VERTICAL] → ListingTeamMembers module
├── teamMemberPositions() [VERTICAL] → ListingTeamMembers module
└── packages() [VERTICAL] → ListingPackages module
```

---

## Current Module Imports in Listing.php

```php
use Modules\ListingAbout\Models\ListingAbout;
use Modules\ListingAppointments\Models\ListingAppointment;
use Modules\ListingAppointments\Models\ListingAppointmentSlot;
use Modules\ListingAppointments\Models\ListingAvailability;
use Modules\ListingAppointments\Models\ListingAvailabilityException;
use Modules\ListingContactForm\Models\ListingContactForm;
use Modules\ListingContactForm\Models\ListingContactFormField;
use Modules\ListingFaqs\Models\ListingFaq;
use Modules\ListingFaqs\Models\ListingFaqCategory;
use Modules\ListingFeatures\Models\ListingFeature;
use Modules\ListingFeatures\Models\ListingListingFeature;
use Modules\ListingGallery\Models\ListingGalleryImage;
use Modules\ListingHero\Models\ListingHero;
use Modules\ListingLeads\Models\ListingLead;
use Modules\ListingLocations\Models\ListingLocation;
use Modules\ListingProducts\Models\ListingProduct;
use Modules\ListingProducts\Models\ListingProductCategory;
use Modules\ListingPromotions\Models\ListingPromotion;
use Modules\ListingReviews\Models\ListingReview;
use Modules\ListingSeo\Models\ListingSeoSetting;
use Modules\ListingServices\Models\ListingService;
```

**Total imports from modules: 22**

---

## Processing Order

1. **ListingProjects** - projects(), projectCategories()
2. **ListingGallery** - galleryImages(), galleries()
3. **ListingProducts** - products(), productCategories()
4. **ListingServices** - services()
5. **ListingLeads** - leads()
6. **ListingAppointments** - appointments(), appointmentSlots(), availability(), availabilityExceptions()
7. **ListingReviews** - reviews()
8. **ListingPromotions** - promotions()
9. **ListingPackages** - packages()
10. **ListingHero** - hero()
11. **ListingAbout** - about()
12. **ListingSocialMedia** - socialNetworks()
13. **ListingFeatures** - features(), listingFeatures()
14. **ListingFaqs** - faqs(), faqCategories()
15. **ListingSeo** - seoSetting()
16. **ListingContactForm** - contactForms(), contactFormFields()
17. **ListingTasks** - tasks()
18. **ListingClients** - clients()
19. **ListingTeamMembers** - teamMembers(), teamMemberPositions()
20. **ListingLocations** - locations() (review if BASE or VERTICAL)

---

## Metrics

| Metric | Value |
|--------|-------|
| Total relationships | 33 |
| Core relationships | 3 |
| BASE relationships | 1 |
| Vertical relationships | 29 |
| Module imports | 22 |
| Non-core hasMany relations | 29 |
| Non-core hasOne relations | 5 (hero, about, seoSetting) |