# PHASE3D8-NEXT-MIGRATION

## Recommended Next Phase: 3D.8.1

## Immediate Migration Candidates

### 1. Admin\MinisiteThemeController (2 routes)

**Action:** Migrate to `Modules\ListingMinisite\Http\Controllers\Member\MinisiteThemeController`

**Rationale:**
- Serves MEMBER routes but lives in Admin namespace
- Should belong to `Modules\ListingMinisite` which already handles minisite content
- Simple migration: just move controller and update routes

**Risk:** LOW

### 2. Member\AiChatbotController (in app/)

**Action:** Audit and migrate to `Modules\ListingAiChatbot\Http\Controllers\Member\AiChatbotController`

**Rationale:**
- Module exists and is enabled
- Member controller should be in module

**Risk:** MEDIUM - need to verify module routes vs app routes don't conflict

## Candidates for Future Phases

### MODULE_OWNED Controllers (Admin namespace, module domains)

| Controller | Routes | Module | Priority |
|------------|--------|--------|----------|
| Admin\ListingLeadsController | 7 | ListingLeads | HIGH |
| Admin\ListingPromotionController | 6 | ListingPromotions | HIGH |
| Admin\ListingReviewController | 6 | ListingReviews | HIGH |
| Admin\ListingSocialNetworkController | 4 | ListingSocialMedia | MEDIUM |
| Admin\ListingHeroController | 2 | ListingHero | MEDIUM |
| Admin\ListingAiChatbotController | 1 | ListingAiChatbot | MEDIUM |
| Admin\ListingContactFormController | 1 | ListingContactForm | MEDIUM |

### LEGACY_AGGREGATOR

| Controller | Routes | Action |
|------------|--------|--------|
| Admin\ListingContentController | 56 | DECOMPOSE in separate phase |

## NOT Recommended for Migration

### Product Composition Controllers (should stay in app/)

- `Public\BusinessController`
- `Public\DirectoryController`
- `Public\BookingWidgetController`
- `Member\BusinessController`
- `Api\V1\Admin\BusinessController`
- `Wizard\BusinessController`

These intentionally compose multiple modules and should remain as product composition layer.

### Platform Controllers (should stay in app/)

All controllers classified as PLATFORM should remain in `app/` as they are fundamental platform infrastructure.

## Phase 3D.8.1 Scope

1. Migrate `Admin\MinisiteThemeController` to `Modules\ListingMinisite`
2. Audit `Member\AiChatbotController` - migrate if safe
3. Run full disable tests and validation
