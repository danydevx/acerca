<?php

namespace App\Providers;

use App\Console\Commands\CreateSuperAdmin;
use App\Console\Commands\InstallSaas;
use App\Models\ApiKey;
use App\Models\MediaFile;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\WebhookEndpoint;
use App\Policies\ApiKeyPolicy;
use App\Policies\BusinessPolicy;
use App\Policies\ListingModulePolicy;
use App\Policies\MediaFilePolicy;
use App\Policies\PaymentPolicy;
use App\Policies\SubscriptionPolicy;
use App\Policies\SupportTicketPolicy;
use App\Policies\UserPolicy;
use App\Policies\WebhookEndpointPolicy;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Modules\Listings\Models\Listing;
use Modules\ListingModules\Models\ListingModule;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole() && $this->app->environment('production')) {
            $destructiveCommands = [
                'migrate:fresh',
                'migrate:refresh',
                'migrate:reset',
                'db:wipe',
                'migrate:fresh --seed',
                'migrate:refresh --seed',
            ];
            $argv = $_SERVER['argv'] ?? [];
            $cmd = $argv[1] ?? '';
            if (in_array($cmd, $destructiveCommands) || str_starts_with($cmd, 'migrate:fresh') || str_starts_with($cmd, 'db:wipe')) {
                $this->app->terminate();
                echo "\n  \033[41m\033[1;37m  ABORTED  \033[0m\n\n";
                echo "  Destructive database command disabled in production.\n";
                echo "  Command: {$cmd}\n";
                echo "  Environment: production\n";
                echo "  Database: " . config('database.connections.mysql.database') . "\n\n";
                echo "  Use --env=local or APP_ENV=local to override.\n";
                echo "  For testing, use: php artisan migrate --force\n\n";
                exit(1);
            }
        }

        if ($this->app->runningInConsole()) {
            $dbName = config('database.connections.mysql.database');
            $productionDbName = env('PRODUCTION_DB_NAME', 'laravel_acerca');
            if ($this->app->environment('production') && $dbName !== $productionDbName) {
                $this->app->terminate();
                echo "\n  \033[41m\033[1;37m  DB NAME MISMATCH  \033[0m\n\n";
                echo "  Production environment detected but database name does not match.\n";
                echo "  Expected: {$productionDbName}\n";
                echo "  Got: {$dbName}\n\n";
                echo "  Check DB_DATABASE in .env or set PRODUCTION_DB_NAME.\n";
                echo "  This may indicate you are pointing at the wrong database.\n\n";
                exit(1);
            }
        }

        $this->app->router->bind('listing', function ($value) {
            return Listing::findOrFail($value);
        });

        $this->app->router->bind('listingSlug', function ($value) {
            return Listing::where('slug', $value)->firstOrFail();
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateSuperAdmin::class,
                InstallSaas::class,
            ]);
        }

        Gate::before(function ($user) {
            return (int) $user->id === 1 ? true : null;
        });

        RedirectIfAuthenticated::redirectUsing(function (Request $request) {
            $user = Auth::user();

            if ($user && $user->hasAnyRole(['admin', 'superadmin'])) {
                return '/admin/dashboard';
            }

            if ($user && $user->hasRole('member')) {
                return '/member';
            }

            return '/';
        });

        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(ApiKey::class, ApiKeyPolicy::class);
        Gate::policy(WebhookEndpoint::class, WebhookEndpointPolicy::class);
        Gate::policy(SupportTicket::class, SupportTicketPolicy::class);
        Gate::policy(MediaFile::class, MediaFilePolicy::class);
        Gate::policy(Payment::class, PaymentPolicy::class);
        Gate::policy(Subscription::class, SubscriptionPolicy::class);
        Gate::policy(Listing::class, BusinessPolicy::class);
        Gate::policy(ListingModule::class, ListingModulePolicy::class);

        RateLimiter::for('login', function (Request $request) {
            $email = mb_strtolower((string) $request->input('email', ''));
            $key = $email !== '' ? $email.'|'.$request->ip() : $request->ip();

            return Limit::perMinute(5)->by($key)->response(function () use ($request) {
                return $this->throttleResponse($request, 'Demasiados intentos. Intente de nuevo en unos minutos.', 'email', false, 'login');
            });
        });

        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinutes(10, 5)->by($request->ip())->response(function () use ($request) {
                return $this->throttleResponse($request, 'Demasiados intentos. Intente de nuevo en unos minutos.', 'email');
            });
        });

        RateLimiter::for('password-email', function (Request $request) {
            $email = mb_strtolower((string) $request->input('email', ''));
            $key = $email !== '' ? $email.'|'.$request->ip() : $request->ip();

            return Limit::perMinutes(15, 3)->by($key)->response(function () use ($request) {
                return $this->throttleResponse($request, 'Demasiados intentos. Intente de nuevo en unos minutos.', 'email');
            });
        });

        RateLimiter::for('password-verify', function (Request $request) {
            $token = (string) $request->route('token');
            $key = ($token !== '' ? $token.'|' : '').$request->ip();

            return Limit::perMinutes(10, 5)->by($key)->response(function () use ($request) {
                return $this->throttleResponse($request, 'Demasiados intentos. Intente de nuevo en unos minutos.', 'code');
            });
        });

        RateLimiter::for('password-reset', function (Request $request) {
            $token = (string) $request->route('token');
            $key = ($token !== '' ? $token.'|' : '').$request->ip();

            return Limit::perMinutes(10, 5)->by($key)->response(function () use ($request) {
                return $this->throttleResponse($request, 'Demasiados intentos. Intente de nuevo en unos minutos.', 'password');
            });
        });

        RateLimiter::for('verification-resend', function (Request $request) {
            $userId = $request->user()?->id;
            $key = $userId ? 'user|'.$userId : $request->ip();

            return Limit::perMinutes(15, 3)->by($key)->response(function () use ($request) {
                return $this->throttleResponse($request, 'Demasiados intentos. Intente de nuevo en unos minutos.', null, true);
            });
        });

        RateLimiter::for('email-verify', function (Request $request) {
            $userId = (string) $request->route('id');
            $key = ($userId !== '' ? $userId.'|' : '').$request->ip();

            return Limit::perMinutes(10, 6)->by($key)->response(function () use ($request) {
                return $this->throttleResponse($request, 'Demasiados intentos. Intente de nuevo en unos minutos.', null, true);
            });
        });

        RateLimiter::for('ticket-create', function (Request $request) {
            $userId = $request->user()?->id;
            $key = $userId ? 'user|'.$userId : $request->ip();

            return Limit::perHour(5)->by($key)->response(function () use ($request) {
                return $this->throttleResponse($request, 'Has excedido el numero de solicitudes permitidas.', 'message');
            });
        });

        RateLimiter::for('ticket-reply', function (Request $request) {
            $userId = $request->user()?->id;
            $key = $userId ? 'user|'.$userId : $request->ip();

            return Limit::perHour(10)->by($key)->response(function () use ($request) {
                return $this->throttleResponse($request, 'Has excedido el numero de solicitudes permitidas.', 'message');
            });
        });

        RateLimiter::for('billing-portal', function (Request $request) {
            $userId = $request->user()?->id;
            $key = $userId ? 'user|'.$userId : $request->ip();

            return Limit::perMinutes(10, 5)->by($key)->response(function () use ($request) {
                return $this->throttleResponse($request, 'Demasiadas solicitudes. Intente de nuevo en unos minutos.', null, true);
            });
        });

        RateLimiter::for('checkout-create', function (Request $request) {
            $userId = $request->user()?->id;
            $key = $userId ? 'user|'.$userId : $request->ip();

            return Limit::perMinutes(10, 5)->by($key)->response(function () use ($request) {
                return $this->throttleResponse($request, 'Demasiadas solicitudes. Intente de nuevo en unos minutos.', null, true);
            });
        });

        RateLimiter::for('checkout-coupon', function (Request $request) {
            $userId = $request->user()?->id;
            $key = $userId ? 'user|'.$userId : $request->ip();

            return Limit::perMinute(10)->by($key)->response(function () use ($request) {
                return $this->throttleResponse($request, 'Has excedido el numero de solicitudes permitidas.', null, true);
            });
        });

        RateLimiter::for('api-key', function (Request $request) {
            $keyId = $request->attributes->get('api_key_id');
            $identifier = $keyId ? 'key|'.$keyId : 'ip|'.$request->ip();

            return Limit::perMinute(60)->by($identifier)->response(function () {
                return response()->json([
                    'message' => 'Demasiadas solicitudes. Intente de nuevo en unos minutos.',
                ], 429);
            });
        });

        RateLimiter::for('api-keys-create', function (Request $request) {
            $userId = $request->user()?->id;
            $key = $userId ? 'user|'.$userId : $request->ip();

            return Limit::perMinutes(10, 5)->by($key)->response(function () use ($request) {
                return $this->throttleResponse(
                    $request,
                    'Has excedido el numero de solicitudes permitidas.',
                    'name'
                );
            });
        });
    }

    private function throttleResponse(Request $request, string $message, ?string $field = null, bool $useFlash = false, ?string $action = null)
    {
        if ($action === 'login') {
            app(\App\Services\SecurityService::class)->log('rate_limit_triggered', null, $request, 'Rate limit en login', [
                'action' => 'login',
                'email' => strtolower((string) $request->input('email', '')),
            ]);
        }

        if ($useFlash) {
            return back()->with('error', $message)->setStatusCode(429);
        }

        $payload = $field ? [$field => $message] : ['rate_limit' => $message];

        return back()
            ->withErrors($payload)
            ->withInput($request->except(['password', 'password_confirmation']))
            ->setStatusCode(429);
    }
}
