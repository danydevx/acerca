# PHASE3D8-LEGACY-AGGREGATORS

## ListingContentController

### Classification: LEGACY_AGGREGATOR

This is the primary legacy aggregator controller that concentrates CRUD operations for multiple domains.

### Route Count: 56

### Responsibilities by Domain

| Domain | Routes | Methods |
|--------|--------|---------|
| Appointments | 9 | GET, POST, PUT, DELETE |
| FaqCategories | 4 | GET, POST, PUT, DELETE |
| Faqs | 6 | GET, POST, PUT, DELETE |
| Galleries | 8 | GET, POST, PUT, DELETE |
| Gallery (single) | 4 | GET, POST, PUT, DELETE |
| Locations | 6 | GET, POST, PUT, DELETE |
| ProductCategories | 4 | GET, POST, PUT, DELETE |
| Products | 6 | GET, POST, PUT, DELETE |
| ServiceCategories | 4 | GET, POST, PUT, DELETE |
| Services | 6 | GET, POST, PUT, DELETE |

### Migration Status

These routes are served by Admin controllers in modules when enabled, but ListingContentController serves as a fallback/legacy aggregator.

### Notes

- Some of these domains already have proper modules with member routes
- The admin routes via this controller remain as legacy
- DO NOT migrate in this phase - requires careful decomposition

### Related Legacy Controllers

The following Admin controllers also serve module domains but are technically separate from ListingContentController:
- Admin\ListingHeroController
- Admin\ListingLeadsController
- Admin\ListingPromotionController
- Admin\ListingReviewController
- Admin\ListingSocialNetworkController
- Admin\ListingAiChatbotController
- Admin\ListingContactFormController

These are classified as MODULE_OWNED because they serve listing-specific domains that have or should have modules.

## Future Decomposition

ListingContentController will need to be decomposed into individual module admin controllers in a future phase.
