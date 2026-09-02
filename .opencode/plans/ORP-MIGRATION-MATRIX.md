# ORP UI Migration Matrix — Acerca Minisite

**Version:** v0.1.0 Dogfooding  
**Date:** 2026-09-02  
**Status:** AUDIT PHASE

---

## Current Architecture

### Route Flow
```
/m/{slug} → ListingMinisiteController::show()
  ↓
resolveThemeView('Show', theme_key) → Minisite.themes.base.Show
  ↓
MinisiteLayout → SectionComponents (v-for)
```

### Key Files

| File | Purpose |
|------|---------|
| `Modules/ListingMinisite/app/Http/Controllers/Public/ListingMinisiteController.php` | Main controller, 1643 lines |
| `resources/js/Pages/Minisite/themes/base/Show.vue` | Main minisite page |
| `resources/js/Pages/Minisite/components/MinisiteLayout.vue` | Layout wrapper with Hero + Footer |
| `resources/js/Pages/Minisite/components/Section*.vue` | 16 section components |
| `resources/less/minisite.less` | Minisite-specific styles |
| `vite.config.js` | Vite entries including `minisite.less` |

### Section Types (16 total)

| Section | Component | Hero Variant | Status |
|---------|-----------|-------------|--------|
| services | SectionServices | - | ACTIVE |
| gallery | SectionGallery | - | ACTIVE |
| promotions | SectionPromotions | - | ACTIVE |
| contact_form | SectionContactForm | - | ACTIVE |
| appointments | SectionAppointments | - | ACTIVE |
| availability | SectionAvailability | - | ACTIVE |
| locations | SectionLocations | - | ACTIVE |
| about | SectionAbout | - | ACTIVE |
| features | SectionFeatures | - | ACTIVE |
| faqs | SectionFaqs | - | ACTIVE |
| products | SectionProducts | - | ACTIVE |
| reviews | SectionReviews | - | ACTIVE |
| restaurant_menu | SectionRestaurantMenu | - | ACTIVE |
| properties | SectionProperties | - | ACTIVE |
| packages | SectionPackages | - | ACTIVE |
| footer | SectionFooter | - | ACTIVE |

### Hero Variants (4)

| Hero | Component | Layout |
|------|-----------|--------|
| Left | HeroLeft.vue | Logo left, text right |
| Center | HeroCenter.vue | Centered, overlay style |
| Right | HeroRight.vue | Text left, logo right |
| Simple | HeroSimple.vue | Minimal centered |

---

## Bootstrap Usage Inventory

### Classes Found in Minisite Components

| Pattern | Bootstrap Class | ORP Equivalent | Migration Action |
|---------|----------------|----------------|------------------|
| Buttons | `.btn .btn-primary` | `.orp-btn .orp-btn--primary` | REPLACE |
| Buttons | `.btn .btn-success` | `.orp-btn .orp-btn--success` | REPLACE |
| Buttons | `.btn .btn-outline-primary` | `.orp-btn .orp-btn--ghost` | REPLACE |
| Text | `.text-muted` | `.orp-text-muted` / CSS var | REPLACE |
| Text | `.text-center` | `.orp-text-center` | REPLACE |
| Spacing | `.py-4` | `.orp-p-4` / `.orp-p-5` | REPLACE |
| Spacing | `.me-1` `.me-2` `.mb-2` `.mt-4` | `.orp-me-1` `.orp-ms-2` | REPLACE |
| Cards | `.card` pattern | `.orp-card` | REPLACE |
| Grid | `.row .col-*` | `.orp-grid` / Stack+Cluster | REFACTOR |
| Container | `.container` | `.orp-container` | REPLACE |
| Modals | `.modal` | `.orp-modal` / `.orp-sheet` | REPLACE |
| Badges | `.badge` | `.orp-badge` | REPLACE |
| Images | `.img-fluid` | `.orp-media img` | REPLACE |

### JS Bootstrap Components Used

| Component | Usage | ORP Replacement | Status |
|-----------|-------|-----------------|--------|
| GLightbox | Gallery images | Keep GLightbox | KEEP EXTERNAL |
| Swiper | Carousel (services) | ORP horizontal scroll / Swiper | EVALUATE |
| Collapse | FAQ accordion | ORP Accordion | REPLACE |
| Dropdown | Bootstrap dropdowns | ORP Dropdown | REPLACE |

---

## ORP Mapping Matrix

### Hero/Profile Section

| Existing Pattern | Current Tech | ORP Primitive | Composition | Action |
|-----------------|--------------|---------------|-------------|--------|
| Hero with logo+text | HeroLeft/Right/Center.vue | `.orp-hero` + `.orp-media` | App shell | REFACTOR |
| Background image | CSS background-image | `.orp-media` with overlay | Hero | REUSE |
| Social icons row | Custom CSS circles | `.orp-cluster` + `.orp-icon-btn` | Compose | REUSE ORP |
| Navigation menu | Custom Vue + Bootstrap | `.orp-app-bar` + `.orp-bottom-nav` | App shell | ORP GAP |

### Services Section

| Existing Pattern | Current Tech | ORP Primitive | Composition | Action |
|-----------------|--------------|---------------|-------------|--------|
| Section wrapper | Custom LESS | `.orp-section` | Layout | REUSE ORP |
| Carousel view | Custom CSS scroll | `.orp-scroll-x` | Horizontal scroll | REUSE ORP |
| Grid view | CSS grid | `.orp-grid` / `.orp-stack` | Layout | REUSE ORP |
| List view | Flex row | `.orp-list` + `.orp-list--divided` | List | REUSE ORP |
| Service card | Custom card (Bootstrap-like) | `.orp-card` | Card | REUSE ORP |
| Duration badge | Custom positioned span | `.orp-badge` | Badge | REUSE ORP |
| Price display | Custom styling | `.orp-price` | Price | REUSE ORP |
| Book CTA button | `.btn .btn-primary` | `.orp-btn .orp-btn--primary` | Button | REPLACE |
| Image placeholder | Custom div+icon | `.orp-media` placeholder | Media | COMPOSE ORP |
| Service modal | Custom fixed overlay | `.orp-sheet` / `.orp-modal` | Overlay | ORP GAP |
| WhatsApp button | `.btn .btn-success` | `.orp-btn .orp-btn--success` | Button | REPLACE |

### Gallery Section

| Existing Pattern | Current Tech | ORP Primitive | Composition | Action |
|-----------------|--------------|---------------|-------------|--------|
| Gallery grid | Custom CSS | `.orp-gallery` | Gallery | REUSE ORP |
| Image lightbox | GLightbox | Keep GLightbox | External | KEEP EXTERNAL |
| Thumbnails | Custom flex | `.orp-cluster` | Cluster | REUSE ORP |

### Contact Form Section

| Existing Pattern | Current Tech | ORP Primitive | Composition | Action |
|-----------------|--------------|---------------|-------------|--------|
| Form fields | Bootstrap forms | ORP form CSS | Forms | REPLACE |
| Submit button | `.btn .btn-primary` | `.orp-btn .orp-btn--primary` | Button | REPLACE |

### Appointments Section

| Existing Pattern | Current Tech | ORP Primitive | Composition | Action |
|-----------------|--------------|---------------|-------------|--------|
| Service selection | Custom radio/list | `.orp-list` + `.orp-radio` | Forms | REUSE ORP |
| Date picker | Native input | Native `<input type="date">` | Native | KEEP CURRENT |
| Location selector | Custom list | `.orp-list` | List | REUSE ORP |
| Book button | `.btn .btn-primary` | `.orp-btn .orp-btn--primary` | Button | REPLACE |

### Locations Section

| Existing Pattern | Current Tech | ORP Primitive | Composition | Action |
|-----------------|--------------|---------------|-------------|--------|
| Location card | Custom card | `.orp-card` | Card | REUSE ORP |
| Map embed | Leaflet | Keep Leaflet | External | KEEP EXTERNAL |
| Directions button | `.btn .btn-outline-primary` | `.orp-btn .orp-btn--ghost` | Button | REPLACE |

### About/Features/FAQs

| Existing Pattern | Current Tech | ORP Primitive | Composition | Action |
|-----------------|--------------|---------------|-------------|--------|
| Rich text | Raw HTML | ORP Typography | Text | KEEP CURRENT |
| FAQ accordion | Bootstrap collapse | `.orp-accordion` | Accordion | REPLACE |
| Feature list | Custom | `.orp-list` | List | REUSE ORP |
| Stats/metrics | Custom cards | `.orp-stat-card` | Stat Card | REUSE ORP |

### Products Section

| Existing Pattern | Current Tech | ORP Primitive | Composition | Action |
|-----------------|--------------|---------------|-------------|--------|
| Product grid | CSS grid | `.orp-grid` / `.orp-stack` | Layout | REUSE ORP |
| Product card | Custom card | `.orp-card` / `.orp-media-card` | Card | REUSE ORP |
| Add to cart | Custom button | `.orp-btn` | Button | REPLACE |

### Reviews Section

| Existing Pattern | Current Tech | ORP Primitive | Composition | Action |
|-----------------|--------------|---------------|-------------|--------|
| Review card | Custom card | `.orp-card` | Card | REUSE ORP |
| Star rating | Custom/CSS | `.orp-rating` | Rating | REUSE ORP |
| Avatar | Custom circle | `.orp-avatar` | Avatar | REUSE ORP |

### Footer Section

| Existing Pattern | Current Tech | ORP Primitive | Composition | Action |
|-----------------|--------------|---------------|-------------|--------|
| Footer wrapper | Custom LESS | `.orp-section` | Section | REUSE ORP |
| Social links | Custom circles | `.orp-cluster` + `.orp-icon-btn` | Cluster | REUSE ORP |
| Copyright text | Raw text | ORP Typography | Text | KEEP CURRENT |

---

## Migration Decisions

### REUSE ORP
Components that can directly use ORP primitives:
- `.orp-section` for section wrappers
- `.orp-card` for cards
- `.orp-list`, `.orp-list--divided` for lists
- `.orp-button`, `.orp-icon-button` for actions
- `.orp-badge` for badges
- `.orp-avatar` for avatars
- `.orp-rating` for ratings
- `.orp-price` for price display
- `.orp-scroll-x` for horizontal scrolling
- `.orp-cluster` for button/icon clusters
- `.orp-accordion` for FAQ accordions

### COMPOSE ORP
Patterns that need ORP composition:
- Hero section → `.orp-hero` + `.orp-media` + Stack/Cluster
- Service cards → `.orp-card` + `.orp-media` + `.orp-price`
- List items → `.orp-list` + `.orp-avatar` + `.orp-meta`

### KEEP CURRENT
Non-Bootstrap patterns that work:
- GLightbox integration
- Leaflet maps
- Native HTML form elements
- Bootstrap Icons (already using)

### REFACTOR APP
Items that need app-level refactoring:
- Navigation menu structure
- App shell layout
- Footer positioning

### ORP GAP
Missing ORP primitives needed:
- **Service modal/sheet** - Current uses custom fixed overlay. ORP Sheet could work but needs mobile-optimized version
- **Product quick-view** - No equivalent in ORP yet
- **Booking calendar** - Complex, keep as app-specific

---

## Bootstrap Coexistence Strategy

### Structural Isolation
```html
<div class="minisite">
  <!-- ORP UI styles apply here -->
  <div class="orp-app">
    <header class="orp-app-bar">...</header>
    <main class="orp-page">
      <section class="orp-section">...</section>
    </main>
  </div>
</div>
```

### CSS Loading Order (Conceptual)
```
1. Bootstrap (admin/legacy)
2. ORP UI (minisite)
3. Application overrides
4. Brand variables
```

### Confirmed Compatible
- Bootstrap CSS reset with ORP tokens
- Bootstrap Icons integration
- Bootstrap grid as fallback

### Potential Conflicts
- `.btn` classes in modals
- `.card` class inheritance
- Form control styling

---

## Pilot Selection Recommendation

### Candidate: Services Section (SectionServices.vue)

**Rationale:**
1. Medium complexity - has carousel, grid, list views
2. Uses multiple ORP primitives (cards, badges, buttons, icons)
3. Self-contained section
4. Visible on most minisites
5. Has clear BEFORE/AFTER for comparison

**Alternative:** Hero section - but requires more layout changes

---

## Next Steps

1. **SELECT PILOT** - Confirm Services section as pilot
2. **IMPLEMENT PILOT** - Migrate SectionServices.vue to use ORP primitives
3. **VALIDATE** - Test at 320px, 375px, 390px, 430px, 768px, desktop
4. **COMPARE** - Visual diff of before/after
5. **DOCUMENT** - Update ORP-DOGFOODING.md with findings
6. **DECIDE** - Continue migration or fix ORP gaps

---

*Generated by ORP UI Dogfooding Audit - Parte 25*
