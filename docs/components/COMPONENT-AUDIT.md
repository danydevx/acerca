# Component Audit — MiniWebs/vCards

**Date:** 2026-09-08
**Total Ui Components:** 91 Vue files
**OrpUI Components:** 43 Vue files

---

## 1. Existing Structure

### Ui/ (main reusable library)

| Category | Components | Notes |
|----------|-----------|-------|
| **Cta/** | CtaArrow, CtaButton, CtaIcon | 3 files — clean abstraction for calls-to-action |
| **products/** | ProductCard, ProductBadges, ProductPrice | Product domain — card + structure parts |
| **services/** | ServiceCard, ServiceListItem, ServiceDetailModal, ServiceActions, ServiceBadges, ServiceDuration, ServiceGallery, ServiceMeta, ServicePrice | 9 files — well structured with `structure/` subfolder |
| **contact/** | ContactCard, ContactDetails, ContactStatus | 3 files — contact domain |
| **pricing/** | PricingCard | Single card for pricing plans |
| **profile/** | ProfileCard, ProfileAvatar | 2 files — profile/vCard domain |
| **catalog/** | CatalogCard, CatalogBadge, CatalogPricing | 3 files |
| **content/** | ContentCard, InteractiveCard, StatCard | 3 content cards |
| **heros/** | Hero | 1 hero component |
| **slider/** | SwiperSlider | Swiper wrapper |
| **root level** | Accordion, ActionSheet, AppBar, AppShell, AudioPlayer, Avatar, AvatarUpload, Breadcrumb, Callout, Comment, Drawer, Dropdown, EmptyState, Fab, FileInput, FileItem, Gallery, HorizontalScroll, IconButton, ImageInput, InteractivePlayground, KeyboardShortcut, List, Map, MediaCard, Media, Modal, NavigationList, NavigationRail, NotificationBanner, NotificationCenter, Notification, Page, PageContent, Pagination, PanelBlock, PanelFilter, PanelTabs, Popover, QuickActions, RangeInput, SearchInput, SegmentedControl, SelectionBar, Skeleton, Stepper, Table, Toast, UiCommandMenu, UiContextMenu, UiDialog, UiDialogHost, UiDropzone, UiProgress, UiSheet, UiSpinner, UiSwitch, UiTabs, VideoCard, VideoPlayer, VideoPlaylist | ~60+ root-level components |

### OrpUI/ (admin-focused duplicates)

43 components mirroring Ui/ with `Orp` prefix. Likely legacy admin components that duplicate Ui functionality.

### Minisite/

| Path | Components | Notes |
|------|-----------|-------|
| **themes/base/** | Show, ProductDetail, Appointments, Properties, Reviews, Contact, Promotions, Gallery, Services, Locations, Menu, Products, PromotionDetail, PropertyDetail, Faqs, ServiceDetail | 16 theme page components |
| **components/** | SectionHero, HeroSimple, HeroLeft, HeroRight, HeroCenter, SectionServices, ServiceCard, ServiceListItem, ServiceDetailModal, SectionContactForm, SectionAbout, SectionGallery, SectionLocations, SectionPromotions, SectionAppointments, SectionProducts, ProductCard, ProductListItem, ProductDetailModal, SectionReviews, SectionFaqs, SectionFeatures, SectionFooter, Footer, NavigationMenu, MinisiteLayout, SectionPackages, SectionRestaurantMenu, SectionProperties | 30+ section components |

### Legacy

- `Pages/Minisite/old_components/products/` — ProductCard, ProductDetailModal, ProductListItem (should be migrated to Ui/ or removed)

---

## 2. Domain Coverage

| Domain | Coverage | Status |
|--------|----------|--------|
| **Products** | ProductCard, ProductListItem, ProductDetailModal, ProductBadges, ProductPrice | Well covered |
| **Services** | ServiceCard, ServiceListItem, ServiceDetailModal, ServicePrice, ServiceDuration, ServiceMeta, ServiceGallery, ServiceBadges, ServiceActions | Well covered |
| **Contact** | ContactCard, ContactDetails, ContactStatus | Basic — needs expansion |
| **Business Info** | Partial in ContactCard | Missing dedicated business components |
| **Calendar** | CalendarView (Appointments/) | Basic — needs mobile-first calendar |
| **Availability** | AvailabilityCalendar, WeeklyScheduleEditor, ExceptionDatesList | Admin-focused — needs public-facing components |
| **Booking** | AppointmentModal | UI only — needs booking flow components |
| **Gallery** | Gallery, SwiperSlider | Covered |
| **Pricing** | PricingCard, ProductPrice, ServicePrice, CatalogPricing | Covered |
| **Profile/People** | ProfileCard, ProfileAvatar | Basic — needs expansion for team/staff |
| **Social** | None dedicated | Missing |
| **Location** | Map, LocationSelector | Basic |
| **Events** | None | Missing |
| **Reviews** | None public | Missing public-facing reviews |
| **Media** | VideoPlayer, VideoPlaylist, AudioPlayer, MediaCard | Covered |

---

## 3. Duplication Issues

| Issue | Location |
|-------|----------|
| OrpUI duplicates Ui/ | OrpAccordion ≈ Accordion, OrpModal ≈ Modal, OrpDialog ≈ UiDialog, OrpSheet ≈ UiSheet, OrpEmptyState ≈ EmptyState, OrpSpinner ≈ UiSpinner, OrpSkeleton ≈ Skeleton |
| ProductCard exists in both Ui/products/ and Minisite/components/ | Should consolidate |
| ServiceCard exists in both Ui/services/ and Minisite/components/ | Should consolidate |
| Hero variants exist in both Ui/heros/ and Minisite/components/ | Should consolidate |

---

## 4. Bootstrap Usage Found

The following files still import or reference Bootstrap CSS (should be migrated to Bulma):

- `resources/js/Components/Ui/VideoPlayer.vue`
- `resources/js/Components/Ui/VideoPlaylist.vue`
- `resources/js/Components/Ui/AudioPlayer.vue`
- `resources/js/Components/Ui/Gallery.vue`
- `resources/js/Components/Ui/MediaCard.vue`
- `resources/js/Components/Ui/VideoCard.vue`
- `resources/js/Components/Ui/heros/Hero.vue`
- `resources/js/Pages/Minisite/components/SectionHero.vue`

---

## 5. Components with Good Patterns

- **ServicePrice, ServiceDuration, ServiceMeta** — Small, focused, reusable primitives for services
- **ProductPrice, ProductBadges** — Same pattern applied to products
- **CtaArrow, CtaButton, CtaIcon** — Clean CTA abstraction
- **ContactDetails, ContactStatus** — Structured contact data presentation

---

## 6. Components Missing (General Purpose)

- Social network links/components
- Date/Calendar display components (mobile-first)
- Availability status display (open/closed)
- Opening hours display
- Event date/time components
- Rating/reputation display
- Compact action buttons (call, whatsapp, directions, email)
- Business hours block
- Location mini-card

---

## 7. Legacy / Should Be Removed

- `Pages/Minisite/old_components/products/` — 3 files, duplicates of Ui/products/
- OrpUI/ — entire folder if admin migrates to Ui/

---

## 8. Observations

1. **Good foundation** — services/, products/, contact/ have well-organized structure/ subfolders with reusable atomic components
2. **No calendar** — CalendarView exists but is admin-focused, not mobile-first public calendar
3. **No social** — Social links still hardcoded in sections
4. **Duplication** — OrpUI and Ui overlap significantly; Minisite and Ui also overlap for cards
5. **Bootstrap remnants** — Media-related components still use Bootstrap CSS
6. **No events domain** — No event-specific components exist
7. **No reviews** — No public-facing rating/review components
8. **Booking/availability split** — Availability in one folder, Appointments in another with no clear relationship
