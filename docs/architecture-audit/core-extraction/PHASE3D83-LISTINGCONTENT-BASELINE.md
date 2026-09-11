# PHASE 3D.8.3 — LISTINGCONTENTCONTROLLER BASELINE

## Controller Location
```
app/Http/Controllers/Admin/ListingContentController.php
```

## Classification
**LEGACY_AGGREGATOR** - Serves multiple module features from a single controller

## Route Count (Exact)
```
ListingContentController routes: 56
```

## Route Breakdown by Feature

### Appointments (8 routes)
```
GET|HEAD     admin/listings/{listing}/appointments
POST         admin/listings/{listing}/appointments
GET|HEAD     admin/listings/{listing}/appointments/create
GET|HEAD     admin/listings/{listing}/appointments/{appointment}
PUT          admin/listings/{listing}/appointments/{appointment}
DELETE       admin/listings/{listing}/appointments/{appointment}
POST         admin/listings/{listing}/appointments/{appointment}/cancel
GET|HEAD     admin/listings/{listing}/appointments/{appointment}/edit
```

### FAQ Categories (4 routes)
```
GET|HEAD     admin/listings/{listing}/faq-categories
POST         admin/listings/{listing}/faq-categories
PUT          admin/listings/{listing}/faq-categories/{category}
DELETE       admin/listings/{listing}/faq-categories/{category}
```

### FAQs (6 routes)
```
GET|HEAD     admin/listings/{listing}/faqs
POST         admin/listings/{listing}/faqs
GET|HEAD     admin/listings/{listing}/faqs/create
PUT          admin/listings/{listing}/faqs/{faq}
DELETE       admin/listings/{listing}/faqs/{faq}
GET|HEAD     admin/listings/{listing}/faqs/{faq}/edit
```

### Galleries (10 routes)
```
GET|HEAD     admin/listings/{listing}/galleries
POST         admin/listings/{listing}/galleries
GET|HEAD     admin/listings/{listing}/galleries/create
PUT          admin/listings/{listing}/galleries/{gallery}
DELETE       admin/listings/{listing}/galleries/{gallery}
GET|HEAD     admin/listings/{listing}/galleries/{gallery}/edit
POST         admin/listings/{listing}/galleries/{gallery}/set-primary
GET|HEAD     admin/listings/{listing}/gallery
POST         admin/listings/{listing}/gallery
GET|HEAD     admin/listings/{listing}/gallery/{gallery}
PUT          admin/listings/{listing}/gallery/{image}
DELETE       admin/listings/{listing}/gallery/{image}
```

### Locations (7 routes)
```
GET|HEAD     admin/listings/{listing}/locations
POST         admin/listings/{listing}/locations
GET|HEAD     admin/listings/{listing}/locations/create
PUT          admin/listings/{listing}/locations/{location}
DELETE       admin/listings/{listing}/locations/{location}
GET|HEAD     admin/listings/{listing}/locations/{location}/edit
```

### Product Categories (4 routes)
```
GET|HEAD     admin/listings/{listing}/product-categories
POST         admin/listings/{listing}/product-categories
PUT          admin/listings/{listing}/product-categories/{category}
DELETE       admin/listings/{listing}/product-categories/{category}
```

### Products (7 routes)
```
GET|HEAD     admin/listings/{listing}/products
POST         admin/listings/{listing}/products
GET|HEAD     admin/listings/{listing}/products/create
PUT          admin/listings/{listing}/products/{product}
DELETE       admin/listings/{listing}/products/{product}
GET|HEAD     admin/listings/{listing}/products/{product}/edit
```

### Service Categories (4 routes)
```
GET|HEAD     admin/listings/{listing}/service-categories
POST         admin/listings/{listing}/service-categories
PUT          admin/listings/{listing}/service-categories/{category}
DELETE       admin/listings/{listing}/service-categories/{category}
```

### Services (6 routes)
```
GET|HEAD     admin/listings/{listing}/services
POST         admin/listings/{listing}/services
GET|HEAD     admin/listings/{listing}/services/create
PUT          admin/listings/{listing}/services/{service}
DELETE       admin/listings/{listing}/services/{service}
GET|HEAD     admin/listings/{listing}/services/{service}/edit
```

## Notes

- This controller is NOT scoped for this phase - it is a LEGACY_AGGREGATOR
- It serves as the Admin interface for multiple business features:
  - Appointments
  - FAQs and FAQ Categories
  - Galleries
  - Locations
  - Product Categories
  - Products
  - Service Categories
  - Services
- Each of these features also has corresponding modules with their own controllers
- This controller serves as a unified Admin interface (likely historical/legacy pattern)
- FASE 3D.9 should address whether to keep this as an aggregator or migrate each feature to its module
