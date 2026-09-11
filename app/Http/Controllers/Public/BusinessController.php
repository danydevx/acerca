<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Listings\Models\Listing;
use Modules\ListingGallery\Models\ListingGallery;
use Modules\ListingPackages\Models\ListingPackage;

class BusinessController extends Controller
{
    protected $themeSections = [
        ['key' => 'hero', 'module' => null, 'label' => 'Hero Principal'],
        ['key' => 'about', 'module' => null, 'label' => 'Acerca de'],
        ['key' => 'services', 'module' => 'services', 'label' => 'Servicios'],
        ['key' => 'gallery', 'module' => 'gallery', 'label' => 'Galería'],
        ['key' => 'products', 'module' => 'products', 'label' => 'Productos'],
        ['key' => 'menu', 'module' => 'restaurant_menu', 'label' => 'Menú'],
        ['key' => 'appointments', 'module' => 'appointments', 'label' => 'Turnos'],
        ['key' => 'contact', 'module' => 'contact_form', 'label' => 'Contacto'],
        ['key' => 'reviews', 'module' => 'reviews', 'label' => 'Reseñas'],
        ['key' => 'locations', 'module' => 'locations', 'label' => 'Ubicaciones'],
        ['key' => 'promotions', 'module' => 'promotions', 'label' => 'Promociones'],
        ['key' => 'packages', 'module' => 'packages', 'label' => 'Paquetes'],
    ];

    public function show(string $slug)
    {
        $business = Listing::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

        $modules = $business->getEnabledModules();

        $theme = $business->minisiteTheme;

        $brandingSetting = $business->brandingSetting;
        $brandingCss = $brandingSetting?->generated_css;
        $sectionVariants = $brandingSetting?->section_variants ?? ['services' => 'cards'];

        $branding = [
            'generated_css' => $brandingCss,
            'page_style' => $brandingSetting?->page_style,
            'section_style' => $brandingSetting?->section_style,
            'hero_style' => $brandingSetting?->hero_style,
            'buttons_uppercase' => $brandingSetting?->buttons_uppercase,
            'dark_mode' => $brandingSetting?->dark_mode,
        ];

        $services = [];
        if (in_array('services', $modules)) {
            $services = $business->services()
                ->where('is_active', true)
                ->where('allows_online_booking', true)
                ->orderBy('sort_order')
                ->get(['id', 'name', 'description', 'price', 'duration_minutes']);
        }

        $locations = [];
        if (in_array('locations', $modules)) {
            $locations = $business->locations()
                ->where('is_active', true)
                ->orderBy('is_primary', 'desc')
                ->get(['id', 'name', 'address_line_1', 'city']);
        }

        $gallery = [];
        if (in_array('gallery', $modules)) {
            $primary = ListingGallery::primaryFor($business->id);

            $gallery = $primary
                ? $business->galleryImages()
                    ->where('is_active', true)
                    ->where('business_gallery_id', $primary->id)
                    ->orderBy('sort_order')
                    ->limit(12)
                    ->get()
                : collect();
        }

        $reviews = [];
        if (in_array('reviews', $modules)) {
            $reviews = $business->reviews()
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get();
        }

        $promotions = [];
        if (in_array('promotions', $modules)) {
            $promotions = $business->promotions()
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('starts_at')
                        ->orWhere('starts_at', '<=', now());
                })
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>=', now());
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $products = [];
        if (in_array('products', $modules)) {
            $products = $business->products()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->limit(12)
                ->get(['id', 'name', 'description', 'price']);
        }

        $packages = [];
        if (in_array('packages', $modules)) {
            $packages = $business->packages()
                ->where('is_active', true)
                ->with('features')
                ->orderBy('sort_order')
                ->limit(12)
                ->get(['id', 'title', 'short_description', 'image', 'price', 'promo_price', 'whatsapp', 'whatsapp_message']);
        }

        $menuCategories = [];
        $menuProducts = [];
        if (in_array('restaurant_menu', $modules)) {
            $menuCategories = \Modules\ListingRestaurantMenu\Entities\MenuCategory::where('listing_id', $business->id)
                ->whereNull('parent_id')
                ->where('active', true)
                ->with(['images', 'children.images', 'children' => function ($q) {
                    $q->where('active', true)->orderBy('sort_order');
                }, 'products' => function ($q) {
                    $q->where('active', true)->orderBy('sort_order');
                }])
                ->orderBy('sort_order')
                ->get()
                ->map(function ($cat) {
                    return [
                        'id' => $cat->id,
                        'title' => $cat->title,
                        'image' => $cat->images->first()?->path,
                        'products' => $cat->products->map(function ($p) {
                            return [
                                'id' => $p->id,
                                'title' => $p->title,
                                'image' => $p->image,
                                'display_price' => $p->display_price,
                            ];
                        }),
                        'children' => $cat->children->map(function ($child) {
                            return [
                                'id' => $child->id,
                                'title' => $child->title,
                                'image' => $child->images->first()?->path,
                                'products' => $child->products->map(function ($p) {
                                    return [
                                        'id' => $p->id,
                                        'title' => $p->title,
                                        'image' => $p->image,
                                        'display_price' => $p->display_price,
                                    ];
                                }),
                            ];
                        }),
                    ];
                });
        }

        $socialNetworks = [];
        if (in_array('socialmedia', $modules)) {
            $socialNetworks = $business->socialNetworks()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(['id', 'platform', 'url', 'username', 'show_on_hero', 'show_on_footer', 'show_on_contact']);
        }

        $hero = $business->hero;

        $about = null;
        if (in_array('about', $modules)) {
            $about = $business->about;
        }

        return Inertia::render('Public/Business/Show', [
            'business' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
                'description' => $business->description,
                'phone' => $business->phone,
                'email' => $business->email,
                'website' => $business->website,
                'timezone' => $business->timezone,
                'currency' => $business->currency,
                'listing_type' => $business->listing_type->value ?? $business->listing_type,
                'logo_path' => $business->logo_path,
                'cover_image_path' => $business->cover_image_path,
            ],
            'theme' => $theme ? [
                'id' => $theme->id,
                'name' => $theme->name,
                'slug' => $theme->slug,
                'css_variables' => $theme->css_variables,
                'layout_config' => $theme->layout_config,
                'section_config' => $theme->section_config,
                'scheme_palettes' => $theme->section_config['scheme_palettes'] ?? [],
            ] : null,
            'theme_css_variables' => $theme?->css_variables ? json_encode($theme->css_variables) : null,
            'sectionSchemes' => $theme?->section_config['section_schemes'] ?? [
                'hero' => 'gradient',
                'about' => 'light',
                'services' => 'neutral',
                'products' => 'light',
                'gallery' => 'dark',
                'menu' => 'neutral',
                'appointments' => 'primary',
                'reviews' => 'light',
                'locations' => 'neutral',
                'contact' => 'dark',
                'promotions' => 'accent',
            ],
            'schemePalettes' => $theme?->section_config['scheme_palettes'] ?? [],
            'header_colors' => $theme?->section_config['header_colors'] ?? [
                'bg' => 'white',
                'text' => 'brand_text',
                'heading' => 'brand_primary',
                'link' => 'brand_primary',
                'link_hover' => 'brand_accent',
                'border' => 'rgba(0,0,0,0.1)',
                'nav_bg' => 'white',
                'nav_text' => 'brand_text',
                'nav_link' => 'brand_primary',
                'nav_link_hover' => 'brand_accent',
                'nav_border' => 'rgba(0,0,0,0.1)',
            ],
            'footer_colors' => $theme?->section_config['footer_colors'] ?? [
                'bg' => 'brand_text',
                'text' => 'white',
                'heading' => 'white',
                'link' => 'white',
                'link_hover' => 'rgba(255,255,255,0.8)',
                'border' => 'rgba(255,255,255,0.1)',
                'nav_bg' => 'brand_text',
                'nav_text' => 'white',
                'nav_link' => 'white',
                'nav_link_hover' => 'rgba(255,255,255,0.8)',
                'nav_border' => 'rgba(255,255,255,0.1)',
            ],
            'themeSections' => $this->themeSections,
            'modules' => $modules,
            'services' => $services,
            'locations' => $locations,
            'gallery' => $gallery,
            'reviews' => $reviews,
            'promotions' => $promotions,
            'products' => $products,
            'packages' => $packages,
            'menuCategories' => $menuCategories,
            'menuProducts' => $menuProducts,
            'socialNetworks' => $socialNetworks,
            'hero' => $hero ? [
                'id' => $hero->id,
                'title' => $hero->title,
                'subtitle' => $hero->subtitle,
                'text_aux' => $hero->text_aux,
                'background_type' => $hero->background_type,
                'background_color' => $hero->background_color,
                'background_gradient_start' => $hero->background_gradient_start,
                'background_gradient_end' => $hero->background_gradient_end,
                'background_image_path' => $hero->background_image_path,
                'alignment' => $hero->alignment,
                'buttons' => $hero->buttons,
                'show_contact_info' => $hero->show_contact_info,
                'show_social_links' => $hero->show_social_links,
            ] : null,
            'about' => $about ? [
                'id' => $about->id,
                'title' => $about->title,
                'subtitle' => $about->subtitle,
                'description' => $about->description,
                'image_path' => $about->image_path,
                'logo_path' => $about->logo_path,
            ] : null,
            'branding' => $branding,
            'sectionVariants' => $sectionVariants,
            'aiChatbot' => $this->getAiChatbotSettings($business),
        ]);
    }

    public function services(string $slug)
    {
        $business = Listing::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

        $modules = $business->modules()->where('is_enabled', true)->get()->pluck('moduleDefinition.key')->toArray();
        if (! in_array('services', $modules)) {
            abort(404);
        }

        $services = $business->services()
            ->where('is_active', true)
            ->where('allows_online_booking', true)
            ->with('location')
            ->orderBy('sort_order')
            ->get(['id', 'name', 'description', 'price', 'duration_minutes', 'whatsapp_contact', 'image']);

        $theme = $business->minisiteTheme;
        $brandingSetting = $business->brandingSetting;
        $socialNetworks = in_array('socialmedia', $modules)
            ? $business->socialNetworks()->where('is_active', true)->orderBy('sort_order')->get(['id', 'platform', 'url', 'username', 'show_on_hero', 'show_on_footer', 'show_on_contact'])
            : [];
        $locations = $business->locations()->where('is_active', true)->orderBy('is_primary', 'desc')->get(['id', 'name', 'address_line_1', 'city']);

        return Inertia::render('Public/Business/Services', [
            'business' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
                'phone' => $business->phone,
                'email' => $business->email,
                'logo_path' => $business->logo_path,
                'website' => $business->website,
            ],
            'services' => $services,
            'theme' => $theme ? ['id' => $theme->id, 'name' => $theme->name, 'slug' => $theme->slug, 'css_variables' => $theme->css_variables, 'layout_config' => $theme->layout_config, 'section_config' => $theme->section_config] : null,
            'theme_css_variables' => $theme?->css_variables ? json_encode($theme->css_variables) : null,
            'modules' => $modules,
            'branding' => ['generated_css' => $brandingSetting?->generated_css, 'page_style' => $brandingSetting?->page_style, 'section_style' => $brandingSetting?->section_style, 'hero_style' => $brandingSetting?->hero_style, 'buttons_uppercase' => $brandingSetting?->buttons_uppercase, 'dark_mode' => $brandingSetting?->dark_mode],
            'socialNetworks' => $socialNetworks,
            'locations' => $locations,
        ]);
    }

    public function gallery(string $slug)
    {
        $business = Listing::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

        $modules = $business->modules()->where('is_enabled', true)->get()->pluck('moduleDefinition.key')->toArray();
        if (! in_array('gallery', $modules)) {
            abort(404);
        }

        $images = $business->galleryImages()
            ->where('is_active', true)
            ->with('location')
            ->orderBy('sort_order')
            ->get();

        $theme = $business->minisiteTheme;
        $brandingSetting = $business->brandingSetting;
        $socialNetworks = in_array('socialmedia', $modules)
            ? $business->socialNetworks()->where('is_active', true)->orderBy('sort_order')->get(['id', 'platform', 'url', 'username', 'show_on_hero', 'show_on_footer', 'show_on_contact'])
            : [];
        $locations = $business->locations()->where('is_active', true)->orderBy('is_primary', 'desc')->get(['id', 'name', 'address_line_1', 'city']);

        return Inertia::render('Public/Business/Gallery', [
            'business' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
                'phone' => $business->phone,
                'email' => $business->email,
                'logo_path' => $business->logo_path,
                'website' => $business->website,
            ],
            'images' => $images,
            'theme' => $theme ? ['id' => $theme->id, 'name' => $theme->name, 'slug' => $theme->slug, 'css_variables' => $theme->css_variables, 'layout_config' => $theme->layout_config, 'section_config' => $theme->section_config] : null,
            'theme_css_variables' => $theme?->css_variables ? json_encode($theme->css_variables) : null,
            'modules' => $modules,
            'branding' => ['generated_css' => $brandingSetting?->generated_css, 'page_style' => $brandingSetting?->page_style, 'section_style' => $brandingSetting?->section_style, 'hero_style' => $brandingSetting?->hero_style, 'buttons_uppercase' => $brandingSetting?->buttons_uppercase, 'dark_mode' => $brandingSetting?->dark_mode],
            'socialNetworks' => $socialNetworks,
            'locations' => $locations,
        ]);
    }

    public function products(string $slug)
    {
        $business = Listing::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

        $modules = $business->modules()->where('is_enabled', true)->get()->pluck('moduleDefinition.key')->toArray();
        if (! in_array('products', $modules)) {
            abort(404);
        }

        $products = $business->products()
            ->where('is_active', true)
            ->with('location')
            ->orderBy('sort_order')
            ->get(['id', 'name', 'description', 'price', 'sku', 'quantity', 'whatsapp_contact']);

        $theme = $business->minisiteTheme;
        $brandingSetting = $business->brandingSetting;
        $socialNetworks = in_array('socialmedia', $modules)
            ? $business->socialNetworks()->where('is_active', true)->orderBy('sort_order')->get(['id', 'platform', 'url', 'username', 'show_on_hero', 'show_on_footer', 'show_on_contact'])
            : [];
        $locations = $business->locations()->where('is_active', true)->orderBy('is_primary', 'desc')->get(['id', 'name', 'address_line_1', 'city']);

        return Inertia::render('Public/Business/Products', [
            'business' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
                'phone' => $business->phone,
                'email' => $business->email,
                'logo_path' => $business->logo_path,
                'website' => $business->website,
            ],
            'products' => $products,
            'theme' => $theme ? ['id' => $theme->id, 'name' => $theme->name, 'slug' => $theme->slug, 'css_variables' => $theme->css_variables, 'layout_config' => $theme->layout_config, 'section_config' => $theme->section_config] : null,
            'theme_css_variables' => $theme?->css_variables ? json_encode($theme->css_variables) : null,
            'modules' => $modules,
            'branding' => ['generated_css' => $brandingSetting?->generated_css, 'page_style' => $brandingSetting?->page_style, 'section_style' => $brandingSetting?->section_style, 'hero_style' => $brandingSetting?->hero_style, 'buttons_uppercase' => $brandingSetting?->buttons_uppercase, 'dark_mode' => $brandingSetting?->dark_mode],
            'socialNetworks' => $socialNetworks,
            'locations' => $locations,
        ]);
    }

    public function locations(string $slug)
    {
        $business = Listing::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

        $modules = $business->modules()->where('is_enabled', true)->get()->pluck('moduleDefinition.key')->toArray();
        if (! in_array('locations', $modules)) {
            abort(404);
        }

        $locations = $business->locations()
            ->where('is_active', true)
            ->orderBy('is_primary', 'desc')
            ->get();

        $theme = $business->minisiteTheme;
        $brandingSetting = $business->brandingSetting;
        $socialNetworks = in_array('socialmedia', $modules)
            ? $business->socialNetworks()->where('is_active', true)->orderBy('sort_order')->get(['id', 'platform', 'url', 'username', 'show_on_hero', 'show_on_footer', 'show_on_contact'])
            : [];

        return Inertia::render('Public/Business/Locations', [
            'business' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
                'phone' => $business->phone,
                'email' => $business->email,
                'logo_path' => $business->logo_path,
                'website' => $business->website,
            ],
            'locations' => $locations,
            'theme' => $theme ? ['id' => $theme->id, 'name' => $theme->name, 'slug' => $theme->slug, 'css_variables' => $theme->css_variables, 'layout_config' => $theme->layout_config, 'section_config' => $theme->section_config] : null,
            'theme_css_variables' => $theme?->css_variables ? json_encode($theme->css_variables) : null,
            'modules' => $modules,
            'branding' => ['generated_css' => $brandingSetting?->generated_css, 'page_style' => $brandingSetting?->page_style, 'section_style' => $brandingSetting?->section_style, 'hero_style' => $brandingSetting?->hero_style, 'buttons_uppercase' => $brandingSetting?->buttons_uppercase, 'dark_mode' => $brandingSetting?->dark_mode],
            'socialNetworks' => $socialNetworks,
        ]);
    }

    public function packages(string $slug)
    {
        $business = Listing::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

        $modules = $business->modules()->where('is_enabled', true)->get()->pluck('moduleDefinition.key')->toArray();
        if (! in_array('packages', $modules)) {
            abort(404);
        }

        $packages = ListingPackage::where('listing_id', $business->id)
            ->where('is_active', true)
            ->with('features')
            ->orderBy('sort_order')
            ->get();

        $defaultWhatsapp = $business->phone;
        $defaultMessage = 'Hola, me interesa el paquete';

        return response()->json([
            'business' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
                'logo_path' => $business->logo_path,
                'phone' => $business->phone,
            ],
            'packages' => $packages->map(function ($package) use ($defaultWhatsapp, $defaultMessage) {
                return [
                    'id' => $package->id,
                    'title' => $package->title,
                    'short_description' => $package->short_description,
                    'long_description' => $package->long_description,
                    'image' => $package->image,
                    'price' => $package->price,
                    'promo_price' => $package->promo_price,
                    'whatsapp' => $package->whatsapp ?? $defaultWhatsapp,
                    'whatsapp_message' => $package->whatsapp_message ?? str_replace('{package_title}', $package->title, $defaultMessage),
                    'features' => $package->features->pluck('name')->toArray(),
                ];
            }),
        ]);
    }

    private function getAiChatbotSettings(Listing $business): ?array
    {
        if (!in_array('ai_chatbot', $business->getEnabledModules())) {
            return null;
        }

        $aiSetting = \Modules\ListingAiChatbot\Models\ListingAiSetting::where('listing_id', $business->id)
            ->where('is_enabled', true)
            ->first();

        if (!$aiSetting) {
            return null;
        }

        return [
            'is_enabled' => true,
            'chatbot_name' => $aiSetting->chatbot_name,
            'chatbot_avatar' => $aiSetting->chatbot_avatar,
            'widget_color' => $aiSetting->widget_color,
            'widget_theme' => $aiSetting->widget_theme ?? 'light',
            'allow_reset_chat' => $aiSetting->allow_reset_chat ?? false,
        ];
    }
}
