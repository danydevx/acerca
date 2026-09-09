# Component Catalog — MiniWebs/vCards

This catalog lists all available reusable components for building MiniWebs and vCards.

---

## Calendar

```
Calendar
├── MiniCalendar           ✅ Month grid calendar, mobile-first
├── CalendarDay            ✅ Single day cell
├── DatePicker             — Full date selection UI (TODO)
└── DateRangePicker       — Start/end date selection (TODO)
```

**API Example:**
```vue
<MiniCalendar
    v-model="selectedDate"
    :events="events"
/>
```

---

## Availability

```
Availability
├── AvailabilityStatus     ✅ Open/Closed badge with pulse animation
├── OpeningHours           ✅ Weekly schedule list with today highlight
├── TimeSlot               ✅ Single time slot button
└── TimeSlotGroup         — Group of time slots (TODO)
```

**API Example:**
```vue
<AvailabilityStatus
    :is-open="true"
    :closes-at="'20:00'"
    :show-time="true"
/>

<OpeningHours
    :schedule="schedule"
    :highlight-today="true"
/>

<TimeSlot
    :slots="[{ time: '09:00', disabled: false }, ...]"
    @select="handleSelect"
/>
```

---

## Booking

```
Booking
├── BookingProgress        ✅ Step indicator for multi-step flow
├── BookingSummary         ✅ Selection confirmation
├── BookingDateSelector    — Date + available slots (TODO)
├── BookingTimeSelector    — Time slot selection (TODO)
├── GuestSelector          — Number of guests (TODO)
├── AppointmentCard        — Appointment display (TODO)
└── AppointmentStatus      — Status badge (TODO)
```

---

## Business

```
Business
├── BusinessStatus         ✅ Open/closed + schedule expand
├── BusinessHours          — Full schedule (uses OpeningHours)
├── BusinessInfo           — Name, description, category (TODO)
├── BusinessLogo           — Logo with fallback (TODO)
├── BusinessCategory       — Category badge (TODO)
├── BusinessAmenities      — Amenities list (TODO)
└── BusinessBadge          — Trust/reputation badge (TODO)
```

---

## Contact

```
Contact
├── ContactAction          ✅ Single action (call, whatsapp, email, etc.)
├── ContactList            ✅ Group of contact actions
├── ContactCard            — Full contact card (existing)
├── ContactDetails         — Contact information block (existing)
└── ContactStatus          — Availability status (existing)
```

**API Example:**
```vue
<ContactAction
    type="whatsapp"
    value="+1234567890"
    label="WhatsApp"
/>

<ContactList :items="contactItems" />
```

---

## Social

```
Social
├── SocialLinks            ✅ Social network links list
├── SocialButton           ✅ Single network button (network + url props)
└── FollowButton          — Follow/subscribe button (TODO)
```

**API Example:**
```vue
<SocialLinks :items="socialItems" />

<SocialLinks :items="socialItems" :icon-only="true" :horizontal="true" />

<SocialButton
    network="instagram"
    url="https://instagram.com/..."
/>
```

---

## Location

```
Location
├── LocationCard           ✅ Full location display with image, contact, hours
├── AddressBlock           ✅ Formatted address with label
├── DirectionsButton       ✅ Open in maps app
└── DistanceBadge          — Distance indicator (TODO)
```

---

## Events

```
Events
├── EventDate              ✅ Formatted date block with day/month/year
├── EventTime              ✅ Start/end time display
├── EventLocation          ✅ Venue display with directions link
├── EventCard              ✅ Event listing card with image, price
├── EventCountdown         — Countdown timer (TODO)
├── EventSchedule          — Session list (TODO)
├── EventScheduleItem      — Single session (TODO)
├── EventSpeaker           — Speaker info (TODO)
└── EventActions           — CTAs (register, share) (TODO)
```

---

## People / Profiles

```
People
├── ProfileCard            — Profile card (existing)
├── ProfileAvatar          — Avatar with fallback (existing)
├── ProfileHeader          — Full profile header (TODO)
├── ProfileMeta            — Metadata (role, etc.) (TODO)
├── ProfileBio             — Biography text (TODO)
├── ProfileCredentials     — Certifications, etc. (TODO)
├── ProfileBadges          — Badges/achievements (TODO)
├── TeamMember             ✅ Single team member with image, role, bio, social
└── TeamGrid               ✅ Responsive team grid
```

---

## Services

```
Services
├── ServiceCard            — Full service card (existing)
├── ServiceListItem        — Compact list item (existing)
├── ServiceDetailModal     — Service detail overlay (existing)
├── ServicePrice           — Price display (existing)
├── ServiceDuration        — Duration display (existing)
├── ServiceMeta            — Metadata (existing)
├── ServiceFeatures        — Feature list (existing)
├── ServiceGallery         — Service images (existing)
├── ServiceBadges          — Badges (featured, etc.) (existing)
└── ServiceActions         — CTA buttons (existing)
```

---

## Products

```
Products
├── ProductCard            — Full product card (existing)
├── ProductListItem        — Compact list item (existing)
├── ProductDetailModal     — Product detail overlay (existing)
├── ProductPrice           — Price display (existing)
├── ProductBadges          — Badges (sale, stock, etc.) (existing)
├── ProductImage           ✅ Single image with placeholder and badge
├── ProductGallery         ✅ Image gallery with thumbnails and navigation
├── ProductStock           ✅ Stock indicator (in stock, low, out, unknown)
├── ProductMeta            ✅ Metadata (SKU, category, brand, tags)
└── ProductVariant         ✅ Variant selector (color, size, etc.)
```

**API Example:**
```vue
<ProductStock :quantity="3" :low-threshold="5" />

<ProductImage
    src="https://..."
    alt="Product"
    badge="Nuevo"
    :zoomable="true"
/>

<ProductGallery
    :images="[{ url: '...', alt: '...' }, ...]"
    @preview="openLightbox"
/>

<ProductMeta
    sku="PRD-123"
    category="Electrónicos"
    :tags="['Nuevo', 'Popular']"
/>

<ProductVariant
    v-model="selectedColor"
    label="Color"
    :options="[{ value: 'red', label: 'Rojo', color: '#dc2626' }, ...]"
/>
```

---

## Real Estate / Properties

```
Properties
├── PropertyCard           ✅ Full property card with image, price, features
├── PropertyPrice         ✅ Price display with rent/sale styling
├── PropertyStatus        ✅ Status badge (for_sale, for_rent, sold, etc.)
├── PropertyFeatures      ✅ Beds, baths, area display
├── PropertyImage         — Single property image (TODO)
├── PropertyGallery       — Property image gallery (TODO)
├── PropertyMap           — Property location map (TODO)
├── PropertyAgent         — Agent contact info (TODO)
└── PropertyMortgage      — Mortgage calculator (TODO)
```

**API Example:**
```vue
<PropertyCard
    title="Casa moderna en el centro"
    address="Av. Principal 456, CDMX"
    price="2500000"
    price-type="sale"
    status="for_sale"
    :beds="3"
    :baths="2"
    :area="150"
    image="https://..."
/>

<PropertyFeatures :beds="3" :baths="2" :area="150" />

<PropertyStatus status="for_sale" />
```

---

## Pricing

```
Pricing
├── Price                  ✅ Simple price display
├── OldPrice               ✅ Strikethrough original price
├── Discount               ✅ Discount badge (percent or amount)
├── PriceRange             — Min-max price (TODO)
├── PriceBadge             — Price highlight badge (TODO)
├── PricingCard            — Pricing plan card (existing)
├── PricingPlan            — Plan with features (TODO)
├── PricingFeatures        — Feature list (TODO)
└── PricingCTA             — Plan CTA button (TODO)
```

---

## Reviews / Reputation

```
Reviews
├── Rating                 ✅ Star rating + count display
├── RatingStars            ✅ Stars only
├── RatingSummary          ✅ Aggregate rating with distribution bars
├── ReviewCard             ✅ Single review with author, rating, text, date, source
├── ReviewAuthor           — Reviewer info (TODO)
├── ReviewList             — Review list (TODO)
├── ReviewSource           — Source badge (TODO)
└── ReviewStats            — Rating statistics (TODO)
```

**API Example:**
```vue
<Rating :value="4.8" :count="127" :show-value="true" />

<ReviewCard
    :author="'María García'"
    :rating="5"
    title="Excelente servicio"
    text="El mejor servicio que he recibido."
    date="2026-08-15"
    source="Google"
/>

<ReviewSummary :average="4.8" :total="127" />
```

---

## Media

```
Media
├── MediaImage             — Image with fallback (TODO)
├── MediaVideo             — Video player (TODO)
├── VideoPreview           — Thumbnail + play button (TODO)
├── VideoPlayer            — Full video player (existing - needs Bootstrap→Bulma)
├── VideoPlaylist          — Video list + player (existing - needs Bootstrap→Bulma)
├── AudioPlayer            — Audio player (existing - needs Bootstrap→Bulma)
├── Gallery                — Image gallery (existing - needs Bootstrap→Bulma)
├── GalleryGrid            — Grid layout (TODO)
├── GalleryItem            — Single gallery item (TODO)
├── GalleryCarousel        — Carousel layout (TODO)
├── MediaCard             — Media + text card (existing)
├── MediaPlaceholder       — No-media placeholder (TODO)
└── LightboxTrigger        — Lightbox open trigger (TODO)
```

---

## Content

```
Content
├── FeatureCard           ✅ Feature/amenity card with icon
├── FaqItem              ✅ FAQ accordion item
├── StatValue            ✅ Stat display with change indicator
├── ContentCard          — Content card (existing)
├── InteractiveCard       — Interactive card (existing)
└── StatCard             — Stat card (existing)
```

**API Example:**
```vue
<FeatureCard
    icon="bi bi-truck"
    title="Envío Gratis"
    description="En pedidos mayores a $500"
/>

<FaqItem
    question="¿Cuál es el tiempo de entrega?"
    answer="3 a 5 días hábiles."
/>

<StatValue
    :value="1250"
    label="Ventas"
    icon="bi bi-cart"
    :change="12"
/>
```

---

## Promotions

```
Promotions
├── PromotionCountdown    ✅ Countdown timer for deals
├── PromotionBanner      — Promotion banner (TODO)
└── PromotionBadge      — Promotion badge (TODO)
```

**API Example:**
```vue
<PromotionCountdown
    :end-date="promotionDate"
    label="Termina en"
/>
```

---

## Feedback / States

```
Feedback
├── EmptyState             ✅ Empty state with icon, title, description
├── LoadingState           ✅ Loading indicator with dots animation
├── ErrorState             ✅ Error message with retry action
├── SuccessState           ✅ Success message with check animation
├── OfflineState           ✅ Offline/no connection state
├── Skeleton               ✅ Skeleton with multiple variants (circle, text, etc.)
├── SkeletonGroup          ✅ Skeleton preset groups (card, list, product)
├── InlineMessage          ✅ Inline alert (info, success, warning, error, tip)
├── StatusBadge            ✅ Generic status badge with icon
├── ProgressBar           ✅ Progress bar with variants, sizes, striped
├── StepIndicator         ✅ Step indicator for wizards
├── Timeline              ✅ Timeline for events/history
├── Alert                 ✅ Alert with icon, title, dismissible
├── Callout                — Callout/highlight box (existing)
└── Notification           — Toast/notification (existing)
```

**API Example:**
```vue
<LoadingState message="Cargando..." />

<ErrorState
    title="Error de conexión"
    message="Verifica tu conexión."
    :show-retry="true"
/>

<SuccessState title="¡Listo!" message="Operación completada." />

<OfflineState />

<Skeleton variant="circle" />
<Skeleton variant="text" />
<SkeletonGroup variant="card" />

<ProgressBar :value="65" label="Progreso" show-value />
<ProgressBar :value="30" variant="success" striped animated />

<StepIndicator
    :steps="['Paso 1', 'Paso 2', 'Paso 3']"
    :current-step="1"
/>

<Timeline :items="timelineItems" />

<InlineMessage type="warning" title="Atención" message="Revisa los datos." />

<StatusBadge type="active" />
<StatusBadge type="pending" label="Pendiente" />

<EmptyState icon="bi bi-inbox" title="No hay resultados" />

<Alert type="error" title="Error" message="Algo salió mal." :dismissible="true" />
```

---

## Actions

```
Actions
├── ShareButton            ✅ Share via Web Share API
├── CopyButton            ✅ Copy to clipboard with feedback
├── FavoriteButton         ✅ Favorite toggle with animation
├── QuantitySelector       ✅ +/- quantity picker for cart
├── DownloadButton         — Download file (TODO)
├── ExternalLink           — External link indicator (TODO)
├── CallButton             — Click to call (TODO)
├── MessageButton          — Click to message (TODO)
└── DirectionsButton      ✅ Open directions (existing)
```

**API Example:**
```vue
<ShareButton
    title="Mi sitio"
    text="Mira esto"
    url="https://..."
/>

<CopyButton text="https://..." />

<FavoriteButton v-model="isFavorite" />

<QuantitySelector v-model="quantity" :min="1" :max="99" />
```

---

## Navigation

```
Navigation
├── NavigationMenu         — Main menu (existing)
├── NavigationList         — List navigation (existing)
├── NavigationRail         — Side rail navigation (existing)
├── BottomNav              — Bottom navigation bar (existing)
├── Breadcrumb             — Breadcrumb trail (existing)
├── UiTabs                 — Tab navigation (existing)
├── SegmentedControl       — Segmented picker (existing)
└── PanelTabs              — Panel tab navigation (existing)
```

---

## Primitives

```
Primitives
├── Button                 — Base button (existing)
├── IconButton             — Icon-only button (existing)
├── Input                  — Text input (existing)
├── Select                 — Dropdown select (existing)
├── Checkbox               — Checkbox (existing)
├── Switch                 — Toggle switch (existing)
├── RangeInput             — Range slider (existing)
├── FileInput              — File upload (existing)
├── SearchInput            — Search field (existing)
├── Dropdown               — Dropdown menu (existing)
├── Popover                — Popover tooltip (existing)
├── Tooltip                — Tooltip (existing)
├── Modal                  — Modal dialog (existing)
├── Drawer                 — Side drawer (existing)
├── Sheet                  — Bottom sheet (existing)
├── ActionSheet            — Action bottom sheet (existing)
├── Dialog                  — Dialog (existing)
├── Avatar                 — User avatar (existing)
├── Badge                  — Badge/tag (existing)
├── Tag                    — Tag element (existing)
├── Button group           — Button group (existing)
├── Control                — Form control wrapper (existing)
├── Field                  — Form field (existing)
├── Label                  — Form label (existing)
├── Icon                   — Bootstrap Icon wrapper (existing)
├── Spinner                — Loading spinner (existing)
├── Progress               — Progress bar (existing)
├── Stepper                — Step indicator (existing)
└── Accordion              — Accordion collapsible (existing)
```

---

## Structure Atoms

Components in `structure/` folders are atomic pieces meant to be composed:

```
products/structure/
├── ProductPrice           — Price with optional compare (existing)
└── ProductBadges          — Discount/stock badges (existing)

services/structure/
├── ServicePrice           — Price display (existing)
├── ServiceDuration        — Duration display (existing)
├── ServiceMeta            — Metadata (existing)
├── ServiceGallery         — Image gallery (existing)
├── ServiceBadges          — Featured/new badges (existing)
└── ServiceActions         — CTA buttons (existing)

contact/structure/
├── ContactDetails         — Contact info block (existing)
└── ContactStatus          — Availability status (existing)

profile/structure/
└── ProfileAvatar          — Avatar with fallback (existing)

catalog/structure/
├── CatalogBadge           — Catalog badge (existing)
└── CatalogPricing         — Price with period (existing)

cta/
├── CtaButton              — Button CTA (existing)
├── CtaArrow               — Arrow CTA (existing)
└── CtaIcon                — Icon CTA (existing)
```

---

## Composables (Logic Layer)

Reusable logic separated from presentation:

| Composable | Purpose | Status |
|------------|---------|--------|
| `useCalendar` | Calendar date calculations | TODO |
| `useBusinessHours` | Open/closed logic | TODO |
| `useAvailability` | Time slot availability | TODO |
| `useSocialLinks` | Social network URL generation | TODO |
| `useContactActions` | Phone/email/whatsapp URL generation | TODO |
| `useShare` | Web Share API wrapper | TODO |
| `useDirections` | Maps URL generation | TODO |

---

## Folder Structure

```
resources/js/Components/Ui/
├── calendar/              ✅ Calendar components
│   ├── MiniCalendar.vue
│   └── CalendarDay.vue
├── availability/          ✅ Availability components
│   ├── AvailabilityStatus.vue
│   ├── OpeningHours.vue
│   └── TimeSlot.vue
├── booking/              ✅ Booking components
│   ├── BookingProgress.vue
│   └── BookingSummary.vue
├── business/             ✅ Business info components
│   └── BusinessStatus.vue
├── contact/              ✅ Contact components (existing + new)
│   ├── ContactAction.vue
│   ├── ContactList.vue
│   ├── ContactCard.vue
│   └── structure/
├── social/                ✅ Social components
│   ├── SocialButton.vue
│   └── SocialLinks.vue
├── location/             ✅ Location components
│   ├── LocationCard.vue
│   ├── AddressBlock.vue
│   └── DirectionsButton.vue
├── events/               ✅ Event components
│   ├── EventDate.vue
│   ├── EventTime.vue
│   ├── EventLocation.vue
│   └── EventCard.vue
├── people/               ✅ People/profile components
│   ├── TeamMember.vue
│   └── TeamGrid.vue
├── reviews/              ✅ Review components
│   ├── Rating.vue
│   ├── RatingStars.vue
│   ├── ReviewCard.vue
│   └── ReviewSummary.vue
├── pricing/              ✅ Pricing components
│   ├── Price.vue
│   ├── OldPrice.vue
│   └── Discount.vue
├── properties/           ✅ Real Estate components
│   ├── PropertyCard.vue
│   ├── PropertyPrice.vue
│   ├── PropertyStatus.vue
│   └── PropertyFeatures.vue
├── actions/             ✅ Action components
│   ├── ShareButton.vue
│   ├── CopyButton.vue
│   ├── FavoriteButton.vue
│   └── QuantitySelector.vue
├── promotions/           ✅ Promotion components
│   └── PromotionCountdown.vue
├── feedback/           ✅ Feedback components
│   ├── EmptyState.vue
│   ├── LoadingState.vue
│   ├── ErrorState.vue
│   ├── SuccessState.vue
│   ├── OfflineState.vue
│   ├── InlineMessage.vue
│   ├── StatusBadge.vue
│   ├── Skeleton.vue
│   ├── SkeletonGroup.vue
│   ├── ProgressBar.vue
│   ├── StepIndicator.vue
│   ├── Timeline.vue
│   └── Alert.vue
├── services/             — Service components (existing)
├── products/             — Product components (existing)
├── media/                — Media components (existing)
├── actions/              — Action button components (TODO)
├── feedback/             — Feedback/state components (TODO)
├── navigation/           — Navigation components (existing)
├── primitives/            — Base primitives (TODO)
└── structure/            — Shared atomic components (existing pattern)
```

---

## Implemented Components (This Session)

| Component | File | Path |
|-----------|------|------|
| MiniCalendar | MiniCalendar.vue | Ui/calendar/ |
| CalendarDay | CalendarDay.vue | Ui/calendar/ |
| AvailabilityStatus | AvailabilityStatus.vue | Ui/availability/ |
| OpeningHours | OpeningHours.vue | Ui/availability/ |
| TimeSlot | TimeSlot.vue | Ui/availability/ |
| SocialButton | SocialButton.vue | Ui/social/ |
| SocialLinks | SocialLinks.vue | Ui/social/ |
| ContactAction | ContactAction.vue | Ui/contact/ |
| ContactList | ContactList.vue | Ui/contact/ |
| BusinessStatus | BusinessStatus.vue | Ui/business/ |
| Rating | Rating.vue | Ui/reviews/ |
| RatingStars | RatingStars.vue | Ui/reviews/ |
| ReviewCard | ReviewCard.vue | Ui/reviews/ |
| ReviewSummary | ReviewSummary.vue | Ui/reviews/ |
| EventDate | EventDate.vue | Ui/events/ |
| EventTime | EventTime.vue | Ui/events/ |
| EventLocation | EventLocation.vue | Ui/events/ |
| EventCard | EventCard.vue | Ui/events/ |
| LocationCard | LocationCard.vue | Ui/location/ |
| AddressBlock | AddressBlock.vue | Ui/location/ |
| DirectionsButton | DirectionsButton.vue | Ui/location/ |
| TeamMember | TeamMember.vue | Ui/people/ |
| TeamGrid | TeamGrid.vue | Ui/people/ |
| BookingProgress | BookingProgress.vue | Ui/booking/ |
| BookingSummary | BookingSummary.vue | Ui/booking/ |
| Price | Price.vue | Ui/pricing/ |
| OldPrice | OldPrice.vue | Ui/pricing/ |
| Discount | Discount.vue | Ui/pricing/ |
| PropertyCard | PropertyCard.vue | Ui/properties/ |
| PropertyPrice | PropertyPrice.vue | Ui/properties/ |
| PropertyStatus | PropertyStatus.vue | Ui/properties/ |
| PropertyFeatures | PropertyFeatures.vue | Ui/properties/ |

**Total: 63 components implemented**

---

## Migration Notes

### Bootstrap → Bulma
The following need CSS migration from Bootstrap to Bulma:
- VideoPlayer
- VideoPlaylist
- AudioPlayer
- Gallery
- MediaCard
- VideoCard
- Hero (and variants)

### Duplicate Consolidation
- OrpUI duplicates → migrate to Ui/ and remove OrpUI
- Minisite/old_components → remove, use Ui/ versions
- Minisite/components Hero variants → consolidate to Ui/heros/
