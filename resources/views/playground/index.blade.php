<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Playground - Blade Components</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @php
        $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        $directoryCss = $manifest['resources/less/directory.less']['file'] ?? 'directory.css';
    @endphp
    <link rel="stylesheet" href="{{ asset('build/' . $directoryCss) }}">
    <style>
        .playground {
            padding: 2rem 0;
        }
        .playground__header {
            background: linear-gradient(135deg, #3B82F6 0%, #6B7280 100%);
            color: white;
            padding: 3rem 1.5rem;
            margin-bottom: 2rem;
        }
        .playground__title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .playground__subtitle {
            opacity: 0.85;
        }
        .component-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .component-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }
        .component-card__preview {
            padding: 1.5rem;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .component-card__info {
            padding: 1rem;
        }
        .component-card__name {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }
        .component-card__desc {
            font-size: 0.875rem;
            color: #6b7280;
        }
        .section-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            margin-bottom: 1rem;
        }
        .playground-nav {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }
        .playground-nav__item {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            background: #f3f4f6;
            color: #374151;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .playground-nav__item:hover {
            background: #e5e7eb;
            color: #111827;
        }
        .playground-nav__item--active {
            background: #3B82F6;
            color: white;
        }
        .playground-nav__item--external {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: white;
        }
        .playground-nav__item--external:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
        }
        .code-block {
            background: #1f2937;
            color: #f9fafb;
            padding: 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            overflow-x: auto;
            margin-top: 1rem;
        }
        .code-block code {
            color: #10B981;
        }
    </style>
</head>
<body>
    <div class="playground">
        <header class="playground__header">
            <div class="container">
                <h1 class="playground__title">Blade Component Playground</h1>
                <p class="playground__subtitle">Test and preview Bulma-based Blade components</p>
            </div>
        </header>

        <div class="container">
            <nav class="playground-nav">
                <a href="#service-card" class="playground-nav__item">Service Card</a>
                <a href="#service-card-realestate" class="playground-nav__item">Real Estate</a>
                <a href="#business-card" class="playground-nav__item">Business Card</a>
                <a href="#review-card" class="playground-nav__item">Review Card</a>
                <a href="#category-card" class="playground-nav__item">Category Card</a>
                <a href="#section-header" class="playground-nav__item">Section Header</a>
                <a href="#rating" class="playground-nav__item">Rating</a>
                <a href="#composed-ui" class="playground-nav__item playground-nav__item--external">
                    Composed UI
                </a>
            </nav>

            <section id="service-card" style="margin-bottom: 3rem;">
                <p class="section-label">Service Card — Variants</p>
                <div class="component-grid">

                    {{-- Default --}}
                    <div class="component-card">
                        <div class="component-card__preview">
                            @php
                                $service = (object) [
                                    'name' => 'Corte de cabello',
                                    'description' => 'Corte clásico con acabado profesional',
                                    'price' => 250,
                                    'duration_minutes' => 45,
                                ];
                            @endphp
                            <div style="width: 100%;">
                                <article class="service-card">
                                    <div class="service-card__header">
                                        <div>
                                            <h4 class="service-card__title">{{ $service->name }}</h4>
                                        </div>
                                        @if($service->price)
                                            <span class="service-card__price">${{ number_format($service->price, 0) }}</span>
                                        @endif
                                    </div>
                                    @if($service->description)
                                        <p class="service-card__description">{{ $service->description }}</p>
                                    @endif
                                    <div class="service-card__footer">
                                        @if($service->duration_minutes)
                                            <span class="service-card__duration">
                                                <i class="bi bi-clock"></i>
                                                {{ $service->duration_minutes }} min
                                            </span>
                                        @endif
                                        <a href="#book" class="service-card__action">Reservar</a>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Service Card — Default</p>
                            <p class="component-card__desc">Basic card with shadow on hover</p>
                        </div>
                    </div>

                    {{-- Elevated --}}
                    <div class="component-card">
                        <div class="component-card__preview" style="background: linear-gradient(145deg, #f1f5f9 0%, #e2e8f0 100%);">
                            <div style="width: 100%;">
                                <article class="service-card service-card--elevated">
                                    <div class="service-card__header">
                                        <div>
                                            <h4 class="service-card__title">Corte Premium</h4>
                                        </div>
                                        <span class="service-card__price">$350</span>
                                    </div>
                                    <p class="service-card__description">Incluye lavado, corte y stylado con productos premium</p>
                                    <div class="service-card__footer">
                                        <span class="service-card__duration">
                                            <i class="bi bi-clock"></i>
                                            60 min
                                        </span>
                                        <a href="#book" class="service-card__action">Reservar</a>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Service Card — Elevated</p>
                            <p class="component-card__desc">Pronounced shadows, gradient header, lifts on hover</p>
                        </div>
                    </div>

                    {{-- Outlined --}}
                    <div class="component-card">
                        <div class="component-card__preview" style="background: #f8fafc;">
                            <div style="width: 100%;">
                                <article class="service-card service-card--outlined">
                                    <div class="service-card__header">
                                        <div>
                                            <h4 class="service-card__title">Afeitado clásico</h4>
                                        </div>
                                        <span class="service-card__price">$150</span>
                                    </div>
                                    <p class="service-card__description">Afeitado con navaja y toalla caliente</p>
                                    <div class="service-card__footer">
                                        <span class="service-card__duration">
                                            <i class="bi bi-clock"></i>
                                            30 min
                                        </span>
                                        <a href="#book" class="service-card__action">Reservar</a>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Service Card — Outlined</p>
                            <p class="component-card__desc">Transparent background, accent border on hover</p>
                        </div>
                    </div>

                    {{-- Minimal --}}
                    <div class="component-card">
                        <div class="component-card__preview" style="background: #fff;">
                            <div style="width: 100%; max-width: 320px;">
                                <article class="service-card service-card--minimal">
                                    <div class="service-card__header">
                                        <h4 class="service-card__title">Arreglo de barba</h4>
                                        <span class="service-card__price">$120</span>
                                    </div>
                                    <div class="service-card__footer">
                                        <span class="service-card__duration">
                                            <i class="bi bi-clock"></i>
                                            25 min
                                        </span>
                                        <a href="#book" class="service-card__action">Reservar</a>
                                    </div>
                                </article>
                                <article class="service-card service-card--minimal">
                                    <div class="service-card__header">
                                        <h4 class="service-card__title">Teñido de cabello</h4>
                                        <span class="service-card__price">$450</span>
                                    </div>
                                    <div class="service-card__footer">
                                        <span class="service-card__duration">
                                            <i class="bi bi-clock"></i>
                                            90 min
                                        </span>
                                        <a href="#book" class="service-card__action">Reservar</a>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Service Card — Minimal</p>
                            <p class="component-card__desc">List-style, bottom border, no shadows</p>
                        </div>
                    </div>

                    {{-- Soft Shadow --}}
                    <div class="component-card">
                        <div class="component-card__preview" style="background: #fafafa;">
                            <div style="width: 100%;">
                                <article class="service-card service-card--soft">
                                    <div class="service-card__header">
                                        <div>
                                            <h4 class="service-card__title">Tratamiento capilar</h4>
                                        </div>
                                        <span class="service-card__price">$280</span>
                                    </div>
                                    <p class="service-card__description">Hidratación profunda con keratina</p>
                                    <div class="service-card__footer">
                                        <span class="service-card__duration">
                                            <i class="bi bi-clock"></i>
                                            45 min
                                        </span>
                                        <a href="#book" class="service-card__action">Reservar</a>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Service Card — Soft Shadow</p>
                            <p class="component-card__desc">Diffuse shadows, accent underline animates on hover</p>
                        </div>
                    </div>

                    {{-- Glass --}}
                    <div class="component-card">
                        <div class="component-card__preview" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <div style="width: 100%;">
                                <article class="service-card service-card--glass">
                                    <div class="service-card__header">
                                        <div>
                                            <h4 class="service-card__title">Spa day</h4>
                                        </div>
                                        <span class="service-card__price">$850</span>
                                    </div>
                                    <p class="service-card__description">Día completo de relajación y tratamiento</p>
                                    <div class="service-card__footer">
                                        <span class="service-card__duration">
                                            <i class="bi bi-clock"></i>
                                            180 min
                                        </span>
                                        <a href="#book" class="service-card__action">Reservar</a>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Service Card — Glass</p>
                            <p class="component-card__desc">Backdrop blur, semi-transparent, scales on hover</p>
                        </div>
                    </div>

                    {{-- Gradient Border --}}
                    <div class="component-card">
                        <div class="component-card__preview" style="background: #f8fafc;">
                            <div style="width: 100%;">
                                <article class="service-card service-card--gradient-border">
                                    <div class="service-card__content">
                                        <div class="service-card__header">
                                            <div>
                                                <h4 class="service-card__title">Paquete novios</h4>
                                            </div>
                                            <span class="service-card__price">$1,200</span>
                                        </div>
                                        <p class="service-card__description">Todo para la boda perfecta para dos</p>
                                        <div class="service-card__footer">
                                            <span class="service-card__duration">
                                                <i class="bi bi-clock"></i>
                                                120 min
                                            </span>
                                            <a href="#book" class="service-card__action">Reservar</a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Service Card — Gradient Border</p>
                            <p class="component-card__desc">CSS gradient border using mask technique</p>
                        </div>
                    </div>

                    {{-- With Image --}}
                    <div class="component-card">
                        <div class="component-card__preview">
                            <div style="width: 100%; max-width: 280px;">
                                <article class="service-card service-card--image">
                                    <div class="service-card__image-wrap">
                                        <img src="https://images.unsplash.com/photo-1599351431202-1e0f0137899a?w=400&h=300&fit=crop" alt="Corte moderno" loading="lazy">
                                        <span class="service-card__badge">Popular</span>
                                        <span class="service-card__discount">-20%</span>
                                    </div>
                                    <div class="service-card__content">
                                        <div class="service-card__header">
                                            <div>
                                                <h4 class="service-card__title">Corte moderno</h4>
                                            </div>
                                            <span class="service-card__price">$320</span>
                                        </div>
                                        <p class="service-card__description">Estilo actual con técnica de degradado</p>
                                        <div class="service-card__footer">
                                            <span class="service-card__duration">
                                                <i class="bi bi-clock"></i>
                                                50 min
                                            </span>
                                            <a href="#book" class="service-card__action">Reservar</a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Service Card — With Image</p>
                            <p class="component-card__desc">Image header, zoom on hover, badge overlays</p>
                        </div>
                    </div>

                    {{-- Promo --}}
                    <div class="component-card">
                        <div class="component-card__preview">
                            <div style="width: 100%;">
                                <article class="service-card service-card--promo">
                                    <div class="service-card__content">
                                        <span class="service-card__promo-tag">
                                            <i class="bi bi-lightning-fill"></i>
                                            Oferta limitada
                                        </span>
                                        <div class="service-card__header">
                                            <div>
                                                <h4 class="service-card__title">Black Friday Pack</h4>
                                            </div>
                                            <div class="service-card__price-wrap">
                                                <span class="service-card__price">$599</span>
                                                <span class="service-card__original-price">$850</span>
                                                <span class="service-card__discount-badge">-30%</span>
                                            </div>
                                        </div>
                                        <p class="service-card__description">5 servicios por el precio de 3</p>
                                        <div class="service-card__footer">
                                            <span class="service-card__duration">
                                                <i class="bi bi-clock"></i>
                                                150 min
                                            </span>
                                            <a href="#book" class="service-card__action">Reservar</a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Service Card — Promo</p>
                            <p class="component-card__desc">Rotating discount badge, original price strikethrough</p>
                        </div>
                    </div>

                    {{-- Pill --}}
                    <div class="component-card">
                        <div class="component-card__preview" style="background: #f8fafc;">
                            <div style="width: 100%;">
                                <article class="service-card service-card--pill">
                                    <div class="service-card__header">
                                        <div>
                                            <h4 class="service-card__title">Consultoría express</h4>
                                        </div>
                                    </div>
                                    <div class="service-card__footer">
                                        <span class="service-card__duration">
                                            <i class="bi bi-clock"></i>
                                            15 min
                                        </span>
                                        <a href="#book" class="service-card__action">Agendar</a>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Service Card — Pill</p>
                            <p class="component-card__desc">Rounded ends, inline layout, pill-shaped duration</p>
                        </div>
                    </div>

                    {{-- Dark --}}
                    <div class="component-card">
                        <div class="component-card__preview" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
                            <div style="width: 100%;">
                                <article class="service-card service-card--dark">
                                    <div class="service-card__header">
                                        <div>
                                            <h4 class="service-card__title">Night style</h4>
                                        </div>
                                        <span class="service-card__price">$380</span>
                                    </div>
                                    <p class="service-card__description">Corte nocturno con productos especiales</p>
                                    <div class="service-card__footer">
                                        <span class="service-card__duration">
                                            <i class="bi bi-clock"></i>
                                            55 min
                                        </span>
                                        <a href="#book" class="service-card__action">Reservar</a>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Service Card — Dark</p>
                            <p class="component-card__desc">Dark background for light sections</p>
                        </div>
                    </div>

                    {{-- Horizontal --}}
                    <div class="component-card">
                        <div class="component-card__preview">
                            <div style="width: 100%;">
                                <article class="service-card service-card--horizontal">
                                    <div class="service-card__header">
                                        <div>
                                            <h4 class="service-card__title">Corte + Barba</h4>
                                        </div>
                                    </div>
                                    <p class="service-card__description">Combo completo para un look perfecto. Incluye productos de cuidado</p>
                                    <div class="service-card__footer">
                                        <span class="service-card__price">$420</span>
                                        <span class="service-card__duration">
                                            <i class="bi bi-clock"></i>
                                            70 min
                                        </span>
                                        <a href="#book" class="service-card__action">Reservar</a>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Service Card — Horizontal</p>
                            <p class="component-card__desc">Side-by-side layout, vertical divider, actions on right</p>
                        </div>
                    </div>

                </div>
            </section>

            <section id="business-card" style="margin-bottom: 3rem;">
                <p class="section-label">Business Card</p>
                <div class="component-grid">
                    <div class="component-card">
                        <div class="component-card__preview">
                            @php
                                $business = (object) [
                                    'id' => 1,
                                    'slug' => 'barberia-central',
                                    'name' => 'Barbería Central',
                                    'description' => 'La mejor barbería de la ciudad con más de 20 años de experiencia',
                                    'listing_type_label' => 'Barbería',
                                    'locations' => collect([(object) ['city' => 'Ciudad de México', 'state' => 'CDMX']]),
                                    'rating' => 4.8,
                                    'reviews_count' => 124,
                                    'cover_image_path' => 'https://picsum.photos/seed/barber/400/300',
                                    'logo_path' => 'https://picsum.photos/seed/barberlogo/100/100',
                                ];
                            @endphp
                            <div style="width: 100%;">
                                <article class="business-card">
                                    <a href="{{ route('directory.show', $business->slug) }}" class="business-card__image-wrap">
                                        <img src="{{ $business->cover_image_path }}" alt="{{ $business->name }}" class="business-card__image" loading="lazy">
                                    </a>
                                    <div class="business-card__body">
                                        <a href="{{ route('directory.show', $business->slug) }}">
                                            <span class="business-card__category">{{ $business->listing_type_label }}</span>
                                            <h3 class="business-card__title">{{ $business->name }}</h3>
                                        </a>
                                        <div class="business-card__location">
                                            <i class="bi bi-geo-alt"></i>
                                            {{ $business->locations->first()->city }}, {{ $business->locations->first()->state }}
                                        </div>
                                        <div class="business-card__rating">
                                            <span class="business-card__rating-score">{{ round($business->rating, 1) }}</span>
                                            <span class="business-card__rating-stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi {{ $i <= round($business->rating) ? 'bi-star-fill' : 'bi-star' }}" style="color: #F59E0B"></i>
                                                @endfor
                                            </span>
                                            <span class="business-card__rating-count">({{ $business->reviews_count }})</span>
                                        </div>
                                        @if($business->description)
                                            <p class="business-card__description">{{ Str::limit($business->description, 100) }}</p>
                                        @endif
                                        <div class="business-card__footer">
                                            <a href="{{ route('directory.show', $business->slug) }}" class="business-card__action">
                                                Ver más <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Business Card</p>
                            <p class="component-card__desc">Full business listing card with image, rating, and location</p>
                            <div class="code-block">
                                <code>&lt;x-business-card :business="$business" /&gt;</code>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="review-card" style="margin-bottom: 3rem;">
                <p class="section-label">Review Card</p>
                <div class="component-grid">
                    <div class="component-card">
                        <div class="component-card__preview">
                            @php
                                $review = (object) [
                                    'client_name' => 'Carlos Mendoza',
                                    'rating' => 5,
                                    'comment' => 'Excelente servicio, muy profesional y el resultado fue exactamente lo que buscaba. Definitivamente volveré.',
                                    'created_at' => now()->setDate(2024, 1, 15),
                                ];
                            @endphp
                            <div style="width: 100%; max-width: 350px;">
                                <article class="review-card">
                                    <div class="review-card__header">
                                        <div class="review-card__author">
                                            <div class="review-card__avatar">
                                                {{ strtoupper(substr($review->client_name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h4 class="review-card__name">{{ $review->client_name }}</h4>
                                                <span class="review-card__date">{{ $review->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                        <div class="review-card__rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi {{ $i <= round($review->rating) ? 'bi-star-fill' : 'bi-star' }}" style="color: #F59E0B"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="review-card__comment">{{ $review->comment }}</p>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Review Card</p>
                            <p class="component-card__desc">Customer review with avatar, rating stars, and content</p>
                            <div class="code-block">
                                <code>&lt;x-review-card :review="$review" /&gt;</code>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="category-card" style="margin-bottom: 3rem;">
                <p class="section-label">Category Card</p>
                <div class="component-grid">
                    <div class="component-card">
                        <div class="component-card__preview">
                            @php
                                $typeValue = 'barberias';
                                $typeLabel = 'Barberías';
                                $typeIcon = 'bi-scissors';
                                $typeColor = '#3B82F6';
                            @endphp
                            <div style="width: 100%; max-width: 150px;">
                                <a href="{{ route('directory.index', ['type' => $typeValue]) }}" class="category-card category-card--{{ $typeValue }}">
                                    <span class="category-card__icon" style="color: {{ $typeColor }}">
                                        <i class="bi {{ $typeIcon }}"></i>
                                    </span>
                                    <span class="category-card__title">{{ $typeLabel }}</span>
                                </a>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Category Card</p>
                            <p class="component-card__desc">Category link with icon and business count</p>
                            <div class="code-block">
                                <code>&lt;x-category-card :type="$type" /&gt;</code>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Real Estate / Property Cards --}}
            <section id="service-card-realestate" style="margin-bottom: 3rem;">
                <p class="section-label">Service Card — Real Estate</p>
                <div class="component-grid">

                    {{-- Property Card --}}
                    <div class="component-card">
                        <div class="component-card__preview">
                            <div style="width: 100%; max-width: 300px;">
                                <article class="service-card service-card--property">
                                    <div class="service-card__image-wrap">
                                        <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=600&h=400&fit=crop" alt="Casa moderna" loading="lazy">
                                        <span class="service-card__status service-card__status--sale">For Sale</span>
                                    </div>
                                    <div class="service-card__content">
                                        <div class="service-card__header">
                                            <h4 class="service-card__title">Casa moderna en zona residencial</h4>
                                            <span class="service-card__price">$2,450,000</span>
                                        </div>
                                        <div class="service-card__address">
                                            <i class="bi bi-geo-alt"></i>
                                            Polanco, CDMX
                                        </div>
                                        <div class="service-card__features">
                                            <div class="service-card__feature">
                                                <i class="bi bi-door-open"></i>
                                                <span>4</span> recámaras
                                            </div>
                                            <div class="service-card__feature">
                                                <i class="bi bi-droplet"></i>
                                                <span>3</span> baños
                                            </div>
                                            <div class="service-card__feature">
                                                <i class="bi bi-fullscreen"></i>
                                                <span>280</span> m²
                                            </div>
                                        </div>
                                        <div class="service-card__footer">
                                            <div class="service-card__agent">
                                                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=100&h=100&fit=crop" alt="Agent">
                                                <span>Carlos Mendoza</span>
                                            </div>
                                            <a href="#contact" class="service-card__action">Contactar</a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Service Card — Property</p>
                            <p class="component-card__desc">Property card with beds, baths, area, status badge and agent</p>
                        </div>
                    </div>

                    {{-- Property Compact --}}
                    <div class="component-card">
                        <div class="component-card__preview" style="background: #f8fafc;">
                            <div style="width: 100%; max-width: 400px;">
                                <article class="service-card service-card--property-compact">
                                    <div class="service-card__image-wrap">
                                        <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=300&h=200&fit=crop" alt="Departamento" loading="lazy">
                                    </div>
                                    <div class="service-card__content">
                                        <div class="service-card__header">
                                            <h4 class="service-card__title">Departamento amueblado</h4>
                                            <span class="service-card__price">$8,500/mo</span>
                                        </div>
                                        <div class="service-card__address">
                                            <i class="bi bi-geo-alt"></i>
                                            Condesa, CDMX
                                        </div>
                                        <div class="service-card__features">
                                            <div class="service-card__feature">
                                                <i class="bi bi-door-open"></i> 2
                                            </div>
                                            <div class="service-card__feature">
                                                <i class="bi bi-droplet"></i> 1
                                            </div>
                                            <div class="service-card__feature">
                                                <i class="bi bi-fullscreen"></i> 75m²
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Service Card — Property Compact</p>
                            <p class="component-card__desc">Horizontal compact list view for property listings</p>
                        </div>
                    </div>

                    {{-- Property Featured --}}
                    <div class="component-card">
                        <div class="component-card__preview">
                            <div style="width: 100%; max-width: 340px;">
                                <article class="service-card service-card--property-featured">
                                    <div class="service-card__image-wrap">
                                        <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&h=400&fit=crop" alt="Villa de lujo" loading="lazy">
                                        <div class="service-card__badges">
                                            <span class="service-card__status">Destacada</span>
                                            <button class="service-card__favorite">
                                                <i class="bi bi-heart-fill"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="service-card__content">
                                        <div class="service-card__header">
                                            <h4 class="service-card__title">Villa de lujo con piscina</h4>
                                            <div class="service-card__price-row">
                                                <span class="service-card__price">$8,900,000</span>
                                                <span class="service-card__price-per-m2">$31,785/m²</span>
                                            </div>
                                        </div>
                                        <div class="service-card__features">
                                            <div class="service-card__feature">
                                                <i class="bi bi-door-open"></i>
                                                <strong>5</strong>
                                                <span>Recámaras</span>
                                            </div>
                                            <div class="service-card__feature">
                                                <i class="bi bi-droplet"></i>
                                                <strong>4</strong>
                                                <span>Baños</span>
                                            </div>
                                            <div class="service-card__feature">
                                                <i class="bi bi-car-front"></i>
                                                <strong>3</strong>
                                                <span>Garage</span>
                                            </div>
                                            <div class="service-card__feature">
                                                <i class="bi bi-fullscreen"></i>
                                                <strong>420</strong>
                                                <span>m²</span>
                                            </div>
                                        </div>
                                        <div class="service-card__footer">
                                            <div class="service-card__agent">
                                                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100&h=100&fit=crop" alt="Agent">
                                                <div>
                                                    <strong>María García</strong>
                                                    <span>Agente Inmobiliario</span>
                                                </div>
                                            </div>
                                            <a href="#contact" class="service-card__action">Ver details</a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Service Card — Property Featured</p>
                            <p class="component-card__desc">Featured property with grid features, favorite button, price per m²</p>
                        </div>
                    </div>

                </div>
            </section>

            <section id="section-header" style="margin-bottom: 3rem;">
                <p class="section-label">Section Header</p>
                <div class="component-grid">
                    <div class="component-card">
                        <div class="component-card__preview" style="text-align: left;">
                            <div style="width: 100%; max-width: 400px;">
                                <header class="section-header">
                                    @if(isset($eyebrow))
                                        <span class="section-header__eyebrow">{{ $eyebrow }}</span>
                                    @endif
                                    <h2 class="section-header__title">Nuestros Servicios</h2>
                                    <p class="section-header__description">Descubre todos los servicios que ofrecemos para ti</p>
                                </header>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Section Header</p>
                            <p class="component-card__desc">Header with eyebrow, title, and description</p>
                            <div class="code-block">
                                <code>&lt;x-section-header title="..." description="..." /&gt;</code>
                            </div>
                        </div>
                    </div>

                    <div class="component-card">
                        <div class="component-card__preview" style="text-align: left;">
                            <div style="width: 100%; max-width: 400px;">
                                <header class="section-header section-header--compact">
                                    <span class="section-header__eyebrow">Get in touch</span>
                                    <h2 class="section-header__title">Contacto</h2>
                                    <p class="section-header__description">We're here to help you</p>
                                </header>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Section Header (compact)</p>
                            <p class="component-card__desc">Compact variant with eyebrow text</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="rating" style="margin-bottom: 3rem;">
                <p class="section-label">Rating</p>
                <div class="component-grid">
                    <div class="component-card">
                        <div class="component-card__preview" style="text-align: left;">
                            <div style="width: 100%; max-width: 200px;">
                                <div class="rating">
                                    <div class="rating__stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="rating__star rating__star--{{ $i <= 4 ? 'filled' : 'empty' }}">
                                                <i class="bi {{ $i <= 4 ? 'bi-star-fill' : 'bi-star' }}"></i>
                                            </span>
                                        @endfor
                                    </div>
                                    <span class="rating__score">4.5</span>
                                    <span class="rating__count">(128 reseñas)</span>
                                </div>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Rating</p>
                            <p class="component-card__desc">Star rating display with score and review count</p>
                            <div class="code-block">
                                <code>&lt;x-rating :score="4.5" :count="128" /&gt;</code>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Composed UI: BookingScheduler Preview --}}
            <section id="composed-ui" style="margin-bottom: 3rem;">
                <p class="section-label">Composed UI — BookingScheduler (Vue Component)</p>
                <div style="background: #f3f4f6; padding: 2rem; border-radius: 12px; margin-bottom: 1rem;">
                    <div style="text-align: center; margin-bottom: 1rem;">
                        <span class="tag is-success is-light">Vue Component</span>
                        <span class="tag is-info is-light ml-2">Reusable</span>
                        <span class="tag is-warning is-light ml-2">Generic</span>
                    </div>
                    <p style="color: #6b7280; margin-bottom: 1rem;">
                        El componente <code>BookingScheduler</code> está disponible en el Playground de Inertia.
                        Es un sistema genérico de agendamiento que funciona para cualquier industria.
                    </p>
                    <a href="/playground" class="button is-primary">
                        <i class="bi bi-box-arrow-up-right mr-2"></i>
                        Abrir Playground de Componentes Vue
                    </a>
                </div>

                <div class="component-grid">
                    {{-- BookingScheduler Visual Preview (Static HTML) --}}
                    <div class="component-card" style="grid-column: span 2;">
                        <div class="component-card__preview" style="background: #fff;">
                            <div class="booking-preview">
                                <div class="booking-preview__sidebar">
                                    <h4 class="booking-preview__title">Corte clásico</h4>
                                    <p class="booking-preview__provider">
                                        <i class="bi bi-person"></i> Marivi Ruiz
                                    </p>
                                    <p class="booking-preview__desc">Corte tradicional con acabado profesional</p>
                                    <div class="booking-preview__meta">
                                        <span><i class="bi bi-clock"></i> 30 min</span>
                                        <span><i class="bi bi-geo-alt"></i> Presencial</span>
                                    </div>
                                    <div class="booking-preview__price">$250</div>
                                </div>
                                <div class="booking-preview__main">
                                    <div class="booking-preview__calendar">
                                        <div class="booking-preview__calendar-header">
                                            <button class="booking-preview__nav"><i class="bi bi-chevron-left"></i></button>
                                            <span>Septiembre 2026</span>
                                            <button class="booking-preview__nav"><i class="bi bi-chevron-right"></i></button>
                                        </div>
                                        <div class="booking-preview__weekdays">
                                            <span>D</span><span>L</span><span>M</span><span>X</span><span>J</span><span>V</span><span>S</span>
                                        </div>
                                        <div class="booking-preview__days">
                                            <span class="outside">31</span>
                                            <span class="available">1</span><span class="available">2</span><span class="available">3</span><span class="available">4</span><span class="available">5</span><span class="available">6</span>
                                            <span class="available">7</span><span class="available">8</span><span class="today selected">9</span><span class="available">10</span><span class="available">11</span><span class="available">12</span><span class="available">13</span>
                                            <span class="available">14</span><span class="available">15</span><span class="available">16</span><span class="available">17</span><span class="available">18</span><span class="available">19</span><span class="available">20</span>
                                            <span class="available">21</span><span class="available">22</span><span class="available">23</span><span class="available">24</span><span class="available">25</span><span class="available">26</span><span class="available">27</span>
                                            <span class="available">28</span><span class="available">29</span><span class="available">30</span>
                                            <span class="outside">1</span><span class="outside">2</span><span class="outside">3</span><span class="outside">4</span>
                                        </div>
                                    </div>
                                    <div class="booking-preview__slots">
                                        <div class="booking-preview__selected-date">
                                            <i class="bi bi-calendar3"></i>
                                            Miércoles 9 de septiembre
                                        </div>
                                        <div class="booking-preview__slots-grid">
                                            <button class="booking-preview__slot">10:00 am</button>
                                            <button class="booking-preview__slot">10:30 am</button>
                                            <button class="booking-preview__slot selected">11:00 am</button>
                                            <button class="booking-preview__slot">11:30 am</button>
                                            <button class="booking-preview__slot">12:00 pm</button>
                                            <button class="booking-preview__slot">2:00 pm</button>
                                            <button class="booking-preview__slot">2:30 pm</button>
                                            <button class="booking-preview__slot">3:00 pm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">BookingScheduler</p>
                            <p class="component-card__desc">Componente genérico de agendamiento. 3 columnas: Info | Calendario | Horarios. Funciona para barberías, spas, clínicas, restaurantes, etc.</p>
                            <div class="code-block">
                                <code>&lt;BookingScheduler :service="$service" :availability="$slots" /&gt;</code>
                            </div>
                        </div>
                    </div>

                    <div class="component-card">
                        <div class="component-card__preview" style="background: #fff;">
                            <div style="text-align: center; padding: 1rem;">
                                <i class="bi bi-scissors" style="font-size: 2rem; color: #3B82F6;"></i>
                                <p style="margin-top: 0.5rem; font-weight: 600;">Barber</p>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Barbería</p>
                            <p class="component-card__desc">Corte, barba, tratamiento</p>
                        </div>
                    </div>

                    <div class="component-card">
                        <div class="component-card__preview" style="background: #fff;">
                            <div style="text-align: center; padding: 1rem;">
                                <i class="bi bi-stars" style="font-size: 2rem; color: #EC4899;"></i>
                                <p style="margin-top: 0.5rem; font-weight: 600;">Beauty</p>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Salón de belleza</p>
                            <p class="component-card__desc">Manicure, pedicure, limpieza</p>
                        </div>
                    </div>

                    <div class="component-card">
                        <div class="component-card__preview" style="background: #fff;">
                            <div style="text-align: center; padding: 1rem;">
                                <i class="bi bi-briefcase" style="font-size: 2rem; color: #10B981;"></i>
                                <p style="margin-top: 0.5rem; font-weight: 600;">Professional</p>
                            </div>
                        </div>
                        <div class="component-card__info">
                            <p class="component-card__name">Servicios profesionales</p>
                            <p class="component-card__desc">Consultoría,律师, contador</p>
                        </div>
                    </div>
                </div>

                <style>
                    .booking-preview {
                        display: grid;
                        grid-template-columns: 220px 1fr;
                        gap: 1.5rem;
                        background: #fff;
                        border: 1px solid #e5e7eb;
                        border-radius: 12px;
                        padding: 1.5rem;
                        max-width: 700px;
                        margin: 0 auto;
                    }
                    .booking-preview__sidebar {
                        border-right: 1px solid #e5e7eb;
                        padding-right: 1.5rem;
                    }
                    .booking-preview__title {
                        font-size: 1.125rem;
                        font-weight: 600;
                        margin: 0 0 0.25rem;
                        color: #111827;
                    }
                    .booking-preview__provider {
                        font-size: 0.875rem;
                        color: #6b7280;
                        margin: 0 0 0.75rem;
                    }
                    .booking-preview__provider i {
                        margin-right: 0.25rem;
                    }
                    .booking-preview__desc {
                        font-size: 0.875rem;
                        color: #374151;
                        margin: 0 0 1rem;
                        line-height: 1.5;
                    }
                    .booking-preview__meta {
                        display: flex;
                        flex-direction: column;
                        gap: 0.5rem;
                        padding-top: 0.75rem;
                        border-top: 1px solid #e5e7eb;
                        margin-bottom: 1rem;
                    }
                    .booking-preview__meta span {
                        font-size: 0.8125rem;
                        color: #374151;
                    }
                    .booking-preview__meta i {
                        margin-right: 0.375rem;
                        color: #6b7280;
                    }
                    .booking-preview__price {
                        font-size: 1.5rem;
                        font-weight: 700;
                        color: #3B82F6;
                    }
                    .booking-preview__main {
                        display: flex;
                        flex-direction: column;
                        gap: 1rem;
                    }
                    .booking-preview__calendar {
                        background: #f9fafb;
                        border-radius: 8px;
                        padding: 1rem;
                    }
                    .booking-preview__calendar-header {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        margin-bottom: 0.75rem;
                        font-weight: 600;
                        font-size: 0.9375rem;
                    }
                    .booking-preview__nav {
                        background: none;
                        border: none;
                        cursor: pointer;
                        padding: 0.25rem;
                        color: #6b7280;
                    }
                    .booking-preview__weekdays {
                        display: grid;
                        grid-template-columns: repeat(7, 1fr);
                        text-align: center;
                        font-size: 0.6875rem;
                        font-weight: 600;
                        color: #9ca3af;
                        text-transform: uppercase;
                        margin-bottom: 0.25rem;
                    }
                    .booking-preview__days {
                        display: grid;
                        grid-template-columns: repeat(7, 1fr);
                        gap: 2px;
                    }
                    .booking-preview__days span {
                        aspect-ratio: 1;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 0.8125rem;
                        border-radius: 6px;
                        cursor: pointer;
                    }
                    .booking-preview__days span.outside {
                        color: #d1d5db;
                    }
                    .booking-preview__days span.available:hover {
                        background: #e5e7eb;
                    }
                    .booking-preview__days span.today {
                        background: #3B82F6;
                        color: white;
                        font-weight: 600;
                    }
                    .booking-preview__days span.selected {
                        background: #1f2937;
                        color: white;
                        font-weight: 700;
                    }
                    .booking-preview__selected-date {
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                        padding: 0.75rem 1rem;
                        background: #f3f4f6;
                        border-radius: 8px;
                        font-size: 0.9375rem;
                        font-weight: 500;
                        color: #374151;
                    }
                    .booking-preview__selected-date i {
                        color: #3B82F6;
                    }
                    .booking-preview__slots-grid {
                        display: grid;
                        grid-template-columns: repeat(4, 1fr);
                        gap: 0.5rem;
                    }
                    .booking-preview__slot {
                        padding: 0.625rem;
                        border: 1px solid #e5e7eb;
                        border-radius: 6px;
                        background: #fff;
                        font-size: 0.875rem;
                        cursor: pointer;
                        transition: all 0.15s;
                    }
                    .booking-preview__slot:hover {
                        border-color: #3B82F6;
                        color: #3B82F6;
                    }
                    .booking-preview__slot.selected {
                        background: #3B82F6;
                        border-color: #3B82F6;
                        color: white;
                    }
                    @media (max-width: 600px) {
                        .booking-preview {
                            grid-template-columns: 1fr;
                        }
                        .booking-preview__sidebar {
                            border-right: none;
                            padding-right: 0;
                            border-bottom: 1px solid #e5e7eb;
                            padding-bottom: 1rem;
                        }
                        .booking-preview__slots-grid {
                            grid-template-columns: repeat(3, 1fr);
                        }
                    }
                </style>
            </section>

        </div>
    </div>
</body>
</html>
