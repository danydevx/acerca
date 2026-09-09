# Component Roadmap — MiniWebs/vCards

Priority classification:
- **P0** — Fundamental, needed immediately for any MiniWeb
- **P1** — Very useful, enables many common use cases
- **P2** — Specialized but common enough to justify
- **P3** — Future, can wait

---

## P0 — Fundamental

### Calendar
| Component | Description | Status |
|-----------|-------------|--------|
| **MiniCalendar** | Mobile-first month calendar grid | ✅ DONE |
| **CalendarDay** | Single day cell | ✅ DONE |
| **CalendarEvent** | Event indicator on calendar | ✅ DONE (in CalendarDay) |
| **CalendarNavigation** | Month/year navigation | ✅ DONE (in MiniCalendar) |

### Availability
| Component | Description | Status |
|-----------|-------------|--------|
| **AvailabilityStatus** | Open/Closed indicator | ✅ DONE |
| **OpeningHours** | Weekly schedule display | ✅ DONE |
| **OpeningHoursDay** | Single day hours block | ✅ DONE (in OpeningHours) |

### Contact
| Component | Description | Status |
|-----------|-------------|--------|
| **ContactAction** | Single contact action (call, whatsapp, email) | ✅ DONE |
| **ContactList** | Group of contact actions | ✅ DONE |

### Social
| Component | Description | Status |
|-----------|-------------|--------|
| **SocialLinks** | Social network links list | ✅ DONE |
| **SocialButton** | Single social network button | ✅ DONE |

### Business
| Component | Description | Status |
|-----------|-------------|--------|
| **BusinessStatus** | Open/closed + hours summary | ✅ DONE |
| **BusinessHours** | Full schedule display | ✅ DONE (uses OpeningHours) |
| **BusinessInfo** | General business info block | TODO |

---

## P1 — Very Useful

### Calendar (continued)
| Component | Description | Status |
|-----------|-------------|--------|
| **DatePicker** | Full date selection UI | TODO |
| **DateRangePicker** | Start/end date selection | TODO |

### Availability (continued)
| Component | Description | Status |
|-----------|-------------|--------|
| **TimeSlot** | Single time slot button | ✅ DONE |
| **TimeSlotGroup** | Group of available times | TODO |
| **AvailabilitySlotList** | List of available slots for a day | TODO |

### Booking
| Component | Description | Status |
|-----------|-------------|--------|
| **BookingProgress** | Step indicator for multi-step flow | ✅ DONE |
| **BookingSummary** | Selected date/time/service summary | ✅ DONE |
| **BookingDateSelector** | Date selection UI | TODO |
| **BookingTimeSelector** | Time slot selection | TODO |

### Location
| Component | Description | Status |
|-----------|-------------|--------|
| **LocationCard** | Single location display | ✅ DONE |
| **AddressBlock** | Formatted address display | ✅ DONE |
| **DirectionsButton** | Open directions in maps app | ✅ DONE |

### Reviews
| Component | Description | Status |
|-----------|-------------|--------|
| **Rating** | Star rating display | ✅ DONE |
| **RatingStars** | Just the stars | ✅ DONE |
| **ReviewCard** | Single review display | ✅ DONE |
| **ReviewSummary** | Aggregate rating display | ✅ DONE |

### Events
| Component | Description | Status |
|-----------|-------------|--------|
| **EventDate** | Event date display | ✅ DONE |
| **EventTime** | Event time display | ✅ DONE |
| **EventLocation** | Event venue display | ✅ DONE |
| **EventCard** | Event listing card | ✅ DONE |

### People
| Component | Description | Status |
|-----------|-------------|--------|
| **TeamMember** | Single team member card | ✅ DONE |
| **TeamGrid** | Grid of team members | ✅ DONE |

### Real Estate
| Component | Description | Status |
|-----------|-------------|--------|
| **PropertyCard** | Full property card | ✅ DONE |
| **PropertyPrice** | Price display | ✅ DONE |
| **PropertyStatus** | Status badge | ✅ DONE |
| **PropertyFeatures** | Beds/baths/area | ✅ DONE |
| **PropertyImage** | Single property image | TODO |
| **PropertyGallery** | Property image gallery | TODO |

---

## P2 — Specialized

### Calendar
| Component | Description | Notes |
|-----------|-------------|-------|
| **CalendarHeader** | Month/year display with nav | Full month navigation bar |
| **CalendarWeek** | Single week row | 7-day row |
| **CalendarLegend** | Event type legend | Color key for events |
| **CalendarEventDot** | Dot indicator for event | Small colored dot |
| **MiniCalendar--compact** | Smaller calendar variant | For inline use |

### Booking (continued)
| Component | Description | Notes |
|-----------|-------------|-------|
| **GuestSelector** | Number of guests/people selector | For appointments |
| **AppointmentCard** | Single appointment display | Date, time, service, status |
| **AppointmentStatus** | Appointment status badge | Confirmed, pending, cancelled |
| **BookingProgress** | Multi-step booking progress | Step indicator |

### Events (continued)
| Component | Description | Notes |
|-----------|-------------|-------|
| **EventCard** | Event listing card | Date, title, location, price |
| **EventCountdown** | Countdown to event | Days/hours remaining |
| **EventSchedule** | List of event sessions | Schedule item list |
| **EventActions** | Event CTA buttons | Register, share, directions |

### Products
| Component | Description | Status |
|-----------|-------------|--------|
| **ProductImage** | Single product image | ✅ DONE |
| **ProductGallery** | Product image gallery | ✅ DONE |
| **ProductStock** | Stock availability indicator | ✅ DONE |
| **ProductMeta** | Product metadata | ✅ DONE |
| **ProductVariant** | Variant selector | ✅ DONE |

### Pricing
| Component | Description | Notes |
|-----------|-------------|-------|
| **Price** | Simple price display | Formatted currency |
| **OldPrice** | Strikethrough original price | For discounts |
| **Discount** | Discount badge | Percentage or amount |
| **PricingPlan** | Pricing plan card | Name, price, features, CTA |

### Media
| Component | Description | Notes |
|-----------|-------------|-------|
| **MediaPlaceholder** | Image/video placeholder | When no media |
| **VideoPreview** | Video thumbnail with play | For playlists |

### Feedback
| Component | Description | Notes |
|-----------|-------------|-------|
| **LoadingState** | Full loading indicator | For sections |
| **ErrorState** | Error message display | With retry action |
| **SuccessState** | Success confirmation | With icon |
| **InlineMessage** | Small inline message | Info, warning, error |

---

## P3 — Future

### Actions
| Component | Description | Notes |
|-----------|-------------|-------|
| **ShareButton** | Share via native share | Web Share API |
| **CopyButton** | Copy to clipboard | URL, text |
| **FavoriteButton** | Add to favorites | Toggle state |
| **DownloadButton** | Download file | With loading state |

### Location (continued)
| Component | Description | Notes |
|-----------|-------------|-------|
| **MapPreview** | Static map image | Placeholder until real map |
| **DistanceBadge** | Distance to location | "0.5 km away" |

### Reviews (continued)
| Component | Description | Notes |
|-----------|-------------|-------|
| **ReviewList** | List of reviews | With pagination/load more |
| **ReviewSource** | Review source badge | "Google", "Yelp" |

### People (continued)
| Component | Description | Notes |
|-----------|-------------|-------|
| **ProfileHeader** | Full profile header | Avatar, name, bio, credentials |
| **ProfileMeta** | Profile metadata | Role, location, joined date |
| **ProfileActions** | Profile CTA buttons | Message, follow, share |

### Events (continued)
| Component | Description | Notes |
|-----------|-------------|-------|
| **EventSpeaker** | Speaker info block | Photo, name, bio |
| **EventScheduleItem** | Single schedule session | Time, title, description |

### Business (continued)
| Component | Description | Notes |
|-----------|-------------|-------|
| **BusinessLogo** | Business logo display | With fallback |
| **BusinessCategory** | Category badge | e.g. "Restaurant" |
| **BusinessAmenities** | Amenities list | WiFi, parking, etc. |
| **BusinessBadge** | Trust/reputation badge | e.g. "Verified" |

### Calendar (continued)
| Component | Description | Notes |
|-----------|-------------|-------|
| **MiniCalendar--agenda** | Agenda view (list) | Events as list instead of grid |

---

## Priority Implementation Order

1. **MiniCalendar** — Base calendar component (P0)
2. **CalendarDay, CalendarEvent, CalendarNavigation** — Calendar atoms (P0)
3. **OpeningHours, OpeningHoursDay** — Schedule display (P0)
4. **AvailabilityStatus** — Open/closed indicator (P0)
5. **SocialLinks, SocialButton** — Social connectivity (P0)
6. **ContactAction, ContactList** — Contact actions (P0)
7. **BusinessStatus, BusinessHours** — Business info (P0)
8. **LocationCard, AddressBlock** — Location display (P1)
9. **Rating, ReviewCard, ReviewSummary** — Reviews/reputation (P1)
10. **DatePicker** — Full date picker (P1)
11. **TimeSlot, TimeSlotGroup** — Time selection (P1)
12. **BookingStep, BookingSummary** — Booking UI (P1)
13. **EventDate, EventTime, EventCard** — Events (P1)
14. **TeamMember, TeamGrid** — People/team (P1)
15. **Price, OldPrice, Discount** — Pricing atoms (P2)
16. **PricingPlan** — Pricing plan (P2)
17. **ProductImage, ProductGallery** — Product media (P2)
18. **EventCountdown, EventSchedule** — Event details (P2)
19. Remaining P2 and P3 as needed
