<?php
// mcpuishor\googlemaps\src\googlemapsServiceProvider.php
namespace mcpuishor\googlemaps;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client as HttpClient;

class googlemapsServiceProvider extends ServiceProvider {

 public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/googlemaps.php', 'googlemaps');

        $this->app->register( googlemapsServiceProvider::class);

        $this->app->bind('geocode', function ($app) {
            $client = app(HttpClient::class);

            return (new Geocode($client))
                ->setApiKey(config('googlemaps.key'))
                ->setLanguage(config('googlemaps.language'))
                ->setRegion(config('googlemaps.region'))
                ->setBounds(config('googlemaps.bounds'))
                ->setCountry(config('googlemaps.country'));
        });

        $this->app->bind(Geocode::class, 'geocode');
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
