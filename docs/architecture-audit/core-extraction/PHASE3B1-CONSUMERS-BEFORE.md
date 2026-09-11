# PHASE3B.1 - CONSUMERS INVENTORY (BEFORE)

## Summary
This document catalogs all consumers of the 29 removed Listing relationships.

---

## INVALID LISTING CONSUMERS (need to be fixed)

### Public Controllers

#### app/Http/Controllers/Public/BusinessController.php
| Line | Relation | Issue |
|------|----------|-------|
| 61 | services() | Query for active services |
| 81 | galleryImages() | Count check |
| 92 | reviews() | Query for reviews |
| 101 | promotions() | Query for promotions |
| 117 | products() | Product listing |
| 126 | packages() | Package listing |
| 181 | socialNetworks() | Social networks query |
| 312 | services() | Services listing |
| 322 | socialNetworks() | Social networks with filters |
| 358 | galleryImages() | Gallery images |
| 367 | socialNetworks() | Social networks with filters |
| 403 | products() | Product listing |
| 412 | socialNetworks() | Social networks with filters |
| 452 | services() | Services listing |
| 583 | socialNetworks() | Social networks with filters |
| 681 | contactForms() | Contact form by shortcode |
| 700 | socialNetworks() | Social networks with filters |
| 745 | contactForms() | Contact form by shortcode |
| 835 | socialNetworks() | Social networks with filters |

#### app/Http/Controllers/Public/DirectoryController.php
| Line | Relation | Issue |
|------|----------|-------|
| 169 | services() | Services query |
| 175 | galleryImages() | Gallery images query |
| 184 | reviews() | Reviews query |
| 190 | reviews() | Avg rating calculation |

#### app/Http/Controllers/Public/BookingWidgetController.php
| Line | Relation | Issue |
|------|----------|-------|
| 44 | services() | Services for booking |

---

### API Controllers

#### app/Http/Controllers/Api/V1/Admin/BusinessController.php
| Line | Relation | Issue |
|------|----------|-------|
| 80 | galleryImages() | Count |
| 82 | services() | Count |
| 83 | products() | Count |
| 84 | reviews() | Count |
| 85 | leads() | Count |

#### app/Http/Controllers/Admin/ApiExplorerController.php
| Line | Relation | Issue |
|------|----------|-------|
| 163 | galleryImages() | Count |
| 165 | services() | Count |
| 166 | products() | Count |
| 167 | reviews() | Count |
| 168 | leads() | Count |

---

### Member Controllers

#### app/Http/Controllers/Member/ProductCategoryController.php
| Line | Relation | Issue |
|------|----------|-------|
| 41 | products()->count() | Count in category |
| 132 | products()->update() | Update on delete |

#### app/Http/Controllers/Member/ServiceCategoryController.php
| Line | Relation | Issue |
|------|----------|-------|
| 39 | services()->count() | Count in category |
| 111 | services()->update() | Update on delete |

#### app/Http/Controllers/Member/FaqCategoryController.php
| Line | Relation | Issue |
|------|----------|-------|
| 39 | faqs()->count() | Count in category |
| 111 | faqs()->update() | Update on delete |

#### app/Http/Controllers/Member/ReviewController.php
| Line | Relation | Issue |
|------|----------|-------|
| 29 | reviews() | Query |
| 106 | reviews()->create() | Create |
| 231 | reviews() | Bulk delete |
| 247 | reviews()->max() | Max sort order |
| 249 | reviews()->create() | Clone |

#### app/Http/Controllers/Member/PromotionController.php
| Line | Relation | Issue |
|------|----------|-------|
| 30 | promotions() | Query |
| 124 | promotions()->create() | Create |
| 334 | promotions()->max() | Max sort order |
| 336 | promotions()->create() | Clone |

#### app/Http/Controllers/Member/PackageController.php
| Line | Relation | Issue |
|------|----------|-------|
| 31 | packages() | Query |
| 237 | features()->delete() | Delete package features |
| 270 | features()->delete() | Delete package features |
| 303 | features()->delete() | Delete package features |
| 349 | packages()->max() | Max sort order |
| 351 | packages()->create() | Clone |
| 365 | features()->create() | Clone features |

#### app/Http/Controllers/Member/ContactFormController.php
| Line | Relation | Issue |
|------|----------|-------|
| 30 | contactForms() | Query |
| 85 | contactForms() | Query |
| 118 | contactForms()->count() | Count |
| 137 | contactForms()->count() | Count |
| 152 | contactForms()->create() | Create |
| 155 | contactForms()->where()->update() | Deactivate others |
| 223 | contactForms()->where()->update() | Deactivate others |

#### app/Http/Controllers/Member/SeoController.php
| Line | Relation | Issue |
|------|----------|-------|
| 79 | seoSetting()->updateOrCreate() | Update or create |

#### app/Http/Controllers/Member/SocialNetworkController.php
| Line | Relation | Issue |
|------|----------|-------|
| 29 | socialNetworks() | Query |

#### app/Http/Controllers/Member/TaskController.php
| Line | Relation | Issue |
|------|----------|-------|
| 17 | tasks() | Query |
| 31 | tasks() | Completed tasks |
| 65 | tasks()->max() | Max sort order |
| 78 | tasks()->create() | Create |
| 97 | tasks()->max() | Max sort order by status |

#### app/Http/Controllers/Member/ClientController.php
| Line | Relation | Issue |
|------|----------|-------|
| 29 | clients() | Query |
| 115 | clients()->create() | Create |
| 245 | clients()->create() | Clone |

#### app/Http/Controllers/Member/TeamMemberController.php
| Line | Relation | Issue |
|------|----------|-------|
| 32 | teamMembers() | Query |

#### app/Http/Controllers/Member/TeamMemberPositionController.php
| Line | Relation | Issue |
|------|----------|-------|
| 56 | teamMembers()->count() | Count |
| 230 | teamMembers()->exists() | Exists check |

#### app/Http/Controllers/Member/AvailabilityController.php
| Line | Relation | Issue |
|------|----------|-------|
| 20 | availability() | Query |
| 39 | availabilityExceptions() | Query |
| 54 | appointments() | Appointment counts |

---

### Admin Controllers

#### app/Http/Controllers/Admin/ListingReviewController.php
| Line | Relation | Issue |
|------|----------|-------|
| 16 | reviews() | Query |
| 56 | reviews()->create() | Create |

#### app/Http/Controllers/Admin/ListingPromotionController.php
| Line | Relation | Issue |
|------|----------|-------|
| 16 | promotions() | Query |
| 65 | promotions()->create() | Create |

#### app/Http/Controllers/Admin/SlotController.php
| Line | Relation | Issue |
|------|----------|-------|
| 18 | appointmentSlots() | Query |
| 24 | services() | Services for slot |
| 61 | appointmentSlots()->create() | Create |

#### app/Http/Controllers/Admin/ListingServicesController.php
| Line | Relation | Issue |
|------|----------|-------|
| 16 | services() | Query |

#### app/Http/Controllers/Admin/ListingContentController.php
| Line | Relation | Issue |
|------|----------|-------|
| 356 | faqs() | Query |
| 526 | faqs()->update() | Update on delete |
| 590 | products()->update() | Update on delete |
| 654 | services()->update() | Update on delete |
| 1140 | appointments() | Query |
| 1203 | appointments()->create() | Create |

#### app/Http/Controllers/Admin/ListingContactFormController.php
| Line | Relation | Issue |
|------|----------|-------|
| 14 | leads() | Query |

---

### Seeders

#### database/seeders/LavanderiaManolosSeeder.php
| Line | Relation | Issue |
|------|----------|-------|
| 162 | services()->count() | Info output |
| 163 | products()->count() | Info output |
| 164 | galleryImages()->count() | Info output |

#### database/seeders/LavanderiaManolosExtraSeeder.php
| Line | Relation | Issue |
|------|----------|-------|
| 23 | about() | Seeder method |
| 24 | socialNetworks() | Seeder method |
| 25 | features() | Seeder method |
| 26 | promotions() | Seeder method |
| 27 | reviews() | Seeder method |

#### database/seeders/BusinessTestSeeder.php
| Line | Relation | Issue |
|------|----------|-------|
| 242 | services()->first() | Get first service |
| 259 | services()->skip(1)->first() | Get second service |
| 268-270 | services()->where() | Get specific services |
| 459 | products()->count() | Info output |
| 460 | leads()->count() | Info output |
| 461 | appointments()->count() | Info output |
| 462 | appointmentSlots()->count() | Info output |
| 463 | reviews()->count() | Info output |

---

### Services

#### app/Services/AvailabilityService.php
| Line | Relation | Issue |
|------|----------|-------|
| 17 | availabilityExceptions() | Query |
| 26 | availability() | Query |
| 41 | availabilityExceptions() | Query |
| 56 | availability() | Query |
| 100 | availabilityExceptions() | Query |
| 108 | availability() | Query |
| 116 | appointments() | Overlapping count |
| 152 | availabilityExceptions() | Query |
| 162 | availability() | Query |
| 178 | appointments() | Existing appointments |
| 211 | appointments() | Return appointments |

---

### Minisite Controllers

#### Modules/ListingMinisite/app/Http/Controllers/Member/ListingMinisiteSectionController.php
| Line | Relation | Issue |
|------|----------|-------|
| 320 | services() | Query |
| 351 | galleryImages() | Query |
| 378 | promotions() | Query |
| 411 | contactForms() | Query |
| 472 | features() | Query |
| 494 | faqs() | Query |
| 521 | products() | Query |

#### Modules/ListingMinisite/app/Http/Controllers/Public/ListingMinisiteController.php
| Line | Relation | Issue |
|------|----------|-------|
| 104 | socialNetworks() | Query |
| 167 | productCategories() | Query |
| 176 | socialNetworks() | Query |
| 256 | socialNetworks() | Query |
| 331 | products() | Single product |
| 365 | products() | Related products |
| 386 | socialNetworks() | Query |
| 458 | services() | Single service |
| 492 | socialNetworks() | Query |
| 568 | promotions() | Single promotion |
| 588 | promotions() | Related promotions |
| 614 | socialNetworks() | Query |
| 849 | socialNetworks() | Query |
| 927 | socialNetworks() | Query |
| 974 | services() | Active check |
| 977 | products() | Active check |
| 980 | galleryImages() | Active check |
| 983 | appointments() | Exists check |
| 986 | availability() | Exists check |
| 989 | promotions() | Active check |
| 995 | reviews() | Active check |
| 998 | faqs() | Active check |
| 1001 | contactForms() | Active check |
| 1016 | services() | Query |
| 1079 | galleryImages() | Query |
| 1106 | promotions() | Query |
| 1139 | contactForms() | Contact form |
| 1186 | availability() | Available days |
| 1200 | availability() | Schedule |
| 1215 | availabilityExceptions() | Exceptions |
| 1369 | features() | Query |
| 1391 | faqs() | Query |
| 1417 | products() | Query |
| 1476 | reviews() | Query |
| 1613 | packages() | Query |

---

### Restaurant Menu Module

#### Modules/ListingRestaurantMenu/app/Entities/MenuCategory.php
| Line | Relation | Issue |
|------|----------|-------|
| 93 | products() | Active products (internal relation) |

#### Modules/ListingRestaurantMenu/app/Http/Controllers/Member/MenuCategoryController.php
| Line | Relation | Issue |
|------|----------|-------|
| 116 | products()->update() | Update on delete |

#### Modules/ListingRestaurantMenu/app/Http/Controllers/Admin/MenuCategoryController.php
| Line | Relation | Issue |
|------|----------|-------|
| 111 | products()->update() | Update on delete |

---

### VCards Module

#### Modules/VCards/app/Http/Controllers/Member/VCardSeoController.php
| Line | Relation | Issue |
|------|----------|-------|
| 106 | seoSetting()->updateOrCreate() | VCard seo setting |

---

## VALID MODULE RELATIONS (NOT INVALID)

These are internal module relations that should NOT be changed:

- `ListingProductCategory::products()` - Valid (Category → Product)
- `ListingServiceCategory::services()` - Valid (Category → Service)
- `ListingFaqCategory::faqs()` - Valid (Category → Faq)
- `ListingPackage::features()` - Valid (Package → Feature)
- `ListingTeamMemberPosition::teamMembers()` - Valid (Position → Member)
- `ListingAvailability::exceptions()` - Valid (Availability → Exception)

---

## SUMMARY

| Category | Count |
|----------|-------|
| Public Controllers | 25 |
| API Controllers | 10 |
| Member Controllers | 46 |
| Admin Controllers | 16 |
| Seeders | 16 |
| Services | 12 |
| Minisite Controllers | 44 |
| Restaurant Menu | 3 |
| VCards | 1 |
| **TOTAL INVALID** | **173** |

---

## NOTES

1. The `about()`, `socialNetworks()`, `features()`, `promotions()`, `reviews()` in LavanderiaManolosExtraSeeder are likely methods being called on the seeder itself, not on Listing. Need to verify.

2. Some relations like `products()` on `MenuCategory` in RestaurantMenu are internal module relations and should use the module's own query.

3. `VCardSeoController` uses `seoSetting()` on a VCard model, not on Listing - need to verify if this is valid or not.