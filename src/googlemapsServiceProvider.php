<?php
// mcpuishor\googlemaps\src\googlemapsServiceProvider.php
namespace mcpuishor\googlemaps;

use Illuminate\Support\ServiceProvider;

class googlemapsServiceProvider extends ServiceProvider {

 public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/googlemaps.php', 'googlemaps');

        $this->app->register( googlemapsServiceProvider::class);

        $this->app->bind('geocoder', function ($app) {
            $client = app(Client::class);

            return (new Geocoder($client))
                ->setApiKey(config('googlemaps.key'))
                ->setLanguage(config('googlemaps.language'))
                ->setRegion(config('googlemaps.region'))
                ->setBounds(config('googlemaps.bounds'))
                ->setCountry(config('googlemaps.country'));
        });

        $this->app->bind(Geocoder::class, 'geocoder');
    }

    public function boot()
    {


        $this->publishes(
        	[
        		__DIR__ . '/../config/googlemaps.php' => config_path('googlemaps.php'),

        	], 'config'
        );
        $this->publishes(
            [
                __DIR__ . '/../migrations/' => database_path('/migrations'),

            ], 'database'
        );
    }
}
