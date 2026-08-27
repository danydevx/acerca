<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Acerca.site') }} - {{ config('app.name', 'Acerca.site') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.8/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body.legal-page {
            font-family: 'Manrope', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #F8FBFF;
            color: #1E293B;
        }
        .legal-header {
            background: linear-gradient(135deg, #2B6EEB 0%, #3AA7F4 100%);
            color: #fff;
            padding: 2.5rem 0 2rem;
        }
        .legal-header .brand-logo {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255,255,255,0.18);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }
        .legal-content {
            background: #fff;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 4px 24px rgba(15, 23, 42, 0.06);
        }
        .legal-content h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .legal-content .updated {
            color: #64748B;
            font-size: 0.875rem;
            margin-bottom: 2rem;
        }
        .legal-content h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-top: 2rem;
            margin-bottom: 0.75rem;
            color: #2B6EEB;
        }
        .legal-content p, .legal-content li {
            color: #334155;
            line-height: 1.7;
        }
        .legal-content a {
            color: #2B6EEB;
            text-decoration: none;
        }
        .legal-content a:hover {
            text-decoration: underline;
        }
        .legal-footer {
            color: #64748B;
            font-size: 0.875rem;
        }
    </style>
    @stack('styles')
</head>
<body class="legal-page">
    <header class="legal-header">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <a href="{{ url('/') }}" class="d-inline-flex align-items-center gap-2 text-white text-decoration-none">
                    <span class="brand-logo"><i class="bi bi-link-45deg"></i></span>
                    <span class="fw-semibold fs-5">Acerca.site</span>
                </a>
                <a href="{{ url('/login') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Iniciar sesion
                </a>
            </div>
        </div>
    </header>

    <main class="container py-5">
        @yield('content')
    </main>

    <footer class="container pb-5 text-center legal-footer">
        <p class="mb-1">&copy; {{ date('Y') }} {{ config('app.name', 'Acerca.site') }}. Todos los derechos reservados.</p>
        <p class="mb-0">
            <a href="{{ url('/terminos') }}">Terminos de servicio</a>
            &middot;
            <a href="{{ url('/privacidad') }}">Politica de privacidad</a>
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>