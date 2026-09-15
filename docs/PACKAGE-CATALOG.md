# MiniWebs Package Catalog

**Project:** laravel-acerca
**Generated:** 2026-09-14
**Packages:** 22
**Modules:** 38
**Workspace:** `/desarrollo/server/laravel/laravel-acerca`

---

## Architecture Contract

MiniWebs packages are reusable backend capabilities.

A product installs only the capabilities it needs.

Installing a package makes the capability available to the product.

Per-Listing activation is a separate concern.

> **Composer package installed != capability enabled for every Listing.**

---

## Verified Portability (FASE 5)

```
Baseline:
  4 packages (crm, locations, media, minisite)
  14 runtime modules
  212 routes
  10/10 tests PASS

Install miniwebs/vcards:
  15 runtime modules
  283 routes (+71)
  26 package tables
  0 manual file changes
  composer require miniwebs/vcards: PASS

Remove miniwebs/vcards:
  14 runtime modules
  212 routes (exact baseline restored)
  10/10 tests PASS
  0 manual cleanup
  composer remove miniwebs/vcards: PASS
```

---

## Category Classification

| Category | Description |
|---|---|
| **CORE SUPPORT** | Infrastructure services (analytics, tracking) |
| **BASE** | Fundamental building blocks for any product (crm, locations, media, minisite) |
| **SHARED** | Utilities shared across multiple packages (shared) |
| **VERTICAL** | Business-type specific capabilities (restaurant, vcards, properties, client-fidelity) |
| **OPTIONAL** | Standalone capabilities that extend base functionality |
| **INFRASTRUCTURE** | Technical infrastructure (none at this time) |

---

## Package Details

---

### miniwebs/analytics

**Composer name:** `miniwebs/analytics`
**Purpose:** Analytics module for MiniWebs - Pageviews, events, and visitor tracking
**Category:** CORE SUPPORT

**Modules included:**
- Analytics

**Host requirements:**
- User: YES (via analytics_visitors)
- Listing: YES (analytics_settings, analytics_events, analytics_pageviews)
- permissions: NOT REQUIRED
- other: miniwebs/shared

**Composer dependencies:** miniwebs/shared

**Listing scoped:** YES

**Primary models:**
- AnalyticsEvent, AnalyticsPageview, AnalyticsSession, AnalyticsSetting, AnalyticsVisitor

**Database tables:** analytics_events, analytics_pageviews, analytics_sessions, analytics_settings, analytics_visitors

**Migrations:** YES (5)

**Routes:** NO

**Policies:** YES (AnalyticsSettingPolicy.php)

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (2 Vue files in package)

**Installation:**
```
composer require miniwebs/analytics
```

**Additional activation required:** NO

**Notes:**
- Core support package providing analytics infrastructure
- No routes in package - analytics data is likely recorded via API endpoints
- Depends on shared for geo-location utilities

---

### miniwebs/catalog

**Composer name:** `miniwebs/catalog`
**Purpose:** Catalog module for MiniWebs - Products and Services
**Category:** OPTIONAL

**Modules included:**
- ListingProducts, ListingServices

**Host requirements:**
- User: YES (via listing_products, listing_services)
- Listing: YES
- permissions: NOT REQUIRED
- other: miniwebs/locations

**Composer dependencies:** miniwebs/locations

**Listing scoped:** YES

**Primary models:**
- ListingProduct, ListingProductCategory, ListingProductImage
- ListingService, ListingServiceCategory, ListingServiceImage

**Database tables:** listing_products, listing_product_categories, listing_product_images, listing_services, listing_service_categories, listing_service_images

**Migrations:** YES (2)

**Routes:** YES

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (16 Vue files in package)

**Installation:**
```
composer require miniwebs/catalog
```

**Additional activation required:** NO

**Notes:**
- Provides product and service catalog management
- Used as dependency by listing-appointments
- Includes image management for products/services

---

### miniwebs/client-fidelity

**Composer name:** `miniwebs/client-fidelity`
**Purpose:** Client Fidelity module for MiniWebs - Loyalty cards and rewards management
**Category:** VERTICAL

**Modules included:**
- ClientFidelity

**Host requirements:**
- User: YES (via client_fidelity_cards)
- Listing: YES
- permissions: NOT REQUIRED
- other: (standalone)

**Composer dependencies:** (none)

**Listing scoped:** YES

**Primary models:**
- ClientFidelityCard, FidelityCardCompletion, FidelityReward

**Database tables:** client_fidelity_cards, fidelity_card_completions, fidelity_rewards

**Migrations:** YES (4)

**Routes:** YES

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (10 Vue files in package)

**Installation:**
```
composer require miniwebs/client-fidelity
```

**Additional activation required:** NO

**Notes:**
- Vertical-specific: loyalty/rewards program for businesses
- Standalone package with no miniwebs dependencies

---

### miniwebs/crm

**Composer name:** `miniwebs/crm`
**Purpose:** CRM module for MiniWebs - Leads and Clients
**Category:** BASE

**Modules included:**
- ListingClients, ListingContactForm, ListingLeads

**Host requirements:**
- User: YES (via listing_clients, listing_leads)
- Listing: YES
- permissions: NOT REQUIRED
- other: miniwebs/locations

**Composer dependencies:** miniwebs/locations

**Listing scoped:** YES

**Primary models:**
- ListingClient, ListingContactForm, ListingContactFormField, ListingLead

**Database tables:** listing_clients, listing_contact_forms, listing_contact_form_fields, listing_leads

**Migrations:** YES (3)

**Routes:** YES (ListingContactForm, ListingLeads)

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (17 Vue files in package)

**Installation:**
```
composer require miniwebs/crm
```

**Additional activation required:** NO

**Notes:**
- Base CRM capability: leads + clients + contact forms
- Required by minisite (minisite depends on crm)
- Core building block for any SaaS product

---

### miniwebs/guests

**Composer name:** `miniwebs/guests`
**Purpose:** Guests module for MiniWebs
**Category:** OPTIONAL

**Modules included:**
- ListingGuests

**Host requirements:**
- User: YES (via listing_guests)
- Listing: YES
- permissions: NOT REQUIRED
- other: (standalone)

**Composer dependencies:** (none)

**Listing scoped:** YES

**Primary models:**
- ListingGuest

**Database tables:** listing_guests

**Migrations:** YES (1)

**Routes:** YES

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (1 Vue file in package)

**Installation:**
```
composer require miniwebs/guests
```

**Additional activation required:** NO

**Notes:**
- Guest management for events
- Used as dependency by listing-checkin

---

### miniwebs/listing-ai-chatbot

**Composer name:** `miniwebs/listing-ai-chatbot`
**Purpose:** Listing AI Chatbot module for MiniWebs - AI-powered chatbot with RAG content indexing
**Category:** OPTIONAL

**Modules included:**
- ListingAiChatbot

**Host requirements:**
- User: YES (via chatbot_widgets, ai_conversations)
- Listing: YES
- permissions: NOT REQUIRED
- other: (standalone)

**Composer dependencies:** (none)

**Listing scoped:** YES

**Primary models:**
- AiContext, AiConversation, AiEmbedding, AiMessage, ChatbotAnalytics, ChatbotPersonality, ChatbotPreset, ChatbotTopQuestion, ChatbotWidgetAnalytics, ChatbotWidget, ListingAiSetting

**Database tables:** ai_contexts, ai_conversations, ai_embeddings, ai_messages, chatbot_analytics, chatbot_personalities, chatbot_presets, chatbot_top_questions, chatbot_widget_analytics, chatbot_widgets, listing_ai_settings

**Migrations:** YES (4)

**Routes:** NO

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (23 Vue files in package)

**Installation:**
```
composer require miniwebs/listing-ai-chatbot
```

**Additional activation required:** NO

**Notes:**
- AI chatbot with RAG content indexing
- No routes in package - may use API-based interaction
- Standalone with no miniwebs dependencies

---

### miniwebs/listing-appointments

**Composer name:** `miniwebs/listing-appointments`
**Purpose:** Listing Appointments module for MiniWebs - Appointment booking and scheduling
**Category:** OPTIONAL

**Modules included:**
- ListingAppointments

**Host requirements:**
- User: YES (via listing_appointments)
- Listing: YES
- permissions: NOT REQUIRED
- other: miniwebs/catalog, miniwebs/locations, miniwebs/packages

**Composer dependencies:** miniwebs/catalog, miniwebs/locations, miniwebs/packages

**Listing scoped:** YES

**Primary models:**
- ListingAppointment, ListingAppointmentSlot, ListingAvailabilityException, ListingAvailability

**Database tables:** listing_appointments, listing_appointment_slots, listing_availability, listing_availability_exceptions

**Migrations:** YES (1)

**Routes:** NO

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (13 Vue files in package)

**Installation:**
```
composer require miniwebs/listing-appointments
```

**Additional activation required:** NO

**Notes:**
- Appointment booking and scheduling
- Depends on catalog (for services), locations (for venue), packages (for pricing)
- Highest dependency count (3 miniwebs packages)

---

### miniwebs/listing-checkin

**Composer name:** `miniwebs/listing-checkin`
**Purpose:** Listing Checkin module for MiniWebs - Guest attendance tracking for events
**Category:** OPTIONAL

**Modules included:**
- ListingCheckin

**Host requirements:**
- User: YES (via listing_checkins)
- Listing: YES
- permissions: NOT REQUIRED
- other: miniwebs/guests

**Composer dependencies:** miniwebs/guests

**Listing scoped:** YES

**Primary models:**
- ListingCheckin

**Database tables:** listing_checkins

**Migrations:** YES (2)

**Routes:** YES

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (1 Vue file in package)

**Installation:**
```
composer require miniwebs/listing-checkin
```

**Additional activation required:** NO

**Notes:**
- Guest attendance tracking for events
- Depends on guests package for guest management

---

### miniwebs/listing-projects

**Composer name:** `miniwebs/listing-projects`
**Purpose:** Listing Projects module for MiniWebs - Project/portfolio management for businesses
**Category:** OPTIONAL

**Modules included:**
- ListingProjects

**Host requirements:**
- User: YES (via listing_projects)
- Listing: YES
- permissions: NOT REQUIRED
- other: (standalone)

**Composer dependencies:** (none)

**Listing scoped:** YES

**Primary models:**
- ListingProject, ListingProjectCategory, ListingProjectImage

**Database tables:** listing_projects, listing_project_categories, listing_project_images

**Migrations:** YES (4)

**Routes:** NO

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (4 Vue files in package)

**Installation:**
```
composer require miniwebs/listing-projects
```

**Additional activation required:** NO

**Notes:**
- Project/portfolio management
- Standalone with no miniwebs dependencies

---

### miniwebs/listing-tasks

**Composer name:** `miniwebs/listing-tasks`
**Purpose:** Listing Tasks module for MiniWebs - Task management for member businesses
**Category:** OPTIONAL

**Modules included:**
- ListingTasks

**Host requirements:**
- User: YES (via listing_tasks)
- Listing: YES
- permissions: NOT REQUIRED
- other: (standalone)

**Composer dependencies:** (none)

**Listing scoped:** YES

**Primary models:**
- ListingTask

**Database tables:** listing_tasks

**Migrations:** YES (1)

**Routes:** NO

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (1 Vue file in package)

**Installation:**
```
composer require miniwebs/listing-tasks
```

**Additional activation required:** NO

**Notes:**
- Task management for members
- Standalone with no miniwebs dependencies

---

### miniwebs/locations

**Composer name:** `miniwebs/locations`
**Purpose:** Locations module for MiniWebs - Geography catalog and listing locations
**Category:** BASE

**Modules included:**
- ListingLocations, Locations

**Host requirements:**
- User: YES (via listing_locations)
- Listing: YES (listing_locations) and INFRASTRUCTURE (countries, states, municipalities)
- permissions: NOT REQUIRED
- other: (standalone)

**Composer dependencies:** (none)

**Listing scoped:** YES (ListingLocations); INFRASTRUCTURE (Locations)

**Primary models:**
- ListingLocation
- Country, Municipality, State

**Database tables:** listing_locations, countries, states, municipalities, mx_municipalities, mx_states

**Migrations:** YES (7)

**Routes:** YES (ListingLocations)

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (9 Vue files in package)

**Installation:**
```
composer require miniwebs/locations
```

**Additional activation required:** NO

**Notes:**
- Base location capability with geo-data (countries, states, municipalities)
- Most depended-upon package (7 other packages depend on it)
- Locations (geo data) is infrastructure; ListingLocations is listing-scoped
- Used by: catalog, crm, listing-appointments, marketing, media, minisite, shared

---

### miniwebs/marketing

**Composer name:** `miniwebs/marketing`
**Purpose:** Promotions module for MiniWebs
**Category:** OPTIONAL

**Modules included:**
- ListingPromotions

**Host requirements:**
- User: YES (via listing_promotions)
- Listing: YES
- permissions: NOT REQUIRED
- other: miniwebs/locations

**Composer dependencies:** miniwebs/locations

**Listing scoped:** YES

**Primary models:**
- ListingPromotion, ListingPromotionImage

**Database tables:** listing_promotions, listing_promotion_images

**Migrations:** YES (1)

**Routes:** NO

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (6 Vue files in package)

**Installation:**
```
composer require miniwebs/marketing
```

**Additional activation required:** NO

**Notes:**
- Promotions/advertising management
- Depends on locations for venue/location data

---

### miniwebs/media

**Composer name:** `miniwebs/media`
**Purpose:** Media module for MiniWebs - Gallery and image management
**Category:** BASE

**Modules included:**
- ListingGallery

**Host requirements:**
- User: YES (via listing_gallery_images)
- Listing: YES
- permissions: NOT REQUIRED
- other: miniwebs/locations

**Composer dependencies:** miniwebs/locations

**Listing scoped:** YES

**Primary models:**
- ListingGallery, ListingGalleryImage

**Database tables:** listing_galleries, listing_gallery_images

**Migrations:** YES (4)

**Routes:** YES

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (8 Vue files in package)

**Installation:**
```
composer require miniwebs/media
```

**Additional activation required:** NO

**Notes:**
- Base media/gallery capability
- Required by minisite (minisite depends on media)
- Core building block for minisite presentation

---

### miniwebs/minisite

**Composer name:** `miniwebs/minisite`
**Purpose:** Minisite foundation module for MiniWebs - About, Branding, FAQs, Hero, SEO, Social Media, Features
**Category:** BASE

**Modules included:**
- ListingAbout, ListingBranding, ListingFaqs, ListingFeatures, ListingGallery, ListingHero, ListingMinisite, ListingOfficeHours, ListingReviews, ListingSeo, ListingSocialMedia, ListingTeamMembers

**Host requirements:**
- User: YES (via multiple modules)
- Listing: YES
- permissions: NOT REQUIRED
- other: miniwebs/crm, miniwebs/locations, miniwebs/media

**Composer dependencies:** miniwebs/crm, miniwebs/locations, miniwebs/media

**Listing scoped:** YES

**Primary models:**
- ListingAbout, ListingBrandingSetting, ListingFaq, ListingFaqCategory, Feature, FeatureCategory, ListingFeature, ListingHero, ListingMinisiteSection, ListingMinisiteSetting, ListingSeoSetting, ListingSocialNetwork

**Database tables:** listing_abouts, listing_branding_settings, listing_faqs, listing_faq_categories, listing_features, listing_featured_categories, listing_heroes, listing_minisite_sections, listing_minisite_settings, listing_seo_settings, listing_social_networks, listing_team_members, listing_team_member_positions

**Migrations:** YES (12)

**Routes:** YES (ListingFeatures)

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (41 Vue files in package - largest frontend)

**Installation:**
```
composer require miniwebs/minisite
```

**Additional activation required:** NO

**Notes:**
- Core minisite building block with most modules (12)
- Largest frontend presence (41 Vue files)
- Depends on crm, locations, and media - most coupled base package
- Used by: orders, properties, restaurant (vertical packages depend on it)

---

### miniwebs/orders

**Composer name:** `miniwebs/orders`
**Purpose:** Orders module for MiniWebs - Generic order management
**Category:** OPTIONAL

**Modules included:**
- Orders

**Host requirements:**
- User: YES (via orders)
- Listing: YES
- permissions: NOT REQUIRED
- other: miniwebs/minisite

**Composer dependencies:** miniwebs/minisite

**Listing scoped:** YES

**Primary models:**
- Order, OrderDeliveryAddress, OrderItem, OrderPickupLocation, OrderSetting

**Database tables:** orders, order_delivery_addresses, order_items, order_pickup_locations, order_settings

**Migrations:** YES (5)

**Routes:** YES

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (3 Vue files in package)

**Installation:**
```
composer require miniwebs/orders
```

**Additional activation required:** NO

**Notes:**
- Generic order management
- Depends on minisite for listing context

---

### miniwebs/packages

**Composer name:** `miniwebs/packages`
**Purpose:** Packages module for MiniWebs
**Category:** OPTIONAL

**Modules included:**
- ListingPackages

**Host requirements:**
- User: YES (via listing_packages)
- Listing: YES
- permissions: NOT REQUIRED
- other: (standalone)

**Composer dependencies:** (none)

**Listing scoped:** YES

**Primary models:**
- ListingPackage, PackageFeature

**Database tables:** listing_packages, listing_package_features

**Migrations:** YES (1)

**Routes:** NO

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (3 Vue files in package)

**Installation:**
```
composer require miniwebs/packages
```

**Additional activation required:** NO

**Notes:**
- Package/pricing plan management
- Used by listing-appointments for pricing
- Standalone with no miniwebs dependencies

---

### miniwebs/properties

**Composer name:** `miniwebs/properties`
**Purpose:** Properties module for MiniWebs - Real estate/v property management
**Category:** VERTICAL

**Modules included:**
- Properties

**Host requirements:**
- User: YES (via properties)
- Listing: YES
- permissions: NOT REQUIRED
- other: miniwebs/minisite

**Composer dependencies:** miniwebs/minisite

**Listing scoped:** YES

**Primary models:**
- GeneralField, GeneralFieldOption, GeneralFieldSection, GeneralFieldTypeAssignment, Property, PropertyAmenity, PropertyAmenityProperty, PropertyAmenityPropertyType, PropertyField, PropertyFieldSection, PropertyImage, PropertyType, PropertyTypeOption, PropertyValue

**Database tables:** properties, property_amenities, property_amenity_property, property_amenity_property_type, property_fields, property_field_sections, property_images, property_types, property_type_options, property_values, general_fields, general_field_sections, general_field_options, general_field_type_assignments

**Migrations:** YES (22 - largest migration count)

**Routes:** YES

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (3 Vue files in package)

**Installation:**
```
composer require miniwebs/properties
```

**Additional activation required:** NO

**Notes:**
- Vertical-specific: real estate / property management
- Most complex schema (22 migrations, 14 models)
- Depends on minisite for listing context

---

### miniwebs/restaurant

**Composer name:** `miniwebs/restaurant`
**Purpose:** Restaurant menu module for MiniWebs
**Category:** VERTICAL

**Modules included:**
- ListingRestaurantMenu

**Host requirements:**
- User: YES (via menu_products)
- Listing: YES
- permissions: NOT REQUIRED
- other: miniwebs/minisite

**Composer dependencies:** miniwebs/minisite

**Listing scoped:** YES

**Primary models:**
- MenuProduct, MenuProductImage, MenuProductVariant, MenuCategory, MenuCategoryImage (inferred from tables)

**Database tables:** menu_products, menu_product_images, menu_product_variants, menu_categories, menu_category_images

**Migrations:** YES (7)

**Routes:** YES

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (5 Vue files in package)

**Installation:**
```
composer require miniwebs/restaurant
```

**Additional activation required:** NO

**Notes:**
- Vertical-specific: restaurant menu management
- Includes product variants for menu items
- Depends on minisite for listing context

---

### miniwebs/reviews

**Composer name:** `miniwebs/reviews`
**Purpose:** Reviews module for MiniWebs
**Category:** OPTIONAL

**Modules included:**
- ListingReviews

**Host requirements:**
- User: YES (via listing_reviews)
- Listing: YES
- permissions: NOT REQUIRED
- other: (standalone)

**Composer dependencies:** (none)

**Listing scoped:** YES

**Primary models:**
- ListingReview

**Database tables:** listing_reviews

**Migrations:** YES (1)

**Routes:** NO

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (3 Vue files in package)

**Installation:**
```
composer require miniwebs/reviews
```

**Additional activation required:** NO

**Notes:**
- Review/rating management
- Standalone with no miniwebs dependencies

---

### miniwebs/shared

**Composer name:** `miniwebs/shared`
**Purpose:** Shared utilities for MiniWebs - Office Hours, GeoLocation
**Category:** SHARED

**Modules included:**
- ListingGeoLocation, ListingOfficeHours

**Host requirements:**
- User: NOT DIRECTLY
- Listing: YES (ListingOfficeHours)
- permissions: NOT REQUIRED
- other: miniwebs/locations

**Composer dependencies:** miniwebs/locations

**Listing scoped:** YES (ListingOfficeHours); INFRASTRUCTURE (ListingGeoLocation)

**Primary models:**
- ListingSchedule (ListingOfficeHours)

**Database tables:** (no migrations - uses existing infrastructure)

**Migrations:** NO

**Routes:** YES (ListingOfficeHours)

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (no Vue files)

**Installation:**
```
composer require miniwebs/shared
```

**Additional activation required:** NO

**Notes:**
- Provides shared utilities: GeoLocation, OfficeHours
- Depends on locations for geo-data infrastructure
- Used by: analytics, vcards

---

### miniwebs/team

**Composer name:** `miniwebs/team`
**Purpose:** Team Members module for MiniWebs
**Category:** OPTIONAL

**Modules included:**
- ListingTeamMembers

**Host requirements:**
- User: YES (via listing_team_members)
- Listing: YES
- permissions: NOT REQUIRED
- other: (standalone)

**Composer dependencies:** (none)

**Listing scoped:** YES

**Primary models:**
- ListingTeamMember, TeamMemberPosition

**Database tables:** listing_team_members, listing_team_member_positions

**Migrations:** YES (1)

**Routes:** NO

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** (none)

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (no Vue files in package - Note: TeamMember Vue pages are in minisite package)

**Installation:**
```
composer require miniwebs/team
```

**Additional activation required:** NO

**Notes:**
- Team member management
- Standalone with no miniwebs dependencies

---

### miniwebs/vcards

**Composer name:** `miniwebs/vcards`
**Purpose:** Digital business cards module for MiniWebs
**Category:** VERTICAL

**Modules included:**
- VCards

**Host requirements:**
- User: YES (via vcards)
- Listing: YES
- permissions: NOT REQUIRED
- other: miniwebs/shared

**Composer dependencies:** miniwebs/shared

**Listing scoped:** YES

**Primary models:**
- VCard, VCardBusinessHour, VCardContact, VCardField, VCardFieldType, VCardPackage, VCardSection, VCardSelectedFeature, VCardSelectedGallery, VCardSelectedLocation, VCardSelectedMenuCategory, VCardSelectedPackage, VCardSelectedProduct, VCardSelectedService, VCardSelectedTestimonial, VCardSeoSetting, VCardTeam, VCardVisit

**Database tables:** vcards, vcard_teams, vcard_contacts, vcard_fields, vcard_packages, vcard_sections, vcard_selected_features, vcard_selected_galleries, vcard_selected_location, vcard_selected_menu_categories, vcard_selected_packages, vcard_selected_products, vcard_selected_services, vcard_selected_testimonials, vcard_seo_settings, vcard_business_hours, vcard_visits

**Migrations:** YES (26)

**Routes:** YES

**Policies:** NO

**Services:** NO

**Jobs / Events:** NO

**Artisan commands:** CleanupVCardVisits

**Frontend required for backend operation:** NO

**Frontend status:** OPTIONAL (45 Vue files in package - second largest frontend)

**Installation:**
```
composer require miniwebs/vcards
```

**Additional activation required:** YES (php artisan module:enable VCards)

**Notes:**
- Vertical-specific: digital business cards (vCard)
- Second largest frontend (45 Vue files + 1 LESS file)
- 18 models - most complex package
- Depends on shared for office hours and geo-location
- CleanupVCardVisits command for maintenance

---

## Dependency Summary

```
PACKAGE               DEPENDS ON                         USED BY                   LISTING SCOPED  CATEGORY
analytics            shared                             (none)                    YES             CORE SUPPORT
catalog              locations                          listing-appointments       YES             OPTIONAL
client-fidelity      (none)                             (none)                    YES             VERTICAL
crm                  locations                          minisite                  YES             BASE
guests               (none)                             listing-checkin           YES             OPTIONAL
listing-ai-chatbot   (none)                             (none)                    YES             OPTIONAL
listing-appointments catalog,locations,packages          (none)                    YES             OPTIONAL
listing-checkin      guests                             (none)                    YES             OPTIONAL
listing-projects     (none)                             (none)                    YES             OPTIONAL
listing-tasks       (none)                             (none)                    YES             OPTIONAL
locations            (none)                             catalog,crm,listing-      YES             BASE
                                                                      appointments,
                                                                      marketing,media,
                                                                      minisite,shared
marketing            locations                          (none)                    YES             OPTIONAL
media                locations                          minisite                  YES             BASE
minisite             crm,locations,media                orders,properties,       YES             BASE
                                                                      restaurant
orders               minisite                           (none)                    YES             OPTIONAL
packages             (none)                             listing-appointments      YES             OPTIONAL
properties           minisite                           (none)                    YES             VERTICAL
restaurant           minisite                           (none)                    YES             VERTICAL
reviews              (none)                             (none)                    YES             OPTIONAL
shared               locations                          analytics,vcards           YES             SHARED
team                 (none)                             (none)                    YES             OPTIONAL
vcards               shared                             (none)                    YES             VERTICAL
```

---

## Installation Matrix

```
CAPABILITY                   COMPOSER PACKAGE              MODULE
CRM Clients                  miniwebs/crm                  ListingClients
CRM Contact Form             miniwebs/crm                  ListingContactForm
CRM Leads                    miniwebs/crm                  ListingLeads
Locations                    miniwebs/locations            ListingLocations
Geo Infrastructure           miniwebs/locations            Locations
Gallery                      miniwebs/media                ListingGallery
Minisite About               miniwebs/minisite             ListingAbout
Minisite Branding            miniwebs/minisite             ListingBranding
Minisite FAQs                miniwebs/minisite             ListingFaqs
Minisite Features            miniwebs/minisite             ListingFeatures
Minisite Hero                miniwebs/minisite             ListingHero
Minisite SEO                 miniwebs/minisite             ListingSeo
Minisite Social Media        miniwebs/minisite             ListingSocialMedia
Minisite Team Members        miniwebs/minisite             ListingTeamMembers
Analytics                    miniwebs/analytics            Analytics
Products                     miniwebs/catalog              ListingProducts
Services                     miniwebs/catalog              ListingServices
Client Loyalty               miniwebs/client-fidelity       ClientFidelity
Guests                       miniwebs/guests               ListingGuests
AI Chatbot                   miniwebs/listing-ai-chatbot   ListingAiChatbot
Appointments                 miniwebs/listing-appointments ListingAppointments
Check-in                     miniwebs/listing-checkin      ListingCheckin
Projects                     miniwebs/listing-projects     ListingProjects
Tasks                        miniwebs/listing-tasks        ListingTasks
Promotions                   miniwebs/marketing            ListingPromotions
Orders                       miniwebs/orders               Orders
Pricing Packages             miniwebs/packages             ListingPackages
Properties                   miniwebs/properties           Properties
Restaurant Menu              miniwebs/restaurant           ListingRestaurantMenu
Reviews                      miniwebs/reviews              ListingReviews
Office Hours                 miniwebs/shared               ListingOfficeHours
Team Members                 miniwebs/team                 ListingTeamMembers
Digital Business Cards       miniwebs/vcards               VCards
```

---

## Summary Statistics

| Metric | Value |
|---|---|
| Total packages | 22 |
| Total modules | 38 |
| Total database tables | 93 |
| Total migrations | 114 |
| Total Vue files in packages | 214 |
| Dependency edges | 17 |
| Standalone packages (no miniwebs deps) | 9 (client-fidelity, guests, listing-ai-chatbot, listing-projects, listing-tasks, locations, packages, reviews, team) |

---

## Unclassified Packages

**None** — All 22 packages have been classified.

| Category | Count |
|---|---|
| BASE | 4 (crm, locations, media, minisite) |
| VERTICAL | 4 (client-fidelity, properties, restaurant, vcards) |
| OPTIONAL | 12 (catalog, guests, listing-ai-chatbot, listing-appointments, listing-checkin, listing-projects, listing-tasks, marketing, orders, packages, reviews, team) |
| SHARED | 1 (shared) |
| CORE SUPPORT | 1 (analytics) |

---

## Architecture Changes During Documentation

**0**

No modifications made to any package, composer.json, providers, routes, or migrations during catalog creation.

---

*End of PACKAGE-CATALOG.md*
