# PHASE3D74-GEOGRAPHY-BOUNDARY

## SYSTEM GEOGRAPHY ROUTES

### Exact Count: 13

### Route Table

| METHOD | URI | NAME | CONTROLLER | OWNER |
|--------|-----|------|------------|-------|
| GET\|HEAD | admin/locations | admin.locations.index | LocationController@index | Modules\Locations |
| GET\|HEAD | admin/locations/countries | admin.locations.countries.index | LocationController@countriesIndex | Modules\Locations |
| POST | admin/locations/countries | admin.locations.countries.store | LocationController@countriesStore | Modules\Locations |
| PUT | admin/locations/countries/{country} | admin.locations.countries.update | LocationController@countriesUpdate | Modules\Locations |
| GET\|HEAD | admin/locations/municipalities | admin.locations.municipalities.index | LocationController@municipalitiesIndex | Modules\Locations |
| POST | admin/locations/municipalities | admin.locations.municipalities.store | LocationController@countriesStore | Modules\Locations |
| PUT | admin/locations/municipalities/{municipality} | admin.locations.municipalities.update | LocationController@countriesUpdate | Modules\Locations |
| GET\|HEAD | admin/locations/states | admin.locations.states.index | LocationController@statesIndex | Modules\Locations |
| POST | admin/locations/states | admin.locations.states.store | LocationController@statesStore | Modules\Locations |
| PUT | admin/locations/states/{state} | admin.locations.states.update | LocationController@statesUpdate | Modules\Locations |
| GET\|HEAD | api/v1/location-data/countries | - | LocationController@getCountries | Modules\Locations |
| GET\|HEAD | api/v1/location-data/municipalities/{stateCode} | - | LocationController@getMunicipalities | Modules\Locations |
| GET\|HEAD | api/v1/location-data/states | - | LocationController@getStates | Modules\Locations |
| GET\|HEAD | api/v1/location-data/states/{countryCode} | - | LocationController@getStates | Modules\Locations |

### Owner
```
CORE_SYSTEM_DATA / Modules\Locations
```

### NOT owned by ListingLocations
```
These routes belong to Modules\Locations, NOT Modules\ListingLocations
```

### Boundary Test

```
ListingLocations DISABLED:
System Geography routes REMAINING: 13
System Geography routes DISAPPEARED: 0
Status: PASS
```

### Historical Discrepancy Resolution

```
Previous count (3D73 audit): 14
Current exact count:        13
Discrepancy:                1 route

The count of 14 was erroneous.
Exact count is 13 based on actual route:list output.
```

### Conclusion

```
SYSTEM_GEOGRAPHY EXACT COUNT = 13
OWNER = Modules\Locations (not ListingLocations)
NO dependency on ListingLocations module
```
