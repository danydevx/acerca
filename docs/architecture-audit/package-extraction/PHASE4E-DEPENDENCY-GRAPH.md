# FASE 4E — DEPENDENCY GRAPH

## Critical Finding: The Listing Hub Problem

The **Listings** module (CORE) has direct Eloquent relationships to **28 different models** from other modules.

This creates a bidirectional dependency that makes extraction extremely complex.

## Dependency Direction

```
Everything → Listings → [ListingsAbout, ListingsAppointments, ListingsContactForm, ...]
                 ↓
           ALL OTHER MODULES
```

## Package → Local Dependencies (BLOCKERS)

| Package Module | Local Module Dependent | Type | Impact |
|----------------|----------------------|------|--------|
| ListingPackages | ListingAppointments | Service usage | BLOCKS Appointments |
| ListingPackages | ListingMinisite | Service usage | BLOCKS Minisite |
| ListingServices | ListingAppointments | Service usage | BLOCKS Appointments |
| ListingGuests | ListingCheckin | Model usage | BLOCKS Checkin |
| ListingLeads | ListingContactForm | Model usage | BLOCKS ContactForm |

## Local → Package Dependencies (BLOCKERS)

| Local Module | Package Module | Type | Impact |
|--------------|----------------|------|--------|
| ListingAppointments | ListingPackages | use | BLOCKS Appointments extraction |
| ListingAppointments | ListingServices | use | BLOCKS Appointments extraction |
| ListingMinisite | ListingPackages | use | BLOCKS Minisite extraction |
| ListingCheckin | ListingGuests | use | BLOCKS Checkin extraction |
| ListingContactForm | ListingLeads | use | BLOCKS ContactForm extraction |

## Listings Module Dependencies

### Listing Model Eloquent Relationships (28 total)

```php
// Self-contained
belongsTo(User::class)
hasMany(ListingLocation::class)
hasMany(ListingModule::class)

// From other LOCAL modules
hasMany(ListingAbout::class)
hasOne(ListingHero::class)
hasMany(ListingFaq::class)
hasMany(ListingFeature::class)
hasMany(ListingSeoSetting::class)
hasMany(ListingContactForm::class)
hasMany(ListingTask::class)
hasMany(ListingProject::class)

// From PACKAGES
hasMany(ListingProduct::class)           // miniwebs/catalog
hasMany(ListingProductCategory::class)  // miniwebs/catalog
hasMany(ListingService::class)           // miniwebs/catalog
hasMany(ListingLead::class)              // miniwebs/crm
hasMany(ListingReview::class)            // miniwebs/reviews
hasMany(ListingPromotion::class)        // miniwebs/marketing
hasMany(ListingPackage::class)           // miniwebs/packages
hasMany(ListingClient::class)            // miniwebs/crm
hasMany(ListingTeamMember::class)        // miniwebs/team
hasMany(ListingAppointment::class)       // local
hasMany(ListingAppointmentSlot::class)  // local
hasMany(ListingAvailability::class)     // local
hasMany(ListingAvailabilityException::class) // local
hasMany(ListingGalleryImage::class)      // local
hasMany(ListingSocialNetwork::class)     // local
```

## Circular Dependency Analysis

### Apparent Cycle
```
Listings → ListingProducts → Listings
Listings → ListingServices → Listings
Listings → ListingLeads → Listings
Listings → ListingReviews → Listings
Listings → ListingPromotions → Listings
Listings → ListingPackages → Listings
Listings → ListingGuests → Listings
Listings → ListingTeamMembers → Listings
```

### Resolution Strategy

The cycle exists because **Listings is the aggregate root**. In DDD terms:
- Listing is the "aggregate root"
- Other modules' models are "entities" within the Listing aggregate
- This is a DESIGN CHOICE, not a technical blocker

**To break this cycle for extraction:**
1. Option A: Keep Listings as part of the core platform (not extracted)
2. Option B: Refactor to use lazy loading / events / interfaces
3. Option C: Accept that Listings will be the last thing extracted

## Dependency Graph: Package Level

```
miniwebs/catalog
├── ListingProducts
│   └── depends on: Listings (local)
└── ListingServices
    └── depends on: Listings (local)

miniwebs/crm
├── ListingLeads
│   └── depends on: Listings (local)
└── ListingClients
    └── depends on: Listings (local)

miniwebs/marketing
└── ListingPromotions
    └── depends on: Listings (local)

miniwebs/packages
└── ListingPackages
    └── depends on: Listings (local)

miniwebs/reviews
└── ListingReviews
    └── depends on: Listings (local)

miniwebs/shared
└── ListingOfficeHours
    └── depends on: Listings (local)

miniwebs/team
└── ListingTeamMembers
    └── depends on: Listings (local)

miniwebs/guests
└── ListingGuests
    └── depends on: Listings (local)
```

## Local → Local Dependencies

| Module | Depends On | Type |
|--------|-----------|------|
| ListingMinisite | Properties | Service |
| VCards | ListingAiChatbot | Service |
| ListingGallery | ListingLocations | Model |
| ListingFeatures | ListingLocations | Model |

## Package-Level Circular Dependencies

```
package-level circular dependencies = 0
```

All extracted packages are self-contained and don't reference each other.
