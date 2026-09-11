# PHASE 4A — GIT STRATEGY

## Proposed Repositories

### Core Packages (6 repositories)

| Repository | Contains |
|------------|----------|
| `miniwebs/core` | Listings, ListingModules, ListingMinisite |
| `miniwebs/minisite` | About, Branding, ContactForm, Faqs, Hero, Seo, SocialMedia |
| `miniwebs/media` | Gallery |
| `miniwebs/locations` | Locations, ListingLocations |
| `miniwebs/crm` | Leads, Clients |
| `miniwebs/catalog` | Products, Services |

### Shared Domain Packages (8 repositories)

| Repository | Contains |
|------------|----------|
| `miniwebs/appointments` | Appointments |
| `miniwebs/guests` | Guests |
| `miniwebs/packages` | Packages |
| `miniwebs/marketing` | Promotions |
| `miniwebs/reviews` | Reviews |
| `miniwebs/team` | TeamMembers |
| `miniwebs/shared` | OfficeHours |
| `miniwebs/orders` | Orders |

### Vertical Packages (6 repositories)

| Repository | Contains |
|------------|----------|
| `miniwebs/properties` | Properties |
| `miniwebs/vcards` | VCards |
| `miniwebs/restaurant` | RestaurantMenu |
| `miniwebs/fidelity` | ClientFidelity |
| `miniwebs/projects` | ListingProjects |
| `miniwebs/analytics` | Analytics |

### Optional Packages (5 repositories)

| Repository | Contains |
|------------|----------|
| `miniwebs/ai-chatbot` | AiChatbot |
| `miniwebs/checkin` | Checkin |
| `miniwebs/features` | Features |
| `miniwebs/tasks` | Tasks |

### Total: 25 package repositories

Plus 3 product repositories (see below).

---

## Why 25 and not 35?

Grouping reduces repositories while maintaining cohesion:

- `miniwebs/minisite` groups 7 modules with high cohesion (all render minisite sections)
- `miniwebs/crm` groups Leads + Clients (both CRM functions)
- `miniwebs/catalog` groups Products + Services (both catalog functions)
- `miniwebs/locations` groups Locations + ListingLocations (both location functions)

This balances:
- Too many repos (35 = unmaintainable)
- Too few repos (1 = monolithic)
- Domain-driven boundaries

---

## Product Repositories

| Repository | Purpose |
|------------|---------|
| `miniwebs-saas` | Default SaaS product (all packages) |
| `invitations-saas` | Event/invitation focused product |
| `realestate-saas` | Real estate focused product |

### Product Repository Structure

```text
miniwebs-saas/
├── composer.json
├── app/
│   ├── Http/
│   ├── Models/
│   └── Providers/
├── config/
├── database/
│   ├── migrations/  (product-specific)
│   └── seeders/     (product-specific)
├── resources/
│   ├── js/
│   └── views/
├── routes/
├── package.json
├── vite.config.js
└── .env.example
```

Each product:
- Owns its own `app/` (controllers, models specific to product)
- Installs `miniwebs/*` packages via Composer
- Has its own CI/CD
- Has its own domain/database

---

## Private Package Repositories

### Option 1: GitHub Private Repositories + VCS

```json
// composer.json in product
{
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:danydevx/miniwebs-core.git"
        }
    ],
    "require": {
        "miniwebs/core": "1.0.0"
    }
}
```

**Pros**: Free for small teams (GitHub free tier has unlimited private repos)
**Cons**: Composer caches credentials, VCS can be slow for large repos

### Option 2: Private Packagist

```json
{
    "repositories": [
        {
            "type": "composer",
            "url": "https://packagist.com/api/v2/repos/danydevx/miniwebs"
        }
    ]
}
```

**Pros**: Fast, professional, handles permissions
**Cons**: Costs money (~$10/month for private packages)

### Option 3: Satis (self-hosted)

```json
{
    "repositories": [
        {
            "type": "composer",
            "url": "https://satis.miniwebs.dev"
        }
    ]
}
```

**Pros**: Free, self-hosted
**Cons**: Maintenance overhead

---

## Recommended: GitHub + VCS for MVP

Start with GitHub private repositories and VCS approach:

1. Create 25 private repos for packages
2. Create 3 private repos for products
3. Each product's composer.json adds all needed VCS repos
4. Use GitHub tokens for authentication

Migrate to Private Packagist when:
- Team grows beyond 3 people
- CI/CD becomes complex with VCS
- Need better version management UI

---

## Git Flow Per Repository

### Package Repositories

```
main (stable releases)
develop (integration)
  ├── feature/xxx
  └── hotfix/xxx
```

### Product Repositories

```
main (production releases)
develop (staging)
  ├── feature/xxx
  └── fix/xxx
```

---

## Access Control

| Repo Type | Access |
|-----------|--------|
| miniwebs/* packages | Core team only |
| invitations-saas | Core team + invitation product team |
| realestate-saas | Core team + realestate product team |
