<?php

use App\Http\Controllers\Admin\ActivityController as AdminActivityController;
use App\Http\Controllers\Admin\ApiKeyController as AdminApiKeyController;
use App\Http\Controllers\Admin\AutomationController;
use Modules\ListingAiChatbot\Http\Controllers\Admin\ChatbotPresetController;
use Modules\ListingAiChatbot\Http\Controllers\Admin\ChatbotPersonalityController;
use Modules\ListingAiChatbot\Http\Controllers\Admin\AiChatbotSettingsController;
use App\Http\Controllers\Admin\ListingController;
use App\Http\Controllers\Admin\ListingModuleController;
use App\Http\Controllers\Admin\ModuleDefinitionController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\FeatureFlagController;
use App\Http\Controllers\Admin\HelpArticleController;

use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\LegalDocumentController;
use Modules\Locations\Http\Controllers\Admin\LocationController as AdminLocationController;
use Modules\ListingRestaurantMenu\Http\Controllers\Admin\MenuCategoryController;
use Modules\ListingRestaurantMenu\Http\Controllers\Admin\MenuProductController;
use Modules\ListingRestaurantMenu\Http\Controllers\Admin\MenuProductImageController;
use Modules\ListingRestaurantMenu\Http\Controllers\Admin\MenuProductVariantController;
use App\Http\Controllers\Admin\MessageTemplateController;
use App\Http\Controllers\Admin\MinisiteThemeController;
use Modules\ListingMinisite\Http\Controllers\Admin\ListingMinisiteController as AdminListingMinisiteController;
use App\Http\Controllers\Admin\ModuleSettingsController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\PlanFeatureFlagController;
use App\Http\Controllers\Admin\QueueController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SecurityEventController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\SupportTicketController as AdminSupportTicketController;
use App\Http\Controllers\Admin\SupportDepartmentController;
use App\Http\Controllers\Admin\SystemAnnouncementController as AdminSystemAnnouncementController;
use App\Http\Controllers\Admin\SystemErrorController;
use App\Http\Controllers\Admin\SystemModuleController;
use App\Http\Controllers\Admin\SystemMonitorController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserSubscriptionController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\Admin\WebhookController as AdminWebhookController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LegalAcceptanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\Wizard\BusinessController as WizardBusinessController;
use App\Http\Controllers\Member\AccountController;
use App\Http\Controllers\Member\ActivityController as MemberActivityController;
use App\Http\Controllers\Member\ApiKeyController as MemberApiKeyController;
use App\Http\Controllers\Member\BillingController;
use App\Http\Controllers\Member\CheckoutController;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\HelpArticleController as MemberHelpArticleController;
use App\Http\Controllers\Member\IntegrationController;
use App\Http\Controllers\Member\InvoiceController as MemberInvoiceController;
use App\Http\Controllers\Member\LocationController;
use App\Http\Controllers\Member\MediaFileController as MemberMediaFileController;
use Modules\ListingRestaurantMenu\Http\Controllers\Member\MenuCategoryController as MemberMenuCategoryController;
use Modules\ListingRestaurantMenu\Http\Controllers\Member\MenuProductController as MemberMenuProductController;
use Modules\ListingRestaurantMenu\Http\Controllers\Member\MenuProductImageController as MemberMenuProductImageController;
use Modules\ListingRestaurantMenu\Http\Controllers\Member\MenuProductVariantController as MemberMenuProductVariantController;
use App\Http\Controllers\Member\NotificationController;
use App\Http\Controllers\Member\NotificationPreferenceController;
use App\Http\Controllers\Member\OnboardingController;
use App\Http\Controllers\Member\PasswordController;
use App\Http\Controllers\Member\PaymentController as MemberPaymentController;
use App\Http\Controllers\Member\PlanSelectionController;
use App\Http\Controllers\Member\PreferenceController as MemberPreferenceController;
use Modules\ListingProducts\Http\Controllers\ListingProductImageController;
use Modules\ListingProjects\Http\Controllers\ListingProjectImageController;
use Modules\Properties\Http\Controllers\Member\PropertyImageController;
use App\Http\Controllers\Member\SessionController as MemberSessionController;
use App\Http\Controllers\Member\SupportTicketController as MemberSupportTicketController;
use App\Http\Controllers\Member\SystemAnnouncementController as MemberSystemAnnouncementController;
use App\Http\Controllers\Member\WebhookController as MemberWebhookController;
use Modules\ListingMinisite\Http\Controllers\Member\ListingMinisiteController;
use Modules\ListingMinisite\Http\Controllers\Member\ListingMinisiteSectionController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\Public\BusinessController as PublicBusinessController;
use App\Http\Controllers\Public\DirectoryController;
use Modules\ListingRestaurantMenu\Http\Controllers\Public\MenuController;
use App\Http\Controllers\StripeWebhookController;
use App\Services\SettingService;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Modules\ListingFeatures\Http\Controllers\Member\FeatureController;
use Modules\ListingFeatures\Http\Controllers\Public\FeatureController as PublicFeatureController;
use Modules\ListingTasks\Http\Controllers\Member\TaskController;

require __DIR__ . '/ai_chatbot.php';
require __DIR__ . '/minisite_ai_chatbot.php';

Route::get('/', [DirectoryController::class, 'index']);

Route::get('/health', HealthController::class)->name('health');

Route::get('/orp-playground', [App\Http\Controllers\OrpPlaygroundController::class, 'index']);

Route::get('/bulma-playground', [App\Http\Controllers\BulmaPlaygroundController::class, 'index']);

Route::get('/maintenance', function () {
    $settings = app(SettingService::class);

    return Inertia::render('Public/Maintenance/Index', [
        'message' => $settings->get('system.maintenance_message') ?: 'El sistema esta en mantenimiento. Intente nuevamente mas tarde.',
        'title' => $settings->get('system.maintenance_title') ?: 'Mantenimiento en progreso',
    ]);
})->name('maintenance');

Route::get('/login', [LoginController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::post('/pricing/select/{plan}', [PricingController::class, 'select'])->name('pricing.select');
Route::get('/plans', function () {
    return redirect('/pricing');
})->name('plans');

Route::get('/negocios', [DirectoryController::class, 'index'])->name('directory.index');
Route::get('/negocios/{slug}', [DirectoryController::class, 'show'])->name('directory.show');

Route::get('/b/{slug}', [PublicBusinessController::class, 'show'])->name('public.business.show');
Route::get('/b/{slug}/locations', [PublicBusinessController::class, 'locations'])->name('public.business.locations');
Route::get('/b/{slug}/services', [PublicBusinessController::class, 'services'])->name('public.business.services');
Route::get('/b/{slug}/gallery', [PublicBusinessController::class, 'gallery'])->name('public.business.gallery');
Route::get('/b/{slug}/products', [PublicBusinessController::class, 'products'])->name('public.business.products');
Route::get('/b/{slug}/packages', [PublicBusinessController::class, 'packages'])->name('public.business.packages');
Route::get('/b/{slug}/features', [PublicFeatureController::class, 'index'])->name('public.business.features.index');
Route::get('/b/{slug}/menu', [MenuController::class, 'show'])->name('public.menu.show');

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');

Route::get('/dev/booking-test', function () {
    return view('dev.booking-test');
})->name('dev.booking-test');

Route::get('/terminos', function () {
    return view('legal.terminos', [
        'title' => 'Terminos de servicio',
    ]);
})->name('legal.terminos');

Route::get('/privacidad', function () {
    return view('legal.privacidad', [
        'title' => 'Politica de privacidad',
    ]);
})->name('legal.privacidad');

Route::get('/register', [RegisterController::class, 'showRegister'])
    ->middleware('guest')
    ->name('register');

Route::get('/legal/accept', [LegalAcceptanceController::class, 'show'])
    ->middleware('auth')
    ->name('legal.accept');
Route::post('/legal/accept', [LegalAcceptanceController::class, 'store'])
    ->middleware('auth')
    ->name('legal.accept.store');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware(['guest', 'throttle:login'])
    ->name('login.store');

Route::post('/register/wizard', [RegisterController::class, 'storeWizard'])
    ->middleware(['guest', 'throttle:register'])
    ->name('register.wizard.store');

Route::post('/register', [RegisterController::class, 'register'])
    ->middleware(['guest', 'throttle:register'])
    ->name('register.store');

Route::get('/onboarding/business', [WizardBusinessController::class, 'show'])
    ->middleware(['auth'])
    ->name('wizard.business');

Route::post('/onboarding/business', [WizardBusinessController::class, 'store'])
    ->middleware(['auth'])
    ->name('wizard.business.store');

Route::get('/auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])
    ->middleware('guest')
    ->name('social.redirect');

Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])
    ->middleware('guest')
    ->name('social.callback');

Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPassword'])
    ->middleware('guest')
    ->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
    ->middleware(['guest', 'throttle:password-email'])
    ->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showVerifyCode'])
    ->middleware('guest')
    ->name('password.verify');
Route::post('/reset-password/{token}/verify-code', [PasswordResetController::class, 'verifyCode'])
    ->middleware(['guest', 'throttle:password-verify'])
    ->name('password.verify-code');
Route::get('/reset-password/{token}/new-password', [PasswordResetController::class, 'showResetPasswordForm'])
    ->middleware('guest')
    ->name('password.reset');
Route::post('/reset-password/{token}', [PasswordResetController::class, 'resetPassword'])
    ->middleware(['guest', 'throttle:password-reset'])
    ->name('password.update');

Route::get('/email/verify', [EmailVerificationController::class, 'notice'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware(['auth', 'signed', 'throttle:email-verify'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:verification-resend'])
    ->name('verification.send');

Route::post('/logout', [LogoutController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/member', fn () => redirect()->route('member.dashboard'))
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member');

Route::get('/member/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.dashboard');

Route::get('/member/business-modules', fn () => redirect()->route('member.listings.index'))
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.business-modules.index');
Route::get('/member/listings', [App\Http\Controllers\Member\ListingModuleController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.index');
Route::get('/member/listings/{listing}/modules', [App\Http\Controllers\Member\ListingModulesController::class, 'show'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.modules');
Route::get('/member/listings/{listing}/edit', [App\Http\Controllers\Member\ListingModuleController::class, 'edit'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.edit');

Route::get('/member/listings/{listing}/modules', [App\Http\Controllers\Member\ListingModulesController::class, 'show'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.modules');

Route::put('/member/listings/{listing}/modules', [App\Http\Controllers\Member\ListingModuleController::class, 'update'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.business-modules.update');


Route::post('/member/listings/{listing}/properties/{property}/images', [PropertyImageController::class, 'store'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.properties.images.store');
Route::delete('/member/listings/{listing}/properties/{property}/images/{image}', [PropertyImageController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.properties.images.destroy');
Route::put('/member/listings/{listing}/properties/{property}/images/{image}/set-main', [PropertyImageController::class, 'setMain'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.properties.images.set-main');

Route::get('/member/listings/{listing}/minisite', [ListingMinisiteController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.minisite.index');
Route::post('/member/listings/{listing}/minisite', [ListingMinisiteController::class, 'store'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.minisite.store');
Route::put('/member/listings/{listing}/minisite', [ListingMinisiteController::class, 'update'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.minisite.update');

Route::get('/member/listings/{listing}/minisite/sections', [ListingMinisiteSectionController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.minisite.sections.index');
Route::get('/member/listings/{listing}/minisite/sections/create', [ListingMinisiteSectionController::class, 'create'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.minisite.sections.create');
Route::post('/member/listings/{listing}/minisite/sections', [ListingMinisiteSectionController::class, 'store'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.minisite.sections.store');
Route::get('/member/listings/{listing}/minisite/sections/{section}/edit', [ListingMinisiteSectionController::class, 'edit'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.minisite.sections.edit');
Route::put('/member/listings/{listing}/minisite/sections/{section}', [ListingMinisiteSectionController::class, 'update'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.minisite.sections.update');
Route::delete('/member/listings/{listing}/minisite/sections/{section}', [ListingMinisiteSectionController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.minisite.sections.destroy');
Route::post('/member/listings/{listing}/minisite/sections/reorder', [ListingMinisiteSectionController::class, 'reorder'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.minisite.sections.reorder');

Route::get('/member/listings/{listing}/tasks', [TaskController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.tasks.index');
Route::post('/member/listings/{listing}/tasks', [TaskController::class, 'store'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.tasks.store');
Route::put('/member/listings/{listing}/tasks/{task}', [TaskController::class, 'update'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.tasks.update');
Route::delete('/member/listings/{listing}/tasks/{task}', [TaskController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.tasks.destroy');
Route::post('/member/listings/{listing}/tasks/{task}/archive', [TaskController::class, 'archive'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.tasks.archive');
Route::post('/member/listings/{listing}/tasks/reorder', [TaskController::class, 'reorder'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.tasks.reorder');

Route::post('/member/listings/{listing}/projects/{project}/images', [ListingProjectImageController::class, 'store'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.projects.images.store');
Route::delete('/member/listings/{listing}/projects/{project}/images/{image}', [ListingProjectImageController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.projects.images.destroy');

Route::get('/member/listings/{listing}/features', [FeatureController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.features.index');
Route::post('/member/listings/{listing}/features', [FeatureController::class, 'store'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.features.store');
Route::post('/member/listings/{listing}/features/import', [FeatureController::class, 'importBulk'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.features.import-bulk');
Route::post('/member/listings/{listing}/features/import/{feature}', [FeatureController::class, 'import'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.features.import');
Route::put('/member/listings/{listing}/features/{feature}', [FeatureController::class, 'update'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.features.update');
Route::delete('/member/listings/{listing}/features/{feature}', [FeatureController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.features.destroy');
Route::put('/member/listings/{listing}/feature-assignments', [FeatureController::class, 'updateAssignment'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.feature-assignments.update');
Route::delete('/member/listings/{listing}/feature-assignments/{assignment}', [FeatureController::class, 'removeAssignment'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.feature-assignments.remove');
Route::post('/member/listings/{listing}/features/reorder', [FeatureController::class, 'reorder'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.features.reorder');
Route::delete('/member/listings/{listing}/features/unlink-all', [FeatureController::class, 'unlinkAll'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.features.unlink-all');

Route::get('/member/listings/{listing}/menu-categories', [MemberMenuCategoryController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.categories.index');
Route::post('/member/listings/{listing}/menu-categories', [MemberMenuCategoryController::class, 'store'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.categories.store');
Route::put('/member/listings/{listing}/menu-categories/{category}', [MemberMenuCategoryController::class, 'update'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.categories.update');
Route::delete('/member/listings/{listing}/menu-categories/{category}', [MemberMenuCategoryController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.categories.destroy');

Route::get('/member/listings/{listing}/menu-products', [MemberMenuProductController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.products.index');
Route::get('/member/listings/{listing}/menu-products/create', [MemberMenuProductController::class, 'create'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.products.create');
Route::post('/member/listings/{listing}/menu-products', [MemberMenuProductController::class, 'store'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.products.store');
Route::post('/member/listings/{listing}/menu-products/reorder', [MemberMenuProductController::class, 'reorder'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.products.reorder');
Route::post('/member/listings/{listing}/menu-products/bulk-delete', [MemberMenuProductController::class, 'bulkDelete'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.products.bulk-delete');
Route::get('/member/listings/{listing}/menu-products/{product}/edit', [MemberMenuProductController::class, 'edit'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.products.edit');
Route::put('/member/listings/{listing}/menu-products/{product}', [MemberMenuProductController::class, 'update'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.products.update');
Route::delete('/member/listings/{listing}/menu-products/{product}', [MemberMenuProductController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.products.destroy');
Route::post('/member/listings/{listing}/menu-products/{product}/clone', [MemberMenuProductController::class, 'clone'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.products.clone');
Route::post('/member/listings/{listing}/menu-products/{product}/variants', [MemberMenuProductVariantController::class, 'store'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.products.variants.store');
Route::put('/member/listings/{listing}/menu-products/{product}/variants/{variant}', [MemberMenuProductVariantController::class, 'update'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.products.variants.update');
Route::delete('/member/listings/{listing}/menu-products/{product}/variants/{variant}', [MemberMenuProductVariantController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.products.variants.destroy');
Route::post('/member/listings/{listing}/menu-products/{product}/images', [MemberMenuProductImageController::class, 'store'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.products.images.store');
Route::put('/member/listings/{listing}/menu-products/{product}/images/{image}', [MemberMenuProductImageController::class, 'update'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.products.images.update');
Route::delete('/member/listings/{listing}/menu-products/{product}/images/{image}', [MemberMenuProductImageController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.menu.products.images.destroy');



Route::get('/member/account', [AccountController::class, 'show'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.account.show');

Route::post('/member/billing/portal', [BillingController::class, 'portal'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:billing', 'throttle:billing-portal'])
    ->name('member.billing.portal');

Route::post('/member/checkout/{plan}', [CheckoutController::class, 'create'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:billing', 'throttle:checkout-create'])
    ->name('member.checkout.create');
Route::post('/member/checkout/coupon/validate', [CheckoutController::class, 'validateCoupon'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:billing', 'throttle:checkout-coupon'])
    ->name('member.checkout.coupon.validate');
Route::put('/member/checkout/coupon/clear', [CheckoutController::class, 'clearCoupon'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:billing'])
    ->name('member.checkout.coupon.clear');
Route::get('/member/checkout/success', [CheckoutController::class, 'success'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:billing'])
    ->name('member.checkout.success');
Route::get('/member/checkout/cancel', [CheckoutController::class, 'cancel'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:billing'])
    ->name('member.checkout.cancel');

Route::get('/member/plan-selection', [PlanSelectionController::class, 'show'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:billing'])
    ->name('member.plan-selection.show');

Route::get('/member/integrations', [IntegrationController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:integrations'])
    ->name('member.integrations.index');
Route::get('/member/integrations/docs', [IntegrationController::class, 'apiDocumentation'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:integrations'])
    ->name('member.integrations.docs');
Route::put('/member/plan-selection/clear', [PlanSelectionController::class, 'clear'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:billing'])
    ->name('member.plan-selection.clear');

Route::get('/member/profile', [UserProfileController::class, 'editMember'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.profile.edit');

Route::get('/member/password', [PasswordController::class, 'edit'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.password.edit');
Route::put('/member/password', [PasswordController::class, 'update'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.password.update');

Route::put('/member/onboarding/complete', [OnboardingController::class, 'complete'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.onboarding.complete');

Route::get('/member/notifications', [NotificationController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:notifications'])
    ->name('member.notifications.index');
Route::get('/member/notifications/unread-count', [NotificationController::class, 'unreadCount'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:notifications'])
    ->name('member.notifications.unread-count');
Route::put('/member/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:notifications'])
    ->name('member.notifications.read');
Route::put('/member/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:notifications'])
    ->name('member.notifications.read-all');

Route::get('/member/announcements/active', [MemberSystemAnnouncementController::class, 'active'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:announcements'])
    ->name('member.announcements.active');
Route::put('/member/announcements/{announcement}/dismiss', [MemberSystemAnnouncementController::class, 'dismiss'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:announcements'])
    ->name('member.announcements.dismiss');

Route::get('/member/notification-preferences', [NotificationPreferenceController::class, 'edit'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:notifications'])
    ->name('member.notification-preferences.edit');
Route::put('/member/notification-preferences', [NotificationPreferenceController::class, 'update'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:notifications'])
    ->name('member.notification-preferences.update');

Route::get('/member/activity', [MemberActivityController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:activity'])
    ->name('member.activity.index');

Route::get('/member/payments', [MemberPaymentController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:billing'])
    ->name('member.payments.index');

Route::get('/member/invoices', [MemberInvoiceController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:billing'])
    ->name('member.invoices.index');
Route::get('/member/invoices/{invoice}', [MemberInvoiceController::class, 'show'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:billing'])
    ->name('member.invoices.show');
Route::get('/member/invoices/{invoice}/download', [MemberInvoiceController::class, 'download'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:billing'])
    ->name('member.invoices.download');

Route::get('/member/support', [MemberSupportTicketController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:support'])
    ->name('member.support.index');
Route::get('/member/support/create', [MemberSupportTicketController::class, 'create'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:support'])
    ->name('member.support.create');
Route::post('/member/support', [MemberSupportTicketController::class, 'store'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:support', 'throttle:ticket-create'])
    ->name('member.support.store');
Route::get('/member/support/{ticket}', [MemberSupportTicketController::class, 'show'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:support'])
    ->name('member.support.show');
Route::post('/member/support/{ticket}/reply', [MemberSupportTicketController::class, 'reply'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:support', 'throttle:ticket-reply'])
    ->name('member.support.reply');

Route::get('/member/api-keys', [MemberApiKeyController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'permission:api-keys.manage', 'module:api'])
    ->name('member.api-keys.index');
Route::post('/member/api-keys', [MemberApiKeyController::class, 'store'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'permission:api-keys.manage', 'module:api', 'throttle:api-keys-create'])
    ->name('member.api-keys.store');
Route::put('/member/api-keys/{apiKey}', [MemberApiKeyController::class, 'update'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'permission:api-keys.manage', 'module:api'])
    ->name('member.api-keys.update');
Route::delete('/member/api-keys/{apiKey}', [MemberApiKeyController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'permission:api-keys.manage', 'module:api'])
    ->name('member.api-keys.destroy');

Route::get('/member/webhooks', [MemberWebhookController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'permission:webhooks.manage', 'module:webhooks'])
    ->name('member.webhooks.index');
Route::post('/member/webhooks', [MemberWebhookController::class, 'store'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'permission:webhooks.manage', 'module:webhooks'])
    ->name('member.webhooks.store');
Route::put('/member/webhooks/{webhook}', [MemberWebhookController::class, 'update'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'permission:webhooks.manage', 'module:webhooks'])
    ->name('member.webhooks.update');
Route::delete('/member/webhooks/{webhook}', [MemberWebhookController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'permission:webhooks.manage', 'module:webhooks'])
    ->name('member.webhooks.destroy');
Route::post('/member/webhooks/{webhook}/test', [MemberWebhookController::class, 'test'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'permission:webhooks.manage', 'module:webhooks'])
    ->name('member.webhooks.test');
Route::post('/member/webhooks/{webhook}/regenerate-secret', [MemberWebhookController::class, 'regenerateSecret'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'permission:webhooks.manage', 'module:webhooks'])
    ->name('member.webhooks.regenerate-secret');
Route::get('/member/webhooks/{webhook}/deliveries', [MemberWebhookController::class, 'deliveries'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'permission:webhooks.manage', 'module:webhooks'])
    ->name('member.webhooks.deliveries');
Route::post('/member/webhooks/deliveries/{delivery}/retry', [MemberWebhookController::class, 'retryDelivery'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'permission:webhooks.manage', 'module:webhooks'])
    ->name('member.webhooks.deliveries.retry');

Route::get('/member/help', [MemberHelpArticleController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:support'])
    ->name('member.help.index');
Route::get('/member/help/{slug}', [MemberHelpArticleController::class, 'show'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:support'])
    ->name('member.help.show');

Route::get('/member/preferences', [MemberPreferenceController::class, 'edit'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.preferences.edit');
Route::put('/member/preferences', [MemberPreferenceController::class, 'update'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.preferences.update');

Route::get('/member/files', [MemberMediaFileController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:media'])
    ->name('member.files.index');
Route::post('/member/files', [MemberMediaFileController::class, 'store'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:media'])
    ->name('member.files.store');
Route::get('/member/files/{file}', [MemberMediaFileController::class, 'show'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:media'])
    ->name('member.files.show');
Route::get('/member/files/{file}/download', [MemberMediaFileController::class, 'download'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:media'])
    ->name('member.files.download');
Route::delete('/member/files/{file}', [MemberMediaFileController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'active', 'role:member', 'module:media'])
    ->name('member.files.destroy');

Route::get('/member/sessions', [MemberSessionController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.sessions.index');
Route::delete('/member/sessions/others', [MemberSessionController::class, 'destroyOthers'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.sessions.destroy-others');
Route::delete('/member/sessions/{session}', [MemberSessionController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.sessions.destroy');

Route::get('/profile', [UserProfileController::class, 'edit'])
    ->middleware('auth')
    ->name('profile.edit');
Route::post('/profile', [UserProfileController::class, 'update'])
    ->middleware('auth')
    ->name('profile.update');

Route::get('/admin/profile', [UserProfileController::class, 'edit'])
    ->middleware('auth')
    ->name('admin.profile.edit');
Route::post('/admin/profile', [UserProfileController::class, 'update'])
    ->middleware('auth')
    ->name('admin.profile.update');

Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->middleware(['auth', 'admin_or_user:1'])
    ->name('admin.dashboard');

Route::get('/admin/api-explorer', [App\Http\Controllers\Admin\ApiExplorerController::class, 'index'])
    ->middleware(['auth', 'admin_or_user:1'])
    ->name('admin.api-explorer.index');

Route::post('/admin/api-explorer/fetch', [App\Http\Controllers\Admin\ApiExplorerController::class, 'fetch'])
    ->middleware(['auth', 'admin_or_user:1'])
    ->name('admin.api-explorer.fetch');

Route::prefix('admin')->middleware(['auth', 'admin_or_user:1'])->group(function () {

    Route::get('/locations', [AdminLocationController::class, 'index'])
        ->name('admin.locations.index');
    Route::get('/locations/countries', [AdminLocationController::class, 'countriesIndex'])
        ->name('admin.locations.countries.index');
    Route::post('/locations/countries', [AdminLocationController::class, 'countriesStore'])
        ->name('admin.locations.countries.store');
    Route::put('/locations/countries/{country}', [AdminLocationController::class, 'countriesUpdate'])
        ->name('admin.locations.countries.update');

    Route::get('/locations/states', [AdminLocationController::class, 'statesIndex'])
        ->name('admin.locations.states.index');
    Route::post('/locations/states', [AdminLocationController::class, 'statesStore'])
        ->name('admin.locations.states.store');
    Route::put('/locations/states/{state}', [AdminLocationController::class, 'statesUpdate'])
        ->name('admin.locations.states.update');

    Route::get('/locations/municipalities', [AdminLocationController::class, 'municipalitiesIndex'])
        ->name('admin.locations.municipalities.index');
    Route::post('/locations/municipalities', [AdminLocationController::class, 'municipalitiesStore'])
        ->name('admin.locations.municipalities.store');
    Route::put('/locations/municipalities/{municipality}', [AdminLocationController::class, 'municipalitiesUpdate'])
        ->name('admin.locations.municipalities.update');

    Route::get('/listings/{listing}/modules', [ListingModuleController::class, 'edit'])
        ->name('admin.business-modules.edit');
    Route::put('/listings/{listing}/modules', [ListingModuleController::class, 'update'])
        ->name('admin.business-modules.update');

    Route::get('/listings', [ListingController::class, 'index'])
        ->name('admin.listings.index');
    Route::get('/listings/create', [ListingController::class, 'create'])
        ->name('admin.listings.create');
    Route::post('/listings', [ListingController::class, 'store'])
        ->name('admin.listings.store');
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])
        ->name('admin.listings.edit');
    Route::put('/listings/{listing}', [ListingController::class, 'update'])
        ->name('admin.listings.update');
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])
        ->name('admin.listings.destroy');

    // Location routes moved to Modules/ListingLocations/routes/admin.php

    // Service routes moved to Modules/ListingServices/routes/admin.php
    // Service image routes already in module: admin.business.services.images.*

    // FAQ routes moved to Modules/ListingFaqs/routes/admin.php

    // Product routes moved to Modules/ListingProducts/routes/admin.php

    // Gallery routes moved to Modules/ListingGallery/routes/admin.php

    // Appointment routes moved to Modules/ListingAppointments/routes/admin.php

    Route::get('/modules/ai_chatbot/settings', [AiChatbotSettingsController::class, 'show'])
        ->name('admin.modules.ai-chatbot.settings');

    Route::get('/modules/ai_chatbot/presets', [ChatbotPresetController::class, 'index'])
        ->name('admin.modules.ai-chatbot.presets.index');
    Route::get('/modules/ai_chatbot/presets/create', [ChatbotPresetController::class, 'create'])
        ->name('admin.modules.ai-chatbot.presets.create');
    Route::post('/modules/ai_chatbot/presets', [ChatbotPresetController::class, 'store'])
        ->name('admin.modules.ai-chatbot.presets.store');
    Route::get('/modules/ai_chatbot/presets/{preset}/edit', [ChatbotPresetController::class, 'edit'])
        ->name('admin.modules.ai-chatbot.presets.edit');
    Route::put('/modules/ai_chatbot/presets/{preset}', [ChatbotPresetController::class, 'update'])
        ->name('admin.modules.ai-chatbot.presets.update');
    Route::delete('/modules/ai_chatbot/presets/{preset}', [ChatbotPresetController::class, 'destroy'])
        ->name('admin.modules.ai-chatbot.presets.destroy');
    Route::post('/modules/ai_chatbot/presets/{preset}/toggle', [ChatbotPresetController::class, 'toggle'])
        ->name('admin.modules.ai-chatbot.presets.toggle');
    Route::post('/modules/ai_chatbot/presets/{preset}/duplicate', [ChatbotPresetController::class, 'duplicate'])
        ->name('admin.modules.ai-chatbot.presets.duplicate');

    Route::get('/modules/ai_chatbot/personalities', [ChatbotPersonalityController::class, 'index'])
        ->name('admin.modules.ai-chatbot.personalities.index');
    Route::get('/modules/ai_chatbot/personalities/create', [ChatbotPersonalityController::class, 'create'])
        ->name('admin.modules.ai-chatbot.personalities.create');
    Route::post('/modules/ai_chatbot/personalities', [ChatbotPersonalityController::class, 'store'])
        ->name('admin.modules.ai-chatbot.personalities.store');
    Route::get('/modules/ai_chatbot/personalities/{personality}/edit', [ChatbotPersonalityController::class, 'edit'])
        ->name('admin.modules.ai-chatbot.personalities.edit');
    Route::put('/modules/ai_chatbot/personalities/{personality}', [ChatbotPersonalityController::class, 'update'])
        ->name('admin.modules.ai-chatbot.personalities.update');
    Route::delete('/modules/ai_chatbot/personalities/{personality}', [ChatbotPersonalityController::class, 'destroy'])
        ->name('admin.modules.ai-chatbot.personalities.destroy');

    // Redirects from old routes to new routes
    Route::get('/chatbot-presets', function () {
        return redirect()->route('admin.modules.ai-chatbot.presets.index');
    });
    Route::get('/chatbot-presets/create', function () {
        return redirect()->route('admin.modules.ai-chatbot.presets.create');
    });
    Route::get('/chatbot-personalities', function () {
        return redirect()->route('admin.modules.ai-chatbot.personalities.index');
    });
    Route::get('/chatbot-personalities/create', function () {
        return redirect()->route('admin.modules.ai-chatbot.personalities.create');
    });

    Route::get('/listings/{listing}/menu-categories', [MenuCategoryController::class, 'index'])
        ->name('admin.menu.categories.index');
    Route::post('/listings/{listing}/menu-categories', [MenuCategoryController::class, 'store'])
        ->name('admin.menu.categories.store');
    Route::put('/listings/{listing}/menu-categories/{category}', [MenuCategoryController::class, 'update'])
        ->name('admin.menu.categories.update');
    Route::delete('/listings/{listing}/menu-categories/{category}', [MenuCategoryController::class, 'destroy'])
        ->name('admin.menu.categories.destroy');

    Route::get('/listings/{listing}/menu-products', [MenuProductController::class, 'index'])
        ->name('admin.menu.products.index');
    Route::post('/listings/{listing}/menu-products', [MenuProductController::class, 'store'])
        ->name('admin.menu.products.store');
    Route::put('/listings/{listing}/menu-products/{product}', [MenuProductController::class, 'update'])
        ->name('admin.menu.products.update');
    Route::delete('/listings/{listing}/menu-products/{product}', [MenuProductController::class, 'destroy'])
        ->name('admin.menu.products.destroy');
    Route::post('/listings/{listing}/menu-products/{product}/variants', [MenuProductVariantController::class, 'store'])
        ->name('admin.menu.products.variants.store');
    Route::put('/listings/{listing}/menu-products/{product}/variants/{variant}', [MenuProductVariantController::class, 'update'])
        ->name('admin.menu.products.variants.update');
    Route::delete('/listings/{listing}/menu-products/{product}/variants/{variant}', [MenuProductVariantController::class, 'destroy'])
        ->name('admin.menu.products.variants.destroy');
    Route::post('/listings/{listing}/menu-products/{product}/images', [MenuProductImageController::class, 'store'])
        ->name('admin.menu.products.images.store');
    Route::put('/listings/{listing}/menu-products/{product}/images/{image}', [MenuProductImageController::class, 'update'])
        ->name('admin.menu.products.images.update');
    Route::delete('/listings/{listing}/menu-products/{product}/images/{image}', [MenuProductImageController::class, 'destroy'])
        ->name('admin.menu.products.images.destroy');

    Route::get('/settings', [SettingController::class, 'index'])
        ->middleware('permission_or_user:settings.view,1')
        ->name('admin.settings.index');
    Route::post('/settings', [SettingController::class, 'update'])
        ->middleware('permission_or_user:settings.update,1')
        ->name('admin.settings.update');

    Route::get('/users', [UserController::class, 'index'])
        ->middleware('permission_or_user:users.view,1')
        ->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])
        ->middleware('permission_or_user:users.create,1')
        ->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])
        ->middleware('permission_or_user:users.create,1')
        ->name('admin.users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->middleware('permission_or_user:users.update,1')
        ->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])
        ->middleware('permission_or_user:users.update,1')
        ->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->middleware('permission_or_user:users.delete,1')
        ->name('admin.users.destroy');
    Route::put('/users/{user}/activate', [UserController::class, 'activate'])
        ->middleware('permission_or_user:users.activate,1')
        ->name('admin.users.activate');
    Route::put('/users/{user}/deactivate', [UserController::class, 'deactivate'])
        ->middleware('permission_or_user:users.deactivate,1')
        ->name('admin.users.deactivate');
    Route::post('/users/{user}/resend-verification', [UserController::class, 'resendVerification'])
        ->middleware('permission_or_user:users.resend_verification,1')
        ->name('admin.users.resend-verification');
    Route::put('/users/{user}/verify-email', [UserController::class, 'verifyEmail'])
        ->middleware('permission_or_user:users.update,1')
        ->name('admin.users.verify-email');
    Route::get('/users/archived', [UserController::class, 'archived'])
        ->middleware('permission_or_user:users.view,1')
        ->name('admin.users.archived');
    Route::post('/users/{user}/restore', [UserController::class, 'restore'])
        ->middleware('permission_or_user:users.restore,1')
        ->name('admin.users.restore');
    Route::delete('/users/{user}/force', [UserController::class, 'forceDestroy'])
        ->middleware('permission_or_user:users.force_delete,1')
        ->name('admin.users.force-destroy');

    Route::get('/users/{user}/subscriptions', [UserSubscriptionController::class, 'index'])
        ->middleware('permission_or_user:users.view,1')
        ->name('admin.users.subscriptions.index');
    Route::post('/users/{user}/subscriptions', [UserSubscriptionController::class, 'store'])
        ->middleware('permission_or_user:users.edit,1')
        ->name('admin.users.subscriptions.store');
    Route::put('/users/{user}/subscriptions', [UserSubscriptionController::class, 'update'])
        ->middleware('permission_or_user:users.edit,1')
        ->name('admin.users.subscriptions.update');
    Route::delete('/users/{user}/subscriptions', [UserSubscriptionController::class, 'destroy'])
        ->middleware('permission_or_user:users.edit,1')
        ->name('admin.users.subscriptions.destroy');

    Route::get('/legal-documents', [LegalDocumentController::class, 'index'])
        ->middleware(['permission_or_user:legal-documents.view,1', 'module:legal'])
        ->name('admin.legal-documents.index');
    Route::get('/legal-documents/create', [LegalDocumentController::class, 'create'])
        ->middleware(['permission_or_user:legal-documents.create,1', 'module:legal'])
        ->name('admin.legal-documents.create');
    Route::post('/legal-documents', [LegalDocumentController::class, 'store'])
        ->middleware(['permission_or_user:legal-documents.create,1', 'module:legal'])
        ->name('admin.legal-documents.store');
    Route::get('/legal-documents/{document}', [LegalDocumentController::class, 'show'])
        ->middleware(['permission_or_user:legal-documents.view,1', 'module:legal'])
        ->name('admin.legal-documents.show');
    Route::get('/legal-documents/{document}/edit', [LegalDocumentController::class, 'edit'])
        ->middleware(['permission_or_user:legal-documents.update,1', 'module:legal'])
        ->name('admin.legal-documents.edit');
    Route::put('/legal-documents/{document}', [LegalDocumentController::class, 'update'])
        ->middleware(['permission_or_user:legal-documents.update,1', 'module:legal'])
        ->name('admin.legal-documents.update');
    Route::delete('/legal-documents/{document}', [LegalDocumentController::class, 'destroy'])
        ->middleware(['permission_or_user:legal-documents.delete,1', 'module:legal'])
        ->name('admin.legal-documents.destroy');

    Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');

    Route::get('/activity', [AdminActivityController::class, 'index'])
        ->middleware(['permission_or_user:activity.view,1', 'module:activity'])
        ->name('admin.activity.index');

    Route::get('/exports', [ExportController::class, 'index'])
        ->middleware(['permission_or_user:exports.view,1', 'module:exports'])
        ->name('admin.exports.index');
    Route::get('/exports/users', [ExportController::class, 'users'])
        ->middleware(['permission_or_user:exports.download,1', 'module:exports'])
        ->name('admin.exports.users');
    Route::get('/exports/subscriptions', [ExportController::class, 'subscriptions'])
        ->middleware(['permission_or_user:exports.download,1', 'module:exports'])
        ->name('admin.exports.subscriptions');
    Route::get('/exports/payments', [ExportController::class, 'payments'])
        ->middleware(['permission_or_user:exports.download,1', 'module:exports'])
        ->name('admin.exports.payments');
    Route::get('/exports/tickets', [ExportController::class, 'tickets'])
        ->middleware(['permission_or_user:exports.download,1', 'module:exports'])
        ->name('admin.exports.tickets');
    Route::get('/exports/activities', [ExportController::class, 'activities'])
        ->middleware(['permission_or_user:exports.download,1', 'module:exports'])
        ->name('admin.exports.activities');

    Route::get('/system-errors', [SystemErrorController::class, 'index'])
        ->middleware(['permission_or_user:system-errors.view,1', 'module:system-errors'])
        ->name('admin.system-errors.index');
    Route::get('/system-errors/{error}', [SystemErrorController::class, 'show'])
        ->middleware(['permission_or_user:system-errors.view,1', 'module:system-errors'])
        ->name('admin.system-errors.show');
    Route::put('/system-errors/{error}/resolve', [SystemErrorController::class, 'resolve'])
        ->middleware(['permission_or_user:system-errors.update,1', 'module:system-errors'])
        ->name('admin.system-errors.resolve');

    Route::get('/api-keys', [AdminApiKeyController::class, 'index'])
        ->middleware(['permission_or_user:api-keys.view,1', 'module:api'])
        ->name('admin.api-keys.index');
    Route::get('/api-keys/{apiKey}', [AdminApiKeyController::class, 'show'])
        ->middleware(['permission_or_user:api-keys.view,1', 'module:api'])
        ->name('admin.api-keys.show');
    Route::put('/api-keys/{apiKey}/revoke', [AdminApiKeyController::class, 'revoke'])
        ->middleware(['permission_or_user:api-keys.revoke,1', 'module:api'])
        ->name('admin.api-keys.revoke');

    Route::get('/webhooks', [AdminWebhookController::class, 'index'])
        ->middleware(['permission_or_user:webhooks.view,1', 'module:webhooks'])
        ->name('admin.webhooks.index');
    Route::get('/webhooks/{webhook}', [AdminWebhookController::class, 'show'])
        ->middleware(['permission_or_user:webhooks.view,1', 'module:webhooks'])
        ->name('admin.webhooks.show');
    Route::get('/webhooks/{webhook}/deliveries', [AdminWebhookController::class, 'deliveries'])
        ->middleware(['permission_or_user:webhooks.view,1', 'module:webhooks'])
        ->name('admin.webhooks.deliveries');

    Route::get('/queues', [QueueController::class, 'index'])
        ->middleware(['permission_or_user:queues.view,1', 'module:queues'])
        ->name('admin.queues.index');
    Route::get('/failed-jobs', [QueueController::class, 'failed'])
        ->middleware(['permission_or_user:queues.view,1', 'module:queues'])
        ->name('admin.queues.failed');
    Route::post('/failed-jobs/{id}/retry', [QueueController::class, 'retry'])
        ->middleware(['permission_or_user:queues.retry,1', 'module:queues'])
        ->name('admin.queues.retry');
    Route::delete('/failed-jobs/{id}', [QueueController::class, 'destroy'])
        ->middleware(['permission_or_user:queues.flush-failed,1', 'module:queues'])
        ->name('admin.queues.destroy');
    Route::post('/failed-jobs/retry-all', [QueueController::class, 'retryAll'])
        ->middleware(['permission_or_user:queues.retry,1', 'module:queues'])
        ->name('admin.queues.retry-all');
    Route::delete('/failed-jobs/flush', [QueueController::class, 'flush'])
        ->middleware(['permission_or_user:queues.flush-failed,1', 'module:queues'])
        ->name('admin.queues.flush');

    Route::get('/system-monitor', [SystemMonitorController::class, 'index'])
        ->middleware('permission_or_user:reports.view,1')
        ->name('admin.system-monitor.index');

    Route::get('/security-events', [SecurityEventController::class, 'index'])
        ->middleware(['permission_or_user:security-events.view,1', 'module:security-events'])
        ->name('admin.security-events.index');
    Route::get('/security-events/{event}', [SecurityEventController::class, 'show'])
        ->middleware(['permission_or_user:security-events.view,1', 'module:security-events'])
        ->name('admin.security-events.show');

    Route::get('/feature-flags', [FeatureFlagController::class, 'index'])
        ->middleware(['permission_or_user:feature-flags.view,1', 'module:feature-flags'])
        ->name('admin.feature-flags.index');
    Route::get('/feature-flags/create', [FeatureFlagController::class, 'create'])
        ->middleware(['permission_or_user:feature-flags.create,1', 'module:feature-flags'])
        ->name('admin.feature-flags.create');
    Route::post('/feature-flags', [FeatureFlagController::class, 'store'])
        ->middleware(['permission_or_user:feature-flags.create,1', 'module:feature-flags'])
        ->name('admin.feature-flags.store');
    Route::get('/feature-flags/{flag}/edit', [FeatureFlagController::class, 'edit'])
        ->middleware(['permission_or_user:feature-flags.update,1', 'module:feature-flags'])
        ->name('admin.feature-flags.edit');
    Route::put('/feature-flags/{flag}', [FeatureFlagController::class, 'update'])
        ->middleware(['permission_or_user:feature-flags.update,1', 'module:feature-flags'])
        ->name('admin.feature-flags.update');

    Route::get('/announcements', [AdminSystemAnnouncementController::class, 'index'])
        ->middleware(['permission_or_user:announcements.view,1', 'module:announcements'])
        ->name('admin.announcements.index');
    Route::get('/announcements/create', [AdminSystemAnnouncementController::class, 'create'])
        ->middleware(['permission_or_user:announcements.create,1', 'module:announcements'])
        ->name('admin.announcements.create');
    Route::post('/announcements', [AdminSystemAnnouncementController::class, 'store'])
        ->middleware(['permission_or_user:announcements.create,1', 'module:announcements'])
        ->name('admin.announcements.store');
    Route::get('/announcements/{announcement}/edit', [AdminSystemAnnouncementController::class, 'edit'])
        ->middleware(['permission_or_user:announcements.update,1', 'module:announcements'])
        ->name('admin.announcements.edit');
    Route::put('/announcements/{announcement}', [AdminSystemAnnouncementController::class, 'update'])
        ->middleware(['permission_or_user:announcements.update,1', 'module:announcements'])
        ->name('admin.announcements.update');
    Route::delete('/announcements/{announcement}', [AdminSystemAnnouncementController::class, 'destroy'])
        ->middleware(['permission_or_user:announcements.delete,1', 'module:announcements'])
        ->name('admin.announcements.destroy');

    Route::get('/plans/{plan}/features', [PlanFeatureFlagController::class, 'edit'])
        ->middleware(['permission_or_user:feature-flags.update,1', 'module:feature-flags'])
        ->name('admin.plans.features.edit');
    Route::put('/plans/{plan}/features', [PlanFeatureFlagController::class, 'update'])
        ->middleware(['permission_or_user:feature-flags.update,1', 'module:feature-flags'])
        ->name('admin.plans.features.update');

    Route::get('/plans', [PlanController::class, 'index'])
        ->middleware(['permission_or_user:plans.view,1', 'module:billing'])
        ->name('admin.plans.index');
    Route::get('/plans/create', [PlanController::class, 'create'])
        ->middleware(['permission_or_user:plans.create,1', 'module:billing'])
        ->name('admin.plans.create');
    Route::post('/plans', [PlanController::class, 'store'])
        ->middleware(['permission_or_user:plans.create,1', 'module:billing'])
        ->name('admin.plans.store');
    Route::get('/plans/{plan}/edit', [PlanController::class, 'edit'])
        ->middleware(['permission_or_user:plans.update,1', 'module:billing'])
        ->name('admin.plans.edit');
    Route::put('/plans/{plan}', [PlanController::class, 'update'])
        ->middleware(['permission_or_user:plans.update,1', 'module:billing'])
        ->name('admin.plans.update');
    Route::delete('/plans/{plan}', [PlanController::class, 'destroy'])
        ->middleware(['permission_or_user:plans.delete,1', 'module:billing'])
        ->name('admin.plans.destroy');

    Route::get('/subscriptions', [SubscriptionController::class, 'index'])
        ->middleware(['permission_or_user:subscriptions.view,1', 'module:billing'])
        ->name('admin.subscriptions.index');

    Route::get('/business-module-definitions', [ModuleDefinitionController::class, 'index'])
        ->middleware(['auth', 'admin_or_user:1'])
        ->name('admin.business-module-definitions.index');
    Route::get('/business-module-definitions/create', [ModuleDefinitionController::class, 'create'])
        ->middleware(['auth', 'admin_or_user:1'])
        ->name('admin.business-module-definitions.create');
    Route::post('/business-module-definitions', [ModuleDefinitionController::class, 'store'])
        ->middleware(['auth', 'admin_or_user:1'])
        ->name('admin.business-module-definitions.store');
    Route::get('/business-module-definitions/{definition}/edit', [ModuleDefinitionController::class, 'edit'])
        ->middleware(['auth', 'admin_or_user:1'])
        ->name('admin.business-module-definitions.edit');
    Route::put('/business-module-definitions/{definition}', [ModuleDefinitionController::class, 'update'])
        ->middleware(['auth', 'admin_or_user:1'])
        ->name('admin.business-module-definitions.update');
    Route::delete('/business-module-definitions/{definition}', [ModuleDefinitionController::class, 'destroy'])
        ->middleware(['auth', 'admin_or_user:1'])
        ->name('admin.business-module-definitions.destroy');

    Route::get('/listings/{listing}/minisite', [AdminListingMinisiteController::class, 'index'])
        ->name('admin.business.minisite.index');
    Route::post('/listings/{listing}/minisite', [AdminListingMinisiteController::class, 'update'])
        ->name('admin.business.minisite.update');

    Route::get('/modules/{moduleKey}/settings', [ModuleSettingsController::class, 'show'])
        ->middleware(['auth', 'admin_or_user:1'])
        ->name('admin.module-settings.show');
    Route::put('/modules/{moduleKey}/settings', [ModuleSettingsController::class, 'update'])
        ->middleware(['auth', 'admin_or_user:1'])
        ->name('admin.module-settings.update');

    Route::get('/payments', [PaymentController::class, 'index'])
        ->middleware(['permission_or_user:payments.view,1', 'module:billing'])
        ->name('admin.payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])
        ->middleware(['permission_or_user:payments.create,1', 'module:billing'])
        ->name('admin.payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])
        ->middleware(['permission_or_user:payments.create,1', 'module:billing'])
        ->name('admin.payments.store');
    Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])
        ->middleware(['permission_or_user:payments.update,1', 'module:billing'])
        ->name('admin.payments.edit');
    Route::put('/payments/{payment}', [PaymentController::class, 'update'])
        ->middleware(['permission_or_user:payments.update,1', 'module:billing'])
        ->name('admin.payments.update');

    Route::get('/coupons', [CouponController::class, 'index'])
        ->middleware(['permission_or_user:coupons.view,1', 'module:billing'])
        ->name('admin.coupons.index');
    Route::get('/coupons/create', [CouponController::class, 'create'])
        ->middleware(['permission_or_user:coupons.create,1', 'module:billing'])
        ->name('admin.coupons.create');
    Route::post('/coupons', [CouponController::class, 'store'])
        ->middleware(['permission_or_user:coupons.create,1', 'module:billing'])
        ->name('admin.coupons.store');
    Route::get('/coupons/{coupon}/edit', [CouponController::class, 'edit'])
        ->middleware(['permission_or_user:coupons.update,1', 'module:billing'])
        ->name('admin.coupons.edit');
    Route::put('/coupons/{coupon}', [CouponController::class, 'update'])
        ->middleware(['permission_or_user:coupons.update,1', 'module:billing'])
        ->name('admin.coupons.update');
    Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy'])
        ->middleware(['permission_or_user:coupons.delete,1', 'module:billing'])
        ->name('admin.coupons.destroy');

    Route::get('/invoices', [AdminInvoiceController::class, 'index'])
        ->middleware(['permission_or_user:invoices.view,1', 'module:billing'])
        ->name('admin.invoices.index');
    Route::get('/invoices/{invoice}', [AdminInvoiceController::class, 'show'])
        ->middleware(['permission_or_user:invoices.view,1', 'module:billing'])
        ->name('admin.invoices.show');
    Route::get('/invoices/{invoice}/download', [AdminInvoiceController::class, 'download'])
        ->middleware(['permission_or_user:invoices.download,1', 'module:billing'])
        ->name('admin.invoices.download');

    Route::get('/support', [AdminSupportTicketController::class, 'index'])
        ->middleware(['permission_or_user:support.view,1', 'module:support'])
        ->name('admin.support.index');
    Route::get('/support/{ticket}', [AdminSupportTicketController::class, 'show'])
        ->middleware(['permission_or_user:support.view,1', 'module:support'])
        ->name('admin.support.show');
    Route::post('/support/{ticket}/reply', [AdminSupportTicketController::class, 'reply'])
        ->middleware(['permission_or_user:support.reply,1', 'module:support'])
        ->name('admin.support.reply');
    Route::put('/support/{ticket}', [AdminSupportTicketController::class, 'update'])
        ->middleware(['permission_or_user:support.update,1', 'module:support'])
        ->name('admin.support.update');

    Route::get('/support/departments', [SupportDepartmentController::class, 'index'])
        ->middleware(['permission_or_user:support.view,1', 'module:support'])
        ->name('admin.support.departments.index');
    Route::post('/support/departments', [SupportDepartmentController::class, 'store'])
        ->middleware(['permission_or_user:support.update,1', 'module:support'])
        ->name('admin.support.departments.store');
    Route::put('/support/departments/{department}', [SupportDepartmentController::class, 'update'])
        ->middleware(['permission_or_user:support.update,1', 'module:support'])
        ->name('admin.support.departments.update');
    Route::delete('/support/departments/{department}', [SupportDepartmentController::class, 'destroy'])
        ->middleware(['permission_or_user:support.delete,1', 'module:support'])
        ->name('admin.support.departments.destroy');

    Route::get('/help', [HelpArticleController::class, 'index'])
        ->middleware(['permission_or_user:help.view,1', 'module:support'])
        ->name('admin.help.index');
    Route::get('/help/create', [HelpArticleController::class, 'create'])
        ->middleware(['permission_or_user:help.create,1', 'module:support'])
        ->name('admin.help.create');
    Route::post('/help', [HelpArticleController::class, 'store'])
        ->middleware(['permission_or_user:help.create,1', 'module:support'])
        ->name('admin.help.store');
    Route::get('/help/{article}/edit', [HelpArticleController::class, 'edit'])
        ->middleware(['permission_or_user:help.update,1', 'module:support'])
        ->name('admin.help.edit');
    Route::put('/help/{article}', [HelpArticleController::class, 'update'])
        ->middleware(['permission_or_user:help.update,1', 'module:support'])
        ->name('admin.help.update');
    Route::delete('/help/{article}', [HelpArticleController::class, 'destroy'])
        ->middleware(['permission_or_user:help.delete,1', 'module:support'])
        ->name('admin.help.destroy');

    Route::get('/reports', [ReportController::class, 'index'])
        ->middleware('permission_or_user:reports.view,1')
        ->name('admin.reports.index');

    Route::get('/automations', [AutomationController::class, 'index'])
        ->middleware('permission_or_user:automations.view,1')
        ->name('admin.automations.index');
    Route::get('/automations/{automation}', [AutomationController::class, 'show'])
        ->middleware('permission_or_user:automations.view,1')
        ->name('admin.automations.show');
    Route::put('/automations/{automation}', [AutomationController::class, 'update'])
        ->middleware('permission_or_user:automations.update,1')
        ->name('admin.automations.update');

    Route::get('/message-templates', [MessageTemplateController::class, 'index'])
        ->middleware('permission_or_user:templates.view,1')
        ->name('admin.message-templates.index');
    Route::get('/message-templates/create', [MessageTemplateController::class, 'create'])
        ->middleware('permission_or_user:templates.create,1')
        ->name('admin.message-templates.create');
    Route::post('/message-templates', [MessageTemplateController::class, 'store'])
        ->middleware('permission_or_user:templates.create,1')
        ->name('admin.message-templates.store');
    Route::get('/message-templates/{template}/edit', [MessageTemplateController::class, 'edit'])
        ->middleware('permission_or_user:templates.update,1')
        ->name('admin.message-templates.edit');
    Route::put('/message-templates/{template}', [MessageTemplateController::class, 'update'])
        ->middleware('permission_or_user:templates.update,1')
        ->name('admin.message-templates.update');
    Route::delete('/message-templates/{template}', [MessageTemplateController::class, 'destroy'])
        ->middleware('permission_or_user:templates.delete,1')
        ->name('admin.message-templates.destroy');

    Route::get('/modules', [SystemModuleController::class, 'index'])
        ->name('admin.modules.index');
    Route::put('/modules/{module}', [SystemModuleController::class, 'update'])
        ->name('admin.modules.update');

});

Route::prefix('admin')->middleware(['auth', 'admin_or_user:1', 'permission_or_user:permissions.view,1'])->group(function () {
    Route::get('/permissions', [PermissionController::class, 'index'])->name('admin.permissions.index');
    Route::post('/permissions/reorder', [PermissionController::class, 'reorder'])
        ->middleware('permission_or_user:permissions.edit,1')
        ->name('admin.permissions.reorder');
    Route::get('/permissions/create', [PermissionController::class, 'create'])
        ->middleware('permission_or_user:permissions.create,1')
        ->name('admin.permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])
        ->middleware('permission_or_user:permissions.create,1')
        ->name('admin.permissions.store');
    Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])
        ->middleware('permission_or_user:permissions.edit,1')
        ->name('admin.permissions.edit');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])
        ->middleware('permission_or_user:permissions.edit,1')
        ->name('admin.permissions.update');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])
        ->middleware('permission_or_user:permissions.delete,1')
        ->name('admin.permissions.destroy');
});

Route::get('/ai/test', [App\Http\Controllers\AiTestController::class, 'test'])
    ->name('ai.test');

Route::post('/ai/chat', [App\Http\Controllers\AiTestController::class, 'chat'])
    ->name('ai.chat');
