# PHASE3D8-PLATFORM-CONTROLLERS

## Platform Controllers

These are shared features that support the platform operation across all listings/domains.

### Admin Platform Controllers (~40 controllers)

| Controller | Routes | Purpose |
|-----------|--------|---------|
| PermissionController | 7 | Permissions management |
| RoleController | 6 | Roles management |
| PlanController | 6 | Subscription plans |
| LegalDocumentController | 7 | Legal documents |
| SystemAnnouncementController | 6 | Platform announcements |
| CouponController | 6 | Coupon management |
| HelpArticleController | 6 | Help content |
| MessageTemplateController | 6 | Notification templates |
| FeatureFlagController | 5 | Feature toggles |
| PaymentController | 5 | Payment management |
| UserProfileController | 5 | User profiles |
| QueueController | 6 | Job queue management |
| AutomationController | 3 | Automation rules |
| ApiKeyController | 3 | API key management |
| InvoiceController | 3 | Invoice viewing |
| SystemErrorController | 3 | Error tracking |
| WebhookController | 3 | Webhook management |
| SupportTicketController | 4 | Support tickets |
| SupportDepartmentController | 4 | Support departments |
| UserSubscriptionController | 4 | Subscription management |
| SystemModuleController | 2 | Module system |
| ModuleDefinitionController | 6 | Module definitions |
| ModuleSettingsController | 2 | Module settings |
| PlanFeatureFlagController | 2 | Plan features |
| SecurityEventController | 2 | Security audit |
| SettingController | 2 | Platform settings |
| ActivityController | 1 | Activity log |
| DashboardController | 1 | Admin dashboard |
| ReportController | 1 | Reports |
| SubscriptionController | 1 | Subscriptions |
| SystemMonitorController | 1 | System health |
| ExportController | 6 | Data export |
| ApiExplorerController | 2 | API documentation |

### Member Platform Controllers (~20 controllers)

| Controller | Routes | Purpose |
|-----------|--------|---------|
| WebhookController | 8 | Webhook management |
| MediaFileController | 5 | File uploads |
| CheckoutController | 5 | Payment checkout |
| SupportTicketController | 5 | Support tickets |
| ApiKeyController | 4 | API keys |
| NotificationController | 4 | Notifications |
| InvoiceController | 3 | Invoices |
| SessionController | 3 | Session management |
| NotificationPreferenceController | 2 | Notification settings |
| SystemAnnouncementController | 2 | Announcements |
| HelpArticleController | 2 | Help articles |
| IntegrationController | 2 | Integrations |
| PasswordController | 2 | Password change |
| PlanSelectionController | 2 | Plan selection |
| PreferenceController | 2 | User preferences |
| AccountController | 1 | Account view |
| ActivityController | 1 | Activity log |
| BillingController | 1 | Billing portal |
| DashboardController | 1 | Member dashboard |
| OnboardingController | 1 | Onboarding flow |
| PaymentController | 1 | Payment history |

### Root Controllers

| Controller | Routes | Purpose |
|-----------|--------|---------|
| HealthController | 1 | Health check endpoint |
| PricingController | 2 | Public pricing page |
| StripeWebhookController | 1 | Stripe webhooks |
| AiTestController | 2 | AI testing (dev) |

## Summary

Platform controllers handle cross-cutting concerns that are not specific to any single domain. They should remain in `app/` as they are fundamental platform infrastructure.
