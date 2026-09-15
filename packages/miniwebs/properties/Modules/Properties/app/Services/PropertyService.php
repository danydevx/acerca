<?php

namespace Modules\Properties\Services;

use Illuminate\Database\Eloquent\Builder;
use Modules\Listings\Models\Listing;
use Modules\Properties\Models\Property;

class PropertyService
{
    public function getPropertiesQuery(Listing $listing, array $filters = []): Builder
    {
        $query = Property::where('listing_id', $listing->id);

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('colony', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['property_type_id'])) {
            $query->where('property_type_id', $filters['property_type_id']);
        }

        if (! empty($filters['operation_type'])) {
            $query->where('operation_type', $filters['operation_type']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (! empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        if (! empty($filters['municipality'])) {
            $query->where('municipality', $filters['municipality']);
        }

        if (! empty($filters['state'])) {
            $query->where('state', $filters['state']);
        }

        $sort = $filters['sort'] ?? 'created_at';
        $direction = $filters['direction'] ?? 'desc';
        $query->orderBy($sort, $direction);

        return $query;
    }

    public function createProperty(Listing $listing, array $data): Property
    {
        $data['listing_id'] = $listing->id;
        $data['slug'] = Property::generateUniqueSlug($listing->id, $data['title'] ?? 'property');

        return Property::create($data);
    }

    public function updateProperty(Property $property, array $data): Property
    {
        if (isset($data['title']) && $data['title'] !== $property->title) {
            $data['slug'] = Property::generateUniqueSlug($property->listing_id, $data['title'], $property->id);
        }

        $property->update($data);

        return $property->fresh();
    }

    public function deleteProperty(Property $property): void
    {
        $property->delete();
    }

    public function duplicateProperty(Property $property): Property
    {
        $newData = $property->toArray();
        unset($newData['id'], $newData['slug'], $newData['created_at'], $newData['updated_at']);
        $newData['title'] = $property->title . ' (copia)';
        $newData['slug'] = Property::generateUniqueSlug($property->listing_id, $newData['title']);

        return $this->createProperty($property->listing, $newData);
    }

    public function changeStatus(Property $property, string $status): Property
    {
        $property->update(['status' => $status]);

        return $property->fresh();
    }
}
