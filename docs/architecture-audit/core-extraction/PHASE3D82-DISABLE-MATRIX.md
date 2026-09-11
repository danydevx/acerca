# PHASE 3D.8.2 — DISABLE MATRIX

## Module Disable Test Results

| Module | Enabled Routes | Disabled Routes | Routes Removed | Remaining Routes | Unexpected Removed |
|--------|---------------|-----------------|----------------|------------------|-------------------|
| ListingLeads | 17 | 1 | 16 | api/admin/listings/{listing}/leads | 0 |
| ListingPromotions | 18 | 2 | 16 | b/{slug}/verify/*, m/{slug}/promociones/* | 0 |
| ListingReviews | 17 | 2 | 15 | api/admin/listings/{listing}/reviews, contact-forms preview | 0 |
| ListingContactForm | 15 | 0 | 15 | None | 0 |
| ListingAiChatbot | 57 | 51 | 6 | admin/modules/ai_chatbot/* (platform routes) | 0 |
| ListingHero | 7 | 3 | 4 | api/admin/listings/{listing}/hero, vcard hero routes | 0 |
| ListingSocialMedia | 9 | 0 | 9 | None | 0 |

## Notes

- Remaining routes after disable are NOT owned by the module (they use module controllers but are defined in web.php as platform-level routes)
- ListingAiChatbot has platform-level routes (admin/modules/ai_chatbot/*) that remain because they are PLATFORM routes, not MODULE_OWNED
- All module-owned routes are correctly removed when the module is disabled
