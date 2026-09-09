# MINISITE COMPONENT DEPENDENCIES

## Dependency Tree

```
MinisiteLayout (Layout)
├── HeroLeft (Layout) - uses business prop
├── HeroCenter (Layout) - uses business prop
│   └── getSocialIcon() - internal mapping
├── HeroRight (Layout) - uses business prop
├── NavigationMenu (Layout) - uses business, existingSections
│   └── emits: sectionClick
└── MinisiteFooter/Footer (Layout) - uses business, socialNetworks
    └── Footer
        └── uses business, text, showSocial

[Content Slot]
    │
    ├── SectionProducts (Section)
    │   ├── ProductCard (Domain) ← item, showImage, showPrice, etc.
    │   ├── ProductListItem (Structure) ← item, showImage, showPrice, etc.
    │   └── ProductDetailModal (Domain) ← product, businessSlug
    │       ├── uses: useCart composable
    │       ├── uses: GLightbox
    │       └── emits: update:modelValue, close
    │
    ├── SectionServices (Section)
    │   ├── ServiceCard (Domain)
    │   ├── ServiceListItem (Structure)
    │   └── ServiceDetailModal (Domain)
    │       ├── uses: GLightbox
    │       └── emits: update:modelValue, close
    │
    ├── SectionGallery (Section)
    │   └── UiGallery (from Components/Ui)
    │
    ├── SectionLocations (Section)
    │   └── UiMap (from Components/Ui)
    │
    ├── SectionReviews (Section)
    │   └── Review cards
    │
    ├── SectionContactForm (Section)
    │   └── Form handling
    │       └── slots: YES (extends content)
    │
    ├── SectionAppointments (Section)
    │   └── Calendar/booking logic
    │
    ├── SectionAvailability (Section)
    │
    ├── SectionFaqs (Section)
    │   └── Accordion component
    │
    ├── SectionFeatures (Section)
    │
    ├── SectionAbout (Section)
    │
    ├── SectionPackages (Section)
    │
    ├── SectionPromotions (Section)
    │
    └── SectionRestaurantMenu (Section)
```

## THEMES ARCHITECTURE

```
themes/base/Show (Main orchestrator)
├── NavigationMenu
├── MinisiteLayout
│   └── Hero variants (Left/Center/Right)
│       └── Footer
└── Dynamic Sections based on type:
    ├── type: 'services' → SectionServices
    ├── type: 'gallery' → SectionGallery
    ├── type: 'promotions' → SectionPromotions
    ├── type: 'contact_form' → SectionContactForm
    ├── type: 'appointments' → SectionAppointments
    ├── type: 'availability' → SectionAvailability
    ├── type: 'locations' → SectionLocations
    ├── type: 'about' → SectionAbout
    ├── type: 'packages' → SectionPackages
    ├── type: 'products' → SectionProducts
    └── type: 'reviews' → SectionReviews

themes/base/* (Detail pages)
├── Products → Product list page
├── ProductDetail → Single product page
├── Services → Service list page
├── ServiceDetail → Single service page
├── Menu → Restaurant menu
├── Gallery → Gallery grid
├── Locations → Location list
├── Reviews → Review list
├── Promotions → Promotion list
├── PromotionDetail → Single promotion
├── Faqs → FAQ list
├── Properties → Property list
├── PropertyDetail → Single property
├── Contact → Contact page
└── Appointments → Booking page
```

## Composables Dependencies

```
usePriceFormatter
├── Used by: ALL card components
├── Locale: 'es-MX' (HARDCODED)
├── Currency: '$' (HARDCODED)
└── Decimals: 2 (HARDCODED)

useCart
├── Used by: ProductDetailModal
└── Global cart state

useOrpTheme
├── Used by: BulmaPlayground (separate from Minisite)
└── Sets: data-orp-theme, data-theme
```

## External Libraries

```
GLightbox
├── Used by: ProductDetailModal, ServiceDetailModal
└── CSS imported: glightbox/dist/css/glightbox.min.css

Bootstrap Icons (bi-*)
├── Used by: All components via CDN
└── Icon classes: bi-image, bi-chevron-right, bi-clock, etc.

Swiper (if used)
└── Not found in current Minisite components
```

## Component Communication Patterns

```
PARENT → CHILD (Props)
├── SectionProducts → ProductCard (item, showImage, showPrice, etc.)
├── SectionProducts → ProductListItem (same props pattern)
├── SectionProducts → ProductDetailModal (product, businessSlug, orderSettings)
└── MinisiteLayout → Hero variants (business, title, subtitle, etc.)

CHILD → PARENT (Emits)
├── ProductCard → details (item)
├── ServiceCard → details (item)
├── NavigationMenu → sectionClick
├── ProductDetailModal → update:modelValue, close
└── ServiceDetailModal → update:modelValue, close

SIBLING (via Parent)
├── SectionProducts manages ProductDetailModal visibility
└── SectionServices manages ServiceDetailModal visibility
```

## Shared Structure Components

```
ProductCard ← Domain
ServiceCard ← Domain
    │
    ├── Both use: orp-card, orp-card--interactive classes
    ├── Both use: orp-card__media, orp-card__body, orp-card__footer
    ├── Both emit: details event
    └── Both use: usePriceFormatter composable

ProductListItem ← Structure
ServiceListItem ← Structure
    │
    ├── Similar list item structure
    ├── Both emit: details event
    └── Both use: usePriceFormatter composable
```

## Props API Patterns

```
ITEM-BASED (Card components)
├── item: Object (required) - The business entity
├── showImage: Boolean
├── showPrice: Boolean
├── showComparePrice: Boolean (ProductCard/ProductListItem only)
├── showDescription: Boolean
├── showStock: Boolean (ProductCard/ProductListItem only)
└── carousel: Boolean

SECTION-BASED (Orchestrators)
├── title: String
├── subtitle: String
├── description: String
├── items: Array
├── config: Object (view_mode, show_image, max_items, etc.)
├── buttons: Array
└── businessSlug: String

LAYOUT-BASED
├── business: Object (required)
├── heroLayout: String ('left' | 'center' | 'right')
├── heroTitle: String
├── heroSubtitle: String
├── heroBackgroundImage: String
├── heroShowSocial: Boolean
├── footerText: String
├── footerShowSocial: Boolean
└── socialNetworks: Array
```
