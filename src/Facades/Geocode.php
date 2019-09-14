<?php

namespace mcpuishor\googlemapss\Facades;

use Illuminate\Support\Facades\Facade;

class GeocodeFacade extends Facade {

	protected static function getFacadeAccessor()
    {
        return 'geocode';
    }
}
