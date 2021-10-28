<?php
namespace SamAsif\Sslcommerz;


use Illuminate\Support\ServiceProvider;
class SSLCommerzServiceProvider extends ServiceProvider
{
    
        /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/sslcommerz.php');
        $this->loadViewsFrom(__DIR__.'/views', 'sslcommerz');
        $this->mergeConfigFrom(__DIR__.'/config/sslcommerz.php', 'sslcommerz');

        $this->publishes([
        __DIR__.'/config/sslcommerz.php' => config_path('sslcommerz.php'),
    ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        
    }
}