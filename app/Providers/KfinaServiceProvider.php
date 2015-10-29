<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class KfinaServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        ############################### Suppliers ########################################
        $this->app->bind('CdiscountPro', function () {
            return new \App\Partners\Suppliers\Suppliers\CdiscountPro\CdiscountPro();
        });
        $this->app->bind('PixmaniaPro', function () {
            return new \App\Partners\Suppliers\Suppliers\PixmaniaPro\PixmaniaPro();
        });

        ############################### Resellers ########################################
        $this->app->bind('AmazonReseller', function () {
            return new \App\Partners\Resellers\Resellers\Amazon\AmazonReseller(App::make('Feed'),App::make('Report'));
        });

        $this->app->singleton('AmazonConfig', function () {
            return new \App\Partners\Resellers\Resellers\Amazon\AmazonConfig();
        });

        ############################### Feeds ########################################
        $this->app->bind('Feed', function () {
            return new \App\Partners\Resellers\Resellers\Amazon\Feeds\Feed();
        });
        $this->app->bind('ProductFeed', function (){
            return new \App\Partners\Resellers\Resellers\Amazon\Feeds\FeedTypes\ProductFeed();
        });

        $this->app->bind('InventoryFeed', function (){
            return new \App\Partners\Resellers\Resellers\Amazon\Feeds\FeedTypes\InventoryFeed();
        });

        $this->app->bind('PricingFeed', function (){
            return new \App\Partners\Resellers\Resellers\Amazon\Feeds\FeedTypes\PricingFeed();
        });

        ############################### Reports ########################################
        $this->app->bind('Report', function () {
            return new \App\Partners\Resellers\Resellers\Amazon\Reports\Report();
        });

        $this->app->bind('InventoryReport', function () {
            return new \App\Partners\Resellers\Resellers\Amazon\Reports\ReportTypes\InventoryReport();
        });

        $this->app->bind('UnshippedOrdersReport', function () {
            return new \App\Partners\Resellers\Resellers\Amazon\Reports\ReportTypes\UnshippedOrdersReport();
        });

        $this->app->bind('ScheduledXMLOrderReport', function () {
            return new \App\Partners\Resellers\Resellers\Amazon\Reports\ReportTypes\ScheduledXMLOrderReport();
        });









    }
        /**
         * Get the services provided by the provider.
         *
         * @return array
         */
   public function provides()
    {
        return ['CdiscountPro','PixmaniaPro','AmazonReseller','ProductFeed'];
    }
}
