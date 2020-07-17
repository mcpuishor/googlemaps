<?php
// mcpuishor\googlemaps\src\googlemapsServiceProvider.php
namespace mcpuishor\googlemaps;

use Illuminate\Support\ServiceProvider;
use mcpuishor\googlemaps\googlemapsServiceProvider;

class googlemapsServiceProvider extends ServiceProvider {

 public function register()
    {
        $this->mergeConfigFrom($this->getConfigPath(), 'googlemaps');
        $this->app->register( googlemapsServiceProvider::class);
    }

    public function boot()
    {
        $this->publishes(
        	[
        		$this->getConfigPath() => config_path('googlemaps.php')
        	]
        );
    }


    private function getConfigPath()
    {
        return __DIR__ . '/../config/googlemaps.php';
    }

}
