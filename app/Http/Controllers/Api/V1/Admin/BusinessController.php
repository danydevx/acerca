<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\BusinessListResource;
use App\Http\Resources\Api\V1\BusinessResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Listings\Models\Listing;
use Modules\ListingGallery\Models\ListingGalleryImage;
use Modules\ListingLocations\Models\ListingLocation;
use Modules\ListingFaqs\Models\ListingFaq;
use Modules\ListingFaqs\Models\ListingFaqCategory;
use Modules\ListingSeo\Models\ListingSeoSetting;
use Modules\ListingBranding\Models\ListingBrandingSetting;
use Modules\ListingHero\Models\ListingHero;
use Modules\ListingAbout\Models\ListingAbout;
use Modules\ListingServices\Models\ListingService;
use Modules\ListingProducts\Models\ListingProduct;
use Modules\ListingReviews\Models\ListingReview;
use Modules\ListingLeads\Models\ListingLead;
use Modules\ListingAppointments\Models\ListingAppointment;
use Modules\ListingAppointments\Models\ListingAppointmentSlot;
use Modules\Properties\Models\Property;
use Modules\ListingClients\Models\ListingClient;
use Modules\ListingRestaurantMenu\Entities\MenuProduct;
use Modules\ListingRestaurantMenu\Entities\MenuCategory;
use Modules\ListingOfficeHours\Models\ListingSchedule;
use Modules\ListingTeamMembers\Models\ListingTeamMember;
use Modules\ListingTeamMembers\Models\TeamMemberPosition;
use Modules\ListingPackages\Models\ListingPackage;
use Modules\VCards\Models\VCard;
use Modules\ClientFidelity\Models\ClientFidelityCard;
use Modules\ClientFidelity\Models\FidelityReward;

class BusinessController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->get('per_page', 20), 100);

        $businesses = Listing::with([
            'user:id,name,email',
            'subscriptions.plan:id,name',
            'modules.moduleDefinition',
        ])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'data' => BusinessListResource::collection($businesses->items()),
            'meta' => [
                'current_page' => $businesses->currentPage(),
                'per_page' => $businesses->perPage(),
                'total' => $businesses->total(),
                'last_page' => $businesses->lastPage(),
            ],
        ]);
    }

    public function show(Listing $business): JsonResponse
    {
        $business->load([
            'user:id,name,email,is_active,created_at',
            'subscriptions.plan:id,name,limits',
            'modules.moduleDefinition',
        ]);

        return response()->json([
            'data' => new BusinessResource($business),
        ]);
    }

    public function stats(Listing $business): JsonResponse
    {
        $stats = [
            'locations' => $business->locations()->count(),
            'gallery' => $business->galleryImages()->count(),
            'faqs' => $business->faqs()->count(),
            'services' => $business->services()->count(),
            'products' => $business->products()->count(),
            'reviews' => $business->reviews()->count(),
            'leads' => $business->leads()->count(),
        ];

        return response()->json([
            'data' => $stats,
        ]);
    }

    private function getModuleStatus(Listing $business, string $moduleKey): array
    {
        $module = $business->modules()->where('module_key', $moduleKey)->first();

        if (!$module) {
            return ['enabled' => false, 'message' => 'Modulo no habilitado en el plan'];
        }

        return ['enabled' => (bool) $module->is_enabled, 'message' => null];
    }

    public function locations(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'locations');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $locations = ListingLocation::where('listing_id', $business->id)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name', 'address', 'city', 'state', 'country', 'phone', 'email', 'coordinates', 'is_primary', 'is_active', 'created_at']);

        if ($locations->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay ubicaciones configuradas'], 200);
        }

        return response()->json([
            'data' => $locations,
            'meta' => ['total' => $locations->count()],
        ]);
    }

    public function gallery(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'gallery');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $images = ListingGalleryImage::where('listing_id', $business->id)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'title', 'description', 'image_path', 'is_active', 'created_at']);

        if ($images->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay imagenes en la galeria'], 200);
        }

        return response()->json([
            'data' => $images,
            'meta' => ['total' => $images->count()],
        ]);
    }

    public function faqs(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'faqs');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $faqs = ListingFaq::where('listing_id', $business->id)
            ->with('category:id,name')
            ->orderBy('order', 'asc')
            ->get(['id', 'category_id', 'question', 'answer', 'is_active', 'order']);

        if ($faqs->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay preguntas frecuentes configuradas'], 200);
        }

        return response()->json([
            'data' => $faqs,
            'meta' => ['total' => $faqs->count()],
        ]);
    }

    public function seo(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'seo');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $seo = ListingSeoSetting::where('listing_id', $business->id)->first([
            'id',
            'seo_title',
            'seo_description',
            'focus_keyword',
            'allow_indexing',
            'follow_links',
            'include_in_sitemap',
            'canonical_url',
            'og_title',
            'og_description',
            'og_image',
            'og_image_alt',
            'schema_enabled',
            'schema_type',
        ]);

        if (!$seo) {
            return response()->json(['data' => null, 'message' => 'No hay configuracion SEO'], 200);
        }

        return response()->json(['data' => $seo]);
    }

    public function branding(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'branding');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $branding = ListingBrandingSetting::where('listing_id', $business->id)->first([
            'id',
            'colors',
            'fonts',
            'custom_font_url',
            'dark_mode',
            'buttons_style',
        ]);

        if (!$branding) {
            return response()->json(['data' => null, 'message' => 'No hay configuracion de marca'], 200);
        }

        return response()->json(['data' => $branding]);
    }

    public function hero(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'hero');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $hero = ListingHero::where('listing_id', $business->id)->first([
            'id',
            'title',
            'subtitle',
            'description',
            'background_image',
            'background_color',
            'cta_text',
            'cta_url',
            'cta_second_text',
            'cta_second_url',
            'is_active',
        ]);

        if (!$hero) {
            return response()->json(['data' => null, 'message' => 'No hay configuracion de hero'], 200);
        }

        return response()->json(['data' => $hero]);
    }

    public function about(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'about');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $about = ListingAbout::where('listing_id', $business->id)->first([
            'id',
            'title',
            'description',
            'image',
            'video_url',
            'mission',
            'vision',
            'values',
        ]);

        if (!$about) {
            return response()->json(['data' => null, 'message' => 'No hay seccion about'], 200);
        }

        return response()->json(['data' => $about]);
    }

    public function services(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'services');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $services = ListingService::where('listing_id', $business->id)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name', 'description', 'price', 'duration', 'is_active']);

        if ($services->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay servicios configurados'], 200);
        }

        return response()->json([
            'data' => $services,
            'meta' => ['total' => $services->count()],
        ]);
    }

    public function products(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'products');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $products = ListingProduct::where('listing_id', $business->id)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name', 'description', 'price', 'compare_at_price', 'sku', 'stock_quantity', 'is_active']);

        if ($products->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay productos configurados'], 200);
        }

        return response()->json([
            'data' => $products,
            'meta' => ['total' => $products->count()],
        ]);
    }

    public function reviews(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'reviews');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $reviews = ListingReview::where('listing_id', $business->id)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'reviewer_name', 'rating', 'comment', 'is_approved', 'created_at']);

        if ($reviews->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay reviews'], 200);
        }

        return response()->json([
            'data' => $reviews,
            'meta' => [
                'total' => $reviews->count(),
                'average_rating' => $reviews->avg('rating'),
            ],
        ]);
    }

    public function leads(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'leads');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $leads = ListingLead::where('listing_id', $business->id)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name', 'email', 'phone', 'status', 'notes', 'created_at']);

        if ($leads->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay leads'], 200);
        }

        return response()->json([
            'data' => $leads,
            'meta' => [
                'total' => $leads->count(),
                'by_status' => $leads->groupBy('status')->map->count(),
            ],
        ]);
    }

    public function appointments(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'appointments');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $perPage = min((int) request()->get('per_page', 20), 100);

        $appointments = ListingAppointment::where('listing_id', $business->id)
            ->with(['location:id,name', 'service:id,name'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate($perPage);

        if ($appointments->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay citas'], 200);
        }

        return response()->json([
            'data' => $appointments->items(),
            'meta' => [
                'current_page' => $appointments->currentPage(),
                'per_page' => $appointments->perPage(),
                'total' => $appointments->total(),
                'last_page' => $appointments->lastPage(),
                'by_status' => ListingAppointment::where('listing_id', $business->id)
                    ->groupBy('status')
                    ->selectRaw('status, count(*) as count')
                    ->pluck('count', 'status'),
            ],
        ]);
    }

    public function appointmentSlots(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'appointments');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $slots = ListingAppointmentSlot::where('listing_id', $business->id)
            ->with(['service:id,name', 'location:id,name'])
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get(['id', 'business_service_id', 'business_location_id', 'day_of_week', 'specific_date', 'start_time', 'end_time', 'is_available', 'slots_available']);

        if ($slots->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay horarios configurados'], 200);
        }

        return response()->json([
            'data' => $slots,
            'meta' => [
                'total' => $slots->count(),
                'by_day_of_week' => $slots->groupBy('day_of_week')->map->count(),
            ],
        ]);
    }

    public function properties(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'properties');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $properties = Property::where('listing_id', $business->id)
            ->with(['propertyType:id,name,key', 'images'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($properties->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay propiedades'], 200);
        }

        return response()->json([
            'data' => $properties,
            'meta' => ['total' => $properties->count()],
        ]);
    }

    public function clients(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'clients');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $clients = ListingClient::where('listing_id', $business->id)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($clients->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay clientes'], 200);
        }

        return response()->json([
            'data' => $clients,
            'meta' => ['total' => $clients->count()],
        ]);
    }

    public function menuCategories(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'restaurant_menu');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $categories = MenuCategory::where('listing_id', $business->id)
            ->with(['parent:id,title', 'children:id,parent_id,title'])
            ->orderBy('sort_order')
            ->get();

        if ($categories->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay categorias'], 200);
        }

        return response()->json([
            'data' => $categories,
            'meta' => ['total' => $categories->count()],
        ]);
    }

    public function menuProducts(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'restaurant_menu');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $products = MenuProduct::where('listing_id', $business->id)
            ->with(['category:id,title', 'variants', 'images'])
            ->orderBy('sort_order')
            ->get();

        if ($products->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay productos'], 200);
        }

        return response()->json([
            'data' => $products,
            'meta' => ['total' => $products->count()],
        ]);
    }

    public function officeHours(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'office_hours');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $schedules = ListingSchedule::where('listing_id', $business->id)
            ->with(['location:id,name'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($schedules->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay horarios'], 200);
        }

        return response()->json([
            'data' => $schedules,
            'meta' => ['total' => $schedules->count()],
        ]);
    }

    public function teamMembers(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'team_members');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $members = ListingTeamMember::where('listing_id', $business->id)
            ->with(['position:id,name'])
            ->orderBy('sort_order')
            ->get();

        if ($members->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay miembros'], 200);
        }

        return response()->json([
            'data' => $members,
            'meta' => ['total' => $members->count()],
        ]);
    }

    public function teamMemberPositions(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'team_members');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $positions = TeamMemberPosition::where('listing_id', $business->id)
            ->orderBy('sort_order')
            ->get();

        if ($positions->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay puestos'], 200);
        }

        return response()->json([
            'data' => $positions,
            'meta' => ['total' => $positions->count()],
        ]);
    }

    public function packages(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'packages');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $packages = ListingPackage::where('listing_id', $business->id)
            ->orderBy('sort_order')
            ->get();

        if ($packages->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay paquetes'], 200);
        }

        return response()->json([
            'data' => $packages,
            'meta' => ['total' => $packages->count()],
        ]);
    }

    public function vcards(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'vcards');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $vcards = VCard::where('listing_id', $business->id)
            ->with(['team:id,name'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($vcards->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay vCards'], 200);
        }

        return response()->json([
            'data' => $vcards,
            'meta' => ['total' => $vcards->count()],
        ]);
    }

    public function fidelityCards(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'client_fidelity');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $cards = ClientFidelityCard::where('listing_id', $business->id)
            ->with(['reward:id,name,description'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($cards->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay tarjetas'], 200);
        }

        return response()->json([
            'data' => $cards,
            'meta' => ['total' => $cards->count()],
        ]);
    }

    public function fidelityRewards(Listing $business): JsonResponse
    {
        $status = $this->getModuleStatus($business, 'client_fidelity');

        if (!$status['enabled']) {
            return response()->json(['data' => null, 'message' => 'Modulo no habilitado en el plan'], 200);
        }

        $rewards = FidelityReward::where('listing_id', $business->id)
            ->orderBy('sort_order')
            ->get();

        if ($rewards->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay recompensas'], 200);
        }

        return response()->json([
            'data' => $rewards,
            'meta' => ['total' => $rewards->count()],
        ]);
    }
}
