# PHASE 4A — PRODUCT REPOSITORIES

## Three Proposed Products

---

## 1. miniwebs-saas

### Purpose
Default generic SaaS product for any business type.

### Installed Packages

```json
{
    "require": {
        "miniwebs/core": "^1.0",
        "miniwebs/minisite": "^1.0",
        "miniwebs/media": "^1.0",
        "miniwebs/locations": "^1.0",
        "miniwebs/crm": "^1.0",
        "miniwebs/catalog": "^1.0",
        "miniwebs/appointments": "^1.0",
        "miniwebs/guests": "^1.0",
        "miniwebs/packages": "^1.0",
        "miniwebs/marketing": "^1.0",
        "miniwebs/reviews": "^1.0",
        "miniwebs/team": "^1.0",
        "miniwebs/orders": "^1.0",
        "miniwebs/analytics": "^1.0",
        "miniwebs/ai-chatbot": "^1.0"
    }
}
```

### Business Types Supported
- Barber shops
- Beauty salons
- Dentists
- Medical clinics
- Spas
- Veterinarians
- Any generic business

### Routes
~963 routes (all modules)

### Notes
- Full-featured product
- Best for when you don't know the niche
- Can disable unwanted modules per listing

---

## 2. invitations-saas

### Purpose
Event management and digital invitations.

### Installed Packages

```json
{
    "require": {
        "miniwebs/core": "^1.0",
        "miniwebs/minisite": "^1.0",
        "miniwebs/media": "^1.0",
        "miniwebs/locations": "^1.0",
        "miniwebs/guests": "^1.0",
        "miniwebs/ai-chatbot": "^1.0"
    }
}
```

### Business Types Supported
- Event planners
- Wedding coordinators
- Party organizers
- Corporate events

### Modules Enabled by Default
- Listings
- ListingModules
- ListingMinisite
- ListingAbout (event info)
- ListingGallery (event photos)
- ListingHero
- ListingLocations (venue locations)
- ListingContactForm
- ListingGuests (RSVP management)
- ListingAiChatbot (event Q&A)

### Excluded
- Properties, VCards, Orders, Products, Services, Appointments, etc.

### Product-Specific Code
```php
// app/Http/Controllers/Public/EventController.php
// app/Models/Event.php
// app/Services/EventService.php
```

### Routes Estimate
~400 routes

---

## 3. realestate-saas

### Purpose
Real estate listings and property management.

### Installed Packages

```json
{
    "require": {
        "miniwebs/core": "^1.0",
        "miniwebs/minisite": "^1.0",
        "miniwebs/media": "^1.0",
        "miniwebs/locations": "^1.0",
        "miniwebs/crm": "^1.0",
        "miniwebs/properties": "^2.0",
        "miniwebs/ai-chatbot": "^1.0"
    }
}
```

### Business Types Supported
- Real estate agencies
- Property managers
- Independent realtors

### Modules Enabled by Default
- Listings
- ListingModules
- ListingMinisite
- ListingHero (property showcase)
- ListingGallery (property photos)
- ListingLocations (property locations)
- ListingAbout (agency info)
- ListingSeo
- Properties (property listings)
- ListingLeads (lead capture)
- ListingAiChatbot (property Q&A)

### Excluded
- Appointments, Orders, RestaurantMenu, etc.

### Product-Specific Code
```php
// app/Http/Controllers/Public/PropertySearchController.php
// app/Models/Property.php (extends Listing)
// app/Services/PropertySearchService.php
// app/Http/Requests/PropertySearchRequest.php
```

### Routes Estimate
~500 routes

---

## Product Composition

### Where does it live?

| Code Type | Location |
|-----------|----------|
| Product-specific controllers | `app/Http/Controllers/Product/` |
| Product-specific models | `app/Models/Product/` |
| Product-specific services | `app/Services/Product/` |
| Product-specific views | `resources/views/product/` |
| Product-specific routes | `routes/product.php` |
| Product-specific migrations | `database/migrations/product/` |
| Product-specific seeders | `database/seeders/Product/` |

### Example: invitations-saas structure

```
invitations-saas/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Member/
│   │       │   └── EventController.php
│   │       └── Public/
│   │           └── InvitationController.php
│   ├── Models/
│   │   └── Event.php
│   └── Services/
│       └── EventService.php
├── database/
│   ├── migrations/
│   │   └── 2026_09_11_create_events_table.php
│   └── seeders/
│       └── EventSeeder.php
├── resources/
│   └── views/
│       └── events/
│           ├── create.blade.php
│           └── show.blade.php
├── routes/
│   └── product.php
└── composer.json
```

---

## Cross-Product Shared Code

### Rule: If code is used by 2+ products, it should be in a package.

### Example: Lead capture

Both `invitations-saas` and `realestate-saas` need lead capture.
- `ListingLeads` is in `miniwebs/crm` package
- Both products require `miniwebs/crm`
- Lead capture code is shared, not duplicated

---

## Product vs Package Ownership

### Package Team
Owns and develops `miniwebs/*` packages.
- Core team
- Makes breaking changes
- Maintains versioning

### Product Team
Owns and deploys a specific product.
- Consumes `miniwebs/*` packages
- Can pin versions
- Can override/extend package code
- Owns product-specific features

### Conflict Resolution

If product needs a change in a package:
1. Product team creates issue/PR in package repo
2. Core team reviews and merges
3. Core team releases new version
4. Product team updates dependency

**No direct hacks in vendor/ - always upstream first.**

---

## CI/CD Per Product

Each product has its own pipeline:

```yaml
# .github/workflows/deploy.yml for invitations-saas
name: Deploy

on:
  push:
    branches: [main]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
          extensions: pdo_mysql, redis

      - name: Install Dependencies
        run: composer install --no-interaction

      - name: Run Tests
        run: php artisan test

      - name: Build Frontend
        run: npm install && npm run build

      - name: Deploy
        run: ./deploy.sh
```

---

## Environment Isolation

Each product has:
- Own `.env` file
- Own database
- Own domain
- Own Redis queue
- Own storage bucket

```bash
# invitations-saas/.env
APP_NAME="Invitations SaaS"
DB_DATABASE=invitations_saas
DOMAIN=invitations.miniwebs.dev

# realestate-saas/.env
APP_NAME="Real Estate SaaS"
DB_DATABASE=realestate_saas
DOMAIN=realestate.miniwebs.dev
```
