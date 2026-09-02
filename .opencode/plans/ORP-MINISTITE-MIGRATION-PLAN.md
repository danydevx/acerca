# ORP Minisite Migration Plan
## Phase 2: Real ORP Component Adoption

**Date:** 2026-09-02
**Status:** PLANNING
**Mode:** READ-ONLY (plan only)

---

## ORP Component Inventory (VERIFIED)

### Vue Components (30 files)
```
OrpAccordion.vue         - accordion
OrpActionSheet.vue       - action sheet
OrpAudioPlayer.vue      - audio
OrpCombobox.vue         - combobox
OrpCommandMenu.vue      - command palette
OrpContextMenu.vue      - context menu
OrpDataTable.vue        - data table
OrpDialog.vue           - dialog
OrpDialogHost.vue       - dialog host
OrpDrawer.vue           - drawer (left/right)
OrpDropdown.vue         - dropdown
OrpDropzone.vue        - dropzone
OrpFileInput.vue        - file input
OrpIconButton.vue       - icon button
OrpModal.vue           - modal
OrpMultiSelect.vue      - multi select
OrpNotification.vue     - notification
OrpNotificationHost.vue - notification host
OrpNumberStepper.vue    - number stepper
OrpOtpInput.vue        - OTP input
OrpPasswordInput.vue     - password input
OrpPopover.vue         - popover
OrpSearchInput.vue      - search input
OrpSegmented.vue        - segmented control
OrpSheet.vue           - bottom sheet
OrpSwitch.vue          - switch
OrpTabs.vue            - tabs
OrpTagInput.vue        - tag input
OrpToast.vue           - toast
OrpVideoPlayer.vue     - video player
```

### CSS Components (verified available)
```
.orp-btn               - button
.orp-card              - card
.orp-badge             - badge
.orp-app-bar           - app bar
.orp-drawer           - drawer
.orp-accordion        - accordion
.orp-section           - section
.orp-stack (--1-5)    - vertical stack
.orp-cluster (--1-4)  - wrapping cluster
.orp-media            - media
.orp-media-card       - media card
.orp-rating           - rating
.orp-price            - price
.orp-list             - list
.orp-bottom-nav       - bottom nav
.orp-fab             - FAB
.orp-chip             - chip
.orp-avatar          - avatar
.orp-divider          - divider
.orp-empty            - empty state
.orp-spinner          - spinner
.orp-skeleton         - skeleton
.orp-sheet            - sheet
.orp-modal            - modal
.orp-hero             - hero
```

---

## Migration Matrix

### NEED: NavigationMenu.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| Header fixed, hamburger, drawer | `OrpDrawer.vue`, `OrpIconButton.vue`, `.orp-app-bar` | COMPOSE |
| nav-menu__* BEM | `.orp-drawer`, `.orp-list` | REPLACE wrapper |
| Overlay backdrop | OrpDrawer handles it | REMOVE custom |
| body scroll lock | OrpDrawer handles it | REMOVE custom |
| z-index management | OrpDrawer handles it | REMOVE custom |
| Focus trap | OrpDrawer handles it | REMOVE custom |
| Touch targets 48px+ | OrpDrawer manages | KEEP |

**Migration:**
```vue
<OrpDrawer
  v-model="isOpen"
  position="left"
  title="Menu"
>
  <nav class="orp-list orp-list--divided">
    <a v-for="item in menuItems" :key="item.url" :href="item.url" class="orp-list__item">
      <i :class="item.icon"></i>
      <span class="orp-list__content">{{ item.name }}</span>
    </a>
  </nav>
</OrpDrawer>

<header class="orp-app-bar">
  <OrpIconButton @click="isOpen = true" aria-label="Abrir menú">
    <i class="bi bi-list"></i>
  </OrpIconButton>
  <div class="orp-app-bar__brand">
    <img :src="business.logo" class="orp-avatar orp-avatar--md" />
    <span>{{ business.name }}</span>
  </div>
</header>
```

---

### NEED: MinisiteLayout.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| minisite root div | `.orp-app` / `.orp-shell` | EVALUATE |
| padding-top for fixed header | `--orp-app-bar-height` | USE TOKEN |
| flex column layout | `.orp-stack` | CONSIDER |
| body scroll lock | handled by content | KEEP |

**Decision:** MinisiteLayout stays as Acerca component (controls sections, ordering, data flow). ORP provides layout primitives via CSS tokens only.

---

### NEED: HeroLeft/Center/Right.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| Custom BEM hero__* | `.orp-hero` + `.orp-media` | COMPOSE |
| Social icon row | `.orp-cluster` + `.orp-icon-button` | REUSE |
| Hardcoded colors | brand CSS vars | INTEGRATE |

**Migration:**
```vue
<div class="orp-hero orp-hero--start orp-hero--light">
  <div class="orp-hero__media">
    <img :src="business.logo" class="orp-media orp-media--rounded" />
  </div>
  <div class="orp-hero__content">
    <h1 class="orp-hero__title">{{ title }}</h1>
    <p class="orp-hero__description">{{ subtitle }}</p>
  </div>
  <div v-if="socialNetworks.length" class="orp-cluster orp-cluster--2">
    <a v-for="n in socialNetworks" :href="n.url" class="orp-icon-button orp-icon-button--ghost orp-icon-button--sm">
      <i :class="getIcon(n.platform)"></i>
    </a>
  </div>
</div>
```

---

### NEED: SectionServices.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| section-services__card | `.orp-card` | REPLACE |
| section-services__duration-badge | `.orp-badge` | REPLACE |
| section-services__card-price | `.orp-price` | REPLACE |
| section-services__book-btn | `.orp-btn` | REPLACE |
| service-modal custom overlay | `OrpSheet.vue` | REPLACE |
| Carousel custom CSS | `.orp-scroll-x` | REUSE |

**Migration:**
```vue
<!-- Service Card -->
<div class="orp-card orp-card--interactive">
  <div class="orp-card__media">
    <img :src="item.image" class="orp-media" />
    <span class="orp-badge orp-badge--dark orp-badge--sm">
      <i class="bi bi-clock"></i>
      {{ item.duration_minutes }} min
    </span>
  </div>
  <div class="orp-card__body">
    <h3 class="orp-card__title">{{ item.name }}</h3>
    <p class="orp-card__description">{{ item.description }}</p>
    <div class="orp-price">
      <span class="orp-price__value">{{ formatCurrency(item.price) }}</span>
    </div>
    <button class="orp-btn orp-btn--primary orp-btn--sm">Ver detalles</button>
  </div>
</div>

<!-- Service Modal -->
<OrpSheet v-model="showModal" title="Servicio">
  <div class="orp-media-card orp-media-card--horizontal">
    <img :src="selectedService.image" class="orp-media-card__media" />
    <div class="orp-media-card__body">
      <h2>{{ selectedService.name }}</h2>
      <span class="orp-badge">{{ selectedService.duration_minutes }} min</span>
      <span class="orp-price">{{ formatCurrency(selectedService.price) }}</span>
    </div>
  </div>
</OrpSheet>
```

---

### NEED: SectionGallery.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| section-gallery__grid | `.orp-gallery` | REUSE ORP |
| section-gallery__carousel | `.orp-scroll-x` + custom | COMPOSE |
| section-gallery__item | `.orp-media` | REPLACE |
| GLightbox integration | KEEP | EXTERNAL |
| section-gallery__btn | `.orp-btn` | REPLACE |
| Empty state | `.orp-empty` | REPLACE |

**Migration:**
```vue
<div v-if="items.length === 0" class="orp-empty">
  <i class="bi bi-images orp-empty__media"></i>
  <p class="orp-empty__title">No hay imágenes</p>
</div>

<div v-else class="orp-gallery">
  <a v-for="item in items" :href="item.path" class="orp-media glightbox">
    <img :src="item.path" :alt="item.title" />
  </a>
</div>

<div class="orp-cluster orp-cluster--2">
  <a v-for="btn in buttons" :href="btn.url" class="orp-btn orp-btn--primary">
    {{ btn.text }}
  </a>
</div>
```

---

### NEED: SectionFaqs.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| Bootstrap collapse / custom accordion | `OrpAccordion.vue` | REPLACE |
| FAQ items array | items prop | KEEP |
| expand/collapse state | OrpAccordion manages | REMOVE custom |

**Migration:**
```vue
<OrpAccordion :items="faqItems" v-model="openFaq">
  <template #item="{ item }">
    <div>
      <strong>{{ item.question }}</strong>
      <p>{{ item.answer }}</p>
    </div>
  </template>
</OrpAccordion>
```

**Note:** OrpAccordion uses `{value, title, content}` format. Transform FAQ data:
```js
const faqItems = computed(() => items.map((item, i) => ({
  value: String(i),
  title: item.question,
  content: item.answer
})))
```

---

### NEED: SectionReviews.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| Review cards custom | `.orp-card` | REPLACE |
| Star rating custom CSS | `.orp-rating` | REPLACE |
| Avatar custom circle | `.orp-avatar` | REPLACE |
| section-reviews__* | `.orp-card`, `.orp-rating`, `.orp-avatar` | REPLACE |

**Migration:**
```vue
<div v-for="review in reviews" class="orp-card">
  <div class="orp-card__header">
    <img :src="review.author.avatar" class="orp-avatar orp-avatar--md" />
    <div>
      <strong>{{ review.author.name }}</strong>
      <div class="orp-rating">
        <i v-for="i in 5" :class="i <= review.rating ? 'bi bi-star-fill' : 'bi bi-star'"></i>
      </div>
    </div>
  </div>
  <div class="orp-card__body">
    <p>{{ review.content }}</p>
  </div>
</div>
```

---

### NEED: SectionContactForm.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| Bootstrap form classes | ORP form CSS | REPLACE |
| form-control styled inputs | `.orp-input`, `.orp-textarea` | REPLACE |
| Submit button | `.orp-btn orp-btn--primary` | REPLACE |
| Success/error alerts | `OrpNotification.vue` | REPLACE |

**Migration:**
```vue
<form @submit.prevent="submit">
  <div class="orp-field">
    <label class="orp-field__label">Nombre</label>
    <input v-model="form.name" class="orp-input" type="text" />
  </div>
  <div class="orp-field">
    <label class="orp-field__label">Email</label>
    <input v-model="form.email" class="orp-input" type="email" />
  </div>
  <div class="orp-field">
    <label class="orp-field__label">Mensaje</label>
    <textarea v-model="form.message" class="orp-textarea"></textarea>
  </div>
  <button type="submit" class="orp-btn orp-btn--primary orp-btn--block">
    Enviar
  </button>
</form>
```

---

### NEED: Footer.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| minisite-footer__social-links | `.orp-cluster` + `.orp-icon-button` | REPLACE |
| Social icons | Bootstrap Icons | KEEP |
| Copyright text | Typography tokens | KEEP |

**Migration:**
```vue
<footer class="orp-section orp-section--compact">
  <div v-if="socialNetworks.length" class="orp-cluster orp-cluster--4">
    <a
      v-for="network in socialNetworks"
      :href="network.url"
      class="orp-icon-button orp-icon-button--ghost"
      target="_blank"
    >
      <i :class="getIcon(network.platform)"></i>
    </a>
  </div>
  <p class="orp-text-muted">{{ text }}</p>
  <p class="orp-text-muted">{{ business.name }}</p>
</footer>
```

---

### NEED: SectionAppointments.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| Service selection list | `.orp-list` + radio | COMPOSE |
| Location selector | `.orp-list` | COMPOSE |
| Book button | `.orp-btn` | REPLACE |
| Custom overlay for time slots | `OrpSheet.vue` or `OrpModal.vue` | REPLACE |
| Loading spinner | `.orp-spinner` | REPLACE |
| Success/error state | `OrpNotification.vue` | REPLACE |

---

### NEED: SectionPackages.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| Package cards | `.orp-card` + `.orp-price` | COMPOSE |
| Feature list | `.orp-list` | REUSE |
| CTA buttons | `.orp-btn` | REPLACE |
| Price display | `.orp-price` | REPLACE |

---

### NEED: SectionLocations.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| Location cards | `.orp-card` | REPLACE |
| Leaflet map | KEEP | EXTERNAL |
| Directions button | `.orp-btn orp-btn--ghost` | REPLACE |
| Address/meta | `.orp-meta` | COMPOSE |

---

### NEED: SectionProducts.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| Product grid | `.orp-gallery` or `.orp-grid` | REUSE |
| Product cards | `.orp-card` or `.orp-media-card` | REPLACE |
| Price display | `.orp-price` | REPLACE |
| Add to cart button | `.orp-btn` | REPLACE |

---

### NEED: SectionPromotions.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| Promotion cards | `.orp-card` + `.orp-badge` | COMPOSE |
| Discount badge | `.orp-badge orp-badge--danger` | REPLACE |
| Price display | `.orp-price` | REPLACE |
| CTA | `.orp-btn` | REPLACE |

---

### NEED: SectionAvailability.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| Schedule list | `.orp-list` | REPLACE |
| Status indicators | `.orp-badge` | REPLACE |
| Time display | Typography | KEEP |

---

### NEED: SectionFeatures.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| Feature grid | `.orp-grid` | REUSE |
| Feature icons | Bootstrap Icons | KEEP |
| Feature cards | `.orp-card` | REPLACE |

---

### NEED: SectionRestaurantMenu.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| Category list | `.orp-list` | REPLACE |
| Menu items | `.orp-card` + `.orp-price` | COMPOSE |
| Badge for tags | `.orp-badge` | REPLACE |

---

### NEED: SectionProperties.vue
| Current | ORP Available | Action |
|---------|--------------|--------|
| Property grid | `.orp-gallery` | REUSE |
| Property cards | `.orp-media-card` | REPLACE |
| Price | `.orp-price` | REPLACE |
| Meta info | `.orp-meta` | COMPOSE |

---

## Priority Order

1. **SectionFaqs.vue** — Accordion is a clear ORP component match
2. **NavigationMenu.vue** — Drawer + AppBar + List = clear ORP composition
3. **Footer.vue** — Simple replacement: cluster + icon-button
4. **SectionServices.vue** — Multiple ORP primitives (card, badge, price, sheet)
5. **SectionGallery.vue** — Gallery + Empty state + Button
6. **SectionReviews.vue** — Card + Rating + Avatar
7. **SectionContactForm.vue** — Form fields + Notification
8. **Hero variants** — Hero + Media + Cluster + IconButton
9. **SectionProducts.vue** — Media card + Price + Grid
10. **SectionLocations.vue** — Card + List + Sheet for detail
11. **SectionPackages.vue** — Card + Price + List
12. **SectionPromotions.vue** — Card + Badge + Price
13. **SectionAppointments.vue** — List + Sheet + Notification
14. **SectionAvailability.vue** — List + Badge
15. **SectionFeatures.vue** — Grid + Card + Icon
16. **SectionRestaurantMenu.vue** — List + Card + Badge
17. **SectionProperties.vue** — Media Card + Price + Grid

---

## ORP Gaps Identified

| Gap | Workaround | Priority |
|-----|-------------|----------|
| No ServiceModal specific component | Use OrpSheet or OrpModal | MEDIUM |
| No Rich Card for pricing/packages | Compose Card + Price + List | LOW |
| No horizontal scroll primitive | Use `.orp-scroll-x` CSS | LOW |
| No Product Card specific | Use `.orp-media-card` | LOW |
| No Rich List Item | Compose `.orp-list__item` with extras | LOW |
| No Testimonial Card specific | Compose Card + Avatar + Rating | LOW |

---

## Files NOT to Modify

```
❌ routes/web.php
❌ Modules/ListingMinisite/routes/public.php
❌ Modules/ListingMinisite/app/Http/Controllers/Public/ListingMinisiteController.php
❌ Database migrations
❌ Module definitions
❌ Business logic in controllers
```

## Files TO Modify

```
resources/js/Pages/Minisite/
├── components/
│   ├── NavigationMenu.vue      [PRIORITY 2]
│   ├── MinisiteLayout.vue      [TOKEN ONLY]
│   ├── HeroLeft.vue           [PRIORITY 8]
│   ├── HeroCenter.vue         [PRIORITY 8]
│   ├── HeroRight.vue          [PRIORITY 8]
│   ├── SectionFaqs.vue        [PRIORITY 1]
│   ├── SectionServices.vue    [PRIORITY 4]
│   ├── SectionGallery.vue     [PRIORITY 5]
│   ├── SectionReviews.vue      [PRIORITY 6]
│   ├── SectionContactForm.vue [PRIORITY 7]
│   ├── Footer.vue             [PRIORITY 3]
│   ├── SectionProducts.vue     [PRIORITY 9]
│   ├── SectionLocations.vue    [PRIORITY 10]
│   ├── SectionPackages.vue     [PRIORITY 11]
│   ├── SectionPromotions.vue   [PRIORITY 12]
│   ├── SectionAppointments.vue [PRIORITY 13]
│   ├── SectionAvailability.vue [PRIORITY 14]
│   ├── SectionFeatures.vue    [PRIORITY 15]
│   ├── SectionRestaurantMenu.vue [PRIORITY 16]
│   └── SectionProperties.vue  [PRIORITY 17]
└── themes/base/
    └── (page compositions - review for duplication)
```

---

## Validation Checklist

For each component migrated, verify:
- [ ] 320px mobile
- [ ] 375px mobile
- [ ] 390px mobile
- [ ] 430px mobile
- [ ] 768px tablet
- [ ] 1200px desktop
- [ ] Keyboard navigation
- [ ] Focus management (for overlays)
- [ ] Reduced motion preference
- [ ] Brand theming (custom colors work)
- [ ] Touch targets ≥ 44px

---

## DOGFOODING-NEXT Entries

```
DOGFOOD-020: ORP Accordion migration - SectionFaqs
DOGFOOD-021: ORP Drawer composition - NavigationMenu  
DOGFOOD-022: ORP Footer composition - Footer
DOGFOOD-023: ORP Service composition - SectionServices
DOGFOOD-024: ORP Gallery + Empty state - SectionGallery
DOGFOOD-025: ORP Card + Rating + Avatar - SectionReviews
DOGFOOD-026: ORP Form fields - SectionContactForm
DOGFOOD-027: ORP Hero composition - Hero variants
DOGFOOD-028: ORP Media Card composition - SectionProducts
DOGFOOD-029: ORP List + Sheet - SectionLocations
```

---

## Status

**PLANNED - Awaiting implementation phase**
