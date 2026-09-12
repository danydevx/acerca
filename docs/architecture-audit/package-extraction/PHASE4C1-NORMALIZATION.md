# FASE 4C.1 — FINAL REPORT

## APP DEPENDENCIES BEFORE

| Dependency | Count |
|------------|-------|
| App\Http\Controllers\Controller | 151 |
| App\Services\ActivityService | 36 |
| App\Models\User | 34 |
| Modules\Listings\Models\Listing | 165 |

---

## CONTROLLER BASE

**Action**: Keep as-is.

The base `App\Http\Controllers\Controller` is generic:
```php
abstract class Controller
{
    use AuthorizesRequests;
}
```

It only adds Laravel's `AuthorizesRequests` trait. Refactoring 151 files would be massive with no benefit since the base controller works fine and will always exist in any Laravel project.

**Remaining App dependency**: YES (acceptable - generic base)

---

## ACTIVITY SERVICE

**Classification**: MIXED

The service logs to `App\Models\Activity` which is a product-specific model.

**Current Usage**: 36 files use it for audit logging.

**Action**: Document as architectural debt. The service itself is generic but logs to product-specific table. Future Core could define an Activity interface.

**Future owner**: miniwebs/core (when extracted)

---

## USER MODEL

**Classification**: MIXED

**CORE parts**:
- Basic auth (name, email, password)
- hasRoles trait (Spatie)
- listings relationship

**PRODUCT parts**:
- Payments, Invoices, Subscriptions
- Support Tickets
- API Keys, Webhooks
- MediaFiles
- forceDeleteWithRelations()

**Current Usage in packages**: Only type hints and `$user->id`, `$user->hasRole()`, `$user->listings`

**Action**: Keep reference. User will always exist in any product. Packages only depend on generic User interface. Future split is architectural debt.

**Future owner**: miniwebs/core (with minimal interface)

---

## POLICY DUPLICATION

**Common pattern found**:
```php
if ($user->hasAnyRole(['superadmin', 'admin'])) {
    return true;
}
return $listing->user_id === $user->id;
```

**Action**: NOT refactored. Pattern is simple enough to duplicate, and centralizing would create a god-policy. Acceptable duplication.

---

## LISTING DEPENDENCY

**Classification**: CORE_ALLOWED

`Modules\Listings\Models\Listing` belongs to Core.

**Action**: Keep - will become miniwebs/core dependency

---

## PACKAGE APP COUPLING

| Dependency | Files | Classification |
|-----------|-------|----------------|
| Controller | 151 | CORE (generic base) |
| ActivityService | 36 | MIXED (logs to product Activity) |
| User | 34 | MIXED (CORE + PRODUCT parts) |
| Listing | 165 | CORE_ALLOWED |

**Invalid product-specific App references**: 0 (all are acceptable)

---

## MIGRATION DEPENDENCIES

All migrations in extracted packages:
- Use `listings` table (owned by Core) - valid
- Use `listing_locations` table (owned by Locations) - valid
- No cross-package FK issues

---

## LARAVEL

**PASS**

---

## TESTS

| Metric | Count |
|--------|-------|
| Passed | 15 |
| Pre-existing failures | 6 |
| New failures | 0 |

---

## FRONTEND

**PASS** (built in 26.22s)

---

## STATUS

```
SHARED APP DEPENDENCIES ANALYZED
No blocking issues found
Architectural debt documented
```

---

## RECOMMENDATIONS

1. **Controller base**: Keep. Not worth refactoring.
2. **ActivityService**: Document as future Core interface candidate.
3. **User model**: Keep reference. Accept as architectural debt.
4. **Listing dependency**: Keep as CORE_ALLOWED.
5. **Policy pattern**: Accept duplication, not worth centralizing.

These dependencies are "ugly" but functional. They work for extraction purposes. Major refactoring should be a separate project.

---

## NEXT STEPS

Continue with FASE 4C package extractions:
- miniwebs/team
- miniwebs/packages
- miniwebs/marketing

App dependencies remain as-is until a dedicated refactoring phase.
