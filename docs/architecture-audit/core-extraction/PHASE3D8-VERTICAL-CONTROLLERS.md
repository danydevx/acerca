# PHASE3D8-VERTICAL-CONTROLLERS

## Vertical Domain Controllers

Controllers for domains that have their own modules but may need separation.

### Member Vertical Controllers

| Controller | Module | Status |
|-----------|--------|--------|
| Member\AiChatbotController | ListingAiChatbot | In module |
| Member\ProjectController | N/A (standalone) | Vertical domain |
| Member\ProjectCategoryController | N/A (standalone) | Vertical domain |

### Observations

- `Member\AiChatbotController` - The module `Modules\ListingAiChatbot` exists and is enabled, but the Member controller is in `app/`. This is a MODULE_OWNED controller that should be migrated.

- `ProjectController` and `ProjectCategoryController` - These handle project portfolio functionality which may be a vertical domain. The module `Modules\ListingProjects` exists with its own controllers.

## Classification

These are verticals that may need their own module structure but currently exist as standalone features.

## Recommendations

1. **AiChatbotController** - Should migrate to `Modules\ListingAiChatbot\Http\Controllers\Member\AiChatbotController`

2. **Project controllers** - Currently in `app/` but there's a `Modules\ListingProjects` with its own controllers. Member controllers in `app/` may be unused or serving different purpose.

## Next Steps

Audit whether these controllers are actually used vs module controllers to determine if they are dead code or active.
